# User Functions

Core functions for user management, authentication, metadata, and utilities.

**Source:** `wp-includes/user.php`, `wp-includes/capabilities.php`, `wp-includes/pluggable.php`

---

## User Retrieval

### get_user()

Retrieves user by ID.

```php
get_user( int $user_id ): WP_User|false
```

**Since:** 6.7.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user_id` | int | User ID |

**Returns:** `WP_User` on success, `false` on failure.

---

### get_userdata()

Retrieves user by ID. Alias for `get_user_by('id', $id)`.

```php
get_userdata( int $user_id ): WP_User|false
```

**Since:** 0.71

---

### get_user_by()

Retrieves user by field.

```php
get_user_by( string $field, int|string $value ): WP_User|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | `'id'`, `'ID'`, `'slug'`, `'email'`, `'login'` |
| `$value` | int\|string | Field value |

**Example:**
```php
$user = get_user_by( 'email', 'john@example.com' );
$user = get_user_by( 'login', 'johndoe' );
```

---

### get_users()

Retrieves list of users matching criteria.

```php
get_users( array $args = array() ): array
```

**See:** `WP_User_Query::prepare_query()` for all arguments.

**Example:**
```php
$editors = get_users( array(
    'role'    => 'editor',
    'orderby' => 'display_name',
    'number'  => 20,
) );
```

---

### wp_get_current_user()

Retrieves current logged-in user.

```php
wp_get_current_user(): WP_User
```

**Returns:** `WP_User` with ID 0 if not logged in.

---

### get_current_user_id()

Gets current user's ID.

```php
get_current_user_id(): int
```

**Returns:** User ID, or 0 if not logged in.

---

## User Creation & Updates

### wp_insert_user()

Inserts or updates a user.

```php
wp_insert_user( array|object|WP_User $userdata ): int|WP_Error
```

**Since:** 2.0.0

| Userdata Key | Type | Description |
|--------------|------|-------------|
| `ID` | int | User ID (for updates) |
| `user_login` | string | Username (required for new users) |
| `user_pass` | string | Password (plaintext for new, hashed for existing) |
| `user_nicename` | string | URL-friendly name |
| `user_url` | string | User's website |
| `user_email` | string | Email address |
| `display_name` | string | Display name |
| `nickname` | string | Nickname |
| `first_name` | string | First name |
| `last_name` | string | Last name |
| `description` | string | Bio |
| `rich_editing` | string | `'true'` or `'false'` |
| `syntax_highlighting` | string | `'true'` or `'false'` |
| `comment_shortcuts` | string | `'true'` or `'false'` |
| `admin_color` | string | Admin color scheme |
| `use_ssl` | bool | Force SSL in admin |
| `user_registered` | string | Registration date (Y-m-d H:i:s) |
| `user_activation_key` | string | Password reset key |
| `spam` | bool | Marked as spam (multisite) |
| `show_admin_bar_front` | string | `'true'` or `'false'` |
| `role` | string | User role |
| `locale` | string | User locale |
| `meta_input` | array | Custom meta values |

**Returns:** User ID on success, `WP_Error` on failure.

**Example:**
```php
$user_id = wp_insert_user( array(
    'user_login' => 'newuser',
    'user_pass'  => wp_generate_password(),
    'user_email' => 'new@example.com',
    'role'       => 'author',
    'meta_input' => array(
        'phone' => '555-1234',
    ),
) );
```

---

### wp_update_user()

Updates existing user.

```php
wp_update_user( array|object|WP_User $userdata ): int|WP_Error
```

Merges with existing data. Sends password/email change notifications.

---

### wp_create_user()

Simple user creation with username, password, and email.

```php
wp_create_user( string $username, string $password, string $email = '' ): int|WP_Error
```

**Example:**
```php
$user_id = wp_create_user( 'johndoe', 'securepass123', 'john@example.com' );
```

---

### wp_delete_user()

Deletes a user.

