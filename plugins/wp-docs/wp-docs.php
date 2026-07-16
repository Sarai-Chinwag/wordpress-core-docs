<?php
/**
 * Plugin Name: WP Docs
 * Description: Local editorial control plane and deterministic Markdown synchronization artifacts for static documentation.
 * Version: 0.1.0
 * Requires at least: 6.4
 * Requires PHP: 7.4
 * Text Domain: wp-docs
 *
 * @package WPDocs
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-wpdocs-codec.php';
require_once __DIR__ . '/includes/class-wpdocs-urls.php';
require_once __DIR__ . '/includes/class-wpdocs-sync.php';

final class WPDocs_Plugin {
	const POST_TYPE = 'wpdocs_document';
	const COLLECTION = 'wpdocs_collection';
	const TOPIC = 'wpdocs_topic';
	const OPTION_BASE_URL = 'wpdocs_base_url';

	public static function register() {
		register_post_type( self::POST_TYPE, array(
			'labels' => array( 'name' => 'Documents', 'singular_name' => 'Document' ),
			'public' => false, 'publicly_queryable' => false, 'exclude_from_search' => true,
			'show_ui' => true, 'show_in_menu' => true, 'show_in_rest' => true, 'rest_base' => 'wpdocs-documents',
			'hierarchical' => true, 'rewrite' => false, 'has_archive' => false, 'query_var' => false,
			'supports' => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'page-attributes', 'custom-fields' ),
			'show_in_nav_menus' => false, 'show_in_admin_bar' => true, 'show_in_sitemap' => false,
		) );
		register_taxonomy( self::COLLECTION, self::POST_TYPE, array(
			'labels' => array( 'name' => 'Collections', 'singular_name' => 'Collection' ), 'public' => false,
			'show_ui' => true, 'show_in_rest' => true, 'rest_base' => 'wpdocs-collections', 'hierarchical' => true,
			'rewrite' => false, 'query_var' => false, 'sort' => true, 'show_in_nav_menus' => false,
		) );
		register_taxonomy( self::TOPIC, self::POST_TYPE, array(
			'labels' => array( 'name' => 'Topics', 'singular_name' => 'Topic' ), 'public' => false,
			'show_ui' => true, 'show_in_rest' => true, 'rest_base' => 'wpdocs-topics', 'hierarchical' => false,
			'rewrite' => false, 'query_var' => false, 'sort' => true, 'show_in_nav_menus' => false,
		) );
	}

	public static function admin_init() {
		register_setting( 'wpdocs', self::OPTION_BASE_URL, array( 'type' => 'string', 'sanitize_callback' => array( __CLASS__, 'sanitize_base_url' ), 'default' => '' ) );
		add_settings_section( 'wpdocs_urls', 'Static documentation', '__return_false', 'writing' );
		add_settings_field( self::OPTION_BASE_URL, 'Docs base URL', array( __CLASS__, 'base_url_field' ), 'writing', 'wpdocs_urls' );
	}

	public static function sanitize_base_url( $value ) {
		if ( '' === trim( (string) $value ) ) { return ''; }
		try { return WPDocs_URLs::normalize_base_url( $value ); } catch ( InvalidArgumentException $error ) { add_settings_error( self::OPTION_BASE_URL, 'wpdocs_invalid_url', $error->getMessage() ); return get_option( self::OPTION_BASE_URL, '' ); }
	}

	public static function base_url_field() {
		printf( '<input class="regular-text" type="url" name="%1$s" value="%2$s" placeholder="https://docs.example.com" />', esc_attr( self::OPTION_BASE_URL ), esc_attr( get_option( self::OPTION_BASE_URL, '' ) ) );
	}

	public static function document_permalink( $permalink, $post, $leavename = false, $sample = false ) {
		if ( self::POST_TYPE !== $post->post_type || ! get_option( self::OPTION_BASE_URL ) ) { return $permalink; }
		return WPDocs_URLs::document_url( $post, get_option( self::OPTION_BASE_URL ), get_post_ancestors( $post ) ? array_map( 'get_post', array_reverse( get_post_ancestors( $post ) ) ) : array() );
	}

	public static function document_preview_link( $url, $post ) {
		if ( self::POST_TYPE !== $post->post_type || ! get_option( self::OPTION_BASE_URL ) ) { return $url; }
		return WPDocs_URLs::document_url( $post, get_option( self::OPTION_BASE_URL ), get_post_ancestors( $post ) ? array_map( 'get_post', array_reverse( get_post_ancestors( $post ) ) ) : array(), true );
	}

	/** @return array<string,mixed> */
	public static function record_from_post( $post ) {
		$ancestors = array_map( 'get_post', array_reverse( get_post_ancestors( $post ) ) );
		$parent = $post->post_parent ? get_post( $post->post_parent ) : null;
		return WPDocs_Codec::normalize_record( array(
			'identity' => get_post_meta( $post->ID, 'wpdocs_identity', true ) ?: 'wp:post:' . $post->ID,
			'slug' => $post->post_name, 'parent_identity' => $parent ? ( get_post_meta( $parent->ID, 'wpdocs_identity', true ) ?: 'wp:post:' . $parent->ID ) : '',
			'parent_path' => $parent ? WPDocs_URLs::canonical_path( $parent, array_slice( $ancestors, 0, -1 ) ) : '',
			'menu_order' => $post->menu_order, 'status' => $post->post_status, 'title' => $post->post_title,
			'excerpt' => $post->post_excerpt, 'terms' => array( 'collections' => self::term_slugs( $post->ID, self::COLLECTION ), 'topics' => self::term_slugs( $post->ID, self::TOPIC ) ),
			'canonical_path' => WPDocs_URLs::canonical_path( $post, $ancestors ), 'content' => $post->post_content,
		) );
	}

	private static function term_slugs( $post_id, $taxonomy ) {
		$terms = get_the_terms( $post_id, $taxonomy );
		if ( ! is_array( $terms ) ) { return array(); }
		$slugs = wp_list_pluck( $terms, 'slug' ); sort( $slugs, SORT_STRING ); return $slugs;
	}

	/** @return array<int,array<string,mixed>> */
	public static function records( $ids = array() ) {
		$args = array( 'post_type' => self::POST_TYPE, 'post_status' => 'any', 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'ASC' );
		if ( $ids ) { $args['post__in'] = array_map( 'absint', $ids ); }
		return array_map( array( __CLASS__, 'record_from_post' ), get_posts( $args ) );
	}

	public static function register_rest() {
		$permission = static function () { return current_user_can( 'edit_others_posts' ); };
		register_rest_route( 'wpdocs/v1', '/export', array( 'methods' => 'POST', 'permission_callback' => $permission, 'args' => array( 'ids' => array( 'type' => 'array', 'items' => array( 'type' => 'integer' ) ) ), 'callback' => array( __CLASS__, 'rest_export' ) ) );
		foreach ( array( 'preview', 'apply' ) as $phase ) {
			register_rest_route( 'wpdocs/v1', '/import/' . $phase, array( 'methods' => 'POST', 'permission_callback' => $permission, 'args' => array( 'records' => array( 'required' => true, 'type' => 'array', 'items' => array( 'type' => 'string' ) ), 'plan' => array( 'required' => 'apply' === $phase, 'type' => 'object' ) ), 'callback' => array( __CLASS__, 'rest_import_' . $phase ) ) );
		}
	}

	public static function rest_export( $request ) { return rest_ensure_response( WPDocs_Sync::export_artifact( self::records( $request->get_param( 'ids' ) ?: array() ), get_option( self::OPTION_BASE_URL, '' ), self::term_records() ) ); }
	public static function rest_import_preview( $request ) { try { return rest_ensure_response( WPDocs_Sync::preview_import( self::decode_records( $request->get_param( 'records' ) ), self::records() ) ); } catch ( Exception $error ) { return new WP_Error( 'wpdocs_invalid_import', $error->getMessage(), array( 'status' => 400 ) ); } }
	public static function rest_import_apply( $request ) {
		try { $plan = WPDocs_Sync::validate_apply( (array) $request->get_param( 'plan' ), self::decode_records( $request->get_param( 'records' ) ), self::records() ); self::apply_changes( $plan['changes'] ); return rest_ensure_response( $plan ); } catch ( Exception $error ) { return new WP_Error( 'wpdocs_stale_import', $error->getMessage(), array( 'status' => 409 ) ); }
	}
	private static function decode_records( $markdown ) { return array_map( array( 'WPDocs_Codec', 'decode' ), (array) $markdown ); }
	/** @return array<int,array<string,string>> */
	public static function term_records() {
		$records = array();
		foreach ( array( self::COLLECTION, self::TOPIC ) as $taxonomy ) {
			$terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false ) );
			if ( is_wp_error( $terms ) ) { throw new RuntimeException( $terms->get_error_message() ); }
			foreach ( $terms as $term ) {
				$parent = $term->parent ? get_term( $term->parent, $taxonomy ) : null;
				$records[] = array( 'taxonomy' => $taxonomy, 'slug' => $term->slug, 'name' => $term->name, 'description' => $term->description, 'parent_slug' => $parent && ! is_wp_error( $parent ) ? $parent->slug : '' );
			}
		}
		return WPDocs_Codec::normalize_terms( $records );
	}
	public static function apply_changes( $changes ) {
		$ids = array();
		$parent_updates = array();
		foreach ( get_posts( array( 'post_type' => self::POST_TYPE, 'post_status' => 'any', 'numberposts' => -1 ) ) as $post ) {
			$ids[ get_post_meta( $post->ID, 'wpdocs_identity', true ) ?: 'wp:post:' . $post->ID ] = $post->ID;
		}
		foreach ( $changes as $change ) {
			if ( 'noop' === $change['action'] ) { continue; }
			$record = $change['record'];
			$post_id = wp_insert_post( array( 'ID' => $ids[ $record['identity'] ] ?? 0, 'post_type' => self::POST_TYPE, 'post_name' => $record['slug'], 'post_status' => $record['status'], 'post_title' => $record['title'], 'post_excerpt' => $record['excerpt'], 'post_content' => $record['content'], 'menu_order' => $record['menu_order'], 'post_parent' => 0 ), true );
			if ( is_wp_error( $post_id ) ) { throw new RuntimeException( $post_id->get_error_message() ); }
			$ids[ $record['identity'] ] = $post_id;
			$parent_updates[ $post_id ] = $record['parent_identity'];
			update_post_meta( $post_id, 'wpdocs_identity', $record['identity'] );
			$collections = wp_set_object_terms( $post_id, $record['terms']['collections'], self::COLLECTION, false );
			if ( is_wp_error( $collections ) ) { throw new RuntimeException( $collections->get_error_message() ); }
			$topics = wp_set_object_terms( $post_id, $record['terms']['topics'], self::TOPIC, false );
			if ( is_wp_error( $topics ) ) { throw new RuntimeException( $topics->get_error_message() ); }
		}
		foreach ( $parent_updates as $post_id => $parent_identity ) {
			$updated = wp_update_post( array( 'ID' => $post_id, 'post_parent' => '' === $parent_identity ? 0 : $ids[ $parent_identity ] ), true );
			if ( is_wp_error( $updated ) ) { throw new RuntimeException( $updated->get_error_message() ); }
		}
	}

	/** @param array<int,string> $paths @return array<int,array<string,mixed>> */
	public static function decode_record_files( array $paths ) {
		$records = array();
		foreach ( $paths as $path ) {
			if ( ! is_file( $path ) || ! is_readable( $path ) ) { throw new InvalidArgumentException( 'WPDocs record file is missing or unreadable: ' . $path ); }
			$content = file_get_contents( $path );
			if ( false === $content ) { throw new InvalidArgumentException( 'WPDocs record file is unreadable: ' . $path ); }
			try { $records[] = WPDocs_Codec::decode( $content ); } catch ( Exception $error ) { throw new InvalidArgumentException( 'WPDocs record file is invalid (' . $path . '): ' . $error->getMessage() ); }
		}
		return $records;
	}

	/** @return array<string,mixed> */
	public static function read_plan_file( $path ) {
		if ( ! is_file( $path ) || ! is_readable( $path ) ) { throw new InvalidArgumentException( 'WPDocs plan file is missing or unreadable: ' . $path ); }
		$content = file_get_contents( $path );
		if ( false === $content ) { throw new InvalidArgumentException( 'WPDocs plan file is unreadable: ' . $path ); }
		try { $plan = json_decode( $content, true, 512, JSON_THROW_ON_ERROR ); } catch ( Exception $error ) { throw new InvalidArgumentException( 'WPDocs plan file is invalid JSON: ' . $path ); }
		if ( ! is_array( $plan ) ) { throw new InvalidArgumentException( 'WPDocs plan file must contain a JSON object: ' . $path ); }
		return $plan;
	}
}

