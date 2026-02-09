# WordPress Links & URL Functions Reference

## Site URL Functions

### `home_url( $path = '', $scheme = null )`
Returns the URL for the site's front-end.

```php
home_url();                    // https://example.com
home_url( '/about/' );         // https://example.com/about/
home_url( '/', 'https' );      // Force HTTPS
home_url( '/', 'relative' );   // /
```

**Parameters:**
- `$path` (string) - Path relative to home URL
- `$scheme` (string|null) - 'http', 'https', 'relative', 'rest', or null

**Filter:** `home_url`

---

### `get_home_url( $blog_id = null, $path = '', $scheme = null )`
Returns home URL for a specific site (multisite-aware).

```php
get_home_url( 2, '/page/' );  // Home URL for site ID 2
```

---

### `site_url( $path = '', $scheme = null )`
Returns the URL where WordPress core files reside.

```php
site_url();                        // https://example.com
site_url( 'wp-login.php' );        // https://example.com/wp-login.php
site_url( '/wp-admin/', 'admin' ); // Respects force_ssl_admin()
```

**Note:** On most installs, `home_url()` and `site_url()` are identical. They differ when WordPress is installed in a subdirectory.

**Filter:** `site_url`

---

### `get_site_url( $blog_id = null, $path = '', $scheme = null )`
Multisite-aware version of `site_url()`.

---

### `admin_url( $path = '', $scheme = 'admin' )`
Returns URL to the admin area.

```php
admin_url();                          // https://example.com/wp-admin/
admin_url( 'edit.php' );              // https://example.com/wp-admin/edit.php
admin_url( 'post.php?action=edit&post=123' );
```

**Scheme options:**
- `'admin'` - Respects `force_ssl_admin()` and `is_ssl()`
- `'http'` - Force HTTP
- `'https'` - Force HTTPS

**Filter:** `admin_url`

---

### `get_admin_url( $blog_id = null, $path = '', $scheme = 'admin' )`
Multisite-aware version of `admin_url()`.

---

### `includes_url( $path = '', $scheme = null )`
Returns URL to the wp-includes directory.

```php
includes_url( 'js/jquery/jquery.min.js' );
```

**Filter:** `includes_url`

---

### `content_url( $path = '' )`
Returns URL to the wp-content directory.

```php
content_url( 'uploads/2024/02/image.jpg' );
```

**Filter:** `content_url`

---

### `plugins_url( $path = '', $plugin = '' )`
Returns URL to a plugin file or directory.

```php
// From within a plugin file:
plugins_url( 'assets/style.css', __FILE__ );
```

**Filter:** `plugins_url`

---

## Network/Multisite URL Functions

### `network_home_url( $path = '', $scheme = null )`
Returns the network home URL.

---

### `network_site_url( $path = '', $scheme = null )`
Returns the network site URL.

---

### `network_admin_url( $path = '', $scheme = 'admin' )`
Returns URL to network admin.

```php
network_admin_url( 'sites.php' );  // Network sites page
```

---

### `user_admin_url( $path = '', $scheme = 'admin' )`
Returns URL to user admin area.

---

### `self_admin_url( $path = '', $scheme = 'admin' )`
Returns context-aware admin URL (network, user, or site admin).

---

## Permalink Functions

### `get_permalink( $post = 0, $leavename = false )`
Returns the full permalink for a post.

```php
get_permalink();           // Current post
get_permalink( 123 );      // Post ID 123
get_permalink( $post );    // WP_Post object
```

**Parameters:**
- `$post` (int|WP_Post) - Post ID or object
- `$leavename` (bool) - Keep `%postname%` placeholder unreplaced

**Dispatches to:**
- `get_page_link()` for pages
- `get_attachment_link()` for attachments
- `get_post_permalink()` for custom post types

**Filter:** `post_link`

---

### `the_permalink( $post = 0 )`
Echoes the permalink (escaped).

---

### `get_the_permalink( $post = 0, $leavename = false )`
Alias for `get_permalink()`.

