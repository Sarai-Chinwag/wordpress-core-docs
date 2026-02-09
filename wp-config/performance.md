# Performance Settings

WordPress provides several constants to control memory usage, caching, cron behavior, and script handling for optimal performance.

## Memory Limits

### WP_MEMORY_LIMIT

```php
define( 'WP_MEMORY_LIMIT', '256M' );
```

- **Type**: String
- **Default**: `40M` (single site), `64M` (multisite)
- **Purpose**: Maximum memory WordPress can use for frontend operations
- **Format**: Number followed by M (megabytes) or G (gigabytes)
- **Note**: Cannot exceed PHP's `memory_limit` setting

#### Common Values

| Value | Use Case |
|-------|----------|
| `64M` | Basic sites, few plugins |
| `128M` | Standard sites |
| `256M` | Complex sites, page builders, WooCommerce |
| `512M` | Heavy sites, large imports, image processing |

### WP_MAX_MEMORY_LIMIT

```php
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
```

- **Type**: String
- **Default**: `256M`
- **Purpose**: Maximum memory for admin-side operations
- **Use Case**: Image uploads, imports, plugin operations
- **Note**: Admin tasks often need more memory than frontend

### Memory Limit Example

```php
// Frontend: 256MB, Admin: 512MB
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );
```

### Checking PHP Memory Limit

```bash
php -i | grep memory_limit
```

WordPress can only use up to PHP's limit:

```php
// If PHP limit is 128M, this won't work
define( 'WP_MEMORY_LIMIT', '256M' ); // Silently limited to 128M
```

## Object Caching

### WP_CACHE

```php
define( 'WP_CACHE', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Enables advanced caching functionality
- **Effect**: Loads `wp-content/advanced-cache.php` if it exists
- **Note**: Typically set by caching plugins (W3 Total Cache, WP Super Cache, etc.)

#### How It Works

1. WordPress checks for `WP_CACHE` constant
2. If true, loads `wp-content/advanced-cache.php`
3. Caching plugin's drop-in handles page caching
4. Cached content served without full WordPress load

#### Manual advanced-cache.php

```php
<?php
// wp-content/advanced-cache.php
// Custom caching logic
$cache_file = WP_CONTENT_DIR . '/cache/' . md5( $_SERVER['REQUEST_URI'] ) . '.html';

