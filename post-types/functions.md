# Post Types API Functions

Core functions for post type registration and management.

**Source:** `wp-includes/post.php`

---

## register_post_type()

Registers a new post type. Must be called during the `init` action.

```php
register_post_type( string $post_type, array|string $args = array() ): WP_Post_Type|WP_Error
```

**Since:** 2.9.0  
**Since:** 4.6.0 Returns `WP_Post_Type` object instead of object/stdClass.

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type key. Max 20 characters, lowercase alphanumeric, dashes, underscores. |
| `$args` | array\|string | Configuration array |

### Args

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `label` | string | Value of `$labels['name']` | Name shown in menu (usually plural) |
| `labels` | array | `[]` | Array of labels. See `get_post_type_labels()` |
| `description` | string | `''` | Short descriptive summary |
| `public` | bool | `false` | Whether intended for public use |
| `hierarchical` | bool | `false` | Whether hierarchical (like pages) |
| `exclude_from_search` | bool | `!$public` | Exclude from front-end search |
| `publicly_queryable` | bool | `$public` | Allow front-end queries |
| `show_ui` | bool | `$public` | Generate admin UI |
| `show_in_menu` | bool\|string | `$show_ui` | Where to show in admin menu |
| `show_in_nav_menus` | bool | `$public` | Available in navigation menus |
| `show_in_admin_bar` | bool | `$show_in_menu` | Available in admin bar |
| `show_in_rest` | bool | `false` | Include in REST API (required for block editor) |
| `rest_base` | string | `$post_type` | REST API base URL |
| `rest_namespace` | string | `'wp/v2'` | REST API namespace |
| `rest_controller_class` | string | `'WP_REST_Posts_Controller'` | REST controller class |
| `menu_position` | int | `null` | Position in admin menu |
| `menu_icon` | string | `null` | Dashicon name or base64 SVG data URI |
| `capability_type` | string\|array | `'post'` | Base for capability generation |
| `capabilities` | array | `[]` | Custom capabilities |
| `map_meta_cap` | bool | `false` | Use internal meta capability handling |
| `supports` | array\|false | `['title', 'editor']` | Features to support |
| `register_meta_box_cb` | callable | `null` | Callback for meta box setup |
| `taxonomies` | array | `[]` | Taxonomies to register |
| `has_archive` | bool\|string | `false` | Enable archive pages |
| `rewrite` | bool\|array | `true` | Rewrite rules configuration |
| `query_var` | string\|bool | `$post_type` | Query var key |
| `can_export` | bool | `true` | Allow export |
| `delete_with_user` | bool | `null` | Delete posts when user deleted |
| `template` | array | `[]` | Default block template |
| `template_lock` | string\|false | `false` | Template lock: `'all'`, `'insert'`, or `false` |
| `embeddable` | bool | `$public` | Whether embeddable (since 6.8.0) |

### Supports Array

| Feature | Description |
|---------|-------------|
| `title` | Post title |
| `editor` | Content editor (implies `autosave`) |
| `author` | Author selection |
| `thumbnail` | Featured image |
| `excerpt` | Excerpt field |
| `trackbacks` | Trackbacks/pingbacks |
| `custom-fields` | Custom fields meta box |
| `comments` | Comments |
| `revisions` | Store revisions |
| `page-attributes` | Menu order, parent (hierarchical) |
| `post-formats` | Post format support |
| `autosave` | Autosave support |

### Rewrite Array

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `slug` | string | `$post_type` | Permalink slug |
| `with_front` | bool | `true` | Prepend front base |
| `feeds` | bool | `$has_archive` | Add feed rewrites |
| `pages` | bool | `true` | Add pagination rewrites |
| `ep_mask` | int | `EP_PERMALINK` | Endpoint mask |

### Returns

`WP_Post_Type` on success, `WP_Error` on failure.

### Example

