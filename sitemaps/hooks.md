# Sitemaps API Hooks

Actions and filters for the Sitemaps API.

---

## Actions

### wp_sitemaps_init

Fires when initializing the Sitemaps object. Register additional providers here.

```php
do_action( 'wp_sitemaps_init', WP_Sitemaps $wp_sitemaps )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$wp_sitemaps` | WP_Sitemaps | Sitemaps instance |

**Example:**

```php
add_action( 'wp_sitemaps_init', function( $sitemaps ) {
    wp_register_sitemap_provider( 'products', new My_Products_Provider() );
} );
```

---

## Filters

### wp_sitemaps_enabled

Filters whether XML sitemaps are enabled.

```php
apply_filters( 'wp_sitemaps_enabled', bool $is_enabled )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$is_enabled` | bool | Whether sitemaps are enabled. Default: `blog_public` option value. |

**Returns:** Boolean enabled status.

**Example:**

```php
// Disable sitemaps completely
add_filter( 'wp_sitemaps_enabled', '__return_false' );

// Disable sitemaps for non-admins
add_filter( 'wp_sitemaps_enabled', function( $enabled ) {
    return current_user_can( 'manage_options' );
} );
```

---

### wp_sitemaps_max_urls

Filters the maximum number of URLs per sitemap.

```php
apply_filters( 'wp_sitemaps_max_urls', int $max_urls, string $object_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_urls` | int | Maximum URLs. Default: 2000. |
| `$object_type` | string | Object type (`post`, `term`, `user`) |

**Returns:** Integer URL limit.

**Example:**

```php
add_filter( 'wp_sitemaps_max_urls', function( $max_urls, $object_type ) {
    // Larger sitemaps for posts
    if ( 'post' === $object_type ) {
        return 5000;
    }
    return $max_urls;
}, 10, 2 );
```

---

### wp_sitemaps_add_provider

Filters a sitemap provider before registration.

```php
apply_filters( 'wp_sitemaps_add_provider', WP_Sitemaps_Provider $provider, string $name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$provider` | WP_Sitemaps_Provider | Provider instance |
| `$name` | string | Provider name |

**Returns:** Provider instance, or non-provider value to block registration.

**Example:**

```php
// Block users sitemap
add_filter( 'wp_sitemaps_add_provider', function( $provider, $name ) {
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}, 10, 2 );
```

---

### wp_sitemaps_index_entry

Filters sitemap entry in the index.

```php
apply_filters( 'wp_sitemaps_index_entry', array $sitemap_entry, string $object_type, string $object_subtype, int $page )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$sitemap_entry` | array | Entry with `loc` key |
| `$object_type` | string | Object type |
| `$object_subtype` | string | Object subtype (empty if none) |
| `$page` | int | Page number |

**Returns:** Modified sitemap entry array.

**Example:**

```php
add_filter( 'wp_sitemaps_index_entry', function( $entry, $type, $subtype, $page ) {
    // Add lastmod to index entries
    $entry['lastmod'] = gmdate( DATE_W3C );
    return $entry;
}, 10, 4 );
```

---

## Stylesheet Filters

### wp_sitemaps_stylesheet_url

Filters the sitemap stylesheet URL.

```php
apply_filters( 'wp_sitemaps_stylesheet_url', string $sitemap_url )
```

**Returns:** URL string, or falsey value to disable stylesheet.

**Example:**

```php
// Use custom stylesheet
add_filter( 'wp_sitemaps_stylesheet_url', function() {
    return get_theme_file_uri( 'assets/sitemap.xsl' );
} );

// Disable stylesheet (raw XML)
add_filter( 'wp_sitemaps_stylesheet_url', '__return_false' );
```

---

### wp_sitemaps_stylesheet_index_url

Filters the sitemap index stylesheet URL.

```php
apply_filters( 'wp_sitemaps_stylesheet_index_url', string $sitemap_url )
```

**Returns:** URL string, or falsey value to disable stylesheet.

---

### wp_sitemaps_stylesheet_content

Filters the sitemap XSL stylesheet content.

```php
apply_filters( 'wp_sitemaps_stylesheet_content', string $xsl_content )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$xsl_content` | string | Full XSL stylesheet |

**Returns:** Modified XSL content.

---

### wp_sitemaps_stylesheet_index_content

Filters the sitemap index XSL stylesheet content.

```php
apply_filters( 'wp_sitemaps_stylesheet_index_content', string $xsl_content )
```

---

### wp_sitemaps_stylesheet_css

Filters the CSS in sitemap stylesheets.

```php
apply_filters( 'wp_sitemaps_stylesheet_css', string $css )
```

**Example:**

