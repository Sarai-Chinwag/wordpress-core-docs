<?php
define( 'ABSPATH', __DIR__ . '/' );

$wpdocs_registered_post_types = array();
$wpdocs_registered_taxonomies = array();
$wpdocs_adapter               = null;
$wpdocs_hooks                 = array();
$wpdocs_registered_settings   = array();
$wpdocs_term_failure          = false;
$wpdocs_term_assignments      = array();
$wpdocs_abilities             = array();
$wpdocs_categories            = array();
$wpdocs_options               = array();
$wpdocs_can_manage            = true;

class WPDocs_Test_Error {
	private $message;
	public function __construct( $message ) { $this->message = $message; }
	public function get_error_message() { return $this->message; }
}
class WP_Error extends WPDocs_Test_Error { public function __construct( $code, $message, $data = array() ) { parent::__construct( $message ); } }
class WPDocs_Test_DB {
	public $options  = 'wp_options';
	public $conflict = false;
	public function update( $table, $data, $where ) {
		global $wpdocs_options;
		unset( $table );
		if ( $this->conflict || maybe_serialize( $wpdocs_options[ $where['option_name'] ] ) !== $where['option_value'] ) { return 0; }
		$wpdocs_options[ $where['option_name'] ] = unserialize( $data['option_value'] );
		return 1;
	}
}
$wpdb = new WPDocs_Test_DB();

function register_post_type( $name, $args ) { global $wpdocs_registered_post_types; $wpdocs_registered_post_types[ $name ] = $args; }
function register_taxonomy( $name, $types, $args ) { global $wpdocs_registered_taxonomies; $wpdocs_registered_taxonomies[ $name ] = array( $types, $args ); }
function push_md_register_content_adapter( $post_type, $args ) { global $wpdocs_adapter; $wpdocs_adapter = array( $post_type, $args ); }
function add_action( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function add_filter( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function wp_register_ability( $name, $args ) { global $wpdocs_abilities; $wpdocs_abilities[ $name ] = $args; }
function wp_register_ability_category( $name, $args ) { global $wpdocs_categories; $wpdocs_categories[ $name ] = $args; }
function register_setting( $group, $name, $args ) { global $wpdocs_registered_settings; $wpdocs_registered_settings[ $name ] = array( $group, $args ); }
function add_settings_section() {}
function add_settings_field() {}
function is_wp_error( $value ) { return $value instanceof WPDocs_Test_Error; }
function current_user_can( $capability ) { global $wpdocs_can_manage; return 'manage_options' !== $capability || $wpdocs_can_manage; }
function get_current_user_id() { return 12; }
function wp_generate_uuid4() { static $sequence = 0; ++$sequence; return sprintf( '00000000-0000-4000-8000-%012d', $sequence ); }
function current_time( $format, $gmt = false ) { unset( $format, $gmt ); return '2026-07-17 12:00:00'; }
function rest_url( $path ) { return 'https://example.test/wp-json/' . $path; }
function wp_count_posts() { return (object) array( 'publish' => 3 ); }
function esc_url_raw( $url ) { return filter_var( $url, FILTER_VALIDATE_URL ) ? $url : ''; }
function sanitize_text_field( $value ) { return trim( strip_tags( (string) $value ) ); }
function maybe_serialize( $value ) { return is_array( $value ) ? serialize( $value ) : $value; }
function wp_cache_delete() { return true; }
function get_option( $name, $default = false ) { global $wpdocs_options; return array_key_exists( $name, $wpdocs_options ) ? $wpdocs_options[ $name ] : $default; }
function update_option( $name, $value ) { global $wpdocs_options; $wpdocs_options[ $name ] = $value; return true; }
function wp_list_pluck( $items, $field ) { return array_map( static function ( $item ) use ( $field ) { return $item->$field; }, $items ); }
function sanitize_title( $value ) { return trim( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $value ) ), '-' ); }
function get_the_terms( $post_id, $taxonomy ) {
	unset( $post_id );
	$slugs = 'wpdocs_collection' === $taxonomy ? array( 'reference', 'guides' ) : array( 'wordpress', 'blocks' );
	return array_map( static function ( $slug ) { return (object) array( 'slug' => $slug ); }, $slugs );
}
function get_terms( $args ) {
	$known = array(
		'wpdocs_collection' => array( 'guides', 'reference' ),
		'wpdocs_topic'      => array( 'blocks', 'wordpress' ),
	);
	return array_values( array_intersect( $known[ $args['taxonomy'] ], $args['slug'] ) );
}
function wp_set_object_terms( $post_id, $terms, $taxonomy, $append ) {
	global $wpdocs_term_failure, $wpdocs_term_assignments;
	unset( $append );
	if ( $wpdocs_term_failure ) { return new WPDocs_Test_Error( 'term assignment failed' ); }
	$wpdocs_term_assignments[] = array( $post_id, $taxonomy, $terms );
	return array();
}

