# Cron Hooks

## Filters

### pre_schedule_event

Short-circuits event scheduling before it occurs.

```php
apply_filters(
    'pre_schedule_event',
    null|bool|WP_Error $result,
    object             $event,
    bool               $wp_error
): null|bool|WP_Error
```

**Parameters:**
- `$result` — Return non-null to short-circuit. `true` = scheduled, `false` = blocked
- `$event` — Event object with `hook`, `timestamp`, `schedule`, `args`, `interval`
- `$wp_error` — Whether caller expects WP_Error on failure

**Used by:** `wp_schedule_single_event()`, `wp_schedule_event()`

```php
// Block scheduling of specific hooks
add_filter( 'pre_schedule_event', function( $result, $event, $wp_error ) {
    if ( $event->hook === 'blocked_hook' ) {
        if ( $wp_error ) {
            return new WP_Error( 'blocked', 'This hook cannot be scheduled.' );
        }
        return false;
    }
    return $result;
}, 10, 3 );

// External cron system integration
add_filter( 'pre_schedule_event', function( $result, $event ) {
    // Store in external queue system instead
    my_external_queue_add( $event );
    return true; // Tell WordPress it's "scheduled"
}, 10, 2 );
```

**Since:** 5.1.0

---

### schedule_event

Modifies an event before it's scheduled.

```php
apply_filters(
    'schedule_event',
    object|false $event
): object|false
```

**Parameters:**
- `$event` — Event object, or `false` to prevent scheduling

**Event object properties:**
- `hook` (string) — Action hook name
- `timestamp` (int) — Unix timestamp (UTC)
- `schedule` (string|false) — Recurrence name or `false` for single events
- `args` (array) — Callback arguments
- `interval` (int) — Seconds between runs (recurring events only)

```php
// Modify timestamp of specific hooks
add_filter( 'schedule_event', function( $event ) {
    if ( $event && $event->hook === 'my_delayed_hook' ) {
        // Always delay by an extra hour
        $event->timestamp += HOUR_IN_SECONDS;
    }
    return $event;
});

// Block events by returning false
add_filter( 'schedule_event', function( $event ) {
    $blocked_hooks = [ 'spam_hook', 'unwanted_task' ];
    if ( $event && in_array( $event->hook, $blocked_hooks, true ) ) {
        return false;
    }
    return $event;
});
```

**Since:** 3.1.0

---

### pre_reschedule_event

Short-circuits rescheduling of recurring events.

```php
apply_filters(
    'pre_reschedule_event',
    null|bool|WP_Error $result,
    object             $event,
    bool               $wp_error
): null|bool|WP_Error
```

**Parameters:**
- `$result` — Return non-null to short-circuit
- `$event` — Event object with `hook`, `timestamp`, `schedule`, `args`, `interval`
- `$wp_error` — Whether caller expects WP_Error on failure

```php
// Prevent rescheduling of exhausted tasks
add_filter( 'pre_reschedule_event', function( $result, $event ) {
    $run_count = get_option( "cron_runs_{$event->hook}", 0 );
    
    if ( $run_count >= 10 ) {
        // Stop after 10 runs
        return false;
    }
    
    return $result;
}, 10, 2 );
```

**Since:** 5.1.0

---

### pre_unschedule_event

Short-circuits event unscheduling.

```php
apply_filters(
    'pre_unschedule_event',
    null|bool|WP_Error $result,
    int                $timestamp,
    string             $hook,
    array              $args,
    bool               $wp_error
): null|bool|WP_Error
```

```php
// Log all unschedule attempts
add_filter( 'pre_unschedule_event', function( $result, $timestamp, $hook, $args ) {
    error_log( sprintf(
        'Unscheduling: %s at %s with args %s',
        $hook,
        date( 'c', $timestamp ),
        wp_json_encode( $args )
    ) );
    return $result;
}, 10, 4 );

// Protect critical hooks from being unscheduled
add_filter( 'pre_unschedule_event', function( $result, $timestamp, $hook, $args, $wp_error ) {
    if ( $hook === 'critical_system_task' ) {
        if ( $wp_error ) {
            return new WP_Error( 'protected', 'Cannot unschedule critical task.' );
        }
        return false;
    }
    return $result;
}, 10, 5 );
```

**Since:** 5.1.0

---

### pre_clear_scheduled_hook

