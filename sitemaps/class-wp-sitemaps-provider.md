# WP_Sitemaps_Provider

Abstract base class for sitemap providers.

**Source:** `wp-includes/sitemaps/class-wp-sitemaps-provider.php`  
**Since:** 5.5.0

## Overview

Base class that all sitemap providers must extend. Provides shared functionality for URL generation, pagination, and sitemap entry building.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$name` | string | protected | Provider name (used in URLs) |
| `$object_type` | string | protected | Object type (`post`, `term`, `user`) |

---

## Abstract Methods

### get_url_list()

Gets a URL list for a sitemap page.

```php
abstract public function get_url_list( int $page_num, string $object_subtype = '' ): array
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$page_num` | int | Page number of results |
| `$object_subtype` | string | Object subtype (e.g., post type or taxonomy). Default empty. |

**Returns:** Array of URL information arrays, each containing at minimum:

```php
array(
    'loc'     => 'https://example.com/page/',     // Required
    'lastmod' => '2024-01-15T10:30:00+00:00',     // Optional (W3C datetime)
)
```

---

### get_max_num_pages()

Gets the maximum number of pages for the object type.

```php
abstract public function get_max_num_pages( string $object_subtype = '' ): int
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$object_subtype` | string | Object subtype. Default empty. |

**Returns:** Total number of sitemap pages.

---

## Methods

### get_sitemap_type_data()

Gets data about each sitemap type.

```php
public function get_sitemap_type_data(): array
```

**Returns:** Array of sitemap types with subtype name and page count:

```php
array(
    array( 'name' => 'post', 'pages' => 3 ),
    array( 'name' => 'page', 'pages' => 1 ),
)
```

**Note:** If no object subtypes, returns single entry with empty name.

---

### get_sitemap_entries()

Lists sitemap pages exposed by this provider.

```php
public function get_sitemap_entries(): array
```

**Returns:** Array of sitemap entries for the index:

```php
array(
    array( 'loc' => 'https://example.com/wp-sitemap-posts-post-1.xml' ),
    array( 'loc' => 'https://example.com/wp-sitemap-posts-post-2.xml' ),
    array( 'loc' => 'https://example.com/wp-sitemap-posts-page-1.xml' ),
)
```

**Hooks:**

```php
apply_filters( 'wp_sitemaps_index_entry', array $sitemap_entry, string $object_type, string $object_subtype, int $page )
```

---

### get_sitemap_url()

Gets the URL of a sitemap entry.

```php
public function get_sitemap_url( string $name, int $page ): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Object subtype name |
| `$page` | int | Page number |

**Returns:** Full sitemap URL.

**Examples:**

```php
// With pretty permalinks
$provider->get_sitemap_url( 'post', 1 );
// https://example.com/wp-sitemap-posts-post-1.xml

$provider->get_sitemap_url( '', 1 );
// https://example.com/wp-sitemap-users-1.xml

// Without pretty permalinks
$provider->get_sitemap_url( 'post', 2 );
// https://example.com/?sitemap=posts&sitemap-subtype=post&paged=2
```

---

### get_object_subtypes()

Returns supported object subtypes.

```php
public function get_object_subtypes(): array
```

**Returns:** Array of object subtypes keyed by name. Default: empty array.

**Override in subclasses** to return subtypes (e.g., post types for posts provider).

---

## Creating a Custom Provider

```php
class My_Products_Sitemap_Provider extends WP_Sitemaps_Provider {

    public function __construct() {
        $this->name        = 'products';
        $this->object_type = 'product';
    }

    public function get_url_list( $page_num, $object_subtype = '' ) {
        $products = $this->query_products( $page_num );
        $url_list = array();

        foreach ( $products as $product ) {
            $url_list[] = array(
                'loc'     => get_permalink( $product ),
                'lastmod' => get_post_modified_time( DATE_W3C, true, $product ),
            );
        }

        return $url_list;
    }

    public function get_max_num_pages( $object_subtype = '' ) {
        $total = $this->count_products();
        return (int) ceil( $total / wp_sitemaps_get_max_urls( $this->object_type ) );
    }

    private function query_products( $page ) {
        // Query logic here
    }

    private function count_products() {
        // Count logic here
    }
}

// Register the provider
add_action( 'wp_sitemaps_init', function( $sitemaps ) {
    wp_register_sitemap_provider( 'products', new My_Products_Sitemap_Provider() );
} );
```

---

## Built-in Providers

### WP_Sitemaps_Posts

Provider for public post types.

**Source:** `wp-includes/sitemaps/providers/class-wp-sitemaps-posts.php`

| Property | Value |
|----------|-------|
| `$name` | `posts` |
| `$object_type` | `post` |

**Methods:**

| Method | Description |
|--------|-------------|
| `get_object_subtypes()` | Returns public, viewable post types (excludes attachments) |
| `get_url_list()` | Queries posts with `WP_Query` |
| `get_max_num_pages()` | Calculates pages per post type |
| `get_posts_query_args()` | Returns default query arguments |

**Hooks:**
- `wp_sitemaps_post_types` — Filter post types included
- `wp_sitemaps_posts_pre_url_list` — Short-circuit URL list generation
- `wp_sitemaps_posts_show_on_front_entry` — Filter homepage entry
- `wp_sitemaps_posts_entry` — Filter individual post entries
- `wp_sitemaps_posts_pre_max_num_pages` — Short-circuit page count
- `wp_sitemaps_posts_query_args` — Filter WP_Query arguments

---

### WP_Sitemaps_Taxonomies

Provider for public taxonomies.

**Source:** `wp-includes/sitemaps/providers/class-wp-sitemaps-taxonomies.php`

| Property | Value |
|----------|-------|
| `$name` | `taxonomies` |
| `$object_type` | `term` |

**Methods:**

| Method | Description |
|--------|-------------|
| `get_object_subtypes()` | Returns public, viewable taxonomies |
| `get_url_list()` | Queries terms with `WP_Term_Query` |
| `get_max_num_pages()` | Calculates pages per taxonomy |
| `get_taxonomies_query_args()` | Returns default query arguments |

**Hooks:**
- `wp_sitemaps_taxonomies` — Filter taxonomies included
- `wp_sitemaps_taxonomies_pre_url_list` — Short-circuit URL list generation
- `wp_sitemaps_taxonomies_entry` — Filter individual term entries
- `wp_sitemaps_taxonomies_pre_max_num_pages` — Short-circuit page count
- `wp_sitemaps_taxonomies_query_args` — Filter WP_Term_Query arguments

---

### WP_Sitemaps_Users

Provider for authors with published posts.

**Source:** `wp-includes/sitemaps/providers/class-wp-sitemaps-users.php`

| Property | Value |
|----------|-------|
| `$name` | `users` |
| `$object_type` | `user` |

**Methods:**

| Method | Description |
|--------|-------------|
| `get_url_list()` | Queries users with `WP_User_Query` |
| `get_max_num_pages()` | Calculates pages |
| `get_users_query_args()` | Returns default query arguments |

**Notes:**
- Only includes users with published posts in public post types
- Excludes attachments and pages from authorship check

**Hooks:**
- `wp_sitemaps_users_pre_url_list` — Short-circuit URL list generation
- `wp_sitemaps_users_entry` — Filter individual user entries
- `wp_sitemaps_users_pre_max_num_pages` — Short-circuit page count
- `wp_sitemaps_users_query_args` — Filter WP_User_Query arguments
