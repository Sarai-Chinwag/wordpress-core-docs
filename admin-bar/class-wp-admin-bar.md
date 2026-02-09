# WP_Admin_Bar Class

Core class implementing the Toolbar API. Defined in `wp-includes/class-wp-admin-bar.php`.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Admin_Bar {
    private $nodes = array();
    private $bound = false;
    public $user;
    public $menu = array(); // Deprecated since 3.3.0
}
```

## Properties

### $nodes (private)

Internal storage for all admin bar nodes.

```php
private $nodes = array();
```

**Type:** `array` of node objects

---

### $bound (private)

Flag indicating whether the node tree has been bound.

```php
private $bound = false;
```

**Type:** `bool`

Once bound, nodes cannot be retrieved or modified.

---

### $user (public)

User data object populated during initialization.

```php
public $user;
```

**Type:** `stdClass` with properties:
- `blogs` - Array of user's blogs (`get_blogs_of_user()`)
- `active_blog` - User's active blog object
- `domain` - User's home domain
- `account_domain` - Account domain URL

---

### $menu (public, deprecated)

Legacy menu property.

```php
public $menu = array();
```

**Deprecated:** Since 3.3.0. Use `get_node()`, `add_node()`, `remove_node()` instead.

---

## Public Methods

### initialize()

Initializes the admin bar.

```php
public function initialize(): void
```

**Actions Performed:**
1. Creates user data object
2. Populates user blogs and domain info
3. Adds `wp_admin_bar_header` action to `wp_head` and `admin_head`
4. Adds bump callback to `wp_head`
5. Enqueues `admin-bar` script and style
6. Fires `admin_bar_init` action

**Usage:**
```php
// Called automatically by _wp_admin_bar_init()
$wp_admin_bar->initialize();
```

---

### add_menus()

Adds all default menus to the admin bar.

```php
public function add_menus(): void
```

**Hooks Added:**
| Priority | Function | Menu |
|----------|----------|------|
| 0 | `wp_admin_bar_my_account_menu` | My Account submenu |
| 0 | `wp_admin_bar_sidebar_toggle` | Menu toggle |
| 10 | `wp_admin_bar_wp_menu` | WordPress logo |
| 20 | `wp_admin_bar_my_sites_menu` | My Sites |
| 30 | `wp_admin_bar_site_menu` | Site Name |
| 40 | `wp_admin_bar_edit_site_menu` | Edit Site |
| 40 | `wp_admin_bar_customize_menu` | Customize |
| 50 | `wp_admin_bar_updates_menu` | Updates |
| 60 | `wp_admin_bar_comments_menu` | Comments |
| 70 | `wp_admin_bar_new_content_menu` | New |
| 80 | `wp_admin_bar_edit_menu` | Edit |
| 200 | `wp_admin_bar_add_secondary_groups` | Secondary groups |
| 9991 | `wp_admin_bar_my_account_item` | My Account |
| 9992 | `wp_admin_bar_recovery_mode_menu` | Recovery Mode |
| 9999 | `wp_admin_bar_search_menu` | Search |

**Fires:** `add_admin_bar_menus` action after menus are added

---

### add_node()

Adds a node (menu item) to the admin bar.

```php
public function add_node( array $args ): void
```

**Parameters:**

| Key | Type | Description |
|-----|------|-------------|
| `id` | string | **Required.** Unique identifier |
| `title` | string | Display text/HTML |
| `parent` | string | Parent node ID (default: 'root') |
| `href` | string | Link URL |
| `group` | bool | Whether node is a group (default: false) |
| `meta` | array | Additional attributes (see below) |

**Meta Array Options:**

| Key | Type | Description |
|-----|------|-------------|
| `class` | string | CSS class(es) |
| `html` | string | Extra HTML after item |
| `onclick` | string | JavaScript onclick handler |
| `target` | string | Link target (_blank, etc.) |
| `title` | string | Tooltip text |
| `rel` | string | Link rel attribute |
| `lang` | string | Language code |
| `dir` | string | Text direction (ltr/rtl) |
| `tabindex` | int | Tab index value |
| `menu_title` | string | ARIA menu name (since 6.5.0) |

**Usage:**
```php
$wp_admin_bar->add_node( array(
    'id'     => 'my-plugin',
    'title'  => '<span class="ab-icon dashicons-admin-plugins"></span> My Plugin',
    'href'   => admin_url( 'plugins.php' ),
    'parent' => 'top-secondary',
    'meta'   => array(
        'class' => 'my-plugin-node',
        'title' => 'Manage My Plugin',
    ),
) );
```

**Node Merging:** If a node with the same ID already exists, the new values are merged with existing values.

**Back-Compat Parents:** Automatically converts deprecated parent IDs:
- `my-account-with-avatar` → `my-account` (3.3)
- `my-blogs` → `my-sites` (3.3)

---

### add_menu()

Alias for `add_node()`.

```php
public function add_menu( array $node ): void
```

---

### add_group()

Adds a group node to organize items.

```php
final public function add_group( array $args ): void
```

**Parameters:**

| Key | Type | Description |
|-----|------|-------------|
| `id` | string | **Required.** Group identifier |
| `parent` | string | Parent node ID (default: 'root') |
| `meta` | array | Supports 'class', 'onclick', 'target', 'title' |

**Usage:**
```php
$wp_admin_bar->add_group( array(
    'id'     => 'my-plugin-actions',
    'parent' => 'my-plugin',
    'meta'   => array(
        'class' => 'ab-sub-secondary',
    ),
) );

