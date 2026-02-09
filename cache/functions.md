# Cache Functions

Public API functions for the WordPress Object Cache.

**Source:** `wp-includes/cache.php`, `wp-includes/cache-compat.php`

---

## Initialization

### wp_cache_init()

Sets up the Object Cache global and assigns it.

```php
wp_cache_init(): void
```

**Since:** 2.0.0

Creates the global `$wp_object_cache` instance. Called automatically during WordPress bootstrap.

**Example:**
```php
// Typically called internally during load
wp_cache_init();

// After init, global is available
global $wp_object_cache;
```

---

## Core Operations

### wp_cache_get()

Retrieves the cache contents from the cache by key and group.

```php
wp_cache_get(
    int|string $key,
    string $group = '',
    bool $force = false,
    bool &$found = null
): mixed|false
```

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | The key under which the cache contents are stored |
| `$group` | `string` | Where the cache contents are grouped. Default `''` |
| `$force` | `bool` | Force update from persistent cache. Default `false` |
| `$found` | `bool` | (by reference) Whether key was found. Disambiguates cached `false` |

**Returns:** Cache contents on success, `false` on failure.

**Example:**
```php
// Simple get
$value = wp_cache_get( 'my_key', 'my_group' );

// Distinguish false value from cache miss
$value = wp_cache_get( 'key', 'group', false, $found );
if ( ! $found ) {
    // Key doesn't exist in cache
    $value = compute_value();
    wp_cache_set( 'key', $value, 'group' );
}
```

---

### wp_cache_set()

Saves the data to the cache. Always writes data regardless of existence.

```php
wp_cache_set(
    int|string $key,
    mixed $data,
    string $group = '',
    int $expire = 0
): bool
```

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | Cache key for later retrieval |
| `$data` | `mixed` | Contents to store |
| `$group` | `string` | Group for the cache. Default `''` |
| `$expire` | `int` | Expiration in seconds. Default `0` (no expiration) |

**Returns:** `true` on success, `false` on failure.

**Example:**
```php
// Cache for 1 hour
wp_cache_set( 'user_stats', $stats, 'my_plugin', HOUR_IN_SECONDS );

// No expiration (lives until flush or request ends)
wp_cache_set( 'config', $config, 'settings' );
```

**Note:** With the default cache, `$expire` is ignored since data doesn't persist beyond the request.

---

### wp_cache_add()

Adds data to the cache if the key doesn't already exist.

```php
wp_cache_add(
    int|string $key,
    mixed $data,
    string $group = '',
    int $expire = 0
): bool
```

**Since:** 2.0.0

**Parameters:** Same as `wp_cache_set()`.

**Returns:** `true` on success, `false` if key/group already exists.

**Example:**
```php
// Only set if not present
$added = wp_cache_add( 'lock', time(), 'my_plugin' );
if ( ! $added ) {
    // Another process already has the lock
}
```

---

### wp_cache_replace()

Replaces cache contents only if the key already exists.

```php
wp_cache_replace(
    int|string $key,
    mixed $data,
    string $group = '',
    int $expire = 0
): bool
```

**Since:** 2.0.0

**Parameters:** Same as `wp_cache_set()`.

**Returns:** `true` if replaced, `false` if original doesn't exist.

**Example:**
```php
// Update only if exists
$replaced = wp_cache_replace( 'session_data', $new_data, 'sessions' );
if ( ! $replaced ) {
    // Session doesn't exist yet
    wp_cache_add( 'session_data', $new_data, 'sessions' );
}
```

---

### wp_cache_delete()

Removes the cache contents matching key and group.

```php
wp_cache_delete(
    int|string $key,
    string $group = ''
): bool
```

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | Cache key to delete |
| `$group` | `string` | Cache group. Default `''` |

**Returns:** `true` on success, `false` on failure.

**Example:**
```php
// Delete specific entry
wp_cache_delete( 'user_123', 'user_data' );

// After updating post, invalidate cache
wp_cache_delete( $post_id, 'posts' );
```

---

## Batch Operations

### wp_cache_get_multiple()

Retrieves multiple values from the cache in one call.

```php
wp_cache_get_multiple(
    array $keys,
    string $group = '',
    bool $force = false
): array
```

**Since:** 5.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$keys` | `array` | Array of cache keys |
| `$group` | `string` | Cache group. Default `''` |
| `$force` | `bool` | Force update from persistent cache. Default `false` |

**Returns:** Array of values keyed by cache key. Missing keys return `false`.

**Example:**
```php
$post_ids = array( 1, 2, 3, 4, 5 );
$posts = wp_cache_get_multiple( $post_ids, 'posts' );

