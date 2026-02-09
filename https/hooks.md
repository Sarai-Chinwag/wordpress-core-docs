# HTTPS Hooks

Filters for customizing HTTPS detection and migration behavior.

---

## Filters

### pre_wp_get_https_detection_errors

Short-circuits the HTTPS detection process.

```php
apply_filters( 'pre_wp_get_https_detection_errors', null|WP_Error $pre )
```

**Since:** 6.4.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pre` | null\|WP_Error | Return WP_Error to short-circuit, null to continue |

**Returns:** `null` to proceed with detection, or `WP_Error` with errors array.

**Example: Force HTTPS as supported**

```php
add_filter( 'pre_wp_get_https_detection_errors', function( $pre ) {
    // Skip detection, assume HTTPS works
    return new WP_Error(); // Empty error = supported
} );
```

**Example: Force HTTPS as unsupported**

```php
add_filter( 'pre_wp_get_https_detection_errors', function( $pre ) {
    $error = new WP_Error();
    $error->add( 'custom_block', 'HTTPS disabled by policy' );
    return $error;
} );
```

**Example: Cache detection results**

```php
add_filter( 'pre_wp_get_https_detection_errors', function( $pre ) {
    $cached = get_transient( 'https_detection_cache' );
    if ( false !== $cached ) {
        $error = new WP_Error();
        foreach ( $cached as $code => $messages ) {
            foreach ( $messages as $message ) {
                $error->add( $code, $message );
            }
        }
        return $error;
    }
    return null; // Proceed with detection
} );
```

---

### site_url

Filters the site URL (used internally by `wp_is_site_url_using_https()`).

```php
apply_filters( 'site_url', string $url, string $path, string|null $scheme, int|null $blog_id )
```

**Note:** `wp_is_site_url_using_https()` manually applies this filter to the raw `siteurl` option value, because `site_url()` adjusts the scheme based on the current request.

**Documented in:** `wp-includes/link-template.php`

---

### wp_should_replace_insecure_home_url

Filters whether WordPress should replace HTTP URLs with HTTPS.

```php
apply_filters( 'wp_should_replace_insecure_home_url', bool $should_replace )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$should_replace` | bool | Whether insecure URLs should be replaced |

**Returns:** `true` to enable replacement, `false` to disable.

**Example: Disable automatic replacement**

```php
add_filter( 'wp_should_replace_insecure_home_url', '__return_false' );
```

**Example: Enable replacement after manual DB update**

```php
// After running search-replace in database, disable replacement
add_filter( 'wp_should_replace_insecure_home_url', function( $should ) {
    // Check if we've completed manual migration
    if ( get_option( 'manual_https_migration_done' ) ) {
        return false;
    }
    return $should;
} );
```

**Example: Force replacement for specific content types**

```php
add_filter( 'wp_should_replace_insecure_home_url', function( $should ) {
    // Always replace, even if migration flag is not set
    return wp_is_using_https();
} );
```

---

## Action Hooks

### update_option_home

Fires after the `home` option is updated.

```php
do_action( 'update_option_home', mixed $old_value, mixed $new_value, string $option )
```

**Internal usage:** `wp_update_https_migration_required()` is hooked to this action to automatically set the `https_migration_required` option when the home URL changes from HTTP to HTTPS.

**Documented in:** `wp-includes/option.php`

---

## Content Filters

`wp_replace_insecure_home_url()` is applied to these content filters to automatically replace HTTP URLs:

| Filter | Priority | Description |
|--------|----------|-------------|
| `the_content` | - | Post content |
| `the_excerpt` | - | Post excerpt |
| `widget_text_content` | - | Widget text |
| `wp_get_custom_css` | - | Custom CSS |

**Note:** These filters are applied in `wp-includes/default-filters.php` when WordPress loads.

---

## Usage Patterns

### Skip Detection for Known Configuration

```php
// If you know SSL is configured correctly
add_filter( 'pre_wp_get_https_detection_errors', function() {
    return new WP_Error(); // Empty = no errors = HTTPS supported
} );
```

### Custom SSL Verification

```php
add_filter( 'pre_wp_get_https_detection_errors', function() {
    // Custom verification logic
    $response = wp_remote_get( home_url( '/', 'https' ), array(
        'sslverify' => true,
        'timeout'   => 5,
    ) );
    
    $error = new WP_Error();
    if ( is_wp_error( $response ) ) {
        $error->add( 'custom_ssl_check', $response->get_error_message() );
    }
    return $error;
} );
```

### Conditional Migration

```php
// Only replace URLs for logged-in users (testing)
add_filter( 'wp_should_replace_insecure_home_url', function( $should ) {
    if ( ! is_user_logged_in() ) {
        return false;
    }
    return $should;
} );
```