// Add items to the group
$wp_admin_bar->add_node( array(
    'parent' => 'my-plugin-actions',
    'id'     => 'action-one',
    'title'  => 'Action One',
    'href'   => '#',
) );
```

**Group Classes:**
- `ab-top-menu` - Applied to root-level groups
- `ab-sub-secondary` - Secondary styling for subgroups

---

### remove_node()

Removes a node from the admin bar.

```php
public function remove_node( string $id ): void
```

**Parameters:**
- `$id` (string) - The ID of the node to remove

**Usage:**
```php
// Remove WordPress logo
$wp_admin_bar->remove_node( 'wp-logo' );

// Remove updates notification
$wp_admin_bar->remove_node( 'updates' );

// Remove search
$wp_admin_bar->remove_node( 'search' );
```

**Note:** Removing a parent node does NOT remove its children. Children become orphaned and attach to root.

---

### remove_menu()

Alias for `remove_node()`.

```php
public function remove_menu( string $id ): void
```

---

### get_node()

Gets a node by ID.

```php
final public function get_node( string $id ): object|void
```

**Parameters:**
- `$id` (string) - Node ID to retrieve

**Returns:** Cloned node object or void if not found

**Usage:**
```php
$node = $wp_admin_bar->get_node( 'site-name' );
if ( $node ) {
    echo $node->title;
    echo $node->href;
}
```

**Important:** Returns a clone to prevent direct modification. Use `add_node()` to update.

**Timing:** Returns void after `_bind()` is called (during render).

---

### get_nodes()

Gets all nodes.

```php
final public function get_nodes(): array|void
```

**Returns:** Array of cloned node objects or void

**Usage:**
```php
$nodes = $wp_admin_bar->get_nodes();
foreach ( $nodes as $node ) {
    error_log( 'Node: ' . $node->id );
}
```

**Timing:** Returns void after `_bind()` is called.

---

### render()

Renders the admin bar HTML.

```php
public function render(): void
```

**Process:**
1. Calls `_bind()` to build tree
2. Calls `_render()` to output HTML

**Output Structure:**
```html
<div id="wpadminbar" class="nojq nojs">
    <a class="screen-reader-shortcut" href="#wp-toolbar">Skip to toolbar</a>
    <div class="quicklinks" id="wp-toolbar" role="navigation" aria-label="Toolbar">
        <!-- Menu groups and items -->
    </div>
