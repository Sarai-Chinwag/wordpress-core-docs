# WordPress Bootstrap Hooks

Hooks fired during WordPress initialization and request handling, in execution order.

## Early Bootstrap Hooks

These hooks fire before plugins load. They can only be used by mu-plugins or by pre-defining filters in `wp-config.php`.

### enable_maintenance_mode

Filter whether to enable maintenance mode.

```php
apply_filters( 'enable_maintenance_mode', bool $enable, int $upgrading ): bool
```

**Parameters:**
- `$enable` - Whether to enable maintenance mode (default `true`)
- `$upgrading` - Timestamp from `.maintenance` file

**Since:** 4.6.0

---

### enable_wp_debug_mode_checks

Filter whether to apply debug mode settings.

```php
apply_filters( 'enable_wp_debug_mode_checks', bool $enable ): bool
```

**Default:** `true`

**Usage:** Define filter in `wp-config.php` before loading WordPress:
```php
$GLOBALS['wp_filter'] = array(
    'enable_wp_debug_mode_checks' => array(
        10 => array(
            array(
                'accepted_args' => 0,
                'function'      => function() { return false; },
            ),
        ),
    ),
);
```

**Since:** 4.6.0

---

### enable_loading_object_cache_dropin

Filter whether to load `object-cache.php` drop-in.

```php
apply_filters( 'enable_loading_object_cache_dropin', bool $enable ): bool
```

**Default:** `true`

**Since:** 5.8.0

---

## Plugin Loading Hooks

### muplugins_loaded

Action fired after must-use plugins load.

```php
do_action( 'muplugins_loaded' );
```

**When:** After mu-plugins are loaded, before regular plugins

**Since:** 2.8.0

---

### plugins_loaded

Action fired after all plugins load.

```php
do_action( 'plugins_loaded' );
```

**Common Uses:**
- Initialize plugin functionality
- Register custom post types (though `init` is preferred)
- Load plugin textdomains
- Check for plugin dependencies

**Since:** 1.5.0

---

## Theme Loading Hooks

### setup_theme

Action fired before theme is loaded.

```php
do_action( 'setup_theme' );
```

**When:** After plugins loaded, before theme's `functions.php`

**Common Uses:**
- Register theme support features
- Initialize theme-related functionality early

**Since:** 3.0.0

---

### after_setup_theme

Action fired after theme's `functions.php` loads.

```php
do_action( 'after_setup_theme' );
```

**Common Uses:**
- `add_theme_support()`
- Register nav menus
- Set content width
- Load theme textdomain

**Example:**
```php
add_action( 'after_setup_theme', function() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    register_nav_menus( array(
        'primary' => 'Primary Menu',
    ) );
} );
```

**Since:** 3.0.0

---

## Initialization Hooks

### init

Action fired after WordPress is fully loaded.

```php
do_action( 'init' );
```

**The most important hook.** WordPress core, plugins, and themes are all loaded.

**Common Uses:**
- Register post types and taxonomies
- Register shortcodes
- Initialize sessions
- Start output buffering
- Any initialization that requires full WordPress

**Example:**
```php
add_action( 'init', function() {
    register_post_type( 'book', array(
        'public' => true,
        'label'  => 'Books',
    ) );
} );
```

**Since:** 1.0.0

---

### wp_loaded

Action fired after WordPress and all plugins/themes are fully loaded.

```php
do_action( 'wp_loaded' );
```

**When:** After `init`, before request parsing

**Common Uses:**
- Buffer flushing
- Late initialization
- Actions that must run after all `init` hooks

**Since:** 3.0.0

---

## Request Parsing Hooks

### do_parse_request

Filter to short-circuit request parsing.

```php
apply_filters( 'do_parse_request', bool $parse, WP $wp, string|array $extra_query_vars ): bool
```

**Return:** `false` to prevent default parsing

**Use Case:** Custom routing, headless setups

**Since:** 3.5.0

---

### query_vars

Filter allowed public query variables.

```php
apply_filters( 'query_vars', array $public_query_vars ): array
```

**Example:**
```php
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'my_custom_var';
    return $vars;
} );
```

**Since:** 1.5.0

---

### request

Filter the parsed query variables.

