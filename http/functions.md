# WordPress HTTP API Functions

## Request Functions

### wp_remote_request()

Performs an HTTP request and returns its response.

```php
wp_remote_request( string $url, array $args = array() ): array|WP_Error
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | The request URL |
| `$args` | array | Request arguments (see below) |

**Request Arguments:**

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `method` | string | `'GET'` | HTTP method: GET, POST, HEAD, PUT, DELETE, TRACE, OPTIONS, PATCH |
| `timeout` | float | `5` | Connection timeout in seconds |
| `redirection` | int | `5` | Number of allowed redirects |
| `httpversion` | string | `'1.0'` | HTTP protocol version: '1.0' or '1.1' |
| `user-agent` | string | WordPress UA | User-Agent header value |
| `reject_unsafe_urls` | bool | `false` | Validate URL with `wp_http_validate_url()` |
| `blocking` | bool | `true` | Wait for response |
| `headers` | array\|string | `[]` | Request headers |
| `cookies` | array | `[]` | Cookies to send |
| `body` | string\|array | `null` | Request body |
| `compress` | bool | `false` | Compress body when sending |
| `decompress` | bool | `true` | Decompress compressed responses |
| `sslverify` | bool | `true` | Verify SSL certificate |
| `sslcertificates` | string | CA bundle path | Path to SSL certificates |
| `stream` | bool | `false` | Stream response to file |
| `filename` | string | `null` | Filename for streamed response |
| `limit_response_size` | int | `null` | Max response size in bytes |

**Returns:** Array with response data or `WP_Error` on failure.

**Example:**

```php
$response = wp_remote_request( 'https://api.example.com/data', [
    'method'  => 'PUT',
    'headers' => [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type'  => 'application/json',
    ],
    'body'    => wp_json_encode( [ 'key' => 'value' ] ),
    'timeout' => 30,
] );

if ( is_wp_error( $response ) ) {
    echo 'Error: ' . $response->get_error_message();
} else {
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );
}
```

---

### wp_remote_get()

Performs an HTTP request using the GET method.

```php
wp_remote_get( string $url, array $args = array() ): array|WP_Error
```

**Example:**

```php
$response = wp_remote_get( 'https://api.example.com/posts' );

if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
    $posts = json_decode( wp_remote_retrieve_body( $response ), true );
}
```

---

### wp_remote_post()

Performs an HTTP request using the POST method.

```php
wp_remote_post( string $url, array $args = array() ): array|WP_Error
```

**Example:**

```php
$response = wp_remote_post( 'https://api.example.com/submit', [
    'body' => [
        'name'  => 'John Doe',
        'email' => 'john@example.com',
    ],
] );
```

**Sending JSON:**

```php
$response = wp_remote_post( 'https://api.example.com/data', [
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'body' => wp_json_encode( [
        'title'   => 'Hello World',
        'content' => 'Post content here',
    ] ),
] );
```

---

### wp_remote_head()

Performs an HTTP request using the HEAD method.

```php
wp_remote_head( string $url, array $args = array() ): array|WP_Error
```

**Note:** HEAD requests have `redirection` set to `0` by default.

**Example:**

```php
// Check if a resource exists without downloading it
$response = wp_remote_head( 'https://example.com/large-file.zip' );

if ( ! is_wp_error( $response ) ) {
    $status = wp_remote_retrieve_response_code( $response );
    $size   = wp_remote_retrieve_header( $response, 'content-length' );
    
    if ( 200 === $status ) {
        echo "File exists, size: {$size} bytes";
    }
}
```

---

## Safe Request Functions

These functions validate URLs to prevent SSRF attacks. Use them when the URL comes from user input.

### wp_safe_remote_request()

```php
wp_safe_remote_request( string $url, array $args = array() ): array|WP_Error
```

Sets `reject_unsafe_urls` to `true` automatically.

**Example:**

```php
// Safe for user-provided URLs
$user_url = sanitize_url( $_POST['webhook_url'] );
$response = wp_safe_remote_request( $user_url, [
    'method' => 'POST',
    'body'   => [ 'event' => 'test' ],
] );
```

---

### wp_safe_remote_get()

```php
wp_safe_remote_get( string $url, array $args = array() ): array|WP_Error
```

**Example:**

```php
// Fetch user-provided feed URL safely
$feed_url = sanitize_url( get_option( 'external_feed_url' ) );
$response = wp_safe_remote_get( $feed_url );
```

---

### wp_safe_remote_post()

```php
wp_safe_remote_post( string $url, array $args = array() ): array|WP_Error
```

---

### wp_safe_remote_head()

```php
wp_safe_remote_head( string $url, array $args = array() ): array|WP_Error
```

---

## Response Retrieval Functions

### wp_remote_retrieve_headers()

Retrieves headers from the response.

```php
wp_remote_retrieve_headers( array|WP_Error $response ): CaseInsensitiveDictionary|array
```

**Returns:** `CaseInsensitiveDictionary` (since 4.6.0) or empty array on error.

**Example:**

```php
$headers = wp_remote_retrieve_headers( $response );

