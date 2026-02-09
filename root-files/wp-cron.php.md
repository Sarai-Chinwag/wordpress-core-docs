# wp-cron.php

## Purpose
Runs scheduled tasks (WP-Cron) when triggered via web requests or server cron.

## Flow
- Sets no-cache headers and finishes the client response early when possible.
- Ensures it is not running during POST/AJAX or nested cron calls.
- Defines `DOING_CRON` and loads WordPress if needed.
- Raises memory limit, obtains cron lock, and loads due events.
- Reschedules recurring events, unschedules current events, and fires each hook.
- Releases cron lock and exits.

## Key functions called
- `wp_get_ready_cron_jobs()`
- `get_transient()` / `set_transient()` / `delete_transient()`
- `wp_reschedule_event()`
- `wp_unschedule_event()`
- `do_action_ref_array()`

## Hooks fired
- Actions:
  - `cron_reschedule_event_error`
  - `cron_unschedule_event_error`
  - Dynamic scheduled hook names via `do_action_ref_array( $hook, $args )`
