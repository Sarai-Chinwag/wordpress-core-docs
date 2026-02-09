# Dashboard Widgets API

WordPress Dashboard Widgets API allows developers to add custom widgets to the WordPress admin dashboard. These widgets appear on the main Dashboard screen when users log in.

## Core Functions

### wp_add_dashboard_widget()

Adds a new dashboard widget.

```php
wp_add_dashboard_widget(
    string   $widget_id,
    string   $widget_name,
    callable $callback,
    callable $control_callback = null,
    array    $callback_args = null,
    string   $context = 'normal',
    string   $priority = 'core'
);
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$widget_id` | string | Widget ID (used in the 'id' attribute) |
| `$widget_name` | string | Title of the widget |
| `$callback` | callable | Function that outputs the widget content |
| `$control_callback` | callable | Optional. Function that outputs widget configuration controls |
| `$callback_args` | array | Optional. Data passed as the `$args` property |
| `$context` | string | Optional. 'normal', 'side', 'column3', or 'column4'. Default 'normal' |
| `$priority` | string | Optional. 'high', 'core', 'default', or 'low'. Default 'core' |

**Example: Basic Dashboard Widget**

```php
add_action( 'wp_dashboard_setup', 'my_custom_dashboard_widget' );

function my_custom_dashboard_widget() {
    wp_add_dashboard_widget(
        'my_custom_widget',          // Widget ID
        'My Custom Widget',          // Title
        'my_custom_widget_display'   // Display callback
    );
}

function my_custom_widget_display() {
    echo '<p>Hello, this is my custom dashboard widget!</p>';
}
```

**Example: Widget with Configuration**

```php
add_action( 'wp_dashboard_setup', 'configurable_dashboard_widget' );

function configurable_dashboard_widget() {
    wp_add_dashboard_widget(
        'configurable_widget',
        'Configurable Widget',
        'configurable_widget_display',
        'configurable_widget_control'  // Control callback
    );
}

function configurable_widget_display() {
    $options = get_option( 'configurable_widget_options', array() );
    $message = isset( $options['message'] ) ? $options['message'] : 'Default message';
    echo '<p>' . esc_html( $message ) . '</p>';
}

function configurable_widget_control() {
    $options = get_option( 'configurable_widget_options', array() );
    
    if ( isset( $_POST['configurable_widget_message'] ) ) {
        $options['message'] = sanitize_text_field( $_POST['configurable_widget_message'] );
        update_option( 'configurable_widget_options', $options );
    }
    
    $message = isset( $options['message'] ) ? $options['message'] : '';
    ?>
    <p>
        <label for="configurable_widget_message">Message:</label>
        <input type="text" id="configurable_widget_message" 
               name="configurable_widget_message" 
               value="<?php echo esc_attr( $message ); ?>" 
               class="widefat">
    </p>
    <?php
}
```

## Removing Dashboard Widgets

Use `remove_meta_box()` to remove dashboard widgets:

```php
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );

function remove_dashboard_widgets() {
    // Remove core widgets
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
    
    // Remove WordPress Events and News
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
```

## Widget Positioning

### Contexts

- **normal**: Main column (left side on multi-column layouts)
- **side**: Side column (right side)
- **column3**: Third column (if available)
- **column4**: Fourth column (if available)

### Priorities

- **high**: Displayed first
- **core**: Standard core widget priority
- **default**: Standard plugin priority
- **low**: Displayed last

## Hooks

### Actions

| Hook | Description |
|------|-------------|
| `wp_dashboard_setup` | Fires after core dashboard widgets are registered |
| `wp_network_dashboard_setup` | Fires after network admin dashboard widgets are registered |
| `wp_user_dashboard_setup` | Fires after user admin dashboard widgets are registered |

### Filters

| Filter | Description |
|--------|-------------|
| `wp_dashboard_widgets` | Filter the list of widget IDs to load |
| `wp_network_dashboard_widgets` | Filter widget IDs for network admin |
| `wp_user_dashboard_widgets` | Filter widget IDs for user admin |
| `dashboard_glance_items` | Add items to the "At a Glance" widget |

## Adding Items to "At a Glance"

```php
add_filter( 'dashboard_glance_items', 'add_custom_glance_items' );

function add_custom_glance_items( $items ) {
    $count = wp_count_posts( 'my_custom_post_type' );
    
    if ( $count && $count->publish ) {
        $text = sprintf(
            _n( '%s Custom Item', '%s Custom Items', $count->publish ),
            number_format_i18n( $count->publish )
        );
        
        $items[] = sprintf(
            '<a class="custom-item-count" href="%s">%s</a>',
            admin_url( 'edit.php?post_type=my_custom_post_type' ),
            $text
        );
    }
    
    return $items;
}
```

## AJAX-Enabled Widgets

```php
add_action( 'wp_dashboard_setup', 'ajax_dashboard_widget' );

function ajax_dashboard_widget() {
    wp_add_dashboard_widget(
        'ajax_widget',
        'AJAX Widget',
        'ajax_widget_display'
    );
}

function ajax_widget_display() {
    ?>
    <div id="ajax-widget-content">Loading...</div>
    <script>
    jQuery(document).ready(function($) {
        $.post(ajaxurl, {
            action: 'load_ajax_widget_content'
        }, function(response) {
            $('#ajax-widget-content').html(response);
        });
    });
    </script>
    <?php
}

add_action( 'wp_ajax_load_ajax_widget_content', 'load_ajax_widget_content' );

function load_ajax_widget_content() {
    // Verify user permissions
    if ( ! current_user_can( 'read' ) ) {
        wp_die( 'Unauthorized' );
    }
    
    echo '<p>Loaded via AJAX!</p>';
    wp_die();
}
```

## Best Practices

1. **Check Capabilities**: Always verify user permissions before displaying sensitive data
2. **Escape Output**: Use `esc_html()`, `esc_attr()`, etc.
3. **Enqueue Scripts Properly**: Use `admin_enqueue_scripts` for widget scripts
4. **Use Nonces**: For any form submissions in widgets
5. **Cache Data**: Dashboard loads frequently; cache expensive operations

```php
function optimized_widget_display() {
    // Cache expensive queries
    $data = get_transient( 'my_widget_data' );
    
    if ( false === $data ) {
        $data = expensive_data_query();
        set_transient( 'my_widget_data', $data, HOUR_IN_SECONDS );
    }
    
    // Display cached data
    echo '<p>' . esc_html( $data ) . '</p>';
}
```
