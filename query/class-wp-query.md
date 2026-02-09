# WP_Query Class

The main WordPress query class. Handles post retrieval, The Loop, and query state.

**Source:** `wp-includes/class-wp-query.php`  
**Since:** 1.5.0

## Basic Usage

```php
$query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'category_name'  => 'news',
) );

if ( $query->have_posts() ) {
    while ( $query->have_posts() ) {
        $query->the_post();
        the_title();
        the_content();
    }
    wp_reset_postdata();
}
```

## Properties

### Query State

| Property | Type | Description |
|----------|------|-------------|
| `$query` | `array` | Original query vars as passed |
| `$query_vars` | `array` | Parsed and filled query vars |
| `$request` | `string` | SQL query string |

### Results

| Property | Type | Description |
|----------|------|-------------|
| `$posts` | `WP_Post[]|int[]` | Array of post objects or IDs |
| `$post` | `WP_Post|null` | Current post in the loop |
| `$post_count` | `int` | Number of posts in current page |
| `$found_posts` | `int` | Total matching posts (all pages) |
| `$max_num_pages` | `int` | Number of pages |
| `$current_post` | `int` | Index of current post (-1 before loop) |

### Queried Object

| Property | Type | Description |
|----------|------|-------------|
| `$queried_object` | `WP_Term|WP_Post_Type|WP_Post|WP_User|null` | Main queried object |
| `$queried_object_id` | `int` | ID of queried object |

### Loop State

| Property | Type | Description |
|----------|------|-------------|
| `$in_the_loop` | `bool` | Whether currently in the loop |
| `$before_loop` | `bool` | Whether before the loop has started (since 6.3.0) |

### Query Type Flags

| Property | Description |
|----------|-------------|
| `$is_single` | Single post (not page or attachment) |
| `$is_page` | Single page |
| `$is_attachment` | Single attachment |
| `$is_singular` | Any single post/page/attachment |
| `$is_preview` | Post preview |
| `$is_archive` | Any archive page |
| `$is_category` | Category archive |
| `$is_tag` | Tag archive |
| `$is_tax` | Custom taxonomy archive |
| `$is_author` | Author archive |
| `$is_date` | Any date archive |
| `$is_year` | Year archive |
| `$is_month` | Month archive |
| `$is_day` | Day archive |
| `$is_time` | Time archive |
| `$is_post_type_archive` | Post type archive |
| `$is_home` | Blog home (posts page) |
| `$is_front_page()` | Site front page (method, not property) |
| `$is_privacy_policy` | Privacy policy page |
| `$is_search` | Search results |
| `$is_feed` | Feed request |
| `$is_comment_feed` | Comments feed |
| `$is_trackback` | Trackback endpoint |
| `$is_paged` | Paginated (page 2+) |
| `$is_admin` | Admin request |
| `$is_404` | No results found |
| `$is_embed` | Embedded post |
| `$is_robots` | robots.txt request |
| `$is_favicon` | favicon.ico request |
| `$is_posts_page` | Page assigned as posts page |

### Sub-Query Objects

| Property | Type | Description |
|----------|------|-------------|
| `$tax_query` | `WP_Tax_Query|null` | Taxonomy query instance |
| `$meta_query` | `WP_Meta_Query|false` | Meta query instance |
| `$date_query` | `WP_Date_Query|false` | Date query instance |

### Comments

| Property | Type | Description |
|----------|------|-------------|
| `$comments` | `WP_Comment[]` | Comments for current post |
| `$comment` | `WP_Comment` | Current comment in loop |
| `$comment_count` | `int` | Number of comments |
| `$current_comment` | `int` | Current comment index |
| `$max_num_comment_pages` | `int` | Number of comment pages |

---

## Query Variables Reference

### Post Selection

#### By ID

| Variable | Type | Description |
|----------|------|-------------|
| `p` | `int` | Post ID |
| `post__in` | `int[]` | Array of post IDs to include |
| `post__not_in` | `int[]` | Array of post IDs to exclude |
| `page_id` | `int` | Page ID |

