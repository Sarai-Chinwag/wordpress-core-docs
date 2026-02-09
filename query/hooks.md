# Query API Hooks

Actions and filters for modifying WordPress queries.

**Source:** `wp-includes/class-wp-query.php`, `wp-includes/query.php`

## Actions

### Query Lifecycle

#### pre_get_posts

Fires after the query variable object is created, but before the query is run. **The primary hook for modifying queries.**

```php
do_action_ref_array( 'pre_get_posts', array( WP_Query &$query ) );
```

**Parameters:**
- `$query` — The WP_Query instance (passed by reference)

**Usage:**
```php
add_action( 'pre_get_posts', function( $query ) {
    // Always check is_main_query() to avoid modifying secondary queries
    if ( ! is_admin() && $query->is_main_query() ) {
        
        // Modify home page query
        if ( $query->is_home() ) {
            $query->set( 'posts_per_page', 5 );
            $query->set( 'cat', -10 ); // Exclude category 10
        }
        
        // Add custom post types to search
        if ( $query->is_search() ) {
            $query->set( 'post_type', array( 'post', 'page', 'product' ) );
        }
    }
} );
```

**⚠️ Important:** Use `$query->is_main_query()` inside this hook, not the global function `is_main_query()`.

**Since:** 2.0.0

---

#### parse_query

Fires after the main query vars have been parsed.

```php
do_action_ref_array( 'parse_query', array( WP_Query &$query ) );
```

**Parameters:**
- `$query` — The WP_Query instance

**Usage:**
```php
add_action( 'parse_query', function( $query ) {
    // Query type flags are now set
    if ( $query->is_category() ) {
        // Modify category queries
    }
} );
```

**Since:** 1.5.0

---

#### parse_tax_query

Fires after taxonomy-related query vars have been parsed.

```php
do_action( 'parse_tax_query', WP_Query $query );
```

**Since:** 3.7.0

---

#### posts_selection

Fires to announce query's selection parameters. For use by caching plugins.

```php
do_action( 'posts_selection', string $selection );
```

**Parameters:**
- `$selection` — The assembled WHERE + GROUP BY + ORDER BY + LIMIT + JOIN

**Since:** 2.3.0

---

### Loop Actions

#### loop_start

Fires once the loop is started.

```php
do_action_ref_array( 'loop_start', array( WP_Query &$query ) );
```

**Since:** 2.0.0

---

#### loop_end

Fires once the loop has ended.

```php
do_action_ref_array( 'loop_end', array( WP_Query &$query ) );
```

**Since:** 2.0.0

---

#### loop_no_results

Fires if no results are found in a post query.

```php
do_action( 'loop_no_results', WP_Query $query );
```

**Usage:**
```php
add_action( 'loop_no_results', function( $query ) {
    if ( $query->is_search() ) {
        // Log failed search
        error_log( 'No results for: ' . $query->get( 's' ) );
    }
} );
```

**Since:** 4.9.0

---

#### the_post

Fires once the post data has been set up.

```php
do_action_ref_array( 'the_post', array( WP_Post &$post, WP_Query &$query ) );
```

**Parameters:**
- `$post` — The Post object
- `$query` — The WP_Query instance

**Usage:**
```php
add_action( 'the_post', function( $post, $query ) {
    // Runs each time a post is set up in the loop
    // Good for setting up custom globals
} , 10, 2 );
```

**Since:** 2.8.0, 4.1.0 (added `$query` parameter)

---

#### comment_loop_start

Fires once the comment loop is started.

```php
do_action( 'comment_loop_start' );
```

**Since:** 2.2.0

---

### Error Handling

#### set_404

Fires after a 404 is triggered.

```php
do_action_ref_array( 'set_404', array( WP_Query &$query ) );
```

**Usage:**
```php
add_action( 'set_404', function( $query ) {
    // Log 404s, redirect, etc.
} );
```

**Since:** 5.5.0

---

## Filters

### SQL Clause Filters

These filters allow modification of the SQL query. They come in two sets:
1. Standard filters — For normal modifications
2. Request filters (suffix `_request`) — For caching plugins

