# Taxonomy API Functions

Core functions for taxonomy and term registration, retrieval, and management.

**Source:** `wp-includes/taxonomy.php`

---

## Taxonomy Registration

### register_taxonomy()

Creates or modifies a taxonomy object.

```php
register_taxonomy( string $taxonomy, array|string $object_type, array|string $args = array() ): WP_Taxonomy|WP_Error
```

**Note:** Do not use before the `init` hook.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy key. Max 32 characters, lowercase alphanumeric, dashes, underscores |
| `$object_type` | array\|string | Object type(s) to associate with |
| `$args` | array\|string | Configuration arguments |

#### Args

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `labels` | string[] | `[]` | Labels array. See `get_taxonomy_labels()` |
| `description` | string | `''` | Short descriptive summary |
| `public` | bool | `true` | Whether intended for public use |
| `publicly_queryable` | bool | (inherits `public`) | Whether publicly queryable |
| `hierarchical` | bool | `false` | Whether hierarchical (like categories) |
| `show_ui` | bool | (inherits `public`) | Whether to show admin UI |
| `show_in_menu` | bool | (inherits `show_ui`) | Whether to show in admin menu |
| `show_in_nav_menus` | bool | (inherits `public`) | Whether available in nav menus |
| `show_in_rest` | bool | `false` | Whether to include in REST API |
| `rest_base` | string | `$taxonomy` | REST API base path |
| `rest_namespace` | string | `'wp/v2'` | REST API namespace |
| `rest_controller_class` | string | `'WP_REST_Terms_Controller'` | REST controller class |
| `show_tagcloud` | bool | (inherits `show_ui`) | Whether to show in tag cloud widget |
| `show_in_quick_edit` | bool | (inherits `show_ui`) | Whether to show in quick/bulk edit |
| `show_admin_column` | bool | `false` | Whether to show column on post type listing |
| `meta_box_cb` | bool\|callable | `null` | Meta box callback. `false` for no meta box |
| `meta_box_sanitize_cb` | callable | (auto) | Meta box sanitization callback |
| `capabilities` | string[] | `[]` | Capability mappings |
| `rewrite` | bool\|array | `true` | Rewrite rules configuration |
| `query_var` | string\|bool | `$taxonomy` | Query var name. `false` to disable |
| `update_count_callback` | callable | (auto) | Count update callback |
| `default_term` | string\|array | `null` | Default term configuration |
| `sort` | bool\|null | `null` | Whether to maintain term order |
| `args` | array | `null` | Default args for `wp_get_object_terms()` |

#### Capabilities Array

| Key | Default | Description |
|-----|---------|-------------|
| `manage_terms` | `'manage_categories'` | Manage terms capability |
| `edit_terms` | `'manage_categories'` | Edit terms capability |
| `delete_terms` | `'manage_categories'` | Delete terms capability |
| `assign_terms` | `'edit_posts'` | Assign terms capability |

#### Rewrite Array

| Key | Default | Description |
|-----|---------|-------------|
| `slug` | `$taxonomy` | Permastruct slug |
| `with_front` | `true` | Prepend with front base |
| `hierarchical` | `false` | Hierarchical URL structure |
| `ep_mask` | `EP_NONE` | Endpoint mask |

**Returns:** `WP_Taxonomy` on success, `WP_Error` on failure.

**Example:**

```php
add_action( 'init', function() {
    register_taxonomy( 'genre', array( 'book', 'movie' ), array(
        'labels'            => array(
            'name'          => __( 'Genres' ),
            'singular_name' => __( 'Genre' ),
        ),
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => array( 'slug' => 'genre' ),
    ) );
} );
```

---

### unregister_taxonomy()

Unregisters a taxonomy. Cannot unregister built-in taxonomies.

```php
unregister_taxonomy( string $taxonomy ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` on success, `WP_Error` on failure.

---

### register_taxonomy_for_object_type()

Adds an already registered taxonomy to an object type.

