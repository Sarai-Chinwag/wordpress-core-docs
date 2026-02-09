# Plugin & Theme Installation API

WordPress provides a comprehensive upgrader system for installing, updating, and managing plugins and themes. The core class is `WP_Upgrader` with specialized subclasses.

## Class Hierarchy

```
WP_Upgrader (base class)
├── Plugin_Upgrader
├── Theme_Upgrader
├── Language_Pack_Upgrader
└── Core_Upgrader
```

## WP_Upgrader Base Class

The base class provides common functionality for all upgrade operations.

### Core Methods

```php
class WP_Upgrader {
    // Download a package
    public function download_package( $package, $check_signatures = false, $hook_extra = array() );
    
    // Unpack a compressed package
    public function unpack_package( $package, $delete_package = true );
    
    // Install from unpacked package
    public function install_package( $args = array() );
    
    // Run an upgrade/install
    public function run( $options );
    
    // Connect to filesystem
    public function fs_connect( $directories = array(), $allow_relaxed_file_ownership = false );
}
```

## Plugin Installation

### Using Plugin_Upgrader

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

// Create upgrader with skin
$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

// Install from WordPress.org
$result = $upgrader->install( 'https://downloads.wordpress.org/plugin/akismet.zip' );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
} elseif ( $result ) {
    echo 'Plugin installed successfully';
}
```

### Install from Uploaded File

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
require_once ABSPATH . 'wp-admin/includes/file.php';

// Handle upload
$file_upload = new File_Upload_Upgrader( 'pluginzip', 'package' );

$upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin() );
$result   = $upgrader->install( $file_upload->package );
```

### Update a Plugin

```php
$upgrader = new Plugin_Upgrader( new Bulk_Upgrader_Skin() );

// Update specific plugin
$result = $upgrader->upgrade( 'plugin-folder/plugin-file.php' );

// Bulk update
$plugins = array(
    'akismet/akismet.php',
    'hello-dolly/hello.php',
);
$results = $upgrader->bulk_upgrade( $plugins );
```

### Plugin_Upgrader Methods

```php
class Plugin_Upgrader extends WP_Upgrader {
    // Install plugin from URL/path
    public function install( $package, $args = array() );
    
    // Update single plugin
    public function upgrade( $plugin, $args = array() );
    
    // Update multiple plugins
    public function bulk_upgrade( $plugins, $args = array() );
}
```

## Theme Installation

### Using Theme_Upgrader

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$upgrader = new Theme_Upgrader( new Theme_Installer_Skin() );

// Install from WordPress.org
$result = $upgrader->install( 'https://downloads.wordpress.org/theme/flavflavor.zip' );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

### Update a Theme

```php
$upgrader = new Theme_Upgrader( new Theme_Upgrader_Skin() );

// Update specific theme
$result = $upgrader->upgrade( 'theme-slug' );

// Bulk update
$themes  = array( 'theme-one', 'theme-two' );
$results = $upgrader->bulk_upgrade( $themes );
```

### Theme_Upgrader Methods

```php
class Theme_Upgrader extends WP_Upgrader {
    // Install theme from URL/path
    public function install( $package, $args = array() );
    
    // Update single theme
    public function upgrade( $theme, $args = array() );
    
    // Update multiple themes
    public function bulk_upgrade( $themes, $args = array() );
    
    // Check parent theme requirements
    public function check_parent_theme_filter( $install_result, $hook_extra, $child_result );
}
```

## Upgrader Skins

Skins control the output/feedback during installation.

### Available Skins