```php
apply_filters( 'request', array $query_vars ): array
```

**Example:**
```php
add_filter( 'request', function( $query_vars ) {
    if ( isset( $query_vars['my_custom_var'] ) ) {
        $query_vars['post_type'] = 'custom';
    }
    return $query_vars;
} );
```

**Since:** 2.1.0

---

### parse_request

Action fired after request variables are parsed.

```php
do_action_ref_array( 'parse_request', array( WP &$wp ) );
```

**Access:** `$wp->query_vars`, `$wp->matched_rule`, `$wp->request`

**Since:** 2.1.0

---

## Headers Hooks

### wp_headers

Filter HTTP headers before sending.

```php
apply_filters( 'wp_headers', array $headers, WP $wp ): array
```

**Example:**
```php
add_filter( 'wp_headers', function( $headers ) {
    $headers['X-Custom-Header'] = 'value';
    return $headers;
} );
```

**Since:** 2.8.0

---

### send_headers

Action fired after headers are sent.

```php
do_action_ref_array( 'send_headers', array( WP &$wp ) );
```

**Since:** 2.1.0

---

## 404 Handling

### pre_handle_404

Filter to short-circuit 404 handling.

```php
apply_filters( 'pre_handle_404', bool $preempt, WP_Query $wp_query ): bool
```

**Return:** Non-false to skip default 404 handling

**Since:** 4.5.0

---

## Main Query Hook

### wp

Action fired after WordPress environment is set up.

```php
do_action_ref_array( 'wp', array( WP &$wp ) );
```

**The query is complete.** Posts are loaded, conditional tags work.

**Common Uses:**
- Redirect logic
- Access control checks
- Modify global post data

**Example:**
```php
add_action( 'wp', function( $wp ) {
    if ( is_singular( 'premium' ) && ! current_user_can( 'read_premium' ) ) {
        wp_redirect( home_url( '/subscribe/' ) );
        exit;
    }
} );
```

**Since:** 2.1.0

---

## Template Hooks

### template_redirect

Action fired before template loads.

```php
do_action( 'template_redirect' );
```

**Common Uses:**
- Redirects
- Output buffering
- Header modifications
- Access control

**Since:** 1.5.0

---

## Shutdown Hooks

### shutdown

Action fired when PHP shuts down.

```php
do_action( 'shutdown' );
```

**When:** Registered via `register_shutdown_function()`

**Common Uses:**
- Cleanup operations
- Logging
- Cache operations

**Since:** 1.2.0

---

## Default Filters (default-filters.php)

This file registers core filter and action callbacks. Key registrations:

### Content Filters

```php
// The Content
add_filter( 'the_content', 'do_blocks', 9 );
add_filter( 'the_content', 'wptexturize' );
add_filter( 'the_content', 'convert_smilies', 20 );
add_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'shortcode_unautop' );
add_filter( 'the_content', 'do_shortcode', 11 );
add_filter( 'the_content', 'wp_filter_content_tags', 12 );
```

### Title Filters

```php
add_filter( 'the_title', 'wptexturize' );
add_filter( 'the_title', 'convert_chars' );
add_filter( 'the_title', 'trim' );
```

### Excerpt Filters

```php
add_filter( 'the_excerpt', 'wptexturize' );
add_filter( 'the_excerpt', 'convert_smilies' );
add_filter( 'the_excerpt', 'convert_chars' );
add_filter( 'the_excerpt', 'wpautop' );
add_filter( 'get_the_excerpt', 'wp_trim_excerpt', 10, 2 );
```

### Head Actions

```php
add_action( 'wp_head', '_wp_render_title_tag', 1 );
add_action( 'wp_head', 'wp_enqueue_scripts', 1 );
add_action( 'wp_head', 'wp_resource_hints', 2 );
add_action( 'wp_head', 'feed_links', 2 );
add_action( 'wp_head', 'feed_links_extra', 3 );
add_action( 'wp_head', 'wp_robots', 1 );
add_action( 'wp_head', 'wp_print_styles', 8 );
add_action( 'wp_head', 'wp_print_head_scripts', 9 );
add_action( 'wp_head', 'wp_generator' );
add_action( 'wp_head', 'rel_canonical' );
add_action( 'wp_head', 'wp_site_icon', 99 );
```

