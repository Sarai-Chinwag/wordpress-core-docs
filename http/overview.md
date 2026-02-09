# WordPress HTTP API Overview

The WordPress HTTP API provides a standardized interface for making HTTP requests. It abstracts away the complexity of different PHP configurations and provides a consistent, secure way to communicate with external services.

## Architecture

```
wp_remote_*() functions
        ↓
   WP_Http class
        ↓
WpOrg\Requests\Requests (Requests library)
        ↓
  Transport Layer (cURL or Streams)
```

## Request Flow

### 1. Entry Point

All requests start via global functions:

```php
// Standard requests
wp_remote_request( $url, $args );
wp_remote_get( $url, $args );
wp_remote_post( $url, $args );
wp_remote_head( $url, $args );

// Safe requests (for user-controlled URLs)
wp_safe_remote_request( $url, $args );
wp_safe_remote_get( $url, $args );
wp_safe_remote_post( $url, $args );
wp_safe_remote_head( $url, $args );
```

### 2. WP_Http Singleton

Functions access a singleton `WP_Http` instance via `_wp_http_get_object()`:

```php
function _wp_http_get_object() {
    static $http = null;
    if ( is_null( $http ) ) {
        $http = new WP_Http();
    }
    return $http;
}
```

### 3. Request Processing

The `WP_Http::request()` method:

1. Merges arguments with defaults
2. Applies `http_request_args` filter
3. Checks `pre_http_request` filter for short-circuit
4. Validates URL (if `reject_unsafe_urls` is true)
5. Checks if request is blocked (`WP_HTTP_BLOCK_EXTERNAL`)
6. Configures SSL, proxy, cookies
7. Delegates to Requests library
8. Converts response to WordPress format
9. Applies `http_response` filter

### 4. Transport Selection

