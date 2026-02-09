# Template Tag Hooks

Template tags provide extensive hooks for customization. This documents the key actions and filters available.

## Template Loading Hooks

### Action: get_header
Fires before the header template is loaded.

```php
do_action( 'get_header', $name, $args );
```

**Parameters:**
- `$name` (string|null): Header template name, null for default.
- `$args` (array): Arguments passed to the template.

**Example:**
```php
add_action('get_header', function($name, $args) {
    if ($name === 'shop') {
        // Enqueue shop-specific styles
        wp_enqueue_style('shop-header', get_template_directory_uri() . '/css/shop-header.css');
    }
}, 10, 2);
```

**Since:** 2.1.0, `$args` since 5.5.0

---

### Action: get_footer
Fires before the footer template is loaded.

```php
do_action( 'get_footer', $name, $args );
```

**Since:** 2.1.0, `$args` since 5.5.0

---

### Action: get_sidebar
Fires before the sidebar template is loaded.

```php
do_action( 'get_sidebar', $name, $args );
```

**Since:** 2.2.0, `$args` since 5.5.0

---

### Action: get_template_part_{$slug}
Fires before a specific template part is loaded.

```php
do_action( "get_template_part_{$slug}", $slug, $name, $args );
```

**Example:**
```php
// For get_template_part('content', 'page')
add_action('get_template_part_content', function($slug, $name, $args) {
    if ($name === 'page') {
        // Do something before content-page.php loads
    }
}, 10, 3);
```

**Since:** 3.0.0

---

### Action: get_template_part
Fires before any template part is located and loaded.

```php
do_action( 'get_template_part', $slug, $name, $templates, $args );
```

**Parameters:**
- `$slug` (string): Template slug.
- `$name` (string): Template name.
- `$templates` (array): Template files to search.
- `$args` (array): Arguments passed to template.

**Since:** 5.2.0

---

## Head/Footer Hooks

### Action: wp_head
Prints content in the `<head>` section.

```php
do_action( 'wp_head' );
```

**Default Priority Items:**
| Priority | Function | Purpose |
|----------|----------|---------|
| 1 | `_wp_render_title_tag` | Output `<title>` |
| 1 | `wp_enqueue_scripts` | Trigger script/style enqueueing |
| 2 | `wp_resource_hints` | DNS prefetch, preconnect |
| 3 | `wp_preload_resources` | Resource preloading |
| 8 | `wp_print_styles` | Print enqueued styles |
| 9 | `wp_print_head_scripts` | Print head scripts |
| 10 | `wp_site_icon` | Site icon meta tags |

**Example:**
```php
add_action('wp_head', function() {
    echo '<meta name="author" content="My Site">';
}, 1);
```

**Since:** 1.5.0

---

### Action: wp_footer
Prints content before `</body>`.

```php
do_action( 'wp_footer' );
```

**Default Items:**
| Priority | Function | Purpose |
|----------|----------|---------|
| 20 | `wp_print_footer_scripts` | Footer scripts |
| 1000 | Various | Admin bar, dev tools |

**Example:**
```php
add_action('wp_footer', function() {
    ?>
    <script>
        console.log('Page loaded');
    </script>
    <?php
}, 100);
```

**Since:** 1.5.1

---

### Action: wp_body_open
Fires immediately after the opening `<body>` tag.

```php
do_action( 'wp_body_open' );
```

**Common Uses:**
```php
add_action('wp_body_open', function() {
    // Skip link for accessibility
    echo '<a class="skip-link" href="#main">Skip to content</a>';
});

// Google Tag Manager
add_action('wp_body_open', function() {
    echo '<!-- GTM noscript -->';
}, 1);
```

**Since:** 5.2.0

---

### Action: wp_meta
Fires in sidebar, originally for theme switching.

```php
do_action( 'wp_meta' );
```

**Since:** 1.5.0

---

## Filter Hooks

### Filter: body_class
Modifies body CSS classes.

```php
$classes = apply_filters( 'body_class', $classes, $css_class );
```

