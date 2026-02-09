# WP_REST_Terms_Controller

Core class used to manage terms associated with a taxonomy via the REST API.

## Class Synopsis

```php
class WP_REST_Terms_Controller extends WP_REST_Controller {
    protected $taxonomy;
    protected $meta;
    protected $sort_column;
    protected $total_terms;
    protected $allow_batch = array( 'v1' => true );
    
    public function __construct( string $taxonomy );
    public function register_routes();
    
    // Permission Checks
    public function get_items_permissions_check( $request );
    public function get_item_permissions_check( $request );
    public function create_item_permissions_check( $request );
    public function update_item_permissions_check( $request );
    public function delete_item_permissions_check( $request );
    public function check_read_terms_permission_for_post( $post, $request );
    
    // CRUD Operations
    public function get_items( $request );
    public function get_item( $request );
    public function create_item( $request );
    public function update_item( $request );
    public function delete_item( $request );
    
    // Data Preparation
    public function prepare_item_for_database( $request );
    public function prepare_item_for_response( $item, $request );
    protected function prepare_links( $term );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    
    // Utilities
    protected function get_term( $id );
    protected function check_is_taxonomy_allowed( $taxonomy );
}
```

## Endpoints

The endpoint path depends on the taxonomy's `rest_base`:

| Taxonomy | Endpoint |
|----------|----------|
| category | `/wp/v2/categories` |
| post_tag | `/wp/v2/tags` |
| Custom | `/wp/v2/{rest_base}` |

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/categories` | List categories |
| POST | `/wp/v2/categories` | Create a category |
| GET | `/wp/v2/categories/{id}` | Get a single category |
| POST/PUT/PATCH | `/wp/v2/categories/{id}` | Update a category |
| DELETE | `/wp/v2/categories/{id}` | Delete a category |

## Constructor

```php
public function __construct( string $taxonomy )
```

**Parameters:**
- `$taxonomy` - Taxonomy key (e.g., `'category'`, `'post_tag'`)

**Behavior:**
- Sets `$this->taxonomy` to the provided taxonomy
- Gets `rest_base` and `rest_namespace` from taxonomy object
- Creates `WP_REST_Term_Meta_Fields` instance

## Collection Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `context` | string | 'view' | Scope under which request is made |
| `page` | integer | 1 | Current page |
| `per_page` | integer | 10 | Items per page (max 100) |
| `search` | string | - | Search string |
| `exclude` | array | [] | Exclude specific IDs |
| `include` | array | [] | Include specific IDs |
| `offset` | integer | - | Offset (non-hierarchical only) |
| `order` | string | 'asc' | Sort order (asc/desc) |
| `orderby` | string | 'name' | Sort field |
| `hide_empty` | boolean | false | Hide terms with no posts |
| `parent` | integer | - | Filter by parent ID (hierarchical only) |
| `post` | integer | - | Filter by post ID |
| `slug` | array | - | Filter by slugs |

### Orderby Options

- `id` - Term ID
- `include` - Order by include parameter
- `name` - Term name
- `slug` - Term slug
- `include_slugs` - Order by slug include
- `term_group` - Term group
- `description` - Term description
- `count` - Post count

## Schema Properties

| Property | Type | Context | Required | Description |
|----------|------|---------|----------|-------------|
| `id` | integer | view, embed, edit | - | Term ID (readonly) |
| `count` | integer | view, edit | - | Post count (readonly) |
| `description` | string | view, edit | - | HTML description |
| `link` | string (uri) | view, embed, edit | - | Term archive URL (readonly) |
| `name` | string | view, embed, edit | create | Term name |
| `slug` | string | view, embed, edit | - | Term slug |
| `taxonomy` | string | view, embed, edit | - | Taxonomy key (readonly) |
| `parent` | integer | view, edit | - | Parent term ID (hierarchical only) |
| `meta` | object | view, edit | - | Term meta |

## Permission Checks

### get_items_permissions_check()
- Returns `false` if taxonomy doesn't exist or isn't allowed in REST
- Requires `edit_terms` capability for `edit` context
- If filtering by `post`, validates post read permission

### get_item_permissions_check()
- Validates term exists and belongs to this taxonomy
- Requires `edit_term` capability for `edit` context

### create_item_permissions_check()
- For hierarchical taxonomies: requires `edit_terms` capability
- For non-hierarchical taxonomies: requires `assign_terms` capability

### update_item_permissions_check()
- Requires `edit_term` capability

### delete_item_permissions_check()
- Requires `delete_term` capability

### check_read_terms_permission_for_post()
```php
public function check_read_terms_permission_for_post( WP_Post $post, WP_REST_Request $request ): bool
```
Checks if terms for a post can be read:
- Post must be associated with this taxonomy
- Post is publicly viewable, or
- User can `read_post`

## Key Methods

### get_term()
```php
protected function get_term( int $id ): WP_Term|WP_Error
```
Gets the term if:
- ID is valid (> 0)
- Term exists
- Term belongs to this taxonomy
- Taxonomy is allowed in REST

### check_is_taxonomy_allowed()
```php
protected function check_is_taxonomy_allowed( string $taxonomy ): bool
```
Checks if taxonomy has `show_in_rest` enabled.

### prepare_item_for_database()
```php
public function prepare_item_for_database( WP_REST_Request $request ): object
```
Maps request fields to term properties:
- `name` → `name`
- `slug` → `slug`
- `description` → `description`
- `parent` → `parent` (validates parent term exists)

### prepare_item_for_response()
```php
public function prepare_item_for_response( WP_Term $item, WP_REST_Request $request ): WP_REST_Response
```
Prepares term data for API response including links.

## Response Links

| Relation | Description |
|----------|-------------|
| `self` | Link to this term |
| `collection` | Link to terms collection |
| `about` | Link to taxonomy info |
| `up` | Link to parent term (hierarchical, embeddable) |
| `wp:post_type` | Links to posts with this term |

## Deletion Behavior

### DELETE /wp/v2/categories/{id}

**Required Parameter:**
- `force` - Must be `true` (terms don't support trashing)

**Response:**
```json
{
    "deleted": true,
    "previous": {
        "id": 123,
        "name": "Category Name",
        "slug": "category-name",
        ...
    }
}
```

## Hierarchical vs Non-Hierarchical

The controller behavior varies based on taxonomy type:

### Hierarchical (e.g., categories)
- `parent` schema property included
- `parent` collection parameter available
- `offset` parameter not available
- Requires `edit_terms` to create

### Non-Hierarchical (e.g., tags)
- No `parent` property
- `offset` parameter available
- Requires `assign_terms` to create

## Usage Example

```php
// List categories
$request = new WP_REST_Request( 'GET', '/wp/v2/categories' );
$request->set_param( 'per_page', 100 );
$request->set_param( 'hide_empty', false );
$request->set_param( 'orderby', 'name' );

