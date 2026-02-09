# WordPress Rewrite Functions

Functions for managing URL rewrite rules, tags, endpoints, and permalink structures.

---

## add_rewrite_rule()

Adds a rewrite rule that transforms a URL structure to a set of query vars.

```php
add_rewrite_rule( string $regex, string|array $query, string $after = 'bottom' )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$regex` | string | Regular expression to match request against |
| `$query` | string\|array | The corresponding query vars for this rewrite rule |
| `$after` | string | Priority: 'top' or 'bottom'. Default 'bottom' |

### Description

Creates a custom rewrite rule mapping a URL pattern to WordPress query variables. Rules added with 'top' priority are matched before WordPress core rules; 'bottom' rules are matched after.

### Examples

**Basic Custom URL:**

```php
// Maps /nutrition/apples/ to index.php?nutrition=apples
add_action( 'init', function() {
    add_rewrite_rule(
        '^nutrition/([^/]+)/?$',
        'index.php?nutrition=$matches[1]',
        'top'
    );
});

// Register the query var
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'nutrition';
    return $vars;
});
```

**With Array Query (since 4.4.0):**

```php
add_rewrite_rule(
    '^products/([^/]+)/reviews/?$',
    array(
        'post_type' => 'product',
        'name'      => '$matches[1]',
        'reviews'   => '1',
    ),
    'top'
);
```

**Date-Based Custom Archive:**

```php
// /events/2024/01/ → Events from January 2024
add_rewrite_rule(
    '^events/([0-9]{4})/([0-9]{2})/?$',
    'index.php?post_type=event&year=$matches[1]&monthnum=$matches[2]',
    'top'
);
```

### Notes

- Always call on `init` hook
- Flush rewrite rules after adding (on activation only, not every page load)
- Use `$matches[N]` to reference capture groups

### Source

`wp-includes/rewrite.php`

### Since

2.1.0 (array support for `$query` added in 4.4.0)

---

## add_rewrite_tag()

Adds a new rewrite tag (like %postname%).

```php
add_rewrite_tag( string $tag, string $regex, string $query = '' )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag` | string | Name of the new rewrite tag (must be wrapped in %) |
| `$regex` | string | Regular expression to substitute the tag for in rewrite rules |
| `$query` | string | String to append to the rewritten query. Must end in '='. Default empty |

### Description

Creates a custom rewrite tag that can be used in permalink structures. Tags must start and end with `%`. If `$query` is empty, a query var matching the tag name (without %) is automatically registered.

### Examples

**Basic Rewrite Tag:**

```php
add_action( 'init', function() {
    // Creates %product% tag matching any non-slash string
    add_rewrite_tag( '%product%', '([^/]+)', 'product=' );
});
```

**For Custom Post Type:**

```php
add_action( 'init', function() {
    // Register CPT with custom permalink structure
    register_post_type( 'book', array(
        'public'   => true,
        'rewrite'  => array( 'slug' => 'library/%author_name%' ),
    ));
    
    // Add custom tag for author name in URL
    add_rewrite_tag( '%author_name%', '([^/]+)', 'author_name=' );
});

// Filter the permalink to replace the tag
add_filter( 'post_type_link', function( $link, $post ) {
    if ( 'book' === $post->post_type ) {
        $author = get_post_meta( $post->ID, 'book_author', true );
        $link = str_replace( '%author_name%', sanitize_title( $author ), $link );
    }
    return $link;
}, 10, 2 );
```

**Auto Query Var Registration:**

```php
// When $query is empty, 'city' becomes a registered query var
add_rewrite_tag( '%city%', '([^/]+)' );

// Now you can use get_query_var( 'city' )
```

### Notes

- Tag name must be at least 3 characters: `%` + name + `%`
- Must be called on or before `init` hook if `$query` is empty
- The tag becomes available for use in `add_permastruct()`

### Source

`wp-includes/rewrite.php`

### Since

2.1.0

---

## remove_rewrite_tag()

Removes an existing rewrite tag.

```php
remove_rewrite_tag( string $tag )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$tag` | string | Name of the rewrite tag to remove |

### Examples

```php
add_action( 'init', function() {
    remove_rewrite_tag( '%author%' );
}, 20 ); // Later priority to ensure tag exists
```

### Source

`wp-includes/rewrite.php`

### Since

4.5.0

---

## add_permastruct()

Adds a permalink structure.