foreach ( $posts as $id => $post ) {
    if ( false === $post ) {
        // Not in cache, need to fetch
    }
}
```

---

### wp_cache_set_multiple()

Sets multiple values to the cache in one call.

```php
wp_cache_set_multiple(
    array $data,
    string $group = '',
    int $expire = 0
): bool[]
```

**Since:** 6.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$data` | `array` | Key-value pairs to set |
| `$group` | `string` | Cache group. Default `''` |
| `$expire` | `int` | Expiration in seconds. Default `0` |

**Returns:** Array of booleans keyed by cache key.

**Example:**
```php
$data = array(
    'post_1' => $post1,
    'post_2' => $post2,
    'post_3' => $post3,
);
$results = wp_cache_set_multiple( $data, 'posts', HOUR_IN_SECONDS );
```

---

### wp_cache_add_multiple()

Adds multiple values if keys don't already exist.

```php
wp_cache_add_multiple(
    array $data,
    string $group = '',
    int $expire = 0
): bool[]
```

**Since:** 6.0.0

**Parameters:** Same as `wp_cache_set_multiple()`.

**Returns:** Array of booleans. `false` where key already exists.

---

### wp_cache_delete_multiple()

Deletes multiple values from the cache.

```php
wp_cache_delete_multiple(
    array $keys,
    string $group = ''
): bool[]
```

**Since:** 6.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$keys` | `array` | Keys to delete |
| `$group` | `string` | Cache group. Default `''` |

**Returns:** Array of booleans keyed by cache key.

**Example:**
```php
$keys = array( 'item_1', 'item_2', 'item_3' );
wp_cache_delete_multiple( $keys, 'my_group' );
```

---

## Numeric Operations

### wp_cache_incr()

Increments a numeric cache item's value.

```php
wp_cache_incr(
    int|string $key,
    int $offset = 1,
    string $group = ''
): int|false
```

**Since:** 3.3.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | Cache key to increment |
| `$offset` | `int` | Amount to increment by. Default `1` |
| `$group` | `string` | Cache group. Default `''` |

**Returns:** New value on success, `false` on failure. Non-numeric values become `0` before incrementing.

**Example:**
```php
// Initialize counter
wp_cache_set( 'page_views', 0, 'stats' );

// Increment
$new_count = wp_cache_incr( 'page_views', 1, 'stats' ); // Returns 1
$new_count = wp_cache_incr( 'page_views', 5, 'stats' ); // Returns 6
```

---

### wp_cache_decr()

Decrements a numeric cache item's value.

```php
wp_cache_decr(
    int|string $key,
    int $offset = 1,
    string $group = ''
): int|false
```

**Since:** 3.3.0

**Parameters:** Same as `wp_cache_incr()`.

**Returns:** New value on success (minimum `0`), `false` on failure.

**Example:**
```php
wp_cache_set( 'stock', 10, 'inventory' );

$remaining = wp_cache_decr( 'stock', 1, 'inventory' ); // Returns 9
$remaining = wp_cache_decr( 'stock', 20, 'inventory' ); // Returns 0 (not -11)
```

---

## Flush Operations

### wp_cache_flush()

Removes all cache items.

```php
wp_cache_flush(): bool
```

**Since:** 2.0.0

**Returns:** `true` on success, `false` on failure.

**Example:**
```php
// Clear everything (use sparingly!)
wp_cache_flush();
```

**Warning:** This clears the entire cache. Use with caution in production.

---

### wp_cache_flush_runtime()

Removes all cache items from in-memory runtime cache only.

```php
wp_cache_flush_runtime(): bool
```

**Since:** 6.0.0

**Returns:** `true` on success, `false` on failure.

With persistent backends, this clears only the local PHP array, not the external cache. Useful for long-running processes.

**Example:**
```php
// In a CLI command processing many items
foreach ( $large_dataset as $item ) {
    process( $item );
    
    // Periodically clear memory
    if ( $i % 1000 === 0 ) {
        wp_cache_flush_runtime();
    }
}
```

---

### wp_cache_flush_group()

Removes all cache items in a specific group.

```php
wp_cache_flush_group( string $group ): bool
```

**Since:** 6.1.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$group` | `string` | Group name to flush |

**Returns:** `true` if flushed, `false` otherwise.

**Example:**
```php
// Check support first
if ( wp_cache_supports( 'flush_group' ) ) {
    wp_cache_flush_group( 'my_plugin' );
}
```

---

## Group Management

### wp_cache_add_global_groups()

Adds groups to the list of global (network-wide) groups.

```php
wp_cache_add_global_groups( string|string[] $groups ): void
```