#### posts_where

Filters the WHERE clause of the query.

```php
apply_filters_ref_array( 'posts_where', array( string $where, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_where', function( $where, $query ) {
    global $wpdb;
    
    if ( $query->get( 'custom_title_search' ) ) {
        $search = $query->get( 'custom_title_search' );
        $where .= $wpdb->prepare(
            " AND {$wpdb->posts}.post_title LIKE %s",
            '%' . $wpdb->esc_like( $search ) . '%'
        );
    }
    
    return $where;
}, 10, 2 );
```

**Since:** 1.5.0

---

#### posts_join

Filters the JOIN clause of the query.

```php
apply_filters_ref_array( 'posts_join', array( string $join, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_join', function( $join, $query ) {
    global $wpdb;
    
    if ( $query->get( 'join_custom_table' ) ) {
        $join .= " LEFT JOIN {$wpdb->prefix}custom_table ct ON {$wpdb->posts}.ID = ct.post_id";
    }
    
    return $join;
}, 10, 2 );
```

**Since:** 1.5.0

---

#### posts_groupby

Filters the GROUP BY clause of the query.

```php
apply_filters_ref_array( 'posts_groupby', array( string $groupby, WP_Query &$query ) );
```

**Since:** 2.0.0

---

#### posts_orderby

Filters the ORDER BY clause of the query.

```php
apply_filters_ref_array( 'posts_orderby', array( string $orderby, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_orderby', function( $orderby, $query ) {
    global $wpdb;
    
    if ( $query->get( 'orderby' ) === 'title_length' ) {
        $orderby = "LENGTH({$wpdb->posts}.post_title) ASC";
    }
    
    return $orderby;
}, 10, 2 );
```

**Since:** 1.5.1

---

#### posts_distinct

Filters the DISTINCT clause of the query.

```php
apply_filters_ref_array( 'posts_distinct', array( string $distinct, WP_Query &$query ) );
```

**Since:** 2.1.0

---

#### posts_fields

Filters the SELECT clause of the query.

```php
apply_filters_ref_array( 'posts_fields', array( string $fields, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_fields', function( $fields, $query ) {
    global $wpdb;
    
    if ( $query->get( 'include_comment_count' ) ) {
        $fields .= ", (SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID = {$wpdb->posts}.ID) as comment_count_custom";
    }
    
    return $fields;
}, 10, 2 );
```

**Since:** 2.1.0

---

#### post_limits

Filters the LIMIT clause of the query.

```php
apply_filters_ref_array( 'post_limits', array( string $limits, WP_Query &$query ) );
```

**Since:** 2.1.0

---

#### posts_clauses

Filters all query clauses at once.

```php
apply_filters_ref_array( 'posts_clauses', array( array $clauses, WP_Query &$query ) );
```

**$clauses Array:**
```php
array(
    'where'    => string,
    'groupby'  => string,
    'join'     => string,
    'orderby'  => string,
    'distinct' => string,
    'fields'   => string,
    'limits'   => string,
)
```

**Usage:**
```php
add_filter( 'posts_clauses', function( $clauses, $query ) {
    if ( $query->get( 'complex_modification' ) ) {
        $clauses['where']   .= " AND ...";
        $clauses['join']    .= " LEFT JOIN ...";
        $clauses['orderby']  = "custom_order";
    }
    return $clauses;
}, 10, 2 );
```

**Since:** 3.1.0

---

### Paging-Specific Filters

These fire after paging is applied:

- `posts_where_paged` — WHERE after paging (since 1.5.0)
- `posts_join_paged` — JOIN after paging (since 1.5.0)

### Request Filters (For Caching Plugins)

Identical to standard filters, for caching plugin use:

- `posts_where_request`
- `posts_join_request`
- `posts_groupby_request`
- `posts_orderby_request`
- `posts_distinct_request`
- `posts_fields_request`
- `post_limits_request`
- `posts_clauses_request`

All since 2.5.0 or 3.1.0.

---

### Final Query Filter

#### posts_request

Filters the completed SQL query before sending.

