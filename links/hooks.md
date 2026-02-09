# WordPress Links & URL Hooks Reference

## Site URL Filters

### `home_url`
Filters the home URL.

```php
add_filter( 'home_url', function( $url, $path, $orig_scheme, $blog_id ) {
    return $url;
}, 10, 4 );
```

**Parameters:**
- `$url` (string) - Complete home URL with scheme and path
- `$path` (string) - Path relative to home URL (empty if none)
- `$orig_scheme` (string|null) - Requested scheme: 'http', 'https', 'relative', 'rest', or null
- `$blog_id` (int|null) - Site ID, or null for current site

---

### `site_url`
Filters the site URL (where WordPress files are).

```php
add_filter( 'site_url', function( $url, $path, $scheme, $blog_id ) {
    return $url;
}, 10, 4 );
```

**Parameters:**
- `$url` (string) - Complete site URL
- `$path` (string) - Path relative to site URL
- `$scheme` (string|null) - Scheme: 'http', 'https', 'login', 'login_post', 'admin', 'relative', or null
- `$blog_id` (int|null) - Site ID

---

### `admin_url`
Filters the admin URL.

```php
add_filter( 'admin_url', function( $url, $path, $blog_id, $scheme ) {
    return $url;
}, 10, 4 );
```

---

### `includes_url`
Filters the wp-includes URL.

```php
add_filter( 'includes_url', function( $url, $path, $scheme ) {
    return $url;
}, 10, 3 );
```

---

### `content_url`
Filters the wp-content URL.

```php
add_filter( 'content_url', function( $url, $path ) {
    return $url;
}, 10, 2 );
```

---

### `plugins_url`
Filters the plugins URL.

```php
add_filter( 'plugins_url', function( $url, $path, $plugin ) {
    return $url;
}, 10, 3 );
```

---

### `network_site_url`
Filters the network site URL (multisite).

```php
add_filter( 'network_site_url', function( $url, $path, $scheme ) {
    return $url;
}, 10, 3 );
```

---

### `network_home_url`
Filters the network home URL (multisite).

```php
add_filter( 'network_home_url', function( $url, $path, $orig_scheme ) {
    return $url;
}, 10, 3 );
```

---

### `network_admin_url`
Filters the network admin URL (multisite).

```php
add_filter( 'network_admin_url', function( $url, $path, $scheme ) {
    return $url;
}, 10, 3 );
```

---

### `user_admin_url`
Filters the user admin URL.

```php
add_filter( 'user_admin_url', function( $url, $path, $scheme ) {
    return $url;
}, 10, 3 );
```

---

### `self_admin_url`
Filters the context-aware admin URL.

```php
add_filter( 'self_admin_url', function( $url, $path, $scheme ) {
    return $url;
}, 10, 3 );
```

---

### `set_url_scheme`
Filters URL after scheme is set.

```php
add_filter( 'set_url_scheme', function( $url, $scheme, $orig_scheme ) {
    return $url;
}, 10, 3 );
```

**Parameters:**
- `$url` (string) - Complete URL with scheme applied
- `$scheme` (string) - Applied scheme: 'http', 'https', or 'relative'
- `$orig_scheme` (string|null) - Originally requested scheme

---

## Permalink Filters

### `the_permalink`
Filters the displayed permalink (output of `the_permalink()`).

```php
add_filter( 'the_permalink', function( $permalink, $post ) {
    return $permalink;
}, 10, 2 );
```

---

### `pre_post_link`
Filters permalink structure before token replacement (posts only).

```php
add_filter( 'pre_post_link', function( $permalink, $post, $leavename ) {
    // Modify permalink structure for specific posts
    return $permalink;
}, 10, 3 );
```

---

### `post_link`
Filters the post permalink (after generation).

```php
add_filter( 'post_link', function( $permalink, $post, $leavename ) {
    return $permalink;
}, 10, 3 );
```

**Use Cases:**
- Modify post URLs based on custom logic
- Add tracking parameters
- Change URL structure

---

### `post_link_category`
Filters category used in `%category%` permalink token.

