# Post Types API Hooks

Actions and filters for post type registration and management.

**Source:** `wp-includes/post.php`, `wp-includes/class-wp-post-type.php`

---

## Actions

### registered_post_type

Fires after a post type is registered.

```php
do_action( 'registered_post_type', string $post_type, WP_Post_Type $post_type_object )
```

**Since:** 3.3.0  
**Since:** 4.6.0 `$post_type_object` is now `WP_Post_Type` instance.

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type key |
| `$post_type_object` | WP_Post_Type | Post type object |

#### Example

```php
add_action( 'registered_post_type', function( $post_type, $post_type_object ) {
    if ( $post_type_object->show_in_rest ) {
        // Track REST-enabled post types
        error_log( "REST-enabled: {$post_type}" );
    }
}, 10, 2 );
```

---

### registered_post_type_{$post_type}

Fires after a specific post type is registered.

```php
do_action( "registered_post_type_{$post_type}", string $post_type, WP_Post_Type $post_type_object )
```

**Since:** 6.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type key |
| `$post_type_object` | WP_Post_Type | Post type object |

#### Example

```php
add_action( 'registered_post_type_product', function( $post_type, $post_type_object ) {
    // Product post type is now registered
    do_something_with_products();
}, 10, 2 );
```

---

### unregistered_post_type

Fires after a post type is unregistered.

```php
do_action( 'unregistered_post_type', string $post_type )
```

**Since:** 4.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_type` | string | Post type key |

---

### save_post_{$post_type}

Fires after a post of specific type is saved.

```php
do_action( "save_post_{$post_type}", int $post_id, WP_Post $post, bool $update )
```

**Since:** 3.7.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_id` | int | Post ID |
| `$post` | WP_Post | Post object |
| `$update` | bool | Whether this is an update |

#### Example

```php
add_action( 'save_post_book', function( $post_id, $post, $update ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    update_post_meta( $post_id, '_book_updated', current_time( 'mysql' ) );
}, 10, 3 );
```

---

### edit_post_{$post_type}

Fires after a post of specific type is updated via edit form.

```php
do_action( "edit_post_{$post_type}", int $post_id, WP_Post $post )
```

**Since:** 6.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_id` | int | Post ID |
| `$post` | WP_Post | Post object |

---

### delete_post_{$post_type}

Fires before a post of specific type is deleted.

```php
do_action( "delete_post_{$post_type}", int $post_id, WP_Post $post )
```

**Since:** 6.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_id` | int | Post ID |
| `$post` | WP_Post | Post object |

---

### deleted_post_{$post_type}

Fires after a post of specific type is deleted.

```php
do_action( "deleted_post_{$post_type}", int $post_id, WP_Post $post )
```

**Since:** 6.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_id` | int | Post ID |
| `$post` | WP_Post | Post object |

---

### {$new_status}_{$post_type}

Fires on post status transition for specific post type.

```php
do_action( "{$new_status}_{$post_type}", int $post_id, WP_Post $post, string $old_status )
```

**Since:** 2.3.0  
**Since:** 6.0.0 Added `$old_status` parameter.

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_id` | int | Post ID |
| `$post` | WP_Post | Post object |
| `$old_status` | string | Previous post status |

#### Example

```php
// Fires when a book is published
add_action( 'publish_book', function( $post_id, $post, $old_status ) {
    if ( 'publish' !== $old_status ) {
        // First time published
        notify_subscribers( $post );
    }
}, 10, 3 );
```

---

### future_{$post_type}

Fires when a scheduled post of specific type is due.

```php
do_action( "future_{$post_type}", int $post_id, WP_Post $post )
```

**Since:** 2.9.0

Hooked internally to `_future_post_hook()` for publishing scheduled posts.

---

### add_meta_boxes_{$post_type}

Fires when registering meta boxes for specific post type.

```php
do_action( "add_meta_boxes_{$post_type}", WP_Post $post )
```

**Since:** 3.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | WP_Post | Post being edited |

#### Example

```php
add_action( 'add_meta_boxes_book', function( $post ) {
    add_meta_box(
        'book_details',
        __( 'Book Details' ),
        'render_book_details_meta_box',
        'book',
        'side'
    );
} );
```

---

## Filters

### register_post_type_args

Filters arguments for registering any post type.

```php
apply_filters( 'register_post_type_args', array $args, string $post_type ): array
```

**Since:** 4.4.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments |
| `$post_type` | string | Post type key |

