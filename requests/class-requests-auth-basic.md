# WpOrg\Requests\Auth\Basic

Basic HTTP authentication provider.

**Source:** `wp-includes/Requests/src/Auth/Basic.php`  
**Namespace:** `WpOrg\Requests\Auth`  
**Package:** `Requests\Authentication`  
**Implements:** `WpOrg\Requests\Auth`

---

## Overview

Provides Basic HTTP authentication for the Requests library. Registers hooks for both cURL and fsockopen transports to inject the `Authorization` header. Implements the `Auth` interface.

---

## Auth Interface

```php
namespace WpOrg\Requests;

interface Auth {
    public function register( Hooks $hooks );
}
```

Called by `Requests::request()` when an `Auth` instance is set as the `'auth'` option.

---

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$user` | `string` | Username |
| `$pass` | `string` | Password |

---

## Methods

### __construct()

```php
public function __construct( array|null $args = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | `array\|null` | Array of `[user, pass]`, must have exactly 2 elements |

**Since:** 2.0 — Throws `InvalidArgument` and `ArgumentCount` exceptions.

**Throws:**
- `InvalidArgument` when `$args` is not an array or null.
- `ArgumentCount` (`authbasicbadargs`) when the array does not have exactly 2 elements.

---

### register()

Register transport-specific callbacks.

```php
public function register( Hooks $hooks ): void
```

Registers:
- `curl.before_send` → `curl_before_send()`
- `fsockopen.after_headers` → `fsockopen_header()`

---

### curl_before_send()

Set cURL authentication options.

```php
public function curl_before_send( resource|CurlHandle &$handle ): void
```

Sets `CURLOPT_HTTPAUTH` to `CURLAUTH_BASIC` and `CURLOPT_USERPWD` to the auth string.

---

### fsockopen_header()

Append the Authorization header for fsockopen transport.

```php
public function fsockopen_header( string &$out ): void
```

Appends `Authorization: Basic <base64>` to the header string.

---

### getAuthString()

Get the authentication credential string.

```php
public function getAuthString(): string
```

**Returns:** `string` — `"user:pass"` format.

---

## Usage

```php
$options = [
    'auth' => new \WpOrg\Requests\Auth\Basic(['username', 'password']),
];
\WpOrg\Requests\Requests::get('https://example.com/api', [], $options);
```
