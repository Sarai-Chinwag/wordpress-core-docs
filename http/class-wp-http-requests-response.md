# WP_HTTP_Requests_Response Class

Core wrapper object for a Requests library response for standardization.

**File:** `wp-includes/class-wp-http-requests-response.php`  
**Since:** 4.6.0

## Overview

`WP_HTTP_Requests_Response` extends `WP_HTTP_Response` and wraps the `WpOrg\Requests\Response` object from the Requests library. It provides a bridge between the Requests library and WordPress's HTTP API, standardizing the response format.

## Class Hierarchy

```
WP_HTTP_Response
    └── WP_HTTP_Requests_Response
```

## Class Definition

```php
class WP_HTTP_Requests_Response extends WP_HTTP_Response {
    protected $response;   // WpOrg\Requests\Response
    protected $filename;   // string|null
}
```

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$response` | `WpOrg\Requests\Response` | protected | The wrapped Requests response object |
| `$filename` | string\|null | protected | Filename if response was streamed to file |

## Constructor

```php
public function __construct( WpOrg\Requests\Response $response, string $filename = '' )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | `WpOrg\Requests\Response` | The Requests library response |
| `$filename` | string | Optional filename for streamed responses |

**Example:**

```php
// This is typically done internally by WP_Http::request()
$requests_response = WpOrg\Requests\Requests::request( $url, $headers, $data, $type, $options );
$wp_response = new WP_HTTP_Requests_Response( $requests_response, $filename );
```

## Methods

### get_response_object()

Retrieves the underlying Requests response object.

```php
public function get_response_object(): WpOrg\Requests\Response
```

**Example:**

```php
$response = wp_remote_get( $url );

if ( ! is_wp_error( $response ) && isset( $response['http_response'] ) ) {
    $http_response = $response['http_response'];
    $requests_obj = $http_response->get_response_object();
    
    // Access Requests library features
    echo $requests_obj->url;           // Final URL (after redirects)
    echo $requests_obj->protocol_version;  // HTTP version
}
```

---

### get_headers()

Retrieves headers as a case-insensitive dictionary.

```php
public function get_headers(): WpOrg\Requests\Utility\CaseInsensitiveDictionary
```

**Returns:** Headers remain case-insensitive for access.

**Example:**

```php
$response = wp_remote_get( $url );
$http_response = $response['http_response'];

$headers = $http_response->get_headers();

// Case-insensitive access
echo $headers['content-type'];
echo $headers['Content-Type'];  // Same result
echo $headers['CONTENT-TYPE'];  // Same result

// Multiple values returned as array
$set_cookies = $headers['set-cookie'];
if ( is_array( $set_cookies ) ) {
    foreach ( $set_cookies as $cookie ) {
        echo $cookie . "\n";
    }
}
```

---

### set_headers()

Sets all header values.

```php
public function set_headers( array $headers ): void
```

Creates a new `WpOrg\Requests\Response\Headers` object from the array.

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
| `$replace` | bool | true | Replace existing header |

---

### get_status()

Retrieves the HTTP status code.

```php
public function get_status(): int
```

**Example:**

```php
$http_response = $response['http_response'];
$status = $http_response->get_status();  // 200, 404, etc.
```

---

### set_status()

Sets the HTTP status code.

```php
public function set_status( int $code ): void
```

---

### get_data()

Retrieves the response body.

```php
public function get_data(): string
```

**Example:**

```php
$http_response = $response['http_response'];
$body = $http_response->get_data();

// Parse as JSON
$data = json_decode( $body, true );
```

---

### set_data()

Sets the response body.

```php
public function set_data( string $data ): void
```

---

### get_cookies()

Retrieves cookies from the response.

```php
public function get_cookies(): WP_HTTP_Cookie[]
```

Converts Requests library cookies to WordPress `WP_Http_Cookie` objects.

**Example:**

```php
$http_response = $response['http_response'];
$cookies = $http_response->get_cookies();

foreach ( $cookies as $cookie ) {
    echo $cookie->name . ' = ' . $cookie->value . "\n";
    echo "  Expires: " . ( $cookie->expires ?: 'session' ) . "\n";
    echo "  Path: " . $cookie->path . "\n";
    echo "  Domain: " . $cookie->domain . "\n";
}
```

---

### to_array()

Converts the response to a standard WordPress HTTP API response array.

```php
public function to_array(): array
```

**Returns:**

