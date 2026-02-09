# wp-blog-header.php

## Purpose
Loads the WordPress environment and runs the front-end request lifecycle (query + template).

## Flow
- Ensures it only runs once via `$wp_did_header` guard.
- Requires `wp-load.php` to bootstrap WordPress.
- Calls `wp()` to set up the main query.
- Requires `template-loader.php` to load the appropriate theme template.

## Key functions called
- `wp()`
- `require_once ABSPATH . WPINC . '/template-loader.php'`

## Hooks fired
- None directly in this file. Hooks fire during `wp()` and template loading.
