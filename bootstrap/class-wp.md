# WP Class - WordPress Environment Setup

The `WP` class is responsible for setting up the WordPress environment, parsing requests, and initializing the main query loop.

**File:** `wp-includes/class-wp.php`

**Since:** 2.0.0

## Overview

The `WP` class handles:
- Parsing the request URL and matching rewrite rules
- Setting up query variables
- Initializing the main WordPress query
- Sending HTTP headers
- Handling 404 errors
- Registering global variables

## Properties

### Query Variables

```php
/**
 * Public query variables.
 * @var string[]
 */
public $public_query_vars = array(
    'm', 'p', 'posts', 'w', 'cat', 'withcomments', 'withoutcomments',
    's', 'search', 'exact', 'sentence', 'calendar', 'page', 'paged',
    'more', 'tb', 'pb', 'author', 'order', 'orderby', 'year', 'monthnum',
    'day', 'hour', 'minute', 'second', 'name', 'category_name', 'tag',
    'feed', 'author_name', 'pagename', 'page_id', 'error', 'attachment',
    'attachment_id', 'subpost', 'subpost_id', 'preview', 'robots',
    'favicon', 'taxonomy', 'term', 'cpage', 'post_type', 'embed'
);

/**
 * Private query variables (not accepted from URL).
 * @var string[]
 */
public $private_query_vars = array(
    'offset', 'posts_per_page', 'posts_per_archive_page', 'showposts',
    'nopaging', 'post_type', 'post_status', 'category__in', 'category__not_in',
    'category__and', 'tag__in', 'tag__not_in', 'tag__and', 'tag_slug__in',
    'tag_slug__and', 'tag_id', 'post_mime_type', 'perm', 'comments_per_page',
    'post__in', 'post__not_in', 'post_parent', 'post_parent__in',
    'post_parent__not_in', 'title', 'fields'
);

/**
 * Extra query variables from user.
 * @var array
 */
public $extra_query_vars = array();

/**
 * Final query variables for WP_Query.
 * @var array
 */
public $query_vars = array();
```

### Request Information

```php
/**
 * The query string (built from query_vars).
 * @var string
 */
public $query_string = '';

/**
 * The request path (e.g., '2015/05/06').
 * @var string
 */
public $request = '';

/**
 * Rewrite rule that matched.
 * @var string
 */
public $matched_rule = '';

/**
 * Query string from matched rewrite rule.
 * @var string
 */
public $matched_query = '';

/**
 * Whether permalink matching was attempted.
 * @var bool
 */
public $did_permalink = false;
```

## Methods

### main()

Entry point that orchestrates the entire request handling.

```php
public function main( string|array $query_args = '' ): void
```

**Flow:**
```
main()
  ├── init()           → Set up current user
  ├── parse_request()  → Parse URL, match rewrite rules
  │   └── (if parsed successfully)
  │       ├── query_posts()    → Execute WP_Query
  │       ├── handle_404()     → Set 404 if needed
  │       └── register_globals() → Export to GLOBALS
  ├── send_headers()   → Send HTTP headers
  └── do_action('wp')  → Fire 'wp' action
```

**Since:** 2.0.0

---

### init()

Sets up the current user.

```php
public function init(): void
```

**Behavior:** Calls `wp_get_current_user()` to initialize the current user.

**Since:** 2.0.0

---

### parse_request()

Parses the request to determine query variables.

```php
public function parse_request( string|array $extra_query_vars = '' ): bool
```

**Parameters:**
- `$extra_query_vars` - Additional query vars to merge

**Returns:** `true` if request was parsed, `false` if short-circuited

**Process:**
1. Check `do_parse_request` filter (allows short-circuit)
2. Process `extra_query_vars`
3. Fetch rewrite rules from `$wp_rewrite`
4. Match request against rewrite rules
5. Extract query vars from matched rule
6. Filter through `query_vars` filter
7. Populate `$this->query_vars` from:
   - Extra query vars
   - `$_GET`
   - `$_POST`
   - Permalink query vars
8. Validate post types and taxonomies
9. Fire `parse_request` action

**Hooks:**
- Filter: `do_parse_request` - Short-circuit parsing
- Filter: `query_vars` - Modify allowed query vars
- Filter: `request` - Modify final query vars
- Action: `parse_request` - After parsing complete

**Since:** 2.0.0

---

### query_posts()

Executes the main WordPress query.

```php
public function query_posts(): void
```

**Process:**
1. Calls `build_query_string()` to create query string
2. Executes `$wp_the_query->query( $this->query_vars )`

**Since:** 2.0.0

---

### build_query_string()

Builds query string from query variables.

