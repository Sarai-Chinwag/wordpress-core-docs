# WP_Comment_Query

Core class for querying comments from the database.

**Since:** 3.1.0  
**Source:** `wp-includes/class-wp-comment-query.php`

## Overview

`WP_Comment_Query` retrieves comments based on specified criteria. It supports filtering, pagination, meta queries, date queries, and hierarchical comment retrieval.

## Basic Usage

```php
// Simple query
$query = new WP_Comment_Query( array(
    'post_id' => 42,
    'status'  => 'approve',
) );
$comments = $query->comments;

// Using get_comments() wrapper
$comments = get_comments( array(
    'post_id' => 42,
    'status'  => 'approve',
) );
```

## Class Properties

| Property | Type | Description |
|----------|------|-------------|
| `$request` | string | The SQL query string |
| `$meta_query` | WP_Meta_Query | Meta query instance |
| `$date_query` | WP_Date_Query | Date query instance |
| `$query_vars` | array | Query variables set by user |
| `$query_var_defaults` | array | Default values for query vars |
| `$comments` | int[]|WP_Comment[] | Located comments |
| `$found_comments` | int | Total found comments |
| `$max_num_pages` | int | Number of pages |

## Query Variables

### Comment Selection

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `comment__in` | int[] | '' | Include specific comment IDs |
| `comment__not_in` | int[] | '' | Exclude specific comment IDs |
| `parent` | int | '' | Parent comment ID |
| `parent__in` | int[] | '' | Parent IDs to include children for |
| `parent__not_in` | int[] | '' | Parent IDs to exclude children for |

**Example:**
```php
// Get specific comments
$comments = get_comments( array(
    'comment__in' => array( 10, 20, 30 ),
) );

// Get replies to specific comment
$replies = get_comments( array(
    'parent' => 123,
) );

// Get replies to multiple parents
$replies = get_comments( array(
    'parent__in' => array( 10, 20, 30 ),
) );
```

### Post Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `post_id` | int | 0 | Limit to specific post ID |
| `post__in` | int[] | '' | Include comments from these posts |
| `post__not_in` | int[] | '' | Exclude comments from these posts |
| `post_author` | int | '' | Post author ID |
| `post_author__in` | int[] | '' | Post author IDs to include |
| `post_author__not_in` | int[] | '' | Post author IDs to exclude |
| `post_status` | string|string[] | '' | Post status(es). 'any' for all. |
| `post_type` | string|string[] | '' | Post type(s). 'any' for all. |
| `post_name` | string | '' | Post slug |
| `post_parent` | int | '' | Post parent ID |

**Example:**
```php
// Comments on specific post
$comments = get_comments( array(
    'post_id' => 42,
) );

// Comments on posts by author
$comments = get_comments( array(
    'post_author' => 5,
) );

// Comments on published posts only
$comments = get_comments( array(
    'post_status' => 'publish',
) );

// Comments on specific post type
$comments = get_comments( array(
    'post_type' => 'product',
) );
```

### Author Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `author_email` | string | '' | Comment author email |
| `author_url` | string | '' | Comment author URL |
| `author__in` | int[] | '' | Registered user IDs to include |
| `author__not_in` | int[] | '' | Registered user IDs to exclude |
| `user_id` | int|int[] | '' | Specific user ID(s) |
| `include_unapproved` | array | '' | IDs/emails whose unapproved comments to include |

**Example:**
```php
// Comments by email
$comments = get_comments( array(
    'author_email' => 'user@example.com',
) );

// Comments by registered users
$comments = get_comments( array(
    'author__in' => array( 1, 2, 3 ),
) );

// Include unapproved comments for current user
$comments = get_comments( array(
    'post_id'            => 42,
    'include_unapproved' => array( get_current_user_id() ),
) );
```

### Status Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `status` | string|array | 'all' | Comment status(es) |

**Status Values:**
- `'approve'` or `'1'` - Approved comments
- `'hold'` or `'0'` - Pending comments  
- `'spam'` - Spam comments
- `'trash'` - Trashed comments
- `'all'` or `''` - Approved and pending (excludes spam/trash)
- `'any'` - All statuses including spam/trash

**Example:**
```php
// Approved only
$approved = get_comments( array(
    'status' => 'approve',
) );

// Pending moderation
$pending = get_comments( array(
    'status' => 'hold',
) );

// Multiple statuses
$comments = get_comments( array(
    'status' => array( 'approve', 'hold' ),
) );
```

