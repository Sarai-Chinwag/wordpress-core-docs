# WP_Http_Streams Class

Core class used to integrate PHP Streams as an HTTP transport.

**File:** `wp-includes/class-wp-http-streams.php`  
**Since:** 2.7.0  
**Since:** 3.7.0 - Combined with fsockopen transport, switched to `stream_socket_client()`  
**Deprecated:** 6.4.0 - Use `WP_Http` instead

## Overview

`WP_Http_Streams` provides HTTP transport using PHP's native stream functions. It serves as a fallback when cURL is unavailable and handles SSL connections via OpenSSL.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Http_Streams {
    // No persistent properties - all state is local to request()
}
```

## Methods

### request()

Send an HTTP request using PHP Streams.

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

---

### test()

Determines whether PHP Streams can be used for retrieving a URL.

```php
public static function test( array $args = array() ): bool
```

**Requirements:**
- `stream_socket_client()` function exists
- For SSL: OpenSSL extension loaded
- For SSL: `openssl_x509_parse()` function exists

**Filter:**

```php
/**
 * Filters whether streams can be used as a transport.
 *
 * @param bool  $use_class Whether the class can be used. Default true.
 * @param array $args      Request arguments.
 */
apply_filters( 'use_streams_transport', true, $args );
```

**Example:**

```php
// Check if streams transport is available
if ( WP_Http_Streams::test() ) {
    // Streams transport available
}

// Check with SSL requirement
if ( WP_Http_Streams::test( [ 'ssl' => true ] ) ) {
    // Streams with SSL support available
}
```

---

### verify_ssl_certificate()

Verifies the SSL certificate against hostnames.

```php
public static function verify_ssl_certificate( resource $stream, string $host ): bool
```

PHP's SSL verification only checks certificate validity, not hostname matching. This method verifies:
- subjectAltName DNS entries
- Common Name (CN) fallback
- Wildcard matching (*.example.com)
- IP address matching (if request is to IP)

**Example:**

```php
$context = stream_context_create( [
    'ssl' => [
        'verify_peer'       => true,
        'capture_peer_cert' => true,
    ],
] );

$stream = stream_socket_client( 'ssl://example.com:443', $errno, $errstr, 30, STREAM_CLIENT_CONNECT, $context );

if ( WP_Http_Streams::verify_ssl_certificate( $stream, 'example.com' ) ) {
    // Certificate is valid for this host
}
```

---

## Connection Flow

### 1. URL Parsing

```php
$parsed_url = parse_url( $url );
$connect_host = $parsed_url['host'];
$secure_transport = ( 'ssl' === $parsed_url['scheme'] || 'https' === $parsed_url['scheme'] );
$port = $parsed_url['port'] ?? ( $secure_transport ? 443 : 80 );
```

### 2. Host Resolution

```php
// Handle localhost IPv6 issues
if ( 'localhost' === strtolower( $connect_host ) ) {
    $connect_host = '127.0.0.1';
}

$connect_host = $secure_transport 
    ? 'ssl://' . $connect_host 
    : 'tcp://' . $connect_host;
```

### 3. Stream Context

```php
$context = stream_context_create( [
    'ssl' => [
        'verify_peer'       => $ssl_verify,
        'capture_peer_cert' => $ssl_verify,
        'SNI_enabled'       => true,
        'cafile'            => $sslcertificates,
        'allow_self_signed' => ! $ssl_verify,
    ],
] );
```

### 4. Connection

```php
$handle = stream_socket_client(
    $connect_host . ':' . $port,
    $connection_error,
    $connection_error_str,
    $connect_timeout,
    STREAM_CLIENT_CONNECT,
    $context
);
```

---

## SSL Verification

### Filter for Local SSL

```php
/**
 * Filters whether SSL should be verified for local HTTP API requests.
 *
 * @param bool|string $ssl_verify Whether to verify SSL or path to certificate.
 * @param string      $url        The request URL.
 */
apply_filters( 'https_local_ssl_verify', $ssl_verify, $url );
```

### Certificate Validation Process

1. Capture peer certificate via context option
2. Parse certificate with `openssl_x509_parse()`
3. Extract subjectAltName or CN
4. Match against requested hostname
5. Support wildcards for subdomains

```php
// Wildcard matching example
// Certificate: *.example.com
// Request to: api.example.com -> VALID
// Request to: sub.api.example.com -> INVALID (wildcards are single-level)
```

---

## Proxy Support

```php
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() && $proxy->send_through_proxy( $url ) ) {
    // Connect to proxy instead
    $handle = stream_socket_client(
        'tcp://' . $proxy->host() . ':' . $proxy->port(),
        // ...
    );
    
    // Full URL in request line for proxy
    $request_path = $url;
    
    // Add proxy authentication header
    if ( $proxy->use_authentication() ) {
        $headers .= $proxy->authentication_header() . "\r\n";
    }
}
```

---

## Request Construction

```php
// Build HTTP request
$headers = strtoupper( $method ) . ' ' . $request_path . ' HTTP/' . $httpversion . "\r\n";
$headers .= 'Host: ' . $host . ( $non_standard_port ? ':' . $port : '' ) . "\r\n";
$headers .= 'User-agent: ' . $user_agent . "\r\n";

