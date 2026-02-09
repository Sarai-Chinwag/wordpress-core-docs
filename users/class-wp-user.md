# WP_User Class

Core class representing a WordPress user with their data and capabilities.

**Since:** 2.0.0  
**Source:** `wp-includes/class-wp-user.php`

## Overview

`WP_User` represents an individual user with their profile data, roles, and capabilities. It provides methods for checking permissions, managing roles, and accessing user metadata.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_User {
    public $data;
    public $ID = 0;
    public $caps = array();
    public $cap_key;
    public $roles = array();
    public $allcaps = array();
    public $filter = null;
    private $site_id = 0;
}
```

## Properties

### Core Properties

| Property | Type | Description |
|----------|------|-------------|
| `$data` | stdClass | User data container from database |
| `$ID` | int | User ID |
| `$caps` | bool[] | Individual capabilities granted to user |
| `$cap_key` | string | Meta key for capabilities (e.g., `wp_capabilities`) |
| `$roles` | string[] | Roles the user has |
| `$allcaps` | bool[] | All capabilities (roles + individual) |
| `$filter` | string\|null | Filter context for data |
| `$site_id` | int | Site ID for capability initialization |

### Magic Properties (via `__get`)

These are accessed from `$data` or user meta:

| Property | Type | Description |
|----------|------|-------------|
| `$user_login` | string | Username |
| `$user_pass` | string | Hashed password |
| `$user_nicename` | string | URL-friendly name |
| `$user_email` | string | Email address |
| `$user_url` | string | Website URL |
| `$user_registered` | string | Registration datetime |
| `$user_activation_key` | string | Password reset key |
| `$user_status` | string | User status |
| `$display_name` | string | Display name |
| `$nickname` | string | Nickname (from meta) |
| `$first_name` | string | First name (from meta) |
| `$last_name` | string | Last name (from meta) |
| `$description` | string | Bio (from meta) |
| `$user_level` | int | Legacy user level |
| `$rich_editing` | string | Rich editor preference |
| `$syntax_highlighting` | string | Code highlighting preference |
| `$locale` | string | User locale |
| `$spam` | string | Spam status (multisite) |
| `$deleted` | string | Deleted status (multisite) |

## Constructor

```php
public function __construct( 
    int|string|stdClass|WP_User $id = 0, 
    string $name = '', 
    int $site_id = 0 
)
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | mixed | User ID, WP_User object, or database row |
| `$name` | string | Username (alternative to ID) |
| `$site_id` | int | Site ID for capabilities (default: current) |

**Examples:**
```php
// By ID
$user = new WP_User( 1 );

// By username
$user = new WP_User( 0, 'admin' );

// From existing object
$user = new WP_User( $existing_user );

// For specific site
$user = new WP_User( 1, '', $site_id );
```

## Static Methods

### get_data_by()

Retrieves user data by field.

