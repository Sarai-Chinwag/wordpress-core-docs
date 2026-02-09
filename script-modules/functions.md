# Script Modules Functions

Global functions for registering and managing script modules.

**Source:** `wp-includes/script-modules.php`

---

## wp_script_modules()

Retrieves the main `WP_Script_Modules` instance.

```php
function wp_script_modules(): WP_Script_Modules
```

**Since:** 6.5.0

### Description

Provides access to the singleton `WP_Script_Modules` instance, creating one if it doesn't exist yet. This is the central registry for all script modules.

### Return

`WP_Script_Modules` — The main script modules instance.

### Example

```php
// Access the registry directly
$registry = wp_script_modules();
$queue = $registry->get_queue();
```

---

## wp_register_script_module()

Registers the script module if no script module with that identifier has already been registered.

```php
function wp_register_script_module(
    string $id,
    string $src,
    array $deps = array(),
    $version = false,
    array $args = array()
)
```

**Since:** 6.5.0  
**Updated:** 6.9.0 — Added the `$args` parameter.

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | Unique identifier for the script module. Used in the import map. |
| `$src` | `string` | Full URL or path relative to WordPress root. |
| `$deps` | `array` | List of dependencies. See Dependencies section below. |
| `$version` | `string\|false\|null` | Version for cache busting. `false` = WP version, `null` = none. |
| `$args` | `array` | Additional arguments. See Args section below. |

### Dependencies Array

Each dependency can be a string or an array:

```php
// Simple string dependency (static import)
$deps = array( '@wordpress/interactivity' );

// Array with import type
$deps = array(
    array(
        'id'     => '@wordpress/interactivity',
        'import' => 'static'  // or 'dynamic'
    )
);

// Mixed
$deps = array(
    '@wordpress/interactivity',  // static
    array( 'id' => 'lazy-module', 'import' => 'dynamic' )
);
```

| Import Type | Behavior |
|-------------|----------|
| `'static'` | Preloaded via `<link rel="modulepreload">`, included in import map |
| `'dynamic'` | Only in import map, for runtime `import()` calls |

### Args Array

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `in_footer` | `bool` | `false` | Print in footer (block themes only) |
| `fetchpriority` | `string` | `'auto'` | `'auto'`, `'low'`, or `'high'` |

### Example

```php
// Basic registration
wp_register_script_module(
    'my-plugin/gallery',
    plugins_url( 'js/gallery.js', __FILE__ ),
    array( '@wordpress/interactivity' ),
    '1.0.0'
);

// With all options
wp_register_script_module(
    'my-plugin/heavy-feature',
    plugins_url( 'js/heavy-feature.js', __FILE__ ),
    array(
        '@wordpress/interactivity',
        array( 'id' => 'my-plugin/utils', 'import' => 'dynamic' )
    ),
    '2.0.0',
    array(
        'in_footer'     => true,
        'fetchpriority' => 'low'
    )
);
```

---

## wp_enqueue_script_module()

Marks the script module to be enqueued in the page.

```php
function wp_enqueue_script_module(
    string $id,
    string $src = '',
    array $deps = array(),
    $version = false,
    array $args = array()
)
```

**Since:** 6.5.0  
**Updated:** 6.9.0 — Added the `$args` parameter.

### Parameters

Same as `wp_register_script_module()`.

### Description

If a `$src` is provided and the script module has not been registered yet, it will be registered automatically. This allows registration and enqueuing in a single call.

### Example

```php
// Enqueue a previously registered module
wp_enqueue_script_module( 'my-plugin/gallery' );

// Register and enqueue in one call
wp_enqueue_script_module(
    'my-plugin/lightbox',
    plugins_url( 'js/lightbox.js', __FILE__ ),
    array( '@wordpress/interactivity' ),
    '1.0.0'
);
```

---

## wp_dequeue_script_module()

Unmarks the script module so it is no longer enqueued in the page.

```php
function wp_dequeue_script_module( string $id )
```

**Since:** 6.5.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | The identifier of the script module. |

### Example

```php
// Remove a module from the queue
wp_dequeue_script_module( 'some-plugin/unwanted-module' );
```

---

## wp_deregister_script_module()

Deregisters the script module.

```php
function wp_deregister_script_module( string $id )
```

**Since:** 6.5.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | `string` | The identifier of the script module. |

### Description

Removes the script module from the registry entirely. Also dequeues it if it was enqueued.

### Example

```php
// Remove a module completely
wp_deregister_script_module( 'some-plugin/unwanted-module' );
```

---

## wp_default_script_modules()

Registers all the default WordPress Script Modules.

```php
function wp_default_script_modules()
```

**Since:** 6.7.0

### Description

Called automatically during WordPress initialization. Registers all core script modules from `wp-includes/js/dist/script-modules/`.

### Registered Modules

| Module ID | Description |
|-----------|-------------|
| `@wordpress/interactivity` | Interactivity API runtime (or `/debug` in SCRIPT_DEBUG) |
| `@wordpress/interactivity-router` | Client-side navigation support |
| `@wordpress/block-library/*` | View scripts for core blocks |
| `@wordpress/a11y` | Accessibility announcements |

### Default Settings

Core modules are registered with:
- `fetchpriority: 'low'` — Not critical for initial render
- `in_footer: true` — Printed in footer

Block library modules also receive client-side navigation support via `WP_Interactivity::add_client_navigation_support_to_script_module()`.
