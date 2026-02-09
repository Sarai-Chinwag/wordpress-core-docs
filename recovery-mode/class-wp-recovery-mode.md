# WP_Recovery_Mode

Core class implementing Recovery Mode functionality. Orchestrates cookie, key, link, and email services.

**Source:** `wp-includes/class-wp-recovery-mode.php`  
**Since:** 5.2.0

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `EXIT_ACTION` | `'exit_recovery_mode'` | Login action for exiting recovery mode |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$cookie_service` | WP_Recovery_Mode_Cookie_Service | private | Handles cookie operations |
| `$key_service` | WP_Recovery_Mode_Key_Service | private | Generates recovery keys |
| `$link_service` | WP_Recovery_Mode_Link_Service | private | Generates and validates recovery links |
| `$email_service` | WP_Recovery_Mode_Email_Service | private | Sends recovery mode emails |
| `$is_initialized` | bool | private | Whether recovery mode has been initialized |
| `$is_active` | bool | private | Whether recovery mode is active in this session |
| `$session_id` | string | private | Current recovery mode session identifier |

---

## Methods

### __construct()

Creates a new recovery mode instance and initializes all services.

```php
public function __construct()
```

Instantiates:
- `WP_Recovery_Mode_Cookie_Service`
- `WP_Recovery_Mode_Key_Service`
- `WP_Recovery_Mode_Link_Service`
- `WP_Recovery_Mode_Email_Service`

---

### initialize()

Initializes recovery mode for the current request.

```php
public function initialize(): void
```

**Actions Registered:**
- `wp_logout` → `exit_recovery_mode()`
- `login_form_exit_recovery_mode` → `handle_exit_recovery_mode()`
- `recovery_mode_clean_expired_keys` → `clean_expired_keys()`

**Behavior:**
1. Schedules daily cron for `recovery_mode_clean_expired_keys`
2. If `WP_RECOVERY_MODE_SESSION_ID` is defined, activates recovery mode
3. If recovery cookie exists, validates and activates session
4. Otherwise, checks for recovery mode link in URL

---

### is_active()

Checks whether recovery mode is active.

```php
public function is_active(): bool
```

**Returns:** `true` if recovery mode is active, `false` otherwise.

---

### get_session_id()

Gets the recovery mode session ID.

```php
public function get_session_id(): string
```

**Returns:** Session ID if active, empty string otherwise.

---

### is_initialized()

Checks whether recovery mode has been initialized.

```php
public function is_initialized(): bool
```

**Returns:** `true` if initialized, `false` otherwise.

---

### handle_error()

Handles a fatal error occurring. The caller should `die()` after calling this.

```php
public function handle_error( array $error ): true|WP_Error|void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | array | Error details from `error_get_last()` |

**Returns:**
- `true` if error handled and headers already sent
- `void` if redirecting to catch multiple errors
- `WP_Error` if error could not be handled

**Error Codes:**
- `invalid_source` — Error not caused by plugin or theme
- `non_protected_endpoint` — Error on non-protected endpoint
- `storage_error` — Failed to store the error

**Behavior:**
1. Identifies extension causing error
2. Skips network-activated plugins in multisite
3. If not in recovery mode, sends recovery email (if on protected endpoint)
4. If in recovery mode, stores error and redirects

---

### exit_recovery_mode()

Ends the current recovery mode session.

```php
public function exit_recovery_mode(): bool
```

**Returns:** `true` on success, `false` if not active.

**Actions:**
1. Clears email rate limit
2. Clears recovery cookie
3. Deletes all paused plugins
4. Deletes all paused themes

---

### handle_exit_recovery_mode()

Handles a request to exit recovery mode via login action.

```php
public function handle_exit_recovery_mode(): void
```

**URL Parameters:**
- `action` — Must be `exit_recovery_mode`
- `_wpnonce` — Valid nonce for `exit_recovery_mode`

**Behavior:**
1. Verifies nonce
2. Calls `exit_recovery_mode()`
3. Redirects to referrer or admin/home

---

### clean_expired_keys()

Removes expired recovery mode keys. Runs on daily cron.

```php
public function clean_expired_keys(): void
```

---

### handle_cookie() <small>(protected)</small>

Validates the recovery mode cookie and activates the session.

```php
protected function handle_cookie(): void
```

**Behavior:**
1. Validates cookie signature and expiration
2. Extracts session ID from cookie
3. Sets `$is_active = true` and `$session_id`
4. On error, clears cookie and calls `wp_die()`

---

### get_email_rate_limit() <small>(protected)</small>

Gets the rate limit between recovery mode emails.

```php
protected function get_email_rate_limit(): int
```

**Returns:** Rate limit in seconds (default: `DAY_IN_SECONDS`).

**Filter:** `recovery_mode_email_rate_limit`

---

### get_link_ttl() <small>(protected)</small>

Gets how long a recovery mode link is valid.

```php
protected function get_link_ttl(): int
```

**Returns:** TTL in seconds (minimum of rate limit).

**Filter:** `recovery_mode_email_link_ttl`

---

### get_extension_for_error() <small>(protected)</small>

Identifies the plugin or theme that caused the error.

```php
protected function get_extension_for_error( array $error ): array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | array | Error details from `error_get_last()` |

**Returns:** Extension info array or `false`.

```php
array(
    'type' => 'plugin', // or 'theme'
    'slug' => 'extension-directory-name',
)
```

---

### is_network_plugin() <small>(protected)</small>

Checks if the extension is a network-activated plugin.

```php
protected function is_network_plugin( array $extension ): bool
```

**Returns:** `true` if network plugin on multisite, `false` otherwise.

---

### store_error() <small>(protected)</small>

Stores the error so the extension is paused.

```php
protected function store_error( array $error ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$error` | array | Error details from `error_get_last()` |

**Returns:** `true` on success, `false` on failure.

---

### redirect_protected() <small>(protected)</small>

Redirects the current request to catch multiple errors.

```php
protected function redirect_protected(): void
```

Exits after redirect.
