# Navigation Menu Functions

Complete reference for WordPress navigation menu functions.

## Display Functions

### wp_nav_menu()

Displays a navigation menu.

```php
wp_nav_menu( array $args = array() ): void|string|false
```

**Parameters:**

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `menu` | int\|string\|WP_Term | `''` | Menu ID, slug, name, or object |
| `theme_location` | string | `''` | Registered menu location |
| `container` | string\|false | `'div'` | Container element (`div`, `nav`, or false) |
| `container_class` | string | `'menu-{slug}-container'` | Container CSS class |
| `container_id` | string | `''` | Container ID |
| `container_aria_label` | string | `''` | Aria-label for nav container |
| `menu_class` | string | `'menu'` | UL element CSS class |
| `menu_id` | string | `'menu-{slug}'` | UL element ID |
| `echo` | bool | `true` | Echo or return output |
| `fallback_cb` | callable\|false | `'wp_page_menu'` | Fallback function if menu missing |
| `before` | string | `''` | Text before link markup |
| `after` | string | `''` | Text after link markup |
| `link_before` | string | `''` | Text before link text |
| `link_after` | string | `''` | Text after link text |
| `items_wrap` | string | `'<ul id="%1$s" class="%2$s">%3$s</ul>'` | Output format |
| `item_spacing` | string | `'preserve'` | `'preserve'` or `'discard'` whitespace |
| `depth` | int | `0` | Menu depth (0 = all levels) |
| `walker` | Walker | `''` | Custom Walker instance |

**Returns:** `void` if echo, `string` if returning, `false` if no items/menu.

**Example:**

```php
// Basic usage with theme location
wp_nav_menu( array(
    'theme_location' => 'primary',
    'container'      => 'nav',
    'container_class' => 'main-navigation',
    'menu_class'     => 'nav-menu',
    'depth'          => 2,
) );

// With custom walker
wp_nav_menu( array(
    'theme_location' => 'primary',
    'walker'         => new Bootstrap_Nav_Walker(),
    'items_wrap'     => '<ul class="navbar-nav">%3$s</ul>',
    'container'      => false,
) );

// Return instead of echo
$menu_html = wp_nav_menu( array(
    'menu'   => 'Main Menu',
    'echo'   => false,
) );

// With before/after content
wp_nav_menu( array(
    'theme_location' => 'social',
    'link_before'    => '<span class="screen-reader-text">',
    'link_after'     => '</span>',
) );

// Disable fallback
wp_nav_menu( array(
    'theme_location' => 'sidebar',
    'fallback_cb'    => false,
) );
```

**Behavior:**

1. First tries to get menu by `menu` argument
2. Falls back to menu at `theme_location`
3. Falls back to first menu with items
4. Calls `fallback_cb` if no menu found

---

### walk_nav_menu_tree()

Retrieves HTML list content for nav menu items using Walker.

```php
walk_nav_menu_tree( array $items, int $depth, stdClass $args ): string
```

**Parameters:**

- `$items` - Array of menu item objects
- `$depth` - Traversal depth (0 = all)
- `$args` - wp_nav_menu() arguments object

**Returns:** HTML string of menu items.

---

## Registration Functions

### register_nav_menus()

Registers multiple navigation menu locations.

```php
register_nav_menus( array $locations = array() ): void
```

**Parameters:**

- `$locations` - Associative array of location slugs => descriptions

**Example:**

```php
add_action( 'after_setup_theme', function() {
    register_nav_menus( array(
        'primary'   => __( 'Primary Menu', 'theme' ),
        'footer'    => __( 'Footer Menu', 'theme' ),
        'social'    => __( 'Social Links', 'theme' ),
        'mobile'    => __( 'Mobile Menu', 'theme' ),
    ) );
} );
```

**Notes:**
- Automatically adds `menus` theme support
- Location keys must be strings (not integers)

---

### register_nav_menu()

Registers a single navigation menu location.

```php
register_nav_menu( string $location, string $description ): void
```

**Example:**

```php
register_nav_menu( 'primary', __( 'Primary Navigation', 'theme' ) );
```

---

### unregister_nav_menu()

Unregisters a navigation menu location.

```php
unregister_nav_menu( string $location ): bool
```

**Returns:** `true` on success, `false` on failure.

**Example:**

