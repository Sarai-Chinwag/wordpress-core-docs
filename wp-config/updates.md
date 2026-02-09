# Update Settings

WordPress provides granular control over automatic updates for core, plugins, themes, and translations.

## Core Update Constants

### WP_AUTO_UPDATE_CORE

```php
define( 'WP_AUTO_UPDATE_CORE', true );
```

- **Type**: Boolean or String
- **Default**: `minor` (since WordPress 3.7)
- **Purpose**: Controls automatic WordPress core updates

#### Values

| Value | Effect |
|-------|--------|
| `true` | Enable all automatic updates (major, minor, dev) |
| `false` | Disable all automatic core updates |
| `'minor'` | Only minor/security updates (default) - e.g., 6.4.1 → 6.4.2 |
| `'beta'` | Minor updates and beta/RC versions |

#### Update Types Explained

- **Major**: 6.3 → 6.4 (new features, potential breaking changes)
- **Minor**: 6.4.1 → 6.4.2 (bug fixes, security patches)
- **Development**: Nightly builds (dev only)

### Examples

```php
// Only security/minor updates (recommended)
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// All updates including major versions
define( 'WP_AUTO_UPDATE_CORE', true );

// Disable all automatic updates
define( 'WP_AUTO_UPDATE_CORE', false );
```

### AUTOMATIC_UPDATER_DISABLED

