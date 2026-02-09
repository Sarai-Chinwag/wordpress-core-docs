# Template Tag Functions

## Template Part Functions

### get_header()
Loads the header template file.

```php
function get_header( $name = null, $args = array() )
```

**Parameters:**
- `$name` (string|null): Specialized header name. For `header-special.php`, pass `'special'`.
- `$args` (array): Additional arguments passed to the template (WP 5.5+).

**Template Search Order:**
1. `header-{$name}.php`
2. `header.php`

**Example:**
```php
get_header();                    // Loads header.php
get_header('shop');              // Loads header-shop.php, falls back to header.php
get_header('nav', ['show_search' => true]);  // Pass data to template
```

**Source:** `wp-includes/general-template.php`

---

### get_footer()
Loads the footer template file.

```php
function get_footer( $name = null, $args = array() )
```

**Parameters:**
- `$name` (string|null): Specialized footer name.
- `$args` (array): Additional arguments passed to the template.

**Example:**
```php
get_footer();           // Loads footer.php
get_footer('minimal');  // Loads footer-minimal.php
```

**Source:** `wp-includes/general-template.php`

---

### get_sidebar()
Loads the sidebar template file.

```php
function get_sidebar( $name = null, $args = array() )
```

**Parameters:**
- `$name` (string|null): Specialized sidebar name.
- `$args` (array): Additional arguments passed to the template.

**Example:**
```php
get_sidebar();           // Loads sidebar.php
get_sidebar('shop');     // Loads sidebar-shop.php
```

**Source:** `wp-includes/general-template.php`

---

### get_template_part()
Loads a template part for reusable theme sections.

```php
function get_template_part( $slug, $name = null, $args = array() )
```

**Parameters:**
- `$slug` (string): The slug name for the generic template.
- `$name` (string|null): The specialized template name.
- `$args` (array): Additional arguments passed to the template.

**Template Search Order:**
1. `{$slug}-{$name}.php`
2. `{$slug}.php`

**Example:**
```php
get_template_part('content', 'page');     // content-page.php
get_template_part('template-parts/card'); // template-parts/card.php
get_template_part('components/hero', null, [
    'title' => 'Welcome',
    'image' => $image_url
]);
```

**Note:** Unlike `require_once`, templates can be included multiple times.

**Source:** `wp-includes/general-template.php`

---

## Head/Footer Functions

### wp_head()
Fires the `wp_head` action for outputting scripts and styles in `<head>`.

```php
function wp_head()
```

**Must be placed:** Inside `<head>` before `</head>`.

**Outputs:**
- Enqueued stylesheets and scripts
- Meta tags (charset, viewport, robots)
- Feed links
- Title tag
- Custom CSS
- Block styles

**Example:**
```html
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>
```

**Source:** `wp-includes/general-template.php`

---

### wp_footer()
Fires the `wp_footer` action for outputting footer scripts.

```php
function wp_footer()
```

**Must be placed:** Before `</body>`.

**Outputs:**
- Deferred scripts
- Footer-enqueued JavaScript
- Analytics/tracking code

**Example:**
```html
    <?php wp_footer(); ?>
</body>
</html>
```

**Source:** `wp-includes/general-template.php`

---

### wp_body_open()
Fires the `wp_body_open` action immediately after `<body>`.

```php
function wp_body_open()
```

**Purpose:** Allows plugins/themes to inject content right after body open tag.

**Common Uses:**
- Skip-to-content links
- Overlay containers
- Google Tag Manager snippets

**Example:**
```html
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
```

**Since:** WordPress 5.2

**Source:** `wp-includes/general-template.php`

---

## Site Information Functions

### bloginfo()
Displays information about the current site.

```php
function bloginfo( $show = '' )
```

**Common Values:**
| Value | Description |
|-------|-------------|
| `'name'` | Site title |
| `'description'` | Site tagline |
| `'url'` | Site URL |
| `'admin_email'` | Admin email |
| `'charset'` | Character encoding |
| `'language'` | Language code |
| `'version'` | WordPress version |
| `'stylesheet_url'` | Active theme stylesheet URL |
| `'template_url'` | Parent theme directory URL |
| `'pingback_url'` | Pingback XML-RPC URL |
| `'rss2_url'` | RSS 2.0 feed URL |
| `'atom_url'` | Atom feed URL |

