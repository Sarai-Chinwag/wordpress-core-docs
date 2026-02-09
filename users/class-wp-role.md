# WP_Role Class

Core class representing a single user role with its capabilities.

**Since:** 2.0.0  
**Source:** `wp-includes/class-wp-role.php`

## Overview

`WP_Role` represents an individual role (e.g., "editor", "subscriber") and provides methods for managing its capabilities. Changes made to a role affect all users with that role.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Role {
    public $name;
    public $capabilities;
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$name` | string | Role identifier (slug) |
| `$capabilities` | bool[] | Capabilities keyed by name, value is grant status |

## Constructor

```php
public function __construct( string $role, bool[] $capabilities )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$role` | string | Role name (slug) |
| `$capabilities` | bool[] | Capability array |

**Example:**
```php
$role = new WP_Role( 'custom_role', array(
    'read'       => true,
    'edit_posts' => true,
    'publish_posts' => false,
) );
```

## Methods

### add_cap()

Adds capability to the role.

```php
public function add_cap( string $cap, bool $grant = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cap` | string | Capability name |
| `$grant` | bool | `true` to grant, `false` to deny |

**Behavior:**
1. Updates local `$capabilities` array
2. Calls `wp_roles()->add_cap()` to persist

**Examples:**
```php
$role = get_role( 'editor' );

// Grant capability
$role->add_cap( 'manage_shop_orders' );

// Explicitly deny capability
$role->add_cap( 'delete_shop_orders', false );
```

---

### remove_cap()

Removes capability from the role.

```php
public function remove_cap( string $cap ): void
```

**Behavior:**
1. Removes from local `$capabilities` array
2. Calls `wp_roles()->remove_cap()` to persist

**Example:**
```php
$role = get_role( 'author' );
$role->remove_cap( 'publish_posts' );
```

---

### has_cap()

Checks if role has a capability.

```php
public function has_cap( string $cap ): bool
```

**Returns:** `true` if granted, `false` if not set or denied.

**Example:**
```php
$role = get_role( 'editor' );

if ( $role->has_cap( 'edit_others_posts' ) ) {
    echo "Editors can edit others' posts.";
}

if ( ! $role->has_cap( 'manage_options' ) ) {
    echo "Editors cannot manage options.";
}
```

---

## Hooks

### role_has_cap

Filters capabilities when checking `has_cap()`.

```php
$capabilities = apply_filters( 'role_has_cap', bool[] $capabilities, string $cap, string $name );
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$capabilities` | bool[] | Role's capability array |
| `$cap` | string | Capability being checked |
| `$name` | string | Role name |

**Example:**
```php
add_filter( 'role_has_cap', function( $caps, $cap, $role_name ) {
    // Give editors manage_options on weekends
    if ( $role_name === 'editor' && $cap === 'manage_options' ) {
        $day = date( 'N' );
        if ( $day >= 6 ) { // Saturday or Sunday
            $caps['manage_options'] = true;
        }
    }
    return $caps;
}, 10, 3 );
```

---

## Usage Examples

### Get Role Object

```php
// Via function
$editor = get_role( 'editor' );

// Via WP_Roles
$editor = wp_roles()->get_role( 'editor' );
```

### Check Role Capabilities

```php
$editor = get_role( 'editor' );

// Check single capability
if ( $editor->has_cap( 'moderate_comments' ) ) {
    echo "Editors can moderate comments.";
}

// List all capabilities
echo "Editor capabilities:\n";
foreach ( $editor->capabilities as $cap => $granted ) {
    $status = $granted ? '✓' : '✗';
    echo "  {$status} {$cap}\n";
}
```

### Modify Role Capabilities

```php
$author = get_role( 'author' );

// Add capabilities
$author->add_cap( 'upload_files' );
$author->add_cap( 'edit_others_posts' );

// Remove capability
$author->remove_cap( 'delete_published_posts' );

// Deny capability (different from remove)
$author->add_cap( 'unfiltered_html', false );
```

### Create Custom Role with Specific Caps

```php
// Add role with base capabilities
add_role( 'forum_moderator', 'Forum Moderator', array(
    'read' => true,
) );

// Then add more specific capabilities
$role = get_role( 'forum_moderator' );
$role->add_cap( 'moderate_forum' );
$role->add_cap( 'edit_forum_posts' );
$role->add_cap( 'delete_forum_posts' );
$role->add_cap( 'ban_forum_users' );
```

### Clone Existing Role

```php
// Get source role
$editor = get_role( 'editor' );

// Create new role with same capabilities
add_role( 'senior_editor', 'Senior Editor', $editor->capabilities );

// Add additional capabilities
$senior = get_role( 'senior_editor' );
$senior->add_cap( 'manage_options' );
$senior->add_cap( 'edit_theme_options' );
```

### Compare Role Capabilities

```php
$editor = get_role( 'editor' );
$admin  = get_role( 'administrator' );

$editor_caps = array_keys( array_filter( $editor->capabilities ) );
$admin_caps  = array_keys( array_filter( $admin->capabilities ) );

$admin_only = array_diff( $admin_caps, $editor_caps );

echo "Admin-only capabilities:\n";
foreach ( $admin_only as $cap ) {
    echo "  - {$cap}\n";
}
```

---

## Capability Grant vs Deny

Capabilities can have three states:

| State | Value | Meaning |
|-------|-------|---------|
| Granted | `true` | User can perform action |
| Denied | `false` | User explicitly cannot |
| Not Set | (missing) | Inherits from other source or denied |

**Difference between remove and deny:**

```php
$role = get_role( 'custom_role' );

// Remove - capability is unset, could be granted elsewhere
$role->remove_cap( 'edit_posts' );
isset( $role->capabilities['edit_posts'] ); // false

// Deny - explicitly set to false
$role->add_cap( 'edit_posts', false );
$role->capabilities['edit_posts']; // false
```

---

## Best Practices

### 1. Use Activation/Deactivation Hooks

```php
// Plugin activation
register_activation_hook( __FILE__, function() {
    $role = get_role( 'editor' );
    $role->add_cap( 'my_plugin_capability' );
} );

// Plugin deactivation
register_deactivation_hook( __FILE__, function() {
    $role = get_role( 'editor' );
    $role->remove_cap( 'my_plugin_capability' );
} );
```

### 2. Check Role Exists

```php
$role = get_role( 'custom_role' );

if ( $role ) {
    $role->add_cap( 'my_capability' );
} else {
    // Role doesn't exist, create it first
    add_role( 'custom_role', 'Custom Role', array(
        'read' => true,
        'my_capability' => true,
    ) );
}
```

### 3. Batch Capability Updates

```php
// More efficient than individual add_cap calls
$caps_to_add = array(
    'manage_inventory',
    'view_reports',
    'export_data',
);

$role = get_role( 'shop_manager' );
foreach ( $caps_to_add as $cap ) {
    $role->add_cap( $cap );
}
```

### 4. Document Custom Capabilities

```php
/**
 * Custom capabilities added by My Plugin:
 * 
 * - myplugin_view_dashboard: View the plugin dashboard
 * - myplugin_edit_settings: Edit plugin settings
 * - myplugin_manage_users: Manage plugin users
 */
```
