# wp-trackback.php

## Purpose
Handles incoming trackbacks/pingbacks, validates data, and creates trackback comments.

## Flow
- Loads WordPress and runs `wp( array( 'tb' => '1' ) )` when needed.
- Runs as unauthenticated user.
- Parses and validates incoming trackback fields.
- Verifies target post and pings open status.
- Creates a trackback comment via `wp_new_comment()`.
- Responds with XML success/error.

## Key functions called
- `wp()`
- `wp_set_current_user( 0 )`
- `pings_open()`
- `wp_new_comment()`

## Hooks fired
- Actions:
  - `pre_trackback_post`
  - `trackback_post`