```php
add_action( 'init', function() {
    register_post_type( 'book', array(
        'labels'             => array(
            'name'          => __( 'Books' ),
            'singular_name' => __( 'Book' ),
            'add_new_item'  => __( 'Add New Book' ),
            'edit_item'     => __( 'Edit Book' ),
        ),
        'public'             => true,
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'taxonomies'         => array( 'category', 'post_tag' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'books' ),
        'menu_icon'          => 'dashicons-book',
        'menu_position'      => 5,
    ) );
} );
```

---

## unregister_post_type()

Unregisters a post type. Cannot unregister built-in types.

```php
unregister_post_type( string $post_type ): true|WP_Error
```

**Since:** 4.5.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type to unregister |

### Returns

`true` on success, `WP_Error` on failure.

---

## get_post_type()

Retrieves the post type of a post.

```php
get_post_type( int|WP_Post|null $post = null ): string|false
```

**Since:** 2.1.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | int\|WP_Post\|null | Post ID or object. Default current post. |

### Returns

Post type string on success, `false` on failure.

---

## get_post_type_object()

Retrieves a post type object by name.

```php
get_post_type_object( string $post_type ): WP_Post_Type|null
```

**Since:** 3.0.0  
**Since:** 4.6.0 Returns `WP_Post_Type` instance.

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Registered post type name |

### Returns

`WP_Post_Type` object or `null` if not found.

---

## get_post_types()

Gets all registered post type objects.

```php
get_post_types( array|string $args = array(), string $output = 'names', string $operator = 'and' ): string[]|WP_Post_Type[]
```

**Since:** 2.9.0

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$args` | array\|string | `[]` | Arguments to filter by |
| `$output` | string | `'names'` | `'names'` or `'objects'` |
| `$operator` | string | `'and'` | `'and'`, `'or'`, or `'not'` |

### Returns

Array of post type names or `WP_Post_Type` objects.

### Example

```php
// Get all public post types
$public_types = get_post_types( array( 'public' => true ), 'objects' );

// Get all post types with REST API support
$rest_types = get_post_types( array( 'show_in_rest' => true ) );
```

---

## post_type_exists()

Checks if a post type is registered.

```php
post_type_exists( string $post_type ): bool
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type name |

### Returns

`true` if registered, `false` otherwise.

---

## is_post_type_hierarchical()

Checks if a post type is hierarchical.

```php
is_post_type_hierarchical( string $post_type ): bool
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type name |

### Returns

`true` if hierarchical, `false` otherwise.

---

## is_post_type_viewable()

Determines if a post type is considered "viewable".

```php
is_post_type_viewable( string|WP_Post_Type $post_type ): bool
```

**Since:** 4.4.0  
**Since:** 5.9.0 Added `is_post_type_viewable` filter.

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string\|WP_Post_Type | Post type name or object |

### Returns

`true` if viewable, `false` otherwise.

---

## get_post_type_capabilities()

Builds capabilities object from post type args.

```php
get_post_type_capabilities( object $args ): object
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | object | Post type registration args |

### Returns

Object with capability properties:

| Capability | Description |
|------------|-------------|
| `edit_post` | Meta capability for editing |
| `read_post` | Meta capability for reading |
| `delete_post` | Meta capability for deleting |
| `edit_posts` | Edit posts of this type |
| `edit_others_posts` | Edit others' posts |
| `delete_posts` | Delete posts |
| `publish_posts` | Publish posts |
| `read_private_posts` | Read private posts |
| `create_posts` | Create new posts |

---

## get_post_type_labels()

Builds labels object for a post type.

```php
get_post_type_labels( object|WP_Post_Type $post_type_object ): object
```

**Since:** 3.0.0

### Label Keys

