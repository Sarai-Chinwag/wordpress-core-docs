# Hook Functions

Core functions for registering and executing WordPress hooks.

**Source:** `wp-includes/plugin.php`

---

## Filter Functions

### add_filter()

Adds a callback function to a filter hook.

```php
add_filter( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10, 
    int      $accepted_args = 1 
): true
```

**Since:** 0.71

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | The name of the filter to add the callback to |
| `$callback` | callable | — | The callback to run when the filter is applied |
| `$priority` | int | 10 | Execution order (lower = earlier) |
| `$accepted_args` | int | 1 | Number of arguments the callback accepts |

**Returns:** Always returns `true`. Does not validate callback existence.

**Examples:**

```php
// Basic usage
add_filter( 'the_title', 'my_title_filter' );

function my_title_filter( $title ) {
    return '🔥 ' . $title;
}

// With priority (run early)
add_filter( 'the_content', 'my_early_filter', 5 );

// Multiple arguments
add_filter( 'the_title', 'my_title_context', 10, 2 );

function my_title_context( $title, $post_id ) {
    return $title . ' (Post #' . $post_id . ')';
}

// Anonymous function
add_filter( 'body_class', function( $classes ) {
    $classes[] = 'my-custom-class';
    return $classes;
} );

// Class method
add_filter( 'the_content', array( $this, 'filter_content' ) );
add_filter( 'the_content', array( 'My_Class', 'static_method' ) );
add_filter( 'the_content', 'My_Class::static_method' );
```

---

### apply_filters()

Calls all callbacks registered to a filter hook.

```php
apply_filters( string $hook_name, mixed $value, mixed ...$args ): mixed
```

**Since:** 0.71  
**Since:** 6.0.0 — Formalized `...$args` parameter

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The name of the filter hook |
| `$value` | mixed | The value to filter |
| `...$args` | mixed | Additional arguments passed to callbacks |

**Returns:** The filtered value after all callbacks are applied.

**Examples:**

```php
// Basic usage
$title = apply_filters( 'the_title', $post->post_title, $post->ID );

// Creating custom filter points
$message = apply_filters( 'my_plugin_message', 'Default message', $context );

// Chained filters
$content = apply_filters( 'the_content', $raw_content );
// Each registered callback receives the output of the previous one
```

---

### apply_filters_ref_array()

Calls filter callbacks with arguments passed as an array.

```php
apply_filters_ref_array( string $hook_name, array $args ): mixed
```

**Since:** 3.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The name of the filter hook |
| `$args` | array | Arguments to pass (first element is the value to filter) |

**Returns:** The filtered value.

**Example:**

```php
$args = array( $value, $arg1, $arg2, $arg3 );
$result = apply_filters_ref_array( 'my_filter', $args );
```

---

### has_filter()

Checks if any callbacks are registered for a filter hook.

```php
has_filter( 
    string                      $hook_name, 
    callable|string|array|false $callback = false,
    int|false                   $priority = false 
): bool|int
```

**Since:** 2.5.0  
**Since:** 6.9.0 — Added `$priority` parameter

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | The name of the filter hook |
| `$callback` | callable\|false | false | Specific callback to check for |
| `$priority` | int\|false | false | Specific priority to check |

**Returns:**
- No `$callback`: `true` if anything registered, `false` otherwise
- With `$callback`: Priority (int) if found, `false` if not found
- With both: `true`/`false` for that specific callback at that priority

**Warning:** Return value can be `0` (valid priority). Use `===` for comparison.

**Examples:**

```php
// Check if hook has any callbacks
if ( has_filter( 'the_content' ) ) {
    // Something is filtering content
}

// Check for specific callback (returns priority or false)
$priority = has_filter( 'the_content', 'wpautop' );
if ( false !== $priority ) {
    echo "wpautop is at priority $priority";
}

// Check callback at specific priority
if ( has_filter( 'the_content', 'wpautop', 10 ) ) {
    // wpautop is registered at priority 10
}
```

---

### remove_filter()

Removes a callback from a filter hook.

```php
remove_filter( 
    string                $hook_name, 
    callable|string|array $callback, 
    int                   $priority = 10 
): bool
```

**Since:** 1.2.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | The filter hook |
| `$callback` | callable | — | The callback to remove |
| `$priority` | int | 10 | Must match the priority used when adding |

**Returns:** `true` if removed, `false` if callback wasn't found.

**Important:** The `$callback` and `$priority` must match exactly what was passed to `add_filter()`.

**Examples:**

