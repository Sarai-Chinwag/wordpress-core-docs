# User Hooks

Actions and filters for user management, authentication, roles, and capabilities.

**Source:** `wp-includes/user.php`, `wp-includes/capabilities.php`, `wp-includes/class-wp-*.php`

---

## Authentication

### Actions

#### wp_authenticate

Fires before user is authenticated.

```php
do_action_ref_array( 'wp_authenticate', array( &$user_login, &$user_password ) );
```

Variables are passed by reference and can be modified.

---

#### wp_login

Fires after successful login.

```php
do_action( 'wp_login', string $user_login, WP_User $user );
```

---

#### wp_logout

Fires after user logs out.

```php
do_action( 'wp_logout', int $user_id );
```

---

#### wp_set_password

Fires when password is set.

```php
do_action( 'wp_set_password', string $password, int $user_id, WP_User $user );
```

**Since 6.8.0:** Added `$user` parameter.

---

### Filters

#### authenticate

Filters authentication result.

```php
$user = apply_filters( 'authenticate', WP_User|WP_Error|null $user, string $username, string $password );
```

Default callbacks at priority 20:
- `wp_authenticate_username_password`
- `wp_authenticate_email_password`

At priority 30:
- `wp_authenticate_cookie`

**Example:**
```php
add_filter( 'authenticate', function( $user, $username, $password ) {
    // Add two-factor check
    if ( $user instanceof WP_User && get_user_meta( $user->ID, '2fa_enabled', true ) ) {
        // Verify 2FA token
        if ( ! verify_2fa_token( $_POST['2fa_token'], $user->ID ) ) {
            return new WP_Error( '2fa_failed', 'Invalid 2FA token.' );
        }
    }
    return $user;
}, 30, 3 );
```

---

#### wp_authenticate_user

Filters user before password check.

```php
$user = apply_filters( 'wp_authenticate_user', WP_User|WP_Error $user, string $password );
```

**Example:**
```php
add_filter( 'wp_authenticate_user', function( $user, $password ) {
    if ( $user instanceof WP_User && get_user_meta( $user->ID, 'account_locked', true ) ) {
        return new WP_Error( 'account_locked', 'Your account is locked.' );
    }
    return $user;
}, 10, 2 );
```

---

#### secure_signon_cookie

Filters whether to use secure cookie.

```php
$secure = apply_filters( 'secure_signon_cookie', bool $secure_cookie, array $credentials );
```

---

#### allow_password_reset

Filters whether password reset is allowed.

```php
$allow = apply_filters( 'allow_password_reset', bool $allow, int $user_id );
```

---

#### password_reset_expiration

Filters password reset key expiration.

```php
$seconds = apply_filters( 'password_reset_expiration', int $expiration );
```

Default: `DAY_IN_SECONDS` (86400).

---

## User Creation & Updates

### Actions

#### user_register

Fires after new user is registered.

```php
do_action( 'user_register', int $user_id, array $userdata );
```

---

#### profile_update

Fires after user is updated.

```php
do_action( 'profile_update', int $user_id, WP_User $old_user_data, array $userdata );
```

---

#### delete_user

Fires before user is deleted.

```php
do_action( 'delete_user', int $user_id, int|null $reassign, WP_User $user );
```

---

#### deleted_user

Fires after user is deleted.

```php
do_action( 'deleted_user', int $user_id, int|null $reassign, WP_User $user );
```

---

#### register_post

Fires during registration form submission.

```php
do_action( 'register_post', string $sanitized_login, string $user_email, WP_Error $errors );
```

---

#### register_new_user

Fires after user registration is recorded.

```php
do_action( 'register_new_user', int $user_id );
```

---

### Filters

#### wp_pre_insert_user_data

Filters user data before database insert/update.

```php
$data = apply_filters( 'wp_pre_insert_user_data', array $data, bool $update, int|null $user_id, array $userdata );
```

---

#### insert_user_meta

Filters user meta before insert.

```php
$meta = apply_filters( 'insert_user_meta', array $meta, WP_User $user, bool $update, array $userdata );
```

---

#### insert_custom_user_meta

Filters custom user meta from `meta_input`.

```php
$custom_meta = apply_filters( 'insert_custom_user_meta', array $custom_meta, WP_User $user, bool $update, array $userdata );
```

---

#### pre_user_login

Filters username before creation.

```php
$login = apply_filters( 'pre_user_login', string $sanitized_login );
```

---

#### pre_user_nicename

Filters nicename before creation.

```php
$nicename = apply_filters( 'pre_user_nicename', string $nicename );
```

---

#### pre_user_email

Filters email before creation.

```php
$email = apply_filters( 'pre_user_email', string $email );
```

---

#### pre_user_url

Filters URL before creation.

```php
$url = apply_filters( 'pre_user_url', string $url );
```

---

#### pre_user_nickname, pre_user_first_name, pre_user_last_name, pre_user_description, pre_user_display_name

Filter respective fields.

