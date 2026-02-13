# WpOrg\Requests\Response

HTTP response object returned by `Requests::request()`.

**Source:** `wp-includes/Requests/src/Response.php`  
**Namespace:** `WpOrg\Requests`

---

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$body` | `string` | `''` | Response body |
| `$raw` | `string` | `''` | Raw HTTP data from the transport (headers + body) |
| `$headers` | `Response\Headers` | *(new Headers)* | Response headers as a case-insensitive dictionary |
| `$status_code` | `int\|bool` | `false` | HTTP status code, `false` if non-blocking |
| `$protocol_version` | `float\|bool` | `false` | HTTP protocol version (e.g. `1.1`), `false` if non-blocking |
| `$success` | `bool` | `false` | Whether the response is successful (2xx status) |
| `$redirects` | `int` | `0` | Number of redirects followed |
| `$url` | `string` | `''` | Final requested URL |
| `$history` | `array` | `[]` | Previous `Response` objects from redirects |
| `$cookies` | `Cookie\Jar` | *(new Jar)* | Cookies from the response |

---

## Methods

### __construct()

```php
public function __construct()
```

Creates a new Response with fresh `Headers` and `Jar` instances.

---

### is_redirect()

```php
public function is_redirect(): bool
```

Check if the response is a redirect. Returns `true` for status codes 300, 301, 302, 303, 307, and 308–399.

---

### throw_for_status()

```php
public function throw_for_status( bool $allow_redirects = true ): void
```

Throws an exception if the request was not successful.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$allow_redirects` | `bool` | Set to `false` to throw on 3xx responses |

**Throws:**
- `Exception` — If `$allow_redirects` is `false` and status is 3xx (`response.no_redirects`)
- `Exception\Http\StatusXXX` — On non-2xx, non-3xx status codes (class name matches status code)

---

### decode_body()

```php
public function decode_body( ?bool $associative = true, int $depth = 512, int $options = 0 ): array
```

JSON decode the response body. Parameters mirror PHP's `json_decode()`.

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$associative` | `bool\|null` | `true` | Return associative arrays (default differs from PHP's `null`) |
| `$depth` | `int` | `512` | Maximum nesting depth |
| `$options` | `int` | `0` | JSON decode bitmask flags |

**Returns:** Decoded data.

**Throws:** `Exception` — If body is not valid JSON (`response.invalid`).
