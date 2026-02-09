# WP_Taxonomy

Core class used for interacting with taxonomies. Represents a registered taxonomy and its configuration.

**Source:** `wp-includes/class-wp-taxonomy.php`  
**Since:** 4.7.0

## Class Declaration

```php
#[AllowDynamicProperties]
final class WP_Taxonomy
```

---

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$name` | string | public | Taxonomy key |
| `$label` | string | public | Name shown in the menu. Usually plural |
| `$labels` | stdClass | public | Labels object for this taxonomy |
| `$description` | string | public | Short descriptive summary. Default `''` |
| `$public` | bool | public | Whether intended for public use. Default `true` |
| `$publicly_queryable` | bool | public | Whether publicly queryable. Default `true` |
| `$hierarchical` | bool | public | Whether hierarchical (like categories). Default `false` |
| `$show_ui` | bool | public | Whether to generate admin UI. Default `true` |
| `$show_in_menu` | bool | public | Whether to show in admin menu. Default `true` |
| `$show_in_nav_menus` | bool | public | Whether available in navigation menus. Default `true` |
| `$show_tagcloud` | bool | public | Whether to list in Tag Cloud Widget. Default `true` |
| `$show_in_quick_edit` | bool | public | Whether to show in quick/bulk edit. Default `true` |
| `$show_admin_column` | bool | public | Whether to show column on post type listing. Default `false` |
| `$meta_box_cb` | bool\|callable | public | Meta box display callback. Default `null` |
| `$meta_box_sanitize_cb` | callable | public | Meta box sanitization callback |
| `$object_type` | string[] | public | Array of object types registered for |
| `$cap` | stdClass | public | Capabilities object for this taxonomy |
| `$rewrite` | array\|false | public | Rewrites information |
| `$query_var` | string\|false | public | Query var string |
| `$update_count_callback` | callable | public | Count update callback |
| `$show_in_rest` | bool | public | Whether to include in REST API. Default `false` |
| `$rest_base` | string\|bool | public | REST API base path |
| `$rest_namespace` | string\|bool | public | REST API namespace. Default `'wp/v2'` |
| `$rest_controller_class` | string\|bool | public | REST controller class name |
| `$rest_controller` | WP_REST_Controller | public | Lazily computed REST controller instance |
| `$default_term` | array\|string | public | Default term configuration |
| `$sort` | bool\|null | public | Whether to maintain term order. Default `null` |
| `$args` | array\|null | public | Default args for `wp_get_object_terms()` |
| `$_builtin` | bool | public | Whether it is a built-in taxonomy |

---

## Static Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$default_labels` | (string\|null)[][] | protected | Cached default labels array |

---

## Methods

### __construct()

Constructor. Instantiates a taxonomy object.

