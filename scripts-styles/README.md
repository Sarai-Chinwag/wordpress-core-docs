# Scripts & Styles API

The Scripts and Styles API provides functions for properly loading JavaScript and CSS in WordPress.

**Since:** WordPress 2.1.0 (scripts), 2.6.0 (styles)

## Overview

WordPress uses a dependency management system for assets:

- Register scripts/styles with dependencies
- Enqueue them when needed
- WordPress handles load order automatically
- Prevents duplicate loading

## Enqueueing Scripts

### wp_enqueue_script()

Adds a JavaScript file to the page.

```php
wp_enqueue_script(
    string           $handle,
    string           $src = '',
    array            $deps = array(),
    string|bool|null $ver = false,
    array|bool       $args = array()
): void
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$handle` | string | Unique identifier |
| `$src` | string | URL to script file |
| `$deps` | array | Script handles this depends on |
| `$ver` | string/bool | Version (false = WP version) |
| `$args` | array/bool | `true` = footer, or array of args |

**Examples:**

```php
add_action( 'wp_enqueue_scripts', function() {
    // Basic usage
    wp_enqueue_script(
        'my-script',
        plugins_url( 'js/script.js', __FILE__ ),
        array( 'jquery' ),
        '1.0.0',
        true  // Load in footer
    );
    
    // With strategy (defer/async)
    wp_enqueue_script(
        'my-script',
        plugins_url( 'js/script.js', __FILE__ ),
        array(),
        '1.0.0',
        array(
            'in_footer' => true,
            'strategy'  => 'defer',  // or 'async'
        )
    );
} );
```

---

### wp_register_script()

Registers a script without enqueueing.

```php
wp_register_script(
    string           $handle,
    string           $src,
    array            $deps = array(),
    string|bool|null $ver = false,
    array|bool       $args = array()
): bool
```

**Example:**

```php
// Register once
wp_register_script( 'my-lib', plugins_url( 'js/lib.js', __FILE__ ) );

// Enqueue conditionally
if ( is_singular( 'product' ) ) {
    wp_enqueue_script( 'my-lib' );
}
```

---

### wp_dequeue_script() / wp_deregister_script()

```php
// Remove a script from loading
wp_dequeue_script( 'jquery-migrate' );

// Completely unregister (can re-register with different source)
wp_deregister_script( 'jquery' );
wp_register_script( 'jquery', 'https://cdn.example.com/jquery.min.js' );
```

---

## Enqueueing Styles

### wp_enqueue_style()

Adds a CSS file to the page.

```php
wp_enqueue_style(
    string           $handle,
    string           $src = '',
    array            $deps = array(),
    string|bool|null $ver = false,
    string           $media = 'all'
): void
```

**Examples:**

```php
add_action( 'wp_enqueue_scripts', function() {
    // Basic usage
    wp_enqueue_style(
        'my-style',
        plugins_url( 'css/style.css', __FILE__ ),
        array(),
        '1.0.0'
    );
    
    // With media query
    wp_enqueue_style(
        'my-print-style',
        plugins_url( 'css/print.css', __FILE__ ),
        array(),
        '1.0.0',
        'print'
    );
    
    // Responsive breakpoint
    wp_enqueue_style(
        'my-mobile-style',
        plugins_url( 'css/mobile.css', __FILE__ ),
        array(),
        '1.0.0',
        'screen and (max-width: 768px)'
    );
} );
```

---

### wp_register_style()

Registers a style without enqueueing.

```php
wp_register_style( 'my-component', plugins_url( 'css/component.css', __FILE__ ) );

// Enqueue later when needed
wp_enqueue_style( 'my-component' );
```

---

## Inline Scripts & Styles

### wp_add_inline_script()

Adds inline JavaScript after a script.

```php
wp_enqueue_script( 'my-script', ... );

wp_add_inline_script( 'my-script', '
    const MY_CONFIG = ' . wp_json_encode( array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'my_nonce' ),
    ) ) . ';
', 'before' );  // 'before' or 'after' (default)
```

