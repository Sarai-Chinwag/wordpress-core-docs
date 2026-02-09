# Recovery Mode Hooks

Actions and filters for the error protection and recovery mode system.

**Source:** Various recovery mode files

---

## Actions

### generate_recovery_mode_key

Fires when a recovery mode key is generated.

```php
do_action( 'generate_recovery_mode_key', string $token, string $key )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | The recovery data token |
| `$key` | string | The recovery mode key (plain text) |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode-key-service.php`

---

### wp_logout

Recovery mode hooks into this action to exit when user logs out.

```php
do_action( 'wp_logout' )
```

**Behavior:** Calls `WP_Recovery_Mode::exit_recovery_mode()`

**Since:** 5.2.0 (recovery mode integration)

---

### login_form_exit_recovery_mode

Custom login action for exiting recovery mode.

```php
do_action( 'login_form_exit_recovery_mode' )
```

**Behavior:** Handles recovery mode exit request with nonce verification.

**URL:** `wp-login.php?action=exit_recovery_mode&_wpnonce=...`

**Since:** 5.2.0

---

### recovery_mode_clean_expired_keys

Scheduled action to clean expired recovery mode keys.

```php
do_action( 'recovery_mode_clean_expired_keys' )
```

**Schedule:** Daily (via `wp_schedule_event`)

**Since:** 5.2.0

---

## Filters

### recovery_mode_email_rate_limit

Filters the rate limit between recovery mode emails.

```php
apply_filters( 'recovery_mode_email_rate_limit', int $rate_limit )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$rate_limit` | int | `DAY_IN_SECONDS` | Time to wait in seconds |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode.php`

**Example:**
```php
// Allow recovery emails every 6 hours
add_filter( 'recovery_mode_email_rate_limit', function() {
    return 6 * HOUR_IN_SECONDS;
} );
```

---

### recovery_mode_email_link_ttl

Filters how long the recovery mode link is valid.

```php
apply_filters( 'recovery_mode_email_link_ttl', int $valid_for )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$valid_for` | int | Rate limit value | Validity in seconds |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode.php`

**Note:** TTL is forced to be at least as long as the email rate limit.

**Example:**
```php
// Links valid for 3 days
add_filter( 'recovery_mode_email_link_ttl', function() {
    return 3 * DAY_IN_SECONDS;
} );
```

---

### recovery_mode_cookie_length

Filters how long the recovery mode cookie is valid.

```php
apply_filters( 'recovery_mode_cookie_length', int $length )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$length` | int | `WEEK_IN_SECONDS` | Cookie validity in seconds |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode-cookie-service.php`

**Example:**
```php
// Cookie valid for 2 days only
add_filter( 'recovery_mode_cookie_length', function() {
    return 2 * DAY_IN_SECONDS;
} );
```

---

### recovery_mode_email

Filters the contents of the recovery mode email.

```php
apply_filters( 'recovery_mode_email', array $email, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$email` | array | Email components |
| `$url` | string | Recovery mode URL |

**Email Array:**
| Key | Type | Description |
|-----|------|-------------|
| `to` | string\|array | Recipient(s) |
| `subject` | string | Email subject |
| `message` | string | Message body |
| `headers` | string\|array | Additional headers |
| `attachments` | string\|array | File attachments |

**Since:** 5.2.0, 5.6.0 (attachments key added)  
**Source:** `class-wp-recovery-mode-email-service.php`

**Example:**
```php
add_filter( 'recovery_mode_email', function( $email, $url ) {
    // Add CC to development team
    $email['headers'] = 'Cc: dev-team@example.com';
    return $email;
}, 10, 2 );
```

---

### recovery_email_support_info

Filters the support message in the recovery email.

```php
apply_filters( 'recovery_email_support_info', string $message )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$message` | string | Host contact suggestion | Support contact message |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode-email-service.php`

**Example:**
```php
add_filter( 'recovery_email_support_info', function() {
    return 'Contact our support team at help@example.com for assistance.';
} );
```

---

### recovery_email_debug_info

Filters the debug information in the recovery email.

```php
apply_filters( 'recovery_email_debug_info', array $debug )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$debug` | array | Debug info key-value pairs |

**Default Keys:**
- `wp` — WordPress version
- `theme` — Active theme name and version
- `plugin` — Failing plugin (if applicable)
- `php` — PHP version

**Since:** 5.3.0  
**Source:** `class-wp-recovery-mode-email-service.php`

**Example:**
```php
add_filter( 'recovery_email_debug_info', function( $debug ) {
    $debug['memory'] = 'Memory limit: ' . ini_get( 'memory_limit' );
    $debug['server'] = 'Server: ' . $_SERVER['SERVER_SOFTWARE'];
    return $debug;
} );
```

---

### recovery_mode_begin_url

Filters the URL to begin recovery mode.

```php
apply_filters( 'recovery_mode_begin_url', string $url, string $token, string $key )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | Generated recovery URL |
| `$token` | string | Recovery mode token |
| `$key` | string | Recovery mode key |

**Since:** 5.2.0  
**Source:** `class-wp-recovery-mode-link-service.php`

---

### wp_fatal_error_handler_enabled

Filters whether the fatal error handler is enabled.

```php
apply_filters( 'wp_fatal_error_handler_enabled', bool $enabled )
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$enabled` | bool | `true` | Whether handler is enabled |

**Since:** 5.2.0  
**Source:** `error-protection.php`

**Important:** This filter runs before plugins load. Must be configured in wp-config.php:

```php
// wp-config.php - Disable recovery mode
$GLOBALS['wp_filter'] = array(
    'wp_fatal_error_handler_enabled' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() {
                    return false;
                },
            ),
        ),
    ),
);
```

---

## Hooks Summary

| Hook | Type | Purpose |
|------|------|---------|
| `generate_recovery_mode_key` | Action | Key generation notification |
| `recovery_mode_clean_expired_keys` | Action | Scheduled key cleanup |
| `recovery_mode_email_rate_limit` | Filter | Email frequency control |
| `recovery_mode_email_link_ttl` | Filter | Link validity duration |
| `recovery_mode_cookie_length` | Filter | Cookie validity duration |
| `recovery_mode_email` | Filter | Email customization |
| `recovery_email_support_info` | Filter | Support message customization |
| `recovery_email_debug_info` | Filter | Debug info customization |
| `recovery_mode_begin_url` | Filter | URL customization |
| `wp_fatal_error_handler_enabled` | Filter | Enable/disable recovery mode |
