# WP_Site_Health

Main class for Site Health diagnostic tests and status display.

**Since:** 5.2.0  
**Source:** `wp-admin/includes/class-wp-site-health.php`

## Properties

```php
private static $instance = null;

// Database info
private $is_acceptable_mysql_version;
private $is_recommended_mysql_version;
public $is_mariadb = false;
private $mysql_server_version = '';
private $mysql_required_version = '5.5';
private $mysql_recommended_version = '8.0';
private $mariadb_recommended_version = '10.6';

// Memory
public $php_memory_limit;

// Cron
public $schedules;
public $crons;
public $last_missed_cron = null;
public $last_late_cron = null;
private $timeout_missed_cron = null;  // -5 min (or -1 hour if DISABLE_WP_CRON)
private $timeout_late_cron = null;    // 0 (or -15 min if DISABLE_WP_CRON)
```

---

## Static Methods

### get_instance()

Singleton accessor.

```php
public static function get_instance(): WP_Site_Health
```

### get_tests()

Returns all registered tests.

```php
public static function get_tests(): array
```

**Returns:**
```php
array(
    'direct' => array(
        'test_identifier' => array(
            'label'     => 'Human Label',
            'test'      => 'test_name',        // Method suffix or callable
            'skip_cron' => false,              // Skip in scheduled checks
        ),
    ),
    'async' => array(
        'test_identifier' => array(
            'label'             => 'Human Label',
            'test'              => 'REST endpoint URL',
            'has_rest'          => true,
            'async_direct_test' => callable,   // For cron fallback
            'headers'           => array(),    // Extra headers
            'skip_cron'         => false,
        ),
    ),
)
```

**Filter:** `site_status_tests` — Add/remove tests

---

## Direct Tests

Run synchronously on page load. Each returns standardized result array.

| Method | Category | Checks |
|--------|----------|--------|
| `get_test_wordpress_version()` | Performance | Core version, updates available |
| `get_test_plugin_version()` | Security | Plugin updates, inactive plugins |
| `get_test_theme_version()` | Security | Theme updates, default theme |
| `get_test_php_version()` | Performance | PHP version support |
| `get_test_php_extensions()` | Performance | Required/recommended modules |
| `get_test_php_default_timezone()` | Performance | Timezone is UTC |
| `get_test_php_sessions()` | Performance | No active sessions |
| `get_test_sql_server()` | Performance | MySQL/MariaDB version |
| `get_test_ssl_support()` | Security | SSL available |
| `get_test_scheduled_events()` | Performance | Cron health |
| `get_test_http_requests()` | Performance | HTTP not blocked |
| `get_test_rest_availability()` | Performance | REST API accessible |
| `get_test_is_in_debug_mode()` | Security | WP_DEBUG disabled |
| `get_test_file_uploads()` | Performance | Uploads directory writable |
| `get_test_plugin_theme_auto_updates()` | Security | Auto-updates configured |
| `get_test_update_temp_backup_writable()` | Performance | Backup dir writable |
| `get_test_available_updates_disk_space()` | Performance | Sufficient disk space |
| `get_test_autoloaded_options()` | Performance | Autoloaded data size |
| `get_test_persistent_object_cache()` | Performance | Object cache (production only) |
| `get_test_search_engine_visibility()` | Privacy | Indexing enabled/disabled |

---

## Async Tests

Run via REST API to avoid blocking page load.

| Method | Endpoint | Checks |
|--------|----------|--------|
| `get_test_dotorg_communication()` | `dotorg-communication` | Can reach api.wordpress.org |
| `get_test_background_updates()` | `background-updates` | Auto-updates work |
| `get_test_loopback_requests()` | `loopback-requests` | Loopback succeeds |
| `get_test_https_status()` | `https-status` | HTTPS properly configured |
| `get_test_authorization_header()` | `authorization-header` | Auth header passes |
| `get_test_page_cache()` | `page-cache` | Page caching active (production) |

---

## Cron Methods

### has_missed_cron()

Check if any scheduled task is overdue.

```php
public function has_missed_cron(): bool|WP_Error
```

### has_late_cron()

Check if any scheduled task is running late.

```php
public function has_late_cron(): bool|WP_Error
```

### wp_cron_scheduled_check()

Runs weekly via `wp_site_health_scheduled_check` hook. Executes all tests and stores results in transient.

```php
public function wp_cron_scheduled_check(): void
```

**Stores:** `health-check-site-status-result` transient with JSON counts

---

## Helper Methods

### can_perform_loopback()

Tests if site can make HTTP requests to itself.

```php
public function can_perform_loopback(): object
```

**Returns:** `(object) ['status' => 'good|critical|recommended', 'message' => '...']`

### detect_plugin_theme_auto_update_issues()

Checks for auto-update configuration problems.

```php
public function detect_plugin_theme_auto_update_issues(): object
```

### get_autoloaded_options_size()

Calculates total bytes of autoloaded options.

```php
public function get_autoloaded_options_size(): int
```

**Filter:** `site_status_autoloaded_options_size_limit` — Warning threshold (default 800000)

### is_development_environment()

```php
public function is_development_environment(): bool
```

Returns `true` if `wp_get_environment_type()` is `development` or `local`.

### get_page_cache_headers()

Returns headers that indicate page caching.

```php
public function get_page_cache_headers(): array
```

**Filter:** `site_status_page_cache_supported_cache_headers`

---

## Usage Example

### Running a Specific Test

```php
$site_health = WP_Site_Health::get_instance();
$result = $site_health->get_test_php_version();

if ( 'critical' === $result['status'] ) {
    // Handle critical issue
}
```

### Adding Custom Test

```php
add_filter( 'site_status_tests', function( $tests ) {
    $tests['direct']['my_custom_test'] = array(
        'label' => __( 'My Custom Check' ),
        'test'  => 'my_custom_test_callback',
    );
    return $tests;
});

function my_custom_test_callback() {
    return array(
        'label'       => __( 'Custom check passed' ),
        'status'      => 'good',
        'badge'       => array(
            'label' => __( 'Security' ),
            'color' => 'blue',
        ),
        'description' => '<p>Everything is fine.</p>',
        'actions'     => '',
        'test'        => 'my_custom_test',
    );
}
```

### Checking Site Health Score

```php
$status = get_transient( 'health-check-site-status-result' );
if ( $status ) {
    $scores = json_decode( $status );
    // $scores->good, $scores->recommended, $scores->critical
}
```