```php
register_taxonomy_for_object_type( string $taxonomy, string $object_type ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |
| `$object_type` | string | Object type name |

**Returns:** `true` on success, `false` if taxonomy or object type doesn't exist.

---

### unregister_taxonomy_for_object_type()

Removes an already registered taxonomy from an object type.

```php
unregister_taxonomy_for_object_type( string $taxonomy, string $object_type ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |
| `$object_type` | string | Object type name |

**Returns:** `true` on success, `false` on failure.

---

## Taxonomy Retrieval

### get_taxonomy()

Retrieves the taxonomy object.

```php
get_taxonomy( string $taxonomy ): WP_Taxonomy|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |

**Returns:** `WP_Taxonomy` object or `false` if not found.

---

### get_taxonomies()

Retrieves a list of registered taxonomy names or objects.

```php
get_taxonomies( array $args = array(), string $output = 'names', string $operator = 'and' ): string[]|WP_Taxonomy[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Key/value arguments to match against taxonomy objects |
| `$output` | string | `'names'` or `'objects'` |
| `$operator` | string | `'and'` or `'or'` for matching logic |

**Returns:** Array of taxonomy names or `WP_Taxonomy` objects.

**Example:**

```php
// Get all public taxonomies
$public_taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

// Get taxonomies for posts
$post_taxonomies = get_object_taxonomies( 'post', 'objects' );
```

---

### get_object_taxonomies()

Returns taxonomies registered for the requested object or object type.

```php
get_object_taxonomies( string|string[]|WP_Post $object_type, string $output = 'names' ): string[]|WP_Taxonomy[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string\|string[]\|WP_Post | Object type name(s) or post object |
| `$output` | string | `'names'` or `'objects'` |

**Returns:** Array of taxonomy names or objects.

---

### taxonomy_exists()

Determines whether the taxonomy name exists.

```php
taxonomy_exists( string $taxonomy ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` if exists, `false` otherwise.

---

### is_taxonomy_hierarchical()

Determines whether the taxonomy object is hierarchical.

```php
is_taxonomy_hierarchical( string $taxonomy ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` if hierarchical, `false` if not or taxonomy doesn't exist.

---

### is_taxonomy_viewable()

Determines whether a taxonomy is considered "viewable".

```php
is_taxonomy_viewable( string|WP_Taxonomy $taxonomy ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string\|WP_Taxonomy | Taxonomy name or object |

**Returns:** `true` if publicly queryable.

---

### get_taxonomy_labels()

Builds an object with all taxonomy labels out of a taxonomy object.

```php
get_taxonomy_labels( WP_Taxonomy $tax ): object
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tax` | WP_Taxonomy | Taxonomy object |

**Returns:** Object with label properties.

---

## Term Retrieval

### get_terms()

Retrieves the terms in a given taxonomy or list of taxonomies.

```php
get_terms( array|string $args = array(), array|string $deprecated = '' ): WP_Term[]|int[]|string[]|string|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array\|string | Query arguments. See `WP_Term_Query::__construct()` |
| `$deprecated` | array\|string | Deprecated. Legacy argument format |

**Returns:** Array of terms, count as numeric string, or `WP_Error`.

**Example:**

```php
$terms = get_terms( array(
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );
```

---

### get_term()

Gets all term data from database by term ID.

```php
get_term( int|WP_Term|object $term, string $taxonomy = '', string $output = OBJECT, string $filter = 'raw' ): WP_Term|array|WP_Error|null
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int\|WP_Term\|object | Term ID or object |
| `$taxonomy` | string | Taxonomy name (optional since 4.4.0) |
| `$output` | string | `OBJECT`, `ARRAY_A`, or `ARRAY_N` |
| `$filter` | string | Sanitization filter. See `sanitize_term_field()` |

**Returns:** `WP_Term` or array on success, `WP_Error` or `null` on failure.

---

### get_term_by()

Gets all term data from database by term field and data.

```php
get_term_by( string $field, string|int $value, string $taxonomy = '', string $output = OBJECT, string $filter = 'raw' ): WP_Term|array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | `'slug'`, `'name'`, `'term_id'`/`'id'`/`'ID'`, or `'term_taxonomy_id'` |
| `$value` | string\|int | Value to search for |
| `$taxonomy` | string | Taxonomy name. Optional if `$field` is `'term_taxonomy_id'` |
| `$output` | string | `OBJECT`, `ARRAY_A`, or `ARRAY_N` |
| `$filter` | string | Sanitization filter |

**Returns:** `WP_Term` or array on success, `false` on failure.

**Example:**

```php
$term = get_term_by( 'slug', 'uncategorized', 'category' );
```

---

### get_term_children()

Merges all term children into a single array of their IDs.

```php
get_term_children( int $term_id, string $taxonomy ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID to get children of |
| `$taxonomy` | string | Taxonomy name |

**Returns:** Array of term IDs or `WP_Error`.

---

### get_term_field()

Gets sanitized term field.

```php
get_term_field( string $field, int|WP_Term $term, string $taxonomy = '', string $context = 'display' ): string|int|null|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | Term field to fetch |
| `$term` | int\|WP_Term | Term ID or object |
| `$taxonomy` | string | Taxonomy name |
| `$context` | string | Sanitization context |

**Returns:** Field value or `WP_Error`.

---

### term_exists()

Determines whether a taxonomy term exists.

```php
term_exists( int|string $term, string $taxonomy = '', int $parent_term = null ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int\|string | Term ID, slug, or name |
| `$taxonomy` | string | Taxonomy name |
| `$parent_term` | int | Parent term ID to confine search |

**Returns:** `null` if not found, term ID if no taxonomy specified, array with `term_id` and `term_taxonomy_id` if taxonomy specified.

---

### is_term_publicly_viewable()

Determines if a term is publicly viewable.

```php
is_term_publicly_viewable( int|WP_Term $term ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int\|WP_Term | Term ID or object |

**Returns:** `true` if taxonomy is viewable.

---

## Object-Term Relationships

### wp_get_object_terms()

Retrieves the terms associated with the given object(s), in the supplied taxonomies.

```php
wp_get_object_terms( int|int[] $object_ids, string|string[] $taxonomies, array|string $args = array() ): WP_Term[]|int[]|string[]|string|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_ids` | int\|int[] | Object ID(s) to retrieve terms for |
| `$taxonomies` | string\|string[] | Taxonomy name(s) |
| `$args` | array\|string | See `WP_Term_Query::__construct()` |

**Returns:** Array of terms or `WP_Error`.

**Example:**

```php
$categories = wp_get_object_terms( $post_id, 'category', array(
    'fields' => 'names',
) );
```

---

### wp_set_object_terms()

Creates term and taxonomy relationships.

```php
wp_set_object_terms( int $object_id, string|int|array $terms, string $taxonomy, bool $append = false ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object to relate to |
| `$terms` | string\|int\|array | Term slug(s) or ID(s). Empty array removes all |
| `$taxonomy` | string | Taxonomy name |
| `$append` | bool | If `false`, replaces existing terms |

**Returns:** Array of term taxonomy IDs or `WP_Error`.

**Example:**

```php
// Set categories for a post
wp_set_object_terms( $post_id, array( 'news', 'featured' ), 'category' );

// Add tags without replacing existing
wp_set_object_terms( $post_id, array( 'wordpress', 'tutorial' ), 'post_tag', true );
```

---

### wp_add_object_terms()

Adds term(s) associated with a given object.

```php
wp_add_object_terms( int $object_id, string|int|array $terms, array|string $taxonomy ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$terms` | string\|int\|array | Term slug(s) or ID(s) |
| `$taxonomy` | array\|string | Taxonomy name |

**Returns:** Array of term taxonomy IDs or `WP_Error`.

---

### wp_remove_object_terms()

Removes term(s) associated with a given object.

```php
wp_remove_object_terms( int $object_id, string|int|array $terms, string $taxonomy ): bool|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$terms` | string\|int\|array | Term slug(s) or ID(s) |
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` on success, `false` or `WP_Error` on failure.

---

### wp_delete_object_term_relationships()

Unlinks the object from the taxonomy or taxonomies.

```php
wp_delete_object_term_relationships( int $object_id, string|array $taxonomies ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$taxonomies` | string\|array | Taxonomy name(s) |

---

### is_object_in_term()

Determines if the given object is associated with any of the given terms.

```php
is_object_in_term( int $object_id, string $taxonomy, int|string|int[]|string[] $terms = null ): bool|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$taxonomy` | string | Taxonomy name |
| `$terms` | int\|string\|array | Term ID(s), name(s), or slug(s). `null` checks any term |

**Returns:** `true`/`false` or `WP_Error`.

---

### is_object_in_taxonomy()

Determines if the given object type is associated with the given taxonomy.

```php
is_object_in_taxonomy( string $object_type, string $taxonomy ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Object type string |
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` if associated.

---

### get_objects_in_term()

Retrieves object IDs of valid taxonomy and term.

```php
get_objects_in_term( int|int[] $term_ids, string|string[] $taxonomies, array|string $args = array() ): string[]|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_ids` | int\|int[] | Term ID(s) |
| `$taxonomies` | string\|string[] | Taxonomy name(s) |
| `$args` | array\|string | `order` can be `'ASC'` or `'DESC'` |

**Returns:** Array of object IDs as strings or `WP_Error`.

---

## Term Modification

### wp_insert_term()

Adds a new term to the database.

```php
wp_insert_term( string $term, string $taxonomy, array|string $args = array() ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | string | Term name |
| `$taxonomy` | string | Taxonomy name |
| `$args` | array\|string | Configuration arguments |

#### Args

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `alias_of` | string | `''` | Slug of term to make this an alias of |
| `description` | string | `''` | Term description |
| `parent` | int | `0` | Parent term ID |
| `slug` | string | `''` | Term slug (auto-generated if empty) |

**Returns:** Array with `term_id` and `term_taxonomy_id` or `WP_Error`.

**Error Codes:**
- `invalid_taxonomy` — Taxonomy doesn't exist
- `invalid_term_id` — Term ID is 0
- `empty_term_name` — Empty term name
- `missing_parent` — Parent term doesn't exist
- `term_exists` — Term already exists at this level

**Example:**

```php
$result = wp_insert_term( 'Jazz', 'genre', array(
    'description' => 'Jazz music genre',
    'slug'        => 'jazz',
    'parent'      => $music_term_id,
) );

if ( ! is_wp_error( $result ) ) {
    $term_id = $result['term_id'];
}
```

---

### wp_update_term()

Updates term based on arguments provided.

```php
wp_update_term( int $term_id, string $taxonomy, array $args = array() ): array|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy name |
| `$args` | array | Same as `wp_insert_term()` args |

**Returns:** Array with `term_id` and `term_taxonomy_id` or `WP_Error`.

---

### wp_delete_term()

Removes a term from the database.

```php
wp_delete_term( int $term, string $taxonomy, array|string $args = array() ): bool|int|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | int | Term ID |
| `$taxonomy` | string | Taxonomy name |
| `$args` | array\|string | Configuration arguments |

#### Args

| Key | Type | Description |
|-----|------|-------------|
| `default` | int | Default term ID to assign orphaned objects |
| `force_default` | bool | Force default assignment even if object has other terms |

**Returns:** `true` on success, `false` if term doesn't exist, `0` if default category, `WP_Error` on failure.

---

### wp_delete_category()

Deletes one existing category.

```php
wp_delete_category( int $cat_id ): bool|int|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cat_id` | int | Category term ID |

**Returns:** Same as `wp_delete_term()`.

---

## Term Metadata

### add_term_meta()

Adds metadata to a term.

```php
add_term_meta( int $term_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$meta_key` | string | Metadata name |
| `$meta_value` | mixed | Metadata value (must be serializable if non-scalar) |
| `$unique` | bool | Whether to prevent duplicate keys |

**Returns:** Meta ID on success, `false` on failure, `WP_Error` if term is shared.

---

### get_term_meta()

Retrieves metadata for a term.

```php
get_term_meta( int $term_id, string $key = '', bool $single = false ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$key` | string | Meta key. Empty returns all meta |
| `$single` | bool | Whether to return single value |

**Returns:** Meta value(s), empty string/array for non-existing, `false` for invalid term ID.

---

### update_term_meta()

Updates term metadata.

```php
update_term_meta( int $term_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$meta_key` | string | Metadata key |
| `$meta_value` | mixed | Metadata value |
| `$prev_value` | mixed | Previous value to match for update |

**Returns:** Meta ID if new, `true` on update, `false` on failure/no change, `WP_Error` if term is shared.

---

### delete_term_meta()

Removes metadata matching criteria from a term.

```php
delete_term_meta( int $term_id, string $meta_key, mixed $meta_value = '' ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$meta_key` | string | Metadata name |
| `$meta_value` | mixed | Metadata value to match (optional) |

**Returns:** `true` on success, `false` on failure.

---

### register_term_meta()

Registers a meta key for terms.

```php
register_term_meta( string $taxonomy, string $meta_key, array $args ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name. Empty for all taxonomies |
| `$meta_key` | string | Meta key to register |
| `$args` | array | Arguments. See `register_meta()` |

**Returns:** `true` on success, `false` on failure.

---

### unregister_term_meta()

Unregisters a meta key for terms.

```php
unregister_term_meta( string $taxonomy, string $meta_key ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy name |
| `$meta_key` | string | Meta key to unregister |

**Returns:** `true` on success, `false` if not registered.

---

### has_term_meta()

Gets all meta data, including meta IDs, for the given term ID.

```php
has_term_meta( int $term_id ): array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |

**Returns:** Array with `meta_key`, `meta_value`, `meta_id`, `term_id` or `false`.

---

## Term Counting

### wp_count_terms()

Counts how many terms are in taxonomy.

```php
wp_count_terms( array|string $args = array(), array|string $deprecated = '' ): string|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array\|string | Query arguments. See `WP_Term_Query::__construct()` |
| `$deprecated` | array\|string | Deprecated. Legacy format |

**Returns:** Numeric string count or `WP_Error`.

---

### wp_update_term_count()

Updates the amount of terms in taxonomy.

```php
wp_update_term_count( int|array $terms, string $taxonomy, bool $do_deferred = false ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | int\|array | Term taxonomy ID(s) |
| `$taxonomy` | string | Taxonomy name |
| `$do_deferred` | bool | Whether to flush deferred counts |

**Returns:** `true` on success, `false` if empty.

---

### wp_defer_term_counting()

Enables or disables term counting.

```php
wp_defer_term_counting( bool $defer = null ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$defer` | bool | `true` to enable deferring, `false` to disable and flush |

**Returns:** Whether deferring is enabled.

---

## Term Hierarchy

### term_is_ancestor_of()

Checks if a term is an ancestor of another term.

```php
term_is_ancestor_of( int|object $term1, int|object $term2, string $taxonomy ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term1` | int\|object | Potential parent term |
| `$term2` | int\|object | Child term |
| `$taxonomy` | string | Taxonomy name |

**Returns:** `true` if `$term2` is child of `$term1`.

---

### get_ancestors()

Gets an array of ancestor IDs for a given object.

```php
get_ancestors( int $object_id = 0, string $object_type = '', string $resource_type = '' ): int[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_id` | int | Object ID |
| `$object_type` | string | Post type or taxonomy name |
| `$resource_type` | string | `'post_type'` or `'taxonomy'` |

**Returns:** Array of ancestor IDs from lowest to highest.

---

### wp_get_term_taxonomy_parent_id()

Returns the term's parent's term ID.

```php
wp_get_term_taxonomy_parent_id( int $term_id, string $taxonomy ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy name |

**Returns:** Parent term ID or `false`.

---

## Term URLs

### get_term_link()

Generates a permalink for a taxonomy term archive.

```php
get_term_link( WP_Term|int|string $term, string $taxonomy = '' ): string|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | WP_Term\|int\|string | Term object, ID, or slug |
| `$taxonomy` | string | Taxonomy name |

**Returns:** URL string or `WP_Error`.

**Example:**

```php
$category = get_category_by_slug( 'news' );
$link = get_term_link( $category );
```

---

## Sanitization

### sanitize_term()

Sanitizes all term fields.

```php
sanitize_term( array|object $term, string $taxonomy, string $context = 'display' ): array|object
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term` | array\|object | Term to check |
| `$taxonomy` | string | Taxonomy name |
| `$context` | string | `'raw'`, `'edit'`, `'db'`, `'display'`, `'rss'`, `'attribute'`, `'js'` |

**Returns:** Term with sanitized fields.

---

### sanitize_term_field()

Sanitizes the field value in the term based on the context.

```php
sanitize_term_field( string $field, string $value, int $term_id, string $taxonomy, string $context ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$field` | string | Term field to sanitize |
| `$value` | string | Field value |
| `$term_id` | int | Term ID |
| `$taxonomy` | string | Taxonomy name |
| `$context` | string | Sanitization context |

**Returns:** Sanitized field value.

---

### wp_unique_term_slug()

Makes term slug unique, if it isn't already.

```php
wp_unique_term_slug( string $slug, object $term ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Proposed slug |
| `$term` | object | Term object |

**Returns:** Unique slug.

---

## Caching

### clean_term_cache()

Removes all of the term IDs from the cache.

```php
clean_term_cache( int|int[] $ids, string $taxonomy = '', bool $clean_taxonomy = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ids` | int\|int[] | Term ID(s) |
| `$taxonomy` | string | Taxonomy name |
| `$clean_taxonomy` | bool | Whether to clean taxonomy-wide caches |

---

### clean_object_term_cache()

Removes the taxonomy relationship to terms from the cache.

```php
clean_object_term_cache( int|array $object_ids, array|string $object_type ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_ids` | int\|array | Object ID(s) |
| `$object_type` | array\|string | Object type(s) |

---

### clean_taxonomy_cache()

Cleans the caches for a taxonomy.

```php
clean_taxonomy_cache( string $taxonomy ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$taxonomy` | string | Taxonomy slug |

---

### get_object_term_cache()

Retrieves the cached term objects for the given object ID.

```php
get_object_term_cache( int $id, string $taxonomy ): bool|WP_Term[]|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | int | Object ID |
| `$taxonomy` | string | Taxonomy name |

**Returns:** Array of `WP_Term` objects, `false` if not cached, `WP_Error` on error.

---

### update_object_term_cache()

Updates the cache for the given term object ID(s).

```php
update_object_term_cache( string|int[] $object_ids, string|string[] $object_type ): void|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_ids` | string\|int[] | Object ID(s) |
| `$object_type` | string\|string[] | Object type(s) |

**Returns:** `void` on success, `false` if all already cached.

---

### update_term_cache()

Updates terms in cache.

```php
update_term_cache( WP_Term[] $terms, string $taxonomy = '' ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$terms` | WP_Term[] | Array of term objects |
| `$taxonomy` | string | Not used |

---

### update_termmeta_cache()

Updates metadata cache for list of term IDs.

```php
update_termmeta_cache( array $term_ids ): array|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_ids` | array | List of term IDs |

**Returns:** Array of metadata or `false` if nothing to update.

---

### wp_lazyload_term_meta()

Queue term meta for lazy-loading.

```php
wp_lazyload_term_meta( array $term_ids ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_ids` | array | List of term IDs |

---

## Display Functions

### the_taxonomies()

Displays the taxonomies of a post with available options.

```php
the_taxonomies( array $args = array() ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Display arguments |

#### Args

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `post` | int\|WP_Post | `0` | Post ID or object |
| `before` | string | `''` | Output before taxonomies |
| `sep` | string | `' '` | Separator between taxonomies |
| `after` | string | `''` | Output after taxonomies |
| `template` | string | `'%s: %l.'` | Label/terms template |
| `term_template` | string | `'<a href="%1$s">%2$s</a>'` | Single term template |

---

### get_the_taxonomies()

Retrieves all taxonomies associated with a post.

```php
get_the_taxonomies( int|WP_Post $post = 0, array $args = array() ): string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | int\|WP_Post | Post ID or object |
| `$args` | array | Display arguments |

**Returns:** Array of formatted taxonomy strings keyed by taxonomy name.

---

### get_post_taxonomies()

Retrieves all taxonomy names for the given post.

```php
get_post_taxonomies( int|WP_Post $post = 0 ): string[]
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | int\|WP_Post | Post ID or object |

**Returns:** Array of taxonomy names.

---

## Split Terms

### wp_get_split_terms()

Gets data about terms that previously shared a single term_id, but have since been split.

```php
wp_get_split_terms( int $old_term_id ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$old_term_id` | int | Old, pre-split term ID |

**Returns:** Array of new term IDs, keyed by taxonomy.

---

### wp_get_split_term()

Gets the new term ID corresponding to a previously split term.

```php
wp_get_split_term( int $old_term_id, string $taxonomy ): int|false
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$old_term_id` | int | Old, pre-split term ID |
| `$taxonomy` | string | Taxonomy name |

**Returns:** New term ID or `false`.

---

### wp_term_is_shared()

Determines whether a term is shared between multiple taxonomies.

```php
wp_term_is_shared( int $term_id ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$term_id` | int | Term ID |

**Returns:** `true` if shared, `false` if not or splitting is finished.