```php
// Remove parent theme menu location
add_action( 'after_setup_theme', function() {
    unregister_nav_menu( 'secondary' );
}, 20 );
```

---

### get_registered_nav_menus()

Retrieves all registered menu locations.

```php
get_registered_nav_menus(): array
```

**Returns:** Associative array of location slugs => descriptions.

**Example:**

```php
$locations = get_registered_nav_menus();
// array( 'primary' => 'Primary Menu', 'footer' => 'Footer Menu' )

foreach ( $locations as $slug => $description ) {
    echo "Location: $slug - $description\n";
}
```

---

## Location Functions

### get_nav_menu_locations()

Retrieves all menu location assignments.

```php
get_nav_menu_locations(): array
```

**Returns:** Array of location slugs => menu IDs.

**Example:**

```php
$locations = get_nav_menu_locations();
// array( 'primary' => 15, 'footer' => 22 )

$primary_menu_id = $locations['primary'] ?? 0;
```

---

### has_nav_menu()

Checks if a location has a menu assigned.

```php
has_nav_menu( string $location ): bool
```

**Example:**

```php
if ( has_nav_menu( 'primary' ) ) {
    wp_nav_menu( array( 'theme_location' => 'primary' ) );
} else {
    // Show fallback
    wp_list_pages();
}
```

---

### wp_get_nav_menu_name()

Gets the name of the menu assigned to a location.

```php
wp_get_nav_menu_name( string $location ): string
```

**Returns:** Menu name or empty string.

**Example:**

```php
$menu_name = wp_get_nav_menu_name( 'primary' );
if ( $menu_name ) {
    echo "Current menu: $menu_name";
}
```

---

## Menu Object Functions

### wp_get_nav_menu_object()

Gets a navigation menu object.

```php
wp_get_nav_menu_object( int|string|WP_Term $menu ): WP_Term|false
```

**Parameters:**

- `$menu` - Menu ID, slug, name, or term object

**Returns:** WP_Term object or `false`.

**Example:**

```php
// By ID
$menu = wp_get_nav_menu_object( 15 );

// By slug
$menu = wp_get_nav_menu_object( 'main-menu' );

// By name
$menu = wp_get_nav_menu_object( 'Main Menu' );

if ( $menu ) {
    echo $menu->name;       // Menu name
    echo $menu->slug;       // Menu slug
    echo $menu->term_id;    // Menu ID
    echo $menu->count;      // Number of items
}
```

---

### wp_get_nav_menus()

Retrieves all navigation menus.

```php
wp_get_nav_menus( array $args = array() ): WP_Term[]
```

**Parameters:**

- `$args` - Arguments passed to `get_terms()`. Defaults: `hide_empty => false`, `orderby => 'name'`

**Returns:** Array of WP_Term menu objects.

**Example:**

```php
$menus = wp_get_nav_menus();

foreach ( $menus as $menu ) {
    printf( 
        "Menu: %s (ID: %d, Items: %d)\n",
        $menu->name,
        $menu->term_id,
        $menu->count
    );
}

// Get menus ordered by ID
$menus = wp_get_nav_menus( array( 'orderby' => 'term_id' ) );
```

---

### is_nav_menu()

Checks if an ID/slug/name is a valid nav menu.

```php
is_nav_menu( int|string|WP_Term $menu ): bool
```

**Example:**

```php
if ( is_nav_menu( 'main-menu' ) ) {
    echo 'Valid menu!';
}
```

---

## Menu Item Functions

### wp_get_nav_menu_items()

Retrieves all items from a navigation menu.

```php
wp_get_nav_menu_items( 
    int|string|WP_Term $menu, 
    array $args = array() 
): array|false
```

**Parameters:**

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `order` | string | `'ASC'` | Sort order |
| `orderby` | string | `'menu_order'` | Sort field |
| `post_type` | string | `'nav_menu_item'` | Post type |
| `post_status` | string | `'publish'` | Post status |
| `output_key` | string | `'menu_order'` | Output sort key |
| `nopaging` | bool | `true` | Get all items |
| `update_menu_item_cache` | bool | `true` | Prime cache |

**Returns:** Array of menu item objects or `false`.

**Example:**

