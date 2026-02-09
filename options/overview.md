# Options API

Framework for storing and retrieving site-wide configuration data in WordPress.

**Since:** 1.0.0  
**Source:** `wp-includes/option.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core option and transient functions |
| [hooks.md](./hooks.md) | Actions and filters |

## Core Concepts

### Options vs Transients

| Feature | Options | Transients |
|---------|---------|------------|
| Expiration | Permanent | Time-limited |
| Storage | `wp_options` table | Object cache or `wp_options` |
| Use case | Settings, config | Cached data, API responses |
| Prefix | None | `_transient_` |

### Autoloading

Options can be autoloaded on every page request. Control with the `$autoload` parameter:

| Value | Behavior |
|-------|----------|
| `true` / `'on'` | Always autoload |
| `false` / `'off'` | Never autoload |
| `null` | WordPress determines (default) |
| `'auto-on'` | Auto-determined, currently on |
| `'auto-off'` | Auto-determined, currently off |

**Best practice:** Autoload options used on every request. Don't autoload large or rarely-used options.

## Option Flow

```
get_option()
    ├── pre_option_{$option} filter (short-circuit)
    ├── pre_option filter (short-circuit)
    ├── Check alloptions cache
    ├── Check notoptions cache
    ├── Check individual option cache
    ├── Query database
    ├── Cache result
    ├── default_option_{$option} filter (if not found)
    └── option_{$option} filter (on value)
```

## Update Flow

```
update_option()
    ├── pre_update_option_{$option} filter
    ├── pre_update_option filter
    ├── Compare old/new values
    ├── do_action('update_option')
    ├── Database UPDATE
    ├── Update cache
    ├── do_action('update_option_{$option}')
    └── do_action('updated_option')
```

## Transient Flow

```
set_transient()
    ├── pre_set_transient_{$transient} filter
    ├── expiration_of_transient_{$transient} filter
    ├── External object cache? → wp_cache_set()
    ├── No cache? → add_option() or update_option()
    ├── Store timeout in _transient_timeout_{$transient}
    ├── do_action('set_transient_{$transient}')
    └── do_action('set_transient')
```

## Multisite

Network-wide options use separate functions:

| Single Site | Network/Site Option |
|-------------|---------------------|
| `get_option()` | `get_site_option()` / `get_network_option()` |
| `add_option()` | `add_site_option()` / `add_network_option()` |
| `update_option()` | `update_site_option()` / `update_network_option()` |
| `delete_option()` | `delete_site_option()` / `delete_network_option()` |

Network options are stored in the `wp_sitemeta` table.

## Database Schema

### wp_options Table

| Column | Type | Description |
|--------|------|-------------|
| `option_id` | bigint | Primary key |
| `option_name` | varchar(191) | Unique option name |
| `option_value` | longtext | Serialized or raw value |
| `autoload` | varchar(20) | Autoload status |

## Settings API Integration

Options can be registered with the Settings API for admin UI integration:

```php
register_setting( 'my_group', 'my_option', array(
    'type'              => 'string',
    'sanitize_callback' => 'sanitize_text_field',
    'show_in_rest'      => true,
    'default'           => 'default_value',
) );
```
