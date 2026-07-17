<?php
/**
 * Durable WordPress-owned Spacefast publication requests.
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

final class WPDocs_Publication {
	const OPTION_REQUESTS = 'wpdocs_publication_requests';
	const MAX_REQUESTS    = 20;

	public static function source_endpoint() {
		return rest_url( 'git/v1/md.git' );
	}

	public static function preview( $input = array() ) {
		unset( $input );
		return array(
			'source_git_endpoint' => self::source_endpoint(),
			'content_post_type'   => WPDocs_Plugin::POST_TYPE,
			'document_count'      => (int) wp_count_posts( WPDocs_Plugin::POST_TYPE )->publish,
			'base_url'            => get_option( WPDocs_Plugin::OPTION_BASE_URL, '' ),
			'configured'          => ! is_wp_error( self::credentials() ),
		);
	}

	public static function request( $input = array() ) {
		unset( $input );
		foreach ( self::requests() as $existing ) {
			if ( in_array( $existing['state'], array( 'waiting_for_source', 'uploading_source', 'queued', 'running' ), true ) ) {
				return $existing;
			}
		}

		$requested_at = current_time( 'mysql', true );
		$request      = array(
			'request_id'          => 'wpdocs-' . wp_generate_uuid4(),
			'source_git_endpoint' => self::source_endpoint(),
			'requested_at'        => $requested_at,
			'requested_by'        => (int) get_current_user_id(),
			'updated_at'          => $requested_at,
			'state'               => 'waiting_for_source',
			'build_id'            => '',
			'provider_state'      => '',
			'version_id'          => '',
			'failure'             => '',
		);
		$requests = self::requests();
		array_unshift( $requests, $request );
		if ( ! self::save( $requests ) ) {
			return new WP_Error( 'wpdocs_request_store_failed', 'Publication request could not be stored.', array( 'status' => 500 ) );
		}

		return self::start( $request );
	}

	public static function status( $input = array() ) {
		$requests = self::requests();
		if ( empty( $input['request_id'] ) ) {
			return $requests;
		}
		foreach ( $requests as $request ) {
			if ( hash_equals( $request['request_id'], (string) $input['request_id'] ) ) {
				return $request;
			}
		}
		return new WP_Error( 'wpdocs_request_not_found', 'Publication request was not found.', array( 'status' => 404 ) );
	}

	public static function reconcile( $input = array() ) {
		$request = self::status( $input );
		if ( is_wp_error( $request ) ) {
			return $request;
		}
		return self::poll( $request );
	}

	public static function resume( $input = array() ) {
		$request = self::status( $input );
		if ( is_wp_error( $request ) || empty( $request['build_id'] ) ) {
			return is_wp_error( $request ) ? $request : new WP_Error( 'wpdocs_missing_build', 'Publication request has no resumable build.', array( 'status' => 409 ) );
		}
		$response = self::api( 'POST', '/v1/builds/' . rawurlencode( $request['build_id'] ) . '/uploads/resume', array(), $request['request_id'] );
		if ( is_wp_error( $response ) ) {
			return self::fail( $request, $response->get_error_message() );
		}
		return self::upload_and_poll( $request, $response );
	}

	public static function retry( $input = array() ) {
		$request = self::status( $input );
		if ( is_wp_error( $request ) ) {
			return $request;
		}
		if ( ! in_array( $request['state'], array( 'failed', 'canceled', 'skipped' ), true ) ) {
			return new WP_Error( 'wpdocs_not_retryable', 'Only unsuccessful terminal requests can be retried.', array( 'status' => 409 ) );
		}
		return self::request();
	}

	public static function cancel( $input = array() ) {
		$request = self::status( $input );
		if ( is_wp_error( $request ) ) {
			return $request;
		}
		if ( empty( $request['build_id'] ) ) {
			return new WP_Error( 'wpdocs_missing_build', 'Publication request has no cancelable build.', array( 'status' => 409 ) );
		}
		$response = self::api( 'POST', '/v1/builds/' . rawurlencode( $request['build_id'] ) . '/cancel', array(), $request['request_id'] );
		if ( is_wp_error( $response ) ) {
			return self::fail( $request, $response->get_error_message() );
		}
		$build = WPDocs_Spacefast_Response::build( $response );
		if ( is_wp_error( $build ) || $request['build_id'] !== $build['id'] ) {
			return self::fail( $request, is_wp_error( $build ) ? $build->get_error_message() : 'Spacefast did not return the canceled build.' );
		}
		return self::transition( $request, $build['state'], array( 'provider_state' => $build['state'] ) );
	}

	public static function archive() {
		if ( ! class_exists( 'Push_MD_Plugin' ) || ! method_exists( 'Push_MD_Plugin', 'build_markdown_path' ) || ! method_exists( 'Push_MD_Plugin', 'export_post_to_markdown' ) ) {
			return new WP_Error( 'wpdocs_push_md_missing', 'Push MD archive export APIs are unavailable.' );
		}
		$files = array(
			'blume.config.ts' => "import { defineConfig } from 'blume';\nexport default defineConfig({ content: { root: 'wpdocs_document' }, deployment: { output: 'static' } });\n",
			'package.json'     => "{\"private\":true,\"scripts\":{\"build\":\"blume build\"},\"devDependencies\":{\"blume\":\"1.0.4\"}}\n",
		);
		$posts = get_posts( array( 'post_type' => WPDocs_Plugin::POST_TYPE, 'post_status' => 'publish', 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'ASC' ) );
		foreach ( $posts as $post ) {
			$path    = self::archive_path( Push_MD_Plugin::build_markdown_path( $post ) );
			$content = Push_MD_Plugin::export_post_to_markdown( $post );
			if ( is_wp_error( $path ) || ! is_string( $content ) ) {
				return new WP_Error( 'wpdocs_export_failed', 'Push MD could not export a safe document path and content.' );
			}
			$files[ $path ] = $content;
		}
		ksort( $files, SORT_STRING );
		$tar = '';
		foreach ( $files as $path => $content ) {
			$tar .= self::tar_file( $path, $content );
		}
		return gzencode( $tar . str_repeat( "\0", 1024 ), 9 );
	}

	private static function start( $request ) {
		$archive = self::archive();
		if ( is_wp_error( $archive ) ) {
			return self::fail( $request, $archive->get_error_message() );
		}
		$credentials = self::credentials();
		if ( is_wp_error( $credentials ) ) {
			return self::fail( $request, $credentials->get_error_message() );
		}
		$response = self::api( 'POST', '/v1/spaces/' . rawurlencode( $credentials['space_id'] ) . '/builds', array( 'input' => array( 'kind' => 'archive' ), 'target' => array( 'channel' => 'live', 'preview' => false ), 'wait' => false ), $request['request_id'] );
		if ( is_wp_error( $response ) ) {
			return self::fail( $request, $response->get_error_message() );
		}
		$build = WPDocs_Spacefast_Response::build( $response );
		if ( is_wp_error( $build ) ) {
			return self::fail( $request, $build->get_error_message() );
		}
		if ( empty( $build['id'] ) ) {
			return self::fail( $request, 'Spacefast did not return a build identifier.' );
		}
		$upload = WPDocs_Spacefast_Response::upload( $response );
		if ( is_wp_error( $upload ) ) {
			return self::fail( $request, $upload->get_error_message() );
		}
		$state   = null === $upload && in_array( $build['state'], array( 'queued', 'running' ), true ) ? $build['state'] : 'uploading_source';
		$request = self::transition( $request, $state, array( 'build_id' => $build['id'], 'provider_state' => $build['state'] ) );
		if ( is_wp_error( $request ) ) {
			return $request;
		}
		return self::upload_and_poll( $request, $response, $archive );
	}

	private static function upload_and_poll( $request, $response, $archive = null ) {
		$upload = WPDocs_Spacefast_Response::upload( $response );
		if ( is_wp_error( $upload ) ) {
			return self::fail( $request, $upload->get_error_message() );
		}
		if ( null !== $upload ) {
			if ( null === $archive ) {
				$archive = self::archive();
			}
			if ( is_wp_error( $archive ) ) {
				return self::fail( $request, $archive->get_error_message() );
			}
			$credentials = self::credentials();
			if ( is_wp_error( $credentials ) ) {
				return self::fail( $request, $credentials->get_error_message() );
			}
			if ( isset( $upload['max_bytes'] ) && strlen( $archive ) > $upload['max_bytes'] ) {
				return self::fail( $request, 'Spacefast source upload exceeds the target size limit.' );
			}
			$url = self::upload_url( $upload['url'], $credentials['api_url'] );
			if ( is_wp_error( $url ) ) {
				return self::fail( $request, $url->get_error_message() );
			}
			$headers = $upload['headers'];
			if ( $upload['content_type'] ) {
				$headers['Content-Type'] = $upload['content_type'];
			} elseif ( ! self::has_header( $headers, 'Content-Type' ) ) {
				$headers['Content-Type'] = 'application/gzip';
			}
			if ( self::same_origin( $url, $credentials['api_url'] ) ) {
				$headers['Authorization'] = 'Bearer ' . $credentials['token'];
			}
			$uploaded = wp_remote_request( $url, array( 'method' => $upload['method'], 'headers' => $headers, 'body' => $archive, 'timeout' => 60 ) );
			if ( is_wp_error( $uploaded ) || wp_remote_retrieve_response_code( $uploaded ) >= 300 ) {
				return self::fail( $request, 'Spacefast source upload failed.' );
			}
		}
		return self::poll( $request );
	}

	private static function poll( $request ) {
		$response = self::api( 'GET', '/v1/builds/' . rawurlencode( $request['build_id'] ), null, $request['request_id'] );
		if ( is_wp_error( $response ) ) {
			return self::fail( $request, $response->get_error_message() );
		}
		$build = WPDocs_Spacefast_Response::build( $response );
		if ( is_wp_error( $build ) ) {
			return self::fail( $request, $build->get_error_message() );
		}
		if ( ! self::transition_allowed( $request['state'], $build['state'] ) ) {
			return new WP_Error( 'wpdocs_stale_transition', 'Provider state does not match the durable request state.', array( 'status' => 409 ) );
		}
		$base_url = '';
		if ( 'succeeded' === $build['state'] ) {
			if ( ! $build['version_id'] ) {
				return self::fail( $request, 'Spacefast success response lacks a version.' );
			}
			$base_url = self::verified_base_url( $build['version_id'], $request['build_id'], $request['request_id'] );
			if ( is_wp_error( $base_url ) ) {
				return self::fail( $request, $base_url->get_error_message() );
			}
		}
		return self::transition( $request, $build['state'], array( 'provider_state' => $build['state'], 'version_id' => $build['version_id'], 'failure' => $build['failure'] ), $base_url );
	}

	public static function transition_allowed( $from, $to ) {
		$transitions = array(
			'waiting_for_source' => array( 'uploading_source', 'queued', 'running', 'failed', 'canceled' ),
			'uploading_source'   => array( 'waiting_for_source', 'queued', 'running', 'succeeded', 'failed', 'canceled', 'skipped' ),
			'queued'             => array( 'queued', 'running', 'succeeded', 'failed', 'canceled', 'skipped' ),
			'running'            => array( 'running', 'succeeded', 'failed', 'canceled', 'skipped' ),
		);
		return isset( $transitions[ $from ] ) && in_array( $to, $transitions[ $from ], true );
	}

	private static function transition( $request, $state, $changes = array(), $base_url = '' ) {
		if ( ! self::transition_allowed( $request['state'], $state ) ) {
			return new WP_Error( 'wpdocs_stale_transition', 'Publication state transition is not allowed.', array( 'status' => 409 ) );
		}
		$requests = self::requests();
		$expected = $requests;
		foreach ( $requests as $index => $stored ) {
			if ( ! hash_equals( $stored['request_id'], $request['request_id'] ) || $stored !== $request ) {
				continue;
			}
			$requests[ $index ] = array_merge( $stored, $changes, array( 'state' => $state, 'updated_at' => current_time( 'mysql', true ) ) );
			$previous_base_url   = get_option( WPDocs_Plugin::OPTION_BASE_URL, '' );
			if ( $base_url ) {
				update_option( WPDocs_Plugin::OPTION_BASE_URL, $base_url, false );
				if ( $base_url !== get_option( WPDocs_Plugin::OPTION_BASE_URL, '' ) ) {
					return new WP_Error( 'wpdocs_base_url_store_failed', 'The verified publication URL could not be stored.', array( 'status' => 500 ) );
				}
			}
			if ( ! self::save( $requests, $expected ) ) {
				if ( $base_url ) {
					update_option( WPDocs_Plugin::OPTION_BASE_URL, $previous_base_url, false );
				}
				return new WP_Error( 'wpdocs_stale_transition', 'Another request changed publication state first.', array( 'status' => 409 ) );
			}
			return $requests[ $index ];
		}
		return new WP_Error( 'wpdocs_stale_transition', 'Publication request changed before this operation completed.', array( 'status' => 409 ) );
	}

	private static function fail( $request, $failure ) {
		if ( ! self::transition_allowed( $request['state'], 'failed' ) ) {
			return new WP_Error( 'wpdocs_stale_transition', 'Publication request changed before failure could be recorded.', array( 'status' => 409 ) );
		}
		return self::transition( $request, 'failed', array( 'failure' => self::redact( $failure ) ) );
	}

	private static function archive_path( $path ) {
		$path = (string) $path;
		$prefix = WPDocs_Plugin::POST_TYPE . '/';
		if ( 0 !== strpos( $path, $prefix ) || '' === $path || '\\' === substr( $path, 0, 1 ) || '/' === substr( $path, 0, 1 ) || false !== strpos( $path, '\\' ) || false !== strpos( $path, "\0" ) ) {
			return new WP_Error( 'wpdocs_invalid_export_path', 'Push MD returned an unsafe archive path.' );
		}
		$segments = explode( '/', $path );
		foreach ( $segments as $segment ) {
			if ( '' === $segment || '.' === $segment || '..' === $segment ) {
				return new WP_Error( 'wpdocs_invalid_export_path', 'Push MD returned an unsafe archive path.' );
			}
		}
		if ( strlen( $path ) > 100 ) {
			return new WP_Error( 'wpdocs_invalid_export_path', 'Push MD returned an archive path that exceeds the tar limit.' );
		}
		return $path;
	}

	private static function tar_file( $path, $content ) {
		$header = str_pad( $path, 100, "\0" ) . sprintf( '%07o', 0644 ) . "\0" . sprintf( '%07o', 0 ) . "\0" . sprintf( '%07o', 0 ) . "\0" . sprintf( '%011o', strlen( $content ) ) . "\0" . sprintf( '%011o', 0 ) . "\0" . str_repeat( ' ', 8 ) . '0' . str_repeat( "\0", 100 ) . "ustar\000" . '00' . str_repeat( "\0", 247 );
		$checksum = array_sum( unpack( 'C*', $header ) );
		$header   = substr_replace( $header, sprintf( "%06o\0 ", $checksum ), 148, 8 );
		return $header . $content . str_repeat( "\0", ( 512 - strlen( $content ) % 512 ) % 512 );
	}

	private static function credentials() {
		$value = static function( $name ) {
			return defined( $name ) ? constant( $name ) : getenv( $name );
		};
		$credentials = array(
			'api_url'  => rtrim( (string) $value( 'WPDOCS_SPACEFAST_API_URL' ), '/' ),
			'token'    => (string) $value( 'WPDOCS_SPACEFAST_TOKEN' ),
			'space_id' => (string) $value( 'WPDOCS_SPACEFAST_SPACE_ID' ),
		);
		$parts = wp_parse_url( $credentials['api_url'] );
		if ( ! $credentials['api_url'] || ! $credentials['token'] || ! $credentials['space_id'] || ! is_array( $parts ) || 'https' !== strtolower( $parts['scheme'] ) || isset( $parts['user'] ) || isset( $parts['pass'] ) ) {
			return new WP_Error( 'wpdocs_spacefast_unconfigured', 'Spacefast server credentials are not configured.' );
		}
		return $credentials;
	}

	private static function api( $method, $path, $body, $idempotency_key ) {
		$credentials = self::credentials();
		if ( is_wp_error( $credentials ) ) {
			return $credentials;
		}
		$args = array(
			'method'  => $method,
			'timeout' => 30,
			'headers' => array(
				'Authorization' => 'Bearer ' . $credentials['token'],
				'Accept'        => 'application/json',
			),
		);
		if ( 'GET' !== $method ) {
			$args['headers']['Idempotency-Key'] = $idempotency_key;
		}
		if ( null !== $body ) {
			$args['headers']['Content-Type'] = 'application/json';
			$args['body']                    = wp_json_encode( $body );
		}
		$response = wp_remote_request( $credentials['api_url'] . $path, $args );
		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) >= 300 ) {
			return new WP_Error( 'wpdocs_spacefast_request_failed', 'Spacefast publication request failed.' );
		}
		$decoded = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( ! is_array( $decoded ) || ! isset( $decoded['data'] ) || ! is_array( $decoded['data'] ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_response', 'Spacefast returned an invalid response.' );
		}
		return $decoded['data'];
	}

	private static function verified_base_url( $version_id, $build_id, $idempotency_key ) {
		$credentials = self::credentials();
		if ( is_wp_error( $credentials ) ) {
			return $credentials;
		}
		$version = self::api( 'GET', '/v1/spaces/' . rawurlencode( $credentials['space_id'] ) . '/versions/' . rawurlencode( $version_id ), null, $idempotency_key );
		if ( is_wp_error( $version ) || $version_id !== (string) ( $version['id'] ?? '' ) || $credentials['space_id'] !== (string) ( $version['spaceId'] ?? '' ) || ( isset( $version['buildId'] ) && $build_id !== (string) $version['buildId'] ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_version', 'Spacefast did not return the succeeded version.' );
		}
		$space = self::api( 'GET', '/v1/spaces/' . rawurlencode( $credentials['space_id'] ), null, $idempotency_key );
		$url   = is_array( $space ) && $credentials['space_id'] === (string) ( $space['id'] ?? '' ) ? WPDocs_Spacefast_Response::serving_url( $space ) : '';
		return $url ? $url : new WP_Error( 'wpdocs_spacefast_invalid_space', 'Spacefast did not return an HTTPS serving URL for the succeeded version.' );
	}

	private static function upload_url( $url, $api_url ) {
		if ( 0 === strpos( $url, '/' ) ) {
			$api = wp_parse_url( $api_url );
			$url = $api['scheme'] . '://' . $api['host'] . ( isset( $api['port'] ) ? ':' . $api['port'] : '' ) . $url;
		}
		$parts = wp_parse_url( $url );
		if ( ! is_array( $parts ) || 'https' !== strtolower( $parts['scheme'] ?? '' ) || isset( $parts['user'] ) || isset( $parts['pass'] ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_upload', 'Spacefast returned an invalid upload URL.' );
		}
		return $url;
	}

	private static function same_origin( $first, $second ) {
		$first  = wp_parse_url( $first );
		$second = wp_parse_url( $second );
		return strtolower( $first['scheme'] ) === strtolower( $second['scheme'] ) && strtolower( $first['host'] ) === strtolower( $second['host'] ) && ( $first['port'] ?? 443 ) === ( $second['port'] ?? 443 );
	}

	private static function has_header( $headers, $name ) {
		foreach ( $headers as $header => $value ) {
			if ( 0 === strcasecmp( $header, $name ) ) {
				return true;
			}
		}
		return false;
	}

	private static function redact( $value ) {
		$value = preg_replace( '#(Bearer\s+|token[=:]\s*)[^\s,]+#i', '$1[REDACTED]', (string) $value );
		$value = preg_replace( '#https?://[^\s/@]+:[^\s/@]+@#', '[REDACTED]@', $value );
		$token = (string) ( defined( 'WPDOCS_SPACEFAST_TOKEN' ) ? WPDOCS_SPACEFAST_TOKEN : getenv( 'WPDOCS_SPACEFAST_TOKEN' ) );
		if ( '' !== $token ) {
			$value = str_replace( $token, '[REDACTED]', $value );
		}
		return substr( sanitize_text_field( $value ), 0, 500 );
	}

	private static function requests() {
		$requests = get_option( self::OPTION_REQUESTS, array() );
		return is_array( $requests ) ? array_values( $requests ) : array();
	}

	private static function save( $requests, $expected = null ) {
		$requests = array_slice( array_values( $requests ), 0, self::MAX_REQUESTS );
		if ( null !== $expected ) {
			$expected = array_slice( array_values( $expected ), 0, self::MAX_REQUESTS );
			global $wpdb;
			if ( isset( $wpdb ) ) {
				$updated = $wpdb->update( $wpdb->options, array( 'option_value' => maybe_serialize( $requests ) ), array( 'option_name' => self::OPTION_REQUESTS, 'option_value' => maybe_serialize( $expected ) ), array( '%s' ), array( '%s', '%s' ) );
				if ( 1 !== $updated ) {
					return false;
				}
				wp_cache_delete( self::OPTION_REQUESTS, 'options' );
				return true;
			}
			if ( $expected !== get_option( self::OPTION_REQUESTS, array() ) ) {
				return false;
			}
		}
		update_option( self::OPTION_REQUESTS, $requests, false );
		return $requests === get_option( self::OPTION_REQUESTS, array() );
	}
}

final class WPDocs_Spacefast_Response {
	public static function build( $response ) {
		$response = isset( $response['build'] ) ? $response['build'] : $response;
		if ( ! is_array( $response ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_build', 'Spacefast returned an invalid build.' );
		}
		$state = isset( $response['status'] ) ? (string) $response['status'] : '';
		if ( ! in_array( $state, array( 'waiting_for_source', 'uploading_source', 'queued', 'running', 'succeeded', 'failed', 'canceled', 'skipped' ), true ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_state', 'Spacefast returned an unknown build state.' );
		}
		$version = isset( $response['producedVersionId'] ) ? sanitize_text_field( $response['producedVersionId'] ) : '';
		if ( ! $version && isset( $response['reusedVersionId'] ) ) {
			$version = sanitize_text_field( $response['reusedVersionId'] );
		}
		return array(
			'id'          => isset( $response['id'] ) ? sanitize_text_field( $response['id'] ) : '',
			'state'       => $state,
			'version_id'  => $version,
			'failure'     => isset( $response['error'] ) ? $response['error'] : '',
		);
	}

	public static function upload( $response ) {
		if ( ! array_key_exists( 'upload', $response ) || null === $response['upload'] ) {
			return null;
		}
		if ( ! is_array( $response['upload'] ) || empty( $response['upload']['targets'] ) || ! is_array( $response['upload']['targets'] ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_upload', 'Spacefast returned invalid upload instructions.' );
		}
		$target = $response['upload']['targets'][0];
		$method = is_array( $target ) && isset( $target['method'] ) ? strtoupper( $target['method'] ) : '';
		$parts  = is_array( $target ) && is_string( $target['url'] ?? null ) && false !== strpos( $target['url'], '://' ) ? wp_parse_url( $target['url'] ) : null;
		if ( ! is_array( $target ) || empty( $target['path'] ) || empty( $target['url'] ) || ! in_array( $method, array( 'PUT', 'POST' ), true ) || ! isset( $target['headers'] ) || ! is_array( $target['headers'] ) || ! is_string( $target['url'] ) || preg_match( '#^//#', $target['url'] ) || ( false === strpos( $target['url'], '://' ) && 0 !== strpos( $target['url'], '/' ) ) || ( is_array( $parts ) && ( 'https' !== strtolower( $parts['scheme'] ?? '' ) || isset( $parts['user'] ) || isset( $parts['pass'] ) ) ) || ( isset( $target['maxBytes'] ) && ( ! is_int( $target['maxBytes'] ) || $target['maxBytes'] < 0 ) ) ) {
			return new WP_Error( 'wpdocs_spacefast_invalid_upload', 'Spacefast returned invalid upload instructions.' );
		}
		return array( 'url' => $target['url'], 'method' => $method, 'headers' => $target['headers'], 'content_type' => isset( $target['contentType'] ) ? (string) $target['contentType'] : '', 'max_bytes' => $target['maxBytes'] ?? null );
	}

	public static function serving_url( $space ) {
		return isset( $space['liveUrl'] ) ? self::url( $space['liveUrl'] ) : '';
	}

	private static function url( $url ) {
		try {
			return WPDocs_URLs::normalize_base_url( $url );
		} catch ( InvalidArgumentException $error ) {
			return '';
		}
	}
}
