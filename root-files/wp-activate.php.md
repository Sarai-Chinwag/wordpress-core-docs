# wp-activate.php

## Purpose
Multisite activation endpoint. Validates signup activation keys and completes user/site activation.

## Flow
- Defines `WP_INSTALLING` and loads WordPress + front-end header.
- Requires multisite; otherwise redirects to registration.
- Reads activation key from query/POST/cookie and calls `wpmu_activate_signup()`.
- Sets appropriate HTTP status (404/400) for invalid states.
- Renders activation form or success/error messaging.

## Key functions called
- `wpmu_activate_signup()`
- `get_site()`
- `wp_login_url()` / `wp_lostpassword_url()`
- `switch_to_blog()` / `restore_current_blog()` (for site URL/login)

## Hooks fired
- Actions:
  - `activate_header`
  - `activate_wp_head`