**Parameters:**
- `$classes` (array): Array of class names.
- `$css_class` (array): Additional classes passed to `body_class()`.

**Example:**
```php
add_filter('body_class', function($classes) {
    if (is_page_template('templates/landing.php')) {
        $classes[] = 'landing-page';
        $classes[] = 'no-sidebar';
    }
    
    // Add browser class
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
        $classes[] = 'is-safari';
    }
    
    return $classes;
});
```

**Since:** 2.8.0

---

### Filter: post_class
Modifies post container CSS classes.

```php
$classes = apply_filters( 'post_class', $classes, $css_class, $post_id );
```

**Parameters:**
- `$classes` (array): Array of class names.
- `$css_class` (array): Additional classes passed to `post_class()`.
- `$post_id` (int): Post ID.

**Example:**
```php
add_filter('post_class', function($classes, $css_class, $post_id) {
    // Add featured class based on meta
    if (get_post_meta($post_id, '_is_featured', true)) {
        $classes[] = 'featured-post';
    }
    
    // Add age class
    $post_date = get_the_date('U', $post_id);
    if ((time() - $post_date) > (365 * DAY_IN_SECONDS)) {
        $classes[] = 'archived-post';
    }
    
    return $classes;
}, 10, 3);
```

**Since:** 2.7.0

---

### Filter: post_class_taxonomies
Controls which taxonomies generate CSS classes.

```php
$taxonomies = apply_filters( 'post_class_taxonomies', $taxonomies, $post_id, $classes, $css_class );
```

**Example:**
```php
// Remove tag classes to reduce HTML size
add_filter('post_class_taxonomies', function($taxonomies) {
    unset($taxonomies['post_tag']);
    return $taxonomies;
});
```

**Since:** 6.1.0

---

### Filter: the_title
Filters the post title.

```php
$title = apply_filters( 'the_title', $post_title, $post_id );
```

**Example:**
```php
add_filter('the_title', function($title, $post_id) {
    if (is_sticky($post_id) && !is_singular()) {
        $title = '⭐ ' . $title;
    }
    return $title;
}, 10, 2);
```

**Since:** 0.71

---

### Filter: wp_title
Filters the page title output.

```php
$title = apply_filters( 'wp_title', $title, $sep, $seplocation );
```

**Example:**
```php
add_filter('wp_title', function($title, $sep, $seplocation) {
    if (is_front_page()) {
        return get_bloginfo('name') . ' | ' . get_bloginfo('description');
    }
    return $title;
}, 10, 3);
```

**Since:** 2.0.0

---

### Filter: wp_title_parts
Filters title parts before joining.

```php
$title_array = apply_filters( 'wp_title_parts', $title_array );
```

**Since:** 4.0.0

---

### Filter: document_title_parts
Filters document title components.

```php
$title = apply_filters( 'document_title_parts', $title );
```

**Parameters:**
- `$title` (array): Components - `title`, `page`, `tagline`, `site`.

**Example:**
```php
add_filter('document_title_parts', function($title) {
    // Remove site name from all pages except home
    if (!is_front_page()) {
        unset($title['site']);
    }
    return $title;
});
```

**Since:** 4.4.0

---

### Filter: document_title_separator
Filters the title separator.

```php
$sep = apply_filters( 'document_title_separator', '-' );
```

**Example:**
```php
add_filter('document_title_separator', function() {
    return '|';
});
```

**Since:** 4.4.0

---

### Filter: bloginfo
Filters non-URL site information.

```php
$output = apply_filters( 'bloginfo', $output, $show );
```

**Since:** 0.71

---

### Filter: bloginfo_url
Filters URL-based site information.

```php
$output = apply_filters( 'bloginfo_url', $output, $show );
```

**Since:** 2.0.5

---

### Filter: language_attributes
Filters the language attributes string.

```php
$output = apply_filters( 'language_attributes', $output, $doctype );
```

**Example:**
```php
add_filter('language_attributes', function($output) {
    return $output . ' data-theme="light"';
});
```

**Since:** 2.5.0

---

### Filter: get_search_form
Filters the search form HTML.