**Example:**
```php
<title><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?></title>
<meta charset="<?php bloginfo('charset'); ?>">
```

**Source:** `wp-includes/general-template.php`

---

### get_bloginfo()
Retrieves site information (return variant).

```php
function get_bloginfo( $show = '', $filter = 'raw' )
```

**Parameters:**
- `$show` (string): Information to retrieve.
- `$filter` (string): `'raw'` or `'display'` (applies escaping).

**Source:** `wp-includes/general-template.php`

---

## Language and HTML Attributes

### language_attributes()
Displays language attributes for the `<html>` tag.

```php
function language_attributes( $doctype = 'html' )
```

**Parameters:**
- `$doctype` (string): `'html'` or `'xhtml'`.

**Output Examples:**
```html
<!-- HTML5 -->
lang="en-US" dir="ltr"

<!-- XHTML -->
lang="en-US" xml:lang="en-US" dir="ltr"
```

**Example:**
```html
<html <?php language_attributes(); ?>>
```

**Source:** `wp-includes/general-template.php`

---

## Body and Post Classes

### body_class()
Displays CSS classes for the body element.

```php
function body_class( $css_class = '' )
```

**Parameters:**
- `$css_class` (string|array): Additional classes to add.

**Generated Classes:**
| Context | Classes |
|---------|---------|
| Front page | `home` |
| Blog index | `blog` |
| Single post | `single`, `single-{post_type}`, `postid-{id}` |
| Single page | `page`, `page-id-{id}` |
| Archive | `archive`, `category`, `tag`, `author`, `date` |
| Search | `search`, `search-results` or `search-no-results` |
| 404 | `error404` |
| Logged in | `logged-in` |
| Admin bar | `admin-bar` |

**Example:**
```php
<body <?php body_class('custom-layout'); ?>>
// Output: class="home blog logged-in admin-bar custom-layout"
```

**Source:** `wp-includes/post-template.php`

---

### post_class()
Displays CSS classes for a post container.

```php
function post_class( $css_class = '', $post = null )
```

**Parameters:**
- `$css_class` (string|array): Additional classes.
- `$post` (int|WP_Post): Post ID or object.

**Generated Classes:**
- `post-{id}`
- `{post_type}` (e.g., `post`, `page`)
- `type-{post_type}`
- `status-{status}`
- `format-{format}` (if post format supported)
- `has-post-thumbnail`
- `sticky` (on home, if sticky)
- `hentry` (hAtom microformat)
- `category-{slug}`, `tag-{slug}` (taxonomy terms)

**Example:**
```php
<article <?php post_class(); ?>>
// Output: class="post-123 post type-post status-publish format-standard hentry category-news"
```

**Source:** `wp-includes/post-template.php`

---

## Title Functions

### wp_title()
Displays the page title with separator.

```php
function wp_title( $sep = '&raquo;', $display = true, $seplocation = '' )
```

**Parameters:**
- `$sep` (string): Separator between title parts.
- `$display` (bool): Echo or return.
- `$seplocation` (string): `'left'` or `'right'`.

**Note:** In themes using `title-tag` support, WordPress handles the `<title>` automatically. Use `wp_get_document_title()` for programmatic access.

**Source:** `wp-includes/general-template.php`

---

### wp_get_document_title()
Retrieves the document title for use in `<title>`.

```php
function wp_get_document_title()
```

**Returns:** Complete page title with separator and site name.

**Title Logic:**
| Page Type | Title Source |
|-----------|--------------|
| 404 | "Page not found" |
| Search | "Search Results for [query]" |
| Front page | Site name |
| Blog page | Blog page title |
| Single/Page | Post title |
| Archive | Archive title |
| Author | Author display name |
| Date | Formatted date |

**Source:** `wp-includes/general-template.php`

---

