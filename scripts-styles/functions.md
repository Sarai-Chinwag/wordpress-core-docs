# Scripts & Styles Functions

Core functions for managing JavaScript and CSS assets.

**Source:** `wp-includes/functions.wp-scripts.php`, `wp-includes/functions.wp-styles.php`, `wp-includes/script-loader.php`

---

## Script Functions

### wp_scripts()

Initializes and returns the global WP_Scripts instance.

```php
wp_scripts(): WP_Scripts
```

**Since:** 4.2.0

**Returns:** `WP_Scripts` instance.

---

### wp_register_script()

Registers a script for later enqueueing.

```php
wp_register_script(
    string $handle,
    string|false $src,
    string[] $deps = array(),
    string|bool|null $ver = false,
    array|bool $args = array()
): bool
```

**Since:** 2.1.0, 6.3.0 (`$args` array), 6.9.0 (`fetchpriority`)

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Unique script name |
| `$src` | string\|false | Script URL or false for alias |
| `$deps` | string[] | Dependency handles |
| `$ver` | string\|bool\|null | Version (false=WP version, null=none) |
| `$args` | array\|bool | Loading options or boolean for footer |

**Args Array:**

| Key | Type | Description |
|-----|------|-------------|
| `strategy` | string | `'defer'` or `'async'` |
| `in_footer` | bool | Print in footer (default: false) |
| `fetchpriority` | string | `'auto'`, `'low'`, `'high'` |

**Returns:** `true` on success, `false` on failure.

**Example:**

```php
wp_register_script(
    'my-app',
    plugins_url( 'js/app.js', __FILE__ ),
    array( 'jquery', 'wp-api-fetch' ),
    '1.0.0',
    array(
        'strategy'  => 'defer',
        'in_footer' => true,
    )
);
```

---

### wp_enqueue_script()

Enqueues a script for output. Registers if source provided.

```php
wp_enqueue_script(
    string $handle,
    string $src = '',
    string[] $deps = array(),
    string|bool|null $ver = false,
    array|bool $args = array()
): void
```

**Since:** 2.1.0, 6.3.0 (`$args` array)

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$src` | string | Script URL (optional if pre-registered) |
| `$deps` | string[] | Dependencies |
| `$ver` | string\|bool\|null | Version |
| `$args` | array\|bool | Loading options |

**Example:**

```php
// Enqueue pre-registered script
wp_enqueue_script( 'jquery' );

// Register and enqueue in one call
wp_enqueue_script(
    'my-script',
    get_template_directory_uri() . '/js/script.js',
    array( 'jquery' ),
    '1.0.0',
    true
);
```

---

### wp_dequeue_script()

Removes a script from the queue.

```php
wp_dequeue_script( string $handle ): void
```

**Since:** 3.1.0

---

### wp_deregister_script()

Unregisters a script. Protected scripts cannot be deregistered in admin.

```php
wp_deregister_script( string $handle ): void
```

**Since:** 2.1.0

**Protected Handles (admin only):** `jquery`, `jquery-core`, `jquery-migrate`, `jquery-ui-*`, `underscore`, `backbone`

---

### wp_script_is()

Checks script status.

```php
wp_script_is( string $handle, string $status = 'enqueued' ): bool
```

**Since:** 2.8.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$status` | string | `'enqueued'`, `'registered'`, `'queue'`, `'to_do'`, `'done'` |

**Returns:** `true` if script matches status.

---

### wp_script_add_data()

Adds metadata to a registered script.

```php
wp_script_add_data( string $handle, string $key, mixed $value ): bool
```

**Since:** 4.2.0

| Key | Type | Description |
|-----|------|-------------|
| `strategy` | string | `'defer'` or `'async'` |
| `group` | int | 0 (header) or 1 (footer) |

---

### wp_add_inline_script()

Adds inline JavaScript to a registered script.

```php
wp_add_inline_script(
    string $handle,
    string $data,
    string $position = 'after'
): bool
```

**Since:** 4.5.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$data` | string | JavaScript code (no `<script>` tags) |
| `$position` | string | `'before'` or `'after'` |

**Example:**

```php
wp_add_inline_script( 'my-script', 'window.MY_CONFIG = ' . wp_json_encode( $config ) . ';', 'before' );
```

---

### wp_localize_script()

Passes PHP data to JavaScript as a global object.

```php
wp_localize_script(
    string $handle,
    string $object_name,
    array $l10n
): bool
```

**Since:** 2.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$object_name` | string | JavaScript variable name |
| `$l10n` | array | Data array |

**Example:**

```php
wp_localize_script( 'my-script', 'myPluginData', array(
    'ajaxUrl' => admin_url( 'admin-ajax.php' ),
    'nonce'   => wp_create_nonce( 'my_action' ),
    'i18n'    => array(
        'loading' => __( 'Loading...', 'my-plugin' ),
    ),
) );
```

**Output:**

```html
<script>
var myPluginData = {"ajaxUrl":"...","nonce":"...","i18n":{"loading":"Loading..."}};
</script>
```

---

### wp_set_script_translations()

Sets translation text domain for a script.

```php
wp_set_script_translations(
    string $handle,
    string $domain = 'default',
    string $path = ''
): bool
```

**Since:** 5.0.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Script handle |
| `$domain` | string | Text domain |
| `$path` | string | Path to translation files |

**Example:**

```php
wp_set_script_translations( 'my-editor', 'my-plugin', plugin_dir_path( __FILE__ ) . 'languages' );
```

---

### wp_print_scripts()

Prints scripts in the queue.

```php
wp_print_scripts( string|string[]|false $handles = false ): string[]
```

**Since:** 2.1.0

**Returns:** Array of printed script handles.

