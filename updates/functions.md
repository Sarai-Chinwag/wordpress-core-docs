# Update Functions

**Source:** `wp-includes/update.php`

## Core Update Functions

### wp_version_check()

Checks WordPress version against the newest version available on WordPress.org.

```php
wp_version_check( array $extra_stats = array(), bool $force_check = false )
```

**Parameters:**
- `$extra_stats` (array) - Extra statistics to report to the WordPress.org API
- `$force_check` (bool) - Bypass transient cache and force fresh check. Auto-true if `$extra_stats` provided.

**Returns:** void

**Behavior:**
1. Bails if `wp_installing()` returns true
2. Respects 1-minute rate limit between checks (unless forced)
3. Collects system info: WP version, PHP, MySQL, locale, extensions, image support
4. POSTs to `api.wordpress.org/core/version-check/1.7/`
5. Stores result in `update_core` site transient
6. May trigger `wp_maybe_auto_update` action if running via cron

**Since:** 2.3.0

---

### wp_update_plugins()

Checks for available plugin updates from WordPress.org.

```php
wp_update_plugins( array $extra_stats = array() )
```

**Parameters:**
- `$extra_stats` (array) - Extra statistics to report to the API

**Returns:** void

**Behavior:**
1. Loads `wp-admin/includes/plugin.php` if needed for `get_plugins()`
2. Compiles list of all plugins with versions
3. POSTs to `api.wordpress.org/plugins/update-check/1.1/`
4. Processes third-party updates via `Update URI` header
5. Stores in `update_plugins` site transient with structure:
   - `response` - Plugins with updates available
   - `no_update` - Plugins at latest version
   - `checked` - All plugins and their versions
   - `translations` - Available translation updates

**Since:** 2.3.0

---

### wp_update_themes()

Checks for available theme updates from WordPress.org.

```php
wp_update_themes( array $extra_stats = array() )
```

**Parameters:**
- `$extra_stats` (array) - Extra statistics to report to the API

**Returns:** void

**Behavior:**
1. Collects all themes via `wp_get_themes()`
2. POSTs to `api.wordpress.org/themes/update-check/1.1/`
3. Processes third-party updates via `Update URI` header
4. Stores in `update_themes` site transient

**Since:** 2.7.0

---

## Auto-Update Functions

### wp_maybe_auto_update()

Performs WordPress automatic background updates for core, plugins, and themes.

```php
wp_maybe_auto_update()
```

**Returns:** void

**Behavior:**
1. Requires `wp-admin/includes/admin.php` and `class-wp-upgrader.php`
2. Instantiates `WP_Automatic_Updater`
3. Calls `$upgrader->run()`

**Since:** 3.7.0

---

## Translation Functions

### wp_get_translation_updates()

Retrieves all available translation updates across core, plugins, and themes.

```php
wp_get_translation_updates(): object[]
```

**Returns:** Array of translation objects with available updates

**Behavior:**
- Reads `update_core`, `update_plugins`, `update_themes` transients
- Extracts `translations` array from each
- Returns combined list of translation update objects

**Since:** 3.7.0

---

## UI Helper Functions

### wp_get_update_data()

Collects counts and UI strings for available updates (used in admin menu badges).

```php
wp_get_update_data(): array
```

**Returns:**
```php
array(
    'counts' => array(
        'plugins'      => int,
        'themes'       => int,
        'wordpress'    => int,  // 0 or 1
        'translations' => int,  // 0 or 1
        'total'        => int,
    ),
    'title' => string,  // e.g., "5 Plugin Updates, 2 Theme Updates"
)
```

**Behavior:**
- Respects user capabilities (`update_plugins`, `update_themes`, `update_core`)
- Only counts non-dismissed core updates
- Generates human-readable title string

**Since:** 3.3.0

---

## Internal/Private Functions

### _maybe_update_core()

Conditionally triggers core version check if stale (>12 hours).

```php
_maybe_update_core()
```

**Hooked to:** `admin_init`

**Since:** 2.8.0

---

### _maybe_update_plugins()

Conditionally triggers plugin version check if stale (>12 hours).

```php
_maybe_update_plugins()
```

**Hooked to:** `admin_init`

**Since:** 2.7.0  
**Access:** Private

---

### _maybe_update_themes()

Conditionally triggers theme version check if stale (>12 hours).

```php
_maybe_update_themes()
```

**Hooked to:** `admin_init`

**Since:** 2.7.0  
**Access:** Private

---

## Scheduling Functions

### wp_schedule_update_checks()

Schedules twice-daily cron events for update checks.

```php
wp_schedule_update_checks()
```

**Behavior:**
- Schedules `wp_version_check` event
- Schedules `wp_update_plugins` event
- Schedules `wp_update_themes` event
- All use `twicedaily` recurrence

**Hooked to:** `init`

**Since:** 3.1.0

---

## Cache Functions

### wp_clean_update_cache()

Clears all update transient caches.

```php
wp_clean_update_cache()
```

**Behavior:**
- Calls `wp_clean_plugins_cache()` if available, else deletes `update_plugins` transient
- Calls `wp_clean_themes_cache()`
- Deletes `update_core` transient

**Hooked to:** `update_option_WPLANG`

**Since:** 4.1.0

---

## Backup Cleanup Functions

### wp_delete_all_temp_backups()

Schedules removal of temporary backup directory contents.

```php
wp_delete_all_temp_backups()
```

**Behavior:**
- Checks for update locks (`core_updater.lock`, `auto_updater.lock`)
- If locked or doing Ajax, reschedules for 1 hour later
- Otherwise hooks `_wp_delete_all_temp_backups()` to `shutdown`

**Hooked to:** `wp_delete_temp_updater_backups` cron event

**Since:** 6.3.0

---

### _wp_delete_all_temp_backups()

Actually deletes contents of `wp-content/upgrade-temp-backup/`.

```php
_wp_delete_all_temp_backups()
```

**Behavior:**
- Requires filesystem credentials
- Iterates `upgrade-temp-backup/` directory
- Recursively deletes all subdirectories

**Since:** 6.3.0  
**Access:** Private

---

## Transient Data Structures

### update_core

```php
object(
    'updates'         => array( /* offer objects */ ),
    'last_checked'    => int,  // Unix timestamp
    'version_checked' => string,
    'translations'    => array( /* translation objects */ ),
)
```

### update_plugins

```php
object(
    'last_checked'  => int,
    'checked'       => array( 'plugin/file.php' => 'version' ),
    'response'      => array( 'plugin/file.php' => object ),
    'no_update'     => array( 'plugin/file.php' => object ),
    'translations'  => array( /* translation objects */ ),
)
```

### update_themes

```php
object(
    'last_checked'  => int,
    'checked'       => array( 'theme-slug' => 'version' ),
    'response'      => array( 'theme-slug' => array ),
    'no_update'     => array( 'theme-slug' => array ),
    'translations'  => array( /* translation objects */ ),
)
```
