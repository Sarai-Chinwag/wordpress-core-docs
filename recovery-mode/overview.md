# Recovery Mode

Error protection system that detects fatal errors from plugins/themes and allows administrators to safely access the site.

**Since:** 5.2.0  
**Source:** `wp-includes/class-wp-recovery-mode.php`, `wp-includes/error-protection.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core helper functions for error protection |
| [class-wp-recovery-mode.md](./class-wp-recovery-mode.md) | Main recovery mode orchestrator |
| [class-wp-recovery-mode-cookie-service.md](./class-wp-recovery-mode-cookie-service.md) | Cookie generation and validation |
| [class-wp-recovery-mode-key-service.md](./class-wp-recovery-mode-key-service.md) | Recovery key generation and storage |
| [class-wp-recovery-mode-link-service.md](./class-wp-recovery-mode-link-service.md) | Recovery URL generation and handling |
| [class-wp-recovery-mode-email-service.md](./class-wp-recovery-mode-email-service.md) | Recovery mode email notifications |
| [class-wp-paused-extensions-storage.md](./class-wp-paused-extensions-storage.md) | Storage for paused plugins/themes |
| [hooks.md](./hooks.md) | Actions and filters |

## How It Works

When a fatal error occurs in a plugin or theme:

1. **Detection** — WordPress shutdown handler catches the fatal error
2. **Email** — Recovery mode email sent to admin with a secure link
3. **Entry** — Admin clicks link, cookie is set, recovery mode activates
4. **Pausing** — Faulty extension is paused for this session only
5. **Exit** — Admin exits recovery mode or logs out, paused extensions cleared

## Error Detection Flow

```
Fatal Error Occurs
    └── WP_Fatal_Error_Handler::handle()
            └── WP_Recovery_Mode::handle_error()
                    ├── get_extension_for_error()
                    ├── is_protected_endpoint()
                    └── WP_Recovery_Mode_Email_Service::maybe_send_recovery_mode_email()
```

## Recovery Mode Entry Flow

```
Admin clicks recovery link
    └── WP_Recovery_Mode_Link_Service::handle_begin_link()
            ├── WP_Recovery_Mode_Key_Service::validate_recovery_mode_key()
            ├── WP_Recovery_Mode_Cookie_Service::set_cookie()
            └── Redirect to wp-login.php?action=entered_recovery_mode
```

## Session Validation Flow

```
Subsequent requests with cookie
    └── WP_Recovery_Mode::initialize()
            └── WP_Recovery_Mode::handle_cookie()
                    ├── WP_Recovery_Mode_Cookie_Service::validate_cookie()
                    ├── WP_Recovery_Mode_Cookie_Service::get_session_id_from_cookie()
                    └── Set is_active = true
```

## Extension Pausing Flow

```
Error occurs in active session
    └── WP_Recovery_Mode::store_error()
            ├── wp_paused_plugins()->set()
            └── wp_paused_themes()->set()
                    └── WP_Paused_Extensions_Storage::set()
```

## Constants

| Constant | Description |
|----------|-------------|
| `WP_RECOVERY_MODE_SESSION_ID` | Defined during recovery mode, contains session ID |
| `RECOVERY_MODE_COOKIE` | Cookie name for recovery mode session |
| `WP_DISABLE_FATAL_ERROR_HANDLER` | Set to `true` in wp-config.php to disable recovery mode |
| `RECOVERY_MODE_EMAIL` | Override email address for recovery notifications |

## Protected Endpoints

Recovery mode emails are only sent for errors on "protected endpoints":

- Admin pages (`/wp-admin/`)
- Login page (`/wp-login.php`)
- AJAX requests
- REST API requests
- JSON API requests
- XMLRPC requests

Frontend errors do not trigger recovery mode emails.
