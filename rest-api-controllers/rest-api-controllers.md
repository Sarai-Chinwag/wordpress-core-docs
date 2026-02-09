# WordPress REST API Controllers Overview

## Architecture

WordPress REST API controllers follow a consistent object-oriented architecture based on the abstract `WP_REST_Controller` class. Each controller manages a specific resource type (posts, users, comments, terms, etc.) and provides standardized CRUD operations through RESTful endpoints.

## Controller Hierarchy

```
WP_REST_Controller (abstract base)
├── WP_REST_Posts_Controller
│   ├── WP_REST_Attachments_Controller
│   ├── WP_REST_Blocks_Controller
│   ├── WP_REST_Templates_Controller
│   ├── WP_REST_Menu_Items_Controller
│   └── WP_REST_Menus_Controller
├── WP_REST_Users_Controller
├── WP_REST_Comments_Controller
├── WP_REST_Terms_Controller
├── WP_REST_Revisions_Controller
├── WP_REST_Autosaves_Controller
├── WP_REST_Taxonomies_Controller
├── WP_REST_Post_Types_Controller
├── WP_REST_Post_Statuses_Controller
├── WP_REST_Settings_Controller
├── WP_REST_Themes_Controller
├── WP_REST_Plugins_Controller
├── WP_REST_Sidebars_Controller
├── WP_REST_Widgets_Controller
├── WP_REST_Widget_Types_Controller
├── WP_REST_Block_Types_Controller
├── WP_REST_Block_Patterns_Controller
├── WP_REST_Block_Pattern_Categories_Controller
├── WP_REST_Search_Controller
├── WP_REST_Site_Health_Controller
├── WP_REST_Application_Passwords_Controller
├── WP_REST_Font_Families_Controller
├── WP_REST_Font_Faces_Controller
├── WP_REST_Font_Collections_Controller
├── WP_REST_Global_Styles_Controller
├── WP_REST_Global_Styles_Revisions_Controller
└── WP_REST_URL_Details_Controller
```

## Core Concepts

### Namespace and Rest Base

Every controller defines two key properties:

```php
protected $namespace = 'wp/v2';  // API version namespace
protected $rest_base = 'posts';   // Resource endpoint path
```

The resulting endpoint URL becomes: `/wp-json/wp/v2/posts`

### Route Registration Pattern

Controllers register routes in `register_routes()`:

```php
public function register_routes() {
    // Collection route (list/create)
    register_rest_route(
        $this->namespace,
        '/' . $this->rest_base,
        array(
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_items' ),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'args'                => $this->get_collection_params(),
            ),
            array(
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => array( $this, 'create_item' ),
                'permission_callback' => array( $this, 'create_item_permissions_check' ),
                'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::CREATABLE ),
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        )
    );
    
    // Single item route (read/update/delete)
    register_rest_route(
        $this->namespace,
        '/' . $this->rest_base . '/(?P<id>[\d]+)',
        array(
            'args' => array(
                'id' => array(
                    'description' => __( 'Unique identifier for the resource.' ),
                    'type'        => 'integer',
                ),
            ),
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_item' ),
                'permission_callback' => array( $this, 'get_item_permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'update_item' ),
                'permission_callback' => array( $this, 'update_item_permissions_check' ),
            ),
            array(
                'methods'             => WP_REST_Server::DELETABLE,
                'callback'            => array( $this, 'delete_item' ),
                'permission_callback' => array( $this, 'delete_item_permissions_check' ),
            ),
            'schema' => array( $this, 'get_public_item_schema' ),
        )
    );
}
```

### CRUD Method Pairs

Each CRUD operation has a permission check method paired with an action method:

| Operation | Permission Check | Action Method |
|-----------|------------------|---------------|
| List | `get_items_permissions_check()` | `get_items()` |
| Read | `get_item_permissions_check()` | `get_item()` |
| Create | `create_item_permissions_check()` | `create_item()` |
| Update | `update_item_permissions_check()` | `update_item()` |
| Delete | `delete_item_permissions_check()` | `delete_item()` |

### Schema System

Controllers define JSON Schema for their resources:

