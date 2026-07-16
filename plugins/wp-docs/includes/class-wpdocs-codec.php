<?php
/**
 * Deterministic PushMD-compatible record codec.
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

final class WPDocs_Codec {
	const SCHEMA_VERSION = 1;

	/** @param array<string,mixed> $record */
	public static function normalize_record( array $record ) {
		$terms = isset( $record['terms'] ) && is_array( $record['terms'] ) ? $record['terms'] : array();
		foreach ( array( 'collections', 'topics' ) as $type ) {
			$values = isset( $terms[ $type ] ) && is_array( $terms[ $type ] ) ? $terms[ $type ] : array();
			sort( $values, SORT_STRING );
			$terms[ $type ] = array_values( array_unique( $values ) );
		}
		$normalized = array(
			'schema_version' => self::SCHEMA_VERSION,
			'identity'       => (string) ( $record['identity'] ?? '' ),
			'slug'           => (string) ( $record['slug'] ?? '' ),
			'parent_identity' => (string) ( $record['parent_identity'] ?? '' ),
			'parent_path'    => (string) ( $record['parent_path'] ?? '' ),
			'menu_order'     => (int) ( $record['menu_order'] ?? 0 ),
			'status'         => (string) ( $record['status'] ?? 'draft' ),
			'title'          => (string) ( $record['title'] ?? '' ),
			'excerpt'        => (string) ( $record['excerpt'] ?? '' ),
			'terms'          => array( 'collections' => $terms['collections'], 'topics' => $terms['topics'] ),
			'canonical_path' => (string) ( $record['canonical_path'] ?? '/' ),
			'content'        => rtrim( str_replace( array( "\r\n", "\r" ), "\n", (string) ( $record['content'] ?? '' ) ), "\n" ),
		);
		$normalized['content_hash'] = hash( 'sha256', self::hash_payload( $normalized ) );
		if ( isset( $record['base_content_hash'] ) ) {
			$normalized['base_content_hash'] = (string) $record['base_content_hash'];
		}
		return $normalized;
	}

	/** @param array<string,mixed> $record */
	public static function encode( array $record ) {
		$record = self::normalize_record( $record );
		$content = $record['content'];
		unset( $record['content'] );
		return "---\n" . self::json( $record ) . "\n---\n\n" . $content . "\n";
	}

	/** @return array<string,mixed> */
	public static function decode( $markdown ) {
		if ( ! preg_match( '/\A---\n(\{.*\})\n---\n(?:\n)?(.*)\z/s', (string) $markdown, $matches ) ) {
			throw new InvalidArgumentException( 'WPDocs records require JSON object frontmatter.' );
		}
		$frontmatter = json_decode( $matches[1], true );
		if ( ! is_array( $frontmatter ) || self::SCHEMA_VERSION !== (int) ( $frontmatter['schema_version'] ?? 0 ) ) {
			throw new InvalidArgumentException( 'WPDocs record schema is unsupported.' );
		}
		$frontmatter['content'] = rtrim( $matches[2], "\n" );
		$given_hash = (string) ( $frontmatter['content_hash'] ?? '' );
		$record = self::normalize_record( $frontmatter );
		if ( ! hash_equals( $record['content_hash'], $given_hash ) ) {
			throw new InvalidArgumentException( 'WPDocs record content hash does not match.' );
		}
		return $record;
	}

	/** @param array<string,mixed> $record */
	private static function hash_payload( array $record ) {
		unset( $record['content_hash'], $record['base_content_hash'] );
		return self::json( $record );
	}

	/** @param array<string,mixed> $value */
	public static function json( array $value ) {
		return json_encode( $value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR );
	}
}