```php
add_filter( 'post_link_category', function( $cat, $cats, $post ) {
    // Return preferred category for permalink
    return $cat;
}, 10, 3 );
```

---

### `post_type_link`
Filters custom post type permalink.

```php
add_filter( 'post_type_link', function( $post_link, $post, $leavename, $sample ) {
    return $post_link;
}, 10, 4 );
```

---

### `page_link`
Filters page permalink.

```php
add_filter( 'page_link', function( $link, $post_id, $sample ) {
    return $link;
}, 10, 3 );
```

---

### `_get_page_link`
Filters non-front-page page permalink (internal use).

```php
add_filter( '_get_page_link', function( $link, $post_id ) {
    return $link;
}, 10, 2 );
```

---

### `attachment_link`
Filters attachment permalink.

```php
add_filter( 'attachment_link', function( $link, $post_id ) {
    return $link;
}, 10, 2 );
```

---

## Archive Link Filters

### `year_link`
Filters year archive permalink.

```php
add_filter( 'year_link', function( $yearlink, $year ) {
    return $yearlink;
}, 10, 2 );
```

---

### `month_link`
Filters month archive permalink.

```php
add_filter( 'month_link', function( $monthlink, $year, $month ) {
    return $monthlink;
}, 10, 3 );
```

---

### `day_link`
Filters day archive permalink.

```php
add_filter( 'day_link', function( $daylink, $year, $month, $day ) {
    return $daylink;
}, 10, 4 );
```

---

### `post_type_archive_link`
Filters post type archive permalink.

```php
add_filter( 'post_type_archive_link', function( $link, $post_type ) {
    return $link;
}, 10, 2 );
```

---

### `author_link`
Filters author archive permalink.

```php
add_filter( 'author_link', function( $link, $author_id, $author_nicename ) {
    return $link;
}, 10, 3 );
```

---

## Taxonomy/Term Link Filters

### `term_link`
Filters term/taxonomy permalink.

```php
add_filter( 'term_link', function( $termlink, $term, $taxonomy ) {
    return $termlink;
}, 10, 3 );
```

---

### `category_link`
Filters category permalink.

```php
add_filter( 'category_link', function( $termlink, $term_id ) {
    return $termlink;
}, 10, 2 );
```

---

### `tag_link`
Filters tag permalink.

```php
add_filter( 'tag_link', function( $termlink, $term_id ) {
    return $termlink;
}, 10, 2 );
```

---

## Feed Link Filters

### `feed_link`
Filters feed permalink.

```php
add_filter( 'feed_link', function( $output, $feed ) {
    return $output;
}, 10, 2 );
```

---

### `post_comments_feed_link`
Filters post comments feed link.

```php
add_filter( 'post_comments_feed_link', function( $url ) {
    return $url;
} );
```

---

### `author_feed_link`
Filters author feed link.

```php
add_filter( 'author_feed_link', function( $link, $feed ) {
    return $link;
}, 10, 2 );
```

---

### `category_feed_link`
Filters category feed link.

```php
add_filter( 'category_feed_link', function( $link, $feed ) {
    return $link;
}, 10, 2 );
```

---

### `tag_feed_link`
Filters tag feed link.

```php
add_filter( 'tag_feed_link', function( $link, $feed ) {
    return $link;
}, 10, 2 );
```

---

### `taxonomy_feed_link`
Filters custom taxonomy feed link.

```php
add_filter( 'taxonomy_feed_link', function( $link, $feed, $taxonomy ) {
    return $link;
}, 10, 3 );
```

---

### `post_type_archive_feed_link`
Filters post type archive feed link.

```php
add_filter( 'post_type_archive_feed_link', function( $link, $feed ) {
    return $link;
}, 10, 2 );
```

---

## Search Link Filters

### `search_link`
Filters search permalink.

```php
add_filter( 'search_link', function( $link, $search ) {
    return $link;
}, 10, 2 );
```

---

### `search_feed_link`
Filters search feed link.

```php
add_filter( 'search_feed_link', function( $link, $feed, $type ) {
    return $link;
}, 10, 3 );
```

