# WP_Post_Type Class

Core class for interacting with post types.

**Since:** 4.6.0  
**Source:** `wp-includes/class-wp-post-type.php`

```php
final class WP_Post_Type {
    // ...
}
```

---

## Properties

### $name

Post type key.

```php
public string $name;
```

**Since:** 4.6.0

---

### $label

Name shown in the menu. Usually plural.

```php
public string $label;
```

**Since:** 4.6.0

---

### $labels

Labels object for this post type.

```php
public stdClass $labels;
```

**Since:** 4.6.0

See `get_post_type_labels()` for available label keys.

---

### $description

Short descriptive summary.

```php
public string $description = '';
```

**Since:** 4.6.0

---

### $public

Whether intended for public use.

```php
public bool $public = false;
```

**Since:** 4.6.0

Controls default values of `$exclude_from_search`, `$publicly_queryable`, `$show_ui`, and `$show_in_nav_menus`.

---

### $hierarchical

Whether hierarchical (like pages).

```php
public bool $hierarchical = false;
```

**Since:** 4.6.0

---

### $exclude_from_search

Whether to exclude from front-end search.

```php
public bool $exclude_from_search = null;
```

**Since:** 4.6.0

Default: opposite of `$public`.

---

### $publicly_queryable

Whether queries can be performed on the front end.

```php
public bool $publicly_queryable = null;
```

**Since:** 4.6.0

Default: value of `$public`.

Enables endpoints like:
- `?post_type={post_type_key}`
- `?{post_type_key}={single_post_slug}`
- `?{post_type_query_var}={single_post_slug}`

---

### $embeddable

Whether this post type is embeddable.

```php
public bool $embeddable = null;
```

**Since:** 6.8.0

Default: value of `$public`.

---

### $show_ui

Whether to generate admin UI.

```php
public bool $show_ui = null;
```

**Since:** 4.6.0

Default: value of `$public`.

---

### $show_in_menu

Where to show in admin menu.

```php
public bool|string $show_in_menu = null;
```

**Since:** 4.6.0

- `true`: Own top-level menu
- `false`: No menu
- String: Submenu of existing menu (e.g., `'tools.php'`)

Default: value of `$show_ui`.

---

### $show_in_nav_menus

Whether available in navigation menus.

```php
public bool $show_in_nav_menus = null;
```

**Since:** 4.6.0

Default: value of `$public`.

---

### $show_in_admin_bar

Whether available in admin bar.

```php
public bool $show_in_admin_bar = null;
```

**Since:** 4.6.0

Default: value of `$show_in_menu`.

---

### $menu_position

Position in admin menu.

```php
public int $menu_position = null;
```

**Since:** 4.6.0

Common positions:
- 5: Below Posts
- 10: Below Media
- 15: Below Links
- 20: Below Pages
- 25: Below Comments

---

### $menu_icon

Menu icon URL or Dashicon name.

```php
public string $menu_icon = null;
```

**Since:** 4.6.0

Options:
- Dashicon class: `'dashicons-book'`
- Base64 SVG data URI: `'data:image/svg+xml;base64,...'`
- `'none'`: Empty div for CSS icon

---

### $capability_type

Base string for building capabilities.

```php
public string $capability_type = 'post';
```

**Since:** 4.6.0

Can be array for alternative plurals: `array( 'story', 'stories' )`.

---

### $map_meta_cap

Whether to use internal meta capability handling.

```php
public bool $map_meta_cap = false;
```

**Since:** 4.6.0

---

### $register_meta_box_cb

Callback for meta box registration.

```php
public callable $register_meta_box_cb = null;
```

**Since:** 4.6.0

Use `remove_meta_box()` and `add_meta_box()` in callback.

---

### $taxonomies

Taxonomy identifiers for this post type.

```php
public string[] $taxonomies = array();
```

**Since:** 4.6.0

---

### $has_archive

Whether post type has archives.

```php
public bool|string $has_archive = false;
```

**Since:** 4.6.0

String value sets custom archive slug.

---

### $query_var

Query var key for this post type.

```php
public string|bool $query_var;
```

**Since:** 4.6.0

- `true`: Uses `$name`
- `false`: No query var
- String: Custom query var

---

### $can_export

Whether to allow export.

```php
public bool $can_export = true;
```

**Since:** 4.6.0

---

### $delete_with_user

Whether to delete posts when user is deleted.

```php
public bool $delete_with_user = null;
```

**Since:** 4.6.0

- `true`: Move to Trash
- `false`: Don't delete
- `null`: Trash if supports 'author'

---

### $template

Default block template.

```php
public array[] $template = array();
```

**Since:** 5.0.0

Each item: `array( 'block/name', array( 'attribute' => 'value' ) )`.

---

### $template_lock

Block template lock mode.

```php
public string|false $template_lock = false;
```

**Since:** 5.0.0

- `'all'`: No insert, move, or delete
- `'insert'`: Move only, no insert or delete
- `false`: Unlocked

---

### $_builtin

Whether this is a built-in post type.

```php
public bool $_builtin = false;
```

**Since:** 4.6.0

**Internal use only.**

---

### $_edit_link

URL segment for edit link.

```php
public string $_edit_link = 'post.php?post=%d';
```

**Since:** 4.6.0

**Internal use only.**

---

### $cap

Post type capabilities.

```php
public stdClass $cap;
```

**Since:** 4.6.0

---

### $rewrite

Rewrite rules configuration.

```php
public array|false $rewrite;
```

**Since:** 4.6.0

---

### $supports

Supported features.

```php
public array|bool $supports;
```

**Since:** 4.6.0

---

### $show_in_rest

Whether to include in REST API.

