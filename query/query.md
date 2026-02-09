# WordPress Query API

The Query API is the backbone of WordPress content retrieval, powering The Loop and determining what content displays on every page.

**Source:** `wp-includes/query.php`, `wp-includes/class-wp-query.php`, `wp-includes/class-wp-date-query.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Query helper functions and conditional tags |
| [class-wp-query.md](./class-wp-query.md) | Main query class with 50+ query variables |
| [class-wp-date-query.md](./class-wp-date-query.md) | Date-based query filtering |
| [hooks.md](./hooks.md) | Actions and filters for query modification |

## Global Query Objects

WordPress maintains several global query-related variables:

```php
global $wp_query;       // The main query object (may be modified)
global $wp_the_query;   // Original/backup of the main query (never modified)
global $post;           // Current post in The Loop
```

### $wp_query vs $wp_the_query

- `$wp_the_query` — The pristine main query, set during `wp()` and never overwritten
- `$wp_query` — Points to `$wp_the_query` initially but can be replaced by `query_posts()`
- Always use `$wp_the_query` when checking `is_main_query()` to avoid false positives

## The Loop

The Loop is WordPress's fundamental content iteration pattern:

```php
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        // Access post data via template tags or $post global
        the_title();
        the_content();
    }
} else {
    // No posts found
}
```

### Loop Functions

| Function | Description |
|----------|-------------|
| `have_posts()` | Check if more posts exist in the loop |
| `the_post()` | Advance to next post, set up globals |
| `rewind_posts()` | Reset loop index to beginning |
| `in_the_loop()` | Check if currently inside a loop |

### Custom Loops

For secondary queries, always use `WP_Query` directly:

```php
$custom_query = new WP_Query( array(
    'post_type' => 'product',
    'posts_per_page' => 10,
) );

if ( $custom_query->have_posts() ) {
    while ( $custom_query->have_posts() ) {
        $custom_query->the_post();
        // Display content
    }
    wp_reset_postdata(); // Restore original $post
}
```

**Never use `query_posts()` for secondary loops.** It overwrites the main query and causes pagination/conditional tag issues.

## Query Flow

### Main Query Lifecycle

```
URL Request
    │
    ▼
WP::parse_request()
    │ Parses URL into query vars
    ▼
WP::query_posts()
    │ Creates WP_Query instance
    ▼
WP_Query::__construct()
    │
    ├── init()              Reset all properties
    ├── parse_query()       Parse query vars, set flags
    │   ├── fill_query_vars()
    │   ├── parse_tax_query()
    │   └── do_action('parse_query')
    │
    ▼
WP_Query::get_posts()
    │
    ├── do_action('pre_get_posts')    ◄── Primary hook for modifying queries
    │
    ├── Build SQL components:
    │   ├── Parse meta_query → WP_Meta_Query
    │   ├── Parse tax_query → WP_Tax_Query
    │   ├── Parse date_query → WP_Date_Query
    │   ├── Build WHERE, JOIN, ORDER BY
    │   └── Apply filters (posts_where, posts_join, etc.)
    │
    ├── apply_filters('posts_request')
    │
    ├── Execute database query
    │
    ├── apply_filters('posts_results')
    │
    ├── apply_filters('the_posts')
    │
    └── Return posts array
```

### Query Types Determined

During `parse_query()`, WordPress sets boolean flags indicating query type:

- **Singular:** `is_single`, `is_page`, `is_attachment`, `is_singular`
- **Archive:** `is_archive`, `is_category`, `is_tag`, `is_tax`, `is_author`, `is_date`
- **Special:** `is_home`, `is_front_page`, `is_search`, `is_feed`, `is_404`

## Three Ways to Query Posts

### 1. Main Query (Automatic)

WordPress creates this automatically based on URL:

```php
// In template files, just use The Loop
if ( have_posts() ) : while ( have_posts() ) : the_post();
    // ...
endwhile; endif;
```

### 2. WP_Query (Recommended for Custom Queries)

Full control with proper encapsulation:

```php
$query = new WP_Query( $args );
// Use $query->have_posts(), $query->the_post()
wp_reset_postdata();
```

### 3. get_posts() (Simple Retrieval)

Returns array of posts without setting up loop globals:

```php
$posts = get_posts( array(
    'numberposts' => 5,
    'category'    => 3,
) );

foreach ( $posts as $post ) {
    setup_postdata( $post );
    // Use template tags
}
wp_reset_postdata();
```

## Reset Functions

| Function | When to Use |
|----------|-------------|
| `wp_reset_postdata()` | After custom WP_Query or get_posts() loops |
| `wp_reset_query()` | After `query_posts()` (which you shouldn't use) |
| `rewind_posts()` | To loop through the same query again |

### Why Reset Matters

Custom queries modify the global `$post`. If you don't reset, template tags in sidebars/footers will reference the wrong post:

```php
// Without reset, sidebar shows wrong post data
$my_query = new WP_Query( $args );
while ( $my_query->have_posts() ) {
    $my_query->the_post();
    the_title(); // Shows custom query post
}
// $post still points to last custom post!

wp_reset_postdata(); // Now $post points to main query post again
```

## Common Query Patterns

### Category Archive + Custom Ordering

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_category() ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
} );
```

### Exclude Posts from Home

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'post__not_in', array( 1, 2, 3 ) );
    }
} );
```

### Include Custom Post Types in Search

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_search() && $query->is_main_query() ) {
        $query->set( 'post_type', array( 'post', 'page', 'product' ) );
    }
} );
```

## Performance Considerations

### Disable Unnecessary Queries

```php
$query = new WP_Query( array(
    'post_type'              => 'post',
    'no_found_rows'          => true,  // Skip SQL_CALC_FOUND_ROWS (no pagination)
    'update_post_meta_cache' => false, // Skip meta cache priming
    'update_post_term_cache' => false, // Skip term cache priming
    'fields'                 => 'ids', // Return only IDs
) );
```

### Query Caching

WordPress caches query results by default. The cache key is generated from:
- Query arguments
- SQL statement
- `posts` and `terms` cache groups' `last_changed` values

Disable with `'cache_results' => false` for one-off queries.

## Debugging Queries

### View Generated SQL

```php
$query = new WP_Query( $args );
echo $query->request; // The SQL query
```

### Query Monitor Plugin

Shows all queries, their execution time, and calling code.

### Debug with Hooks

```php
add_filter( 'posts_request', function( $sql, $query ) {
    if ( $query->is_main_query() ) {
        error_log( $sql );
    }
    return $sql;
}, 10, 2 );
```
