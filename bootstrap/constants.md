# WordPress Bootstrap Constants

Constants defined during WordPress initialization. Many can be overridden in `wp-config.php`.

## Version Constants

Defined in `wp-includes/version.php`:

| Constant | Value | Purpose |
|----------|-------|---------|
| `$wp_version` | `'6.9.1'` | WordPress version string |
| `$wp_db_version` | `60717` | Database schema version |
| `$tinymce_version` | `'49110-20250317'` | TinyMCE version |
| `$required_php_version` | `'7.2.24'` | Minimum PHP version |
| `$required_php_extensions` | `['json', 'hash']` | Required PHP extensions |
| `$required_mysql_version` | `'5.5.5'` | Minimum MySQL version |

## Size Constants

Defined in `wp_initial_constants()`:

```php
define( 'KB_IN_BYTES', 1024 );
define( 'MB_IN_BYTES', 1024 * KB_IN_BYTES );         // 1,048,576
define( 'GB_IN_BYTES', 1024 * MB_IN_BYTES );         // 1,073,741,824
define( 'TB_IN_BYTES', 1024 * GB_IN_BYTES );         // 1,099,511,627,776
define( 'PB_IN_BYTES', 1024 * TB_IN_BYTES );
define( 'EB_IN_BYTES', 1024 * PB_IN_BYTES );
define( 'ZB_IN_BYTES', 1024 * EB_IN_BYTES );
define( 'YB_IN_BYTES', 1024 * ZB_IN_BYTES );
```

**Since:** 4.4.0 (PB through YB added in 6.0.0)

## Time Constants

Defined in `wp_initial_constants()`:

```php
define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS', 60 * MINUTE_IN_SECONDS );     // 3,600
define( 'DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS );        // 86,400
define( 'WEEK_IN_SECONDS', 7 * DAY_IN_SECONDS );         // 604,800
define( 'MONTH_IN_SECONDS', 30 * DAY_IN_SECONDS );       // 2,592,000
define( 'YEAR_IN_SECONDS', 365 * DAY_IN_SECONDS );       // 31,536,000
```

**Note:** These are approximations. Use `DateTime` class for precise calculations.

**Since:** 3.5.0 (MONTH_IN_SECONDS added in 4.4.0)

## Memory Constants

Defined in `wp_initial_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_MEMORY_LIMIT` | `'40M'` (single) / `'64M'` (multisite) | Normal memory limit |
| `WP_MAX_MEMORY_LIMIT` | `'256M'` | Admin memory limit |

**Override in wp-config.php:**
```php
define( 'WP_MEMORY_LIMIT', '128M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
```

## Debug Constants

Defined in `wp_initial_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_DEBUG` | `false` | Enable debug mode |
| `WP_DEBUG_DISPLAY` | `true` | Display errors |
| `WP_DEBUG_LOG` | `false` | Log errors to file |

**Configuration Examples:**
```php
// Development setup
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'WP_DEBUG_LOG', true );

// Production setup with logging
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', '/path/to/debug.log' );

// Use global display_errors setting
define( 'WP_DEBUG_DISPLAY', null );
```

## Development Constants

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_DEVELOPMENT_MODE` | `''` | Development mode (`core`, `plugin`, `theme`, `all`) |
| `SCRIPT_DEBUG` | `false` | Load unminified scripts/styles |

**Configuration:**
```php
define( 'WP_DEVELOPMENT_MODE', 'theme' );
define( 'SCRIPT_DEBUG', true );
```

## Cache Constants

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_CACHE` | `false` | Enable advanced-cache.php |

## Path Constants

### Core Paths

| Constant | Default | Purpose |
|----------|---------|---------|
| `ABSPATH` | WordPress root | Base directory |
| `WPINC` | `'wp-includes'` | Includes directory name |
| `WP_CONTENT_DIR` | `ABSPATH . 'wp-content'` | Content directory path |
| `WP_CONTENT_URL` | `site_url() . '/wp-content'` | Content directory URL |

