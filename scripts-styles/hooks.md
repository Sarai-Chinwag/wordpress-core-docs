# Scripts & Styles Hooks

Actions and filters for the WordPress scripts and styles system.

---

## Actions

### wp_enqueue_scripts

Primary hook for enqueueing front-end scripts and styles.

```php
do_action( 'wp_enqueue_scripts' );
```

**Since:** 2.8.0  
**Location:** Runs early in `wp_head()`

**Example:**

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'my-theme', get_stylesheet_uri() );
    wp_enqueue_script( 'my-app', get_template_directory_uri() . '/js/app.js', array( 'jquery' ), '1.0', true );
} );
```

---

### admin_enqueue_scripts

Hook for enqueueing scripts and styles in admin.

```php
do_action( 'admin_enqueue_scripts', string $hook_suffix );
```

**Since:** 2.8.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hook_suffix` | string | Current admin page (e.g., `'edit.php'`, `'post.php'`) |

**Example:**

```php
add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( 'edit.php' !== $hook ) {
        return;
    }
    wp_enqueue_script( 'my-admin', plugins_url( 'js/admin.js', __FILE__ ) );
} );
```

---

### login_enqueue_scripts

Hook for enqueueing scripts and styles on login page.

```php
do_action( 'login_enqueue_scripts' );
```

**Since:** 3.1.0

---

### wp_print_scripts

Fires before scripts are printed.

```php
do_action( 'wp_print_scripts' );
```

**Since:** 2.1.0  
**Note:** Fires once per page load. Use `wp_enqueue_scripts` for enqueueing.

---

### wp_print_styles

Fires before styles are printed.

```php
do_action( 'wp_print_styles' );
```

**Since:** 2.6.0

---

### wp_print_footer_scripts

Fires when footer scripts are printed.

```php
do_action( 'wp_print_footer_scripts' );
```

**Since:** 2.8.0

**Note:** Use to add inline scripts at end of body.

---

### wp_default_scripts

Fires when WP_Scripts is initialized.

```php
do_action_ref_array( 'wp_default_scripts', array( WP_Scripts &$wp_scripts ) );
```

**Since:** 2.6.0

**Use Case:** Register default scripts, modify script properties.

**Example:**

```php
add_action( 'wp_default_scripts', function( $scripts ) {
    // Modify jQuery-migrate behavior
    $scripts->add_data( 'jquery-migrate', 'group', 1 );
} );
```

---

### wp_default_styles

Fires when WP_Styles is initialized.

```php
do_action_ref_array( 'wp_default_styles', array( WP_Styles &$wp_styles ) );
```

**Since:** 2.6.0

---

### enqueue_block_assets

Fires after enqueueing block assets for editor and front-end.

```php
do_action( 'enqueue_block_assets' );
```

**Since:** 5.0.0

**Use Case:** Enqueue assets needed by blocks in both contexts.

---

### enqueue_block_editor_assets

Fires after enqueueing block assets for editor only.

```php
do_action( 'enqueue_block_editor_assets' );
```

**Since:** 5.0.0

---

## Filters

### script_loader_tag

Filters the HTML script tag.

```php
apply_filters( 'script_loader_tag', string $tag, string $handle, string $src ): string
```

**Since:** 4.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag` | string | Complete `<script>` tag |
| `$handle` | string | Script handle |
| `$src` | string | Script source URL |

**Example:**

```php
add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
    if ( 'my-module' === $handle ) {
        return str_replace( '<script', '<script type="module"', $tag );
    }
    return $tag;
}, 10, 3 );
```

---

### script_loader_src

Filters the script source URL.

```php
apply_filters( 'script_loader_src', string $src, string $handle ): string
```

**Since:** 2.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$src` | string | Script URL |
| `$handle` | string | Script handle |

**Example:**

```php
add_filter( 'script_loader_src', function( $src, $handle ) {
    // Use CDN for jQuery
    if ( 'jquery-core' === $handle ) {
        return 'https://cdn.example.com/jquery.min.js';
    }
    return $src;
}, 10, 2 );
```

---

### style_loader_tag

Filters the HTML link tag for stylesheets.

```php
apply_filters( 'style_loader_tag', string $tag, string $handle, string $href, string $media ): string
```

