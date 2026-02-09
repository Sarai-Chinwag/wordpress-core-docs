# WP_REST_Request

Core class implementing a REST request object. Contains request data passed to endpoint callbacks.

**Source:** `wp-includes/rest-api/class-wp-rest-request.php`  
**Since:** 4.4.0

Implements `ArrayAccess` for parameter access: `$request['param']` is equivalent to `$request->get_param('param')`.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$method` | string | protected | HTTP method |
| `$params` | array | protected | Parameters by source (URL, GET, POST, FILES, JSON, defaults) |
| `$headers` | array | protected | Request headers (lowercase keys) |
| `$body` | string | protected | Request body data |
| `$route` | string | protected | Matched route pattern |
| `$attributes` | array | protected | Route handler attributes |
| `$parsed_json` | bool | protected | Whether JSON has been parsed |
| `$parsed_body` | bool | protected | Whether body has been parsed |

---

## Methods

### __construct()

Creates a new request object.

```php
public function __construct( string $method = '', string $route = '', array $attributes = array() )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$method` | string | HTTP method |
| `$route` | string | Request route |
| `$attributes` | array | Route attributes |

---

## HTTP Method

### get_method()

Retrieves the HTTP method.

```php
public function get_method(): string
```

**Returns:** HTTP method (uppercase).

---

### set_method()

Sets the HTTP method.

```php
public function set_method( string $method ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$method` | string | HTTP method |

---

### is_method()

Checks if request uses a specific method.

```php
public function is_method( string $method ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$method` | string | Method to check |

**Returns:** `true` if method matches.

**Since:** 6.8.0

---

## Headers

### get_headers()

Retrieves all headers.

```php
public function get_headers(): array
```

**Returns:** Map of lowercase header name to values array.

---

### get_header()

Retrieves a single header value.

```php
public function get_header( string $key ): string|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name (case-insensitive) |

**Returns:** Comma-joined values, or `null` if not set.

---

### get_header_as_array()

Retrieves header values as array.

```php
public function get_header_as_array( string $key ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |

**Returns:** Array of values, or `null` if not set.

---

### set_header()

Sets a header value.

```php
public function set_header( string $key, string $value ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |
| `$value` | string | Header value |

---

### add_header()

Appends a value to a header.

```php
public function add_header( string $key, string $value ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |
| `$value` | string | Value to append |

---

### remove_header()

Removes a header.

```php
public function remove_header( string $key ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |

---

### set_headers()

Sets multiple headers.

```php
public function set_headers( array $headers, bool $override = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$headers` | array | Map of header name to value |
| `$override` | bool | Replace existing headers |

---

### canonicalize_header_name() <small>(static)</small>

Normalizes header name to lowercase with underscores.

```php
public static function canonicalize_header_name( string $key ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |

**Returns:** Normalized name.

**Note:** Treats `-` and `_` as equivalent per Apache/nginx behavior.

---

## Content Type

### get_content_type()

Retrieves parsed Content-Type header.

```php
public function get_content_type(): array|null
```

**Returns:** Array with keys:
- `value` — Full content type
- `type` — Main type (e.g., `application`)
- `subtype` — Subtype (e.g., `json`)
- `parameters` — Extra parameters

Or `null` if not set/invalid.

---

### is_json_content_type()

Checks if request has JSON Content-Type.

```php
public function is_json_content_type(): bool
```

**Returns:** `true` if `application/json` or similar.

**Since:** 5.6.0

---

## Parameters

### get_param()

Retrieves a parameter from any source.

```php
public function get_param( string $key ): mixed|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Parameter name |

**Returns:** Parameter value or `null`.

**Priority Order:** JSON → POST → GET → URL → defaults

---

### has_param()

Checks if a parameter exists.

```php
public function has_param( string $key ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Parameter name |

**Returns:** `true` if parameter exists (even if `null`).

**Since:** 5.3.0

---

### set_param()

Sets a parameter value.

```php
public function set_param( string $key, mixed $value ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Parameter name |
| `$value` | mixed | Parameter value |

Updates existing parameter in its original source, or adds to primary source.

---

### get_params()

Retrieves all merged parameters.

```php
public function get_params(): array
```

**Returns:** Map of parameter name to value.

---

### get_url_params()

Retrieves URL (route regex) parameters.

```php
public function get_url_params(): array
```

**Returns:** Parameters parsed from URL path.

---

### set_url_params()

Sets URL parameters.

```php
public function set_url_params( array $params ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | Parameter map |

---

### get_query_params()

Retrieves query string parameters (`$_GET`).

```php
public function get_query_params(): array
```

**Returns:** Query parameters.

---

### set_query_params()

Sets query parameters.

```php
public function set_query_params( array $params ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | Parameter map |

---

### get_body_params()

Retrieves body parameters (`$_POST`).

```php
public function get_body_params(): array
```

**Returns:** Body parameters.

---

### set_body_params()

Sets body parameters.

```php
public function set_body_params( array $params ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | Parameter map |

---

### get_file_params()

Retrieves file parameters (`$_FILES`).

```php
public function get_file_params(): array
```

**Returns:** File upload data.

---

### set_file_params()

Sets file parameters.

```php
public function set_file_params( array $params ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | File parameter map |

---

### get_default_params()

Retrieves default parameters from route registration.

```php
public function get_default_params(): array
```

**Returns:** Default parameter values.

---

### set_default_params()

Sets default parameters.

```php
public function set_default_params( array $params ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | Default values |

---

### get_json_params()

Retrieves JSON body parameters.

```php
public function get_json_params(): array
```

**Returns:** Parsed JSON data.

---

## Body

### get_body()

Retrieves raw request body.

```php
public function get_body(): string
```

**Returns:** Request body content.

---

### set_body()

Sets request body.

```php
public function set_body( string $data ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | string | Body content |

Resets JSON parsing state.

---

## Route

### get_route()

Retrieves matched route pattern.

```php
public function get_route(): string
```

**Returns:** Route regex pattern.

---

### set_route()

Sets the matched route.

```php
public function set_route( string $route ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | Route pattern |

---

### get_attributes()

Retrieves route handler attributes.

```php
public function get_attributes(): array
```

**Returns:** Handler options from registration.

---

### set_attributes()

Sets route attributes.

```php
public function set_attributes( array $attributes ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$attributes` | array | Handler attributes |

---

## Validation

### sanitize_params()

Sanitizes all parameters.

```php
public function sanitize_params(): true|WP_Error
```

**Returns:** `true` if all valid, `WP_Error` with invalid params.

Uses `sanitize_callback` from route args, or `rest_parse_request_arg` for typed params.

**Error Codes:**
- `rest_invalid_param` — One or more parameters failed sanitization

---

### has_valid_params()

Validates parameters against route requirements.

```php
public function has_valid_params(): true|WP_Error
```

**Returns:** `true` if valid, `WP_Error` if missing/invalid params.

Checks:
1. JSON parsing errors
2. Required parameters
3. `validate_callback` for each arg
4. Global `validate_callback` on route

**Error Codes:**
- `rest_invalid_json` — Invalid JSON body
- `rest_missing_callback_param` — Required parameter missing
- `rest_invalid_param` — Parameter failed validation

---

## ArrayAccess Implementation

### offsetExists()

Checks if parameter exists.

```php
public function offsetExists( string $offset ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | string | Parameter name |

---

### offsetGet()

Retrieves a parameter.

```php
public function offsetGet( string $offset ): mixed|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | string | Parameter name |

---

### offsetSet()

Sets a parameter.

```php
public function offsetSet( string $offset, mixed $value ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | string | Parameter name |
| `$value` | mixed | Parameter value |

---

### offsetUnset()

Removes a parameter from all sources.

```php
public function offsetUnset( string $offset ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | string | Parameter name |

---

## Static Methods

### from_url()

Creates request from a full URL.

```php
public static function from_url( string $url ): WP_REST_Request|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | Full URL with query string |

**Returns:** Request object or `false` if URL couldn't be parsed.

**Since:** 4.5.0

**Example:**

```php
$request = WP_REST_Request::from_url( 'https://example.com/wp-json/wp/v2/posts?per_page=5' );
// Creates GET request to /wp/v2/posts with per_page=5
```

---

## Protected Methods

### get_parameter_order()

Gets priority order for parameter sources.

```php
protected function get_parameter_order(): string[]
```

**Returns:** `['JSON', 'POST', 'GET', 'URL', 'defaults']` (varies by method).

Filterable via `rest_request_parameter_order`.

---

### parse_json_params()

Parses JSON body into parameters.

```php
protected function parse_json_params(): true|WP_Error
```

**Returns:** `true` if parsed or not JSON, `WP_Error` if invalid JSON.

---

### parse_body_params()

Parses URL-encoded body.

```php
protected function parse_body_params(): void
```

Called automatically for non-POST requests with body.
