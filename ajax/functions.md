# WordPress AJAX Functions

Core functions for handling AJAX requests and responses.

## Response Functions

### wp_send_json()

Sends a JSON response and terminates execution.

**File:** `wp-includes/functions.php`  
**Since:** 3.5.0

```php
wp_send_json( mixed $response, int $status_code = null, int $flags = 0 ): void
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | mixed | Data to encode as JSON |
| `$status_code` | int\|null | HTTP status code (since 4.7.0) |
| `$flags` | int | `json_encode()` flags (since 5.6.0) |

**Behavior:**
1. Sets `Content-Type: application/json` header
2. Sets HTTP status code if provided
3. Outputs JSON-encoded response
4. Calls `wp_die()` (AJAX) or `die()`

**Example:**
```php
// Basic response
wp_send_json(array('status' => 'ok', 'count' => 42));
// Output: {"status":"ok","count":42}

// With status code
wp_send_json(array('error' => 'Not found'), 404);

// With JSON flags
wp_send_json($data, 200, JSON_PRETTY_PRINT);
```

**Note:** Don't use in REST API callbacks - return `WP_REST_Response` instead.

---

### wp_send_json_success()

Sends a JSON success response with standardized format.

**File:** `wp-includes/functions.php`  
**Since:** 3.5.0

```php
wp_send_json_success( mixed $value = null, int $status_code = null, int $flags = 0 ): void
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Data to include in response (optional) |
| `$status_code` | int\|null | HTTP status code (since 4.7.0) |
| `$flags` | int | `json_encode()` flags (since 5.6.0) |

**Output Format:**
```json
{
    "success": true,
    "data": <value>
}
```

**Examples:**
```php
// Without data
wp_send_json_success();
// Output: {"success":true}

// With data
wp_send_json_success(array('id' => 123, 'title' => 'New Post'));
// Output: {"success":true,"data":{"id":123,"title":"New Post"}}

// With status code
wp_send_json_success($data, 201);  // Created
```

---

### wp_send_json_error()

Sends a JSON error response with standardized format.

**File:** `wp-includes/functions.php`  
**Since:** 3.5.0

```php
wp_send_json_error( mixed $value = null, int $status_code = null, int $flags = 0 ): void
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Error data or WP_Error object |
| `$status_code` | int\|null | HTTP status code (since 4.7.0) |
| `$flags` | int | `json_encode()` flags (since 5.6.0) |

**Output Format (basic):**
```json
{
    "success": false,
    "data": <value>
}
```

**Output Format (with WP_Error):**
```json
{
    "success": false,
    "data": [
        {"code": "error_code", "message": "Error message"},
        {"code": "another_error", "message": "Another message"}
    ]
}
```

**Examples:**
```php
// Simple error
wp_send_json_error('Something went wrong');
// Output: {"success":false,"data":"Something went wrong"}

// With error array
wp_send_json_error(array('field' => 'email', 'message' => 'Invalid email'));

// With WP_Error (since 4.1.0)
$error = new WP_Error('invalid_id', 'ID not found');
$error->add('permission_denied', 'Cannot access this resource');
wp_send_json_error($error);
// Output: {"success":false,"data":[{"code":"invalid_id","message":"ID not found"},{"code":"permission_denied","message":"Cannot access this resource"}]}

// With HTTP status
wp_send_json_error('Forbidden', 403);
```

---

## Detection Functions

### wp_doing_ajax()

Determines if the current request is a WordPress AJAX request.

**File:** `wp-includes/load.php`  
**Since:** 4.7.0

```php
wp_doing_ajax(): bool
```

**Return:** `true` if `DOING_AJAX` constant is defined and true.

**Example:**
```php
if (wp_doing_ajax()) {
    // Handle AJAX-specific logic
    wp_send_json_error('Unauthorized');
} else {
    // Handle normal request
    wp_redirect(home_url());
    exit;
}
```

**Filter:** `wp_doing_ajax`
```php
add_filter('wp_doing_ajax', function($is_ajax) {
    // Force AJAX mode for specific requests
    if (isset($_GET['ajax_mode'])) {
        return true;
    }
    return $is_ajax;
});
```

---

## Security Functions

### check_ajax_referer()

Verifies the AJAX request nonce to prevent CSRF attacks.

**File:** `wp-includes/pluggable.php`  
**Since:** 2.0.3

```php
check_ajax_referer( int|string $action = -1, false|string $query_arg = false, bool $stop = true ): int|false
```

**Parameters:**
| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$action` | int\|string | `-1` | Nonce action name |
| `$query_arg` | false\|string | `false` | Key in `$_REQUEST` to check; if false, checks `_ajax_nonce` then `_wpnonce` |
| `$stop` | bool | `true` | Whether to die on failure |

**Return:**
- `1` - Nonce valid, generated 0-12 hours ago
- `2` - Nonce valid, generated 12-24 hours ago
- `false` - Nonce invalid

**Examples:**
```php
// Basic usage - dies on failure
check_ajax_referer('my_action_nonce');

// Specify the request parameter
check_ajax_referer('my_action_nonce', 'security');

// Don't die, handle manually
$result = check_ajax_referer('my_action_nonce', 'nonce', false);
if (!$result) {
    wp_send_json_error(array(
        'code' => 'invalid_nonce',
        'message' => 'Security check failed. Please refresh and try again.',
    ), 403);
}
```

**Action:** `check_ajax_referer`
```php
// Fired after nonce verification
add_action('check_ajax_referer', function($action, $result) {
    if ($result === false) {
        error_log("Failed nonce check for action: $action");
    }
}, 10, 2);
```

---