```php
public function build_query_string(): void
```

**Sets:** `$this->query_string`

**Filter:** `query_string` (deprecated since 2.1.0)

**Since:** 2.0.0

---

### send_headers()

Sends HTTP headers for the response.

```php
public function send_headers(): void
```

**Headers Set:**
- `Content-Type` - Based on request type
- `X-Pingback` - For pingback-enabled posts
- `Last-Modified` / `ETag` - For feeds
- Cache headers - For logged-in users, password-protected posts

**Supports:**
- 304 Not Modified for feeds
- Error status codes (403, 404, 500, 502, 503)
- No-cache headers where appropriate

**Filter:** `wp_headers` - Modify headers before sending

**Action:** `send_headers` - After headers sent

**Since:** 2.0.0

---

### handle_404()

Sets 404 status when appropriate.

```php
public function handle_404(): void
```

**Logic:**
- **Never 404:** Admin, robots.txt, favicon.ico
- **Not 404:** Posts found with valid pagination
- **Not 404:** Empty archives for valid objects (categories, authors, etc.)
- **404:** No posts found for invalid requests

**Filter:** `pre_handle_404` - Short-circuit handling

**Since:** 2.0.0

---

### register_globals()

Exports query variables to global scope.

```php
public function register_globals(): void
```

**Globals Set:**
- Each query var as `$GLOBALS[$key]`
- `$query_string`
- `$posts` (reference to WP_Query posts)
- `$post` (current post)
- `$request` (SQL query)
- `$more` (for single posts/pages)
- `$single` (for single posts/pages)
- `$authordata` (for author archives)

**Since:** 2.0.0

---

### add_query_var()

Adds a public query variable.

```php
public function add_query_var( string $qv ): void
```

**Parameters:**
- `$qv` - Query variable name

**Since:** 2.1.0

---

### remove_query_var()

Removes a public query variable.

```php
public function remove_query_var( string $name ): void
```

**Since:** 4.5.0

---

### set_query_var()

Sets a query variable value.

```php
public function set_query_var( string $key, mixed $value ): void
```

**Since:** 2.3.0

---

## Usage Example

```php
// WordPress core instantiation (in wp-includes/class-wp.php)
global $wp;

// In wp-blog-header.php or similar
$wp = new WP();

// Process the request
$wp->main();

// After main(), you can access:
echo $wp->request;           // e.g., '2024/01/hello-world'
echo $wp->matched_rule;      // e.g., '([0-9]{4})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$'
print_r( $wp->query_vars );  // ['year' => '2024', 'monthnum' => '01', 'name' => 'hello-world']
```

## Request Parsing Flow

```
URL: https://example.com/2024/01/hello-world/

1. parse_request() called

2. Strip home path from URL
   Request: '2024/01/hello-world'

3. Match against rewrite rules
   Matched: '([0-9]{4})/([0-9]{1,2})/([^/]+)(?:/([0-9]+))?/?$'
   
4. Extract matches
   $matches = ['2024/01/hello-world', '2024', '01', 'hello-world']

5. Apply to rule's query
   'year=$matches[1]&monthnum=$matches[2]&name=$matches[3]'
   → 'year=2024&monthnum=01&name=hello-world'

6. Parse into query_vars
   $this->query_vars = [
       'year' => '2024',
       'monthnum' => '01',
       'name' => 'hello-world'
   ]
```

## Public vs Private Query Vars

**Public Query Variables:**
- Accepted from URL parameters (`$_GET`, `$_POST`)
- Can be added via `query_vars` filter
- Used for permalink structures

**Private Query Variables:**
- Only accepted from `extra_query_vars` (code-supplied)
- Security measure - prevents users from manipulating internal queries
- Examples: `posts_per_page`, `post_status`, `perm`

## Integration with WP_Query

The `WP` class prepares query variables, then passes them to `WP_Query`:

```php
// In query_posts()
global $wp_the_query;
$wp_the_query->query( $this->query_vars );

// WP_Query then:
// 1. Parses the query vars
// 2. Builds SQL query
// 3. Executes query
// 4. Sets up post data
```

## Hooks Reference

| Hook | Type | Purpose |
|------|------|---------|
| `do_parse_request` | Filter | Short-circuit request parsing |
| `query_vars` | Filter | Modify allowed public query vars |
| `request` | Filter | Modify parsed query vars |
| `parse_request` | Action | After request is parsed |
| `wp_headers` | Filter | Modify HTTP headers |
| `send_headers` | Action | After headers sent |
| `pre_handle_404` | Filter | Short-circuit 404 handling |
| `wp` | Action | After environment fully set up |
