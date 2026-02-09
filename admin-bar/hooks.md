# Admin Bar Hooks

Filters and actions for customizing the WordPress admin bar.

## Actions

### admin_bar_init

Fires after `WP_Admin_Bar` is initialized.

```php
do_action( 'admin_bar_init' );
```

**Location:** `WP_Admin_Bar::initialize()`

**Timing:** After user data populated, scripts/styles enqueued, before menus added

**Usage:**
```php
add_action( 'admin_bar_init', 'my_admin_bar_init' );

function my_admin_bar_init() {
    // Early initialization tasks
    // Note: $wp_admin_bar is not passed to this action
}
```

---

### admin_bar_menu

Loads all admin bar items. Primary hook for adding/removing nodes.

```php
do_action_ref_array( 'admin_bar_menu', array( &$wp_admin_bar ) );
```

**Location:** `wp_admin_bar_render()`

**Timing:** During render, after `add_menus()`, before `_bind()`

**Parameters:**
- `$wp_admin_bar` (WP_Admin_Bar) - Passed by reference

**Usage:**
```php
add_action( 'admin_bar_menu', 'my_admin_bar_items', 100 );

function my_admin_bar_items( $wp_admin_bar ) {
    $wp_admin_bar->add_node( array(
        'id'    => 'my-custom-item',
        'title' => 'My Item',
        'href'  => '#',
    ) );
}
```

**Priority Guidelines:**
| Priority | Use Case |
|----------|----------|
| 0-10 | Before WordPress logo |
| 10-30 | With site menus |
| 30-70 | Content area |
| 70-200 | After core menus |
| 200+ | Secondary items |
| 999+ | For removing existing items |

---

### add_admin_bar_menus

Fires after default menus are added via `add_menus()`.

```php
do_action( 'add_admin_bar_menus' );
```

**Location:** `WP_Admin_Bar::add_menus()`

**Timing:** After all `add_action( 'admin_bar_menu', ... )` calls in `add_menus()`

**Usage:**
```php
add_action( 'add_admin_bar_menus', 'remove_default_admin_bar_menus' );

function remove_default_admin_bar_menus() {
    // Remove specific menu callbacks before they run
    remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
    remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 70 );
}
```

---

### wp_before_admin_bar_render

Fires immediately before the admin bar is rendered.

```php
do_action( 'wp_before_admin_bar_render' );
```

**Location:** `wp_admin_bar_render()`

**Timing:** After `admin_bar_menu` action, before `render()`

**Global Available:** `$wp_admin_bar`

**Usage:**
```php
add_action( 'wp_before_admin_bar_render', 'final_admin_bar_modifications' );

function final_admin_bar_modifications() {
    global $wp_admin_bar;
    
    // Last chance to modify nodes before rendering
    $wp_admin_bar->remove_node( 'updates' );
    
    // Modify existing node
    $site_name = $wp_admin_bar->get_node( 'site-name' );
    if ( $site_name ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'site-name',
            'title' => '🏠 ' . $site_name->title,
        ) );
    }
}
```

**Best For:** Modifications that don't need a specific priority

---

### wp_after_admin_bar_render

Fires immediately after the admin bar is rendered.

```php
do_action( 'wp_after_admin_bar_render' );
```

**Location:** `wp_admin_bar_render()`

**Timing:** After HTML output complete

**Usage:**
```php
add_action( 'wp_after_admin_bar_render', 'after_admin_bar_output' );

function after_admin_bar_output() {
    // Output additional content after admin bar
    echo '<style>#wpadminbar { background: #23282d; }</style>';
}
```

---

## Filters

### show_admin_bar

Filters whether to show the admin bar.

```php
$show_admin_bar = apply_filters( 'show_admin_bar', $show_admin_bar );
```

**Location:** `is_admin_bar_showing()`

**Parameters:**
- `$show_admin_bar` (bool) - Default based on user preference and context

**Returns:** bool

**Usage:**
```php
// Hide admin bar for subscribers
add_filter( 'show_admin_bar', 'hide_admin_bar_for_subscribers' );

function hide_admin_bar_for_subscribers( $show ) {
    if ( current_user_can( 'subscriber' ) ) {
        return false;
    }
    return $show;
}

// Hide on specific pages
add_filter( 'show_admin_bar', 'hide_admin_bar_on_landing_pages' );

function hide_admin_bar_on_landing_pages( $show ) {
    if ( is_page( 'landing-page' ) ) {
        return false;
    }
    return $show;
}

// Always show (override user preference)
add_filter( 'show_admin_bar', '__return_true' );

// Always hide
add_filter( 'show_admin_bar', '__return_false' );
```

---

### wp_admin_bar_class

Filters the admin bar class to instantiate.

```php
$admin_bar_class = apply_filters( 'wp_admin_bar_class', 'WP_Admin_Bar' );
```

**Location:** `_wp_admin_bar_init()`

**Parameters:**
- `$wp_admin_bar_class` (string) - Class name. Default 'WP_Admin_Bar'

**Returns:** string (class name)

**Usage:**
```php
add_filter( 'wp_admin_bar_class', 'use_custom_admin_bar' );

function use_custom_admin_bar( $class ) {
    require_once 'class-my-admin-bar.php';
    return 'My_Admin_Bar';
}

class My_Admin_Bar extends WP_Admin_Bar {
    public function render() {
        // Custom rendering
        parent::render();
    }
}
```

---

### wp_admin_bar_show_site_icons

Filters whether to show site icons in the "My Sites" menu.

```php
$show_site_icons = apply_filters( 'wp_admin_bar_show_site_icons', true );
```

