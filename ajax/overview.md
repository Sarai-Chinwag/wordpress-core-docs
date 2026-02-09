# WordPress AJAX API Overview

WordPress provides a structured AJAX system through `admin-ajax.php`, offering a standardized way for plugins and themes to handle asynchronous requests.

## Architecture

### Request Flow

```
Client JavaScript
      │
      ▼
POST /wp-admin/admin-ajax.php?action=my_action
      │
      ▼
┌─────────────────────────────────────────────┐
│ admin-ajax.php                              │
│ ┌─────────────────────────────────────────┐ │
│ │ 1. Define DOING_AJAX = true             │ │
│ │ 2. Load WordPress (wp-load.php)         │ │
│ │ 3. Load admin APIs                      │ │
│ │ 4. Load ajax-actions.php (core)         │ │
│ │ 5. Fire admin_init action               │ │
│ │ 6. Check user authentication            │ │
│ │ 7. Fire wp_ajax_{action} or             │ │
│ │    wp_ajax_nopriv_{action}              │ │
│ └─────────────────────────────────────────┘ │
└─────────────────────────────────────────────┘
      │
      ▼
Handler function (your callback)
      │
      ▼
Response (JSON/XML/HTML)
```

### Key Constants

```php
// Defined automatically when processing AJAX
define('DOING_AJAX', true);
define('WP_ADMIN', true);
```

### Endpoint URL

The AJAX endpoint is always `admin-ajax.php`:

```php
// PHP - get the URL
admin_url('admin-ajax.php');  // https://example.com/wp-admin/admin-ajax.php

// JavaScript (admin pages) - already available
ajaxurl  // Global variable set by WordPress
```

## Setting Up AJAX

### 1. Register JavaScript

```php
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
function my_enqueue_scripts() {
    wp_enqueue_script(
        'my-ajax-script',
        plugin_dir_url(__FILE__) . 'js/ajax.js',
        array('jquery'),
        '1.0.0',
        true
    );
    
    // Pass data to JavaScript
    wp_localize_script('my-ajax-script', 'MyAjax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('my_ajax_nonce'),
    ));
}
```

### 2. Register AJAX Handlers

```php
// For logged-in users
add_action('wp_ajax_my_action', 'handle_my_action');

// For logged-out users (public)
add_action('wp_ajax_nopriv_my_action', 'handle_my_action');

function handle_my_action() {
    // Verify nonce
    check_ajax_referer('my_ajax_nonce', 'nonce');
    
    // Process request
    $result = do_something($_POST['data']);
    
    // Return response
    wp_send_json_success($result);
}
```

### 3. Client-Side JavaScript

```javascript
// Using jQuery
jQuery.ajax({
    url: MyAjax.ajax_url,
    type: 'POST',
    data: {
        action: 'my_action',
        nonce: MyAjax.nonce,
        data: 'my_data'
    },
    success: function(response) {
        if (response.success) {
            console.log(response.data);
        }
    }
});

// Using Fetch API
fetch(MyAjax.ajax_url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: new URLSearchParams({
        action: 'my_action',
        nonce: MyAjax.nonce,
        data: 'my_data'
    })
})
.then(response => response.json())
.then(data => console.log(data));
```

## Authentication

WordPress automatically checks authentication and routes requests:

| User State | Hook Fired |
|-----------|------------|
| Logged in | `wp_ajax_{action}` |
| Logged out | `wp_ajax_nopriv_{action}` |

If no handler is registered, WordPress returns `0` with HTTP 400.

## Response Formats

### JSON (Recommended)

```php
// Success
wp_send_json_success(array('message' => 'Done'));
// Output: {"success":true,"data":{"message":"Done"}}

// Error
wp_send_json_error(array('message' => 'Failed'));
// Output: {"success":false,"data":{"message":"Failed"}}
```

### XML (Legacy)

```php
$response = new WP_Ajax_Response(array(
    'what'   => 'item',
    'id'     => 123,
    'data'   => 'Item content',
));
$response->send();
```