Short-circuits clearing all events for a hook with specific args.

```php
apply_filters(
    'pre_clear_scheduled_hook',
    null|int|false|WP_Error $result,
    string                  $hook,
    array                   $args,
    bool                    $wp_error
): null|int|false|WP_Error
```

**Returns:** Number of events cleared, or `false`/`WP_Error` on failure

```php
// External cron system: clear from external queue
add_filter( 'pre_clear_scheduled_hook', function( $result, $hook, $args ) {
    $cleared = my_external_queue_clear( $hook, $args );
    return $cleared; // Return count of cleared events
}, 10, 3 );
```

**Since:** 5.1.0

---

### pre_unschedule_hook

Short-circuits clearing ALL events for a hook (regardless of args).

```php
apply_filters(
    'pre_unschedule_hook',
    null|int|false|WP_Error $result,
    string                  $hook,
    bool                    $wp_error
): null|int|false|WP_Error
```

```php
// Sync with external cron system
add_filter( 'pre_unschedule_hook', function( $result, $hook ) {
    my_external_queue_clear_all( $hook );
    return $result; // null = continue with WordPress cron
}, 10, 2 );
```

**Since:** 5.1.0

---

### pre_get_scheduled_event

Short-circuits retrieving a scheduled event.

```php
apply_filters(
    'pre_get_scheduled_event',
    null|false|object $result,
    string            $hook,
    array             $args,
    int|null          $timestamp
): null|false|object
```

**Returns:** Event object if found, `false` if not, `null` to continue normal retrieval

```php
// Merge events from external queue
add_filter( 'pre_get_scheduled_event', function( $result, $hook, $args, $timestamp ) {
    $external_event = my_external_queue_get( $hook, $args, $timestamp );
    
    if ( $external_event ) {
        return (object) [
            'hook'      => $hook,
            'timestamp' => $external_event['time'],
            'schedule'  => $external_event['recurrence'],
            'args'      => $args,
            'interval'  => $external_event['interval'] ?? null,
        ];
    }
    
    return $result;
}, 10, 4 );
```

**Since:** 5.1.0

---

### pre_get_ready_cron_jobs

Short-circuits retrieving ready-to-run cron jobs.

```php
apply_filters(
    'pre_get_ready_cron_jobs',
    null|array $result
): null|array
```

**Returns:** Array of ready jobs, or `null` to continue normal retrieval

```php
// Completely replace with external queue
add_filter( 'pre_get_ready_cron_jobs', function() {
    return my_external_queue_get_due_jobs();
});
```

**Since:** 5.1.0

---

### wp_next_scheduled

Filters the timestamp returned by `wp_next_scheduled()`.

```php
apply_filters(
    'wp_next_scheduled',
    int    $timestamp,
    object $next_event,
    string $hook,
    array  $args
): int
```

**Parameters:**
- `$timestamp` — Unix timestamp of next occurrence
- `$next_event` — Full event object
- `$hook` — Action hook name
- `$args` — Callback arguments

```php
// Delay all occurrences of a specific hook
add_filter( 'wp_next_scheduled', function( $timestamp, $next_event, $hook ) {
    if ( $hook === 'my_adjustable_hook' ) {
        // Report as 5 minutes later than actual
        return $timestamp + ( 5 * MINUTE_IN_SECONDS );
    }
    return $timestamp;
}, 10, 3 );
```

**Since:** 6.8.0

---

### get_schedule

Filters the schedule name for an event.

```php
apply_filters(
    'get_schedule',
    string|false $schedule,
    string       $hook,
    array        $args
): string|false
```

```php
// Override schedule names for display
add_filter( 'get_schedule', function( $schedule, $hook ) {
    if ( $hook === 'my_custom_hook' && $schedule === 'hourly' ) {
        return 'custom_hourly'; // For display purposes
    }
    return $schedule;
}, 10, 2 );
```

**Since:** 5.1.0

---

### cron_schedules

Adds custom recurrence schedules.

```php
apply_filters(
    'cron_schedules',
    array $schedules
): array
```

**Parameters:**
- `$schedules` — Array of custom schedules to merge with defaults

