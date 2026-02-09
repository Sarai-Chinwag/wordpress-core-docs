# WP_REST_Controller

Abstract base class for all REST API controllers. Provides the foundation for managing and interacting with REST API resources.

## Class Synopsis

```php
abstract class WP_REST_Controller {
    protected $namespace;
    protected $rest_base;
    protected $schema;
    
    // Route Registration
    public function register_routes();
    
    // CRUD Permission Checks
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
    public function prepare_response_for_collection( $response );
    
    // Schema
    public function get_item_schema();
    public function get_public_item_schema();
    public function get_collection_params();
    public function get_context_param( $args = array() );
    public function get_endpoint_args_for_item_schema( $method = WP_REST_Server::CREATABLE );
    
    // Response Filtering
    public function filter_response_by_context( $response_data, $context );
    public function get_fields_for_response( $request );
    
    // Additional Fields
    protected function add_additional_fields_to_object( $response_data, $request );
    protected function update_additional_fields_for_object( $data_object, $request );
    protected function add_additional_fields_schema( $schema );
    protected function get_additional_fields( $object_type = null );
    protected function get_object_type();
    
    // Utilities
    public function sanitize_slug( $slug );
}
```

## Properties

### $namespace
```php
protected $namespace;
```
The namespace for this controller's routes. Default: `'wp/v2'`.

### $rest_base
```php
protected $rest_base;
```
The base path for this controller's routes (e.g., `'posts'`, `'users'`).

### $schema
```php
protected $schema;
```
Cached results of `get_item_schema()` for performance.

## Methods

### register_routes()
```php
public function register_routes()
```
**Must be overridden.** Registers the routes for the controller using `register_rest_route()`.

**Triggers:** `_doing_it_wrong` if not overridden.

---

### get_items_permissions_check()
```php
public function get_items_permissions_check( WP_REST_Request $request ): true|WP_Error
```
Checks if the request has access to read a collection of items.

**Parameters:**
- `$request` - Full details about the request

**Returns:** `true` if access granted, `WP_Error` otherwise

---