### Plain Text

```php
echo 'plain text response';
wp_die();
```

## Security

### Nonce Verification

Always verify nonces to prevent CSRF attacks:

```php
// Create nonce in PHP
wp_create_nonce('my_action_nonce');

// Verify in AJAX handler
check_ajax_referer('my_action_nonce', 'security');  // Dies on failure
// OR
if (!wp_verify_nonce($_POST['security'], 'my_action_nonce')) {
    wp_send_json_error('Invalid nonce');
}
```

### Capability Checks

Always verify user capabilities:

```php
function handle_admin_action() {
    check_ajax_referer('admin_action_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Insufficient permissions', 403);
    }
    
    // Proceed with admin action
}
```

### Data Sanitization

```php
$title = sanitize_text_field($_POST['title']);
$content = wp_kses_post($_POST['content']);
$id = absint($_POST['id']);
$email = sanitize_email($_POST['email']);
```

## Core AJAX Actions

WordPress defines many core AJAX actions in `wp-admin/includes/ajax-actions.php`:

### GET Actions
- `fetch-list` - Fetch list table data
- `ajax-tag-search` - Search tags
- `wp-compression-test` - Test compression support
- `imgedit-preview` - Image editor preview
- `oembed-cache` - Cache oEmbed data
- `autocomplete-user` - User autocomplete
- `dashboard-widgets` - Dashboard widget data
- `logged-in` - Check login status
- `rest-nonce` - Get REST API nonce

### POST Actions
- `heartbeat` - Heartbeat API
- `save-widget` - Save widget
- `delete-comment`, `delete-post`, `delete-tag` - Delete content
- `inline-save`, `inline-save-tax` - Quick edit
- `upload-attachment`, `save-attachment` - Media handling
- `install-plugin`, `update-plugin`, `delete-plugin` - Plugin management
- `install-theme`, `update-theme`, `delete-theme` - Theme management

## Heartbeat API

WordPress includes a Heartbeat API that uses AJAX for periodic communication:

```php
// Add data to heartbeat request
add_filter('heartbeat_send', function($response, $screen_id) {
    $response['my_data'] = get_my_data();
    return $response;
}, 10, 2);

// Process heartbeat data
add_filter('heartbeat_received', function($response, $data, $screen_id) {
    if (isset($data['my_request'])) {
        $response['my_response'] = process_request($data['my_request']);
    }
    return $response;
}, 10, 3);
```

## Detection Functions

```php
// Check if current request is AJAX
if (wp_doing_ajax()) {
    // This is an AJAX request
}

// The constant (set by admin-ajax.php)
if (defined('DOING_AJAX') && DOING_AJAX) {
    // This is an AJAX request
}
```

## Error Handling

```php
function my_ajax_handler() {
    try {
        check_ajax_referer('my_nonce', 'security');
        
        $result = risky_operation();
        
        wp_send_json_success($result);
        
    } catch (Exception $e) {
        wp_send_json_error(array(
            'message' => $e->getMessage(),
            'code'    => $e->getCode(),
        ), 500);
    }
}
```

## Best Practices

1. **Always use nonces** - Prevent CSRF attacks
2. **Check capabilities** - Don't rely on authentication alone
3. **Sanitize all input** - Never trust user data
4. **Use `wp_send_json_*`** - Consistent JSON responses
5. **Handle errors gracefully** - Return meaningful error messages
6. **Use `wp_die()`** - Ensures proper termination
7. **Consider REST API** - For new projects, REST API may be preferable

## AJAX vs REST API

| Feature | AJAX (admin-ajax.php) | REST API |
|---------|----------------------|----------|
| URL | Single endpoint | Resource-based URLs |
| Auth | Cookie-based | Multiple methods |
| Format | Any | JSON |
| Discoverability | None | Self-documenting |
| Caching | Manual | HTTP caching |

For new development, consider using the REST API instead. The AJAX system is maintained for backward compatibility and simple use cases.