```php
add_filter( 'wp_sitemaps_stylesheet_css', function( $css ) {
    return $css . '
        body { background: #1a1a1a; color: #fff; }
        a { color: #3498db; }
    ';
} );
```

---

## Posts Provider Filters

### wp_sitemaps_post_types

Filters post types included in sitemap.

```php
apply_filters( 'wp_sitemaps_post_types', WP_Post_Type[] $post_types )
```

**Example:**

```php
add_filter( 'wp_sitemaps_post_types', function( $post_types ) {
    // Exclude a custom post type
    unset( $post_types['private_cpt'] );
    return $post_types;
} );
```

---

### wp_sitemaps_posts_pre_url_list

Short-circuits posts URL list generation.

```php
apply_filters( 'wp_sitemaps_posts_pre_url_list', array|null $url_list, string $post_type, int $page_num )
```

**Returns:** URL list array to use, or `null` to continue normal generation.

---

### wp_sitemaps_posts_entry

Filters individual post sitemap entry.

```php
apply_filters( 'wp_sitemaps_posts_entry', array $sitemap_entry, WP_Post $post, string $post_type )
```

**Example:**

```php
add_filter( 'wp_sitemaps_posts_entry', function( $entry, $post, $post_type ) {
    // Add priority for sticky posts
    if ( is_sticky( $post->ID ) ) {
        $entry['priority'] = '1.0';
    }
    return $entry;
}, 10, 3 );
```

---

### wp_sitemaps_posts_show_on_front_entry

Filters homepage entry when showing latest posts.

```php
apply_filters( 'wp_sitemaps_posts_show_on_front_entry', array $sitemap_entry )
```

---

### wp_sitemaps_posts_query_args

Filters WP_Query arguments for posts sitemap.

```php
apply_filters( 'wp_sitemaps_posts_query_args', array $args, string $post_type )
```

**Example:**

```php
add_filter( 'wp_sitemaps_posts_query_args', function( $args, $post_type ) {
    // Exclude posts from certain category
    if ( 'post' === $post_type ) {
        $args['category__not_in'] = array( 123 );
    }
    return $args;
}, 10, 2 );
```

---

### wp_sitemaps_posts_pre_max_num_pages

Short-circuits posts max pages calculation.

```php
apply_filters( 'wp_sitemaps_posts_pre_max_num_pages', int|null $max_num_pages, string $post_type )
```

---

## Taxonomies Provider Filters

### wp_sitemaps_taxonomies

Filters taxonomies included in sitemap.

```php
apply_filters( 'wp_sitemaps_taxonomies', WP_Taxonomy[] $taxonomies )
```

---

### wp_sitemaps_taxonomies_pre_url_list

Short-circuits taxonomies URL list generation.

```php
apply_filters( 'wp_sitemaps_taxonomies_pre_url_list', array|null $url_list, string $taxonomy, int $page_num )
```

---

### wp_sitemaps_taxonomies_entry

Filters individual term sitemap entry.

```php
apply_filters( 'wp_sitemaps_taxonomies_entry', array $sitemap_entry, int $term_id, string $taxonomy, WP_Term $term )
```

**Since:** 5.5.0, `$term` added in 6.0.0

---

### wp_sitemaps_taxonomies_query_args

Filters WP_Term_Query arguments.

```php
apply_filters( 'wp_sitemaps_taxonomies_query_args', array $args, string $taxonomy )
```

---

### wp_sitemaps_taxonomies_pre_max_num_pages

Short-circuits taxonomies max pages calculation.

```php
apply_filters( 'wp_sitemaps_taxonomies_pre_max_num_pages', int|null $max_num_pages, string $taxonomy )
```

---

## Users Provider Filters

### wp_sitemaps_users_pre_url_list

Short-circuits users URL list generation.

```php
apply_filters( 'wp_sitemaps_users_pre_url_list', array|null $url_list, int $page_num )
```

---

### wp_sitemaps_users_entry

Filters individual user sitemap entry.

```php
apply_filters( 'wp_sitemaps_users_entry', array $sitemap_entry, WP_User $user )
```

---

### wp_sitemaps_users_query_args

Filters WP_User_Query arguments.

```php
apply_filters( 'wp_sitemaps_users_query_args', array $args )
```

**Example:**

```php
add_filter( 'wp_sitemaps_users_query_args', function( $args ) {
    // Only include users with specific role
    $args['role__in'] = array( 'author', 'editor' );
    return $args;
} );
```

---

### wp_sitemaps_users_pre_max_num_pages

Short-circuits users max pages calculation.

```php
apply_filters( 'wp_sitemaps_users_pre_max_num_pages', int|null $max_num_pages )
```
