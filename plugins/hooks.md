# WordPress Plugin-Specific Hooks

This document covers hooks specifically related to plugin lifecycle, management, and pluggable function customization. For the general action/filter system, see the hooks-api documentation.

## Plugin Activation Hooks

### `activate_plugin`
Fires before a plugin is activated (non-silent only).

```php
add_action( 'activate_plugin', function( $plugin, $network_wide ) {
    error_log( "Activating: $plugin" );
}, 10, 2 );
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory
- `$network_wide` (bool) - Network activation (Multisite)

---

### `activate_{$plugin}`
Fires for a specific plugin during activation.

This is the hook used by `register_activation_hook()`.

```php
// For plugin 'my-plugin/my-plugin.php'
add_action( 'activate_my-plugin/my-plugin.php', function( $network_wide ) {
    // Activation logic
} );
```

**Parameters:**
- `$network_wide` (bool) - Network activation (Multisite)

---

### `activated_plugin`
Fires after a plugin has been activated (non-silent only).

```php
add_action( 'activated_plugin', function( $plugin, $network_wide ) {
    // Clear any caches
    wp_cache_flush();
}, 10, 2 );
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory
- `$network_wide` (bool) - Network activation

---

## Plugin Deactivation Hooks

### `deactivate_plugin`
Fires before a plugin is deactivated (non-silent only).

```php
add_action( 'deactivate_plugin', function( $plugin, $network_deactivating ) {
    error_log( "Deactivating: $plugin" );
}, 10, 2 );
```

**Parameters:**
- `$plugin` (string) - Plugin path relative to plugins directory
- `$network_deactivating` (bool) - Network deactivation

---

### `deactivate_{$plugin}`
Fires for a specific plugin during deactivation.

This is the hook used by `register_deactivation_hook()`.

```php
// For plugin 'my-plugin/my-plugin.php'
add_action( 'deactivate_my-plugin/my-plugin.php', function( $network_deactivating ) {
    // Cleanup scheduled tasks, transients, etc.
    wp_clear_scheduled_hook( 'my_plugin_cron_job' );
} );
```

---

### `deactivated_plugin`
Fires after a plugin has been deactivated (non-silent only).

```php
add_action( 'deactivated_plugin', function( $plugin, $network_deactivating ) {
    // Post-deactivation tasks
}, 10, 2 );
```

---

## Plugin Deletion Hooks

### `delete_plugin`
Fires before a plugin deletion attempt.

```php
add_action( 'delete_plugin', function( $plugin_file ) {
    // Log deletion attempt
    error_log( "Deleting plugin: $plugin_file" );
} );
```

**Parameters:**
- `$plugin_file` (string) - Plugin path relative to plugins directory

---

### `deleted_plugin`
Fires after a plugin deletion attempt.

```php
add_action( 'deleted_plugin', function( $plugin_file, $deleted ) {
    if ( $deleted ) {
        error_log( "Successfully deleted: $plugin_file" );
    }
}, 10, 2 );
```

**Parameters:**
- `$plugin_file` (string) - Plugin path
- `$deleted` (bool) - Whether deletion was successful

---

## Plugin Loading Hooks

### `muplugins_loaded`
Fires after must-use plugins have loaded.

```php
add_action( 'muplugins_loaded', function() {
    // All mu-plugins are now loaded
    // Regular plugins not yet loaded
} );
```

---

### `plugins_loaded`
Fires after all plugins have loaded.

```php
add_action( 'plugins_loaded', function() {
    // All plugins are now available
    // Good place for plugin compatibility checks
    if ( class_exists( 'WooCommerce' ) ) {
        // WooCommerce integration
    }
} );
```

**Priority considerations:**
- Default: 10
- Early (before most plugins): 0-5
- Late (after most plugins): 20+

---

### `plugin_loaded`
Fires after a single plugin is loaded.

```php
add_action( 'plugin_loaded', function( $plugin ) {
    // $plugin is the full path to the plugin file
} );
```

**Parameters:**
- `$plugin` (string) - Full path to plugin file

---

## Plugin Update Hooks

### `upgrader_process_complete`
Fires when plugin/theme/core update completes.

```php
add_action( 'upgrader_process_complete', function( $upgrader, $options ) {
    if ( 'plugin' === $options['type'] ) {
        // Plugin was updated
        $plugins = $options['plugins'] ?? array();
    }
}, 10, 2 );
```

**Parameters:**
- `$upgrader` (WP_Upgrader) - Upgrader instance
- `$options` (array) - Contains 'type', 'action', 'plugins'/'themes'

---

## Email Hooks (Pluggable)

### `wp_mail`
Filters all wp_mail() arguments.

```php
add_filter( 'wp_mail', function( $args ) {
    // Modify any email argument
    $args['subject'] = '[SITE] ' . $args['subject'];
    return $args;
} );
```

**Parameters:**
- `$args` (array) - 'to', 'subject', 'message', 'headers', 'attachments', 'embeds'

---