```php
// Single post by ID
'p' => 42

// Multiple specific posts
'post__in' => array( 1, 2, 3 )

// Exclude posts
'post__not_in' => array( 10, 20 )
```

#### By Slug/Name

| Variable | Type | Description |
|----------|------|-------------|
| `name` | `string` | Post slug |
| `pagename` | `string` | Page slug (supports hierarchy: `parent/child`) |
| `post_name__in` | `string[]` | Array of post slugs |
| `title` | `string` | Exact post title match |

```php
// By slug
'name' => 'hello-world'

// By page path
'pagename' => 'about/team'

// Multiple slugs
'post_name__in' => array( 'hello', 'world' )
```

### Post Type & Status

| Variable | Type | Description |
|----------|------|-------------|
| `post_type` | `string|string[]` | Post type(s). Default: `'post'` |
| `post_status` | `string|string[]` | Post status(es). Default: `'publish'` |

**Post Type Values:**
- `'post'` — Blog posts
- `'page'` — Pages
- `'attachment'` — Media
- `'revision'` — Revisions
- `'nav_menu_item'` — Menu items
- `'any'` — All types except revisions and types with `exclude_from_search = true`
- Custom post type slugs

**Post Status Values:**
- `'publish'` — Published
- `'pending'` — Pending review
- `'draft'` — Draft
- `'auto-draft'` — Auto-draft
- `'future'` — Scheduled
- `'private'` — Private
- `'inherit'` — Inherits parent (attachments)
- `'trash'` — Trashed
- `'any'` — All except `trash` and `auto-draft`

```php
// Multiple post types
'post_type' => array( 'post', 'page', 'product' )

// Multiple statuses
'post_status' => array( 'publish', 'private' )
```

### Pagination

| Variable | Type | Description |
|----------|------|-------------|
| `posts_per_page` | `int` | Posts per page. `-1` for all. |
| `posts_per_archive_page` | `int` | Posts per page on archives |
| `nopaging` | `bool` | Disable pagination |
| `paged` | `int` | Page number |
| `offset` | `int` | Number of posts to skip |
| `page` | `int` | Page number for static front page |

```php
// 10 posts per page, page 2
'posts_per_page' => 10,
'paged' => 2

// Skip first 5 posts
'offset' => 5

// All posts, no pagination
'posts_per_page' => -1
// or
'nopaging' => true
```

### Category Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `cat` | `int|string` | Category ID(s). Negative excludes. |
| `category_name` | `string` | Category slug (includes children) |
| `category__in` | `int[]` | Category IDs (no children) |
| `category__not_in` | `int[]` | Exclude category IDs |
| `category__and` | `int[]` | Posts in ALL listed categories |

```php
// By category ID
'cat' => 5

// Multiple categories (OR)
'cat' => '2,6,17'

// Exclude category
'cat' => '-12'

// By slug
'category_name' => 'news'

// Posts in ALL categories
'category__and' => array( 2, 6 )

// Posts in ANY category (no children)
'category__in' => array( 2, 6 )
```

### Tag Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `tag` | `string` | Tag slug(s). Comma = OR, plus = AND |
| `tag_id` | `int` | Tag ID |
| `tag__in` | `int[]` | Tag IDs (OR) |
| `tag__not_in` | `int[]` | Exclude tag IDs |
| `tag__and` | `int[]` | Posts with ALL tags |
| `tag_slug__in` | `string[]` | Tag slugs (OR) |
| `tag_slug__and` | `string[]` | Tag slugs (AND) |

```php
// Single tag
'tag' => 'bread'

// Multiple tags (OR)
'tag' => 'bread,butter'

// Multiple tags (AND)
'tag' => 'bread+butter'

// By tag IDs
'tag__in' => array( 37, 47 )

// All tags required
'tag__and' => array( 37, 47 )
```