```php
define( 'AUTOMATIC_UPDATER_DISABLED', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Completely disables ALL automatic updates
- **Effect**:
  - No core updates
  - No plugin updates
  - No theme updates
  - No translation updates
- **Use Case**: Managed hosting, staging environments, version control deployments

### CORE_UPGRADE_SKIP_NEW_BUNDLED

```php
define( 'CORE_UPGRADE_SKIP_NEW_BUNDLED', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Skip installing new default themes/plugins during core upgrade
- **Effect**: Prevents Twenty Twenty-Five, Akismet, etc. from being installed

## File Modification Control

### DISALLOW_FILE_MODS

```php
define( 'DISALLOW_FILE_MODS', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Completely prevents file modifications through WordPress
- **Effect**:
  - Disables plugin/theme installation
  - Disables plugin/theme updates (including auto-updates)
  - Disables core updates (including auto-updates)
  - Disables plugin/theme editor
- **Use Case**: Deployments via Git/CI where all changes go through version control

**Note**: This is the most restrictive constant. If set, no updates of any kind can occur through WordPress.

### DISALLOW_FILE_EDIT

```php
define( 'DISALLOW_FILE_EDIT', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Disables only the theme/plugin editors
- **Effect**: Removes editor access, but updates still work
- **Note**: Less restrictive than `DISALLOW_FILE_MODS`

## Plugin and Theme Auto-Updates

Since WordPress 5.5, plugins and themes can auto-update individually. These filters control defaults:

### Via Filters (not constants)

```php
// Enable auto-updates for all plugins
add_filter( 'auto_update_plugin', '__return_true' );

// Enable auto-updates for all themes
add_filter( 'auto_update_theme', '__return_true' );

// Disable auto-updates for all plugins
add_filter( 'auto_update_plugin', '__return_false' );

// Disable auto-updates for all themes
add_filter( 'auto_update_theme', '__return_false' );
```

### Selective Plugin Auto-Updates

```php
add_filter( 'auto_update_plugin', function( $update, $item ) {
    // Auto-update only specific plugins
    $auto_update_plugins = array(
        'akismet/akismet.php',
        'wordpress-seo/wp-seo.php',
    );
    
    if ( in_array( $item->plugin, $auto_update_plugins, true ) ) {
        return true;
    }
    
    // Disable for all others
    return false;
}, 10, 2 );
```

### Selective Theme Auto-Updates

```php
add_filter( 'auto_update_theme', function( $update, $item ) {
    // Never auto-update the active theme
    if ( get_stylesheet() === $item->theme ) {
        return false;
    }
    return $update;
}, 10, 2 );
```

## Translation Auto-Updates

### Automatic Translation Updates

```php
// Enable (default behavior)
add_filter( 'auto_update_translation', '__return_true' );

// Disable translation auto-updates
add_filter( 'auto_update_translation', '__return_false' );
```

## Update Notifications

### Email Notifications

```php
// Disable update success emails
add_filter( 'auto_core_update_send_email', '__return_false' );

// Disable plugin update emails
add_filter( 'auto_plugin_update_send_email', '__return_false' );

// Disable theme update emails
add_filter( 'auto_theme_update_send_email', '__return_false' );
```

### Customize Notification Email

```php
add_filter( 'auto_core_update_email', function( $email, $type, $core_update, $result ) {
    // Customize recipient
    $email['to'] = 'admin@example.com';
    
    // Add to subject
    $email['subject'] = '[MySite] ' . $email['subject'];
    
    return $email;
}, 10, 4 );
```

## Update Process Control

### WP_INSTALLING

```php
// Usually set internally during installation/updates
define( 'WP_INSTALLING', true );
```

- **Type**: Boolean
- **Purpose**: Indicates WordPress is being installed or upgraded
- **Note**: Set automatically; don't manually define

### Update Locks

WordPress uses database locks to prevent concurrent updates:

```php
// Check if update is locked
$lock = get_option( 'core_updater.lock' );
$lock = get_option( 'auto_updater.lock' );
```

## Rollback Settings

### WP_ROLLBACK_VERSION

WordPress 6.3+ includes rollback functionality:

```php
// Rollback is automatic for failed updates
// No constant needed - WordPress handles this
```

## Version Checks

### WP_INSTALLING_NETWORK

```php
define( 'WP_INSTALLING_NETWORK', true );
```

- **Purpose**: Indicates network installation in progress
- **Note**: Set during multisite setup

## Complete Update Configuration Examples

### Production: Security-Focused

```php
<?php
// Only security updates for core
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// Disable plugin/theme installation/updates via admin
// (Manage via deployment pipeline)
define( 'DISALLOW_FILE_MODS', true );
```

### Production: Fully Automatic

```php
<?php
// Enable all core updates
define( 'WP_AUTO_UPDATE_CORE', true );

// In mu-plugins/auto-updates.php
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
```

### Staging: No Automatic Updates

```php
<?php
// Disable all automatic updates
define( 'AUTOMATIC_UPDATER_DISABLED', true );

// Or more granularly:
define( 'WP_AUTO_UPDATE_CORE', false );
```

### Development: Manual Control

```php
<?php
// No auto-updates in development
define( 'AUTOMATIC_UPDATER_DISABLED', true );

// But allow manual updates
// (don't set DISALLOW_FILE_MODS)
```

### Managed Hosting / Git Workflow

```php
<?php
// All changes through version control
define( 'DISALLOW_FILE_MODS', true );

// Updates handled by deployment pipeline:
// 1. Update locally
// 2. Test
// 3. Commit
// 4. Deploy
```

## Update-Related Filters Reference

| Filter | Purpose |
|--------|---------|
| `auto_update_core` | Control core auto-updates |
| `auto_update_plugin` | Control plugin auto-updates |
| `auto_update_theme` | Control theme auto-updates |
| `auto_update_translation` | Control translation auto-updates |
| `allow_major_auto_core_updates` | Allow/block major core updates |
| `allow_minor_auto_core_updates` | Allow/block minor core updates |
| `allow_dev_auto_core_updates` | Allow/block dev core updates |
| `auto_core_update_send_email` | Control core update emails |
| `auto_plugin_update_send_email` | Control plugin update emails |
| `auto_theme_update_send_email` | Control theme update emails |
| `send_core_update_notification_email` | Control update notification emails |

## Checking Update Status

### WP-CLI Commands

```bash
# Check for available updates
wp core check-update
wp plugin list --update=available
wp theme list --update=available

# View auto-update status
wp plugin auto-updates status --all
wp theme auto-updates status --all

# Enable/disable auto-updates
wp plugin auto-updates enable --all
wp plugin auto-updates disable akismet
```

### Programmatic Check

```php
// Check if auto-updates are possible
if ( wp_is_auto_update_enabled_for_type( 'core' ) ) {
    // Core auto-updates are enabled
}

// Get update info
$update_data = get_site_transient( 'update_core' );
$plugin_updates = get_site_transient( 'update_plugins' );
$theme_updates = get_site_transient( 'update_themes' );
```

## Security Considerations

1. **Enable minor auto-updates** - Security patches should apply automatically
2. **Test major updates** - Verify compatibility before allowing auto-updates
3. **Monitor update emails** - Know when updates occur
4. **Have rollback plan** - Backups before major updates
5. **Use staging** - Test updates before production
6. **Consider DISALLOW_FILE_MODS** - For version-controlled deployments

## Troubleshooting Updates

### Updates Failing

1. Check file permissions (web server needs write access)
2. Verify `FS_METHOD` setting
3. Check available disk space
4. Review `WP_DEBUG_LOG` for errors

### Updates Not Appearing

1. Clear transients: `wp transient delete --all`
2. Force update check: `wp core check-update --force-check`
3. Check `AUTOMATIC_UPDATER_DISABLED` constant
4. Verify `WP_HTTP_BLOCK_EXTERNAL` isn't blocking api.wordpress.org

### Email Notifications Not Received

1. Check spam folder
2. Verify email configuration (SMTP plugin)
3. Check filters aren't disabling emails
4. Review server mail logs
