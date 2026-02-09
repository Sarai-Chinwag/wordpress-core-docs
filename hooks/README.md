# Hooks API

The Hooks API is the foundation of WordPress extensibility, allowing plugins and themes to modify behavior without editing core files.

**Since:** WordPress 1.2.0

## Overview

WordPress hooks come in two types:

- **Actions** — Execute code at specific points
- **Filters** — Modify data before it's used

## Actions

Actions let you run code when WordPress performs specific tasks.

### add_action()

Registers a callback to run at a specific point.

```php
add_action( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10, 
    int      $accepted_args = 1 
): true
```

**Parameters:**

| Name | Type | Default | Description |
|------|------|---------|-------------|
| `$hook_name` | string | — | Hook to attach to |
| `$callback` | callable | — | Function to execute |
| `$priority` | int | 10 | Execution order (lower = earlier) |
| `$accepted_args` | int | 1 | Number of arguments passed |

**Examples:**

```php
// Basic usage
add_action( 'init', 'my_custom_init' );

function my_custom_init() {
    // Runs during WordPress initialization
}

// With priority (run early)
add_action( 'init', 'my_early_init', 5 );

// With multiple arguments
add_action( 'save_post', 'my_save_handler', 10, 3 );

function my_save_handler( $post_id, $post, $update ) {
    if ( $update ) {
        // Post was updated
    }
}

// Anonymous function
add_action( 'wp_footer', function() {
    echo '<!-- Custom footer content -->';
} );

// Class method
add_action( 'init', array( $this, 'init_method' ) );
add_action( 'init', array( 'My_Class', 'static_method' ) );
add_action( 'init', 'My_Class::static_method' );
```

---

### do_action()

Executes all callbacks attached to a hook.

```php
do_action( string $hook_name, mixed ...$args ): void
```

**Example:**

```php
// In your plugin, create a hook point
do_action( 'my_plugin_initialized', $plugin_data );

// Others can hook into it
add_action( 'my_plugin_initialized', function( $data ) {
    // React to plugin initialization
} );
```

---

### remove_action()

Removes a previously registered callback.

```php
remove_action( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10 
): bool
```

**Example:**

```php
// Remove a named function
remove_action( 'wp_head', 'wp_generator' );

// Remove class method (must match exactly)
remove_action( 'init', array( $instance, 'method' ), 10 );
```

---

### has_action()

Checks if a hook has callbacks registered.

```php
has_action( string $hook_name, callable $callback = false ): bool|int
```

---

## Filters

Filters let you modify data before WordPress uses it.

### add_filter()

Registers a callback to filter data.

```php
add_filter( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10, 
    int      $accepted_args = 1 
): true
```

**Examples:**

```php
// Modify post title
add_filter( 'the_title', 'my_custom_title' );

function my_custom_title( $title ) {
    return '🔥 ' . $title;
}

// Multiple arguments
add_filter( 'the_content', 'my_content_filter', 10, 2 );

function my_content_filter( $content, $post_id ) {
    return $content . '<p>Post ID: ' . $post_id . '</p>';
}

// Chained filters
add_filter( 'the_content', 'first_filter', 5 );
add_filter( 'the_content', 'second_filter', 15 );
```

---

### apply_filters()

Applies all registered filters to a value.

```php
apply_filters( string $hook_name, mixed $value, mixed ...$args ): mixed
```

**Example:**

```php
// In your plugin
$message = apply_filters( 'my_plugin_message', 'Default message', $context );

// Others can modify it
add_filter( 'my_plugin_message', function( $message, $context ) {
    return $message . ' (modified)';
}, 10, 2 );
```

---

### remove_filter()

Removes a previously registered filter.

```php
remove_filter( 
    string   $hook_name, 
    callable $callback, 
    int      $priority = 10 
): bool
```

---

### has_filter()

Checks if a hook has filters registered.

```php
has_filter( string $hook_name, callable $callback = false ): bool|int
```

---

## Common Hooks

### Actions

| Hook | When it Fires |
|------|---------------|
| `init` | After WordPress loads, before headers |
| `wp_loaded` | After WordPress fully loads |
| `admin_init` | First thing in admin screens |
| `wp_enqueue_scripts` | Enqueue frontend scripts/styles |
| `admin_enqueue_scripts` | Enqueue admin scripts/styles |
| `wp_head` | Inside `<head>` tag |
| `wp_footer` | Before `</body>` |
| `save_post` | When a post is saved |
| `delete_post` | When a post is deleted |
| `user_register` | When a user is created |
| `wp_login` | After user logs in |
| `wp_logout` | After user logs out |
| `rest_api_init` | When REST API initializes |
| `widgets_init` | Register widget areas |
| `after_setup_theme` | Theme is loaded |

### Filters

| Hook | What it Filters |
|------|-----------------|
| `the_content` | Post content |
| `the_title` | Post title |
| `the_excerpt` | Post excerpt |
| `body_class` | Body CSS classes |
| `post_class` | Post wrapper classes |
| `wp_nav_menu_items` | Navigation menu items |
| `upload_mimes` | Allowed upload MIME types |
| `query_vars` | Query variables |
| `pre_get_posts` | WP_Query before execution |
| `posts_where` | SQL WHERE clause |
| `widget_text` | Text widget content |
| `login_redirect` | Redirect URL after login |
| `authenticate` | Authentication process |

## Advanced Patterns

### Current Hook

```php
// Inside a callback
$current = current_action();  // or current_filter()
```

### One-Time Execution

```php
add_action( 'init', function() {
    // This runs once, then removes itself
    remove_action( 'init', __FUNCTION__ );
    
    // Do something once
} );
```

### Conditional Hooks

```php
add_action( 'init', function() {
    if ( is_admin() ) {
        add_action( 'admin_menu', 'add_my_menu' );
    } else {
        add_action( 'wp_footer', 'add_my_footer' );
    }
} );
```

### Hook All Calls (Debugging)

```php
add_action( 'all', function( $hook ) {
    error_log( 'Hook fired: ' . $hook );
} );
```

## Priority Guide

| Priority | Use Case |
|----------|----------|
| 1-4 | Must run first (setup, early modification) |
| 5-9 | Run early |
| 10 | Default |
| 11-19 | Run late |
| 20+ | Must run last (cleanup, final modification) |
| PHP_INT_MAX | Absolute last |

## Best Practices

1. **Use descriptive callback names** — `my_plugin_modify_title`, not `my_func`
2. **Always return in filters** — Even if unchanged, return the value
3. **Use appropriate priorities** — Don't use extreme values without reason
4. **Remove hooks you add** — In deactivation, undo what activation did
5. **Document custom hooks** — Let others know they can extend your code
