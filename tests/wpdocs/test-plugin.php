<?php
define( 'ABSPATH', __DIR__ . '/' );

$wpdocs_registered_post_types = array();
$wpdocs_registered_taxonomies = array();
$wpdocs_adapter               = null;
$wpdocs_hooks                 = array();
$wpdocs_term_failure          = false;
$wpdocs_term_assignments      = array();

class WPDocs_Test_Error {
	private $message;
	public function __construct( $message ) { $this->message = $message; }
	public function get_error_message() { return $this->message; }
}

function register_post_type( $name, $args ) { global $wpdocs_registered_post_types; $wpdocs_registered_post_types[ $name ] = $args; }
function register_taxonomy( $name, $types, $args ) { global $wpdocs_registered_taxonomies; $wpdocs_registered_taxonomies[ $name ] = array( $types, $args ); }
function push_md_register_content_adapter( $post_type, $args ) { global $wpdocs_adapter; $wpdocs_adapter = array( $post_type, $args ); }
function add_action( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function add_filter( $name, $callback ) { global $wpdocs_hooks; $wpdocs_hooks[ $name ][] = $callback; }
function is_wp_error( $value ) { return $value instanceof WPDocs_Test_Error; }
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
$post_type = $wpdocs_registered_post_types['wpdocs_document'];
wpdocs_assert( $post_type['hierarchical'] && $post_type['show_ui'] && $post_type['show_in_rest'], 'document editor registration is incomplete' );
wpdocs_assert( ! $post_type['public'] && ! $post_type['publicly_queryable'] && ! $post_type['rewrite'] && ! $post_type['has_archive'] && ! $post_type['query_var'] && $post_type['exclude_from_search'] && ! $post_type['show_in_sitemap'], 'document must remain absent from WordPress frontend' );
wpdocs_assert( in_array( 'revisions', $post_type['supports'], true ) && in_array( 'page-attributes', $post_type['supports'], true ), 'document supports are incomplete' );
wpdocs_assert( $wpdocs_registered_taxonomies['wpdocs_collection'][1]['hierarchical'] && ! $wpdocs_registered_taxonomies['wpdocs_topic'][1]['hierarchical'], 'taxonomy hierarchy is wrong' );

wpdocs_assert( 'wpdocs_document' === $wpdocs_adapter[0], 'Push MD adapter post type is wrong' );
$adapter = $wpdocs_adapter[1];
wpdocs_assert( $adapter['hierarchical'], 'Push MD adapter must preserve document hierarchy' );
wpdocs_assert( array( 'collections', 'topics' ) === $adapter['frontmatter_fields'], 'Push MD adapter metadata fields are wrong' );

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
