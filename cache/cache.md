# Cache API

In-memory object caching system for reducing database queries and expensive computations.

**Since:** 2.0.0  
**Source:** `wp-includes/cache.php`, `wp-includes/class-wp-object-cache.php`, `wp-includes/cache-compat.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Public cache functions |
| [class-wp-object-cache.md](./class-wp-object-cache.md) | Core cache implementation |
| [hooks.md](./hooks.md) | Cache-related hooks and filters |

## Architecture

### Cache Layers

WordPress employs a multi-layer caching strategy:

```
┌─────────────────────────────────────────────┐
│           Application Layer                  │
│    wp_cache_get(), wp_cache_set(), etc.     │
└──────────────────────┬──────────────────────┘
                       │
┌──────────────────────▼──────────────────────┐
│          WP_Object_Cache (default)          │
│         In-memory PHP array storage         │
│       Lives only for single request         │
└──────────────────────┬──────────────────────┘
                       │
        ┌──────────────┴──────────────┐
        ▼                             ▼
┌───────────────────┐      ┌───────────────────┐
│   Drop-in Cache   │      │ Transients API    │
│ (wp-content/      │      │ (persistent via   │
│  object-cache.php)│      │  database)        │
│  Redis, Memcached │      │                   │
└───────────────────┘      └───────────────────┘
```

### Default Behavior

The built-in `WP_Object_Cache` stores data in a PHP array (`$this->cache`). This means:

- **Request-scoped**: Data persists only during a single PHP request
- **No persistence**: Cache is rebuilt on every page load
- **No expiration**: The `$expire` parameter is ignored (cache dies with request)
- **No network overhead**: Simple array operations

### Persistent Cache Drop-ins

For true persistence, install an object cache drop-in at `wp-content/object-cache.php`. Popular implementations:

| Backend | Use Case |
|---------|----------|
| **Redis** | High-performance, supports data structures |
| **Memcached** | Distributed caching, horizontal scaling |
| **APCu** | Single-server, PHP user cache |
| **SQLite** | Simple persistence without external services |

When a drop-in exists, `wp-includes/cache.php` is **not loaded** and the drop-in's implementation handles all cache operations.

## Cache Groups

Groups namespace cache keys, allowing the same key in different contexts:

```php
// These don't conflict:
wp_cache_set( 'data', $post_data, 'posts' );
wp_cache_set( 'data', $user_data, 'users' );

// Retrieve separately:
$post = wp_cache_get( 'data', 'posts' );
$user = wp_cache_get( 'data', 'users' );
```

### WordPress Core Groups

| Group | Contents |
|-------|----------|
| `default` | Ungrouped cache items |
| `posts` | Post objects |
| `post_meta` | Post metadata |
| `terms` | Term objects |
| `term_meta` | Term metadata |
| `users` | User objects |
| `user_meta` | User metadata |
| `options` | Options (alloptions) |
| `site-options` | Network options (multisite) |
| `comment` | Comment objects |
| `counts` | Various count caches |
| `plugins` | Plugin data |
| `themes` | Theme data |
| `site-transient` | Network transients |
| `transient` | Site transients |

### Global Groups (Multisite)

In multisite, most cache keys are prefixed with the blog ID. **Global groups** are shared across all sites:

```php
// Register global groups (typically in sunrise.php or object-cache.php)
wp_cache_add_global_groups( array(
    'users',
    'userlogins',
    'usermeta',
    'user_meta',
    'useremail',
    'userslugs',
    'site-transient',
    'site-options',
    'blog-lookup',
    'blog-details',
    'site-details',
    'rss',
    'global-posts',
    'blog-id-cache',
) );
```

### Non-Persistent Groups

Some groups should never persist (e.g., request-specific data):

```php
wp_cache_add_non_persistent_groups( array( 'comment', 'counts' ) );
```

This tells persistent cache backends to skip storing these groups.

## Key Generation

### Single Site

Keys are used as-is:
```
cache[group][key] = value
```

### Multisite

Non-global group keys are prefixed with blog ID:
```
cache[group][{blog_id}:{key}] = value
```

Global group keys remain unprefixed:
```
cache[global_group][key] = value
```

## Cache Lifecycle

### Request Flow

```
1. wp_cache_init()
   └── Creates $wp_object_cache global

2. During request
   ├── wp_cache_get() → cache hit → return data
   └── wp_cache_get() → cache miss → query DB → wp_cache_set()

3. Request ends
   └── PHP garbage collection destroys $wp_object_cache
```

### With Persistent Backend

```
1. wp_cache_init()
   └── Connects to Redis/Memcached

2. wp_cache_get()
   ├── Check local cache (in-memory)
   └── If miss, check persistent backend

3. wp_cache_set()
   ├── Update local cache
   └── Write to persistent backend

4. Request ends
   └── Connection closed, local cache destroyed
       Persistent data survives
```

## Cache Statistics

Track cache efficiency via `WP_Object_Cache` properties:

```php
global $wp_object_cache;

echo "Hits: " . $wp_object_cache->cache_hits;
echo "Misses: " . $wp_object_cache->cache_misses;

// Hit ratio
$total = $wp_object_cache->cache_hits + $wp_object_cache->cache_misses;
$ratio = $total > 0 ? $wp_object_cache->cache_hits / $total : 0;
echo "Hit ratio: " . round( $ratio * 100, 2 ) . "%";
```

## Feature Detection

Check what the current cache implementation supports:

```php
// Check before using batch operations
if ( wp_cache_supports( 'get_multiple' ) ) {
    $results = wp_cache_get_multiple( $keys, 'my_group' );
}

// Supported features:
// - add_multiple
// - set_multiple
// - get_multiple
// - delete_multiple
// - flush_runtime
// - flush_group
```

## Salted Cache (6.9.0+)

For cache invalidation without flushing, use salted cache functions:

```php
// Store with a salt (timestamp or version)
$salt = get_option( 'my_data_version', '1.0' );
wp_cache_set_salted( 'my_key', $data, 'my_group', $salt );

// Retrieve - returns false if salt changed
$data = wp_cache_get_salted( 'my_key', 'my_group', $salt );

// Invalidate by updating salt
update_option( 'my_data_version', '1.1' );
// Next get_salted() will return false, forcing refresh
```

## Best Practices

### Do

```php
// Use groups to namespace
wp_cache_set( $post_id, $data, 'my_plugin_posts' );

// Check if cache is available before expensive operations
$cached = wp_cache_get( 'expensive_result', 'my_plugin' );
if ( false === $cached ) {
    $cached = expensive_calculation();
    wp_cache_set( 'expensive_result', $cached, 'my_plugin', HOUR_IN_SECONDS );
}

// Use batch operations for multiple items
$results = wp_cache_get_multiple( $ids, 'posts' );

// Distinguish false from cache miss
$value = wp_cache_get( 'key', 'group', false, $found );
if ( ! $found ) {
    // Actually not in cache (vs cached false value)
}
```

### Don't

```php
// Don't cache very large data
wp_cache_set( 'huge', str_repeat( 'x', 10 * MB_IN_BYTES ), 'group' );

// Don't assume persistence
// The default cache doesn't persist!

// Don't use empty keys
wp_cache_set( '', $data, 'group' ); // Invalid!

// Don't rely on expiration with default cache
// Expiration only works with persistent backends
```

## Related APIs

| API | Purpose |
|-----|---------|
| **Transients API** | Persistent cache with DB fallback |
| **Site Transients** | Network-wide transients (multisite) |
| **Fragment Cache** | Cache rendered HTML fragments |
