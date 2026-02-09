# Admin Notices API

Admin notices are alert boxes displayed at the top of admin screens. They provide feedback to users about actions, errors, warnings, and general information.

## Core Function

### wp_admin_notice()

Display an admin notice (WordPress 6.4+).

```php
wp_admin_notice(
    string $message,
    array  $args = array()
);
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$message` | string | The message to display |
| `$args` | array | Configuration options |

**Args:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `type` | string | `''` | 'error', 'warning', 'success', 'info' |
| `dismissible` | bool | `false` | Whether notice is dismissible |
| `id` | string | `''` | HTML id attribute |
| `additional_classes` | array | `array()` | Extra CSS classes |
| `attributes` | array | `array()` | Additional HTML attributes |
| `paragraph_wrap` | bool | `true` | Wrap message in `<p>` |

**Example:**

```php
wp_admin_notice(
    __( 'Settings saved successfully.' ),
    array(
        'type'        => 'success',
        'dismissible' => true,
    )
);
```

## Notice Types

### Error Notice

```php
add_action( 'admin_notices', 'my_error_notice' );

function my_error_notice() {
    wp_admin_notice(
        __( 'An error occurred. Please try again.' ),
        array( 'type' => 'error' )
    );
}
```

### Warning Notice

```php
add_action( 'admin_notices', 'my_warning_notice' );

function my_warning_notice() {
    wp_admin_notice(
        __( 'Please backup your data before proceeding.' ),
        array( 'type' => 'warning' )
    );
}
```

### Success Notice

```php
add_action( 'admin_notices', 'my_success_notice' );

function my_success_notice() {
    wp_admin_notice(
        __( 'Your changes have been saved.' ),
        array(
            'type'        => 'success',
            'dismissible' => true,
        )
    );
}
```

### Info Notice

```php
add_action( 'admin_notices', 'my_info_notice' );

function my_info_notice() {
    wp_admin_notice(
        __( 'A new version of this plugin is available.' ),
        array( 'type' => 'info' )
    );
}
```

## Traditional HTML Approach

For WordPress versions before 6.4:

```php
add_action( 'admin_notices', 'traditional_notice' );

function traditional_notice() {
    $class   = 'notice notice-success is-dismissible';
    $message = __( 'Settings saved.' );
    
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
```

### Notice CSS Classes

| Class | Description |
|-------|-------------|
| `notice` | Base notice class |
| `notice-error` | Red error styling |
| `notice-warning` | Yellow warning styling |
| `notice-success` | Green success styling |
| `notice-info` | Blue info styling |
| `is-dismissible` | Adds dismiss button |
| `inline` | Display inline (not fixed) |
| `notice-alt` | Alternative styling |

## Conditional Notices

### Show on Specific Screens

```php
add_action( 'admin_notices', 'conditional_notice' );

function conditional_notice() {
    $screen = get_current_screen();
    
    // Only show on plugins page
    if ( 'plugins' !== $screen->id ) {
        return;
    }
    
    wp_admin_notice(
        __( 'Please configure your plugin settings.' ),
        array( 'type' => 'info' )
    );
}
```

### Show After Action

```php
add_action( 'admin_notices', 'action_result_notice' );

function action_result_notice() {
    if ( ! isset( $_GET['my_action_result'] ) ) {
        return;
    }
    
    $result = sanitize_key( $_GET['my_action_result'] );
    
    switch ( $result ) {
        case 'success':
            wp_admin_notice(
                __( 'Action completed successfully.' ),
                array( 'type' => 'success', 'dismissible' => true )
            );
            break;
        case 'error':
            wp_admin_notice(
                __( 'Action failed. Please try again.' ),
                array( 'type' => 'error' )
            );
            break;
    }
}
```

### Transient-Based Notices

```php
// Set notice after form submission
function handle_form_submission() {
    // Process form...
    
    set_transient( 'my_plugin_notice', array(
        'type'    => 'success',
        'message' => __( 'Form submitted successfully!' ),
    ), 30 );
    
    wp_redirect( admin_url( 'admin.php?page=my-plugin' ) );
    exit;
}

// Display the notice
add_action( 'admin_notices', 'display_transient_notice' );

function display_transient_notice() {
    $notice = get_transient( 'my_plugin_notice' );
    
    if ( ! $notice ) {
        return;
    }
    
    wp_admin_notice(
        $notice['message'],
        array(
            'type'        => $notice['type'],
            'dismissible' => true,
        )
    );
    
    delete_transient( 'my_plugin_notice' );
}
```

## Persistent Dismissible Notices