```php
// Remove named function
remove_filter( 'the_content', 'wpautop' );

// Remove class method (must have same instance reference)
remove_filter( 'the_content', array( $instance, 'method' ), 10 );

// Remove static method
remove_filter( 'the_content', array( 'My_Class', 'method' ), 10 );

// Removing closures requires storing reference
$my_closure = function( $content ) { return $content; };
add_filter( 'the_content', $my_closure );
// Later...
remove_filter( 'the_content', $my_closure );
```

---

### remove_all_filters()

Removes all callbacks from a filter hook.

```php
remove_all_filters( string $hook_name, int|false $priority = false ): true
```

**Since:** 2.7.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | The filter hook |
| `$priority` | int\|false | false | Remove only at this priority, or all if false |

**Returns:** Always `true`.

**Examples:**

```php
// Remove all callbacks from the_content
remove_all_filters( 'the_content' );

// Remove only priority 10 callbacks
remove_all_filters( 'the_content', 10 );
```

---

### current_filter()

Gets the name of the currently executing filter hook.

```php
current_filter(): string|false
```

**Since:** 2.5.0

**Returns:** Hook name, or `false` if no hook is executing.

**Example:**

```php
function my_flexible_callback( $value ) {
    $hook = current_filter();
    
    if ( 'the_title' === $hook ) {
        return strtoupper( $value );
    }
    
    return $value;
}

add_filter( 'the_title', 'my_flexible_callback' );
add_filter( 'the_excerpt', 'my_flexible_callback' );
```

---

### doing_filter()

Checks if a specific filter is currently being executed.

```php
doing_filter( string|null $hook_name = null ): bool
```

**Since:** 3.9.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string\|null | null | Hook to check, or null for any |

**Returns:** `true` if the filter is in the execution stack.

**Note:** Unlike `current_filter()`, this checks the entire stack, not just the most recent hook.

**Example:**

```php
function my_callback() {
    if ( doing_filter( 'the_content' ) ) {
        // We're somewhere in the_content filter chain
        // (may be nested inside another callback)
    }
}
```

---

### did_filter()

Gets the number of times a filter has been applied.

```php
did_filter( string $hook_name ): int
```

**Since:** 6.1.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The filter hook name |

**Returns:** Number of times the filter was applied during the current request.

**Example:**

```php
$count = did_filter( 'the_content' );
echo "the_content has been applied $count times";
```

---

## Action Functions

### add_action()

Adds a callback function to an action hook.

```php
add_action( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10, 
    int      $accepted_args = 1 
): true
```

**Since:** 1.2.0

Internally calls `add_filter()`. Parameters and behavior are identical.

**Examples:**

```php
// Basic usage
add_action( 'init', 'my_init_function' );

// With priority
add_action( 'wp_head', 'my_head_content', 5 );

// With arguments
add_action( 'save_post', 'my_save_handler', 10, 3 );

function my_save_handler( $post_id, $post, $update ) {
    if ( $update ) {
        // Post was updated, not created
    }
}
```

---

### do_action()

Executes all callbacks registered to an action hook.

```php
do_action( string $hook_name, mixed ...$arg ): void
```

**Since:** 1.2.0  
**Since:** 5.3.0 — Formalized `...$arg` parameter

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The action hook name |
| `...$arg` | mixed | Arguments passed to callbacks |

**Returns:** Nothing (`void`).

**Examples:**

```php
// Trigger WordPress core action
do_action( 'init' );

// Create custom action point
do_action( 'my_plugin_loaded', $plugin_instance );

// With multiple arguments
do_action( 'my_plugin_event', $arg1, $arg2, $arg3 );
```

---

### do_action_ref_array()

Executes action callbacks with arguments passed as an array.

```php
do_action_ref_array( string $hook_name, array $args ): void
```

**Since:** 2.1.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The action hook name |
| `$args` | array | Arguments to pass to callbacks |

**Example:**

```php
$args = array( $post_id, $post, $update );
do_action_ref_array( 'save_post', $args );
```

---

### has_action()

Checks if any callbacks are registered for an action hook.

```php
has_action( 
    string                      $hook_name, 
    callable|string|array|false $callback = false,
    int|false                   $priority = false 
): bool|int
```

**Since:** 2.5.0  
**Since:** 6.9.0 — Added `$priority` parameter

Alias for `has_filter()`. Parameters and return values are identical.

---

### remove_action()

Removes a callback from an action hook.

```php
remove_action( 
    string                $hook_name, 
    callable|string|array $callback, 
    int                   $priority = 10 
): bool
```

**Since:** 1.2.0

Alias for `remove_filter()`. Parameters and return values are identical.

---

### remove_all_actions()

Removes all callbacks from an action hook.

```php
remove_all_actions( string $hook_name, int|false $priority = false ): true
```

**Since:** 2.7.0

Alias for `remove_all_filters()`.

---

### current_action()

Gets the name of the currently executing action hook.

