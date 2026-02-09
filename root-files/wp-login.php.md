# wp-login.php

## Purpose
Handles authentication-related flows: login, logout, registration, password reset, and admin email confirmation.

## Flow
- Loads WordPress via `wp-load.php` and enforces SSL if required.
- Determines the `$action` (login, logout, lostpassword, resetpass, register, etc.).
- Renders the login header/footer wrappers.
- Routes to the appropriate handler:
  - Login: validates credentials, calls `wp_signon()`, sets auth cookies, redirects.
  - Logout: calls `wp_logout()` and redirects.
  - Lost password: calls `retrieve_password()` and sends reset email.
  - Reset password: validates key, calls `reset_password()`.
  - Register: calls `register_new_user()` (when enabled).
  - Admin email confirmation / user request confirmation.

## Key functions called
- `wp_signon()`
- `wp_logout()`
- `retrieve_password()`
- `reset_password()`
- `register_new_user()`
- `wp_login_form()` / `login_header()` / `login_footer()`
- `wp_safe_redirect()`

## Hooks fired
- Actions:
  - `login_enqueue_scripts`
  - `login_head`
  - `login_header`
  - `login_footer`
  - `login_init`
  - `login_form_{$action}`
  - `admin_email_confirm`
  - `admin_email_confirm_form`
  - `lost_password`
  - `lostpassword_form`
  - `validate_password_reset`
  - `resetpass_form`
  - `register_form`
  - `user_request_action_confirmed`
  - `login_form`
- Filters (selected):
  - `shake_error_codes`
  - `login_title`
  - `login_headerurl`
  - `login_headertext`
  - `login_body_class`
