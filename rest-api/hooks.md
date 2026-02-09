# REST API Hooks

Actions and filters for the REST API.

---

## Actions

### rest_api_init

Fires when the REST API server is initialized. Register routes here.

```php
do_action( 'rest_api_init', WP_REST_Server $server )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$server` | WP_REST_Server | Server instance |

**Example:**

```php
add_action( 'rest_api_init', function( $server ) {
    register_rest_route( 'my-plugin/v1', '/items', array(
        'methods'             => 'GET',
        'callback'            => 'get_items',
        'permission_callback' => '__return_true',
    ) );
} );
```

---

## Authentication Filters

### rest_authentication_errors

Filters REST API authentication. Return `WP_Error` to deny, `true` to allow, `null` to defer.

```php
apply_filters( 'rest_authentication_errors', WP_Error|null|true $errors )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$errors` | WP_Error\|null\|true | Current auth state |

**Returns:** `WP_Error` to reject, `null` to let other auth handle, `true` if authenticated.

**Example:**

```php
add_filter( 'rest_authentication_errors', function( $result ) {
    // Skip if another method authenticated
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }
    
    // Custom auth check
    $token = $_SERVER['HTTP_X_API_KEY'] ?? '';
    if ( $token === 'secret' ) {
        return true;
    }
    
    return new WP_Error( 'invalid_key', 'Invalid API key', array( 'status' => 401 ) );
} );
```

---

## Request Lifecycle Filters

### rest_pre_dispatch

Filters before dispatching. Return non-null to short-circuit.

```php
apply_filters( 'rest_pre_dispatch', mixed $result, WP_REST_Server $server, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$result` | mixed | Pre-dispatch result (null to continue) |
| `$server` | WP_REST_Server | Server instance |
| `$request` | WP_REST_Request | Request being dispatched |

**Returns:** Response to send, or `null` to continue normal dispatch.

**Example:**

```php
add_filter( 'rest_pre_dispatch', function( $result, $server, $request ) {
    // Rate limiting
    if ( is_rate_limited( $request ) ) {
        return new WP_Error( 'rate_limited', 'Too many requests', array( 'status' => 429 ) );
    }
    return $result;
}, 10, 3 );
```

---

### rest_request_before_callbacks

Filters response before executing callbacks.