```php
current_action(): string|false
```

**Since:** 3.9.0

Alias for `current_filter()`.

---

### doing_action()

Checks if a specific action is currently being executed.

```php
doing_action( string|null $hook_name = null ): bool
```

**Since:** 3.9.0

Alias for `doing_filter()`.

---

### did_action()

Gets the number of times an action has been fired.

```php
did_action( string $hook_name ): int
```

**Since:** 2.1.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$hook_name` | string | The action hook name |

**Returns:** Number of times the action was fired during the current request.

**Example:**

```php
if ( did_action( 'init' ) ) {
    // init has already fired
}

// Check if fired exactly once
if ( 1 === did_action( 'plugins_loaded' ) ) {
    // First time plugins_loaded has run
}
```

---

## Deprecated Hook Functions

### apply_filters_deprecated()

Fires a deprecated filter with a deprecation notice.

```php
apply_filters_deprecated( 
    string $hook_name, 
    array  $args, 
    string $version, 
    string $replacement = '', 
    string $message = '' 
): mixed
```

**Since:** 4.6.0

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | Deprecated hook name |
| `$args` | array | — | Arguments (first element is filtered value) |
| `$version` | string | — | Version when deprecated |
| `$replacement` | string | '' | Replacement hook name |
| `$message` | string | '' | Additional message |

**Example:**

```php
// Old code
return apply_filters( 'old_filter', $value, $extra_arg );

// Deprecated replacement
return apply_filters_deprecated( 
    'old_filter', 
    array( $value, $extra_arg ), 
    '5.0.0', 
    'new_filter' 
);
```

---

### do_action_deprecated()

Fires a deprecated action with a deprecation notice.

```php
do_action_deprecated( 
    string $hook_name, 
    array  $args, 
    string $version, 
    string $replacement = '', 
    string $message = '' 
): void
```

**Since:** 4.6.0

**Example:**

```php
// Old code
do_action( 'old_action', $arg1, $arg2 );

// Deprecated replacement
do_action_deprecated( 
    'old_action', 
    array( $arg1, $arg2 ), 
    '5.0.0', 
    'new_action',
    'The old_action hook is no longer used.'
);
```

---

## Internal Functions

### _wp_call_all_hook()

Processes callbacks on the 'all' hook.

```php
_wp_call_all_hook( array $args ): void
```

**Since:** 2.5.0  
**Access:** Private

Called internally by `apply_filters()` and `do_action()` when the 'all' hook has callbacks.

---

### _wp_filter_build_unique_id()

Generates a unique string ID for a callback.

```php
_wp_filter_build_unique_id( 
    string                $hook_name, 
    callable|string|array $callback, 
    int                   $priority 
): string|null
```

**Since:** 2.2.3  
**Since:** 5.3.0 — Removed workarounds, always returns string  
**Access:** Private

**Returns:**

| Callback Type | Return Value |
|---------------|--------------|
| String function | `"function_name"` |
| Static method | `"Class::method"` |
| Object method | `spl_object_hash($obj) . "method"` |
| Closure | `spl_object_hash($closure) . ""` |
| Invalid | `null` |

---

## Plugin Lifecycle Hooks

### register_activation_hook()

Sets the activation hook for a plugin.

```php
register_activation_hook( string $file, callable $callback ): void
```

**Since:** 2.0.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$file` | string | Main plugin file path (use `__FILE__`) |
| `$callback` | callable | Function to run on activation |

**Example:**

```php
register_activation_hook( __FILE__, 'my_plugin_activate' );

function my_plugin_activate() {
    add_option( 'my_plugin_version', '1.0.0' );
    flush_rewrite_rules();
}
```

---

### register_deactivation_hook()

Sets the deactivation hook for a plugin.

```php
register_deactivation_hook( string $file, callable $callback ): void
```

**Since:** 2.0.0

**Example:**

```php
register_deactivation_hook( __FILE__, 'my_plugin_deactivate' );

function my_plugin_deactivate() {
    wp_clear_scheduled_hook( 'my_plugin_cron' );
    flush_rewrite_rules();
}
```

---

### register_uninstall_hook()

Sets the uninstall hook for a plugin.

```php
register_uninstall_hook( string $file, callable $callback ): void
```

**Since:** 2.7.0

**Important:** Callback must be a static method or function (not an instance method).

**Alternative:** Create `uninstall.php` in plugin root directory. Check for `WP_UNINSTALL_PLUGIN` constant.

**Example:**

```php
register_uninstall_hook( __FILE__, 'My_Plugin::uninstall' );

class My_Plugin {
    public static function uninstall() {
        delete_option( 'my_plugin_settings' );
        // Clean up database tables, etc.
    }
}
```