| Skin Class | Use Case |
|------------|----------|
| `WP_Upgrader_Skin` | Base skin |
| `Plugin_Upgrader_Skin` | Single plugin upgrade |
| `Theme_Upgrader_Skin` | Single theme upgrade |
| `Bulk_Upgrader_Skin` | Bulk upgrades |
| `Bulk_Plugin_Upgrader_Skin` | Bulk plugin upgrades |
| `Bulk_Theme_Upgrader_Skin` | Bulk theme upgrades |
| `Plugin_Installer_Skin` | Plugin installation |
| `Theme_Installer_Skin` | Theme installation |
| `Language_Pack_Upgrader_Skin` | Language packs |
| `Automatic_Upgrader_Skin` | Background updates |
| `WP_Ajax_Upgrader_Skin` | AJAX updates |

### Using WP_Ajax_Upgrader_Skin

For AJAX/background operations (no output):

```php
$skin     = new WP_Ajax_Upgrader_Skin();
$upgrader = new Plugin_Upgrader( $skin );

$result = $upgrader->install( $package_url );

// Get messages
$messages = $skin->get_upgrade_messages();

// Get errors
if ( $skin->get_errors()->has_errors() ) {
    $errors = $skin->get_errors();
}
```

### Custom Skin

```php
class My_Custom_Skin extends WP_Upgrader_Skin {
    public function header() {
        echo '<div class="my-upgrade-wrapper">';
    }
    
    public function footer() {
        echo '</div>';
    }
    
    public function feedback( $string, ...$args ) {
        if ( ! empty( $args ) ) {
            $string = vsprintf( $string, $args );
        }
        echo '<p class="my-feedback">' . esc_html( $string ) . '</p>';
    }
    
    public function error( $errors ) {
        echo '<p class="my-error">' . esc_html( $errors ) . '</p>';
    }
}
```

## Silent/Background Installation

```php
function silent_plugin_install( $package_url ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    
    // Use skin that captures output
    $skin     = new Automatic_Upgrader_Skin();
    $upgrader = new Plugin_Upgrader( $skin );
    
    // Install silently
    $result = $upgrader->install( $package_url );
    
    if ( is_wp_error( $result ) ) {
        return $result;
    }
    
    // Get the installed plugin file
    $plugin_info = $upgrader->plugin_info();
    
    // Optionally activate
    if ( $plugin_info ) {
        activate_plugin( $plugin_info );
    }
    
    return $plugin_info;
}
```

## Plugin Management Functions

### Get Plugin Data

```php
// Get plugin header information
$plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/plugin-folder/plugin-file.php' );
/*
array(
    'Name'        => 'Plugin Name',
    'PluginURI'   => 'https://example.com',
    'Version'     => '1.0.0',
    'Description' => 'Plugin description',
    'Author'      => 'Author Name',
    'AuthorURI'   => 'https://author.com',
    'TextDomain'  => 'plugin-textdomain',
    'DomainPath'  => '/languages',
    'Network'     => false,
    'RequiresWP'  => '5.0',
    'RequiresPHP' => '7.4',
)
*/
```

### Get All Plugins

```php
// All plugins
$plugins = get_plugins();

// MU-plugins
$mu_plugins = get_mu_plugins();

// Drop-ins
$dropins = get_dropins();
```

### Activate/Deactivate

```php
// Activate
$result = activate_plugin( 'plugin-folder/plugin-file.php' );

if ( is_wp_error( $result ) ) {
    // Activation failed
}

// Deactivate
deactivate_plugins( 'plugin-folder/plugin-file.php' );

// Deactivate multiple
deactivate_plugins( array(
    'plugin-one/plugin.php',
    'plugin-two/plugin.php',
), true );  // true = silent (no hooks)
```

### Delete Plugin

```php
$result = delete_plugins( array( 'plugin-folder/plugin-file.php' ) );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

## Theme Management Functions

### Get Theme Data

```php
$theme = wp_get_theme( 'theme-slug' );

if ( $theme->exists() ) {
    $name    = $theme->get( 'Name' );
    $version = $theme->get( 'Version' );
    $author  = $theme->get( 'Author' );
}
```

### Get All Themes

```php
$themes = wp_get_themes();

foreach ( $themes as $theme_slug => $theme ) {
    echo $theme->get( 'Name' );
}
```

### Switch/Delete Theme

```php
// Switch active theme
switch_theme( 'theme-slug' );

