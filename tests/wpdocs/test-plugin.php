<?php
define( 'ABSPATH', __DIR__ . '/' );
$wpdocs_registered_post_types = array();
$wpdocs_registered_taxonomies = array();
$wpdocs_hooks = array();
$wpdocs_apply_failure = '';
class WPDocs_Test_Error { private $message; public function __construct( $message ) { $this->message = $message; } public function get_error_message() { return $this->message; } }
function register_post_type( $name, $args ) { global $wpdocs_registered_post_types; $wpdocs_registered_post_types[ $name ] = $args; }
function register_taxonomy( $name, $types, $args ) { global $wpdocs_registered_taxonomies; $wpdocs_registered_taxonomies[ $name ] = array( $types, $args ); }
function add_action( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function add_filter( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function get_posts( $args ) { return array(); }
function get_post_meta( $id, $key, $single ) { return ''; }
function wp_insert_post( $post, $error = false ) { return 101; }
function update_post_meta( $id, $key, $value ) {}
function wp_set_object_terms( $id, $terms, $taxonomy, $append ) { global $wpdocs_apply_failure; return 'terms' === $wpdocs_apply_failure ? new WPDocs_Test_Error( 'term assignment failed' ) : array(); }
function wp_update_post( $post, $error = false ) { global $wpdocs_apply_failure; return 'parent' === $wpdocs_apply_failure ? new WPDocs_Test_Error( 'parent update failed' ) : $post['ID']; }
function is_wp_error( $value ) { return $value instanceof WPDocs_Test_Error; }
require __DIR__ . '/../../plugins/wp-docs/wp-docs.php';

function wpdocs_assert( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }
function wpdocs_throws( $callback, $message ) { try { $callback(); } catch ( InvalidArgumentException $error ) { return; } throw new RuntimeException( $message ); }
function wpdocs_record( $identity, $content, $path = '/guide/' ) { return array( 'identity' => $identity, 'slug' => trim( $path, '/' ), 'parent_identity' => '', 'parent_path' => '', 'menu_order' => 2, 'status' => 'publish', 'title' => 'Guide', 'excerpt' => 'Summary', 'terms' => array( 'collections' => array( 'start', 'api' ), 'topics' => array( 'rest', 'blocks' ) ), 'canonical_path' => $path, 'content' => $content ); }

WPDocs_Plugin::register();
$post_type = $wpdocs_registered_post_types['wpdocs_document'];
wpdocs_assert( $post_type['hierarchical'] && $post_type['show_ui'] && $post_type['show_in_rest'], 'document editor registration is incomplete' );
wpdocs_assert( ! $post_type['public'] && ! $post_type['publicly_queryable'] && ! $post_type['rewrite'] && ! $post_type['has_archive'] && ! $post_type['query_var'] && $post_type['exclude_from_search'] && ! $post_type['show_in_sitemap'], 'document must remain absent from WordPress frontend' );
wpdocs_assert( in_array( 'revisions', $post_type['supports'], true ) && in_array( 'page-attributes', $post_type['supports'], true ) && in_array( 'custom-fields', $post_type['supports'], true ), 'document supports are incomplete' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['hierarchical'] && ! $wpdocs_registered_taxonomies['wpdocs_topic'][1]['hierarchical'], 'taxonomy hierarchy is wrong' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['show_in_rest'] && $wpdocs_registered_taxonomies['wpdocs_topic'][1]['sort'], 'taxonomy REST or ordering support is missing' );

$root = (object) array( 'post_name' => 'root' );
$parent = (object) array( 'post_name' => 'section' );
$child = (object) array( 'post_name' => 'page' );
wpdocs_assert( WPDocs_URLs::document_url( $child, 'https://DOCS.example.com/', array( $root, $parent ) ) === 'https://docs.example.com/root/section/page/', 'root-to-parent canonical URL is unstable' );
wpdocs_assert( WPDocs_URLs::document_url( $child, 'https://docs.example.com', array( $root, $parent ), true ) === 'https://docs.example.com/root/section/page/?wpdocs-preview=1', 'root-to-parent preview URL is wrong' );

$record = wpdocs_record( 'wp:post:7', "# Hello\n" );
$encoded = WPDocs_Codec::encode( $record );
$decoded = WPDocs_Codec::decode( $encoded );
wpdocs_assert( $decoded['content'] === '# Hello', 'Markdown round trip changed content' );
wpdocs_assert( $decoded['terms']['collections'] === array( 'api', 'start' ) && $decoded['terms']['topics'] === array( 'blocks', 'rest' ), 'term serialization is not sorted' );
$record_file = tempnam( sys_get_temp_dir(), 'wpdocs-record-' );
$plan_file = tempnam( sys_get_temp_dir(), 'wpdocs-plan-' );
file_put_contents( $record_file, $encoded );
file_put_contents( $plan_file, '{"plan_hash":"abc"}' );
wpdocs_assert( WPDocs_Plugin::decode_record_files( array( $record_file ) )[0]['identity'] === 'wp:post:7', 'CLI record file was not decoded' );
wpdocs_assert( WPDocs_Plugin::read_plan_file( $plan_file )['plan_hash'] === 'abc', 'CLI plan file was not decoded' );
wpdocs_throws( static function () { WPDocs_Plugin::decode_record_files( array( '/not/a/wpdocs-record.md' ) ); }, 'missing CLI record file was accepted' );
file_put_contents( $plan_file, 'not json' );
wpdocs_throws( static function () use ( $plan_file ) { WPDocs_Plugin::read_plan_file( $plan_file ); }, 'invalid CLI plan file was accepted' );
unlink( $record_file );
unlink( $plan_file );

$second = wpdocs_record( 'wp:post:8', 'Second', '/second/' );
$export_a = WPDocs_Sync::export_artifact( array( $second, $record ), 'https://docs.example.com/' );
$export_b = WPDocs_Sync::export_artifact( array( $record, $second ), 'https://docs.example.com' );
wpdocs_assert( $export_a === $export_b, 'export or publication manifest depends on input order' );
wpdocs_assert( str_contains( $export_a['files']['guide.md'], '"base_content_hash"' ), 'export must carry a three-way base hash' );
$shuffled_terms = array(
	array( 'taxonomy' => 'wpdocs_topic', 'slug' => 'rest', 'name' => 'REST', 'description' => '', 'parent_slug' => '' ),
	array( 'taxonomy' => 'wpdocs_collection', 'slug' => 'start', 'name' => 'Start', 'description' => 'Intro', 'parent_slug' => '' ),
);
$export_terms_a = WPDocs_Sync::export_artifact( array( $record ), 'https://docs.example.com', $shuffled_terms );
$export_terms_b = WPDocs_Sync::export_artifact( array( $record ), 'https://docs.example.com', array_reverse( $shuffled_terms ) );
wpdocs_assert( $export_terms_a === $export_terms_b && $export_terms_a['manifest']['terms'][0]['taxonomy'] === 'wpdocs_collection', 'taxonomy manifest is not deterministic' );
wpdocs_throws( static function () use ( $record ) { $empty = $record; $empty['identity'] = ''; WPDocs_Sync::export_artifact( array( $empty ), 'https://docs.example.com' ); }, 'empty artifact identity was accepted' );
wpdocs_throws( static function () use ( $record ) { WPDocs_Sync::export_artifact( array( $record, $record ), 'https://docs.example.com' ); }, 'duplicate artifact identity was accepted' );
wpdocs_throws( static function () use ( $record ) { $other = $record; $other['identity'] = 'wp:post:9'; WPDocs_Sync::export_artifact( array( $record, $other ), 'https://docs.example.com' ); }, 'duplicate artifact output path was accepted' );
wpdocs_throws( static function () use ( $record ) { $unsafe = $record; $unsafe['canonical_path'] = '/../'; WPDocs_Sync::export_artifact( array( $unsafe ), 'https://docs.example.com' ); }, 'unsafe artifact path was accepted' );

$current = WPDocs_Codec::normalize_record( $record );
$same = WPDocs_Sync::preview_import( array( $current ), array( $current ) );
wpdocs_assert( $same['changes'][0]['action'] === 'noop', 'same content must be noop' );
$changed = wpdocs_record( 'wp:post:7', 'Changed' );
$changed['base_content_hash'] = $current['content_hash'];
$update = WPDocs_Sync::preview_import( array( $changed ), array( $current ) );
wpdocs_assert( $update['changes'][0]['action'] === 'update', 'matching base hash must update' );
$other_current = WPDocs_Codec::normalize_record( wpdocs_record( 'wp:post:7', 'Server changed' ) );
$conflict = WPDocs_Sync::preview_import( array( $changed ), array( $other_current ) );
wpdocs_assert( $conflict['changes'][0]['action'] === 'conflict', 'diverged base hash must conflict' );
wpdocs_assert( WPDocs_Sync::preview_import( array( wpdocs_record( 'external:9', 'New' ) ), array() )['changes'][0]['action'] === 'create', 'missing document must create' );
wpdocs_throws( static function () use ( $record ) { WPDocs_Sync::preview_import( array( $record, $record ), array() ); }, 'duplicate incoming identity was accepted' );
wpdocs_throws( static function () use ( $record ) { $orphan = $record; $orphan['parent_identity'] = 'missing'; $orphan['canonical_path'] = '/missing/guide/'; WPDocs_Sync::preview_import( array( $orphan ), array() ); }, 'unknown parent was accepted' );
wpdocs_throws( static function () use ( $record ) { $self = $record; $self['parent_identity'] = $self['identity']; $self['canonical_path'] = '/guide/guide/'; WPDocs_Sync::preview_import( array( $self ), array() ); }, 'self parent was accepted' );
wpdocs_throws( static function () use ( $record ) { $one = $record; $one['identity'] = 'one'; $one['slug'] = 'one'; $one['parent_identity'] = 'two'; $one['canonical_path'] = '/two/one/'; $two = $record; $two['identity'] = 'two'; $two['slug'] = 'two'; $two['parent_identity'] = 'one'; $two['canonical_path'] = '/one/two/'; WPDocs_Sync::preview_import( array( $one, $two ), array() ); }, 'parent cycle was accepted' );
wpdocs_throws( static function () use ( $record ) { $bad_path = $record; $bad_path['canonical_path'] = '/wrong/'; WPDocs_Sync::preview_import( array( $bad_path ), array() ); }, 'hierarchy-mismatched canonical path was accepted' );
$parent_record = wpdocs_record( 'parent', 'Parent', '/parent/' );
$child_record = wpdocs_record( 'child', 'Child', '/parent/child/' );
$child_record['slug'] = 'child';
$child_record['parent_identity'] = 'parent';
wpdocs_assert( WPDocs_Sync::preview_import( array( $child_record ), array( $parent_record ) )['changes'][0]['action'] === 'create', 'resolved existing parent was rejected' );
$apply_change = array( 'action' => 'create', 'record' => $record );
$wpdocs_apply_failure = 'terms';
try { WPDocs_Plugin::apply_changes( array( $apply_change ) ); throw new RuntimeException( 'term assignment failure was hidden' ); } catch ( RuntimeException $error ) { wpdocs_assert( $error->getMessage() === 'term assignment failed', 'wrong term assignment failure' ); }
$wpdocs_apply_failure = 'parent';
try { WPDocs_Plugin::apply_changes( array( $apply_change ) ); throw new RuntimeException( 'parent update failure was hidden' ); } catch ( RuntimeException $error ) { wpdocs_assert( $error->getMessage() === 'parent update failed', 'wrong parent update failure' ); }
$wpdocs_apply_failure = '';
try { WPDocs_Sync::validate_apply( $update, array( $changed ), array( $other_current ) ); throw new RuntimeException( 'stale plan was accepted' ); } catch ( RuntimeException $error ) { wpdocs_assert( $error->getMessage() === 'WPDocs import plan is stale; preview again before applying.', 'wrong stale-plan rejection' ); }

printf( "WP Docs behavioral tests passed.\n" );
