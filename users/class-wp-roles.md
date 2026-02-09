# WP_Roles Class

Core class for managing all user roles and their capabilities.

**Since:** 2.0.0  
**Source:** `wp-includes/class-wp-roles.php`

## Overview

`WP_Roles` is a singleton-like registry that manages all roles available on a site. It handles role storage in the database, role creation/removal, and capability management at the role level.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Roles {
    public $roles;
    public $role_objects = array();
    public $role_names = array();
    public $role_key;
    public $use_db = true;
    protected $site_id = 0;
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$roles` | array[] | Raw role data from database |
| `$role_objects` | WP_Role[] | Role objects keyed by role name |
| `$role_names` | string[] | Display names keyed by role name |
| `$role_key` | string | Option name (e.g., `wp_user_roles`) |
| `$use_db` | bool | Whether to persist to database |
| `$site_id` | int | Site ID for current context |

## Data Structure

Roles are stored in the `{prefix}_user_roles` option:

```php
array(
    'administrator' => array(
        'name'         => 'Administrator',
        'capabilities' => array(
            'switch_themes'          => true,
            'edit_themes'            => true,
            'activate_plugins'       => true,
            'edit_plugins'           => true,
            'edit_users'             => true,
            'edit_files'             => true,
            'manage_options'         => true,
            'moderate_comments'      => true,
            // ... many more
        ),
    ),
    'editor' => array(
        'name'         => 'Editor',
        'capabilities' => array(
            'moderate_comments'      => true,
            'manage_categories'      => true,
            'manage_links'           => true,
            'edit_others_posts'      => true,
            // ...
        ),
    ),
    // subscriber, contributor, author...
)
```

## Constructor

```php
public function __construct( int $site_id = null )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$site_id` | int\|null | Site ID (default: current site) |

**Behavior:**
1. Checks for `$wp_user_roles` global override
2. Sets `$use_db = false` if global is set
3. Calls `for_site()` to initialize

---

## Role Management

### add_role()

Adds a new role with capabilities.

```php
public function add_role( 
    string $role, 
    string $display_name, 
    array $capabilities = array() 
): WP_Role|void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$role` | string | Role identifier (slug) |
| `$display_name` | string | Human-readable name |
| `$capabilities` | array | Capabilities (bool[] or string[]) |

**Since 6.9.0:** Accepts numerically indexed capability array.

**Returns:** `WP_Role` on success, `void` if role exists or is empty.

**Examples:**
```php
// Associative array (traditional)
wp_roles()->add_role( 'shop_manager', 'Shop Manager', array(
    'read'              => true,
    'edit_posts'        => true,
    'manage_woocommerce' => true,
    'delete_posts'      => false,  // Explicitly deny
) );

// Numerically indexed (since 6.9.0)
wp_roles()->add_role( 'shop_manager', 'Shop Manager', array(
    'read',
    'edit_posts',
    'manage_woocommerce',
) );
```

---

### remove_role()

Removes a role.

```php
public function remove_role( string $role ): void
```

**Side effects:**
- Updates `default_role` option to `'subscriber'` if removed role was default

---

### get_role()

Retrieves a role object.

```php
public function get_role( string $role ): WP_Role|null
```

**Returns:** `WP_Role` or `null` if not found.

---

### is_role()

Checks if role exists.

```php
public function is_role( string $role ): bool
```

---

### get_names()

Gets all role display names.

```php
public function get_names(): string[]
```

**Returns:**
```php
array(
    'administrator' => 'Administrator',
    'editor'        => 'Editor',
    'author'        => 'Author',
    'contributor'   => 'Contributor',
    'subscriber'    => 'Subscriber',
)
```

---

## Capability Management

### add_cap()

Adds capability to a role.

```php
public function add_cap( string $role, string $cap, bool $grant = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$role` | string | Role name |
| `$cap` | string | Capability name |
| `$grant` | bool | Grant (`true`) or deny (`false`) |

**Example:**
```php
wp_roles()->add_cap( 'editor', 'manage_shop_orders', true );
```

---

### remove_cap()

Removes capability from a role.

```php
public function remove_cap( string $role, string $cap ): void
```

---

## Site Context

### for_site()

Initializes roles for a specific site.

```php
public function for_site( int $site_id = null ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$site_id` | int\|null | Site ID (default: current) |

**Behavior:**
1. Sets `$role_key` to `{prefix}user_roles`
2. Loads roles from database or global
3. Calls `init_roles()` to create objects

---

### get_site_id()

Gets current site context.

```php
public function get_site_id(): int
```

---

### init_roles()

Creates `WP_Role` objects from raw data.

```php
public function init_roles(): void
```

**Fires:** `wp_roles_init` action.

---

## Hooks

### wp_roles_init

Fires after roles are initialized.

```php
do_action( 'wp_roles_init', WP_Roles $wp_roles );
```

**Use case:** Add custom roles or capabilities.

```php
add_action( 'wp_roles_init', function( $wp_roles ) {
    if ( ! $wp_roles->is_role( 'custom_role' ) ) {
        $wp_roles->add_role( 'custom_role', 'Custom Role', array(
            'read' => true,
        ) );
    }
} );
```

---

## Usage Examples

### Get WP_Roles Instance

```php
// Preferred method
$roles = wp_roles();

// Alternative
global $wp_roles;
```

### Add Custom Role

```php
// In plugin activation
function myplugin_add_roles() {
    add_role( 'shop_manager', __( 'Shop Manager', 'myplugin' ), array(
        'read'                   => true,
        'edit_posts'             => false,
        'manage_woocommerce'     => true,
        'edit_shop_orders'       => true,
        'edit_others_shop_orders' => true,
    ) );
}
register_activation_hook( __FILE__, 'myplugin_add_roles' );

// In plugin deactivation
function myplugin_remove_roles() {
    remove_role( 'shop_manager' );
}
register_deactivation_hook( __FILE__, 'myplugin_remove_roles' );
```

### Add Capability to Existing Role

```php
// On plugin activation
function myplugin_add_caps() {
    $role = get_role( 'editor' );
    if ( $role ) {
        $role->add_cap( 'manage_custom_content' );
    }
}
register_activation_hook( __FILE__, 'myplugin_add_caps' );
```

### List All Roles

```php
$roles = wp_roles();

foreach ( $roles->get_names() as $slug => $name ) {
    echo "{$name} ({$slug})<br>";
}
```

### Check Role Capabilities

```php
$role = get_role( 'editor' );

if ( $role && $role->has_cap( 'edit_others_posts' ) ) {
    echo "Editors can edit others' posts.";
}

// Get all capabilities
print_r( $role->capabilities );
```

### Multisite: Different Roles Per Site

```php
// Roles are stored per-site in multisite
$roles = wp_roles();

// Current site
echo "Site {$roles->get_site_id()} roles:\n";

// Switch to another site
$roles->for_site( 2 );
echo "Site 2 roles:\n";
print_r( $roles->get_names() );
```

---

## Deprecated Methods

| Method | Since | Replacement |
|--------|-------|-------------|
| `_init()` | 4.9.0 | `for_site()` |
| `reinit()` | 4.7.0 | `for_site()` |

---

## Global Override

Roles can be defined via global variable (bypasses database):

```php
// In wp-config.php or early in loading
$wp_user_roles = array(
    'administrator' => array(
        'name' => 'Administrator',
        'capabilities' => array( /* ... */ ),
    ),
    // ...
);
```

When `$wp_user_roles` is set:
- `$use_db` becomes `false`
- Roles are not saved to database
- Useful for network-wide role definition
