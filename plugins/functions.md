# WordPress Plugin Functions

Core functions for plugin management, URLs, lifecycle hooks, and utilities.

## Plugin Path & URL Functions

### `plugin_basename( $file )`
Extracts the plugin's relative path from its absolute file path.

```php
// In your-plugin/your-plugin.php
$basename = plugin_basename( __FILE__ );
// Returns: 'your-plugin/your-plugin.php'

// Single-file plugin in plugins root
$basename = plugin_basename( '/var/www/html/wp-content/plugins/hello.php' );
// Returns: 'hello.php'
```

**Parameters:**
- `$file` (string) - Absolute path to plugin file

**Returns:** (string) - Plugin path relative to plugins directory

**Source:** `wp-includes/plugin.php`

---

### `plugin_dir_path( $file )`
Gets the filesystem directory path for a plugin file.

```php
// In your-plugin/your-plugin.php
$path = plugin_dir_path( __FILE__ );
// Returns: '/var/www/html/wp-content/plugins/your-plugin/'

// Use for includes
require_once plugin_dir_path( __FILE__ ) . 'includes/class-loader.php';
```

**Parameters:**
- `$file` (string) - Plugin's `__FILE__` constant

**Returns:** (string) - Directory path with trailing slash

**Source:** `wp-includes/plugin.php`

---

### `plugin_dir_url( $file )`
Gets the URL directory path for a plugin file.

```php
// In your-plugin/your-plugin.php
$url = plugin_dir_url( __FILE__ );
// Returns: 'https://example.com/wp-content/plugins/your-plugin/'

// Use for assets
wp_enqueue_script( 'my-script', plugin_dir_url( __FILE__ ) . 'js/script.js' );
```

**Parameters:**
- `$file` (string) - Plugin's `__FILE__` constant

**Returns:** (string) - URL path with trailing slash

**Source:** `wp-includes/plugin.php`

---

### `plugins_url( $path, $plugin )`
Retrieves a URL within the plugins or mu-plugins directory.

```php
// Get plugins directory URL
$url = plugins_url();
// Returns: 'https://example.com/wp-content/plugins'

// Get URL to specific file
$url = plugins_url( 'js/script.js', __FILE__ );
// Returns: 'https://example.com/wp-content/plugins/your-plugin/js/script.js'

// Mu-plugin detection
// If $plugin is in WPMU_PLUGIN_DIR, returns WPMU_PLUGIN_URL
```

**Parameters:**
- `$path` (string) - Optional. Relative path within plugin directory. Default empty.
- `$plugin` (string) - Optional. Plugin file path. Default empty.

**Returns:** (string) - Plugins URL with optional path appended

**Filter:** `plugins_url` - Modify the returned URL

**Source:** `wp-includes/link-template.php`

---

### `wp_register_plugin_realpath( $file )`
Registers a plugin's real path for symlink resolution.

```php
// Useful for symlinked plugin development
wp_register_plugin_realpath( __FILE__ );
```

**Parameters:**
- `$file` (string) - Known path to the file

**Returns:** (bool) - Whether the path was registered

**Source:** `wp-includes/plugin.php`

---

## Lifecycle Hook Registration

### `register_activation_hook( $file, $callback )`
Sets the activation hook for a plugin.

```php
// Function callback
register_activation_hook( __FILE__, 'my_plugin_activate' );

function my_plugin_activate() {
    // Create database tables
    // Set default options
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Class method callback
register_activation_hook( __FILE__, array( 'My_Plugin', 'activate' ) );

// Object method
register_activation_hook( __FILE__, array( $this, 'activate' ) );
```

**Parameters:**
- `$file` (string) - Plugin main file path
- `$callback` (callable) - Function to run on activation

**Action fired:** `activate_{$plugin}` where `$plugin` is the plugin basename

**Source:** `wp-includes/plugin.php`

---

### `register_deactivation_hook( $file, $callback )`
Sets the deactivation hook for a plugin.

