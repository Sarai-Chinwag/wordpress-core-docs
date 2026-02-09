# wp-config.php

## Purpose
Site-specific configuration for WordPress. Defines database credentials, salts, table prefix, debug/config constants, and then loads `wp-settings.php`.

## Flow
- Defines core constants (e.g., cache, DB settings, debug flags, filesystem, cron, caching).
- Loads salts/keys (in this install via `wp-salt.php`).
- Sets `$table_prefix`.
- Defines `ABSPATH` if missing.
- Requires `wp-settings.php` to bootstrap WordPress.

## Key functions called
- `require __DIR__ . '/wp-salt.php'` (site-specific salts)
- `require_once ABSPATH . 'wp-settings.php'`

## Hooks fired
- None directly in this file.

## Notes
- This instance includes additional constants for caching, filesystem permissions, CDN, Redis, and cron behavior. Values are environment-specific and should not be committed or shared.
