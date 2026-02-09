# Navigation Menu Hooks

Comprehensive reference for all action and filter hooks in the WordPress Navigation Menus API.

## Display Filters

### wp_nav_menu_args

Filters arguments passed to `wp_nav_menu()`.

```php
apply_filters( 'wp_nav_menu_args', array $args )
```

**Parameters:**

- `$args` - Array of wp_nav_menu() arguments

**Example:**

```php
add_filter( 'wp_nav_menu_args', function( $args ) {
    // Force all menus to use a custom walker
    $args['walker'] = new My_Custom_Walker();
    
    // Add a common class to all menus
    $args['menu_class'] .= ' site-navigation';
    
    return $args;
} );

// Modify specific location
add_filter( 'wp_nav_menu_args', function( $args ) {
    if ( $args['theme_location'] === 'primary' ) {
        $args['depth'] = 2;
        $args['container'] = 'nav';
    }
    return $args;
} );
```

---

### pre_wp_nav_menu

Short-circuits `wp_nav_menu()` output.

```php
apply_filters( 'pre_wp_nav_menu', string|null $output, stdClass $args )
```

**Parameters:**

- `$output` - Nav menu output to short-circuit with (default `null`)
- `$args` - Object of wp_nav_menu() arguments

**Returns:** Non-null value to skip normal menu rendering.

**Example:**

```php
add_filter( 'pre_wp_nav_menu', function( $output, $args ) {
    // Return cached menu if available
    if ( $args->theme_location === 'primary' ) {
        $cached = get_transient( 'primary_menu_cache' );
        if ( $cached ) {
            return $cached;
        }
    }
    return null; // Continue normal rendering
}, 10, 2 );
```

---

### wp_nav_menu_container_allowedtags

Filters allowed HTML tags for menu container.

```php
apply_filters( 'wp_nav_menu_container_allowedtags', array $tags )
```

**Default:** `array( 'div', 'nav' )`

**Example:**

```php
add_filter( 'wp_nav_menu_container_allowedtags', function( $tags ) {
    $tags[] = 'section';
    $tags[] = 'aside';
    return $tags;
} );
```

---

### wp_nav_menu_objects

Filters sorted menu items before HTML generation.

```php
apply_filters( 'wp_nav_menu_objects', array $sorted_menu_items, stdClass $args )
```

**Parameters:**

- `$sorted_menu_items` - Menu items sorted by menu_order
- `$args` - Object of wp_nav_menu() arguments

**Example:**

```php
// Add custom item to menu
add_filter( 'wp_nav_menu_objects', function( $items, $args ) {
    if ( $args->theme_location === 'primary' && is_user_logged_in() ) {
        $logout_item = (object) array(
            'ID'               => -1,
            'db_id'            => -1,
            'menu_item_parent' => 0,
            'object_id'        => -1,
            'object'           => 'custom',
            'type'             => 'custom',
            'type_label'       => 'Custom',
            'title'            => 'Logout',
            'url'              => wp_logout_url(),
            'target'           => '',
            'attr_title'       => '',
            'description'      => '',
            'classes'          => array( 'menu-item', 'logout-link' ),
            'xfn'              => '',
            'menu_order'       => count( $items ) + 1,
        );
        $items[] = $logout_item;
    }
    return $items;
}, 10, 2 );

// Remove items conditionally
add_filter( 'wp_nav_menu_objects', function( $items, $args ) {
    if ( ! current_user_can( 'manage_options' ) ) {
        $items = array_filter( $items, function( $item ) {
            return ! in_array( 'admin-only', $item->classes );
        } );
    }
    return $items;
}, 10, 2 );

// Reorder items
add_filter( 'wp_nav_menu_objects', function( $items, $args ) {
    usort( $items, function( $a, $b ) {
        return strcmp( $a->title, $b->title ); // Alphabetical
    } );
    return $items;
}, 10, 2 );
```

---

### wp_nav_menu_items

Filters HTML list content for all menus.

```php
apply_filters( 'wp_nav_menu_items', string $items, stdClass $args )
```

**Parameters:**

- `$items` - HTML list content (`<li>...</li>`)
- `$args` - Object of wp_nav_menu() arguments

**Example:**

```php
add_filter( 'wp_nav_menu_items', function( $items, $args ) {
    if ( $args->theme_location === 'primary' ) {
        // Add search form at end
        $items .= '<li class="menu-item search-form">' . get_search_form( false ) . '</li>';
    }
    return $items;
}, 10, 2 );
```

---

### wp_nav_menu_{$menu->slug}_items

Filters HTML content for a specific menu by slug.

```php
apply_filters( "wp_nav_menu_{$menu->slug}_items", string $items, stdClass $args )
```

**Example:**

