# Update Hooks

**Source:** `wp-includes/update.php`

## Filters

### core_version_check_locale

Filters the locale requested for WordPress core translations.

```php
apply_filters( 'core_version_check_locale', string $locale )
```

**Parameters:**
- `$locale` (string) - Current locale from `get_locale()`

**Returns:** string - Locale code to use for update check

**Since:** 2.8.0

**Example:**
```php
// Force English locale for update checks
add_filter( 'core_version_check_locale', function( $locale ) {
    return 'en_US';
});
```

---

### core_version_check_query_args

Filters the query arguments sent to WordPress.org core version check.

```php
apply_filters( 'core_version_check_query_args', array $query )
```

**Parameters:**
- `$query` (array):
  - `version` - WordPress version
  - `php` - PHP version
  - `locale` - Locale code
  - `mysql` - MySQL version
  - `local_package` - Value of `$wp_local_package` global
  - `blogs` - Number of sites
  - `users` - Number of users
  - `multisite_enabled` - 1 or 0
  - `initial_db_version` - DB version at installation
  - `myisam_tables` - List of MyISAM tables (since 6.1.0)
  - `extensions` - PHP extensions and versions (since 6.1.0)
  - `platform_flags` - OS and bit info (since 6.1.0)
  - `image_support` - GD/Imagick format support (since 6.1.0)

**Returns:** array

**Since:** 4.9.0

**Warning:** Modifying this data may prevent security updates. Use with extreme caution.

---

### plugins_update_check_locales

Filters the locales requested for plugin translations.

```php
apply_filters( 'plugins_update_check_locales', string[] $locales )
```

**Parameters:**
- `$locales` (string[]) - Available locales from `get_available_languages()`

**Returns:** string[] - Array of locale codes

**Since:** 3.7.0 (4.5.0 changed default to all locales)

---

### themes_update_check_locales

Filters the locales requested for theme translations.

```php
apply_filters( 'themes_update_check_locales', string[] $locales )
```

**Parameters:**
- `$locales` (string[]) - Available locales from `get_available_languages()`

**Returns:** string[] - Array of locale codes

**Since:** 3.7.0 (4.5.0 changed default to all locales)

---

### update_plugins_{$hostname}

Filters update response for plugins using custom `Update URI` header.

```php
apply_filters( "update_plugins_{$hostname}", array|false $update, array $plugin_data, string $plugin_file, string[] $locales )
```

**Dynamic portion:** `$hostname` is the hostname from the plugin's `Update URI` header.

**Parameters:**
- `$update` (array|false) - Update data or false for no update:
  - `id` - Plugin URI identifier
  - `slug` - Plugin slug
  - `version` - Available version
  - `url` - Plugin details URL
  - `package` - Update ZIP URL (optional)
  - `tested` - WordPress version tested against (optional)
  - `requires_php` - Minimum PHP version (optional)
  - `autoupdate` - Auto-update flag (optional)
  - `icons` - Plugin icons (optional)
  - `banners` - Plugin banners (optional)
  - `banners_rtl` - RTL banners (optional)
  - `translations` - Translation updates (optional)
- `$plugin_data` (array) - Plugin header data
- `$plugin_file` (string) - Plugin basename
- `$locales` (string[]) - Installed locales

**Returns:** array|false

**Since:** 5.8.0

**Example:**
```php
// Handle updates for plugins hosted at updates.example.com
add_filter( 'update_plugins_updates.example.com', function( $update, $plugin_data, $plugin_file, $locales ) {
    // Query your update server
    $response = wp_remote_get( "https://updates.example.com/api/plugin/{$plugin_data['slug']}" );
    
    if ( is_wp_error( $response ) ) {
        return false;
    }
    
    return json_decode( wp_remote_retrieve_body( $response ), true );
}, 10, 4 );
```

---

### update_themes_{$hostname}

Filters update response for themes using custom `Update URI` header.

