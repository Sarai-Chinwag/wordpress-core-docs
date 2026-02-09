# Text Diff Functions

Core function for generating human-readable diff output.

**Source:** `wp-includes/pluggable.php`

---

## wp_text_diff()

Displays a human-readable HTML representation of the difference between two strings.

**Since:** 2.6.0  
**Pluggable:** Yes — can be overridden in a plugin

```php
wp_text_diff( string $left_string, string $right_string, string|array $args = null ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$left_string` | string | "Old" (left) version of string |
| `$right_string` | string | "New" (right) version of string |
| `$args` | string\|array | Optional configuration |

### Args

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `title` | string | `''` | Title displayed in table caption |
| `title_left` | string | `''` | Header for left/original column |
| `title_right` | string | `''` | Header for right/modified column |
| `show_split_view` | bool | `true` | Two columns (true) or single column (false) |

### Returns

- `string` — HTML table showing differences
- `string` (empty) — If strings are equivalent after whitespace normalization

### Processing Flow

1. Parse arguments with `wp_parse_args()`
2. Load `wp-diff.php` if needed
3. Normalize whitespace on both strings
4. Split strings into lines
5. Create `Text_Diff` object
6. Render with `WP_Text_Diff_Renderer_Table`
7. Wrap output in accessible HTML table

### Example: Basic Usage

```php
$old_content = "Hello world.\nThis is a test.";
$new_content = "Hello world.\nThis is a modified test.";

$diff = wp_text_diff( $old_content, $new_content );
echo $diff;
```

### Example: With Column Headers

```php
$diff = wp_text_diff( $old_content, $new_content, array(
    'title'       => __( 'Content Changes' ),
    'title_left'  => __( 'Revision 42' ),
    'title_right' => __( 'Current Version' ),
) );
```

### Example: Single Column View

```php
// Useful for narrow layouts or mobile
$diff = wp_text_diff( $old_content, $new_content, array(
    'show_split_view' => false,
) );
```

### Example: Check for Changes

```php
$diff = wp_text_diff( $old_content, $new_content );

if ( empty( $diff ) ) {
    echo 'No changes detected.';
} else {
    echo $diff;
}
```

### Overriding (Pluggable)

This function is pluggable and can be replaced entirely:

```php
// In a must-use plugin (loaded before pluggable.php)
function wp_text_diff( $left_string, $right_string, $args = null ) {
    // Custom implementation
    // Perhaps using a different diff library
    return my_custom_diff( $left_string, $right_string, $args );
}
```

### Internal Notes

- Whitespace is normalized before comparison via `normalize_whitespace()`
- The function loads `wp-diff.php` lazily only when needed
- Empty diff result (no changes) returns empty string, not empty table
- The `is-split-view` class is added to table when split view is enabled
- Column headers use `<th>` when content is provided, `<td>` when empty
