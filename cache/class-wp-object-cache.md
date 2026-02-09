# WP_Object_Cache

Core class that implements an in-memory object cache.

**Since:** 2.0.0  
**Source:** `wp-includes/class-wp-object-cache.php`

## Description

The WordPress Object Cache stores data in memory to reduce database queries. It uses a key/group system to namespace cache entries.

The default implementation stores data in a PHP array, meaning data persists only for the current request. For true persistence, a drop-in at `wp-content/object-cache.php` can replace this class with Redis, Memcached, or other backends.

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Object_Cache {
    // Properties
    private array $cache = array();
    public int $cache_hits = 0;
    public int $cache_misses = 0;
    protected array $global_groups = array();
    private string $blog_prefix;
    private bool $multisite;
    
    // Methods
    public function __construct()
    public function add( $key, $data, $group = 'default', $expire = 0 ): bool
    public function add_multiple( array $data, $group = '', $expire = 0 ): array
    public function replace( $key, $data, $group = 'default', $expire = 0 ): bool
    public function set( $key, $data, $group = 'default', $expire = 0 ): bool
    public function set_multiple( array $data, $group = '', $expire = 0 ): array
    public function get( $key, $group = 'default', $force = false, &$found = null ): mixed
    public function get_multiple( $keys, $group = 'default', $force = false ): array
    public function delete( $key, $group = 'default', $deprecated = false ): bool
    public function delete_multiple( array $keys, $group = '' ): array
    public function incr( $key, $offset = 1, $group = 'default' ): int|false
    public function decr( $key, $offset = 1, $group = 'default' ): int|false
    public function flush(): bool
    public function flush_group( $group ): bool
    public function add_global_groups( $groups ): void
    public function switch_to_blog( $blog_id ): void
    public function reset(): void  // Deprecated
    public function stats(): void
    protected function is_valid_key( $key ): bool
    protected function _exists( $key, $group ): bool
}
```

---

## Properties

### $cache

```php
private array $cache = array();
```

Holds all cached objects. Structure: `$cache[ $group ][ $key ] = $value`

**Since:** 2.0.0

---

### $cache_hits

```php
public int $cache_hits = 0;
```

Number of times cache returned a stored value.

**Since:** 2.5.0

---

### $cache_misses

```php
public int $cache_misses = 0;
```

Number of times a key was not found in cache.

**Since:** 2.0.0

---

### $global_groups

```php
protected array $global_groups = array();
```

List of global cache groups (shared across multisite network).

**Since:** 3.0.0

---

### $blog_prefix

```php
private string $blog_prefix;
```

Prefix prepended to keys in non-global groups. Format: `{blog_id}:` in multisite, empty string otherwise.

**Since:** 3.5.0

---

### $multisite

```php
private bool $multisite;
```

Whether WordPress is running in multisite mode.

**Since:** 3.5.0

---

## Methods

### __construct()

```php
public function __construct()
```

Sets up object properties, detecting multisite and setting blog prefix.

**Since:** 2.0.8

---

### add()

```php
public function add( 
    int|string $key, 
    mixed $data, 
    string $group = 'default', 
    int $expire = 0 
): bool
```

Adds data to the cache if it doesn't already exist.

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | Cache key |
| `$data` | `mixed` | Data to store |
| `$group` | `string` | Cache group. Default `'default'` |
| `$expire` | `int` | Expiration (ignored in default implementation) |

**Returns:** `true` on success, `false` if key exists or cache addition is suspended.

**Behavior:**
1. Checks `wp_suspend_cache_addition()` - returns `false` if suspended
2. Validates key with `is_valid_key()`
3. Applies blog prefix for non-global groups in multisite
4. Checks if key exists with `_exists()`
5. Calls `set()` if key doesn't exist

---

### add_multiple()

```php
public function add_multiple( 
    array $data, 
    string $group = '', 
    int $expire = 0 
): bool[]
```

Adds multiple values in one call.

**Since:** 6.0.0

**Returns:** Array of booleans keyed by cache key.

---

### replace()

```php
public function replace( 
    int|string $key, 
    mixed $data, 
    string $group = 'default', 
    int $expire = 0 
): bool
```

Replaces cache contents only if key exists.

**Since:** 2.0.0

**Returns:** `true` if replaced, `false` if original doesn't exist.

---

### set()

```php
public function set( 
    int|string $key, 
    mixed $data, 
    string $group = 'default', 
    int $expire = 0 
): bool
```

Sets data in the cache. Always writes regardless of existence.

**Since:** 2.0.0  
**Modified:** 6.1.0 - Returns `false` for invalid keys

**Behavior:**
1. Validates key
2. Defaults empty group to `'default'`
3. Applies blog prefix for non-global groups
4. Clones objects to prevent reference issues
5. Stores in `$this->cache[ $group ][ $key ]`

**Note:** The `$expire` parameter is not used in the default implementation since cache dies with request.

---

### set_multiple()

```php
public function set_multiple( 
    array $data, 
    string $group = '', 
    int $expire = 0 
): bool[]
```

Sets multiple values in one call.

**Since:** 6.0.0

---

### get()

```php
public function get( 
    int|string $key, 
    string $group = 'default', 
    bool $force = false, 
    bool &$found = null 
): mixed|false
```

Retrieves cache contents.

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$key` | `int\|string` | Cache key |
| `$group` | `string` | Cache group. Default `'default'` |
| `$force` | `bool` | Unused in default implementation |
| `$found` | `bool` | Set to `true` if found, `false` otherwise |

**Returns:** Cached value on success, `false` on failure.