**Since:** 2.6.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$groups` | `string\|string[]` | Group or array of groups |

Global groups are shared across all sites in a multisite network.

**Example:**
```php
// In sunrise.php or object-cache.php
wp_cache_add_global_groups( array(
    'users',
    'userlogins', 
    'usermeta',
    'site-transient',
    'my_plugin_global',
) );
```

---

### wp_cache_add_non_persistent_groups()

Adds groups that should not be persisted.

```php
wp_cache_add_non_persistent_groups( string|string[] $groups ): void
```

**Since:** 2.6.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$groups` | `string\|string[]` | Group or array of groups |

Tells persistent cache backends to skip these groups.

**Example:**
```php
// Request-specific data that shouldn't persist
wp_cache_add_non_persistent_groups( array(
    'counts',
    'request_data',
    'temporary',
) );
```

**Note:** With the default non-persistent cache, this function does nothing.

---

## Multisite

### wp_cache_switch_to_blog()

Switches the internal blog ID for cache key generation.

```php
wp_cache_switch_to_blog( int $blog_id ): void
```

**Since:** 3.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$blog_id` | `int` | Site ID to switch to |

Changes the blog prefix used in non-global cache keys.

**Example:**
```php
// Cache for current site
wp_cache_set( 'option', $value, 'options' ); // Key: 1:option (on site 1)

// Switch context
wp_cache_switch_to_blog( 2 );
wp_cache_set( 'option', $other_value, 'options' ); // Key: 2:option
```

---

### wp_cache_reset()

**Deprecated.** Use `wp_cache_switch_to_blog()` instead.

```php
wp_cache_reset(): void
```

**Since:** 3.0.0  
**Deprecated:** 3.5.0

---

## Feature Detection

### wp_cache_supports()

Determines whether the cache implementation supports a feature.

```php
wp_cache_supports( string $feature ): bool
```

**Since:** 6.1.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$feature` | `string` | Feature name to check |

**Supported Features:**

| Feature | Description |
|---------|-------------|
| `add_multiple` | Batch add support |
| `set_multiple` | Batch set support |
| `get_multiple` | Batch get support |
| `delete_multiple` | Batch delete support |
| `flush_runtime` | Runtime-only flush |
| `flush_group` | Per-group flush |

**Example:**
```php
if ( wp_cache_supports( 'get_multiple' ) ) {
    $results = wp_cache_get_multiple( $keys, 'group' );
} else {
    $results = array();
    foreach ( $keys as $key ) {
        $results[ $key ] = wp_cache_get( $key, 'group' );
    }
}
```

---

## Connection

### wp_cache_close()

Closes the cache connection.

```php
wp_cache_close(): true
```

**Since:** 2.0.0

**Returns:** Always `true`.

This function does nothing in the default implementation. Persistent cache backends may use it to close connections.

---

## Salted Cache

Salted cache functions add version validation for cache invalidation without flushing.

### wp_cache_get_salted()

Retrieves cached data only if salt matches.

```php
wp_cache_get_salted(
    string $cache_key,
    string $group,
    string|string[] $salt
): mixed|false
```

**Since:** 6.9.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$cache_key` | `string` | Cache key |
| `$group` | `string` | Cache group |
| `$salt` | `string\|string[]` | Version salt (e.g., timestamp) |

**Returns:** Cached data if valid, `false` if outdated or missing.

**Example:**
```php
$salt = get_option( 'posts_last_modified' );
$data = wp_cache_get_salted( 'all_posts', 'my_plugin', $salt );

if ( false === $data ) {
    $data = expensive_query();
    wp_cache_set_salted( 'all_posts', $data, 'my_plugin', $salt );
}
```

---

### wp_cache_set_salted()

Stores data with a salt for version-based invalidation.

```php
wp_cache_set_salted(
    string $cache_key,
    mixed $data,
    string $group,
    string|string[] $salt,
    int $expire = 0
): bool
```

**Since:** 6.9.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$cache_key` | `string` | Cache key |
| `$data` | `mixed` | Data to cache |
| `$group` | `string` | Cache group |
| `$salt` | `string\|string[]` | Version salt |
| `$expire` | `int` | Expiration in seconds. Default `0` |

**Returns:** `true` on success, `false` on failure.

---

### wp_cache_get_multiple_salted()

Retrieves multiple salted cache items.

```php
wp_cache_get_multiple_salted(
    array $cache_keys,
    string $group,
    string|string[] $salt
): array
```

**Since:** 6.9.0

**Returns:** Array of values. Invalid/outdated entries return `false`.

---

### wp_cache_set_multiple_salted()

Stores multiple items with salt.

```php
wp_cache_set_multiple_salted(
    array $data,
    string $group,
    string|string[] $salt,
    int $expire = 0
): bool[]
```

**Since:** 6.9.0

**Returns:** Array of booleans keyed by cache key.