add_action( 'init', array( 'WPDocs_Plugin', 'register' ) );
add_action( 'admin_init', array( 'WPDocs_Plugin', 'admin_init' ) );
add_action( 'rest_api_init', array( 'WPDocs_Plugin', 'register_rest' ) );
add_filter( 'post_type_link', array( 'WPDocs_Plugin', 'document_permalink' ), 10, 4 );
add_filter( 'preview_post_link', array( 'WPDocs_Plugin', 'document_preview_link' ), 10, 2 );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	WP_CLI::add_command( 'wpdocs export', static function () { WP_CLI::line( WPDocs_Codec::json( WPDocs_Sync::export_artifact( WPDocs_Plugin::records(), get_option( WPDocs_Plugin::OPTION_BASE_URL, '' ), WPDocs_Plugin::term_records() ) ) ); } );
	WP_CLI::add_command( 'wpdocs import-preview', static function ( $args ) { try { WP_CLI::line( WPDocs_Codec::json( WPDocs_Sync::preview_import( WPDocs_Plugin::decode_record_files( $args ), WPDocs_Plugin::records() ) ) ); } catch ( Exception $error ) { WP_CLI::error( $error->getMessage() ); } } );
	WP_CLI::add_command( 'wpdocs import-apply', static function ( $args ) { if ( count( $args ) < 2 ) { WP_CLI::error( 'Usage: wpdocs import-apply <plan.json> <record.md>...' ); } try { $plan = WPDocs_Plugin::read_plan_file( array_shift( $args ) ); $fresh = WPDocs_Sync::validate_apply( $plan, WPDocs_Plugin::decode_record_files( $args ), WPDocs_Plugin::records() ); WPDocs_Plugin::apply_changes( $fresh['changes'] ); WP_CLI::line( WPDocs_Codec::json( $fresh ) ); } catch ( Exception $error ) { WP_CLI::error( $error->getMessage() ); } } );
}