```php
public bool $show_in_rest;
```

**Since:** 4.7.4

Required for block editor support.

---

### $rest_base

REST API base path.

```php
public string|bool $rest_base;
```

**Since:** 4.7.4

---

### $rest_namespace

REST API namespace.

```php
public string|bool $rest_namespace;
```

**Since:** 5.9.0

Default: `'wp/v2'` when `$show_in_rest` is true.

---

### $rest_controller_class

REST API controller class.

```php
public string|bool $rest_controller_class;
```

**Since:** 4.7.4

Must extend `WP_REST_Controller`.

---

### $rest_controller

REST controller instance (lazy-loaded).

```php
public WP_REST_Controller $rest_controller;
```

**Since:** 5.3.0

Access via `get_rest_controller()`.

---

### $revisions_rest_controller_class

Revisions REST controller class.

```php
public string|bool $revisions_rest_controller_class;
```

**Since:** 6.4.0

---

### $revisions_rest_controller

Revisions REST controller instance.

```php
public WP_REST_Controller $revisions_rest_controller;
```

**Since:** 6.4.0

Access via `get_revisions_rest_controller()`.

---

### $autosave_rest_controller_class

Autosave REST controller class.

```php
public string|bool $autosave_rest_controller_class;
```

**Since:** 6.4.0

---

### $autosave_rest_controller

Autosave REST controller instance.

```php
public WP_REST_Controller $autosave_rest_controller;
```

**Since:** 6.4.0

Access via `get_autosave_rest_controller()`.

---

### $late_route_registration

Whether to register REST routes after autosave/revisions controllers.

```php
public bool $late_route_registration;
```

**Since:** 6.4.0

---

### $default_labels (protected static)

Cached default labels.

```php
protected static array $default_labels = array();
```

**Since:** 6.0.0

---

## Methods

### __construct()

Constructor. Initializes post type with provided arguments.

```php
public function __construct( string $post_type, array|string $args = array() )
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type key |
| `$args` | array\|string | Registration arguments |

---

### set_props()

Sets post type properties from arguments.

```php
public function set_props( array|string $args ): void
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array\|string | Registration arguments |

Applies filters:
- `register_post_type_args`
- `register_{$post_type}_post_type_args`

---

### add_supports()

Registers feature support.

```php
public function add_supports(): void
```

**Since:** 4.6.0

Processes `$supports` array and calls `add_post_type_support()` for each feature.

Note: `'editor'` support implies `'autosave'` support.

---

### add_rewrite_rules()

Adds rewrite rules for the post type.

```php
public function add_rewrite_rules(): void
```

**Since:** 4.6.0

Handles:
- Query var registration
- Rewrite tags
- Archive rules
- Pagination rules
- Permastruct

---

### register_meta_boxes()

Registers the meta box callback.

```php
public function register_meta_boxes(): void
```

**Since:** 4.6.0

Hooks `$register_meta_box_cb` to `add_meta_boxes_{$post_type}` action.

---

### add_hooks()

Adds action hooks for the post type.

```php
public function add_hooks(): void
```

**Since:** 4.6.0

Hooks `_future_post_hook` to `future_{$post_type}` action for scheduled posts.

---

### register_taxonomies()

Registers taxonomies for this post type.

```php
public function register_taxonomies(): void
```

**Since:** 4.6.0

Calls `register_taxonomy_for_object_type()` for each taxonomy in `$taxonomies`.

---

### remove_supports()

Removes feature support.

```php
public function remove_supports(): void
```

**Since:** 4.6.0

Clears `$_wp_post_type_features[$name]`.

---

### remove_rewrite_rules()

Removes rewrite rules, permastructs, and query vars.

```php
public function remove_rewrite_rules(): void
```

**Since:** 4.6.0

Also removes registered meta capabilities.

---

### unregister_meta_boxes()

Removes the meta box callback hook.

```php
public function unregister_meta_boxes(): void
```

**Since:** 4.6.0

---

### unregister_taxonomies()

Removes post type from all taxonomies.

```php
public function unregister_taxonomies(): void
```

**Since:** 4.6.0

---

### remove_hooks()

Removes action hooks for the post type.

```php
public function remove_hooks(): void
```

**Since:** 4.6.0

---

### get_rest_controller()

Gets the REST API controller instance.

```php
public function get_rest_controller(): ?WP_REST_Controller
```

**Since:** 5.3.0

#### Returns

Controller instance, or `null` if:
- `$show_in_rest` is false
- Controller class doesn't exist
- Controller doesn't extend `WP_REST_Controller`

---

### get_revisions_rest_controller()

Gets the revisions REST controller instance.

```php
public function get_revisions_rest_controller(): ?WP_REST_Controller
```

**Since:** 6.4.0

#### Returns

Controller instance, or `null` if:
- `$show_in_rest` is false
- Post type doesn't support `'revisions'`
- Controller class invalid

---

### get_autosave_rest_controller()

Gets the autosave REST controller instance.

```php
public function get_autosave_rest_controller(): ?WP_REST_Controller
```

**Since:** 6.4.0

#### Returns

Controller instance, or `null` if:
- `$show_in_rest` is false
- Post type doesn't support `'autosave'`
- Controller class invalid

---

### get_default_labels() (static)

Returns default labels for post types.

```php
public static function get_default_labels(): array
```

**Since:** 6.0.0

#### Returns

Array of label defaults, indexed by label key. Each value is `array( $non_hierarchical, $hierarchical )`.

---

### reset_default_labels() (static)

Clears the default labels cache.

```php
public static function reset_default_labels(): void
```

**Since:** 6.0.0

Called during `create_initial_post_types()` to allow translation switching.
