# Text Diff API

System for computing and rendering differences between two text strings, commonly used for revision comparison.

**Since:** 2.6.0  
**Source:** `wp-includes/wp-diff.php`, `wp-includes/pluggable.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Main diff generation function |
| [class-wp-text-diff-renderer-table.md](./class-wp-text-diff-renderer-table.md) | Table-based diff renderer |
| [class-wp-text-diff-renderer-inline.md](./class-wp-text-diff-renderer-inline.md) | Inline word diff renderer |
| [hooks.md](./hooks.md) | Filters for customizing diff output |

## Architecture

WordPress uses the PEAR Text_Diff library as its foundation, with custom renderers for WordPress-specific HTML output.

```
wp_text_diff()
    ├── normalize_whitespace() - Clean input strings
    ├── Text_Diff - PEAR library computes diff operations
    └── WP_Text_Diff_Renderer_Table
            ├── _added() / _deleted() / _context()
            └── _changed()
                    └── WP_Text_Diff_Renderer_inline
                            └── Word-by-word highlighting
```

## PEAR Text_Diff Components

WordPress bundles these PEAR library files:

| File | Purpose |
|------|---------|
| `Text/Diff.php` | Core diff computation |
| `Text/Diff/Renderer.php` | Base renderer class |
| `Text/Diff/Renderer/inline.php` | Inline diff renderer |
| `Text/Diff/Engine/native.php` | Pure PHP diff engine |
| `Text/Diff/Engine/xdiff.php` | xdiff extension engine |
| `Text/Exception.php` | Exception handling |

## Usage

### Basic Comparison

```php
$old = "The quick brown fox";
$new = "The quick red fox";

$diff = wp_text_diff( $old, $new );
// Returns HTML table showing "brown" deleted, "red" added
```

### With Titles

```php
$diff = wp_text_diff( $old, $new, array(
    'title'       => 'Content Comparison',
    'title_left'  => 'Original',
    'title_right' => 'Modified',
) );
```

### Single Column View

```php
$diff = wp_text_diff( $old, $new, array(
    'show_split_view' => false,
) );
```

## Output Structure

The diff output is an HTML table with accessible markup:

```html
<table class="diff is-split-view">
    <caption class="diff-title">Title</caption>
    <thead>
        <tr class="diff-sub-title">
            <th>Original</th>
            <th>Modified</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="diff-deletedline">
                <span class="dashicons dashicons-minus"></span>
                <span class="screen-reader-text">Deleted:</span>
                old text with <del>removed</del>
            </td>
            <td class="diff-addedline">
                <span class="dashicons dashicons-plus"></span>
                <span class="screen-reader-text">Added:</span>
                new text with <ins>added</ins>
            </td>
        </tr>
    </tbody>
</table>
```

## CSS Classes

| Class | Description |
|-------|-------------|
| `.diff` | Container table |
| `.is-split-view` | Two-column layout enabled |
| `.diff-title` | Caption element |
| `.diff-sub-title` | Header row with column titles |
| `.diff-addedline` | Cell containing additions |
| `.diff-deletedline` | Cell containing deletions |
| `.diff-context` | Cell containing unchanged text |

## Core Usage

WordPress uses this system for:

- **Post Revisions** — Comparing revision content in the admin
- **Plugin/Theme Editor** — Showing file changes before saving
- **Customizer** — Comparing customizer settings
- **Import/Export** — Displaying content differences

## Diff Threshold

When comparing changed lines, word-level diffs are only shown if the lines are similar enough (< 60% different). This prevents confusing output when lines are completely rewritten.

```php
// In WP_Text_Diff_Renderer_Table
protected $_diff_threshold = 0.6;
```

## Related Functions

| Function | Description |
|----------|-------------|
| `normalize_whitespace()` | Normalizes whitespace before comparison |
| `wp_save_post_revision()` | Creates revisions that can be compared |
| `wp_get_post_revisions()` | Retrieves revisions for comparison |