```php
$form = apply_filters( 'get_search_form', $form, $args );
```

**Example:**
```php
add_filter('get_search_form', function($form) {
    return str_replace(
        'type="search"',
        'type="search" autocomplete="off"',
        $form
    );
});
```

**Since:** 2.7.0

---

### Filter: search_form_args
Filters search form arguments before rendering.

```php
$args = apply_filters( 'search_form_args', $args );
```

**Since:** 5.2.0

---

### Filter: search_form_format
Filters whether to use HTML5 or XHTML format.

```php
$format = apply_filters( 'search_form_format', $format, $args );
```

**Since:** 3.6.0

---

### Filter: the_author
Filters the author display name.

```php
$display_name = apply_filters( 'the_author', $display_name );
```

**Since:** 2.9.0

---

### Filter: get_the_author_{$field}
Filters specific author metadata.

```php
$value = apply_filters( "get_the_author_{$field}", $value, $user_id, $original_user_id );
```

**Example:**
```php
// Ensure email is not displayed publicly
add_filter('get_the_author_user_email', function($email, $user_id) {
    if (!current_user_can('edit_user', $user_id)) {
        return '';
    }
    return $email;
}, 10, 2);
```

**Since:** 2.8.0

---

### Filter: the_category
Filters the category list output.

```php
$thelist = apply_filters( 'the_category', $thelist, $separator, $parents );
```

**Since:** 1.2.0

---

### Filter: the_category_list
Filters categories before list is built.

```php
$categories = apply_filters( 'the_category_list', $categories, $post_id );
```

**Since:** 4.4.0

---

### Filter: get_the_archive_title
Filters the archive title.

```php
$title = apply_filters( 'get_the_archive_title', $title, $original_title, $prefix );
```

**Example:**
```php
add_filter('get_the_archive_title', function($title) {
    // Remove prefixes like "Category:" or "Tag:"
    return preg_replace('/^[^:]+: /', '', $title);
});
```

**Since:** 4.1.0

---

### Filter: get_the_archive_title_prefix
Filters just the archive title prefix.

```php
$prefix = apply_filters( 'get_the_archive_title_prefix', $prefix );
```

**Example:**
```php
// Remove all prefixes
add_filter('get_the_archive_title_prefix', '__return_empty_string');
```

**Since:** 5.5.0

---

### Filter: get_the_archive_description
Filters the archive description.

```php
$description = apply_filters( 'get_the_archive_description', $description );
```

**Since:** 4.1.0

---

### Filter: loginout
Filters the login/logout link.

```php
$link = apply_filters( 'loginout', $link );
```

**Since:** 1.5.0

---

### Filter: login_url
Filters the login URL.

```php
$login_url = apply_filters( 'login_url', $login_url, $redirect, $force_reauth );
```

**Since:** 2.8.0

---

### Filter: logout_url
Filters the logout URL.

```php
$logout_url = apply_filters( 'logout_url', $logout_url, $redirect );
```

**Since:** 2.8.0

---

### Filter: register_url
Filters the registration URL.

```php
$url = apply_filters( 'register_url', $url );
```

**Since:** 3.6.0

---

### Filter: paginate_links
Filters individual pagination link URLs.

```php
$link = apply_filters( 'paginate_links', $link );
```

**Since:** 3.0.0

---

### Filter: paginate_links_output
Filters the complete pagination HTML output.

```php
$r = apply_filters( 'paginate_links_output', $r, $args );
```

**Since:** 5.7.0

---

### Filter: get_calendar
Filters the calendar HTML output.

```php
$calendar_output = apply_filters( 'get_calendar', $calendar_output, $args );
```

**Since:** 3.0.0, `$args` since 6.8.0

---

### Filter: get_calendar_args
Filters calendar function arguments.

```php
$args = apply_filters( 'get_calendar_args', $args );
```

**Since:** 6.8.0

---

### Filter: getarchives_where
Filters the WHERE clause for archive queries.

```php
$where = apply_filters( 'getarchives_where', $sql_where, $parsed_args );
```

**Since:** 2.2.0

---