```php
wp_delete_user( int $id, int $reassign = null ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | int | User ID to delete |
| `$reassign` | int | User ID to reassign content to |

---

## Authentication

### wp_signon()

Authenticates and logs in a user.

```php
wp_signon( array $credentials = array(), bool $secure_cookie = '' ): WP_User|WP_Error
```

| Credentials Key | Type | Description |
|-----------------|------|-------------|
| `user_login` | string | Username |
| `user_password` | string | Password |
| `remember` | bool | Remember login |

**Example:**
```php
$user = wp_signon( array(
    'user_login'    => $_POST['username'],
    'user_password' => $_POST['password'],
    'remember'      => true,
) );

if ( is_wp_error( $user ) ) {
    echo $user->get_error_message();
}
```

---

### wp_authenticate()

Authenticates a user (does not log in).

```php
wp_authenticate( string $username, string $password ): WP_User|WP_Error
```

Runs through `authenticate` filter chain.

---

### wp_authenticate_username_password()

Authenticates via username and password.

```php
wp_authenticate_username_password( 
    WP_User|WP_Error|null $user, 
    string $username, 
    string $password 
): WP_User|WP_Error
```

**Hooked to:** `authenticate` filter at priority 20.

---

### wp_authenticate_email_password()

Authenticates via email and password.

```php
wp_authenticate_email_password( 
    WP_User|WP_Error|null $user, 
    string $email, 
    string $password 
): WP_User|WP_Error
```

**Since:** 4.5.0  
**Hooked to:** `authenticate` filter at priority 20.

---

### wp_authenticate_application_password()

Authenticates via application password (REST API, XML-RPC).

```php
wp_authenticate_application_password( 
    WP_User|WP_Error|null $input_user, 
    string $username, 
    string $password 
): WP_User|WP_Error|null
```

**Since:** 5.6.0

---

### wp_logout()

Logs out current user and destroys session.

```php
wp_logout(): void
```

---

### is_user_logged_in()

Checks if current user is logged in.

```php
is_user_logged_in(): bool
```

---

### wp_set_current_user()

Sets current user by ID or name.

```php
wp_set_current_user( int $id, string $name = '' ): WP_User
```

---

## Password Functions

### wp_set_password()

Sets user password (hashes and stores).

```php
wp_set_password( string $password, int $user_id ): void
```

---

### wp_check_password()

Checks plaintext against hashed password.

```php
wp_check_password( string $password, string $hash, int $user_id = 0 ): bool
```

---

### wp_hash_password()

Hashes a password.

```php
wp_hash_password( string $password ): string
```

**Since 6.8.0:** Uses bcrypt by default instead of phpass.

---

### get_password_reset_key()

Creates and stores a password reset key.

```php
get_password_reset_key( WP_User $user ): string|WP_Error
```

---

### check_password_reset_key()

Validates a password reset key.

```php
check_password_reset_key( string $key, string $login ): WP_User|WP_Error
```

---

### reset_password()

Resets user password.

```php
reset_password( WP_User $user, string $new_pass ): void
```

---

### retrieve_password()

Sends password retrieval email.

```php
retrieve_password( string $user_login = '' ): true|WP_Error
```

---

## User Meta

### get_user_meta()

Retrieves user meta field.

```php
get_user_meta( int $user_id, string $key = '', bool $single = false ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user_id` | int | User ID |
| `$key` | string | Meta key (empty for all) |
| `$single` | bool | Return single value |

**Example:**
```php
$phone = get_user_meta( $user_id, 'phone', true );
$all_meta = get_user_meta( $user_id );
```

---

### add_user_meta()

Adds user meta.

```php
add_user_meta( int $user_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false
```

---

### update_user_meta()

Updates user meta.

```php
update_user_meta( int $user_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
```

---

### delete_user_meta()

Deletes user meta.

```php
delete_user_meta( int $user_id, string $meta_key, mixed $meta_value = '' ): bool
```

---

## User Options

### get_user_option()

Gets user option (site or network scoped).

```php
get_user_option( string $option, int $user = 0, string $deprecated = '' ): mixed
```

Checks for `{prefix}{option}` first, then `{option}`.

---

### update_user_option()

Updates user option.

```php
update_user_option( int $user_id, string $option_name, mixed $newvalue, bool $is_global = false ): int|bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$is_global` | bool | `false` = site-specific (prefixed), `true` = network-wide |

---

### delete_user_option()

Deletes user option.

```php
delete_user_option( int $user_id, string $option_name, bool $is_global = false ): bool
```

---

## Capabilities

### current_user_can()

Checks if current user has capability.

```php
current_user_can( string $capability, mixed ...$args ): bool
```

**Example:**
```php
if ( current_user_can( 'edit_posts' ) ) { }
if ( current_user_can( 'edit_post', $post_id ) ) { }
if ( current_user_can( 'edit_post_meta', $post_id, $meta_key ) ) { }
```

---

### current_user_can_for_site()

Checks capability for specific site.

```php
current_user_can_for_site( int $site_id, string $capability, mixed ...$args ): bool
```

**Since:** 6.7.0

---

### user_can()

Checks if specific user has capability.

```php
user_can( int|WP_User $user, string $capability, mixed ...$args ): bool
```

---

### user_can_for_site()

Checks user capability for specific site.

```php
user_can_for_site( int|WP_User $user, int $site_id, string $capability, mixed ...$args ): bool
```

**Since:** 6.7.0

---

### author_can()

Checks if post author has capability.

```php
author_can( int|WP_Post $post, string $capability, mixed ...$args ): bool
```

---

### map_meta_cap()

Maps meta capability to primitive capabilities.

```php
map_meta_cap( string $cap, int $user_id, mixed ...$args ): string[]
```

**Example:**
```php
// edit_post for post 123 might return:
// ['edit_others_posts', 'edit_published_posts']
$caps = map_meta_cap( 'edit_post', $user_id, 123 );
```

---

## Roles

### wp_roles()

Gets global WP_Roles instance.

```php
wp_roles(): WP_Roles
```

---

### get_role()

Gets role object by name.

```php
get_role( string $role ): WP_Role|null
```

---

### add_role()

Adds a new role.

```php
add_role( string $role, string $display_name, array $capabilities = array() ): WP_Role|void
```

**Example:**
```php
add_role( 'custom_editor', 'Custom Editor', array(
    'read'         => true,
    'edit_posts'   => true,
    'delete_posts' => false,
) );
```

---

### remove_role()

Removes a role.

```php
remove_role( string $role ): void
```

---

## Super Admin (Multisite)

### is_super_admin()

Checks if user is super admin.

```php
is_super_admin( int|false $user_id = false ): bool
```

---

### get_super_admins()

Gets list of super admin logins.

```php
get_super_admins(): string[]
```

---

### grant_super_admin()

Grants super admin privileges.

```php
grant_super_admin( int $user_id ): bool
```

---

### revoke_super_admin()

Revokes super admin privileges.

```php
revoke_super_admin( int $user_id ): bool
```

---

## Validation & Checking

### username_exists()

Checks if username exists.

```php
username_exists( string $username ): int|false
```

**Returns:** User ID if exists, `false` otherwise.

---

### email_exists()

Checks if email exists.

```php
email_exists( string $email ): int|false
```

**Returns:** User ID if exists, `false` otherwise.

---

### validate_username()

Validates username format.

```php
validate_username( string $username ): bool
```

---

## Session Management

### wp_get_session_token()

Gets current session token from cookie.

```php
wp_get_session_token(): string
```

---

### wp_get_all_sessions()

Gets all sessions for current user.

```php
wp_get_all_sessions(): array
```

---

### wp_destroy_current_session()

Destroys current session.

```php
wp_destroy_current_session(): void
```

---

### wp_destroy_other_sessions()

Destroys all sessions except current.

```php
wp_destroy_other_sessions(): void
```

---

### wp_destroy_all_sessions()

Destroys all sessions for current user.

```php
wp_destroy_all_sessions(): void
```

---

## Counting

### count_users()

Counts users by role.

```php
count_users( string $strategy = 'time', int|null $site_id = null ): array
```

**Returns:**
```php
array(
    'total_users' => 150,
    'avail_roles' => array(
        'administrator' => 2,
        'editor'        => 10,
        'author'        => 25,
        'subscriber'    => 113,
        'none'          => 0,
    ),
)
```

---

### count_user_posts()

Counts posts by user.

```php
count_user_posts( int $userid, array|string $post_type = 'post', bool $public_only = false ): string
```

---

### count_many_users_posts()

Counts posts for multiple users.

```php
count_many_users_posts( int[] $users, string|string[] $post_type = 'post', bool $public_only = false ): array
```

---

### get_user_count()

Gets total active users count.

```php
get_user_count( int|null $network_id = null ): int
```

---

## Multisite

### get_blogs_of_user()

Gets sites a user belongs to.

```php
get_blogs_of_user( int $user_id, bool $all = false ): object[]
```

---

### is_user_member_of_blog()

Checks if user is member of site.

```php
is_user_member_of_blog( int $user_id = 0, int $blog_id = 0 ): bool
```

---

### wp_get_users_with_no_role()

Gets users with no role on site.

```php
wp_get_users_with_no_role( int|null $site_id = null ): string[]
```

---

## Display Functions

### wp_dropdown_users()

Creates user dropdown HTML.

```php
wp_dropdown_users( array|string $args = '' ): string
```

| Arg | Type | Default | Description |
|-----|------|---------|-------------|
| `show_option_all` | string | `''` | Text for "all" option |
| `show_option_none` | string | `''` | Text for "none" option |
| `orderby` | string | `'display_name'` | Field to order by |
| `order` | string | `'ASC'` | Sort order |
| `include` | array\|string | `''` | User IDs to include |
| `exclude` | array\|string | `''` | User IDs to exclude |
| `show` | string | `'display_name'` | Field to display |
| `echo` | bool | `true` | Echo or return |
| `selected` | int | `0` | Selected user ID |
| `name` | string | `'user'` | Select name attribute |
| `class` | string | `''` | Select class attribute |
| `role` | string\|array | `''` | Filter by role |

---

### wp_list_users()

Lists users as HTML.

```php
wp_list_users( string|array $args = array() ): string|null
```

**Since:** 5.9.0

---

## Application Passwords

### wp_is_application_passwords_available()

Checks if app passwords are available.

```php
wp_is_application_passwords_available(): bool
```

---

### wp_is_application_passwords_available_for_user()

Checks if app passwords are available for user.

```php
wp_is_application_passwords_available_for_user( int|WP_User $user ): bool
```

---

## Cache Functions

### update_user_caches()

Updates all user caches.

```php
update_user_caches( object|WP_User $user ): void|false
```

---

### clean_user_cache()

Clears all user caches.

```php
clean_user_cache( WP_User|int $user ): void
```

---

### wp_cache_set_users_last_changed()

Sets last changed time for users cache.

```php
wp_cache_set_users_last_changed(): void
```

---

## Utility Functions

### sanitize_user_field()

Sanitizes user field by context.

```php
sanitize_user_field( string $field, mixed $value, int $user_id, string $context ): mixed
```

| Context | Description |
|---------|-------------|
| `'raw'` | No sanitization |
| `'edit'` | For editing (esc_attr) |
| `'db'` | For database |
| `'display'` | For display (default) |
| `'attribute'` | For HTML attributes |
| `'js'` | For JavaScript |

---

### wp_get_user_contact_methods()

Gets registered contact methods.

```php
wp_get_user_contact_methods( WP_User|null $user = null ): string[]
```

---

### wp_get_password_hint()

Gets password strength hint text.

```php
wp_get_password_hint(): string
```

---

### register_new_user()

Registers new user and sends notification.

```php
register_new_user( string $user_login, string $user_email ): int|WP_Error
```

---

### wp_send_new_user_notifications()

Sends new user notification emails.

```php
wp_send_new_user_notifications( int $user_id, string $notify = 'both' ): void
```

| Notify | Description |
|--------|-------------|
| `'admin'` | Admin only |
| `'user'` | User only |
| `'both'` | Admin and user |
