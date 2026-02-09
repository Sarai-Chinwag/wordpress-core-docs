# WP_Rewrite Class

Core class implementing the WordPress rewrite component API. Handles permalink structures, rewrite rules, and URL pattern matching.

```php
class WP_Rewrite {
    // ...
}
```

## Overview

The `WP_Rewrite` class:

- Writes mod_rewrite rules to `.htaccess` (Apache) or `web.config` (IIS)
- Parses requests to set up the WordPress Query
- Acts as a front controller alongside the `WP` class
- Allows adding custom URL patterns via hooks and methods

**Global Instance:**

```php
global $wp_rewrite;
```

## Properties

### Permalink Structure Properties

#### $permalink_structure

```php
public string $permalink_structure
```

The permalink structure for posts. Read from `get_option('permalink_structure')`.

**Examples:**
- `/%postname%/`
- `/%year%/%monthnum%/%postname%/`
- Empty string for plain permalinks

---

#### $use_trailing_slashes

```php
public bool $use_trailing_slashes
```

Whether to add trailing slashes to URLs. Determined by whether `$permalink_structure` ends with `/`.

---

#### $front

```php
public string $front
```

The static portion of the post permalink structure before the first `%tag%`.

**Examples:**
- Permalink `/blog/%postname%/` → front is `/blog/`
- Permalink `/%postname%/` → front is `/`

---

#### $root

```php
public string $root = ''
```

The prefix for all permalink structures. Empty for mod_rewrite, `index.php/` for PATHINFO permalinks.

---

#### $index

```php
public string $index = 'index.php'
```

The name of the index file which is the entry point to all requests.

---

### Base Properties

#### $author_base

```php
public string $author_base = 'author'
```

Base for author permalink structure (`example.com/author/username`).

---

#### $search_base

```php
public string $search_base = 'search'
```

Base for search permalink structure (`example.com/search/query`).

---

#### $comments_base

```php
public string $comments_base = 'comments'
```

Base for comments permalink.

---

#### $pagination_base

```php
public string $pagination_base = 'page'
```

Base for pagination (`example.com/page/2`).

**Since:** 3.1.0

---

#### $comments_pagination_base

```php
public string $comments_pagination_base = 'comment-page'
```

Base for comments pagination (`example.com/post/comment-page-2`).

**Since:** 4.2.0

---

#### $feed_base

```php
public string $feed_base = 'feed'
```

Base for feed URLs (`example.com/feed/rss2`).

---

### Structure Properties

#### $author_structure

```php
public string $author_structure
```

Permalink structure for author archives. Built as `$front . $author_base . '/%author%'`.

---

#### $date_structure

```php
public string $date_structure
```

Permalink structure for date archives. Typically `%year%/%monthnum%/%day%`.

---

#### $page_structure

```php
public string $page_structure
```

Permalink structure for pages. Built as `$root . '%pagename%'`.

---

#### $search_structure

```php
public string $search_structure
```

Permalink structure for searches. Built as `$root . $search_base . '/%search%'`.

---

#### $feed_structure

```php
public string $feed_structure
```

Feed request permalink structure.

---

#### $comment_feed_structure

```php
public string $comment_feed_structure
```

Comments feed permalink structure.

---

### Rewrite Tag Properties

#### $rewritecode

```php
public string[] $rewritecode = array(
    '%year%',
    '%monthnum%',
    '%day%',
    '%hour%',
    '%minute%',
    '%second%',
    '%postname%',
    '%post_id%',
    '%author%',
    '%pagename%',
    '%search%',
)
```

Rewrite tags that can be used in permalink structures.

---

#### $rewritereplace

```php
public string[] $rewritereplace = array(
    '([0-9]{4})',
    '([0-9]{1,2})',
    '([0-9]{1,2})',
    '([0-9]{1,2})',
    '([0-9]{1,2})',
    '([0-9]{1,2})',
    '([^/]+)',
    '([0-9]+)',
    '([^/]+)',
    '([^/]+?)',
    '(.+)',
)
```