require __DIR__ . '/../../plugins/wp-docs/wp-docs.php';

function wpdocs_assert( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }
function wpdocs_throws( $callback, $message ) { try { $callback(); } catch ( InvalidArgumentException $error ) { return; } throw new RuntimeException( $message ); }

WPDocs_Plugin::register();
WPDocs_Plugin::register_settings();
WPDocs_Plugin::register_ability_category();
WPDocs_Plugin::register_abilities();
$post_type = $wpdocs_registered_post_types['wpdocs_document'];
wpdocs_assert( $post_type['hierarchical'] && $post_type['show_ui'] && $post_type['show_in_rest'], 'document editor registration is incomplete' );
wpdocs_assert( ! $post_type['public'] && ! $post_type['publicly_queryable'] && ! $post_type['rewrite'] && ! $post_type['has_archive'] && ! $post_type['query_var'] && $post_type['exclude_from_search'] && ! $post_type['show_in_sitemap'], 'document must remain absent from WordPress frontend' );
wpdocs_assert( in_array( 'revisions', $post_type['supports'], true ) && in_array( 'page-attributes', $post_type['supports'], true ), 'document supports are incomplete' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['hierarchical'] && ! $wpdocs_registered_taxonomies['wpdocs_topic'][1]['hierarchical'], 'taxonomy hierarchy is wrong' );

wpdocs_assert( 'wpdocs_document' === $wpdocs_adapter[0], 'Push MD adapter post type is wrong' );
$adapter = $wpdocs_adapter[1];
wpdocs_assert( $adapter['hierarchical'], 'Push MD adapter must preserve document hierarchy' );
wpdocs_assert( array( 'collections', 'topics' ) === $adapter['frontmatter_fields'], 'Push MD adapter metadata fields are wrong' );
wpdocs_assert( $wpdocs_registered_settings['wpdocs_base_url'][1]['show_in_rest'], 'Docs base URL must use the core settings REST endpoint' );
wpdocs_assert( isset( $wpdocs_hooks['rest_api_init'] ), 'Docs base URL setting must register during REST initialization' );
wpdocs_assert( 4 === count( $wpdocs_abilities ), 'publication abilities were not registered' );
wpdocs_assert( $wpdocs_abilities['wpdocs/request-publication']['permission_callback']() && ! $wpdocs_abilities['wpdocs/preview-publication']['meta']['annotations']['destructive'], 'publication ability metadata is incomplete' );
$wpdocs_can_manage = false;
wpdocs_assert( ! $wpdocs_abilities['wpdocs/request-publication']['permission_callback'](), 'publication mutation must require manage_options' );
wpdocs_assert( ! $wpdocs_abilities['wpdocs/get-publication-status']['permission_callback'](), 'publication history must require manage_options' );
$wpdocs_can_manage = true;

