# Update Functions API

WordPress provides APIs for checking, managing, and applying updates to core, plugins, themes, and translations.

## Checking for Updates

### Core Updates

```php
// Get available core updates
$updates = get_core_updates();

if ( $updates && ! is_wp_error( $updates ) ) {
    foreach ( $updates as $update ) {
        echo 'Version: ' . $update->current;
        echo 'Response: ' . $update->response; // 'upgrade', 'latest', 'development'
        echo 'Download: ' . $update->download;
    }
}

// Get preferred update (first available)
$update = get_preferred_from_update_core();

// Force check for updates
wp_version_check();
```

### Plugin Updates

```php
// Force refresh plugin updates
wp_clean_plugins_cache();
delete_site_transient( 'update_plugins' );
wp_update_plugins();

// Get updates
$updates = get_site_transient( 'update_plugins' );

// Available updates
if ( isset( $updates->response ) ) {
    foreach ( $updates->response as $plugin_file => $data ) {
        echo $plugin_file . ': ' . $data->new_version;
    }
}

// Checked but no update
if ( isset( $updates->no_update ) ) {
    // Plugins that are up to date
}

// Get plugin update info
$update = get_plugin_updates();
```

### Theme Updates

```php
// Force refresh
delete_site_transient( 'update_themes' );
wp_update_themes();

// Get updates
$updates = get_site_transient( 'update_themes' );

if ( isset( $updates->response ) ) {
    foreach ( $updates->response as $theme => $data ) {
        echo $theme . ': ' . $data['new_version'];
    }
}

// Get theme update info
$update = get_theme_updates();
```

### Translation Updates

```php
// Check for translation updates
wp_get_translation_updates();

// Force refresh
wp_clean_update_cache();
wp_update_translations();
```

## Update Display Functions

### Core Update Nag

```php
// Display update notification
add_action( 'admin_notices', 'update_nag' );

// Custom update nag
function my_update_nag() {
    $update = get_preferred_from_update_core();
    
    if ( ! isset( $update->response ) || 'upgrade' !== $update->response ) {
        return;
    }
    
    $msg = sprintf(
        __( 'WordPress %s is available!' ),
        $update->current
    );
    
    wp_admin_notice( $msg, array( 'type' => 'warning' ) );
}
```

### Footer Version Message

```php
// Get update footer message
$footer = core_update_footer();

// Display in admin footer
add_filter( 'update_footer', 'core_update_footer' );
```

## Plugin/Theme Update Counts

```php
// Get update counts
$counts = wp_get_update_data();
/*
array(
    'counts' => array(
        'plugins'      => 2,
        'themes'       => 1,
        'wordpress'    => 1,
        'translations' => 0,
        'total'        => 4,
    ),
    'title' => 'Updates (4)',
)
*/
```

## Dismiss/Undismiss Updates

### Core Updates

```php
// Dismiss a core update
dismiss_core_update( $update );

// Undismiss
undismiss_core_update( $version, $locale );

// Find specific core update
$update = find_core_update( $version, $locale );
```

## Automatic Updates

### WP_Automatic_Updater Class

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$auto_updater = new WP_Automatic_Updater();

// Check if auto-updates are disabled
if ( $auto_updater->is_disabled() ) {
    // Auto-updates disabled
}

// Check if specific update should proceed
$should_update = $auto_updater->should_update( 'core', $update, ABSPATH );
$should_update = $auto_updater->should_update( 'plugin', $plugin_data, WP_PLUGIN_DIR );
$should_update = $auto_updater->should_update( 'theme', $theme_data, get_theme_root() );
```

### Auto-Update Filters

```php
// Disable all auto-updates
add_filter( 'automatic_updater_disabled', '__return_true' );

// Control core auto-updates
add_filter( 'allow_dev_auto_core_updates', '__return_false' );   // Development
add_filter( 'allow_minor_auto_core_updates', '__return_true' );  // Minor updates
add_filter( 'allow_major_auto_core_updates', '__return_false' ); // Major updates

// Control plugin auto-updates
add_filter( 'auto_update_plugin', function( $update, $item ) {
    // Specific plugin
    if ( 'akismet/akismet.php' === $item->plugin ) {
        return true;
    }
    return $update;
}, 10, 2 );

// Control theme auto-updates
add_filter( 'auto_update_theme', function( $update, $item ) {
    // Disable for specific theme
    if ( 'my-theme' === $item->theme ) {
        return false;
    }
    return $update;
}, 10, 2 );

// Control translation auto-updates
add_filter( 'auto_update_translation', '__return_true' );
```

### Plugin/Theme Auto-Update UI

```php
// Get plugin auto-update status
$auto_updates = (array) get_site_option( 'auto_update_plugins', array() );

if ( in_array( 'plugin-folder/plugin.php', $auto_updates, true ) ) {
    // Auto-updates enabled for this plugin
}

// Enable auto-updates for a plugin
$auto_updates[] = 'plugin-folder/plugin.php';
update_site_option( 'auto_update_plugins', array_unique( $auto_updates ) );

// Same for themes
$auto_updates = (array) get_site_option( 'auto_update_themes', array() );
```

## Update Application

### Apply Core Update

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$upgrader = new Core_Upgrader( new WP_Ajax_Upgrader_Skin() );
$result   = $upgrader->upgrade( $update );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

### Apply Plugin Updates

```php
$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

