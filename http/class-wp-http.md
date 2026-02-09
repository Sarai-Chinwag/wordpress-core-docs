# WP_Http Class

Core class used for managing HTTP transports and making HTTP requests.

**File:** `wp-includes/class-wp-http.php`  
**Since:** 2.7.0

## Overview

`WP_Http` is the primary class for making outgoing HTTP requests in WordPress. It provides a consistent interface across different PHP configurations and delegates actual transport to the Requests library (since WordPress 4.6).

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Http {
    // HTTP status code constants
    const HTTP_CONTINUE       = 100;
    const OK                  = 200;
    const CREATED             = 201;
    const MOVED_PERMANENTLY   = 301;
    const FOUND               = 302;
    const NOT_MODIFIED        = 304;
    const BAD_REQUEST         = 400;
    const UNAUTHORIZED        = 401;
    const FORBIDDEN           = 403;
    const NOT_FOUND           = 404;
    const INTERNAL_SERVER_ERROR = 500;
    // ... many more
}
```

## HTTP Status Code Constants

### Informational (1xx)

| Constant | Value | Description |
|----------|-------|-------------|
| `HTTP_CONTINUE` | 100 | Continue |
| `SWITCHING_PROTOCOLS` | 101 | Switching Protocols |
| `PROCESSING` | 102 | Processing |
| `EARLY_HINTS` | 103 | Early Hints |

### Successful (2xx)

| Constant | Value | Description |
|----------|-------|-------------|
| `OK` | 200 | OK |
| `CREATED` | 201 | Created |
| `ACCEPTED` | 202 | Accepted |
| `NON_AUTHORITATIVE_INFORMATION` | 203 | Non-Authoritative Information |
| `NO_CONTENT` | 204 | No Content |
| `RESET_CONTENT` | 205 | Reset Content |
| `PARTIAL_CONTENT` | 206 | Partial Content |
| `MULTI_STATUS` | 207 | Multi-Status |
| `IM_USED` | 226 | IM Used |

### Redirection (3xx)

| Constant | Value | Description |
|----------|-------|-------------|
| `MULTIPLE_CHOICES` | 300 | Multiple Choices |
| `MOVED_PERMANENTLY` | 301 | Moved Permanently |
| `FOUND` | 302 | Found |
| `SEE_OTHER` | 303 | See Other |
| `NOT_MODIFIED` | 304 | Not Modified |
| `USE_PROXY` | 305 | Use Proxy |
| `TEMPORARY_REDIRECT` | 307 | Temporary Redirect |
| `PERMANENT_REDIRECT` | 308 | Permanent Redirect |

### Client Error (4xx)

| Constant | Value | Description |
|----------|-------|-------------|
| `BAD_REQUEST` | 400 | Bad Request |
| `UNAUTHORIZED` | 401 | Unauthorized |
| `PAYMENT_REQUIRED` | 402 | Payment Required |
| `FORBIDDEN` | 403 | Forbidden |
| `NOT_FOUND` | 404 | Not Found |
| `METHOD_NOT_ALLOWED` | 405 | Method Not Allowed |
| `NOT_ACCEPTABLE` | 406 | Not Acceptable |
| `REQUEST_TIMEOUT` | 408 | Request Timeout |
| `CONFLICT` | 409 | Conflict |
| `GONE` | 410 | Gone |
| `UNPROCESSABLE_ENTITY` | 422 | Unprocessable Entity |
| `TOO_MANY_REQUESTS` | 429 | Too Many Requests |
| `IM_A_TEAPOT` | 418 | I'm a teapot (RFC 2324) |

### Server Error (5xx)

| Constant | Value | Description |
|----------|-------|-------------|
| `INTERNAL_SERVER_ERROR` | 500 | Internal Server Error |
| `NOT_IMPLEMENTED` | 501 | Not Implemented |
| `BAD_GATEWAY` | 502 | Bad Gateway |
| `SERVICE_UNAVAILABLE` | 503 | Service Unavailable |
| `GATEWAY_TIMEOUT` | 504 | Gateway Timeout |
| `HTTP_VERSION_NOT_SUPPORTED` | 505 | HTTP Version Not Supported |

## Methods

### request()

Send an HTTP request to a URI.

```php
public function request( string $url, string|array $args = array() ): array|WP_Error
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | The request URL |
| `$args` | string\|array | Request arguments |