```php
public static function get_data_by( string $field, string|int $value ): object|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | `'id'`, `'ID'`, `'slug'`, `'email'`, `'login'` |
| `$value` | mixed | Field value |

**Returns:** Raw user object or `false`.

**Example:**
```php
$data = WP_User::get_data_by( 'email', 'user@example.com' );
if ( $data ) {
    $user = new WP_User( $data );
}
```

## Instance Methods

### Initialization

#### init()

Sets up object properties from data.

```php
public function init( object $data, int $site_id = 0 ): void
```

#### for_site()

Initializes capabilities for a specific site.

```php
public function for_site( int $site_id = 0 ): void
```

**Example:**
```php
$user = new WP_User( 1 );
$user->for_site( 2 ); // Switch to site 2's capabilities
```

#### get_site_id()

Gets the site ID for current capability context.

```php
public function get_site_id(): int
```

---

### Data Access

#### exists()

Checks if user exists in database.

```php
public function exists(): bool
```

#### get()

Retrieves property or meta value.

```php
public function get( string $key ): mixed
```

#### has_prop()

Checks if property or meta exists.

```php
public function has_prop( string $key ): bool
```

#### to_array()

Returns array representation.

```php
public function to_array(): array
```

---

### Role Management

#### set_role()

Sets user's role (replaces existing roles).

```php
public function set_role( string $role ): void
```

**Example:**
```php
$user->set_role( 'editor' );    // Set to editor
$user->set_role( '' );          // Remove all roles
```

**Fires:**
- `remove_user_role` for each removed role
- `add_user_role` for new role
- `set_user_role`

---

#### add_role()

Adds role to user (keeps existing).

```php
public function add_role( string $role ): void
```

**Example:**
```php
$user->add_role( 'editor' );  // User now has original role + editor
```

**Fires:** `add_user_role`

---

#### remove_role()

Removes specific role from user.

```php
public function remove_role( string $role ): void
```

**Fires:** `remove_user_role`

---

### Capability Management

#### has_cap()

Checks if user has capability.

```php
public function has_cap( string $cap, mixed ...$args ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cap` | string | Capability name |
| `...$args` | mixed | Additional args (e.g., object ID for meta caps) |

**Examples:**
```php
// Primitive capability
$user->has_cap( 'edit_posts' );

// Meta capability with object ID
$user->has_cap( 'edit_post', $post_id );

// Meta capability with multiple args
$user->has_cap( 'edit_post_meta', $post_id, $meta_key );
```

**How it works:**
1. Calls `map_meta_cap()` to get required primitive caps
2. Super admins return `true` unless `do_not_allow`
3. Applies `user_has_cap` filter
4. Checks all required caps exist in `$allcaps`

---

#### add_cap()

Adds capability to user.

```php
public function add_cap( string $cap, bool $grant = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cap` | string | Capability name |
| `$grant` | bool | Grant (`true`) or deny (`false`) |

**Example:**
```php
$user->add_cap( 'edit_others_posts' );       // Grant
$user->add_cap( 'delete_others_posts', false ); // Deny
```

---

#### remove_cap()

Removes capability from user.

```php
public function remove_cap( string $cap ): void
```

---

#### remove_all_caps()

Removes all capabilities and roles.

```php
public function remove_all_caps(): void
```

---

#### get_role_caps()

Builds `$allcaps` from roles and individual caps.

```php
public function get_role_caps(): bool[]
```

Called automatically during initialization.

---

### Utility Methods

#### level_reduction()

Compares level capabilities (internal).

```php
public function level_reduction( int $max, string $item ): int
```

#### update_user_level_from_caps()

Updates legacy user level from capabilities.

```php
public function update_user_level_from_caps(): void
```

#### translate_level_to_cap()

Converts numeric level to capability name.

```php
public function translate_level_to_cap( int $level ): string
```

**Example:**
```php
$cap = $user->translate_level_to_cap( 10 ); // 'level_10'
```

---

## Magic Methods

### __get()

Accesses user data and meta as properties.

```php
public function __get( string $key ): mixed
```

**Retrieval order:**
1. Check `$data->$key`
2. Check back-compat key mapping
3. Get from user meta

---

### __set()

Sets property on data object (not persisted).

```php
public function __set( string $key, mixed $value ): void
```

**Note:** Does not update database. Use `update_user_meta()` for persistence.

---

### __isset()

Checks if property exists.

```php
public function __isset( string $key ): bool
```

---

### __unset()

Unsets property from data object.

```php
public function __unset( string $key ): void
```

---

## Usage Examples

### Basic Usage

```php
// Get user and check capabilities
$user = new WP_User( get_current_user_id() );

if ( $user->exists() ) {
    echo "Welcome, {$user->display_name}!";
    
    if ( $user->has_cap( 'edit_posts' ) ) {
        echo "You can edit posts.";
    }
}
```

### Role Management

```php
$user = new WP_User( $user_id );

// Check current roles
print_r( $user->roles ); // ['subscriber']

// Promote to author
$user->set_role( 'author' );

// Add additional role
$user->add_role( 'custom_role' );

// Check roles again
print_r( $user->roles ); // ['author', 'custom_role']
```

### Custom Capabilities

```php
$user = new WP_User( $user_id );

// Grant custom capability
$user->add_cap( 'manage_shop_orders' );

// Deny specific capability (overrides role)
$user->add_cap( 'delete_shop_orders', false );

// Check
$user->has_cap( 'manage_shop_orders' ); // true
$user->has_cap( 'delete_shop_orders' ); // false
```

### Multisite Context

```php
$user = new WP_User( $user_id );

// Get current site's roles
echo "Site 1 roles: " . implode( ', ', $user->roles );

// Switch to another site
$user->for_site( 2 );
echo "Site 2 roles: " . implode( ', ', $user->roles );

// Site ID accessor
$site_id = $user->get_site_id();
```

### Accessing All Data

```php
$user = new WP_User( $user_id );

// Direct properties
echo $user->ID;
echo $user->user_login;
echo $user->user_email;

// Meta values (magic __get)
echo $user->first_name;
echo $user->last_name;
echo $user->description;

// Custom meta
echo $user->phone_number; // If exists in usermeta

// Check existence first
if ( $user->has_prop( 'custom_field' ) ) {
    echo $user->custom_field;
}
```

## Deprecated Methods

| Method | Since | Replacement |
|--------|-------|-------------|
| `_init_caps()` | 4.9.0 | `for_site()` |
| `for_blog()` | 4.9.0 | `for_site()` |