### wp_create_nonce()

Creates a cryptographic nonce for AJAX security.

**File:** `wp-includes/pluggable.php`  
**Since:** 2.0.3

```php
wp_create_nonce( int|string $action = -1 ): string
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$action` | int\|string | Nonce action name |

**Return:** 10-character nonce string

**Example:**
```php
// Create nonce for localization
wp_localize_script('my-script', 'MySettings', array(
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('my_ajax_action'),
));
```

---

### wp_verify_nonce()

Verifies a nonce is correct and not expired.

**File:** `wp-includes/pluggable.php`  
**Since:** 2.0.3

```php
wp_verify_nonce( string $nonce, int|string $action = -1 ): int|false
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$nonce` | string | Nonce to verify |
| `$action` | int\|string | Nonce action name |

**Return:**
- `1` - Nonce valid, generated 0-12 hours ago
- `2` - Nonce valid, generated 12-24 hours ago  
- `false` - Nonce invalid

**Example:**
```php
function my_ajax_handler() {
    $nonce = isset($_POST['nonce']) ? $_POST['nonce'] : '';
    
    if (!wp_verify_nonce($nonce, 'my_ajax_action')) {
        wp_send_json_error('Invalid security token', 403);
    }
    
    // Proceed with handler
}
```

---

## Termination Functions

### wp_die()

Kills WordPress execution and displays an error message.

**File:** `wp-includes/functions.php`  
**Since:** 2.0.4

```php
wp_die( string|WP_Error $message = '', string|int $title = '', array|int $args = array() ): void
```

In AJAX context, `wp_die()` behaves differently - it outputs the message and exits cleanly without displaying an error page.

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$message` | string\|WP_Error | Error message or WP_Error |
| `$title` | string\|int | Error title or HTTP status code |
| `$args` | array\|int | Additional arguments or HTTP status code |

**AJAX-specific Args:**
| Key | Type | Description |
|-----|------|-------------|
| `response` | int | HTTP status code |

**Examples:**
```php
// Simple AJAX exit
wp_die();

// Exit with message
wp_die('Operation complete');

// Exit with status code
wp_die('Not found', 404);

// Exit with response code
wp_die('Forbidden', '', array('response' => 403));

// In JSON handlers, prefer:
wp_send_json_error('message', 403);
```

---

## Utility Functions

### wp_json_encode()

Encodes data to JSON with WordPress-specific handling.

**File:** `wp-includes/functions.php`  
**Since:** 4.1.0

```php
wp_json_encode( mixed $value, int $flags = 0, int $depth = 512 ): string|false
```

**Features:**
- Handles UTF-8 encoding issues
- Provides fallback for encoding failures

**Example:**
```php
$json = wp_json_encode(array(
    'title' => 'My Post',
    'content' => $html_content,
), JSON_UNESCAPED_UNICODE);
```

---

### wp_check_jsonp_callback()

Validates a JSONP callback function name.

**File:** `wp-includes/functions.php`  
**Since:** 4.6.0

```php
wp_check_jsonp_callback( string $callback ): bool
```

**Allowed Characters:** Alphanumeric and `.` (dot)

**Example:**
```php
$callback = isset($_GET['callback']) ? $_GET['callback'] : '';

if ($callback && wp_check_jsonp_callback($callback)) {
    header('Content-Type: application/javascript');
    echo $callback . '(' . wp_json_encode($data) . ');';
    wp_die();
} else {
    wp_send_json($data);
}
```

---

## Complete Handler Example

```php
/**
 * Register AJAX handlers
 */
add_action('wp_ajax_save_settings', 'handle_save_settings');
add_action('wp_ajax_nopriv_save_settings', 'handle_save_settings_nopriv');

/**
 * Handle logged-in requests
 */
function handle_save_settings() {
    // 1. Verify nonce
    check_ajax_referer('settings_nonce', 'security');
    
    // 2. Check capabilities
    if (!current_user_can('manage_options')) {
        wp_send_json_error(
            array('message' => 'Permission denied'),
            403
        );
    }
    
    // 3. Sanitize input
    $settings = array(
        'title'   => sanitize_text_field($_POST['title'] ?? ''),
        'enabled' => (bool) ($_POST['enabled'] ?? false),
        'limit'   => absint($_POST['limit'] ?? 10),
    );
    
    // 4. Validate
    if (empty($settings['title'])) {
        wp_send_json_error(
            array('field' => 'title', 'message' => 'Title is required')
        );
    }
    
    // 5. Process
    $result = update_option('my_settings', $settings);
    
    if (!$result) {
        wp_send_json_error(
            array('message' => 'Failed to save settings')
        );
    }
    
    // 6. Return success
    wp_send_json_success(array(
        'message'  => 'Settings saved',
        'settings' => $settings,
    ));
}

/**
 * Handle logged-out requests
 */
function handle_save_settings_nopriv() {
    wp_send_json_error(
        array('message' => 'You must be logged in'),
        401
    );
}
```

---

## Function Quick Reference

| Function | Purpose | Terminates |
|----------|---------|------------|
| `wp_send_json()` | Send raw JSON | Yes |
| `wp_send_json_success()` | Send `{success:true}` response | Yes |
| `wp_send_json_error()` | Send `{success:false}` response | Yes |
| `wp_doing_ajax()` | Check if AJAX request | No |
| `check_ajax_referer()` | Verify nonce (die on fail) | Optional |
| `wp_verify_nonce()` | Verify nonce (return result) | No |
| `wp_create_nonce()` | Create nonce | No |
| `wp_die()` | Terminate execution | Yes |
| `wp_json_encode()` | Encode to JSON | No |
