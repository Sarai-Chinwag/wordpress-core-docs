# WP_Http_Curl Class

Core class used to integrate cURL as an HTTP transport.

**File:** `wp-includes/class-wp-http-curl.php`  
**Since:** 2.7.0  
**Deprecated:** 6.4.0 - Use `WP_Http` instead

## Overview

`WP_Http_Curl` provides HTTP transport using PHP's cURL extension. Since WordPress 4.6, the Requests library handles transport selection, making this class largely deprecated. It remains for backward compatibility.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Http_Curl {
    private $headers = '';
    private $body = '';
    private $max_body_length = false;
    private $stream_handle = false;
    private $bytes_written_total = 0;
}
```

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$headers` | string | private | Temporary header storage during requests |
| `$body` | string | private | Temporary body storage during requests |
| `$max_body_length` | int\|false | private | Maximum response size |
| `$stream_handle` | resource\|false | private | File handle for streaming |
| `$bytes_written_total` | int | private | Total bytes written in current request |

## Methods

### request()

Send an HTTP request using cURL.

```php
public function request( string $url, string|array $args = array() ): array|WP_Error
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | The request URL |
| `$args` | string\|array | Request arguments |

**Default Arguments:**

```php
$defaults = [
    'method'      => 'GET',
    'timeout'     => 5,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking'    => true,
    'headers'     => [],
    'body'        => null,
    'cookies'     => [],
    'decompress'  => false,
    'stream'      => false,
    'filename'    => null,
];
```

**cURL Options Set:**

| Option | Value |
|--------|-------|
| `CURLOPT_CONNECTTIMEOUT` | Timeout (seconds) |
| `CURLOPT_TIMEOUT` | Timeout (seconds) |
| `CURLOPT_URL` | Request URL |
| `CURLOPT_RETURNTRANSFER` | true |
| `CURLOPT_SSL_VERIFYHOST` | 2 or false |
| `CURLOPT_SSL_VERIFYPEER` | SSL verify setting |
| `CURLOPT_CAINFO` | Certificate path |
| `CURLOPT_USERAGENT` | User-Agent string |
| `CURLOPT_FOLLOWLOCATION` | false (handled manually) |
| `CURLOPT_PROTOCOLS` | HTTP and HTTPS only |

---

### test()

Determines whether cURL can be used for retrieving a URL.

```php
public static function test( array $args = array() ): bool
```

**Requirements:**
- `curl_init()` function exists
- `curl_exec()` function exists
- For SSL: cURL SSL support enabled (`CURL_VERSION_SSL`)

**Filter:**

```php
/**
 * Filters whether cURL can be used as a transport.
 *
 * @param bool  $use_class Whether the class can be used. Default true.
 * @param array $args      Request arguments.
 */
apply_filters( 'use_curl_transport', true, $args );
```

**Example:**

```php
// Check if cURL is available
if ( WP_Http_Curl::test() ) {
    // cURL transport available
}

// Check with SSL requirement
if ( WP_Http_Curl::test( [ 'ssl' => true ] ) ) {
    // cURL with SSL support available
}
```

---

## Private Methods

### stream_headers()

Callback for cURL to capture response headers.

```php
private function stream_headers( resource $handle, string $headers ): int
```

Called by cURL via `CURLOPT_HEADERFUNCTION`. Appends each header line to `$this->headers`.

---

### stream_body()

Callback for cURL to capture response body.

```php
private function stream_body( resource $handle, string $data ): int
```

Called by cURL via `CURLOPT_WRITEFUNCTION`. Handles:
- Body size limiting
- Streaming to file
- Memory buffering

Returns bytes written. Returning less than `strlen($data)` causes `CURLE_WRITE_ERROR`.

---

## cURL Configuration Details

### HTTP Methods

```php
switch ( $method ) {
    case 'HEAD':
        curl_setopt( $handle, CURLOPT_NOBODY, true );
        break;
    case 'POST':
        curl_setopt( $handle, CURLOPT_POST, true );
        curl_setopt( $handle, CURLOPT_POSTFIELDS, $body );
        break;
    case 'PUT':
        curl_setopt( $handle, CURLOPT_CUSTOMREQUEST, 'PUT' );
        curl_setopt( $handle, CURLOPT_POSTFIELDS, $body );
        break;
    default:
        curl_setopt( $handle, CURLOPT_CUSTOMREQUEST, $method );
        if ( $body ) {
            curl_setopt( $handle, CURLOPT_POSTFIELDS, $body );
        }
}
```

### Proxy Configuration

```php
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() && $proxy->send_through_proxy( $url ) ) {
    curl_setopt( $handle, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
    curl_setopt( $handle, CURLOPT_PROXY, $proxy->host() );
    curl_setopt( $handle, CURLOPT_PROXYPORT, $proxy->port() );
    
    if ( $proxy->use_authentication() ) {
        curl_setopt( $handle, CURLOPT_PROXYAUTH, CURLAUTH_ANY );
        curl_setopt( $handle, CURLOPT_PROXYUSERPWD, $proxy->authentication() );
    }
}
```

### SSL Configuration

```php
if ( $ssl_verify ) {
    curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, 2 );
    curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, true );
    curl_setopt( $handle, CURLOPT_CAINFO, $sslcertificates );
} else {
    curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, false );
    curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );
}
```

---

## Action Hook

### http_api_curl

Fires before the cURL request is executed.

```php
/**
 * @param resource $handle      The cURL handle (passed by reference).
 * @param array    $parsed_args The HTTP request arguments.
 * @param string   $url         The request URL.
 */
