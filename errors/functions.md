# Error Functions

Core functions for error checking, termination, and error protection.

**Source:** `wp-includes/load.php`, `wp-includes/functions.php`, `wp-includes/error-protection.php`

---

## Error Checking

### is_wp_error()

Checks whether a variable is a WP_Error instance.

```php
function is_wp_error( mixed $thing ): bool
```

**Since:** 2.1.0  
**Source:** `wp-includes/load.php`

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$thing` | mixed | Yes | Variable to check |

**Returns:** `true` if `$thing` is a WP_Error instance.

**Fires:** `is_wp_error_instance` action (if true)

**Example:**

```php
$result = wp_insert_post( $args );

if ( is_wp_error( $result ) ) {
    echo 'Error: ' . $result->get_error_message();
    return;
}

echo 'Post created with ID: ' . $result;
```

---

## Execution Termination

### wp_die()

Kills WordPress execution and displays an error message.

```php
function wp_die( 
    string|WP_Error $message = '', 
    string|int $title = '', 
    string|array|int $args = array() 
): void
```

**Since:** 2.0.4  
**Source:** `wp-includes/functions.php`

| Parameter | Type | Required | Default | Description |
|-----------|------|----------|---------|-------------|
| `$message` | string\|WP_Error | No | `''` | Error message or WP_Error object |
| `$title` | string\|int | No | `''` | Error title (or response code if int) |
| `$args` | string\|array\|int | No | `[]` | Arguments (or response code if int) |

**Arguments:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `response` | int | 500 (200 for Ajax) | HTTP response code |
| `link_url` | string | `''` | URL for a link |
| `link_text` | string | `''` | Text for the link |
| `back_link` | bool | `false` | Show "Back" link |
| `text_direction` | string | auto | `'ltr'` or `'rtl'` |
| `charset` | string | `'utf-8'` | HTML charset |
| `code` | string | `'wp_die'` | Error code |
| `exit` | bool | `true` | Whether to exit after display |

**Handler selection:**

| Context | Filter | Default Handler |
|---------|--------|-----------------|
| Ajax request | `wp_die_ajax_handler` | `_ajax_wp_die_handler` |
| JSON request | `wp_die_json_handler` | `_json_wp_die_handler` |
| JSONP REST | `wp_die_jsonp_handler` | `_jsonp_wp_die_handler` |
| XML-RPC | `wp_die_xmlrpc_handler` | `_xmlrpc_wp_die_handler` |
| XML/Feed | `wp_die_xml_handler` | `_xml_wp_die_handler` |
| Default | `wp_die_handler` | `_default_wp_die_handler` |

**Examples:**

```php
// Simple message
wp_die( 'You do not have permission to access this page.' );

// With title and response code
wp_die( 'Invalid request.', 'Error', 400 );

// With WP_Error
$error = new WP_Error( 'forbidden', 'Access denied.', array( 'status' => 403 ) );
wp_die( $error );

// With options
wp_die( 'An error occurred.', 'Error', array(
    'response'  => 500,
    'back_link' => true,
    'exit'      => true,
) );