**Location:** `wp_admin_bar_my_sites_menu()`

**Parameters:**
- `$show_site_icons` (bool) - Default true

**Returns:** bool

**Context:** Multisite only

**Usage:**
```php
// Disable for performance on large multisites
add_filter( 'wp_admin_bar_show_site_icons', '__return_false' );

// Conditional based on network size
add_filter( 'wp_admin_bar_show_site_icons', 'conditional_site_icons' );

function conditional_site_icons( $show ) {
    // Disable if user has more than 50 sites
    $user_blogs = get_blogs_of_user( get_current_user_id() );
    if ( count( $user_blogs ) > 50 ) {
        return false;
    }
    return $show;
}
```

---

## Related Hooks

### wp_head / admin_head

Admin bar adds callbacks to these hooks during initialization:

```php
add_action( 'wp_head', 'wp_admin_bar_header' );
add_action( 'admin_head', 'wp_admin_bar_header' );
```

---

### wp_body_open / wp_footer

Admin bar renders on these hooks:

```php
// Primary (if theme supports)
add_action( 'wp_body_open', 'wp_admin_bar_render', 0 );

// Fallback for older themes
add_action( 'wp_footer', 'wp_admin_bar_render' );
```

---

## Hook Execution Order

```
1. wp_loaded
   └── _wp_admin_bar_init()
       ├── wp_admin_bar_class filter
       ├── WP_Admin_Bar::initialize()
       │   └── admin_bar_init action
       └── WP_Admin_Bar::add_menus()
           └── add_admin_bar_menus action

2. wp_body_open or wp_footer
   └── wp_admin_bar_render()
       ├── admin_bar_menu action (all menu callbacks run)
       ├── wp_before_admin_bar_render action
       ├── WP_Admin_Bar::render()
       └── wp_after_admin_bar_render action
```

---

## Common Patterns

### Remove Multiple Items

```php
add_action( 'admin_bar_menu', 'cleanup_admin_bar', 999 );

function cleanup_admin_bar( $wp_admin_bar ) {
    $remove = array(
        'wp-logo',
        'about',
        'wporg',
        'documentation',
        'support-forums',
        'feedback',
        'comments',
        'updates',
        'new-content',
    );
    
    foreach ( $remove as $id ) {
        $wp_admin_bar->remove_node( $id );
    }
}
```

### Role-Based Menu Items

```php
add_action( 'admin_bar_menu', 'role_based_admin_bar', 100 );

function role_based_admin_bar( $wp_admin_bar ) {
    $user = wp_get_current_user();
    
    if ( in_array( 'administrator', $user->roles ) ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'admin-tools',
            'title' => 'Admin Tools',
            'href'  => admin_url( 'tools.php' ),
        ) );
    }
    
    if ( in_array( 'editor', $user->roles ) ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'pending-posts',
            'title' => 'Pending Posts',
            'href'  => admin_url( 'edit.php?post_status=pending' ),
        ) );
    }
}
```

### Complete Removal with Prevention

```php
// Remove all default actions
add_action( 'add_admin_bar_menus', 'remove_all_admin_bar_menus' );

function remove_all_admin_bar_menus() {
    remove_all_actions( 'admin_bar_menu' );
}

// Then add only what you want
add_action( 'admin_bar_menu', 'minimal_admin_bar', 10 );

function minimal_admin_bar( $wp_admin_bar ) {
    $wp_admin_bar->add_node( array(
        'id'    => 'site-name',
        'title' => get_bloginfo( 'name' ),
        'href'  => home_url(),
    ) );
    
    $wp_admin_bar->add_node( array(
        'parent' => 'top-secondary',
        'id'     => 'logout',
        'title'  => 'Log Out',
        'href'   => wp_logout_url(),
    ) );
}
```

### Dynamic Menu Based on Page Context

```php
add_action( 'admin_bar_menu', 'context_aware_admin_bar', 80 );

function context_aware_admin_bar( $wp_admin_bar ) {
    if ( is_singular( 'product' ) ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'woo-actions',
            'title' => 'Product Actions',
        ) );
        
        $wp_admin_bar->add_node( array(
            'parent' => 'woo-actions',
            'id'     => 'duplicate-product',
            'title'  => 'Duplicate',
            'href'   => admin_url( 'admin.php?action=duplicate&product=' . get_the_ID() ),
        ) );
    }
    
    if ( is_archive() ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'archive-count',
            'title' => sprintf( '%d posts', $GLOBALS['wp_query']->found_posts ),
        ) );
    }
}
```

### Add External Links Group

```php
add_action( 'admin_bar_menu', 'add_external_links', 100 );

function add_external_links( $wp_admin_bar ) {
    $wp_admin_bar->add_node( array(
        'id'    => 'external-links',
        'title' => 'Resources',
    ) );
    
    $wp_admin_bar->add_group( array(
        'parent' => 'external-links',
        'id'     => 'external-links-main',
    ) );
    
    $links = array(
        'analytics' => array( 'Google Analytics', 'https://analytics.google.com/' ),
        'gsc'       => array( 'Search Console', 'https://search.google.com/search-console' ),
        'pagespeed' => array( 'PageSpeed', 'https://pagespeed.web.dev/' ),
    );
    
    foreach ( $links as $id => $link ) {
        $wp_admin_bar->add_node( array(
            'parent' => 'external-links-main',
            'id'     => 'external-' . $id,
            'title'  => $link[0],
            'href'   => $link[1],
            'meta'   => array(
                'target' => '_blank',
                'rel'    => 'noopener noreferrer',
            ),
        ) );
    }
}
```
