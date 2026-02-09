# WP_REST_Revisions_Controller

Core class used to access revisions via the REST API. Provides read-only access to post revisions plus deletion capability.

## Class Synopsis

```php
class WP_REST_Revisions_Controller extends WP_REST_Controller {
    private $parent_post_type;
    private $parent_controller;
    private $parent_base;
    protected $meta;
    
    public function __construct( string $parent_post_type );
    public function register_routes();
    
    // Permission Checks
    public function get_items_permissions_check( $request );
    public function get_item_permissions_check( $request );
    public function delete_item_permissions_check( $request );
    
    // Operations
    public function get_items( $request );
    public function get_item( $request );
    public function delete_item( $request );
    
    // Data Preparation
    protected function prepare_items_query( $prepared_args, $request );
    public function prepare_item_for_response( $item, $request );
    protected function prepare_links( $revision );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    
    // Utilities
    protected function get_parent( $parent_post_id );
    protected function get_revision( $id );
    protected function check_read_permission( $post );
}
```

## Endpoints

Revisions are nested under their parent post type:

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/posts/{parent}/revisions` | List revisions for a post |
| GET | `/wp/v2/posts/{parent}/revisions/{id}` | Get a single revision |
| DELETE | `/wp/v2/posts/{parent}/revisions/{id}` | Delete a revision |
| GET | `/wp/v2/pages/{parent}/revisions` | List revisions for a page |

## Constructor

```php
public function __construct( string $parent_post_type )
```

**Parameters:**
- `$parent_post_type` - Post type of the parent (e.g., `'post'`, `'page'`)

**Behavior:**
- Gets or creates the parent post type's controller
- Sets `rest_base` to `'revisions'`
- Sets `parent_base` from parent post type's `rest_base`
- Creates `WP_REST_Post_Meta_Fields` instance for the parent post type

## Collection Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `context` | string | 'view' | Scope under which request is made |
| `page` | integer | 1 | Current page |
| `per_page` | integer | 10 | Items per page (max 100, or -1 for all) |
| `search` | string | - | Search string |
| `exclude` | array | [] | Exclude specific IDs |
| `include` | array | [] | Include specific IDs |
| `offset` | integer | - | Offset for pagination |
| `order` | string | 'desc' | Sort order (asc/desc) |
| `orderby` | string | 'date' | Sort field |

### Orderby Options

- `date` - Revision date (includes ID for stable sorting)
- `id` - Revision ID
- `include` - Order by include parameter
- `relevance` - Search relevance (requires search)
- `slug` - Revision slug

## Schema Properties

| Property | Type | Context | Description |
|----------|------|---------|-------------|
| `author` | integer | view, edit, embed | Revision author ID |
| `date` | string | view, edit, embed | Revision date (site timezone) |
| `date_gmt` | string | view, edit | Revision date (GMT) |
| `guid` | object | view, edit | Global unique identifier |
| `id` | integer | view, edit, embed | Revision ID (readonly) |
| `modified` | string | view, edit | Modified date (site timezone) |
| `modified_gmt` | string | view, edit | Modified date (GMT) |
| `parent` | integer | view, edit, embed | Parent post ID |
| `slug` | string | view, edit, embed | Revision slug |
| `title` | object | view, edit, embed | Title (raw/rendered) |
| `content` | object | view, edit | Content (raw/rendered) |
| `excerpt` | object | view, edit, embed | Excerpt (raw/rendered) |
| `meta` | object | view, edit | Revision meta (since 6.4.0) |

## Permission Checks

### get_items_permissions_check()
- Validates parent post exists and matches post type
- Requires `edit_post` capability for parent post

### get_item_permissions_check()
- Validates parent post and revision exist
- Revision must belong to parent post
- Requires `edit_post` capability for parent post

### delete_item_permissions_check()
- Validates parent post and revision exist
- Requires `delete_post` capability for parent post

## Key Methods

### get_parent()
```php
protected function get_parent( int $parent_post_id ): WP_Post|WP_Error
```
Gets the parent post if:
- ID is valid (> 0)
- Post exists
- Post matches controller's parent post type

### get_revision()
```php
protected function get_revision( int $id ): WP_Post|WP_Error
```
Gets the revision if:
- ID is valid (> 0)
- Post exists
- Post type is `'revision'`

### check_read_permission()
```php
protected function check_read_permission( WP_Post $post ): bool
```
Checks read permission using parent controller's method.

## Response Links

| Relation | Description |
|----------|-------------|
| `self` | Link to this revision |
| `parent` | Link to parent post |

## Deletion Behavior

### DELETE /wp/v2/posts/{parent}/revisions/{id}

**Required Parameter:**
- `force` - Must be `true` (revisions don't support trashing)

**Response:**
```json
{
    "deleted": true,
    "previous": {
        "id": 789,
        "author": 1,
        "date": "2024-01-15T10:30:00",
        "title": { "rendered": "Post Title" },
        ...
    }
}
```

## Revisions Disabled

When revisions are disabled for a post type, the collection returns empty with proper headers:

- `X-WP-Total: 0`
- `X-WP-TotalPages: 0`

Check if revisions are enabled:
```php
wp_revisions_enabled( $post );
```

## Usage Example

```php
// Get revisions for a post
$request = new WP_REST_Request( 'GET', '/wp/v2/posts/123/revisions' );
$request->set_param( 'per_page', 10 );

$controller = new WP_REST_Revisions_Controller( 'post' );
$response = $controller->get_items( $request );

// Get all revisions (no pagination)
$request = new WP_REST_Request( 'GET', '/wp/v2/posts/123/revisions' );
$request->set_param( 'per_page', -1 );

$response = $controller->get_items( $request );

// Get a specific revision
$request = new WP_REST_Request( 'GET', '/wp/v2/posts/123/revisions/789' );
$request->set_param( 'context', 'edit' );

$response = $controller->get_item( $request );

// Delete a revision
$request = new WP_REST_Request( 'DELETE', '/wp/v2/posts/123/revisions/789' );
$request->set_param( 'force', true );

$response = $controller->delete_item( $request );
```

## Related Controllers

### WP_REST_Autosaves_Controller
Extends this class to handle autosaves specifically:
- Endpoint: `/wp/v2/posts/{parent}/autosaves`
- Can create autosaves (POST)
- Filters to only autosave revisions

### WP_REST_Template_Revisions_Controller
Handles revisions for block templates:
- Endpoint: `/wp/v2/templates/{parent}/revisions`

### WP_REST_Global_Styles_Revisions_Controller
Handles revisions for global styles:
- Endpoint: `/wp/v2/global-styles/{parent}/revisions`

## Pagination Differences

Unlike other controllers, revisions support `per_page=-1` to fetch all revisions at once. This is the default behavior for backward compatibility.

When paginating:
- Invalid `offset` returns error if >= total revisions
- Invalid `page` returns error if > max pages

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-revisions-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 6.4.0 | Added meta field support |