// Without exiting
wp_die( 'Warning message.', '', array( 'exit' => false ) );
echo 'This still runs.';
```

---

## Die Handlers (Internal)

### _default_wp_die_handler()

Default handler that displays an HTML error page.

```php
function _default_wp_die_handler( 
    string|WP_Error $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 3.0.0  
**Access:** Private

---

### _ajax_wp_die_handler()

Handler for Ajax requests. Returns plain text.

```php
function _ajax_wp_die_handler( 
    string $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 3.4.0  
**Access:** Private

Default response code: 200

---

### _json_wp_die_handler()

Handler for JSON requests.

```php
function _json_wp_die_handler( 
    string $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 5.1.0  
**Access:** Private

**Response format:**

```json
{
    "code": "error_code",
    "message": "Error message",
    "data": {
        "status": 500
    },
    "additional_errors": []
}
```

---

### _jsonp_wp_die_handler()

Handler for JSONP REST requests.

```php
function _jsonp_wp_die_handler( 
    string $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 5.2.0  
**Access:** Private

---

### _xmlrpc_wp_die_handler()

Handler for XML-RPC requests.

```php
function _xmlrpc_wp_die_handler( 
    string $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 3.2.0  
**Access:** Private

---

### _xml_wp_die_handler()

Handler for XML requests (feeds, trackbacks).

```php
function _xml_wp_die_handler( 
    string $message, 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 5.2.0  
**Access:** Private

**Response format:**

```xml
<error>
    <code>error_code</code>
    <title><![CDATA[Error Title]]></title>
    <message><![CDATA[Error message]]></message>
    <data>
        <status>500</status>
    </data>
</error>
```

---

### _scalar_wp_die_handler()

Handler for simple scalar output.

```php
function _scalar_wp_die_handler( 
    string $message = '', 
    string $title = '', 
    string|array $args = array() 
): void
```

**Since:** 3.4.0  
**Access:** Private

---

### _wp_die_process_input()

Processes arguments passed to `wp_die()` handlers.

```php
function _wp_die_process_input( 
    string|WP_Error $message, 
    string $title = '', 
    string|array $args = array() 
): array
```

**Since:** 5.1.0  
**Access:** Private

**Returns:** Array with `[ $message, $title, $parsed_args ]`

---

## Error Protection Functions

### wp_register_fatal_error_handler()

Registers the shutdown handler for fatal errors.

```php
function wp_register_fatal_error_handler(): void
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

Only registers if `wp_is_fatal_error_handler_enabled()` returns true.

---

### wp_is_fatal_error_handler_enabled()

Checks whether the fatal error handler is enabled.

```php
function wp_is_fatal_error_handler_enabled(): bool
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

**Returns:** `true` if enabled, `false` if disabled.

**Disabled by:**
- `WP_DISABLE_FATAL_ERROR_HANDLER` constant
- `wp_fatal_error_handler_enabled` filter

---

### wp_recovery_mode()

Access the WordPress Recovery Mode instance.

```php
function wp_recovery_mode(): WP_Recovery_Mode
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

**Returns:** Singleton `WP_Recovery_Mode` instance.

---

### wp_paused_plugins()

Gets the storage instance for paused plugins.

```php
function wp_paused_plugins(): WP_Paused_Extensions_Storage
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

---

### wp_paused_themes()

Gets the storage instance for paused themes.

```php
function wp_paused_themes(): WP_Paused_Extensions_Storage
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

---

### wp_get_extension_error_description()

Gets a human-readable description of an extension's error.

```php
function wp_get_extension_error_description( array $error ): string
```

**Since:** 5.2.0  
**Source:** `wp-includes/error-protection.php`

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `$error` | array | Yes | Error from `error_get_last()` |

**Returns:** Formatted error description string.

**Example output:**

> An error of type `E_ERROR` was caused in line `123` of the file `/path/to/file.php`. Error message: `Call to undefined function foo()`

---

## Usage Patterns

### Function Return Pattern

```php
function my_function( $id ) {
    if ( empty( $id ) ) {
        return new WP_Error( 'missing_id', 'ID is required.' );
    }
    
    $result = get_post( $id );
    
    if ( ! $result ) {
        return new WP_Error( 'not_found', 'Post not found.', array( 'status' => 404 ) );
    }
    
    return $result;
}

// Caller
$post = my_function( $id );
if ( is_wp_error( $post ) ) {
    wp_die( $post );
}
```

### Ajax Error Response

```php
add_action( 'wp_ajax_my_action', function() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_die( 'Unauthorized', '', 403 );
    }
    
    $result = do_something();
    
    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array(
            'code'    => $result->get_error_code(),
            'message' => $result->get_error_message(),
        ) );
    }
    
    wp_send_json_success( $result );
} );
```

### Custom wp_die Handler

```php
add_filter( 'wp_die_handler', function( $handler ) {
    return function( $message, $title, $args ) {
        // Log errors
        error_log( "wp_die called: $message" );
        
        // Call original handler
        _default_wp_die_handler( $message, $title, $args );
    };
} );
```