---

### `get_post_permalink( $post = 0, $leavename = false, $sample = false )`
Returns permalink for custom post types.

```php
get_post_permalink( $book_id );
```

**Filter:** `post_type_link`

---

### `get_page_link( $post = 0, $leavename = false, $sample = false )`
Returns permalink for a page, respecting front page settings.

**Filter:** `page_link`

---

### `get_attachment_link( $post = null, $leavename = false )`
Returns permalink for an attachment.

**Filter:** `attachment_link`

---

## Archive Permalink Functions

### `get_year_link( $year )`
Returns URL to year archive.

```php
get_year_link( 2024 );     // /2024/
get_year_link( false );    // Current year
```

**Filter:** `year_link`

---

### `get_month_link( $year, $month )`
Returns URL to month archive.

```php
get_month_link( 2024, 2 ); // /2024/02/
```

**Filter:** `month_link`

---

### `get_day_link( $year, $month, $day )`
Returns URL to day archive.

```php
get_day_link( 2024, 2, 9 ); // /2024/02/09/
```

**Filter:** `day_link`

---

### `get_post_type_archive_link( $post_type )`
Returns URL to post type archive.

```php
get_post_type_archive_link( 'book' );  // /books/
get_post_type_archive_link( 'post' );  // Blog page or home
```

**Returns:** `false` if post type doesn't exist or has no archive.

**Filter:** `post_type_archive_link`

---

## Taxonomy/Term Permalink Functions

### `get_term_link( $term, $taxonomy = '' )`
Returns permalink for a term.

```php
get_term_link( 15, 'category' );     // By ID
get_term_link( 'news', 'category' ); // By slug
get_term_link( $term_object );       // By object
```

**Returns:** URL string or `WP_Error` on failure.

---

### `get_category_link( $category )`
Returns permalink for a category (wrapper for `get_term_link()`).

---

### `get_tag_link( $tag )`
Returns permalink for a tag (wrapper for `get_term_link()`).

---

## Author URL Functions

### `get_author_posts_url( $author_id, $author_nicename = '' )`
Returns URL to author archive.

```php
get_author_posts_url( 1 );  // /author/admin/
```

**Filter:** `author_link`

---

## Feed URL Functions

### `get_feed_link( $feed = '' )`
Returns URL to the site feed.

```php
get_feed_link();           // Default feed
get_feed_link( 'rss2' );   // RSS 2.0
get_feed_link( 'atom' );   // Atom
```

**Filter:** `feed_link`

---

### `get_post_comments_feed_link( $post_id = 0, $feed = '' )`
Returns URL to a post's comments feed.

---

### `get_author_feed_link( $author_id, $feed = '' )`
Returns URL to an author's posts feed.

---

### `get_category_feed_link( $cat, $feed = '' )`
Returns URL to a category feed.

**Filter:** `category_feed_link`

---

### `get_tag_feed_link( $tag, $feed = '' )`
Returns URL to a tag feed.

**Filter:** `tag_feed_link`

---

### `get_term_feed_link( $term, $taxonomy = '', $feed = '' )`
Returns URL to a term feed.

---

### `get_post_type_archive_feed_link( $post_type, $feed = '' )`
Returns URL to post type archive feed.

---

## Search URL Functions

### `get_search_link( $query = '' )`
Returns URL for search results.

```php
get_search_link( 'hello world' );  // /?s=hello+world or /search/hello+world/
```

**Filter:** `search_link`

---

### `get_search_feed_link( $search_query = '', $feed = '' )`
Returns URL for search results feed.

---

## Edit Link Functions

### `get_edit_post_link( $post = 0, $context = 'display' )`
Returns URL to edit a post.

```php
get_edit_post_link( 123 );           // /wp-admin/post.php?post=123&action=edit
get_edit_post_link( 123, 'url' );    // Without HTML entity encoding
```

**Filter:** `get_edit_post_link`

---

### `edit_post_link( $text = null, $before = '', $after = '', $post = 0, $css_class = 'post-edit-link' )`
Outputs edit link with wrapper.

