# WP_Hook

Core class implementing action and filter hook functionality.

**Since:** 4.7.0  
**Source:** `wp-includes/class-wp-hook.php`

```php
final class WP_Hook implements Iterator, ArrayAccess
```

## Overview

`WP_Hook` is the internal implementation behind WordPress hooks. Each hook name gets its own `WP_Hook` instance stored in the global `$wp_filter` array.

Prior to WordPress 4.7, hooks were stored as plain arrays. `WP_Hook` provides proper iteration handling for hooks modified during execution.

## Properties

### $callbacks

Hook callbacks organized by priority.

```php
public array $callbacks = array();
```

Structure:
```php
$callbacks = array(
    10 => array(
        'function_id' => array(
            'function'      => callable,
            'accepted_args' => int,
        ),
    ),
    20 => array( ... ),
);
```

---

### $priorities

Sorted list of priority keys.

```php
protected array $priorities = array();
```

**Since:** 6.4.0

Cached array of `array_keys( $callbacks )` for iteration performance.

---

### $iterations

Priority keys of actively running iterations.

```php
private array $iterations = array();
```

Indexed by nesting level. Each entry is a copy of `$priorities` for that iteration.

---

### $current_priority

Current priority of actively running iterations.

```php
private array $current_priority = array();
```

Indexed by nesting level.

---

### $nesting_level

Recursion depth counter.

```php
private int $nesting_level = 0;
```

Tracks how many times this hook is currently executing (for nested/recursive calls).

---

### $doing_action

Flag for action vs filter execution.

```php
private bool $doing_action = false;
```

When `true`, return values from callbacks are ignored.

---

## Methods

### add_filter()

Adds a callback function to a filter hook.

```php
public function add_filter( 
    string   $hook_name, 
    callable $callback, 
    int      $priority, 
    int      $accepted_args 
): void
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The filter hook name |
| `$callback` | callable | Callback to execute |
| `$priority` | int | Execution order |
| `$accepted_args` | int | Number of arguments to pass |

**Behavior:**

1. Generates unique ID via `_wp_filter_build_unique_id()`
2. Stores callback in `$this->callbacks[ $priority ][ $id ]`
3. Re-sorts callbacks if new priority added
4. Updates `$priorities` cache
5. Calls `resort_active_iterations()` if currently executing

---

### remove_filter()

Removes a callback function from a filter hook.

```php
public function remove_filter( 
    string                $hook_name, 
    callable|string|array $callback, 
    int                   $priority 
): bool
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The filter hook name |
| `$callback` | callable | Callback to remove |
| `$priority` | int | Priority it was registered at |

**Returns:** `true` if callback existed and was removed, `false` otherwise.

**Behavior:**

1. Generates unique ID for callback
2. Unsets from `$this->callbacks`
3. Removes priority key if now empty
4. Updates `$priorities` cache
5. Calls `resort_active_iterations()` if currently executing

---

### has_filter()

Checks if a specific callback has been registered.

```php
public function has_filter( 
    string                      $hook_name = '', 
    callable|string|array|false $callback = false,
    int|false                   $priority = false 
): bool|int
```

**Since:** 4.7.0  
**Since:** 6.9.0 — Added `$priority` parameter

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | '' | The hook name |
| `$callback` | callable\|false | false | Callback to check for |
| `$priority` | int\|false | false | Priority to check |

**Returns:**

- `$callback = false`: Boolean (any callbacks registered?)
- `$callback` provided: Priority (int) or `false`
- Both provided: Boolean (exists at that priority?)

**Warning:** Can return `0` (valid priority). Use `===` for comparison.

---

### has_filters()

Checks if any callbacks are registered.

```php
public function has_filters(): bool
```

**Since:** 4.7.0

**Returns:** `true` if any callbacks exist, `false` if empty.

---

### remove_all_filters()

Removes all callbacks from the filter.

```php
public function remove_all_filters( int|false $priority = false ): void
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$priority` | int\|false | false | Remove only this priority, or all |

---

### apply_filters()

Calls callback functions registered to the filter.

```php
public function apply_filters( mixed $value, array $args ): mixed
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$value` | mixed | Value to filter |
| `$args` | array | All arguments (must include `$value` at index 0) |

**Returns:** Filtered value after all callbacks execute.