### get_items()
```php
public function get_items( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Retrieves a collection of items.

**Parameters:**
- `$request` - Full details about the request

**Returns:** Response object on success, `WP_Error` on failure

---

### get_item_permissions_check()
```php
public function get_item_permissions_check( WP_REST_Request $request ): true|WP_Error
```
Checks if the request has access to read a specific item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** `true` if access granted, `WP_Error` otherwise

---

### get_item()
```php
public function get_item( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Retrieves a single item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** Response object on success, `WP_Error` on failure

---

### create_item_permissions_check()
```php
public function create_item_permissions_check( WP_REST_Request $request ): true|WP_Error
```
Checks if the request has access to create items.

**Parameters:**
- `$request` - Full details about the request

**Returns:** `true` if access granted, `WP_Error` otherwise

---

### create_item()
```php
public function create_item( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Creates a single item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** Response object on success, `WP_Error` on failure

---

### update_item_permissions_check()
```php
public function update_item_permissions_check( WP_REST_Request $request ): true|WP_Error
```
Checks if the request has access to update a specific item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** `true` if access granted, `WP_Error` otherwise

---

### update_item()
```php
public function update_item( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Updates a single item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** Response object on success, `WP_Error` on failure

---

### delete_item_permissions_check()
```php
public function delete_item_permissions_check( WP_REST_Request $request ): true|WP_Error
```
Checks if the request has access to delete a specific item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** `true` if access granted, `WP_Error` otherwise

---

### delete_item()
```php
public function delete_item( WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Deletes a single item.

**Parameters:**
- `$request` - Full details about the request

**Returns:** Response object on success, `WP_Error` on failure

---

### prepare_item_for_database()
```php
protected function prepare_item_for_database( WP_REST_Request $request ): object|WP_Error
```
Prepares a single item for create or update operations.

**Parameters:**
- `$request` - Request object

**Returns:** Prepared item object, `WP_Error` on failure

---

### prepare_item_for_response()
```php
public function prepare_item_for_response( mixed $item, WP_REST_Request $request ): WP_REST_Response|WP_Error
```
Prepares the item for the REST response.

**Parameters:**
- `$item` - WordPress representation of the item
- `$request` - Request object

**Returns:** Response object on success, `WP_Error` on failure

---

### prepare_response_for_collection()
```php
public function prepare_response_for_collection( WP_REST_Response $response ): array|mixed
```
Prepares a response for insertion into a collection.

**Parameters:**
- `$response` - Response object

**Returns:** Response data ready for collection, including `_links` if present

---

### filter_response_by_context()
```php
public function filter_response_by_context( array $response_data, string $context ): array
```
Filters response data based on the context defined in the schema.

**Parameters:**
- `$response_data` - Response data to filter
- `$context` - Context (`'view'`, `'edit'`, `'embed'`)

**Returns:** Filtered response data

---

### get_item_schema()
```php
public function get_item_schema(): array
```
Retrieves the item's schema conforming to JSON Schema.

**Returns:** Item schema data

---

### get_public_item_schema()
```php
public function get_public_item_schema(): array
```
Retrieves the item's schema for public consumption (removes `arg_options`).

**Returns:** Public item schema data

---

### get_collection_params()
```php
public function get_collection_params(): array
```
Retrieves the query parameters for collections.

**Default Parameters:**
- `context` - Scope under which the request is made
- `page` - Current page (default: 1, minimum: 1)
- `per_page` - Items per page (default: 10, min: 1, max: 100)
- `search` - Search string

**Returns:** Collection query parameters

---

### get_context_param()
```php
public function get_context_param( array $args = array() ): array
```
Retrieves the context parameter details with consistent descriptions and enum from schema.

**Parameters:**
- `$args` - Additional arguments for context parameter

**Returns:** Context parameter details

---

### get_endpoint_args_for_item_schema()
```php
public function get_endpoint_args_for_item_schema( string $method = WP_REST_Server::CREATABLE ): array
```
Retrieves endpoint arguments from the item schema.

**Parameters:**
- `$method` - HTTP method (`CREATABLE` checks for required values)

**Returns:** Endpoint arguments

---

### get_fields_for_response()
```php
public function get_fields_for_response( WP_REST_Request $request ): string[]
```
Gets an array of fields to include in the response based on schema and `_fields` parameter.

**Parameters:**
- `$request` - Request object

**Returns:** Fields to include in response

---

### add_additional_fields_to_object()
```php
protected function add_additional_fields_to_object( array $response_data, WP_REST_Request $request ): array
```
Adds values from additional registered fields to the response data.

**Parameters:**
- `$response_data` - Prepared response array
- `$request` - Request object

**Returns:** Modified data with additional fields

---

### update_additional_fields_for_object()
```php
protected function update_additional_fields_for_object( object $data_object, WP_REST_Request $request ): true|WP_Error
```
Updates the values of additional fields added to a data object.

**Parameters:**
- `$data_object` - Data model (WP_Post, WP_Term, etc.)
- `$request` - Request object

**Returns:** `true` on success, `WP_Error` if a field cannot be updated

---

### add_additional_fields_schema()
```php
protected function add_additional_fields_schema( array $schema ): array
```
Adds schema from additional fields to the schema array.

**Parameters:**
- `$schema` - Schema array

**Returns:** Modified schema

---

### get_additional_fields()
```php
protected function get_additional_fields( string $object_type = null ): array
```
Retrieves all registered additional fields for a given object type.

**Parameters:**
- `$object_type` - Optional object type (defaults to schema title)

**Returns:** Registered additional fields

---

### get_object_type()
```php
protected function get_object_type(): string|null
```
Retrieves the object type this controller manages (from schema title).

**Returns:** Object type string or `null`

---

### sanitize_slug()
```php
public function sanitize_slug( string $slug ): string
```
Sanitizes the slug value using `sanitize_title()`.

**Parameters:**
- `$slug` - Slug value

**Returns:** Sanitized slug

## Usage Example

```php
class My_Custom_Controller extends WP_REST_Controller {
    
    public function __construct() {
        $this->namespace = 'my-plugin/v1';
        $this->rest_base = 'items';
    }
    
    public function register_routes() {
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
                'schema' => array( $this, 'get_public_item_schema' ),
            )
        );
    }
    
    public function get_items_permissions_check( $request ) {
        return current_user_can( 'read' );
    }
    
    public function get_items( $request ) {
        $items = get_my_items();
        $data = array();
        
        foreach ( $items as $item ) {
            $response = $this->prepare_item_for_response( $item, $request );
            $data[] = $this->prepare_response_for_collection( $response );
        }
        
        return rest_ensure_response( $data );
    }
    
    public function get_item_schema() {
        if ( $this->schema ) {
            return $this->add_additional_fields_schema( $this->schema );
        }
        
        $this->schema = array(
            '$schema'    => 'http://json-schema.org/draft-04/schema#',
            'title'      => 'my-item',
            'type'       => 'object',
            'properties' => array(
                'id' => array(
                    'description' => __( 'Unique identifier.' ),
                    'type'        => 'integer',
                    'context'     => array( 'view', 'edit' ),
                    'readonly'    => true,
                ),
                'name' => array(
                    'description' => __( 'Item name.' ),
                    'type'        => 'string',
                    'context'     => array( 'view', 'edit' ),
                ),
            ),
        );
        
        return $this->add_additional_fields_schema( $this->schema );
    }
}
```

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 4.9.6 | Added `get_fields_for_response()` |
| 5.3.0 | Added schema caching |