```php
$value = apply_filters( 'pre_user_{field}', string $value );
```

---

#### illegal_user_logins

Filters disallowed usernames.

```php
$logins = apply_filters( 'illegal_user_logins', array $usernames );
```

---

#### registration_errors

Filters registration errors.

```php
$errors = apply_filters( 'registration_errors', WP_Error $errors, string $login, string $email );
```

---

#### username_exists

Filters username exists check.

```php
$user_id = apply_filters( 'username_exists', int|false $user_id, string $username );
```

---

#### email_exists

Filters email exists check.

```php
$user_id = apply_filters( 'email_exists', int|false $user_id, string $email );
```

---

## Roles & Capabilities

### Actions

#### set_user_role

Fires after user's role changes.

```php
do_action( 'set_user_role', int $user_id, string $role, string[] $old_roles );
```

---

#### add_user_role

Fires when role is added to user.

```php
do_action( 'add_user_role', int $user_id, string $role );
```

---

#### remove_user_role

Fires when role is removed from user.

```php
do_action( 'remove_user_role', int $user_id, string $role );
```

---

#### wp_roles_init

Fires after roles are initialized.

```php
do_action( 'wp_roles_init', WP_Roles $wp_roles );
```

---

#### grant_super_admin

Fires before granting super admin.

```php
do_action( 'grant_super_admin', int $user_id );
```

---

#### granted_super_admin

Fires after granting super admin.

```php
do_action( 'granted_super_admin', int $user_id );
```

---

#### revoke_super_admin

Fires before revoking super admin.

```php
do_action( 'revoke_super_admin', int $user_id );
```

---

#### revoked_super_admin

Fires after revoking super admin.

```php
do_action( 'revoked_super_admin', int $user_id );
```

---

### Filters

#### user_has_cap

Dynamically filters user capabilities.

```php
$allcaps = apply_filters( 'user_has_cap', bool[] $allcaps, string[] $caps, array $args, WP_User $user );
```

| Parameter | Description |
|-----------|-------------|
| `$allcaps` | All user capabilities |
| `$caps` | Required primitive capabilities |
| `$args` | [capability, user_id, ...object_ids] |
| `$user` | User object |

**Example:**
```php
add_filter( 'user_has_cap', function( $allcaps, $caps, $args, $user ) {
    // Give shop managers full access to orders
    if ( in_array( 'shop_manager', $user->roles ) ) {
        foreach ( $caps as $cap ) {
            if ( strpos( $cap, 'shop_order' ) !== false ) {
                $allcaps[ $cap ] = true;
            }
        }
    }
    return $allcaps;
}, 10, 4 );
```

---

#### map_meta_cap

Filters mapped capabilities.

```php
$caps = apply_filters( 'map_meta_cap', string[] $caps, string $cap, int $user_id, array $args );
```

**Example:**
```php
add_filter( 'map_meta_cap', function( $caps, $cap, $user_id, $args ) {
    // Custom capability mapping
    if ( $cap === 'edit_custom_post' && isset( $args[0] ) ) {
        $post = get_post( $args[0] );
        if ( $post && $post->post_author == $user_id ) {
            return array( 'edit_custom_posts' );
        }
        return array( 'edit_others_custom_posts' );
    }
    return $caps;
}, 10, 4 );
```

---

#### role_has_cap

Filters role's capabilities.

```php
$caps = apply_filters( 'role_has_cap', bool[] $capabilities, string $cap, string $name );
```

---

## User Queries

### Actions

#### pre_get_users

Fires before WP_User_Query is parsed.

```php
do_action_ref_array( 'pre_get_users', array( &$query ) );
```

---

#### pre_user_query

Fires after parsing, before execution.

```php
do_action_ref_array( 'pre_user_query', array( &$query ) );
```

---

### Filters

#### users_pre_query

Short-circuits user query.

```php
$results = apply_filters_ref_array( 'users_pre_query', array( null, &$query ) );
```

Return non-null to bypass default query.

---

#### user_search_columns

Filters search columns.

```php
$columns = apply_filters( 'user_search_columns', string[] $columns, string $search, WP_User_Query $query );
```

---

#### found_users_query

Filters FOUND_ROWS() query.

```php
$sql = apply_filters( 'found_users_query', string $sql, WP_User_Query $query );
```

---

#### wp_dropdown_users_args

Filters dropdown query args.

```php
$args = apply_filters( 'wp_dropdown_users_args', array $query_args, array $parsed_args );
```

---

#### wp_dropdown_users

Filters dropdown HTML output.

```php
$html = apply_filters( 'wp_dropdown_users', string $output );
```

---

#### wp_list_users_args

Filters list users query args.

```php
$args = apply_filters( 'wp_list_users_args', array $query_args, array $parsed_args );
```

---

## User Options & Meta

### Filters

#### get_user_option_{$option}

Filters specific user option.

```php
$result = apply_filters( "get_user_option_{$option}", mixed $result, string $option, WP_User $user );
```