### wp_add_inline_style()

Adds inline CSS after a stylesheet.

```php
wp_enqueue_style( 'my-style', ... );

$custom_css = '
    .my-element {
        background-color: ' . esc_attr( get_theme_mod( 'bg_color', '#ffffff' ) ) . ';
    }
';
wp_add_inline_style( 'my-style', $custom_css );
```

---

## Localization (Passing Data to JS)

### wp_localize_script()

Passes PHP data to JavaScript.

```php
wp_enqueue_script( 'my-script', ... );

wp_localize_script( 'my-script', 'MyScriptData', array(
    'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
    'nonce'     => wp_create_nonce( 'my_action' ),
    'postId'    => get_the_ID(),
    'i18n'      => array(
        'loading' => __( 'Loading...', 'my-plugin' ),
        'error'   => __( 'An error occurred', 'my-plugin' ),
    ),
) );
```

In JavaScript:
```js
console.log( MyScriptData.ajaxUrl );
console.log( MyScriptData.i18n.loading );
```

### wp_set_script_translations()

Loads translations for JavaScript.

```php
wp_set_script_translations( 'my-script', 'my-plugin', plugin_dir_path( __FILE__ ) . 'languages' );
```

In JavaScript:
```js
import { __ } from '@wordpress/i18n';
const message = __( 'Hello', 'my-plugin' );
```

---

## Script Modules (ES Modules)

**Since:** WordPress 6.5.0

### wp_register_script_module()

Registers an ES module.

```php
wp_register_script_module(
    'my-module',
    plugins_url( 'js/module.js', __FILE__ ),
    array( '@wordpress/interactivity' ),
    '1.0.0'
);
```

### wp_enqueue_script_module()

```php
wp_enqueue_script_module( 'my-module' );
```

---

## Hooks

### wp_enqueue_scripts

Frontend scripts and styles.

```php
add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' );
```

### admin_enqueue_scripts

Admin scripts and styles. Receives current admin page.

```php
add_action( 'admin_enqueue_scripts', function( $hook ) {
    // Only on specific admin pages
    if ( 'settings_page_my-plugin' !== $hook ) {
        return;
    }
    
    wp_enqueue_script( 'my-admin-script', ... );
} );
```

### login_enqueue_scripts

Login page assets.

```php
add_action( 'login_enqueue_scripts', 'my_login_styles' );
```

### enqueue_block_editor_assets

Block editor (Gutenberg) assets.

```php
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_script( 'my-block-script', ... );
} );
```

---

## Core Script Handles

Common built-in scripts you can use as dependencies:

| Handle | Library |
|--------|---------|
| `jquery` | jQuery |
| `jquery-ui-core` | jQuery UI Core |
| `jquery-ui-dialog` | jQuery UI Dialog |
| `wp-api-fetch` | WordPress API Fetch |
| `wp-element` | React wrapper |
| `wp-components` | WordPress Components |
| `wp-blocks` | Block API |
| `wp-data` | Data stores |
| `wp-hooks` | JS Hooks API |
| `wp-i18n` | Internationalization |
| `lodash` | Lodash utilities |
| `moment` | Moment.js |

---

## Loading Strategies

**Since:** WordPress 6.3.0

```php
wp_enqueue_script( 'my-script', $src, array(), '1.0', array(
    'strategy' => 'defer',  // Options: 'defer', 'async'
) );
```

| Strategy | Behavior |
|----------|----------|
| (none) | Blocks rendering, executes in order |
| `defer` | Downloads parallel, executes after HTML parse |
| `async` | Downloads parallel, executes immediately |

---

## Best Practices

1. **Use handles consistently** — Same handle = same script
2. **Set dependencies** — Let WordPress order scripts
3. **Version your assets** — Cache busting on updates
4. **Load in footer** — When possible, for performance
5. **Conditional loading** — Only load where needed
6. **Use built-in scripts** — Don't bundle jQuery twice
7. **Minify for production** — Use `.min.js` versions
8. **Use `defer` or `async`** — For non-critical scripts
