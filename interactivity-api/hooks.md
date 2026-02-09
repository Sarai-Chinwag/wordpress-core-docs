# Interactivity API Hooks

Filters for customizing Interactivity API behavior.

**Source:** `wp-includes/interactivity-api/class-wp-interactivity-api.php`

---

## Filters

### script_module_data_@wordpress/interactivity

Filters the data passed to the `@wordpress/interactivity` script module.

```php
apply_filters( 'script_module_data_@wordpress/interactivity', array $data )
```

**Since:** 6.7.0 (via `WP_Interactivity_API::add_hooks()`)

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$data` | `array` | Data to pass to the script module |

**Default Data Structure:**
```php
array(
    'state'  => array(
        'namespace1' => array( /* state data */ ),
        'namespace2' => array( /* state data */ ),
    ),
    'config' => array(
        'namespace1' => array( /* config data */ ),
    ),
    'derivedStateClosures' => array(
        'namespace1' => array( 'path.to.derived', 'another.derived' ),
    ),
)
```

**Example:**
```php
add_filter(
    'script_module_data_@wordpress/interactivity',
    function( $data ) {
        // Add global state
        $data['state']['myPlugin'] = array(
            'apiRoot' => rest_url(),
            'nonce'   => wp_create_nonce( 'wp_rest' ),
        );
        return $data;
    }
);
```

---

### script_module_data_@wordpress/interactivity-router

Filters the data passed to the `@wordpress/interactivity-router` script module.

```php
apply_filters( 'script_module_data_@wordpress/interactivity-router', array $data )
```

**Since:** 6.7.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$data` | `array` | Data to pass to the router module |

**Default Data Structure:**
```php
array(
    'i18n' => array(
        'loading' => 'Loading page, please wait.',
        'loaded'  => 'Page Loaded.',
    ),
)
```

**Example:**
```php
add_filter(
    'script_module_data_@wordpress/interactivity-router',
    function( $data ) {
        // Customize loading messages
        $data['i18n']['loading'] = __( 'Loading...', 'my-plugin' );
        return $data;
    }
);
```

---

### wp_script_attributes

Filters script tag attributes (used to add router options).

```php
apply_filters( 'wp_script_attributes', array $attributes )
```

**Since:** 6.9.0 (via `WP_Interactivity_API::add_hooks()`)

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$attributes` | `array` | Script tag attributes |

**Interactivity API Usage:**
The Interactivity API uses this filter to add `data-wp-router-options` to script modules marked as compatible with client-side navigation.

**Resulting Attribute:**
```html
<script type="module" id="my-module-js-module" data-wp-router-options='{"loadOnClientNavigation":true}' src="..."></script>
```

---

## Actions

### wp_footer

Used to output router loading bar markup.

```php
add_action( 'wp_footer', array( $this, 'print_router_markup' ) )
```

**Since:** 6.5.0 (triggered by `data-wp-router-region` processing)

**Condition:** Only added when `data-wp-router-region` directive is found.

**Output:**
```html
<div
    class="wp-interactivity-router-loading-bar"
    data-wp-interactive="core/router"
    data-wp-class--start-animation="state.navigation.hasStarted"
    data-wp-class--finish-animation="state.navigation.hasFinished"
></div>
```

---

## Internal Hooks

These are used internally but can be observed:

### Inline Style Registration

When `data-wp-router-region` is processed:

```php
wp_register_style( 'wp-interactivity-router-animations', false );
wp_add_inline_style( 'wp-interactivity-router-animations', $css );
wp_enqueue_style( 'wp-interactivity-router-animations' );
```

This adds the loading bar animation CSS to the page.

---

## Usage Patterns

### Adding Custom State Server-Side

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_interactivity_state( 'myPlugin', array(
        'userId'   => get_current_user_id(),
        'isAdmin'  => current_user_can( 'manage_options' ),
        'settings' => get_option( 'my_plugin_settings', array() ),
    ) );
} );
```

### Adding Custom Config

```php
add_action( 'wp_enqueue_scripts', function() {
    wp_interactivity_config( 'myPlugin', array(
        'apiEndpoint' => rest_url( 'my-plugin/v1/' ),
        'maxItems'    => 10,
    ) );
} );
```

### Enabling Client Navigation for Script Modules

```php
add_action( 'init', function() {
    wp_interactivity()->add_client_navigation_support_to_script_module( 'my-module' );
} );
```
