# wp-mail.php

## Purpose
Implements Post by Email: pulls messages from a configured POP3 mailbox and turns them into posts.

## Flow
- Loads WordPress and checks `enable_post_by_email_configuration` filter.
- Validates mailserver settings and rate-limits execution.
- Connects to the POP3 mailbox and iterates messages.
- Parses headers/body, maps sender to a user, builds post data.
- Inserts post via `wp_insert_post()` and deletes the processed email.

## Key functions called
- `get_option()` / `set_transient()` / `get_transient()`
- `wp_set_current_user( 0 )`
- `wp_insert_post()`
- `xmlrpc_getposttitle()`

## Hooks fired
- Actions:
  - `wp-mail.php` (custom action name)
  - `publish_phone`
- Filters:
  - `enable_post_by_email_configuration`
  - `wp_mail_original_content`
  - `phone_content`
