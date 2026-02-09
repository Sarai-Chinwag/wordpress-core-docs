# Sitemaps API

The Sitemaps API provides XML sitemaps for WordPress sites, helping search engines discover and index content.

**Since:** WordPress 5.5.0

## Overview

WordPress automatically generates XML sitemaps including:

- Posts, pages, and custom post types
- Categories, tags, and custom taxonomies
- Author archives
- Sitemap index linking all individual sitemaps

## URLs

| URL | Description |
|-----|-------------|
| `/wp-sitemap.xml` | Main sitemap index |
| `/wp-sitemap-posts-post-1.xml` | Posts sitemap (page 1) |
| `/wp-sitemap-posts-page-1.xml` | Pages sitemap |
| `/wp-sitemap-taxonomies-category-1.xml` | Categories sitemap |
| `/wp-sitemap-users-1.xml` | Authors sitemap |

## Core Functions

### wp_sitemaps_get_server()

Returns the main sitemaps server instance.

```php
wp_sitemaps_get_server(): WP_Sitemaps
```

### wp_get_sitemap_providers()

Returns all registered sitemap providers.

```php
wp_get_sitemap_providers(): WP_Sitemaps_Provider[]
```

### wp_register_sitemap_provider()

Registers a custom sitemap provider.

```php
wp_register_sitemap_provider( string $name, WP_Sitemaps_Provider $provider ): bool
```

## Customization

### Disabling Sitemaps

```php
add_filter( 'wp_sitemaps_enabled', '__return_false' );
```

### Excluding Post Types

```php
add_filter( 'wp_sitemaps_post_types', function( $post_types ) {
    unset( $post_types['attachment'] );
    return $post_types;
} );
```

### Excluding Taxonomies

```php
add_filter( 'wp_sitemaps_taxonomies', function( $taxonomies ) {
    unset( $taxonomies['post_tag'] );
    return $taxonomies;
} );
```

### Excluding Specific Posts

```php
add_filter( 'wp_sitemaps_posts_query_args', function( $args, $post_type ) {
    if ( 'post' === $post_type ) {
        $args['post__not_in'] = array( 123, 456 ); // Exclude these IDs
    }
    return $args;
}, 10, 2 );
```

### Adding Custom Data to Entries

```php
add_filter( 'wp_sitemaps_posts_entry', function( $entry, $post ) {
    // Add lastmod based on post modified date
    $entry['lastmod'] = get_the_modified_date( 'c', $post );
    return $entry;
}, 10, 2 );
```

### Changing Items Per Page

```php
add_filter( 'wp_sitemaps_max_urls', function( $max_urls ) {
    return 1000; // Default is 2000
} );
```

## Custom Providers

Create a custom sitemap provider for custom content:

```php
class My_Custom_Sitemap_Provider extends WP_Sitemaps_Provider {
    public function __construct() {
        $this->name        = 'custom';
        $this->object_type = 'custom';
    }
    
    public function get_url_list( $page_num, $object_subtype = '' ) {
        $urls = array();
        
        // Your logic to get URLs
        $items = $this->get_custom_items( $page_num );
        
        foreach ( $items as $item ) {
            $urls[] = array(
                'loc'     => $item->url,
                'lastmod' => $item->modified,
            );
        }
        
        return $urls;
    }
    
    public function get_max_num_pages( $object_subtype = '' ) {
        $total_items = $this->count_custom_items();
        return (int) ceil( $total_items / wp_sitemaps_get_max_urls( $this->object_type ) );
    }
}

// Register the provider
add_action( 'init', function() {
    wp_register_sitemap_provider( 'custom', new My_Custom_Sitemap_Provider() );
} );
```

## Filters Reference

| Filter | Description |
|--------|-------------|
| `wp_sitemaps_enabled` | Enable/disable sitemaps |
| `wp_sitemaps_max_urls` | Max URLs per sitemap |
| `wp_sitemaps_post_types` | Post types to include |
| `wp_sitemaps_taxonomies` | Taxonomies to include |
| `wp_sitemaps_posts_query_args` | Modify posts query |
| `wp_sitemaps_posts_entry` | Modify post entries |
| `wp_sitemaps_taxonomies_entry` | Modify taxonomy entries |
| `wp_sitemaps_users_entry` | Modify user entries |
| `wp_sitemaps_index_entry` | Modify index entries |

## Classes

| Class | Description |
|-------|-------------|
| `WP_Sitemaps` | Main controller class |
| `WP_Sitemaps_Index` | Generates sitemap index |
| `WP_Sitemaps_Provider` | Base provider class |
| `WP_Sitemaps_Registry` | Provider registry |
| `WP_Sitemaps_Renderer` | XML output renderer |
| `WP_Sitemaps_Stylesheet` | XSL stylesheet |

## Built-in Providers

| Provider | Class | Object Types |
|----------|-------|--------------|
| Posts | `WP_Sitemaps_Posts` | All public post types |
| Taxonomies | `WP_Sitemaps_Taxonomies` | All public taxonomies |
| Users | `WP_Sitemaps_Users` | Authors with published posts |
