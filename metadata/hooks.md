# Metadata API Hooks

Actions and filters for the Metadata API.

All hooks use dynamic names where `{$meta_type}` is replaced with the object type (`post`, `user`, `comment`, `term`, `blog`, etc.).

---

## Short-Circuit Filters

These filters allow intercepting metadata operations before they hit the database.

### add_{$meta_type}_metadata

Short-circuits adding metadata. Return non-null to prevent database insert.

```php
apply_filters( "add_{$meta_type}_metadata", null|int|false $check, int $object_id, string $meta_key, mixed $meta_value, bool $unique )
```

**Since:** 3.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$check` | null\|int\|false | Return `null` to continue, `false` or meta ID to short-circuit. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value. |
| `$unique` | bool | Whether key should be unique. |

**Hook names:** `add_post_metadata`, `add_user_metadata`, `add_comment_metadata`, `add_term_metadata`, `add_blog_metadata`

---

### update_{$meta_type}_metadata

Short-circuits updating metadata. Return non-null to prevent database update.

```php
apply_filters( "update_{$meta_type}_metadata", null|bool $check, int $object_id, string $meta_key, mixed $meta_value, mixed $prev_value )
```

**Since:** 3.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$check` | null\|bool | Return `null` to continue, bool to short-circuit. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value. |
| `$prev_value` | mixed | Previous value to check. |

**Hook names:** `update_post_metadata`, `update_user_metadata`, `update_comment_metadata`, `update_term_metadata`, `update_blog_metadata`

---

### delete_{$meta_type}_metadata

Short-circuits deleting metadata. Return non-null to prevent database delete.

```php
apply_filters( "delete_{$meta_type}_metadata", null|bool $delete, int $object_id, string $meta_key, mixed $meta_value, bool $delete_all )
```

**Since:** 3.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$delete` | null\|bool | Return `null` to continue, bool to short-circuit. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value. |
| `$delete_all` | bool | Whether to delete for all objects. |

**Hook names:** `delete_post_metadata`, `delete_user_metadata`, `delete_comment_metadata`, `delete_term_metadata`, `delete_blog_metadata`

---

### get_{$meta_type}_metadata

Short-circuits retrieving metadata. Return non-null to provide custom value.

```php
apply_filters( "get_{$meta_type}_metadata", mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type )
```

**Since:** 3.1.0, 5.5.0 added `$meta_type` parameter

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Return `null` to continue, any value to short-circuit. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$single` | bool | Whether to return single value. |
| `$meta_type` | string | Type of object. |

**Hook names:** `get_post_metadata`, `get_user_metadata`, `get_comment_metadata`, `get_term_metadata`, `get_blog_metadata`

**Example:**

```php
add_filter( 'get_post_metadata', function( $value, $object_id, $meta_key, $single ) {
    if ( 'my_computed_key' === $meta_key ) {
        return $single ? 'computed_value' : array( 'computed_value' );
    }
    return $value;
}, 10, 4 );
```

---

### get_{$meta_type}_metadata_by_mid

Short-circuits retrieving metadata by meta ID.

```php
apply_filters( "get_{$meta_type}_metadata_by_mid", stdClass|null $value, int $meta_id )
```

**Since:** 5.0.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | stdClass\|null | Return `null` to continue, object to short-circuit. |
| `$meta_id` | int | Meta ID. |

---

### update_{$meta_type}_metadata_by_mid

Short-circuits updating metadata by meta ID.

```php
apply_filters( "update_{$meta_type}_metadata_by_mid", null|bool $check, int $meta_id, mixed $meta_value, string|false $meta_key )
```

**Since:** 5.0.0

---

### delete_{$meta_type}_metadata_by_mid

Short-circuits deleting metadata by meta ID.

```php
apply_filters( "delete_{$meta_type}_metadata_by_mid", null|bool $delete, int $meta_id )
```

**Since:** 5.0.0

---

### update_{$meta_type}_metadata_cache

Short-circuits updating the metadata cache.

```php
apply_filters( "update_{$meta_type}_metadata_cache", mixed $check, int[] $object_ids )
```

