# WordPress Plugin API Overview

The Plugin API is WordPress's system for extending core functionality through modular code packages. It encompasses plugin loading, activation lifecycle, pluggable functions, and mu-plugins.

## Plugin Types

### Standard Plugins (`wp-content/plugins/`)
- Installed in `WP_PLUGIN_DIR` (default: `wp-content/plugins/`)
- Must be explicitly activated via admin or programmatically
- Can be activated per-site or network-wide (Multisite)
- Support activation, deactivation, and uninstall hooks

### Must-Use Plugins (`wp-content/mu-plugins/`)
- Installed in `WPMU_PLUGIN_DIR` (default: `wp-content/mu-plugins/`)
- Automatically loaded on every request
- Cannot be deactivated through admin interface
- No subdirectory support (only files in root are loaded)
- Loaded before regular plugins

### Drop-ins (`wp-content/`)
- Special plugins that replace core functionality
- Located directly in `WP_CONTENT_DIR`
- Examples: `advanced-cache.php`, `db.php`, `object-cache.php`

## Plugin Loading Order

1. **Drop-ins** - Loaded during WordPress initialization
2. **Must-Use Plugins** - Loaded via `wp_get_mu_plugins()` in `wp-settings.php`
3. **Active Plugins** - Loaded from `active_plugins` option

## Plugin File Structure

### Header Requirements
```php
/*
Plugin Name: My Plugin
Plugin URI: https://example.com/my-plugin
Description: A brief description of the plugin.
Version: 1.0.0
Author: Author Name
Author URI: https://example.com
Text Domain: my-plugin
Domain Path: /languages
Network: true
Requires at least: 6.0
Requires PHP: 7.4
Requires Plugins: woocommerce, jetpack
Update URI: https://example.com/updates/
*/
```

### Header Fields

| Field | Required | Description |
|-------|----------|-------------|
| `Plugin Name` | Yes | Display name for the plugin |
| `Version` | Recommended | Current version number |
| `Description` | Recommended | Brief description |
| `Author` | Recommended | Plugin author name |
| `Plugin URI` | No | Plugin homepage URL |
| `Author URI` | No | Author homepage URL |
| `Text Domain` | No | Translation text domain |
| `Domain Path` | No | Path to translation files |
| `Network` | No | Require network-wide activation (Multisite) |
| `Requires at least` | No | Minimum WordPress version |
| `Requires PHP` | No | Minimum PHP version |
| `Requires Plugins` | No | Comma-separated plugin slugs (6.5+) |
| `Update URI` | No | Custom update server URI |

## Plugin Activation Lifecycle

### Activation Flow
1. `validate_plugin()` - Verify plugin file exists and has valid header
2. `validate_plugin_requirements()` - Check WP/PHP version compatibility
3. `activate_plugin` action fires
4. `activate_{$plugin}` action fires (used by `register_activation_hook()`)
5. Plugin added to `active_plugins` option
6. `activated_plugin` action fires

### Deactivation Flow
1. `deactivate_plugin` action fires
2. `deactivate_{$plugin}` action fires (used by `register_deactivation_hook()`)
3. Plugin removed from `active_plugins` option
4. `deactivated_plugin` action fires

### Uninstall Methods
Two options for cleanup when plugin is deleted:

1. **Uninstall Hook** (via `register_uninstall_hook()`)
   - Must be a static method or function
   - Stored in `uninstall_plugins` option

2. **uninstall.php File**
   - Place `uninstall.php` in plugin root
   - Check for `WP_UNINSTALL_PLUGIN` constant
   - Preferred for complex uninstall routines

## Pluggable Functions

WordPress defines certain functions as "pluggable" - they can be replaced by defining them before WordPress loads `pluggable.php`. This allows complete override of core functionality.

### How Pluggable Functions Work
```php
// In wp-includes/pluggable.php
if ( ! function_exists( 'wp_mail' ) ) :
    function wp_mail( $to, $subject, $message, ... ) {
        // Default implementation
    }
endif;
```

### Overriding Pluggable Functions
Define the function in a plugin that loads before `pluggable.php`:

```php
// In mu-plugin or early-loading plugin
function wp_mail( $to, $subject, $message, ... ) {
    // Custom implementation
}
```

### Categories of Pluggable Functions

**Authentication & Users:**
- `wp_set_current_user()`, `wp_get_current_user()`
- `get_userdata()`, `get_user_by()`, `cache_users()`
- `wp_authenticate()`, `wp_logout()`
- `is_user_logged_in()`, `auth_redirect()`

**Password & Security:**
- `wp_hash_password()`, `wp_check_password()`
- `wp_set_password()`, `wp_generate_password()`
- `wp_verify_nonce()`, `wp_create_nonce()`
- `wp_salt()`, `wp_hash()`

**Cookies & Sessions:**
- `wp_set_auth_cookie()`, `wp_clear_auth_cookie()`
- `wp_validate_auth_cookie()`, `wp_generate_auth_cookie()`
- `wp_parse_auth_cookie()`

**Email:**
- `wp_mail()` - Primary email sending function
- `wp_notify_postauthor()`, `wp_notify_moderator()`
- `wp_new_user_notification()`, `wp_password_change_notification()`

**Redirects:**
- `wp_redirect()`, `wp_safe_redirect()`
- `wp_sanitize_redirect()`, `wp_validate_redirect()`

**Nonces & Security Checks:**
- `check_admin_referer()`, `check_ajax_referer()`
- `wp_nonce_tick()`

**Miscellaneous:**
- `get_avatar()` - User avatar display
- `wp_text_diff()` - HTML diff display
- `wp_rand()` - Secure random number generation

## Best Practices

### Plugin Development
1. Use namespaces or class prefixes to avoid conflicts
2. Register hooks at appropriate priority levels
3. Always sanitize input and escape output
4. Use nonces for form submissions and AJAX
5. Check user capabilities before actions
6. Load scripts/styles only where needed

### Activation/Deactivation
1. Keep activation hooks lightweight
2. Use transients for expensive one-time operations
3. Clean up all options/data on uninstall
4. Don't run arbitrary code at top level

### Pluggable Function Override
1. Only override when absolutely necessary
2. Consider using filters/hooks instead
3. Maintain compatibility with expected behavior
4. Test thoroughly - affects entire site

## Related Files

- `wp-includes/plugin.php` - Hook system and plugin utilities
- `wp-includes/pluggable.php` - Pluggable function definitions
- `wp-includes/pluggable-deprecated.php` - Deprecated pluggable functions
- `wp-admin/includes/plugin.php` - Admin plugin management functions
- `wp-includes/class-wp-hook.php` - WP_Hook class for hook management
