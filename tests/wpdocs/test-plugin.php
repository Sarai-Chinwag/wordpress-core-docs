<?php
define( 'ABSPATH', __DIR__ . '/' );
$wpdocs_registered_post_types = array();
$wpdocs_registered_taxonomies = array();
$wpdocs_hooks = array();
function register_post_type( $name, $args ) { global $wpdocs_registered_post_types; $wpdocs_registered_post_types[ $name ] = $args; }
function register_taxonomy( $name, $types, $args ) { global $wpdocs_registered_taxonomies; $wpdocs_registered_taxonomies[ $name ] = array( $types, $args ); }
function add_action( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function add_filter( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
require __DIR__ . '/../../plugins/wp-docs/wp-docs.php';

function wpdocs_assert( $condition, $message ) { if ( ! $condition ) { throw new RuntimeException( $message ); } }
function wpdocs_record( $identity, $content, $path = '/guide/' ) { return array( 'identity' => $identity, 'slug' => trim( $path, '/' ), 'parent_identity' => '', 'parent_path' => '', 'menu_order' => 2, 'status' => 'publish', 'title' => 'Guide', 'excerpt' => 'Summary', 'terms' => array( 'collections' => array( 'start', 'api' ), 'topics' => array( 'rest', 'blocks' ) ), 'canonical_path' => $path, 'content' => $content ); }

WPDocs_Plugin::register();
$post_type = $wpdocs_registered_post_types['wpdocs_document'];
wpdocs_assert( $post_type['hierarchical'] && $post_type['show_ui'] && $post_type['show_in_rest'], 'document editor registration is incomplete' );
wpdocs_assert( ! $post_type['public'] && ! $post_type['publicly_queryable'] && ! $post_type['rewrite'] && ! $post_type['has_archive'] && ! $post_type['query_var'] && $post_type['exclude_from_search'] && ! $post_type['show_in_sitemap'], 'document must remain absent from WordPress frontend' );
wpdocs_assert( in_array( 'revisions', $post_type['supports'], true ) && in_array( 'page-attributes', $post_type['supports'], true ) && in_array( 'custom-fields', $post_type['supports'], true ), 'document supports are incomplete' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['hierarchical'] && ! $wpdocs_registered_taxonomies['wpdocs_topic'][1]['hierarchical'], 'taxonomy hierarchy is wrong' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['show_in_rest'] && $wpdocs_registered_taxonomies['wpdocs_topic'][1]['sort'], 'taxonomy REST or ordering support is missing' );

$parent = (object) array( 'post_name' => 'getting-started' );
$child = (object) array( 'post_name' => 'install' );
wpdocs_assert( WPDocs_URLs::document_url( $child, 'https://DOCS.example.com/', array( $parent ) ) === 'https://docs.example.com/getting-started/install/', 'hierarchy canonical URL is unstable' );
wpdocs_assert( WPDocs_URLs::document_url( $child, 'https://docs.example.com', array( $parent ), true ) === 'https://docs.example.com/getting-started/install/?wpdocs-preview=1', 'preview URL is wrong' );

$record = wpdocs_record( 'wp:post:7', "# Hello\n" );
$encoded = WPDocs_Codec::encode( $record );
$decoded = WPDocs_Codec::decode( $encoded );
wpdocs_assert( $decoded['content'] === '# Hello', 'Markdown round trip changed content' );
wpdocs_assert( $decoded['terms']['collections'] === array( 'api', 'start' ) && $decoded['terms']['topics'] === array( 'blocks', 'rest' ), 'term serialization is not sorted' );

$second = wpdocs_record( 'wp:post:8', 'Second', '/second/' );
$export_a = WPDocs_Sync::export_artifact( array( $second, $record ), 'https://docs.example.com/' );
$export_b = WPDocs_Sync::export_artifact( array( $record, $second ), 'https://docs.example.com' );
wpdocs_assert( $export_a === $export_b, 'export or publication manifest depends on input order' );
wpdocs_assert( str_contains( $export_a['files']['guide.md'], '"base_content_hash"' ), 'export must carry a three-way base hash' );

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
try { WPDocs_Sync::validate_apply( $update, array( $changed ), array( $other_current ) ); throw new RuntimeException( 'stale plan was accepted' ); } catch ( RuntimeException $error ) { wpdocs_assert( $error->getMessage() === 'WPDocs import plan is stale; preview again before applying.', 'wrong stale-plan rejection' ); }

printf( "WP Docs behavioral tests passed.\n" );
