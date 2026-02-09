# wp-comments-post.php

## Purpose
Processes comment submissions and prevents duplicate/invalid posts.

## Flow
- Requires a POST request; otherwise returns 405.
- Loads WordPress and disables cache headers.
- Calls `wp_handle_comment_submission()` to validate and insert.
- Fires cookie-setting hook and redirects to the comment location.

## Key functions called
- `wp_handle_comment_submission()`
- `wp_get_current_user()`
- `wp_safe_redirect()`

## Hooks fired
- Actions:
  - `set_comment_cookies`
- Filters:
  - `comment_post_redirect`