**Behavior:**
1. Validates key
2. Applies blog prefix for non-global groups
3. Checks existence with `_exists()`
4. On hit: increments `cache_hits`, clones objects, returns value
5. On miss: increments `cache_misses`, returns `false`

---

### get_multiple()

```php
public function get_multiple( 
    array $keys, 
    string $group = 'default', 
    bool $force = false 
): array
```

Retrieves multiple values in one call.

**Since:** 5.5.0

---

### delete()

```php
public function delete( 
    int|string $key, 
    string $group = 'default', 
    bool $deprecated = false 
): bool
```

Removes a cache entry.

**Since:** 2.0.0

**Returns:** `true` on success, `false` if key doesn't exist.

---

### delete_multiple()

```php
public function delete_multiple( 
    array $keys, 
    string $group = '' 
): bool[]
```

Deletes multiple keys in one call.

**Since:** 6.0.0

---

### incr()

```php
public function incr( 
    int|string $key, 
    int $offset = 1, 
    string $group = 'default' 
): int|false
```

Increments a numeric cache value.

**Since:** 3.3.0

**Behavior:**
- Non-numeric values are treated as `0` before incrementing
- Result cannot go below `0`

**Returns:** New value on success, `false` if key doesn't exist.

---

### decr()

```php
public function decr( 
    int|string $key, 
    int $offset = 1, 
    string $group = 'default' 
): int|false
```

Decrements a numeric cache value.

**Since:** 3.3.0

**Behavior:**
- Non-numeric values are treated as `0`
- Result floors at `0` (never negative)

---

### flush()

```php
public function flush(): true
```

Clears the entire cache.

**Since:** 2.0.0

**Returns:** Always `true`.

---

### flush_group()

```php
public function flush_group( string $group ): true
```

Removes all cache items in a group.

**Since:** 6.1.0

**Returns:** Always `true`.

---

### add_global_groups()

```php
public function add_global_groups( string|string[] $groups ): void
```

Registers groups as global (shared across multisite network).

**Since:** 3.0.0

Keys in global groups are not prefixed with blog ID.

---

### switch_to_blog()

```php
public function switch_to_blog( int $blog_id ): void
```

Changes the blog ID used for key prefixing.

**Since:** 3.5.0

---

### reset()

```php
public function reset(): void
```

**Deprecated:** 3.5.0. Use `switch_to_blog()`.

Clears non-global caches when blog ID changes.

---

### stats()

```php
public function stats(): void
```

Outputs cache statistics (hits, misses, group sizes).

**Since:** 2.0.0

**Example Output:**
```html
<p>
<strong>Cache Hits:</strong> 523<br />
<strong>Cache Misses:</strong> 47<br />
</p>
<ul>
<li><strong>Group:</strong> posts - ( 125.43k )</li>
<li><strong>Group:</strong> options - ( 45.21k )</li>
</ul>
```

---

### is_valid_key()

```php
protected function is_valid_key( int|string $key ): bool
```

Validates a cache key.

**Since:** 6.1.0

**Valid Keys:**
- Integers
- Non-empty strings

**Invalid Keys:**
- Empty strings
- Non-string, non-integer types

Triggers `_doing_it_wrong()` for invalid keys.

---

### _exists()

```php
protected function _exists( int|string $key, string $group ): bool
```

Checks if a key exists in the cache.

**Since:** 3.4.0

Uses both `isset()` and `array_key_exists()` to handle `null` values.

---

## Magic Methods

The class uses `#[AllowDynamicProperties]` and implements magic methods for backward compatibility:

```php
public function __get( $name )    // Read private properties
public function __set( $name, $value )  // Write private properties
public function __isset( $name )  // Check if property set
public function __unset( $name )  // Unset property
```

**Since:** 4.0.0

This allows external access to private properties like `$cache` for debugging:

```php
global $wp_object_cache;
var_dump( $wp_object_cache->cache ); // Works via __get()
```

---

## Implementing a Drop-in

To create a persistent cache, place `object-cache.php` in `wp-content/`:

```php
<?php
/**
 * Object Cache Drop-in
 */

class WP_Object_Cache {
    private $local_cache = array();
    private $redis;
    
    public function __construct() {
        $this->redis = new Redis();
        $this->redis->connect( '127.0.0.1', 6379 );
    }
    
    public function get( $key, $group = 'default', $force = false, &$found = null ) {
        $cache_key = $this->build_key( $key, $group );
        
        // Check local cache first
        if ( ! $force && isset( $this->local_cache[ $cache_key ] ) ) {
            $found = true;
            return $this->local_cache[ $cache_key ];
        }
        
        // Check Redis
        $value = $this->redis->get( $cache_key );
        if ( false !== $value ) {
            $found = true;
            $this->local_cache[ $cache_key ] = unserialize( $value );
            return $this->local_cache[ $cache_key ];
        }
        
        $found = false;
        return false;
    }
    
    public function set( $key, $data, $group = 'default', $expire = 0 ) {
        $cache_key = $this->build_key( $key, $group );
        
        $this->local_cache[ $cache_key ] = $data;
        
        if ( $expire > 0 ) {
            return $this->redis->setex( $cache_key, $expire, serialize( $data ) );
        }
        return $this->redis->set( $cache_key, serialize( $data ) );
    }
    
    // ... implement remaining methods
}

function wp_cache_init() {
    $GLOBALS['wp_object_cache'] = new WP_Object_Cache();
}

// ... implement all wp_cache_* functions
```

The drop-in must implement all the functions from `cache.php` as WordPress expects them to exist.
