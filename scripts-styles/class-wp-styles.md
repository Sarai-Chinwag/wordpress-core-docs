# WP_Styles

Core class for registering and outputting CSS stylesheets.

**Source:** `wp-includes/class-wp-styles.php`  
**Since:** 2.6.0  
**Extends:** [WP_Dependencies](./class-wp-dependencies.md)

## Properties

### Public Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$base_url` | string | 2.6.0 | Base URL for styles (trailing slash) |
| `$content_url` | string | 2.8.0 | URL of wp-content directory |
| `$default_version` | string | 2.6.0 | Default version string |
| `$text_direction` | string | 2.6.0 | Text direction (`'ltr'` or `'rtl'`) |
| `$concat` | string | 2.8.0 | Handles to concatenate |
| `$concat_version` | string | 2.8.0 | Deprecated (3.4.0) |
| `$do_concat` | bool | 2.8.0 | Whether to concatenate |
| `$print_html` | string | 2.8.0 | HTML markup when concatenating |
| `$print_code` | string | 3.3.0 | Inline styles when concatenating |
| `$default_dirs` | array | 2.8.0 | Default style directories |

### Private Properties

| Property | Type | Since | Description |
|----------|------|-------|-------------|
| `$type_attr` | string | 5.3.0 | Type attribute for style tags (empty for HTML5) |

---

## Methods

### __construct()

Initializes the styles object and fires initialization action.

```php
public function __construct()
```

**Since:** 2.6.0

**Behavior:**
- Sets `$type_attr` to `" type='text/css'"` if theme doesn't support HTML5 styles
- Fires `wp_default_styles` action

**Hooks:**

```php
do_action_ref_array( 'wp_default_styles', array( &$this ) );
```

---

### do_item()

Processes and outputs a single stylesheet.

```php
public function do_item(
    string $handle,
    int|false $group = false
): bool
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Style handle |
| `$group` | int\|false | Group level |

**Returns:** `true` on success, `false` on failure.

**Behavior:**
- Skips styles with conditional comments
- Builds version query string
- Outputs inline styles after main stylesheet
- Handles RTL stylesheets when `$text_direction` is `'rtl'`
- Applies `style_loader_tag` filter

**RTL Handling:**
- `rtl => true` or `rtl => 'replace'`: Loads `*-rtl.css` (replaces original if `'replace'`)
- `rtl => 'url'`: Loads specified RTL URL

---

### add_inline_style()

Adds inline CSS to a registered stylesheet.

```php
public function add_inline_style(
    string $handle,
    string $code
): bool
```

**Since:** 3.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Style handle |
| `$code` | string | CSS code |

**Returns:** `true` on success, `false` on failure.

**Note:** Inline styles are always added after the main stylesheet.

---

### print_inline_style()

Prints inline styles for a handle.

```php
public function print_inline_style(
    string $handle,
    bool $display = true
): string|bool
```

**Since:** 3.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Style handle |
| `$display` | bool | Print or return |

**Returns:** `false` if no data, inline styles if `$display` true, `true` otherwise.

**Note:** Adds `sourceURL` comment for debugging when not concatenating.

---

### add_data()

Adds data to a registered stylesheet with special handling for conditionals.

```php
public function add_data(
    string $handle,
    string $key,
    mixed $value
): bool
```

**Since:** 6.9.0

| Key | Effect |
|-----|--------|
| `conditional` | Clears dependencies (stylesheet will be ignored) |

**Returns:** `true` on success, `false` on failure.

---

### all_deps()

Determines all dependencies for given handles.

```php
public function all_deps(
    string|string[] $handles,
    bool $recursion = false,
    int|false $group = false
): bool
```

**Since:** 2.6.0

**Hooks:**

```php
$this->to_do = apply_filters( 'print_styles_array', $this->to_do );
```

---

### _css_href()

Generates fully-qualified URL for a stylesheet.

```php
public function _css_href(
    string $src,
    string $ver,
    string $handle
): string
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$src` | string | Source URL or path |
| `$ver` | string | Version string |
| `$handle` | string | Style handle |

**Returns:** Fully-qualified, escaped URL.

**Hooks:**

```php
$src = apply_filters( 'style_loader_src', $src, $handle );
```

---

### in_default_dir()

Checks if source is in a default directory.

```php
public function in_default_dir( string $src ): bool
```

**Since:** 2.8.0

**Returns:** `true` if in default directory.

---

### do_footer_items()

Processes styles enqueued late (in body).

```php
public function do_footer_items(): string[]
```

**Since:** 3.3.0

**Returns:** Handles of processed styles.

**Note:** HTML5 allows styles in body; this outputs late-enqueued styles.

---

### reset()

Resets concatenation properties.

```php
public function reset(): void
```

**Since:** 3.3.0

Clears: `do_concat`, `concat`, `concat_version`, `print_html`

---

### get_dependency_warning_message()

Gets localized warning message for missing dependencies.

```php
protected function get_dependency_warning_message(
    string $handle,
    string[] $missing_dependency_handles
): string
```

**Since:** 6.9.1

---

## Style Data Keys

Use `wp_style_add_data()` or `$wp_styles->add_data()`:

| Key | Type | Description |
|-----|------|-------------|
| `rtl` | bool\|string | RTL handling: `true`, `'replace'`, or URL |
| `suffix` | string | Suffix for RTL file (e.g., `.min`) |
| `alt` | bool | `rel="alternate stylesheet"` |
| `title` | string | Stylesheet title (for alternate) |
| `path` | string | Absolute path (enables inlining in 5.8.0+) |
| `conditional` | string | Deprecated, stylesheet ignored |

---

## RTL Support Examples

### Replace with RTL version

```php
wp_register_style( 'my-style', 'css/style.css' );
wp_style_add_data( 'my-style', 'rtl', 'replace' );
// In RTL: loads css/style-rtl.css instead
```

### Add RTL version alongside LTR

```php
wp_register_style( 'my-style', 'css/style.css' );
wp_style_add_data( 'my-style', 'rtl', true );
// In RTL: loads both style.css AND style-rtl.css
```

### Custom RTL URL

```php
wp_register_style( 'my-style', 'css/style.css' );
wp_style_add_data( 'my-style', 'rtl', 'css/custom-rtl.css' );
// In RTL: loads custom-rtl.css
```

### With suffix

```php
wp_register_style( 'my-style', 'css/style.min.css' );
wp_style_add_data( 'my-style', 'rtl', 'replace' );
wp_style_add_data( 'my-style', 'suffix', '.min' );
// In RTL: loads css/style-rtl.min.css
```

---

## Alternate Stylesheets

```php
wp_register_style( 'theme-dark', 'css/dark.css' );
wp_style_add_data( 'theme-dark', 'alt', true );
wp_style_add_data( 'theme-dark', 'title', 'Dark Mode' );
wp_enqueue_style( 'theme-dark' );
// Output: <link rel='alternate stylesheet' title='Dark Mode' ...>
```

---

## Inline Style Optimization (5.8.0+)

Stylesheets with a `path` set may be inlined if small enough:

```php
wp_register_style( 'small-style', 'css/small.css' );
wp_style_add_data( 'small-style', 'path', ABSPATH . 'wp-content/themes/my-theme/css/small.css' );
// If file is small, contents are inlined instead of linked
```