// Single plugin
$result = $upgrader->upgrade( 'plugin-folder/plugin.php' );

// Bulk update
$results = $upgrader->bulk_upgrade( array(
    'plugin-one/plugin.php',
    'plugin-two/plugin.php',
) );
```

### Apply Theme Updates

```php
$upgrader = new Theme_Upgrader( new WP_Ajax_Upgrader_Skin() );

// Single theme
$result = $upgrader->upgrade( 'theme-slug' );

// Bulk update
$results = $upgrader->bulk_upgrade( array( 'theme-one', 'theme-two' ) );
```

## Version Comparison

```php
// Compare versions
if ( version_compare( $installed_version, $available_version, '<' ) ) {
    // Update available
}

// Check WordPress version
if ( version_compare( get_bloginfo( 'version' ), '6.0', '>=' ) ) {
    // Running WP 6.0 or higher
}
```

## Update Checksums

```php
// Get checksums for a WordPress version
$checksums = get_core_checksums( '6.4.2', 'en_US' );

if ( $checksums ) {
    foreach ( $checksums as $file => $hash ) {
        $actual = md5_file( ABSPATH . $file );
        if ( $hash !== $actual ) {
            // File modified
        }
    }
}
```

## Update Hooks

### Before/After Updates

| Hook | Description |
|------|-------------|
| `pre_auto_update` | Before auto-update starts |
| `automatic_updates_complete` | After auto-updates complete |
| `upgrader_process_complete` | After any upgrade completes |
| `_core_updated_successfully` | After core successfully updated |

### Update Checks

| Hook | Description |
|------|-------------|
| `pre_set_site_transient_update_plugins` | Before plugin updates cached |
| `pre_set_site_transient_update_themes` | Before theme updates cached |
| `pre_set_site_transient_update_core` | Before core updates cached |

### Example: After Update Actions

```php
add_action( 'upgrader_process_complete', function( $upgrader, $options ) {
    if ( 'update' === $options['action'] ) {
        if ( 'plugin' === $options['type'] ) {
            // Plugins were updated
            $plugins = isset( $options['plugins'] ) ? $options['plugins'] : array();
        } elseif ( 'theme' === $options['type'] ) {
            // Themes were updated
            $themes = isset( $options['themes'] ) ? $options['themes'] : array();
        } elseif ( 'core' === $options['type'] ) {
            // Core was updated
        }
    }
}, 10, 2 );
```

## Update Email Notifications

```php
// Control update emails
add_filter( 'auto_core_update_send_email', function( $send, $type, $core_update, $result ) {
    // $type: 'success', 'fail', 'critical'
    
    // Disable success emails
    if ( 'success' === $type ) {
        return false;
    }
    
    return $send;
}, 10, 4 );

// Control plugin/theme update emails
add_filter( 'auto_plugin_theme_update_email', function( $email, $type, $successful_updates, $failed_updates ) {
    // Customize email
    $email['subject'] = 'Custom: ' . $email['subject'];
    
    return $email;
}, 10, 4 );
```

## Maintenance Mode

During updates, WordPress enters maintenance mode.

```php
// Check if in maintenance mode
if ( is_maintenance_mode() ) {
    // Site is being updated
}

// Enable maintenance mode manually
$upgrader = new WP_Upgrader();
$upgrader->maintenance_mode( true );

// Disable
$upgrader->maintenance_mode( false );

// The maintenance file
$maintenance_file = ABSPATH . '.maintenance';
```

## Rollback (WordPress 6.3+)

```php
// Check for backup
$backup = get_site_option( 'upgrade_temp_backup' );

// Restore from backup after failed update
$upgrader = new WP_Upgrader();
$upgrader->restore_temp_backup( $args );
```

## Complete Example: Update Status Dashboard

```php
function get_update_status() {
    $status = array(
        'core'         => null,
        'plugins'      => array(),
        'themes'       => array(),
        'translations' => array(),
    );
    
    // Core
    $core_updates = get_core_updates();
    if ( is_array( $core_updates ) && ! empty( $core_updates ) ) {
        if ( 'upgrade' === $core_updates[0]->response ) {
            $status['core'] = array(
                'current'   => get_bloginfo( 'version' ),
                'available' => $core_updates[0]->current,
            );
        }
    }
    
    // Plugins
    $plugin_updates = get_site_transient( 'update_plugins' );
    if ( isset( $plugin_updates->response ) ) {
        foreach ( $plugin_updates->response as $file => $data ) {
            $plugin = get_plugin_data( WP_PLUGIN_DIR . '/' . $file );
            $status['plugins'][] = array(
                'name'      => $plugin['Name'],
                'file'      => $file,
                'current'   => $plugin['Version'],
                'available' => $data->new_version,
            );
        }
    }
    
    // Themes
    $theme_updates = get_site_transient( 'update_themes' );
    if ( isset( $theme_updates->response ) ) {
        foreach ( $theme_updates->response as $slug => $data ) {
            $theme = wp_get_theme( $slug );
            $status['themes'][] = array(
                'name'      => $theme->get( 'Name' ),
                'slug'      => $slug,
                'current'   => $theme->get( 'Version' ),
                'available' => $data['new_version'],
            );
        }
    }
    
    // Translations
    $status['translations'] = wp_get_translation_updates();
    
    return $status;
}
```