```php
add_action( 'admin_notices', 'persistent_notice' );

function persistent_notice() {
    // Check if dismissed
    if ( get_user_meta( get_current_user_id(), 'my_notice_dismissed', true ) ) {
        return;
    }
    
    $dismiss_url = wp_nonce_url(
        add_query_arg( 'dismiss_my_notice', '1' ),
        'dismiss_my_notice'
    );
    
    ?>
    <div class="notice notice-info is-dismissible" data-dismissible="my-notice">
        <p>
            <?php _e( 'Welcome to my plugin! Check out the documentation.' ); ?>
            <a href="<?php echo esc_url( $dismiss_url ); ?>">
                <?php _e( 'Dismiss forever' ); ?>
            </a>
        </p>
    </div>
    <?php
}

// Handle dismissal
add_action( 'admin_init', 'handle_notice_dismissal' );

function handle_notice_dismissal() {
    if ( ! isset( $_GET['dismiss_my_notice'] ) ) {
        return;
    }
    
    check_admin_referer( 'dismiss_my_notice' );
    
    update_user_meta( get_current_user_id(), 'my_notice_dismissed', true );
    
    wp_redirect( remove_query_arg( array( 'dismiss_my_notice', '_wpnonce' ) ) );
    exit;
}
```

## AJAX Dismissible Notices

```php
add_action( 'admin_notices', 'ajax_dismissible_notice' );

function ajax_dismissible_notice() {
    if ( get_user_meta( get_current_user_id(), 'my_ajax_notice_dismissed', true ) ) {
        return;
    }
    ?>
    <div class="notice notice-info is-dismissible" id="my-ajax-notice">
        <p><?php _e( 'This notice can be dismissed via AJAX.' ); ?></p>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#my-ajax-notice').on('click', '.notice-dismiss', function() {
            $.post(ajaxurl, {
                action: 'dismiss_my_ajax_notice',
                nonce: '<?php echo wp_create_nonce( 'dismiss_notice' ); ?>'
            });
        });
    });
    </script>
    <?php
}

add_action( 'wp_ajax_dismiss_my_ajax_notice', 'dismiss_my_ajax_notice' );

function dismiss_my_ajax_notice() {
    check_ajax_referer( 'dismiss_notice', 'nonce' );
    
    update_user_meta( get_current_user_id(), 'my_ajax_notice_dismissed', true );
    
    wp_die();
}
```

## Network Admin Notices

For multisite network admin:

```php
add_action( 'network_admin_notices', 'network_notice' );

function network_notice() {
    wp_admin_notice(
        __( 'This notice appears in network admin only.' ),
        array( 'type' => 'info' )
    );
}
```

## All Admin Notices Hook

Displays on all admin pages (including network and user admin):

```php
add_action( 'all_admin_notices', 'universal_notice' );

function universal_notice() {
    // Shows everywhere in admin
}
```

## Hooks for Notices

| Hook | Description |
|------|-------------|
| `admin_notices` | Standard admin notices hook |
| `network_admin_notices` | Network admin only |
| `user_admin_notices` | User admin only (multisite) |
| `all_admin_notices` | All admin contexts |

## Rich Content Notices

```php
add_action( 'admin_notices', 'rich_content_notice' );

function rich_content_notice() {
    ?>
    <div class="notice notice-info">
        <h3><?php _e( 'Getting Started' ); ?></h3>
        <p><?php _e( 'Welcome to our plugin! Here are some quick links:' ); ?></p>
        <ul>
            <li><a href="#"><?php _e( 'Settings' ); ?></a></li>
            <li><a href="#"><?php _e( 'Documentation' ); ?></a></li>
            <li><a href="#"><?php _e( 'Support' ); ?></a></li>
        </ul>
        <p>
            <a href="#" class="button button-primary">
                <?php _e( 'Get Started' ); ?>
            </a>
            <a href="#" class="button">
                <?php _e( 'Learn More' ); ?>
            </a>
        </p>
    </div>
    <?php
}
```

## Inline Notices

For notices within specific areas (not at top of page):

```php
function inline_notice() {
    wp_admin_notice(
        __( 'This appears inline, not at the top.' ),
        array(
            'type'               => 'warning',
            'additional_classes' => array( 'inline' ),
        )
    );
}
```

## Best Practices

1. **Be Specific**: Use appropriate notice type for the message
2. **Be Concise**: Keep messages short and actionable
3. **Respect Dismissals**: Remember user preferences
4. **Escape Output**: Always sanitize/escape content
5. **Check Capabilities**: Only show notices to appropriate users
6. **Limit Frequency**: Don't spam users with notices
7. **Target Screens**: Show notices where they're relevant

```php
add_action( 'admin_notices', 'best_practice_notice' );

function best_practice_notice() {
    // Check capability
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    // Check dismissal
    if ( get_option( 'my_notice_dismissed' ) ) {
        return;
    }
    
    // Target specific screen
    $screen = get_current_screen();
    if ( 'options-general' !== $screen->id ) {
        return;
    }
    
    // Display notice
    wp_admin_notice(
        wp_kses_post( __( 'Configure <a href="#">plugin settings</a> to get started.' ) ),
        array(
            'type'           => 'info',
            'dismissible'    => true,
            'paragraph_wrap' => true,
        )
    );
}
```
