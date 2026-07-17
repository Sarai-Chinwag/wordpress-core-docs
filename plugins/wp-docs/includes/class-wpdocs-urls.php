<?php
/** @package WPDocs */
defined( 'ABSPATH' ) || exit;

final class WPDocs_URLs {
	public static function normalize_base_url( $url ) {
		$parts = parse_url( trim( (string) $url ) );
		if ( ! $parts || 'https' !== ( $parts['scheme'] ?? '' ) || empty( $parts['host'] ) || isset( $parts['query'], $parts['fragment'], $parts['user'], $parts['pass'], $parts['port'] ) ) {
			throw new InvalidArgumentException( 'Docs base URL must be an HTTPS hostname without credentials, port, query, or fragment.' );
		}
		return 'https://' . strtolower( $parts['host'] ) . rtrim( $parts['path'] ?? '', '/' );
	}

	/**
	 * Ancestors are ordered from the document root to the immediate parent.
	 *
	 * @param array<int,object> $ancestors
	 */
	public static function canonical_path( $post, array $ancestors = array() ) {
		$parts = array();
		foreach ( $ancestors as $ancestor ) { $parts[] = $ancestor->post_name; }
		$parts[] = $post->post_name;
		return '/' . implode( '/', array_filter( $parts ) ) . '/';
	}

	public static function document_url( $post, $base_url, array $ancestors = array(), $preview = false ) {
		$url = self::normalize_base_url( $base_url ) . self::canonical_path( $post, $ancestors );
		return $preview ? $url . '?wpdocs-preview=1' : $url;
	}
}