### `pre_wp_mail`
Short-circuits wp_mail() to prevent sending.

```php
add_filter( 'pre_wp_mail', function( $return, $atts ) {
    // Log instead of sending
    error_log( "Would send email to: " . print_r( $atts['to'], true ) );
    return true; // Pretend it was sent
}, 10, 2 );
```

**Returns:** Non-null value to short-circuit

---

### `wp_mail_from`
Filters the "from" email address.

```php
add_filter( 'wp_mail_from', function( $from_email ) {
    return 'noreply@example.com';
} );
```

---

### `wp_mail_from_name`
Filters the "from" name.

```php
add_filter( 'wp_mail_from_name', function( $from_name ) {
    return 'My Website';
} );
```

---

### `wp_mail_content_type`
Filters the content type.

```php
add_filter( 'wp_mail_content_type', function( $content_type ) {
    return 'text/html';
} );
```

---

### `wp_mail_charset`
Filters the character set.

```php
add_filter( 'wp_mail_charset', function( $charset ) {
    return 'UTF-8';
} );
```

---

### `phpmailer_init`
Customize PHPMailer directly.

```php
add_action( 'phpmailer_init', function( $phpmailer ) {
    // Use SMTP
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.example.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 'user@example.com';
    $phpmailer->Password = 'secret';
} );
```

**Parameters:**
- `$phpmailer` (PHPMailer) - Passed by reference

---

### `wp_mail_succeeded`
Fires after successful email send.

```php
add_action( 'wp_mail_succeeded', function( $mail_data ) {
    // Log successful email
    error_log( "Email sent to: " . implode( ', ', $mail_data['to'] ) );
} );
```

---

### `wp_mail_failed`
Fires when email sending fails.

```php
add_action( 'wp_mail_failed', function( $error ) {
    error_log( 'Email failed: ' . $error->get_error_message() );
} );
```

**Parameters:**
- `$error` (WP_Error) - Contains message and mail data

---

## Authentication Hooks

### `authenticate`
Filters user authentication.

```php
// Custom authentication source
add_filter( 'authenticate', function( $user, $username, $password ) {
    if ( ! $user && my_custom_auth( $username, $password ) ) {
        return get_user_by( 'login', $username );
    }
    return $user;
}, 30, 3 );
```

**Parameters:**
- `$user` (null|WP_User|WP_Error) - Current authentication result
- `$username` (string) - Username or email
- `$password` (string) - Password

**Default Handlers (priority):**
- 20: `wp_authenticate_username_password`
- 20: `wp_authenticate_email_password`
- 30: `wp_authenticate_spam_check`

---

### `wp_login_failed`
Fires after failed login attempt.

```php
add_action( 'wp_login_failed', function( $username, $error ) {
    // Track failed attempts
    $attempts = get_transient( 'login_attempts_' . $username ) ?: 0;
    set_transient( 'login_attempts_' . $username, $attempts + 1, HOUR_IN_SECONDS );
}, 10, 2 );
```

---

### `wp_login`
Fires after successful login.

```php
add_action( 'wp_login', function( $user_login, $user ) {
    // Log successful login
    update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
}, 10, 2 );
```

---

### `wp_logout`
Fires after user logs out.

```php
add_action( 'wp_logout', function( $user_id ) {
    // Cleanup user session data
    delete_user_meta( $user_id, 'my_session_data' );
} );
```

---

### `set_current_user`
Fires after current user is set.

```php
add_action( 'set_current_user', function() {
    $user = wp_get_current_user();
    // React to user change
} );
```

---

## Cookie Hooks

### `auth_cookie_expiration`
Filters cookie expiration time.

```php
add_filter( 'auth_cookie_expiration', function( $length, $user_id, $remember ) {
    if ( $remember ) {
        return 30 * DAY_IN_SECONDS; // 30 days instead of 14
    }
    return $length;
}, 10, 3 );
```

---

### `set_auth_cookie`
Fires before auth cookie is set.

```php
add_action( 'set_auth_cookie', function( $auth_cookie, $expire, $expiration, $user_id, $scheme, $token ) {
    // Additional cookie logic
}, 10, 6 );
```

---

### `set_logged_in_cookie`
Fires before logged-in cookie is set.

---

### `clear_auth_cookie`
Fires before auth cookies are cleared.

---

### `send_auth_cookies`
Filters whether to actually send auth cookies.

```php
add_filter( 'send_auth_cookies', function( $send ) {
    // Prevent cookies in headless context
    if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
        return false;
    }
    return $send;
} );
```

---

### Auth Cookie Validation Actions

```php
// Cookie is malformed
add_action( 'auth_cookie_malformed', function( $cookie, $scheme ) {}, 10, 2 );

// Cookie has expired
add_action( 'auth_cookie_expired', function( $cookie_elements ) {} );

// Username in cookie doesn't exist
add_action( 'auth_cookie_bad_username', function( $cookie_elements ) {} );

// Hash doesn't match
add_action( 'auth_cookie_bad_hash', function( $cookie_elements ) {} );

// Session token invalid
add_action( 'auth_cookie_bad_session_token', function( $cookie_elements ) {} );

// Cookie validated successfully
add_action( 'auth_cookie_valid', function( $cookie_elements, $user ) {}, 10, 2 );
```