Regular expressions substituted for rewrite tags. Parallel array to `$rewritecode`.

---

#### $queryreplace

```php
public string[] $queryreplace = array(
    'year=',
    'monthnum=',
    'day=',
    'hour=',
    'minute=',
    'second=',
    'name=',
    'p=',
    'author_name=',
    'pagename=',
    's=',
)
```

Query variables that rewrite tags map to. Parallel array to `$rewritecode`.

---

### Rules Properties

#### $rules

```php
public string[] $rules
```

Compiled rewrite rules to match against requests. Keys are regex patterns, values are query strings.

---

#### $extra_rules

```php
public string[] $extra_rules = array()
```

Additional rules added externally (at bottom priority) via `add_rewrite_rule()`.

---

#### $extra_rules_top

```php
public string[] $extra_rules_top = array()
```

Additional rules that belong at the beginning (top priority) via `add_rewrite_rule($regex, $query, 'top')`.

**Since:** 2.3.0

---

#### $non_wp_rules

```php
public string[] $non_wp_rules = array()
```

Rules that don't redirect to WordPress's `index.php`. Written directly to `.htaccess` via `add_external_rule()`.

---

#### $extra_permastructs

```php
public array[] $extra_permastructs = array()
```

Extra permalink structures added via `add_permastruct()`. Used for custom post types and taxonomies.

---

#### $endpoints

```php
public array[] $endpoints
```

Endpoints (like `/trackback/`) added via `add_rewrite_endpoint()`.

---

### Configuration Properties

#### $matches

```php
public string $matches = ''
```

Variable name for regex matches in the rewritten query. When set, references become `$matches[N]` instead of `$N`.

---

#### $feeds

```php
public string[] $feeds = array( 'feed', 'rdf', 'rss', 'rss2', 'atom' )
```

Supported default feed types.

---

#### $use_verbose_rules

```php
public bool $use_verbose_rules = false
```

Whether to write every mod_rewrite rule to `.htaccess`. Off by default to keep the file small.

---

#### $use_verbose_page_rules

```php
public bool $use_verbose_page_rules = true
```

Whether post permalinks could be confused with page permalinks. Set to true when permalink structure starts with `%postname%`, `%category%`, `%tag%`, or `%author%`.

**Since:** 2.5.0

---

## Methods

### Permalink Detection Methods

#### using_permalinks()

```php
public function using_permalinks(): bool
```

Determines whether permalinks are being used.

**Returns:** `true` if `$permalink_structure` is not empty.

```php
global $wp_rewrite;
if ( $wp_rewrite->using_permalinks() ) {
    // Pretty permalinks enabled
}
```

---

#### using_index_permalinks()

```php
public function using_index_permalinks(): bool
```

Determines whether PATHINFO permalinks are in use (index.php is in the URL).

**Returns:** `true` if permalinks enabled AND `index.php` is in the structure.

```php
// Check for PATHINFO/index permalinks
if ( $wp_rewrite->using_index_permalinks() ) {
    // URLs like /index.php/post-name/
}
```

---

#### using_mod_rewrite_permalinks()

```php
public function using_mod_rewrite_permalinks(): bool
```

Determines whether mod_rewrite permalinks are in use (index.php NOT in URL).

**Returns:** `true` if using permalinks AND NOT using index permalinks.

```php
if ( $wp_rewrite->using_mod_rewrite_permalinks() ) {
    // Clean URLs like /post-name/
}
```

---

### Structure Retrieval Methods

#### get_date_permastruct()

```php
public function get_date_permastruct(): string|false
```

Retrieves the date permalink structure with year, month, and day.

**Returns:** Date permalink structure or `false` if no permalinks.

Supports three date formats:
- `%year%/%monthnum%/%day%` (default)
- `%day%/%monthnum%/%year%`
- `%monthnum%/%day%/%year%`

