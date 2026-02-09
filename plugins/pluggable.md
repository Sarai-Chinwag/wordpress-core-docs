# WordPress Pluggable Functions

Pluggable functions are core WordPress functions that can be completely overridden by plugins. They are defined conditionally in `wp-includes/pluggable.php` using `if ( ! function_exists() )` wrappers.

## How to Override

Define the function before WordPress loads `pluggable.php` (typically in an mu-plugin or early-loading plugin):

```php
// In wp-content/mu-plugins/custom-mail.php
function wp_mail( $to, $subject, $message, $headers = '', $attachments = array(), $embeds = array() ) {
    // Custom email implementation
}
```

**Important:** Your implementation must maintain the same function signature and expected behavior.

---

## User & Authentication Functions

### `wp_set_current_user( $id, $name )`
Changes the current user by ID or name.

```php
function wp_set_current_user( $id, $name = '' ) {
    global $current_user;
    
    $current_user = new WP_User( $id, $name );
    setup_userdata( $current_user->ID );
    
    do_action( 'set_current_user' );
    
    return $current_user;
}
```

**Parameters:**
- `$id` (int|null) - User ID
- `$name` (string) - Optional. Username

**Returns:** (WP_User) - Current user object

**Action:** `set_current_user`

---

### `wp_get_current_user()`
Retrieves the current user object.

```php
function wp_get_current_user() {
    return _wp_get_current_user();
}
```

**Returns:** (WP_User) - Current user (ID 0 if not logged in)

---

### `get_userdata( $user_id )`
Retrieves user data by ID.

```php
function get_userdata( $user_id ) {
    return get_user_by( 'id', $user_id );
}
```

**Returns:** (WP_User|false) - User object or false

---

### `get_user_by( $field, $value )`
Retrieves user by field.

```php
function get_user_by( $field, $value ) {
    $userdata = WP_User::get_data_by( $field, $value );
    
    if ( ! $userdata ) {
        return false;
    }
    
    $user = new WP_User();
    $user->init( $userdata );
    
    return $user;
}
```

**Parameters:**
- `$field` (string) - 'id', 'ID', 'slug', 'email', or 'login'
- `$value` (int|string) - Value to match

**Returns:** (WP_User|false)

---

### `cache_users( $user_ids )`
Primes the cache for multiple users.

```php
function cache_users( $user_ids ) {
    global $wpdb;
    
    update_meta_cache( 'user', $user_ids );
    
    $clean = _get_non_cached_ids( $user_ids, 'users' );
    if ( empty( $clean ) ) {
        return;
    }
    
    $list = implode( ',', $clean );
    $users = $wpdb->get_results( "SELECT * FROM $wpdb->users WHERE ID IN ($list)" );
    
    foreach ( $users as $user ) {
        update_user_caches( $user );
    }
}
```

**Parameters:**
- `$user_ids` (int[]) - Array of user IDs

---

### `wp_authenticate( $username, $password )`
Authenticates a user with credentials.

```php
function wp_authenticate( $username, $password ) {
    $username = sanitize_user( $username );
    $password = trim( $password );
    
    $user = apply_filters( 'authenticate', null, $username, $password );
    
    if ( null === $user || false === $user ) {
        $user = new WP_Error( 'authentication_failed', 
            __( '<strong>Error:</strong> Invalid username, email address or incorrect password.' ) 
        );
    }
    
    if ( is_wp_error( $user ) ) {
        do_action( 'wp_login_failed', $username, $user );
    }
    
    return $user;
}
```

**Parameters:**
- `$username` (string) - Username or email
- `$password` (string) - Password

**Returns:** (WP_User|WP_Error)

**Filter:** `authenticate` - Custom authentication logic
**Action:** `wp_login_failed`

---

### `wp_logout()`
Logs the current user out.

```php
function wp_logout() {
    $user_id = get_current_user_id();
    
    wp_destroy_current_session();
    wp_clear_auth_cookie();
    wp_set_current_user( 0 );
    
    do_action( 'wp_logout', $user_id );
}
```

**Action:** `wp_logout`

---

### `is_user_logged_in()`
Checks if current visitor is logged in.

```php
function is_user_logged_in() {
    $user = wp_get_current_user();
    return $user->exists();
}
```

