# WpOrg\Requests\Session

Session handler for persistent requests with shared default parameters.

**Source:** `wp-includes/Requests/src/Session.php`  
**Namespace:** `WpOrg\Requests`

---

## Overview

Session allows setting a base URL, default headers, data, and options that are merged into every request. A shared cookie jar is automatically created if none is provided, enabling cookie persistence across requests.

Options can be set as properties on the Session object via magic methods (e.g. `$session->useragent = 'X'`).

---

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$url` | `string\|null` | `null` | Base URL — per-request URLs are resolved relative to this |
| `$headers` | `array` | `[]` | Default headers merged with per-request headers |
| `$data` | `array` | `[]` | Default data merged with per-request data (both must be arrays) |
| `$options` | `array` | `[]` | Default options merged with per-request options |

---

## Methods

### __construct()

```php
public function __construct(
    string|Stringable|null $url = null,
    array $headers = [],
    array $data = [],
    array $options = []
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | `string\|Stringable\|null` | Base URL |
| `$headers` | `array` | Default headers |
| `$data` | `array` | Default data |
| `$options` | `array` | Default options |

Creates a shared `Cookie\Jar` in `$options['cookies']` if not provided.

**Throws:** `InvalidArgument` for invalid parameter types.

---

### Magic Methods

```php
public function __get( string $name ): mixed|null
public function __set( string $name, mixed $value ): void
public function __isset( string $name ): bool
public function __unset( string $name ): void
```

Proxy get/set/isset/unset to `$this->options[$name]`. Allows `$session->useragent = 'MyApp'` as shorthand for `$session->options['useragent'] = 'MyApp'`.

---

### __wakeup()

```php
public function __wakeup(): void
```

Throws `\LogicException` — Session should never be unserialized.

---

### HTTP Method Shortcuts

#### Without body (GET, HEAD, DELETE):

```php
public function get( string $url, array $headers = [], array $options = [] ): Response
public function head( string $url, array $headers = [], array $options = [] ): Response
public function delete( string $url, array $headers = [], array $options = [] ): Response
```

#### With body (POST, PUT, PATCH):

```php
public function post( string $url, array $headers = [], array $data = [], array $options = [] ): Response
public function put( string $url, array $headers = [], array $data = [], array $options = [] ): Response
public function patch( string $url, array $headers, array $data = [], array $options = [] ): Response
```

Note: `patch()` requires `$headers` (not optional), same as `Requests::patch()`.

All delegate to `$this->request()`.

---

### request()

```php
public function request(
    string $url,
    array $headers = [],
    array|null $data = [],
    string $type = Requests::GET,
    array $options = []
): Response
```

Merges session defaults with per-request values via `merge_request()`, then delegates to `Requests::request()`.

---

### request_multiple()

```php
public function request_multiple( array $requests, array $options = [] ): array
```

Send multiple requests. Each request is merged with session defaults. The `type` option is **removed** from merged global options (type is per-request only).

**Throws:** `InvalidArgument` for invalid parameter types.

---

## Protected Methods

### merge_request()

```php
protected function merge_request( array $request, bool $merge_options = true ): array
```

Merges a request's data with session defaults:
1. If `$this->url` is set, resolves `$request['url']` relative to it using `Iri::absolutize()`
2. Merges headers (`array_merge`)
3. Merges data if both are arrays
4. Merges options (if `$merge_options` is true), removing `type` from merged result
