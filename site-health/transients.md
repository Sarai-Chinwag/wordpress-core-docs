# Transients API

Temporary data storage with automatic expiration. Uses database or object cache.

**Since:** 2.8.0  
**Source:** `wp-includes/option.php`

## Core Functions

### get_transient()

Retrieves a transient value.

```php
function get_transient( string $transient ): mixed
```

**Parameters:**
- `$transient` — Transient name (not SQL-escaped)

**Returns:** Transient value, or `false` if not set/expired

**Behavior:**
1. Checks `pre_transient_{$transient}` filter (short-circuit)
2. If object cache: `wp_cache_get($transient, 'transient')`
3. If database:
   - Check if in alloptions (autoloaded, no timeout)
   - If not, check timeout and delete if expired
   - Return value from `_transient_{name}` option
4. Filter through `transient_{$transient}`

---

### set_transient()

Sets or updates a transient value.

```php
function set_transient( 
    string $transient, 
    mixed $value, 
    int $expiration = 0 
): bool
```

**Parameters:**
- `$transient` — Name (max 172 characters)
- `$value` — Value (auto-serialized if needed)
- `$expiration` — Seconds until expiration (0 = no expiration)

**Returns:** `true` on success

**Database storage:**
- No expiration: `_transient_{name}` with autoload
- With expiration: Both `_transient_{name}` and `_transient_timeout_{name}`, no autoload

---

### delete_transient()

Removes a transient.

```php
function delete_transient( string $transient ): bool
```

---

### delete_expired_transients()

Batch cleanup of expired transients. Called by WP automatically.

```php
function delete_expired_transients( bool $force_db = false ): void
```

**Note:** No-op when using external object cache (unless `$force_db = true`)

---

## Site Transients (Multisite)

Network-wide transients. On single site, stored in options table. On multisite, stored in sitemeta.

### get_site_transient()

```php
function get_site_transient( string $transient ): mixed
```

**Special cases:** `update_core`, `update_plugins`, `update_themes` have no timeout checks.

### set_site_transient()

```php
function set_site_transient( 
    string $transient, 
    mixed $value, 
    int $expiration = 0 
): bool
```

**Max length:** 167 characters

### delete_site_transient()

```php
function delete_site_transient( string $transient ): bool
```

---

## Helper Class

### WP_Feed_Cache_Transient

SimplePie cache implementation using site transients.

**Since:** 2.8.0, 6.9.0 (switched to site transients)

```php
class WP_Feed_Cache_Transient implements SimplePie\Cache\Base {
    public $name;           // feed_{hash}
    public $mod_name;       // feed_mod_{hash}
    public $lifetime;       // 43200 (12 hours default)
    
    public function save( $data );   // Store feed data
    public function load();          // Retrieve feed data
    public function mtime();         // Get modification time
    public function touch();         // Update mod time
    public function unlink();        // Delete both transients
}
```

**Filter:** `wp_feed_cache_transient_lifetime` — Customize cache duration

---

## Common Transients

| Name | Purpose | Expiration |
|------|---------|------------|
| `update_core` | Core update check data | No timeout |
| `update_plugins` | Plugin update data | No timeout |
| `update_themes` | Theme update data | No timeout |
| `health-check-site-status-result` | Site Health scores | Set by cron |
| `feed_{hash}` | RSS feed cache | 12 hours |

---

## Usage Examples

### Basic Caching

```php
// Try to get cached data
$data = get_transient( 'my_expensive_data' );

if ( false === $data ) {
    // Cache miss - generate data
    $data = expensive_operation();
    
    // Cache for 1 hour
    set_transient( 'my_expensive_data', $data, HOUR_IN_SECONDS );
}

return $data;
```

### API Response Caching

```php
function get_api_data() {
    $transient_key = 'api_response_' . md5( $api_url );
    $cached = get_transient( $transient_key );
    
    if ( false !== $cached ) {
        return $cached;
    }
    
    $response = wp_remote_get( $api_url );
    if ( is_wp_error( $response ) ) {
        return $response;
    }
    
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    set_transient( $transient_key, $data, 15 * MINUTE_IN_SECONDS );
    
    return $data;
}
```

### Invalidation on Update

```php
// Clear transient when related data changes
add_action( 'save_post', function( $post_id ) {
    delete_transient( 'recent_posts_cache' );
});
```

---

## Time Constants

Use WordPress time constants for readability:

```php
MINUTE_IN_SECONDS  // 60
HOUR_IN_SECONDS    // 3600
DAY_IN_SECONDS     // 86400
WEEK_IN_SECONDS    // 604800
MONTH_IN_SECONDS   // 2592000 (30 days)
YEAR_IN_SECONDS    // 31536000
```

---

## Object Cache Considerations

When using Redis/Memcached:

1. **Transients bypass database** — stored directly in cache
2. **No cleanup needed** — TTL handled by cache server
3. **No autoload queries** — reduced database load
4. **Cache groups:** `transient`, `site-transient`

Check with: `wp_using_ext_object_cache()`