```php
apply_filters_ref_array( 'posts_request', array( string $request, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_request', function( $request, $query ) {
    // Log all queries
    error_log( $request );
    return $request;
}, 10, 2 );
```

**Since:** 2.0.0

---

#### posts_request_ids

Filters the Post IDs SQL request when query is split.

```php
apply_filters( 'posts_request_ids', string $request, WP_Query $query );
```

**Since:** 3.4.0

---

### Results Filters

#### posts_pre_query

Filters the posts array before the query takes place. Return non-null to bypass WordPress queries.

```php
apply_filters_ref_array( 'posts_pre_query', array( null $posts, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'posts_pre_query', function( $posts, $query ) {
    // Return cached results to skip database query
    $cache_key = md5( serialize( $query->query_vars ) );
    $cached = wp_cache_get( $cache_key, 'custom_query_cache' );
    
    if ( $cached !== false ) {
        $query->found_posts   = $cached['found_posts'];
        $query->max_num_pages = $cached['max_num_pages'];
        return $cached['posts'];
    }
    
    return null; // Let WordPress query
}, 10, 2 );
```

**Since:** 4.6.0

---

#### posts_results

Filters the raw post results array, prior to status checks.

```php
apply_filters_ref_array( 'posts_results', array( WP_Post[] $posts, WP_Query &$query ) );
```

**Since:** 2.3.0

---

#### the_posts

Filters the array of posts after they've been fetched and processed.

```php
apply_filters_ref_array( 'the_posts', array( WP_Post[] $posts, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'the_posts', function( $posts, $query ) {
    if ( $query->is_main_query() && $query->is_home() ) {
        // Add a synthetic "featured" post at the beginning
        array_unshift( $posts, get_post( 123 ) );
    }
    return $posts;
}, 10, 2 );
```

**Since:** 1.5.0

---

#### found_posts

Filters the number of found posts.

```php
apply_filters_ref_array( 'found_posts', array( int $found_posts, WP_Query &$query ) );
```

**Usage:**
```php
add_filter( 'found_posts', function( $found_posts, $query ) {
    // Adjust for pagination display
    if ( $query->get( 'custom_found_posts' ) ) {
        return $query->get( 'custom_found_posts' );
    }
    return $found_posts;
}, 10, 2 );
```

**Since:** 2.1.0

---

#### found_posts_query

Filters the query to run for retrieving found posts count.

```php
apply_filters_ref_array( 'found_posts_query', array( string $found_posts_query, WP_Query &$query ) );
```

Default query: `'SELECT FOUND_ROWS()'`

**Since:** 2.1.0

---

### Search Filters

#### posts_search

Filters the search SQL in the WHERE clause.

```php
apply_filters_ref_array( 'posts_search', array( string $search, WP_Query &$query ) );
```

**Since:** 3.0.0

---

#### posts_search_orderby

Filters the ORDER BY used for search results.

```php
apply_filters( 'posts_search_orderby', string $search_orderby, WP_Query $query );
```

**Since:** 3.7.0

---

#### wp_search_stopwords

Filters stopwords used when parsing search terms.

```php
apply_filters( 'wp_search_stopwords', string[] $stopwords );
```

**Since:** 3.7.0

---

#### wp_query_search_exclusion_prefix

Filters the prefix that indicates a search term should be excluded.

```php
apply_filters( 'wp_query_search_exclusion_prefix', string $prefix );
```

Default: `'-'`

**Since:** 4.7.0

---

#### post_search_columns

Filters the columns to search.

```php
apply_filters( 'post_search_columns', string[] $columns, string $search, WP_Query $query );
```

Supported columns: `'post_title'`, `'post_excerpt'`, `'post_content'`

**Since:** 6.2.0

---

### Content Filters

#### content_pagination

Filters the "pages" derived from splitting post content by `<!-- nextpage -->`.

```php
apply_filters( 'content_pagination', string[] $pages, WP_Post $post );
```

**Since:** 4.4.0

---

#### the_preview

Filters the single post for preview mode.

```php
apply_filters_ref_array( 'the_preview', array( WP_Post $post_preview, WP_Query &$query ) );
```

