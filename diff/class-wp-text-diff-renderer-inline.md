# WP_Text_Diff_Renderer_inline

Inline diff renderer with improved word splitting for multilingual support.

**Source:** `wp-includes/class-wp-text-diff-renderer-inline.php`  
**Since:** 2.6.0 (class), 4.7.0 (separate file)  
**Extends:** `Text_Diff_Renderer_inline`

## Purpose

This class improves upon the PEAR `Text_Diff_Renderer_inline` by providing better word splitting that handles Unicode characters properly. It's used internally by `WP_Text_Diff_Renderer_Table` to generate word-level diffs within changed lines.

## Properties

Uses `#[AllowDynamicProperties]` attribute for PHP 8.2+ compatibility.

---

## Methods

### _splitOnWords()

Splits a string into an array of words and delimiters for comparison.

```php
public function _splitOnWords( string $string, string $newlineEscape = "\n" ): array
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$string` | string | — | Text to split into words |
| `$newlineEscape` | string | `"\n"` | Replacement for newline characters |

**Returns:** Array of words and delimiter characters.

### Improvements Over PEAR

The parent PEAR class uses a simpler word-splitting regex that may not handle Unicode properly. WordPress's version:

1. **Removes null bytes** — Strips `\0` characters to prevent issues
2. **Unicode-aware splitting** — Uses `/([^\w])/u` with the `u` (Unicode) flag
3. **Preserves all delimiters** — Uses `PREG_SPLIT_DELIM_CAPTURE` to keep punctuation

### Algorithm

```php
// 1. Remove null bytes
$string = str_replace( "\0", '', $string );

// 2. Split on non-word characters (Unicode-aware)
$words = preg_split( '/([^\w])/u', $string, -1, PREG_SPLIT_DELIM_CAPTURE );

// 3. Escape newlines
$words = str_replace( "\n", $newlineEscape, $words );

return $words;
```

---

## Usage

This class is typically not used directly. It's instantiated by `WP_Text_Diff_Renderer_Table::_changed()` to compute word-level diffs:

```php
// Inside WP_Text_Diff_Renderer_Table::_changed()
$text_diff = new Text_Diff( 'auto', array( array( $orig_line ), array( $final_line ) ) );
$renderer = new $this->inline_diff_renderer(); // WP_Text_Diff_Renderer_inline
$diff = $renderer->render( $text_diff );

// $diff contains: "The quick <del>brown</del><ins>red</ins> fox"
```

---

## Output Format

The parent `Text_Diff_Renderer_inline` class (from PEAR) produces output with `<ins>` and `<del>` tags:

```html
The quick <del>brown</del><ins>red</ins> fox jumped
```

When rendered by `WP_Text_Diff_Renderer_Table`, this is separated:

- **Deleted column:** `The quick <del>brown</del> fox jumped` (with `<ins>` tags stripped)
- **Added column:** `The quick <ins>red</ins> fox jumped` (with `<del>` tags stripped)

---

## Customizing

To use a different inline renderer, set the property on the table renderer:

```php
class My_Inline_Renderer extends WP_Text_Diff_Renderer_inline {
    public function _splitOnWords( $string, $newlineEscape = "\n" ) {
        // Custom word splitting logic
        // Perhaps treating hyphenated words as single units
        $string = str_replace( "\0", '', $string );
        $words = preg_split( '/(\s+|[^\w-])/u', $string, -1, PREG_SPLIT_DELIM_CAPTURE );
        $words = str_replace( "\n", $newlineEscape, $words );
        return $words;
    }
}

class My_Table_Renderer extends WP_Text_Diff_Renderer_Table {
    protected $inline_diff_renderer = 'My_Inline_Renderer';
}
```

---

## Unicode Example

```php
// Japanese text comparison
$old = "こんにちは世界";
$new = "こんにちは宇宙";

// WP_Text_Diff_Renderer_inline correctly splits on character boundaries
// Output: こんにちは<del>世界</del><ins>宇宙</ins>
```

---

## Related Files

| File | Description |
|------|-------------|
| `Text/Diff/Renderer/inline.php` | Parent PEAR class |
| `Text/Diff/Renderer.php` | Base renderer class |
| `class-wp-text-diff-renderer-table.php` | Main table renderer that uses this |
