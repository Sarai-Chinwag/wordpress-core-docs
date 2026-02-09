# WordPress AJAX Hooks

WordPress uses dynamic action hooks to route AJAX requests to handler functions.

## Primary Action Hooks

### wp_ajax_{action}

Fires for authenticated (logged-in) users.

**File:** `wp-admin/admin-ajax.php`  
**Since:** 2.1.0

```php
do_action( "wp_ajax_{$action}" );
```

The `{action}` portion is the value of `$_REQUEST['action']`.

**Example:**
```php
// Handler for action: my_custom_action
add_action('wp_ajax_my_custom_action', 'handle_my_custom_action');

function handle_my_custom_action() {
    check_ajax_referer('my_nonce', 'security');
    
    // Only logged-in users reach this code
    $user_id = get_current_user_id();
    
    wp_send_json_success(array('user_id' => $user_id));
}
```

**JavaScript:**
```javascript
jQuery.post(ajaxurl, {
    action: 'my_custom_action',  // Maps to wp_ajax_my_custom_action
    security: nonce
});
```

---

### wp_ajax_nopriv_{action}

Fires for unauthenticated (logged-out) users.

**File:** `wp-admin/admin-ajax.php`  
**Since:** 2.8.0

```php
do_action( "wp_ajax_nopriv_{$action}" );
```

**Example:**
```php
// Public action - both logged-in and logged-out users
add_action('wp_ajax_get_posts', 'handle_get_posts');
add_action('wp_ajax_nopriv_get_posts', 'handle_get_posts');

function handle_get_posts() {
    $posts = get_posts(array('numberposts' => 5));
    wp_send_json_success($posts);
}

// Private action - only logged-in users
add_action('wp_ajax_delete_post', 'handle_delete_post');
// No nopriv hook = logged-out users get 400 Bad Request
```

**Common Pattern:**
```php
// Same handler for both
add_action('wp_ajax_search', 'handle_search');
add_action('wp_ajax_nopriv_search', 'handle_search');

// Or different handlers
add_action('wp_ajax_save_draft', 'handle_save_draft_auth');
add_action('wp_ajax_nopriv_save_draft', 'handle_save_draft_noauth');

function handle_save_draft_noauth() {
    wp_send_json_error('Please log in to save drafts', 401);
}
```

---

## Security Hook

### check_ajax_referer

Fires after nonce verification in `check_ajax_referer()`.

**File:** `wp-includes/pluggable.php`  
**Since:** 2.1.0

```php
do_action( 'check_ajax_referer', string $action, false|int $result );
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$action` | string | The nonce action |
| `$result` | false\|int | `false` if invalid, `1` if 0-12h old, `2` if 12-24h old |

**Example:**
```php
add_action('check_ajax_referer', 'log_ajax_security', 10, 2);

function log_ajax_security($action, $result) {
    if ($result === false) {
        error_log(sprintf(
            'AJAX security failure: action=%s, IP=%s, user=%d',
            $action,
            $_SERVER['REMOTE_ADDR'],
            get_current_user_id()
        ));
    }
}
```

---

## Heartbeat Hooks

The Heartbeat API uses AJAX for periodic server communication.

### heartbeat_received

Filters the Heartbeat response for logged-in users.

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
$response = apply_filters( 'heartbeat_received', array $response, array $data, string $screen_id );
```

**Parameters:**
| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | array | Response data to send back |
| `$data` | array | Data received from client |
| `$screen_id` | string | Current admin screen ID |

**Example:**
```php
add_filter('heartbeat_received', 'my_heartbeat_received', 10, 3);

function my_heartbeat_received($response, $data, $screen_id) {
    // Check if client sent our data
    if (isset($data['my_plugin_check'])) {
        $response['my_plugin_status'] = array(
            'pending_tasks' => get_pending_task_count(),
            'last_update'   => get_last_update_time(),
        );
    }
    return $response;
}
```

---

### heartbeat_send

Filters the Heartbeat response before sending (logged-in users).

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
$response = apply_filters( 'heartbeat_send', array $response, string $screen_id );
```

**Example:**
```php
add_filter('heartbeat_send', 'my_heartbeat_send', 10, 2);

function my_heartbeat_send($response, $screen_id) {
    // Always send notification count
    $response['notification_count'] = get_user_notification_count();
    return $response;
}
```

---

### heartbeat_tick

Fires when Heartbeat ticks (logged-in users).

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
do_action( 'heartbeat_tick', array $response, string $screen_id );
```

**Example:**
```php
add_action('heartbeat_tick', 'on_heartbeat_tick', 10, 2);

function on_heartbeat_tick($response, $screen_id) {
    // Update user's last activity timestamp
    update_user_meta(get_current_user_id(), 'last_activity', time());
}
```

---

### heartbeat_nopriv_received

Filters Heartbeat response for logged-out users.

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
$response = apply_filters( 'heartbeat_nopriv_received', array $response, array $data, string $screen_id );
```

---

### heartbeat_nopriv_send

Filters Heartbeat response before sending (logged-out users).

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
$response = apply_filters( 'heartbeat_nopriv_send', array $response, string $screen_id );
```

---

### heartbeat_nopriv_tick

Fires when Heartbeat ticks (logged-out users).

**File:** `wp-admin/includes/ajax-actions.php`  
**Since:** 3.6.0

```php
do_action( 'heartbeat_nopriv_tick', array $response, string $screen_id );
```

---

## Detection Filter

### wp_doing_ajax

Filters whether the current request is an AJAX request.

**File:** `wp-includes/load.php`  
**Since:** 4.7.0

```php
$is_ajax = apply_filters( 'wp_doing_ajax', bool $wp_doing_ajax );
```

**Example:**
```php
add_filter('wp_doing_ajax', 'force_ajax_mode');

