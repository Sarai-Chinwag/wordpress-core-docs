# WP_Application_Passwords Class Reference

`WP_Application_Passwords` is a static utility class for managing application passwords. All methods are static — no instantiation required.

**Since:** WordPress 5.6.0  
**File:** `wp-includes/class-wp-application-passwords.php`

## Class Constants

### USERMETA_KEY_APPLICATION_PASSWORDS

```php
const USERMETA_KEY_APPLICATION_PASSWORDS = '_application_passwords';
```

The user meta key where application passwords are stored.

### OPTION_KEY_IN_USE

```php
const OPTION_KEY_IN_USE = 'using_application_passwords';
```

Network option key that tracks whether any application passwords exist.

### PW_LENGTH

```php
const PW_LENGTH = 24;
```

The length of generated application passwords (24 characters).

---

## Static Methods

### is_in_use()

Checks if application passwords are being used by the site.

```php
public static function is_in_use(): bool
```

**Returns:** `bool` — True if at least one application password has ever been created.

**Example:**

```php
if ( WP_Application_Passwords::is_in_use() ) {
    // Show application password management UI
}
```

**Note:** This checks a network-level option, not individual user meta.

---

### create_new_application_password()

Creates a new application password for a user.

```php
public static function create_new_application_password( 
    int $user_id, 
    array $args = array() 
): array|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$args` | array | Arguments for creating the password |

**$args array:**

| Key | Type | Description |
|-----|------|-------------|
| `name` | string | **Required.** Human-readable name for the password |
| `app_id` | string | Optional UUID provided by the application |

**Returns:** `array|WP_Error`

On success, returns an array with two elements:
- `[0]` — The plain text password (24 characters)
- `[1]` — Array with password details (uuid, app_id, name, hashed password, created, last_used, last_ip)

On failure, returns `WP_Error` with one of:
- `application_password_empty_name` — No name provided
- `db_error` — Failed to save

**Example:**

```php
$result = WP_Application_Passwords::create_new_application_password(
    get_current_user_id(),
    array(
        'name'   => 'My Mobile App',
        'app_id' => wp_generate_uuid4(),
    )
);

if ( is_wp_error( $result ) ) {
    wp_die( $result->get_error_message() );
}

list( $password, $item ) = $result;

// Display password to user (only time it's visible!)
printf( 'Your new password: %s', esc_html( $password ) );
printf( 'Password UUID: %s', esc_html( $item['uuid'] ) );
```

**Fires:** `wp_create_application_password` action

**Version History:**
- 5.6.0: Introduced
- 5.7.0: Returns WP_Error if application name already exists
- 6.8.0: Uses `wp_fast_hash()` instead of phpass

---

### get_user_application_passwords()

Gets all application passwords for a user.

```php
public static function get_user_application_passwords( int $user_id ): array
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |

**Returns:** `array` — Array of password records, each containing:

| Key | Type | Description |
|-----|------|-------------|
| `uuid` | string | Unique identifier |
| `app_id` | string | Application-provided UUID |
| `name` | string | Human-readable name |
| `password` | string | One-way hash |
| `created` | int | Unix timestamp |
| `last_used` | int\|null | Last use timestamp |
| `last_ip` | string\|null | Last use IP address |

**Example:**

```php
$passwords = WP_Application_Passwords::get_user_application_passwords( $user_id );

foreach ( $passwords as $password ) {
    printf(
        '%s (created: %s, last used: %s)',
        esc_html( $password['name'] ),
        date( 'Y-m-d', $password['created'] ),
        $password['last_used'] ? date( 'Y-m-d', $password['last_used'] ) : 'Never'
    );
}
```

**Note:** This method auto-generates UUIDs for any legacy passwords missing them.

---

### get_user_application_password()

Gets a specific application password by UUID.

```php
public static function get_user_application_password( 
    int $user_id, 
    string $uuid 
): array|null
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$uuid` | string | The password's UUID |

**Returns:** `array|null` — The password record or null if not found.

**Example:**

```php
$password = WP_Application_Passwords::get_user_application_password( $user_id, $uuid );

if ( $password ) {
    echo 'Password name: ' . esc_html( $password['name'] );
} else {
    echo 'Password not found';
}
```

---

### application_name_exists_for_user()

Checks if an application password with the given name already exists.

```php
public static function application_name_exists_for_user( 
    int $user_id, 
    string $name 
): bool
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$name` | string | Application name to check |

**Returns:** `bool` — True if a password with this name exists (case-insensitive).

**Since:** 5.7.0

**Example:**

```php
if ( WP_Application_Passwords::application_name_exists_for_user( $user_id, 'My App' ) ) {
    // Suggest a different name or update existing
}
```

---

### update_application_password()

Updates an existing application password.

```php
public static function update_application_password( 
    int $user_id, 
    string $uuid, 
    array $update = array() 
): true|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$uuid` | string | The password's UUID |
| `$update` | array | Fields to update |

**$update array:**

| Key | Type | Description |
|-----|------|-------------|
| `name` | string | New name for the password |

**Returns:** `true|WP_Error` — True on success, WP_Error on failure.

**Error Codes:**
- `db_error` — Failed to save changes
- `application_password_not_found` — UUID doesn't match any password

**Example:**

```php
$result = WP_Application_Passwords::update_application_password(
    $user_id,
    $uuid,
    array( 'name' => 'Renamed App' )
);

