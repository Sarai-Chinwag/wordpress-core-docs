# Cron Functions

## Scheduling Functions

### wp_schedule_single_event()

Schedules an event to run only once.

```php
wp_schedule_single_event(
    int    $timestamp,
    string $hook,
    array  $args = [],
    bool   $wp_error = false
): bool|WP_Error
```

**Parameters:**
- `$timestamp` — Unix timestamp (UTC) for when to run the event
- `$hook` — Action hook to execute
- `$args` — Arguments passed to the hook callback (keys ignored)
- `$wp_error` — Return WP_Error on failure instead of false

**Returns:** `true` on success, `false` or `WP_Error` on failure

**Duplicate Prevention:** Events within 10 minutes of an identical event (same hook + args) are rejected.

```php
// Schedule cleanup in 1 hour
wp_schedule_single_event(
    time() + HOUR_IN_SECONDS,
    'my_cleanup_task',
    [ 'batch_id' => 42 ]
);

// With error handling
$result = wp_schedule_single_event(
    time() + DAY_IN_SECONDS,
    'my_task',
    [],
    true // Return WP_Error
);

if ( is_wp_error( $result ) ) {
    error_log( $result->get_error_message() );
}
```

**Since:** 2.1.0  
**Modified:** 5.1.0 (return value, `pre_schedule_event` filter), 5.7.0 (`$wp_error` param)

---

### wp_schedule_event()

Schedules a recurring event.

```php
wp_schedule_event(
    int    $timestamp,
    string $recurrence,
    string $hook,
    array  $args = [],
    bool   $wp_error = false
): bool|WP_Error
```

**Parameters:**
- `$timestamp` — Unix timestamp (UTC) for the first run
- `$recurrence` — Schedule name from `wp_get_schedules()` (e.g., `hourly`, `daily`)
- `$hook` — Action hook to execute
- `$args` — Arguments passed to the hook callback
- `$wp_error` — Return WP_Error on failure

**Returns:** `true` on success, `false` or `WP_Error` on failure

```php
// Daily cleanup starting now
if ( ! wp_next_scheduled( 'my_daily_task' ) ) {
    wp_schedule_event( time(), 'daily', 'my_daily_task' );
}

// Custom schedule with args
wp_schedule_event(
    time(),
    'twicedaily',
    'sync_external_api',
    [ 'endpoint' => 'products' ]
);
```

**Valid recurrence values:**
- `hourly` — Every hour
- `twicedaily` — Every 12 hours
- `daily` — Every 24 hours
- `weekly` — Every 7 days
- Custom schedules via `cron_schedules` filter

**Since:** 2.1.0  
**Modified:** 5.1.0, 5.7.0

---

### wp_reschedule_event()

Reschedules a recurring event for its next run.

```php
wp_reschedule_event(
    int    $timestamp,
    string $recurrence,
    string $hook,
    array  $args = [],
    bool   $wp_error = false
): bool|WP_Error
```

**Internal Use:** Called by `wp-cron.php` after executing a recurring event.

**Timestamp Calculation:**
- If original timestamp is in the future: `now + interval`
- If original timestamp is in the past: Calculates next aligned occurrence

```php
// Example of internal rescheduling logic
if ( $timestamp >= $now ) {
    $timestamp = $now + $interval;
} else {
    $timestamp = $now + ( $interval - ( ( $now - $timestamp ) % $interval ) );
}
```

**Since:** 2.1.0

---

## Unscheduling Functions

### wp_unschedule_event()

Unschedules a specific event occurrence.

```php
wp_unschedule_event(
    int    $timestamp,
    string $hook,
    array  $args = [],
    bool   $wp_error = false
): bool|WP_Error
```

**Parameters:**
- `$timestamp` — Exact timestamp of the event to remove
- `$hook` — Action hook name
- `$args` — Arguments that match the scheduled event
- `$wp_error` — Return WP_Error on failure

```php
// Get the timestamp first
$timestamp = wp_next_scheduled( 'my_hook', [ 'id' => 5 ] );

if ( $timestamp ) {
    wp_unschedule_event( $timestamp, 'my_hook', [ 'id' => 5 ] );
}
```

**Since:** 2.1.0

---

### wp_clear_scheduled_hook()

