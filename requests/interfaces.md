# Requests Interfaces

All interfaces defined in the Requests library.

**Source files:**
- `wp-includes/Requests/src/Auth.php`
- `wp-includes/Requests/src/Capability.php`
- `wp-includes/Requests/src/HookManager.php`
- `wp-includes/Requests/src/Proxy.php`
- `wp-includes/Requests/src/Transport.php`

---

## WpOrg\Requests\Auth

Authentication provider interface.

**Source:** `wp-includes/Requests/src/Auth.php`  
**Package:** `Requests\Authentication`

Implement this interface to act as an authentication provider. Parameters should be passed via the constructor.

### Methods

#### register()

```php
public function register( \WpOrg\Requests\Hooks $hooks ): void
```

Called by `Requests::request()` when an `Auth` instance is set as the `'auth'` option. Register all needed hooks here.

### Implementations

- `WpOrg\Requests\Auth\Basic` — Basic HTTP authentication

---

## WpOrg\Requests\Capability

Capability interface declaring known transport capabilities.

**Source:** `wp-includes/Requests/src/Capability.php`  
**Package:** `Requests\Utilities`

### Constants

| Constant | Type | Value | Description |
|----------|------|-------|-------------|
| `SSL` | `string` | `'ssl'` | Support for SSL |
| `ALL` | `string[]` | `[self::SSL]` | Collection of all capabilities supported in Requests |

This interface defines no methods — it serves as an authoritative source of queryable capability identifiers. Used by `Transport::test()` to check transport capabilities.

---

## WpOrg\Requests\HookManager

Event dispatcher interface.

**Source:** `wp-includes/Requests/src/HookManager.php`  
**Package:** `Requests\EventDispatcher`

### Methods

#### register()

```php
public function register( string $hook, callable $callback, int $priority = 0 ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hook` | `string` | Hook name |
| `$callback` | `callable` | Callback to invoke |
| `$priority` | `int` | Priority. Negative = earlier, positive = later |

#### dispatch()

```php
public function dispatch( string $hook, array $parameters = [] ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hook` | `string` | Hook name |
| `$parameters` | `array` | Parameters passed to callbacks |

**Returns:** `bool` — Whether dispatching was successful.

### Implementations

- `WpOrg\Requests\Hooks` — Default hook manager

---

## WpOrg\Requests\Proxy

Proxy connection interface.

**Source:** `wp-includes/Requests/src/Proxy.php`  
**Package:** `Requests\Proxy`  
**Since:** 1.6

Implement this interface to handle proxy settings and authentication. Parameters should be passed via the constructor.

### Methods

#### register()

```php
public function register( \WpOrg\Requests\Hooks $hooks ): void
```

Called by `Requests::request()` when a `Proxy` instance is set as the `'proxy'` option. Register all needed hooks here.

### Implementations

- `WpOrg\Requests\Proxy\Http` — HTTP proxy support

---

## WpOrg\Requests\Transport

Base HTTP transport interface.

**Source:** `wp-includes/Requests/src/Transport.php`  
**Package:** `Requests\Transport`

### Methods

#### request()

Perform a single HTTP request.

```php
public function request( string $url, array $headers = [], string|array $data = [], array $options = [] ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | `string` | URL to request |
| `$headers` | `array` | Associative array of request headers |
| `$data` | `string\|array` | POST body or GET/HEAD URL parameters |
| `$options` | `array` | Request options |

**Returns:** `string` — Raw HTTP result.

#### request_multiple()

Send multiple requests simultaneously.

```php
public function request_multiple( array $requests, array $options ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$requests` | `array` | Array of request data arrays (`url`, `headers`, `data`, `options`) |
| `$options` | `array` | Global options |

**Returns:** `array` — Array of `Response` objects (may contain `Exception` or string values).

#### test()

Self-test whether the transport can be used.

```php
public static function test( array $capabilities = [] ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$capabilities` | `array<string, bool>` | Capabilities to test (e.g., `['ssl' => true]`) |

**Returns:** `bool` — Whether the transport is available.

### Implementations

- `WpOrg\Requests\Transport\Curl` — cURL transport
- `WpOrg\Requests\Transport\Fsockopen` — fsockopen transport