---

#### pre_count_users

Short-circuits count_users().

```php
$result = apply_filters( 'pre_count_users', null|array $result, string $strategy, int $site_id );
```

---

#### get_usernumposts

Filters user post count.

```php
$count = apply_filters( 'get_usernumposts', string $count, int $userid, string|array $post_type, bool $public_only );
```

---

## Cache & Data

### Actions

#### clean_user_cache

Fires after user cache is cleaned.

```php
do_action( 'clean_user_cache', int $user_id, WP_User $user );
```

---

### Filters

#### pre_get_blogs_of_user

Short-circuits get_blogs_of_user().

```php
$sites = apply_filters( 'pre_get_blogs_of_user', null|object[] $sites, int $user_id, bool $all );
```

---

#### get_blogs_of_user

Filters user's sites.

```php
$sites = apply_filters( 'get_blogs_of_user', object[] $sites, int $user_id, bool $all );
```

---

## User Display

### Filters

#### user_contactmethods

Filters contact methods.

```php
$methods = apply_filters( 'user_contactmethods', string[] $methods, WP_User|null $user );
```

**Example:**
```php
add_filter( 'user_contactmethods', function( $methods ) {
    $methods['twitter']  = __( 'Twitter' );
    $methods['linkedin'] = __( 'LinkedIn' );
    unset( $methods['yim'] ); // Remove Yahoo IM
    return $methods;
} );
```

---

#### password_hint

Filters password strength hint.

```php
$hint = apply_filters( 'password_hint', string $hint );
```

---

#### user_{$field}

Filters user field on display.

```php
$value = apply_filters( "user_{$field}", mixed $value, int $user_id, string $context );
```

---

#### edit_user_{$field}

Filters user field in edit context.

```php
$value = apply_filters( "edit_user_{$field}", mixed $value, int $user_id );
```

---

#### pre_user_{$field}

Filters user field in db context.

```php
$value = apply_filters( "pre_user_{$field}", mixed $value );
```

---

## Email Notifications

### Filters

#### send_password_change_email

Filters whether to send password change email.

```php
$send = apply_filters( 'send_password_change_email', bool $send, array $user, array $userdata );
```

---

#### send_email_change_email

Filters whether to send email change email.

```php
$send = apply_filters( 'send_email_change_email', bool $send, array $user, array $userdata );
```

---

#### password_change_email

Filters password change email content.

```php
$email = apply_filters( 'password_change_email', array $email, array $user, array $userdata );
```

---

#### email_change_email

Filters email change email content.

```php
$email = apply_filters( 'email_change_email', array $email, array $user, array $userdata );
```

---

#### retrieve_password_title

Filters password reset email subject.

```php
$title = apply_filters( 'retrieve_password_title', string $title, string $user_login, WP_User $user );
```

---

#### retrieve_password_message

Filters password reset email body.

```php
$message = apply_filters( 'retrieve_password_message', string $message, string $key, string $user_login, WP_User $user );
```

---

#### send_retrieve_password_email

Filters whether to send password retrieval email.

```php
$send = apply_filters( 'send_retrieve_password_email', bool $send, string $user_login, WP_User $user );
```

---

## Application Passwords

### Filters

#### wp_is_application_passwords_available

Filters app passwords availability.

```php
$available = apply_filters( 'wp_is_application_passwords_available', bool $available );
```

---

#### wp_is_application_passwords_available_for_user

Filters app passwords availability for user.

```php
$available = apply_filters( 'wp_is_application_passwords_available_for_user', bool $available, WP_User $user );
```

---

#### application_password_is_api_request

Filters whether request is API request.

```php
$is_api = apply_filters( 'application_password_is_api_request', bool $is_api_request );
```

---

### Actions

#### application_password_did_authenticate

Fires after app password authentication.

```php
do_action( 'application_password_did_authenticate', WP_User $user, array $item );
```

---

#### application_password_failed_authentication

Fires when app password fails.

```php
do_action( 'application_password_failed_authentication', WP_Error $error );
```

---

## Password Reset

### Actions

#### retrieve_password

Fires before password is retrieved.

```php
do_action( 'retrieve_password', string $user_login );
```

---

#### retrieve_password_key

Fires when reset key is generated.

```php
do_action( 'retrieve_password_key', string $user_login, string $key );
```

---

#### password_reset

Fires before password reset.

```php
do_action( 'password_reset', WP_User $user, string $new_pass );
```

---

#### after_password_reset

Fires after password reset.

```php
do_action( 'after_password_reset', WP_User $user, string $new_pass );
```

---

### Filters

#### lostpassword_user_data

Filters user data during password reset.

```php
$user_data = apply_filters( 'lostpassword_user_data', WP_User|false $user_data, WP_Error $errors );
```

---

#### lostpassword_errors

Filters password reset errors.

```php
$errors = apply_filters( 'lostpassword_errors', WP_Error $errors, WP_User|false $user_data );
```
