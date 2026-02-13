# PO

Reads and writes PO (Portable Object) text-based translation files — the human-editable source format used by gettext.

**Source:** `wp-includes/pomo/po.php`
**Since:** 2.8.0
**Extends:** `Gettext_Translations`

## Constants

| Constant | Value | Scope | Description |
|----------|-------|-------|-------------|
| `PO_MAX_LINE_LEN` | `79` | Global | Maximum line length for PO comment wrapping |

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$comments_before_headers` | string | `''` | Text to include as comments before the PO header entry |

---

## Methods

### `export_headers()`

Exports headers as a PO `msgid ""`/`msgstr` entry.

**Returns:** `string` — Complete PO header block (without trailing newline).

Includes `$comments_before_headers` (prefixed with `# `) if set.

---

### `export_entries()`

Exports all entries to PO format.

**Returns:** `string` — All entries joined by double newlines.

---

### `export( $include_headers = true )`

Exports the complete PO file as a string.

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$include_headers` | bool | `true` | Whether to include headers |

**Returns:** `string`

---

### `export_to_file( $filename, $include_headers = true )`

Writes the PO export to a file.

**Returns:** `bool` — `true` on success, `false` on error.

---

### `set_comment_before_headers( $text )`

Sets text to include as a comment before the PO headers. The `#` prefix is added automatically.

---

### `poify( $input_string )` *(static)*

Formats a string in PO-style with proper escaping.

**Returns:** `string` — The PO-formatted ("poified") string.

**Escaping applied:**
- `\` → `\\`
- `"` → `\"`
- `\t` → `\t`
- `\n` → `\n"` (with line continuation)

**Behavior:** Multi-line strings get an empty `""` first line for readability. Empty trailing lines from continuations are removed.

---

### `unpoify( $input_string )` *(static)*

Reverses PO-style formatting back to the original string.

**Returns:** `string` — Unescaped string.

**Escape sequences recognized:** `\t`, `\n`, `\r`, `\\`. Line endings are normalized to `\n`.

---

### `prepend_each_line( $input_string, $with )` *(static)*

Prepends a string to every line.

**Returns:** `string`

---

### `comment_block( $text, $char = ' ' )` *(static)*

Wraps text into a PO comment block. Word-wraps at `PO_MAX_LINE_LEN - 3`, prepends `#$char ` to each line.

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$text` | string | — | Comment text |
| `$char` | string | `' '` | Special character: ` ` (translator), `.` (extracted), `:` (reference), `,` (flags) |

---

### `export_entry( $entry )` *(static)*

Converts a `Translation_Entry` to a PO-formatted string.

**Returns:** `string|false` — PO entry string, or `false` if entry has null/empty singular.

**Output includes (in order):**
1. Translator comments (`# ...`)
2. Extracted comments (`#. ...`)
3. References (`#: ...`)
4. Flags (`#, ...`)
5. `msgctxt` (if context set)
6. `msgid`
7. `msgid_plural` (if plural)
8. `msgstr` / `msgstr[N]`

Translation newlines are matched to original newlines via `match_begin_and_end_newlines()`.

---

### `match_begin_and_end_newlines( $translation, $original )` *(static)*

Ensures translation begins/ends with newlines matching the original string.

**Returns:** `string` — Adjusted translation.

---

### `import_from_file( $filename )`

Parses a PO file into entries and headers.

**Returns:** `bool` — `true` on success, `false` if the file can't be read or contains no entries/headers.

**Behavior:** Reads entries one at a time via `read_entry()`. Empty-singular entries become headers (via `make_headers()`). All others are added via `add_entry()`.

---

### `read_entry( $f, $lineno = 0 )`

Reads a single PO entry from a file handle.

**Returns:** `null|false|array` — `null` at EOF with no context, `false` on parse error, or `array{ 'entry' => Translation_Entry, 'lineno' => int }`.

**State machine contexts:** `comment`, `msgctxt`, `msgid`, `msgid_plural`, `msgstr`, `msgstr_plural`.

**Behavior:** Supports multi-line continuation strings (bare `"..."` lines). Uses `read_line()` with put-back support for look-ahead.

---

### `read_line( $f, $action = 'read' )` *(static-like)*

Reads a line from a file handle with put-back support.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$f` | resource | File handle |
| `$action` | string | `'read'` (default), `'put-back'` (re-read last line next call), or `'clear'` (reset state) |

**Returns:** `bool|string` — The line, or `true` for `put-back`/`clear` actions.

Normalizes `\r\n` line endings to `\n`.

---

### `add_comment_to_entry( &$entry, $po_comment_line )`

Parses a PO comment line and adds it to the appropriate entry field.

**Comment types by prefix:**
| Prefix | Entry field | Parsing |
|--------|-------------|---------|
| `#:` | `$references` | Split on whitespace |
| `#.` | `$extracted_comments` | Appended with newline |
| `#,` | `$flags` | Split on `, ` |
| Other (`# `) | `$translator_comments` | Appended with newline |

---

### `trim_quotes( $s )` *(static)*

Removes leading and trailing double quotes from a string.

**Returns:** `string`

---

### `is_final( $context )` *(protected, static)*

Helper: returns `true` if the parser context is `'msgstr'` or `'msgstr_plural'` (i.e., we've completed reading an entry).