### single_post_title()
Displays the post title for single posts/pages.

```php
function single_post_title( $prefix = '', $display = true )
```

**Source:** `wp-includes/general-template.php`

---

### single_term_title()
Displays the term title for taxonomy archives.

```php
function single_term_title( $prefix = '', $display = true )
```

**Source:** `wp-includes/general-template.php`

---

## Archive Functions

### the_archive_title()
Displays the archive title.

```php
function the_archive_title( $before = '', $after = '' )
```

**Output Examples:**
- Category: "Category: News"
- Tag: "Tag: Featured"
- Author: "Author: John"
- Date: "Month: January 2024"

**Example:**
```php
the_archive_title('<h1 class="archive-title">', '</h1>');
```

**Source:** `wp-includes/general-template.php`

---

### the_archive_description()
Displays the archive description.

```php
function the_archive_description( $before = '', $after = '' )
```

**Source:** `wp-includes/general-template.php`

---

## Author Functions

### the_author()
Displays the post author's display name.

```php
function the_author()
```

**Requires:** The Loop

**Source:** `wp-includes/author-template.php`

---

### get_the_author_meta()
Retrieves author metadata.

```php
function get_the_author_meta( $field = '', $user_id = false )
```

**Common Fields:**
- `display_name`, `first_name`, `last_name`, `nickname`
- `user_email`, `user_url`, `user_login`
- `description` (bio)
- `ID`

**Example:**
```php
echo get_the_author_meta('description');
echo get_the_author_meta('user_email', 5);  // Specific user
```

**Source:** `wp-includes/author-template.php`

---

### get_author_posts_url()
Retrieves the author archive URL.

```php
function get_author_posts_url( $author_id, $author_nicename = '' )
```

**Source:** `wp-includes/author-template.php`

---

## Category/Term Functions

### the_category()
Displays category list for current post.

```php
function the_category( $separator = '', $parents = '', $post_id = false )
```

**Parameters:**
- `$separator` (string): Text between categories. Empty = unordered list.
- `$parents` (string): `'multiple'`, `'single'`, or empty.
- `$post_id` (int): Post ID (optional outside Loop).

**Example:**
```php
the_category(', ');  // Output: "News, Featured, Tech"
```

**Source:** `wp-includes/category-template.php`

---

### wp_list_categories()
Displays a list of categories.

```php
function wp_list_categories( $args = '' )
```

**Key Arguments:**
| Argument | Description |
|----------|-------------|
| `show_count` | Show post counts |
| `hierarchical` | Show parent/child structure |
| `title_li` | List title |
| `hide_empty` | Hide empty categories |
| `exclude` | Category IDs to exclude |
| `orderby` | Sort field |
| `taxonomy` | Taxonomy to list |

**Example:**
```php
wp_list_categories([
    'title_li' => '',
    'show_count' => true,
    'hierarchical' => true
]);
```

**Source:** `wp-includes/category-template.php`

---

### wp_tag_cloud()
Displays a tag cloud.

```php
function wp_tag_cloud( $args = '' )
```

**Key Arguments:**
| Argument | Description |
|----------|-------------|
| `smallest` | Smallest font size (default 8) |
| `largest` | Largest font size (default 22) |
| `unit` | Font size unit (default 'pt') |
| `number` | Max tags to show |
| `taxonomy` | Taxonomy to use |

**Source:** `wp-includes/category-template.php`

---

### wp_dropdown_categories()
Displays a dropdown select of categories.

```php
function wp_dropdown_categories( $args = '' )
```

**Key Arguments:**
- `show_option_all`: Text for "all categories" option
- `show_option_none`: Text for "no category" option
- `name`, `id`, `class`: Form element attributes
- `selected`: Pre-selected value
- `taxonomy`: Taxonomy to list

**Source:** `wp-includes/category-template.php`

---

## Date/Time Functions

### the_date()
Displays the post date (once per day).

```php
function the_date( $format = '', $before = '', $after = '', $display = true )
```

**Note:** Only displays once per day in a loop (to avoid repetition).

**Source:** `wp-includes/general-template.php`

