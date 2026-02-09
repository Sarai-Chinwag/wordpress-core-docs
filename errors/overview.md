# Error Handling

WordPress error handling system using the WP_Error class pattern and PHP error/exception handling.

**Since:** 2.1.0 (WP_Error), 5.2.0 (Fatal Error Handler), 6.7.0 (WP_Exception)  
**Source:** `wp-includes/class-wp-error.php`, `wp-includes/class-wp-exception.php`, `wp-includes/class-wp-fatal-error-handler.php`, `wp-includes/error-protection.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-error.md](./class-wp-error.md) | Error container class for returning errors |
| [class-wp-exception.md](./class-wp-exception.md) | Base exception class for exceptions |
| [class-wp-fatal-error-handler.md](./class-wp-fatal-error-handler.md) | Fatal PHP error handling |
| [functions.md](./functions.md) | Core error functions (`is_wp_error`, `wp_die`, etc.) |
| [hooks.md](./hooks.md) | Actions and filters for error handling |

## Philosophy: WP_Error vs Exceptions

WordPress historically uses **return-based error handling** rather than exception throwing. This design predates modern PHP practices but provides backward compatibility and explicit control flow.

### WP_Error Pattern

```php
function my_function() {
    if ( $something_wrong ) {
        return new WP_Error( 'error_code', 'Error message', array( 'status' => 400 ) );
    }
    return $success_value;
}

// Caller must check
$result = my_function();
if ( is_wp_error( $result ) ) {
    $code    = $result->get_error_code();
    $message = $result->get_error_message();
    // Handle error
}
```

### WP_Exception Pattern (Since 6.7.0)

```php
try {
    // Code that might throw
    throw new WP_Exception( 'Something went wrong' );
} catch ( WP_Exception $e ) {
    // Handle exception
}
```

### When to Use Each

| Use Case | Approach |
|----------|----------|
| API functions returning data | WP_Error (backward compatible) |
| Constructor failures | WP_Error (stored in property) |
| Validation errors | WP_Error |
| Critical internal errors | WP_Exception |
| Plugin/theme errors | WP_Error preferred |
| Recovery mode integration | WP_Error |

### Key Differences

| Aspect | WP_Error | WP_Exception |
|--------|----------|--------------|
| Multiple errors | Yes (can store multiple codes/messages) | No (single message) |
| Error data | Yes (arbitrary data per code) | No (use exception properties) |
| Flow control | Explicit check required | Automatic propagation |
| Legacy support | All WordPress versions | 6.7.0+ only |
| Stack trace | No | Yes |

## Error Flow

### Standard Error Return

```
Function returns WP_Error
    └── Caller checks is_wp_error()
        ├── TRUE: Handle error (get_error_message, etc.)
        └── FALSE: Continue with result
```

### Fatal Error Flow (5.2.0+)

```
PHP Fatal Error occurs
    └── register_shutdown_function() triggers
        └── WP_Fatal_Error_Handler::handle()
            ├── detect_error()
            ├── should_handle_error()
            ├── Recovery Mode (if available)
            └── display_error_template()
```

### wp_die() Flow

```
wp_die( $message, $title, $args )
    ├── Detect request type (Ajax, JSON, XML-RPC, HTML)
    ├── Apply handler filter (wp_die_handler, wp_die_ajax_handler, etc.)
    └── Call appropriate handler
        ├── _default_wp_die_handler() → HTML page
        ├── _ajax_wp_die_handler() → Plain text
        ├── _json_wp_die_handler() → JSON response
        ├── _xmlrpc_wp_die_handler() → XML-RPC fault
        └── _xml_wp_die_handler() → XML response
```

## Error Types Handled

The fatal error handler processes these PHP error types:

- `E_ERROR` - Fatal run-time errors
- `E_PARSE` - Compile-time parse errors
- `E_USER_ERROR` - User-generated fatal errors
- `E_COMPILE_ERROR` - Fatal compile-time errors
- `E_RECOVERABLE_ERROR` - Catchable fatal errors

## Recovery Mode

Since WordPress 5.2.0, fatal errors trigger Recovery Mode:

1. Error detected and logged
2. Recovery email sent to admin
3. Problematic plugin/theme paused
4. Site remains accessible via recovery link
5. Admin can fix issue and resume normal operation

## Best Practices

### Creating WP_Error

```php
// Simple error
return new WP_Error( 'invalid_id', 'Invalid post ID.' );

// With data (include HTTP status for REST API)
return new WP_Error( 
    'rest_forbidden',
    'You do not have permission.',
    array( 'status' => 403 )
);

// Multiple errors
$error = new WP_Error();
$error->add( 'field_email', 'Invalid email address.' );
$error->add( 'field_name', 'Name is required.' );
return $error;
```

### Checking Errors

```php
// Always check return values
$result = wp_insert_post( $args );
if ( is_wp_error( $result ) ) {
    error_log( $result->get_error_message() );
    return $result; // Propagate error
}
```

### Using wp_die()

```php
// Simple die
wp_die( 'Access denied.' );

// With WP_Error
wp_die( new WP_Error( 'forbidden', 'Access denied.', array( 'status' => 403 ) ) );

// With options
wp_die( 'Error message', 'Error Title', array(
    'response'  => 500,
    'back_link' => true,
) );
```
