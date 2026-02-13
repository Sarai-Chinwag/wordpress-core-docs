# Requests Utility Classes

Utility classes for the Requests library.

**Source files:**
- `wp-includes/Requests/src/Utility/CaseInsensitiveDictionary.php`
- `wp-includes/Requests/src/Utility/FilteredIterator.php`
- `wp-includes/Requests/src/Utility/InputValidator.php`

---

## WpOrg\Requests\Utility\CaseInsensitiveDictionary

Case-insensitive dictionary, suitable for HTTP headers.

**Namespace:** `WpOrg\Requests\Utility`  
**Package:** `Requests\Utilities`  
**Implements:** `ArrayAccess`, `IteratorAggregate`

### Properties

| Property | Type | Visibility | Default | Description |
|----------|------|------------|---------|-------------|
| `$data` | `array` | `protected` | `[]` | Actual item data (keys stored lowercased) |

### Methods

#### __construct()

```php
public function __construct( array $data = [] )
```

Iterates over `$data` and calls `offsetSet()` for each entry (lowercasing keys).

#### offsetExists()

```php
public function offsetExists( string $offset ): bool
```

Lowercases the key before checking. Uses `#[ReturnTypeWillChange]` attribute.

#### offsetGet()

```php
public function offsetGet( string $offset ): string|null
```

Returns `null` if the key doesn't exist. Lowercases the key before lookup.

#### offsetSet()

```php
public function offsetSet( string $offset, string $value ): void
```

**Throws:** `Exception` (`invalidset`) when `$offset` is `null` (prevents list-style `$dict[] = value` usage).

Lowercases the key before storing.

#### offsetUnset()

```php
public function offsetUnset( string $offset ): void
```

Lowercases the key before unsetting.

#### getIterator()

```php
public function getIterator(): ArrayIterator
```

Returns an `ArrayIterator` over the internal data.

#### getAll()

```php
public function getAll(): array
```

Returns the raw `$data` array.

---

## WpOrg\Requests\Utility\FilteredIterator

Iterator that applies a callback filter to values on access.

**Namespace:** `WpOrg\Requests\Utility`  
**Package:** `Requests\Utilities`  
**Modifier:** `final`  
**Extends:** `ArrayIterator`

### Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$callback` | `callable` | `private` | Filter callback applied to each value |

### Methods

#### __construct()

```php
public function __construct( iterable $data, callable $callback )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | `iterable` | Array or traversable to iterate |
| `$callback` | `callable` | Filter function applied to each value via `current()` |

**Throws:** `InvalidArgument` when `$data` is not iterable.

The callback is only stored if `is_callable()` returns `true`.

#### current()

```php
public function current(): string
```

Returns `parent::current()` passed through the callback (if callable).

#### __unserialize()

```php
public function __unserialize( array $data ): void
```

Empty implementation — prevents unserialization for security.

#### __wakeup()

```php
public function __wakeup(): void
```

Unsets the callback to prevent injection during unserialization.

#### unserialize()

```php
public function unserialize( string $data ): void
```

Empty implementation — prevents creating an object from serialized data.

---

## WpOrg\Requests\Utility\InputValidator

Static input validation utilities used throughout the library.

**Namespace:** `WpOrg\Requests\Utility`  
**Package:** `Requests\Utilities`  
**Modifier:** `final`

### Methods

#### is_string_or_stringable()

```php
public static function is_string_or_stringable( mixed $input ): bool
```

Returns `true` if `$input` is a string or an object with `__toString()`.

#### is_numeric_array_key()

```php
public static function is_numeric_array_key( mixed $input ): bool
```

Returns `true` if `$input` is an `int`, or a string matching `/^-?[0-9]+$/`.

#### is_stringable_object()

```php
public static function is_stringable_object( mixed $input ): bool
```

Returns `true` if `$input` is an object with a `__toString()` method.

#### has_array_access()

```php
public static function has_array_access( mixed $input ): bool
```

Returns `true` if `$input` is an array or implements `ArrayAccess`.

#### is_iterable()

```php
public static function is_iterable( mixed $input ): bool
```

Returns `true` if `$input` is an array or implements `Traversable`. Exists for PHP 5.6 compatibility (native `is_iterable()` was added in PHP 7.1).

#### is_curl_handle()

```php
public static function is_curl_handle( mixed $input ): bool
```

Returns `true` if `$input` is a cURL resource (pre-PHP 8.0) or a `CurlHandle` instance (PHP 8.0+).