```php
apply_filters( "update_themes_{$hostname}", array|false $update, array $theme_data, string $theme_stylesheet, string[] $locales )
```

**Dynamic portion:** `$hostname` is the hostname from the theme's `Update URI` header.

**Parameters:**
- `$update` (array|false) - Update data or false:
  - `id` - Theme URI identifier
  - `theme` - Theme directory name
  - `version` - Available version
  - `url` - Theme details URL
  - `package` - Update ZIP URL (optional)
  - `tested` - WordPress version tested against (optional)
  - `requires_php` - Minimum PHP version (optional)
  - `autoupdate` - Auto-update flag (optional)
  - `translations` - Translation updates (optional)
- `$theme_data` (array) - Theme header data
- `$theme_stylesheet` (string) - Theme stylesheet/slug
- `$locales` (string[]) - Installed locales

**Returns:** array|false

**Since:** 6.1.0

---

### wp_get_update_data

Filters the update data returned for admin UI display.

```php
apply_filters( 'wp_get_update_data', array $update_data, array $titles )
```

**Parameters:**
- `$update_data` (array):
  - `counts` - Array of update counts (plugins, themes, wordpress, translations, total)
  - `title` - Combined title string
- `$titles` (array) - Individual title strings

**Returns:** array

**Since:** 3.5.0

**Example:**
```php
// Add custom update count
add_filter( 'wp_get_update_data', function( $data, $titles ) {
    $data['counts']['custom'] = 3;
    $data['counts']['total'] += 3;
    return $data;
}, 10, 2 );
```

---

## Actions

### wp_maybe_auto_update

Fires during cron to start the auto-update process.

```php
do_action( 'wp_maybe_auto_update' )
```

**Since:** 3.9.0

**Behavior:** Triggered by `wp_version_check()` when running via cron and not already in update handler.

**Default callback:** `wp_maybe_auto_update()` (priority 10)

---

## Registered Action Hooks

The following hooks are registered at the bottom of `update.php`:

### Admin Init Hooks

```php
add_action( 'admin_init', '_maybe_update_core' );
add_action( 'admin_init', '_maybe_update_plugins' );
add_action( 'admin_init', '_maybe_update_themes' );
```

### Cron Event Hooks

```php
add_action( 'wp_version_check', 'wp_version_check' );
add_action( 'wp_update_plugins', 'wp_update_plugins' );
add_action( 'wp_update_themes', 'wp_update_themes' );
add_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
add_action( 'wp_delete_temp_updater_backups', 'wp_delete_all_temp_backups' );
```

### Page Load Hooks

```php
// Plugin checks on relevant admin pages
add_action( 'load-plugins.php', 'wp_update_plugins' );
add_action( 'load-update.php', 'wp_update_plugins' );
add_action( 'load-update-core.php', 'wp_update_plugins' );

// Theme checks on relevant admin pages
add_action( 'load-themes.php', 'wp_update_themes' );
add_action( 'load-update.php', 'wp_update_themes' );
add_action( 'load-update-core.php', 'wp_update_themes' );
```

### Other Hooks

```php
add_action( 'update_option_WPLANG', 'wp_clean_update_cache', 10, 0 );
add_action( 'init', 'wp_schedule_update_checks' );
```

---

## Conditional Loading

Update hooks only register on main site or network admin, excluding Ajax:

```php
if ( ( ! is_main_site() && ! is_network_admin() ) || wp_doing_ajax() ) {
    return;
}
```

This prevents update checks from running on subsites in multisite installations.

---

## Related Hooks (External)

These hooks are used by the update system but defined elsewhere:

- `upgrader_process_complete` - Fires after updates complete (class-wp-upgrader.php)
- `auto_update_{$type}` - Filter auto-update decision per item type
- `auto_update_plugin` - Filter individual plugin auto-update
- `auto_update_theme` - Filter individual theme auto-update
- `auto_update_core` - Filter core auto-update
- `automatic_updater_disabled` - Disable all auto-updates
