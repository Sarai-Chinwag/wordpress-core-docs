# Template Tags System

Template tags are WordPress functions designed for use in theme template files. They output dynamic content, generate HTML markup, and provide access to site data directly within templates.

## Core Concept

Template tags bridge the gap between WordPress data and HTML output. Unlike internal functions, they're specifically designed to:

- Echo output directly (most functions)
- Return formatted HTML strings
- Output CSS class attributes
- Fire action hooks for extensibility

## Primary Source Files

| File | Purpose |
|------|---------|
| `general-template.php` | Core template functions (wp_head, wp_footer, bloginfo, get_header, etc.) |
| `post-template.php` | Post-specific tags (the_title, the_content, post_class, body_class) |
| `author-template.php` | Author functions (the_author, get_the_author_meta, author_posts_url) |
| `category-template.php` | Category/term functions (the_category, wp_list_categories, tag_cloud) |
| `link-template.php` | URL functions (the_permalink, get_permalink, home_url) |
| `comment-template.php` | Comment display functions |

## Template Structure

A typical WordPress template follows this pattern:

```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php get_header(); ?>

<!-- Main content with The Loop -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </article>
<?php endwhile; endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php wp_footer(); ?>
</body>
</html>
```

## Template Part Loading

WordPress loads template parts via a hierarchy system:

### Primary Parts
- `get_header($name)` → loads `header-{$name}.php` or `header.php`
- `get_footer($name)` → loads `footer-{$name}.php` or `footer.php`
- `get_sidebar($name)` → loads `sidebar-{$name}.php` or `sidebar.php`
- `get_template_part($slug, $name)` → loads `{$slug}-{$name}.php` or `{$slug}.php`

### Loading Process
1. Fire action hook (e.g., `get_header`)
2. Build template name array (specialized first, then default)
3. Use `locate_template()` to find in child theme, then parent theme
4. Include the template via `require`

### Passing Data to Templates (WP 5.5+)
```php
get_template_part('parts/card', 'product', [
    'product_id' => 123,
    'show_price' => true,
]);

// In parts/card-product.php:
$product_id = $args['product_id'];
```

## Hook Integration Points

Template tags fire hooks at critical rendering points:

| Hook | Location | Purpose |
|------|----------|---------|
| `wp_head` | Inside `<head>` | Enqueue styles, meta tags, scripts |
| `wp_footer` | Before `</body>` | Footer scripts, tracking codes |
| `wp_body_open` | After `<body>` | Skip links, overlay containers |
| `body_class` | Filter | Add/modify body CSS classes |
| `post_class` | Filter | Add/modify post wrapper classes |
| `the_title` | Filter | Modify post titles |
| `the_content` | Filter | Process post content |

## Display vs Get Pattern

Most template tags follow a dual-function pattern:

| Display Function | Get Function | Purpose |
|-----------------|--------------|---------|
| `the_title()` | `get_the_title()` | Post title |
| `the_content()` | `get_the_content()` | Post content |
| `the_excerpt()` | `get_the_excerpt()` | Post excerpt |
| `the_permalink()` | `get_permalink()` | Post URL |
| `the_category()` | `get_the_category_list()` | Category links |
| `bloginfo()` | `get_bloginfo()` | Site information |

**Convention:**
- `the_*()` functions **echo** output
- `get_the_*()` functions **return** values

## Conditional Tags

Template tags work with conditional functions to control output:

```php
if (is_single()) {
    the_content();
} elseif (is_archive()) {
    the_excerpt();
}

if (has_post_thumbnail()) {
    the_post_thumbnail('large');
}

if (is_user_logged_in()) {
    echo 'Welcome, ' . wp_get_current_user()->display_name;
}
```

## The Loop Context

Many template tags require being inside The Loop:

```php
<?php while (have_posts()) : the_post(); ?>
    <!-- These functions work because $post is set -->
    <?php the_ID(); ?>
    <?php the_title(); ?>
    <?php the_content(); ?>
    <?php the_author(); ?>
    <?php the_date(); ?>
<?php endwhile; ?>
```

Functions that work outside The Loop require a post ID parameter:
```php
get_the_title($post_id);
get_permalink($post_id);
get_post_class('', $post_id);
```

## Theme Support Dependencies

Some template tags require theme support:

```php
// In functions.php
add_theme_support('title-tag');        // Required for wp_title() automatic handling
add_theme_support('post-thumbnails');  // Required for the_post_thumbnail()
add_theme_support('automatic-feed-links'); // Required for feed_links()
add_theme_support('html5', ['search-form', 'comment-form']);
```

## Escaping Considerations

Template tags handle their own escaping, but when building custom output:

```php
// Already escaped by WordPress:
the_title();           // Applies 'the_title' filter
bloginfo('name');      // Escaped via esc_html in 'display' context

// Manual escaping needed:
echo esc_html(get_the_title());  // When modifying before output
echo esc_url(get_permalink());   // URLs in href attributes
echo esc_attr(get_the_title());  // In HTML attributes
```

## Related Systems

- **Block Editor**: Modern themes use block patterns and templates
- **Template Hierarchy**: Determines which template file loads
- **Theme JSON**: Block theme configuration
- **Hooks System**: Extends template output
