<?php
/**
 * Artifact generation and import planning.
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

final class WPDocs_Sync {
	/** @param array<int,array<string,mixed>> $records */
	public static function export_artifact( array $records, $docs_base_url ) {
		$records = array_map( array( 'WPDocs_Codec', 'normalize_record' ), $records );
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
		);
		foreach ( $records as $record ) {
			$manifest['records'][] = array( 'identity' => $record['identity'], 'path' => trim( $record['canonical_path'], '/' ) . '.md', 'content_hash' => $record['content_hash'] );
		}
		$manifest['manifest_hash'] = hash( 'sha256', WPDocs_Codec::json( $manifest ) );
		return array( 'files' => $files, 'manifest' => $manifest );
	}

	/** @param array<int,array<string,mixed>> $incoming @param array<int,array<string,mixed>> $current */
	public static function preview_import( array $incoming, array $current ) {
		$existing = array();
		foreach ( $current as $record ) {
			$record = WPDocs_Codec::normalize_record( $record );
			$existing[ $record['identity'] ] = $record;
		}
		$changes = array();
		foreach ( $incoming as $record ) {
			$record = WPDocs_Codec::normalize_record( $record );
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
}
