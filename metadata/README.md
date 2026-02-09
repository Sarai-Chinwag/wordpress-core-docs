# Metadata API

The Metadata API provides functions for storing and retrieving additional data associated with posts, users, comments, and terms.

**Since:** WordPress 2.9.0

## Overview

Metadata is key-value data attached to WordPress objects:

| Object Type | Table | Functions |
|-------------|-------|-----------|
| Posts | `wp_postmeta` | `get_post_meta()`, `update_post_meta()`, etc. |
| Users | `wp_usermeta` | `get_user_meta()`, `update_user_meta()`, etc. |
| Comments | `wp_commentmeta` | `get_comment_meta()`, `update_comment_meta()`, etc. |
| Terms | `wp_termmeta` | `get_term_meta()`, `update_term_meta()`, etc. |

## Post Meta

### get_post_meta()

Retrieves post metadata.

```php
get_post_meta( int $post_id, string $key = '', bool $single = false ): mixed
```

**Examples:**

```php
// Get single value
$price = get_post_meta( $post_id, 'price', true );

// Get all values for a key (returns array)
$colors = get_post_meta( $post_id, 'color', false );

// Get all meta for a post
$all_meta = get_post_meta( $post_id );
```

---

### update_post_meta()

Updates or creates post metadata.

```php
update_post_meta( 
    int    $post_id, 
    string $meta_key, 
    mixed  $meta_value, 
    mixed  $prev_value = '' 
): int|bool
```

**Examples:**

```php
// Simple update
update_post_meta( $post_id, 'price', 29.99 );

// Update array
update_post_meta( $post_id, 'settings', array(
    'enabled' => true,
    'limit'   => 100,
) );

// Update only if previous value matches
update_post_meta( $post_id, 'status', 'published', 'draft' );
```

---

### add_post_meta()

Adds new metadata (can create duplicates).

```php
add_post_meta( 
    int    $post_id, 
    string $meta_key, 
    mixed  $meta_value, 
    bool   $unique = false 
): int|false
```

**Examples:**

```php
// Add (allows duplicates)
add_post_meta( $post_id, 'related_post', 123 );
add_post_meta( $post_id, 'related_post', 456 );

// Add only if key doesn't exist
add_post_meta( $post_id, 'featured', true, true );
```

---

### delete_post_meta()

Removes post metadata.

```php
delete_post_meta( 
    int    $post_id, 
    string $meta_key, 
    mixed  $meta_value = '' 
): bool
```

**Examples:**

```php
// Delete all values for key
delete_post_meta( $post_id, 'temp_data' );

// Delete specific value only
delete_post_meta( $post_id, 'related_post', 123 );
```

---

## User Meta

Same pattern as post meta:

```php
// Get
$bio = get_user_meta( $user_id, 'biography', true );

// Update
update_user_meta( $user_id, 'biography', 'New bio text' );

// Add
add_user_meta( $user_id, 'skill', 'PHP' );
add_user_meta( $user_id, 'skill', 'JavaScript' );

// Delete
delete_user_meta( $user_id, 'old_preference' );
```

---

## Comment Meta

```php
// Get
$rating = get_comment_meta( $comment_id, 'rating', true );

// Update
update_comment_meta( $comment_id, 'rating', 5 );

// Add
add_comment_meta( $comment_id, 'flag', 'helpful' );

// Delete
delete_comment_meta( $comment_id, 'spam_score' );
```

---

## Term Meta

**Since:** WordPress 4.4.0

```php
// Get
$color = get_term_meta( $term_id, 'color', true );

// Update
update_term_meta( $term_id, 'color', '#ff0000' );

// Add
add_term_meta( $term_id, 'image_id', 123 );

// Delete
delete_term_meta( $term_id, 'deprecated_field' );
```

---

## Registering Meta

### register_post_meta()

Registers metadata for a post type.

```php
register_post_meta( string $post_type, string $meta_key, array $args ): bool
```

**Example:**

```php
register_post_meta( 'product', 'price', array(
    'type'              => 'number',
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'floatval',
    'auth_callback'     => function() {
        return current_user_can( 'edit_posts' );
    },
    'default'           => 0,
) );
```