#### Returns

Modified arguments array.

#### Example

```php
add_filter( 'register_post_type_args', function( $args, $post_type ) {
    // Force all custom post types to show in REST
    if ( ! $args['_builtin'] ) {
        $args['show_in_rest'] = true;
    }
    return $args;
}, 10, 2 );
```

---

### register_{$post_type}_post_type_args

Filters arguments for registering a specific post type.

```php
apply_filters( "register_{$post_type}_post_type_args", array $args, string $post_type ): array
```

**Since:** 6.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments |
| `$post_type` | string | Post type key |

#### Returns

Modified arguments array.

#### Example

```php
// Modify the 'post' post type registration
add_filter( 'register_post_post_type_args', function( $args ) {
    $args['menu_icon'] = 'dashicons-edit';
    return $args;
} );
```

---

### post_type_labels_{$post_type}

Filters labels for a specific post type.

```php
apply_filters( "post_type_labels_{$post_type}", object $labels ): object
```

**Since:** 3.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$labels` | object | Labels object |

#### Returns

Modified labels object.

#### Example

```php
add_filter( 'post_type_labels_page', function( $labels ) {
    $labels->add_new_item = __( 'Create New Page' );
    return $labels;
} );
```

---

### is_post_type_viewable

Filters whether a post type is viewable.

```php
apply_filters( 'is_post_type_viewable', bool $is_viewable, WP_Post_Type $post_type ): bool
```

**Since:** 5.9.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$is_viewable` | bool | Current viewable status |
| `$post_type` | WP_Post_Type | Post type object |

#### Returns

Boolean. Must be strictly `true` or `false`.

#### Example

```php
add_filter( 'is_post_type_viewable', function( $is_viewable, $post_type ) {
    // Make 'hidden_cpt' viewable only to admins
    if ( 'hidden_cpt' === $post_type->name ) {
        return current_user_can( 'manage_options' );
    }
    return $is_viewable;
}, 10, 2 );
```

---

### use_block_editor_for_post_type

Filters whether to use the block editor for a post type.

```php
apply_filters( 'use_block_editor_for_post_type', bool $use_block_editor, string $post_type ): bool
```

**Since:** 5.0.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$use_block_editor` | bool | Whether to use block editor |
| `$post_type` | string | Post type key |

#### Returns

Boolean.

#### Example

```php
add_filter( 'use_block_editor_for_post_type', function( $use, $post_type ) {
    // Disable block editor for specific post type
    if ( 'legacy_cpt' === $post_type ) {
        return false;
    }
    return $use;
}, 10, 2 );
```

---

### default_category_post_types

Filters which post types use the default category on publish.

```php
apply_filters( 'default_category_post_types', array $post_types ): array
```

**Since:** 5.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post_types` | array | Post type names |

#### Returns

Array of post type names.

#### Example

```php
add_filter( 'default_category_post_types', function( $types ) {
    $types[] = 'my_cpt';
    return $types;
} );
```

---

### wp_unique_post_slug

Filters the unique post slug.

```php
apply_filters( 'wp_unique_post_slug', string $slug, int $post_id, string $post_status, string $post_type, int $post_parent, string $original_slug ): string
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Unique slug |
| `$post_id` | int | Post ID |
| `$post_status` | string | Post status |
| `$post_type` | string | Post type |
| `$post_parent` | int | Parent post ID |
| `$original_slug` | string | Original requested slug |

#### Returns

Unique slug string.

---

### pre_wp_unique_post_slug

Short-circuits slug uniqueness check.

```php
apply_filters( 'pre_wp_unique_post_slug', null|string $override, string $slug, int $post_id, string $post_status, string $post_type, int $post_parent ): null|string
```

**Since:** 5.1.0

#### Returns

`null` to proceed with normal check, or string to use as slug.

---

### wp_unique_post_slug_is_bad_flat_slug

Filters whether a flat post type slug is bad.

```php
apply_filters( 'wp_unique_post_slug_is_bad_flat_slug', bool $is_bad, string $slug, string $post_type ): bool
```

**Since:** 3.1.0

---

### wp_unique_post_slug_is_bad_hierarchical_slug

Filters whether a hierarchical post type slug is bad.

```php
apply_filters( 'wp_unique_post_slug_is_bad_hierarchical_slug', bool $is_bad, string $slug, string $post_type, int $post_parent ): bool
```

**Since:** 3.1.0
