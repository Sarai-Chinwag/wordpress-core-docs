# WordPress Feed Functions

## Feed Consumption

### fetch_feed()

Builds a SimplePie object from an RSS or Atom feed URL.

```php
function fetch_feed( string|array $url ): SimplePie\SimplePie|WP_Error
```

**Parameters:**
- `$url` - URL of feed to retrieve, or array of URLs for merged multifeed

**Returns:** `SimplePie\SimplePie` on success, `WP_Error` on failure

**Example:**
```php
$feed = fetch_feed( 'https://example.com/feed/' );

if ( is_wp_error( $feed ) ) {
    echo 'Error: ' . $feed->get_error_message();
    return;
}

$items = $feed->get_items( 0, 5 ); // Get first 5 items

foreach ( $items as $item ) {
    echo $item->get_title() . "\n";
    echo $item->get_permalink() . "\n";
    echo $item->get_date( 'Y-m-d' ) . "\n";
}
```

**Multifeed Example:**
```php
$feeds = fetch_feed( array(
    'https://example.com/feed/',
    'https://another.com/rss/',
) );

// Items from both feeds are merged and sorted by date
$items = $feeds->get_items();
```

**Notes:**
- Caches for 12 hours by default (filterable via `wp_feed_cache_transient_lifetime`)
- Uses WordPress HTTP API for requests
- Content sanitized via KSES

---

## Blog Information (Feed Context)

### get_bloginfo_rss()

Retrieves blog information with feed-safe encoding.

```php
function get_bloginfo_rss( string $show = '' ): string
```

**Parameters:**
- `$show` - Same values as `get_bloginfo()` (name, description, url, etc.)

**Returns:** Stripped and character-converted blog info

**Example:**
```php
$site_name = get_bloginfo_rss( 'name' );
$site_url  = get_bloginfo_rss( 'url' );
```

### bloginfo_rss()

Displays blog information for feeds.

```php
function bloginfo_rss( string $show = '' ): void
```

---

## Feed Configuration

### get_default_feed()

Returns the default feed type.

```php
function get_default_feed(): string
```

**Returns:** Default feed type (default: `'rss2'`)

**Example:**
```php
$default = get_default_feed(); // 'rss2'
```

### feed_content_type()

Returns the appropriate Content-Type header for a feed type.

```php
function feed_content_type( string $type = '' ): string
```

**Parameters:**
- `$type` - Feed type: `'rss'`, `'rss2'`, `'atom'`, `'rdf'`

**Returns:** MIME type string

| Type | Content-Type |
|------|-------------|
| `rss` | `application/rss+xml` |
| `rss2` | `application/rss+xml` |
| `atom` | `application/atom+xml` |
| `rdf` | `application/rdf+xml` |
| `rss-http` | `text/xml` |

---

## Title Functions

### get_wp_title_rss()

Retrieves the blog title for the feed title element.

```php
function get_wp_title_rss( string $deprecated = '&#8211;' ): string
```

**Returns:** Document title via `wp_get_document_title()`

### wp_title_rss()

Displays the blog title for feeds.

```php
function wp_title_rss( string $deprecated = '&#8211;' ): void
```

### get_the_title_rss()

Retrieves the current post title for feeds.

```php
function get_the_title_rss( int|WP_Post $post = 0 ): string
```

**Parameters:**
- `$post` - Post ID or object (default: global `$post`)

**Returns:** Filtered post title

### the_title_rss()

Displays the post title in the feed.

```php
function the_title_rss(): void
```

---

## Content Functions

### get_the_content_feed()

Retrieves post content formatted for feeds.

```php
function get_the_content_feed( string $feed_type = null ): string
```

**Parameters:**
- `$feed_type` - Feed type: `'rss2'`, `'atom'`, `'rss'`, `'rdf'`

**Returns:** Content with `the_content` filter applied, `]]>` escaped

### the_content_feed()

Displays post content for feeds.

```php
function the_content_feed( string $feed_type = null ): void
```

### the_excerpt_rss()

Displays the post excerpt for feeds.

```php
function the_excerpt_rss(): void
```

---

## Link Functions

### the_permalink_rss()

Displays the permalink for use in feeds.

```php
function the_permalink_rss(): void
```

### comments_link_feed()

Outputs the comments link in an XML-safe way.

```php
function comments_link_feed(): void
```

### get_self_link()

Returns the current feed's self-reference URL.

```php
function get_self_link(): string
```

**Returns:** Full URL for atom:self element

### self_link()

Displays the current feed URL (escaped).

```php
function self_link(): void
```

---

## Category Functions

### get_the_category_rss()

Retrieves all post categories and tags formatted for feeds.

```php
function get_the_category_rss( string $type = null ): string
```

**Parameters:**
- `$type` - Feed type: `'rss2'`, `'atom'`, `'rdf'`

**Returns:** Formatted category/tag XML