```php
// For a menu with slug "main-menu"
add_filter( 'wp_nav_menu_main-menu_items', function( $items, $args ) {
    return '<li class="menu-brand">Logo</li>' . $items;
}, 10, 2 );
```

---

### wp_nav_menu

Filters final HTML output of navigation menu.

```php
apply_filters( 'wp_nav_menu', string $nav_menu, stdClass $args )
```

**Parameters:**

- `$nav_menu` - Complete HTML output
- `$args` - Object of wp_nav_menu() arguments

**Example:**

```php
add_filter( 'wp_nav_menu', function( $nav_menu, $args ) {
    // Cache the menu
    if ( $args->theme_location === 'primary' ) {
        set_transient( 'primary_menu_cache', $nav_menu, HOUR_IN_SECONDS );
    }
    return $nav_menu;
}, 10, 2 );

// Add wrapper div
add_filter( 'wp_nav_menu', function( $nav_menu, $args ) {
    if ( $args->theme_location === 'mobile' ) {
        return '<div class="mobile-menu-wrapper">' . $nav_menu . '</div>';
    }
    return $nav_menu;
}, 10, 2 );
```

---

## Walker Filters

### nav_menu_item_args

Filters arguments for individual menu items.

```php
apply_filters( 'nav_menu_item_args', stdClass $args, WP_Post $menu_item, int $depth )
```

**Example:**

```php
add_filter( 'nav_menu_item_args', function( $args, $item, $depth ) {
    // Modify args for specific items
    if ( in_array( 'special-item', $item->classes ) ) {
        $args->link_before = '<span class="special-icon"></span>';
    }
    return $args;
}, 10, 3 );
```

---

### nav_menu_css_class

Filters CSS classes for menu item `<li>` element.

```php
apply_filters( 'nav_menu_css_class', array $classes, WP_Post $menu_item, stdClass $args, int $depth )
```

**Parameters:**

- `$classes` - Array of CSS classes
- `$menu_item` - Current menu item object
- `$args` - Object of wp_nav_menu() arguments
- `$depth` - Menu depth (0-based)

**Example:**

```php
add_filter( 'nav_menu_css_class', function( $classes, $item, $args, $depth ) {
    // Add depth-based class
    $classes[] = 'depth-' . $depth;
    
    // Add class based on item type
    if ( $item->type === 'post_type' && $item->object === 'page' ) {
        $classes[] = 'is-page-link';
    }
    
    // Active state based on post parent
    if ( is_singular() && $item->object_id == wp_get_post_parent_id( get_the_ID() ) ) {
        $classes[] = 'current-menu-parent';
    }
    
    return $classes;
}, 10, 4 );

// Remove unwanted classes
add_filter( 'nav_menu_css_class', function( $classes ) {
    // Keep only essential classes
    $keep = array( 'menu-item', 'current-menu-item', 'menu-item-has-children' );
    return array_intersect( $classes, $keep );
} );
```

---

### nav_menu_item_id

Filters ID attribute of menu item `<li>` element.

```php
apply_filters( 'nav_menu_item_id', string $menu_item_id, WP_Post $menu_item, stdClass $args, int $depth )
```

**Example:**

```php
// Remove ID attributes
add_filter( 'nav_menu_item_id', '__return_empty_string' );

// Custom ID format
add_filter( 'nav_menu_item_id', function( $id, $item, $args, $depth ) {
    return 'nav-item-' . $item->ID;
}, 10, 4 );
```

---

### nav_menu_item_attributes

Filters HTML attributes on menu item `<li>` element.

```php
apply_filters( 'nav_menu_item_attributes', array $li_atts, WP_Post $menu_item, stdClass $args, int $depth )
```

**Since:** WordPress 6.3.0

**Parameters:**

- `$li_atts` - Array with `id` and `class` keys
- `$menu_item` - Current menu item
- `$args` - wp_nav_menu() arguments
- `$depth` - Menu depth

**Example:**

```php
add_filter( 'nav_menu_item_attributes', function( $atts, $item, $args, $depth ) {
    // Add data attribute
    $atts['data-menu-item-id'] = $item->ID;
    
    // Add role for accessibility
    $atts['role'] = 'none';
    
    return $atts;
}, 10, 4 );
```

---

### nav_menu_link_attributes

Filters HTML attributes on menu item `<a>` element.

```php
apply_filters( 'nav_menu_link_attributes', array $atts, WP_Post $menu_item, stdClass $args, int $depth )
```

**Parameters:**

- `$atts` - Array of attributes (title, target, rel, href, aria-current)
- `$menu_item` - Current menu item
- `$args` - wp_nav_menu() arguments
- `$depth` - Menu depth

**Example:**

