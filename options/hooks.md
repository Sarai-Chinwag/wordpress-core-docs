# Options API Hooks

Actions and filters for the Options API.

---

## Option Filters

### pre_option_{$option}

Short-circuits option retrieval. Return non-false to bypass database lookup.

```php
apply_filters( "pre_option_{$option}", mixed $pre_option, string $option, mixed $default_value )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pre_option` | mixed | Value to return instead. Default `false` (no short-circuit) |
| `$option` | string | Option name |
| `$default_value` | mixed | The default value passed to `get_option()` |

**Returns:** Value to use, or `false` to continue normal retrieval.

**Example:**

```php
add_filter( 'pre_option_siteurl', function( $pre, $option, $default ) {
    return 'https://example.com'; // Always return this URL
}, 10, 3 );
```

**Since:** 1.5.0  
**Since:** 4.4.0 — `$option` parameter added  
**Since:** 4.9.0 — `$default_value` parameter added

---

### pre_option

Short-circuits retrieval for any option. Runs after `pre_option_{$option}`.

```php
apply_filters( 'pre_option', mixed $pre_option, string $option, mixed $default_value )
```

**Since:** 6.1.0

---

### default_option_{$option}

Filters the default value when option doesn't exist.

```php
apply_filters( "default_option_{$option}", mixed $default_value, string $option, bool $passed_default )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$default_value` | mixed | Default value to return |
| `$option` | string | Option name |
| `$passed_default` | bool | Whether a default was passed to `get_option()` |

**Example:**

```php
add_filter( 'default_option_my_setting', function( $default, $option, $passed ) {
    if ( ! $passed ) {
        return array( 'enabled' => true ); // Provide structured default
    }
    return $default;
}, 10, 3 );
```

**Since:** 3.4.0  
**Since:** 4.4.0 — `$option` parameter added  
**Since:** 4.7.0 — `$passed_default` parameter added

---

### option_{$option}

Filters an existing option's value before returning.

```php
apply_filters( "option_{$option}", mixed $value, string $option )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Option value (unserialized) |
| `$option` | string | Option name |

**Example:**

```php
add_filter( 'option_blogname', function( $value ) {
    return $value . ' - Staging';
} );
```

**Since:** 1.5.0  
**Since:** 4.4.0 — `$option` parameter added

---

### pre_update_option_{$option}

Filters value before update.

```php
apply_filters( "pre_update_option_{$option}", mixed $value, mixed $old_value, string $option )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | New value |
| `$old_value` | mixed | Current value |
| `$option` | string | Option name |

**Example:**

```php
add_filter( 'pre_update_option_my_option', function( $value, $old ) {
    $value['updated_at'] = time();
    return $value;
}, 10, 2 );
```

**Since:** 2.6.0  
**Since:** 4.4.0 — `$option` parameter added

---

### pre_update_option

Filters any option value before update.

```php
apply_filters( 'pre_update_option', mixed $value, string $option, mixed $old_value )
```

**Since:** 3.9.0

---

### pre_add_site_option_{$option}

Filters network option value before adding.

