# WordPress Update System

**Source:** `wp-includes/update.php`  
**Since:** WordPress 2.3.0

## Purpose

The Update system checks for available updates to WordPress core, plugins, and themes by querying the WordPress.org API. It handles update detection, caching via transients, and triggers automatic background updates when configured.

## Architecture

### Update Check Flow

1. **Scheduled Events** - Cron jobs run twice daily via `wp_schedule_update_checks()`
2. **API Queries** - Version info sent to `api.wordpress.org` endpoints
3. **Transient Storage** - Results cached in site transients:
   - `update_core` - Core WordPress updates
   - `update_plugins` - Plugin updates  
   - `update_themes` - Theme updates
4. **Auto-Updates** - `wp_maybe_auto_update()` performs background updates

### API Endpoints

| Type | Endpoint | Version |
|------|----------|---------|
| Core | `api.wordpress.org/core/version-check/1.7/` | 1.7 |
| Plugins | `api.wordpress.org/plugins/update-check/1.1/` | 1.1 |
| Themes | `api.wordpress.org/themes/update-check/1.1/` | 1.1 |

### Data Sent to WordPress.org

Core version checks include:
- WordPress version, PHP version, MySQL version
- Locale and local package info
- Number of sites/users (multisite awareness)
- PHP extensions and their versions
- Platform info (OS, 32/64-bit)
- Image format support (GD/Imagick for WebP, AVIF, HEIC, JXL)
- MyISAM table usage

Plugin/theme checks include:
- Full list of installed plugins/themes with versions
- Active plugins/themes
- Available locales for translations

## Update Check Timeouts

Timeouts vary by context to balance freshness vs performance:

| Context | Timeout |
|---------|---------|
| `upgrader_process_complete` | 0 (immediate) |
| `load-update-core.php` | 1 minute |
| `load-plugins.php` / `load-themes.php` | 1 hour |
| Cron | 2 hours |
| Default (blog-side) | 12 hours |

## Auto-Updates

### Configuration

Auto-updates are controlled by `WP_AUTO_UPDATE_CORE` constant:

```php
// In wp-config.php
define( 'WP_AUTO_UPDATE_CORE', true );      // Minor + security updates
define( 'WP_AUTO_UPDATE_CORE', false );     // Disable auto-updates
define( 'WP_AUTO_UPDATE_CORE', 'minor' );   // Minor updates only (default)
define( 'WP_AUTO_UPDATE_CORE', 'beta' );    // Include beta releases
define( 'WP_AUTO_UPDATE_CORE', 'rc' );      // Include release candidates
define( 'WP_AUTO_UPDATE_CORE', 'development' ); // Development builds
```

### Automatic Updater

The `WP_Automatic_Updater` class (in `wp-admin/includes/class-wp-upgrader.php`) handles:
- Core minor/security updates
- Plugin updates with auto-update enabled
- Theme updates with auto-update enabled
- Translation updates

Triggered via `wp_maybe_auto_update` action during cron.

## Update URI Header

Since WordPress 5.8 (plugins) and 6.1 (themes), extensions can use the `Update URI` header to receive updates from third-party servers:

```php
/**
 * Plugin Name: My Plugin
 * Update URI: https://example.com/my-plugin/
 */
```

The update system fires dynamic hooks `update_plugins_{$hostname}` and `update_themes_{$hostname}` allowing custom update servers.

## Temporary Backups

Since WordPress 6.3, update operations create temporary backups in `wp-content/upgrade-temp-backup/`. The `wp_delete_temp_updater_backups` cron event cleans these up, running on shutdown to avoid conflicts with active updates.

## Multisite Considerations

- Update checks only run on main site or network admin
- Uses `get_site_transient()` / `set_site_transient()` for network-wide caching
- Blog count and network URL included in API queries

## Security

- HTTPS preferred, falls back to HTTP with warning
- API responses sanitized (URLs escaped, HTML escaped)
- Response data filtered to allowed keys only
- Update locks prevent concurrent update operations