```php
add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args, $depth ) {
    // Add class to all links
    $atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' nav-link' : 'nav-link';
    
    // Active class
    if ( $item->current ) {
        $atts['class'] .= ' active';
    }
    
    // External links
    if ( strpos( $item->url, home_url() ) === false && $item->url !== '#' ) {
        $atts['target'] = '_blank';
        $atts['rel'] = 'noopener noreferrer';
    }
    
    return $atts;
}, 10, 4 );

// Add data attributes for JS
add_filter( 'nav_menu_link_attributes', function( $atts, $item ) {
    $atts['data-item-id'] = $item->ID;
    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        $atts['data-has-children'] = 'true';
    }
    return $atts;
}, 10, 2 );
```

---

### nav_menu_item_title

Filters menu item title text.

```php
apply_filters( 'nav_menu_item_title', string $title, WP_Post $menu_item, stdClass $args, int $depth )
```

**Example:**

```php
add_filter( 'nav_menu_item_title', function( $title, $item, $args, $depth ) {
    // Add chevron to items with children
    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        $title .= ' <span class="chevron">▼</span>';
    }
    
    // Add badge to specific items
    if ( in_array( 'new-item', $item->classes ) ) {
        $title .= ' <span class="badge">New</span>';
    }
    
    return $title;
}, 10, 4 );
```

---

### nav_menu_attr_title

Filters title attribute of menu item link.

```php
apply_filters( 'nav_menu_attr_title', string $item_title )
```

---

### nav_menu_description

Filters menu item description.

```php
apply_filters( 'nav_menu_description', string $description )
```

---

### walker_nav_menu_start_el

Filters complete menu item HTML output.

```php
apply_filters( 'walker_nav_menu_start_el', string $item_output, WP_Post $menu_item, int $depth, stdClass $args )
```

**Parameters:**

- `$item_output` - HTML including `$args->before`, `<a>`, title, `</a>`, `$args->after`
- `$menu_item` - Current menu item
- `$depth` - Menu depth
- `$args` - wp_nav_menu() arguments

**Example:**

```php
add_filter( 'walker_nav_menu_start_el', function( $output, $item, $depth, $args ) {
    // Add description below link
    if ( $depth === 0 && $item->description ) {
        $output .= '<p class="menu-item-description">' . esc_html( $item->description ) . '</p>';
    }
    
    // Wrap output for mega menu
    if ( in_array( 'mega-menu-col', $item->classes ) ) {
        $output = '<div class="mega-col">' . $output . '</div>';
    }
    
    return $output;
}, 10, 4 );
```

---

### nav_menu_submenu_css_class

Filters CSS classes for sub-menu `<ul>` element.

```php
apply_filters( 'nav_menu_submenu_css_class', array $classes, stdClass $args, int $depth )
```

**Default:** `array( 'sub-menu' )`

**Example:**

```php
add_filter( 'nav_menu_submenu_css_class', function( $classes, $args, $depth ) {
    $classes[] = 'dropdown-menu';
    $classes[] = 'level-' . ( $depth + 1 );
    return $classes;
}, 10, 3 );
```

---

### nav_menu_submenu_attributes

Filters HTML attributes on sub-menu `<ul>` element.

```php
apply_filters( 'nav_menu_submenu_attributes', array $atts, stdClass $args, int $depth )
```

**Since:** WordPress 6.3.0

**Example:**

```php
add_filter( 'nav_menu_submenu_attributes', function( $atts, $args, $depth ) {
    $atts['data-depth'] = $depth;
    $atts['role'] = 'menu';
    return $atts;
}, 10, 3 );
```

---

## Menu Item Setup Filters

### pre_wp_setup_nav_menu_item

Short-circuits `wp_setup_nav_menu_item()`.

```php
apply_filters( 'pre_wp_setup_nav_menu_item', object|null $modified_menu_item, object $menu_item )
```

**Since:** WordPress 6.3.0

**Returns:** Non-null to skip normal setup.

---

### wp_setup_nav_menu_item

Filters menu item object after setup.

```php
apply_filters( 'wp_setup_nav_menu_item', object $menu_item )
```

**Example:**

```php
add_filter( 'wp_setup_nav_menu_item', function( $item ) {
    // Add custom property
    $item->is_external = ( strpos( $item->url, home_url() ) === false );
    
    // Modify URL
    if ( $item->object === 'page' && get_post_meta( $item->object_id, '_redirect_url', true ) ) {
        $item->url = get_post_meta( $item->object_id, '_redirect_url', true );
    }
    
    return $item;
} );
```

---

## Menu Retrieval Filters

### wp_get_nav_menu_object

Filters retrieved menu object.

```php
apply_filters( 'wp_get_nav_menu_object', WP_Term|false $menu_obj, int|string|WP_Term $menu )
```

