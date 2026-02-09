# Plugin Dependencies Hooks

Filters for the Plugin Dependencies API.

---

## Filters

### wp_plugin_dependencies_slug

Filters a dependency slug before validation against WordPress.org slug format.

```php
apply_filters( 'wp_plugin_dependencies_slug', string $slug )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | The dependency slug being processed |

**Returns:** Modified slug string.

**Since:** 6.5.0

**Context:** Applied during `read_dependencies_from_plugin_headers()` before slug format validation.

---

### Use Cases

#### Switch Between Free and Premium Slugs

```php
add_filter( 'wp_plugin_dependencies_slug', function( $slug ) {
    // Map premium slug to free version for dependency checks
    $premium_to_free = array(
        'woocommerce-pro' => 'woocommerce',
        'acf-pro'         => 'advanced-custom-fields',
    );
    
    return $premium_to_free[ $slug ] ?? $slug;
} );
```

#### Normalize Slug Variations

```php
add_filter( 'wp_plugin_dependencies_slug', function( $slug ) {
    // Handle common slug variations
    $normalized = array(
        'woo'  => 'woocommerce',
        'wp-seo' => 'wordpress-seo',
    );
    
    return $normalized[ $slug ] ?? $slug;
} );
```

#### Custom Plugin Repository Support

```php
add_filter( 'wp_plugin_dependencies_slug', function( $slug ) {
    // Strip custom prefix for internal plugins
    if ( str_starts_with( $slug, 'internal-' ) ) {
        return substr( $slug, 9 );
    }
    return $slug;
} );
```

---

## Transients

The Plugin Dependencies API uses these transients for caching:

| Transient Key | Expiry | Description |
|---------------|--------|-------------|
| `wp_plugin_dependencies_plugin_data` | None (persistent) | WordPress.org API data for all dependencies |
| `wp_plugin_dependencies_plugin_timeout_{$slug}` | 12 hours | Per-slug API refresh timeout |

**Clearing Cache:**

```php
// Force refresh of all dependency data
delete_site_transient( 'wp_plugin_dependencies_plugin_data' );

// Force refresh for specific plugin
delete_site_transient( 'wp_plugin_dependencies_plugin_timeout_woocommerce' );
```
