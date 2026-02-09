# WP_Ajax_Response Class

The `WP_Ajax_Response` class generates XML responses for AJAX requests. This is the legacy response format, primarily used by WordPress core for backward compatibility. For new code, prefer `wp_send_json_*` functions.

**File:** `wp-includes/class-wp-ajax-response.php`  
**Since:** WordPress 2.1.0

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Ajax_Response {
    public $responses = array();
    
    public function __construct($args = '');
    public function add($args = '');
    public function send();
}
```

## Properties

### `$responses`
- **Type:** `array`
- **Access:** `public`
- **Description:** Stores XML response strings to be sent

## Methods

### `__construct($args = '')`

Constructor that optionally passes arguments to `add()`.

**Parameters:**
- `$args` (string|array) - Optional. Arguments to pass to `add()`

**Example:**
```php
// Create and immediately add a response
$response = new WP_Ajax_Response(array(
    'what' => 'comment',
    'id'   => 42,
    'data' => 'Comment saved successfully',
));
```

### `add($args = '')`

Appends data to the XML response. Returns the XML string for the added response.

**Parameters:**

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `what` | string | `'object'` | XML element type, becomes child of `<response>` |
| `action` | string\|false | `false` | Action attribute value; defaults to `$_POST['action']` if false |
| `id` | int\|WP_Error | `0` | Response ID; if WP_Error, data is extracted from it |
| `old_id` | int\|false | `false` | Previous ID for updates; false hides attribute |
| `position` | string | `1` | Position hint: `1` (bottom), `-1` (top), HTML ID (after), `-HTML ID` (before) |
| `data` | string\|WP_Error | `''` | Response content; WP_Error outputs error codes/messages |
| `supplemental` | array | `array()` | Extra data output in `<supplemental>` element |

**Return:** `string` - The XML response fragment

**Example:**
```php
$response = new WP_Ajax_Response();

// Simple success
$response->add(array(
    'what' => 'row',
    'id'   => 123,
    'data' => '<tr><td>New row content</td></tr>',
));

// With supplemental data
$response->add(array(
    'what'         => 'item',
    'id'           => 456,
    'data'         => 'Item created',
    'supplemental' => array(
        'total_count' => 42,
        'timestamp'   => time(),
    ),
));

// Error response
$response->add(array(
    'what' => 'item',
    'id'   => new WP_Error('create_failed', 'Could not create item'),
));
```

### `send()`

Outputs the complete XML response and terminates execution.

**Behavior:**
1. Sets `Content-Type: text/xml` header
2. Outputs XML declaration and `<wp_ajax>` wrapper
3. Outputs all accumulated responses
4. Calls `wp_die()` (if AJAX) or `die()`

**Example:**
```php
$response = new WP_Ajax_Response();
$response->add(array(
    'what' => 'comment',
    'id'   => $comment_id,
    'data' => $comment_html,
));
$response->send();  // Outputs XML and exits
```

## XML Output Format

### Basic Structure

```xml
<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<wp_ajax>
    <response action='my_action_123'>
        <object id='123' position='1'>
            <response_data><![CDATA[Response content here]]></response_data>
        </object>
    </response>
</wp_ajax>
```

### With Supplemental Data

```xml
<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<wp_ajax>
    <response action='save_item_456'>
        <item id='456' position='1'>
            <response_data><![CDATA[Item saved]]></response_data>
            <supplemental>
                <count><![CDATA[42]]></count>
                <timestamp><![CDATA[1609459200]]></timestamp>
            </supplemental>
        </item>
    </response>
</wp_ajax>
```

### Error Response

```xml
<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<wp_ajax>
    <response action='create_item_0'>
        <item id='0' position='1'>
            <wp_error code='create_failed'><![CDATA[Could not create item]]></wp_error>
        </item>
    </response>
