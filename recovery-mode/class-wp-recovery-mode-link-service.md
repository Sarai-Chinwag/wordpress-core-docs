# WP_Recovery_Mode_Link_Service

Service class for generating and handling recovery mode links.

**Source:** `wp-includes/class-wp-recovery-mode-link-service.php`  
**Since:** 5.2.0

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `LOGIN_ACTION_ENTER` | `'enter_recovery_mode'` | Login action for entering recovery mode |
| `LOGIN_ACTION_ENTERED` | `'entered_recovery_mode'` | Login action after successful entry |

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$key_service` | WP_Recovery_Mode_Key_Service | private | Key generation service |
| `$cookie_service` | WP_Recovery_Mode_Cookie_Service | private | Cookie handling service |

---

## Methods

### __construct()

Creates the link service instance.

```php
public function __construct(
    WP_Recovery_Mode_Cookie_Service $cookie_service,
    WP_Recovery_Mode_Key_Service $key_service
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie_service` | WP_Recovery_Mode_Cookie_Service | Cookie service |
| `$key_service` | WP_Recovery_Mode_Key_Service | Key service |

---

### generate_url()

Generates a URL to begin recovery mode.

```php
public function generate_url(): string
```

**Returns:** Full recovery mode URL.

**URL Format:**
```
https://example.com/wp-login.php?action=enter_recovery_mode&rm_token=...&rm_key=...
```

**Behavior:**
1. Generates token via `WP_Recovery_Mode_Key_Service::generate_recovery_mode_token()`
2. Generates and stores key via `generate_and_store_recovery_mode_key()`
3. Builds URL with token and key parameters

**Note:** Only one recovery URL may be valid at a time. Generating a new URL doesn't invalidate old ones until they expire or are used.

---

### handle_begin_link()

Handles recovery mode link when user visits wp-login.php.

```php
public function handle_begin_link( int $ttl ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ttl` | int | Link validity in seconds |

**URL Parameters Expected:**
- `action` — Must be `enter_recovery_mode`
- `rm_token` — Recovery mode token
- `rm_key` — Recovery mode key

**Behavior:**
1. Checks if on wp-login.php with correct action
2. Validates key via `WP_Recovery_Mode_Key_Service::validate_recovery_mode_key()`
3. On success, sets recovery cookie
4. Redirects to `wp-login.php?action=entered_recovery_mode`
5. On failure, calls `wp_die()` with error

**Exit:** Always exits after redirect or on error.

---

### get_recovery_mode_begin_url() <small>(private)</small>

Builds the recovery mode URL with token and key.

```php
private function get_recovery_mode_begin_url( string $token, string $key ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Recovery mode token |
| `$key` | string | Recovery mode key |

**Returns:** Complete recovery mode URL.

**Filter:** `recovery_mode_begin_url`

---

## URL Flow

```
1. Error occurs
   └── Email sent with: wp-login.php?action=enter_recovery_mode&rm_token=X&rm_key=Y

2. User clicks link
   └── handle_begin_link() validates token/key
       └── Sets cookie
       └── Redirects to: wp-login.php?action=entered_recovery_mode

3. Subsequent requests
   └── Cookie validates session
   └── Recovery mode active
```