// Access headers (case-insensitive)
echo $headers['content-type'];
echo $headers['Content-Type'];  // Same result

// Iterate headers
foreach ( $headers as $name => $value ) {
    echo "{$name}: {$value}\n";
}
```

---

### wp_remote_retrieve_header()

Retrieves a single header by name.

```php
wp_remote_retrieve_header( array|WP_Error $response, string $header ): array|string
```

**Returns:** Header value(s) or empty string if not found.

**Example:**

```php
$content_type = wp_remote_retrieve_header( $response, 'content-type' );
$etag         = wp_remote_retrieve_header( $response, 'etag' );

// Multiple values returned as array
$set_cookies = wp_remote_retrieve_header( $response, 'set-cookie' );
if ( is_array( $set_cookies ) ) {
    foreach ( $set_cookies as $cookie ) {
        // Process each Set-Cookie header
    }
}
```

---

### wp_remote_retrieve_response_code()

Retrieves the HTTP status code.

```php
wp_remote_retrieve_response_code( array|WP_Error $response ): int|string
```

**Returns:** Status code as integer, or empty string on error.

**Example:**

```php
$code = wp_remote_retrieve_response_code( $response );

switch ( $code ) {
    case 200:
        // Success
        break;
    case 401:
        // Unauthorized
        break;
    case 404:
        // Not found
        break;
    case 500:
        // Server error
        break;
}
```

---

### wp_remote_retrieve_response_message()

Retrieves the response status message.

```php
wp_remote_retrieve_response_message( array|WP_Error $response ): string
```

**Example:**

```php
$message = wp_remote_retrieve_response_message( $response );
// Returns: "OK", "Not Found", "Internal Server Error", etc.
```

---

### wp_remote_retrieve_body()

Retrieves the response body.

```php
wp_remote_retrieve_body( array|WP_Error $response ): string
```

**Example:**

```php
$body = wp_remote_retrieve_body( $response );

// Parse JSON
$data = json_decode( $body, true );
if ( json_last_error() === JSON_ERROR_NONE ) {
    // Valid JSON
}

// Parse XML
$xml = simplexml_load_string( $body );
```

---

### wp_remote_retrieve_cookies()

Retrieves all cookies from the response.

```php
wp_remote_retrieve_cookies( array|WP_Error $response ): WP_Http_Cookie[]
```

**Example:**

```php
$cookies = wp_remote_retrieve_cookies( $response );

foreach ( $cookies as $cookie ) {
    printf(
        "Cookie: %s = %s (expires: %s)\n",
        $cookie->name,
        $cookie->value,
        $cookie->expires ? date( 'Y-m-d', $cookie->expires ) : 'session'
    );
}
```

---

### wp_remote_retrieve_cookie()

Retrieves a single cookie by name.

```php
wp_remote_retrieve_cookie( array|WP_Error $response, string $name ): WP_Http_Cookie|string
```

**Example:**

```php
$session = wp_remote_retrieve_cookie( $response, 'session_id' );

if ( $session instanceof WP_Http_Cookie ) {
    echo "Session: " . $session->value;
}
```

---

### wp_remote_retrieve_cookie_value()

Retrieves just the value of a cookie by name.

```php
wp_remote_retrieve_cookie_value( array|WP_Error $response, string $name ): string
```

**Example:**

```php
$token = wp_remote_retrieve_cookie_value( $response, 'auth_token' );

if ( ! empty( $token ) ) {
    // Use the token
}
```

---

## Utility Functions

### wp_http_supports()

Checks if an HTTP transport supports specific capabilities.

```php
wp_http_supports( array $capabilities = array(), string $url = null ): bool
```

**Example:**

```php
// Check SSL support
if ( wp_http_supports( [ 'ssl' ] ) ) {
    // HTTPS requests are supported
}

// Check specific URL
if ( wp_http_supports( [], 'https://api.example.com' ) ) {
    // Can make requests to this URL
}
```

---

### wp_http_validate_url()

Validates a URL as safe for HTTP API use.

```php
wp_http_validate_url( string $url ): string|false
```

Blocks:
- Non-HTTP(S) protocols
- Malformed URLs
- URLs with credentials
- Private/local IP addresses (unless filtered)
- Non-standard ports (unless filtered)

**Example:**

```php
$url = wp_http_validate_url( $_POST['url'] );