**Since:** 5.0.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$check` | mixed | Return `null` to continue, non-null to short-circuit. |
| `$object_ids` | int[] | Array of object IDs. |

---

## Before/After Actions

### add_{$meta_type}_meta

Fires immediately before meta is added.

```php
do_action( "add_{$meta_type}_meta", int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 3.1.0

**Hook names:** `add_post_meta`, `add_user_meta`, `add_comment_meta`, `add_term_meta`, `add_blog_meta`

---

### added_{$meta_type}_meta

Fires immediately after meta is added.

```php
do_action( "added_{$meta_type}_meta", int $mid, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$mid` | int | The meta ID after insertion. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value. |

**Hook names:** `added_post_meta`, `added_user_meta`, `added_comment_meta`, `added_term_meta`, `added_blog_meta`

---

### update_{$meta_type}_meta

Fires immediately before meta is updated.

```php
do_action( "update_{$meta_type}_meta", int $meta_id, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

**Hook names:** `update_post_meta`, `update_user_meta`, `update_comment_meta`, `update_term_meta`, `update_blog_meta`

---

### updated_{$meta_type}_meta

Fires immediately after meta is updated.

```php
do_action( "updated_{$meta_type}_meta", int $meta_id, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

**Hook names:** `updated_post_meta`, `updated_user_meta`, `updated_comment_meta`, `updated_term_meta`, `updated_blog_meta`

---

### delete_{$meta_type}_meta

Fires immediately before meta is deleted.

```php
do_action( "delete_{$meta_type}_meta", string[] $meta_ids, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 3.1.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_ids` | string[] | Array of metadata entry IDs to delete. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value. |

**Hook names:** `delete_post_meta`, `delete_user_meta`, `delete_comment_meta`, `delete_term_meta`, `delete_blog_meta`

---

### deleted_{$meta_type}_meta

Fires immediately after meta is deleted.

```php
do_action( "deleted_{$meta_type}_meta", string[] $meta_ids, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

**Hook names:** `deleted_post_meta`, `deleted_user_meta`, `deleted_comment_meta`, `deleted_term_meta`, `deleted_blog_meta`

---

## Post-Specific Hooks

These legacy hooks fire only for post metadata.

### update_postmeta

Fires before updating post metadata.

```php
do_action( 'update_postmeta', int $meta_id, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

**Note:** `$meta_value` is serialized if originally array/object.

---

### updated_postmeta

Fires after updating post metadata.

```php
do_action( 'updated_postmeta', int $meta_id, int $object_id, string $meta_key, mixed $meta_value )
```

**Since:** 2.9.0

---

### delete_postmeta

Fires before deleting post metadata.

```php
do_action( 'delete_postmeta', string[] $meta_ids )
```

**Since:** 2.9.0

---

### deleted_postmeta

Fires after deleting post metadata.

```php
do_action( 'deleted_postmeta', string[] $meta_ids )
```

**Since:** 2.9.0

---

## Default Value Filter

### default_{$meta_type}_metadata

Filters the default metadata value.

```php
apply_filters( "default_{$meta_type}_metadata", mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type )
```

**Since:** 5.5.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Default value (empty string or array). |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$single` | bool | Whether to return single value. |
| `$meta_type` | string | Type of object. |

**Hook names:** `default_post_metadata`, `default_user_metadata`, `default_comment_metadata`, `default_term_metadata`, `default_blog_metadata`

**Example:**

```php
add_filter( 'default_post_metadata', function( $value, $object_id, $meta_key, $single ) {
    if ( 'view_count' === $meta_key ) {
        return $single ? 0 : array( 0 );
    }
    return $value;
}, 10, 4 );
```

---

## Sanitization Filters

### sanitize_{$meta_type}_meta_{$meta_key}

Filters sanitization of a specific meta key.

```php
apply_filters( "sanitize_{$object_type}_meta_{$meta_key}", mixed $meta_value, string $meta_key, string $object_type )
```

**Since:** 3.3.0

---

### sanitize_{$meta_type}_meta_{$meta_key}_for_{$object_subtype}

Filters sanitization of a specific meta key for a specific subtype.

```php
apply_filters( "sanitize_{$object_type}_meta_{$meta_key}_for_{$object_subtype}", mixed $meta_value, string $meta_key, string $object_type, string $object_subtype )
```

**Since:** 4.9.8

**Example:**

```php
// Sanitize 'price' meta for 'product' post type
add_filter( 'sanitize_post_meta_price_for_product', function( $value ) {
    return floatval( $value );
} );
```

---

## Authorization Filters

### auth_{$meta_type}_meta_{$meta_key}

Filters authorization for editing a meta key.

```php
apply_filters( "auth_{$object_type}_meta_{$meta_key}", bool $allowed, string $meta_key, int $object_id, int $user_id, string $cap, string[] $caps )
```

---

### auth_{$meta_type}_meta_{$meta_key}_for_{$object_subtype}

Filters authorization for a specific subtype.

```php
apply_filters( "auth_{$object_type}_meta_{$meta_key}_for_{$object_subtype}", bool $allowed, string $meta_key, int $object_id, int $user_id, string $cap, string[] $caps )
```

**Since:** 4.9.8

---

## Registration Filter

### register_meta_args

Filters the registration arguments when registering meta.

```php
apply_filters( 'register_meta_args', array $args, array $defaults, string $object_type, string $meta_key )
```

**Since:** 4.6.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Registration arguments. |
| `$defaults` | array | Default arguments. |
| `$object_type` | string | Type of object. |
| `$meta_key` | string | Meta key being registered. |

**Example:**

```php
add_filter( 'register_meta_args', function( $args, $defaults, $object_type, $meta_key ) {
    // Force all post meta to be single
    if ( 'post' === $object_type ) {
        $args['single'] = true;
    }
    return $args;
}, 10, 4 );
```

---

## Protected Meta Filter

### is_protected_meta

Filters whether a meta key is considered protected.

```php
apply_filters( 'is_protected_meta', bool $protected, string $meta_key, string $meta_type )
```

**Since:** 3.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$protected` | bool | Whether key is protected (starts with `_`). |
| `$meta_key` | string | Metadata key. |
| `$meta_type` | string | Type of object. |

**Example:**

```php
// Make 'public_key' not protected despite starting with underscore
add_filter( 'is_protected_meta', function( $protected, $meta_key ) {
    if ( '_my_public_key' === $meta_key ) {
        return false;
    }
    return $protected;
}, 10, 2 );
```

---

## Object Subtype Filter

### get_object_subtype_{$object_type}

Filters the object subtype identifier.

```php
apply_filters( "get_object_subtype_{$object_type}", string $object_subtype, int $object_id )
```

**Since:** 4.9.8

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_subtype` | string | Object subtype. |
| `$object_id` | int | ID of the object. |

**Hook names:** `get_object_subtype_post`, `get_object_subtype_term`, `get_object_subtype_comment`, `get_object_subtype_user`, `get_object_subtype_blog`

---

## Lazy-Loader Action

### metadata_lazyloader_queued_objects

Fires after objects are added to the lazy-load queue.

```php
do_action( 'metadata_lazyloader_queued_objects', array $object_ids, string $object_type, WP_Metadata_Lazyloader $lazyloader )
```

**Since:** 4.5.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_ids` | array | Array of object IDs queued. |
| `$object_type` | string | Type of object being queued. |
| `$lazyloader` | WP_Metadata_Lazyloader | The lazy-loader instance. |