### Filter: getarchives_join
Filters the JOIN clause for archive queries.

```php
$join = apply_filters( 'getarchives_join', '', $parsed_args );
```

**Since:** 2.2.0

---

### Filter: get_archives_link
Filters individual archive link HTML.

```php
$link_html = apply_filters( 'get_archives_link', $link_html, $url, $text, $format, $before, $after, $selected );
```

**Since:** 2.6.0

---

### Filter: wp_list_categories
Filters the category list HTML output.

```php
$html = apply_filters( 'wp_list_categories', $output, $args );
```

**Since:** 2.1.0

---

### Filter: wp_tag_cloud
Filters the tag cloud output.

```php
$return = apply_filters( 'wp_tag_cloud', $return, $args );
```

**Since:** 2.3.0

---

### Filter: wp_dropdown_cats
Filters the category dropdown output.

```php
$output = apply_filters( 'wp_dropdown_cats', $output, $parsed_args );
```

**Since:** 2.1.0

---

### Filter: list_cats
Filters category display in dropdowns and lists.

```php
$element = apply_filters( 'list_cats', $element, $category );
```

**Since:** 1.2.0

---

### Filter: feed_links_args
Filters main feed link arguments.

```php
$args = apply_filters( 'feed_links_args', $args );
```

**Since:** 6.7.0

---

### Filter: feed_links_show_posts_feed
Controls whether to show the main posts feed link.

```php
$show = apply_filters( 'feed_links_show_posts_feed', true );
```

**Since:** 4.4.0

---

### Filter: feed_links_show_comments_feed
Controls whether to show the comments feed link.

```php
$show = apply_filters( 'feed_links_show_comments_feed', true );
```

**Since:** 4.4.0

---

### Filter: site_icon_meta_tags
Filters site icon meta tag output.

```php
$meta_tags = apply_filters( 'site_icon_meta_tags', $meta_tags );
```

**Since:** 4.3.0

---

### Filter: get_custom_logo
Filters the custom logo HTML.

```php
$html = apply_filters( 'get_custom_logo', $html, $blog_id );
```

**Since:** 4.5.0

---

### Filter: get_custom_logo_image_attributes
Filters custom logo image attributes.

```php
$attrs = apply_filters( 'get_custom_logo_image_attributes', $custom_logo_attr, $custom_logo_id, $blog_id );
```

**Since:** 5.5.0

---

### Filter: wp_resource_hints
Filters resource hint URLs (dns-prefetch, preconnect, etc.).

```php
$urls = apply_filters( 'wp_resource_hints', $urls, $relation_type );
```

**Since:** 4.6.0

---

### Filter: wp_preload_resources
Filters resources to preload.

```php
$preload_resources = apply_filters( 'wp_preload_resources', array() );
```

**Since:** 6.1.0

---

## Action: pre_get_search_form
Fires before search form is built.

```php
do_action( 'pre_get_search_form', $args );
```

**Since:** 3.6.0

---

## Date/Time Filters

### Filter: the_date
Filters the displayed post date.

```php
$the_date = apply_filters( 'the_date', $the_date, $format, $before, $after );
```

**Since:** 0.71

---

### Filter: get_the_date
Filters the retrieved post date.

```php
$the_date = apply_filters( 'get_the_date', $the_date, $format, $post );
```

**Since:** 3.0.0

---

### Filter: the_time
Filters the displayed post time.

```php
echo apply_filters( 'the_time', get_the_time( $format ), $format );
```

**Since:** 0.71

---

### Filter: get_the_time
Filters the retrieved post time.

```php
$the_time = apply_filters( 'get_the_time', $the_time, $format, $post );
```

**Since:** 1.5.0

---

### Filter: the_modified_date
Filters the displayed modified date.

```php
$the_modified_date = apply_filters( 'the_modified_date', $the_modified_date, $format, $before, $after );
```

**Since:** 2.1.0

---

### Filter: get_the_modified_date
Filters the retrieved modified date.

```php
$the_time = apply_filters( 'get_the_modified_date', $the_time, $format, $post );
```

**Since:** 2.1.0