**Since:** 2.7.0

---

### Query Splitting

#### split_the_query

Filters whether to split the query (fetch IDs first, then objects).

```php
apply_filters( 'split_the_query', bool $split, WP_Query $query, string $old_request, array $clauses );
```

**Since:** 3.4.0, 6.6.0 (added `$old_request` and `$clauses`)

---

### Attachment Queries

#### wp_allow_query_attachment_by_filename

Filters whether attachment queries should include filenames.

```php
apply_filters( 'wp_allow_query_attachment_by_filename', bool $allow );
```

Default: `false`

**Since:** 6.0.3

---

### Comment Feed Filters

Filters for comment feed queries:

- `comment_feed_join` — JOIN clause
- `comment_feed_where` — WHERE clause  
- `comment_feed_groupby` — GROUP BY clause
- `comment_feed_orderby` — ORDER BY clause
- `comment_feed_limits` — LIMIT clause

All since 2.2.0 or 2.8.0.

---

### Date Query Filters

#### date_query_valid_columns

Filters the list of valid date query columns.

```php
apply_filters( 'date_query_valid_columns', string[] $valid_columns );
```

**Since:** 3.7.0, 4.1.0 (added `user_registered`), 4.6.0 (added `registered`, `last_updated`)

---

#### get_date_sql

Filters the date query WHERE clause.

```php
apply_filters( 'get_date_sql', string $where, WP_Date_Query $query );
```

**Since:** 3.7.0

---

### Redirect Filters

#### old_slug_redirect_post_id

Filters the old slug redirect post ID.

```php
apply_filters( 'old_slug_redirect_post_id', int $id );
```

**Since:** 4.9.3

---

#### old_slug_redirect_url

Filters the old slug redirect URL.

```php
apply_filters( 'old_slug_redirect_url', string $link );
```

**Since:** 4.4.0

---

## Common Patterns

### Exclude Category from Home

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set( 'cat', '-5' ); // Exclude category ID 5
    }
} );
```

### Add Custom Post Type to Archives

```php
add_action( 'pre_get_posts', function( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        if ( $query->is_category() || $query->is_tag() ) {
            $query->set( 'post_type', array( 'post', 'custom_type' ) );
        }
    }
} );
```

### Custom Ordering

```php
add_filter( 'posts_orderby', function( $orderby, $query ) {
    if ( $query->get( 'orderby' ) === 'random_seeded' ) {
        $seed = $query->get( 'seed', 1 );
        return "RAND({$seed})";
    }
    return $orderby;
}, 10, 2 );
```

### Complex JOIN

```php
add_filter( 'posts_clauses', function( $clauses, $query ) {
    global $wpdb;
    
    if ( $query->get( 'order_by_views' ) ) {
        $clauses['join'] .= " 
            LEFT JOIN {$wpdb->postmeta} view_meta 
            ON {$wpdb->posts}.ID = view_meta.post_id 
            AND view_meta.meta_key = 'post_views'
        ";
        $clauses['orderby'] = "CAST(view_meta.meta_value AS UNSIGNED) DESC";
    }
    
    return $clauses;
}, 10, 2 );
```

### Query Cache Layer

```php
add_filter( 'posts_pre_query', function( $posts, $query ) {
    if ( $query->get( 'cache_this' ) ) {
        $key = 'query_' . md5( serialize( $query->query_vars ) );
        $cached = get_transient( $key );
        
        if ( $cached !== false ) {
            $query->found_posts   = $cached['found'];
            $query->max_num_pages = $cached['pages'];
            return $cached['posts'];
        }
    }
    return null;
}, 10, 2 );

add_filter( 'the_posts', function( $posts, $query ) {
    if ( $query->get( 'cache_this' ) ) {
        $key = 'query_' . md5( serialize( $query->query_vars ) );
        set_transient( $key, array(
            'posts' => wp_list_pluck( $posts, 'ID' ),
            'found' => $query->found_posts,
            'pages' => $query->max_num_pages,
        ), HOUR_IN_SECONDS );
    }
    return $posts;
}, 10, 2 );
```
