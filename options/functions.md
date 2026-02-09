# Options API Functions

Core functions for option and transient management.

**Source:** `wp-includes/option.php`

---

## Core Option Functions

### get_option()

Retrieves an option value based on option name.

```php
get_option( string $option, mixed $default_value = false ): mixed
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$option` | string | — | Option name (not SQL-escaped) |
| `$default_value` | mixed | `false` | Value to return if option doesn't exist |

#### Returns

Option value. Returns `$default_value` if option doesn't exist. Serialized values are automatically unserialized.

#### Notes

- Scalar values stored in DB are returned as strings
- Arrays/objects are returned as their original type (serialized/unserialized)
- Empty option name returns `false`
- Deprecated keys (`blacklist_keys`, `comment_whitelist`) are redirected

#### Example

```php
$value = get_option( 'blogname', 'My Site' );
$array = get_option( 'my_plugin_settings', array() );
```

**Since:** 1.5.0

---

### update_option()

Updates an existing option value, or creates it if it doesn't exist.

```php
update_option( string $option, mixed $value, bool|null $autoload = null ): bool
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$option` | string | — | Option name (not SQL-escaped) |
| `$value` | mixed | — | Option value (not SQL-escaped, serializable) |
| `$autoload` | bool\|null | `null` | Whether to autoload. `null` uses heuristics |

#### Returns

`true` if updated, `false` if value unchanged or update failed.

#### Notes

- Values are serialized automatically if needed
- No update occurs if new value equals old value
- If option doesn't exist, calls `add_option()`

#### Example

```php
update_option( 'my_option', 'new_value' );
update_option( 'my_settings', array( 'key' => 'value' ), false );
```

**Since:** 1.0.0  
**Since:** 4.2.0 — `$autoload` parameter added  
**Since:** 6.7.0 — `'yes'`/`'no'` autoload values deprecated

---

### add_option()

Adds a new option. Does not update if option already exists.

```php
add_option( string $option, mixed $value = '', string $deprecated = '', bool|null $autoload = null ): bool
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$option` | string | — | Option name (not SQL-escaped) |
| `$value` | mixed | `''` | Option value (not SQL-escaped) |
| `$deprecated` | string | `''` | Deprecated. Not used. |
| `$autoload` | bool\|null | `null` | Whether to autoload |

#### Returns

`true` if added, `false` if option exists or insert failed.

#### Example

```php
add_option( 'my_option', 'initial_value' );
add_option( 'my_large_option', $big_array, '', false ); // Don't autoload
```

**Since:** 1.0.0  
**Since:** 6.6.0 — `$autoload` default changed to `null`

---

### delete_option()

Removes an option by name.

```php
delete_option( string $option ): bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option` | string | Option name (not SQL-escaped) |

#### Returns

`true` if deleted, `false` if option didn't exist.

#### Example

```php
delete_option( 'my_obsolete_option' );
```

**Since:** 1.2.0

---

## Batch Option Functions

### get_options()

Retrieves multiple options in a single call.

```php
get_options( string[] $options ): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | string[] | Array of option names |

#### Returns

Associative array of option names to values.

#### Example

```php
$values = get_options( array( 'blogname', 'blogdescription', 'admin_email' ) );
```

**Since:** 6.4.0

---

### wp_prime_option_caches()

Primes option caches with a single database query.

```php
wp_prime_option_caches( string[] $options ): void
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | string[] | Array of option names to prime |

#### Notes

Only loads options not already cached.

**Since:** 6.4.0

---

### wp_prime_option_caches_by_group()

Primes caches for all options in a registered settings group.

```php
wp_prime_option_caches_by_group( string $option_group ): void
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option_group` | string | Settings group name |

**Since:** 6.4.0

---

## Autoload Functions

### wp_set_option_autoload()

Sets the autoload value for a single option.

```php
wp_set_option_autoload( string $option, bool $autoload ): bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option` | string | Option name |
| `$autoload` | bool | Whether to autoload |

#### Returns

`true` if autoload value was modified.

**Since:** 6.4.0

---

### wp_set_options_autoload()

Sets the autoload value for multiple options.

```php
wp_set_options_autoload( string[] $options, bool $autoload ): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | string[] | Array of option names |
| `$autoload` | bool | Autoload value to set |

#### Returns

Associative array of option names to success booleans.

**Since:** 6.4.0

---

### wp_set_option_autoload_values()

Sets different autoload values for multiple options at once.

```php
wp_set_option_autoload_values( array $options ): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | array | Associative array of option names to autoload values |

#### Returns