---

## Nonce Hooks

### `nonce_life`
Filters nonce lifespan.

```php
add_filter( 'nonce_life', function( $lifespan, $action ) {
    // Shorter lifespan for sensitive actions
    if ( 'delete_post' === $action ) {
        return HOUR_IN_SECONDS;
    }
    return $lifespan;
}, 10, 2 );
```

---

### `nonce_user_logged_out`
Filters user ID for logged-out nonce creation.

```php
add_filter( 'nonce_user_logged_out', function( $uid, $action ) {
    return $uid; // 0 for logged out users
}, 10, 2 );
```

---

### `wp_verify_nonce_failed`
Fires when nonce verification fails.

```php
add_action( 'wp_verify_nonce_failed', function( $nonce, $action, $user, $token ) {
    error_log( "Nonce failed for action: $action" );
}, 10, 4 );
```

---

### `check_admin_referer`
Fires after admin referer check.

```php
add_action( 'check_admin_referer', function( $action, $result ) {
    // $result is false or 1/2
}, 10, 2 );
```

---

### `check_ajax_referer`
Fires after ajax referer check.

---

## Password Hooks

### `wp_hash_password_algorithm`
Filters the password hashing algorithm.

```php
add_filter( 'wp_hash_password_algorithm', function( $algorithm ) {
    return PASSWORD_ARGON2ID; // If available
} );
```

---

### `wp_hash_password_options`
Filters password hashing options.

```php
add_filter( 'wp_hash_password_options', function( $options, $algorithm ) {
    if ( PASSWORD_BCRYPT === $algorithm ) {
        $options['cost'] = 12;
    }
    return $options;
}, 10, 2 );
```

---

### `check_password`
Filters password verification result.

```php
add_filter( 'check_password', function( $check, $password, $hash, $user_id ) {
    return $check;
}, 10, 4 );
```

---

### `password_needs_rehash`
Filters whether password needs rehashing.

---

### `random_password`
Filters generated password.

```php
add_filter( 'random_password', function( $password, $length, $special, $extra_special ) {
    return $password;
}, 10, 4 );
```

---

### `wp_set_password`
Fires after password is set.

```php
add_action( 'wp_set_password', function( $password, $user_id, $old_user_data ) {
    // Notify user of password change
}, 10, 3 );
```

---

## Redirect Hooks

### `wp_redirect`
Filters redirect location.

```php
add_filter( 'wp_redirect', function( $location, $status ) {
    // Modify redirect URL
    return $location;
}, 10, 2 );
```

---

### `wp_redirect_status`
Filters redirect HTTP status code.

```php
add_filter( 'wp_redirect_status', function( $status, $location ) {
    return $status;
}, 10, 2 );
```

---

### `allowed_redirect_hosts`
Filters allowed redirect hosts for safe redirects.

```php
add_filter( 'allowed_redirect_hosts', function( $hosts, $host ) {
    $hosts[] = 'trusted-site.com';
    return $hosts;
}, 10, 2 );
```

---

### `wp_safe_redirect_fallback`
Filters fallback URL when redirect is unsafe.

```php
add_filter( 'wp_safe_redirect_fallback', function( $fallback, $status ) {
    return home_url();
}, 10, 2 );
```

---

## Salt & Hash Hooks

### `salt`
Filters the generated salt.

```php
add_filter( 'salt', function( $salt, $scheme ) {
    // Add extra entropy
    return $salt . 'extra-secret';
}, 10, 2 );
```

---

## Avatar Hooks

### `pre_get_avatar`
Short-circuits get_avatar().

```php
add_filter( 'pre_get_avatar', function( $avatar, $id_or_email, $args ) {
    // Return custom avatar HTML to skip Gravatar
    return '<img src="custom-avatar.png" />';
}, 10, 3 );
```

---

### `get_avatar`
Filters final avatar HTML.

```php
add_filter( 'get_avatar', function( $avatar, $id_or_email, $size, $default, $alt, $args ) {
    // Modify avatar HTML
    return $avatar;
}, 10, 6 );
```

---

## Plugin File Hooks

### `plugin_files_exclusions`
Filters directories/files excluded from plugin file scan.

```php
add_filter( 'plugin_files_exclusions', function( $exclusions ) {
    $exclusions[] = 'tests';
    $exclusions[] = '.git';
    return $exclusions;
} );
```

Default exclusions: 'CVS', 'node_modules', 'vendor', 'bower_components'

---

### `plugins_url`
Filters plugins directory URL.

```php
add_filter( 'plugins_url', function( $url, $path, $plugin ) {
    // Modify plugins URL (e.g., for CDN)
    return $url;
}, 10, 3 );
```
