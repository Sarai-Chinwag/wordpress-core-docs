# Error Hooks

Actions and filters for WordPress error handling.

---

## Actions

### wp_error_added

Fires when an error is added to a WP_Error object.

```php
do_action( 'wp_error_added', string|int $code, string $message, mixed $data, WP_Error $wp_error )
```

**Since:** 5.6.0  
**Source:** `WP_Error::add()`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$code` | string\|int | Error code |
| `$message` | string | Error message |
| `$data` | mixed | Error data (might be empty) |
| `$wp_error` | WP_Error | The WP_Error object |

**Example:**

```php
add_action( 'wp_error_added', function( $code, $message, $data, $wp_error ) {
    // Log all errors
    error_log( sprintf( 'WP_Error: [%s] %s', $code, $message ) );
    
    // Track specific error codes
    if ( $code === 'rest_forbidden' ) {
        do_action( 'my_access_denied_tracking', $message, $data );
    }
}, 10, 4 );
```

---

### is_wp_error_instance

Fires when `is_wp_error()` detects a WP_Error instance.

```php
do_action( 'is_wp_error_instance', WP_Error $thing )
```

**Since:** 5.6.0  
**Source:** `is_wp_error()`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$thing` | WP_Error | The WP_Error object |

**Example:**

```php
add_action( 'is_wp_error_instance', function( $error ) {
    // Debug logging for development
    if ( WP_DEBUG ) {
        error_log( 'WP_Error encountered: ' . $error->get_error_message() );
    }
} );
```

**Note:** This fires every time `is_wp_error()` returns true, which can be frequent. Use sparingly.

---

## Filters

### wp_die_handler

Filters the callback for killing WordPress execution (default/HTML requests).

```php
apply_filters( 'wp_die_handler', callable $callback )
```

**Since:** 3.0.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_default_wp_die_handler'` | Handler function |

**Example:**

```php
add_filter( 'wp_die_handler', function( $handler ) {
    return function( $message, $title, $args ) use ( $handler ) {
        // Custom logging
        error_log( "wp_die: $message" );
        
        // Custom template for frontend
        if ( ! is_admin() ) {
            include get_template_directory() . '/error.php';
            exit;
        }
        
        // Default for admin
        call_user_func( $handler, $message, $title, $args );
    };
} );
```

---

### wp_die_ajax_handler

Filters the callback for killing WordPress execution for Ajax requests.

```php
apply_filters( 'wp_die_ajax_handler', callable $callback )
```

**Since:** 3.4.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_ajax_wp_die_handler'` | Handler function |

---

### wp_die_json_handler

Filters the callback for killing WordPress execution for JSON requests.

```php
apply_filters( 'wp_die_json_handler', callable $callback )
```

**Since:** 5.1.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_json_wp_die_handler'` | Handler function |

---

### wp_die_jsonp_handler

Filters the callback for killing WordPress execution for JSONP REST requests.

```php
apply_filters( 'wp_die_jsonp_handler', callable $callback )
```

**Since:** 5.2.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_jsonp_wp_die_handler'` | Handler function |

---

### wp_die_xmlrpc_handler

Filters the callback for killing WordPress execution for XML-RPC requests.

```php
apply_filters( 'wp_die_xmlrpc_handler', callable $callback )
```

**Since:** 3.4.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_xmlrpc_wp_die_handler'` | Handler function |

---

### wp_die_xml_handler

Filters the callback for killing WordPress execution for XML requests.

```php
apply_filters( 'wp_die_xml_handler', callable $callback )
```

**Since:** 5.2.0  
**Source:** `wp_die()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$callback` | callable | `'_xml_wp_die_handler'` | Handler function |

---

### wp_should_handle_php_error

Filters whether a PHP error should be handled by the fatal error handler.

```php
apply_filters( 'wp_should_handle_php_error', bool $should_handle, array $error )
```

**Since:** 5.2.0  
**Source:** `WP_Fatal_Error_Handler::should_handle_error()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$should_handle` | bool | `false` | Whether to handle the error |
| `$error` | array | — | Error from `error_get_last()` |