### Footer Actions

```php
add_action( 'wp_footer', 'wp_print_footer_scripts', 20 );
```

### REST API Actions

```php
add_action( 'init', 'rest_api_init' );
add_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
add_action( 'rest_api_init', 'register_initial_settings', 10 );
add_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
add_action( 'parse_request', 'rest_api_loaded' );
```

### Authentication Filters

```php
add_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
add_filter( 'authenticate', 'wp_authenticate_email_password', 20, 3 );
add_filter( 'authenticate', 'wp_authenticate_application_password', 20, 3 );
add_filter( 'authenticate', 'wp_authenticate_spam_check', 99 );
add_filter( 'determine_current_user', 'wp_validate_auth_cookie' );
add_filter( 'determine_current_user', 'wp_validate_logged_in_cookie', 20 );
```

### Cron Actions

```php
add_action( 'init', 'wp_cron' );  // Only if not DOING_CRON
```

### Widget Actions

```php
add_action( 'plugins_loaded', 'wp_maybe_load_widgets', 0 );
add_action( 'init', 'wp_widgets_init', 1 );
```

### Theme Actions

```php
add_action( 'setup_theme', 'create_initial_theme_features', 0 );
add_action( 'after_setup_theme', '_add_default_theme_supports', 1 );
```

### Post Type/Taxonomy Actions

```php
add_action( 'init', 'create_initial_post_types', 0 );
add_action( 'init', 'create_initial_taxonomies', 0 );
```

---

## Hook Execution Order Summary

1. `enable_maintenance_mode` (filter)
2. `enable_wp_debug_mode_checks` (filter)
3. `enable_loading_object_cache_dropin` (filter)
4. **mu-plugins loaded**
5. `muplugins_loaded` (action)
6. **plugins loaded**
7. `plugins_loaded` (action)
8. `setup_theme` (action)
9. **theme functions.php loaded**
10. `after_setup_theme` (action)
11. `init` (action)
12. `wp_loaded` (action)
13. `do_parse_request` (filter)
14. `query_vars` (filter)
15. `request` (filter)
16. `parse_request` (action)
17. **WP_Query executed**
18. `pre_handle_404` (filter)
19. `wp_headers` (filter)
20. `send_headers` (action)
21. `wp` (action)
22. `template_redirect` (action)
23. **template loaded**
24. `shutdown` (action)

---

## Protected AJAX Actions

These AJAX actions are protected in recovery mode:

```php
$actions_to_protect = array(
    'edit-theme-plugin-file',
    'heartbeat',
    'install-plugin',
    'install-theme',
    'search-plugins',
    'search-install-plugins',
    'update-plugin',
    'update-theme',
    'activate-plugin',
);
```

**Filter:** `wp_protected_ajax_actions`

---

## Request Type Filters

### wp_doing_ajax

```php
apply_filters( 'wp_doing_ajax', bool $is_ajax ): bool
```

### wp_doing_cron

```php
apply_filters( 'wp_doing_cron', bool $is_cron ): bool
```

### wp_using_themes

```php
apply_filters( 'wp_using_themes', bool $use_themes ): bool
```

---

## Filter/Action Best Practices

### Priority Guidelines

- **0-5:** Core functionality, must run first
- **10:** Default priority
- **11-15:** After core filters (e.g., do_shortcode at 11)
- **20+:** Late execution
- **100+:** Final modifications

### Common Patterns

```php
// Add custom query var
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'my_var';
    return $vars;
} );

// Modify request
add_filter( 'request', function( $vars ) {
    if ( isset( $vars['my_var'] ) ) {
        // Modify query based on custom var
    }
    return $vars;
} );

// Late init
add_action( 'wp_loaded', function() {
    // Runs after all init hooks
}, 10 );

// Before template
add_action( 'template_redirect', function() {
    if ( some_condition() ) {
        include get_template_directory() . '/custom-template.php';
        exit;
    }
} );

// Modify headers
add_filter( 'wp_headers', function( $headers ) {
    $headers['X-Frame-Options'] = 'SAMEORIGIN';
    return $headers;
} );
```
