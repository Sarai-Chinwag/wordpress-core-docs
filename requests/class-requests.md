# WpOrg\Requests\Requests

Main entry point for the Requests HTTP library. This is a purely static class — it cannot be instantiated.

**Source:** `wp-includes/Requests/src/Requests.php`  
**Namespace:** `WpOrg\Requests`  
**Type:** `final`-constructor static class

---

## Constants

### HTTP Method Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `POST` | `'POST'` | POST method |
| `PUT` | `'PUT'` | PUT method |
| `GET` | `'GET'` | GET method |
| `HEAD` | `'HEAD'` | HEAD method |
| `DELETE` | `'DELETE'` | DELETE method |
| `OPTIONS` | `'OPTIONS'` | OPTIONS method |
| `TRACE` | `'TRACE'` | TRACE method |
| `PATCH` | `'PATCH'` | PATCH method |

### Other Constants

| Constant | Value | Since | Description |
|----------|-------|-------|-------------|
| `BUFFER_SIZE` | `1160` | — | Default buffer size for reading streams |
| `VERSION` | `'2.0.11'` | — | Current library version |
| `OPTION_DEFAULTS` | *(array)* | 2.0.0 | Default option values (see [Overview](requests.md#default-options)) |
| `DEFAULT_TRANSPORTS` | *(array)* | 2.0.0 | Default transport classes: `[Curl::class, Fsockopen::class]` |

### OPTION_DEFAULTS Detail

```php
const OPTION_DEFAULTS = [
    'timeout'          => 10,
    'connect_timeout'  => 10,
    'useragent'        => 'php-requests/' . self::VERSION,
    'protocol_version' => 1.1,
    'redirected'       => 0,
    'redirects'        => 10,
    'follow_redirects' => true,
    'blocking'         => true,
    'type'             => self::GET,
    'filename'         => false,
    'auth'             => false,
    'proxy'            => false,
    'cookies'          => false,
    'max_bytes'        => false,
    'idn'              => true,
    'hooks'            => null,
    'transport'        => null,
    'verify'           => null,
    'verifyname'       => true,
];
```

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|-----------|-------------|
| `$transport` | `array` | `public static` | Selected transport name cache (keyed by serialized capabilities) |
| `$transports` | `array` | `protected static` | Registered transport classes |
| `$certificate_path` | `string` | `protected static` | Default certificate path (`src/../certificates/cacert.pem`) |

### Private Properties

| Property | Type | Description |
|----------|------|-------------|
| `$magic_compression_headers` | `array` | @since 2.0.0 — Gzip/zlib magic byte markers for decompression detection |

---

## Public Methods

### get()

```php
public static function get( string $url, array $headers = [], array $options = [] ): Response
```

Send a GET request. Delegates to `request()` with `$data = null` and `$type = self::GET`.

---

### head()

```php
public static function head( string $url, array $headers = [], array $options = [] ): Response
```

Send a HEAD request.

---

### delete()

```php
public static function delete( string $url, array $headers = [], array $options = [] ): Response
```

Send a DELETE request.

---

### trace()

```php
public static function trace( string $url, array $headers = [], array $options = [] ): Response
```

Send a TRACE request.

---

### post()

```php
public static function post( string $url, array $headers = [], array $data = [], array $options = [] ): Response
```

Send a POST request.

---

### put()

```php
public static function put( string $url, array $headers = [], array $data = [], array $options = [] ): Response
```

Send a PUT request.

---

### options()

```php
public static function options( string $url, array $headers = [], array $data = [], array $options = [] ): Response
```

Send an OPTIONS request.

---

### patch()

```php
public static function patch( string $url, array $headers, array $data = [], array $options = [] ): Response
```

Send a PATCH request. Note: `$headers` is **required** (not optional) because the RFC recommends sending an ETag.

---

### request()

```php
public static function request(
    string|Stringable $url,
    array $headers = [],
    array|null $data = [],
    string $type = self::GET,
    array $options = []
): Response
```

Main interface for HTTP requests. This is the core method all shorthand methods delegate to.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | `string\|Stringable` | URL to request |
| `$headers` | `array` | Extra headers |
| `$data` | `array\|null` | Data for query string (GET/HEAD) or body (POST) |
| `$type` | `string` | HTTP method (use class constants) |
| `$options` | `array` | Request options (see [Overview](requests.md#default-options)) |

**Returns:** `Response`

**Throws:**
- `InvalidArgument` — When `$url` is not string/Stringable
- `InvalidArgument` — When `$type` is not a string
- `InvalidArgument` — When `$options` is not an array
- `Exception` — On invalid (non-HTTP) URLs (`nonhttp`)

**Processing flow:**
1. Validates arguments
2. Sets `$options['type']` if empty
3. Merges with `get_default_options()`
4. Calls `set_defaults()` (normalizes auth, proxy, cookies, IDN)
5. Dispatches `requests.before_request` hook
6. Selects or creates transport (checks for SSL capability if HTTPS)
7. Calls `$transport->request()`
8. Dispatches `requests.before_parse` hook
9. Calls `parse_response()` for header/body splitting, decompression, redirects

---

### request_multiple()

```php
public static function request_multiple( array $requests, array $options = [] ): array
```

Send multiple HTTP requests simultaneously.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$requests` | `array` | Array of request data arrays with keys: `url` (required), `headers`, `data`, `type`, `cookies`, `options` |
| `$options` | `array` | Global options inherited by individual requests |

**Returns:** `array` — Array of `Response` objects (or `Exception` objects on failure)

**Additional option:** `complete` — callback called when each request completes, receives `(&$response, $id)`.

**Throws:**
- `InvalidArgument` — When `$requests` is not array/iterable with array access
- `InvalidArgument` — When `$options` is not an array

---

### has_capabilities()

```php
public static function has_capabilities( array $capabilities = [] ): bool
```

Check if a transport is available for the given capabilities.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$capabilities` | `array<string, bool>` | Capabilities to test, e.g. `[Capability::SSL => true]` |

**Returns:** `bool`

---

### add_transport()

```php
public static function add_transport( string $transport ): void
```

Register a custom transport class. Must implement `WpOrg\Requests\Transport`.

---

### get_certificate_path()

```php
public static function get_certificate_path(): string
```

Get the default certificate path.

---

### set_certificate_path()

```php
public static function set_certificate_path( string|Stringable|bool $path ): void
```

Set the default certificate path.

**Throws:** `InvalidArgument` — When `$path` is not string/Stringable/bool.

---

### flatten()

```php
public static function flatten( iterable $dictionary ): array
```

Convert a `key => value` array to a `['key: value']` array for headers.

**Throws:** `InvalidArgument` — When `$dictionary` is not iterable.

---

### decompress()

```php
public static function decompress( string $data ): string
```

Decompress gzip/deflate/compress encoded data. Attempts `gzdecode()`, `gzinflate()`, `compatible_gzinflate()`, then `gzuncompress()`. Returns original data if not compressed.

**Throws:** `InvalidArgument` — When `$data` is not a string.

---

### compatible_gzinflate()

```php
public static function compatible_gzinflate( string $gz_data ): string|bool
```

Decompression compatible with various server implementations. Handles gzip headers, Huffman encoding, and ZIP format.

**Since:** 1.6.0

**Throws:** `InvalidArgument` — When `$gz_data` is not a string.

---

### parse_multiple()

```php
public static function parse_multiple( string &$response, array $request ): void
```

Callback for `transport.internal.parse_response`. Converts raw HTTP response to `Response` object during multi-request processing. On failure, sets `$response` to an `Exception`.

---

## Protected Methods

| Method | Signature | Description |
|--------|-----------|-------------|
| `get_transport_class()` | `(array $capabilities = []): string` | Find a working transport class name. Results cached in `$transport`. Returns empty string if none found. |
| `get_transport()` | `(array $capabilities = []): Transport` | Get a transport instance. Throws `Exception('notransport')` if none found. |
| `get_default_options()` | `(bool $multirequest = false): array` | Returns `OPTION_DEFAULTS` with `verify` set to `$certificate_path`. Adds `complete => null` for multi-requests. |
| `set_defaults()` | `(&$url, &$headers, &$data, &$type, &$options): void` | Normalizes URL (HTTP-only check), creates `Hooks` if empty, converts auth/proxy/cookies arrays to objects, handles IDN, sets `data_format`. Throws on non-HTTP URLs. |
| `parse_response()` | `($headers, $url, $req_headers, $req_data, $options): Response` | Parses raw response: splits headers/body, decodes chunked transfer, decompresses, handles redirects (303→GET, relative URLs), manages redirect history. |
| `decode_chunked()` | `(string $data): string` | Decodes chunked transfer encoding per RFC 2616. |
