# Translation_Entry

Encapsulates a single translatable string with its translations, metadata, and context.

**Source:** `wp-includes/pomo/entry.php`
**Since:** 2.8.0

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$is_plural` | bool | `false` | Whether the entry contains a plural form |
| `$context` | string\|null | `null` | Context string differentiating equal strings in different contexts |
| `$singular` | string\|null | `null` | The singular source string |
| `$plural` | string\|null | `null` | The plural form of the source string |
| `$translations` | array | `array()` | Translations of the string (index 0 = singular, 1+ = plural forms) |
| `$translator_comments` | string | `''` | Comments left by translators |
| `$extracted_comments` | string | `''` | Comments left by developers |
| `$references` | array | `array()` | Source code locations in `path/file.php:linenum` format |
| `$flags` | array | `array()` | Flags like `php-format` |

**Note:** The class uses `#[AllowDynamicProperties]` and will accept arbitrary properties via the constructor args.

---

## Methods

### `__construct( $args = array() )`

**Since:** 2.8.0

Creates a translation entry from an associative array. If `singular` is not set in `$args`, creates an empty entry (returns immediately). All keys in `$args` are assigned as properties. Sets `$is_plural = true` if `plural` is provided and truthy. Forces `$translations`, `$references`, and `$flags` to arrays.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Associative array with keys: `singular`, `plural`, `translations`, `context`, `translator_comments`, `extracted_comments`, `references`, `flags` |

---

### `key()`

Generates a unique lookup key for this entry.

**Since:** 2.8.0

**Returns:** `string|false` — The key, or `false` if `$singular` is `null`.

**Key format:**
- Without context: `singular` (with `\r\n` and `\r` normalized to `\n`)
- With context: `context\x04singular` (EOT character as separator, matching MO file format)

---

### `merge_with( &$other )`

Merges another `Translation_Entry` into this one.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$other` | Translation_Entry | Other entry (passed by reference) |

**Behavior:**
- Merges `$flags` arrays (unique values)
- Merges `$references` arrays (unique values)
- Appends `$extracted_comments` if different

---

### `Translation_Entry( $args = array() )` *(deprecated)*

PHP4 constructor.

**Since:** 2.8.0
**Deprecated:** 5.4.0 — Use `__construct()` instead.
