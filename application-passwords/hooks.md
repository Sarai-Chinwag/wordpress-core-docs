# Application Passwords Hooks

This document covers the action hooks available in the `WP_Application_Passwords` class for extending and monitoring application password functionality.

## Actions

### wp_create_application_password

Fires when a new application password is created.

```php
do_action( 
    'wp_create_application_password', 
    int $user_id, 
    array $new_item, 
    string $new_password, 
    array $args 
);
```

**Since:** 5.6.0  
**Updated:** 6.8.0 — Password now hashed with `wp_fast_hash()` instead of phpass

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$new_item` | array | The created password details |
| `$new_password` | string | The plain text password |
| `$args` | array | Original arguments passed to creation |

**$new_item array:**

| Key | Type | Description |
|-----|------|-------------|
| `uuid` | string | Unique identifier |
| `app_id` | string | Application-provided UUID (may be empty) |
| `name` | string | Human-readable name |
| `password` | string | One-way hash of the password |
| `created` | int | Unix timestamp |
| `last_used` | null | Always null on creation |
| `last_ip` | null | Always null on creation |

**Example — Send notification email:**

```php
add_action( 'wp_create_application_password', function( $user_id, $item, $password, $args ) {
    $user = get_userdata( $user_id );
    
    wp_mail(
        $user->user_email,
        'New Application Password Created',
        sprintf(
            'A new application password "%s" was created for your account on %s.',
            $item['name'],
            get_bloginfo( 'name' )
        )
    );
}, 10, 4 );
```

**Example — Log creation event:**

```php
add_action( 'wp_create_application_password', function( $user_id, $item, $password, $args ) {
    error_log( sprintf(
        'Application password created: user=%d, name=%s, uuid=%s',
        $user_id,
        $item['name'],
        $item['uuid']
    ) );
}, 10, 4 );
```

**Example — Sync to external system:**

```php
add_action( 'wp_create_application_password', function( $user_id, $item, $password, $args ) {
    // Store app_id mapping for external service
    if ( ! empty( $item['app_id'] ) ) {
        update_user_meta( 
            $user_id, 
            '_external_app_' . $item['app_id'], 
            $item['uuid'] 
        );
    }
}, 10, 4 );
```

---

### wp_update_application_password

Fires when an application password is updated.

```php
do_action( 
    'wp_update_application_password', 
    int $user_id, 
    array $item, 
    array $update 
);
```

**Since:** 5.6.0  
**Updated:** 6.8.0 — Password may be hashed with either `wp_fast_hash()` (new) or phpass (existing)

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$item` | array | The updated password details |
| `$update` | array | The fields that were requested to change |

**$item array:**

| Key | Type | Description |
|-----|------|-------------|
| `uuid` | string | Unique identifier |
| `app_id` | string | Application-provided UUID |
| `name` | string | Human-readable name (may be updated) |
| `password` | string | One-way hash (unchanged) |
| `created` | int | Unix timestamp (unchanged) |
| `last_used` | int\|null | Last use timestamp |
| `last_ip` | string\|null | Last use IP address |

**Example — Audit logging:**

```php
add_action( 'wp_update_application_password', function( $user_id, $item, $update ) {
    if ( isset( $update['name'] ) ) {
        error_log( sprintf(
            'Application password renamed: user=%d, uuid=%s, new_name=%s',
            $user_id,
            $item['uuid'],
            $item['name']
        ) );
    }
}, 10, 3 );
```

**Note:** Currently only the `name` field can be updated. This action fires even if the new name matches the old name (no actual change).

---

### wp_delete_application_password

Fires when an application password is deleted.

```php
do_action( 
    'wp_delete_application_password', 
    int $user_id, 
    array $item 
);
```

