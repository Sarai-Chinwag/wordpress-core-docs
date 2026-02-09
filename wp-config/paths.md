# Path Settings

WordPress allows customization of directory locations and URLs through constants. These are useful for non-standard installations, security, or organizational preferences.

## Site URL Constants

### WP_SITEURL

```php
define( 'WP_SITEURL', 'https://example.com' );
```

- **Type**: String (URL)
- **Default**: Retrieved from `siteurl` option in database
- **Purpose**: The URL where WordPress core files reside
- **Effect**: Overrides database `siteurl` value
- **Must Include**: Protocol (https:// or http://)
- **Must NOT Include**: Trailing slash

### WP_HOME

```php
define( 'WP_HOME', 'https://example.com' );
```

- **Type**: String (URL)
- **Default**: Retrieved from `home` option in database
- **Purpose**: The URL users type to reach your site
- **Effect**: Overrides database `home` value
- **Must Include**: Protocol
- **Must NOT Include**: Trailing slash

### WordPress in Subdirectory

```php
// WordPress in /blog/ folder, but site accessed at root
define( 'WP_HOME', 'https://example.com' );
define( 'WP_SITEURL', 'https://example.com/blog' );
```

### Benefits of Hardcoding

1. **Performance**: Skips database lookup
2. **Security**: Prevents redirect attacks via database modification
3. **Reliability**: Works even if database is corrupted

## Content Directory

### WP_CONTENT_DIR

```php
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/custom-content' );
```

- **Type**: String (absolute path)
- **Default**: `{ABSPATH}/wp-content`
- **Purpose**: Absolute filesystem path to wp-content directory
- **Must Be**: Full server path (not URL)
- **Must NOT Have**: Trailing slash

### WP_CONTENT_URL

```php
define( 'WP_CONTENT_URL', 'https://example.com/custom-content' );
```

- **Type**: String (URL)
- **Default**: `{site_url}/wp-content`
- **Purpose**: URL to wp-content directory
- **Must NOT Have**: Trailing slash

### Renaming wp-content Example

```php
// Move and rename wp-content to "assets"
define( 'WP_CONTENT_DIR', '/var/www/html/assets' );
define( 'WP_CONTENT_URL', 'https://example.com/assets' );
```

## Plugin Directory

### WP_PLUGIN_DIR

```php
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/extensions' );
```

- **Type**: String (absolute path)
- **Default**: `{WP_CONTENT_DIR}/plugins`
- **Purpose**: Filesystem path to plugins directory

### WP_PLUGIN_URL

```php
define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/extensions' );
```

- **Type**: String (URL)
- **Default**: `{WP_CONTENT_URL}/plugins`
- **Purpose**: URL to plugins directory

### PLUGINDIR (Relative)

```php
define( 'PLUGINDIR', 'wp-content/extensions' );
```

- **Type**: String (relative path)
- **Default**: `wp-content/plugins`
- **Purpose**: Relative path to plugins from WordPress root

### Custom Plugin Directory Example

```php
// Plugins in /extensions/ instead of /wp-content/plugins/
define( 'WP_PLUGIN_DIR', dirname( __FILE__ ) . '/extensions' );
define( 'WP_PLUGIN_URL', 'https://example.com/extensions' );
define( 'PLUGINDIR', 'extensions' );
```

## Must-Use Plugins Directory

### WPMU_PLUGIN_DIR

```php
define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-extensions' );
```

- **Type**: String (absolute path)
- **Default**: `{WP_CONTENT_DIR}/mu-plugins`
- **Purpose**: Directory for must-use plugins (auto-loaded)

### WPMU_PLUGIN_URL

```php
define( 'WPMU_PLUGIN_URL', WP_CONTENT_URL . '/mu-extensions' );
```

- **Type**: String (URL)
- **Default**: `{WP_CONTENT_URL}/mu-plugins`
- **Purpose**: URL to must-use plugins directory

## Uploads Directory

### UPLOADS

```php
define( 'UPLOADS', 'wp-content/media' );
```

- **Type**: String (relative path)
- **Default**: `wp-content/uploads`
- **Purpose**: Relative path (from ABSPATH) to uploads directory
- **Note**: This is relative, NOT absolute

#### Important Notes

1. Cannot use absolute paths
2. Path is relative to ABSPATH, not WP_CONTENT_DIR
3. WordPress still creates year/month subfolders by default

### Move Uploads Outside wp-content

```php
// Uploads at site.com/media/ instead of site.com/wp-content/uploads/
define( 'UPLOADS', 'media' );
```

### Uploads with Custom wp-content

When using custom `WP_CONTENT_DIR`, uploads path needs adjustment:

```php
define( 'WP_CONTENT_DIR', '/var/www/html/assets' );
define( 'WP_CONTENT_URL', 'https://example.com/assets' );
define( 'UPLOADS', 'assets/media' ); // Relative to ABSPATH
```

## Theme Directory

WordPress doesn't have direct constants for theme directory, but themes reside in:
`{WP_CONTENT_DIR}/themes/`

To customize, use `WP_CONTENT_DIR` and include themes within it.

### register_theme_directory()

For additional theme directories (not via wp-config.php):

```php
// In a plugin or theme
register_theme_directory( '/var/www/shared-themes' );
```

## Languages Directory

### WP_LANG_DIR

```php
define( 'WP_LANG_DIR', dirname( __FILE__ ) . '/languages' );
```

- **Type**: String (absolute path)
- **Default**: `{WP_CONTENT_DIR}/languages`
- **Purpose**: Directory for WordPress translation files (.mo, .po)

### LANGDIR (Deprecated)

```php
define( 'LANGDIR', 'my-languages' ); // Deprecated
```

- **Status**: Deprecated
- **Replacement**: Use `WP_LANG_DIR`

## Temporary Directory

### WP_TEMP_DIR

```php
define( 'WP_TEMP_DIR', '/tmp/wordpress' );
```

- **Type**: String (absolute path)
- **Default**: System temp directory
- **Purpose**: Directory for temporary files during updates, uploads, etc.
- **Requirements**: Must be writable by web server

## WordPress Core Directory

### ABSPATH

```php
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
```

- **Type**: String (absolute path)
- **Default**: Directory containing wp-config.php
- **Purpose**: Absolute path to WordPress installation
- **Must Have**: Trailing slash
- **Note**: Defined at end of wp-config.php, do not redefine

## Complete Custom Directory Structure

### Example: Security-Focused Layout

```
/var/www/
├── config/
│   └── wp-config.php      # Outside web root
├── html/                   # Document root
│   ├── index.php          # Modified to find wp-config.php
│   ├── wp/                # WordPress core
│   ├── assets/            # Custom wp-content
│   │   ├── themes/
│   │   ├── extensions/    # Plugins
│   │   ├── mu-extensions/ # MU plugins
│   │   └── media/         # Uploads
│   └── languages/
└── logs/
    └── debug.log
```

**wp-config.php**:

```php
<?php
// Site URLs
define( 'WP_HOME', 'https://example.com' );
define( 'WP_SITEURL', 'https://example.com/wp' );

// Content directory
define( 'WP_CONTENT_DIR', '/var/www/html/assets' );
define( 'WP_CONTENT_URL', 'https://example.com/assets' );

// Plugins
define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/extensions' );
define( 'WP_PLUGIN_URL', WP_CONTENT_URL . '/extensions' );
define( 'PLUGINDIR', 'assets/extensions' );

// MU Plugins
define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-extensions' );
define( 'WPMU_PLUGIN_URL', WP_CONTENT_URL . '/mu-extensions' );

// Uploads (relative to ABSPATH which is /var/www/html/wp/)
define( 'UPLOADS', '../assets/media' );

// Languages
define( 'WP_LANG_DIR', '/var/www/html/languages' );

// Debug log outside web root
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', '/var/www/logs/debug.log' );
define( 'WP_DEBUG_DISPLAY', false );

// ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', '/var/www/html/wp/' );
}

require_once ABSPATH . 'wp-settings.php';
```

**html/index.php** (modified):

```php
<?php
define( 'WP_USE_THEMES', true );
require __DIR__ . '/wp/wp-blog-header.php';
```

## Symlink Handling

### Theme/Plugin Symlinks

For development with symlinked themes/plugins:

```php
// In wp-config.php - resolve symlinks for proper paths
$_SERVER['SCRIPT_FILENAME'] = realpath( $_SERVER['SCRIPT_FILENAME'] );
```

## CDN URL Configuration

For serving content from a CDN:

```php
define( 'WP_CONTENT_URL', 'https://cdn.example.com/wp-content' );
```

**Note**: This only affects `content_url()` and related functions. Many plugins have their own CDN settings.

## Path Constants Quick Reference

| Constant | Default Value | Type |
|----------|---------------|------|
| `WP_SITEURL` | Database `siteurl` | URL |
| `WP_HOME` | Database `home` | URL |
| `WP_CONTENT_DIR` | `{ABSPATH}wp-content` | Absolute path |
| `WP_CONTENT_URL` | `{site_url}/wp-content` | URL |
| `WP_PLUGIN_DIR` | `{WP_CONTENT_DIR}/plugins` | Absolute path |
| `WP_PLUGIN_URL` | `{WP_CONTENT_URL}/plugins` | URL |
| `WPMU_PLUGIN_DIR` | `{WP_CONTENT_DIR}/mu-plugins` | Absolute path |
| `WPMU_PLUGIN_URL` | `{WP_CONTENT_URL}/mu-plugins` | URL |
| `UPLOADS` | `wp-content/uploads` | Relative path |
| `WP_LANG_DIR` | `{WP_CONTENT_DIR}/languages` | Absolute path |
| `WP_TEMP_DIR` | System temp | Absolute path |
| `ABSPATH` | WordPress root + `/` | Absolute path |

## Best Practices

1. **Always use trailing-slash consistently**: ABSPATH has it, others don't
2. **Use constants for building paths**: `WP_CONTENT_DIR . '/custom'` not hardcoded paths
3. **Test after changes**: Path misconfiguration breaks sites completely
4. **Use absolute paths** for filesystem, URLs for web access
5. **Keep sensitive files outside web root**: wp-config.php, logs, etc.
