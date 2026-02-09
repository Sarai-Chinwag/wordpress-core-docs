# WP_Sitemaps_Registry

Registry for managing sitemap providers.

**Source:** `wp-includes/sitemaps/class-wp-sitemaps-registry.php`  
**Since:** 5.5.0

## Overview

Manages registration and retrieval of sitemap providers. Accessed via `WP_Sitemaps::$registry`.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$providers` | WP_Sitemaps_Provider[] | private | Registered providers keyed by name |

---

## Methods

### add_provider()

Adds a new sitemap provider.

```php
public function add_provider( string $name, WP_Sitemaps_Provider $provider ): bool
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Provider name |
| `$provider` | WP_Sitemaps_Provider | Provider instance |

**Returns:** `true` on success, `false` if name exists or provider filtered out.

**Hooks:**

```php
apply_filters( 'wp_sitemaps_add_provider', WP_Sitemaps_Provider $provider, string $name )
```

Return a non-`WP_Sitemaps_Provider` value to prevent registration.

**Example:**

```php
// Register custom provider
$registry->add_provider( 'products', new My_Products_Provider() );

// Prevent a provider from being registered
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    if ( 'users' === $name ) {
        return false; // Block users sitemap
    }
    return $provider;
}, 10, 2 );
```

---

### get_provider()

Returns a single registered provider.

```php
public function get_provider( string $name ): ?WP_Sitemaps_Provider
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Provider name |

**Returns:** `WP_Sitemaps_Provider` or `null` if not found.

**Example:**

```php
$posts_provider = $registry->get_provider( 'posts' );
if ( $posts_provider ) {
    $url_list = $posts_provider->get_url_list( 1, 'post' );
}
```

---

### get_providers()

Returns all registered providers.

```php
public function get_providers(): WP_Sitemaps_Provider[]
```

**Returns:** Array of `WP_Sitemaps_Provider` instances keyed by name.

**Example:**

```php
$providers = $registry->get_providers();

foreach ( $providers as $name => $provider ) {
    $entries = $provider->get_sitemap_entries();
    echo "{$name}: " . count( $entries ) . " sitemaps\n";
}
```

---

## Usage Examples

### Access the Registry

```php
$sitemaps = wp_sitemaps_get_server();
$registry = $sitemaps->registry;

// List all providers
$providers = $registry->get_providers();
// array( 'posts' => WP_Sitemaps_Posts, 'taxonomies' => WP_Sitemaps_Taxonomies, 'users' => WP_Sitemaps_Users )
```

### Remove a Built-in Provider

```php
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    // Disable users sitemap
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}, 10, 2 );
```

### Replace a Provider

```php
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    if ( 'posts' === $name ) {
        return new My_Custom_Posts_Provider();
    }
    return $provider;
}, 10, 2 );
```
