# wp-settings.php

## Purpose
Core bootstrap that initializes WordPress: loads core libraries, sets constants, configures DB/cache, loads plugins and themes, and fires the key lifecycle hooks (`init`, `wp_loaded`).

## Flow
- Defines `WPINC` and loads core version/compat/load files.
- Checks server requirements and registers fatal error handler.
- Initializes constants, time zone, server vars, maintenance mode, timers, and debug mode.
- Loads early core libraries and sets up database access (`require_wp_db`, `wp_set_wpdb_vars`).
- Starts object cache and default filters.
- Loads multisite stack when enabled.
- Loads MU plugins, network plugins, then active plugins.
- Loads pluggable functions and sets encoding/magic quotes.
- Instantiates globals (`WP_Query`, `WP_Rewrite`, `WP`, `WP_Roles`, etc.).
- Loads themes’ `functions.php`, then fires theme hooks.
- Initializes current user, runs `init`, checks multisite site status, and fires `wp_loaded`.

## Key functions called
- `wp_initial_constants()`
- `wp_register_fatal_error_handler()`
- `wp_fix_server_vars()`
- `wp_maintenance()`
- `timer_start()`
- `wp_debug_mode()`
- `require_wp_db()`
- `wp_set_wpdb_vars()`
- `wp_start_object_cache()`
- `wp_plugin_directory_constants()`
- `create_initial_taxonomies()` / `create_initial_post_types()`
- `wp_not_installed()`
- `wp_templating_constants()` / `wp_set_template_globals()`
- `load_default_textdomain()`
- `$GLOBALS['wp']->init()`

## Hooks fired
- Filters:
  - `enable_loading_advanced_cache_dropin`
- Actions:
  - `mu_plugin_loaded`
  - `network_plugin_loaded`
  - `muplugins_loaded`
  - `plugin_loaded`
  - `plugins_loaded`
  - `sanitize_comment_cookies`
  - `setup_theme`
  - `after_setup_theme`
  - `init`
  - `wp_loaded`