Associative array of option names to success booleans.

#### Example

```php
wp_set_option_autoload_values( array(
    'frequently_used'   => true,
    'rarely_used'       => false,
    'admin_only_option' => false,
) );
```

**Since:** 6.4.0

---

### wp_determine_option_autoload_value()

Determines the autoload value based on input and heuristics.

```php
wp_determine_option_autoload_value( 
    string $option, 
    mixed $value, 
    mixed $serialized_value, 
    bool|null $autoload 
): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option` | string | Option name |
| `$value` | mixed | Option value |
| `$serialized_value` | mixed | Serialized option value |
| `$autoload` | bool\|null | Explicit autoload value or `null` |

#### Returns

`'on'`, `'off'`, `'auto-on'`, `'auto-off'`, or `'auto'`

**Since:** 6.6.0  
**Access:** private

---

### wp_autoload_values_to_autoload()

Returns the autoload column values that trigger autoloading.

```php
wp_autoload_values_to_autoload(): string[]
```

#### Returns

`array( 'yes', 'on', 'auto-on', 'auto' )`

**Since:** 6.6.0

---

## Transient Functions

### get_transient()

Retrieves the value of a transient.

```php
get_transient( string $transient ): mixed
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transient` | string | Transient name (not SQL-escaped) |

#### Returns

Transient value, or `false` if expired/not set.

#### Notes

- With external object cache: uses `wp_cache_get()`
- Without: checks `_transient_{$transient}` option and timeout

**Since:** 2.8.0

---

### set_transient()

Sets or updates a transient value.

```php
set_transient( string $transient, mixed $value, int $expiration = 0 ): bool
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$transient` | string | — | Transient name (≤172 chars, not SQL-escaped) |
| `$value` | mixed | — | Transient value (serializable) |
| `$expiration` | int | `0` | Time until expiration in seconds. `0` = no expiration |

#### Returns

`true` if set successfully.

#### Example

```php
set_transient( 'api_response', $data, HOUR_IN_SECONDS );
set_transient( 'permanent_cache', $value ); // No expiration
```

**Since:** 2.8.0

---

### delete_transient()

Deletes a transient.

```php
delete_transient( string $transient ): bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transient` | string | Transient name |

#### Returns

`true` if deleted.

**Since:** 2.8.0

---

### delete_expired_transients()

Deletes all expired transients from the database.

```php
delete_expired_transients( bool $force_db = false ): void
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$force_db` | bool | `false` | Force DB cleanup even with external object cache |

**Since:** 4.9.0

---

## Site Transient Functions

### get_site_transient()

Retrieves the value of a site (network-wide) transient.

```php
get_site_transient( string $transient ): mixed
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transient` | string | Transient name |

#### Returns

Transient value, or `false` if expired/not set.

**Since:** 2.9.0

---

### set_site_transient()

Sets or updates a site transient value.

```php
set_site_transient( string $transient, mixed $value, int $expiration = 0 ): bool
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$transient` | string | — | Transient name (≤167 chars) |
| `$value` | mixed | — | Transient value |
| `$expiration` | int | `0` | Time until expiration in seconds |

**Since:** 2.9.0

---

### delete_site_transient()

Deletes a site transient.

```php
delete_site_transient( string $transient ): bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transient` | string | Transient name |

**Since:** 2.9.0

---

## Network Option Functions

### get_site_option()

Retrieves an option for the current network.

```php
get_site_option( string $option, mixed $default_value = false, bool $deprecated = true ): mixed
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$option` | string | — | Option name |
| `$default_value` | mixed | `false` | Default if not found |
| `$deprecated` | bool | `true` | Deprecated. Not used. |

**Since:** 2.8.0

---

### add_site_option()

Adds a new option for the current network.

```php
add_site_option( string $option, mixed $value ): bool
```

**Since:** 2.8.0

---

### update_site_option()

Updates an option for the current network.

```php
update_site_option( string $option, mixed $value ): bool
```

**Since:** 2.8.0

---

### delete_site_option()

Deletes an option from the current network.

```php
delete_site_option( string $option ): bool
```

**Since:** 2.8.0

---

### get_network_option()

Retrieves a network option for a specific network.

```php
get_network_option( int|null $network_id, string $option, mixed $default_value = false ): mixed
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$network_id` | int\|null | — | Network ID. `null` for current network |
| `$option` | string | — | Option name |
| `$default_value` | mixed | `false` | Default if not found |

**Since:** 4.4.0

---

### add_network_option()

Adds a new network option.

```php
add_network_option( int|null $network_id, string $option, mixed $value ): bool
```

