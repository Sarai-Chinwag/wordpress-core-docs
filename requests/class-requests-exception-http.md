# Requests HTTP Status Exceptions

Exception classes for HTTP response status codes.

**Source files:**
- `wp-includes/Requests/src/Exception/Http.php`
- `wp-includes/Requests/src/Exception/Http/Status*.php`
- `wp-includes/Requests/src/Exception/Http/StatusUnknown.php`

---

## WpOrg\Requests\Exception\Http

Base class for HTTP status code exceptions.

**Namespace:** `WpOrg\Requests\Exception`  
**Package:** `Requests\Exceptions`  
**Extends:** `WpOrg\Requests\Exception`

### Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$code` | `int` | `0` | HTTP status code |
| `$reason` | `string` | `'Unknown'` | Reason phrase |

### Methods

#### __construct()

```php
public function __construct( string|null $reason = null, mixed $data = null )
```

If `$reason` is provided, overrides the default. Formats the parent message as `"{code} {reason}"` and sets the parent type to `'httpresponse'`.

#### getReason()

```php
public function getReason(): string
```

Returns the reason phrase.

#### get_class()

Get the appropriate exception class for an HTTP status code.

```php
public static function get_class( int|bool $code ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$code` | `int\|bool` | HTTP status code, or `false` if unavailable |

**Returns:** Fully qualified class name. Returns `StatusUnknown::class` if `$code` is falsy or no matching `Status{code}` class exists.

---

## WpOrg\Requests\Exception\Http\StatusUnknown

Exception for unknown/unrecognized HTTP status codes.

**Extends:** `WpOrg\Requests\Exception\Http`  
**Modifier:** `final`

| Property | Default |
|----------|---------|
| `$code` | `0` |
| `$reason` | `'Unknown'` |

#### __construct()

```php
public function __construct( string|null $reason = null, mixed $data = null )
```

If `$data` is an instance of `\WpOrg\Requests\Response`, sets `$code` from `$data->status_code`. Then calls the parent constructor.

---

## HTTP Status Exception Classes

All classes below are `final`, extend `WpOrg\Requests\Exception\Http`, and override only `$code` and `$reason`. They inherit the constructor and all methods from the base class.

### 3xx Redirection

| Class | Code | Reason |
|-------|------|--------|
| `Status304` | 304 | Not Modified |
| `Status305` | 305 | Use Proxy |
| `Status306` | 306 | Switch Proxy |

### 4xx Client Errors

| Class | Code | Reason |
|-------|------|--------|
| `Status400` | 400 | Bad Request |
| `Status401` | 401 | Unauthorized |
| `Status402` | 402 | Payment Required |
| `Status403` | 403 | Forbidden |
| `Status404` | 404 | Not Found |
| `Status405` | 405 | Method Not Allowed |
| `Status406` | 406 | Not Acceptable |
| `Status407` | 407 | Proxy Authentication Required |
| `Status408` | 408 | Request Timeout |
| `Status409` | 409 | Conflict |
| `Status410` | 410 | Gone |
| `Status411` | 411 | Length Required |
| `Status412` | 412 | Precondition Failed |
| `Status413` | 413 | Request Entity Too Large |
| `Status414` | 414 | Request-URI Too Large |
| `Status415` | 415 | Unsupported Media Type |
| `Status416` | 416 | Requested Range Not Satisfiable |
| `Status417` | 417 | Expectation Failed |
| `Status418` | 418 | I'm A Teapot |
| `Status428` | 428 | Precondition Required |
| `Status429` | 429 | Too Many Requests |
| `Status431` | 431 | Request Header Fields Too Large |

### 5xx Server Errors

| Class | Code | Reason |
|-------|------|--------|
| `Status500` | 500 | Internal Server Error |
| `Status501` | 501 | Not Implemented |
| `Status502` | 502 | Bad Gateway |
| `Status503` | 503 | Service Unavailable |
| `Status504` | 504 | Gateway Timeout |
| `Status505` | 505 | HTTP Version Not Supported |
| `Status511` | 511 | Network Authentication Required |

### Special

| Class | Code | Reason | Notes |
|-------|------|--------|-------|
| `StatusUnknown` | `0` | Unknown | Sets code from Response object if available |

---

## Usage

```php
// Get the right exception class for a status code
$class = \WpOrg\Requests\Exception\Http::get_class(404);
// Returns '\WpOrg\Requests\Exception\Http\Status404'

// Throw with custom reason
throw new \WpOrg\Requests\Exception\Http\Status404('Resource not found', $response);

// Unknown status codes
$class = \WpOrg\Requests\Exception\Http::get_class(999);
// Returns '\WpOrg\Requests\Exception\Http\StatusUnknown'
```
