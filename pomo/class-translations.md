# Translations

Base class for a set of translation entries and their associated headers. Provides the core translation lookup interface.

**Source:** `wp-includes/pomo/translations.php`
**Since:** 2.8.0

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$entries` | Translation_Entry[] | `array()` | Translation entries keyed by `Translation_Entry::key()` |
| `$headers` | array\<string, string\> | `array()` | Translation headers (e.g., `Plural-Forms`, `Content-Type`) |

**Note:** Uses `#[AllowDynamicProperties]`.

---

## Methods

### `add_entry( $entry )`

Adds an entry to the translations.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$entry` | array\|Translation_Entry | Entry to add. Arrays are converted to `Translation_Entry`. |

**Returns:** `bool` — `true` on success, `false` if the entry has no key.

---

### `add_entry_or_merge( $entry )`

Adds an entry, or merges it with an existing entry if one with the same key exists.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$entry` | array\|Translation_Entry | Entry to add or merge |

**Returns:** `bool` — `true` on success, `false` if the entry has no key.

**Behavior:** If an entry with the same key exists, calls `merge_with()` on the existing entry. Otherwise adds it.

---

### `set_header( $header, $value )`

Sets a single PO header.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$header` | string | Header name (without trailing `:`) |
| `$value` | string | Header value (without trailing `\n`) |

---

### `set_headers( $headers )`

Sets multiple translation headers from an associative array.

**Since:** 2.8.0

---

### `get_header( $header )`

Returns a translation header value.

**Since:** 2.8.0

**Returns:** `string|false` — Header value if it exists, `false` otherwise.

---

### `translate_entry( &$entry )`

Looks up a translation entry by key.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$entry` | Translation_Entry | Entry to look up (passed by reference) |

**Returns:** `Translation_Entry|false` — The matched entry or `false`.

---

### `translate( $singular, $context = null )`

Translates a singular string.

**Since:** 2.8.0

**Returns:** `string` — The translation if found and non-empty, otherwise the original `$singular`.

---

### `select_plural_form( $count )`

Returns the 0-based index of the plural form to use. Base implementation uses English rules: 0 if count is 1, 1 otherwise.

**Since:** 2.8.0

**Returns:** `int`

---

### `get_plural_forms_count()`

Returns the number of plural forms. Base implementation returns 2.

**Since:** 2.8.0

**Returns:** `int`

---

### `translate_plural( $singular, $plural, $count, $context = null )`

Translates a plural string.

**Since:** 2.8.0

**Returns:** `string` — The appropriate plural translation if found and the index is valid, otherwise falls back to English rules (`$singular` if count is 1, `$plural` otherwise).

**Behavior:** Looks up the entry, selects the plural form index via `select_plural_form()`, and returns `$translated->translations[$index]` if valid.

---

### `merge_with( &$other )`

Merges entries from another `Translations` object. Overwrites existing entries with the same key.

**Since:** 2.8.0

---

### `merge_originals_with( &$other )`

Merges originals from another `Translations` object. If a key already exists, calls `merge_with()` on the existing entry. Otherwise adds the new entry.

**Since:** 2.8.0