### Taxonomy Parameters (tax_query)

| Variable | Type | Description |
|----------|------|-------------|
| `tax_query` | `array` | Complex taxonomy query |

**tax_query Structure:**
```php
'tax_query' => array(
    'relation' => 'AND', // 'AND' or 'OR' between clauses
    array(
        'taxonomy'         => 'genre',      // Taxonomy name
        'field'            => 'slug',       // 'term_id', 'slug', 'name', or 'term_taxonomy_id'
        'terms'            => array( 'action', 'comedy' ),
        'operator'         => 'IN',         // 'IN', 'NOT IN', 'AND', 'EXISTS', 'NOT EXISTS'
        'include_children' => true,         // Include children terms
    ),
    array(
        'taxonomy' => 'actor',
        'field'    => 'term_id',
        'terms'    => array( 103, 115 ),
    ),
)
```

**Operators:**
- `'IN'` — Match any term (default)
- `'NOT IN'` — Exclude posts with these terms
- `'AND'` — Match ALL terms
- `'EXISTS'` — Has any term in taxonomy
- `'NOT EXISTS'` — Has no terms in taxonomy

### Author Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `author` | `int|string` | Author ID(s). Negative excludes. |
| `author_name` | `string` | Author nicename (slug) |
| `author__in` | `int[]` | Author IDs to include |
| `author__not_in` | `int[]` | Author IDs to exclude |

```php
// By author ID
'author' => 1

// Multiple authors
'author' => '1,2,3'

// Exclude author
'author' => '-1'

// By nicename
'author_name' => 'john-doe'

// Multiple authors
'author__in' => array( 1, 5, 12 )
```

### Date Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `year` | `int` | Four-digit year |
| `monthnum` | `int` | Month (1-12) |
| `day` | `int` | Day of month (1-31) |
| `w` | `int` | Week of year (0-53) |
| `hour` | `int` | Hour (0-23) |
| `minute` | `int` | Minute (0-59) |
| `second` | `int` | Second (0-59) |
| `m` | `int` | YearMonth (e.g., `202301`) |
| `date_query` | `array` | Complex date query |

```php
// Posts from January 2023
'year' => 2023,
'monthnum' => 1

// Combined format
'm' => 202301

// Complex date query
'date_query' => array(
    array(
        'after'     => 'January 1st, 2023',
        'before'    => 'December 31st, 2023',
        'inclusive' => true,
    ),
)
```

See [class-wp-date-query.md](./class-wp-date-query.md) for complete date_query documentation.

### Meta (Custom Field) Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `meta_key` | `string` | Custom field key |
| `meta_value` | `string` | Custom field value |
| `meta_compare` | `string` | Comparison operator |
| `meta_type` | `string` | Data type for CAST |
| `meta_query` | `array` | Complex meta query |

**Simple Meta Query:**
```php
// Posts with specific meta value
'meta_key'   => 'color',
'meta_value' => 'blue'

// Numeric comparison
'meta_key'     => 'price',
'meta_value'   => 100,
'meta_compare' => '>=',
'meta_type'    => 'NUMERIC'
```

**Complex meta_query:**
```php
'meta_query' => array(
    'relation' => 'AND',
    array(
        'key'     => 'color',
        'value'   => 'blue',
        'compare' => '=',
    ),
    'price_clause' => array(  // Named clause for ordering
        'key'     => 'price',
        'value'   => array( 20, 100 ),
        'type'    => 'NUMERIC',
        'compare' => 'BETWEEN',
    ),
),
'orderby' => 'price_clause' // Order by named clause
```

**Compare Operators:**
- `'='`, `'!='` — Equal, not equal
- `'>'`, `'>='`, `'<'`, `'<='` — Numeric comparison
- `'LIKE'`, `'NOT LIKE'` — Pattern matching
- `'IN'`, `'NOT IN'` — Value in array
- `'BETWEEN'`, `'NOT BETWEEN'` — Range
- `'EXISTS'`, `'NOT EXISTS'` — Key exists
- `'REGEXP'`, `'NOT REGEXP'`, `'RLIKE'` — Regular expression