$controller = new WP_REST_Terms_Controller( 'category' );
$response = $controller->get_items( $request );

// Create a category
$request = new WP_REST_Request( 'POST', '/wp/v2/categories' );
$request->set_param( 'name', 'New Category' );
$request->set_param( 'description', 'Category description' );
$request->set_param( 'parent', 5 ); // Parent category ID

$response = $controller->create_item( $request );

// Get terms for a specific post
$request = new WP_REST_Request( 'GET', '/wp/v2/tags' );
$request->set_param( 'post', 123 );

$controller = new WP_REST_Terms_Controller( 'post_tag' );
$response = $controller->get_items( $request );

// Update a term
$request = new WP_REST_Request( 'POST', '/wp/v2/categories/5' );
$request->set_param( 'name', 'Updated Name' );
$request->set_param( 'slug', 'updated-slug' );

$response = $controller->update_item( $request );

// Delete a term
$request = new WP_REST_Request( 'DELETE', '/wp/v2/categories/5' );
$request->set_param( 'force', true );

$response = $controller->delete_item( $request );
```

## Custom Taxonomies

Register custom taxonomies with REST support:

```php
register_taxonomy( 'genre', 'post', array(
    'public'       => true,
    'show_in_rest' => true,
    'rest_base'    => 'genres',
    'hierarchical' => true,
    'labels'       => array(
        'name' => 'Genres',
        'singular_name' => 'Genre',
    ),
));

// Endpoint automatically available at /wp/v2/genres
```

## Term Existence Handling

When creating a term that already exists, the API returns an error with the existing term ID:

```json
{
    "code": "term_exists",
    "message": "A term with the name provided already exists with this parent.",
    "data": {
        "status": 400,
        "term_id": 123
    }
}
```

## Taxonomy Default Args

Since WordPress 6.8.0, taxonomies can define default query arguments that are respected:

```php
register_taxonomy( 'custom_tax', 'post', array(
    'show_in_rest' => true,
    'args'         => array(
        'orderby' => 'term_order',
    ),
));
```

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-terms-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 5.0.0 | Added `rest_after_insert_{$taxonomy}` action |
| 5.9.0 | Added batching support |
| 6.0.3 | Added `check_read_terms_permission_for_post()` |
| 6.8.0 | Respects taxonomy default query arguments |
