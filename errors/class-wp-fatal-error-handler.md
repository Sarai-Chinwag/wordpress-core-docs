# WP_Fatal_Error_Handler

Default shutdown handler for fatal PHP errors.

**Source:** `wp-includes/class-wp-fatal-error-handler.php`  
**Since:** 5.2.0

## Description

`WP_Fatal_Error_Handler` handles fatal PHP errors that would normally cause a "white screen of death" (WSOD). It provides user-friendly error messages and integrates with WordPress Recovery Mode.

A drop-in `fatal-error-handler.php` in `wp-content/` can provide a custom handler class.

## Class Attributes

```php
#[AllowDynamicProperties]
class WP_Fatal_Error_Handler
```

## How It Works

1. Registered via `register_shutdown_function()` during WordPress bootstrap
2. When PHP encounters a fatal error, the shutdown function runs
3. Handler detects the error, checks if it should be handled
4. Attempts Recovery Mode for protected endpoints
5. Displays appropriate error template

---

## Methods

### handle()

Runs the shutdown handler. Registered via `register_shutdown_function()`.

```php
public function handle(): void
```

**Flow:**

1. Exit early if `WP_SANDBOX_SCRAPING` is defined
2. Exit early if in maintenance mode
3. Detect error via `detect_error()`
4. Load text domain if needed
5. Attempt Recovery Mode handling (single site, initialized)
6. Display error template if admin or headers not sent

**Example registration:**

```php
// Done automatically by wp_register_fatal_error_handler()
register_shutdown_function( array( $handler, 'handle' ) );
```

---

### detect_error() (protected)

Detects the error causing the crash.

```php
protected function detect_error(): ?array
```

**Returns:** Error array from `error_get_last()`, or `null` if no error or error shouldn't be handled.

**Error array structure:**

```php
array(
    'type'    => E_ERROR,           // Error type constant
    'message' => 'Error message',   // Error description
    'file'    => '/path/to/file.php',
    'line'    => 123,
)
```

---

### should_handle_error() (protected)

Determines whether WordPress should handle the error.

```php
protected function should_handle_error( array $error ): bool
```

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | array | Yes | Error from `error_get_last()` |

**Returns:** `true` if WordPress should handle the error.

**Handled error types:**

| Constant | Value | Description |
|----------|-------|-------------|
| `E_ERROR` | 1 | Fatal run-time error |
| `E_PARSE` | 4 | Compile-time parse error |
| `E_USER_ERROR` | 256 | User-generated fatal error |
| `E_COMPILE_ERROR` | 64 | Fatal compile-time error |
| `E_RECOVERABLE_ERROR` | 4096 | Catchable fatal error |

Additional errors can be included via the `wp_should_handle_php_error` filter.

---

### display_error_template() (protected)

Displays the PHP error template.

```php
protected function display_error_template( array $error, true|WP_Error $handled ): void
```

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | array | Yes | Error from `error_get_last()` |
| `$handled` | true\|WP_Error | Yes | Whether Recovery Mode handled the error |

**Template priority:**

1. Custom drop-in: `wp-content/php-error.php`
2. Default template via `display_default_error_template()`

---

### display_default_error_template() (protected)

Displays the default PHP error template using `wp_die()`.

```php
protected function display_default_error_template( array $error, true|WP_Error $handled ): void
```

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | array | Yes | Error from `error_get_last()` |
| `$handled` | true\|WP_Error | Yes | Whether Recovery Mode handled the error |

**Messages by context:**

| Context | Message |
|---------|---------|
| Recovery Mode active | "...putting it in recovery mode. Please check Themes and Plugins..." |
| Protected endpoint (multisite) | "...reach out to your site administrator..." |
| Protected endpoint (single) | "...check your site admin email inbox..." |
| Other | "There has been a critical error on this website." |

---

## Customization

### Custom Fatal Error Handler (Drop-in)

Create `wp-content/fatal-error-handler.php`:

```php
<?php
class My_Fatal_Error_Handler extends WP_Fatal_Error_Handler {
    
    protected function display_default_error_template( $error, $handled ) {
        // Custom error display
        http_response_code( 500 );
        echo '<h1>Site Temporarily Unavailable</h1>';
        echo '<p>We are experiencing technical difficulties.</p>';
        
        // Log the actual error
        error_log( sprintf(
            'Fatal error: %s in %s on line %d',
            $error['message'],
            $error['file'],
            $error['line']
        ) );
    }
}

return new My_Fatal_Error_Handler();
```

### Custom PHP Error Template (Drop-in)

Create `wp-content/php-error.php`:

```php
<?php
/**
 * Custom PHP error template.
 * 
 * Variables available:
 * - $error: Error array from error_get_last()
 * - $handled: Whether Recovery Mode handled the error
 */
http_response_code( 500 );
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Something went wrong</h1>
    <p>Please try again later.</p>
</body>
</html>
```

### Disabling the Handler

Via constant in `wp-config.php`:

```php
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', true );
```

Via filter (must be defined before WordPress loads):

```php
$GLOBALS['wp_filter'] = array(
    'wp_fatal_error_handler_enabled' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() {
                    return false;
                },
            ),
        ),
    ),
);
```

---

## Integration with Recovery Mode

When a fatal error occurs on a protected endpoint:

1. Error is detected by `WP_Fatal_Error_Handler`
2. `wp_recovery_mode()->handle_error()` is called
3. Recovery Mode:
   - Logs the error
   - Identifies the problematic extension
   - Pauses the extension
   - Sends recovery email to admin
4. Admin can access site via recovery link
5. Admin can fix or deactivate the extension

**Protected endpoints:**

- Admin pages (`/wp-admin/`)
- Login page (`wp-login.php`)
- REST API (selected routes)

---

## Error Handling Flow

```
PHP Fatal Error
    │
    ▼
register_shutdown_function() triggers
    │
    ▼
WP_Fatal_Error_Handler::handle()
    │
    ├── WP_SANDBOX_SCRAPING? → exit
    ├── Maintenance mode? → exit
    │
    ▼
detect_error()
    │
    ├── No error? → exit
    ├── should_handle_error() = false? → exit
    │
    ▼
Recovery Mode initialized?
    │
    ├── Yes → wp_recovery_mode()->handle_error()
    │         └── Pause extension, send email
    │
    ▼
display_error_template()
    │
    ├── php-error.php drop-in exists?
    │   └── Yes → require php-error.php
    │
    └── No → display_default_error_template()
             └── wp_die() with error message
```