**Returns:** (bool)

---

### `auth_redirect()`
Redirects non-logged-in users to login page.

```php
function auth_redirect() {
    $secure = ( is_ssl() || force_ssl_admin() );
    $secure = apply_filters( 'secure_auth_redirect', $secure );
    
    $scheme = apply_filters( 'auth_redirect_scheme', '' );
    $user_id = wp_validate_auth_cookie( '', $scheme );
    
    if ( $user_id ) {
        do_action( 'auth_redirect', $user_id );
        return;
    }
    
    // Force login
    nocache_headers();
    $login_url = wp_login_url( $redirect, true );
    wp_redirect( $login_url );
    exit;
}
```

**Actions:** `auth_redirect`
**Filters:** `secure_auth_redirect`, `auth_redirect_scheme`

---

## Cookie & Session Functions

### `wp_validate_auth_cookie( $cookie, $scheme )`
Validates authentication cookie.

**Parameters:**
- `$cookie` (string) - Optional. Cookie to validate
- `$scheme` (string) - Optional. 'auth', 'secure_auth', or 'logged_in'

**Returns:** (int|false) - User ID if valid, false otherwise

**Actions:** `auth_cookie_malformed`, `auth_cookie_expired`, `auth_cookie_bad_username`, `auth_cookie_bad_hash`, `auth_cookie_bad_session_token`, `auth_cookie_valid`

---

### `wp_generate_auth_cookie( $user_id, $expiration, $scheme, $token )`
Generates authentication cookie contents.

**Parameters:**
- `$user_id` (int) - User ID
- `$expiration` (int) - Expiration timestamp
- `$scheme` (string) - 'auth', 'secure_auth', or 'logged_in'
- `$token` (string) - Session token

**Returns:** (string) - Cookie value

**Filter:** `auth_cookie`

---

### `wp_parse_auth_cookie( $cookie, $scheme )`
Parses a cookie into components.

**Returns:** (array|false) - `username`, `expiration`, `token`, `hmac`, `scheme`

---

### `wp_set_auth_cookie( $user_id, $remember, $secure, $token )`
Sets authentication cookies for a user.

**Parameters:**
- `$user_id` (int) - User ID
- `$remember` (bool) - Persistent cookie (14 days vs session)
- `$secure` (bool|string) - HTTPS only. Default: auto-detect
- `$token` (string) - Session token

**Actions:** `set_auth_cookie`, `set_logged_in_cookie`
**Filters:** `auth_cookie_expiration`, `secure_auth_cookie`, `secure_logged_in_cookie`, `send_auth_cookies`

---

### `wp_clear_auth_cookie()`
Clears all authentication cookies.

**Action:** `clear_auth_cookie`

---

## Email Functions

### `wp_mail( $to, $subject, $message, $headers, $attachments, $embeds )`
Sends email using PHPMailer.

```php
function wp_mail( $to, $subject, $message, $headers = '', $attachments = array(), $embeds = array() ) {
    // Filter all arguments
    $atts = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments', 'embeds' ) );
    
    // Allow short-circuit
    $pre_wp_mail = apply_filters( 'pre_wp_mail', null, $atts );
    if ( null !== $pre_wp_mail ) {
        return $pre_wp_mail;
    }
    
    // ... PHPMailer setup and sending ...
    
    do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
    
    try {
        $send = $phpmailer->send();
        do_action( 'wp_mail_succeeded', $mail_data );
        return $send;
    } catch ( Exception $e ) {
        do_action( 'wp_mail_failed', new WP_Error( 'wp_mail_failed', $e->getMessage(), $mail_data ) );
        return false;
    }
}
```

**Parameters:**
- `$to` (string|string[]) - Recipient(s)
- `$subject` (string) - Subject line
- `$message` (string) - Message body
- `$headers` (string|string[]) - Additional headers
- `$attachments` (string|string[]) - File paths to attach
- `$embeds` (string|string[]) - File paths to embed (6.9+)

**Returns:** (bool) - Success/failure

**Filters:**
- `wp_mail` - All arguments
- `pre_wp_mail` - Short-circuit
- `wp_mail_from` - From email
- `wp_mail_from_name` - From name
- `wp_mail_content_type` - Content type
- `wp_mail_charset` - Character set
- `wp_mail_embed_args` - Embed configuration