</wp_ajax>
```

### With Error Data

```xml
<?xml version='1.0' encoding='UTF-8' standalone='yes'?>
<wp_ajax>
    <response action='save_0'>
        <object id='0' position='1'>
            <wp_error code='validation_error'><![CDATA[Invalid input]]></wp_error>
            <wp_error_data code='validation_error'>
                <field><![CDATA[email]]></field>
                <reason><![CDATA[Invalid format]]></reason>
            </wp_error_data>
        </object>
    </response>
</wp_ajax>
```

## Complete Usage Example

### PHP Handler

```php
add_action('wp_ajax_add_item', 'handle_add_item');

function handle_add_item() {
    check_ajax_referer('add_item_nonce', 'security');
    
    if (!current_user_can('edit_posts')) {
        $response = new WP_Ajax_Response(array(
            'what' => 'item',
            'id'   => new WP_Error('permission_denied', 'You cannot add items'),
        ));
        $response->send();
    }
    
    $item_id = create_item($_POST['data']);
    
    if (is_wp_error($item_id)) {
        $response = new WP_Ajax_Response(array(
            'what' => 'item',
            'id'   => $item_id,  // Pass WP_Error directly
        ));
        $response->send();
    }
    
    $response = new WP_Ajax_Response(array(
        'what'         => 'item',
        'id'           => $item_id,
        'data'         => render_item_row($item_id),
        'position'     => 1,  // Add at bottom
        'supplemental' => array(
            'total' => get_item_count(),
        ),
    ));
    $response->send();
}
```

### JavaScript Handler

```javascript
jQuery.ajax({
    url: ajaxurl,
    type: 'POST',
    data: {
        action: 'add_item',
        security: nonce,
        data: itemData
    },
    dataType: 'xml',
    success: function(xml) {
        var $response = jQuery(xml).find('response');
        var $item = $response.find('item');
        
        // Check for errors
        var $error = $item.find('wp_error');
        if ($error.length) {
            alert('Error: ' + $error.text());
            return;
        }
        
        // Get response data
        var id = $item.attr('id');
        var html = $item.find('response_data').text();
        var total = $item.find('supplemental total').text();
        
        // Insert based on position
        var position = $item.attr('position');
        if (position === '1') {
            jQuery('#item-list').append(html);
        } else if (position === '-1') {
            jQuery('#item-list').prepend(html);
        }
        
        jQuery('#total-count').text(total);
    }
});
```

## Position Values

| Value | Meaning | Typical Use |
|-------|---------|-------------|
| `1` | Bottom | Append to list |
| `-1` | Top | Prepend to list |
| `html_id` | After element | Insert after `#html_id` |
| `-html_id` | Before element | Insert before `#html_id` |

## Multiple Responses

You can add multiple responses before sending:

```php
$response = new WP_Ajax_Response();

// Add multiple items
foreach ($items as $item) {
    $response->add(array(
        'what' => 'item',
        'id'   => $item->ID,
        'data' => render_item($item),
    ));
}

$response->send();
```

## When to Use

### Use WP_Ajax_Response When:
- Maintaining legacy code that expects XML
- Working with existing WordPress admin list tables
- Need structured multi-part responses

### Use wp_send_json_* Instead When:
- Building new AJAX handlers
- Working with modern JavaScript
- Need simpler response handling
- Building REST-like APIs

## Core Usage

WordPress core uses `WP_Ajax_Response` extensively in admin list tables for:

- Adding/deleting comments
- Adding/editing tags
- Inline editing posts
- Managing menu items
- Widget operations

Example from core (`wp-admin/includes/ajax-actions.php`):

```php
function wp_ajax_add_tag() {
    // ... validation ...
    
    $tag = wp_insert_term($tag_name, $taxonomy, $args);
    
    if (is_wp_error($tag)) {
        $x = new WP_Ajax_Response(array(
            'what' => 'taxonomy',
            'data' => $tag,
        ));
        $x->send();
    }
    
    // ... build response ...
    
    $x = new WP_Ajax_Response(array(
        'what'         => 'taxonomy',
        'supplemental' => $supplemental,
        'id'           => $tag['term_id'],
        'data'         => $tag_row,
    ));
    $x->send();
}
```
