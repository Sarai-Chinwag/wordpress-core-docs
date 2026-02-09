# Sitemaps API Functions

Core functions for sitemap management and registration.

**Source:** `wp-includes/sitemaps.php`

---

## wp_sitemaps_get_server()

Retrieves the current Sitemaps server instance.

```php
wp_sitemaps_get_server(): WP_Sitemaps
```

### Returns

`WP_Sitemaps` instance.

### Notes

- Bootstraps the sitemaps system if not already initialized
- Fires `wp_sitemaps_init` action on first call
- Uses global `$wp_sitemaps`

### Example

```php
$sitemaps = wp_sitemaps_get_server();
$providers = $sitemaps->registry->get_providers();
```

---

## wp_get_sitemap_providers()

Gets an array of sitemap providers.

```php
wp_get_sitemap_providers(): WP_Sitemaps_Provider[]
```

### Returns

Array of `WP_Sitemaps_Provider` instances keyed by provider name.

### Example

```php
$providers = wp_get_sitemap_providers();

foreach ( $providers as $name => $provider ) {
    echo "Provider: {$name}\n";
}
// Output: Provider: posts, Provider: taxonomies, Provider: users
```

---

## wp_register_sitemap_provider()

Registers a new sitemap provider.

```php
wp_register_sitemap_provider( string $name, WP_Sitemaps_Provider $provider ): bool
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Unique name for the sitemap provider |
| `$provider` | WP_Sitemaps_Provider | Provider instance |

### Returns

`true` on success, `false` if provider already exists or filtered out.

### Hooks

- `wp_sitemaps_add_provider` — Filters provider before registration

### Example

```php
add_action( 'wp_sitemaps_init', function( $sitemaps ) {
    wp_register_sitemap_provider( 'products', new My_Products_Sitemap_Provider() );
} );
```

---

## wp_sitemaps_get_max_urls()

Gets the maximum number of URLs for a sitemap.

```php
wp_sitemaps_get_max_urls( string $object_type ): int
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_type` | string | Object type (e.g., `post`, `term`, `user`) |

### Returns

Maximum number of URLs. Default: 2000.

### Hooks

- `wp_sitemaps_max_urls` — Filters the maximum URL count

### Example

```php
// Increase limit for posts
add_filter( 'wp_sitemaps_max_urls', function( $max_urls, $object_type ) {
    if ( 'post' === $object_type ) {
        return 5000;
    }
    return $max_urls;
}, 10, 2 );
```

---

## get_sitemap_url()

Retrieves the full URL for a sitemap.

```php
get_sitemap_url( string $name, string $subtype_name = '', int $page = 1 ): string|false
```

**Since:** 5.5.1

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Sitemap name (`posts`, `taxonomies`, `users`, or `index`) |
| `$subtype_name` | string | Subtype name (e.g., `post`, `page`, `category`). Default empty. |
| `$page` | int | Page number. Default 1. |

### Returns

Sitemap URL string, or `false` if sitemap doesn't exist.

### Example

```php
// Get index URL
$index_url = get_sitemap_url( 'index' );
// https://example.com/wp-sitemap.xml

// Get posts sitemap page 1
$posts_url = get_sitemap_url( 'posts', 'post', 1 );
// https://example.com/wp-sitemap-posts-post-1.xml

// Get categories sitemap page 2
$cat_url = get_sitemap_url( 'taxonomies', 'category', 2 );
// https://example.com/wp-sitemap-taxonomies-category-2.xml

// Invalid provider returns false
$invalid = get_sitemap_url( 'nonexistent' );
// false
```