### Type Filtering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `type` | string|string[] | '' | Comment type(s) |
| `type__in` | string[] | '' | Types to include |
| `type__not_in` | string[] | '' | Types to exclude |

**Type Values:**
- `'comment'` - Regular comments (includes empty type for BC)
- `'pingback'` - Pingback notifications
- `'trackback'` - Trackback notifications
- `'pings'` - Both pingback and trackback
- `'all'` or `''` - All types
- `'note'` - Internal notes (excluded by default since 6.9.0)

**Example:**
```php
// Regular comments only
$comments = get_comments( array(
    'type' => 'comment',
) );

// Pingbacks and trackbacks
$pings = get_comments( array(
    'type' => 'pings',
) );

// Exclude pingbacks
$comments = get_comments( array(
    'type__not_in' => array( 'pingback', 'trackback' ),
) );

// Include notes (normally excluded)
$notes = get_comments( array(
    'type' => 'note',
) );
```

### Ordering

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `orderby` | string|array | 'comment_date_gmt' | Field(s) to order by |
| `order` | string | 'DESC' | Order direction: 'ASC' or 'DESC' |

**Orderby Values:**
- `'comment_agent'` - Browser user agent
- `'comment_approved'` - Approval status
- `'comment_author'` - Author name
- `'comment_author_email'` - Author email
- `'comment_author_IP'` - Author IP
- `'comment_author_url'` - Author URL
- `'comment_content'` - Comment content
- `'comment_date'` - Local date
- `'comment_date_gmt'` - GMT date (default)
- `'comment_ID'` - Comment ID
- `'comment_karma'` - Karma score
- `'comment_parent'` - Parent ID
- `'comment_post_ID'` - Post ID
- `'comment_type'` - Comment type
- `'user_id'` - User ID
- `'comment__in'` - Match order of `comment__in` array
- `'meta_value'` - Meta value (requires `meta_key`)
- `'meta_value_num'` - Numeric meta value
- `'none'`, `false`, or `array()` - Disable ordering

**Example:**
```php
// Oldest first
$comments = get_comments( array(
    'orderby' => 'comment_date',
    'order'   => 'ASC',
) );

// By karma, then date
$comments = get_comments( array(
    'orderby' => array(
        'comment_karma' => 'DESC',
        'comment_date'  => 'ASC',
    ),
) );

// By meta value
$comments = get_comments( array(
    'meta_key' => 'rating',
    'orderby'  => 'meta_value_num',
    'order'    => 'DESC',
) );

// Match specific order
$comments = get_comments( array(
    'comment__in' => array( 5, 2, 8, 1 ),
    'orderby'     => 'comment__in',
) );
```

### Pagination

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `number` | int | '' | Maximum comments to return |
| `offset` | int | 0 | Number of comments to skip |
| `paged` | int | 1 | Page number (used with `number`) |
| `no_found_rows` | bool | true | Skip counting total rows |

**Example:**
```php
// First 10 comments
$comments = get_comments( array(
    'number' => 10,
) );

// Page 2, 10 per page
$comments = get_comments( array(
    'number' => 10,
    'paged'  => 2,
) );

// Skip first 20, get next 10
$comments = get_comments( array(
    'number' => 10,
    'offset' => 20,
) );

// Get total count for pagination
$query = new WP_Comment_Query( array(
    'post_id'       => 42,
    'number'        => 10,
    'no_found_rows' => false,
) );
echo "Page 1 of " . $query->max_num_pages;
```

### Hierarchical/Threading

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `hierarchical` | bool|string | false | How to handle descendants |

**Values:**
- `false` - Don't include descendants
- `'threaded'` - Tree structure with children in `WP_Comment::$children`
- `'flat'` - Flat array including all descendants

**Example:**
```php
// Threaded comments with children populated
$comments = get_comments( array(
    'post_id'      => 42,
    'parent'       => 0,
    'hierarchical' => 'threaded',
) );

foreach ( $comments as $comment ) {
    display_comment( $comment );
    foreach ( $comment->get_children() as $reply ) {
        display_reply( $reply );
    }
}

// Flat list of all comments including replies
$comments = get_comments( array(
    'post_id'      => 42,
    'hierarchical' => 'flat',
) );
```

