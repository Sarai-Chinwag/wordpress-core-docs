# MO

Reads and writes MO (Machine Object) binary translation files — the compiled format used by gettext at runtime.

**Source:** `wp-includes/pomo/mo.php`
**Since:** 2.8.0
**Extends:** `Gettext_Translations`

## Properties

| Property | Type | Default | Visibility | Description |
|----------|------|---------|------------|-------------|
| `$_nplurals` | int | `2` | public | Number of plural forms |
| `$filename` | string | `''` | private | Path to the loaded MO file |

---

## Methods

### `get_filename()`

Returns the path of the loaded MO file.

**Returns:** `string`

---

### `import_from_file( $filename )`

Loads translation entries from an MO file.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$filename` | string | Path to MO file |

**Returns:** `bool` — `true` on success, `false` on failure.

**Behavior:** Opens the file with `POMO_FileReader`, stores the filename, and delegates to `import_from_reader()`.

---

### `import_from_reader( $reader )`

Parses an MO file from a `POMO_FileReader`.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$reader` | POMO_FileReader | Reader positioned at the start of the MO data |

**Returns:** `bool` — `true` on success, `false` on failure.

**Behavior:**

1. Reads magic number (first 4 bytes) to determine byte order via `get_byteorder()`
2. Reads 24-byte header: revision, total strings, originals table offset, translations table offset, hash length, hash address
3. Validates: only revision 0 is supported; table sizes must match `total * 8`
4. Reads originals and translations length/offset tables
5. Skips hash table, reads all string data
6. For each entry:
   - Empty original → parsed as headers via `make_headers()`
   - Non-empty → parsed via `make_entry()` into `Translation_Entry`

---

### `export()`

Exports the MO data as a binary string.

**Returns:** `string|false` — The binary MO data, or `false` on failure.

Uses `php://temp` stream internally.

---

### `export_to_file( $filename )`

Writes the MO data to a file.

**Returns:** `bool`

---

### `export_to_file_handle( $fh )`

Writes the MO binary format to a file handle.

**Returns:** `true`

**MO binary layout written:**
1. Magic number: `0x950412de`
2. Revision: `0`
3. Total count (entries + 1 for headers)
4. Originals table offset (28)
5. Translations table offset
6. Hash size (0) and hash offset
7. Originals length/offset table
8. Translations length/offset table
9. Original strings (null-separated)
10. Translation strings (null-separated)

Entries are sorted by key before export. Only entries passing `is_entry_good_for_export()` are included.

---

### `is_entry_good_for_export( $entry )`

Checks if an entry should be included in export.

**Returns:** `bool` — `false` if translations are empty or all falsy.

---

### `export_original( $entry )`

Formats an entry's original string for MO format.

**Returns:** `string` — Format: `[context\x04]singular[\x00plural]`

---

### `export_translations( $entry )`

Formats an entry's translations for MO format.

**Returns:** `string` — Plural translations joined by `\x00`, or single translation.

---

### `export_headers()`

Formats headers as a string (`Header: value\n` per line).

**Returns:** `string`

---

### `get_byteorder( $magic )`

Determines byte order from the MO magic number.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$magic` | int | First 4 bytes of the file as an integer |

**Returns:** `string|false` — `'little'`, `'big'`, or `false` if not a valid MO magic number.

**Magic values recognized:**
- Little-endian: `0x950412de` (as `-1794895138` on 32-bit or `2500072158` on 64-bit PHP)
- Big-endian: `0xde120495`

---

### `&make_entry( $original, $translation )`

Builds a `Translation_Entry` from raw MO original and translation strings.

**Returns:** `Translation_Entry` (by reference)

**Parsing:**
- Context separated by `\x04` (EOT)
- Plural original separated by `\x00` (NUL)
- Plural translations separated by `\x00` (NUL)

---

### `select_plural_form( $count )`

Delegates to `gettext_select_plural_form()` from `Gettext_Translations`.

**Returns:** `string` (return type in source; effectively `int`)

---

### `get_plural_forms_count()`

Returns `$_nplurals`.

**Returns:** `int`