**Arguments:**

```php
$defaults = [
    'method'              => 'GET',
    'timeout'             => 5,
    'redirection'         => 5,
    'httpversion'         => '1.0',
    'user-agent'          => 'WordPress/X.X; https://example.com',
    'reject_unsafe_urls'  => false,
    'blocking'            => true,
    'headers'             => [],
    'cookies'             => [],
    'body'                => null,
    'compress'            => false,
    'decompress'          => true,
    'sslverify'           => true,
    'sslcertificates'     => ABSPATH . WPINC . '/certificates/ca-bundle.crt',
    'stream'              => false,
    'filename'            => null,
    'limit_response_size' => null,
];
```

**Return Value:**

```php
[
    'headers'       => \WpOrg\Requests\Utility\CaseInsensitiveDictionary,
    'body'          => string,
    'response'      => [
        'code'    => int|false,
        'message' => string|false,
    ],
    'cookies'       => WP_HTTP_Cookie[],
    'filename'      => string|null,
    'http_response' => WP_HTTP_Requests_Response|null,
]
```

**Example:**

```php
$http = new WP_Http();
$response = $http->request( 'https://api.example.com/data', [
    'method'  => 'POST',
    'headers' => [ 'Content-Type' => 'application/json' ],
    'body'    => '{"key":"value"}',
    'timeout' => 30,
] );
```

---

### get()

Uses the GET HTTP method.

```php
public function get( string $url, string|array $args = array() ): array|WP_Error
```

**Example:**

```php
$http = new WP_Http();
$response = $http->get( 'https://api.example.com/resource/123' );
```

---

### post()

Uses the POST HTTP method.

```php
public function post( string $url, string|array $args = array() ): array|WP_Error
```

**Example:**

```php
$http = new WP_Http();
$response = $http->post( 'https://api.example.com/resource', [
    'body' => [ 'name' => 'Test', 'value' => 42 ],
] );
```

---

### head()

Uses the HEAD HTTP method.

```php
public function head( string $url, string|array $args = array() ): array|WP_Error
```

**Example:**

```php
$http = new WP_Http();
$response = $http->head( 'https://example.com/file.zip' );
$size = $response['headers']['content-length'] ?? 'unknown';
```

---

### block_request()

Determines whether an HTTP API request to the given URL should be blocked.

```php
public function block_request( string $uri ): bool
```

**Configuration:** Controlled by `WP_HTTP_BLOCK_EXTERNAL` and `WP_ACCESSIBLE_HOSTS` constants.

**Example:**

```php
// In wp-config.php
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,*.github.com' );

// In code
$http = new WP_Http();
if ( $http->block_request( 'https://api.example.com' ) ) {
    // Request will be blocked
}
```

---

## Static Methods

### normalize_cookies()

Normalizes cookies for use with the Requests library.

```php
public static function normalize_cookies( array $cookies ): WpOrg\Requests\Cookie\Jar
```

**Example:**

```php
$cookies = [
    'session' => 'abc123',
    new WP_Http_Cookie( [ 'name' => 'auth', 'value' => 'token' ] ),
];

$jar = WP_Http::normalize_cookies( $cookies );
```

---

### browser_redirect_compatibility()

Match redirect behavior to browser handling. Changes 302 redirects from POST to GET.

```php
public static function browser_redirect_compatibility( 
    string $location, 
    array $headers, 
    string|array $data, 
    array &$options, 
    WpOrg\Requests\Response $original 
): void
```

Registered as a hook callback on `requests.before_redirect`.

---

### validate_redirects()

Validates redirected URLs when `reject_unsafe_urls` is enabled.

```php
public static function validate_redirects( string $location ): void
```

**Throws:** `WpOrg\Requests\Exception` on invalid URL.

---

### processResponse()

Parses the response and splits into headers and body.

```php
public static function processResponse( string $response ): array
```

**Returns:**

```php
[
    'headers' => string,  // Raw headers
    'body'    => string,  // Response body
]
```

---

### processHeaders()

Transforms header string into an array.

```php
public static function processHeaders( string|array $headers, string $url = '' ): array
```

**Returns:**

```php
[
    'response' => [
        'code'    => int,
        'message' => string,
    ],
    'headers'  => array,           // Parsed headers
    'cookies'  => WP_Http_Cookie[], // Cookie objects
]
```

