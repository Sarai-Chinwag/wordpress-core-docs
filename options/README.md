# Options API

The Options API provides a simple way to store and retrieve settings in the WordPress database.

**Since:** WordPress 1.0.0

## Overview

Options are key-value pairs stored in the `wp_options` table. They're used for:

- Plugin settings
- Theme settings  
- Site configuration
- Cached data

## Core Functions

### get_option()

Retrieves an option value.

```php
get_option( string $option, mixed $default = false ): mixed
```

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$option` | string | — | Option name |
| `$default` | mixed | false | Default if option doesn't exist |

**Examples:**

```php
// Get site title
$title = get_option( 'blogname' );

// With default value
$setting = get_option( 'my_plugin_setting', 'default_value' );

// Get array option
$settings = get_option( 'my_plugin_settings', array() );
$color = $settings['color'] ?? '#000000';
```

---

### update_option()

Updates or creates an option.

```php
update_option( 
    string $option, 
    mixed  $value, 
    bool   $autoload = null 
): bool
```

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$option` | string | — | Option name |
| `$value` | mixed | — | New value |
| `$autoload` | bool | null | Load on every page (null = auto) |

**Examples:**

```php
// Simple value
update_option( 'my_plugin_version', '1.2.0' );

// Array value
update_option( 'my_plugin_settings', array(
    'enabled' => true,
    'color'   => '#ff0000',
    'limit'   => 10,
) );

// Disable autoload for large/rarely-used options
update_option( 'my_plugin_cache', $large_data, false );
```

---

### add_option()

Adds a new option (only if it doesn't exist).

```php
add_option( 
    string $option, 
    mixed  $value = '', 
    string $deprecated = '', 
    bool   $autoload = true 
): bool
```

**Example:**

```php
// Set default on plugin activation
add_option( 'my_plugin_settings', array(
    'enabled' => true,
    'limit'   => 5,
) );
```

---

### delete_option()

Removes an option.

```php
delete_option( string $option ): bool
```

**Example:**

```php
// On plugin uninstall
delete_option( 'my_plugin_settings' );
delete_option( 'my_plugin_version' );
```

---

## Transients

Transients are options with expiration times, useful for caching.

### set_transient()

Stores a transient value.

```php
set_transient( string $transient, mixed $value, int $expiration = 0 ): bool
```

**Examples:**

```php
// Cache API response for 1 hour
$data = fetch_external_api();
set_transient( 'my_api_cache', $data, HOUR_IN_SECONDS );

// Cache for 1 day
set_transient( 'my_daily_cache', $data, DAY_IN_SECONDS );

// Never expire (use 0, but then it's just an option)
set_transient( 'my_permanent_cache', $data, 0 );
```

### get_transient()

Retrieves a transient value.

```php
get_transient( string $transient ): mixed
```

**Example:**

```php
$data = get_transient( 'my_api_cache' );

if ( false === $data ) {
    // Cache expired or doesn't exist
    $data = fetch_external_api();
    set_transient( 'my_api_cache', $data, HOUR_IN_SECONDS );
}

return $data;
```

### delete_transient()

Removes a transient.

```php
delete_transient( string $transient ): bool
```

---

## Time Constants

WordPress provides these constants for transient expiration:

| Constant | Seconds |
|----------|---------|
| `MINUTE_IN_SECONDS` | 60 |
| `HOUR_IN_SECONDS` | 3600 |
| `DAY_IN_SECONDS` | 86400 |
| `WEEK_IN_SECONDS` | 604800 |
| `MONTH_IN_SECONDS` | 2592000 |
| `YEAR_IN_SECONDS` | 31536000 |

---

## Site Options (Multisite)

For network-wide options in multisite:

```php
// Get network option
get_site_option( 'network_setting' );

// Update network option
update_site_option( 'network_setting', $value );

// Delete network option  
delete_site_option( 'network_setting' );

// Network transients
get_site_transient( 'network_cache' );
set_site_transient( 'network_cache', $data, HOUR_IN_SECONDS );
delete_site_transient( 'network_cache' );
```

---

## Autoloading

Options with `autoload = 'yes'` are loaded into memory on every page load. This is efficient for frequently-used options but wastes memory for large or rarely-used data.

### Guidelines

| Autoload | When to Use |
|----------|-------------|
| `true` (default) | Small settings used on every page |
| `false` | Large data, admin-only settings, caches |

### Check Autoloaded Options

```sql
SELECT option_name, LENGTH(option_value) as size 
FROM wp_options 
WHERE autoload = 'yes' 
ORDER BY size DESC 
LIMIT 20;
```

---

## Filters

### option_{$option}

Filters an option value after retrieval.

```php
add_filter( 'option_blogname', function( $value ) {
    return $value . ' - My Site';
} );
```

### pre_option_{$option}

Short-circuits option retrieval.

```php
add_filter( 'pre_option_my_setting', function( $pre ) {
    // Return a value to skip database lookup
    return 'forced_value';
} );
```

### pre_update_option_{$option}

Filters value before saving.

```php
add_filter( 'pre_update_option_my_setting', function( $value, $old_value ) {
    // Validate or modify before save
    return sanitize_text_field( $value );
}, 10, 2 );
```

---

## Settings API

For admin settings pages, use the Settings API:

### register_setting()

Registers a setting for a settings page.

```php
register_setting( 
    string $option_group, 
    string $option_name, 
    array  $args = array() 
): void
```

**Example:**

```php
add_action( 'admin_init', function() {
    register_setting( 'my_plugin_options', 'my_plugin_settings', array(
        'type'              => 'array',
        'sanitize_callback' => 'my_sanitize_settings',
        'default'           => array( 'enabled' => false ),
    ) );
} );
```

### add_settings_section() / add_settings_field()

```php
add_action( 'admin_init', function() {
    add_settings_section(
        'my_section',
        'My Settings Section',
        '__return_false',
        'my-plugin-settings'
    );
    
    add_settings_field(
        'my_field',
        'Enable Feature',
        'render_my_field',
        'my-plugin-settings',
        'my_section'
    );
} );
```

---

## Best Practices

1. **Prefix option names** — `myplugin_settings`, not `settings`
2. **Use arrays for grouped settings** — One option vs. many
3. **Set autoload appropriately** — False for large/admin-only data
4. **Delete on uninstall** — Clean up your options
5. **Sanitize before save** — Never trust user input
6. **Use transients for caching** — Not permanent options
7. **Default values** — Always provide sensible defaults
