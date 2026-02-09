# Script Modules API

Native support for ES Modules and Import Maps in WordPress.

**Since:** 6.5.0  
**Source:** `wp-includes/script-modules.php`, `wp-includes/class-wp-script-modules.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration and enqueue functions |
| [class-wp-script-modules.md](./class-wp-script-modules.md) | Script modules registry class |
| [hooks.md](./hooks.md) | Actions and filters |

## What Are Script Modules?

Script Modules are WordPress's implementation of native ES Modules (ESM). Unlike traditional scripts loaded with `wp_enqueue_script()`, script modules:

- Use `<script type="module">` tags
- Support native `import`/`export` syntax
- Leverage browser import maps for dependency resolution
- Are deferred by default (no blocking)
- Have module scope (not global)

## Import Maps

Import maps allow bare module specifiers (like `@wordpress/interactivity`) to resolve to actual URLs. WordPress automatically generates an import map containing all registered script modules and their dependencies.

```html
<script type="importmap" id="wp-importmap">
{
  "imports": {
    "@wordpress/interactivity": "/wp-includes/js/dist/script-modules/interactivity/index.min.js?ver=6.7"
  }
}
</script>
```

## Registration Flow

```
wp_register_script_module( $id, $src, $deps, $version, $args )
    └── WP_Script_Modules::register()
            └── Store in $registered array
```

## Enqueue Flow

```
wp_enqueue_script_module( $id )
    └── WP_Script_Modules::enqueue()
            └── Add to $queue array
```

## Output Flow

```
add_hooks()
    ├── wp_head (block themes) or wp_footer (classic themes)
    │       ├── print_import_map()
    │       └── print_script_module_preloads()
    │
    ├── wp_head (block themes only)
    │       └── print_head_enqueued_script_modules()
    │
    └── wp_footer
            ├── print_enqueued_script_modules()
            ├── print_script_module_data()
            └── print_a11y_script_module_html()
```

## Block Themes vs Classic Themes

| Behavior | Block Themes | Classic Themes |
|----------|--------------|----------------|
| Import map location | `wp_head` | `wp_footer` |
| Head script modules | Supported (`in_footer: false`) | Not supported |
| Module preloads | `wp_head` | `wp_footer` |

In classic themes, script modules used by blocks aren't known at `wp_head`, so everything prints in the footer.

## Dependencies

Dependencies can be static or dynamic:

```php
// Static dependency (preloaded, in import map)
wp_register_script_module( 'my-module', $src, array( 'other-module' ) );

// Dynamic dependency (in import map only, not preloaded)
wp_register_script_module( 'my-module', $src, array(
    array( 'id' => 'lazy-module', 'import' => 'dynamic' )
) );
```

- **Static**: Loaded immediately via `<link rel="modulepreload">` and included in import map
- **Dynamic**: Only included in import map for runtime `import()` calls

## Fetch Priority

Script modules support the `fetchpriority` attribute (since 6.9.0):

```php
wp_register_script_module( 'critical-module', $src, array(), false, array(
    'fetchpriority' => 'high'
) );
```

| Value | Behavior |
|-------|----------|
| `'auto'` | Browser default (default) |
| `'low'` | Lower priority, non-critical path |
| `'high'` | Higher priority, critical path |

WordPress core modules (`@wordpress/interactivity`, `@wordpress/block-library/*`, `@wordpress/a11y`) use `fetchpriority: low` and `in_footer: true` since they're not needed for critical rendering.

## Default Script Modules

WordPress registers these modules via `wp_default_script_modules()`:

| Module ID | Description |
|-----------|-------------|
| `@wordpress/interactivity` | Interactivity API runtime |
| `@wordpress/interactivity-router` | Client-side navigation |
| `@wordpress/block-library/*` | Block-specific view scripts |
| `@wordpress/a11y` | Accessibility announcements |

## Example Usage

### Register and Enqueue

```php
// Register a script module
wp_register_script_module(
    'my-plugin/gallery',
    plugin_dir_url( __FILE__ ) . 'js/gallery.js',
    array( '@wordpress/interactivity' ),
    '1.0.0'
);

// Enqueue it
wp_enqueue_script_module( 'my-plugin/gallery' );
```

### Register and Enqueue in One Call

```php
wp_enqueue_script_module(
    'my-plugin/gallery',
    plugin_dir_url( __FILE__ ) . 'js/gallery.js',
    array( '@wordpress/interactivity' ),
    '1.0.0'
);
```

### Passing Data to Modules

```php
add_filter( 'script_module_data_my-plugin/gallery', function( $data ) {
    $data['apiEndpoint'] = rest_url( 'my-plugin/v1/images' );
    $data['nonce'] = wp_create_nonce( 'wp_rest' );
    return $data;
} );
```

In JavaScript:

```javascript
const dataEl = document.getElementById( 'wp-script-module-data-my-plugin/gallery' );
const data = dataEl ? JSON.parse( dataEl.textContent ) : {};
console.log( data.apiEndpoint );
```

## Best Practices

1. **Use namespaced IDs**: `my-plugin/module-name` prevents collisions
2. **Prefer static dependencies**: Only use dynamic for lazy-loaded code
3. **Set appropriate fetchpriority**: Use `low` for non-critical modules
4. **Use `in_footer` for non-critical modules**: Especially in block themes
5. **Don't mix with `wp_enqueue_script()`**: Keep ES modules separate from classic scripts
