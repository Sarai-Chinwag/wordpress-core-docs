# WordPress Navigation Menus API Overview

The Navigation Menus API, introduced in WordPress 3.0, provides a comprehensive system for creating, managing, and displaying navigation menus. It enables theme developers to define menu locations and allows users to create custom menus through the admin interface.

## Core Concepts

### Menu Taxonomy

Navigation menus are stored using WordPress's taxonomy system:

- **Taxonomy**: `nav_menu` - Custom taxonomy for storing menus
- **Post Type**: `nav_menu_item` - Custom post type for individual menu items
- **Term**: Each menu is a term in the `nav_menu` taxonomy

### Menu Locations

Theme-defined locations where menus can be displayed:

```php
// Register menu locations in functions.php
register_nav_menus( array(
    'primary'   => __( 'Primary Menu', 'theme-textdomain' ),
    'footer'    => __( 'Footer Menu', 'theme-textdomain' ),
    'social'    => __( 'Social Links Menu', 'theme-textdomain' ),
) );

// Register a single location
register_nav_menu( 'mobile', __( 'Mobile Menu', 'theme-textdomain' ) );
```

Registering menu locations automatically adds `menus` theme support.

### Menu Item Types

Menu items can link to different content types:

| Type | Description | Object Property |
|------|-------------|-----------------|
| `post_type` | Links to posts, pages, custom post types | Post type slug (e.g., `page`, `post`) |
| `taxonomy` | Links to categories, tags, custom taxonomies | Taxonomy slug |
| `post_type_archive` | Links to post type archive pages | Post type slug |
| `custom` | Custom URLs | `custom` |

### Menu Item Properties

Each menu item object contains these properties:

```php
$menu_item->ID;                // Post ID
$menu_item->db_id;             // Database ID as nav_menu_item
$menu_item->title;             // Menu item title
$menu_item->url;               // URL to link to
$menu_item->target;            // Link target (_blank, etc.)
$menu_item->attr_title;        // Title attribute
$menu_item->description;       // Item description
$menu_item->classes;           // Array of CSS classes
$menu_item->xfn;               // XFN relationship
$menu_item->menu_item_parent;  // Parent menu item ID
$menu_item->menu_order;        // Position in menu
$menu_item->object;            // Object type (post type or taxonomy)
$menu_item->object_id;         // Original object ID
$menu_item->type;              // Item type (post_type, taxonomy, custom)
$menu_item->type_label;        // Human-readable type label
$menu_item->current;           // Boolean - is current page
$menu_item->current_item_ancestor; // Boolean - ancestor of current
$menu_item->current_item_parent;   // Boolean - parent of current
```

### Menu Item Meta Keys

Menu item data is stored as post meta:

| Meta Key | Description |
|----------|-------------|
| `_menu_item_type` | Item type (post_type, taxonomy, custom) |
| `_menu_item_menu_item_parent` | Parent menu item ID |
| `_menu_item_object_id` | Original object ID |
| `_menu_item_object` | Object type slug |
| `_menu_item_target` | Link target |
| `_menu_item_classes` | CSS classes (serialized array) |
| `_menu_item_xfn` | XFN relationship |
| `_menu_item_url` | Custom URL (for custom items) |
| `_menu_item_orphaned` | Timestamp if orphaned |

## The Walker Pattern

The Walker_Nav_Menu class traverses menu items and generates HTML output. It extends the base Walker class and implements:

```php
$walker->db_fields = array(
    'parent' => 'menu_item_parent',  // Field for parent relationship
    'id'     => 'db_id',              // Field for item ID
);

$walker->tree_type = array( 'post_type', 'taxonomy', 'custom' );
```

### Walker Methods

| Method | Purpose |
|--------|---------|
| `start_lvl()` | Opens a sub-menu `<ul>` |
| `end_lvl()` | Closes a sub-menu `</ul>` |
| `start_el()` | Opens a menu item `<li>` and renders the link |
| `end_el()` | Closes a menu item `</li>` |
| `build_atts()` | Builds HTML attribute string from array |

### Custom Walker Example

```php
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = implode( ' ', array_filter( $classes ) );
        
        $output .= $indent . '<li class="' . esc_attr( $class_names ) . '">';
        
        $atts = array(
            'href'  => $item->url,
            'class' => 'nav-link',
        );
        
        if ( $item->current ) {
            $atts['aria-current'] = 'page';
        }
        
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $attributes .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
            }
        }
        
        $output .= '<a' . $attributes . '>';
        $output .= $args->link_before . $item->title . $args->link_after;
        $output .= '</a>';
    }
}
```