| Key | Description |
|-----|-------------|
| `name` | General name (plural) |
| `singular_name` | Singular name |
| `add_new` | Add new label |
| `add_new_item` | Add new item |
| `edit_item` | Edit item |
| `new_item` | New item |
| `view_item` | View item |
| `view_items` | View items |
| `search_items` | Search items |
| `not_found` | Not found |
| `not_found_in_trash` | Not found in trash |
| `parent_item_colon` | Parent item (hierarchical) |
| `all_items` | All items |
| `archives` | Archives |
| `attributes` | Attributes |
| `insert_into_item` | Insert into item |
| `uploaded_to_this_item` | Uploaded to this item |
| `featured_image` | Featured image |
| `set_featured_image` | Set featured image |
| `remove_featured_image` | Remove featured image |
| `use_featured_image` | Use as featured image |
| `menu_name` | Menu name |
| `filter_items_list` | Filter items list |
| `filter_by_date` | Filter by date |
| `items_list_navigation` | Items list navigation |
| `items_list` | Items list |
| `item_published` | Item published |
| `item_published_privately` | Item published privately |
| `item_reverted_to_draft` | Item reverted to draft |
| `item_trashed` | Item trashed (since 6.3.0) |
| `item_scheduled` | Item scheduled |
| `item_updated` | Item updated |
| `item_link` | Item link |
| `item_link_description` | Item link description |
| `template_name` | Template name (since 6.6.0) |

---

## add_post_type_support()

Registers feature support for a post type.

```php
add_post_type_support( string $post_type, string|array $feature, mixed ...$args ): void
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type |
| `$feature` | string\|array | Feature(s) to add |
| `...$args` | mixed | Additional feature arguments |

### Example

```php
add_post_type_support( 'page', 'excerpt' );
add_post_type_support( 'my_cpt', array( 'thumbnail', 'comments' ) );
add_post_type_support( 'my_cpt', 'custom_feature', array( 'option' => 'value' ) );
```

---

## remove_post_type_support()

Removes feature support from a post type.

```php
remove_post_type_support( string $post_type, string $feature ): void
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type |
| `$feature` | string | Feature to remove |

### Example

```php
// Remove editor from pages
add_action( 'init', function() {
    remove_post_type_support( 'page', 'editor' );
} );
```

---

## post_type_supports()

Checks if a post type supports a feature.

```php
post_type_supports( string $post_type, string $feature ): bool
```

**Since:** 3.0.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type |
| `$feature` | string | Feature to check |

### Returns

`true` if supported, `false` otherwise.

---

## get_all_post_type_supports()

Gets all features a post type supports.

```php
get_all_post_type_supports( string $post_type ): array
```

**Since:** 3.4.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type |

### Returns

Array of supported features.

---

## get_post_types_by_support()

Gets post types that support specific feature(s).

```php
get_post_types_by_support( array|string $feature, string $operator = 'and' ): string[]
```

**Since:** 4.5.0

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$feature` | array\|string | — | Feature(s) to check |
| `$operator` | string | `'and'` | `'and'`, `'or'`, or `'not'` |

### Returns

Array of post type names.

### Example

```php
// Get all post types with revisions
$revisioned = get_post_types_by_support( 'revisions' );

// Get post types with both title and editor
$editable = get_post_types_by_support( array( 'title', 'editor' ) );
```

---

## set_post_type()

Updates the post type for a post.

```php
set_post_type( int $post_id = 0, string $post_type = 'post' ): int|false
```

**Since:** 2.5.0

### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$post_id` | int | `0` | Post ID |
| `$post_type` | string | `'post'` | New post type |

### Returns

Number of rows changed (1 for success, 0 for failure), or `false`.

---

## is_post_publicly_viewable()

Checks if a specific post is publicly viewable.

```php
is_post_publicly_viewable( int|WP_Post|null $post = null ): bool
```

**Since:** 5.7.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | int\|WP_Post\|null | Post ID or object |

### Returns

`true` if publicly viewable, `false` otherwise.

---

## is_post_embeddable()

Checks if a post is embeddable.

```php
is_post_embeddable( int|WP_Post|null $post = null ): bool
```

**Since:** 6.8.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | int\|WP_Post\|null | Post ID or object |

### Returns

`true` if embeddable, `false` otherwise.
