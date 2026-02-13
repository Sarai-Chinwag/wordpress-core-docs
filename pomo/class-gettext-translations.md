# Gettext_Translations

Extends `Translations` with gettext-specific functionality: plural form expression parsing, header management, and dynamic plural form selection from the `Plural-Forms` header.

**Source:** `wp-includes/pomo/translations.php`
**Since:** 2.8.0
**Extends:** `Translations`

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$_nplurals` | int | Number of plural forms (parsed from `Plural-Forms` header) |
| `$_gettext_select_plural_form` | callable | Callback that returns the plural form index for a given count |

---

## Methods

### `gettext_select_plural_form( $count )`

Selects the plural form index using the `Plural-Forms` header expression.

**Since:** 2.8.0

On first call, lazily parses the `Plural-Forms` header via `nplurals_and_expression_from_header()`, creates the plural form function via `make_plural_form_function()`, and caches both `$_nplurals` and `$_gettext_select_plural_form`.

**Returns:** `int` — 0-based plural form index.

---

### `nplurals_and_expression_from_header( $header )`

Parses the `Plural-Forms` header string.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$header` | string | The `Plural-Forms` header value (e.g., `nplurals=2; plural=n != 1;`) |

**Returns:** `array{0: int, 1: string}` — Array of `[nplurals, expression]`.

**Behavior:** Uses regex `/^\s*nplurals\s*=\s*(\d+)\s*;\s+plural\s*=\s*(.+)$/` to parse. Falls back to `[2, 'n != 1']` if parsing fails.

---

### `make_plural_form_function( $nplurals, $expression )`

Creates a callable that evaluates the plural expression for a given count.

**Since:** 2.8.0

**Returns:** `callable` — An array callback `[$handler, 'get']` where `$handler` is a `Plural_Forms` instance.

**Behavior:** Strips trailing semicolons from the expression, creates a `Plural_Forms` instance. On exception, recursively falls back to `make_plural_form_function(2, 'n != 1')`.

---

### `parenthesize_plural_exression( $expression )` *(deprecated)*

Adds parentheses to ternary operators in plural expressions for correct PHP evaluation (PHP evaluates ternary left-to-right unlike C).

**Since:** 2.8.0
**Deprecated:** 6.5.0 — Use the `Plural_Forms` class instead.

**Note:** Method name contains a typo (`exression` instead of `expression`) — this is intentional/historical.

**Returns:** `string` — Expression with parentheses added around ternary branches.

---

### `make_headers( $translation )`

Parses a raw header translation string into an associative array.

**Since:** 2.8.0

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$translation` | string | Raw header string (literal `\n` sequences are converted to real newlines) |

**Returns:** `array<string, string>` — Parsed headers keyed by header name.

**Behavior:** Splits on newlines, then splits each line on the first `:`. Both key and value are trimmed.

---

### `set_header( $header, $value )`

Overrides parent to additionally re-parse the `Plural-Forms` header when it is set, updating `$_nplurals` and `$_gettext_select_plural_form`.

**Since:** 2.8.0
