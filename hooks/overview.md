# Hooks API

The foundation of WordPress extensibility. Hooks allow plugins and themes to modify behavior without editing core files.

**Since:** 0.71 (filters), 1.2.0 (actions)  
**Source:** `wp-includes/plugin.php`, `wp-includes/class-wp-hook.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core hook registration and execution functions |
| [class-wp-hook.md](./class-wp-hook.md) | Internal hook implementation class |
| [common-hooks.md](./common-hooks.md) | Categorized list of common hooks |

## Architecture

WordPress hooks come in two types:

- **Actions** — Execute code at specific points (fire-and-forget)
- **Filters** — Modify and return data (value transformation)

Both use the same underlying `WP_Hook` class. Actions are implemented as filters that ignore return values.

## Global State

```
$wp_filter          WP_Hook[]   All registered hooks (keyed by hook name)
$wp_actions         int[]       Action execution counts (keyed by hook name)
$wp_filters         int[]       Filter execution counts (keyed by hook name)  
$wp_current_filter  string[]    Stack of currently executing hooks
```

## Registration Flow

```
add_action() / add_filter()
    └── $wp_filter[ $hook_name ] = new WP_Hook()  (if not exists)
            └── WP_Hook::add_filter()
                    └── _wp_filter_build_unique_id()  (callback key)
                            └── Store in $this->callbacks[ $priority ][ $id ]
```

## Execution Flow

### Filters

```
apply_filters( $hook_name, $value, ...$args )
    ├── ++$wp_filters[ $hook_name ]
    ├── _wp_call_all_hook()  (if 'all' hook exists)
    ├── $wp_current_filter[] = $hook_name
    ├── WP_Hook::apply_filters( $value, $args )
    │       └── foreach priority → foreach callback
    │               └── call_user_func_array() → $value
    ├── array_pop( $wp_current_filter )
    └── return $value
```

### Actions

```
do_action( $hook_name, ...$args )
    ├── ++$wp_actions[ $hook_name ]
    ├── _wp_call_all_hook()  (if 'all' hook exists)
    ├── $wp_current_filter[] = $hook_name
    ├── WP_Hook::do_action( $args )
    │       └── $this->doing_action = true
    │       └── apply_filters( '', $args )  (value ignored)
    └── array_pop( $wp_current_filter )
```

## Priority System

Callbacks execute in priority order (lower = earlier). Same-priority callbacks execute in registration order.

| Priority | Use Case |
|----------|----------|
| 1-4 | Must run first (setup, early modification) |
| 5-9 | Run early |
| **10** | **Default** |
| 11-19 | Run late |
| 20+ | Must run last (cleanup, final modification) |
| PHP_INT_MAX | Absolute last |

## Callback Identification

`_wp_filter_build_unique_id()` generates unique keys for callbacks:

| Callback Type | Key Format |
|---------------|------------|
| Function name | `"function_name"` |
| Static method | `"Class::method"` |
| Object method | `spl_object_hash($obj) . "method"` |
| Closure | `spl_object_hash($closure) . ""` |

## Nesting & Recursion

The hook system supports:

- **Nested hooks** — Firing a hook from within a hook callback
- **Recursive hooks** — Same hook firing multiple times (tracked via `$nesting_level`)
- **Dynamic modification** — Adding/removing callbacks during execution

`WP_Hook` maintains iteration state per nesting level to handle mid-execution modifications safely.

## The 'all' Hook

Special hook that fires for every action and filter:

```php
add_action( 'all', function( $hook_name ) {
    error_log( 'Hook fired: ' . $hook_name );
} );
```

Receives the hook name plus all arguments. Useful for debugging. Performance-intensive.
