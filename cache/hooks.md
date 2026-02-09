# Cache Hooks

Actions and filters related to the WordPress Object Cache.

**Source:** Various WordPress core files

## Overview

The Object Cache API itself has minimal hooks. Most cache-related hooks are in components that *use* the cache (posts, terms, users, etc.). This document covers hooks that directly affect caching behavior.

---

## Cache Suspension

### wp_suspend_cache_addition

Filter that determines whether to suspend cache additions.

```php
apply_filters( 'wp_suspend_cache_addition', bool $suspend ): bool
```

**Location:** `wp-includes/functions.php` (`wp_suspend_cache_addition()`)

When suspended, `wp_cache_add()` returns `false` without adding data.

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$suspend` | `bool` | Current suspension state |

**Example:**
```php
// Temporarily suspend cache additions during import
add_filter( 'wp_suspend_cache_addition', '__return_true' );

// Do bulk import...
wp_insert_post( $post_data ); // Won't cache

// Re-enable
remove_filter( 'wp_suspend_cache_addition', '__return_true' );
```

**Related Function:**
```php
/**
 * Suspends cache additions.
 *
 * @param bool $suspend Optional. Suspends cache if true, enables if false.
 * @return bool Previous suspend setting.
 */
function wp_suspend_cache_addition( $suspend = null ) {
    static $_suspend = false;

    if ( is_bool( $suspend ) ) {
        $_suspend = $suspend;
    }

    return $_suspend;
}
```

---

### wp_suspend_cache_invalidation

Filter that determines whether to suspend cache invalidation.

```php
apply_filters( 'wp_suspend_cache_invalidation', bool $suspend ): bool
```

**Location:** `wp-includes/functions.php` (`wp_suspend_cache_invalidation()`)

When suspended, cache invalidation functions (like those triggered by post updates) are skipped.

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$suspend` | `bool` | Current suspension state |

**Example:**
```php
// Suspend invalidation during bulk operations
wp_suspend_cache_invalidation( true );

foreach ( $posts as $post ) {
    wp_update_post( $post ); // Won't trigger cache clearing
}

wp_suspend_cache_invalidation( false );

// Manually invalidate once at the end
wp_cache_flush_group( 'posts' );
```

---

## Object Cache Actions

The core `WP_Object_Cache` class doesn't fire actions, but persistent cache drop-ins may add their own. Common patterns:

### Custom: object_cache_init

```php
do_action( 'object_cache_init', WP_Object_Cache $cache );
```

Fired after cache connection is established (custom drop-in hook).

### Custom: object_cache_flush

```php
do_action( 'object_cache_flush' );
```

Fired when cache is flushed (custom drop-in hook).

---

## Cache Priming Hooks

These core hooks are useful for warming the cache:

### pre_get_posts

```php
add_action( 'pre_get_posts', function( $query ) {
    // Prime cache before main query
} );
```

### wp_loaded

```php
add_action( 'wp_loaded', function() {
    // Prime frequently-accessed data
    wp_cache_set( 'site_config', get_complex_config(), 'my_plugin' );
} );
```

---

## Core Cache Invalidation Points

While not hooks themselves, these functions trigger cache clearing and are hooked by core:

### Post Cache

```php
// After post is updated/deleted
clean_post_cache( $post_id );
```

**Clears:** `posts`, `post_meta`, related term caches

### Term Cache

```php
// After term is updated/deleted
clean_term_cache( $term_ids, $taxonomy );
```

**Clears:** `terms`, `term_meta`, term relationship caches

### User Cache

```php
// After user is updated/deleted
clean_user_cache( $user_id );
```

**Clears:** `users`, `user_meta`, `userlogins`, `useremail`, `userslugs`

### Options Cache

```php
// Options are cached in 'alloptions' key
// Automatically invalidated on add/update/delete_option()
```

---

## Cache-Related Filters

### pre_wp_cache_* (Custom Pattern)

Some drop-ins implement filters to intercept cache operations:

```php
// Example from custom drop-in
add_filter( 'pre_wp_cache_get', function( $value, $key, $group, $force, $found ) {
    // Custom logic before cache get
    return $value;
}, 10, 5 );
```

### notoptions

When an option doesn't exist, it's recorded in the `notoptions` cache to prevent repeated DB lookups:

```php
// Core uses this pattern
$notoptions = wp_cache_get( 'notoptions', 'options' );
if ( isset( $notoptions[ $option ] ) ) {
    return $default; // Known to not exist
}
```

---

## Transient Hooks

Transients use the Object Cache when available. Related hooks:

### setted_transient

```php
do_action( 'setted_transient', string $transient, mixed $value, int $expiration );
```

Fired after transient is set.

### deleted_transient

```php
do_action( 'deleted_transient', string $transient );
```

Fired after transient is deleted.

### pre_transient_{$transient}

```php
apply_filters( "pre_transient_{$transient}", mixed $pre_transient, string $transient );
```

Short-circuits transient retrieval.

### transient_{$transient}

```php
apply_filters( "transient_{$transient}", mixed $value, string $transient );
```

Filters transient value after retrieval.

---

## Multisite Cache Hooks

### switch_blog

```php
do_action( 'switch_blog', int $new_blog_id, int $prev_blog_id );
```

Triggers `wp_cache_switch_to_blog()` to update cache key prefixes.

---

## Implementing Custom Cache Hooks

When building a persistent cache drop-in, consider adding hooks:

```php
class My_Object_Cache extends WP_Object_Cache {
    
    public function set( $key, $data, $group = 'default', $expire = 0 ) {
        /**
         * Fires before data is cached.
         *
         * @param string $key   Cache key.
         * @param mixed  $data  Data to cache.
         * @param string $group Cache group.
         * @param int    $expire Expiration in seconds.
         */
        do_action( 'pre_object_cache_set', $key, $data, $group, $expire );
        
        $result = parent::set( $key, $data, $group, $expire );
        
        /**
         * Fires after data is cached.
         *
         * @param string $key    Cache key.
         * @param mixed  $data   Cached data.
         * @param string $group  Cache group.
         * @param bool   $result Whether set succeeded.
         */
        do_action( 'object_cache_set', $key, $data, $group, $result );
        
        return $result;
    }
    
    public function flush() {
        /**
         * Fires before cache is flushed.
         */
        do_action( 'pre_object_cache_flush' );
        
        $result = parent::flush();
        
        /**
         * Fires after cache is flushed.
         */
        do_action( 'object_cache_flush' );
        
        return $result;
    }
}
```

---

## Debug & Monitoring Hooks

### qm/collect (Query Monitor)

If using Query Monitor, cache data is collected automatically. Custom data:

```php
add_filter( 'qm/collect/cache', function( $cache_data ) {
    $cache_data['my_metric'] = get_my_cache_metric();
    return $cache_data;
} );
```

---

## Best Practices

### Invalidating Custom Cache

```php
// Hook into post save to invalidate related cache
add_action( 'save_post', function( $post_id ) {
    wp_cache_delete( 'my_computed_data_' . $post_id, 'my_plugin' );
    wp_cache_delete( 'related_posts_' . $post_id, 'my_plugin' );
} );
```

### Warming Cache on Cron

```php
add_action( 'my_plugin_warm_cache', function() {
    $expensive_data = compute_expensive_data();
    wp_cache_set( 'expensive_data', $expensive_data, 'my_plugin', DAY_IN_SECONDS );
} );

// Schedule if not already
if ( ! wp_next_scheduled( 'my_plugin_warm_cache' ) ) {
    wp_schedule_event( time(), 'daily', 'my_plugin_warm_cache' );
}
```

### Conditional Cache Bypass

```php
add_filter( 'pre_transient_my_data', function( $value ) {
    // Bypass cache for admins
    if ( current_user_can( 'manage_options' ) && isset( $_GET['nocache'] ) ) {
        return compute_fresh_data();
    }
    return $value;
} );
```
