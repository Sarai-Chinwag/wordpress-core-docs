# WP_Recovery_Mode_Email_Service

Service class for sending recovery mode notification emails with rate limiting.

**Source:** `wp-includes/class-wp-recovery-mode-email-service.php`  
**Since:** 5.2.0

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `RATE_LIMIT_OPTION` | `'recovery_mode_email_last_sent'` | Option name for rate limiting |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$link_service` | WP_Recovery_Mode_Link_Service | private | Service for generating recovery URLs |

---

## Methods

### __construct()

Creates the email service instance.

```php
public function __construct( WP_Recovery_Mode_Link_Service $link_service )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$link_service` | WP_Recovery_Mode_Link_Service | Link generation service |

---

### maybe_send_recovery_mode_email()

Sends recovery email if rate limit allows.

```php
public function maybe_send_recovery_mode_email( int $rate_limit, array $error, array $extension ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rate_limit` | int | Seconds before another email can be sent |
| `$error` | array | Error details from `error_get_last()` |
| `$extension` | array | Extension that caused the error |

**Returns:** `true` if sent, `WP_Error` otherwise.

**Error Codes:**
- `storage_error` — Could not update last sent time
- `email_failed` — `mail()` function failed
- `email_sent_already` — Rate limit not expired

---

### clear_rate_limit()

Clears the rate limit, allowing immediate email send.

```php
public function clear_rate_limit(): bool
```

**Returns:** `true` on success, `false` on failure.

---

### send_recovery_mode_email() <small>(private)</small>

Sends the recovery mode email to the admin.

```php
private function send_recovery_mode_email( int $rate_limit, array $error, array $extension ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rate_limit` | int | TTL for the recovery link |
| `$error` | array | Error details |
| `$extension` | array | Extension info |

**Returns:** `true` if email sent.

**Email Contents:**
- Recovery mode link URL
- Link expiration time
- Cause description (plugin/theme name)
- Error details (type, line, file, message)
- Debug info (WP version, active theme, plugin version, PHP version)
- Support contact message

**Placeholders in Template:**
- `###LINK###` — Recovery mode URL
- `###EXPIRES###` — Human-readable expiration
- `###CAUSE###` — Extension that caused the error
- `###DETAILS###` — Formatted error details
- `###SITEURL###` — Site home URL
- `###PAGEURL###` — Page where error occurred
- `###SUPPORT###` — Support message
- `###DEBUG###` — Debug information

**Filter:** `recovery_mode_email`

---

### get_recovery_mode_email_address() <small>(private)</small>

Gets the recipient email address.

```php
private function get_recovery_mode_email_address(): string
```

**Returns:** Email from `RECOVERY_MODE_EMAIL` constant if defined and valid, otherwise `admin_email` option.

---

### get_cause() <small>(private)</small>

Gets a description of which extension caused the error.

```php
private function get_cause( array $extension ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | array | Extension info (`slug`, `type`) |

**Returns:** Human-readable cause message.

---

### get_plugin() <small>(private)</small>

Gets plugin data for an extension.

```php
private function get_plugin( array $extension ): array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | array | Extension info |

**Returns:** Plugin array from `get_plugins()` or `false`.

**Lookup Order:**
1. `{slug}/{slug}.php` (common convention)
2. Any plugin file starting with `{slug}/`

---

### get_debug() <small>(private)</small>

Gets debug information for the email.

```php
private function get_debug( array $extension ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$extension` | array | Extension info |

**Returns:** Associative array with debug info.

**Keys:**
- `wp` — WordPress version
- `theme` — Active theme name and version
- `plugin` — Failing plugin name and version (if applicable)
- `php` — PHP version

**Filter:** `recovery_email_debug_info`
