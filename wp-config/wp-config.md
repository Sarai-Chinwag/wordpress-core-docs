# wp-config.php Overview

The `wp-config.php` file is WordPress's primary configuration file. It contains the essential settings WordPress needs to connect to the database and operate. This file is created during WordPress installation and resides in the root WordPress directory.

## File Location

By default: `/wp-config.php` (WordPress root)

WordPress also checks one directory above the root, allowing you to keep wp-config.php outside the web-accessible directory for security:

```
/wp-config.php          ← WordPress checks here first
/public_html/           ← WordPress installation
```

## File Structure

A standard wp-config.php contains:

1. **Database settings** - Connection credentials
2. **Security keys and salts** - Authentication tokens
3. **Table prefix** - Database table naming
4. **Debug settings** - Development/troubleshooting options
5. **Custom constants** - Site-specific configuration
6. **ABSPATH definition** - WordPress directory path
7. **wp-settings.php include** - Bootstraps WordPress

## Basic Template

```php
<?php
/**
 * WordPress Configuration File
 */

// ** Database settings ** //
define( 'DB_NAME', 'database_name' );
define( 'DB_USER', 'database_user' );
define( 'DB_PASSWORD', 'database_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// ** Security Keys and Salts ** //
define( 'AUTH_KEY',         'unique-phrase-here' );
define( 'SECURE_AUTH_KEY',  'unique-phrase-here' );
define( 'LOGGED_IN_KEY',    'unique-phrase-here' );
define( 'NONCE_KEY',        'unique-phrase-here' );
define( 'AUTH_SALT',        'unique-phrase-here' );
define( 'SECURE_AUTH_SALT', 'unique-phrase-here' );
define( 'LOGGED_IN_SALT',   'unique-phrase-here' );
define( 'NONCE_SALT',       'unique-phrase-here' );

// ** Table Prefix ** //
$table_prefix = 'wp_';

// ** Debug Settings ** //
define( 'WP_DEBUG', false );

// ** Absolute Path ** //
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

// ** Load WordPress ** //
require_once ABSPATH . 'wp-settings.php';
```

## Table Prefix

```php
$table_prefix = 'wp_';
```

- **Type**: String (variable, not constant)
- **Default**: `wp_`
- **Purpose**: Prefixes all database table names
- **Security**: Change from default to prevent automated SQL injection attacks
- **Multisite**: Each site can have its own prefix (e.g., `wp_2_`, `wp_3_`)
- **Requirements**: Only numbers, letters, and underscores; must end with underscore

### Custom Prefix Example

```php
$table_prefix = 'mysite_2024_';
// Tables: mysite_2024_posts, mysite_2024_options, etc.
```

## Important Notes

### Order Matters

Constants must be defined **before** the `wp-settings.php` include:

```php
// ✓ Correct - defined before wp-settings.php
define( 'WP_DEBUG', true );
require_once ABSPATH . 'wp-settings.php';

// ✗ Wrong - defined after (will have no effect)
require_once ABSPATH . 'wp-settings.php';
define( 'WP_DEBUG', true );
```

### PHP Syntax

- Must start with `<?php`
- No closing `?>` tag (prevents whitespace issues)
- No whitespace or BOM before `<?php`
- Use single quotes for strings (prevents variable interpolation issues)

### File Permissions

Recommended permissions:
- **440** or **400** - Read-only for owner (most secure)
- **644** - Readable by all, writable by owner (common)
- Never use 777

### Version Control

**Never commit wp-config.php to version control** with real credentials. Use:

```php
// wp-config.php
if ( file_exists( __DIR__ . '/wp-config-local.php' ) ) {
    require_once __DIR__ . '/wp-config-local.php';
} else {
    // Production settings
    define( 'DB_NAME', 'prod_db' );
    // ...
}
```

## Environment Detection

Common pattern for environment-specific settings:

```php
// Detect environment
$environment = getenv( 'WP_ENVIRONMENT_TYPE' ) ?: 'production';

switch ( $environment ) {
    case 'local':
    case 'development':
        define( 'WP_DEBUG', true );
        define( 'WP_DEBUG_DISPLAY', true );
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

## WP_ENVIRONMENT_TYPE

```php
define( 'WP_ENVIRONMENT_TYPE', 'development' );
```

- **Since**: WordPress 5.5
- **Values**: `local`, `development`, `staging`, `production`
- **Default**: `production`
- **Function**: `wp_get_environment_type()` returns current environment

## Related Documentation

- [database.md](database.md) - Database connection settings
- [security.md](security.md) - Security keys, salts, and hardening
- [debug.md](debug.md) - Debug and development settings
- [paths.md](paths.md) - Directory and URL configuration
- [multisite.md](multisite.md) - Network/Multisite settings
- [performance.md](performance.md) - Caching, memory, and optimization
- [updates.md](updates.md) - Automatic update controls
