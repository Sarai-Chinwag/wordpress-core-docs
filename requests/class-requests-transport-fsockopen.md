# WpOrg\Requests\Transport\Fsockopen

Socket-based HTTP transport using `stream_socket_client()`. Serves as the fallback when cURL is unavailable.

**Source:** `wp-includes/Requests/src/Transport/Fsockopen.php`  
**Namespace:** `WpOrg\Requests\Transport`  
**Implements:** `WpOrg\Requests\Transport`  
**Declared:** `final class Fsockopen`

---

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `SECOND_IN_MICROSECONDS` | `1000000` | Conversion factor for `stream_set_timeout()` |

---

## Properties

### Public

| Property | Type | Description |
|----------|------|-------------|
| `$headers` | `string` | Raw HTTP data (headers + body after processing) |
| `$info` | `array` | Stream metadata from `stream_get_meta_data()` |

### Private

| Property | Type | Description |
|----------|------|-------------|
| `$max_bytes` | `int\|bool` | Response byte limit, or `false` |
| `$connect_error` | `string` | Cached connection error messages |

---

## Methods

### request()

```php
public function request(
    string|Stringable $url,
    array $headers = [],
    string|array $data = [],
    array $options = []
): string
```

Perform an HTTP request via `stream_socket_client()`.

**Flow:**

1. Validates arguments
2. Dispatches `fsockopen.before_request`
3. Parses URL, creates stream context
4. **HTTPS:** Configures SSL context options:
   - `verify_peer` → `true` (default)
   - `capture_peer_cert` → `true`
   - SNI enabled if `OPENSSL_TLSEXT_SERVER_NAME` defined
   - Custom CA file from `$options['verify']`
   - Peer name verification from `$options['verifyname']`
5. Dispatches `fsockopen.remote_socket` hook with `&$remote_socket`
6. Connects via `stream_socket_client()` with connection timeout
7. For HTTPS, verifies certificate against hostname via `verify_certificate_from_context()`
8. Formats request line and data based on `data_format`
9. Dispatches `fsockopen.remote_host_path` hook
10. Builds raw HTTP request: method line, Host, User-Agent, Accept-Encoding, custom headers
11. Dispatches `fsockopen.after_headers`, `fsockopen.before_send`
12. Writes to socket via `fwrite()`
13. Dispatches `fsockopen.after_send`
14. For non-blocking: closes socket, returns empty string
15. Sets stream timeout (supports fractional seconds via microseconds)
16. Reads response in `BUFFER_SIZE` chunks, splitting headers from body
17. Enforces `max_bytes` limit on body
18. Supports streaming to file via `$options['filename']`
19. Dispatches `fsockopen.after_request` with `&$headers, &$info`

**Throws:**
- `InvalidArgument` for invalid parameter types
- `Exception` — Invalid URL (`invalidurl`)
- `Exception` — Connection failure (`fsockopen.connect_error` or `fsockopenerror`)
- `Exception` — Socket timeout (`timeout`)
- `Exception` — SSL mismatch (`ssl.no_match`)
- `Exception` — File open failure (`fopen`)

**Auto-added headers** (if not already set):
- `Host` (with port if non-standard)
- `User-Agent` (from options)
- `Accept-Encoding` (deflate, compress, gzip with quality values)
- `Content-Length` (for POST or non-empty body)
- `Content-Type` → `application/x-www-form-urlencoded; charset=UTF-8`
- `Connection: Close`

---

### request_multiple()

```php
public function request_multiple( array $requests, array $options ): array
```

Send multiple requests **sequentially** (no parallel support). Creates a new `Fsockopen` instance per request, dispatches `transport.internal.parse_response` and `multiple.request.complete` hooks.

On exception, stores the `Exception` object as the response for that request ID.

**Throws:** `InvalidArgument` for invalid parameter types.

---

### test() (static)

```php
public static function test( array $capabilities = [] ): bool
```

Checks:
1. `fsockopen()` function exists
2. If `Capability::SSL` requested, checks `openssl` extension and `openssl_x509_parse()` function

---

### verify_certificate_from_context()

```php
public function verify_certificate_from_context( string $host, resource $context ): bool
```

Verify the SSL certificate against hostname using the stream context's peer certificate. PHP doesn't check Subject Alternative Names by default; this method uses `Ssl::verify_certificate()` to handle that.

**Throws:**
- `Exception` — No SSL options/peer cert available (`ssl.connect_error`)
- `Exception` — Certificate doesn't match hostname (`fsockopen.ssl.no_match`) — *via `Ssl::verify_certificate()`*

---

### connect_error_handler()

```php
public function connect_error_handler( int $errno, string $errstr ): bool
```

Custom error handler for `stream_socket_client()`. Captures `E_WARNING` and `E_NOTICE` messages into `$this->connect_error`. Returns `false` for other error types.

---

## Private Methods

| Method | Description |
|--------|-------------|
| `accept_encoding()` | Returns Accept-Encoding header value: `deflate;q=1.0, compress;q=0.5, gzip;q=0.5` based on available PHP functions |
| `format_get($url_parts, $data)` | Builds request path with query string from parsed URL parts and data |

---

## Differences from cURL Transport

| Feature | Curl | Fsockopen |
|---------|------|-----------|
| Parallel requests | True multi-handle parallelism | Sequential (one at a time) |
| SSL verification | Via cURL options (`CURLOPT_SSL_*`) | Via stream context + manual cert check |
| Compression | cURL handles automatically (`CURLOPT_ENCODING`) | Accept-Encoding header + Requests decompression |
| Timeout precision | Millisecond (cURL ≥ 7.16.2) | Microsecond via `stream_set_timeout()` |
| HTTP construction | cURL builds request internally | Manually constructs raw HTTP request text |