```php
add_permastruct( string $name, string $struct, array $args = array() )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Name for permalink structure |
| `$struct` | string | Permalink structure (e.g., `category/%category%`) |
| `$args` | array | Arguments for building the rules |

**$args Parameters:**

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `with_front` | bool | true | Prepend `$wp_rewrite->front` to structure |
| `ep_mask` | int | EP_NONE | Endpoint mask for attached endpoints |
| `paged` | bool | true | Add pagination rules |
| `feed` | bool | true | Add feed rules |
| `forcomments` | bool | false | Make feeds comment feeds |
| `walk_dirs` | bool | true | Create rules for each directory level |
| `endpoints` | bool | true | Apply endpoints to generated rules |

### Description

Creates a new permastruct that generates a set of rewrite rules. This is the preferred way to add complex URL structures rather than calling `add_rewrite_rule()` multiple times.

### Examples

**Custom Post Type Archive:**

```php
add_action( 'init', function() {
    add_permastruct( 'portfolio', 'work/%portfolio%', array(
        'with_front' => false,
        'ep_mask'    => EP_PERMALINK,
        'paged'      => true,
        'feed'       => true,
    ));
});
```

**Taxonomy with Custom Base:**

```php
add_action( 'init', function() {
    add_permastruct( 'genre', 'music/genre/%genre%', array(
        'with_front' => false,
        'ep_mask'    => EP_CATEGORIES,
    ));
});
```

**Without Pagination or Feeds:**

```php
add_permastruct( 'simple', 'simple/%name%', array(
    'paged' => false,
    'feed'  => false,
));
```

### Notes

- Structures are stored in `$wp_rewrite->extra_permastructs`
- Rules are generated when `WP_Rewrite::rewrite_rules()` is called
- Cannot remove built-in permastructs; only those added via this function

### Source

`wp-includes/rewrite.php`

### Since

3.0.0

---

## remove_permastruct()

Removes a permalink structure.

```php
remove_permastruct( string $name )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Name for permalink structure to remove |

### Description

Can only remove permastructs added via `add_permastruct()`. Built-in permastructs (category, post_tag, etc.) cannot be removed.

### Examples

```php
add_action( 'init', function() {
    remove_permastruct( 'portfolio' );
}, 20 );
```

### Source

`wp-includes/rewrite.php`

### Since

4.5.0

---

## add_feed()

Adds a new feed type like /atom1/.

```php
add_feed( string $feedname, callable $callback ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$feedname` | string | Feed name (should not start with '_') |
| `$callback` | callable | Callback to run on feed display |

### Return

`string` - Feed action name (hook name)

### Description

Registers a new feed type that generates rewrite rules like `/feed/feedname/`. The callback receives two parameters: `$is_comment_feed` and `$feed_type`.

### Examples

**JSON Feed:**

```php
add_action( 'init', function() {
    add_feed( 'json', 'render_json_feed' );
});

function render_json_feed( $is_comment_feed, $feed_type ) {
    header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
    
    $posts = get_posts( array( 'posts_per_page' => 10 ) );
    $items = array();
    
    foreach ( $posts as $post ) {
        $items[] = array(
            'title'   => $post->post_title,
            'url'     => get_permalink( $post ),
            'content' => $post->post_content,
        );
    }
    
    echo wp_json_encode( array( 'items' => $items ) );
}
```

**Custom RSS Format:**

```php
add_feed( 'myfeed', function( $is_comment_feed, $feed_type ) {
    load_template( get_template_directory() . '/feed-myfeed.php' );
});
```

### Notes

- Feed becomes available at `/feed/feedname/` and `/feedname/`
- Added to `$wp_rewrite->feeds` array
- Creates a `do_feed_{feedname}` action hook

### Source

`wp-includes/rewrite.php`

### Since

2.1.0

---

## add_rewrite_endpoint()

Adds an endpoint, like /trackback/.

```php
add_rewrite_endpoint( string $name, int $places, string|bool $query_var = true )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Name of the endpoint |
| `$places` | int | Endpoint mask (EP_* constants) |
| `$query_var` | string\|bool | Query variable name, or false to skip registration. Default true (uses $name) |

### Description

Creates extra rewrite rules for each matching place. For example, adding an endpoint 'json' with `EP_PERMALINK | EP_PAGES` creates rules for `/post-name/json/` and `/page-name/json/`.

### Examples

**API Endpoint on Posts:**

```php
add_action( 'init', function() {
    add_rewrite_endpoint( 'api', EP_PERMALINK );
});

// Handle the endpoint
add_action( 'template_redirect', function() {
    $api = get_query_var( 'api' );
    if ( $api !== '' ) {
        // Output JSON instead of template
        wp_send_json( array(
            'post_id' => get_the_ID(),
            'title'   => get_the_title(),
        ));
    }
});
```

**Print-Friendly Version:**

```php
add_action( 'init', function() {
    add_rewrite_endpoint( 'print', EP_PERMALINK | EP_PAGES );
});