```php
register_deactivation_hook( __FILE__, 'my_plugin_deactivate' );

function my_plugin_deactivate() {
    // Clear scheduled events
    wp_clear_scheduled_hook( 'my_plugin_cron' );
    
    // Flush rewrite rules
    flush_rewrite_rules();
    
    // Note: Don't delete options here - that's for uninstall
}
```

**Parameters:**
- `$file` (string) - Plugin main file path
- `$callback` (callable) - Function to run on deactivation

**Action fired:** `deactivate_{$plugin}` where `$plugin` is the plugin basename

**Source:** `wp-includes/plugin.php`

---

### `register_uninstall_hook( $file, $callback )`
Sets the uninstallation hook for a plugin.

```php
// Must be static method or function
register_uninstall_hook( __FILE__, 'my_plugin_uninstall' );

function my_plugin_uninstall() {
    // Delete options
    delete_option( 'my_plugin_settings' );
    
    // Delete custom tables
    global $wpdb;
    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}my_plugin_data" );
    
    // Delete user meta
    delete_metadata( 'user', 0, 'my_plugin_user_data', '', true );
}

// Class static method
register_uninstall_hook( __FILE__, array( 'My_Plugin', 'uninstall' ) );
```

**Parameters:**
- `$file` (string) - Plugin file path
- `$callback` (callable) - **Must be static method or function**

**Note:** Alternative is `uninstall.php` file in plugin root.

**Source:** `wp-includes/plugin.php`

---

## Plugin State Functions

### `is_plugin_active( $plugin )`
Determines whether a plugin is active.

```php
// Check by plugin basename
if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
    // WooCommerce is active
}

// Note: Only checks plugins/ directory, not mu-plugins/
// For mu-plugins, check if class/function exists instead
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory

**Returns:** (bool) - True if active (site or network), false otherwise

**Note:** Only available after `plugins_loaded`. Include `wp-admin/includes/plugin.php` for frontend use.

**Source:** `wp-admin/includes/plugin.php`

---

### `is_plugin_inactive( $plugin )`
Determines whether a plugin is inactive. Reverse of `is_plugin_active()`.

```php
if ( is_plugin_inactive( 'old-plugin/old-plugin.php' ) ) {
    // Plugin is not active
}
```

**Source:** `wp-admin/includes/plugin.php`

---

### `is_plugin_active_for_network( $plugin )`
Determines whether a plugin is network-activated (Multisite only).

```php
if ( is_plugin_active_for_network( 'my-plugin/my-plugin.php' ) ) {
    // Plugin is network-activated
}
```

**Returns:** (bool) - True if network-activated, false if single-site active or inactive

**Source:** `wp-admin/includes/plugin.php`

---

### `is_network_only_plugin( $plugin )`
Checks for "Network: true" in the plugin header.

```php
if ( is_network_only_plugin( 'multisite-only/multisite-only.php' ) ) {
    // Plugin requires network activation
}
```

**Source:** `wp-admin/includes/plugin.php`

---

## Plugin Management Functions

### `activate_plugin( $plugin, $redirect, $network_wide, $silent )`
Attempts to activate a plugin.

```php
// Basic activation
$result = activate_plugin( 'my-plugin/my-plugin.php' );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}

// Network-wide activation
activate_plugin( 'my-plugin/my-plugin.php', '', true );

// Silent activation (skip hooks)
activate_plugin( 'my-plugin/my-plugin.php', '', false, true );
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory
- `$redirect` (string) - Optional. URL to redirect on success. Default empty.
- `$network_wide` (bool) - Optional. Network activation (Multisite). Default false.
- `$silent` (bool) - Optional. Skip activation hooks. Default false.

**Returns:** `null|WP_Error` - Null on success, WP_Error on failure

**Source:** `wp-admin/includes/plugin.php`

---

### `deactivate_plugins( $plugins, $silent, $network_wide )`
Deactivates one or more plugins.

