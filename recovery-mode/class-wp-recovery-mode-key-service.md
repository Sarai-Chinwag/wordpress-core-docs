# WP_Recovery_Mode_Key_Service

Service class for generating, storing, and validating recovery mode keys.

**Source:** `wp-includes/class-wp-recovery-mode-key-service.php`  
**Since:** 5.2.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$option_name` | string | private | Option name for key storage (`'recovery_keys'`) |

## Key Storage Format

Keys are stored in the `recovery_keys` option as an associative array:

```php
array(
    'token_string' => array(
        'hashed_key' => 'wp_fast_hash_result',
        'created_at' => 1234567890,
    ),
    // ...
)
```

**Note:** Since 6.8.0, keys are hashed using `wp_fast_hash()` instead of phpass. Existing keys may still use the older format.

---

## Methods

### generate_recovery_mode_token()

Creates a recovery mode token.

```php
public function generate_recovery_mode_token(): string
```

**Returns:** 22-character random alphanumeric string.

**Purpose:** The token identifies a specific recovery key in storage and is included in the recovery URL.

---

### generate_and_store_recovery_mode_key()

Creates and stores a recovery mode key.

```php
public function generate_and_store_recovery_mode_key( string $token ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Token from `generate_recovery_mode_token()` |

**Returns:** 22-character plain-text key (included in recovery URL).

**Behavior:**
1. Generates random key
2. Hashes key with `wp_fast_hash()`
3. Stores hash with creation timestamp
4. Fires `generate_recovery_mode_key` action

**Action:** `generate_recovery_mode_key`

---

### validate_recovery_mode_key()

Verifies a recovery mode key. Keys are single-use and consumed on validation.

```php
public function validate_recovery_mode_key( string $token, string $key, int $ttl ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Token identifying the key |
| `$key` | string | Plain-text key to validate |
| `$ttl` | int | Maximum age in seconds |

**Returns:** `true` if valid, `WP_Error` on failure.

**Error Codes:**
- `token_not_found` — Token doesn't exist in storage
- `invalid_recovery_key_format` — Stored record is malformed
- `hash_mismatch` — Key doesn't match stored hash
- `key_expired` — Key is older than TTL

**Behavior:**
1. Retrieves record by token
2. **Removes key from storage** (single-use)
3. Validates record format
4. Verifies key hash with `wp_verify_fast_hash()`
5. Checks expiration against TTL

---

### clean_expired_keys()

Removes expired keys from storage.

```php
public function clean_expired_keys( int $ttl ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ttl` | int | Maximum age in seconds |

**Behavior:** Removes any key where `time() > created_at + ttl` or where `created_at` is missing.

---

### remove_key() <small>(private)</small>

Removes a specific key from storage.

```php
private function remove_key( string $token ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Token to remove |

---

### get_keys() <small>(private)</small>

Retrieves all stored recovery keys.

```php
private function get_keys(): array
```

**Returns:** Associative array of token => record pairs.

---

### update_keys() <small>(private)</small>

Updates the stored recovery keys.

```php
private function update_keys( array $keys ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$keys` | array | Keys array to store |

**Returns:** `true` on success, `false` on failure.

**Note:** Option autoload is disabled (`false`).