**Type Values:**
- `'NUMERIC'`, `'DECIMAL'`, `'SIGNED'`, `'UNSIGNED'`
- `'CHAR'`, `'BINARY'`
- `'DATE'`, `'DATETIME'`, `'TIME'`

### Search Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `s` | `string` | Search keyword(s) |
| `search_columns` | `string[]` | Columns to search |
| `sentence` | `bool` | Search as exact phrase |
| `exact` | `bool` | Exact match (no wildcards) |

```php
// Basic search
's' => 'hello world'

// Exclude terms (prefix with -)
's' => 'pillow -sofa'

// Search specific columns
's' => 'hello',
'search_columns' => array( 'post_title', 'post_excerpt' )

// Exact phrase
's' => 'hello world',
'sentence' => true
```

**Search Columns:**
- `'post_title'`
- `'post_excerpt'`
- `'post_content'`

### Ordering Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `orderby` | `string|array` | Sort field(s) |
| `order` | `string` | `'ASC'` or `'DESC'` |

**orderby Values:**
| Value | Description |
|-------|-------------|
| `'none'` | No order |
| `'ID'` | Post ID |
| `'author'` | Author ID |
| `'title'` | Post title |
| `'name'` | Post slug |
| `'type'` | Post type |
| `'date'` | Post date (default) |
| `'modified'` | Last modified date |
| `'parent'` | Parent post ID |
| `'rand'` | Random |
| `'RAND(x)'` | Random with seed |
| `'comment_count'` | Number of comments |
| `'relevance'` | Search relevance |
| `'menu_order'` | Menu order |
| `'meta_value'` | Meta value (requires `meta_key`) |
| `'meta_value_num'` | Numeric meta value |
| `'post__in'` | Preserve `post__in` order |
| `'post_name__in'` | Preserve `post_name__in` order |
| `'post_parent__in'` | Preserve `post_parent__in` order |

```php
// Single orderby
'orderby' => 'title',
'order'   => 'ASC'

// Multiple orderby
'orderby' => array(
    'menu_order' => 'ASC',
    'title'      => 'ASC',
)

// Order by meta
'meta_key' => 'price',
'orderby'  => 'meta_value_num',
'order'    => 'ASC'

// Preserve post__in order
'post__in' => array( 5, 2, 8 ),
'orderby'  => 'post__in'

// Random with seed (for consistent pagination)
'orderby' => 'RAND(123)'
```

### Parent/Hierarchy Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `post_parent` | `int` | Parent post ID. `0` for top-level. |
| `post_parent__in` | `int[]` | Parent IDs to include |
| `post_parent__not_in` | `int[]` | Parent IDs to exclude |

```php
// Children of post 10
'post_parent' => 10

// Top-level pages only
'post_type'   => 'page',
'post_parent' => 0

// Children of multiple parents
'post_parent__in' => array( 10, 20 )
```

### Password Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `has_password` | `bool` | `true` for protected, `false` for not |
| `post_password` | `string` | Posts with specific password |

```php
// Only password-protected posts
'has_password' => true

// Only non-protected posts
'has_password' => false

// Specific password
'post_password' => 'mypassword'
```

### Comment Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `comment_status` | `string` | `'open'` or `'closed'` |
| `ping_status` | `string` | `'open'` or `'closed'` |
| `comment_count` | `int|array` | Filter by comment count |
| `comments_per_page` | `int` | Comments per page |

```php
// Posts with comments open
'comment_status' => 'open'

// Posts with exact comment count
'comment_count' => 10

// Posts with more than 5 comments
'comment_count' => array(
    'value'   => 5,
    'compare' => '>'
)
```

### Permission Parameters

| Variable | Type | Description |
|----------|------|-------------|
| `perm` | `string` | Permission check: `'readable'` or `'editable'` |

