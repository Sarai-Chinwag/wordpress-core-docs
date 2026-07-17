<?php
/**
 * Durable, provider-neutral publication request state.
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
		);
	}

	public static function request( $input = array() ) {
		$endpoint = isset( $input['source_git_endpoint'] ) ? (string) $input['source_git_endpoint'] : self::source_endpoint();
		if ( self::source_endpoint() !== $endpoint ) {
			return new WP_Error( 'wpdocs_invalid_source', 'Publication requests may only use this site\'s Push MD endpoint.', array( 'status' => 400 ) );
		}

		$requests = self::requests();
		foreach ( $requests as $request ) {
			if ( in_array( $request['state'], array( 'queued', 'running' ), true ) && $request['source_git_endpoint'] === $endpoint ) {
				return $request;
			}
		}

		$requested_at = current_time( 'mysql', true );
		$user_id      = get_current_user_id();
		$request      = array(
			'request_id'          => 'wpdocs-' . wp_generate_uuid4(),
			'source_git_endpoint' => $endpoint,
			'requested_at'        => $requested_at,
			'requested_by'        => (int) $user_id,
			'state'               => 'queued',
			'updated_at'          => $requested_at,
			'artifact'            => array(),
			'failure'             => '',
		);
		array_unshift( $requests, $request );
		if ( ! self::save( $requests ) ) {
			return new WP_Error( 'wpdocs_request_store_failed', 'Publication request could not be stored.', array( 'status' => 500 ) );
		}
		return $request;
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

	public static function report( $input = array() ) {
		if ( empty( $input['request_id'] ) || empty( $input['state'] ) ) {
			return new WP_Error( 'wpdocs_invalid_report', 'A request ID and state are required.', array( 'status' => 400 ) );
		}
		$requests          = self::requests();
		$previous_requests = $requests;
		foreach ( $requests as $index => $request ) {
			if ( ! hash_equals( $request['request_id'], (string) $input['request_id'] ) ) {
				continue;
			}
			$state = (string) $input['state'];
			if ( ! self::transition_allowed( $request['state'], $state ) ) {
				return new WP_Error( 'wpdocs_stale_report', 'Publication report does not match the current request state.', array( 'status' => 409 ) );
			}
			if ( 'succeeded' === $state && ! self::verified_artifact( $input ) ) {
				return new WP_Error( 'wpdocs_unverified_publication', 'A succeeded report requires a verified serving URL and immutable publication evidence.', array( 'status' => 400 ) );
			}

			$request['state']      = $state;
			$request['updated_at'] = current_time( 'mysql', true );
			if ( isset( $input['artifact'] ) && is_array( $input['artifact'] ) ) {
				$request['artifact'] = self::artifact( $input['artifact'] );
			}
			if ( 'failed' === $state ) {
				$request['failure'] = self::redact_failure( isset( $input['failure'] ) ? $input['failure'] : '' );
			}
			$requests[ $index ] = $request;
			if ( 'succeeded' === $state ) {
				$previous_base_url = get_option( WPDocs_Plugin::OPTION_BASE_URL, '' );
				update_option( WPDocs_Plugin::OPTION_BASE_URL, $request['artifact']['serving_url'], false );
				if ( $request['artifact']['serving_url'] !== get_option( WPDocs_Plugin::OPTION_BASE_URL, '' ) ) {
					return new WP_Error( 'wpdocs_base_url_store_failed', 'The verified publication URL could not be stored.', array( 'status' => 500 ) );
				}
			}
			if ( ! self::save( $requests, $previous_requests ) ) {
				if ( 'succeeded' === $state ) {
					update_option( WPDocs_Plugin::OPTION_BASE_URL, $previous_base_url, false );
				}
				return new WP_Error( 'wpdocs_stale_report', 'Another runner changed the publication request first.', array( 'status' => 409 ) );
			}
			return $request;
		}
		return new WP_Error( 'wpdocs_request_not_found', 'Publication request was not found.', array( 'status' => 404 ) );
	}

	public static function transition_allowed( $from, $to ) {
		return ( 'queued' === $from && in_array( $to, array( 'running', 'failed' ), true ) ) || ( 'running' === $from && in_array( $to, array( 'succeeded', 'failed' ), true ) );
	}

	private static function verified_artifact( $input ) {
		$artifact      = isset( $input['artifact'] ) && is_array( $input['artifact'] ) ? $input['artifact'] : array();
		$url           = self::normalized_url( isset( $artifact['serving_url'] ) ? $artifact['serving_url'] : '' );
		$immutable_url = self::normalized_url( isset( $artifact['immutable_url'] ) ? $artifact['immutable_url'] : '' );
		return ! empty( $input['verified'] ) && 0 === strpos( $url, 'https://' ) && 0 === strpos( $immutable_url, 'https://' ) && ! empty( $artifact['version'] ) && ! empty( $artifact['identifier'] );
	}

	private static function artifact( $artifact ) {
		return array(
			'serving_url'     => self::normalized_url( isset( $artifact['serving_url'] ) ? $artifact['serving_url'] : '' ),
			'version'         => isset( $artifact['version'] ) ? sanitize_text_field( $artifact['version'] ) : '',
			'identifier'      => isset( $artifact['identifier'] ) ? sanitize_text_field( $artifact['identifier'] ) : '',
			'immutable_url'   => self::normalized_url( isset( $artifact['immutable_url'] ) ? $artifact['immutable_url'] : '' ),
			'source_revision' => isset( $artifact['source_revision'] ) ? sanitize_text_field( $artifact['source_revision'] ) : '',
		);
	}

	private static function normalized_url( $url ) {
		try {
			return WPDocs_URLs::normalize_base_url( $url );
		} catch ( InvalidArgumentException $error ) {
			return '';
		}
	}

	private static function redact_failure( $failure ) {
		$failure = preg_replace( '#https?://[^\s/@]+:[^\s/@]+@#', '[REDACTED]@', (string) $failure );
		return substr( sanitize_text_field( $failure ), 0, 500 );
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
				$updated = $wpdb->update(
					$wpdb->options,
					array( 'option_value' => maybe_serialize( $requests ) ),
					array( 'option_name' => self::OPTION_REQUESTS, 'option_value' => maybe_serialize( $expected ) ),
					array( '%s' ),
					array( '%s', '%s' )
				);
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

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	/** WP-CLI commands delegate to the same durable publication service as Abilities. */
	class WPDocs_Publication_CLI {
		public function preview() { WP_CLI::log( wp_json_encode( WPDocs_Publication::preview() ) ); }
		public function request( $args, $assoc_args ) {
			unset( $args );
			$this->result( WPDocs_Publication::request( array_filter( array( 'source_git_endpoint' => isset( $assoc_args['source-git-endpoint'] ) ? $assoc_args['source-git-endpoint'] : null ) ) ) );
		}
		public function status( $args ) { $this->result( WPDocs_Publication::status( empty( $args[0] ) ? array() : array( 'request_id' => $args[0] ) ) ); }
		public function report( $args, $assoc_args ) {
			unset( $args );
			$this->result( WPDocs_Publication::report( array( 'request_id' => $assoc_args['request-id'], 'state' => $assoc_args['state'], 'verified' => ! empty( $assoc_args['verified'] ), 'failure' => isset( $assoc_args['failure'] ) ? $assoc_args['failure'] : '', 'artifact' => array( 'serving_url' => isset( $assoc_args['serving-url'] ) ? $assoc_args['serving-url'] : '', 'version' => isset( $assoc_args['version'] ) ? $assoc_args['version'] : '', 'identifier' => isset( $assoc_args['identifier'] ) ? $assoc_args['identifier'] : '', 'immutable_url' => isset( $assoc_args['immutable-url'] ) ? $assoc_args['immutable-url'] : '', 'source_revision' => isset( $assoc_args['source-revision'] ) ? $assoc_args['source-revision'] : '' ) ) ) );
		}
		private function result( $result ) { if ( is_wp_error( $result ) ) { WP_CLI::error( $result->get_error_message() ); } WP_CLI::log( wp_json_encode( $result ) ); }
	}
	WP_CLI::add_command( 'wpdocs publication', 'WPDocs_Publication_CLI' );
}
