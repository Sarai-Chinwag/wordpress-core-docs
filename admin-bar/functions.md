# Admin Bar Functions

Functions for managing the WordPress admin bar, defined in `wp-includes/admin-bar.php`.

## Visibility Functions

### show_admin_bar()

Sets the display status of the admin bar globally.

```php
show_admin_bar( bool $show ): void
```

**Parameters:**
- `$show` (bool) - Whether to allow the admin bar to show

**Usage:**
```php
// Hide admin bar on front-end
show_admin_bar( false );

// Can be called immediately on plugin load
// Does not need to be hooked to 'init'
```

**Note:** This sets a global `$show_admin_bar` variable. The `show_admin_bar` filter is still applied.

---

### is_admin_bar_showing()

Determines whether the admin bar should be showing.

```php
is_admin_bar_showing(): bool
```

**Returns:** `true` if admin bar should show, `false` otherwise

**Automatic False Conditions:**
- XMLRPC requests (`XMLRPC_REQUEST` defined)
- AJAX requests (`DOING_AJAX` defined)
- iFrame requests (`IFRAME_REQUEST` defined)
- JSON requests (`wp_is_json_request()` returns true)
- Embedded content (`is_embed()` returns true)

**Usage:**
```php
if ( is_admin_bar_showing() ) {
    // Enqueue admin bar specific scripts
}
```

---

### _get_admin_bar_pref()

Retrieves the admin bar display preference of a user. **Private function.**

```php
_get_admin_bar_pref( string $context = 'front', int $user = 0 ): bool
```

**Parameters:**
- `$context` (string) - Preference context: 'front' (default). 'admin' is no longer used.
- `$user` (int) - User ID. Defaults to 0 (current user).

**Returns:** Whether admin bar should show for this user

---

## Initialization Functions

### _wp_admin_bar_init()

Instantiates the admin bar object and sets it up as a global. **Private function.**

```php
_wp_admin_bar_init(): bool
```

**Returns:** Whether the admin bar was successfully initialized

**Important:** Unhooking this function will NOT properly remove the admin bar. Use `show_admin_bar(false)` or the `show_admin_bar` filter instead.

**Process:**
1. Checks `is_admin_bar_showing()`
2. Applies `wp_admin_bar_class` filter to get class name
3. Instantiates the class
4. Calls `initialize()` and `add_menus()`

---

### wp_admin_bar_render()

Renders the admin bar to the page.

```php
wp_admin_bar_render(): void
```

**Hook Locations:**
- Called on `wp_body_open` action (primary)
- Called on `wp_footer` action (fallback for older themes)

**Fires Actions:**
1. `admin_bar_menu` - Add/modify menu items
2. `wp_before_admin_bar_render` - Before rendering
3. `wp_after_admin_bar_render` - After rendering

**Note:** Only renders once per request (uses static `$rendered` flag).

---

## Core Menu Functions

These functions add the default admin bar menus. All accept `WP_Admin_Bar $wp_admin_bar` as parameter.

### wp_admin_bar_wp_menu()

Adds the WordPress logo menu with About, Documentation, and Support links.