**Behavior:**

1. Increments `$nesting_level`
2. Copies `$priorities` to `$iterations[ $nesting_level ]`
3. Iterates through priorities
4. For each callback:
   - Updates `$args[0]` with current `$value` (unless doing action)
   - Calls callback with appropriate argument count
   - Stores return value as new `$value`
5. Decrements `$nesting_level`
6. Returns final `$value`

---

### do_action()

Calls callback functions registered to an action.

```php
public function do_action( array $args ): void
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$args` | array | Arguments to pass to callbacks |

**Behavior:**

1. Sets `$doing_action = true`
2. Calls `apply_filters( '', $args )`
3. Sets `$doing_action = false` when nesting complete

---

### do_all_hook()

Processes functions hooked to the 'all' hook.

```php
public function do_all_hook( array &$args ): void
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$args` | array | Arguments passed by reference |

Called for every hook execution when 'all' has callbacks. Does not filter values.

---

### current_priority()

Returns the current priority of the running iteration.

```php
public function current_priority(): int|false
```

**Since:** 4.7.0

**Returns:** Current priority if executing, `false` if not running.

---

### resort_active_iterations()

Handles resetting callback priority keys mid-iteration.

```php
private function resort_active_iterations( 
    false|int $new_priority = false, 
    bool      $priority_existed = false 
): void
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$new_priority` | int\|false | false | Priority being added |
| `$priority_existed` | bool | false | Whether priority existed before |

Called when callbacks are added/removed during execution. Ensures iterators remain valid.

---

### build_preinitialized_hooks()

Normalizes pre-4.7 hook arrays to WP_Hook objects.

```php
public static function build_preinitialized_hooks( array $filters ): WP_Hook[]
```

**Since:** 4.7.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$filters` | array | Array of hooks (may contain WP_Hook or legacy arrays) |

**Returns:** Array of WP_Hook instances keyed by hook name.

**Example input:**

```php
$filters = array(
    'wp_fatal_error_handler_enabled' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() { return false; },
            ),
        ),
    ),
);
```

Used during WordPress initialization to convert hooks registered before `WP_Hook` was loaded.

---

## ArrayAccess Methods

`WP_Hook` implements `ArrayAccess` for backward compatibility with code accessing `$wp_filter[$hook][$priority]`.

### offsetExists()

Checks if a priority exists.

```php
public function offsetExists( mixed $offset ): bool
```

**Since:** 4.7.0

---

### offsetGet()

Gets callbacks at a priority.

```php
public function offsetGet( mixed $offset ): mixed
```

**Since:** 4.7.0

**Returns:** Callbacks array or `null`.

---

### offsetSet()

Sets callbacks at a priority.

```php
public function offsetSet( mixed $offset, mixed $value ): void
```

**Since:** 4.7.0

---

### offsetUnset()

Removes a priority.

```php
public function offsetUnset( mixed $offset ): void
```

**Since:** 4.7.0

---

## Iterator Methods

`WP_Hook` implements `Iterator` for foreach traversal of priorities.

### current()

Returns callbacks at current priority.

```php
public function current(): array
```

**Since:** 4.7.0

---

### next()

Moves to next priority.

```php
public function next(): array
```

**Since:** 4.7.0

---

### key()

Returns current priority.

```php
public function key(): mixed
```

**Since:** 4.7.0

**Returns:** Priority (int) or `null`.

---

### valid()

Checks if current position is valid.

```php
public function valid(): bool
```

**Since:** 4.7.0

---

### rewind()

Resets to first priority.

```php
public function rewind(): void
```

**Since:** 4.7.0

---

## Usage Example

```php
// Direct usage (not recommended — use API functions instead)
$hook = new WP_Hook();

$hook->add_filter( 'my_hook', 'my_callback', 10, 1 );
$hook->add_filter( 'my_hook', 'another_callback', 20, 2 );

$result = $hook->apply_filters( 'initial', array( 'initial', $extra_arg ) );

// Check registration
if ( $hook->has_filter( 'my_hook', 'my_callback' ) ) {
    $hook->remove_filter( 'my_hook', 'my_callback', 10 );
}

// Iterate priorities
foreach ( $hook as $priority => $callbacks ) {
    echo "Priority $priority has " . count( $callbacks ) . " callbacks\n";
}
```
