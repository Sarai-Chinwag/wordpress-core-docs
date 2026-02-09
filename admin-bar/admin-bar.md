# Admin Bar API Overview

The Admin Bar (also called Toolbar) API provides a way to add, modify, and remove items from the WordPress admin bar that appears at the top of both front-end and admin pages for logged-in users.

## Architecture

### Core Components

| File | Purpose |
|------|---------|
| `wp-includes/admin-bar.php` | Top-level functions for admin bar operations |
| `wp-includes/class-wp-admin-bar.php` | `WP_Admin_Bar` class implementing the Toolbar API |

### Global Instance

```php
global $wp_admin_bar;
```

The admin bar is instantiated as a global `$wp_admin_bar` object during the `wp_loaded` action via `_wp_admin_bar_init()`.

## Node System

The admin bar is built as a tree of **nodes**. Each node can be:

- **Item** - A clickable menu item (default)
- **Group** - An organizational container for items
- **Container** - Auto-generated wrapper for nested groups

### Node Structure

```php
$node = array(
    'id'     => 'my-item',           // Required: unique identifier
    'title'  => 'My Item',           // Display text/HTML
    'parent' => 'parent-id',         // Parent node ID (default: 'root')
    'href'   => 'https://example.com', // Link URL
    'group'  => false,               // true = group, false = item
    'meta'   => array(               // Additional attributes
        'class'      => 'my-class',
        'html'       => '<span>Extra HTML</span>',
        'onclick'    => 'javascript:void(0)',
        'target'     => '_blank',
        'title'      => 'Tooltip text',
        'rel'        => 'noopener',
        'lang'       => 'en',
        'dir'        => 'ltr',
        'tabindex'   => 0,
        'menu_title' => 'ARIA menu name',
    ),
);
```

### Node Hierarchy

```
root
├── wp-logo (WordPress logo menu)
│   ├── about
│   ├── contribute
│   └── wp-logo-external (group)
│       ├── wporg
│       ├── documentation
│       └── support-forums
├── site-name (Site menu)
│   ├── dashboard / view-site
│   └── appearance (group)
├── my-sites (Multisite only)
├── customize / site-editor
├── updates
├── comments
├── new-content ("+ New" menu)
├── edit
└── top-secondary (group, right-aligned)
    ├── my-account
    ├── recovery-mode
    └── search
```

## Rendering Flow

1. **Initialization** (`_wp_admin_bar_init()`)
   - Check `is_admin_bar_showing()`
   - Instantiate `WP_Admin_Bar` class
   - Call `initialize()` and `add_menus()`

2. **Menu Population** (`admin_bar_menu` action)
   - Core menus added via `add_menus()`
   - Plugins/themes add custom nodes

3. **Binding** (`_bind()`)
   - Build node tree from flat array
   - Wrap orphan items in groups
   - Handle nested groups with containers

4. **Rendering** (`render()`)
   - Fire `wp_before_admin_bar_render`
   - Output HTML via `_render()`, `_render_group()`, `_render_item()`
   - Fire `wp_after_admin_bar_render`

## Visibility Control

### Show/Hide Functions

```php
// Hide admin bar globally
show_admin_bar( false );

// Check if showing
if ( is_admin_bar_showing() ) {
    // Admin bar is visible
}
```

### Automatic Hiding

The admin bar is automatically hidden for:
- XMLRPC requests
- AJAX requests
- iFrame requests
- JSON requests
- Embedded content
- Logged-out users (front-end)
- `wp-login.php` page

## Default Menu Priorities

| Priority | Function | Menu |
|----------|----------|------|
| 0 | `wp_admin_bar_my_account_menu` | My Account submenu |
| 0 | `wp_admin_bar_sidebar_toggle` | Menu toggle (admin) |
| 10 | `wp_admin_bar_wp_menu` | WordPress logo |
| 20 | `wp_admin_bar_my_sites_menu` | My Sites |
| 30 | `wp_admin_bar_site_menu` | Site Name |
| 40 | `wp_admin_bar_edit_site_menu` | Edit Site (block themes) |
| 40 | `wp_admin_bar_customize_menu` | Customize |
| 50 | `wp_admin_bar_updates_menu` | Updates |
| 60 | `wp_admin_bar_comments_menu` | Comments |
| 70 | `wp_admin_bar_new_content_menu` | New |
| 80 | `wp_admin_bar_edit_menu` | Edit |
| 200 | `wp_admin_bar_add_secondary_groups` | Secondary groups |
| 9991 | `wp_admin_bar_my_account_item` | My Account (top) |
| 9992 | `wp_admin_bar_recovery_mode_menu` | Recovery Mode |
| 9999 | `wp_admin_bar_search_menu` | Search |

## CSS Classes

### Container Classes

| Class | Description |
|-------|-------------|
| `#wpadminbar` | Main admin bar container |
| `.quicklinks` | Navigation wrapper |
| `.ab-top-menu` | Top-level menu group |
| `.ab-submenu` | Submenu group |
| `.ab-group-container` | Group container wrapper |

### Item Classes

| Class | Description |
|-------|-------------|
| `.ab-item` | Menu item (link or div) |
| `.ab-empty-item` | Item without href |
| `.menupop` | Item with children |
| `.with-avatar` | My Account with avatar |
| `.ab-icon` | Icon span |
| `.ab-label` | Label span |

### State Classes

| Class | Description |
|-------|-------------|
| `.hover` | Hover state |
| `.nojq` | No jQuery detected |
| `.nojs` | No JavaScript |
| `.mobile` | Mobile device |

## User Preferences

Users can control admin bar visibility via their profile settings:

```php
// Get user preference (front-end)
$show = _get_admin_bar_pref( 'front', $user_id );

// Stored as user meta
// show_admin_bar_front = 'true' | 'false'
```

## Theme Support

Themes can customize the admin bar bump (spacing):

```php
// Use default bump callback
add_theme_support( 'admin-bar' );

// Use custom callback
add_theme_support( 'admin-bar', array(
    'callback' => 'my_admin_bar_bump',
) );

// Disable bump entirely
add_theme_support( 'admin-bar', array(
    'callback' => '__return_false',
) );
```

Default bump CSS:
```css
@media screen { html { margin-top: 32px !important; } }
@media screen and (max-width: 782px) { html { margin-top: 46px !important; } }
```

## Multisite Considerations

On multisite installations:
- `wp_admin_bar_my_sites_menu()` shows all user blogs
- Site icons can be shown (filterable via `wp_admin_bar_show_site_icons`)
- Network Admin links appear for super admins
- Blog switching uses `switch_to_blog()` / `restore_current_blog()`