**Actions:**
- `phpmailer_init` - Customize PHPMailer
- `wp_mail_succeeded` - After successful send
- `wp_mail_failed` - After failed send

---

### `wp_notify_postauthor( $comment_id )`
Notifies post author of new comment.

**Filters:** `comment_notification_recipients`, `comment_notification_notify_author`, `comment_notification_headers`, `comment_notification_text`, `comment_notification_subject`

---

### `wp_notify_moderator( $comment_id )`
Notifies moderators of comment awaiting approval.

**Filters:** `notify_moderator`, `comment_moderation_recipients`, `comment_moderation_headers`, `comment_moderation_text`, `comment_moderation_subject`

---

### `wp_password_change_notification( $user )`
Notifies admin of user password change.

**Filter:** `wp_password_change_notification_email`

---

### `wp_new_user_notification( $user_id, $deprecated, $notify )`
Emails registration notification.

**Parameters:**
- `$user_id` (int) - New user ID
- `$deprecated` (null) - Not used
- `$notify` (string) - 'admin', 'user', 'both', or ''

**Filters:**
- `wp_send_new_user_notification_to_admin`
- `wp_send_new_user_notification_to_user`
- `wp_new_user_notification_email_admin`
- `wp_new_user_notification_email`

---

## Nonce & Security Functions

### `wp_nonce_tick( $action )`
Returns the time-dependent variable for nonce creation.

**Filter:** `nonce_life` - Nonce lifespan (default: DAY_IN_SECONDS)

---

### `wp_verify_nonce( $nonce, $action )`
Verifies a nonce value.

**Parameters:**
- `$nonce` (string) - Nonce to verify
- `$action` (string|int) - Action name

**Returns:** (int|false) - 1 (0-12h old), 2 (12-24h old), or false

**Filter:** `nonce_user_logged_out`
**Action:** `wp_verify_nonce_failed`

---

### `wp_create_nonce( $action )`
Creates a cryptographic nonce token.

**Returns:** (string) - 10-character nonce

---

### `check_admin_referer( $action, $query_arg )`
Verifies admin request with nonce.

**Parameters:**
- `$action` (int|string) - Nonce action
- `$query_arg` (string) - Query arg to check. Default '_wpnonce'

**Returns:** (int|false)

**Action:** `check_admin_referer`

---

### `check_ajax_referer( $action, $query_arg, $stop )`
Verifies Ajax request with nonce.

**Parameters:**
- `$action` (int|string) - Nonce action
- `$query_arg` (string|false) - Query arg or false for auto-detect
- `$stop` (bool) - Die on failure. Default true

**Action:** `check_ajax_referer`

---

## Password Functions

### `wp_hash_password( $password )`
Creates a hash of a plain text password.

```php
function wp_hash_password( $password ) {
    global $wp_hasher;
    
    if ( ! empty( $wp_hasher ) ) {
        return $wp_hasher->HashPassword( trim( $password ) );
    }
    
    if ( strlen( $password ) > 4096 ) {
        return '*';
    }
    
    $algorithm = apply_filters( 'wp_hash_password_algorithm', PASSWORD_BCRYPT );
    $options = apply_filters( 'wp_hash_password_options', array(), $algorithm );
    
    // bcrypt with SHA-384 pre-hash
    $password_to_hash = base64_encode( hash_hmac( 'sha384', trim( $password ), 'wp-sha384', true ) );
    
    return '$wp' . password_hash( $password_to_hash, $algorithm, $options );
}
```

**Filters:** `wp_hash_password_algorithm`, `wp_hash_password_options`

**Note:** Since 6.8.0, uses bcrypt by default (was phpass).

---

### `wp_check_password( $password, $hash, $user_id )`
Checks a password against a hash.

**Parameters:**
- `$password` (string) - Plain text password
- `$hash` (string) - Hashed password
- `$user_id` (string|int) - Optional. User ID

**Returns:** (bool)

**Filter:** `check_password`

**Supports:** md5, phpass (`$P$`), bcrypt (`$2y$`), WordPress bcrypt (`$wp`)

---

### `wp_password_needs_rehash( $hash, $user_id )`
Checks if password hash needs rehashing.