```php
public function __construct( string $taxonomy, array|string $object_type, array|string $args = array() )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy key. Must not exceed 32 characters |
| `$object_type` | array\|string | Object type(s) for the taxonomy |
| `$args` | array\|string | Configuration arguments. See `register_taxonomy()` |

**Note:** Do not instantiate directly. Use `register_taxonomy()`.

---

### set_props()

Sets taxonomy properties.

```php
public function set_props( string|string[] $object_type, array|string $args ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string\|string[] | Object type name(s) |
| `$args` | array\|string | Configuration arguments |

**Filters Applied:**

- `register_taxonomy_args` — Filters registration arguments
- `register_{$taxonomy}_taxonomy_args` — Filters arguments for specific taxonomy

**Processing:**

1. Parses and applies default arguments
2. Sets `publicly_queryable` from `public` if not specified
3. Configures `query_var` and `rewrite` rules
4. Inherits `show_ui`, `show_in_menu`, `show_in_nav_menus`, `show_tagcloud`, `show_in_quick_edit` from defaults
5. Sets default capabilities
6. Configures meta box callbacks
7. Processes `default_term` configuration
8. Generates labels via `get_taxonomy_labels()`

---

### add_rewrite_rules()

Adds the necessary rewrite rules for the taxonomy.

```php
public function add_rewrite_rules(): void
```

**Behavior:**

- Adds query var if `query_var` is set and not in admin
- Adds rewrite tag and permastruct if `rewrite` is configured
- Uses hierarchical tag `(.+?)` or non-hierarchical `([^/]+)` based on settings

---

### remove_rewrite_rules()

Removes any rewrite rules, permastructs, and rules for the taxonomy.

```php
public function remove_rewrite_rules(): void
```

**Behavior:**

- Removes query var from `$wp->query_vars`
- Removes rewrite tag and permastruct

---

### add_hooks()

Registers the ajax callback for the meta box.

```php
public function add_hooks(): void
```

**Behavior:**

Adds filter `wp_ajax_add-{$taxonomy}` pointing to `_wp_ajax_add_hierarchical_term`.

---

### remove_hooks()

Removes the ajax callback for the meta box.

```php
public function remove_hooks(): void
```

**Behavior:**

Removes filter `wp_ajax_add-{$taxonomy}`.

---

### get_rest_controller()

Gets the REST API controller for this taxonomy.

```php
public function get_rest_controller(): WP_REST_Controller|null
```

**Returns:** Controller instance, or `null` if `show_in_rest` is `false`.

**Behavior:**

- Returns `null` if `show_in_rest` is falsy
- Uses `rest_controller_class` if set, otherwise `WP_REST_Terms_Controller`
- Validates class exists and extends `WP_REST_Controller`
- Lazily instantiates and caches controller

---

### get_default_labels()

Returns the default labels for taxonomies.

```php
public static function get_default_labels(): (string|null)[][]
```

**Returns:** Associative array of label keys to arrays of `[non-hierarchical, hierarchical]` values.

**Label Keys:**

| Key | Non-Hierarchical | Hierarchical |
|-----|------------------|--------------|
| `name` | Tags | Categories |
| `singular_name` | Tag | Category |
| `search_items` | Search Tags | Search Categories |
| `popular_items` | Popular Tags | `null` |
| `all_items` | All Tags | All Categories |
| `parent_item` | `null` | Parent Category |
| `parent_item_colon` | `null` | Parent Category: |
| `name_field_description` | (shared) | (shared) |
| `slug_field_description` | (shared) | (shared) |
| `parent_field_description` | `null` | (description) |
| `desc_field_description` | (shared) | (shared) |
| `edit_item` | Edit Tag | Edit Category |
| `view_item` | View Tag | View Category |
| `update_item` | Update Tag | Update Category |
| `add_new_item` | Add Tag | Add Category |
| `new_item_name` | New Tag Name | New Category Name |
| `separate_items_with_commas` | Separate tags with commas | `null` |
| `add_or_remove_items` | Add or remove tags | `null` |
| `choose_from_most_used` | Choose from the most used tags | `null` |
| `not_found` | No tags found. | No categories found. |
| `no_terms` | No tags | No categories |
| `filter_by_item` | `null` | Filter by category |
| `items_list_navigation` | Tags list navigation | Categories list navigation |
| `items_list` | Tags list | Categories list |
| `most_used` | Most Used | Most Used |
| `back_to_items` | ← Go to Tags | ← Go to Categories |
| `item_link` | Tag Link | Category Link |
| `item_link_description` | A link to a tag. | A link to a category. |

---

### reset_default_labels()

Resets the cache for the default labels.

```php
public static function reset_default_labels(): void
```

**Behavior:**

Clears `self::$default_labels` to force regeneration on next access.

---

## Capabilities Object

The `$cap` property contains:

| Property | Default | Description |
|----------|---------|-------------|
| `manage_terms` | `'manage_categories'` | Manage terms capability |
| `edit_terms` | `'manage_categories'` | Edit terms capability |
| `delete_terms` | `'manage_categories'` | Delete terms capability |
| `assign_terms` | `'edit_posts'` | Assign terms capability |

---

## Rewrite Configuration

When `$rewrite` is an array:

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `slug` | string | `$taxonomy` | URL slug |
| `with_front` | bool | `true` | Prepend with front base |
| `hierarchical` | bool | `false` | Hierarchical URL structure |
| `ep_mask` | int | `EP_NONE` | Endpoint mask |

---

## Usage Example

```php
// Taxonomy is created via register_taxonomy(), not directly
add_action( 'init', function() {
    register_taxonomy( 'genre', 'book', array(
        'labels' => array(
            'name' => 'Genres',
            'singular_name' => 'Genre',
        ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite' => array( 'slug' => 'book-genre' ),
    ) );
} );

// Get taxonomy object
$taxonomy = get_taxonomy( 'genre' );

// Access properties
echo $taxonomy->name;           // 'genre'
echo $taxonomy->labels->name;   // 'Genres'
echo $taxonomy->hierarchical;   // true

// Get REST controller
$controller = $taxonomy->get_rest_controller();
```