```php
// Single plugin
deactivate_plugins( 'my-plugin/my-plugin.php' );

// Multiple plugins
deactivate_plugins( array(
    'plugin-one/plugin-one.php',
    'plugin-two/plugin-two.php'
) );

// Silent deactivation (skip hooks)
deactivate_plugins( 'my-plugin/my-plugin.php', true );

// Network-wide deactivation
deactivate_plugins( 'my-plugin/my-plugin.php', false, true );
```

**Parameters:**
- `$plugins` (string|string[]) - Single plugin or array of plugins
- `$silent` (bool) - Optional. Skip deactivation hooks. Default false.
- `$network_wide` (bool|null) - Optional. Network deactivation. Default null (both).

**Source:** `wp-admin/includes/plugin.php`

---

### `activate_plugins( $plugins, $redirect, $network_wide, $silent )`
Activates multiple plugins.

```php
$result = activate_plugins( array(
    'plugin-one/plugin-one.php',
    'plugin-two/plugin-two.php'
) );

if ( is_wp_error( $result ) ) {
    // Contains array of individual plugin errors
    $errors = $result->get_error_data();
}
```

**Returns:** `true|WP_Error` - True on success, WP_Error with plugin errors on failure

**Source:** `wp-admin/includes/plugin.php`

---

### `delete_plugins( $plugins )`
Removes plugin files and directories.

```php
$result = delete_plugins( array( 'old-plugin/old-plugin.php' ) );

if ( is_wp_error( $result ) ) {
    echo $result->get_error_message();
}
```

**Parameters:**
- `$plugins` (string[]) - Array of plugin paths to delete

**Returns:** `bool|null|WP_Error` - True on success, false if empty, WP_Error on failure, null if credentials needed

**Source:** `wp-admin/includes/plugin.php`

---

## Plugin Data Functions

### `get_plugin_data( $plugin_file, $markup, $translate )`
Parses plugin file to retrieve metadata.

```php
$data = get_plugin_data( WP_PLUGIN_DIR . '/my-plugin/my-plugin.php' );

/*
Returns:
array(
    'Name'            => 'My Plugin',
    'PluginURI'       => 'https://example.com/my-plugin',
    'Version'         => '1.0.0',
    'Description'     => 'Plugin description.',
    'Author'          => 'Author Name',
    'AuthorURI'       => 'https://example.com',
    'TextDomain'      => 'my-plugin',
    'DomainPath'      => '/languages',
    'Network'         => false,
    'RequiresWP'      => '6.0',
    'RequiresPHP'     => '7.4',
    'UpdateURI'       => '',
    'RequiresPlugins' => 'woocommerce',
    'Title'           => 'My Plugin',
    'AuthorName'      => 'Author Name',
)
*/

// Without markup (links)
$data = get_plugin_data( $file, false );

// Without translation
$data = get_plugin_data( $file, true, false );
```

**Parameters:**
- `$plugin_file` (string) - Absolute path to main plugin file
- `$markup` (bool) - Optional. Apply HTML markup. Default true.
- `$translate` (bool) - Optional. Translate strings. Default true.

**Returns:** (array) - Plugin data array

**Source:** `wp-admin/includes/plugin.php`

---

### `get_plugins( $plugin_folder )`
Gets all installed plugins with their data.

```php
$all_plugins = get_plugins();

foreach ( $all_plugins as $plugin_path => $plugin_data ) {
    echo $plugin_data['Name'] . ': ' . $plugin_data['Version'];
}

// Get plugins from specific folder
$subfolder_plugins = get_plugins( '/my-folder' );
```

**Parameters:**
- `$plugin_folder` (string) - Optional. Relative path to subfolder. Default empty.

**Returns:** (array[]) - Array of plugin data arrays, keyed by plugin file

**Source:** `wp-admin/includes/plugin.php`

---

### `get_mu_plugins()`
Gets all must-use plugins.

```php
$mu_plugins = get_mu_plugins();

foreach ( $mu_plugins as $file => $data ) {
    echo $data['Name'];
}
```

**Returns:** (array[]) - Array of mu-plugin data arrays, keyed by filename

**Source:** `wp-admin/includes/plugin.php`

---

### `get_dropins()`
Gets all drop-in plugins.