```php
apply_filters( "pre_add_site_option_{$option}", mixed $value, string $option, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### pre_update_site_option_{$option}

Filters network option value before updating.

```php
apply_filters( "pre_update_site_option_{$option}", mixed $value, mixed $old_value, string $option, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### pre_site_option_{$option}

Short-circuits network option retrieval.

```php
apply_filters( "pre_site_option_{$option}", mixed $pre, string $option, int $network_id, mixed $default_value )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added  
**Since:** 4.9.0 — `$default_value` parameter added

---

### pre_site_option

Short-circuits retrieval for any network option.

```php
apply_filters( 'pre_site_option', mixed $pre, string $option, int $network_id, mixed $default_value )
```

**Since:** 6.9.0

---

### default_site_option_{$option}

Filters default value for non-existent network option.

```php
apply_filters( "default_site_option_{$option}", mixed $default_value, string $option, int $network_id )
```

**Since:** 3.4.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### site_option_{$option}

Filters network option value before returning.

```php
apply_filters( "site_option_{$option}", mixed $value, string $option, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

## Option Actions

### update_option

Fires before an option value is updated.

```php
do_action( 'update_option', string $option, mixed $old_value, mixed $value )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option` | string | Option name |
| `$old_value` | mixed | Current value |
| `$value` | mixed | New value |

**Since:** 2.9.0

---

### update_option_{$option}

Fires after a specific option is updated.

```php
do_action( "update_option_{$option}", mixed $old_value, mixed $value, string $option )
```

**Since:** 2.0.1  
**Since:** 4.4.0 — `$option` parameter added

---

### updated_option

Fires after any option is updated.

```php
do_action( 'updated_option', string $option, mixed $old_value, mixed $value )
```

**Since:** 2.9.0

---

### add_option

Fires before an option is added.

```php
do_action( 'add_option', string $option, mixed $value )
```

**Since:** 2.9.0

---

### add_option_{$option}

Fires after a specific option is added.

```php
do_action( "add_option_{$option}", string $option, mixed $value )
```

**Since:** 2.5.0  
**Since:** 3.0.0 — Hook name standardized

---

### added_option

Fires after any option is added.

```php
do_action( 'added_option', string $option, mixed $value )
```

**Since:** 2.9.0

---

### delete_option

Fires before an option is deleted.

```php
do_action( 'delete_option', string $option )
```

**Since:** 2.9.0

---

### delete_option_{$option}

Fires after a specific option is deleted.

```php
do_action( "delete_option_{$option}", string $option )
```

**Since:** 3.0.0

---

### deleted_option

Fires after any option is deleted.

```php
do_action( 'deleted_option', string $option )
```

**Since:** 2.9.0

---

## Network Option Actions

### add_site_option_{$option}

Fires after a network option is added.

```php
do_action( "add_site_option_{$option}", string $option, mixed $value, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### add_site_option

Fires after any network option is added.

```php
do_action( 'add_site_option', string $option, mixed $value, int $network_id )
```

**Since:** 3.0.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### update_site_option_{$option}

Fires after a specific network option is updated.

```php
do_action( "update_site_option_{$option}", string $option, mixed $value, mixed $old_value, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### update_site_option

Fires after any network option is updated.

```php
do_action( 'update_site_option', string $option, mixed $value, mixed $old_value, int $network_id )
```

**Since:** 3.0.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### pre_delete_site_option_{$option}

Fires before a network option is deleted.

```php
do_action( "pre_delete_site_option_{$option}", string $option, int $network_id )
```

**Since:** 3.0.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### delete_site_option_{$option}

Fires after a specific network option is deleted.

```php
do_action( "delete_site_option_{$option}", string $option, int $network_id )
```

**Since:** 2.9.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

### delete_site_option

Fires after any network option is deleted.

```php
do_action( 'delete_site_option', string $option, int $network_id )
```

**Since:** 3.0.0  
**Since:** 4.7.0 — `$network_id` parameter added

---

## Transient Filters

### pre_transient_{$transient}

Short-circuits transient retrieval.

```php
apply_filters( "pre_transient_{$transient}", mixed $pre_transient, string $transient )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pre_transient` | mixed | Value to return. Default `false` |
| `$transient` | string | Transient name |

**Since:** 2.8.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### transient_{$transient}

Filters transient value before returning.

```php
apply_filters( "transient_{$transient}", mixed $value, string $transient )
```

**Since:** 2.8.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### pre_set_transient_{$transient}

Filters value before setting transient.

```php
apply_filters( "pre_set_transient_{$transient}", mixed $value, int $expiration, string $transient )
```

**Since:** 3.0.0  
**Since:** 4.2.0 — `$expiration` parameter added  
**Since:** 4.4.0 — `$transient` parameter added

---

### expiration_of_transient_{$transient}

Filters transient expiration time.

```php
apply_filters( "expiration_of_transient_{$transient}", int $expiration, mixed $value, string $transient )
```

**Since:** 4.4.0

---

### pre_site_transient_{$transient}

Short-circuits site transient retrieval.

```php
apply_filters( "pre_site_transient_{$transient}", mixed $pre, string $transient )
```

**Since:** 2.9.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### site_transient_{$transient}

Filters site transient value before returning.

```php
apply_filters( "site_transient_{$transient}", mixed $value, string $transient )
```

**Since:** 2.9.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### pre_set_site_transient_{$transient}

Filters value before setting site transient.

```php
apply_filters( "pre_set_site_transient_{$transient}", mixed $value, string $transient )
```

**Since:** 3.0.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### expiration_of_site_transient_{$transient}

Filters site transient expiration time.

```php
apply_filters( "expiration_of_site_transient_{$transient}", int $expiration, mixed $value, string $transient )
```

**Since:** 4.4.0

---

## Transient Actions

### delete_transient_{$transient}

Fires before a transient is deleted.

```php
do_action( "delete_transient_{$transient}", string $transient )
```

**Since:** 3.0.0

---

### deleted_transient

Fires after a transient is deleted.

```php
do_action( 'deleted_transient', string $transient )
```

**Since:** 3.0.0

---

### set_transient_{$transient}

Fires after a specific transient is set.

```php
do_action( "set_transient_{$transient}", mixed $value, int $expiration, string $transient )
```

**Since:** 3.0.0  
**Since:** 3.6.0 — `$value`, `$expiration` parameters added  
**Since:** 4.4.0 — `$transient` parameter added

---

### set_transient

Fires after any transient is set.

```php
do_action( 'set_transient', string $transient, mixed $value, int $expiration )
```

**Since:** 6.8.0

---

### delete_site_transient_{$transient}

Fires before a site transient is deleted.

```php
do_action( "delete_site_transient_{$transient}", string $transient )
```

**Since:** 3.0.0

---

### deleted_site_transient

Fires after a site transient is deleted.

```php
do_action( 'deleted_site_transient', string $transient )
```

**Since:** 3.0.0

---

### set_site_transient_{$transient}

Fires after a specific site transient is set.

```php
do_action( "set_site_transient_{$transient}", mixed $value, int $expiration, string $transient )
```

**Since:** 3.0.0  
**Since:** 4.4.0 — `$transient` parameter added

---

### set_site_transient

Fires after any site transient is set.

```php
do_action( 'set_site_transient', string $transient, mixed $value, int $expiration )
```

**Since:** 6.8.0

---

## Settings API Filters

### register_setting_args

Filters setting registration arguments.

```php
apply_filters( 'register_setting_args', array $args, array $defaults, string $option_group, string $option_name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments |
| `$defaults` | array | Default arguments |
| `$option_group` | string | Settings group |
| `$option_name` | string | Option name |

**Since:** 4.7.0

---

### sanitize_option_{$option}

Filters option value during sanitization.

```php
apply_filters( "sanitize_option_{$option}", mixed $value )
```

**Note:** Added automatically when `sanitize_callback` is provided to `register_setting()`.

---

### wp_default_autoload_value

Filters the default autoload value when none is specified.

```php
apply_filters( 'wp_default_autoload_value', bool|null $autoload, string $option, mixed $value, mixed $serialized_value )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$autoload` | bool\|null | Default autoload. `true` → `auto-on`, `false` → `auto-off`, `null` → `auto` |
| `$option` | string | Option name |
| `$value` | mixed | Option value |
| `$serialized_value` | mixed | Serialized option value |

**Since:** 6.6.0

---

### wp_max_autoloaded_option_size

Filters the maximum size for autoloaded options.

```php
apply_filters( 'wp_max_autoloaded_option_size', int $max_size, string $option )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_size` | int | Max size in bytes. Default 150000 |
| `$option` | string | Option name |

**Since:** 6.6.0

---

### wp_autoload_values_to_autoload

Filters autoload column values that trigger autoloading.

```php
apply_filters( 'wp_autoload_values_to_autoload', string[] $autoload_values )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$autoload_values` | string[] | Default: `array( 'yes', 'on', 'auto-on', 'auto' )` |

**Note:** Can only remove values from the default list, not add new ones.

**Since:** 6.6.0

---

## Settings API Actions

### register_setting

Fires before a setting is registered (after filters applied).

```php
do_action( 'register_setting', string $option_group, string $option_name, array $args )
```

**Since:** 5.5.0

---

### unregister_setting

Fires before a setting is unregistered.

```php
do_action( 'unregister_setting', string $option_group, string $option_name )
```

**Since:** 5.5.0

---

## Alloptions Filters

### pre_wp_load_alloptions

Short-circuits `wp_load_alloptions()`.

```php
apply_filters( 'pre_wp_load_alloptions', array|null $alloptions, bool $force_cache )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$alloptions` | array\|null | Return array to short-circuit. Default `null` |
| `$force_cache` | bool | Whether cache refresh was forced |

**Since:** 6.2.0

---

### pre_cache_alloptions

Filters options before caching.

```php
apply_filters( 'pre_cache_alloptions', array $alloptions )
```

**Since:** 4.9.0

---

### alloptions

Filters all options after retrieval.

```php
apply_filters( 'alloptions', array $alloptions )
```

**Since:** 4.9.0