---

### `get_delete_post_link( $post = 0, $deprecated = '', $force_delete = false )`
Returns URL to delete/trash a post.

---

### `get_edit_term_link( $term, $taxonomy = '', $object_type = '' )`
Returns URL to edit a term.

**Filter:** `get_edit_term_link`

---

### `get_edit_comment_link( $comment_id = 0, $context = 'display' )`
Returns URL to edit a comment.

---

### `get_edit_user_link( $user_id = null )`
Returns URL to edit a user.

---

### `get_edit_bookmark_link( $link = 0 )`
Returns URL to edit a bookmark.

---

## Navigation Functions

### `get_previous_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Returns previous post object.

---

### `get_next_post( $in_same_term = false, $excluded_terms = '', $taxonomy = 'category' )`
Returns next post object.

---

### `get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' )`
Returns adjacent post (previous or next).

---

### `get_previous_post_link( $format = '&laquo; %link', $link = '%title', ... )`
Returns formatted previous post link.

---

### `get_next_post_link( $format = '%link &raquo;', $link = '%title', ... )`
Returns formatted next post link.

---

### `get_the_post_navigation( $args = array() )`
Returns navigation markup for previous/next posts.

---

### `get_the_posts_navigation( $args = array() )`
Returns navigation for previous/next set of posts (older/newer).

---

### `paginate_links( $args = '' )`
Returns paginated numeric links.

```php
echo paginate_links( array(
    'total'   => $total_pages,
    'current' => $current_page,
) );
```

---

## Shortlink Functions

### `wp_get_shortlink( $id = 0, $context = 'post', $allow_slugs = true )`
Returns shortlink for a post.

```php
wp_get_shortlink();      // Current post: ?p=123
wp_get_shortlink( 123 ); // Specific post
```

**Filters:** `pre_get_shortlink`, `get_shortlink`

---

### `the_shortlink( $text = '', $title = '', $before = '', $after = '' )`
Outputs shortlink anchor tag.

---

### `wp_shortlink_wp_head()`
Outputs `<link rel="shortlink">` in head.

---

### `wp_shortlink_header()`
Sends `Link: <shortlink>; rel=shortlink` HTTP header.

---

## Canonical URL Functions

### `wp_get_canonical_url( $post = null )`
Returns canonical URL for a post.

```php
wp_get_canonical_url();      // Current post
wp_get_canonical_url( 123 ); // Specific post
```

Handles pagination (page, cpage) automatically.

**Filter:** `get_canonical_url`

---

### `rel_canonical()`
Outputs `<link rel="canonical">` tag for singular pages.

---

### `redirect_canonical( $requested_url = null, $do_redirect = true )`
Redirects to canonical URL when needed.

**Filter:** `redirect_canonical` - Return false to cancel redirect.

---

### `redirect_guess_404_permalink()`
Attempts to guess correct URL for 404 pages.

**Filters:**
- `do_redirect_guess_404_permalink` - Enable/disable guessing
- `pre_redirect_guess_404_permalink` - Short-circuit with custom URL
- `strict_redirect_guess_404_permalink` - Exact match only

---

## Utility Functions

### `set_url_scheme( $url, $scheme = null )`
Sets URL scheme (protocol).

```php
set_url_scheme( $url, 'https' );    // Force HTTPS
set_url_scheme( $url, 'relative' ); // Strip scheme and host
set_url_scheme( $url, 'admin' );    // Respects force_ssl_admin()
```

**Scheme options:** `http`, `https`, `login`, `login_post`, `admin`, `relative`, `rest`, `rpc`

**Filter:** `set_url_scheme`

---

### `user_trailingslashit( $url, $type_of_url = '' )`
Adds or removes trailing slash based on permalink settings.

```php
user_trailingslashit( '/category/news', 'category' );
```

**Filter:** `user_trailingslashit`

---

### `wp_force_plain_post_permalink( $post = null, $sample = null )`
Determines if post should use plain `?p=` permalink.