if ( is_wp_error( $result ) ) {
    echo 'Error: ' . $result->get_error_message();
}
```

**Fires:** `wp_update_application_password` action

**Note:** Currently only the `name` field can be updated. The actual password cannot be changed — delete and recreate instead.

---

### record_application_password_usage()

Records that an application password was used for authentication.

```php
public static function record_application_password_usage( 
    int $user_id, 
    string $uuid 
): true|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$uuid` | string | The password's UUID |

**Returns:** `true|WP_Error` — True on success, WP_Error if password not found or save fails.

**Example:**

```php
// Called internally by WordPress during authentication
WP_Application_Passwords::record_application_password_usage( $user_id, $uuid );
```

**Note:** Usage is only recorded once per day to reduce database writes. The method updates `last_used` (timestamp) and `last_ip` (from `$_SERVER['REMOTE_ADDR']`).

---

### delete_application_password()

Deletes a specific application password.

```php
public static function delete_application_password( 
    int $user_id, 
    string $uuid 
): true|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$uuid` | string | The password's UUID |

**Returns:** `true|WP_Error` — True on success, WP_Error on failure.

**Error Codes:**
- `db_error` — Failed to save changes
- `application_password_not_found` — UUID doesn't match any password

**Example:**

```php
$result = WP_Application_Passwords::delete_application_password( $user_id, $uuid );

if ( is_wp_error( $result ) ) {
    echo 'Failed to delete: ' . $result->get_error_message();
} else {
    echo 'Password revoked successfully';
}
```

**Fires:** `wp_delete_application_password` action

---

### delete_all_application_passwords()

Deletes all application passwords for a user.

```php
public static function delete_all_application_passwords( int $user_id ): int|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |

**Returns:** `int|WP_Error` — Number of passwords deleted, or WP_Error on failure.

**Example:**

```php
$count = WP_Application_Passwords::delete_all_application_passwords( $user_id );

if ( is_wp_error( $count ) ) {
    echo 'Error: ' . $count->get_error_message();
} else {
    printf( 'Deleted %d application passwords', $count );
}
```

**Fires:** `wp_delete_application_password` action for each deleted password

---

### chunk_password()

Formats a password into readable 4-character chunks.

```php
public static function chunk_password( string $raw_password ): string
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$raw_password` | string | The raw password |

**Returns:** `string` — Password formatted as "xxxx xxxx xxxx xxxx xxxx xxxx"

**Example:**

```php
$formatted = WP_Application_Passwords::chunk_password( 'abcd1234efgh5678ijkl9012' );
// Returns: "abcd 1234 efgh 5678 ijkl 9012"
```

**Note:** This method strips any non-alphanumeric characters before chunking. The `#[\SensitiveParameter]` attribute prevents the password from appearing in stack traces.

---

### hash_password()

Hashes a plaintext application password.

```php
public static function hash_password( string $password ): string
```

**Since:** 6.8.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$password` | string | Plaintext password |

**Returns:** `string` — Hashed password using `wp_fast_hash()`

**Example:**

```php
$hash = WP_Application_Passwords::hash_password( 'mypassword123' );
// Hash starts with '$generic$'
```

---

### check_password()

Verifies a plaintext password against a stored hash.

```php
public static function check_password( string $password, string $hash ): bool
```

**Since:** 6.8.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$password` | string | Plaintext password to verify |
| `$hash` | string | Stored hash |

**Returns:** `bool` — True if password matches.

**Example:**

```php
if ( WP_Application_Passwords::check_password( $submitted_password, $stored_hash ) ) {
    // Password is valid
}
```

**Note:** This method handles both new hashes (starting with `$generic$`, using `wp_verify_fast_hash()`) and legacy phpass hashes (using `wp_check_password()`).

---

## Protected Methods

### set_user_application_passwords()

Saves application passwords to user meta.

```php
protected static function set_user_application_passwords( 
    int $user_id, 
    array $passwords 
): int|bool
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$passwords` | array | Array of password records |

**Returns:** `int|bool` — Meta ID if first password, true on update, false on failure.

**Note:** This is a protected method — use the public CRUD methods instead.