Since WordPress 4.6, the [Requests library](https://github.com/WordPress/Requests) handles transport selection:

| Priority | Transport | Requirements |
|----------|-----------|--------------|
| 1 | cURL | `curl_init()` and `curl_exec()` functions |
| 2 | PHP Streams | `stream_socket_client()` function |

The legacy `WP_Http_Curl` and `WP_Http_Streams` classes are deprecated as of WordPress 6.4.

## Response Format

Successful requests return an array:

```php
[
    'headers'       => CaseInsensitiveDictionary,  // Response headers
    'body'          => string,                      // Response body
    'response'      => [
        'code'    => int,                           // HTTP status code
        'message' => string,                        // Status message
    ],
    'cookies'       => WP_Http_Cookie[],            // Cookie objects
    'filename'      => string|null,                 // For streamed responses
    'http_response' => WP_HTTP_Requests_Response,   // Raw response object
]
```

Failed requests return a `WP_Error` object.

## Transports

### cURL Transport (WP_Http_Curl)

- **Deprecated**: 6.4.0
- Uses PHP's cURL extension
- Supports all HTTP methods
- Handles SSL verification
- Supports proxy authentication (including NTLM)
- Streams large responses efficiently

### Streams Transport (WP_Http_Streams)

- **Deprecated**: 6.4.0  
- Uses `stream_socket_client()`
- Fallback when cURL unavailable
- Supports SSL with OpenSSL
- Custom certificate validation

## Security Features

### URL Validation

The `wp_http_validate_url()` function protects against SSRF attacks:

- Only allows `http` and `https` protocols
- Blocks local/private IP ranges (unless explicitly allowed)
- Restricts ports to 80, 443, 8080 (configurable)
- Rejects URLs with credentials

```php
// Safe for user input
wp_safe_remote_get( $_POST['url'] );  // Validates URL

// Only for trusted URLs
wp_remote_get( 'https://api.example.com/data' );
```

### Request Blocking

Block all external requests via `wp-config.php`:

```php
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,*.github.com' );
```

### SSL Verification

SSL is verified by default using bundled CA certificates:

```php
wp_remote_get( $url, [
    'sslverify'       => true,                    // Default
    'sslcertificates' => '/path/to/ca-bundle.crt' // Custom CA
] );
```

## Caching

The HTTP API itself doesn't implement caching, but WordPress caches some requests:

### Transient-Based Caching Pattern

```php
function get_api_data() {
    $cache_key = 'my_api_data';
    $data = get_transient( $cache_key );
    
    if ( false === $data ) {
        $response = wp_remote_get( 'https://api.example.com/data' );
        
        if ( ! is_wp_error( $response ) ) {
            $data = wp_remote_retrieve_body( $response );
            set_transient( $cache_key, $data, HOUR_IN_SECONDS );
        }
    }
    
    return $data;
}
```

### HTTP Caching Headers

The API respects standard HTTP caching:

- `Cache-Control` headers
- `ETag` / `If-None-Match`
- `Last-Modified` / `If-Modified-Since`

Plugins can implement conditional requests:

```php
$response = wp_remote_get( $url, [
    'headers' => [
        'If-None-Match' => $stored_etag,
    ],
] );

if ( 304 === wp_remote_retrieve_response_code( $response ) ) {
    // Use cached version
}
```

## Compression

The API automatically handles compressed responses:

### Supported Encodings

| Encoding | Function | Priority |
|----------|----------|----------|
| deflate | `gzinflate()` | 1.0 |
| compress | `gzuncompress()` | 0.5 |
| gzip | `gzdecode()` | 0.5 |

### Automatic Decompression

```php
// Decompress is enabled by default
wp_remote_get( $url, [
    'decompress' => true,  // Default
] );

// Disable to get raw compressed data
wp_remote_get( $url, [
    'decompress' => false,
] );
```

## Cookie Handling

Cookies are automatically parsed and made available:

```php
$response = wp_remote_get( $url );
$cookies = wp_remote_retrieve_cookies( $response );

foreach ( $cookies as $cookie ) {
    echo $cookie->name . ': ' . $cookie->value;
}
```

Send cookies with requests:

```php
wp_remote_get( $url, [
    'cookies' => [
        'session_id' => 'abc123',
        new WP_Http_Cookie( [
            'name'    => 'auth',
            'value'   => 'token',
            'expires' => time() + 3600,
        ] ),
    ],
] );
```

## Proxy Support

Configure via `wp-config.php`:

```php
define( 'WP_PROXY_HOST', '192.168.1.100' );
define( 'WP_PROXY_PORT', '8080' );
define( 'WP_PROXY_USERNAME', 'user' );
define( 'WP_PROXY_PASSWORD', 'pass' );
define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, *.local' );
```

## Timeouts and Limits

```php
wp_remote_get( $url, [
    'timeout'             => 5,      // Seconds (default: 5)
    'redirection'         => 5,      // Max redirects (default: 5)
    'limit_response_size' => 1048576, // Bytes (1MB)
] );
```

## Streaming to File

For large downloads:

```php
wp_remote_get( $large_file_url, [
    'stream'   => true,
    'filename' => '/tmp/download.zip',
] );
```

## Non-Blocking Requests

Fire-and-forget requests:

```php
wp_remote_post( $webhook_url, [
    'blocking' => false,
    'body'     => [ 'event' => 'completed' ],
] );
// Returns immediately, no response body
```

## HTTP Status Code Constants

`WP_Http` provides status code constants:

```php
WP_Http::OK                    // 200
WP_Http::CREATED               // 201
WP_Http::MOVED_PERMANENTLY     // 301
WP_Http::FOUND                 // 302
WP_Http::NOT_MODIFIED          // 304
WP_Http::BAD_REQUEST           // 400
WP_Http::UNAUTHORIZED          // 401
WP_Http::FORBIDDEN             // 403
WP_Http::NOT_FOUND             // 404
WP_Http::INTERNAL_SERVER_ERROR // 500
// ... and many more
```

## Best Practices

1. **Use safe functions for user input**: Always use `wp_safe_remote_*()` for URLs from untrusted sources

2. **Set appropriate timeouts**: Don't use excessively long timeouts that could block execution

3. **Handle errors**: Always check for `WP_Error`:
   ```php
   $response = wp_remote_get( $url );
   if ( is_wp_error( $response ) ) {
       error_log( $response->get_error_message() );
       return;
   }
   ```

4. **Validate response codes**:
   ```php
   if ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
       // Handle non-200 response
   }
   ```

5. **Implement caching**: Use transients or object cache for repeated requests

6. **Don't disable SSL verification** in production:
   ```php
   // NEVER do this in production
   'sslverify' => false  // Security risk!
   ```

## Related Files

- `wp-includes/http.php` - API functions
- `wp-includes/class-wp-http.php` - Main class
- `wp-includes/class-wp-http-cookie.php` - Cookie handling
- `wp-includes/class-wp-http-encoding.php` - Compression
- `wp-includes/class-wp-http-proxy.php` - Proxy support
- `wp-includes/class-wp-http-response.php` - Response objects
- `wp-includes/Requests/` - Requests library