### Plugin Paths

Defined in `wp_plugin_directory_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_PLUGIN_DIR` | `WP_CONTENT_DIR . '/plugins'` | Plugins directory path |
| `WP_PLUGIN_URL` | `WP_CONTENT_URL . '/plugins'` | Plugins directory URL |
| `PLUGINDIR` | `'wp-content/plugins'` | Relative plugins path (deprecated) |
| `WPMU_PLUGIN_DIR` | `WP_CONTENT_DIR . '/mu-plugins'` | MU-plugins path |
| `WPMU_PLUGIN_URL` | `WP_CONTENT_URL . '/mu-plugins'` | MU-plugins URL |
| `MUPLUGINDIR` | `'wp-content/mu-plugins'` | Relative MU-plugins path (deprecated) |

### Language Paths

Defined in `wp_set_lang_dir()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_LANG_DIR` | `WP_CONTENT_DIR . '/languages'` | Language files path |
| `LANGDIR` | `'wp-content/languages'` | Relative language path (deprecated) |

### Template Paths

Defined in `wp_templating_constants()`:

| Constant | Purpose | Deprecated |
|----------|---------|------------|
| `TEMPLATEPATH` | Current template directory | 6.4.0 |
| `STYLESHEETPATH` | Current stylesheet directory | 6.4.0 |

**Use instead:** `get_template_directory()` and `get_stylesheet_directory()`

## Cookie Constants

Defined in `wp_cookie_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `COOKIEHASH` | `md5(siteurl)` | Unique hash for cookies |
| `USER_COOKIE` | `'wordpressuser_' . COOKIEHASH` | User cookie name |
| `PASS_COOKIE` | `'wordpresspass_' . COOKIEHASH` | Password cookie name |
| `AUTH_COOKIE` | `'wordpress_' . COOKIEHASH` | Auth cookie name |
| `SECURE_AUTH_COOKIE` | `'wordpress_sec_' . COOKIEHASH` | Secure auth cookie |
| `LOGGED_IN_COOKIE` | `'wordpress_logged_in_' . COOKIEHASH` | Logged-in cookie |
| `TEST_COOKIE` | `'wordpress_test_cookie'` | Test cookie name |
| `COOKIEPATH` | `'/'` (home path) | Cookie path |
| `SITECOOKIEPATH` | Site path | Site cookie path |
| `ADMIN_COOKIE_PATH` | `SITECOOKIEPATH . 'wp-admin'` | Admin cookie path |
| `PLUGINS_COOKIE_PATH` | Plugins URL path | Plugins cookie path |
| `COOKIE_DOMAIN` | `''` | Cookie domain |
| `RECOVERY_MODE_COOKIE` | `'wordpress_rec_' . COOKIEHASH` | Recovery mode cookie |

## SSL Constants

Defined in `wp_ssl_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `FORCE_SSL_ADMIN` | `true` if site uses HTTPS | Force SSL for admin |
| `FORCE_SSL_LOGIN` | N/A | Deprecated in 4.0.0 |

## Functionality Constants

Defined in `wp_functionality_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `AUTOSAVE_INTERVAL` | `60` (1 minute) | Autosave interval in seconds |
| `EMPTY_TRASH_DAYS` | `30` | Days before trash auto-empties |
| `WP_POST_REVISIONS` | `true` | Enable post revisions |
| `WP_CRON_LOCK_TIMEOUT` | `60` | Cron lock timeout in seconds |

**Disable revisions:**
```php
define( 'WP_POST_REVISIONS', false );
```

**Limit revisions:**
```php
define( 'WP_POST_REVISIONS', 5 );
```

## Theme Constants

Defined in `wp_templating_constants()`:

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_DEFAULT_THEME` | `'twentytwentyfive'` | Fallback theme |

## Media Constants

| Constant | Default | Purpose |
|----------|---------|---------|
| `MEDIA_TRASH` | `false` | Enable media trash |

## Environment Constants

