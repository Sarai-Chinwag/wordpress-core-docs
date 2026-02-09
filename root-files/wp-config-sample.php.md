# wp-config-sample.php

## Purpose
Template configuration file used during installation. Provides placeholder constants and structure for creating a real `wp-config.php`.

## Flow
- Defines placeholder DB constants and authentication salts.
- Sets `$table_prefix` and `WP_DEBUG` defaults.
- Defines `ABSPATH` if missing.
- Requires `wp-settings.php` to bootstrap WordPress once configured.

## Key functions called
- `require_once ABSPATH . 'wp-settings.php'`

## Hooks fired
- None directly in this file.
