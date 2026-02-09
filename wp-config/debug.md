# Debug Settings

WordPress provides extensive debugging options for development and troubleshooting. These should be disabled in production.

## Primary Debug Constants

### WP_DEBUG

```php
define( 'WP_DEBUG', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Master switch for WordPress debug mode
- **Effect When True**:
  - PHP errors, warnings, and notices are displayed
  - Deprecated function notices are shown
  - Enables other debug features (WP_DEBUG_LOG, WP_DEBUG_DISPLAY)

### WP_DEBUG_LOG

```php
define( 'WP_DEBUG_LOG', true );
```

- **Type**: Boolean or String (path)
- **Default**: `false`
- **Requires**: `WP_DEBUG` must be `true`
- **Purpose**: Writes errors to a log file
- **Default Location**: `/wp-content/debug.log`

#### Custom Log Path

```php
// Log to custom location
define( 'WP_DEBUG_LOG', '/var/log/wordpress/debug.log' );

// Log to a path outside web root (recommended)
define( 'WP_DEBUG_LOG', dirname( __DIR__ ) . '/logs/wp-debug.log' );
```

### WP_DEBUG_DISPLAY

```php
define( 'WP_DEBUG_DISPLAY', false );
```

- **Type**: Boolean
- **Default**: `true` (when WP_DEBUG is true)
- **Requires**: `WP_DEBUG` must be `true`
- **Purpose**: Controls whether errors are printed to the screen
- **Recommendation**: Set to `false` in production even during debugging

### Recommended Debug Configurations

#### Development Environment

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
```

#### Production Debugging (Safe)

```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', '/var/log/wordpress/debug.log' );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
```

#### Production (Normal)

```php
define( 'WP_DEBUG', false );
// Or simply don't define it (defaults to false)
```

## Script and Asset Debugging

### SCRIPT_DEBUG

