# Site Health & Transients API

WordPress Site Health provides diagnostic tests and debugging info. Transients offer temporary cached data storage with automatic expiration.

**Since:** Site Health 5.2.0, Transients 2.8.0  
**Source:** 
- `wp-admin/includes/class-wp-site-health.php`
- `wp-admin/includes/class-wp-site-health-auto-updates.php`
- `wp-includes/rest-api/endpoints/class-wp-rest-site-health-controller.php`
- `wp-includes/option.php` (transient functions)
- `wp-includes/class-wp-feed-cache-transient.php`

## Components

| Component | Description |
|-----------|-------------|
| [transients.md](./transients.md) | Temporary data storage with expiration |
| [class-wp-site-health.md](./class-wp-site-health.md) | Main Site Health class (admin) |
| [class-wp-site-health-auto-updates.md](./class-wp-site-health-auto-updates.md) | Auto-updates testing |
| [class-wp-rest-site-health-controller.md](./class-wp-rest-site-health-controller.md) | REST API endpoints |
| [hooks.md](./hooks.md) | Actions and filters |

## Transients vs Options

| Transients | Options |
|------------|---------|
| Temporary, expire | Permanent |
| May use object cache | Always database |
| For cached data | For settings |
| Auto-cleanup on expiration | Manual delete |

## Site Health Test Flow

```
WP_Site_Health::get_tests()
    ├── direct tests (run on page load)
    │   └── get_test_{name}() → result array
    └── async tests (run via REST/AJAX)
        └── WP_REST_Site_Health_Controller
            └── test_{endpoint}() → result array
```

## Test Result Structure

```php
array(
    'label'       => 'Human-readable label',
    'status'      => 'good|recommended|critical',
    'badge'       => array(
        'label' => 'Category',        // Security, Performance, etc.
        'color' => 'blue|orange|red|green|purple|gray',
    ),
    'description' => 'Detailed explanation',
    'actions'     => 'HTML with action links',
    'test'        => 'test_identifier',
)
```

## Transient Storage

```
Database (no object cache):
    _transient_{name}           → value
    _transient_timeout_{name}   → expiration timestamp

Site Transients (multisite):
    _site_transient_{name}      → value (sitemeta table)

Object Cache (Redis/Memcached):
    transient:{name}            → value with TTL
    site-transient:{name}       → value with TTL
```
