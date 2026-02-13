# WpOrg\Requests\Transport\Curl & WpOrg\Requests\Transport (Interface)

cURL-based HTTP transport with support for single and parallel (multi-handle) requests.

**Source:** `wp-includes/Requests/src/Transport/Curl.php`, `wp-includes/Requests/src/Transport.php`  
**Namespace:** `WpOrg\Requests\Transport`  
**Implements:** `WpOrg\Requests\Transport`  
**Declared:** `final class Curl`

---

## Transport Interface

```php
interface Transport {
    public function request( string $url, array $headers = [], string|array $data = [], array $options = [] ): string;
    public function request_multiple( array $requests, array $options ): array;
    public static function test( array $capabilities = [] ): bool;
}
```

| Method | Description |
|--------|-------------|
| `request()` | Perform a single request, return raw HTTP result |
| `request_multiple()` | Send multiple requests simultaneously |
| `test()` | Self-test whether the transport can be used for given capabilities |

---

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `CURL_7_10_5` | `0x070A05` | cURL 7.10.5 version number |
| `CURL_7_16_2` | `0x071002` | cURL 7.16.2 version number (millisecond timeout support) |

---

## Properties

### Public

| Property | Type | Description |
|----------|------|-------------|
| `$headers` | `string` | Raw HTTP header data |
| `$response_data` | `string` | Raw body data |
| `$info` | `array` | cURL info array (from `curl_getinfo()`) |
| `$version` | `int` | cURL version number |

### Private

| Property | Type | Description |
|----------|------|-------------|
| `$handle` | `resource\|CurlHandle` | cURL handle |
| `$hooks` | `Hooks` | Hook dispatcher |
| `$done_headers` | `bool` | Whether header parsing is complete |
| `$stream_handle` | `resource` | File pointer for streaming to file |
| `$response_bytes` | `int` | Bytes received so far |
| `$response_byte_limit` | `int\|bool` | Max bytes, or `false` for no limit |

---

## Methods

### __construct()

```php
public function __construct()
```

Initializes cURL handle with:
- `CURLOPT_HEADER` → `false`
- `CURLOPT_RETURNTRANSFER` → `1`
- `CURLOPT_ENCODING` → `''` (accept all encodings, cURL ≥ 7.10.5)
- `CURLOPT_PROTOCOLS` → `CURLPROTO_HTTP | CURLPROTO_HTTPS` (if available)
- `CURLOPT_REDIR_PROTOCOLS` → `CURLPROTO_HTTP | CURLPROTO_HTTPS` (if available)

---

### __destruct()

Closes the cURL handle if it's still a resource.

---

### request()

```php
public function request(
    string|Stringable $url,
    array $headers = [],
    string|array $data = [],
    array $options = []
): string
```

Perform a single request.

**Flow:**
1. Validates arguments
2. Calls `setup_handle()` to configure cURL options
3. Dispatches `curl.before_send` hook
4. Opens file stream if `$options['filename']` is set
5. Sets response byte limit from `$options['max_bytes']`
6. Configures SSL verification from `$options['verify']` and `$options['verifyname']`
7. Executes `curl_exec()`
8. On `CURLE_WRITE_ERROR` or `CURLE_BAD_CONTENT_ENCODING`, retries with encoding disabled
9. Calls `process_response()`
10. Clears header/write function callbacks (prevents GC issues)
11. Returns raw headers string

**Throws:**
- `InvalidArgument` for invalid parameter types
- `Exception` — On cURL errors (`curlerror`)
- `Exception` — On file open failure (`fopen`)

---

### request_multiple()

```php
public function request_multiple( array $requests, array $options ): array
```

Send multiple requests using cURL multi handles.

**Flow:**
1. Creates `curl_multi_init()` handle
2. For each request, creates a new `Curl` instance, gets sub-handle via `get_subrequest_handle()`
3. Dispatches `curl.before_multi_add` for each sub-handle
4. Adds all handles to multi handle
5. Dispatches `curl.before_multi_exec`
6. Loops `curl_multi_exec()` until all complete
7. For completed requests: dispatches `transport.internal.parse_response` or `transport.internal.parse_error`
8. Dispatches `multiple.request.complete` for each
9. Dispatches `curl.after_multi_exec`
10. Cleans up with `curl_multi_close()`

**Throws:** `InvalidArgument` for invalid parameter types.

---

### get_subrequest_handle()

```php
public function &get_subrequest_handle( string $url, array $headers, string|array $data, array $options ): resource|CurlHandle
```

Get the cURL handle configured for use in multi-request. Returns by reference. Sets up the handle, file streaming, and byte limits.

---

### process_response()

```php
public function process_response( string $response, array $options ): string|false
```

Process the response after cURL execution. Returns `false` for non-blocking requests. Throws on cURL errors. Dispatches `curl.after_request` hook with `&$headers` and `&$info`.

---

### stream_headers()

```php
public function stream_headers( resource|CurlHandle $handle, string $headers ): int
```

cURL header callback. Collects headers; resets on seeing `\r\n` (end of headers) to handle interim responses (e.g. `100 Continue`).

---

### stream_body()

```php
public function stream_body( resource|CurlHandle $handle, string $data ): int
```

cURL write callback. Dispatches `request.progress` hook. Enforces byte limit. Writes to stream handle (file) or `$response_data` (memory).

**Since:** 1.6.1

---

### test() (static)

```php
public static function test( array $capabilities = [] ): bool
```

Checks:
1. `curl_init()` and `curl_exec()` functions exist
2. If `Capability::SSL` requested, checks `CURL_VERSION_SSL` feature flag

---

## Private Methods

| Method | Description |
|--------|-------------|
| `setup_handle($url, $headers, $data, $options)` | Configures all cURL options: method, headers, timeouts, URL, user-agent, protocol version, streaming callbacks. Adds `Connection: close` and empty `Expect` header. Dispatches `curl.before_request`. |
| `format_get($url, $data)` | Appends query string data to URL |
| `get_expect_header($data)` | Returns `'100-Continue'` if data ≥ 1MB, empty string otherwise |

### setup_handle() Details

- **Expect header:** For HTTP/1.1, adds empty `Expect` header for requests < 1MB to avoid 1-second delay
- **Timeouts:** Minimum 1 second for cURL (DNS resolver uses `alarm()` with second resolution). Uses `CURLOPT_TIMEOUT_MS` for cURL ≥ 7.16.2 with non-integer timeouts.
- **Methods:** POST uses `CURLOPT_POST`; HEAD uses `CURLOPT_NOBODY`; others use `CURLOPT_CUSTOMREQUEST`
- **Data format:** `'query'` appends to URL; otherwise `http_build_query()` for arrays