```php
define( 'SCRIPT_DEBUG', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Forces WordPress to use development versions of CSS and JavaScript files
- **Effect**:
  - Loads `.dev.js` instead of `.min.js`
  - Loads non-minified CSS
  - Disables concatenation
- **Use Case**: Debugging JavaScript/CSS issues, developing themes/plugins

### CONCATENATE_SCRIPTS

```php
define( 'CONCATENATE_SCRIPTS', false );
```

- **Type**: Boolean
- **Default**: `true` in admin, varies on frontend
- **Purpose**: Controls whether admin scripts are combined into fewer requests
- **Effect When False**:
  - Each JavaScript file loads separately
  - Easier to identify which script causes issues
- **Note**: Automatically disabled when `SCRIPT_DEBUG` is true

### COMPRESS_SCRIPTS

```php
define( 'COMPRESS_SCRIPTS', false );
```

- **Type**: Boolean
- **Default**: `true`
- **Purpose**: Controls JavaScript compression in admin
- **Effect When False**: Scripts are served uncompressed

### COMPRESS_CSS

```php
define( 'COMPRESS_CSS', false );
```

- **Type**: Boolean
- **Default**: `true`
- **Purpose**: Controls CSS compression in admin
- **Effect When False**: Stylesheets are served uncompressed

### ENFORCE_GZIP

```php
define( 'ENFORCE_GZIP', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Forces gzip compression for scripts in admin

## Database Query Debugging

### SAVEQUERIES

```php
define( 'SAVEQUERIES', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Saves all database queries to `$wpdb->queries` array
- **Data Stored Per Query**:
  - SQL query string
  - Execution time
  - Calling function/file (backtrace)
- **Warning**: Significant memory and performance impact; never use in production

#### Using SAVEQUERIES

```php
// In your code or a must-use plugin
global $wpdb;

// Display all queries at the bottom of the page
add_action( 'shutdown', function() {
    global $wpdb;
    
    if ( ! defined( 'SAVEQUERIES' ) || ! SAVEQUERIES ) {
        return;
    }
    
    echo '<pre>';
    echo 'Total queries: ' . count( $wpdb->queries ) . "\n\n";
    
    foreach ( $wpdb->queries as $query ) {
        echo 'Query: ' . $query[0] . "\n";
        echo 'Time: ' . $query[1] . " seconds\n";
        echo 'Called from: ' . $query[2] . "\n\n";
    }
    echo '</pre>';
});
```

#### Query Monitor Integration

The Query Monitor plugin automatically uses `SAVEQUERIES` data to display a detailed query log in its toolbar panel.

## Error Display Control

### WP_DISABLE_FATAL_ERROR_HANDLER

```php
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Since**: WordPress 5.2
- **Purpose**: Disables the recovery mode and fatal error handler
- **Effect**:
  - No "There has been a critical error" message
  - No recovery mode email sent
  - Raw PHP errors shown (if display_errors is on)
- **Use Case**: Development environments where you want immediate error feedback

### WP_SANDBOX_SCRAPING

```php
define( 'WP_SANDBOX_SCRAPING', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Disables error scraping during plugin/theme activation
- **Effect**: Plugin/theme fatal errors are thrown directly instead of caught

## Environment Type

### WP_ENVIRONMENT_TYPE

```php
define( 'WP_ENVIRONMENT_TYPE', 'development' );
```

- **Type**: String
- **Default**: `production`
- **Since**: WordPress 5.5
- **Values**: `local`, `development`, `staging`, `production`
- **Purpose**: Identifies the current environment for conditional logic

#### Usage in Code

```php
// Check environment type
$env = wp_get_environment_type();

if ( 'development' === $env || 'local' === $env ) {
    // Development-only code
}

// Helper functions
if ( wp_is_development_mode( 'plugin' ) ) {
    // Plugin development mode
}
```

#### Environment-Based Configuration

```php
switch ( wp_get_environment_type() ) {
    case 'local':
    case 'development':
        define( 'WP_DEBUG', true );
        define( 'WP_DEBUG_DISPLAY', true );
        define( 'SCRIPT_DEBUG', true );
        break;
        
    case 'staging':
        define( 'WP_DEBUG', true );
        define( 'WP_DEBUG_LOG', true );
        define( 'WP_DEBUG_DISPLAY', false );
        break;
        
    case 'production':
    default:
        define( 'WP_DEBUG', false );
        break;
}
```

## Development Mode

### WP_DEVELOPMENT_MODE

```php
define( 'WP_DEVELOPMENT_MODE', 'plugin' );
```

- **Type**: String
- **Default**: Empty string
- **Since**: WordPress 6.3
- **Values**: `core`, `plugin`, `theme`, `all`, or empty string
- **Purpose**: Indicates what type of development is being done

#### Usage

```php
// Check if in any development mode
if ( wp_is_development_mode( 'all' ) ) {
    // Any development mode is active
}

// Check specific development mode
if ( wp_is_development_mode( 'theme' ) ) {
    // Theme development mode
}
```

## Additional Debug Constants

### WP_LOCAL_DEV

```php
define( 'WP_LOCAL_DEV', true );
```

- **Type**: Boolean
- **Purpose**: Custom constant often used by plugins/themes to detect local development
- **Note**: Not a core WordPress constant, but widely adopted

### DIEONDBERROR

```php
define( 'DIEONDBERROR', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Causes WordPress to die (halt) on database errors
- **Effect**: Displays database error and stops execution

### ERRORLOGFILE

```php
define( 'ERRORLOGFILE', '/path/to/error.log' );
```

- **Type**: String
- **Purpose**: Custom error log location for PHP errors (used with `ini_set`)
- **Note**: WordPress doesn't use this directly; use with PHP configuration

## Debug Plugins and Tools

While these settings are configured in wp-config.php, these plugins enhance debugging:

1. **Query Monitor** - Comprehensive debugging panel
2. **Debug Bar** - Admin toolbar debugging
3. **Log Deprecated Notices** - Tracks deprecated function usage
4. **Simply Show Hooks** - Displays hooks on page

## Complete Debug Configuration Examples

### Full Development Setup

```php
// Environment
define( 'WP_ENVIRONMENT_TYPE', 'development' );
define( 'WP_DEVELOPMENT_MODE', 'all' );

// Core debugging
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

// Script debugging
define( 'SCRIPT_DEBUG', true );
define( 'CONCATENATE_SCRIPTS', false );
define( 'COMPRESS_SCRIPTS', false );
define( 'COMPRESS_CSS', false );

// Query debugging
define( 'SAVEQUERIES', true );

// Disable recovery mode for immediate feedback
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
```

### Staging Environment

```php
define( 'WP_ENVIRONMENT_TYPE', 'staging' );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', '/var/log/wordpress/staging-debug.log' );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Keep scripts minified for realistic testing
define( 'SCRIPT_DEBUG', false );
```

### Production with Logging

```php
define( 'WP_ENVIRONMENT_TYPE', 'production' );

// Log errors but don't display
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', '/var/log/wordpress/error.log' );
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );
@ini_set( 'log_errors', 1 );
```

## Security Considerations

1. **Never enable WP_DEBUG_DISPLAY in production** - Exposes system information
2. **Protect debug.log** - Add to `.htaccess`: `<Files debug.log>Order allow,deny Deny from all</Files>`
3. **Move log outside web root** - Use custom path for WP_DEBUG_LOG
4. **Disable SAVEQUERIES in production** - Memory and performance impact
5. **Disable SCRIPT_DEBUG in production** - Slower page loads