do_action_ref_array( 'http_api_curl', [ &$handle, $parsed_args, $url ] );
```

**Example - Adding Custom cURL Options:**

```php
add_action( 'http_api_curl', function( $handle, $args, $url ) {
    // Add custom CA certificate
    if ( str_contains( $url, 'internal.example.com' ) ) {
        curl_setopt( $handle, CURLOPT_CAINFO, '/path/to/internal-ca.crt' );
    }
    
    // Enable verbose debugging
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        curl_setopt( $handle, CURLOPT_VERBOSE, true );
        curl_setopt( $handle, CURLOPT_STDERR, fopen( '/tmp/curl.log', 'a' ) );
    }
    
    // Force IPv4
    curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    
}, 10, 3 );
```

**Example - Client Certificate Authentication:**

```php
add_action( 'http_api_curl', function( $handle, $args, $url ) {
    if ( str_contains( $url, 'secure-api.example.com' ) ) {
        curl_setopt( $handle, CURLOPT_SSLCERT, '/path/to/client.crt' );
        curl_setopt( $handle, CURLOPT_SSLKEY, '/path/to/client.key' );
        curl_setopt( $handle, CURLOPT_SSLKEYPASSWD, 'key-password' );
    }
}, 10, 3 );
```

---

## Disabling cURL Transport

```php
// Force WordPress to use streams transport instead
add_filter( 'use_curl_transport', '__return_false' );
```

---

## Error Handling

The class handles various cURL errors:

```php
$curl_error = curl_errno( $handle );

// Write error (e.g., response size limit reached)
if ( CURLE_WRITE_ERROR === $curl_error ) {
    // Check if it was intentional (size limit)
    if ( $this->max_body_length === $bytes_written_total ) {
        // Expected - size limit reached
    } else {
        // Actual write error
        return new WP_Error( 'http_request_failed', 'Failed to write request' );
    }
}

// General curl error
if ( $curl_error ) {
    return new WP_Error( 'http_request_failed', curl_error( $handle ) );
}
```

---

## Non-Blocking Requests

For non-blocking requests, the class executes but doesn't wait for response:

```php
if ( ! $blocking ) {
    curl_exec( $handle );
    
    $curl_error = curl_error( $handle );
    if ( $curl_error ) {
        return new WP_Error( 'http_request_failed', $curl_error );
    }
    
    // Check for redirect loop
    if ( in_array( curl_getinfo( $handle, CURLINFO_HTTP_CODE ), [ 301, 302 ] ) ) {
        return new WP_Error( 'http_request_failed', 'Too many redirects.' );
    }
    
    return [
        'headers'  => [],
        'body'     => '',
        'response' => [ 'code' => false, 'message' => false ],
        'cookies'  => [],
    ];
}
```

---

## PHP 8.0+ Considerations

In PHP 8.0+, `curl_close()` has no effect (cURL handles are objects, not resources):

```php
if ( PHP_VERSION_ID < 80000 ) {
    curl_close( $handle );
}
```

---

## Comparison with Streams Transport

| Feature | cURL | Streams |
|---------|------|---------|
| SSL Support | Native | Requires OpenSSL |
| Proxy Auth | NTLM, Digest, Basic | Basic only |
| Performance | Generally faster | Slightly slower |
| HTTP/2 | Supported (if compiled) | Not supported |
| Availability | Requires extension | Always available |

---

## Deprecation Notice

Since WordPress 6.4.0, this class is deprecated. The Requests library (`WpOrg\Requests\Requests`) now handles transport selection internally. The class remains for:

1. Backward compatibility
2. The `http_api_curl` action hook (still functional)
3. Legacy code that instantiates the class directly

**Recommended approach:**

```php
// Don't do this (deprecated)
$curl = new WP_Http_Curl();
$response = $curl->request( $url, $args );

// Do this instead
$response = wp_remote_request( $url, $args );
// or
$http = new WP_Http();
$response = $http->request( $url, $args );
```