---

#### get_year_permastruct()

```php
public function get_year_permastruct(): string|false
```

Retrieves the year-only permalink structure.

**Returns:** Year structure (e.g., `/%year%/`) or `false`.

---

#### get_month_permastruct()

```php
public function get_month_permastruct(): string|false
```

Retrieves the year/month permalink structure.

**Returns:** Month structure (e.g., `/%year%/%monthnum%/`) or `false`.

---

#### get_day_permastruct()

```php
public function get_day_permastruct(): string|false
```

Retrieves the full date permalink structure. Same as `get_date_permastruct()`.

**Returns:** Day structure or `false`.

---

#### get_author_permastruct()

```php
public function get_author_permastruct(): string|false
```

Retrieves the author permalink structure.

**Returns:** Author structure (e.g., `/author/%author%`) or `false`.

---

#### get_search_permastruct()

```php
public function get_search_permastruct(): string|false
```

Retrieves the search permalink structure.

**Returns:** Search structure (e.g., `/search/%search%`) or `false`.

---

#### get_page_permastruct()

```php
public function get_page_permastruct(): string|false
```

Retrieves the page permalink structure.

**Returns:** Page structure (e.g., `%pagename%`) or `false`.

---

#### get_feed_permastruct()

```php
public function get_feed_permastruct(): string|false
```

Retrieves the feed permalink structure.

**Returns:** Feed structure (e.g., `/feed/%feed%`) or `false`.

---

#### get_comment_feed_permastruct()

```php
public function get_comment_feed_permastruct(): string|false
```

Retrieves the comment feed permalink structure.

**Returns:** Comment feed structure or `false`.

---

#### get_category_permastruct()

```php
public function get_category_permastruct(): string|false
```

Retrieves the category permalink structure.

**Returns:** Category structure or `false`.

---

#### get_tag_permastruct()

```php
public function get_tag_permastruct(): string|false
```

Retrieves the tag permalink structure.

**Returns:** Tag structure or `false`.

**Since:** 2.3.0

---

#### get_extra_permastruct()

```php
public function get_extra_permastruct( string $name ): string|false
```

Retrieves an extra permalink structure by name.

**Parameters:**
- `$name` - Permalink structure name (e.g., 'category', 'post_tag', or custom)

**Returns:** Permalink structure string or `false`.

```php
$struct = $wp_rewrite->get_extra_permastruct( 'product' );
```

**Since:** 2.5.0

---

### Rewrite Tag Methods

#### add_rewrite_tag()

```php
public function add_rewrite_tag( string $tag, string $regex, string $query )
```

Adds or updates a rewrite tag.

**Parameters:**
- `$tag` - Name of the rewrite tag (e.g., `%postname%`)
- `$regex` - Regular expression to match
- `$query` - Query string parameter (must end with `=`)

```php
$wp_rewrite->add_rewrite_tag( '%product%', '([^/]+)', 'product=' );
```

---

#### remove_rewrite_tag()

```php
public function remove_rewrite_tag( string $tag )
```

Removes an existing rewrite tag.

**Parameters:**
- `$tag` - Name of the rewrite tag to remove

**Since:** 4.5.0

---

### Rule Generation Methods

#### generate_rewrite_rules()

```php
public function generate_rewrite_rules(
    string $permalink_structure,
    int $ep_mask = EP_NONE,
    bool $paged = true,
    bool $feed = true,
    bool $forcomments = false,
    bool $walk_dirs = true,
    bool $endpoints = true
): string[]
```

Generates rewrite rules from a permalink structure.

**Parameters:**
- `$permalink_structure` - The permalink structure
- `$ep_mask` - Endpoint mask (EP_* constants)
- `$paged` - Add pagination rules
- `$feed` - Add feed rules
- `$forcomments` - Make feeds comment feeds
- `$walk_dirs` - Build rules for each directory level
- `$endpoints` - Apply endpoints to generated rules

