# WP_Text_Diff_Renderer_Table

Table-based renderer for displaying diff output in a two-column HTML table format.

**Source:** `wp-includes/class-wp-text-diff-renderer-table.php`  
**Since:** 2.6.0  
**Extends:** `Text_Diff_Renderer`

## Properties

### Public Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$_leading_context_lines` | int | `10000` | Lines of context before changes |
| `$_trailing_context_lines` | int | `10000` | Lines of context after changes |
| `$_title` | string\|null | `null` | Title of compared item |
| `$_title_left` | string\|null | `null` | Left column title |
| `$_title_right` | string\|null | `null` | Right column title |

### Protected Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$_diff_threshold` | float | `0.6` | Max difference ratio for word-level diffs |
| `$inline_diff_renderer` | string | `'WP_Text_Diff_Renderer_inline'` | Class for inline word diffs |
| `$_show_split_view` | bool | `true` | Enable two-column layout |
| `$compat_fields` | array | `[...]` | Fields exposed via magic methods |
| `$count_cache` | array | `[]` | Character count cache |
| `$difference_cache` | array | `[]` | String distance cache |

---

## Methods

### __construct()

Creates a new table renderer with optional configuration.

```php
public function __construct( array $params = array() )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$params` | array | Configuration options |

**Params:**

| Key | Type | Description |
|-----|------|-------------|
| `show_split_view` | bool | Enable two-column layout |

---

### render()

Renders the diff as HTML table rows. Inherited from `Text_Diff_Renderer`.

```php
public function render( Text_Diff $diff ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$diff` | Text_Diff | Diff object to render |

**Returns:** HTML string of table rows (`<tr>` elements).

---

### addedLine()

Generates HTML for an added line cell.

```php
public function addedLine( string $line ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$line` | string | HTML-escaped line content |

**Returns:** `<td class='diff-addedline'>...</td>` with plus icon and screen reader text.

---

### deletedLine()

Generates HTML for a deleted line cell.

```php
public function deletedLine( string $line ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$line` | string | HTML-escaped line content |

**Returns:** `<td class='diff-deletedline'>...</td>` with minus icon and screen reader text.

---

### contextLine()

Generates HTML for an unchanged context line cell.

```php
public function contextLine( string $line ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$line` | string | HTML-escaped line content |

**Returns:** `<td class='diff-context'>...</td>` with screen reader text.

---

### emptyLine()

Generates HTML for an empty placeholder cell.

```php
public function emptyLine(): string
```

**Returns:** `<td>&nbsp;</td>`

---

### _added()

Renders added lines with optional encoding.

```php
public function _added( array $lines, bool $encode = true ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$lines` | array | Lines that were added |
| `$encode` | bool | Whether to HTML-encode content |

**Returns:** HTML rows for added content.

**Applies Filter:** `process_text_diff_html` with context `'added'`

---

### _deleted()

Renders deleted lines with optional encoding.

```php
public function _deleted( array $lines, bool $encode = true ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$lines` | array | Lines that were deleted |
| `$encode` | bool | Whether to HTML-encode content |

**Returns:** HTML rows for deleted content.

**Applies Filter:** `process_text_diff_html` with context `'deleted'`

---

### _context()

Renders unchanged context lines with optional encoding.

```php
public function _context( array $lines, bool $encode = true ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$lines` | array | Unchanged lines |
| `$encode` | bool | Whether to HTML-encode content |

**Returns:** HTML rows for context (duplicated in both columns for split view).

**Applies Filter:** `process_text_diff_html` with context `'unchanged'`

---

### _changed()

Processes changed lines with word-level diff highlighting.

```php
public function _changed( array $orig, array $final ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$orig` | array | Original lines |
| `$final` | array | Final/modified lines |

**Returns:** HTML rows with `<ins>` and `<del>` tags for word-level changes.

**Algorithm:**

1. Interleave lines to match similar content
2. Compute word-level diffs using inline renderer
3. Apply threshold check (skip highlighting if too different)
4. Render side-by-side or stacked based on view mode

---

### interleave_changed_lines()

Matches original and final lines to align similar content.

```php
public function interleave_changed_lines( array $orig, array $final ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$orig` | array | Original lines |
| `$final` | array | Final lines |

**Returns:** Array with four elements:

| Index | Key | Description |
|-------|-----|-------------|
| 0 | `$orig_matches` | Map of orig index → final index (or 'x' for deleted) |
| 1 | `$final_matches` | Map of final index → orig index (or 'x' for added) |
| 2 | `$orig_rows` | Interleaved row indices with blanks (-1) |
| 3 | `$final_rows` | Interleaved row indices with blanks (-1) |

---

### compute_string_distance()

Computes a distance metric between two strings.

```php
public function compute_string_distance( string $string1, string $string2 ): int
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$string1` | string | First string |
| `$string2` | string | Second string |

**Returns:** Distance score (lower = more similar). Based on L1-norm of character frequency difference.

**Uses caching** for performance with `$count_cache` and `$difference_cache`.

---

### difference()

Computes absolute difference between two values.

```php
public function difference( int $a, int $b ): int
```

Used internally by `compute_string_distance()`.

---

## Magic Methods

For backward compatibility, protected properties are accessible via magic methods:

| Method | Purpose |
|--------|---------|
| `__get()` | Read protected properties |
| `__set()` | Write protected properties |
| `__isset()` | Check if property is set |
| `__unset()` | Unset a property |

**Deprecated since 6.4.0** — Accessing undefined dynamic properties triggers deprecation notice.

---

## Diff Threshold

The `$_diff_threshold` (default 0.6) controls when word-level highlighting is shown:

```php
// If more than 60% of content changed, skip word highlighting
if ( $diff_ratio > $this->_diff_threshold ) {
    continue; // Show as plain deleted/added without <ins>/<del>
}
```

This prevents confusing output when lines are completely rewritten.

---

## Split vs. Single View

**Split view (default):**

```html
<tr>
    <td class="diff-deletedline">old content</td>
    <td class="diff-addedline">new content</td>
</tr>
```

**Single column view:**

```html
<tr>
    <td class="diff-deletedline">old content</td>
</tr>
<tr>
    <td class="diff-addedline">new content</td>
</tr>
```

---

## Extending

```php
class My_Diff_Renderer extends WP_Text_Diff_Renderer_Table {
    
    // Lower threshold for more word-level diffs
    protected $_diff_threshold = 0.8;
    
    // Custom added line styling
    public function addedLine( $line ) {
        return "<td class='my-added'>{$line}</td>";
    }
}

// Use custom renderer
$renderer = new My_Diff_Renderer();
$output = $renderer->render( $text_diff );
```