**Output by Type:**

RSS 2.0:
```xml
<category><![CDATA[Category Name]]></category>
```

Atom:
```xml
<category scheme="https://example.com" term="Category Name" />
```

RDF:
```xml
<dc:subject><![CDATA[Category Name]]></dc:subject>
```

### the_category_rss()

Displays post categories in the feed.

```php
function the_category_rss( string $type = null ): void
```

---

## Comment Functions

### get_comment_author_rss()

Retrieves the comment author for feeds.

```php
function get_comment_author_rss(): string
```

### comment_author_rss()

Displays the comment author in feeds.

```php
function comment_author_rss(): void
```

### comment_text_rss()

Displays the comment content for feeds.

```php
function comment_text_rss(): void
```

### comment_guid()

Displays the feed GUID for the current comment.

```php
function comment_guid( int|WP_Comment $comment_id = null ): void
```

### get_comment_guid()

Retrieves the feed GUID for a comment.

```php
function get_comment_guid( int|WP_Comment $comment_id = null ): string|false
```

**Returns:** GUID in format `{post_guid}#comment-{comment_id}`, or false on failure

### comment_link()

Displays the comment permalink.

```php
function comment_link( int|WP_Comment $comment = null ): void
```

---

## Enclosure Functions

### rss_enclosure()

Displays RSS 2.0 enclosure elements for the current post.

```php
function rss_enclosure(): void
```

**Output:**
```xml
<enclosure url="..." length="..." type="audio/mpeg" />
```

**Notes:**
- Reads from `enclosure` post meta
- Skipped for password-protected posts

### atom_enclosure()

Displays Atom enclosure elements for the current post.

```php
function atom_enclosure(): void
```

**Output:**
```xml
<link href="..." rel="enclosure" length="..." type="audio/mpeg" />
```

---

## Site Icon Functions

### rss2_site_icon()

Displays the site icon in RSS 2.0 feeds.

```php
function rss2_site_icon(): void
```

**Output:**
```xml
<image>
    <url>https://example.com/icon.png</url>
    <title>Site Name</title>
    <link>https://example.com</link>
    <width>32</width>
    <height>32</height>
</image>
```

### atom_site_icon()

Displays the site icon in Atom feeds.

```php
function atom_site_icon(): void
```

**Output:**
```xml
<icon>https://example.com/icon.png</icon>
```

---

## Date Functions

### get_feed_build_date()

Returns the UTC time of the most recently modified post in WP_Query.

```php
function get_feed_build_date( string $format ): string|false
```

**Parameters:**
- `$format` - PHP date format string

**Returns:** Formatted date or false on failure

**Example:**
```php
// RFC 2822 (for RSS)
echo get_feed_build_date( 'r' );
// Output: Mon, 09 Feb 2026 05:48:00 +0000

// ISO 8601 (for Atom)
echo get_feed_build_date( 'Y-m-d\TH:i:s\Z' );
// Output: 2026-02-09T05:48:00Z
```

---

## Utility Functions

### html_type_rss()

Displays 'xhtml' or 'html' based on blog settings.

```php
function html_type_rss(): void
```

### prep_atom_text_construct()

Determines text type and formats data for Atom feeds (RFC 4287 Section 3.1).

```php
function prep_atom_text_construct( string $data ): array
```

**Returns:** `array( $type, $value )` where type is `'text'`, `'html'`, or `'xhtml'`

**Example:**
```php
list( $type, $value ) = prep_atom_text_construct( $content );
echo "<content type=\"$type\">$value</content>";
```

---

## Cache Classes

### WP_Feed_Cache_Transient

Implements feed caching using WordPress transients.

```php
class WP_Feed_Cache_Transient implements SimplePie\Cache\Base {
    public string $name;          // Transient name: feed_{hash}
    public string $mod_name;      // Mod time name: feed_mod_{hash}
    public int    $lifetime = 43200; // 12 hours
    
    public function save( $data ): bool;   // Store feed data
    public function load(): array;         // Retrieve cached data
    public function mtime(): int;          // Get modification timestamp
    public function touch(): bool;         // Update modification time
    public function unlink(): bool;        // Delete cache
}
```

### WP_SimplePie_File

Fetches remote feeds using WordPress HTTP API.

```php
class WP_SimplePie_File extends SimplePie\File {
    public int $timeout = 10;  // Connection timeout in seconds
    
    public function __construct(
        string $url,
        int $timeout = 10,
        int $redirects = 5,
        string|array $headers = null,
        string $useragent = null,
        bool $force_fsockopen = false
    );
}
```

### WP_SimplePie_Sanitize_KSES

Sanitizes feed content using WordPress KSES.

```php
class WP_SimplePie_Sanitize_KSES extends SimplePie\Sanitize {
    public function sanitize( 
        mixed $data, 
        int $type, 
        string $base = '' 
    ): mixed;
}
```