Returns `true` for:
- Unpublished posts
- Private posts (unless user can read them)
- Invalid post types

---

### `get_dashboard_url( $user_id = 0, $path = '', $scheme = 'admin' )`
Returns dashboard URL for a user.

---

### `get_edit_profile_url( $user_id = 0, $scheme = 'admin' )`
Returns profile edit URL.

---

### `get_privacy_policy_url()`
Returns URL to privacy policy page.

**Filter:** `privacy_policy_url`

---

### `wp_is_internal_link( $link )`
Checks if URL is internal (same host).

```php
wp_is_internal_link( 'https://example.com/page' );  // true
wp_is_internal_link( 'https://other.com/page' );    // false
```

---

### `wp_internal_hosts()`
Returns array of internal hostnames.

**Filter:** `wp_internal_hosts`

---

## Bookmark (Links) Functions

### `get_bookmark( $bookmark, $output = OBJECT, $filter = 'raw' )`
Retrieves a single bookmark.

```php
$link = get_bookmark( 1 );
echo $link->link_url;
```

---

### `get_bookmark_field( $field, $bookmark, $context = 'display' )`
Retrieves a specific bookmark field.

---

### `get_bookmarks( $args = '' )`
Retrieves list of bookmarks.

```php
$links = get_bookmarks( array(
    'orderby'        => 'name',
    'order'          => 'ASC',
    'limit'          => 10,
    'category'       => '5,7',
    'hide_invisible' => 1,
    'search'         => 'blog',
) );
```

**Filter:** `get_bookmarks`

---

### `sanitize_bookmark( $bookmark, $context = 'display' )`
Sanitizes all bookmark fields.

---

### `sanitize_bookmark_field( $field, $value, $bookmark_id, $context )`
Sanitizes a single bookmark field.

**Contexts:** `raw`, `edit`, `db`, `display`, `attribute`, `js`

---

### `clean_bookmark_cache( $bookmark_id )`
Clears bookmark cache.

---

## Theme URL Functions

### `get_theme_file_uri( $file = '' )`
Returns URL to file in theme (checks child theme first).

```php
get_theme_file_uri( 'assets/js/app.js' );
```

**Filter:** `theme_file_uri`

---

### `get_parent_theme_file_uri( $file = '' )`
Returns URL to file in parent theme.

**Filter:** `parent_theme_file_uri`

---

### `get_theme_file_path( $file = '' )`
Returns path to file in theme.

**Filter:** `theme_file_path`

---

### `get_parent_theme_file_path( $file = '' )`
Returns path to file in parent theme.

**Filter:** `parent_theme_file_path`

---

## Avatar URL Functions

### `get_avatar_url( $id_or_email, $args = null )`
Returns Gravatar URL.

```php
get_avatar_url( 1 );                  // User ID
get_avatar_url( 'user@example.com' ); // Email
get_avatar_url( $comment );           // Comment object
```

**Args:**
- `size` - Pixel size (default 96)
- `default` - Fallback type: 'mm', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash', 'blank', '404'
- `rating` - Max rating: 'g', 'pg', 'r', 'x'

**Filter:** `get_avatar_url`

---

### `get_avatar_data( $id_or_email, $args = null )`
Returns complete avatar data array including URL and metadata.

**Filter:** `get_avatar_data`

---

## Comment Link Functions

### `get_comments_pagenum_link( $pagenum = 1, $max_page = 0 )`
Returns URL for specific comments page.

---

### `get_next_comments_link( $label = '', $max_page = 0, $page = null )`
Returns link to next comments page.

---

### `get_previous_comments_link( $label = '', $page = null )`
Returns link to previous comments page.

---

### `paginate_comments_links( $args = array() )`
Returns paginated comments navigation.

---

### `get_the_comments_navigation( $args = array() )`
Returns comments navigation markup (prev/next).

---

### `get_the_comments_pagination( $args = array() )`
Returns comments pagination markup (numbered).
