# WpOrg\Requests\Port

Port number utilities for the Requests library.

**Source:** `wp-includes/Requests/src/Port.php`  
**Namespace:** `WpOrg\Requests`  
**Package:** `Requests\Utilities`  
**Since:** 2.0.0  
**Modifier:** `final`

---

## Overview

Provides well-known port constants and a method to retrieve the port number for a given request type.

---

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `ACAP` | `674` | Port for ACAP requests |
| `DICT` | `2628` | Port for Dictionary requests |
| `HTTP` | `80` | Port for HTTP requests |
| `HTTPS` | `443` | Port for HTTPS requests |

---

## Methods

### get()

Retrieve the port number for a given request type.

```php
public static function get( string $type ): int
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$type` | `string` | Request type: `'acap'`, `'dict'`, `'http'`, or `'https'` (case-insensitive) |

**Returns:** `int` — The port number.

The type is uppercased internally and looked up as a class constant via `defined("self::{$type}")` / `constant("self::{$type}")`.

**Throws:**
- `InvalidArgument` when `$type` is not a string.
- `Exception` with type `portnotsupported` when the requested port type has no corresponding constant.
