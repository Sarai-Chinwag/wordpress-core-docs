# WP_Http_Encoding Class

Core class used to implement deflate and gzip transfer encoding support for HTTP requests.

**File:** `wp-includes/class-wp-http-encoding.php`  
**Since:** 2.8.0

## Overview

`WP_Http_Encoding` handles compression and decompression of HTTP request/response bodies. It supports RFC 1950 (zlib), RFC 1951 (deflate), and RFC 1952 (gzip) encoding standards.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Http_Encoding {
    // All methods are static
}
```

## Methods

### compress()

Compress raw string using the deflate format (RFC 1951).

```php
public static function compress( string $raw, int $level = 9, string $supports = null ): string|false
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$raw` | string | - | String to compress |
| `$level` | int | 9 | Compression level (1-9, 9 is highest) |
| `$supports` | string | null | Not currently used |

**Returns:** Compressed string or `false` on failure.

**Example:**

```php
$data = 'This is some text to compress';
$compressed = WP_Http_Encoding::compress( $data );

// With different compression level (faster, less compression)
$compressed = WP_Http_Encoding::compress( $data, 1 );

// Highest compression (slower)
$compressed = WP_Http_Encoding::compress( $data, 9 );
```

---

### decompress()

Decompress a compressed string.

```php
public static function decompress( string $compressed, int $length = null ): string|false
```

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$compressed` | string | - | String to decompress |
| `$length` | int | null | Optional length hint (not used) |

**Attempts decompression in order:**
1. `gzinflate()` - RFC 1951 deflate
2. `compatible_gzinflate()` - Handles edge cases
3. `gzuncompress()` - RFC 1950 zlib
4. `gzdecode()` - RFC 1952 gzip

**Returns:** Decompressed string, or original string if decompression fails.

**Example:**

```php
// Automatically detects compression format
$decompressed = WP_Http_Encoding::decompress( $compressed_data );

// Safe to call on non-compressed data (returns as-is)
$text = WP_Http_Encoding::decompress( 'Not compressed' );
// Returns: 'Not compressed'
```

---

### compatible_gzinflate()

Decompression while staying compatible with various server implementations.

```php
public static function compatible_gzinflate( string $gz_data ): string|false
```

Handles edge cases where `gzinflate()` fails due to:
- Full gzip headers in data
- Java's `Deflater` output format
- Various server quirks

**Example:**

```php
// Usually called by decompress(), but can be used directly
$result = WP_Http_Encoding::compatible_gzinflate( $data );
```

---

### accept_encoding()

Determine which encoding types to accept and their priority.

```php
public static function accept_encoding( string $url, array $args ): string
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | Request URL |
| `$args` | array | Request arguments |

**Returns:** Comma-separated list with quality values, e.g., `"deflate;q=1.0, compress;q=0.5, gzip;q=0.5"`

**Compression is disabled when:**
- `$args['decompress']` is `false`
- `$args['stream']` is `true` (streaming to file)
- `$args['limit_response_size']` is set (partial content)

**Example:**

```php
$accept = WP_Http_Encoding::accept_encoding( $url, [
    'decompress' => true,
    'stream'     => false,
] );
// Returns: 'deflate;q=1.0, compress;q=0.5, gzip;q=0.5'

$accept = WP_Http_Encoding::accept_encoding( $url, [
    'decompress' => false,
] );
// Returns: '' (empty, no compression accepted)
```

**Filter:**

```php
/**
 * Filters the allowed encoding types.
 *
 * @param string[] $type Array of encoding types with priority values.
 * @param string   $url  URL of the HTTP request.
 * @param array    $args HTTP request arguments.
 */