```php
// Only posts current user can read
'perm' => 'readable'
```

### MIME Type (Attachments)

| Variable | Type | Description |
|----------|------|-------------|
| `post_mime_type` | `string|string[]` | MIME type(s) for attachments |

```php
// Only images
'post_type'      => 'attachment',
'post_status'    => 'inherit',
'post_mime_type' => 'image'

// Specific types
'post_mime_type' => array( 'image/jpeg', 'image/png' )
```

### Cache Control

| Variable | Type | Default | Description |
|----------|------|---------|-------------|
| `cache_results` | `bool` | `true` | Cache post information |
| `update_post_meta_cache` | `bool` | `true` | Prime meta cache |
| `update_post_term_cache` | `bool` | `true` | Prime term cache |
| `update_menu_item_cache` | `bool` | `false` | Prime menu item cache |
| `lazy_load_term_meta` | `bool` | (varies) | Lazy-load term meta |

```php
// Optimized query (no extra queries)
'cache_results'          => true,
'update_post_meta_cache' => false, // Don't need meta
'update_post_term_cache' => false, // Don't need terms
```

### Miscellaneous

| Variable | Type | Description |
|----------|------|-------------|
| `fields` | `string` | Return format: `''`, `'ids'`, or `'id=>parent'` |
| `no_found_rows` | `bool` | Skip counting total rows |
| `suppress_filters` | `bool` | Bypass filters |
| `ignore_sticky_posts` | `bool` | Ignore sticky post handling |
| `menu_order` | `int` | Specific menu order value |

```php
// Return only IDs (fast)
'fields' => 'ids'

// Return ID => parent mapping
'fields' => 'id=>parent'

// Skip SQL_CALC_FOUND_ROWS (faster when not paginating)
'no_found_rows' => true

// Bypass all filters
'suppress_filters' => true

// Don't put stickies first
'ignore_sticky_posts' => true
```

---

## Methods

### Constructor

```php
public function __construct( string|array $query = '' )
```

Creates new query. If `$query` provided, immediately runs `query()`.

---

### Core Methods

#### query()

```php
public function query( string|array $query ): WP_Post[]|int[]
```

Sets up the query and retrieves posts.

**Parameters:**
- `$query` — Query string or array

**Returns:** Array of posts or post IDs.

---

#### get_posts()

```php
public function get_posts(): WP_Post[]|int[]
```

Retrieves posts based on current query variables. Called internally by `query()`.

---

#### parse_query()

```php
public function parse_query( string|array $query = '' ): void
```

Parses query string and sets query type flags.

---

### Loop Methods

#### have_posts()

```php
public function have_posts(): bool
```

Check if more posts available. Fires `loop_end` and `loop_no_results` actions.

---

#### the_post()

```php
public function the_post(): void
```

Advances to next post, sets up globals. Fires `loop_start` on first call.

---

#### rewind_posts()

```php
public function rewind_posts(): void
```

Resets loop to beginning.

---

#### next_post()

```php
public function next_post(): WP_Post
```

Returns next post in loop (internal use).

---

### Comment Loop Methods

#### have_comments()

```php
public function have_comments(): bool
```

Check if more comments available.

---

#### the_comment()

```php
public function the_comment(): void
```

Advances to next comment.

---

#### rewind_comments()

```php
public function rewind_comments(): void
```

Resets comment loop.

---

### Getters/Setters

#### get()

```php
public function get( string $query_var, mixed $default_value = '' ): mixed
```

Retrieves query variable value.

---

#### set()

```php
public function set( string $query_var, mixed $value ): void
```

Sets query variable value.

---

#### get_queried_object()

```php
public function get_queried_object(): WP_Term|WP_Post_Type|WP_Post|WP_User|null
```

Returns the main queried object based on query type.

---

#### get_queried_object_id()

```php
public function get_queried_object_id(): int
```

Returns ID of queried object, or `0`.