## CSS Classes

WordPress automatically adds contextual CSS classes to menu items:

### Standard Classes

| Class | Description |
|-------|-------------|
| `menu-item` | Applied to all items |
| `menu-item-{ID}` | Item-specific class |
| `menu-item-type-{type}` | Type indicator (post_type, taxonomy, custom) |
| `menu-item-object-{object}` | Object indicator (page, category, etc.) |
| `menu-item-has-children` | Parent items with children |

### Current Item Classes

| Class | Description |
|-------|-------------|
| `current-menu-item` | Currently viewed page |
| `current-menu-parent` | Parent of current item |
| `current-menu-ancestor` | Ancestor of current item |
| `current_page_item` | Current page (backwards compat) |
| `current_page_parent` | Parent page of current |
| `current_page_ancestor` | Ancestor page of current |

### Special Classes

| Class | Description |
|-------|-------------|
| `menu-item-home` | Front page menu item |
| `menu-item-privacy-policy` | Privacy policy page |
| `current-{taxonomy}-ancestor` | Taxonomy ancestor |
| `current-{post_type}-ancestor` | Post type ancestor |

## Menu Display Flow

1. **`wp_nav_menu()`** is called with arguments
2. Menu is resolved (by ID, slug, name, or theme location)
3. **`wp_get_nav_menu_items()`** retrieves menu items
4. **`wp_setup_nav_menu_item()`** decorates each item with properties
5. **`_wp_menu_item_classes_by_context()`** adds contextual CSS classes
6. **`walk_nav_menu_tree()`** uses Walker to generate HTML
7. Filters are applied at each stage

## Theme Location Workflow

```php
// 1. Register locations (in theme setup)
add_action( 'after_setup_theme', function() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu' ),
    ) );
} );

// 2. Display menu at location (in template)
if ( has_nav_menu( 'primary' ) ) {
    wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => 'nav',
        'menu_class'     => 'main-navigation',
    ) );
}

// 3. Get assigned menu name
$menu_name = wp_get_nav_menu_name( 'primary' );
```

## Menu Management

### Create a Menu

```php
$menu_id = wp_create_nav_menu( 'My New Menu' );
```

### Add Items

```php
// Add a page
wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'     => 'About Us',
    'menu-item-object-id' => $page_id,
    'menu-item-object'    => 'page',
    'menu-item-type'      => 'post_type',
    'menu-item-status'    => 'publish',
) );

// Add a custom link
wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'  => 'External Link',
    'menu-item-url'    => 'https://example.com',
    'menu-item-type'   => 'custom',
    'menu-item-status' => 'publish',
) );

// Add a category
wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'     => 'News',
    'menu-item-object-id' => $category_id,
    'menu-item-object'    => 'category',
    'menu-item-type'      => 'taxonomy',
    'menu-item-status'    => 'publish',
) );
```

### Assign to Location

```php
$locations = get_nav_menu_locations();
$locations['primary'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
```

### Delete a Menu

```php
wp_delete_nav_menu( $menu_id );
```

## Navigation Menu Widget

The `WP_Nav_Menu_Widget` class provides a widget for displaying menus in sidebars:

```php
// Widget automatically registered - users configure via admin
// Supports selective refresh in Customizer
// Outputs with <nav> container when theme supports 'html5' 'navigation-widgets'
```

## Auto-Add Pages Option

WordPress can automatically add new top-level pages to specified menus:

```php
// Stored in option: nav_menu_options
$options = get_option( 'nav_menu_options' );
$auto_add_menus = $options['auto_add']; // Array of menu IDs
```

## Theme Switching

When switching themes, WordPress attempts to map menu locations:

1. Locations with matching slugs are preserved
2. Common slug groups are matched (primary/main/header, secondary/footer, social)
3. Single-location themes map the one location automatically

```php
// Mapping function
$mapped = wp_map_nav_menu_locations( $new_locations, $old_locations );
```

## Related Functions Quick Reference

| Function | Purpose |
|----------|---------|
| `wp_nav_menu()` | Display a navigation menu |
| `register_nav_menus()` | Register theme menu locations |
| `has_nav_menu()` | Check if location has assigned menu |
| `wp_get_nav_menu_object()` | Get menu term object |
| `wp_get_nav_menu_items()` | Get menu items |
| `wp_update_nav_menu_item()` | Add/update menu item |
| `wp_create_nav_menu()` | Create new menu |
| `wp_delete_nav_menu()` | Delete a menu |
| `is_nav_menu()` | Check if ID is a menu |
| `is_nav_menu_item()` | Check if ID is a menu item |