```php
$menu_items = wp_get_nav_menu_items( 'main-menu' );

if ( $menu_items ) {
    foreach ( $menu_items as $item ) {
        echo $item->title . ' - ' . $item->url . "\n";
    }
}

// Include draft items
$items = wp_get_nav_menu_items( $menu_id, array(
    'post_status' => 'publish,draft',
) );

// Get menu items by location
$locations = get_nav_menu_locations();
if ( isset( $locations['primary'] ) ) {
    $items = wp_get_nav_menu_items( $locations['primary'] );
}
```

---

### wp_setup_nav_menu_item()

Decorates a menu item with navigation properties.

```php
wp_setup_nav_menu_item( object $menu_item ): object
```

**Returns:** Menu item with these properties added:

- `db_id` - Database ID as nav_menu_item
- `menu_item_parent` - Parent menu item ID
- `object_id` - Original object ID
- `object` - Object type (page, category, etc.)
- `type` - Item type (post_type, taxonomy, custom)
- `type_label` - Human-readable type label
- `title` - Menu item title
- `url` - Link URL
- `target` - Link target
- `attr_title` - Title attribute
- `description` - Item description
- `classes` - CSS classes array
- `xfn` - XFN relationship
- `_invalid` - Boolean if original object missing

**Example:**

```php
// Usually called automatically by wp_get_nav_menu_items()
// Manual usage for custom objects:
$post = get_post( $page_id );
$menu_item = wp_setup_nav_menu_item( $post );
echo $menu_item->url; // Page permalink
```

---

### is_nav_menu_item()

Checks if a post ID is a nav menu item.

```php
is_nav_menu_item( int $menu_item_id = 0 ): bool
```

**Example:**

```php
if ( is_nav_menu_item( $post_id ) ) {
    $type = get_post_meta( $post_id, '_menu_item_type', true );
}
```

---

### wp_update_nav_menu_item()

Creates or updates a navigation menu item.

```php
wp_update_nav_menu_item( 
    int $menu_id = 0, 
    int $menu_item_db_id = 0, 
    array $menu_item_data = array(),
    bool $fire_after_hooks = true
): int|WP_Error
```

**Parameters:**

| Data Key | Type | Description |
|----------|------|-------------|
| `menu-item-db-id` | int | Database ID (0 for new) |
| `menu-item-object-id` | int | Original object ID |
| `menu-item-object` | string | Object type slug |
| `menu-item-parent-id` | int | Parent menu item ID |
| `menu-item-position` | int | Menu order position |
| `menu-item-type` | string | `post_type`, `taxonomy`, `custom` |
| `menu-item-title` | string | Menu item title |
| `menu-item-url` | string | URL (for custom items) |
| `menu-item-description` | string | Item description |
| `menu-item-attr-title` | string | Title attribute |
| `menu-item-target` | string | Link target |
| `menu-item-classes` | string | Space-separated CSS classes |
| `menu-item-xfn` | string | XFN relationship |
| `menu-item-status` | string | `publish` or `draft` |

**Returns:** Menu item database ID or WP_Error.

**Examples:**

```php
// Add a page to menu
$item_id = wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'     => 'About Us',
    'menu-item-object-id' => 42,
    'menu-item-object'    => 'page',
    'menu-item-type'      => 'post_type',
    'menu-item-status'    => 'publish',
) );

// Add custom link
$item_id = wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'  => 'Google',
    'menu-item-url'    => 'https://google.com',
    'menu-item-type'   => 'custom',
    'menu-item-target' => '_blank',
    'menu-item-status' => 'publish',
) );

// Add category with parent
$item_id = wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'     => 'News Category',
    'menu-item-object-id' => $cat_id,
    'menu-item-object'    => 'category',
    'menu-item-type'      => 'taxonomy',
    'menu-item-parent-id' => $parent_item_id,
    'menu-item-status'    => 'publish',
) );

// Update existing item
wp_update_nav_menu_item( $menu_id, $existing_item_id, array(
    'menu-item-title'   => 'Updated Title',
    'menu-item-classes' => 'highlight special',
) );

// Add post type archive
wp_update_nav_menu_item( $menu_id, 0, array(
    'menu-item-title'  => 'All Products',
    'menu-item-object' => 'product',
    'menu-item-type'   => 'post_type_archive',
    'menu-item-status' => 'publish',
) );
```

---

