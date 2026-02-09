# wp-load.php

## Purpose
Bootstraps WordPress by defining `ABSPATH` and loading `wp-config.php`, which then loads `wp-settings.php`. If no config exists, it initiates the setup flow.

## Flow
- Defines `ABSPATH` to the WordPress root if not already defined.
- Initializes a baseline `error_reporting()` level.
- Loads `wp-config.php` from the root, or one directory above if present and not another install.
- If no config is found:
  - Loads minimal core (`version.php`, `compat.php`, `load.php`).
  - Runs `wp_check_php_mysql_versions()` and `wp_fix_server_vars()`.
  - Loads `functions.php`, computes setup URL, and redirects to `setup-config.php`.
  - Loads early translations and exits with `wp_die()` messaging.

## Key functions called
- `wp_check_php_mysql_versions()`
- `wp_fix_server_vars()`
- `wp_guess_url()`
- `wp_load_translations_early()`
- `wp_die()`

## Hooks fired
- None directly in this file.
