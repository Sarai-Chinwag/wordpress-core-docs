<?php
define( 'ABSPATH', __DIR__ . '/' );
define( 'WPDOCS_SPACEFAST_API_URL', 'https://spacefast.example.test' );
define( 'WPDOCS_SPACEFAST_TOKEN', 'very-secret-token' );
define( 'WPDOCS_SPACEFAST_SPACE_ID', 'spc_123' );

$wpdocs_registered_post_types = array();
$wpdocs_registered_taxonomies = array();
$wpdocs_registered_settings   = array();
$wpdocs_hooks                 = array();
$wpdocs_abilities             = array();
$wpdocs_categories            = array();
$wpdocs_options               = array();
$wpdocs_adapter               = null;
$wpdocs_can_manage            = true;
$wpdocs_term_failure          = false;
$wpdocs_term_assignments      = array();
$wpdocs_remote                = array();
$wpdocs_calls                 = array();
$wpdocs_paths                 = array();

class WPDocs_Test_Error {
	private $message;
	public function __construct( $message ) { $this->message = $message; }
	public function get_error_message() { return $this->message; }
}
class WP_Error extends WPDocs_Test_Error { public function __construct( $code, $message, $data = array() ) { parent::__construct( $message ); } }
class WPDocs_Test_DB {
	public $options = 'wp_options';
	public $conflict = false;
	public function update( $table, $data, $where ) {
		global $wpdocs_options;
		if ( $this->conflict || maybe_serialize( $wpdocs_options[ $where['option_name'] ] ) !== $where['option_value'] ) return 0;
		$wpdocs_options[ $where['option_name'] ] = unserialize( $data['option_value'] );
		return 1;
	}
}
class Push_MD_Plugin {
	public static function build_markdown_path( $post ) { global $wpdocs_paths; return isset( $wpdocs_paths[ $post->ID ] ) ? $wpdocs_paths[ $post->ID ] : 'wpdocs_document/' . ( 1 === $post->ID ? 'guides/' : '' ) . $post->post_name . '.md'; }
	public static function export_post_to_markdown( $post ) { return "# {$post->post_title}\n"; }
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
function wp_generate_uuid4() { static $number = 0; ++$number; return sprintf( '00000000-0000-4000-8000-%012d', $number ); }
function current_time( $format, $gmt = false ) { return '2026-07-17 12:00:00'; }
function rest_url( $path ) { return 'https://example.test/wp-json/' . $path; }
function wp_count_posts() { return (object) array( 'publish' => 2 ); }
function get_posts() { return array( (object) array( 'ID' => 2, 'post_name' => 'zulu', 'post_title' => 'Zulu' ), (object) array( 'ID' => 1, 'post_name' => 'alpha', 'post_title' => 'Alpha' ) ); }
function esc_url_raw( $url ) { return filter_var( $url, FILTER_VALIDATE_URL ) ? $url : ''; }
function wp_parse_url( $url ) { return parse_url( $url ); }
function sanitize_text_field( $value ) { return trim( strip_tags( (string) $value ) ); }
function maybe_serialize( $value ) { return is_array( $value ) ? serialize( $value ) : $value; }
function wp_cache_delete() {}
function wp_json_encode( $value ) { return json_encode( $value ); }
function get_option( $name, $default = false ) { global $wpdocs_options; return array_key_exists( $name, $wpdocs_options ) ? $wpdocs_options[ $name ] : $default; }
function update_option( $name, $value ) { global $wpdocs_options; $wpdocs_options[ $name ] = $value; return true; }
function wp_list_pluck( $items, $field ) { return array_map( static function ( $item ) use ( $field ) { return $item->$field; }, $items ); }
function sanitize_title( $value ) { return trim( preg_replace( '/[^a-z0-9]+/', '-', strtolower( $value ) ), '-' ); }
function get_the_terms( $post_id, $taxonomy ) { $slugs = 'wpdocs_collection' === $taxonomy ? array( 'reference', 'guides' ) : array( 'wordpress', 'blocks' ); return array_map( static function ( $slug ) { return (object) array( 'slug' => $slug ); }, $slugs ); }
function get_terms( $args ) { $known = array( 'wpdocs_collection' => array( 'guides', 'reference' ), 'wpdocs_topic' => array( 'blocks', 'wordpress' ) ); return array_values( array_intersect( $known[ $args['taxonomy'] ], $args['slug'] ) ); }
function wp_set_object_terms( $post_id, $terms, $taxonomy, $append ) { global $wpdocs_term_failure, $wpdocs_term_assignments; if ( $wpdocs_term_failure ) return new WPDocs_Test_Error( 'term assignment failed' ); $wpdocs_term_assignments[] = array( $post_id, $taxonomy, $terms ); return array(); }
function wp_remote_request( $url, $args ) { global $wpdocs_calls, $wpdocs_remote; $wpdocs_calls[] = array( $url, $args ); return array_shift( $wpdocs_remote ); }
function wp_remote_retrieve_response_code( $response ) { return $response['code']; }
function wp_remote_retrieve_body( $response ) { return $response['body']; }

require __DIR__ . '/../../plugins/wp-docs/wp-docs.php';
function check( $condition, $message ) { if ( ! $condition ) throw new RuntimeException( $message ); }
function throws( $callback, $message ) { try { $callback(); } catch ( InvalidArgumentException $error ) { return; } throw new RuntimeException( $message ); }
function response( $data, $code = 200 ) { return array( 'code' => $code, 'body' => json_encode( array( 'data' => $data ) ) ); }
function tar_entries( $archive ) { $tar = gzdecode( $archive ); $entries = array(); for ( $offset = 0; substr( $tar, $offset, 1024 ) !== str_repeat( "\0", 1024 ); ) { $header = substr( $tar, $offset, 512 ); $name = rtrim( substr( $header, 0, 100 ), "\0" ); $size = octdec( trim( substr( $header, 124, 12 ), "\0 " ) ); $stored = octdec( trim( substr( $header, 148, 8 ), "\0 " ) ); $checksum_header = substr_replace( $header, str_repeat( ' ', 8 ), 148, 8 ); check( $stored === array_sum( unpack( 'C*', $checksum_header ) ), 'tar checksum invalid' ); $entries[] = array( 'name' => $name, 'mode' => octdec( trim( substr( $header, 100, 8 ), "\0 " ) ), 'mtime' => octdec( trim( substr( $header, 136, 12 ), "\0 " ) ), 'body' => substr( $tar, $offset + 512, $size ) ); $offset += 512 + (int) ( ceil( $size / 512 ) * 512 ); } check( substr( $tar, -1024 ) === str_repeat( "\0", 1024 ), 'tar end blocks missing' ); return $entries; }

WPDocs_Plugin::register();
WPDocs_Plugin::register_settings();
WPDocs_Plugin::register_ability_category();
WPDocs_Plugin::register_abilities();
$post_type = $wpdocs_registered_post_types['wpdocs_document'];
check( $post_type['hierarchical'] && $post_type['show_ui'] && $post_type['show_in_rest'], 'document editor registration incomplete' );
check( ! $post_type['public'] && ! $post_type['publicly_queryable'] && ! $post_type['rewrite'] && ! $post_type['has_archive'] && ! $post_type['query_var'] && $post_type['exclude_from_search'] && ! $post_type['show_in_sitemap'], 'document frontend isolation changed' );
check( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['hierarchical'] && ! $wpdocs_registered_taxonomies['wpdocs_topic'][1]['hierarchical'], 'taxonomy hierarchy changed' );
check( 'wpdocs_document' === $wpdocs_adapter[0] && $wpdocs_adapter[1]['hierarchical'], 'Push MD adapter changed' );
check( array( 'collections', 'topics' ) === $wpdocs_adapter[1]['frontmatter_fields'], 'metadata fields changed' );
check( $wpdocs_registered_settings['wpdocs_base_url'][1]['show_in_rest'] && isset( $wpdocs_hooks['rest_api_init'] ), 'settings registration changed' );
check( 7 === count( $wpdocs_abilities ), 'publication abilities missing' );
$wpdocs_can_manage = false;
check( ! $wpdocs_abilities['wpdocs/request-publication']['permission_callback']() && ! $wpdocs_abilities['wpdocs/get-publication-status']['permission_callback'](), 'publication permissions weakened' );
$wpdocs_can_manage = true;
$metadata = call_user_func( $wpdocs_adapter[1]['export_metadata'], (object) array( 'ID' => 7 ) );
check( array( 'guides', 'reference' ) === $metadata['collections'] && array( 'blocks', 'wordpress' ) === $metadata['topics'], 'taxonomy export is not deterministic' );
call_user_func( $wpdocs_adapter[1]['validate_metadata'], $metadata );
throws( static function() use ( $wpdocs_adapter ) { call_user_func( $wpdocs_adapter[1]['validate_metadata'], array( 'topics' => array( 'missing-topic' ) ) ); }, 'missing taxonomy accepted' );
call_user_func( $wpdocs_adapter[1]['apply_metadata'], 7, $metadata );
check( 2 === count( $wpdocs_term_assignments ), 'taxonomy assignment changed' );
$wpdocs_term_failure = true;
try { call_user_func( $wpdocs_adapter[1]['apply_metadata'], 7, $metadata ); throw new RuntimeException( 'term failure hidden' ); } catch ( RuntimeException $error ) { check( 'term assignment failed' === $error->getMessage(), 'term failure changed' ); }
$child = (object) array( 'post_name' => 'page' );
check( 'https://docs.example.com/root/page/' === WPDocs_URLs::document_url( $child, 'https://DOCS.example.com/', array( (object) array( 'post_name' => 'root' ) ) ), 'static URL changed' );

$archive = WPDocs_Publication::archive();
check( $archive === WPDocs_Publication::archive(), 'archive bytes are not deterministic' );
$entries = tar_entries( $archive );
check( array( 'blume.config.ts', 'package.json', 'wpdocs_document/guides/alpha.md', 'wpdocs_document/zulu.md' ) === array_column( $entries, 'name' ), 'tar order changed or Push MD path was changed' );
foreach ( $entries as $entry ) check( 0644 === $entry['mode'] && 0 === $entry['mtime'], 'tar metadata is not fixed' );
check( "# Alpha\n" === $entries[2]['body'] && "# Zulu\n" === $entries[3]['body'], 'exported markdown changed' );
foreach ( array( '../escape.md', '/absolute.md', 'folder\\escape.md', 'other_type/slug.md', 'wpdocs_document/../escape.md', 'wpdocs_document//empty.md', 'wpdocs_document/' . str_repeat( 'a', 90 ) . '.md' ) as $path ) { $wpdocs_paths[1] = $path; check( is_wp_error( WPDocs_Publication::archive() ), 'unsafe Push MD path accepted: ' . $path ); }
$wpdocs_paths = array();

$wpdocs_remote = array( response( array( 'build' => array( 'id' => 'build_1', 'status' => 'waiting_for_source' ), 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => 'https://upload.example.test/source', 'method' => 'POST', 'headers' => array( 'X-Signed' => 'yes', 'Authorization' => 'Bearer provider-token' ), 'contentType' => 'application/x-gzip', 'maxBytes' => 100000 ), array( 'path' => 'unused', 'url' => 'https://upload.example.test/unused', 'method' => 'PUT', 'headers' => array() ) ) ) ) ), array( 'code' => 204, 'body' => '' ), response( array( 'id' => 'build_1', 'status' => 'waiting_for_source' ) ) );
$request = WPDocs_Publication::request();
check( 'waiting_for_source' === $request['state'] && 'build_1' === $request['build_id'], 'request state not persisted' );
check( 'wpdocs-00000000-0000-4000-8000-000000000001' === $wpdocs_calls[0][1]['headers']['Idempotency-Key'], 'idempotency key changed' );
check( array( 'input' => array( 'kind' => 'archive' ), 'target' => array( 'channel' => 'live', 'preview' => false ), 'wait' => false ) === json_decode( $wpdocs_calls[0][1]['body'], true ), 'build create body does not match the Spacefast contract' );
check( 'POST' === $wpdocs_calls[1][1]['method'] && 'yes' === $wpdocs_calls[1][1]['headers']['X-Signed'] && 'application/x-gzip' === $wpdocs_calls[1][1]['headers']['Content-Type'] && 'Bearer provider-token' === $wpdocs_calls[1][1]['headers']['Authorization'] && 'Bearer very-secret-token' !== $wpdocs_calls[1][1]['headers']['Authorization'], 'external upload leaked the configured bearer token' );
check( ! in_array( 'https://upload.example.test/unused', array_column( $wpdocs_calls, 0 ), true ), 'a non-source upload target received the source archive' );
$wpdocs_remote = array( response( array( 'id' => 'build_1', 'status' => 'running' ) ) );
$running = WPDocs_Publication::reconcile( array( 'request_id' => $request['request_id'] ) );
check( 'running' === $running['state'], 'running state not mapped' );
check( ! isset( $wpdocs_calls[3][1]['headers']['Idempotency-Key'] ), 'GET request sent an idempotency key' );
$wpdb->conflict = true;
$wpdocs_remote = array( response( array( 'id' => 'build_1', 'status' => 'succeeded', 'producedVersionId' => 'ver_1' ) ), response( array( 'id' => 'ver_1', 'spaceId' => 'spc_123', 'buildId' => 'build_1' ) ), response( array( 'id' => 'spc_123', 'liveUrl' => 'https://docs.example.test' ) ) );
check( is_wp_error( WPDocs_Publication::reconcile( array( 'request_id' => $running['request_id'] ) ) ) && 'running' === WPDocs_Publication::status( array( 'request_id' => $running['request_id'] ) )['state'] && '' === get_option( 'wpdocs_base_url', '' ), 'stale success overwrote concurrent state or URL' );
$wpdb->conflict = false;
$wpdocs_remote = array( response( array( 'id' => 'build_1', 'status' => 'succeeded', 'producedVersionId' => 'ver_1' ) ), response( array( 'id' => 'ver_1', 'spaceId' => 'spc_123', 'buildId' => 'build_1' ) ), response( array( 'id' => 'spc_123', 'liveUrl' => 'https://docs.example.test' ) ) );
$success = WPDocs_Publication::reconcile( array( 'request_id' => $running['request_id'] ) );
check( 'succeeded' === $success['state'] && 'ver_1' === $success['version_id'] && 'https://docs.example.test' === get_option( 'wpdocs_base_url' ), 'verified success not persisted' );

