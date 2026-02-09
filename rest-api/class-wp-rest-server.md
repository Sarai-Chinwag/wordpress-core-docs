# WP_REST_Server

Core class implementing the WordPress REST API server. Handles route registration, request dispatch, and response formatting.

**Source:** `wp-includes/rest-api/class-wp-rest-server.php`  
**Since:** 4.4.0

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `READABLE` | `'GET'` | GET transport method |
| `CREATABLE` | `'POST'` | POST transport method |
| `EDITABLE` | `'POST, PUT, PATCH'` | Writable methods |
| `DELETABLE` | `'DELETE'` | DELETE transport method |
| `ALLMETHODS` | `'GET, POST, PUT, PATCH, DELETE'` | All methods |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$namespaces` | array | protected | Namespaces registered to server |
| `$endpoints` | array | protected | Endpoints registered to server |
| `$route_options` | array | protected | Options for routes |
| `$embed_cache` | array | protected | Cache for embedded requests |
| `$dispatching_requests` | array | protected | Request stack being handled |

---

## Methods

### __construct()

Instantiates the REST server with default routes.

```php
public function __construct()
```

Registers default `/` (index) and `/batch/v1` endpoints.

---

### check_authentication()

Checks authentication headers.

```php
public function check_authentication(): WP_Error|null|true
```

**Returns:**
- `WP_Error` if authentication error
- `null` if no authentication method used
- `true` if authentication succeeded

Triggers `rest_authentication_errors` filter.

---

### serve_request()

Handles serving a REST API request.

```php
public function serve_request( string $path = null ): null|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$path` | string\|null | Request route. Default uses `$_SERVER['PATH_INFO']` |

**Returns:** `null` if served (or HEAD request), `false` on error.

**Flow:**
1. Sets up request from `$_SERVER`, `$_GET`, `$_POST`, `$_FILES`
2. Handles method override via `_method` param or `X-HTTP-Method-Override` header
3. Calls `check_authentication()`
4. Dispatches request
5. Applies `rest_post_dispatch` filter
6. Handles envelope (`_envelope` param)
7. Sends headers and JSON response

---

### response_to_data()

Converts a response to data for sending.

```php
public function response_to_data( WP_REST_Response $response, bool|string[] $embed ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Response object |
| `$embed` | bool\|string[] | Whether to embed links |

**Returns:** Array with `_links` and optionally `_embedded`.

---

### get_response_links() <small>(static)</small>

Extracts links from a response.

```php
public static function get_response_links( WP_REST_Response $response ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Response object |

**Returns:** Map of link relation to list of link hashes.

---

### get_compact_response_links() <small>(static)</small>

Gets links with CURIE-shortened relations.

```php
public static function get_compact_response_links( WP_REST_Response $response ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Response object |

**Returns:** Links with `wp:` prefixes for WordPress relations.

---

### envelope_response()

Wraps response in an envelope.

```php
public function envelope_response( WP_REST_Response $response, bool|string[] $embed ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | WP_REST_Response | Response to wrap |
| `$embed` | bool\|string[] | Embed setting |

**Returns:** Response with `body`, `status`, and `headers` data.

---

### register_route()

Registers a route to the server.

```php
public function register_route( string $route_namespace, string $route, array $route_args, bool $override = false ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route_namespace` | string | Namespace |
| `$route` | string | Route path |
| `$route_args` | array | Route arguments |
| `$override` | bool | Override existing route |

**Note:** Use `register_rest_route()` wrapper function instead.

---

### get_routes()

Retrieves the route map.

```php
public function get_routes( string $route_namespace = '' ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route_namespace` | string | Filter to specific namespace |

**Returns:** Map of route regex to handlers.

---

### get_namespaces()

Retrieves registered namespaces.

```php
public function get_namespaces(): string[]
```

**Returns:** Array of namespace strings.

---

### get_route_options()

Retrieves options for a route.

```php
public function get_route_options( string $route ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | Route pattern |

**Returns:** Route options or `null` if not found.

---

### dispatch()

Matches request to handler and calls it.

```php
public function dispatch( WP_REST_Request $request ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request | Request to dispatch |

**Returns:** Response from the matched callback.

**Flow:**
1. Applies `rest_pre_dispatch` filter
2. Matches request to route
3. Validates and sanitizes parameters
4. Calls `respond_to_request()`

---

### is_dispatching()

Checks if server is currently handling a request.

```php
public function is_dispatching(): bool
```

**Returns:** `true` during dispatch, `false` otherwise.

**Since:** 6.5.0

---

### match_request_to_handler() <small>(protected)</small>

Matches a request to its handler.

```php
protected function match_request_to_handler( WP_REST_Request $request ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request | Request object |

**Returns:** `array( $route, $handler )` or `WP_Error`.

**Error Codes:**
- `rest_no_route` — No matching route found (404)

---

### respond_to_request() <small>(protected)</small>

Dispatches request to the callback handler.

```php
protected function respond_to_request( WP_REST_Request $request, string $route, array $handler, WP_Error|null $response ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request | Request object |
| `$route` | string | Matched route regex |
| `$handler` | array | Matched handler |
| `$response` | WP_Error\|null | Pre-existing error |

**Returns:** Response from callback.

**Flow:**
1. `rest_request_before_callbacks` filter
2. Calls `permission_callback`
3. `rest_dispatch_request` filter
4. Calls `callback`
5. `rest_request_after_callbacks` filter

---

### get_index()

Retrieves the site index (root endpoint).

```php
public function get_index( WP_REST_Request $request ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request | Request object |

**Returns:** Response with site info, namespaces, routes, authentication.

---

### get_namespace_index()

Retrieves index for a namespace.

```php
public function get_namespace_index( WP_REST_Request $request ): WP_REST_Response|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request` | WP_REST_Request | Request with `namespace` param |

**Returns:** Response with namespace routes or error if not found.

---

### get_data_for_routes()

Retrieves publicly-visible data for routes.

```php
public function get_data_for_routes( array $routes, string $context = 'view' ): array[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$routes` | array | Routes to describe |
| `$context` | string | `view` or `help` |

**Returns:** Route data keyed by route.

---

### get_data_for_route()

Retrieves publicly-visible data for a single route.

```php
public function get_data_for_route( string $route, array $callbacks, string $context = 'view' ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | Route pattern |
| `$callbacks` | array | Route callbacks |
| `$context` | string | Data context |

**Returns:** Route data or `null` if hidden.

---

### serve_batch_request_v1()

Serves batch API requests.

```php
public function serve_batch_request_v1( WP_REST_Request $batch_request ): WP_REST_Response
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$batch_request` | WP_REST_Request | Batch request with `requests` array |

**Returns:** Response with `responses` array (207 Multi-Status).

**Request Format:**

```json
{
    "validation": "normal",
    "requests": [
        { "path": "/wp/v2/posts/1", "method": "PUT", "body": {}, "headers": {} }
    ]
}
```

**Validation Modes:**
- `normal` — Execute all, return individual results
- `require-all-validate` — Abort if any request fails validation

---

### send_header()

Sends an HTTP header.

```php
public function send_header( string $key, string $value ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |
| `$value` | string | Header value |

---

### send_headers()

Sends multiple HTTP headers.

```php
public function send_headers( array $headers ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$headers` | array | Map of header name to value |

---

### remove_header()

Removes an HTTP header.

```php
public function remove_header( string $key ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |

**Since:** 4.8.0

---

### get_raw_data() <small>(static)</small>

Retrieves raw request body.

```php
public static function get_raw_data(): string
```

**Returns:** Raw `php://input` contents.

---

### get_headers()

Extracts headers from `$_SERVER` array.

```php
public function get_headers( array $server ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$server` | array | Server variables |

**Returns:** Extracted headers.

Handles:
- `HTTP_*` prefixed headers
- `CONTENT_TYPE`, `CONTENT_LENGTH`, `CONTENT_MD5`
- `REDIRECT_HTTP_AUTHORIZATION` fallback

---

## Protected Methods

### error_to_response()

Converts `WP_Error` to response object.

```php
protected function error_to_response( WP_Error $error ): WP_REST_Response
```

---

### json_error()

Gets JSON error representation.

```php
protected function json_error( string $code, string $message, int|null $status = null ): string
```

---

### get_json_encode_options()

Gets JSON encoding options.

```php
protected function get_json_encode_options( WP_REST_Request $request ): int
```

Respects `_pretty` param for pretty printing.

---

### embed_links()

Embeds links into response data.

```php
protected function embed_links( array $data, bool|string[] $embed = true ): array
```

---

### get_json_last_error()

Gets last JSON encoding error message.

```php
protected function get_json_last_error(): false|string
```

---

### set_status()

Sends HTTP status code.

```php
protected function set_status( int $code ): void
```

---

### get_max_batch_size()

Gets maximum batch request size.

```php
protected function get_max_batch_size(): int
```

**Returns:** Default 25, filterable via `rest_get_max_batch_size`.

---

### add_active_theme_link_to_index()

Adds active theme link to index response.

```php
protected function add_active_theme_link_to_index( WP_REST_Response $response ): void
```

**Since:** 5.7.0

---

### add_site_logo_to_index()

Adds site logo to index response.

```php
protected function add_site_logo_to_index( WP_REST_Response $response ): void
```

**Since:** 5.8.0

---

### add_site_icon_to_index()

Adds site icon to index response.

```php
protected function add_site_icon_to_index( WP_REST_Response $response ): void
```

**Since:** 5.9.0

---

### add_image_to_index()

Adds image data to index response.

```php
protected function add_image_to_index( WP_REST_Response $response, int $image_id, string $type ): void
```

**Since:** 5.9.0

---

### get_target_hints_for_link() <small>(static)</small>

Gets target hints for a link.

```php
protected static function get_target_hints_for_link( array $link ): array|null
```

**Since:** 6.7.0