$request = WPDocs_Publication::request();
wpdocs_assert( 'queued' === $request['state'] && 'https://example.test/wp-json/git/v1/md.git' === $request['source_git_endpoint'], 'publication request is not durable or deterministic' );
wpdocs_assert( is_wp_error( WPDocs_Publication::report( array( 'request_id' => $request['request_id'], 'state' => 'succeeded' ) ) ), 'unverified success was accepted' );
$running = WPDocs_Publication::report( array( 'request_id' => $request['request_id'], 'state' => 'running' ) );
wpdocs_assert( 'running' === $running['state'], 'queued request did not enter running state' );
wpdocs_assert( is_wp_error( WPDocs_Publication::report( array( 'request_id' => $request['request_id'], 'state' => 'succeeded', 'verified' => true, 'artifact' => array( 'serving_url' => 'https://docs.example.test', 'version' => 'ver_abc123', 'identifier' => 'spc_abc123' ) ) ) ), 'success without an immutable version URL was accepted' );
$success = WPDocs_Publication::report( array( 'request_id' => $request['request_id'], 'state' => 'succeeded', 'verified' => true, 'artifact' => array( 'serving_url' => 'https://docs.example.test', 'version' => 'ver_abc123', 'identifier' => 'spc_abc123', 'immutable_url' => 'https://v42--docs.view.fast', 'source_revision' => 'abc123' ) ) );
wpdocs_assert( 'succeeded' === $success['state'] && 'https://docs.example.test' === get_option( 'wpdocs_base_url' ), 'verified publication did not update the base URL' );
wpdocs_assert( is_wp_error( WPDocs_Publication::report( array( 'request_id' => $request['request_id'], 'state' => 'failed', 'failure' => 'late result' ) ) ), 'stale terminal report was accepted' );
$failed_request = WPDocs_Publication::request();
$wpdb->conflict = true;
wpdocs_assert( is_wp_error( WPDocs_Publication::report( array( 'request_id' => $failed_request['request_id'], 'state' => 'running' ) ) ) && 'queued' === WPDocs_Publication::status( array( 'request_id' => $failed_request['request_id'] ) )['state'], 'a runner won a stale compare-and-swap claim' );
$wpdb->conflict = false;
$failure = WPDocs_Publication::report( array( 'request_id' => $failed_request['request_id'], 'state' => 'failed', 'failure' => 'git https://user:secret@example.test failed' ) );
wpdocs_assert( 'failed' === $failure['state'] && false === strpos( $failure['failure'], 'secret' ) && 'https://docs.example.test' === get_option( 'wpdocs_base_url' ), 'failure report leaked credentials or changed the base URL' );

$metadata = call_user_func( $adapter['export_metadata'], (object) array( 'ID' => 7 ) );
wpdocs_assert( array( 'guides', 'reference' ) === $metadata['collections'], 'collection export is not deterministic' );
wpdocs_assert( array( 'blocks', 'wordpress' ) === $metadata['topics'], 'topic export is not deterministic' );
call_user_func( $adapter['validate_metadata'], $metadata, array() );
wpdocs_throws( static function () use ( $adapter ) { call_user_func( $adapter['validate_metadata'], array( 'topics' => array( 'Missing Topic' ) ), array() ); }, 'non-canonical taxonomy slug was accepted' );
wpdocs_throws( static function () use ( $adapter ) { call_user_func( $adapter['validate_metadata'], array( 'topics' => array( 'missing-topic' ) ), array() ); }, 'missing taxonomy term was accepted' );

call_user_func( $adapter['apply_metadata'], 7, $metadata, array() );
wpdocs_assert( 2 === count( $wpdocs_term_assignments ), 'Push MD metadata did not apply both taxonomies' );
$wpdocs_term_failure = true;
try {
	call_user_func( $adapter['apply_metadata'], 7, $metadata, array() );
	throw new RuntimeException( 'term assignment failure was hidden' );
} catch ( RuntimeException $error ) {
	wpdocs_assert( 'term assignment failed' === $error->getMessage(), 'wrong term assignment failure' );
}

$root   = (object) array( 'post_name' => 'root' );
$parent = (object) array( 'post_name' => 'section' );
$child  = (object) array( 'post_name' => 'page' );
wpdocs_assert( 'https://docs.example.com/root/section/page/' === WPDocs_URLs::document_url( $child, 'https://DOCS.example.com/', array( $root, $parent ) ), 'canonical static URL is unstable' );

printf( "WP Docs Push MD adapter tests passed.\n" );