foreach ( array( response( array( 'id' => 'build_1', 'status' => 'unknown' ) ), array( 'code' => 500, 'body' => 'Bearer very-secret-token' ), array( 'code' => 200, 'body' => '{bad' ) ) as $bad ) { $wpdocs_remote = array( $bad ); $result = WPDocs_Publication::reconcile( array( 'request_id' => $success['request_id'] ) ); check( is_wp_error( $result ) || ( isset( $result['failure'] ) && false === strpos( $result['failure'], 'very-secret-token' ) ), 'provider error leaked secret' ); }
$unknown = WPDocs_Spacefast_Response::build( array( 'build' => array( 'id' => 'build_2', 'status' => 'unknown' ) ) );
check( is_wp_error( $unknown ), 'unknown provider state accepted' );
$missing_success = WPDocs_Spacefast_Response::build( array( 'build' => array( 'id' => 'build_2', 'status' => 'succeeded' ) ) );
check( is_array( $missing_success ) && ! $missing_success['version_id'], 'incomplete success fixture changed' );
$bad_upload = WPDocs_Spacefast_Response::upload( array( 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => 'https://user:secret@upload.example.test', 'method' => 'PUT', 'headers' => array() ) ) ) ) );
check( is_wp_error( $bad_upload ), 'credentialed upload URL was accepted' );
$unsupported_upload = WPDocs_Spacefast_Response::upload( array( 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => 'https://upload.example.test/source', 'method' => 'PATCH', 'headers' => array() ) ) ) ) );
check( is_wp_error( $unsupported_upload ), 'unsupported upload method was accepted' );
$wpdocs_remote = array( response( array( 'build' => array( 'status' => 'waiting_for_source' ), 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => 'https://upload.example.test/source', 'method' => 'PUT', 'headers' => array() ) ) ) ) ) );
$missing_build = WPDocs_Publication::request();
check( 'failed' === $missing_build['state'] && empty( $missing_build['build_id'] ), 'missing build identifier was persisted or uploaded' );
check( is_wp_error( WPDocs_Publication::cancel( array( 'request_id' => $missing_build['request_id'] ) ) ), 'cancel accepted a missing build identifier' );
$wpdocs_options = array();
$wpdocs_calls = array();
$wpdocs_remote = array(
	response( array( 'build' => array( 'id' => 'build_2', 'status' => 'queued' ), 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => '/uploads/build_2', 'method' => 'PUT', 'headers' => array( 'X-Signed' => 'yes' ), 'maxBytes' => 100000 ) ) ) ) ),
	array( 'code' => 204, 'body' => '' ),
	response( array( 'id' => 'build_2', 'status' => 'running' ) ),
);
$immediate = WPDocs_Publication::request();
check( 'running' === $immediate['state'] && 'https://spacefast.example.test/uploads/build_2' === $wpdocs_calls[1][0] && 'Bearer very-secret-token' === $wpdocs_calls[1][1]['headers']['Authorization'], 'relative API upload did not preserve the immediate lifecycle and scoped bearer authorization' );
$wpdocs_remote = array( response( array( 'build' => array( 'id' => 'build_2', 'status' => 'running' ), 'upload' => array( 'targets' => array( array( 'path' => 'source', 'url' => '/uploads/build_2', 'method' => 'PUT', 'headers' => array(), 'maxBytes' => 100000 ) ) ) ) ), array( 'code' => 204, 'body' => '' ), response( array( 'id' => 'build_2', 'status' => 'running' ) ) );
check( 'running' === WPDocs_Publication::resume( array( 'request_id' => $immediate['request_id'] ) )['state'], 'resume did not accept the current upload envelope' );
$cancel_request               = $immediate;
$cancel_request['request_id'] = 'wpdocs-cancel-test';
$wpdocs_options['wpdocs_publication_requests'][] = $cancel_request;
$wpdocs_remote = array( response( array( 'id' => 'build_2', 'status' => 'canceled' ) ) );
check( 'canceled' === WPDocs_Publication::cancel( array( 'request_id' => $cancel_request['request_id'] ) )['state'], 'cancel did not parse the flat build response' );
$wpdocs_remote = array( response( array( 'id' => 'build_2', 'status' => 'succeeded', 'reusedVersionId' => 'ver_2' ) ), response( array( 'id' => 'ver_2', 'spaceId' => 'spc_123', 'buildId' => 'build_2' ) ), response( array( 'id' => 'spc_123', 'liveUrl' => 'http://docs.example.test' ) ) );
check( 'failed' === WPDocs_Publication::reconcile( array( 'request_id' => $immediate['request_id'] ) )['state'] && '' === get_option( 'wpdocs_base_url', '' ), 'non-HTTPS authoritative space URL was persisted' );
printf( "WP Docs hosted publication tests passed.\n" );
