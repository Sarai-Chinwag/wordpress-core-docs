# WP_REST_Posts_Controller

Core class to access posts via the REST API. The most comprehensive controller, serving as the basis for many other content-type controllers.

## Class Synopsis

```php
class WP_REST_Posts_Controller extends WP_REST_Controller {
    protected $post_type;
    protected $meta;
    protected $password_check_passed = array();
    protected $allow_batch = array( 'v1' => true );
    
    public function __construct( string $post_type );
    public function register_routes();
    
    // Permission Checks
    public function get_items_permissions_check( $request );
    public function get_item_permissions_check( $request );
    public function create_item_permissions_check( $request );
    public function update_item_permissions_check( $request );
    public function delete_item_permissions_check( $request );
    
    // CRUD Operations
    public function get_items( $request );
    public function get_item( $request );
    public function create_item( $request );
    public function update_item( $request );
    public function delete_item( $request );
    
    // Data Preparation
    protected function prepare_item_for_database( $request );
    public function prepare_item_for_response( $item, $request );
    protected function prepare_items_query( $prepared_args, $request );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    
    // Permission Helpers
    public function check_read_permission( $post );
    protected function check_update_permission( $post );
    protected function check_create_permission( $post );
    protected function check_delete_permission( $post );
    protected function check_assign_terms_permission( $request );
    
    // Content Handling
    public function can_access_password_content( $post, $request );
    public function check_password_required( $required, $post );
    protected function handle_status_param( $post_status, $post_type );
    protected function handle_featured_media( $featured_media, $post_id );
    protected function handle_terms( $post_id, $request );
    protected function handle_template( $template, $post_id, $validate = false );
    
    // Utilities
    protected function get_post( $id );
    protected function prepare_date_response( $date_gmt, $date = null );
    protected function prepare_links( $post );
    protected function get_available_actions( $post, $request );
    public function check_template( $template, $request );
    public function check_status( $status, $request, $param );
    public function sanitize_post_statuses( $statuses, $request, $parameter );
}
```

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/posts` | List posts |
| POST | `/wp/v2/posts` | Create a post |
| GET | `/wp/v2/posts/{id}` | Get a single post |
| POST/PUT/PATCH | `/wp/v2/posts/{id}` | Update a post |
| DELETE | `/wp/v2/posts/{id}` | Delete a post |

## Constructor

```php
public function __construct( string $post_type )
```

**Parameters:**
- `$post_type` - The post type slug

**Behavior:**
- Sets `$this->post_type` to the provided type
- Gets the post type object for rest_base and rest_namespace
- Creates `WP_REST_Post_Meta_Fields` instance for meta handling

## Collection Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `context` | string | 'view' | Scope under which request is made |
| `page` | integer | 1 | Current page |
| `per_page` | integer | 10 | Items per page (max 100) |
| `search` | string | - | Search string |
| `after` | date-time | - | Posts published after date |
| `before` | date-time | - | Posts published before date |
| `modified_after` | date-time | - | Posts modified after date |
| `modified_before` | date-time | - | Posts modified before date |
| `author` | array | [] | Limit to specific authors |
| `author_exclude` | array | [] | Exclude specific authors |
| `exclude` | array | [] | Exclude specific IDs |
| `include` | array | [] | Include specific IDs |
| `offset` | integer | - | Offset for pagination |
| `order` | string | 'desc' | Sort order (asc/desc) |
| `orderby` | string | 'date' | Sort field |
| `search_columns` | array | [] | Columns to search |
| `slug` | array | - | Filter by slugs |
| `status` | array | 'publish' | Filter by status |
| `sticky` | boolean | - | Filter sticky posts (post type only) |
| `categories` | array | - | Filter by categories |
| `categories_exclude` | array | - | Exclude categories |
| `tags` | array | - | Filter by tags |
| `tags_exclude` | array | - | Exclude tags |

### Orderby Options

- `author` - Author ID
- `date` - Publish date
- `id` - Post ID
- `include` - Order by include parameter
- `modified` - Modified date
- `parent` - Parent ID
- `relevance` - Search relevance (requires search)
- `slug` - Post slug
- `include_slugs` - Order by slug include
- `title` - Post title
- `menu_order` - Menu order (pages/page-attributes)

## Schema Properties

The schema varies based on post type support. Core properties:

| Property | Type | Context | Description |
|----------|------|---------|-------------|
| `id` | integer | view, edit, embed | Post ID (readonly) |
| `date` | string/null | view, edit, embed | Publish date (site timezone) |
| `date_gmt` | string/null | view, edit | Publish date (GMT) |
| `guid` | object | view, edit | Global unique identifier (readonly) |
| `link` | string | view, edit, embed | Post URL (readonly) |
| `modified` | string | view, edit | Modified date (readonly) |
| `modified_gmt` | string | view, edit | Modified date GMT (readonly) |
| `slug` | string | view, edit, embed | Post slug |
| `status` | string | view, edit | Post status |
| `type` | string | view, edit, embed | Post type (readonly) |
| `password` | string | edit | Post password |

### Conditional Properties (based on post_type_supports)

| Property | Support | Type | Description |
|----------|---------|------|-------------|
| `title` | 'title' | object | Post title (raw/rendered) |
| `content` | 'editor' | object | Post content (raw/rendered/protected/block_version) |
| `author` | 'author' | integer | Author user ID |
| `excerpt` | 'excerpt' | object | Post excerpt (raw/rendered/protected) |
| `featured_media` | 'thumbnail' | integer | Featured image ID |
| `comment_status` | 'comments' | string | Comments open/closed |
| `ping_status` | 'comments' | string | Pingbacks open/closed |
| `menu_order` | 'page-attributes' | integer | Menu order |
| `format` | 'post-formats' | string | Post format |
| `meta` | 'custom-fields' | object | Post meta |
| `sticky` | (post type only) | boolean | Is sticky |
| `template` | - | string | Page template |
| `parent` | (hierarchical) | integer | Parent post ID |
| `categories` | (taxonomy) | array | Category term IDs |
| `tags` | (taxonomy) | array | Tag term IDs |

## Permission Checks

### get_items_permissions_check()
- Returns `true` for public requests
- Requires `edit_posts` capability for `edit` context

### get_item_permissions_check()
- Verifies post exists and matches controller's post type
- Checks password if provided
- Requires `edit_post` capability for `edit` context
- Calls `check_read_permission()` for view context

### create_item_permissions_check()
- Requires `create_posts` capability
- Checks `edit_others_posts` for setting different author
- Checks `edit_others_posts` or `publish_posts` for sticky
- Validates term assignment permissions

### update_item_permissions_check()
- Requires `edit_post` capability
- Additional checks for author, sticky, and terms

### delete_item_permissions_check()
- Requires `delete_post` capability

## Key Methods

### get_post()
```php
protected function get_post( int $id ): WP_Post|WP_Error
```
Gets the post if ID is valid and matches the controller's post type.

### check_read_permission()
```php
public function check_read_permission( WP_Post $post ): bool
```
Checks if a post can be read. Handles:
- Published posts (always readable)
- Private posts (requires `read_post` capability)
- Inherited status (checks parent)
- Public post statuses

### prepare_item_for_database()
Maps request parameters to post object properties:
- `title` → `post_title`
- `content` → `post_content`
- `excerpt` → `post_excerpt`
- `status` → `post_status`
- `date`/`date_gmt` → `post_date`/`post_date_gmt`
- `slug` → `post_name`
- `author` → `post_author`
- `password` → `post_password`
- `parent` → `post_parent`
- `menu_order` → `menu_order`
- `comment_status` → `comment_status`
- `ping_status` → `ping_status`

### prepare_item_for_response()
Prepares full post response including:
- All schema fields based on context
- Taxonomy terms
- Meta fields
- Links (self, collection, author, replies, revisions, etc.)

### handle_terms()
```php
protected function handle_terms( int $post_id, WP_REST_Request $request ): null|WP_Error
```
Updates post terms from request data using `wp_set_object_terms()`.

### handle_featured_media()
```php
protected function handle_featured_media( int $featured_media, int $post_id ): bool|WP_Error
```
Sets or removes the post thumbnail.

### handle_template()
```php
public function handle_template( string $template, int $post_id, bool $validate = false )
```
Sets the page template via `_wp_page_template` meta.

## Response Links

The controller adds HAL-style links:

| Relation | Description |
|----------|-------------|
| `self` | Link to this post |
| `collection` | Link to posts collection |
| `about` | Link to post type |
| `author` | Link to author (embeddable) |
| `replies` | Link to comments (embeddable) |
| `version-history` | Link to revisions |
| `predecessor-version` | Link to latest revision |
| `up` | Link to parent (hierarchical) |
| `wp:featuredmedia` | Link to featured image (embeddable) |
| `wp:attachment` | Link to attachments |
| `wp:term` | Links to taxonomy terms (embeddable) |

## Action Links

Edit context includes action links indicating user capabilities:

| Action | Description |
|--------|-------------|
| `wp:action-publish` | Can publish posts |
| `wp:action-unfiltered-html` | Can use unfiltered HTML |
| `wp:action-sticky` | Can make posts sticky |
| `wp:action-assign-author` | Can change author |
| `wp:action-create-{taxonomy}` | Can create terms |
| `wp:action-assign-{taxonomy}` | Can assign terms |

## Usage Example

```php
// Get posts with specific parameters
$request = new WP_REST_Request( 'GET', '/wp/v2/posts' );
$request->set_param( 'per_page', 5 );
$request->set_param( 'categories', array( 1, 2 ) );
$request->set_param( 'orderby', 'title' );
$request->set_param( 'order', 'asc' );

$controller = new WP_REST_Posts_Controller( 'post' );
$response = $controller->get_items( $request );

// Create a post
$request = new WP_REST_Request( 'POST', '/wp/v2/posts' );
$request->set_param( 'title', 'My New Post' );
$request->set_param( 'content', 'Post content here.' );
$request->set_param( 'status', 'publish' );
$request->set_param( 'categories', array( 1 ) );

$response = $controller->create_item( $request );
```

## Extending for Custom Post Types

```php
// Register custom post type with REST support
register_post_type( 'book', array(
    'public'       => true,
    'show_in_rest' => true,
    'rest_base'    => 'books',
    'supports'     => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
));

// Endpoint automatically available at /wp/v2/books
```

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-posts-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 5.0.0 | Added `rest_after_insert_{$post_type}` action |
| 5.4.0 | Added `tax_relation` parameter |
| 5.6.0 | Added `check_status()` method |
| 5.7.0 | Added `modified_after` and `modified_before` parameters |
| 5.7.1 | Added password check bypass for REST requests |
| 5.9.0 | Added batching support |