add_filter( 'template_include', function( $template ) {
    if ( get_query_var( 'print' ) !== false && get_query_var( 'print' ) !== '' ) {
        return get_template_directory() . '/print-template.php';
    }
    return $template;
});
```

**Endpoint Without Query Var:**

```php
// Don't register query var (handle differently)
add_rewrite_endpoint( 'custom', EP_ROOT, false );
```

**Endpoint with Value:**

```php
// Creates URLs like /post-name/format/json/
add_rewrite_endpoint( 'format', EP_PERMALINK );

// Access the value
$format = get_query_var( 'format' ); // 'json' from /post/format/json/
```

### Notes

- Always flush rewrite rules after adding/removing endpoints
- The endpoint URL pattern is `name(/(.*))?/?$`
- Value after endpoint name is captured and available via query var

### Source

`wp-includes/rewrite.php`

### Since

2.1.0, query_var parameter added in 4.3.0

---

## flush_rewrite_rules()

Removes rewrite rules and then recreates them.

```php
flush_rewrite_rules( bool $hard = true )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$hard` | bool | Update .htaccess (hard) or just rewrite_rules option (soft). Default true |

### Description

Regenerates all rewrite rules from scratch. Hard flush updates server configuration files (.htaccess for Apache, web.config for IIS). Soft flush only updates the database option.

### Examples

**Plugin Activation:**

```php
register_activation_hook( __FILE__, 'myplugin_activate' );
function myplugin_activate() {
    // Register post types/taxonomies first
    myplugin_register_post_types();
    
    // Then flush
    flush_rewrite_rules();
}
```

**Plugin Deactivation:**

```php
register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
function myplugin_deactivate() {
    flush_rewrite_rules();
}
```

**Soft Flush (Database Only):**

```php
flush_rewrite_rules( false );
```

### ⚠️ Warning

**Never call this on every page load!** It's an expensive operation that:
- Rebuilds all rewrite rules
- Updates the database
- Potentially writes to .htaccess

```php
// BAD - causes performance issues
add_action( 'init', function() {
    add_rewrite_rule( '...', '...' );
    flush_rewrite_rules(); // DON'T DO THIS
});

// GOOD - flush only on activation
register_activation_hook( __FILE__, function() {
    myplugin_add_rewrite_rules();
    flush_rewrite_rules();
});
```

### Source

`wp-includes/rewrite.php`

### Since

3.0.0

---

## url_to_postid()

Examines a URL and tries to determine the post ID it represents.

```php
url_to_postid( string $url ): int
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$url` | string | Permalink to check |

### Return

`int` - Post ID, or 0 on failure

### Description

Parses a URL and attempts to find the corresponding post. Works with both pretty permalinks and plain query string URLs. Only works for URLs from the current site.

### Examples

**Basic Usage:**

```php
$post_id = url_to_postid( 'https://example.com/hello-world/' );
if ( $post_id ) {
    $post = get_post( $post_id );
}
```

**From Referer:**

```php
$referer = wp_get_referer();
if ( $referer ) {
    $post_id = url_to_postid( $referer );
}
```

**Validate Internal Links:**

```php
function is_internal_post_link( $url ) {
    return url_to_postid( $url ) > 0;
}
```

### Notes

- Returns 0 for external URLs
- Works with `?p=123`, `?page_id=123`, and pretty permalinks
- Uses current rewrite rules to match URLs
- Filters: `url_to_postid` (filters the URL before processing)

### Source

`wp-includes/rewrite.php`

### Since

1.0.0

---

## wp_resolve_numeric_slug_conflicts()

Resolves numeric slugs that collide with date permalinks.

```php
wp_resolve_numeric_slug_conflicts( array $query_vars = array() ): array
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$query_vars` | array | Query variables from WP::parse_request() |

### Return

`array` - Original query vars with date/post conflicts resolved

### Description

Handles edge cases where a post with a numeric slug (like '05') could be confused with a date archive URL. For example, with permalink structure `/%year%/%postname%/`, a post named '05' at `/2024/05/` could be mistaken for May 2024.

### Notes

- Called internally during request parsing
- Since 4.3.0, `wp_unique_post_slug()` prevents creation of conflicting slugs
- Primarily for legacy content compatibility

### Source

`wp-includes/rewrite.php`

### Since

4.3.0

---

## _wp_filter_taxonomy_base()

Filters the URL base for taxonomies to remove prepended /index.php/.

```php
_wp_filter_taxonomy_base( string $base ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$base` | string | The taxonomy base to filter |

### Return

`string` - Filtered base without /index.php/ prefix

### Description

Internal function that cleans up taxonomy bases. Removes any `/index.php/` prefix and trims slashes.

### Notes

- **Private function** - do not use directly
- Used internally when processing taxonomy rewrite bases

### Source

`wp-includes/rewrite.php`

### Since

2.6.0