apply_filters( 'wp_http_accept_encoding', $type, $url, $args );
```

---

### content_encoding()

Get the content encoding string for compressed outgoing data.

```php
public static function content_encoding(): string
```

**Returns:** `'deflate'`

**Example:**

```php
// When sending compressed data
$compressed = WP_Http_Encoding::compress( $body );
$headers = [
    'Content-Encoding' => WP_Http_Encoding::content_encoding(),
];
```

---

### should_decode()

Determine if content should be decoded based on headers.

```php
public static function should_decode( array|string $headers ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$headers` | array\|string | Response headers |

**Returns:** `true` if `Content-Encoding` header is present and not empty.

**Example:**

```php
// With array of headers
$should_decode = WP_Http_Encoding::should_decode( [
    'content-encoding' => 'gzip',
    'content-type'     => 'application/json',
] );
// Returns: true

// With header string
$should_decode = WP_Http_Encoding::should_decode( 
    "Content-Type: text/html\r\nContent-Encoding: deflate" 
);
// Returns: true

// No encoding
$should_decode = WP_Http_Encoding::should_decode( [
    'content-type' => 'text/html',
] );
// Returns: false
```

---

### is_available()

Check if compression/decompression is supported.

```php
public static function is_available(): bool
```

**Returns:** `true` if any of these functions exist:
- `gzuncompress()`
- `gzdeflate()`
- `gzinflate()`

**Example:**

```php
if ( WP_Http_Encoding::is_available() ) {
    // Compression is supported
}
```

---

## Usage in HTTP API

### Automatic Request Handling

The HTTP API automatically handles encoding:

```php
// In WP_Http::request()
$response = wp_remote_get( $url, [
    'decompress' => true,  // Default
] );

// Response body is automatically decompressed
$body = wp_remote_retrieve_body( $response );
```

### Manual Compression

```php
// Compress request body
$data = [ 'large' => str_repeat( 'data', 1000 ) ];
$json = wp_json_encode( $data );
$compressed = WP_Http_Encoding::compress( $json );

$response = wp_remote_post( $url, [
    'headers' => [
        'Content-Type'     => 'application/json',
        'Content-Encoding' => 'deflate',
    ],
    'body' => $compressed,
] );
```

### Disable Automatic Decompression

```php
$response = wp_remote_get( $url, [
    'decompress' => false,
] );

// Body may be compressed
$body = wp_remote_retrieve_body( $response );

// Check if decompression is needed
$headers = wp_remote_retrieve_headers( $response );
if ( WP_Http_Encoding::should_decode( $headers ) ) {
    $body = WP_Http_Encoding::decompress( $body );
}
```

---

## Supported Encoding Formats

| Format | RFC | Functions | Priority |
|--------|-----|-----------|----------|
| deflate | 1951 | `gzdeflate()`, `gzinflate()` | 1.0 |
| compress | 1950 | `gzcompress()`, `gzuncompress()` | 0.5 |
| gzip | 1952 | `gzencode()`, `gzdecode()` | 0.5 |

---

## Edge Cases Handled

### Gzip with Full Header

```php
// Data starting with gzip magic bytes
if ( str_starts_with( $gz_data, "\x1f\x8b\x08" ) ) {
    // Parse and strip gzip header
    // Then inflate the raw data
}
```

### Java Deflater Output

```php
// Java's Deflater adds 2-byte header
$decompressed = @gzinflate( substr( $gz_data, 2 ) );
```

### Server Variations

The `compatible_gzinflate()` method handles various server quirks documented in:
- https://core.trac.wordpress.org/ticket/18273
- PHP manual comments for `gzinflate()`

---

## Filter Examples

### Disable Specific Encodings

```php
add_filter( 'wp_http_accept_encoding', function( $types, $url, $args ) {
    // Remove gzip support
    return array_filter( $types, function( $type ) {
        return strpos( $type, 'gzip' ) === false;
    } );
}, 10, 3 );
```

### Disable All Compression

```php
add_filter( 'wp_http_accept_encoding', '__return_empty_array' );
```

### Custom Encoding Priority

```php
add_filter( 'wp_http_accept_encoding', function( $types, $url, $args ) {
    // Prefer gzip over deflate
    return [
        'gzip;q=1.0',
        'deflate;q=0.5',
    ];
}, 10, 3 );
```

---

## Debugging Compression

```php
function debug_encoding_support() {
    $functions = [
        'gzinflate'    => function_exists( 'gzinflate' ),
        'gzuncompress' => function_exists( 'gzuncompress' ),
        'gzdecode'     => function_exists( 'gzdecode' ),
        'gzdeflate'    => function_exists( 'gzdeflate' ),
        'gzcompress'   => function_exists( 'gzcompress' ),
        'gzencode'     => function_exists( 'gzencode' ),
    ];
    
    echo "Compression Support:\n";
    foreach ( $functions as $func => $available ) {
        echo "  {$func}: " . ( $available ? 'Yes' : 'No' ) . "\n";
    }
    
    echo "\nOverall: " . ( WP_Http_Encoding::is_available() ? 'Enabled' : 'Disabled' ) . "\n";
    
    echo "\nAccept-Encoding: " . WP_Http_Encoding::accept_encoding( 
        'https://example.com', 
        [ 'decompress' => true, 'stream' => false ] 
    ) . "\n";
}
```

---

## Performance Considerations

1. **Compression Level:** Higher levels (9) provide better compression but are slower. Level 6 is a good balance.

2. **Small Data:** Compression overhead may make small payloads larger. Only compress data over a few KB.

3. **Binary Data:** Pre-compressed data (images, videos) won't benefit from additional compression.

4. **CPU vs Bandwidth:** Compression trades CPU for bandwidth. On slow connections, compression helps; on fast local networks, it may not.