---

### wp_get_nav_menus

Filters array of all nav menus.

```php
apply_filters( 'wp_get_nav_menus', WP_Term[] $menus, array $args )
```

---

### wp_get_nav_menu_items

Filters retrieved menu items.

```php
apply_filters( 'wp_get_nav_menu_items', array $items, object $menu, array $args )
```

**Example:**

```php
add_filter( 'wp_get_nav_menu_items', function( $items, $menu, $args ) {
    // Filter out private items for non-admins
    if ( ! current_user_can( 'manage_options' ) ) {
        $items = array_filter( $items, function( $item ) {
            return ! get_post_meta( $item->ID, '_menu_item_private', true );
        } );
    }
    return $items;
}, 10, 3 );
```

---

## Location Filters

### has_nav_menu

Filters whether location has a menu assigned.

```php
apply_filters( 'has_nav_menu', bool $has_nav_menu, string $location )
```

---

### wp_get_nav_menu_name

Filters menu name for a location.

```php
apply_filters( 'wp_get_nav_menu_name', string $menu_name, string $location )
```

---

## Menu Actions

### wp_create_nav_menu

Fires after a new menu is created.

```php
do_action( 'wp_create_nav_menu', int $term_id, array $menu_data )
```

---

### wp_update_nav_menu

Fires after a menu is updated.

```php
do_action( 'wp_update_nav_menu', int $menu_id, array $menu_data )
```

---

### wp_delete_nav_menu

Fires after a menu is deleted.

```php
do_action( 'wp_delete_nav_menu', int $term_id )
```

---

### wp_add_nav_menu_item

Fires after a new menu item is added.

```php
do_action( 'wp_add_nav_menu_item', int $menu_id, int $menu_item_db_id, array $args )
```

**Since:** WordPress 4.4.0

---

### wp_update_nav_menu_item

Fires after a menu item is updated.

```php
do_action( 'wp_update_nav_menu_item', int $menu_id, int $menu_item_db_id, array $args )
```

---

## Widget Filters

### widget_nav_menu_args

Filters wp_nav_menu() args from Navigation Menu widget.

```php
apply_filters( 'widget_nav_menu_args', array $nav_menu_args, WP_Term $nav_menu, array $args, array $instance )
```

**Example:**

```php
add_filter( 'widget_nav_menu_args', function( $nav_menu_args, $nav_menu, $widget_args, $instance ) {
    // Use custom walker for widget menus
    $nav_menu_args['walker'] = new Widget_Nav_Walker();
    
    // Add widget-specific class
    $nav_menu_args['menu_class'] .= ' widget-menu';
    
    return $nav_menu_args;
}, 10, 4 );
```

---

### navigation_widgets_format

Filters HTML format for navigation widgets.

```php
apply_filters( 'navigation_widgets_format', string $format )
```

**Default:** `'html5'` if theme supports it, otherwise `'xhtml'`

---

## Common Hook Patterns

### Remove Default Classes

```php
add_filter( 'nav_menu_css_class', function( $classes ) {
    return array_intersect( $classes, array(
        'menu-item',
        'current-menu-item',
        'current-menu-parent',
        'current-menu-ancestor',
        'menu-item-has-children',
    ) );
} );

add_filter( 'nav_menu_item_id', '__return_empty_string' );
```

### Add Bootstrap Classes

```php
add_filter( 'nav_menu_css_class', function( $classes, $item, $args, $depth ) {
    if ( $args->theme_location === 'primary' ) {
        $classes[] = 'nav-item';
        if ( $item->current ) {
            $classes[] = 'active';
        }
    }
    return $classes;
}, 10, 4 );

add_filter( 'nav_menu_link_attributes', function( $atts, $item, $args ) {
    if ( $args->theme_location === 'primary' ) {
        $atts['class'] = 'nav-link';
    }
    return $atts;
}, 10, 3 );

add_filter( 'nav_menu_submenu_css_class', function( $classes ) {
    $classes[] = 'dropdown-menu';
    return $classes;
} );
```

### Cache Menu Output

```php
add_filter( 'pre_wp_nav_menu', function( $output, $args ) {
    $cache_key = 'nav_menu_' . md5( serialize( $args ) );
    return get_transient( $cache_key );
}, 10, 2 );

add_filter( 'wp_nav_menu', function( $nav_menu, $args ) {
    $cache_key = 'nav_menu_' . md5( serialize( $args ) );
    set_transient( $cache_key, $nav_menu, HOUR_IN_SECONDS );
    return $nav_menu;
}, 10, 2 );

// Clear on menu update
add_action( 'wp_update_nav_menu', function() {
    global $wpdb;
    $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_nav_menu_%'" );
} );
```
