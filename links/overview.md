# WordPress Links & URL API Overview

WordPress provides a comprehensive URL generation system that handles permalinks, site URLs, admin URLs, and canonical URL management. The system is flexible, supporting both "pretty permalinks" and query-string-based URLs.

## Core Concepts

### URL Types

WordPress distinguishes between several URL types:

| URL Type | Function | Purpose |
|----------|----------|---------|
| **Home URL** | `home_url()` | Front-end site address (where visitors see content) |
| **Site URL** | `site_url()` | WordPress installation address (where files live) |
| **Admin URL** | `admin_url()` | WordPress admin dashboard |
| **Content URL** | `content_url()` | wp-content directory |
| **Plugins URL** | `plugins_url()` | Plugins directory |
| **Includes URL** | `includes_url()` | wp-includes directory |

### Permalink Structure

Permalinks are the permanent URLs to posts, pages, and archives. WordPress supports:

- **Plain**: `?p=123`
- **Day and name**: `/2024/02/09/sample-post/`
- **Month and name**: `/2024/02/sample-post/`
- **Numeric**: `/archives/123`
- **Post name**: `/sample-post/`
- **Custom structure**: Using rewrite tags like `%postname%`, `%category%`, `%author%`

### URL Scheme Handling

The `set_url_scheme()` function normalizes URLs to use the correct protocol:

```php
// Forces HTTPS
set_url_scheme( $url, 'https' );

// Uses current scheme (respects is_ssl())
set_url_scheme( $url );

// Relative URL (strips protocol and host)
set_url_scheme( $url, 'relative' );
```

## Primary Source Files

| File | Purpose |
|------|---------|
| `link-template.php` | Main URL generation functions (4900+ lines) |
| `canonical.php` | Canonical URL redirect handling |
| `bookmark.php` | Legacy links/blogroll management |

## URL Generation Architecture

### Post Permalinks

```
get_permalink( $post )
    ├── get_page_link()      → For pages
    ├── get_attachment_link() → For attachments  
    └── get_post_permalink() → For custom post types
```

### Archive Permalinks

```
Archive URLs
    ├── get_year_link()          → /2024/
    ├── get_month_link()         → /2024/02/
    ├── get_day_link()           → /2024/02/09/
    ├── get_term_link()          → /category/news/
    ├── get_author_posts_url()   → /author/admin/
    └── get_post_type_archive_link() → /books/
```

### Feed URLs

```
Feed URLs
    ├── get_feed_link()               → Main site feed
    ├── get_post_comments_feed_link() → Post comments feed
    ├── get_author_feed_link()        → Author posts feed
    ├── get_category_feed_link()      → Category feed
    └── get_tag_feed_link()           → Tag feed
```

## Canonical URLs

Canonical URLs prevent duplicate content issues by redirecting to the "correct" URL version:

### How `redirect_canonical()` Works

1. **Builds requested URL** from `$_SERVER` variables
2. **Determines correct URL** based on query type (single, archive, etc.)
3. **Handles edge cases**:
   - www vs non-www normalization
   - Trailing slash consistency
   - Query parameter cleanup
   - Pagination handling
4. **Issues 301 redirect** if URLs differ

### SEO Implications

- Consolidates link equity to canonical URL
- Prevents penalty for duplicate content
- Normalizes URL variations

## Legacy Bookmarks (Links Manager)

The Bookmarks API manages external links (formerly "blogroll"). Disabled by default since WordPress 3.5 but still functional.

### Link Data Structure

```php
object(stdClass) {
    link_id          // Unique ID
    link_url         // The URL
    link_name        // Display name
    link_image       // Optional image URL
    link_target      // _blank, _top, or empty
    link_description // Description text
    link_visible     // Y or N
    link_owner       // User ID who created
    link_rating      // 0-10 rating
    link_updated     // Last update timestamp
    link_rel         // Relationship (XFN)
    link_notes       // Private notes
    link_rss         // RSS feed URL
    link_category    // Array of category IDs
}
```

## Trailing Slashes

WordPress handles trailing slashes via `user_trailingslashit()`:

```php
// Adds or removes trailing slash based on permalink settings
$url = user_trailingslashit( $url, 'single' );
```

The `$type_of_url` parameter allows different handling for:
- `single` - Single posts
- `page` - Pages
- `category` - Category archives
- `home` - Home page
- `feed` - Feeds
- `paged` - Paginated archives

## Multisite URL Functions

For multisite installations:

| Function | Purpose |
|----------|---------|
| `network_home_url()` | Network home URL |
| `network_site_url()` | Network site URL |
| `network_admin_url()` | Network admin URL |
| `get_home_url( $blog_id )` | Specific site home URL |
| `get_admin_url( $blog_id )` | Specific site admin URL |

## Shortlinks

WordPress provides a shortlink system for sharing:

```php
// Get shortlink for current post
$shortlink = wp_get_shortlink();

// Default format: ?p=123
// Can be filtered for custom shorteners
```

The shortlink is:
- Added to `<head>` via `wp_shortlink_wp_head()`
- Sent as HTTP header via `wp_shortlink_header()`

## Common Patterns

### Getting the Current Page URL

```php
// For posts/pages
$url = get_permalink();

// For archives
$url = get_term_link( $term );

// For search results
$url = get_search_link( $query );
```

### Building Admin URLs

```php
// Edit post screen
$url = get_edit_post_link( $post_id );

// Custom admin page
$url = admin_url( 'admin.php?page=my-plugin' );

// User profile
$url = get_edit_user_link( $user_id );
```

### Navigation Links

```php
// Previous/Next post
$prev = get_previous_post_link();
$next = get_next_post_link();

// Pagination
$links = paginate_links( $args );
```

## Best Practices

1. **Use URL functions** instead of hardcoding paths
2. **Escape URLs** with `esc_url()` before output
3. **Respect permalink structure** - use built-in functions
4. **Use relative URLs** when appropriate for portability
5. **Filter URLs** only when necessary; prefer built-in hooks
