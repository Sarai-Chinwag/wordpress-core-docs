# WordPress Cron API

Pseudo-cron system for scheduling deferred and recurring tasks in WordPress.

**Since:** 2.1.0  
**Source:** `wp-includes/cron.php`, `wp-cron.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Scheduling, unscheduling, and query functions |
| [hooks.md](./hooks.md) | Filters for overriding cron behavior |

## WP-Cron vs System Cron

| Aspect | WP-Cron | System Cron |
|--------|---------|-------------|
| **Trigger** | Page visits | OS scheduler |
| **Reliability** | Depends on traffic | Guaranteed timing |
| **Precision** | Approximate | Exact |
| **Setup** | Automatic | Requires server access |
| **Load** | Per-request overhead | Dedicated execution |

### When WP-Cron Fails

- **Low traffic sites**: Events may not run until someone visits
- **Cached pages**: Full-page caching may prevent cron triggers
- **Long-running processes**: Previous cron still running (60-second lock)

### Switching to System Cron

```php
// wp-config.php
define( 'DISABLE_WP_CRON', true );
```

```bash
# System crontab (every minute)
* * * * * curl -s https://example.com/wp-cron.php?doing_wp_cron > /dev/null 2>&1

# Or with WP-CLI
* * * * * cd /var/www/html && wp cron event run --due-now > /dev/null 2>&1
```

## Spawn Mechanism

WP-Cron doesn't run synchronously. Instead, it "spawns" a separate HTTP request:

```
Page Request
    └── wp_cron() [on 'shutdown' action]
            └── _wp_cron()
                    └── wp_get_ready_cron_jobs()
                            └── spawn_cron()
                                    └── wp_remote_post( wp-cron.php )
```

### Spawn Locking

Prevents multiple simultaneous spawns:

```php
// Transient lock with 60-second timeout
$lock = get_transient( 'doing_cron' );

// Lock format: Unix timestamp with microseconds
$doing_wp_cron = sprintf( '%.22F', $gmt_time );
set_transient( 'doing_cron', $doing_wp_cron );
```

**Lock conditions:**
- Lock expires after 10 minutes (stale lock)
- New spawn blocked for 60 seconds after last spawn (`WP_CRON_LOCK_TIMEOUT`)

### Alternate Cron Mode

For servers that can't make loopback requests:

```php
// wp-config.php
define( 'ALTERNATE_WP_CRON', true );
```

Instead of spawning a background request, redirects the visitor to trigger cron:

```
Page Request
    └── wp_cron() [on 'wp_loaded' action]
            └── spawn_cron()
                    └── wp_redirect( ?doing_wp_cron=... )
                            └── require wp-cron.php
```

## Cron Storage Structure

Events stored in `wp_options` table under `cron` option:

```php
[
    1707465600 => [                    // Unix timestamp
        'my_hourly_hook' => [
            'a1b2c3d4...' => [          // MD5 of serialized args
                'schedule' => 'hourly',
                'args'     => [],
                'interval' => 3600,
            ],
        ],
    ],
    1707469200 => [
        'my_daily_hook' => [
            'e5f6g7h8...' => [
                'schedule' => 'daily',
                'args'     => ['post_id' => 123],
                'interval' => 86400,
            ],
        ],
    ],
    'version' => 2,
]
```

**Key structure:** `$crons[timestamp][hook][args_hash]`

## Default Schedules

| Name | Interval | Constant |
|------|----------|----------|
| `hourly` | 3,600 seconds | `HOUR_IN_SECONDS` |
| `twicedaily` | 43,200 seconds | `12 * HOUR_IN_SECONDS` |
| `daily` | 86,400 seconds | `DAY_IN_SECONDS` |
| `weekly` | 604,800 seconds | `WEEK_IN_SECONDS` |

## Execution Flow (wp-cron.php)

```
wp-cron.php
    ├── Verify doing_wp_cron matches lock
    ├── _get_cron_array()
    ├── For each due event:
    │       ├── wp_unschedule_event() [remove from array]
    │       ├── wp_reschedule_event() [if recurring]
    │       └── do_action_ref_array( $hook, $args )
    └── Exit
```

## Common Patterns

### Schedule on Plugin Activation

```php
register_activation_hook( __FILE__, 'my_plugin_activate' );
function my_plugin_activate() {
    if ( ! wp_next_scheduled( 'my_plugin_cron_hook' ) ) {
        wp_schedule_event( time(), 'hourly', 'my_plugin_cron_hook' );
    }
}

add_action( 'my_plugin_cron_hook', 'my_plugin_cron_callback' );
function my_plugin_cron_callback() {
    // Scheduled task logic
}
```

### Clean Up on Deactivation

```php
register_deactivation_hook( __FILE__, 'my_plugin_deactivate' );
function my_plugin_deactivate() {
    wp_clear_scheduled_hook( 'my_plugin_cron_hook' );
}
```

### One-Time Delayed Task

```php
wp_schedule_single_event( time() + HOUR_IN_SECONDS, 'my_delayed_task', [ $post_id ] );

add_action( 'my_delayed_task', function( $post_id ) {
    // Runs once, ~1 hour from now
}, 10, 1 );
```

## Debugging

### WP-CLI Commands

```bash
# List scheduled events
wp cron event list

# Run due events now
wp cron event run --due-now

# Run specific hook
wp cron event run my_hook_name

# Test cron spawning
wp cron test
```

### Check Cron Lock

```php
$lock = get_transient( 'doing_cron' );
if ( $lock ) {
    echo 'Cron locked until: ' . date( 'Y-m-d H:i:s', $lock + 60 );
}
```