```php
wp_admin_bar_wp_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 10

**Nodes Created:**
- `wp-logo` - Main logo node
- `about` - About WordPress
- `contribute` - Get Involved
- `wp-logo-external` - Group for external links
- `wporg` - WordPress.org
- `documentation` - Documentation
- `learn` - Learn WordPress
- `support-forums` - Support
- `feedback` - Feedback

---

### wp_admin_bar_sidebar_toggle()

Adds the sidebar toggle button (admin only).

```php
wp_admin_bar_sidebar_toggle( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 0

**Nodes Created:**
- `menu-toggle` - Toggle button

---

### wp_admin_bar_my_account_item()

Adds the "My Account" top-level item with avatar.

```php
wp_admin_bar_my_account_item( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 9991

**Nodes Created:**
- `my-account` - Parent in `top-secondary` group

---

### wp_admin_bar_my_account_menu()

Adds the "My Account" submenu items.

```php
wp_admin_bar_my_account_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 0

**Nodes Created:**
- `user-actions` - Group
- `user-info` - User avatar and name
- `logout` - Log Out link

---

### wp_admin_bar_site_menu()

Adds the "Site Name" menu with Dashboard/Visit Site links.

```php
wp_admin_bar_site_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 30

**Nodes Created:**
- `site-name` - Main site node
- `view-site` / `dashboard` - Context-dependent link
- `edit-site` - Manage Site (multisite)
- Calls `wp_admin_bar_appearance_menu()` on front-end

---

### wp_admin_bar_appearance_menu()

Adds appearance submenu items to the Site Name menu.

```php
wp_admin_bar_appearance_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Nodes Created:**
- `appearance` - Group
- `themes` - Themes link
- `widgets` - Widgets link
- `menus` - Menus link
- `background` - Custom Background
- `header` - Custom Header

---

### wp_admin_bar_edit_site_menu()

Adds "Edit Site" link for block themes (Site Editor).

```php
wp_admin_bar_edit_site_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 40

**Conditions:**
- Block theme must be active (`wp_is_block_theme()`)
- User must have `edit_theme_options` capability
- Must be on front-end (not admin)

**Nodes Created:**
- `site-editor` - Edit Site link with current template

---

### wp_admin_bar_customize_menu()

Adds the "Customize" link.

```php
wp_admin_bar_customize_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 40

**Conditions:**
- For block themes, only shows if plugins use customizer
- User must have `customize` capability
- Must be on front-end

**Nodes Created:**
- `customize` - Customize link with return URL

---

### wp_admin_bar_my_sites_menu()

Adds "My Sites" menu for multisite installations.

```php
wp_admin_bar_my_sites_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 20

**Conditions:**
- User must be logged in
- Must be multisite installation
- User must have at least one site OR be super admin

**Nodes Created:**
- `my-sites` - Main node
- `my-sites-super-admin` - Group for network admin links
- `network-admin` - Network Admin with subitems
- `my-sites-list` - Group for site list
- `blog-{id}` - Individual site nodes with subitems

---

### wp_admin_bar_shortlink_menu()

Provides a shortlink input for the current page.

```php
wp_admin_bar_shortlink_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Nodes Created:**
- `get-shortlink` - Shortlink with input field in meta HTML

---

### wp_admin_bar_edit_menu()

Provides Edit/View links for posts and terms.

```php
wp_admin_bar_edit_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 80

**Context-Aware Behavior:**
- **Admin (post editor):** View/Preview post link
- **Admin (post list):** View archive link
- **Admin (term editor):** View term link
- **Admin (user editor):** View user link
- **Front-end (single post):** Edit post link
- **Front-end (term archive):** Edit term link
- **Front-end (author page):** Edit user link

**Nodes Created:**
- `edit` / `view` / `preview` / `archive` - Context-dependent

---

### wp_admin_bar_new_content_menu()

Adds "Add New" menu for creating new content.

```php
wp_admin_bar_new_content_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 70

**Nodes Created:**
- `new-content` - Main "New" node
- `new-post` - New Post
- `new-media` - New Media
- `new-link` - New Link
- `new-page` - New Page
- `new-{cpt}` - Custom post types with `show_in_admin_bar = true`
- `new-user` - New User
- `add-new-site` - New Site (multisite super admins)

---

### wp_admin_bar_comments_menu()

Adds edit comments link with moderation count bubble.

```php
wp_admin_bar_comments_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 60

**Conditions:**
- User must have `edit_posts` capability

**Nodes Created:**
- `comments` - Comments link with pending count

---

### wp_admin_bar_updates_menu()

Provides update link if updates are available.

```php
wp_admin_bar_updates_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 50

**Conditions:**
- Must have available updates

**Nodes Created:**
- `updates` - Updates link with count

---

### wp_admin_bar_recovery_mode_menu()

Adds link to exit recovery mode when active.

```php
wp_admin_bar_recovery_mode_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 9992

**Conditions:**
- Recovery mode must be active (`wp_is_recovery_mode()`)

**Nodes Created:**
- `recovery-mode` - Exit Recovery Mode link

---

### wp_admin_bar_search_menu()

Adds search form to admin bar.

```php
wp_admin_bar_search_menu( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 9999

**Conditions:**
- Only on front-end (not admin)

**Nodes Created:**
- `search` - Search form in `top-secondary` group

---

### wp_admin_bar_add_secondary_groups()

Adds secondary (right-aligned) groups.

```php
wp_admin_bar_add_secondary_groups( WP_Admin_Bar $wp_admin_bar ): void
```

**Priority:** 200

**Groups Created:**
- `top-secondary` - Right-aligned top-level group
- `wp-logo-external` - External links under WP logo

---

## Style Functions

### wp_enqueue_admin_bar_header_styles()

Enqueues inline style to hide admin bar when printing.

```php
wp_enqueue_admin_bar_header_styles(): void
```

**CSS Added:**
```css
@media print { #wpadminbar { display:none; } }
```

---

### wp_enqueue_admin_bar_bump_styles()

Enqueues inline bump styles to make room for admin bar.

```php
wp_enqueue_admin_bar_bump_styles(): void
```

**CSS Added:**
```css
@media screen { html { margin-top: 32px !important; } }
@media screen and ( max-width: 782px ) { html { margin-top: 46px !important; } }
```

---

## Adding Custom Items

### Using admin_bar_menu Hook

```php
add_action( 'admin_bar_menu', 'my_custom_admin_bar_items', 100 );

function my_custom_admin_bar_items( $wp_admin_bar ) {
    // Add a top-level item
    $wp_admin_bar->add_node( array(
        'id'    => 'my-custom-menu',
        'title' => 'My Menu',
        'href'  => admin_url( 'options-general.php' ),
        'meta'  => array(
            'title' => 'Settings Page',
        ),
    ) );
    
    // Add a child item
    $wp_admin_bar->add_node( array(
        'parent' => 'my-custom-menu',
        'id'     => 'my-custom-submenu',
        'title'  => 'Submenu Item',
        'href'   => admin_url( 'options-general.php?page=my-settings' ),
    ) );
}
```

### Removing Items

```php
add_action( 'admin_bar_menu', 'remove_admin_bar_items', 999 );

function remove_admin_bar_items( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
    $wp_admin_bar->remove_node( 'comments' );
    $wp_admin_bar->remove_node( 'updates' );
}
```

### Using wp_before_admin_bar_render

For modifications without needing a specific priority:

```php
add_action( 'wp_before_admin_bar_render', 'modify_admin_bar' );

function modify_admin_bar() {
    global $wp_admin_bar;
    
    // Get existing node
    $node = $wp_admin_bar->get_node( 'site-name' );
    
    // Modify and re-add
    if ( $node ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'site-name',
            'title' => 'Custom Title',
        ) );
    }
}
```