if ( false === $url ) {
    wp_die( 'Invalid URL provided.' );
}
```

---

### wp_parse_url()

Wrapper for PHP's `parse_url()` with consistent behavior.

```php
wp_parse_url( string $url, int $component = -1 ): mixed
```

**Example:**

```php
$parts = wp_parse_url( 'https://user:pass@example.com:8080/path?query=1#hash' );
// Returns: [
//     'scheme'   => 'https',
//     'host'     => 'example.com',
//     'port'     => 8080,
//     'user'     => 'user',
//     'pass'     => 'pass',
//     'path'     => '/path',
//     'query'    => 'query=1',
//     'fragment' => 'hash',
// ]

$host = wp_parse_url( $url, PHP_URL_HOST );
```

---

## CORS Functions

### get_http_origin()

Gets the HTTP Origin of the current request.

```php
get_http_origin(): string
```

---

### get_allowed_http_origins()

Gets the list of allowed HTTP origins.

```php
get_allowed_http_origins(): string[]
```

---

### is_allowed_http_origin()

Checks if an origin is authorized.

```php
is_allowed_http_origin( string|null $origin = null ): string
```

---

### send_origin_headers()

Sends CORS headers if the request is from an allowed origin.

```php
send_origin_headers(): string|false
```

**Example:**

```php
// In a custom endpoint
add_action( 'init', function() {
    if ( isset( $_GET['my_api'] ) ) {
        $origin = send_origin_headers();
        
        if ( $origin ) {
            // CORS headers sent, proceed with response
        }
    }
} );
```

---

## Internal Functions

### _wp_http_get_object()

Returns the singleton `WP_Http` instance.

```php
_wp_http_get_object(): WP_Http
```

**Note:** This is a private function intended for internal use.

---

### allowed_http_request_hosts()

Filter callback that marks allowed redirect hosts as safe.

```php
allowed_http_request_hosts( bool $is_external, string $host ): bool
```

Attached to `http_request_host_is_external` filter.

---

### ms_allowed_http_request_hosts()

Filter callback for multisite that allows domains in the network.

```php
ms_allowed_http_request_hosts( bool $is_external, string $host ): bool
```

Attached to `http_request_host_is_external` filter in multisite.

---

## Complete Usage Examples

### Basic API Request

```php
function fetch_api_data( $endpoint ) {
    $url = 'https://api.example.com/' . ltrim( $endpoint, '/' );
    
    $response = wp_remote_get( $url, [
        'headers' => [
            'Accept' => 'application/json',
        ],
        'timeout' => 15,
    ] );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    $code = wp_remote_retrieve_response_code( $response );
    
    if ( 200 !== $code ) {
        return new WP_Error(
            'api_error',
            sprintf( 'API returned status %d', $code ),
            [ 'status' => $code ]
        );
    }
    
    $body = wp_remote_retrieve_body( $response );
    return json_decode( $body, true );
}
```

### POST with Authentication

```php
function create_remote_resource( $data ) {
    $response = wp_remote_post( 'https://api.example.com/resources', [
        'headers' => [
            'Authorization' => 'Bearer ' . get_option( 'api_token' ),
            'Content-Type'  => 'application/json',
        ],
        'body'    => wp_json_encode( $data ),
        'timeout' => 30,
    ] );
    
    if ( is_wp_error( $response ) ) {
        error_log( 'API Error: ' . $response->get_error_message() );
        return false;
    }
    
    $code = wp_remote_retrieve_response_code( $response );
    
    if ( 201 === $code ) {
        return json_decode( wp_remote_retrieve_body( $response ), true );
    }
    
    return false;
}
```

### File Download with Streaming

```php
function download_file( $url, $destination ) {
    $response = wp_remote_get( $url, [
        'stream'   => true,
        'filename' => $destination,
        'timeout'  => 300, // 5 minutes for large files
    ] );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        @unlink( $destination );
        return new WP_Error( 'download_failed', 'Download failed' );
    }
    
    return $destination;
}
```

### Handling Cookies Across Requests

```php
function api_session_request( $endpoint, $cookies = [] ) {
    $response = wp_remote_get( 'https://api.example.com/' . $endpoint, [
        'cookies' => $cookies,
    ] );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    // Get cookies for next request
    $new_cookies = wp_remote_retrieve_cookies( $response );
    
    return [
        'data'    => json_decode( wp_remote_retrieve_body( $response ), true ),
        'cookies' => $new_cookies,
    ];
}

// Usage
$result = api_session_request( 'login', [] );
$result = api_session_request( 'profile', $result['cookies'] );
```

### Caching with Transients

```php
function get_cached_api_data( $cache_key, $url, $expiration = HOUR_IN_SECONDS ) {
    $data = get_transient( $cache_key );
    
    if ( false !== $data ) {
        return $data;
    }
    
    $response = wp_remote_get( $url );
    
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return new WP_Error( 'api_error', 'Failed to fetch data' );
    }
    
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    set_transient( $cache_key, $data, $expiration );
    
    return $data;
}
```
