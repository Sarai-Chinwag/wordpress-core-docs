<?php
/**
 * Plugin Name: WP Docs
 * Description: WordPress-native documentation content for Push MD and static documentation sites.
 * Version: 0.2.0
 * Requires at least: 6.9
 * Requires PHP: 7.4
 * Requires Plugins: push-md
 * Text Domain: wp-docs
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-wpdocs-urls.php';
require_once __DIR__ . '/includes/class-wpdocs-publication.php';

final class WPDocs_Plugin {
	const POST_TYPE       = 'wpdocs_document';
	const COLLECTION      = 'wpdocs_collection';
	const TOPIC           = 'wpdocs_topic';
	const OPTION_BASE_URL = 'wpdocs_base_url';

	public static function register() {
		register_post_type(
			self::POST_TYPE,
			array(
				'labels'              => array( 'name' => 'Documents', 'singular_name' => 'Document' ),
				'public'              => false,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_rest'        => true,
				'rest_base'           => 'wpdocs-documents',
				'hierarchical'        => true,
				'rewrite'             => false,
				'has_archive'         => false,
				'query_var'           => false,
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'page-attributes', 'custom-fields' ),
				'show_in_nav_menus'   => false,
				'show_in_admin_bar'   => true,
				'show_in_sitemap'     => false,
			)
		);
		register_taxonomy(
			self::COLLECTION,
			self::POST_TYPE,
			array(
				'labels'            => array( 'name' => 'Collections', 'singular_name' => 'Collection' ),
				'public'            => false,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'rest_base'         => 'wpdocs-collections',
				'hierarchical'      => true,
				'rewrite'           => false,
				'query_var'         => false,
				'sort'              => true,
				'show_in_nav_menus' => false,
			)
		);
		register_taxonomy(
			self::TOPIC,
			self::POST_TYPE,
			array(
				'labels'            => array( 'name' => 'Topics', 'singular_name' => 'Topic' ),
				'public'            => false,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'rest_base'         => 'wpdocs-topics',
				'hierarchical'      => false,
				'rewrite'           => false,
				'query_var'         => false,
				'sort'              => true,
				'show_in_nav_menus' => false,
			)
		);

		if ( function_exists( 'push_md_register_content_adapter' ) ) {
			push_md_register_content_adapter(
				self::POST_TYPE,
				array(
					'hierarchical'       => true,
					'frontmatter_fields' => array( 'collections', 'topics' ),
					'export_metadata'    => array( __CLASS__, 'export_push_md_metadata' ),
					'validate_metadata'  => array( __CLASS__, 'validate_push_md_metadata' ),
					'apply_metadata'     => array( __CLASS__, 'apply_push_md_metadata' ),
				)
			);
		}
	}

	public static function register_settings() {
		register_setting(
			'wpdocs',
			self::OPTION_BASE_URL,
			array(
				'type'              => 'string',
				'sanitize_callback' => array( __CLASS__, 'sanitize_base_url' ),
				'default'           => '',
				'show_in_rest'      => true,
			)
		);
	}

	public static function admin_init() {
		self::register_settings();
		add_settings_section( 'wpdocs_urls', 'Static documentation', '__return_false', 'writing' );
		add_settings_field( self::OPTION_BASE_URL, 'Docs base URL', array( __CLASS__, 'base_url_field' ), 'writing', 'wpdocs_urls' );
	}

	public static function sanitize_base_url( $value ) {
		if ( '' === trim( (string) $value ) ) {
			return '';
		}
		try {
			return WPDocs_URLs::normalize_base_url( $value );
		} catch ( InvalidArgumentException $error ) {
			add_settings_error( self::OPTION_BASE_URL, 'wpdocs_invalid_url', $error->getMessage() );
			return get_option( self::OPTION_BASE_URL, '' );
		}
	}

	public static function base_url_field() {
		printf(
			'<input class="regular-text" type="url" name="%1$s" value="%2$s" placeholder="https://docs.example.com" />',
			esc_attr( self::OPTION_BASE_URL ),
			esc_attr( get_option( self::OPTION_BASE_URL, '' ) )
		);
	}

	public static function document_permalink( $permalink, $post, $leavename = false, $sample = false ) {
		unset( $leavename, $sample );
		if ( self::POST_TYPE !== $post->post_type || ! get_option( self::OPTION_BASE_URL ) ) {
			return $permalink;
		}

		return WPDocs_URLs::document_url( $post, get_option( self::OPTION_BASE_URL ), self::ancestors( $post ) );
	}

	public static function document_preview_link( $url, $post ) {
		if ( self::POST_TYPE !== $post->post_type || ! get_option( self::OPTION_BASE_URL ) ) {
			return $url;
		}

		return WPDocs_URLs::document_url( $post, get_option( self::OPTION_BASE_URL ), self::ancestors( $post ), true );
	}

	private static function ancestors( $post ) {
		$ids = get_post_ancestors( $post );
		return $ids ? array_map( 'get_post', array_reverse( $ids ) ) : array();
	}

	public static function export_push_md_metadata( $post ) {
		return array(
			'collections' => self::term_slugs( $post->ID, self::COLLECTION ),
			'topics'      => self::term_slugs( $post->ID, self::TOPIC ),
		);
	}

	private static function term_slugs( $post_id, $taxonomy ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( is_wp_error( $terms ) ) {
			throw new RuntimeException( $terms->get_error_message() );
		}
		if ( ! is_array( $terms ) ) {
			return array();
		}

		$slugs = wp_list_pluck( $terms, 'slug' );
		sort( $slugs, SORT_STRING );
		return $slugs;
	}

	public static function validate_push_md_metadata( $metadata ) {
		$mapping = array(
			'collections' => self::COLLECTION,
			'topics'      => self::TOPIC,
		);
		foreach ( $mapping as $field => $taxonomy ) {
			if ( ! array_key_exists( $field, $metadata ) ) {
				continue;
			}
			$slugs = array_values( array_unique( array_map( 'strval', $metadata[ $field ] ) ) );
			foreach ( $slugs as $slug ) {
				if ( '' === $slug || sanitize_title( $slug ) !== $slug ) {
					throw new InvalidArgumentException( 'WP Docs taxonomy slugs must use canonical WordPress slug formatting.' );
				}
			}
			if ( ! $slugs ) {
				continue;
			}

			$existing = get_terms(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
					'slug'       => $slugs,
					'fields'     => 'slugs',
				)
			);
			if ( is_wp_error( $existing ) ) {
				throw new RuntimeException( $existing->get_error_message() );
			}
			sort( $existing, SORT_STRING );
			sort( $slugs, SORT_STRING );
			if ( $existing !== $slugs ) {
				throw new InvalidArgumentException( 'Push MD cannot assign a WP Docs taxonomy term that does not already exist in WordPress.' );
			}
		}
	}

	public static function apply_push_md_metadata( $post_id, $metadata ) {
		$mapping = array(
			'collections' => self::COLLECTION,
			'topics'      => self::TOPIC,
		);
		foreach ( $mapping as $field => $taxonomy ) {
			if ( ! array_key_exists( $field, $metadata ) ) {
				continue;
			}
			$result = wp_set_object_terms( $post_id, $metadata[ $field ], $taxonomy, false );
			if ( is_wp_error( $result ) ) {
				throw new RuntimeException( $result->get_error_message() );
			}
		}
	}

	public static function register_ability_category() {
		wp_register_ability_category( 'wpdocs-publication', array( 'label' => 'WP Docs publication', 'description' => 'Publication request and status operations for WP Docs.' ) );
	}

	public static function register_abilities() {
		$abilities = array(
			'preview-publication' => array( 'Preview publication', 'Returns the Push MD source and current WP Docs publication context.', 'preview', true, array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ) ),
			'request-publication' => array( 'Request publication', 'Queues an explicit publication request for the credentialed external runner.', 'request', false, array( 'readonly' => false, 'destructive' => false, 'idempotent' => true ) ),
			'get-publication-status' => array( 'Get publication status', 'Returns a durable publication request status record.', 'status', true, array( 'readonly' => true, 'destructive' => false, 'idempotent' => true ) ),
			'report-publication' => array( 'Report publication', 'Records a runner state transition and verified publication evidence.', 'report', false, array( 'readonly' => false, 'destructive' => false, 'idempotent' => false ) ),
		);
		foreach ( $abilities as $name => $definition ) {
			wp_register_ability( 'wpdocs/' . $name, array(
				'label' => $definition[0], 'description' => $definition[1], 'category' => 'wpdocs-publication',
				'input_schema' => self::publication_input_schema( $definition[2] ), 'output_schema' => array( 'type' => array( 'object', 'array' ) ),
				'execute_callback' => array( 'WPDocs_Publication', $definition[2] ),
				'permission_callback' => $definition[3] ? array( __CLASS__, 'can_read_publication' ) : array( __CLASS__, 'can_mutate_publication' ),
				'meta' => array( 'public' => true, 'show_in_rest' => true, 'annotations' => $definition[4] ),
			) );
		}
	}

	private static function publication_input_schema( $operation ) {
		$schema = array( 'type' => 'object', 'additionalProperties' => false, 'properties' => array() );
		if ( 'request' === $operation ) { $schema['properties']['source_git_endpoint'] = array( 'type' => 'string', 'format' => 'uri' ); }
		if ( 'status' === $operation ) { $schema['properties']['request_id'] = array( 'type' => 'string' ); }
		if ( 'report' === $operation ) {
			$schema['properties'] = array(
				'request_id' => array( 'type' => 'string' ), 'state' => array( 'type' => 'string', 'enum' => array( 'running', 'succeeded', 'failed' ) ), 'verified' => array( 'type' => 'boolean' ), 'failure' => array( 'type' => 'string', 'maxLength' => 500 ),
				'artifact' => array( 'type' => 'object', 'additionalProperties' => false, 'properties' => array( 'serving_url' => array( 'type' => 'string', 'format' => 'uri' ), 'version' => array( 'type' => 'string' ), 'identifier' => array( 'type' => 'string' ), 'immutable_url' => array( 'type' => 'string', 'format' => 'uri' ), 'source_revision' => array( 'type' => 'string' ) ) ),
			);
			$schema['required'] = array( 'request_id', 'state' );
		}
		return $schema;
	}

	public static function can_read_publication() { return current_user_can( 'manage_options' ); }
	public static function can_mutate_publication() { return current_user_can( 'manage_options' ); }
}

add_action( 'init', array( 'WPDocs_Plugin', 'register' ) );
add_action( 'admin_init', array( 'WPDocs_Plugin', 'admin_init' ) );
add_action( 'rest_api_init', array( 'WPDocs_Plugin', 'register_settings' ) );
add_action( 'wp_abilities_api_categories_init', array( 'WPDocs_Plugin', 'register_ability_category' ) );
add_action( 'wp_abilities_api_init', array( 'WPDocs_Plugin', 'register_abilities' ) );
add_filter( 'post_type_link', array( 'WPDocs_Plugin', 'document_permalink' ), 10, 4 );
add_filter( 'preview_post_link', array( 'WPDocs_Plugin', 'document_preview_link' ), 10, 2 );
