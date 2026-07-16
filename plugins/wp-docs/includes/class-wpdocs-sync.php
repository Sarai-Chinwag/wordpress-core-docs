<?php
/**
 * Artifact generation and import planning.
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

final class WPDocs_Sync {
	/** @param array<int,array<string,mixed>> $records */
	public static function export_artifact( array $records, $docs_base_url, array $terms = array() ) {
		$records = array_map( array( 'WPDocs_Codec', 'normalize_record' ), $records );
		self::validate_artifact_records( $records );
		foreach ( $records as &$record ) {
			// Export snapshots become the base for a later three-way import.
			$record['base_content_hash'] = $record['content_hash'];
		}
		unset( $record );
		usort( $records, static function ( $left, $right ) { return strcmp( $left['identity'], $right['identity'] ); } );
		$files = array();
		foreach ( $records as $record ) {
			$files[ trim( $record['canonical_path'], '/' ) . '.md' ] = WPDocs_Codec::encode( $record );
		}
		ksort( $files, SORT_STRING );
		$manifest = array(
			'schema_version' => 1,
			'format'         => 'wpdocs-publication-manifest',
			'docs_base_url'  => WPDocs_URLs::normalize_base_url( $docs_base_url ),
			'records'        => array(),
			'terms'          => WPDocs_Codec::normalize_terms( $terms ),
		);
		foreach ( $records as $record ) {
			$manifest['records'][] = array( 'identity' => $record['identity'], 'path' => trim( $record['canonical_path'], '/' ) . '.md', 'content_hash' => $record['content_hash'] );
		}
		$manifest['manifest_hash'] = hash( 'sha256', WPDocs_Codec::json( $manifest ) );
		return array( 'files' => $files, 'manifest' => $manifest );
	}

	/** @param array<int,array<string,mixed>> $incoming @param array<int,array<string,mixed>> $current */
	public static function preview_import( array $incoming, array $current ) {
		$incoming = array_map( array( 'WPDocs_Codec', 'normalize_record' ), $incoming );
		self::validate_incoming( $incoming, $current );
		$existing = array();
		foreach ( $current as $record ) {
			$record = WPDocs_Codec::normalize_record( $record );
			$existing[ $record['identity'] ] = $record;
		}
		$changes = array();
		foreach ( $incoming as $record ) {
			$old = $existing[ $record['identity'] ] ?? null;
			$action = 'create';
			if ( $old ) {
				if ( hash_equals( $old['content_hash'], $record['content_hash'] ) ) {
					$action = 'noop';
				} elseif ( isset( $record['base_content_hash'] ) && ! hash_equals( $old['content_hash'], $record['base_content_hash'] ) ) {
					$action = 'conflict';
				} else {
					$action = 'update';
				}
			}
			$changes[] = array( 'identity' => $record['identity'], 'action' => $action, 'base_content_hash' => (string) ( $record['base_content_hash'] ?? '' ), 'current_content_hash' => $old['content_hash'] ?? '', 'record' => $record );
		}
		usort( $changes, static function ( $left, $right ) { return strcmp( $left['identity'], $right['identity'] ); } );
		$plan = array( 'schema_version' => 1, 'changes' => $changes );
		$plan['plan_hash'] = hash( 'sha256', WPDocs_Codec::json( $plan ) );
		return $plan;
	}

	/** @param array<string,mixed> $plan @param array<int,array<string,mixed>> $incoming @param array<int,array<string,mixed>> $current */
	public static function validate_apply( array $plan, array $incoming, array $current ) {
		$fresh = self::preview_import( $incoming, $current );
		if ( ! isset( $plan['plan_hash'] ) || ! hash_equals( $fresh['plan_hash'], (string) $plan['plan_hash'] ) ) {
			throw new RuntimeException( 'WPDocs import plan is stale; preview again before applying.' );
		}
		foreach ( $fresh['changes'] as $change ) {
			if ( 'conflict' === $change['action'] ) {
				throw new RuntimeException( 'WPDocs import plan contains a content conflict.' );
			}
		}
		return $fresh;
	}

	/** @param array<int,array<string,mixed>> $records */
	private static function validate_artifact_records( array $records ) {
		$identities = array();
		$paths = array();
		foreach ( $records as $record ) {
			self::validate_identity_and_path( $record );
			if ( isset( $identities[ $record['identity'] ] ) ) { throw new InvalidArgumentException( 'WPDocs artifact contains a duplicate identity: ' . $record['identity'] ); }
			$identities[ $record['identity'] ] = true;
			$path = trim( $record['canonical_path'], '/' ) . '.md';
			if ( isset( $paths[ $path ] ) ) { throw new InvalidArgumentException( 'WPDocs artifact contains a duplicate output path: ' . $path ); }
			$paths[ $path ] = true;
		}
	}

	/** @param array<string,mixed> $record */
	private static function validate_identity_and_path( array $record ) {
		if ( '' === trim( $record['identity'] ) ) { throw new InvalidArgumentException( 'WPDocs record identity cannot be empty.' ); }
		$path = $record['canonical_path'];
		if ( ! is_string( $path ) || ! preg_match( '~\A/(?!/)(?:[^/?#\\\\\x00]+/)+\z~', $path ) || false !== strpos( $path, '/./' ) || false !== strpos( $path, '/../' ) ) {
			throw new InvalidArgumentException( 'WPDocs record canonical path is empty or unsafe.' );
		}
	}

	/** @param array<int,array<string,mixed>> $incoming @param array<int,array<string,mixed>> $current */
	private static function validate_incoming( array $incoming, array $current ) {
		self::validate_artifact_records( $incoming );
		$by_identity = array();
		foreach ( $incoming as $record ) { $by_identity[ $record['identity'] ] = $record; }
		$existing = array();
		foreach ( $current as $record ) {
			$record = WPDocs_Codec::normalize_record( $record );
			if ( '' !== $record['identity'] ) { $existing[ $record['identity'] ] = $record; }
		}
		$resolve = static function ( $identity, array $trail = array() ) use ( &$resolve, $by_identity, $existing ) {
			if ( isset( $trail[ $identity ] ) ) { throw new InvalidArgumentException( 'WPDocs import parent hierarchy contains a cycle.' ); }
			if ( isset( $by_identity[ $identity ] ) ) {
				$record = $by_identity[ $identity ];
				$parent = $record['parent_identity'];
				if ( '' === $parent ) { $expected = '/' . $record['slug'] . '/'; }
				else {
					$trail[ $identity ] = true;
					$expected = rtrim( $resolve( $parent, $trail ), '/' ) . '/' . $record['slug'] . '/';
				}
				if ( $record['canonical_path'] !== $expected ) { throw new InvalidArgumentException( 'WPDocs record canonical path does not match its resolved hierarchy: ' . $identity ); }
				return $record['canonical_path'];
			}
			if ( isset( $existing[ $identity ] ) ) { return $existing[ $identity ]['canonical_path']; }
			throw new InvalidArgumentException( 'WPDocs record parent identity does not resolve: ' . $identity );
		};
		foreach ( $incoming as $record ) {
			if ( $record['identity'] === $record['parent_identity'] ) { throw new InvalidArgumentException( 'WPDocs record cannot be its own parent: ' . $record['identity'] ); }
			$resolve( $record['identity'] );
		}
	}
}
