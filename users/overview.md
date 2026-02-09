# WordPress Users API

Core system for managing users, authentication, roles, and capabilities.

**Since:** 2.0.0  
**Source:** `wp-includes/user.php`, `wp-includes/capabilities.php`, `wp-includes/class-wp-*.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | User CRUD, authentication, meta, and utility functions |
| [class-wp-user.md](./class-wp-user.md) | Individual user instance with capabilities |
| [class-wp-user-query.md](./class-wp-user-query.md) | User query builder and executor |
| [class-wp-roles.md](./class-wp-roles.md) | Role registry and manager |
| [class-wp-role.md](./class-wp-role.md) | Individual role with capabilities |
| [hooks.md](./hooks.md) | Actions and filters |

## Architecture

### Database Tables

| Table | Purpose |
|-------|---------|
| `wp_users` | Core user data (login, email, pass, registered, etc.) |
| `wp_usermeta` | User metadata including capabilities, preferences |

### User Data Flow

```
wp_insert_user() / wp_create_user()
    ├── Validate & sanitize input
    ├── Apply pre_user_* filters
    ├── Insert into wp_users
    ├── Insert metadata (nickname, first_name, etc.)
    ├── Set role (wp_capabilities meta)
    └── Fire user_register action

get_userdata() / get_user_by()
    ├── Check cache
    ├── Query wp_users
    ├── Create WP_User object
    ├── Load capabilities from meta
    └── Return WP_User instance
```

## Roles & Capabilities Model

### Hierarchy

```
Super Admin (Multisite)
    └── Administrator
            └── Editor
                    └── Author
                            └── Contributor
                                    └── Subscriber
```

### Default Roles

| Role | Key Capabilities |
|------|------------------|
| `administrator` | Full site access, manage_options, install_plugins, edit_users |
| `editor` | Publish/edit all posts, manage_categories, moderate_comments |
| `author` | Publish/edit own posts, upload_files |
| `contributor` | Write/edit own posts (no publishing) |
| `subscriber` | Read only, manage own profile |

### Capability Types

1. **Primitive Capabilities** - Stored directly in role (e.g., `edit_posts`, `manage_options`)
2. **Meta Capabilities** - Mapped to primitives via `map_meta_cap()` (e.g., `edit_post` → `edit_others_posts`)

### Capability Storage

```php
// Stored in wp_usermeta as serialized array
// Key: {prefix}capabilities
// Value: a:1:{s:10:"subscriber";b:1;}
```

## Authentication Flow

```
wp_signon()
    ├── do_action('wp_authenticate')
    ├── wp_authenticate() - runs authenticate filters
    │       ├── wp_authenticate_username_password()
    │       ├── wp_authenticate_email_password()
    │       ├── wp_authenticate_application_password()
    │       └── wp_authenticate_cookie()
    ├── wp_set_auth_cookie()
    └── do_action('wp_login')
```

### Session Tokens

- Stored in `session_tokens` user meta
- Managed by `WP_Session_Tokens` / `WP_User_Meta_Session_Tokens`
- Contains: expiration, IP, user agent, login time

## Multisite Considerations

- Users are global across network
- Capabilities are per-site (stored with blog prefix)
- Super Admins stored in `site_admins` site option
- `is_super_admin()` checks network-level access
- `switch_to_blog()` / `for_site()` changes capability context

## Key Patterns

### Getting Current User

```php
// Preferred method
$user = wp_get_current_user();
$user_id = get_current_user_id();

// Check if logged in
if ( is_user_logged_in() ) {
    // ...
}
```

### Checking Capabilities

```php
// Current user
if ( current_user_can( 'edit_posts' ) ) { }
if ( current_user_can( 'edit_post', $post_id ) ) { }

// Specific user
if ( user_can( $user_id, 'manage_options' ) ) { }

// On specific site (multisite)
if ( current_user_can_for_site( $site_id, 'edit_posts' ) ) { }
```

### Querying Users

```php
$users = get_users( array(
    'role'    => 'author',
    'orderby' => 'registered',
    'number'  => 10,
) );

// Advanced query
$query = new WP_User_Query( array(
    'role__in'     => array( 'editor', 'author' ),
    'meta_key'     => 'last_active',
    'meta_compare' => '>',
    'meta_value'   => strtotime( '-30 days' ),
) );
```

## Cache Groups

| Group | Contents |
|-------|----------|
| `users` | User objects by ID |
| `userlogins` | User ID by login |
| `userslugs` | User ID by nicename |
| `useremail` | User ID by email |
| `user_meta` | User metadata |
| `user-queries` | WP_User_Query results |
