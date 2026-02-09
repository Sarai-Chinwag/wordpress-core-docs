# index.php

## Purpose
Entry point for front-end requests. It only defines `WP_USE_THEMES` and hands off execution to `wp-blog-header.php`.

## Flow
- Defines `WP_USE_THEMES` as `true` to signal that the theme should render.
- Requires `wp-blog-header.php` to bootstrap WordPress, run the main query, and load the template.

## Key functions called
- `require __DIR__ . '/wp-blog-header.php'` (hands off to core loader and template pipeline).

## Hooks fired
- None directly in this file. Hooks fire in `wp-blog-header.php` and downstream bootstrapping.