```php
$dropins = get_dropins();

// Check if object cache is in use
if ( isset( $dropins['object-cache.php'] ) ) {
    echo 'Object cache plugin active';
}
```

**Returns:** (array[]) - Array of drop-in data arrays, keyed by filename

**Source:** `wp-admin/includes/plugin.php`

---

### `get_plugin_files( $plugin )`
Gets list of files belonging to a plugin.

```php
$files = get_plugin_files( 'my-plugin/my-plugin.php' );

/*
Returns array of relative paths:
array(
    'my-plugin/my-plugin.php',
    'my-plugin/includes/class-main.php',
    'my-plugin/assets/style.css',
    ...
)
*/
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory

**Returns:** (string[]) - Array of file paths relative to plugin root

**Filter:** `plugin_files_exclusions` - Directories/files to exclude from scan

**Source:** `wp-admin/includes/plugin.php`

---

## Validation Functions

### `validate_plugin( $plugin )`
Validates plugin path and header.

```php
$result = validate_plugin( 'my-plugin/my-plugin.php' );

if ( is_wp_error( $result ) ) {
    switch ( $result->get_error_code() ) {
        case 'plugin_invalid':
            // Invalid path
            break;
        case 'plugin_not_found':
            // File doesn't exist
            break;
        case 'no_plugin_header':
            // No valid plugin header
            break;
    }
}
```

**Returns:** `int|WP_Error` - 0 on success, WP_Error on failure

**Source:** `wp-admin/includes/plugin.php`

---

### `validate_plugin_requirements( $plugin )`
Validates WordPress and PHP version requirements.

```php
$result = validate_plugin_requirements( 'my-plugin/my-plugin.php' );

if ( is_wp_error( $result ) ) {
    // Requirements not met
    echo $result->get_error_message();
}
```

**Returns:** `true|WP_Error` - True if requirements met, WP_Error otherwise

**Error codes:**
- `plugin_wp_php_incompatible` - Both WP and PHP requirements failed
- `plugin_php_incompatible` - PHP version too low
- `plugin_wp_incompatible` - WordPress version too low

**Source:** `wp-admin/includes/plugin.php`

---

### `validate_active_plugins()`
Validates all active plugins, deactivating invalid ones.

```php
$invalid = validate_active_plugins();

foreach ( $invalid as $plugin => $error ) {
    echo $plugin . ': ' . $error->get_error_message();
}
```

**Returns:** (WP_Error[]) - Array of errors keyed by plugin file

**Source:** `wp-admin/includes/plugin.php`

---

## Admin Menu Functions

### `get_plugin_page_hook( $plugin_page, $parent_page )`
Gets the hook name for a plugin admin page.

```php
$hook = get_plugin_page_hook( 'my-settings', 'options-general.php' );
// Returns: 'settings_page_my-settings'
```

**Source:** `wp-admin/includes/plugin.php`

---

### `get_plugin_page_hookname( $plugin_page, $parent_page )`
Gets the hookname for plugin page output.

```php
$hookname = get_plugin_page_hookname( 'my-settings', 'options-general.php' );
```

**Source:** `wp-admin/includes/plugin.php`

---

## Utility Functions

### `plugin_sandbox_scrape( $plugin )`
Loads a plugin in a sandbox for testing fatal errors.

```php
// Used internally during activation
plugin_sandbox_scrape( 'my-plugin/my-plugin.php' );
```

**Source:** `wp-admin/includes/plugin.php`

---

### `is_uninstallable_plugin( $plugin )`
Checks if plugin has registered an uninstall hook or has uninstall.php.

```php
if ( is_uninstallable_plugin( 'my-plugin/my-plugin.php' ) ) {
    // Will run cleanup on deletion
}
```

**Source:** `wp-admin/includes/plugin.php`

---

### `uninstall_plugin( $plugin )`
Runs the plugin's uninstall routine.

```php
// Called automatically during delete_plugins()
uninstall_plugin( 'my-plugin/my-plugin.php' );
```

**Source:** `wp-admin/includes/plugin.php`