---

### Post Data Methods

#### setup_postdata()

```php
public function setup_postdata( WP_Post|object|int $post ): true
```

Sets up global post data. Fires `the_post` action.

---

#### generate_postdata()

```php
public function generate_postdata( WP_Post|object|int $post ): array|false
```

Generates postdata array without setting globals.

---

#### reset_postdata()

```php
public function reset_postdata(): void
```

Restores `$post` global to current query's post.

---

### Conditional Methods

All return `bool`. Some accept optional parameters for specific checks.

| Method | Parameters |
|--------|------------|
| `is_archive()` | — |
| `is_post_type_archive()` | `$post_types = ''` |
| `is_attachment()` | `$attachment = ''` |
| `is_author()` | `$author = ''` |
| `is_category()` | `$category = ''` |
| `is_tag()` | `$tag = ''` |
| `is_tax()` | `$taxonomy = ''`, `$term = ''` |
| `is_date()` | — |
| `is_day()` | — |
| `is_month()` | — |
| `is_year()` | — |
| `is_time()` | — |
| `is_feed()` | `$feeds = ''` |
| `is_comment_feed()` | — |
| `is_front_page()` | — |
| `is_home()` | — |
| `is_privacy_policy()` | — |
| `is_page()` | `$page = ''` |
| `is_paged()` | — |
| `is_preview()` | — |
| `is_robots()` | — |
| `is_favicon()` | — |
| `is_search()` | — |
| `is_single()` | `$post = ''` |
| `is_singular()` | `$post_types = ''` |
| `is_trackback()` | — |
| `is_404()` | — |
| `is_embed()` | — |
| `is_main_query()` | — |

---

### Internal Methods

#### init()

```php
public function init(): void
```

Resets all properties to defaults.

---

#### fill_query_vars()

```php
public function fill_query_vars( array $query_vars ): array
```

Fills in missing query variables with defaults.

---

#### parse_tax_query()

```php
public function parse_tax_query( array &$query_vars ): void
```

Parses taxonomy-related query vars.

---

#### set_404()

```php
public function set_404(): void
```

Sets 404 state. Fires `set_404` action.

---

## Example Queries

### Recent Posts with Thumbnails

```php
$query = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 5,
    'meta_query'     => array(
        array(
            'key'     => '_thumbnail_id',
            'compare' => 'EXISTS',
        ),
    ),
) );
```

### Products by Price Range

```php
$query = new WP_Query( array(
    'post_type'  => 'product',
    'meta_query' => array(
        array(
            'key'     => '_price',
            'value'   => array( 10, 50 ),
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
        ),
    ),
    'orderby'    => 'meta_value_num',
    'meta_key'   => '_price',
    'order'      => 'ASC',
) );
```

### Posts in Multiple Taxonomies

```php
$query = new WP_Query( array(
    'post_type' => 'post',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'news',
        ),
        array(
            'taxonomy' => 'post_tag',
            'field'    => 'slug',
            'terms'    => array( 'featured', 'breaking' ),
            'operator' => 'IN',
        ),
    ),
) );
```

### Complex Date Query

```php
$query = new WP_Query( array(
    'post_type'  => 'event',
    'date_query' => array(
        array(
            'after'  => array(
                'year'  => 2023,
                'month' => 6,
            ),
            'before' => array(
                'year'  => 2023,
                'month' => 12,
                'day'   => 31,
            ),
            'inclusive' => true,
        ),
        array(
            'hour'    => 9,
            'compare' => '>=',
        ),
        array(
            'hour'    => 17,
            'compare' => '<=',
        ),
        'relation' => 'AND',
    ),
) );
```

### Optimized ID-Only Query

```php
$post_ids = new WP_Query( array(
    'post_type'              => 'post',
    'posts_per_page'         => 100,
    'fields'                 => 'ids',
    'no_found_rows'          => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
) );

// $post_ids->posts is array of integers
```
