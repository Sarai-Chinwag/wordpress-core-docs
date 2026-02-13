# WpOrg\Requests\Proxy\Http

HTTP proxy connection handler.

**Source:** `wp-includes/Requests/src/Proxy/Http.php`  
**Namespace:** `WpOrg\Requests\Proxy`  
**Package:** `Requests\Proxy`  
**Since:** 1.6  
**Modifier:** `final`  
**Implements:** `WpOrg\Requests\Proxy`

---

## Overview

Routes HTTP requests through an HTTP proxy. Supports optional proxy authentication (username/password). Registers hooks for both cURL and fsockopen transports. Implements the `Proxy` interface.

---

## Proxy Interface

```php
namespace WpOrg\Requests;

interface Proxy {
    public function register( Hooks $hooks );
}
```

**Since:** 1.6. Called by `Requests::request()` when a `Proxy` instance is set as the `'proxy'` option.

---

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$proxy` | `string` | Proxy host and port (e.g., `"127.0.0.1:8080"`) |
| `$user` | `string` | Proxy username |
| `$pass` | `string` | Proxy password |
| `$use_authentication` | `bool` | Whether authentication credentials were provided |

---

## Methods

### __construct()

```php
public function __construct( array|string|null $args = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | `array\|string\|null` | Proxy string, or array of 1 element `[proxy]` or 3 elements `[proxy, user, pass]` |

**Since:** 1.6

- **String:** Sets `$proxy` directly.
- **Array (1 element):** Sets `$proxy`.
- **Array (3 elements):** Sets `$proxy`, `$user`, `$pass`, and `$use_authentication = true`.

**Throws:**
- `InvalidArgument` when `$args` is not an array, string, or null.
- `ArgumentCount` (`proxyhttpbadargs`) when the array has neither 1 nor 3 elements.

---

### register()

Register transport-specific callbacks.

```php
public function register( Hooks $hooks ): void
```

**Since:** 1.6

Registers:
- `curl.before_send` → `curl_before_send()`
- `fsockopen.remote_socket` → `fsockopen_remote_socket()`
- `fsockopen.remote_host_path` → `fsockopen_remote_host_path()`
- `fsockopen.after_headers` → `fsockopen_header()` *(only if `$use_authentication` is true)*

---

### curl_before_send()

Configure cURL for proxy usage.

```php
public function curl_before_send( resource|CurlHandle &$handle ): void
```

**Since:** 1.6

Sets `CURLOPT_PROXYTYPE` to `CURLPROXY_HTTP` and `CURLOPT_PROXY` to the proxy address. If authentication is enabled, sets `CURLOPT_PROXYAUTH` to `CURLAUTH_ANY` and `CURLOPT_PROXYUSERPWD` to the auth string.

---

### fsockopen_remote_socket()

Replace the remote socket with the proxy address.

```php
public function fsockopen_remote_socket( string &$remote_socket ): void
```

**Since:** 1.6

---

### fsockopen_remote_host_path()

Replace the request path with the full URL for proxy requests.

```php
public function fsockopen_remote_host_path( string &$path, string $url ): void
```

**Since:** 1.6

Sets `$path = $url` so the HTTP request line uses the absolute URL (required by HTTP proxies).

---

### fsockopen_header()

Append Proxy-Authorization header.

```php
public function fsockopen_header( string &$out ): void
```

**Since:** 1.6

Appends `Proxy-Authorization: Basic <base64>` to the header string.

---

### get_auth_string()

Get the proxy authentication string.

```php
public function get_auth_string(): string
```

**Since:** 1.6  
**Returns:** `string` — `"user:pass"` format.
