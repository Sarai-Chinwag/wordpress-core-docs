# Metadata API Functions

Core functions for metadata CRUD operations and registration.

**Source:** `wp-includes/meta.php`

---

## CRUD Functions

### add_metadata()

Adds metadata for the specified object.

```php
add_metadata( string $meta_type, int $object_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. Accepts `'blog'`, `'post'`, `'comment'`, `'term'`, `'user'`, or any type with an associated meta table. |
| `$object_id` | int | ID of the object metadata is for. |
| `$meta_key` | string | Metadata key. Expected to be slashed. |
| `$meta_value` | mixed | Metadata value. Must be serializable if non-scalar. Expected to be slashed. |
| `$unique` | bool | Optional. If true and key already exists, no change is made. Default `false`. |

#### Returns

`int` meta ID on success, `false` on failure.

#### Example

```php
$meta_id = add_metadata( 'post', 123, 'my_key', 'my_value' );

// With unique constraint
add_metadata( 'post', 123, 'unique_key', 'value', true );
```

---

### update_metadata()

Updates metadata for the specified object. Adds if no value exists.

```php
update_metadata( string $meta_type, int $object_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. Accepts `'blog'`, `'post'`, `'comment'`, `'term'`, `'user'`, or any type with an associated meta table. |
| `$object_id` | int | ID of the object metadata is for. |
| `$meta_key` | string | Metadata key. Expected to be slashed. |
| `$meta_value` | mixed | Metadata value. Must be serializable if non-scalar. Expected to be slashed. |
| `$prev_value` | mixed | Optional. Only update entries with this value. Default empty string (update all). |

#### Returns

- `int` meta ID if field was added (key didn't exist)
- `true` on successful update
- `false` on failure or if new value equals existing value

#### Example

```php
// Update or add
update_metadata( 'user', 1, 'favorite_color', 'blue' );

// Update only specific previous value
update_metadata( 'post', 123, 'status', 'published', 'draft' );
```

---

### delete_metadata()

Deletes metadata for the specified object.

```php
delete_metadata( string $meta_type, int $object_id, string $meta_key, mixed $meta_value = '', bool $delete_all = false ): bool
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. Accepts `'blog'`, `'post'`, `'comment'`, `'term'`, `'user'`, or any type with an associated meta table. |
| `$object_id` | int | ID of the object metadata is for. |
| `$meta_key` | string | Metadata key. Expected to be slashed. |
| `$meta_value` | mixed | Optional. Only delete entries with this value. Pass `null`, `false`, or `''` to skip. Default empty string. |
| `$delete_all` | bool | Optional. If true, delete for all objects ignoring `$object_id`. Default `false`. |

#### Returns

`true` on success, `false` on failure.

#### Example

```php
// Delete all entries for key
delete_metadata( 'post', 123, 'my_key' );

// Delete specific value
delete_metadata( 'post', 123, 'my_key', 'specific_value' );

// Delete from all posts
delete_metadata( 'post', 0, 'deprecated_key', '', true );
```

---

### get_metadata()

Retrieves metadata value for the specified object.

```php
get_metadata( string $meta_type, int $object_id, string $meta_key = '', bool $single = false ): mixed
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. Accepts `'blog'`, `'post'`, `'comment'`, `'term'`, `'user'`, or any type with an associated meta table. |
| `$object_id` | int | ID of the object metadata is for. |
| `$meta_key` | string | Optional. Metadata key. If empty, retrieves all metadata. Default empty string. |
| `$single` | bool | Optional. If true, return first value only. No effect without `$meta_key`. Default `false`. |

#### Returns

- Array of values if `$single` is false
- Single value if `$single` is true
- `false` for invalid `$object_id` or missing `$meta_type`
- Empty array/string for valid but non-existing object ID

#### Example

```php
// Get all values for key
$values = get_metadata( 'post', 123, 'my_key' );

// Get single value
$value = get_metadata( 'post', 123, 'my_key', true );

// Get all metadata for object
$all_meta = get_metadata( 'post', 123 );
```

---

### get_metadata_raw()

Retrieves raw metadata value without applying defaults.

```php
get_metadata_raw( string $meta_type, int $object_id, string $meta_key = '', bool $single = false ): mixed
```

**Since:** 5.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Optional. Metadata key. Default empty string. |
| `$single` | bool | Optional. Return first value only. Default `false`. |

#### Returns

- Value(s) if exists
- `null` if value does not exist
- `false` for invalid parameters

---

### get_metadata_default()

Retrieves default metadata value for the specified key.

```php
get_metadata_default( string $meta_type, int $object_id, string $meta_key, bool $single = false ): mixed
```

**Since:** 5.5.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |
| `$single` | bool | Optional. Return first value only. Default `false`. |

#### Returns

- Empty string if `$single` is true (default)
- Empty array if `$single` is false (default)
- Registered default value if set via `register_meta()`

---

### metadata_exists()

Determines if a meta field exists for the given object.

```php
metadata_exists( string $meta_type, int $object_id, string $meta_key ): bool
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Metadata key. |

#### Returns

`true` if meta field exists, `false` otherwise.

---

## By Meta ID Functions

### get_metadata_by_mid()

Retrieves metadata by meta ID.

```php
get_metadata_by_mid( string $meta_type, int $meta_id ): stdClass|false
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$meta_id` | int | ID for a specific meta row. |

#### Returns

Object with properties:
- `meta_key` - The meta key
- `meta_value` - The unserialized meta value
- `meta_id` or `umeta_id` - The meta ID
- `{type}_id` - The object ID (e.g., `post_id`, `user_id`)

Returns `false` if metadata doesn't exist.

---

### update_metadata_by_mid()

Updates metadata by meta ID.

```php
update_metadata_by_mid( string $meta_type, int $meta_id, mixed $meta_value, string|false $meta_key = false ): bool
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$meta_id` | int | ID for a specific meta row. |
| `$meta_value` | mixed | Metadata value. Must be serializable if non-scalar. |
| `$meta_key` | string\|false | Optional. New meta key. Default `false` (keep original). |

#### Returns

`true` on success, `false` on failure.

---

### delete_metadata_by_mid()

Deletes metadata by meta ID.

```php
delete_metadata_by_mid( string $meta_type, int $meta_id ): bool
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$meta_id` | int | ID for a specific meta row. |

#### Returns

`true` on success, `false` on failure.

---

## Cache Functions

### update_meta_cache()

Updates the metadata cache for the specified objects.

```php
update_meta_cache( string $meta_type, string|int[] $object_ids ): array|false
```

**Since:** 2.9.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_type` | string | Type of object. |
| `$object_ids` | string\|int[] | Array or comma-delimited list of object IDs. |

#### Returns

Array of metadata keyed by object ID, or `false` on failure.

#### Example

```php
// Prime cache for multiple posts
$post_ids = array( 1, 2, 3, 4, 5 );
update_meta_cache( 'post', $post_ids );
```

---

### wp_metadata_lazyloader()

Retrieves the queue for lazy-loading metadata.

```php
wp_metadata_lazyloader(): WP_Metadata_Lazyloader
```

**Since:** 4.5.0

#### Returns

`WP_Metadata_Lazyloader` singleton instance.

#### Example

```php
$lazyloader = wp_metadata_lazyloader();
$lazyloader->queue_objects( 'term', $term_ids );
```

---

## Registration Functions

### register_meta()

Registers a meta key for an object type.

```php
register_meta( string $object_type, string $meta_key, array $args, mixed $deprecated = null ): bool
```

**Since:** 3.3.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. Accepts `'blog'`, `'post'`, `'comment'`, `'term'`, `'user'`, or any type with an associated meta table. |
| `$meta_key` | string | Meta key to register. |
| `$args` | array | Configuration array. |
| `$deprecated` | mixed | Deprecated. Use `$args` instead. |

#### Args

| Key | Type | Description |
|-----|------|-------------|
| `object_subtype` | string | Subtype (e.g., post type). Default empty (entire object type). |
| `type` | string | Data type: `'string'`, `'boolean'`, `'integer'`, `'number'`, `'array'`, `'object'`. Default `'string'`. |
| `label` | string | Human-readable label. Since 6.7.0. |
| `description` | string | Description of the data. |
| `single` | bool | Whether key has one value per object. Default `false`. |
| `default` | mixed | Default value from `get_metadata()`. Since 5.5.0. |
| `sanitize_callback` | callable | Sanitization function. |
| `auth_callback` | callable | Authorization check for capability checks. |
| `show_in_rest` | bool\|array | Expose via REST API. Can be array with `'schema'` or `'prepare_callback'`. Default `false`. |
| `revisions_enabled` | bool | Enable revisions support (post type only). Since 6.4.0. Default `false`. |

#### Returns

`true` on success, `false` on failure.

#### Example

```php
register_meta( 'post', '_my_plugin_data', array(
    'object_subtype'    => 'page',
    'type'              => 'string',
    'single'            => true,
    'default'           => '',
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function() {
        return current_user_can( 'edit_posts' );
    },
    'show_in_rest'      => true,
) );
```

---

### unregister_meta_key()

Unregisters a meta key from the list of registered keys.

```php
unregister_meta_key( string $object_type, string $meta_key, string $object_subtype = '' ): bool
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. |
| `$meta_key` | string | Metadata key. |
| `$object_subtype` | string | Optional. Object subtype. Default empty string. |

#### Returns

`true` on success, `false` if not registered.

---

### registered_meta_key_exists()

Checks if a meta key is registered.

```php
registered_meta_key_exists( string $object_type, string $meta_key, string $object_subtype = '' ): bool
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. |
| `$meta_key` | string | Metadata key. |
| `$object_subtype` | string | Optional. Object subtype. Default empty string. |

#### Returns

`true` if registered, `false` otherwise.

---

### get_registered_meta_keys()

Retrieves registered meta keys for an object type.

```php
get_registered_meta_keys( string $object_type, string $object_subtype = '' ): array[]
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. |
| `$object_subtype` | string | Optional. Object subtype. Default empty string. |

#### Returns

Array of registered meta args, keyed by meta key.

---

### get_registered_metadata()

Retrieves registered metadata for a specified object.

```php
get_registered_metadata( string $object_type, int $object_id, string $meta_key = '' ): mixed
```

**Since:** 4.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. |
| `$object_id` | int | ID of the object. |
| `$meta_key` | string | Optional. Specific key to retrieve. Default empty (all registered). |

#### Returns

- Single value or array for a key if specified
- Array of all registered keys/values if not specified
- `false` if specified key is not registered

---

## Utility Functions

### sanitize_meta()

Sanitizes a meta value.

```php
sanitize_meta( string $meta_key, mixed $meta_value, string $object_type, string $object_subtype = '' ): mixed
```

**Since:** 3.1.3

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_key` | string | Metadata key. |
| `$meta_value` | mixed | Metadata value to sanitize. |
| `$object_type` | string | Type of object. |
| `$object_subtype` | string | Optional. Object subtype. Default empty string. |

#### Returns

Sanitized `$meta_value`.

---

### is_protected_meta()

Determines whether a meta key is considered protected.

```php
is_protected_meta( string $meta_key, string $meta_type = '' ): bool
```

**Since:** 3.1.3

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_key` | string | Metadata key. |
| `$meta_type` | string | Optional. Type of object. Default empty string. |

#### Returns

`true` if key starts with `_` (underscore), `false` otherwise.

---

### get_object_subtype()

Returns the object subtype for a given object ID.

```php
get_object_subtype( string $object_type, int $object_id ): string
```

**Since:** 4.9.8

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. |
| `$object_id` | int | ID of the object. |

#### Returns

Object subtype (e.g., post type, taxonomy) or empty string.

---

### get_meta_sql()

Given a meta query, generates SQL clauses to append to a main query.

```php
get_meta_sql( array $meta_query, string $type, string $primary_table, string $primary_id_column, object $context = null ): string[]|false
```

**Since:** 3.2.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$meta_query` | array | A meta query array. |
| `$type` | string | Type of meta. |
| `$primary_table` | string | Primary database table name. |
| `$primary_id_column` | string | Primary ID column name. |
| `$context` | object | Optional. Main query object. Default `null`. |

#### Returns

Array with `'join'` and `'where'` SQL fragments, or `false` if no table exists.

---

### _get_meta_table()

Retrieves the name of the metadata table for the specified object type.

```php
_get_meta_table( string $type ): string|false
```

**Since:** 2.9.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$type` | string | Type of object. |

#### Returns

Metadata table name, or `false` if no table exists.

---

### filter_default_metadata()

Filters into `default_{$object_type}_metadata` to add default values.

```php
filter_default_metadata( mixed $value, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed
```

**Since:** 5.5.0

*Internal function. Automatically added when `register_meta()` is called with a default value.*

---

## Convenience Wrapper Functions

These functions are wrappers around the core metadata functions for specific object types.

### Post Meta

```php
add_post_meta( int $post_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false
update_post_meta( int $post_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
delete_post_meta( int $post_id, string $meta_key, mixed $meta_value = '' ): bool
get_post_meta( int $post_id, string $meta_key = '', bool $single = false ): mixed
```

### User Meta

```php
add_user_meta( int $user_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false
update_user_meta( int $user_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
delete_user_meta( int $user_id, string $meta_key, mixed $meta_value = '' ): bool
get_user_meta( int $user_id, string $meta_key = '', bool $single = false ): mixed
```

### Comment Meta

```php
add_comment_meta( int $comment_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false
update_comment_meta( int $comment_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool
delete_comment_meta( int $comment_id, string $meta_key, mixed $meta_value = '' ): bool
get_comment_meta( int $comment_id, string $meta_key = '', bool $single = false ): mixed
```

### Term Meta

```php
add_term_meta( int $term_id, string $meta_key, mixed $meta_value, bool $unique = false ): int|false|WP_Error
update_term_meta( int $term_id, string $meta_key, mixed $meta_value, mixed $prev_value = '' ): int|bool|WP_Error
delete_term_meta( int $term_id, string $meta_key, mixed $meta_value = '' ): bool
get_term_meta( int $term_id, string $meta_key = '', bool $single = false ): mixed
```
