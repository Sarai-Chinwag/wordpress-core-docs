# WP_Recovery_Mode_Cookie_Service

Service class for setting, validating, and clearing recovery mode cookies.

**Source:** `wp-includes/class-wp-recovery-mode-cookie-service.php`  
**Since:** 5.2.0

## Cookie Format

The cookie is base64 encoded with four pipe-delimited parts:

```
recovery_mode|created_at|random|signature
```

| Part | Description |
|------|-------------|
| `recovery_mode` | Constant string identifier |
| `created_at` | Unix timestamp when cookie was created |
| `random` | 20-character random password (used as session ID seed) |
| `signature` | HMAC-SHA1 of the first three parts |

---

## Methods

### is_cookie_set()

Checks whether the recovery mode cookie is set.

```php
public function is_cookie_set(): bool
```

**Returns:** `true` if cookie exists, `false` otherwise.

---

### set_cookie()

Sets the recovery mode cookie. Must immediately exit the request after calling.

```php
public function set_cookie(): void
```

**Behavior:**
1. Generates cookie value with signature
2. Sets cookie with configurable expiration
3. Sets on both `COOKIEPATH` and `SITECOOKIEPATH` if different

**Cookie Attributes:**
- **Name:** `RECOVERY_MODE_COOKIE` constant
- **Expiration:** Configurable via filter (default: 1 week)
- **Secure:** Based on `is_ssl()`
- **HttpOnly:** `true`

**Filter:** `recovery_mode_cookie_length`

---

### clear_cookie()

Clears the recovery mode cookie.

```php
public function clear_cookie(): void
```

Sets cookie with past expiration on both paths.

---

### validate_cookie()

Validates the recovery mode cookie.

```php
public function validate_cookie( string $cookie = '' ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie` | string | Cookie value (optional, reads from `$_COOKIE` if empty) |

**Returns:** `true` if valid, `WP_Error` on failure.

**Error Codes:**
- `no_cookie` — No cookie present
- `invalid_format` — Cookie format invalid (not 4 parts)
- `invalid_created_at` — Timestamp not numeric
- `expired` — Cookie has expired
- `signature_mismatch` — HMAC signature invalid

**Validation Steps:**
1. Parse base64-decoded cookie into parts
2. Verify `created_at` is numeric
3. Check cookie hasn't expired
4. Verify HMAC signature matches

---

### get_session_id_from_cookie()

Extracts the session identifier from the cookie.

```php
public function get_session_id_from_cookie( string $cookie = '' ): string|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cookie` | string | Cookie value (optional, reads from `$_COOKIE` if empty) |

**Returns:** SHA1 hash of the random component, or `WP_Error`.

**Note:** Cookie should be validated before calling this method.

---

### parse_cookie() <small>(private)</small>

Parses the cookie into its four parts.

```php
private function parse_cookie( string $cookie ): array|WP_Error
```

**Returns:** Array of 4 parts, or `WP_Error` if invalid format.

---

### generate_cookie() <small>(private)</small>

Generates a new recovery mode cookie value.

```php
private function generate_cookie(): string
```

**Returns:** Base64-encoded cookie string.

---

### recovery_mode_hash() <small>(private)</small>

Creates an HMAC hash for recovery mode. Uses `AUTH_KEY`/`AUTH_SALT` if valid, otherwise generates and stores custom salts.

```php
private function recovery_mode_hash( string $data ): string|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | string | Data to hash |

**Returns:** HMAC-SHA1 hash.

**Fallback Keys:**
If `AUTH_KEY` or `AUTH_SALT` are default placeholder values, generates and stores:
- `recovery_mode_auth_key` (site option)
- `recovery_mode_auth_salt` (site option)