```php
[
    'headers'  => CaseInsensitiveDictionary,  // Response headers
    'body'     => string,                      // Response body
    'response' => [
        'code'    => int,                      // HTTP status code
        'message' => string,                   // Status message
    ],
    'cookies'  => WP_HTTP_Cookie[],            // Cookie objects
    'filename' => string|null,                 // Streamed filename
]
```

This is the format returned by `wp_remote_*()` functions.

**Example:**

```php
// Internal usage in WP_Http::request()
$http_response = new WP_HTTP_Requests_Response( $requests_response, $filename );
$response = $http_response->to_array();

// Add the object reference
$response['http_response'] = $http_response;

return $response;
```

---

## Usage Examples

### Accessing the Underlying Response

```php
function get_final_url( $url ) {
    $response = wp_remote_get( $url, [
        'redirection' => 5,
    ] );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    // Get the Requests response object
    $http_response = $response['http_response'];
    $requests_obj = $http_response->get_response_object();
    
    // The final URL after redirects
    return $requests_obj->url;
}
```

### Working with Response History

```php
function get_redirect_chain( $url ) {
    $response = wp_remote_get( $url, [
        'redirection' => 10,
    ] );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    $requests_obj = $response['http_response']->get_response_object();
    
    $chain = [ $url ];
    
    // History contains previous responses in redirect chain
    foreach ( $requests_obj->history as $previous ) {
        $chain[] = $previous->url;
    }
    
    $chain[] = $requests_obj->url;  // Final URL
    
    return array_unique( $chain );
}
```

### Checking Response Properties

```php
function analyze_response( $response ) {
    if ( is_wp_error( $response ) || ! isset( $response['http_response'] ) ) {
        return null;
    }
    
    $http_response = $response['http_response'];
    $requests_obj = $http_response->get_response_object();
    
    return [
        'status_code'      => $http_response->get_status(),
        'headers_count'    => count( $http_response->get_headers() ),
        'body_size'        => strlen( $http_response->get_data() ),
        'cookies_count'    => count( $http_response->get_cookies() ),
        'final_url'        => $requests_obj->url,
        'protocol_version' => $requests_obj->protocol_version ?? 'unknown',
        'success'          => $requests_obj->success,
        'redirects'        => count( $requests_obj->history ),
    ];
}
```

### Comparing with Array Access

```php
$response = wp_remote_get( $url );

// Via http_response object
$http_response = $response['http_response'];
$status = $http_response->get_status();
$body = $http_response->get_data();
$headers = $http_response->get_headers();
$cookies = $http_response->get_cookies();

// Via array (same data, different access pattern)
$status = $response['response']['code'];
$body = $response['body'];
$headers = $response['headers'];
$cookies = $response['cookies'];
```

---

## Cookie Conversion

The class converts Requests cookies to WordPress format:

```php
public function get_cookies() {
    $cookies = [];
    
    foreach ( $this->response->cookies as $cookie ) {
        $cookies[] = new WP_Http_Cookie( [
            'name'      => $cookie->name,
            'value'     => urldecode( $cookie->value ),
            'expires'   => $cookie->attributes['expires'] ?? null,
            'path'      => $cookie->attributes['path'] ?? null,
            'domain'    => $cookie->attributes['domain'] ?? null,
            'host_only' => $cookie->flags['host-only'] ?? null,
        ] );
    }
    
    return $cookies;
}
```

---

## Status Message Lookup

The `to_array()` method uses `get_status_header_desc()` to get human-readable status messages:

```php
'response' => [
    'code'    => $this->get_status(),
    'message' => get_status_header_desc( $this->get_status() ),
]

// Examples:
// 200 -> 'OK'
// 404 -> 'Not Found'
// 500 -> 'Internal Server Error'
```

---

## Relationship to WP_Http

In `WP_Http::request()`:

```php
try {
    $requests_response = WpOrg\Requests\Requests::request( 
        $url, $headers, $data, $type, $options 
    );
    
    // Wrap in WordPress response object
    $http_response = new WP_HTTP_Requests_Response( 
        $requests_response, 
        $parsed_args['filename'] 
    );
    
    // Convert to array format
    $response = $http_response->to_array();
    
    // Add reference to the object
    $response['http_response'] = $http_response;
    
} catch ( WpOrg\Requests\Exception $e ) {
    $response = new WP_Error( 'http_request_failed', $e->getMessage() );
}
```

---

## When to Use

**Use the array format (`$response['body']`, etc.) when:**
- Simple data access
- Working with existing code
- You only need body, status, and headers

**Use the object (`$response['http_response']`) when:**
- Need access to redirect history
- Want the final URL after redirects
- Need raw Requests library features
- Working with response protocol details
