# WP_Metadata_Lazyloader

Lazy-loads object metadata for improved performance.

**Since:** 4.5.0  
**Source:** `wp-includes/class-wp-metadata-lazyloader.php`

## Description

When loading many objects of a given type (e.g., posts in a `WP_Query` loop), priming metadata caches at the beginning with a single database query can dramatically improve performance.

Lazy-loading takes this further: metadata is only loaded when first requested, ensuring unused metadata is never fetched.

The lazyloader queues objects, then intercepts the first `get_*_meta()` call to prime the cache for all queued objects at once.

## Usage

```php
// Get the singleton instance
$lazyloader = wp_metadata_lazyloader();

// Queue term IDs for lazy-loading
$lazyloader->queue_objects( 'term', array( 1, 2, 3, 4, 5 ) );

// Later, first call to get_term_meta() triggers cache priming for ALL queued terms
$meta = get_term_meta( 3, 'my_key', true );
```

Do not instantiate this class directly. Use `wp_metadata_lazyloader()`.

## Supported Object Types

| Type | Filter Hook |
|------|-------------|
| `term` | `get_term_metadata` |
| `comment` | `get_comment_metadata` |
| `blog` | `get_blog_metadata` |

## Class Synopsis

```php
class WP_Metadata_Lazyloader {
    protected array $pending_objects;
    protected array $settings;

    public function __construct();
    public function queue_objects( string $object_type, array $object_ids ): void|WP_Error;
    public function reset_queue( string $object_type ): void|WP_Error;
    public function lazyload_meta_callback( mixed $check, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed;

    // Deprecated
    public function lazyload_term_meta( mixed $check ): mixed;
    public function lazyload_comment_meta( mixed $check ): mixed;
}
```

---

## Properties

### $pending_objects

```php
protected array $pending_objects
```

Queue of objects awaiting metadata loading, keyed by object type then object ID.

---

### $settings

```php
protected array $settings
```

Configuration for supported object types, including filter hooks and callbacks.

---

## Methods

### __construct()

Initializes the lazyloader with default settings.

```php
public function __construct()
```

Sets up filter hooks for `term`, `comment`, and `blog` object types.

---

### queue_objects()

Adds objects to the metadata lazy-load queue.

```php
public function queue_objects( string $object_type, array $object_ids ): void|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Type of object. Accepts `'term'`, `'comment'`, or `'blog'`. |
| `$object_ids` | array | Array of object IDs to queue. |

#### Returns

`void` on success, `WP_Error` if object type is invalid.

#### Example

```php
$lazyloader = wp_metadata_lazyloader();

// Queue terms
$lazyloader->queue_objects( 'term', array( 10, 20, 30 ) );

// Queue comments
$lazyloader->queue_objects( 'comment', array( 100, 101, 102 ) );
```

#### Hooks

**Action:** `metadata_lazyloader_queued_objects`

Fires after objects are added to the queue.

```php
do_action( 'metadata_lazyloader_queued_objects', array $object_ids, string $object_type, WP_Metadata_Lazyloader $lazyloader )
```

---

### reset_queue()

Resets the lazy-load queue for a given object type.

```php
public function reset_queue( string $object_type ): void|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Object type. Accepts `'term'`, `'comment'`, or `'blog'`. |

#### Returns

`void` on success, `WP_Error` if object type is invalid.

---

### lazyload_meta_callback()

Lazy-loads meta for queued objects. Filter callback.

```php
public function lazyload_meta_callback( mixed $check, int $object_id, string $meta_key, bool $single, string $meta_type ): mixed
```

**Since:** 6.3.0

This method is public for use as a filter callback. Do not invoke directly.

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$check` | mixed | The `$check` param from `get_*_metadata` hook. |
| `$object_id` | int | ID of the object metadata is for. |
| `$meta_key` | string | Unused. |
| `$single` | bool | Unused. |
| `$meta_type` | string | Type of object. Accepts `'term'`, `'comment'`, `'blog'`, etc. |

#### Returns

Original `$check` value (typically `null`) to avoid short-circuiting `get_metadata()`.

#### Behavior

1. Checks if there are pending objects for the meta type
2. Collects all queued object IDs
3. Adds the current `$object_id` if not already queued
4. Calls `update_meta_cache()` for all IDs
5. Resets the queue
6. Returns `$check` unchanged

---

### lazyload_term_meta()

Lazy-loads term meta for queued terms.

```php
public function lazyload_term_meta( mixed $check ): mixed
```

**Deprecated:** 6.3.0 — Use `lazyload_meta_callback()` instead.

---

### lazyload_comment_meta()

Lazy-loads comment meta for queued comments.

```php
public function lazyload_comment_meta( mixed $check ): mixed
```

**Deprecated:** 6.3.0 — Use `lazyload_meta_callback()` instead.

---

## How It Works

```
queue_objects( 'term', [1, 2, 3] )
    ├── Store IDs in $pending_objects['term']
    └── Add filter on 'get_term_metadata'

... later ...

get_term_meta( 2, 'some_key' )
    └── triggers 'get_term_metadata' filter
        └── lazyload_meta_callback()
            ├── Get all queued term IDs: [1, 2, 3]
            ├── update_meta_cache( 'term', [1, 2, 3] )
            ├── reset_queue( 'term' )
            └── return null (don't short-circuit)
```

After this, all term meta for IDs 1, 2, and 3 is cached. Subsequent `get_term_meta()` calls hit the cache directly.

---

## Performance Example

Without lazy-loading (N+1 problem):

```php
$terms = get_terms( array( 'taxonomy' => 'category' ) );
foreach ( $terms as $term ) {
    // Each call = separate database query
    $icon = get_term_meta( $term->term_id, 'icon', true );
}
// 50 terms = 50 queries
```

With lazy-loading:

```php
$terms = get_terms( array( 'taxonomy' => 'category' ) );
$term_ids = wp_list_pluck( $terms, 'term_id' );

// Queue all terms
wp_metadata_lazyloader()->queue_objects( 'term', $term_ids );

foreach ( $terms as $term ) {
    // First call primes cache for ALL terms
    // Subsequent calls hit cache
    $icon = get_term_meta( $term->term_id, 'icon', true );
}
// 50 terms = 1 query
```

**Note:** WordPress core automatically queues terms and comments during queries, so manual queueing is often unnecessary.
