# Site Health & Transients Hooks

Actions and filters for Site Health and Transients APIs.

---

## Transient Hooks

### Actions

#### delete_transient_{$transient}

Fires before a specific transient is deleted.

```php
do_action( "delete_transient_{$transient}", string $transient )
```

**Since:** 3.0.0

#### deleted_transient

Fires after any transient is deleted.

```php
do_action( 'deleted_transient', string $transient )
```

**Since:** 3.0.0

#### set_transient_{$transient}

Fires after a specific transient is set.

```php
do_action( "set_transient_{$transient}", mixed $value, int $expiration, string $transient )
```

**Since:** 3.0.0

#### set_transient

Fires after any transient is set.

```php
do_action( 'set_transient', string $transient, mixed $value, int $expiration )
```

**Since:** 6.8.0

---

### Filters

#### pre_transient_{$transient}

Short-circuits transient retrieval.

```php
apply_filters( "pre_transient_{$transient}", mixed $pre_transient, string $transient )
```

**Since:** 2.8.0  
**Returns:** Return non-false to skip database lookup.

#### transient_{$transient}

Filters the value after retrieval.

```php
apply_filters( "transient_{$transient}", mixed $value, string $transient )
```

**Since:** 2.8.0

#### pre_set_transient_{$transient}

Filters value before saving.

```php
apply_filters( "pre_set_transient_{$transient}", mixed $value, int $expiration, string $transient )
```

**Since:** 3.0.0

#### expiration_of_transient_{$transient}

Filters expiration time before saving.

```php
apply_filters( "expiration_of_transient_{$transient}", int $expiration, mixed $value, string $transient )
```

**Since:** 4.4.0

---

## Site Transient Hooks

Same pattern as transients, with `site_transient` prefix:

- `delete_site_transient_{$transient}`
- `deleted_site_transient`
- `set_site_transient_{$transient}`
- `set_site_transient`
- `pre_site_transient_{$transient}`
- `site_transient_{$transient}`
- `pre_set_site_transient_{$transient}`
- `expiration_of_site_transient_{$transient}`

---

## Feed Cache Hook

#### wp_feed_cache_transient_lifetime

Filters feed cache duration.

```php
apply_filters( 'wp_feed_cache_transient_lifetime', int $lifetime, string $name )
```

**Since:** 2.8.0  
**Default:** 43200 (12 hours)

---

## Site Health Hooks

### Actions

#### wp_site_health_scheduled_check

Weekly cron hook for background health checks.

```php
do_action( 'wp_site_health_scheduled_check' )
```

**Since:** 5.4.0

#### site_health_tab_content

Outputs content for Site Health tabs.

```php
do_action( 'site_health_tab_content', string $tab )
```

**Since:** 5.8.0

---

### Filters

#### site_status_tests

Modifies the list of Site Health tests.

```php
apply_filters( 'site_status_tests', array $tests )
```

**Since:** 5.2.0

```php
add_filter( 'site_status_tests', function( $tests ) {
    // Add custom test
    $tests['direct']['my_test'] = array(
        'label' => 'My Test',
        'test'  => 'my_test_callback',
    );
    
    // Remove a test
    unset( $tests['direct']['debug_enabled'] );
    
    return $tests;
});
```

#### site_status_test_result

Filters individual test results.

```php
apply_filters( 'site_status_test_result', array $result )
```

**Since:** 5.3.0

#### site_status_test_php_modules

Filters required/recommended PHP modules list.

```php
apply_filters( 'site_status_test_php_modules', array $modules )
```

**Since:** 5.2.0

#### site_health_test_rest_capability_{$check}

Filters capability for REST endpoint access.

```php
apply_filters( "site_health_test_rest_capability_{$check}", string $cap, string $check )
```

**Since:** 5.6.0  
**Default:** `view_site_health_checks`

---

### Autoloaded Options Filters

#### site_status_autoloaded_options_size_limit

Warning threshold for autoloaded data.

```php
apply_filters( 'site_status_autoloaded_options_size_limit', int $limit )
```

**Since:** 6.6.0  
**Default:** 800000 (bytes)

#### site_status_autoloaded_options_limit_description

Custom warning description.

```php
apply_filters( 'site_status_autoloaded_options_limit_description', string $description )
```

**Since:** 6.6.0

#### site_status_autoloaded_options_action_to_perform

Custom action/link for fixing issue.

```php
apply_filters( 'site_status_autoloaded_options_action_to_perform', string $actions )
```

**Since:** 6.6.0

---

### Page Cache Filters

#### site_status_page_cache_supported_cache_headers

Headers that indicate page caching.

```php
apply_filters( 'site_status_page_cache_supported_cache_headers', array $cache_headers )
```

**Since:** 6.1.0

---

## Auto-Update Filters

#### automatic_updater_disabled

Disables automatic updater entirely.

```php
apply_filters( 'automatic_updater_disabled', bool $disabled )
```

#### allow_dev_auto_core_updates

Allows development version updates.

```php
apply_filters( 'allow_dev_auto_core_updates', bool|string $upgrade_dev )
```

#### allow_minor_auto_core_updates

Allows security/maintenance updates.

```php
apply_filters( 'allow_minor_auto_core_updates', bool $upgrade_minor )
```

#### automatic_updates_is_vcs_checkout

Allows updates even in VCS directories.

```php
apply_filters( 'automatic_updates_is_vcs_checkout', bool $is_checkout, string $context )
```

---

## Usage Examples

### Cache External API Calls

```php
add_filter( 'pre_transient_my_api_data', function( $pre, $transient ) {
    // Check alternative cache first
    $cached = wp_cache_get( 'my_api_data', 'api_cache' );
    if ( $cached ) {
        return $cached;
    }
    return $pre;
}, 10, 2 );
```

### Custom Site Health Test

```php
add_filter( 'site_status_tests', function( $tests ) {
    $tests['direct']['custom_security'] = array(
        'label' => __( 'Security Headers' ),
        'test'  => function() {
            $headers = wp_remote_retrieve_headers( 
                wp_remote_get( home_url() ) 
            );
            
            $has_security = isset( $headers['x-content-type-options'] );
            
            return array(
                'label'       => $has_security 
                    ? __( 'Security headers are configured' )
                    : __( 'Security headers missing' ),
                'status'      => $has_security ? 'good' : 'recommended',
                'badge'       => array(
                    'label' => __( 'Security' ),
                    'color' => 'blue',
                ),
                'description' => '<p>...</p>',
                'actions'     => '',
                'test'        => 'custom_security',
            );
        },
    );
    return $tests;
});
```

### Modify Transient Expiration

```php
// Extend cache for slow external API
add_filter( 
    'expiration_of_transient_external_api_data', 
    function( $expiration ) {
        return DAY_IN_SECONDS;  // Cache for 24 hours
    }
);
```
