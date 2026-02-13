# WpOrg\Requests\Autoload

PSR-4 autoloader for the Requests library with PSR-0 backward compatibility.

**Source:** `wp-includes/Requests/src/Autoload.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests`  
**Since:** 2.0.0  
**Modifier:** `final`

---

## Overview

Provides autoloading for the Requests library. Supports PSR-4 namespaced classes (`WpOrg\Requests\*`) in a case-sensitive manner, and provides backward compatibility for the deprecated PSR-0 class names (`Requests_*`) via `class_alias()` with deprecation notices.

The entire class definition is wrapped in `if (class_exists('WpOrg\Requests\Autoload') === false)` to prevent "Class already declared" fatal errors when the file is required multiple times.

---

## Properties

### $deprecated_classes

```php
private static array $deprecated_classes
```

Maps old PSR-0 class names (lowercase) to their PSR-4 equivalents. Contains mappings for all interfaces, classes, and exception classes in the library. Examples:

| PSR-0 Key (lowercase) | PSR-4 Value |
|------------------------|-------------|
| `requests_auth` | `\WpOrg\Requests\Auth` |
| `requests_hooker` | `\WpOrg\Requests\HookManager` |
| `requests_ssl` | `\WpOrg\Requests\Ssl` |
| `requests_exception_http_404` | `\WpOrg\Requests\Exception\Http\Status404` |
| `requests_exception_http_unknown` | `\WpOrg\Requests\Exception\Http\StatusUnknown` |

*(Full list contains 50+ mappings for all library classes.)*

---

## Methods

### register()

Register the autoloader with `spl_autoload_register()`.

```php
public static function register(): void
```

The autoloader is **prepended** to the autoload queue to take precedence over any Requests 1.x autoloader. Uses the `REQUESTS_AUTOLOAD_REGISTERED` global constant as a guard against double-registration.

---

### load()

Autoloader callback. Attempts to load a class by name.

```php
public static function load( string $class_name ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$class_name` | `string` | Fully qualified class name |

**Returns:** `bool` — Whether a class was loaded.

**Loading strategy:**

1. If the class doesn't start with `Requests` (PSR-0) or `WpOrg\Requests\` (PSR-4), return `false`.
2. If the class is exactly `Requests` (case-insensitive), load `library/Requests.php`.
3. If PSR-4 prefixed (`WpOrg\Requests\`), compute file path by replacing `\` with `/` after stripping the prefix, relative to `src/`.
4. If the file exists, `include` it and return `true`.
5. If the lowercased class name is in `$deprecated_classes`:
   - Emit `E_USER_DEPRECATED` notice (unless `REQUESTS_SILENCE_PSR0_DEPRECATIONS` is `true`).
   - Call `class_alias()` to map the old name to the PSR-4 name, triggering recursive autoloading.
6. Return `false` if nothing matched.

---

## Deprecation Behavior

When a PSR-0 class name is requested:

```
Requests_Exception_Http_404
│
├─ Not found as PSR-4
├─ Lowercased: "requests_exception_http_404"
├─ Found in $deprecated_classes → \WpOrg\Requests\Exception\Http\Status404
├─ Emit E_USER_DEPRECATED (first time only)
│  "The PSR-0 `Requests_...` class names in the Requests library are deprecated.
│   Switch to the PSR-4 `WpOrg\Requests\...` class names at your earliest convenience."
├─ Define REQUESTS_SILENCE_PSR0_DEPRECATIONS = true (prevents repeat notices)
└─ class_alias() → autoloader recursively loads PSR-4 class
```