**Parameters:**
- `$type` - 'posts' or 'comments'

---

## Edit Link Filters

### `get_edit_post_link`
Filters edit post link.

```php
add_filter( 'get_edit_post_link', function( $link, $post_id, $context ) {
    return $link;
}, 10, 3 );
```

---

### `edit_post_link`
Filters edit post anchor tag.

```php
add_filter( 'edit_post_link', function( $link, $post_id, $text ) {
    return $link;
}, 10, 3 );
```

---

### `get_delete_post_link`
Filters delete post link.

```php
add_filter( 'get_delete_post_link', function( $link, $post_id, $force_delete ) {
    return $link;
}, 10, 3 );
```

---

### `get_edit_term_link`
Filters edit term link.

```php
add_filter( 'get_edit_term_link', function( $location, $term_id, $taxonomy, $object_type ) {
    return $location;
}, 10, 4 );
```

---

### `edit_term_link`
Filters edit term anchor tag.

```php
add_filter( 'edit_term_link', function( $link, $term_id ) {
    return $link;
}, 10, 2 );
```

---

### `get_edit_tag_link`
Filters edit tag link.

```php
add_filter( 'get_edit_tag_link', function( $link ) {
    return $link;
} );
```

---

### `edit_tag_link`
Filters edit tag anchor tag.

```php
add_filter( 'edit_tag_link', function( $link ) {
    return $link;
} );
```

---

### `get_edit_comment_link`
Filters edit comment link.

```php
add_filter( 'get_edit_comment_link', function( $location, $comment_id, $context ) {
    return $location;
}, 10, 3 );
```

---

### `edit_comment_link`
Filters edit comment anchor tag.

```php
add_filter( 'edit_comment_link', function( $link, $comment_id, $text ) {
    return $link;
}, 10, 3 );
```

---

### `get_edit_bookmark_link`
Filters edit bookmark link.

```php
add_filter( 'get_edit_bookmark_link', function( $location, $link_id ) {
    return $location;
}, 10, 2 );
```

---

### `edit_bookmark_link`
Filters edit bookmark anchor tag.

```php
add_filter( 'edit_bookmark_link', function( $link, $link_id ) {
    return $link;
}, 10, 2 );
```

---

### `get_edit_user_link`
Filters edit user link.

```php
add_filter( 'get_edit_user_link', function( $link, $user_id ) {
    return $link;
}, 10, 2 );
```

---

## Navigation Link Filters

### `previous_post_link`
Filters previous post link markup.

```php
add_filter( 'previous_post_link', function( $output, $format, $link, $post, $adjacent ) {
    return $output;
}, 10, 5 );
```

---

### `next_post_link`
Filters next post link markup.

```php
add_filter( 'next_post_link', function( $output, $format, $link, $post, $adjacent ) {
    return $output;
}, 10, 5 );
```

---

### `get_previous_post_join`
### `get_next_post_join`
Filters JOIN clause for adjacent post query.

```php
add_filter( 'get_previous_post_join', function( $join, $in_same_term, $excluded_terms, $taxonomy, $post ) {
    return $join;
}, 10, 5 );
```

---

### `get_previous_post_where`
### `get_next_post_where`
Filters WHERE clause for adjacent post query.

```php
add_filter( 'get_previous_post_where', function( $where, $in_same_term, $excluded_terms, $taxonomy, $post ) {
    return $where;
}, 10, 5 );
```

---

### `get_previous_post_sort`
### `get_next_post_sort`
Filters ORDER BY clause for adjacent post query.

```php
add_filter( 'get_previous_post_sort', function( $order_by, $post, $order ) {
    return $order_by;
}, 10, 3 );
```

---

### `get_previous_post_excluded_terms`
### `get_next_post_excluded_terms`
Filters excluded term IDs for adjacent post query.

```php
add_filter( 'get_previous_post_excluded_terms', function( $excluded_terms ) {
    return $excluded_terms;
} );
```

---

### `navigation_markup_template`
Filters navigation wrapper HTML template.

```php
add_filter( 'navigation_markup_template', function( $template, $css_class ) {
    return $template;
}, 10, 2 );
```