```php
add_filter( 'cron_schedules', function( $schedules ) {
    // Every 5 minutes
    $schedules['every_five_minutes'] = [
        'interval' => 5 * MINUTE_IN_SECONDS,
        'display'  => __( 'Every 5 Minutes' ),
    ];
    
    // Every 15 minutes
    $schedules['quarterly_hour'] = [
        'interval' => 15 * MINUTE_IN_SECONDS,
        'display'  => __( 'Every 15 Minutes' ),
    ];
    
    // Twice weekly
    $schedules['twice_weekly'] = [
        'interval' => 3.5 * DAY_IN_SECONDS,
        'display'  => __( 'Twice Weekly' ),
    ];
    
    return $schedules;
});
```

**Note:** Hook early (plugins_loaded or init) so schedules exist when cron runs.

**Since:** 2.1.0

---

### cron_request

Filters the HTTP request arguments for spawning cron.

```php
apply_filters(
    'cron_request',
    array  $cron_request,
    string $doing_wp_cron
): array
```

**Parameters:**
- `$cron_request` — Request configuration array
- `$doing_wp_cron` — Lock timestamp string

**Request structure:**
```php
[
    'url'  => 'https://example.com/wp-cron.php?doing_wp_cron=...',
    'key'  => '1707465600.1234567890123456789012',
    'args' => [
        'timeout'   => 0.01,
        'blocking'  => false,
        'sslverify' => false,
    ],
]
```

```php
// Increase spawn timeout
add_filter( 'cron_request', function( $request ) {
    $request['args']['timeout'] = 1; // 1 second instead of 0.01
    return $request;
});

// Use alternative cron URL
add_filter( 'cron_request', function( $request, $doing_wp_cron ) {
    $request['url'] = add_query_arg(
        'doing_wp_cron',
        $doing_wp_cron,
        'https://cron.example.com/wp-cron.php'
    );
    return $request;
}, 10, 2 );

// Enable SSL verification for cron requests
add_filter( 'cron_request', function( $request ) {
    $request['args']['sslverify'] = true;
    return $request;
});
```

**Since:** 3.5.0

---

## Actions

WordPress cron doesn't define built-in actions, but your scheduled hooks ARE actions:

```php
// When you schedule this:
wp_schedule_event( time(), 'hourly', 'my_custom_cron_hook' );

// You need to register the callback:
add_action( 'my_custom_cron_hook', 'my_cron_callback' );

function my_cron_callback() {
    // This runs when cron executes
}
```

### Built-in Cron Hooks

WordPress core schedules these hooks:

| Hook | Schedule | Purpose |
|------|----------|---------|
| `wp_scheduled_delete` | Daily | Empty trash |
| `wp_scheduled_auto_draft_delete` | Daily | Delete old auto-drafts |
| `wp_version_check` | Twice daily | Check for core updates |
| `wp_update_plugins` | Twice daily | Check for plugin updates |
| `wp_update_themes` | Twice daily | Check for theme updates |
| `wp_site_health_scheduled_check` | Weekly | Site health check |
| `delete_expired_transients` | Daily | Clean expired transients |
| `recovery_mode_clean_expired_keys` | Daily | Clean recovery mode keys |

---

## Filter Flow Diagram

```
wp_schedule_event()
    │
    ├── pre_schedule_event ──► [short-circuit possible]
    │
    ├── schedule_event ──► [modify or block]
    │
    └── Save to cron array


wp_unschedule_event()
    │
    ├── pre_unschedule_event ──► [short-circuit possible]
    │
    └── Remove from cron array


spawn_cron()
    │
    ├── cron_request ──► [modify URL/timeout]
    │
    └── wp_remote_post()
```

---

## External Cron Integration Pattern

For plugins replacing WP-Cron with external systems:

```php
// Intercept all scheduling
add_filter( 'pre_schedule_event', function( $result, $event ) {
    external_queue_add( $event );
    return true;
}, 10, 2 );

// Intercept all unscheduling
add_filter( 'pre_unschedule_event', function( $result, $timestamp, $hook, $args ) {
    external_queue_remove( $timestamp, $hook, $args );
    return true;
}, 10, 4 );

// Provide scheduled event data
add_filter( 'pre_get_scheduled_event', function( $result, $hook, $args, $timestamp ) {
    return external_queue_get_event( $hook, $args, $timestamp );
}, 10, 4 );

// Provide ready jobs
add_filter( 'pre_get_ready_cron_jobs', function() {
    return external_queue_get_due();
});
```
