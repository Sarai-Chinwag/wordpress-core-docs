# WordPress Bootstrap/Loading System

## Overview

WordPress follows a carefully orchestrated loading sequence that initializes the environment, loads core functionality, and prepares the system for request handling. This document outlines the complete bootstrap process.

## Loading Sequence

### 1. Initial Entry Point

Request hits `index.php` or `wp-admin/index.php`:

```
index.php
  └── wp-blog-header.php
        ├── wp-load.php (loads WordPress)
        └── template-loader.php (loads theme template)
```

### 2. wp-load.php Sequence

```
wp-load.php
  ├── Locate wp-config.php
  └── Load wp-config.php
        └── wp-settings.php (main bootstrap)
```

### 3. wp-settings.php Bootstrap Order

This is the heart of WordPress initialization:

```
wp-settings.php
  │
  ├── [1] version.php - Version information
  │     └── Sets $wp_version, $wp_db_version, $required_php_version
  │
  ├── [2] load.php - Core loading functions
  │     └── Defines wp_fix_server_vars(), require_wp_db(), etc.
  │
  ├── [3] wp_check_php_mysql_versions()
  │     └── Validates PHP/MySQL requirements
  │
  ├── [4] default-constants.php
  │     └── wp_initial_constants() - Memory, debug, time constants
  │
  ├── [5] wp_fix_server_vars()
  │     └── Normalizes $_SERVER for IIS, CGI, etc.
  │
  ├── [6] wp_maintenance()
  │     └── Checks .maintenance file
  │
  ├── [7] timer_start()
  │     └── Starts page load timer
  │
  ├── [8] wp_debug_mode()
  │     └── Configures error reporting
  │
  ├── [9] wp_set_lang_dir()
  │     └── Sets WP_LANG_DIR constant
  │
  ├── [10] require_wp_db()
  │      └── Loads wpdb class, connects to database
  │
  ├── [11] wp_set_wpdb_vars()
  │      └── Configures table prefix, field types
  │
  ├── [12] wp_start_object_cache()
  │      └── Initializes object cache (or drop-in)
  │
  ├── [13] wp_plugin_directory_constants()
  │      └── Sets WP_PLUGIN_DIR, WPMU_PLUGIN_DIR
  │
  ├── [14] Load core includes
  │      └── compat.php, functions.php, class-wp.php, etc.
  │
  ├── [15] wp_not_installed()
  │      └── Redirects to installer if needed
  │
  ├── [16] wp_magic_quotes()
  │      └── Adds slashes to superglobals
  │
  ├── [17] Load mu-plugins
  │      └── wp_get_mu_plugins()
  │
  ├── [18] do_action('muplugins_loaded')
  │
  ├── [19] ms_cookie_constants() [multisite]
  │
  ├── [20] wp_cookie_constants()
  │
  ├── [21] wp_ssl_constants()
  │
  ├── [22] Load active plugins
  │      └── wp_get_active_and_valid_plugins()
  │
  ├── [23] do_action('plugins_loaded')
  │
  ├── [24] wp_functionality_constants()
  │
  ├── [25] do_action('setup_theme')
  │
  ├── [26] Load theme functions.php
  │
  ├── [27] do_action('after_setup_theme')
  │
  ├── [28] Register default widgets
  │
  ├── [29] do_action('init')
  │
  ├── [30] wp_templating_constants()
  │      └── TEMPLATEPATH, STYLESHEETPATH
  │
  └── [31] do_action('wp_loaded')
```

### 4. Request Processing (class-wp.php)

After `wp_loaded`, the `WP` class handles the request:

```
$wp->main()
  ├── init() - Set up current user
  ├── parse_request() - Parse URL, match rewrite rules
  ├── query_posts() - Execute main WP_Query
  ├── handle_404() - Set 404 status if needed
  ├── register_globals() - Export query vars to global scope
  ├── send_headers() - Send HTTP headers
  └── do_action('wp') - Request ready
```

### 5. Template Loading

After `wp` action fires, template is loaded:

```
template-loader.php
  ├── do_action('template_redirect')
  ├── Determine template (single.php, page.php, etc.)
  └── Include template file
```

## Key Files

| File | Purpose |
|------|---------|
| `wp-settings.php` | Main bootstrap orchestrator |
| `load.php` | Core loading functions |
| `default-constants.php` | Constant definitions |
| `default-filters.php` | Default hooks registration |
| `vars.php` | Browser/server detection globals |
| `version.php` | Version information |
| `class-wp.php` | Request handling class |

## Bootstrap Hooks (Execution Order)

1. `muplugins_loaded` - After mu-plugins load
2. `plugins_loaded` - After plugins load
3. `setup_theme` - Before theme loads
4. `after_setup_theme` - After theme functions.php
5. `init` - WordPress fully initialized
6. `wp_loaded` - After all loading complete
7. `wp` - Request parsed and ready
8. `template_redirect` - Before template loads
9. `shutdown` - PHP shutdown

## Short-Circuit Loading

### SHORTINIT Mode

Define `SHORTINIT = true` before loading wp-settings.php for minimal bootstrap:

- Loads: version.php, load.php, compat.php, wpdb
- Skips: plugins, themes, most functions

### Recovery Mode

When fatal errors occur, WordPress enters recovery mode:

- Pauses problematic plugins/themes
- Protected endpoints: wp-admin, wp-login.php
- Allows administrators to fix issues

## Database Connection

```php
// require_wp_db() in load.php
global $wpdb;
require_once ABSPATH . WPINC . '/class-wpdb.php';

// Check for db.php drop-in
if ( file_exists( WP_CONTENT_DIR . '/db.php' ) ) {
    require_once WP_CONTENT_DIR . '/db.php';
}

// Instantiate wpdb if not already done
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
```

## Object Cache Initialization

```php
// wp_start_object_cache() in load.php

// Check for object-cache.php drop-in
if ( file_exists( WP_CONTENT_DIR . '/object-cache.php' ) ) {
    require_once WP_CONTENT_DIR . '/object-cache.php';
    wp_using_ext_object_cache( true );
}

// Initialize cache
wp_cache_init();

// Register global cache groups (for multisite)
wp_cache_add_global_groups( array( 'users', 'sites', ... ) );
```

## Environment Detection

WordPress detects the environment type:

```php
wp_get_environment_type()
// Returns: 'local', 'development', 'staging', or 'production'

// Set via:
// 1. Environment variable: WP_ENVIRONMENT_TYPE
// 2. Constant in wp-config.php: define('WP_ENVIRONMENT_TYPE', 'development')
```

## Development Mode

```php
wp_get_development_mode()
// Returns: 'core', 'plugin', 'theme', 'all', or ''

wp_is_development_mode( 'theme' )
// Check if specific development mode is active
```

## Maintenance Mode

WordPress checks for `.maintenance` file in ABSPATH:

```php
// .maintenance file content
<?php $upgrading = time(); ?>

// If file exists and is < 10 minutes old, maintenance mode is active
```
