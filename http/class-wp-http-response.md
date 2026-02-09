# WP_HTTP_Response Class

Core class used to prepare HTTP responses.

**File:** `wp-includes/class-wp-http-response.php`  
**Since:** 4.4.0

## Overview

`WP_HTTP_Response` is a simple container class for HTTP response data. It's primarily used in the REST API for building responses before they're sent to the client. This is distinct from the response arrays returned by `wp_remote_*()` functions.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_HTTP_Response {
    public $data;
    public $headers;
    public $status;
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$data` | mixed | Response data (body content) |
| `$headers` | array | HTTP headers as key-value pairs |
| `$status` | int | HTTP status code |

## Constructor

```php
public function __construct( mixed $data = null, int $status = 200, array $headers = array() )
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$data` | mixed | null | Response body data |
| `$status` | int | 200 | HTTP status code |
| `$headers` | array | [] | HTTP headers |

**Example:**

```php
// Basic response
$response = new WP_HTTP_Response( 'Hello World' );

// With status code
$response = new WP_HTTP_Response( null, 204 );

// With headers
$response = new WP_HTTP_Response( 
    [ 'message' => 'Created' ], 
    201, 
    [ 'Location' => '/resource/123' ]
);
```

## Methods

### get_headers()

Retrieves headers associated with the response.

```php
public function get_headers(): array
```

**Example:**

```php
$response = new WP_HTTP_Response( $data, 200, [
    'Content-Type'  => 'application/json',
    'Cache-Control' => 'max-age=3600',
] );

$headers = $response->get_headers();
// [ 'Content-Type' => 'application/json', 'Cache-Control' => 'max-age=3600' ]
```

---

### set_headers()

Sets all header values (replaces existing).

```php
public function set_headers( array $headers ): void
```

**Example:**

```php
$response->set_headers( [
    'Content-Type'     => 'text/html',
    'X-Custom-Header'  => 'value',
] );
```

---

### header()

Sets a single HTTP header.

```php
public function header( string $key, string $value, bool $replace = true ): void
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$key` | string | - | Header name |
| `$value` | string | - | Header value |
| `$replace` | bool | true | Replace existing header of same name |

**Example:**

```php
$response = new WP_HTTP_Response();

// Set header (replaces if exists)
$response->header( 'Content-Type', 'application/json' );

// Append to existing header
$response->header( 'Vary', 'Accept', false );
$response->header( 'Vary', 'Accept-Encoding', false );
// Result: 'Vary: Accept, Accept-Encoding'
```

---

### get_status()

Retrieves the HTTP status code.

```php
public function get_status(): int
```

**Example:**

```php
$response = new WP_HTTP_Response( $data, 404 );
echo $response->get_status();  // 404
```

---

### set_status()

Sets the HTTP status code.

```php
public function set_status( int $code ): void
```

**Example:**

```php
$response = new WP_HTTP_Response();
$response->set_status( 201 );
```

---

### get_data()

Retrieves the response data.

```php
public function get_data(): mixed
```

**Example:**

```php
$response = new WP_HTTP_Response( [ 'id' => 123, 'name' => 'Test' ] );
$data = $response->get_data();
// [ 'id' => 123, 'name' => 'Test' ]
```

---

### set_data()

Sets the response data.

```php
public function set_data( mixed $data ): void
```

**Example:**

```php
$response = new WP_HTTP_Response();
$response->set_data( [
    'success' => true,
    'items'   => [ 1, 2, 3 ],
] );
```

---

### jsonSerialize()

Retrieves response data for JSON serialization.

```php
public function jsonSerialize(): mixed
```

By default, returns the same as `get_data()`. Override in subclasses for custom JSON handling.

**Example:**

```php
$response = new WP_HTTP_Response( [ 'key' => 'value' ] );
echo json_encode( $response );  // '{"key":"value"}'
```

---

## Usage Examples

### Basic REST API Response

```php
function my_rest_endpoint( WP_REST_Request $request ) {
    $data = get_some_data();
    
    return new WP_HTTP_Response( $data, 200, [
        'X-Custom-Header' => 'value',
    ] );
}
```

### Building Response with Fluent Interface

```php
function create_resource( $data ) {
    $response = new WP_HTTP_Response();
    
    $response->set_status( 201 );
    $response->set_data( [ 'id' => 123, 'created' => true ] );
    $response->header( 'Location', '/resource/123' );
    $response->header( 'Content-Type', 'application/json' );
    
    return $response;
}
```

### Error Response

```php
function handle_error( $error_code, $message ) {
    return new WP_HTTP_Response( 
        [
            'code'    => $error_code,
            'message' => $message,
        ], 
        400,
        [ 'Content-Type' => 'application/json' ]
    );
}
```

### Conditional Response

```php
function get_resource( $id ) {
    $resource = find_resource( $id );
    
    if ( ! $resource ) {
        return new WP_HTTP_Response( 
            [ 'error' => 'Not found' ], 
            404 
        );
    }
    
    return new WP_HTTP_Response( $resource, 200 );
}
```

### Caching Headers

```php
function cacheable_response( $data ) {
    $response = new WP_HTTP_Response( $data );
    
    $response->header( 'Cache-Control', 'public, max-age=3600' );
    $response->header( 'ETag', md5( serialize( $data ) ) );
    $response->header( 'Last-Modified', gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
    
    return $response;
}
```

### Streaming Response

```php
function download_file( $file_path ) {
    $response = new WP_HTTP_Response();
    
    $response->set_data( file_get_contents( $file_path ) );
    $response->set_status( 200 );
    $response->header( 'Content-Type', 'application/octet-stream' );
    $response->header( 'Content-Disposition', 'attachment; filename="' . basename( $file_path ) . '"' );
    $response->header( 'Content-Length', filesize( $file_path ) );
    
    return $response;
}
```

---

## Extending the Class

```php
class My_JSON_Response extends WP_HTTP_Response {
    public function __construct( $data = null, $status = 200 ) {
        parent::__construct( $data, $status, [
            'Content-Type' => 'application/json; charset=utf-8',
        ] );
    }
    
    public function jsonSerialize() {
        return [
            'success' => $this->status >= 200 && $this->status < 300,
            'data'    => $this->data,
        ];
    }
}

// Usage
$response = new My_JSON_Response( [ 'id' => 123 ], 200 );
echo json_encode( $response );
// '{"success":true,"data":{"id":123}}'
```

---

## Relationship to Other Classes

### WP_HTTP_Requests_Response

`WP_HTTP_Requests_Response` extends `WP_HTTP_Response` and wraps the Requests library's response object. It's used internally by `WP_Http::request()`.

```
WP_HTTP_Response (base class)
    └── WP_HTTP_Requests_Response (wraps Requests\Response)
```

### WP_REST_Response

In the REST API, `WP_REST_Response` extends `WP_HTTP_Response` with additional features:

```
WP_HTTP_Response
    └── WP_REST_Response (adds links, matched_route, etc.)
```

---

## Common Status Codes

| Code | Meaning | Use Case |
|------|---------|----------|
| 200 | OK | Successful GET, PUT, PATCH |
| 201 | Created | Successful POST that creates resource |
| 204 | No Content | Successful DELETE |
| 301 | Moved Permanently | Permanent redirect |
| 302 | Found | Temporary redirect |
| 304 | Not Modified | Cache validation (If-None-Match) |
| 400 | Bad Request | Invalid input |
| 401 | Unauthorized | Authentication required |
| 403 | Forbidden | Permission denied |
| 404 | Not Found | Resource doesn't exist |
| 405 | Method Not Allowed | Wrong HTTP method |
| 409 | Conflict | Resource conflict |
| 422 | Unprocessable Entity | Validation error |
| 429 | Too Many Requests | Rate limited |
| 500 | Internal Server Error | Server error |
| 503 | Service Unavailable | Maintenance/overload |
