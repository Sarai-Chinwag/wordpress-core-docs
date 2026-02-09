# Script Modules Hooks

Actions and filters for customizing script module behavior.

**Source:** `wp-includes/class-wp-script-modules.php`

---

## Filters

### script_module_loader_src

Filters the script module source URL.

```php
apply_filters( 'script_module_loader_src', string $src, string $id )
```

**Since:** 6.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$src` | `string` | Module source URL (with version query param). |
| `$id` | `string` | Module identifier. |

#### Return

`string` — Filtered source URL. Non-string returns become empty string.

#### Example

```php
// Use a CDN for certain modules
add_filter( 'script_module_loader_src', function( $src, $id ) {
    if ( str_starts_with( $id, '@wordpress/' ) ) {
        return str_replace(
            site_url( '/wp-includes/' ),
            'https://cdn.example.com/wp/',
            $src
        );
    }
    return $src;
}, 10, 2 );
```

```php
// Add integrity hash
add_filter( 'script_module_loader_src', function( $src, $id ) {
    if ( 'my-plugin/main' === $id ) {
        // Note: This modifies URL, not the tag attributes
        // For SRI, you'd need to filter the tag output
    }
    return $src;
}, 10, 2 );
```

---

### script_module_data_{$module_id}

Filters data associated with a specific script module.

```php
apply_filters( "script_module_data_{$module_id}", array $data )
```

**Since:** 6.7.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | `array` | Data to embed for this module. Default empty array. |

#### Return

`array` — Filtered data. If empty array, nothing is embedded.

#### Description

Data passed through this filter is JSON-serialized and embedded in the page as a `<script type="application/json">` tag with ID `wp-script-module-data-{$module_id}`.

This is useful for passing configuration, nonces, or other data that the module needs immediately on load, without requiring an additional API request.

#### Example: Passing Configuration

```php
add_filter( 'script_module_data_my-plugin/gallery', function( $data ) {
    $data['config'] = array(
        'apiEndpoint' => rest_url( 'my-plugin/v1/images' ),
        'nonce'       => wp_create_nonce( 'wp_rest' ),
        'maxItems'    => 50,
    );
    return $data;
} );
```

#### Example: Passing User Data

```php
add_filter( 'script_module_data_my-plugin/dashboard', function( $data ) {
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $data['user'] = array(
            'id'       => $user->ID,
            'name'     => $user->display_name,
            'canEdit'  => current_user_can( 'edit_posts' ),
        );
    }
    return $data;
} );
```

#### Reading Data in JavaScript

```javascript
// In your ES module
function getModuleData( moduleId ) {
    const el = document.getElementById( `wp-script-module-data-${ moduleId }` );
    if ( el ) {
        try {
            return JSON.parse( el.textContent );
        } catch ( e ) {
            console.error( 'Failed to parse module data:', e );
        }
    }
    return {};
}

// Usage
const data = getModuleData( 'my-plugin/gallery' );
console.log( data.config.apiEndpoint );
```

#### Output

```html
<script type="application/json" id="wp-script-module-data-my-plugin/gallery">
{"config":{"apiEndpoint":"https://example.com/wp-json/my-plugin/v1/images","nonce":"abc123","maxItems":50}}
</script>
```

---

## Internal Hooks

These hooks are used by WordPress internally but can be leveraged:

### wp_head / wp_footer / admin_print_footer_scripts

`WP_Script_Modules::add_hooks()` attaches output methods to these standard WordPress hooks:

| Hook | Block Themes | Classic Themes | Admin |
|------|--------------|----------------|-------|
| `wp_head` | import map, preloads, head modules | — | — |
| `wp_footer` | footer modules, data, a11y HTML | all output | — |
| `admin_print_footer_scripts` | — | — | all output |

You can use these hooks to add your own module-related output:

```php
// Add custom importmap entries (advanced)
add_action( 'wp_head', function() {
    // Note: This is a workaround. Prefer wp_register_script_module().
    echo '<script type="importmap-shim">{"imports":{"custom":"..."}}</script>';
}, 1 ); // Before WordPress prints its import map
```

---

## No Hook: Registration Timing

Unlike `wp_enqueue_scripts`, there's no dedicated hook for script module registration. Register modules when your code loads:

```php
// In a plugin
add_action( 'init', function() {
    wp_register_script_module(
        'my-plugin/main',
        plugins_url( 'js/main.js', __FILE__ ),
        array( '@wordpress/interactivity' ),
        '1.0.0'
    );
} );

// Enqueue when needed (e.g., in a block's render callback)
add_action( 'render_block_my-plugin/gallery', function( $content ) {
    wp_enqueue_script_module( 'my-plugin/main' );
    return $content;
} );
```

Or use `wp_enqueue_scripts` for frontend modules:

```php
add_action( 'wp_enqueue_scripts', function() {
    if ( is_singular( 'gallery' ) ) {
        wp_enqueue_script_module( 'my-plugin/gallery' );
    }
} );
```

---

## Hook Priorities

When working with script modules, be aware of default priorities:

| Method | Hook | Priority |
|--------|------|----------|
| `print_import_map` | `wp_head`/`wp_footer` | 10 |
| `print_script_module_preloads` | `wp_head`/`wp_footer` | 10 |
| `print_head_enqueued_script_modules` | `wp_head` | 10 |
| `print_enqueued_script_modules` | `wp_footer` | 10 |
| `print_script_module_data` | `wp_footer` | 10 |
| `print_a11y_script_module_html` | `wp_footer` | 20 |

The a11y HTML prints at priority 20 to ensure it comes after the data.