**Note:** This filter only fires for errors NOT already handled by default (E_ERROR, E_PARSE, etc.). It allows adding more error types.

**Example:**

```php
add_filter( 'wp_should_handle_php_error', function( $should_handle, $error ) {
    // Also handle E_WARNING in production
    if ( $error['type'] === E_WARNING && ! WP_DEBUG ) {
        return true;
    }
    return $should_handle;
}, 10, 2 );
```

---

### wp_fatal_error_handler_enabled

Filters whether the fatal error handler is enabled.

```php
apply_filters( 'wp_fatal_error_handler_enabled', bool $enabled )
```

**Since:** 5.2.0  
**Source:** `wp_is_fatal_error_handler_enabled()`

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$enabled` | bool | `true` | Whether handler is enabled |

**Important:** This filter runs before plugins load. Must be defined in `wp-config.php`:

```php
$GLOBALS['wp_filter'] = array(
    'wp_fatal_error_handler_enabled' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() {
                    return false; // Disable handler
                },
            ),
        ),
    ),
);
```

---

### wp_php_error_message

Filters the message displayed by the default PHP error template.

```php
apply_filters( 'wp_php_error_message', string $message, array $error )
```

**Since:** 5.2.0  
**Source:** `WP_Fatal_Error_Handler::display_default_error_template()`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$message` | string | HTML error message |
| `$error` | array | Error from `error_get_last()` |

**Example:**

```php
add_filter( 'wp_php_error_message', function( $message, $error ) {
    // Add contact info
    $message .= '<p>Contact support: support@example.com</p>';
    
    // Add error details in debug mode
    if ( WP_DEBUG_DISPLAY ) {
        $message .= sprintf(
            '<pre>%s in %s on line %d</pre>',
            esc_html( $error['message'] ),
            esc_html( $error['file'] ),
            $error['line']
        );
    }
    
    return $message;
}, 10, 2 );
```

---

### wp_php_error_args

Filters the arguments passed to `wp_die()` for the default PHP error template.

```php
apply_filters( 'wp_php_error_args', array $args, array $error )
```

**Since:** 5.2.0  
**Source:** `WP_Fatal_Error_Handler::display_default_error_template()`

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Arguments for `wp_die()` |
| `$error` | array | Error from `error_get_last()` |

**Default args:**

```php
array(
    'response' => 500,
    'exit'     => false,
)
```

**Example:**

```php
add_filter( 'wp_php_error_args', function( $args, $error ) {
    // Add a link to status page
    $args['link_url']  = 'https://status.example.com';
    $args['link_text'] = 'Check system status';
    
    return $args;
}, 10, 2 );
```

---

## Hook Reference Table

| Hook | Type | Since | Context |
|------|------|-------|---------|
| `wp_error_added` | Action | 5.6.0 | WP_Error::add() |
| `is_wp_error_instance` | Action | 5.6.0 | is_wp_error() |
| `wp_die_handler` | Filter | 3.0.0 | HTML requests |
| `wp_die_ajax_handler` | Filter | 3.4.0 | Ajax requests |
| `wp_die_json_handler` | Filter | 5.1.0 | JSON requests |
| `wp_die_jsonp_handler` | Filter | 5.2.0 | JSONP requests |
| `wp_die_xmlrpc_handler` | Filter | 3.4.0 | XML-RPC requests |
| `wp_die_xml_handler` | Filter | 5.2.0 | XML/feed requests |
| `wp_should_handle_php_error` | Filter | 5.2.0 | Fatal error detection |
| `wp_fatal_error_handler_enabled` | Filter | 5.2.0 | Handler registration |
| `wp_php_error_message` | Filter | 5.2.0 | Error display |
| `wp_php_error_args` | Filter | 5.2.0 | Error display |

---

## Testing Hooks

For unit tests, use filters to capture `wp_die()` calls:

```php
// In test setup
add_filter( 'wp_die_handler', function() {
    return function( $message, $title, $args ) {
        throw new WPDieException( $message );
    };
} );

// In test
$this->expectException( WPDieException::class );
wp_die( 'Test error' );
```
