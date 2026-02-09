# WP_Session_Tokens

Abstract class for managing user session tokens.

**Source:** `wp-includes/class-wp-session-tokens.php`  
**Since:** 4.0.0

## Overview

WordPress uses session tokens to track authenticated user sessions. Each login creates a token stored in a cookie and linked to session metadata (expiration, IP, user agent).

The default implementation `WP_User_Meta_Session_Tokens` stores tokens in user meta. Plugins can provide alternative storage (Redis, database table) via the `session_token_manager` filter.

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$user_id` | int | protected | User ID for this session manager |

---

## Methods

### get_instance()

Retrieves a session manager instance for a user.

```php
final public static function get_instance( int $user_id ): WP_Session_Tokens
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user_id` | int | User whose sessions to manage |

**Returns:** Session manager instance (default: `WP_User_Meta_Session_Tokens`).

**Example:**

```php
$manager = WP_Session_Tokens::get_instance( get_current_user_id() );
```

---

### create()

Generates a session token and stores session information.

```php
final public function create( int $expiration ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$expiration` | int | Session expiration timestamp |

**Returns:** 43-character random session token.

**Session Data Stored:**
- `expiration` — Expiration timestamp
- `ip` — Client IP address (from `$_SERVER['REMOTE_ADDR']`)
- `ua` — User agent string
- `login` — Login timestamp

**Example:**

```php
$manager = WP_Session_Tokens::get_instance( $user_id );
$expiration = time() + DAY_IN_SECONDS;
$token = $manager->create( $expiration );
```

---

### get()

Retrieves session data for a token.

```php
final public function get( string $token ): array|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Session token |

**Returns:** Session array or `null` if not found.

**Example:**

```php
$session = $manager->get( $token );
if ( $session ) {
    echo 'Logged in from: ' . $session['ip'];
    echo 'Expires: ' . date( 'Y-m-d', $session['expiration'] );
}
```

---

### verify()

Validates a session token.

```php
final public function verify( string $token ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Token to verify |

**Returns:** `true` if valid and not expired, `false` otherwise.

**Example:**

```php
if ( $manager->verify( $token ) ) {
    // Token is valid
}
```

---

### update()

Updates session data for an existing token.

```php
final public function update( string $token, array $session )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Session token |
| `$session` | array | New session data |

**Example:**

```php
$session = $manager->get( $token );
$session['last_activity'] = time();
$manager->update( $token, $session );
```

---

### destroy()

Destroys a single session.

```php
final public function destroy( string $token )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token` | string | Session token to destroy |

**Example:**

```php
// Logout current session
$manager->destroy( wp_get_session_token() );
```

---

### destroy_others()

Destroys all sessions except the current one.

```php
final public function destroy_others( string $token_to_keep )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$token_to_keep` | string | Session to preserve |

**Example:**

```php
// "Log out everywhere else"
$manager->destroy_others( wp_get_session_token() );
```

---

### destroy_all()

Destroys all sessions for the user.

```php
final public function destroy_all()
```

**Example:**

```php
// Force logout from all devices
$manager->destroy_all();
```

---

### destroy_all_for_all_users()

Destroys all sessions for all users (global logout).

```php
final public static function destroy_all_for_all_users()
```

**Example:**

```php
// Emergency: log out everyone
WP_Session_Tokens::destroy_all_for_all_users();
```

---

### get_all()

Retrieves all sessions for the user.

```php
final public function get_all(): array
```

**Returns:** Array of session data arrays.

**Example:**

```php
$sessions = $manager->get_all();
foreach ( $sessions as $session ) {
    echo $session['ip'] . ' - ' . $session['ua'];
}
```

---

### is_still_valid() <small>(protected)</small>

Checks if a session has expired.

```php
final protected function is_still_valid( array $session ): bool
```

---

## Abstract Methods

Subclasses must implement:

| Method | Description |
|--------|-------------|
| `get_sessions()` | Retrieve all sessions for user |
| `get_session( $verifier )` | Get session by verifier hash |
| `update_session( $verifier, $session )` | Update/delete session |
| `destroy_other_sessions( $verifier )` | Destroy all except one |
| `destroy_all_sessions()` | Destroy all sessions |

---

## Token Hashing

Tokens are hashed with SHA-256 before storage. The raw token is stored in the cookie; the hash (verifier) is stored server-side.

```
Token (in cookie) → hash_token() → Verifier (in storage)
```

---

## Custom Implementation

```php
class Redis_Session_Tokens extends WP_Session_Tokens {
    
    protected function get_sessions() {
        return $this->redis->hGetAll( "sessions:{$this->user_id}" );
    }
    
    protected function get_session( $verifier ) {
        $data = $this->redis->hGet( "sessions:{$this->user_id}", $verifier );
        return $data ? json_decode( $data, true ) : null;
    }
    
    protected function update_session( $verifier, $session = null ) {
        if ( null === $session ) {
            $this->redis->hDel( "sessions:{$this->user_id}", $verifier );
        } else {
            $this->redis->hSet( 
                "sessions:{$this->user_id}", 
                $verifier, 
                json_encode( $session ) 
            );
        }
    }
    
    protected function destroy_other_sessions( $verifier ) {
        $sessions = $this->get_sessions();
        foreach ( array_keys( $sessions ) as $v ) {
            if ( $v !== $verifier ) {
                $this->redis->hDel( "sessions:{$this->user_id}", $v );
            }
        }
    }
    
    protected function destroy_all_sessions() {
        $this->redis->del( "sessions:{$this->user_id}" );
    }
    
    public static function drop_sessions() {
        // Delete all session keys (for destroy_all_for_all_users)
    }
}

// Register custom manager
add_filter( 'session_token_manager', function() {
    return 'Redis_Session_Tokens';
} );
```