**Since:** 5.6.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$user_id` | int | The user ID |
| `$item` | array | The deleted password details |

**$item array:**

| Key | Type | Description |
|-----|------|-------------|
| `uuid` | string | Unique identifier |
| `app_id` | string | Application-provided UUID |
| `name` | string | Human-readable name |
| `password` | string | One-way hash |
| `created` | int | Unix timestamp |
| `last_used` | int\|null | Last use timestamp |
| `last_ip` | string\|null | Last use IP address |

**Example — Security notification:**

```php
add_action( 'wp_delete_application_password', function( $user_id, $item ) {
    $user = get_userdata( $user_id );
    
    wp_mail(
        $user->user_email,
        'Application Password Revoked',
        sprintf(
            'The application password "%s" has been revoked from your account.',
            $item['name']
        )
    );
}, 10, 2 );
```

**Example — Clean up external references:**

```php
add_action( 'wp_delete_application_password', function( $user_id, $item ) {
    // Remove any external mappings
    if ( ! empty( $item['app_id'] ) ) {
        delete_user_meta( $user_id, '_external_app_' . $item['app_id'] );
    }
}, 10, 2 );
```

**Example — Track deletion for security audit:**

```php
add_action( 'wp_delete_application_password', function( $user_id, $item ) {
    // Log with usage statistics
    error_log( sprintf(
        'Application password deleted: user=%d, name=%s, created=%s, last_used=%s, last_ip=%s',
        $user_id,
        $item['name'],
        date( 'Y-m-d H:i:s', $item['created'] ),
        $item['last_used'] ? date( 'Y-m-d H:i:s', $item['last_used'] ) : 'never',
        $item['last_ip'] ?? 'unknown'
    ) );
}, 10, 2 );
```

**Note:** When `delete_all_application_passwords()` is called, this action fires once for each password deleted.

---

## Common Patterns

### Limit Application Passwords Per User

```php
add_action( 'wp_create_application_password', function( $user_id ) {
    $passwords = WP_Application_Passwords::get_user_application_passwords( $user_id );
    $max_allowed = 10;
    
    if ( count( $passwords ) > $max_allowed ) {
        // Delete oldest passwords beyond limit
        usort( $passwords, function( $a, $b ) {
            return $a['created'] - $b['created'];
        } );
        
        while ( count( $passwords ) > $max_allowed ) {
            $oldest = array_shift( $passwords );
            WP_Application_Passwords::delete_application_password( $user_id, $oldest['uuid'] );
        }
    }
}, 20, 1 );
```

### Require Approval for New Passwords

```php
// Store pending passwords
add_action( 'wp_create_application_password', function( $user_id, $item ) {
    // Mark as pending
    update_user_meta( 
        $user_id, 
        '_pending_app_password_' . $item['uuid'], 
        true 
    );
    
    // Notify admin
    wp_mail(
        get_option( 'admin_email' ),
        'Application Password Needs Approval',
        sprintf(
            'User %d created application password "%s". Review and approve.',
            $user_id,
            $item['name']
        )
    );
}, 10, 2 );
```

### Sync Deletions Across Multisite

```php
add_action( 'wp_delete_application_password', function( $user_id, $item ) {
    if ( is_multisite() ) {
        // Log to main site for centralized audit
        switch_to_blog( get_main_site_id() );
        
        // Your logging logic here
        
        restore_current_blog();
    }
}, 10, 2 );
```

---

## Related Filters

While not part of `WP_Application_Passwords` class, these filters affect application password behavior:

### wp_is_application_passwords_available

Controls whether application passwords feature is available site-wide.

```php
add_filter( 'wp_is_application_passwords_available', '__return_false' );
```

### wp_is_application_passwords_available_for_user

Controls availability for a specific user.

```php
add_filter( 'wp_is_application_passwords_available_for_user', function( $available, $user ) {
    // Only allow for administrators
    return user_can( $user, 'manage_options' );
}, 10, 2 );
```

### application_password_is_api_request

Filters whether the current request is an API request that should allow application password authentication.

```php
add_filter( 'application_password_is_api_request', function( $is_api_request ) {
    // Custom logic to determine if this is an API request
    return $is_api_request;
} );
```