---

### `the_posts_pagination_args`
Filters posts pagination arguments.

```php
add_filter( 'the_posts_pagination_args', function( $args ) {
    $args['mid_size'] = 3;
    return $args;
} );
```

---

## Shortlink Filters

### `pre_get_shortlink`
Short-circuits shortlink generation.

```php
add_filter( 'pre_get_shortlink', function( $return, $id, $context, $allow_slugs ) {
    // Return custom shortlink or false to continue
    return 'https://short.link/' . $id;
}, 10, 4 );
```

---

### `get_shortlink`
Filters the shortlink.

```php
add_filter( 'get_shortlink', function( $shortlink, $id, $context, $allow_slugs ) {
    return $shortlink;
}, 10, 4 );
```

---

### `the_shortlink`
Filters shortlink anchor tag.

```php
add_filter( 'the_shortlink', function( $link, $shortlink, $text, $title ) {
    return $link;
}, 10, 4 );
```

---

## Canonical URL Filters

### `get_canonical_url`
Filters canonical URL for a post.

```php
add_filter( 'get_canonical_url', function( $canonical_url, $post ) {
    return $canonical_url;
}, 10, 2 );
```

---

### `redirect_canonical`
Filters or cancels canonical redirect.

```php
// Cancel all canonical redirects
add_filter( 'redirect_canonical', '__return_false' );

// Modify redirect URL
add_filter( 'redirect_canonical', function( $redirect_url, $requested_url ) {
    return $redirect_url;
}, 10, 2 );
```

---

### `do_redirect_guess_404_permalink`
Enables/disables 404 URL guessing.

```php
// Disable 404 URL guessing
add_filter( 'do_redirect_guess_404_permalink', '__return_false' );
```

---

### `pre_redirect_guess_404_permalink`
Short-circuits 404 URL guessing.

```php
add_filter( 'pre_redirect_guess_404_permalink', function( $pre ) {
    // Return URL string or false to skip guessing
    return $pre;
} );
```

---

### `strict_redirect_guess_404_permalink`
Enables strict (exact match) 404 guessing.

```php
// Only redirect exact post_name matches
add_filter( 'strict_redirect_guess_404_permalink', '__return_true' );
```

---

### `wp_signup_location`
Filters signup page location (multisite).

```php
add_filter( 'wp_signup_location', function( $url ) {
    return $url;
} );
```

---

## Trailing Slash Filter

### `user_trailingslashit`
Filters trailing slash handling.

```php
add_filter( 'user_trailingslashit', function( $url, $type_of_url ) {
    // Force trailing slash for categories
    if ( 'category' === $type_of_url ) {
        return trailingslashit( $url );
    }
    return $url;
}, 10, 2 );
```

**`$type_of_url` values:**
- `single` - Single posts
- `single_trackback`, `single_feed`, `single_paged`
- `page` - Pages
- `category`, `post_tag` - Taxonomy archives
- `paged` - Paginated archives
- `home` - Home page
- `feed` - Feeds
- `year`, `month`, `day` - Date archives
- `post_type_archive` - CPT archives
- `commentpaged` - Comment pagination
- `search` - Search results

---

## Bookmark Filters

### `get_bookmarks`
Filters list of bookmarks.

```php
add_filter( 'get_bookmarks', function( $bookmarks, $parsed_args ) {
    return $bookmarks;
}, 10, 2 );
```

---

### `edit_{$field}` (bookmarks)
Filters bookmark field in 'edit' context.

```php
add_filter( 'edit_link_url', function( $value, $bookmark_id ) {
    return $value;
}, 10, 2 );
```

---

### `pre_{$field}` (bookmarks)
Filters bookmark field in 'db' context (before save).

```php
add_filter( 'pre_link_url', function( $value ) {
    return $value;
} );
```

---

### `{$field}` (bookmarks)
Filters bookmark field in 'display' context.

```php
add_filter( 'link_url', function( $value, $bookmark_id, $context ) {
    return $value;
}, 10, 3 );
```

**Available fields:** `link_url`, `link_name`, `link_description`, `link_notes`, etc.