**Returns:** Array of rewrite rules keyed by regex pattern.

```php
$rules = $wp_rewrite->generate_rewrite_rules(
    '/products/%product%/',
    EP_PERMALINK,
    true,
    true,
    false,
    true,
    true
);
```

---

#### generate_rewrite_rule()

```php
public function generate_rewrite_rule( string $permalink_structure, bool $walk_dirs = false ): array
```

Shorthand for `generate_rewrite_rules()` with minimal options.

**Parameters:**
- `$permalink_structure` - The permalink structure
- `$walk_dirs` - Whether to walk directories

**Returns:** Array of rewrite rules.

---

#### rewrite_rules()

```php
public function rewrite_rules(): string[]
```

Constructs all rewrite rules from permalink structures. Called during rule regeneration.

**Returns:** Associative array of regex patterns to query strings.

**Fires:**
- `generate_rewrite_rules` action
- `rewrite_rules_array` filter

---

#### wp_rewrite_rules()

```php
public function wp_rewrite_rules(): string[]
```

Retrieves cached rewrite rules from the database, regenerating if needed.

**Returns:** Array of rewrite rules keyed by regex pattern.

```php
$rules = $wp_rewrite->wp_rewrite_rules();
foreach ( $rules as $pattern => $query ) {
    echo "$pattern => $query\n";
}
```

---

#### page_rewrite_rules()

```php
public function page_rewrite_rules(): string[]
```

Retrieves all rewrite rules for pages.

**Returns:** Page rewrite rules array.

---

### Rule Addition Methods

#### add_rule()

```php
public function add_rule( string $regex, string|array $query, string $after = 'bottom' )
```

Adds a rewrite rule.

**Parameters:**
- `$regex` - Regular expression to match
- `$query` - Query string or array of query vars
- `$after` - Priority: 'top' or 'bottom'

```php
$wp_rewrite->add_rule(
    '^custom/([^/]+)/?$',
    'index.php?custom=$matches[1]',
    'top'
);
```

**Since:** 2.1.0 (array support in 4.4.0)

---

#### add_external_rule()

```php
public function add_external_rule( string $regex, string $query )
```

Adds a rewrite rule that doesn't correspond to `index.php`.

**Parameters:**
- `$regex` - Regular expression to match
- `$query` - External destination

```php
// Redirect to external script
$wp_rewrite->add_external_rule( '^api/v1/(.*)$', 'api/handler.php?route=$1' );
```

---

#### add_endpoint()

```php
public function add_endpoint( string $name, int $places, string|bool $query_var = true )
```

Adds an endpoint.

**Parameters:**
- `$name` - Endpoint name
- `$places` - Endpoint mask (EP_* constants)
- `$query_var` - Query variable name, or `false` to skip registration

**Since:** 2.1.0 (query_var support in 3.9.0/4.3.0)

---

#### add_permastruct()

```php
public function add_permastruct( string $name, string $struct, array $args = array() )
```

Adds a new permalink structure.

**Parameters:**
- `$name` - Name for the permastruct
- `$struct` - Permalink structure
- `$args` - Options array (with_front, ep_mask, paged, feed, forcomments, walk_dirs, endpoints)

**Since:** 2.5.0

---

#### remove_permastruct()

```php
public function remove_permastruct( string $name )
```

Removes a permalink structure.

**Parameters:**
- `$name` - Name of the permastruct to remove

**Since:** 4.5.0

---

### Server Configuration Methods

#### mod_rewrite_rules()

```php
public function mod_rewrite_rules(): string
```

Retrieves mod_rewrite-formatted rules for `.htaccess`.

**Returns:** Apache mod_rewrite rules string.

**Filters:** `mod_rewrite_rules`

---

#### iis7_url_rewrite_rules()

```php
public function iis7_url_rewrite_rules( bool $add_parent_tags = false ): string
```