```php
public function get_item_schema() {
    return array(
        '$schema'    => 'http://json-schema.org/draft-04/schema#',
        'title'      => 'post',
        'type'       => 'object',
        'properties' => array(
            'id' => array(
                'description' => __( 'Unique identifier.' ),
                'type'        => 'integer',
                'context'     => array( 'view', 'edit', 'embed' ),
                'readonly'    => true,
            ),
            // ... more properties
        ),
    );
}
```

### Context-Based Field Filtering

The `context` parameter controls which fields are returned:

- **view**: Default context, public fields
- **edit**: Additional fields for editing (requires authentication)
- **embed**: Minimal fields for embedding in other resources

### Response Preparation

The `prepare_item_for_response()` method transforms database objects to API responses:

```php
public function prepare_item_for_response( $item, $request ) {
    $fields = $this->get_fields_for_response( $request );
    $data = array();
    
    if ( rest_is_field_included( 'id', $fields ) ) {
        $data['id'] = $item->ID;
    }
    // ... build response data
    
    $context = $request['context'] ?? 'view';
    $data = $this->filter_response_by_context( $data, $context );
    
    $response = rest_ensure_response( $data );
    $response->add_links( $this->prepare_links( $item ) );
    
    return $response;
}
```

### Database Preparation

The `prepare_item_for_database()` method transforms request data for database operations:

```php
protected function prepare_item_for_database( $request ) {
    $prepared = new stdClass();
    
    if ( isset( $request['title'] ) ) {
        $prepared->post_title = $request['title'];
    }
    // ... map request fields to database fields
    
    return apply_filters( 'rest_pre_insert_post', $prepared, $request );
}
```

## Batching Support

Controllers can enable batching for bulk operations:

```php
protected $allow_batch = array( 'v1' => true );
```

This enables sending multiple requests in a single HTTP call to `/wp-json/batch/v1`.

## Meta Fields

Controllers that support meta fields use companion meta field classes:

- `WP_REST_Post_Meta_Fields`
- `WP_REST_User_Meta_Fields`
- `WP_REST_Comment_Meta_Fields`
- `WP_REST_Term_Meta_Fields`

## Additional Fields

Plugins can register additional fields using `register_rest_field()`:

```php
register_rest_field( 'post', 'custom_field', array(
    'get_callback'    => 'get_custom_field',
    'update_callback' => 'update_custom_field',
    'schema'          => array(
        'type'        => 'string',
        'description' => 'A custom field.',
        'context'     => array( 'view', 'edit' ),
    ),
));
```

## HTTP Method Constants

`WP_REST_Server` provides constants for HTTP methods:

- `WP_REST_Server::READABLE` = 'GET'
- `WP_REST_Server::CREATABLE` = 'POST'
- `WP_REST_Server::EDITABLE` = 'POST, PUT, PATCH'
- `WP_REST_Server::DELETABLE` = 'DELETE'
- `WP_REST_Server::ALLMETHODS` = 'GET, POST, PUT, PATCH, DELETE'

## Error Handling

Controllers return `WP_Error` objects for failures:

```php
return new WP_Error(
    'rest_forbidden',
    __( 'Sorry, you cannot do that.' ),
    array( 'status' => 403 )
);
```

Common error codes:
- `rest_forbidden` - Permission denied
- `rest_invalid_param` - Invalid parameter
- `rest_post_invalid_id` - Invalid post ID
- `rest_user_invalid_id` - Invalid user ID
- `rest_term_invalid` - Invalid term

## HEAD Request Optimization

Controllers optimize HEAD requests by:
- Setting `'fields' => 'ids'` to only fetch IDs
- Disabling meta/term cache priming
- Returning empty response body

```php
$is_head_request = $request->is_method( 'HEAD' );
if ( $is_head_request ) {
    $args['fields'] = 'ids';
    $args['update_post_meta_cache'] = false;
}
```

## Pagination

Collection endpoints support pagination via:

- `page` - Current page number (1-indexed)
- `per_page` - Items per page (1-100, default 10)
- `offset` - Offset for pagination

Response headers indicate totals:
- `X-WP-Total` - Total items available
- `X-WP-TotalPages` - Total pages available

Link headers provide navigation:
- `Link: <url>; rel="prev"` - Previous page
- `Link: <url>; rel="next"` - Next page

## Source Location

```
/wp-includes/rest-api/endpoints/
```

## Since Version

REST API Controllers were introduced in WordPress 4.7.0.