function force_ajax_mode($is_ajax) {
    // Treat custom endpoint as AJAX
    if (isset($_GET['custom_ajax'])) {
        return true;
    }
    return $is_ajax;
}
```

---

## Core AJAX Actions Reference

WordPress registers these core actions in `admin-ajax.php`:

### GET Actions

| Action | Handler | Description |
|--------|---------|-------------|
| `fetch-list` | `wp_ajax_fetch_list` | Fetch list table data |
| `ajax-tag-search` | `wp_ajax_ajax_tag_search` | Search tags/terms |
| `wp-compression-test` | `wp_ajax_wp_compression_test` | Test compression |
| `imgedit-preview` | `wp_ajax_imgedit_preview` | Image editor preview |
| `oembed-cache` | `wp_ajax_oembed_cache` | Cache oEmbed response |
| `autocomplete-user` | `wp_ajax_autocomplete_user` | User autocomplete |
| `dashboard-widgets` | `wp_ajax_dashboard_widgets` | Dashboard widgets |
| `logged-in` | `wp_ajax_logged_in` | Check login status |
| `rest-nonce` | `wp_ajax_rest_nonce` | Get REST API nonce |

### POST Actions (Selection)

| Action | Handler | Description |
|--------|---------|-------------|
| `heartbeat` | `wp_ajax_heartbeat` | Heartbeat API |
| `save-widget` | `wp_ajax_save_widget` | Save widget settings |
| `delete-comment` | `wp_ajax_delete_comment` | Delete comment |
| `delete-post` | `wp_ajax_delete_post` | Delete post |
| `trash-post` | `wp_ajax_trash_post` | Trash post |
| `inline-save` | `wp_ajax_inline_save` | Quick edit post |
| `upload-attachment` | `wp_ajax_upload_attachment` | Upload media |
| `save-attachment` | `wp_ajax_save_attachment` | Save attachment data |
| `install-plugin` | `wp_ajax_install_plugin` | Install plugin |
| `update-plugin` | `wp_ajax_update_plugin` | Update plugin |
| `delete-plugin` | `wp_ajax_delete_plugin` | Delete plugin |

### Nopriv Actions

| Action | Handler | Description |
|--------|---------|-------------|
| `heartbeat` | `wp_ajax_nopriv_heartbeat` | Heartbeat (logged out) |
| `generate-password` | `wp_ajax_nopriv_generate_password` | Generate password |

---

## Complete Hook Usage Example

```php
<?php
/**
 * Plugin Name: AJAX Example
 */

// Enqueue scripts and localize
add_action('wp_enqueue_scripts', 'my_ajax_enqueue');
function my_ajax_enqueue() {
    wp_enqueue_script(
        'my-ajax',
        plugin_dir_url(__FILE__) . 'ajax.js',
        array('jquery', 'heartbeat'),
        '1.0.0',
        true
    );
    
    wp_localize_script('my-ajax', 'MyAjax', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('my_ajax_nonce'),
    ));
}

// Register AJAX handlers
add_action('wp_ajax_my_action', 'handle_my_action');
add_action('wp_ajax_nopriv_my_action', 'handle_my_action_public');

function handle_my_action() {
    check_ajax_referer('my_ajax_nonce', 'security');
    
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Unauthorized', 403);
    }
    
    // Process request...
    wp_send_json_success(array('message' => 'Done'));
}

function handle_my_action_public() {
    wp_send_json_error('Login required', 401);
}

// Hook into Heartbeat
add_filter('heartbeat_received', 'my_heartbeat_received', 10, 3);
function my_heartbeat_received($response, $data, $screen_id) {
    if (!empty($data['my_plugin_tick'])) {
        $response['my_plugin_data'] = get_plugin_status();
    }
    return $response;
}

// Log security failures
add_action('check_ajax_referer', 'log_ajax_failures', 10, 2);
function log_ajax_failures($action, $result) {
    if ($result === false && strpos($action, 'my_') === 0) {
        // Log our plugin's nonce failures
        error_log("My Plugin: Nonce failure for {$action}");
    }
}
```

---

## Hook Priority

Default priority is `10`. For core actions registered in `admin-ajax.php`, priority is `1`:

```php
// Core uses priority 1
add_action('wp_ajax_' . $_POST['action'], 'wp_ajax_' . $function, 1);

// Your handlers default to priority 10
add_action('wp_ajax_my_action', 'my_handler');  // Priority 10

// Override core behavior with lower priority
add_action('wp_ajax_heartbeat', 'my_heartbeat_override', 0);
```

---

## Debugging AJAX Hooks

```php
// Log all AJAX actions
add_action('admin_init', function() {
    if (wp_doing_ajax()) {
        $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'unknown';
        error_log("AJAX Request: {$action}");
        error_log("User: " . (is_user_logged_in() ? get_current_user_id() : 'guest'));
    }
});

// Check if hook exists
add_action('wp_ajax_my_action', function() {
    error_log('Hooks on wp_ajax_my_action: ' . print_r(
        $GLOBALS['wp_filter']['wp_ajax_my_action'] ?? [],
        true
    ));
});
```