| Constant | Default | Purpose |
|----------|---------|---------|
| `WP_ENVIRONMENT_TYPE` | `'production'` | Environment type |

**Values:** `'local'`, `'development'`, `'staging'`, `'production'`

## Request Type Constants

Set during request processing:

| Constant | Purpose |
|----------|---------|
| `WP_ADMIN` | Admin request |
| `WP_BLOG_ADMIN` | Site admin request |
| `WP_NETWORK_ADMIN` | Network admin request |
| `WP_USER_ADMIN` | User admin request |
| `DOING_AJAX` | AJAX request |
| `DOING_CRON` | Cron request |
| `REST_REQUEST` | REST API request |
| `XMLRPC_REQUEST` | XML-RPC request |
| `WP_INSTALLING` | Installation in progress |

## Special Load Constants

| Constant | Purpose |
|----------|---------|
| `SHORTINIT` | Minimal bootstrap (skip plugins, themes) |
| `WP_USE_THEMES` | Load themes (default `true`) |
| `WP_SANDBOX_SCRAPING` | Error scraping mode |
| `IFRAME_REQUEST` | Request in iframe |

## Security Constants

| Constant | Default | Purpose |
|----------|---------|---------|
| `DISALLOW_FILE_MODS` | `false` | Disable plugin/theme editor |
| `DISALLOW_FILE_EDIT` | `false` | Disable file editor only |
| `DISALLOW_UNFILTERED_HTML` | `false` | Disable unfiltered HTML |
| `ALLOW_UNFILTERED_UPLOADS` | `false` | Allow unfiltered file uploads |
| `AUTOMATIC_UPDATER_DISABLED` | `false` | Disable auto-updates |

## Multisite Constants

| Constant | Purpose |
|----------|---------|
| `MULTISITE` | Multisite enabled |
| `SUBDOMAIN_INSTALL` | Subdomain multisite |
| `DOMAIN_CURRENT_SITE` | Main site domain |
| `PATH_CURRENT_SITE` | Main site path |
| `SITE_ID_CURRENT_SITE` | Main network ID |
| `BLOG_ID_CURRENT_SITE` | Main site ID |
| `SUNRISE` | Load sunrise.php |

## Feature Constants

| Constant | Purpose |
|----------|---------|
| `WP_FEATURE_BETTER_PASSWORDS` | Better password handling available |

## Timestamp Constants

| Constant | Purpose |
|----------|---------|
| `WP_START_TIMESTAMP` | Request start time (microtime) |

## Defining Constants

Constants should be defined in `wp-config.php` before `require_once ABSPATH . 'wp-settings.php'`:

```php
// Example wp-config.php

// Debug settings
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SCRIPT_DEBUG', true );

// Memory limits
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// Custom content directory
define( 'WP_CONTENT_DIR', '/var/www/content' );
define( 'WP_CONTENT_URL', 'https://example.com/content' );

// Custom plugin directory
define( 'WP_PLUGIN_DIR', '/var/www/content/plugins' );
define( 'WP_PLUGIN_URL', 'https://example.com/content/plugins' );

// Revisions
define( 'WP_POST_REVISIONS', 10 );
define( 'AUTOSAVE_INTERVAL', 120 );

// Security
define( 'DISALLOW_FILE_EDIT', true );
define( 'FORCE_SSL_ADMIN', true );

// Cron
define( 'DISABLE_WP_CRON', true );  // If using system cron
define( 'ALTERNATE_WP_CRON', true ); // Alternative cron method

// Must be last
require_once ABSPATH . 'wp-settings.php';
```

## Checking Constants

```php
// Check if defined
if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
    // Debug mode is on
}

// Check specific value
if ( defined( 'WP_ENVIRONMENT_TYPE' ) ) {
    $env = WP_ENVIRONMENT_TYPE;
} else {
    $env = 'production';
}

// Use helper functions when available
if ( function_exists( 'wp_get_environment_type' ) ) {
    $env = wp_get_environment_type();
}
```