### Meta Query

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `meta_key` | string|string[] | '' | Meta key(s) to filter by |
| `meta_value` | string|string[] | '' | Meta value(s) to filter by |
| `meta_compare` | string | '=' | Comparison operator |
| `meta_compare_key` | string | '=' | Key comparison operator |
| `meta_type` | string | 'CHAR' | Value cast type |
| `meta_type_key` | string | '' | Key cast type |
| `meta_query` | array | '' | Complex meta query |

**Example:**
```php
// Simple meta filter
$comments = get_comments( array(
    'meta_key'   => 'rating',
    'meta_value' => 5,
) );

// Complex meta query
$comments = get_comments( array(
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'rating',
            'value'   => 4,
            'compare' => '>=',
            'type'    => 'NUMERIC',
        ),
        array(
            'key'     => 'verified',
            'value'   => 'yes',
        ),
    ),
) );
```

### Date Query

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `date_query` | array | null | Date query clauses |

**Example:**
```php
// Comments from last 30 days
$comments = get_comments( array(
    'date_query' => array(
        array(
            'after' => '30 days ago',
        ),
    ),
) );

// Comments from specific date range
$comments = get_comments( array(
    'date_query' => array(
        array(
            'after'     => 'January 1, 2024',
            'before'    => 'March 31, 2024',
            'inclusive' => true,
        ),
    ),
) );
```

### Search

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `search` | string | '' | Search term |

**Searches:** `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_content`

**Example:**
```php
$comments = get_comments( array(
    'search' => 'wordpress',
) );
```

### Other Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `karma` | int | '' | Specific karma score |
| `fields` | string | '' | 'ids' for IDs only, empty for full objects |
| `count` | bool | false | Return count instead of comments |
| `cache_domain` | string | 'core' | Cache key namespace |
| `update_comment_meta_cache` | bool | true | Prime meta cache |
| `update_comment_post_cache` | bool | false | Prime post cache |

**Example:**
```php
// Get IDs only
$ids = get_comments( array(
    'post_id' => 42,
    'fields'  => 'ids',
) );

// Count comments
$count = get_comments( array(
    'post_id' => 42,
    'count'   => true,
) );
```

## Methods

### __construct()

Sets up the query.

```php
public function __construct( $query = '' )
```

### query()

Executes the query.

```php
public function query( $query ): array|int
```

### get_comments()

Internal method that retrieves comments.

```php
public function get_comments(): int|int[]|WP_Comment[]
```

### parse_query()

Parses query arguments.

```php
public function parse_query( $query = '' )
```

## SQL Clauses Filter

The `comments_clauses` filter allows modifying the SQL query:

```php
add_filter( 'comments_clauses', function( $clauses, $query ) {
    // $clauses = array(
    //     'fields'  => 'SELECT ...',
    //     'join'    => 'JOIN ...',
    //     'where'   => 'WHERE ...',
    //     'orderby' => 'ORDER BY ...',
    //     'limits'  => 'LIMIT ...',
    //     'groupby' => 'GROUP BY ...',
    // );
    return $clauses;
}, 10, 2 );
```

## Performance Tips

1. **Use `no_found_rows`** (default true) when you don't need pagination counts
2. **Use `fields => 'ids'`** when you only need IDs
3. **Set `update_comment_meta_cache => false`** if you won't access meta
4. **Use `update_comment_post_cache => true`** if accessing post properties

```php
// Optimized query for counting
$count = get_comments( array(
    'post_id'                   => 42,
    'count'                     => true,
    'update_comment_meta_cache' => false,
) );
```

## Complete Example

```php
// Get paginated, threaded comments for a post
$query = new WP_Comment_Query( array(
    'post_id'                    => get_the_ID(),
    'status'                     => 'approve',
    'parent'                     => 0,
    'number'                     => get_option( 'comments_per_page' ),
    'paged'                      => get_query_var( 'cpage' ) ?: 1,
    'no_found_rows'              => false,
    'hierarchical'               => 'threaded',
    'update_comment_post_cache'  => false,
    'include_unapproved'         => is_user_logged_in() 
        ? array( get_current_user_id() ) 
        : array(),
) );

$comments = $query->comments;
$total_pages = $query->max_num_pages;
$total_comments = $query->found_comments;
```
