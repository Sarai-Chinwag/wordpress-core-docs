# WpOrg\Requests\Response\Headers

Case-insensitive dictionary for HTTP response headers with multi-value support.

**Source:** `wp-includes/Requests/src/Response/Headers.php`  
**Namespace:** `WpOrg\Requests\Response`  
**Extends:** `WpOrg\Requests\Utility\CaseInsensitiveDictionary`  
**Implements:** `ArrayAccess`, `IteratorAggregate` (via parent)

---

## Inheritance

`CaseInsensitiveDictionary` provides the base `ArrayAccess` and `IteratorAggregate` implementation with case-insensitive key handling. `Headers` overrides key methods to support **multiple values per header**.

### Parent: CaseInsensitiveDictionary

| Property | Type | Visibility | Description |
|----------|------|-----------|-------------|
| `$data` | `array` | `protected` | Actual stored data |

Parent methods:
- `offsetExists($offset)` — Case-insensitive key check
- `offsetGet($offset)` — Returns single value
- `offsetSet($offset, $value)` — Replaces value
- `offsetUnset($offset)` — Removes key
- `getIterator()` — Returns `ArrayIterator`
- `getAll()` — Returns raw `$data` array

---

## Methods (Overridden)

### offsetGet()

```php
public function offsetGet( string $offset ): string|null
```

Get a header value as a string. If the header has **multiple values**, they are joined with `,` (comma) per RFC 2616.

> **Warning:** Avoid this for headers where commas appear unquoted in values (e.g. `Set-Cookie`). Use `getValues()` instead.

**Returns:** Comma-joined string, or `null` if header not set.

---

### offsetSet()

```php
public function offsetSet( string $offset, string $value ): void
```

Set a header value. Unlike the parent, this **appends** to an array of values rather than replacing. Each call adds another value for that header key.

**Throws:** `Exception` — If `$offset` is `null` (`invalidset`).

---

### getIterator()

```php
public function getIterator(): ArrayIterator
```

Returns a `FilteredIterator` that flattens multi-value arrays to comma-separated strings.

---

## Additional Methods

### getValues()

```php
public function getValues( string|int $offset ): array|null
```

Get **all** values for a header as an array (without flattening).

| Parameter | Type | Description |
|-----------|------|-------------|
| `$offset` | `string\|int` | Header name |

**Returns:** Array of values, or `null` if not set.

**Throws:** `InvalidArgument` — When `$offset` is not a string or integer.

---

### flatten()

```php
public function flatten( string|array $value ): string
```

Flatten a value to a string. Arrays are imploded with `,`.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | `string\|array` | Value to flatten |

**Returns:** Flattened string.

**Throws:** `InvalidArgument` — When `$value` is not a string or array.

---

## Usage Notes

Headers stores each value as an array internally. When a header appears multiple times in a response (e.g. `Set-Cookie`), each value is stored separately:

```php
// Internally: $data['set-cookie'] = ['cookie1=a', 'cookie2=b']

// offsetGet returns comma-joined:
$headers['set-cookie']; // "cookie1=a,cookie2=b"

// getValues returns array:
$headers->getValues('set-cookie'); // ['cookie1=a', 'cookie2=b']
```