### register_meta()

Generic metadata registration.

```php
register_meta( string $object_type, string $meta_key, array $args ): bool
```

**Object Types:** `post`, `user`, `comment`, `term`

**Example:**

```php
register_meta( 'user', 'favorite_color', array(
    'type'         => 'string',
    'single'       => true,
    'show_in_rest' => true,
    'default'      => 'blue',
) );
```

### Args Reference

| Arg | Type | Description |
|-----|------|-------------|
| `type` | string | `string`, `boolean`, `integer`, `number`, `array`, `object` |
| `single` | bool | Single value or array of values |
| `show_in_rest` | bool/array | Expose in REST API |
| `sanitize_callback` | callable | Sanitize before save |
| `auth_callback` | callable | Permission check |
| `default` | mixed | Default value |
| `description` | string | Field description |

---

## REST API Integration

With `show_in_rest => true`, meta appears in REST responses:

```json
{
    "id": 123,
    "title": { "rendered": "My Post" },
    "meta": {
        "price": 29.99,
        "featured": true
    }
}
```

### Complex REST Schema

```php
register_post_meta( 'product', 'dimensions', array(
    'type'         => 'object',
    'single'       => true,
    'show_in_rest' => array(
        'schema' => array(
            'type'       => 'object',
            'properties' => array(
                'width'  => array( 'type' => 'number' ),
                'height' => array( 'type' => 'number' ),
                'depth'  => array( 'type' => 'number' ),
            ),
        ),
    ),
) );
```

---

## Querying by Meta

### WP_Query with meta_query

```php
$query = new WP_Query( array(
    'post_type'  => 'product',
    'meta_query' => array(
        array(
            'key'     => 'price',
            'value'   => 50,
            'compare' => '<=',
            'type'    => 'NUMERIC',
        ),
    ),
) );

// Multiple conditions
$query = new WP_Query( array(
    'post_type'  => 'product',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'price',
            'value'   => array( 10, 100 ),
            'compare' => 'BETWEEN',
            'type'    => 'NUMERIC',
        ),
        array(
            'key'   => 'in_stock',
            'value' => '1',
        ),
    ),
) );

// Order by meta
$query = new WP_Query( array(
    'post_type'  => 'product',
    'meta_key'   => 'price',
    'orderby'    => 'meta_value_num',
    'order'      => 'ASC',
) );
```

### Compare Operators

| Operator | Description |
|----------|-------------|
| `=` | Equal (default) |
| `!=` | Not equal |
| `>` | Greater than |
| `>=` | Greater than or equal |
| `<` | Less than |
| `<=` | Less than or equal |
| `LIKE` | Contains |
| `NOT LIKE` | Does not contain |
| `IN` | In array |
| `NOT IN` | Not in array |
| `BETWEEN` | Between two values |
| `NOT BETWEEN` | Not between |
| `EXISTS` | Key exists |
| `NOT EXISTS` | Key doesn't exist |
| `REGEXP` | Regular expression |

---

## Protected Meta

Keys starting with `_` are "protected" and hidden from Custom Fields UI:

```php
update_post_meta( $post_id, '_internal_data', $value );
```

---

## Filters

### sanitize_meta_{$meta_key}

```php
add_filter( 'sanitize_post_meta_my_field', function( $value, $key, $type ) {
    return sanitize_text_field( $value );
}, 10, 3 );
```

### update_post_meta

```php
add_action( 'update_post_meta', function( $meta_id, $post_id, $key, $value ) {
    if ( 'price' === $key ) {
        // Log price changes
    }
}, 10, 4 );
```

---

## Best Practices

1. **Prefix meta keys** — `myplugin_setting`, not `setting`
2. **Use `_` prefix for internal data** — Hidden from UI
3. **Register meta** — For REST API and type safety
4. **Sanitize on save** — Use `sanitize_callback`
5. **Use appropriate types** — NUMERIC for numbers in queries
6. **Consider performance** — Meta queries can be slow on large datasets
7. **Clean up on uninstall** — Delete your meta when plugin is removed
