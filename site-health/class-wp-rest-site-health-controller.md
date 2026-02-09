# WP_REST_Site_Health_Controller

REST API endpoints for asynchronous Site Health tests.

**Since:** 5.6.0  
**Source:** `wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php`

## Properties

```php
private $site_health;  // WP_Site_Health instance
```

**Namespace:** `wp-site-health/v1`  
**Base:** `tests`

---

## Constructor

```php
public function __construct( WP_Site_Health $site_health )
```

Receives `WP_Site_Health` instance for running tests.

---

## Routes

### Background Updates

```
GET /wp-site-health/v1/tests/background-updates
```

Tests if automatic background updates work.

### Loopback Requests

```
GET /wp-site-health/v1/tests/loopback-requests
```

Tests if site can make HTTP requests to itself.

### HTTPS Status

```
GET /wp-site-health/v1/tests/https-status
```

**Since:** 5.7.0

Checks HTTPS configuration.

### WordPress.org Communication

```
GET /wp-site-health/v1/tests/dotorg-communication
```

Tests connectivity to api.wordpress.org.

### Authorization Header

```
GET /wp-site-health/v1/tests/authorization-header
```

Verifies Authorization header passes through.

### Page Cache

```
GET /wp-site-health/v1/tests/page-cache
```

**Since:** 6.1.0

Checks if page caching is active.

### Directory Sizes

```
GET /wp-site-health/v1/directory-sizes
```

Returns sizes of WordPress directories.

**Note:** Not available on multisite.

---

## Permission Callback

All endpoints use `validate_request_permission()`:

```php
protected function validate_request_permission( string $check ): bool
```

**Default capability:** `view_site_health_checks`

**Filter:** `site_health_test_rest_capability_{$check}`

```php
add_filter( 
    'site_health_test_rest_capability_background_updates', 
    function( $cap, $check ) {
        return 'manage_options';  // Require higher capability
    }, 
    10, 
    2 
);
```

---

## Test Methods

### test_background_updates()

```php
public function test_background_updates(): array
```

Proxies to `WP_Site_Health::get_test_background_updates()`.

### test_loopback_requests()

```php
public function test_loopback_requests(): array
```

Proxies to `WP_Site_Health::get_test_loopback_requests()`.

### test_https_status()

```php
public function test_https_status(): array
```

Proxies to `WP_Site_Health::get_test_https_status()`.

### test_dotorg_communication()

```php
public function test_dotorg_communication(): array
```

Proxies to `WP_Site_Health::get_test_dotorg_communication()`.

### test_authorization_header()

```php
public function test_authorization_header(): array
```

Proxies to `WP_Site_Health::get_test_authorization_header()`.

### test_page_cache()

```php
public function test_page_cache(): array
```

Proxies to `WP_Site_Health::get_test_page_cache()`.

---

## Directory Sizes Response

```php
public function get_directory_sizes(): array|WP_Error
```

**Returns:**

```php
array(
    'wordpress_size' => array(
        'size'  => '45.2 MB',
        'debug' => '45.2 MB (47,396,352 bytes)',
        'raw'   => 47396352,
    ),
    'uploads_size' => array( ... ),
    'themes_size' => array( ... ),
    'plugins_size' => array( ... ),
    'database_size' => array( ... ),
    'total_size' => array( ... ),
    'raw' => 0,  // Aggregated raw size
)
```

**Error:** Returns `WP_Error` with status 500 if sizes unavailable.

---

## Response Schema

```php
public function get_item_schema(): array
```

```php
array(
    'title'      => 'wp-site-health-test',
    'type'       => 'object',
    'properties' => array(
        'test'        => array( 'type' => 'string' ),
        'label'       => array( 'type' => 'string' ),
        'status'      => array( 
            'type' => 'string',
            'enum' => array( 'good', 'recommended', 'critical' ),
        ),
        'badge'       => array(
            'type'       => 'object',
            'properties' => array(
                'label' => array( 'type' => 'string' ),
                'color' => array( 
                    'type' => 'string',
                    'enum' => array( 'blue', 'orange', 'red', 'green', 'purple', 'gray' ),
                ),
            ),
        ),
        'description' => array( 'type' => 'string' ),
        'actions'     => array( 'type' => 'string' ),
    ),
)
```

---

## Admin Textdomain Loading

```php
protected function load_admin_textdomain(): void
```

Loads admin translations for REST API context (normally only loaded in admin).

---

## Usage Examples

### JavaScript Async Test

```javascript
// From Site Health admin page
wp.apiRequest({
    path: 'wp-site-health/v1/tests/loopback-requests',
    method: 'GET'
}).done(function(response) {
    console.log(response.status);  // 'good', 'recommended', or 'critical'
    console.log(response.label);
});
```

### PHP API Call

```php
$request = new WP_REST_Request( 'GET', '/wp-site-health/v1/tests/background-updates' );
$response = rest_do_request( $request );

if ( ! $response->is_error() ) {
    $data = $response->get_data();
    // $data['status'], $data['label'], etc.
}
```

### Check Directory Sizes

```php
$request = new WP_REST_Request( 'GET', '/wp-site-health/v1/directory-sizes' );
$response = rest_do_request( $request );
$sizes = $response->get_data();

// Total site size
$total_bytes = $sizes['total_size']['raw'];
```
