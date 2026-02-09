# REST API Functions

Core functions for route registration, URL handling, and utilities.

**Source:** `wp-includes/rest-api.php`

---

## Route Registration

### register_rest_route()

Registers a REST API route. Must be called during `rest_api_init` action.

```php
register_rest_route( string $route_namespace, string $route, array $args = array(), bool $override = false ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route_namespace` | string | First URL segment after prefix (e.g., `my-plugin/v1`) |
| `$route` | string | Route path (e.g., `/items/(?P<id>\d+)`) |
| `$args` | array | Endpoint options or array of options for multiple methods |
| `$override` | bool | Whether to override existing route. Default `false` |

**Args:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `methods` | string | Yes | HTTP methods (`GET`, `POST`, etc.) |
| `callback` | callable | Yes | Handler function |
| `permission_callback` | callable | Yes | Permission check (use `__return_true` for public) |
| `args` | array | No | Parameter definitions |

**Returns:** `true` on success, `false` on error.

**Example:**

```php
add_action( 'rest_api_init', function() {
    register_rest_route( 'my-plugin/v1', '/items/(?P<id>\d+)', array(
        'methods'             => 'GET',
        'callback'            => 'get_item',
        'permission_callback' => '__return_true',
        'args'                => array(
            'id' => array(
                'type'              => 'integer',
                'required'          => true,
                'validate_callback' => fn( $v ) => $v > 0,
            ),
        ),
    ) );
} );
```

---

### register_rest_field()

Registers a new field on an existing object type.

