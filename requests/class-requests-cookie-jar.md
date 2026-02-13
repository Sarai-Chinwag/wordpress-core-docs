# WpOrg\Requests\Cookie\Jar

Cookie collection that automatically handles sending cookies on requests and parsing cookies from responses.

**Source:** `wp-includes/Requests/src/Cookie/Jar.php`  
**Namespace:** `WpOrg\Requests\Cookie`  
**Implements:** `ArrayAccess`, `IteratorAggregate`

---

## Properties

| Property | Type | Visibility | Default | Description |
|----------|------|-----------|---------|-------------|
| `$cookies` | `array` | `protected` | `[]` | Stored cookie data |

---

## Methods

### __construct()

```php
public function __construct( array $cookies = [] )
```

**Throws:** `InvalidArgument` when `$cookies` is not an array.

---

### normalize_cookie()

```php
public function normalize_cookie( string|Cookie $cookie, string $key = '' ): Cookie
```

Normalize a cookie value into a `Cookie` object. If already a `Cookie` instance, returns it directly. Otherwise, parses the string via `Cookie::parse()`.

---

### ArrayAccess Methods

```php
public function offsetExists( string $offset ): bool
public function offsetGet( string $offset ): string|null
public function offsetSet( string $offset, string $value ): void
public function offsetUnset( string $offset ): void
```

Standard dictionary access. `offsetSet()` throws `Exception('invalidset')` if `$offset` is `null`.

---

### getIterator()

```php
public function getIterator(): ArrayIterator
```

Returns an `ArrayIterator` over the cookies array.

---

### register()

```php
public function register( HookManager $hooks ): void
```

Register the cookie handler with the request hook system. Registers two hooks:

| Hook | Callback | Purpose |
|------|----------|---------|
| `requests.before_request` | `$this->before_request` | Add `Cookie` header to outgoing requests |
| `requests.before_redirect_check` | `$this->before_redirect_check` | Parse `Set-Cookie` headers from responses |

---

### before_request()

```php
public function before_request( string $url, array &$headers, array &$data, string &$type, array &$options ): void
```

Called before each request. Filters cookies by domain match and expiration, formats matching cookies as `name=value` pairs joined with `'; '` (per RFC 6265), and sets the `Cookie` header.

Converts the URL to an `Iri` object for domain matching.

---

### before_redirect_check()

```php
public function before_redirect_check( Response $response ): void
```

Called after each response. Parses `Set-Cookie` headers from the response via `Cookie::parse_from_headers()`, merges them into the jar, and sets `$response->cookies` to this jar instance.

---

## Integration Flow

```
Request out:
  register() hooks into before_request
  → before_request() adds Cookie header with matching, non-expired cookies

Response in:
  register() hooks into before_redirect_check  
  → before_redirect_check() parses Set-Cookie headers
  → Merges new cookies into jar
  → Sets $response->cookies = $this
  
Next request (redirect or new):
  → before_request() sends updated cookies
```