Unschedules all events attached to the hook with the specified arguments.

```php
wp_clear_scheduled_hook(
    string $hook,
    array  $args = [],
    bool   $wp_error = false
): int|false|WP_Error
```

**Returns:**
- `int` — Number of events unscheduled (0 if none found)
- `false` or `WP_Error` — On failure

```php
// Remove all occurrences of a hook with specific args
$count = wp_clear_scheduled_hook( 'process_item', [ 'item_id' => 123 ] );

// Remove all occurrences with no args
wp_clear_scheduled_hook( 'my_simple_hook' );

// With error handling
$result = wp_clear_scheduled_hook( 'my_hook', [], true );
if ( is_wp_error( $result ) ) {
    // Handle error
}
```

**Caution:** Use `===` for comparison — returns `0` when no events exist (which is falsy).

**Since:** 2.1.0  
**Modified:** 3.0.0 (args changed to array), 5.1.0 (return value), 5.7.0 (`$wp_error`)

---

### wp_unschedule_hook()

Unschedules ALL events attached to a hook, regardless of arguments.

```php
wp_unschedule_hook(
    string $hook,
    bool   $wp_error = false
): int|false|WP_Error
```

**Returns:** Number of events unscheduled, or `false`/`WP_Error` on failure

```php
// Plugin deactivation cleanup
register_deactivation_hook( __FILE__, function() {
    wp_unschedule_hook( 'my_plugin_hourly_task' );
    wp_unschedule_hook( 'my_plugin_cleanup' );
});

// Returns count of removed events
$removed = wp_unschedule_hook( 'my_hook' );
echo "Removed {$removed} scheduled events";
```

**Since:** 4.9.0

---

## Query Functions

### wp_next_scheduled()

Retrieves the timestamp of the next scheduled occurrence.

```php
wp_next_scheduled(
    string $hook,
    array  $args = []
): int|false
```

**Returns:** Unix timestamp (UTC), or `false` if not scheduled

```php
// Check if already scheduled (prevent duplicates)
if ( ! wp_next_scheduled( 'my_hourly_task' ) ) {
    wp_schedule_event( time(), 'hourly', 'my_hourly_task' );
}

// With arguments
$next = wp_next_scheduled( 'process_post', [ 'post_id' => 42 ] );
if ( $next ) {
    echo 'Next run: ' . date( 'Y-m-d H:i:s', $next );
}
```

**Since:** 2.1.0  
**Modified:** 6.8.0 (`wp_next_scheduled` filter added)

---

### wp_get_scheduled_event()

Retrieves the full event object for a scheduled event.

```php
wp_get_scheduled_event(
    string   $hook,
    array    $args = [],
    int|null $timestamp = null
): object|false
```

**Parameters:**
- `$hook` — Action hook name
- `$args` — Arguments to match
- `$timestamp` — Specific timestamp, or `null` for next occurrence

**Returns:**
```php
object {
    string       $hook;      // Action hook name
    int          $timestamp; // Unix timestamp (UTC)
    string|false $schedule;  // Recurrence name or false for single events
    array        $args;      // Callback arguments
    int          $interval;  // Seconds between runs (recurring only)
}
```

```php
$event = wp_get_scheduled_event( 'my_recurring_task' );

if ( $event ) {
    echo "Hook: {$event->hook}\n";
    echo "Next run: " . date( 'c', $event->timestamp ) . "\n";
    echo "Schedule: {$event->schedule}\n";
    
    if ( isset( $event->interval ) ) {
        echo "Interval: {$event->interval} seconds\n";
    }
}
```

**Since:** 5.1.0

---

### wp_get_ready_cron_jobs()

Retrieves all cron jobs that are due to run.

```php
wp_get_ready_cron_jobs(): array
```

**Returns:** Array of cron jobs with timestamps in the past

```php
$ready_jobs = wp_get_ready_cron_jobs();

foreach ( $ready_jobs as $timestamp => $hooks ) {
    foreach ( $hooks as $hook => $events ) {
        foreach ( $events as $key => $event ) {
            echo "Due: {$hook} (scheduled for " . date( 'c', $timestamp ) . ")\n";
        }
    }
}
```

**Since:** 5.1.0

---

## Schedule Functions

### wp_get_schedules()

Retrieves all available recurrence schedules.