```php
register_rest_field( string|array $object_type, string $attribute, array $args = array() ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string\|array | Object type(s): `post`, `term`, `comment`, etc. |
| `$attribute` | string | Field name |
| `$args` | array | Callbacks and schema |

**Args:**

| Key | Type | Description |
|-----|------|-------------|
| `get_callback` | callable\|null | Retrieves field value |
| `update_callback` | callable\|null | Sets field value |
| `schema` | array\|null | JSON Schema for the field |

**Example:**

```php
register_rest_field( 'post', 'custom_meta', array(
    'get_callback' => fn( $post ) => get_post_meta( $post['id'], 'custom_key', true ),
    'update_callback' => fn( $value, $post ) => update_post_meta( $post->ID, 'custom_key', $value ),
    'schema' => array(
        'type'        => 'string',
        'description' => 'Custom metadata field',
    ),
) );
```

---

## URL Functions

### rest_url()

Retrieves the URL to a REST endpoint.

```php
rest_url( string $path = '', string $scheme = 'rest' ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$path` | string | REST route path |
| `$scheme` | string | URL scheme (`rest`, `http`, `https`) |

**Returns:** Full URL to the endpoint.

**Example:**

```php
rest_url( '/wp/v2/posts' );
// https://example.com/wp-json/wp/v2/posts
```

---

### get_rest_url()

Retrieves the URL to a REST endpoint on a site.

```php
get_rest_url( int $blog_id = null, string $path = '/', string $scheme = 'rest' ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$blog_id` | int\|null | Blog ID. Default current site |
| `$path` | string | REST route path |
| `$scheme` | string | URL scheme |

**Returns:** Full URL to the endpoint.

---

### rest_get_url_prefix()

Retrieves the REST URL prefix.

```php
rest_get_url_prefix(): string
```

**Returns:** URL prefix, default `wp-json`.

---

## Request/Response Functions

### rest_do_request()

Performs an internal REST API request.

```php
rest_do_request( WP_REST_Request|string $request ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request\|string | Request object or route path |

**Returns:** Response from the endpoint.

**Example:**

```php
$request = new WP_REST_Request( 'GET', '/wp/v2/posts' );
$request['per_page'] = 5;
$response = rest_do_request( $request );
$posts = $response->get_data();
```

---

### rest_get_server()

Retrieves the current REST server instance.

```php
rest_get_server(): WP_REST_Server
```

**Returns:** The global `WP_REST_Server` instance.

---

### rest_ensure_request()

Ensures a request is a `WP_REST_Request` object.

```php
rest_ensure_request( WP_REST_Request|array|string $request ): WP_REST_Request
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | mixed | Request to normalize |

**Returns:** `WP_REST_Request` instance.

---

### rest_ensure_response()

Ensures a response is a `WP_REST_Response` object.

```php
rest_ensure_response( WP_REST_Response|WP_Error|WP_HTTP_Response|mixed $response ): WP_REST_Response|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | mixed | Response to normalize |

**Returns:** `WP_REST_Response` or `WP_Error`.

---

### rest_convert_error_to_response()

Converts a `WP_Error` to a `WP_REST_Response`.

```php
rest_convert_error_to_response( WP_Error $error ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | WP_Error | Error to convert |

**Returns:** Response with error data, status from error's `status` data.

---

## Validation Functions

### rest_validate_request_arg()

Validates a request argument based on route args.

```php
rest_validate_request_arg( mixed $value, WP_REST_Request $request, string $param ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Value to validate |
| `$request` | WP_REST_Request | Request object |
| `$param` | string | Parameter name |

**Returns:** `true` if valid, `WP_Error` if invalid.

---

### rest_sanitize_request_arg()

Sanitizes a request argument based on route args.

```php
rest_sanitize_request_arg( mixed $value, WP_REST_Request $request, string $param ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Value to sanitize |
| `$request` | WP_REST_Request | Request object |
| `$param` | string | Parameter name |

**Returns:** Sanitized value.

---

### rest_parse_request_arg()

Parses a request argument based on type.

```php
rest_parse_request_arg( mixed $value, WP_REST_Request $request, string $param ): mixed|WP_Error
```

---

### rest_validate_value_from_schema()

Validates a value against a JSON Schema.

```php
rest_validate_value_from_schema( mixed $value, array $args, string $param = '' ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Value to validate |
| `$args` | array | JSON Schema definition |
| `$param` | string | Parameter name for errors |

**Returns:** `true` if valid, `WP_Error` if invalid.

---

### rest_sanitize_value_from_schema()

Sanitizes a value based on JSON Schema.

```php
rest_sanitize_value_from_schema( mixed $value, array $args, string $param = '' ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Value to sanitize |
| `$args` | array | JSON Schema definition |
| `$param` | string | Parameter name |

**Returns:** Sanitized value.

---

### rest_get_allowed_schema_keywords()

Gets supported JSON Schema keywords.

```php
rest_get_allowed_schema_keywords(): string[]
```

**Returns:** Array of supported keywords like `type`, `enum`, `minimum`, `pattern`, etc.

---

## Type Checking Functions

### rest_is_boolean()

Determines if a value is boolean-like.

```php
rest_is_boolean( mixed $maybe_bool ): bool
```

Accepts: `true`, `false`, `'true'`, `'false'`, `1`, `0`, `'1'`, `'0'`, `'yes'`, `'no'`.

---

### rest_sanitize_boolean()

Sanitizes a value to boolean.

```php
rest_sanitize_boolean( mixed $value ): bool
```

---

### rest_is_integer()

Determines if a value is an integer or integer string.

```php
rest_is_integer( mixed $maybe_integer ): bool
```

---

### rest_is_array()

Determines if a value is array-like.

```php
rest_is_array( mixed $maybe_array ): bool
```

---

### rest_sanitize_array()

Sanitizes a value to an array.

```php
rest_sanitize_array( mixed $maybe_array ): array
```

---

### rest_is_object()

Determines if a value is object-like.

```php
rest_is_object( mixed $maybe_object ): bool
```

---

### rest_sanitize_object()

Sanitizes a value to an object/associative array.

```php
rest_sanitize_object( mixed $maybe_object ): array
```

---

## Date Functions

### rest_parse_date()

Parses an RFC 3339 date string.

```php
rest_parse_date( string $date, bool $force_utc = false ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$date` | string | RFC 3339 date string |
| `$force_utc` | bool | Whether to force UTC timezone |

**Returns:** Unix timestamp or `false` on failure.

---

### rest_get_date_with_gmt()

Parses a date into local and GMT times.

```php
rest_get_date_with_gmt( string $date, bool $is_utc = false ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$date` | string | RFC 3339 date |
| `$is_utc` | bool | Whether input is UTC |

**Returns:** Array with `date` and `date_gmt` keys, or `null`.

---

## Utility Functions

### rest_is_ip_address()

Validates an IP address string.

```php
rest_is_ip_address( string $ip ): string|false
```

**Returns:** IP address if valid, `false` otherwise.

---

### rest_parse_hex_color()

Parses and validates a hex color.

```php
rest_parse_hex_color( string $color ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$color` | string | Hex color with or without `#` |

**Returns:** 6-character hex with `#`, or `false`.

---

### rest_get_avatar_urls()

Retrieves avatar URLs for a user.

```php
rest_get_avatar_urls( mixed $id_or_email ): array
```

**Returns:** Array of size => URL pairs.

---

### rest_get_avatar_sizes()

Retrieves available avatar sizes.

```php
rest_get_avatar_sizes(): int[]
```

**Returns:** Default `array( 24, 48, 96 )`.

---

### rest_authorization_required_code()

Gets appropriate HTTP status for unauthorized requests.

```php
rest_authorization_required_code(): int
```

**Returns:** `401` if not logged in, `403` if logged in.

---

### wp_is_rest_endpoint()

Checks if the current request is a REST API request.

```php
wp_is_rest_endpoint(): bool
```

**Returns:** `true` if REST request, `false` otherwise.

---

## Route Lookup Functions

### rest_get_route_for_post()

Gets the REST route for a post.

```php
rest_get_route_for_post( WP_Post|int $post ): string
```

**Returns:** Route like `/wp/v2/posts/123`.

---

### rest_get_route_for_post_type_items()

Gets the REST route for a post type's collection.

```php
rest_get_route_for_post_type_items( string $post_type ): string
```

**Returns:** Route like `/wp/v2/posts`.

---

### rest_get_route_for_term()

Gets the REST route for a term.

```php
rest_get_route_for_term( WP_Term|int $term ): string
```

**Returns:** Route like `/wp/v2/categories/5`.

---

### rest_get_route_for_taxonomy_items()

Gets the REST route for a taxonomy's collection.

```php
rest_get_route_for_taxonomy_items( string $taxonomy ): string
```

**Returns:** Route like `/wp/v2/categories`.

---

### rest_get_queried_resource_route()

Gets the REST route for the currently queried resource.

```php
rest_get_queried_resource_route(): string
```

**Returns:** Route for current post, term, or author.

---

## Response Filtering

### rest_filter_response_fields()

Filters response to only include requested fields.

```php
rest_filter_response_fields( WP_REST_Response $response, WP_REST_Server $server, WP_REST_Request $request ): WP_REST_Response
```

Respects `_fields` query parameter.

---

### rest_is_field_included()

Checks if a field should be included in response.

```php
rest_is_field_included( string $field, array $fields ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | Field to check (supports dot notation) |
| `$fields` | array | Requested fields |

**Example:**

```php
rest_is_field_included( 'title.rendered', array( 'title' ) ); // true
rest_is_field_included( 'content', array( 'title' ) );        // false
```

---

### rest_filter_response_by_context()

Filters response data by schema context.

```php
rest_filter_response_by_context( array $response_data, array $schema, string $context ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response_data` | array | Response data |
| `$schema` | array | Full schema with context arrays |
| `$context` | string | Context (`view`, `edit`, `embed`) |

**Returns:** Filtered response data.

---

### rest_default_additional_properties_to_false()

Sets `additionalProperties: false` on all object schemas.

```php
rest_default_additional_properties_to_false( array $schema ): array
```

---

## Preloading

### rest_preload_api_request()

Preloads REST API data to avoid additional requests.

```php
rest_preload_api_request( array $memo, string $path ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$memo` | array | Preloaded data accumulator |
| `$path` | string | REST path to preload |

**Example:**

```php
$preload_paths = array(
    '/wp/v2/posts?per_page=5',
    '/wp/v2/users/me?context=edit',
);
$preload_data = array_reduce( $preload_paths, 'rest_preload_api_request', array() );
wp_add_inline_script( 'my-script', 'var preloadedData = ' . wp_json_encode( $preload_data ) );
```

---

### rest_parse_embed_param()

Parses the `_embed` parameter.

```php
rest_parse_embed_param( string|array $embed ): bool|string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$embed` | string\|array | Embed parameter value |

**Returns:** `true` for all links, or array of relation names.

---

## Schema Endpoints

### rest_get_endpoint_args_for_schema()

Converts schema to endpoint args.

```php
rest_get_endpoint_args_for_schema( array $schema, string $method = WP_REST_Server::CREATABLE ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$schema` | array | JSON Schema |
| `$method` | string | HTTP method for required fields |

**Returns:** Args array suitable for `register_rest_route()`.