foreach ( $custom_headers as $header => $value ) {
    $headers .= $header . ': ' . $value . "\r\n";
}

$headers .= "\r\n";

if ( $body ) {
    $headers .= $body;
}

fwrite( $handle, $headers );
```

---

## Response Handling

### Blocking Requests

```php
$response = '';
$body_started = false;

while ( ! feof( $handle ) && $keep_reading ) {
    $block = fread( $handle, $block_size );
    
    if ( ! $body_started && strpos( $response, "\r\n\r\n" ) ) {
        $body_started = true;
        // Split headers from body
    }
    
    // Handle size limits, streaming, etc.
}
```

### Non-Blocking Requests

```php
if ( ! $blocking ) {
    stream_set_blocking( $handle, 0 );
    fclose( $handle );
    
    return [
        'headers'  => [],
        'body'     => '',
        'response' => [ 'code' => false, 'message' => false ],
        'cookies'  => [],
    ];
}
```

---

## Streaming to File

```php
if ( $stream ) {
    $stream_handle = fopen( $filename, 'w+' );
    $bytes_written = 0;
    
    while ( ! feof( $handle ) && $keep_reading ) {
        $block = fread( $handle, $block_size );
        
        // Respect size limits
        if ( $limit_response_size && ( $bytes_written + strlen( $block ) ) > $limit_response_size ) {
            $block = substr( $block, 0, $limit_response_size - $bytes_written );
        }
        
        $written = fwrite( $stream_handle, $block );
        $bytes_written += $written;
        
        if ( $written !== strlen( $block ) ) {
            return new WP_Error( 'http_request_failed', 'Failed to write request to temporary file.' );
        }
    }
    
    fclose( $stream_handle );
}
```

---

## Chunked Transfer Decoding

The transport handles chunked responses:

```php
if ( isset( $headers['transfer-encoding'] ) && 'chunked' === $headers['transfer-encoding'] ) {
    $body = WP_Http::chunkTransferDecode( $body );
}
```

---

## Error Handling

### Connection Errors

```php
if ( false === $handle ) {
    // SSL connection failed with no error message
    if ( $secure_transport && 0 === $connection_error && '' === $connection_error_str ) {
        return new WP_Error( 
            'http_request_failed', 
            'The SSL certificate for the host could not be verified.' 
        );
    }
    
    return new WP_Error( 
        'http_request_failed', 
        $connection_error . ': ' . $connection_error_str 
    );
}
```

### SSL Verification Failure

```php
if ( $secure_transport && $ssl_verify && ! $proxy->is_enabled() ) {
    if ( ! self::verify_ssl_certificate( $handle, $host ) ) {
        return new WP_Error( 
            'http_request_failed', 
            'The SSL certificate for the host could not be verified.' 
        );
    }
}
```

---

## Timeout Configuration

```php
// Integer and microsecond components
$timeout  = (int) floor( $parsed_args['timeout'] );
$utimeout = 0;

if ( $timeout !== (int) $parsed_args['timeout'] ) {
    // Handle fractional seconds
    $utimeout = 1000000 * $parsed_args['timeout'] % 1000000;
}

// Minimum 1 second for connection
$connect_timeout = max( $timeout, 1 );

// Set stream timeout
stream_set_timeout( $handle, $timeout, $utimeout );
```

---

## Disabling Streams Transport

```php
// Force WordPress to use cURL transport instead
add_filter( 'use_streams_transport', '__return_false' );
```

---

## Comparison with cURL Transport

| Feature | Streams | cURL |
|---------|---------|------|
| Always Available | Yes | Requires extension |
| SSL Support | Requires OpenSSL | Native |
| Proxy Auth | Basic only | NTLM, Digest, Basic |
| Performance | Slightly slower | Generally faster |
| HTTP/2 | Not supported | Supported (if compiled) |
| Custom Certificates | Via context | Via options |

---

## WP_HTTP_Fsockopen Class

A deprecated alias class for backward compatibility:

```php
/**
 * @since 2.7.0
 * @deprecated 3.7.0 Use WP_HTTP::request() directly
 */
class WP_HTTP_Fsockopen extends WP_Http_Streams {
    // For backward compatibility
}
```

---

## Deprecation Notice

Since WordPress 6.4.0, this class is deprecated. Use `WP_Http` instead:

```php
// Deprecated
$streams = new WP_Http_Streams();
$response = $streams->request( $url, $args );

// Recommended
$response = wp_remote_request( $url, $args );
```

The class remains for:
1. Backward compatibility
2. Legacy code that instantiates the class directly
3. Custom transport implementations that extend it