```php
wp_get_schedules(): array
```

**Returns:**
```php
[
    'hourly' => [
        'interval' => 3600,
        'display'  => 'Once Hourly',
    ],
    'twicedaily' => [
        'interval' => 43200,
        'display'  => 'Twice Daily',
    ],
    'daily' => [
        'interval' => 86400,
        'display'  => 'Once Daily',
    ],
    'weekly' => [
        'interval' => 604800,
        'display'  => 'Once Weekly',
    ],
]
```

```php
// Display available schedules
$schedules = wp_get_schedules();
foreach ( $schedules as $name => $schedule ) {
    printf(
        "%s: Every %d seconds (%s)\n",
        $name,
        $schedule['interval'],
        $schedule['display']
    );
}
```

**Since:** 2.1.0  
**Modified:** 5.4.0 (`weekly` schedule added)

---

### wp_get_schedule()

Retrieves the schedule name for a specific event.

```php
wp_get_schedule(
    string $hook,
    array  $args = []
): string|false
```

**Returns:** Schedule name (e.g., `hourly`, `daily`) or `false` for single events

```php
$schedule = wp_get_schedule( 'my_task' );

if ( $schedule ) {
    echo "This is a {$schedule} recurring event";
} else {
    echo "Single event or not scheduled";
}
```

**Since:** 2.1.0  
**Modified:** 5.1.0 (`get_schedule` filter added)

---

## Spawn Functions

### spawn_cron()

Sends a non-blocking HTTP request to trigger cron execution.

```php
spawn_cron( int $gmt_time = 0 ): bool
```

**Parameters:**
- `$gmt_time` — Unix timestamp (defaults to current time with microseconds)

**Returns:** `true` if spawn request sent, `false` if blocked

**Spawn Prevention Conditions:**
- `DOING_CRON` constant defined
- `doing_wp_cron` query parameter present
- Lock transient less than 60 seconds old
- No events due

```php
// Force spawn check
spawn_cron();

// Spawn won't run if:
if ( defined( 'DOING_CRON' ) ) {
    return false; // Already running cron
}
```

**Since:** 2.1.0

---

### wp_cron()

Registers cron spawning on the `shutdown` action.

```php
wp_cron(): void
```

**Behavior:**
- Normal mode: Queues `_wp_cron()` for `shutdown` action
- Alternate cron: Queues for `wp_loaded` action

```php
// Called automatically in wp-settings.php
// Manual call possible but rarely needed
wp_cron();
```

**Since:** 2.1.0  
**Modified:** 5.7.0, 6.9.0 (moved from `wp_loaded` to `shutdown`)

---

## Internal Functions

### _get_cron_array()

Retrieves the raw cron array from the database.

```php
_get_cron_array(): array
```

**Returns:** Array of scheduled events, or empty array

**Internal:** Use `wp_get_scheduled_event()` or `wp_next_scheduled()` for public code.

---

### _set_cron_array()

Saves the cron array to the database.

```php
_set_cron_array(
    array $cron,
    bool  $wp_error = false
): bool|WP_Error
```

**Internal:** Called by scheduling/unscheduling functions.

---

### _upgrade_cron_array()

Upgrades legacy cron format to version 2.

```php
_upgrade_cron_array( array $cron ): array
```

**Internal:** Handles migration from pre-2.1 cron format.

---

### _wp_cron()

Core cron execution logic.

```php
_wp_cron(): int|false
```

**Returns:** Number of events spawned, or `false` on failure

**Internal:** Called by `wp_cron()` via action hook.

---

## Adding Custom Schedules

```php
add_filter( 'cron_schedules', function( $schedules ) {
    // Every 5 minutes
    $schedules['every_five_minutes'] = [
        'interval' => 5 * MINUTE_IN_SECONDS,
        'display'  => __( 'Every Five Minutes' ),
    ];
    
    // Every month (approximate)
    $schedules['monthly'] = [
        'interval' => MONTH_IN_SECONDS,
        'display'  => __( 'Once Monthly' ),
    ];
    
    return $schedules;
});

// Now usable in wp_schedule_event()
wp_schedule_event( time(), 'every_five_minutes', 'my_frequent_task' );
```

**Note:** Custom schedules must be added early (before `init`) to be available when cron runs.
