# Requests Exception Hierarchy

Exception classes for the Requests library.

**Source files:**
- `wp-includes/Requests/src/Exception.php`
- `wp-includes/Requests/src/Exception/InvalidArgument.php`
- `wp-includes/Requests/src/Exception/ArgumentCount.php`
- `wp-includes/Requests/src/Exception/Transport.php`
- `wp-includes/Requests/src/Exception/Transport/Curl.php`

---

## Class Hierarchy

```
PHP\Exception
├── WpOrg\Requests\Exception
│   ├── WpOrg\Requests\Exception\ArgumentCount (final)
│   ├── WpOrg\Requests\Exception\Transport
│   │   └── WpOrg\Requests\Exception\Transport\Curl (final)
│   └── WpOrg\Requests\Exception\Http (see class-requests-exception-http.md)
│
PHP\InvalidArgumentException
└── WpOrg\Requests\Exception\InvalidArgument (final)
```

---

## WpOrg\Requests\Exception

Base exception for all Requests errors.

**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Exceptions`  
**Extends:** `\Exception`

### Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$type` | `string` | `protected` | String error type code |
| `$data` | `mixed` | `protected` | Associated data |

### Methods

#### __construct()

```php
public function __construct( string $message, string $type, mixed $data = null, int $code = 0 )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$message` | `string` | Human-readable error message |
| `$type` | `string` | String error type identifier |
| `$data` | `mixed` | Associated data |
| `$code` | `int` | Numerical error code |

#### getType()

```php
public function getType(): string
```

Returns the string type code (similar to `getCode()` but a string).

#### getData()

```php
public function getData(): mixed
```

Returns associated data.

---

## WpOrg\Requests\Exception\InvalidArgument

Exception for invalid argument types.

**Namespace:** `WpOrg\Requests\Exception`  
**Package:** `Requests\Exceptions`  
**Since:** 2.0.0  
**Modifier:** `final`  
**Extends:** `\InvalidArgumentException`

### Methods

#### create()

Factory method producing a standardized error message.

```php
public static function create( int $position, string $name, string $expected, string $received ): InvalidArgument
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$position` | `int` | Argument position (1-based) |
| `$name` | `string` | Argument name (e.g., `'$host'`) |
| `$expected` | `string` | Expected type(s) as string |
| `$received` | `string` | Actual type received |

**Message format:** `ClassName::methodName(): Argument #1 ($name) must be of type expected, received given`

Uses `debug_backtrace()` to determine the calling class and method.

---

## WpOrg\Requests\Exception\ArgumentCount

Exception for incorrect number of arguments or array elements.

**Namespace:** `WpOrg\Requests\Exception`  
**Package:** `Requests\Exceptions`  
**Since:** 2.0.0  
**Modifier:** `final`  
**Extends:** `WpOrg\Requests\Exception`

### Methods

#### create()

Factory method producing a standardized error message.

```php
public static function create( string $expected, int $received, string $type ): ArgumentCount
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$expected` | `string` | Expected count as phrase (e.g., `'an array with exactly two elements'`) |
| `$received` | `int` | Actual count |
| `$type` | `string` | Exception type string for the parent `Exception` |

**Message format:** `ClassName::methodName() expects expected, received given`

Uses `debug_backtrace()` to determine the calling class and method.

---

## WpOrg\Requests\Exception\Transport

Base transport exception.

**Namespace:** `WpOrg\Requests\Exception`  
**Package:** `Requests\Exceptions`  
**Extends:** `WpOrg\Requests\Exception`

Empty class — serves as a base type for transport-specific exceptions.

---

## WpOrg\Requests\Exception\Transport\Curl

cURL-specific transport exception.

**Namespace:** `WpOrg\Requests\Exception\Transport`  
**Package:** `Requests\Exceptions`  
**Modifier:** `final`  
**Extends:** `WpOrg\Requests\Exception\Transport`

### Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `EASY` | `'cURLEasy'` | cURL easy handle error |
| `MULTI` | `'cURLMulti'` | cURL multi handle error |
| `SHARE` | `'cURLShare'` | cURL share handle error |

### Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$code` | `int` | `-1` | cURL error code |
| `$type` | `string` | `'Unknown'` | Error type: EASY, MULTI, or SHARE |
| `$reason` | `string` | `'Unknown'` | Clear text error message |

### Methods

#### __construct()

```php
public function __construct( string $message, string $type, mixed $data = null, int $code = 0 )
```

Sets `$type`, `$code`, and `$reason` from parameters (if non-null). Formats the parent message as `"{code} {reason}"`.

#### getReason()

```php
public function getReason(): string
```

Returns the clear text error message.