if ( file_exists( $cache_file ) && ! is_user_logged_in() ) {
    readfile( $cache_file );
    exit;
}
```

### Object Cache Drop-In

For persistent object caching (Redis, Memcached):

```php
// wp-content/object-cache.php
// Provided by Redis Object Cache or similar plugins
```

Common object cache plugins:
- Redis Object Cache
- Memcached Object Cache
- LiteSpeed Cache

## Cron Settings

WordPress uses a pseudo-cron system triggered by page visits.

### DISABLE_WP_CRON

```php
define( 'DISABLE_WP_CRON', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Disables WordPress's built-in cron system
- **Use Case**: Replace with real system cron for better reliability

#### Why Disable WP-Cron?

1. **Performance**: Each page load checks for due cron jobs
2. **Reliability**: Low-traffic sites may miss scheduled tasks
3. **Control**: System cron runs on exact schedule
4. **Timeouts**: Long cron jobs don't affect page loads

#### Setting Up System Cron

**Linux crontab:**
```bash
# Run WordPress cron every 5 minutes
*/5 * * * * curl -s https://example.com/wp-cron.php?doing_wp_cron > /dev/null 2>&1

# Or using wget
*/5 * * * * wget -q -O - https://example.com/wp-cron.php?doing_wp_cron > /dev/null 2>&1

# Or using WP-CLI
*/5 * * * * cd /var/www/html && wp cron event run --due-now > /dev/null 2>&1
```

### ALTERNATE_WP_CRON

```php
define( 'ALTERNATE_WP_CRON', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Uses alternate cron method via redirect
- **Use Case**: When standard cron fails due to server configuration
- **Effect**: Fires cron via JavaScript redirect instead of background request

### WP_CRON_LOCK_TIMEOUT

```php
define( 'WP_CRON_LOCK_TIMEOUT', 60 );
```

- **Type**: Integer (seconds)
- **Default**: `60`
- **Purpose**: Minimum time between cron process spawns
- **Effect**: Prevents multiple cron processes from overlapping

## Script and Style Optimization

### CONCATENATE_SCRIPTS

```php
define( 'CONCATENATE_SCRIPTS', true );
```

- **Type**: Boolean
- **Default**: `true` (admin), varies (frontend)
- **Purpose**: Combines admin JavaScript files into fewer HTTP requests
- **Effect When True**: Reduces HTTP requests in wp-admin
- **Note**: Disabled automatically when `SCRIPT_DEBUG` is true

### COMPRESS_SCRIPTS

```php
define( 'COMPRESS_SCRIPTS', true );
```

- **Type**: Boolean
- **Default**: `true`
- **Purpose**: Compresses JavaScript output using gzip
- **Effect**: Smaller script payloads

### COMPRESS_CSS

```php
define( 'COMPRESS_CSS', true );
```

- **Type**: Boolean
- **Default**: `true`
- **Purpose**: Compresses CSS output using gzip
- **Effect**: Smaller stylesheet payloads

### ENFORCE_GZIP

```php
define( 'ENFORCE_GZIP', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Forces gzip encoding when outputting compressed scripts

### Performance Optimization Example

```php
// Production performance settings
define( 'CONCATENATE_SCRIPTS', true );
define( 'COMPRESS_SCRIPTS', true );
define( 'COMPRESS_CSS', true );
define( 'ENFORCE_GZIP', true );

// Disable emoji script
define( 'DISABLE_WP_EMOJI', true ); // Custom - not core, but commonly added
```

## Content Settings Affecting Performance

### WP_POST_REVISIONS

```php
define( 'WP_POST_REVISIONS', 5 );
```

- **Type**: Boolean or Integer
- **Default**: `true` (unlimited revisions)
- **Purpose**: Controls post revision storage
- **Values**:
  - `true` - Unlimited revisions (default)
  - `false` - Disable revisions entirely
  - Integer - Maximum number of revisions to keep

#### Revision Settings

| Value | Effect |
|-------|--------|
| `true` | Unlimited revisions (database bloat over time) |
| `false` | No revisions saved |
| `3` | Keep only last 3 revisions per post |
| `10` | Keep last 10 revisions |

### AUTOSAVE_INTERVAL

```php
define( 'AUTOSAVE_INTERVAL', 300 );
```

- **Type**: Integer (seconds)
- **Default**: `60` (1 minute)
- **Purpose**: Interval between automatic post saves
- **Effect**: Reduces server requests when editing
- **Recommended**: 120-300 seconds for better performance

### EMPTY_TRASH_DAYS

```php
define( 'EMPTY_TRASH_DAYS', 7 );
```

- **Type**: Integer (days)
- **Default**: `30`
- **Purpose**: Days before trashed items are permanently deleted
- **Values**:
  - `0` - Disable trash (items deleted immediately)
  - `7` - Empty trash weekly
  - `30` - Default monthly cleanup

### Media Settings

### IMAGE_EDIT_OVERWRITE

```php
define( 'IMAGE_EDIT_OVERWRITE', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Overwrites original images when editing instead of creating copies
- **Effect**: Saves disk space, but loses original

## Database Query Optimization

### DO_NOT_UPGRADE_GLOBAL_TABLES

```php
define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true );
```

- **Type**: Boolean
- **Default**: Not defined
- **Purpose**: Prevents upgrades of global tables in multisite
- **Use Case**: Shared user tables across networks

## External Request Optimization

### WP_HTTP_BLOCK_EXTERNAL

```php
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
```

- **Type**: Boolean
- **Purpose**: Blocks external HTTP requests
- **Effect**: Speeds up page loads by preventing update checks, API calls
- **Warning**: Breaks updates, oEmbed, and external API features

### WP_ACCESSIBLE_HOSTS

```php
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,*.github.com' );
```

- **Type**: Comma-separated string
- **Purpose**: Whitelist hosts when `WP_HTTP_BLOCK_EXTERNAL` is true

## Filesystem Method

### FS_METHOD

```php
define( 'FS_METHOD', 'direct' );
```

- **Type**: String
- **Default**: Auto-detected
- **Values**: `direct`, `ssh2`, `ftpext`, `ftpsockets`
- **Purpose**: Defines method for filesystem operations (updates, plugin installs)

| Method | Description |
|--------|-------------|
| `direct` | Direct PHP file operations (fastest) |
| `ssh2` | SSH2 connection |
| `ftpext` | FTP via PHP extension |
| `ftpsockets` | FTP via sockets |

### FS_CHMOD_DIR / FS_CHMOD_FILE

```php
define( 'FS_CHMOD_DIR', 0755 );
define( 'FS_CHMOD_FILE', 0644 );
```

- **Purpose**: File permissions for created directories/files
- **Default**: `0755` for directories, `0644` for files

## Complete Performance Configuration

### High-Traffic Production Site

```php
<?php
// Memory
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// Caching (managed by caching plugin)
define( 'WP_CACHE', true );

// Cron - use system cron
define( 'DISABLE_WP_CRON', true );

// Script optimization
define( 'CONCATENATE_SCRIPTS', true );
define( 'COMPRESS_SCRIPTS', true );
define( 'COMPRESS_CSS', true );
define( 'ENFORCE_GZIP', true );

// Content limits
define( 'WP_POST_REVISIONS', 5 );
define( 'AUTOSAVE_INTERVAL', 300 );
define( 'EMPTY_TRASH_DAYS', 7 );

// Filesystem
define( 'FS_METHOD', 'direct' );
```

### Development Environment

```php
<?php
// Memory (generous for debugging)
define( 'WP_MEMORY_LIMIT', '512M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// No caching
define( 'WP_CACHE', false );

// Keep WP-Cron for testing
// don't define DISABLE_WP_CRON

// Uncompressed for debugging
define( 'CONCATENATE_SCRIPTS', false );
define( 'COMPRESS_SCRIPTS', false );
define( 'COMPRESS_CSS', false );

// Full revisions for development
define( 'WP_POST_REVISIONS', true );
define( 'AUTOSAVE_INTERVAL', 60 );
```

### Low-Resource Environment

```php
<?php
// Conservative memory
define( 'WP_MEMORY_LIMIT', '64M' );
define( 'WP_MAX_MEMORY_LIMIT', '128M' );

// Minimal revisions
define( 'WP_POST_REVISIONS', 2 );
define( 'AUTOSAVE_INTERVAL', 600 );
define( 'EMPTY_TRASH_DAYS', 3 );

// Block external requests except essentials
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org' );
```

## Monitoring Performance

### Query Count

```php
// Add to theme footer
echo get_num_queries() . ' queries in ' . timer_stop() . ' seconds';
```

### Memory Usage

```php
echo 'Memory: ' . round( memory_get_peak_usage() / 1024 / 1024, 2 ) . 'MB';
```

### Recommended Tools

1. **Query Monitor** - Detailed performance analysis
2. **New Relic** - Application performance monitoring
3. **Debug Bar** - Admin toolbar debugging
4. **Server Timing** - Browser developer tools