**Filter:** `password_needs_rehash`

---

### `wp_set_password( $password, $user_id )`
Updates a user's password.

**Action:** `wp_set_password`

---

### `wp_generate_password( $length, $special_chars, $extra_special_chars )`
Generates a random password.

**Parameters:**
- `$length` (int) - Length. Default 12
- `$special_chars` (bool) - Include `!@#$%^&*()`. Default true
- `$extra_special_chars` (bool) - Include `-_ []{}<>~` etc. Default false

**Filter:** `random_password`

---

### `wp_rand( $min, $max )`
Generates a secure random number.

Uses `random_int()` when available.

---

## Hash & Salt Functions

### `wp_salt( $scheme )`
Returns a salt for hashing.

**Parameters:**
- `$scheme` (string) - 'auth', 'secure_auth', 'logged_in', 'nonce'

**Filter:** `salt`

---

### `wp_hash( $data, $scheme, $algo )`
Hashes data using HMAC.

**Parameters:**
- `$data` (string) - Data to hash
- `$scheme` (string) - Salt scheme
- `$algo` (string) - Algorithm. Default 'md5' (6.8+: supports any `hash_hmac_algos()`)

---

## Redirect Functions

### `wp_redirect( $location, $status, $x_redirect_by )`
Redirects to another URL.

```php
function wp_redirect( $location, $status = 302, $x_redirect_by = 'WordPress' ) {
    $location = apply_filters( 'wp_redirect', $location, $status );
    $status = apply_filters( 'wp_redirect_status', $status, $location );
    
    if ( ! $location ) {
        return false;
    }
    
    $location = wp_sanitize_redirect( $location );
    
    $x_redirect_by = apply_filters( 'x_redirect_by', $x_redirect_by, $status, $location );
    if ( is_string( $x_redirect_by ) ) {
        header( "X-Redirect-By: $x_redirect_by" );
    }
    
    header( "Location: $location", true, $status );
    return true;
}
```

**Important:** Does not exit. Always follow with `exit;`

**Filters:** `wp_redirect`, `wp_redirect_status`, `x_redirect_by`

---

### `wp_safe_redirect( $location, $status, $x_redirect_by )`
Safe redirect that validates the host.

**Filter:** `wp_safe_redirect_fallback` - Fallback URL

---

### `wp_sanitize_redirect( $location )`
Sanitizes a URL for redirect use.

---

### `wp_validate_redirect( $location, $fallback_url )`
Validates redirect URL against allowed hosts.

**Filter:** `allowed_redirect_hosts`

---

## Miscellaneous Functions

### `get_avatar( $id_or_email, $size, $default, $alt, $args )`
Retrieves avatar `<img>` tag.

**Parameters:**
- `$id_or_email` (mixed) - User ID, email, WP_User, WP_Post, or WP_Comment
- `$size` (int) - Size in pixels. Default 96
- `$default` (string) - Default type ('mystery', 'blank', 'gravatar_default', etc.)
- `$alt` (string) - Alt text
- `$args` (array) - Additional arguments

**Filters:** `pre_get_avatar`, `get_avatar`

---

### `wp_text_diff( $left_string, $right_string, $args )`
Returns HTML diff between two strings.

**Parameters:**
- `$left_string` (string) - "Old" version
- `$right_string` (string) - "New" version
- `$args` (array) - title, title_left, title_right, show_split_view

---

## Deprecated Pluggable Functions

Located in `wp-includes/pluggable-deprecated.php`:

| Function | Deprecated | Replacement |
|----------|------------|-------------|
| `set_current_user()` | 3.0.0 | `wp_set_current_user()` |
| `get_currentuserinfo()` | 4.5.0 | `wp_get_current_user()` |
| `get_userdatabylogin()` | 3.3.0 | `get_user_by('login')` |
| `get_user_by_email()` | 3.3.0 | `get_user_by('email')` |
| `wp_setcookie()` | 2.5.0 | `wp_set_auth_cookie()` |
| `wp_clearcookie()` | 2.5.0 | `wp_clear_auth_cookie()` |
| `wp_get_cookie_login()` | 2.5.0 | N/A |
| `wp_login()` | 2.5.0 | `wp_signon()` |