---

### get_the_date()
Retrieves the post date.

```php
function get_the_date( $format = '', $post = null )
```

**Parameters:**
- `$format` (string): PHP date format. Default: `date_format` option.
- `$post` (int|WP_Post): Post to get date for.

**Example:**
```php
echo get_the_date('F j, Y');  // "January 15, 2024"
```

**Source:** `wp-includes/general-template.php`

---

### the_time()
Displays the post time.

```php
function the_time( $format = '' )
```

**Source:** `wp-includes/general-template.php`

---

### the_modified_date()
Displays when the post was last modified.

```php
function the_modified_date( $format = '', $before = '', $after = '', $display = true )
```

**Source:** `wp-includes/general-template.php`

---

## Search Form

### get_search_form()
Retrieves or displays the search form.

```php
function get_search_form( $args = array() )
```

**Parameters:**
- `$args['echo']` (bool): Echo or return.
- `$args['aria_label']` (string): Accessibility label.

**Template Override:** Create `searchform.php` in theme.

**Example:**
```php
get_search_form();

// Custom aria label for multiple search forms
get_search_form(['aria_label' => 'Search products']);
```

**Source:** `wp-includes/general-template.php`

---

## Login/Logout Functions

### wp_loginout()
Displays login/logout link based on user state.

```php
function wp_loginout( $redirect = '', $display = true )
```

**Source:** `wp-includes/general-template.php`

---

### wp_login_url()
Returns the login page URL.

```php
function wp_login_url( $redirect = '', $force_reauth = false )
```

**Source:** `wp-includes/general-template.php`

---

### wp_logout_url()
Returns the logout URL with nonce.

```php
function wp_logout_url( $redirect = '' )
```

**Source:** `wp-includes/general-template.php`

---

## Pagination Functions

### paginate_links()
Generates paginated archive links.

```php
function paginate_links( $args = '' )
```

**Key Arguments:**
| Argument | Description |
|----------|-------------|
| `total` | Total pages |
| `current` | Current page |
| `prev_text` | Previous link text |
| `next_text` | Next link text |
| `mid_size` | Links on each side of current |
| `end_size` | Links at start/end |
| `type` | `'plain'`, `'array'`, or `'list'` |

**Example:**
```php
echo paginate_links([
    'prev_text' => '← Previous',
    'next_text' => 'Next →',
    'mid_size' => 2
]);
```

**Source:** `wp-includes/general-template.php`

---

## Icon/Logo Functions

### has_site_icon()
Checks if site has a site icon.

```php
function has_site_icon( $blog_id = 0 )
```

**Source:** `wp-includes/general-template.php`

---

### has_custom_logo()
Checks if theme has a custom logo.

```php
function has_custom_logo( $blog_id = 0 )
```

**Source:** `wp-includes/general-template.php`

---

### the_custom_logo()
Displays the custom logo.

```php
function the_custom_logo( $blog_id = 0 )
```

**Requires:** `add_theme_support('custom-logo')`

**Source:** `wp-includes/general-template.php`

---

## Calendar

### get_calendar()
Displays a calendar with post links.

```php
function get_calendar( $args = array() )
```

**Parameters:**
- `$args['initial']` (bool): Use initial day names.
- `$args['display']` (bool): Echo or return.
- `$args['post_type']` (string): Post type to show.

**Source:** `wp-includes/general-template.php`

---

## Archives

### wp_get_archives()
Displays archive links (monthly, yearly, etc.).

```php
function wp_get_archives( $args = '' )
```

**Key Arguments:**
| Argument | Description |
|----------|-------------|
| `type` | `'monthly'`, `'yearly'`, `'daily'`, `'weekly'`, `'postbypost'`, `'alpha'` |
| `limit` | Number of links |
| `format` | `'html'`, `'option'`, `'link'` |
| `show_post_count` | Display post counts |
| `post_type` | Post type |

**Example:**
```php
wp_get_archives([
    'type' => 'monthly',
    'limit' => 12,
    'show_post_count' => true
]);
```

**Source:** `wp-includes/general-template.php`