Retrieves IIS7 URL Rewrite formatted rules for `web.config`.

**Parameters:**
- `$add_parent_tags` - Whether to wrap rules in parent XML tags

**Returns:** IIS7 rewrite rules string.

**Filters:** `iis7_url_rewrite_rules`

**Since:** 2.8.0

---

### Flush and Initialization Methods

#### flush_rules()

```php
public function flush_rules( bool $hard = true )
```

Removes and recreates rewrite rules.

**Parameters:**
- `$hard` - Update `.htaccess`/`web.config` (true) or just database (false)

**Filters:** `flush_rewrite_rules_hard`

**Since:** 2.0.1

---

#### init()

```php
public function init()
```

Sets up the object's properties from options. Called automatically by constructor and after option changes.

---

#### set_permalink_structure()

```php
public function set_permalink_structure( string $permalink_structure )
```

Sets the main permalink structure for the site.

**Parameters:**
- `$permalink_structure` - New permalink structure

**Fires:** `permalink_structure_changed` action

---

#### set_category_base()

```php
public function set_category_base( string $category_base )
```

Sets the category base for category permalinks.

**Parameters:**
- `$category_base` - Category permalink base

---

#### set_tag_base()

```php
public function set_tag_base( string $tag_base )
```

Sets the tag base for tag permalinks.

**Parameters:**
- `$tag_base` - Tag permalink base

**Since:** 2.3.0

---

### Utility Methods

#### preg_index()

```php
public function preg_index( int $number ): string
```

Creates match index strings for use in preg_* functions.

**Parameters:**
- `$number` - Index number

**Returns:** Match reference like `$1` or `$matches[1]`

```php
$index = $wp_rewrite->preg_index( 2 ); // Returns '$2' or '$matches[2]'
```

---

#### page_uri_index()

```php
public function page_uri_index(): array
```

Retrieves all pages and attachments for page URIs.

**Returns:** Array with two elements:
1. Page URIs (uri => ID)
2. Page attachment URIs (uri => ID)

**Since:** 2.5.0

---

### Constructor

#### __construct()

```php
public function __construct()
```

Constructor. Calls `init()` to run setup.

**Since:** 1.5.0

---

## Usage Examples

### Check Permalink Configuration

```php
global $wp_rewrite;

// Get current structure
$structure = $wp_rewrite->permalink_structure;

// Check permalink type
if ( ! $wp_rewrite->using_permalinks() ) {
    echo 'Plain permalinks (query strings)';
} elseif ( $wp_rewrite->using_index_permalinks() ) {
    echo 'PATHINFO permalinks (/index.php/...)';
} else {
    echo 'mod_rewrite permalinks (clean URLs)';
}
```

### Inspect Rewrite Rules

```php
global $wp_rewrite;

$rules = $wp_rewrite->wp_rewrite_rules();

foreach ( $rules as $pattern => $query ) {
    printf( "Pattern: %s\nQuery: %s\n\n", $pattern, $query );
}
```

### Add Custom Permastruct

```php
global $wp_rewrite;

// Add structure for products
$wp_rewrite->add_permastruct( 'product', 'shop/%product%', array(
    'with_front' => false,
    'ep_mask'    => EP_PERMALINK,
    'paged'      => false,
    'feed'       => true,
));

// Flush rules (only on activation!)
$wp_rewrite->flush_rules();
```

### Generate Rules for Custom Structure

```php
global $wp_rewrite;

$rules = $wp_rewrite->generate_rewrite_rules(
    '/events/%year%/%monthnum%/%event%/',
    EP_PERMALINK,
    true,  // paged
    true,  // feed
    false, // forcomments
    true,  // walk_dirs
    true   // endpoints
);

// Merge with extra_rules_top for priority
$wp_rewrite->extra_rules_top = array_merge( $wp_rewrite->extra_rules_top, $rules );
```