</div>
```

---

### recursive_render() (deprecated)

```php
public function recursive_render( string $id, object $node ): void
```

**Deprecated:** Since 3.3.0. Use `render()` or `_render_item()` instead.

---

## Protected Methods

### _set_node()

Internal method to set a node.

```php
final protected function _set_node( array $args ): void
```

---

### _get_node()

Internal method to get a node without cloning.

```php
final protected function _get_node( string $id ): object|void
```

---

### _get_nodes()

Internal method to get all nodes without cloning.

```php
final protected function _get_nodes(): array|void
```

---

### _unset_node()

Internal method to remove a node.

```php
final protected function _unset_node( string $id ): void
```

---

### _bind()

Binds nodes into a hierarchical tree.

```php
final protected function _bind(): object|void
```

**Process:**
1. Adds 'root' node
2. Sets `children` array and `type` property on all nodes
3. Orphaned items (no parent) attach to root
4. Wraps nested items in default groups
5. Wraps nested groups in containers
6. Sets `$this->bound = true`

**Returns:** Root node object

---

### _render()

Outputs the admin bar HTML.

```php
final protected function _render( object $root ): void
```

---

### _render_container()

Renders a container node (for nested groups).

```php
final protected function _render_container( object $node ): void
```

**Output:**
```html
<div id="wp-admin-bar-{container-id}" class="ab-group-container">
    <!-- Nested groups -->
</div>
```

---

### _render_group()

Renders a group node as a `<ul>`.

```php
final protected function _render_group( object $node, string|bool $menu_title = false ): void
```

**Output:**
```html
<ul role="menu" id="wp-admin-bar-{group-id}" class="{classes}" aria-label="{menu_title}">
    <!-- Child items -->
</ul>
```

---

### _render_item()

Renders an item node as an `<li>`.

```php
final protected function _render_item( object $node ): void
```

**Output (with link):**
```html
<li role="group" id="wp-admin-bar-{item-id}" class="menupop {classes}">
    <a class="ab-item" role="menuitem" href="{url}" aria-expanded="false">
        <span class="wp-admin-bar-arrow" aria-hidden="true"></span>
        {title}
    </a>
    <div class="ab-sub-wrapper">
        <!-- Child groups -->
    </div>
    {meta.html}
</li>
```

**Output (without link):**
```html
<li role="group" id="wp-admin-bar-{item-id}">
    <div class="ab-item ab-empty-item" role="menuitem">
        {title}
    </div>
</li>
```

---

## Extending WP_Admin_Bar

You can use a custom admin bar class:

```php
add_filter( 'wp_admin_bar_class', 'my_custom_admin_bar_class' );

function my_custom_admin_bar_class( $class ) {
    return 'My_Custom_Admin_Bar';
}

class My_Custom_Admin_Bar extends WP_Admin_Bar {
    
    public function render() {
        // Custom rendering logic
        parent::render();
    }
    
    public function add_node( $args ) {
        // Modify all nodes before adding
        $args['title'] = '🚀 ' . $args['title'];
        parent::add_node( $args );
    }
}
```

---

## Common Patterns

### Add Icon to Node

```php
$wp_admin_bar->add_node( array(
    'id'    => 'my-item',
    'title' => '<span class="ab-icon dashicons-admin-settings"></span>' .
               '<span class="ab-label">Settings</span>',
    'href'  => admin_url( 'options.php' ),
) );
```

### Add Separator Group

```php
$wp_admin_bar->add_group( array(
    'parent' => 'my-menu',
    'id'     => 'my-menu-secondary',
    'meta'   => array(
        'class' => 'ab-sub-secondary', // Adds visual separator
    ),
) );
```

### Conditional Nodes

```php
if ( current_user_can( 'manage_options' ) ) {
    $wp_admin_bar->add_node( array(
        'id'    => 'admin-only-item',
        'title' => 'Admin Only',
        'href'  => admin_url(),
    ) );
}
```

### Node with Custom HTML

```php
$wp_admin_bar->add_node( array(
    'id'    => 'custom-html',
    'title' => 'Custom',
    'meta'  => array(
        'html' => '<div class="my-custom-popup">
                      <p>Custom content here</p>
                   </div>',
    ),
) );
```
