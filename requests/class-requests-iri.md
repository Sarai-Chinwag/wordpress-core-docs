# WpOrg\Requests\Iri

IRI (Internationalized Resource Identifier) parser, serializer, and normalizer.

**Source:** `wp-includes/Requests/src/Iri.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Utilities`  
**Authors:** Geoffrey Sneddon, Steve Minutillo  
**License:** BSD

---

## Overview

Parses, normalizes, and serializes IRIs per RFC 3987/3986. Supports scheme normalization for `acap`, `dict`, `file`, `http`, and `https`. Provides magic property access for IRI components in both IRI and URI forms. Handles IPv6 host compression, percent-encoding normalization, and dot-segment removal.

---

## Properties

All properties are accessed via magic `__get`/`__set`. The class stores internal ("i"-prefixed) forms and derives URI forms on access.

| Property | Type | Description |
|----------|------|-------------|
| `$iri` | `string` | Complete IRI (read via `get_iri()`) |
| `$uri` | `string` | IRI converted to URI form (read-only, via `to_uri()`) |
| `$scheme` | `string\|null` | Scheme component |
| `$authority` | `string` | Authority in URI form |
| `$iauthority` | `string` | Authority in IRI form |
| `$userinfo` | `string` | Userinfo in URI form |
| `$iuserinfo` | `string\|null` | Userinfo in IRI form |
| `$host` | `string` | Host in URI form |
| `$ihost` | `string\|null` | Host in IRI form |
| `$port` | `string\|null` | Port number |
| `$path` | `string` | Path in URI form |
| `$ipath` | `string` | Path in IRI form (defaults to `''`) |
| `$query` | `string` | Query in URI form |
| `$iquery` | `string\|null` | Query in IRI form |
| `$fragment` | `string` | Fragment in URI form |
| `$ifragment` | `string\|null` | Fragment in IRI form |

### Internal Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$scheme` | `string\|null` | `null` | Scheme |
| `$iuserinfo` | `string\|null` | `null` | User information |
| `$ihost` | `string\|null` | `null` | Host |
| `$port` | `string\|null` | `null` | Port |
| `$ipath` | `string` | `''` | Path |
| `$iquery` | `string\|null` | `null` | Query |
| `$ifragment` | `string\|null` | `null` | Fragment |
| `$normalization` | `array` | *(see below)* | Scheme-specific normalization defaults |

### Normalization Database

```php
$normalization = [
    'acap'  => ['port' => Port::ACAP],       // 674
    'dict'  => ['port' => Port::DICT],       // 2628
    'file'  => ['ihost' => 'localhost'],
    'http'  => ['port' => Port::HTTP],       // 80
    'https' => ['port' => Port::HTTPS],      // 443
];
```

When a component is `null` and the scheme has a default, the default is returned by `__get()`. During normalization, components matching defaults are set to `null` to suppress them.

---

## Public Methods

### __construct()

```php
public function __construct( string|Stringable|null $iri = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$iri` | `string\|Stringable\|null` | IRI string to parse |

**Throws:** `InvalidArgument` when `$iri` is not a string, Stringable, or null.

---

### __toString()

```php
public function __toString(): string
```

Returns the complete IRI via `get_iri()`.

---

### __set() / __get() / __isset() / __unset()

Magic property access. `__set` dispatches to `set_*` methods. `__get` dispatches to `get_*` methods or reads internal properties directly, with fallback mapping between IRI/URI forms (e.g., `host` → `ihost`, `ischeme` → `scheme`). Returns scheme normalization defaults when a property is `null`.

---

### absolutize()

Resolve a relative IRI against an absolute base IRI.

```php
public static function absolutize( Iri|string $base, Iri|string $relative ): Iri|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$base` | `Iri\|string` | Absolute base IRI |
| `$relative` | `Iri\|string` | Relative IRI to resolve |

**Returns:** `Iri` on success, `false` if the base has no scheme or either IRI is invalid.

Implements RFC 3986 Section 5 reference resolution algorithm.

---

### is_valid()

```php
public function is_valid(): bool
```

Checks structural validity: path must start with `/` when authority is present; relative paths without authority cannot have `:` before the first `/`.

---

### __wakeup()

Validates property types on unserialization. Throws `UnexpectedValueException` on type mismatch, then sets all properties to `null`.

---

## Protected Methods

| Method | Signature | Description |
|--------|-----------|-------------|
| `parse_iri()` | `(string $iri): array` | Regex-based parsing into scheme/authority/path/query/fragment |
| `remove_dot_segments()` | `(string $input): string` | RFC 3986 Section 5.2.4 dot segment removal |
| `replace_invalid_with_pct_encoding()` | `(string $text, string $extra_chars, bool $iprivate = false): string` | Normalize and percent-encode invalid characters |
| `remove_iunreserved_percent_encoded()` | `(array $regex_match): string` | Callback: decode percent-encoded iunreserved chars |
| `scheme_normalization()` | `(): void` | Remove components matching scheme defaults |
| `set_iri()` | `(string $iri): bool` | Parse and set all components (cached) |
| `set_scheme()` | `(string $scheme): bool` | Validate and lowercase scheme |
| `set_authority()` | `(string $authority): bool` | Parse authority into userinfo/host/port (cached) |
| `set_userinfo()` | `(string $iuserinfo): bool` | Set userinfo with percent-encoding |
| `set_host()` | `(string $ihost): bool` | Set host; handles IPv6 compression and lowercasing |
| `set_port()` | `(string $port): bool` | Validate numeric port |
| `set_path()` | `(string $ipath): bool` | Set path with percent-encoding and dot removal (cached) |
| `set_query()` | `(string $iquery): bool` | Set query with percent-encoding (iprivate allowed) |
| `set_fragment()` | `(string $ifragment): bool` | Set fragment with percent-encoding |
| `to_uri()` | `(string\|bool $iri): string\|false` | Convert IRI to URI by percent-encoding non-ASCII bytes |
| `get_iri()` | `(): string\|false` | Assemble complete IRI from components |
| `get_uri()` | `(): string` | Get complete URI |
| `get_iauthority()` | `(): string\|null` | Assemble iauthority (userinfo@host:port) |
| `get_authority()` | `(): string` | Get authority in URI form |

---

## IRI Resolution Flow

```
absolutize($base, $relative)
│
├─ $relative has scheme → clone $relative (already absolute)
├─ $relative has authority → use $base scheme + $relative authority/path/query
├─ $relative has path
│  ├─ Starts with '/' → use as-is
│  └─ Merge with base path, remove dot segments
│     └─ Use $relative query
├─ $relative has query → use base path + relative query
└─ Empty relative → clone base (clear fragment)
   └─ Apply scheme_normalization()
```