**Since:** 2.6.0, 4.3.0 (`$href`), 4.5.0 (`$media`)

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag` | string | Complete `<link>` tag |
| `$handle` | string | Style handle |
| `$href` | string | Stylesheet URL |
| `$media` | string | Media attribute |

**Example:**

```php
add_filter( 'style_loader_tag', function( $tag, $handle, $href, $media ) {
    if ( 'my-async-style' === $handle ) {
        // Convert to preload + async load
        return sprintf(
            '<link rel="preload" href="%s" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">',
            esc_url( $href )
        );
    }
    return $tag;
}, 10, 4 );
```

---

### style_loader_src

Filters the stylesheet source URL.

```php
apply_filters( 'style_loader_src', string $src, string $handle ): string
```

**Since:** 2.6.0

---

### print_scripts_array

Filters the list of script handles to print.

```php
apply_filters( 'print_scripts_array', string[] $to_do ): string[]
```

**Since:** 2.3.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$to_do` | string[] | Script handles about to be printed |

**Example:**

```php
add_filter( 'print_scripts_array', function( $to_do ) {
    // Remove a script conditionally
    if ( ! is_admin() ) {
        $to_do = array_diff( $to_do, array( 'debug-script' ) );
    }
    return $to_do;
} );
```

---

### print_styles_array

Filters the list of style handles to print.

```php
apply_filters( 'print_styles_array', string[] $to_do ): string[]
```

**Since:** 2.6.0

---

### print_head_scripts

Filters whether to print head scripts.

```php
apply_filters( 'print_head_scripts', bool $print ): bool
```

**Since:** 2.8.0

**Default:** `true`

---

### print_footer_scripts

Filters whether to print footer scripts.

```php
apply_filters( 'print_footer_scripts', bool $print ): bool
```

**Since:** 2.8.0

---

### print_admin_styles

Filters whether to print admin styles.

```php
apply_filters( 'print_admin_styles', bool $print ): bool
```

**Since:** 2.8.0

---

### print_late_styles

Filters whether to print late-enqueued styles.

```php
apply_filters( 'print_late_styles', bool $print ): bool
```

**Since:** 3.3.0

---

### mejs_settings

Filters MediaElement.js configuration.

```php
apply_filters( 'mejs_settings', array $settings ): array
```

**Since:** 4.4.0

---

### heartbeat_settings

Filters Heartbeat API settings.

```php
apply_filters( 'heartbeat_settings', array $settings ): array
```

**Since:** 3.6.0

---

### tiny_mce_plugins

Filters TinyMCE plugins.

```php
apply_filters( 'tiny_mce_plugins', string[] $plugins, string $editor_id ): string[]
```

**Since:** 3.3.0

---

### mce_buttons

Filters TinyMCE toolbar buttons (row 1).

```php
apply_filters( 'mce_buttons', string[] $buttons, string $editor_id ): string[]
```

---

### mce_buttons_2

Filters TinyMCE toolbar buttons (row 2).

```php
apply_filters( 'mce_buttons_2', string[] $buttons, string $editor_id ): string[]
```

---

### wp_editor_settings

Filters wp_editor() settings.

```php
apply_filters( 'wp_editor_settings', array $settings, string $editor_id ): array
```

---

### tiny_mce_before_init

Filters TinyMCE init settings.

```php
apply_filters( 'tiny_mce_before_init', array $settings, string $editor_id ): array
```

---

## Common Patterns

### Defer all scripts

```php
add_filter( 'script_loader_tag', function( $tag, $handle ) {
    if ( is_admin() ) {
        return $tag;
    }
    if ( strpos( $tag, 'defer' ) !== false ) {
        return $tag;
    }
    return str_replace( '<script ', '<script defer ', $tag );
}, 10, 2 );
```

### Add integrity attribute

```php
add_filter( 'script_loader_tag', function( $tag, $handle, $src ) {
    $integrity = array(
        'jquery-core' => 'sha384-abc123...',
    );
    if ( isset( $integrity[ $handle ] ) ) {
        $tag = str_replace(
            "src='$src'",
            "src='$src' integrity='{$integrity[$handle]}' crossorigin='anonymous'",
            $tag
        );
    }
    return $tag;
}, 10, 3 );
```

### Conditionally remove scripts

```php
add_action( 'wp_enqueue_scripts', function() {
    if ( ! is_singular( 'post' ) ) {
        wp_dequeue_script( 'comment-reply' );
    }
}, 100 );
```

### Add nonce to inline script

```php
add_filter( 'script_loader_tag', function( $tag, $handle ) {
    $nonce = wp_create_nonce( 'csp-nonce' );
    return str_replace( '<script', "<script nonce='$nonce'", $tag );
}, 10, 2 );
```