---

## User/Dashboard Link Filters

### `user_dashboard_url`
Filters dashboard URL for a user.

```php
add_filter( 'user_dashboard_url', function( $url, $user_id, $path, $scheme ) {
    return $url;
}, 10, 4 );
```

---

### `edit_profile_url`
Filters profile edit URL.

```php
add_filter( 'edit_profile_url', function( $url, $user_id, $scheme ) {
    return $url;
}, 10, 3 );
```

---

## Preview Link Filter

### `preview_post_link`
Filters post preview URL.

```php
add_filter( 'preview_post_link', function( $preview_link, $post ) {
    return $preview_link;
}, 10, 2 );
```

---

## Privacy Policy Filters

### `privacy_policy_url`
Filters privacy policy page URL.

```php
add_filter( 'privacy_policy_url', function( $url, $policy_page_id ) {
    return $url;
}, 10, 2 );
```

---

### `the_privacy_policy_link`
Filters privacy policy link markup.

```php
add_filter( 'the_privacy_policy_link', function( $link, $privacy_policy_url ) {
    return $link;
}, 10, 2 );
```

---

## Theme File URL Filters

### `theme_file_uri`
Filters theme file URL.

```php
add_filter( 'theme_file_uri', function( $url, $file ) {
    return $url;
}, 10, 2 );
```

---

### `parent_theme_file_uri`
Filters parent theme file URL.

```php
add_filter( 'parent_theme_file_uri', function( $url, $file ) {
    return $url;
}, 10, 2 );
```

---

### `theme_file_path`
Filters theme file path.

```php
add_filter( 'theme_file_path', function( $path, $file ) {
    return $path;
}, 10, 2 );
```

---

### `parent_theme_file_path`
Filters parent theme file path.

```php
add_filter( 'parent_theme_file_path', function( $path, $file ) {
    return $path;
}, 10, 2 );
```

---

## Internal Link Filters

### `wp_internal_hosts`
Filters list of internal hostnames.

```php
add_filter( 'wp_internal_hosts', function( $hosts ) {
    $hosts[] = 'cdn.example.com';
    return $hosts;
} );
```

---

## Avatar URL Filters

### `pre_get_avatar_data`
Short-circuits avatar data retrieval.

```php
add_filter( 'pre_get_avatar_data', function( $args, $id_or_email ) {
    // Set $args['url'] to short-circuit
    return $args;
}, 10, 2 );
```

---

### `get_avatar_url`
Filters avatar URL.

```php
add_filter( 'get_avatar_url', function( $url, $id_or_email, $args ) {
    return $url;
}, 10, 3 );
```

---

### `get_avatar_data`
Filters complete avatar data.

```php
add_filter( 'get_avatar_data', function( $args, $id_or_email ) {
    return $args;
}, 10, 2 );
```

---

### `get_avatar_comment_types`
Filters comment types that can have avatars.

```php
add_filter( 'get_avatar_comment_types', function( $types ) {
    $types[] = 'pingback';
    return $types;
} );
```

---

## Comment Navigation Filters

### `next_comments_link_attributes`
Filters next comments link attributes.

```php
add_filter( 'next_comments_link_attributes', function( $attributes ) {
    return $attributes . ' class="next-comments"';
} );
```

---

### `previous_comments_link_attributes`
Filters previous comments link attributes.

```php
add_filter( 'previous_comments_link_attributes', function( $attributes ) {
    return $attributes . ' class="prev-comments"';
} );
```

---

### `get_comments_pagenum_link`
Filters comments page number link.

```php
add_filter( 'get_comments_pagenum_link', function( $result ) {
    return $result;
} );
```

---

## Feed Display Filters

### `the_feed_link`
Filters feed link anchor tag.

```php
add_filter( 'the_feed_link', function( $link, $feed ) {
    return $link;
}, 10, 2 );
```

---

### `post_comments_feed_link_html`
Filters post comments feed link anchor tag.

```php
add_filter( 'post_comments_feed_link_html', function( $link, $post_id, $feed ) {
    return $link;
}, 10, 3 );
```