**Example:**

```php
$raw_headers = "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nSet-Cookie: session=abc";
$parsed = WP_Http::processHeaders( $raw_headers );
// $parsed['headers']['content-type'] = 'text/html'
```

---

### buildCookieHeader()

Takes request arguments and builds the Cookie header from cookies array.

```php
public static function buildCookieHeader( array &$r ): void
```

Modifies the array by reference, adding `$r['headers']['cookie']`.

---

### chunkTransferDecode()

Decodes chunk transfer-encoding.

```php
public static function chunkTransferDecode( string $body ): string
```

**Example:**

```php
$decoded = WP_Http::chunkTransferDecode( $chunked_body );
```

---

### make_absolute_url()

Converts a relative URL to an absolute URL.

```php
public static function make_absolute_url( string $maybe_relative_path, string $url ): string
```

**Example:**

```php
$absolute = WP_Http::make_absolute_url( 
    '/api/data', 
    'https://example.com/path/' 
);
// Returns: https://example.com/api/data

$absolute = WP_Http::make_absolute_url( 
    '../images/logo.png', 
    'https://example.com/css/style.css' 
);
// Returns: https://example.com/images/logo.png
```

---

### handle_redirects()

Handles an HTTP redirect and follows it if appropriate.

```php
public static function handle_redirects( 
    string $url, 
    array $args, 
    array $response 
): array|false|WP_Error
```

**Returns:**
- Response array if redirect followed
- `false` if no redirect present
- `WP_Error` on error

---

### is_ip_address()

Determines if a string represents an IP address.

```php
public static function is_ip_address( string $maybe_ip ): int|false
```

**Returns:** `4` for IPv4, `6` for IPv6, `false` if not an IP.

**Example:**

```php
WP_Http::is_ip_address( '192.168.1.1' );    // Returns 4
WP_Http::is_ip_address( '::1' );             // Returns 6
WP_Http::is_ip_address( 'example.com' );     // Returns false
```

---

## Deprecated Methods

### _get_first_available_transport()

**Deprecated:** 6.4.0

```php
public function _get_first_available_transport( array $args, string $url = null ): string|false
```

Use `WpOrg\Requests\Requests::get_transport_class()` instead.

---

### _dispatch_request()

**Deprecated:** 5.1.0

```php
private function _dispatch_request( string $url, array $args ): array|WP_Error
```

Use `WP_Http::request()` directly.

---

### parse_url()

**Deprecated:** 4.4.0

```php
protected static function parse_url( string $url ): bool|array
```

Use `wp_parse_url()` instead.

---

## Usage Examples

### Direct Class Usage

```php
$http = new WP_Http();

// GET request
$response = $http->get( 'https://api.example.com/users' );

// POST with JSON
$response = $http->post( 'https://api.example.com/users', [
    'headers' => [ 'Content-Type' => 'application/json' ],
    'body'    => wp_json_encode( [ 'name' => 'John' ] ),
] );

// Check result
if ( ! is_wp_error( $response ) ) {
    $body = $response['body'];
    $code = $response['response']['code'];
}
```

### Using Status Code Constants

```php
$response = wp_remote_get( $url );
$code = wp_remote_retrieve_response_code( $response );

switch ( $code ) {
    case WP_Http::OK:
        // Handle success
        break;
    case WP_Http::NOT_FOUND:
        // Handle 404
        break;
    case WP_Http::UNAUTHORIZED:
        // Handle auth error
        break;
    case WP_Http::TOO_MANY_REQUESTS:
        // Handle rate limiting
        break;
}
```

### Handling Redirects Manually

```php
$response = wp_remote_get( $url, [
    'redirection' => 0,  // Disable auto-redirect
] );

$code = wp_remote_retrieve_response_code( $response );

if ( in_array( $code, [ 301, 302, 307, 308 ], true ) ) {
    $location = wp_remote_retrieve_header( $response, 'location' );
    $absolute = WP_Http::make_absolute_url( $location, $url );
    
    // Follow redirect manually
    $response = wp_remote_get( $absolute );
}
```

### Checking Request Blocking

```php
function can_reach_url( $url ) {
    $http = new WP_Http();
    
    if ( $http->block_request( $url ) ) {
        return new WP_Error( 
            'blocked', 
            'External requests are blocked for this URL' 
        );
    }
    
    return true;
}
```
