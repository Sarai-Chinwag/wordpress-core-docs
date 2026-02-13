# WpOrg\Requests\Cookie

HTTP cookie storage, parsing, and validation per RFC 6265.

**Source:** `wp-includes/Requests/src/Cookie.php`  
**Namespace:** `WpOrg\Requests`

---

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$name` | `string` | — | Cookie name |
| `$value` | `string` | — | Cookie value |
| `$attributes` | `CaseInsensitiveDictionary\|array` | `[]` | Cookie attributes. Valid keys: `path`, `domain`, `expires`, `max-age`, `secure`, `httponly` |
| `$flags` | `array` | *(see below)* | Cookie flags. Valid keys: `creation`, `last-access`, `persistent`, `host-only` |
| `$reference_time` | `int` | `time()` | Reference time for relative calculations (Max-Age expiration, validity checks) |

### Default Flags

```php
[
    'creation'    => time(),
    'last-access' => time(),
    'persistent'  => false,
    'host-only'   => true,
]
```

---

## Methods

### __construct()

```php
public function __construct(
    string $name,
    string $value,
    array|CaseInsensitiveDictionary $attributes = [],
    array $flags = [],
    int|null $reference_time = null
)
```

Creates a cookie, merges flags with defaults, sets reference time, and calls `normalize()`.

**Throws:** `InvalidArgument` for invalid parameter types.

---

### __toString()

```php
public function __toString(): string
```

Returns the cookie value.

---

### is_expired()

```php
public function is_expired(): bool
```

Check if cookie is expired. Per RFC 6265 s.4.1.2.2, `max-age` takes precedence over `expires`. Both are compared against `$this->reference_time`.

---

### uri_matches()

```php
public function uri_matches( Iri $uri ): bool
```

Check if cookie is valid for a given URI. Validates domain match, path match, and secure attribute against scheme.

---

### domain_matches()

```php
public function domain_matches( string $domain ): bool
```

Check if cookie is valid for a domain. Implements RFC 6265 domain matching:
- Exact match returns `true`
- If `host-only` flag is set and no exact match, returns `false`
- Cookie domain must be a suffix of the given domain
- The character before the suffix must be `.`
- Domain must not be an IP address

Returns `true` if no `domain` attribute is set (manually created cookies).

---

### path_matches()

```php
public function path_matches( string $request_path ): bool
```

Check if cookie is valid for a path per RFC 6265 section 5.1.4:
- Exact match
- Cookie path is a prefix ending with `/`
- Cookie path is a prefix and the next character in request path is `/`

Returns `true` if no `path` attribute is set.

---

### normalize()

```php
public function normalize(): bool
```

Normalize cookie attributes. Iterates all attributes and calls `normalize_attribute()`. Removes attributes that normalize to `null`. Always returns `true`.

---

### format_for_header()

```php
public function format_for_header(): string
```

Format as `name=value` for a `Cookie` request header.

---

### format_for_set_cookie()

```php
public function format_for_set_cookie(): string
```

Format for a `Set-Cookie` response header. Includes attributes as `; key=value` pairs.

---

### parse() (static)

```php
public static function parse(
    string $cookie_header,
    string $name = '',
    int|null $reference_time = null
): Cookie
```

Parse a `Set-Cookie` header string into a Cookie object. Based on Mozilla's parsing (intentional deviation from RFC 2109/2616).

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie_header` | `string` | Set-Cookie header value |
| `$name` | `string` | If provided, entire header is treated as the value |
| `$reference_time` | `int\|null` | Reference time for expiration |

**Behavior:**
- Splits on `;` to separate attributes
- First segment split on `=` for name/value
- If no `=` in first segment, name is `''` and entire segment is value
- Attributes stored in a `CaseInsensitiveDictionary`

**Throws:** `InvalidArgument` for invalid parameter types.

---

### parse_from_headers() (static)

```php
public static function parse_from_headers(
    Response\Headers $headers,
    Iri|null $origin = null,
    int|null $time = null
): array
```

Parse all `Set-Cookie` headers from response headers.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$headers` | `Response\Headers` | Response headers to parse |
| `$origin` | `Iri\|null` | Request URI for default domain/path |
| `$time` | `int\|null` | Reference time |

**Returns:** Associative array of `Cookie` objects keyed by cookie name.

**Behavior:**
- Gets all `Set-Cookie` values via `$headers->getValues()`
- Sets default `domain` from origin host if not in cookie (marks `host-only`)
- Sets default `path` per RFC 6265 section 5.1.4
- Rejects cookies whose domain doesn't match origin host

**Throws:** `InvalidArgument` when `$origin` is not `Iri` or null.

---

## Protected Methods

### normalize_attribute()

```php
protected function normalize_attribute( string $name, string|int|bool $value ): mixed|null
```

Normalize individual attribute values:

| Attribute | Normalization |
|-----------|---------------|
| `expires` | Parsed with `strtotime()`. Returns `null` on failure. |
| `max-age` | Validated as integer string (`/^-?\d+$/`). If ≤ 0, expiry = 0. Otherwise, expiry = `reference_time + delta`. Returns `null` on invalid format. |
| `domain` | Strips leading `.`. Returns `null` if empty. |
| *(other)* | Returned as-is. |