// Delete theme
delete_theme( 'theme-slug' );
```

## Checking for Updates

### Force Update Check

```php
// Force check for plugin updates
wp_clean_plugins_cache();
delete_site_transient( 'update_plugins' );
wp_update_plugins();

// Force check for theme updates  
delete_site_transient( 'update_themes' );
wp_update_themes();

// Force check for core updates
wp_version_check();
```

### Get Available Updates

```php
// Plugin updates
$updates = get_site_transient( 'update_plugins' );
if ( isset( $updates->response ) ) {
    foreach ( $updates->response as $plugin => $data ) {
        echo $plugin . ' has update: ' . $data->new_version;
    }
}

// Theme updates
$updates = get_site_transient( 'update_themes' );
if ( isset( $updates->response ) ) {
    foreach ( $updates->response as $theme => $data ) {
        echo $theme . ' has update: ' . $data['new_version'];
    }
}
```

## WP_Automatic_Updater

For automatic background updates.

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

$auto_updater = new WP_Automatic_Updater();

// Check if auto-updates are disabled
if ( $auto_updater->is_disabled() ) {
    return;
}

// Check if specific update should run
$should_update = $auto_updater->should_update( 'plugin', $update_data, ABSPATH );

// Run auto-updates
$auto_updater->run();
```

## Hooks

### Installation Hooks

| Hook | Description |
|------|-------------|
| `upgrader_pre_download` | Before downloading package |
| `upgrader_pre_install` | Before installation |
| `upgrader_post_install` | After installation |
| `upgrader_process_complete` | After upgrade process |
| `upgrader_package_options` | Filter package options |

### Plugin-Specific

| Hook | Description |
|------|-------------|
| `activate_plugin` | During plugin activation |
| `deactivate_plugin` | During plugin deactivation |
| `activated_plugin` | After plugin activated |
| `deactivated_plugin` | After plugin deactivated |
| `deleted_plugin` | After plugin deleted |

### Theme-Specific

| Hook | Description |
|------|-------------|
| `switch_theme` | When theme is switched |
| `after_switch_theme` | After theme switch |
| `deleted_theme` | After theme deleted |

## Error Handling

```php
$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
$result   = $upgrader->install( $package_url );

if ( is_wp_error( $result ) ) {
    $error_code = $result->get_error_code();
    $error_msg  = $result->get_error_message();
    
    switch ( $error_code ) {
        case 'no_package':
            // Package URL not available
            break;
        case 'download_failed':
            // Could not download
            break;
        case 'incompatible_archive':
            // Invalid package structure
            break;
        case 'mkdir_failed':
            // Could not create directory
            break;
        case 'folder_exists':
            // Plugin/theme already exists
            break;
    }
}
```

## Complete Example: Plugin Auto-Installer

```php
function auto_install_required_plugins() {
    $required = array(
        'akismet' => 'https://downloads.wordpress.org/plugin/akismet.zip',
        'jetpack' => 'https://downloads.wordpress.org/plugin/jetpack.zip',
    );
    
    $installed = get_plugins();
    
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    
    foreach ( $required as $slug => $url ) {
        // Check if already installed
        $plugin_file = null;
        foreach ( $installed as $file => $data ) {
            if ( strpos( $file, $slug ) === 0 ) {
                $plugin_file = $file;
                break;
            }
        }
        
        if ( $plugin_file ) {
            // Already installed, just activate
            if ( ! is_plugin_active( $plugin_file ) ) {
                activate_plugin( $plugin_file );
            }
            continue;
        }
        
        // Install the plugin
        $skin     = new Automatic_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $url );
        
        if ( ! is_wp_error( $result ) && $result ) {
            $plugin_file = $upgrader->plugin_info();
            if ( $plugin_file ) {
                activate_plugin( $plugin_file );
            }
        }
    }
}
```