### wp_get_associated_nav_menu_items()

Gets menu items associated with an object.

```php
wp_get_associated_nav_menu_items( 
    int $object_id = 0, 
    string $object_type = 'post_type', 
    string $taxonomy = '' 
): int[]
```

**Returns:** Array of menu item IDs.

**Example:**

```php
// Find all menu items linking to a specific page
$menu_item_ids = wp_get_associated_nav_menu_items( $page_id, 'post_type' );

// Find menu items linking to a category
$menu_item_ids = wp_get_associated_nav_menu_items( 
    $term_id, 
    'taxonomy', 
    'category' 
);
```

---

## Menu CRUD Functions

### wp_create_nav_menu()

Creates a new navigation menu.

```php
wp_create_nav_menu( string $menu_name ): int|WP_Error
```

**Parameters:**

- `$menu_name` - Menu name (pre-slashed)

**Returns:** Menu ID or WP_Error.

**Example:**

```php
$menu_id = wp_create_nav_menu( 'My New Menu' );

if ( ! is_wp_error( $menu_id ) ) {
    // Add items to the new menu
    wp_update_nav_menu_item( $menu_id, 0, array(
        'menu-item-title'  => 'Home',
        'menu-item-url'    => home_url( '/' ),
        'menu-item-type'   => 'custom',
        'menu-item-status' => 'publish',
    ) );
}
```

---

### wp_update_nav_menu_object()

Saves or creates a menu with properties.

```php
wp_update_nav_menu_object( 
    int $menu_id = 0, 
    array $menu_data = array() 
): int|WP_Error
```

**Parameters:**

| Data Key | Description |
|----------|-------------|
| `menu-name` | Menu name |
| `description` | Menu description |
| `parent` | Parent term ID |

**Returns:** Menu ID or WP_Error.

**Example:**

```php
// Create new menu
$menu_id = wp_update_nav_menu_object( 0, array(
    'menu-name'   => 'Footer Links',
    'description' => 'Links for site footer',
) );

// Update existing menu
wp_update_nav_menu_object( $menu_id, array(
    'menu-name' => 'Updated Menu Name',
) );
```

---

### wp_delete_nav_menu()

Deletes a navigation menu and all its items.

```php
wp_delete_nav_menu( int|string|WP_Term $menu ): bool|WP_Error
```

**Returns:** `true` on success, `false` or WP_Error on failure.

**Example:**

```php
$result = wp_delete_nav_menu( 'old-menu' );

if ( $result && ! is_wp_error( $result ) ) {
    echo 'Menu deleted successfully';
}
```

---

## Utility Functions

### update_menu_item_cache()

Primes post and term caches for menu item objects.

```php
update_menu_item_cache( WP_Post[] $menu_items ): void
```

**Example:**

```php
// Called automatically by wp_get_nav_menu_items()
// Manual usage for custom queries:
$items = get_posts( array( 'post_type' => 'nav_menu_item' ) );
update_menu_item_cache( $items );
```

---

### wp_map_nav_menu_locations()

Maps menu locations when switching themes.

```php
wp_map_nav_menu_locations( 
    array $new_nav_menu_locations, 
    array $old_nav_menu_locations 
): array
```

**Returns:** Mapped locations array.

**Mapping Logic:**

1. Exact slug matches preserved
2. Common slugs matched: primary/main/header, secondary/footer, social
3. Single-location themes auto-mapped

---

## Private/Internal Functions

These are used internally but understanding them helps with debugging:

### _wp_menu_item_classes_by_context()

Adds contextual CSS classes (current-menu-item, etc.) to menu items based on the current page.

### _is_valid_nav_menu_item()

Checks if a menu item's target object still exists.

### _wp_delete_post_menu_item()

Callback to delete menu items when their linked post is trashed.

### _wp_delete_tax_menu_item()

Callback to delete menu items when their linked term is deleted.

### _wp_auto_add_pages_to_menu()

Automatically adds new top-level pages to menus with auto-add enabled.

### _nav_menu_item_id_use_once()

Prevents duplicate menu item IDs in output.

### _wp_reset_invalid_menu_item_parent()

Prevents menu items from being their own parent.

### wp_nav_menu_remove_menu_item_has_children_class()

Removes `menu-item-has-children` class from bottom-level items based on depth.