```php
apply_filters( 'rest_request_before_callbacks', WP_REST_Response|WP_Error|mixed $response, array $handler, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | mixed | Current response (null initially) |
| `$handler` | array | Matched route handler |
| `$request` | WP_REST_Request | Request object |

**Returns:** Response to use, or original to continue.

---

### rest_dispatch_request

Filters before calling route callback. Return non-null to override.

```php
apply_filters( 'rest_dispatch_request', mixed $dispatch_result, WP_REST_Request $request, string $route, array $handler )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$dispatch_result` | mixed | Override result (null to call callback) |
| `$request` | WP_REST_Request | Request object |
| `$route` | string | Matched route |
| `$handler` | array | Route handler |

**Returns:** Response to use, or `null` to execute callback.

---

### rest_request_after_callbacks

Filters response after executing callbacks.

```php
apply_filters( 'rest_request_after_callbacks', WP_REST_Response|WP_Error|mixed $response, array $handler, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | mixed | Response from callback |
| `$handler` | array | Matched route handler |
| `$request` | WP_REST_Request | Request object |

**Returns:** Modified response.

**Example:**

```php
add_filter( 'rest_request_after_callbacks', function( $response, $handler, $request ) {
    // Add timing header
    if ( $response instanceof WP_REST_Response ) {
        $response->header( 'X-Request-Time', microtime( true ) - $_SERVER['REQUEST_TIME_FLOAT'] );
    }
    return $response;
}, 10, 3 );
```

---

### rest_post_dispatch

Filters final response before sending.

```php
apply_filters( 'rest_post_dispatch', WP_HTTP_Response $result, WP_REST_Server $server, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$result` | WP_HTTP_Response | Response object |
| `$server` | WP_REST_Server | Server instance |
| `$request` | WP_REST_Request | Request object |

**Returns:** Modified response.

**Example:**

```php
add_filter( 'rest_post_dispatch', function( $response, $server, $request ) {
    // Modify all responses
    $data = $response->get_data();
    $data['api_version'] = '2.0';
    $response->set_data( $data );
    return $response;
}, 10, 3 );
```

---

## Response Filters

### rest_pre_serve_request

Filters whether to serve the request manually.

```php
apply_filters( 'rest_pre_serve_request', bool $served, WP_HTTP_Response $result, WP_REST_Request $request, WP_REST_Server $server )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$served` | bool | Whether already served |
| `$result` | WP_HTTP_Response | Response to send |
| `$request` | WP_REST_Request | Request object |
| `$server` | WP_REST_Server | Server instance |

**Returns:** `true` to skip default JSON output.

---

### rest_pre_echo_response

Filters response data before JSON encoding.

```php
apply_filters( 'rest_pre_echo_response', array $result, WP_REST_Server $server, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$result` | array | Response data array |
| `$server` | WP_REST_Server | Server instance |
| `$request` | WP_REST_Request | Request object |

**Returns:** Modified response data.

---

### rest_envelope_response

Filters envelope format.

```php
apply_filters( 'rest_envelope_response', array $envelope, WP_REST_Response $response )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$envelope` | array | Envelope with `body`, `status`, `headers` |
| `$response` | WP_REST_Response | Original response |

**Returns:** Modified envelope.

---

## URL Filters

### rest_url_prefix

Filters the REST URL prefix.

```php
apply_filters( 'rest_url_prefix', string $prefix )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$prefix` | string | URL prefix (default `wp-json`) |

**Returns:** Modified prefix.

---

### rest_url

Filters the REST URL.

```php
apply_filters( 'rest_url', string $url, string $path, int $blog_id, string $scheme )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | Full REST URL |
| `$path` | string | REST path |
| `$blog_id` | int | Blog ID |
| `$scheme` | string | URL scheme |

**Returns:** Modified URL.

---

## Route/Endpoint Filters

### rest_endpoints

Filters available endpoints.

```php
apply_filters( 'rest_endpoints', array $endpoints )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$endpoints` | array | Map of route to handlers |

**Returns:** Modified endpoints.

---

### rest_endpoints_description

Filters publicly-visible data for a single route.

```php
apply_filters( 'rest_endpoints_description', array $data )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | array | Route data for index |

**Returns:** Modified route data.

---

### rest_route_data

Filters publicly-visible route data.

```php
apply_filters( 'rest_route_data', array[] $available, array $routes )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$available` | array[] | Route data keyed by route |
| `$routes` | array | Internal route data |

**Returns:** Modified route data.

---

### rest_index

Filters the REST API root index.

```php
apply_filters( 'rest_index', WP_REST_Response $response, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Index response |
| `$request` | WP_REST_Request | Request object |

**Returns:** Modified response.

---

### rest_namespace_index

Filters namespace index data.

```php
apply_filters( 'rest_namespace_index', WP_REST_Response $response, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Namespace index |
| `$request` | WP_REST_Request | Request with `namespace` param |

**Returns:** Modified response.

---

## CORS Filters

### rest_exposed_cors_headers

Filters exposed CORS headers.

```php
apply_filters( 'rest_exposed_cors_headers', string[] $expose_headers, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$expose_headers` | string[] | Headers to expose |
| `$request` | WP_REST_Request | Request object |

**Default:** `['X-WP-Total', 'X-WP-TotalPages', 'Link']`

---

### rest_allowed_cors_headers

Filters allowed CORS request headers.

```php
apply_filters( 'rest_allowed_cors_headers', string[] $allow_headers, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$allow_headers` | string[] | Allowed headers |
| `$request` | WP_REST_Request | Request object |

**Default:** `['Authorization', 'X-WP-Nonce', 'Content-Disposition', 'Content-MD5', 'Content-Type']`

---

## JSON Filters

### rest_json_encode_options

Filters JSON encoding options.

```php
apply_filters( 'rest_json_encode_options', int $options, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | int | `json_encode()` options |
| `$request` | WP_REST_Request | Request object |

**Returns:** Modified options (e.g., add `JSON_PRETTY_PRINT`).

---

### rest_jsonp_enabled

Filters whether JSONP is enabled.

```php
apply_filters( 'rest_jsonp_enabled', bool $enabled )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$enabled` | bool | Whether JSONP enabled (default `true`) |

---

## Route Lookup Filters

### rest_route_for_post

Filters REST route for a post.

```php
apply_filters( 'rest_route_for_post', string $route, WP_Post $post )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | REST route |
| `$post` | WP_Post | Post object |

---

### rest_route_for_post_type_items

Filters REST route for post type collection.

```php
apply_filters( 'rest_route_for_post_type_items', string $route, WP_Post_Type $post_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | REST route |
| `$post_type` | WP_Post_Type | Post type object |

---

### rest_route_for_term

Filters REST route for a term.

```php
apply_filters( 'rest_route_for_term', string $route, WP_Term $term )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | REST route |
| `$term` | WP_Term | Term object |

---

### rest_route_for_taxonomy_items

Filters REST route for taxonomy collection.

```php
apply_filters( 'rest_route_for_taxonomy_items', string $route, WP_Taxonomy $taxonomy )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | REST route |
| `$taxonomy` | WP_Taxonomy | Taxonomy object |

---

### rest_queried_resource_route

Filters REST route for current query.

```php
apply_filters( 'rest_queried_resource_route', string $route )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | REST route |

---

## Miscellaneous Filters

### rest_send_nocache_headers

Filters whether to send no-cache headers.

```php
apply_filters( 'rest_send_nocache_headers', bool $send )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$send` | bool | Whether to send (default: `is_user_logged_in()`) |

---

### rest_avatar_sizes

Filters available avatar sizes.

```php
apply_filters( 'rest_avatar_sizes', int[] $sizes )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$sizes` | int[] | Avatar sizes (default `[24, 48, 96]`) |

---

### rest_request_parameter_order

Filters parameter priority order.

```php
apply_filters( 'rest_request_parameter_order', string[] $order, WP_REST_Request $request )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$order` | string[] | Parameter sources in priority order |
| `$request` | WP_REST_Request | Request object |

---

### rest_request_from_url

Filters request created from URL.

```php
apply_filters( 'rest_request_from_url', WP_REST_Request|false $request, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request\|false | Created request or false |
| `$url` | string | Source URL |

---

### rest_response_link_curies

Filters additional CURIEs for responses.

```php
apply_filters( 'rest_response_link_curies', array $additional )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additional` | array | Additional CURIE definitions |

---

### rest_get_max_batch_size

Filters maximum batch request size.

```php
apply_filters( 'rest_get_max_batch_size', int $max_size )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_size` | int | Maximum requests (default `25`) |

---

### wp_is_rest_endpoint

Filters whether current request is REST endpoint.

```php
apply_filters( 'wp_is_rest_endpoint', bool $is_rest_endpoint )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$is_rest_endpoint` | bool | Whether REST endpoint |

---

### wp_rest_server_class

Filters the REST server class name.

```php
apply_filters( 'wp_rest_server_class', string $class_name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | string | Server class (default `WP_REST_Server`) |

---

### wp_rest_search_handlers

Filters search handlers for the search endpoint.

```php
apply_filters( 'wp_rest_search_handlers', WP_REST_Search_Handler[] $handlers )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handlers` | WP_REST_Search_Handler[] | Search handlers |