**Since:** 4.4.0

---

### update_network_option()

Updates a network option.

```php
update_network_option( int|null $network_id, string $option, mixed $value ): bool
```

**Since:** 4.4.0

---

### delete_network_option()

Deletes a network option.

```php
delete_network_option( int|null $network_id, string $option ): bool
```

**Since:** 4.4.0

---

### wp_prime_network_option_caches()

Primes network option caches with a single query.

```php
wp_prime_network_option_caches( int|null $network_id, string[] $options ): void
```

**Since:** 6.6.0

---

### wp_prime_site_option_caches()

Primes site option caches for the current network.

```php
wp_prime_site_option_caches( string[] $options ): void
```

**Since:** 6.6.0

---

## Settings API Functions

### register_setting()

Registers a setting and its data.

```php
register_setting( string $option_group, string $option_name, array $args = array() ): void
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$option_group` | string | — | Settings group (`general`, `discussion`, `media`, `reading`, `writing`, `options`) |
| `$option_name` | string | — | Option name to register |
| `$args` | array | `array()` | Registration arguments |

#### Args

| Key | Type | Description |
|-----|------|-------------|
| `type` | string | Data type: `string`, `boolean`, `integer`, `number`, `array`, `object` |
| `label` | string | Human-readable label |
| `description` | string | Setting description |
| `sanitize_callback` | callable | Sanitization function |
| `show_in_rest` | bool\|array | Expose in REST API. Array for custom schema |
| `default` | mixed | Default value for `get_option()` |

#### Example

```php
register_setting( 'my_plugin', 'my_option', array(
    'type'              => 'string',
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'hello',
    'show_in_rest'      => true,
) );
```

**Since:** 2.7.0  
**Since:** 4.7.0 — `$args` array added  
**Since:** 6.6.0 — `label` argument added

---

### unregister_setting()

Unregisters a setting.

```php
unregister_setting( string $option_group, string $option_name, callable $deprecated = '' ): void
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option_group` | string | Settings group |
| `$option_name` | string | Option name |
| `$deprecated` | callable | Deprecated. Not used. |

**Since:** 2.7.0

---

### get_registered_settings()

Retrieves all registered settings.

```php
get_registered_settings(): array
```

#### Returns

Array of registered settings keyed by option name.

**Since:** 4.7.0

---

### register_initial_settings()

Registers WordPress core settings for REST API exposure.

```php
register_initial_settings(): void
```

**Since:** 4.7.0

---

## Utility Functions

### wp_load_alloptions()

Loads and caches all autoloaded options.

```php
wp_load_alloptions( bool $force_cache = false ): array
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$force_cache` | bool | `false` | Force refresh from persistent cache |

#### Returns

Array of all autoloaded options.

**Since:** 2.2.0

---

### wp_load_core_site_options()

Loads and primes caches for core network options.

```php
wp_load_core_site_options( int $network_id = null ): void
```

**Since:** 3.0.0

---

### wp_protect_special_option()

Dies if option is protected (`alloptions`, `notoptions`).

```php
wp_protect_special_option( string $option ): void
```

**Since:** 2.2.0

---

### form_option()

Prints an option value escaped for HTML forms.

```php
form_option( string $option ): void
```

**Since:** 1.5.0

---

### filter_default_option()

Filters the default value for options registered with `register_setting()`.

```php
filter_default_option( mixed $default_value, string $option, bool $passed_default ): mixed
```

**Since:** 4.7.0

---

## User Settings Functions

### get_user_setting()

Retrieves a user interface setting.

```php
get_user_setting( string $name, string|false $default_value = false ): mixed
```

**Since:** 2.7.0

---

### set_user_setting()

Sets a user interface setting.

```php
set_user_setting( string $name, string $value ): bool|null
```

**Since:** 2.8.0

---

### delete_user_setting()

Deletes user interface settings.

```php
delete_user_setting( string $names ): bool|null
```

**Since:** 2.7.0

---

### get_all_user_settings()

Retrieves all user interface settings.

```php
get_all_user_settings(): array
```

**Since:** 2.7.0

---

### wp_set_all_user_settings()

Sets all user interface settings.

```php
wp_set_all_user_settings( array $user_settings ): bool|null
```

**Since:** 2.8.0  
**Access:** private

---

### delete_all_user_settings()

Deletes all user settings for the current user.

```php
delete_all_user_settings(): void
```

**Since:** 2.7.0

---

### wp_user_settings()

Saves and restores user settings from cookie.

```php
wp_user_settings(): void
```

**Since:** 2.7.0