---

## Style Functions

### wp_styles()

Initializes and returns the global WP_Styles instance.

```php
wp_styles(): WP_Styles
```

**Since:** 4.2.0

**Returns:** `WP_Styles` instance.

---

### wp_register_style()

Registers a stylesheet for later enqueueing.

```php
wp_register_style(
    string $handle,
    string|false $src,
    string[] $deps = array(),
    string|bool|null $ver = false,
    string $media = 'all'
): bool
```

**Since:** 2.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Unique style name |
| `$src` | string\|false | Stylesheet URL or false for alias |
| `$deps` | string[] | Dependency handles |
| `$ver` | string\|bool\|null | Version |
| `$media` | string | Media query (default: `'all'`) |

**Media Examples:** `'all'`, `'screen'`, `'print'`, `'(min-width: 768px)'`

**Example:**

```php
wp_register_style(
    'my-theme-style',
    get_stylesheet_uri(),
    array( 'dashicons' ),
    wp_get_theme()->get( 'Version' )
);
```

---

### wp_enqueue_style()

Enqueues a stylesheet for output.

```php
wp_enqueue_style(
    string $handle,
    string $src = '',
    string[] $deps = array(),
    string|bool|null $ver = false,
    string $media = 'all'
): void
```

**Since:** 2.6.0

**Example:**

```php
wp_enqueue_style(
    'my-plugin-admin',
    plugins_url( 'css/admin.css', __FILE__ ),
    array(),
    '1.0.0'
);
```

---

### wp_dequeue_style()

Removes a stylesheet from the queue.

```php
wp_dequeue_style( string $handle ): void
```

**Since:** 3.1.0

---

### wp_deregister_style()

Unregisters a stylesheet.

```php
wp_deregister_style( string $handle ): void
```

**Since:** 2.1.0

---

### wp_style_is()

Checks stylesheet status.

```php
wp_style_is( string $handle, string $status = 'enqueued' ): bool
```

**Since:** 2.8.0

| Status | Description |
|--------|-------------|
| `'enqueued'` | In queue or dependency of queued |
| `'registered'` | Registered (may not be enqueued) |
| `'queue'` | Alias for enqueued |
| `'to_do'` | Will be printed |
| `'done'` | Already printed |

---

### wp_style_add_data()

Adds metadata to a registered stylesheet.

```php
wp_style_add_data( string $handle, string $key, mixed $value ): bool
```

**Since:** 3.6.0

| Key | Type | Description |
|-----|------|-------------|
| `rtl` | bool\|string | `true`, `'replace'`, or RTL URL |
| `suffix` | string | Suffix for RTL (e.g., `.min`) |
| `alt` | bool | Alternate stylesheet |
| `title` | string | Stylesheet title |
| `path` | string | Absolute path (enables inlining) |

**RTL Example:**

```php
wp_register_style( 'my-style', 'style.css' );
wp_style_add_data( 'my-style', 'rtl', 'replace' );
wp_style_add_data( 'my-style', 'suffix', '.min' );
// Loads style-rtl.min.css in RTL mode
```

---

### wp_add_inline_style()

Adds inline CSS to a registered stylesheet.

```php
wp_add_inline_style( string $handle, string $data ): bool
```

**Since:** 3.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | string | Style handle |
| `$data` | string | CSS code (no `<style>` tags) |

**Example:**

```php
$custom_css = sprintf(
    ':root { --primary-color: %s; }',
    esc_attr( get_theme_mod( 'primary_color', '#0073aa' ) )
);
wp_add_inline_style( 'my-theme-style', $custom_css );
```

---

### wp_print_styles()

Prints stylesheets in the queue.

```php
wp_print_styles( string|bool|array $handles = false ): string[]
```

**Since:** 2.6.0

**Returns:** Array of printed style handles.

---

## Output Functions

### wp_print_head_scripts()

Prints scripts queued for the head.

```php
wp_print_head_scripts(): string[]
```

**Since:** 2.8.0

---

### wp_print_footer_scripts()

Fires the footer scripts action.

```php
wp_print_footer_scripts(): void
```

**Since:** 2.8.0

---

### print_head_scripts()

Prints head scripts in admin.

```php
print_head_scripts(): string[]
```

**Since:** 2.8.0

---

### print_footer_scripts()

Prints footer scripts in admin.

```php
print_footer_scripts(): string[]
```

**Since:** 2.8.0

---

### print_admin_styles()

Prints stylesheets in admin head.

```php
print_admin_styles(): string[]
```

**Since:** 2.8.0

---

### print_late_styles()

Prints styles queued after head.

```php
print_late_styles(): array|void
```

**Since:** 3.3.0

---

## Utility Functions

### wp_scripts_get_suffix()

Returns the script suffix based on SCRIPT_DEBUG.

```php
wp_scripts_get_suffix( string $type = '' ): string
```

**Since:** 5.0.0

| Type | SCRIPT_DEBUG=true | SCRIPT_DEBUG=false |
|------|-------------------|---------------------|
| `''` | `''` | `'.min'` |
| `'dev'` | `''` | `'.min'` |

---

### wp_get_script_polyfill()

Generates inline script for conditional polyfill loading.

```php
wp_get_script_polyfill( WP_Scripts $scripts, string[] $tests ): string
```

**Since:** 5.0.0

**Example:**

```php
$polyfill = wp_get_script_polyfill( wp_scripts(), array(
    'fetch' in window' => 'wp-polyfill-fetch',
) );
```

---

### script_concat_settings()

Determines concatenation and compression settings.

```php
script_concat_settings(): void
```

**Since:** 2.8.0

Sets globals: `$concatenate_scripts`, `$compress_scripts`, `$compress_css`
