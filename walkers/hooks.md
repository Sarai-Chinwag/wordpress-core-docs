# Walker Hooks

Filters available in WordPress Walker classes.

## Category Walkers

### `list_cats`

Filters the category name for display.

```php
apply_filters( 'list_cats', string $cat_name, WP_Term $category )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$cat_name` | `string` | Category name (already escaped in Walker_Category) |
| `$category` | `WP_Term` | Category term object |

**Used in:** `Walker_Category::start_el()`, `Walker_CategoryDropdown::start_el()`

```php
add_filter( 'list_cats', function( $name, $category ) {
    // Add emoji based on category slug
    if ( $category->slug === 'news' ) {
        return '📰 ' . $name;
    }
    return $name;
}, 10, 2 );
```

---

### `category_description`

Filters the category description used for link title.

```php
apply_filters( 'category_description', string $description, WP_Term $category )
```

**Since:** 1.2.0  
**Used in:** `Walker_Category::start_el()`

---

### `category_list_link_attributes`

Filters the HTML attributes for category list links.

```php
apply_filters( 'category_list_link_attributes', array $atts, WP_Term $category, int $depth, array $args, int $current_object_id )
```

**Since:** 5.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$atts` | `array` | Attributes: `href`, `title` |
| `$category` | `WP_Term` | Category term object |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Walker arguments |
| `$current_object_id` | `int` | Current category ID |

```php
add_filter( 'category_list_link_attributes', function( $atts, $category ) {
    // Add data attribute
    $atts['data-count'] = $category->count;
    return $atts;
}, 10, 2 );
```

---

### `category_css_class`

Filters the CSS classes for category list items.

```php
apply_filters( 'category_css_class', string[] $css_classes, WP_Term $category, int $depth, array $args )
```

**Since:** 4.2.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_classes` | `string[]` | Array of class names |
| `$category` | `WP_Term` | Category term object |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Walker arguments |

```php
add_filter( 'category_css_class', function( $classes, $category, $depth ) {
    // Add depth class
    $classes[] = 'depth-' . $depth;
    
    // Add class for categories with many posts
    if ( $category->count > 50 ) {
        $classes[] = 'popular-category';
    }
    
    return $classes;
}, 10, 3 );
```

## Page Walkers

### `page_css_class`

Filters the CSS classes for page list items.

```php
apply_filters( 'page_css_class', string[] $css_class, WP_Post $page, int $depth, array $args, int $current_page_id )
```

**Since:** 2.8.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_class` | `string[]` | Array of class names |
| `$page` | `WP_Post` | Page post object |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Walker arguments |
| `$current_page_id` | `int` | Current page ID |

```php
add_filter( 'page_css_class', function( $classes, $page, $depth ) {
    // Add template-based class
    $template = get_page_template_slug( $page->ID );
    if ( $template ) {
        $classes[] = 'template-' . sanitize_html_class( basename( $template, '.php' ) );
    }
    
    return $classes;
}, 10, 3 );
```

---

### `page_menu_link_attributes`

Filters the HTML attributes for page menu links.

```php
apply_filters( 'page_menu_link_attributes', array $atts, WP_Post $page, int $depth, array $args, int $current_page_id )
```

**Since:** 4.8.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$atts` | `array` | Attributes: `href`, `aria-current` |
| `$page` | `WP_Post` | Page post object |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Walker arguments |
| `$current_page_id` | `int` | Current page ID |

```php
add_filter( 'page_menu_link_attributes', function( $atts, $page ) {
    // Open external pages in new tab
    $external = get_post_meta( $page->ID, 'external_url', true );
    if ( $external ) {
        $atts['href']   = $external;
        $atts['target'] = '_blank';
        $atts['rel']    = 'noopener';
    }
    
    return $atts;
}, 10, 2 );
```

---

### `list_pages`

Filters the page title in dropdown lists.

```php
apply_filters( 'list_pages', string $title, WP_Post $page )
```

**Since:** 3.1.0  
**Used in:** `Walker_PageDropdown::start_el()`

```php
add_filter( 'list_pages', function( $title, $page ) {
    // Append page ID for debugging
    if ( current_user_can( 'edit_pages' ) ) {
        return $title . ' (ID: ' . $page->ID . ')';
    }
    return $title;
}, 10, 2 );
```

---

### `the_title`

Filters the page title (standard WordPress filter).

```php
apply_filters( 'the_title', string $title, int $post_id )
```

**Used in:** `Walker_Page::start_el()`

## Comment Walker

The comment walker primarily uses WordPress's comment template tags which have their own hooks:

### `comment_text`

Filters the comment text.

```php
apply_filters( 'comment_text', string $comment_text, WP_Comment|null $comment, array $args )
```

**Note:** `Walker_Comment::filter_comment_text()` hooks into this to remove links from pending comments.

### `comment_class`

Filters comment CSS classes via `get_comment_class()`.

```php
apply_filters( 'comment_class', string[] $classes, string[] $class, int $comment_id, WP_Comment $comment, int $post_id )
```

## Walker Arguments

Many walker hooks receive an `$args` array. Common elements:

```php
$args = [
    // Category/Page
    'style'              => 'list',        // 'list' or separator string
    'show_count'         => false,         // Show post count
    'current_category'   => 0,             // Current category ID(s)
    'use_desc_for_title' => true,          // Description as title attr
    
    // Page-specific
    'link_before'        => '',            // Before link text
    'link_after'         => '',            // After link text
    'show_date'          => '',            // Show post date
    'date_format'        => '',            // PHP date format
    'item_spacing'       => 'preserve',    // Preserve whitespace
    'pages_with_children' => [],           // Page IDs with children
    
    // Comment-specific
    'format'             => 'html5',       // 'html5' or ''
    'callback'           => null,          // Custom render function
    'end-callback'       => null,          // Custom end function
    'avatar_size'        => 32,            // Avatar size in pixels
    'max_depth'          => '',            // Max nesting depth
    'short_ping'         => false,         // Short pingback format
    
    // Dropdown-specific
    'selected'           => 0,             // Selected value
    'value_field'        => 'term_id',     // Field for option value
];
```

## Custom Walker Integration

When creating custom walkers, you can add your own filters:

```php
class My_Walker extends Walker {
    public function start_el( &$output, $item, $depth = 0, $args = [], $current = 0 ) {
        $classes = [ 'my-item', 'my-item-' . $item->ID ];
        
        // Allow filtering
        $classes = apply_filters( 'my_walker_item_class', $classes, $item, $depth, $args );
        
        $output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';
        $output .= esc_html( apply_filters( 'my_walker_item_title', $item->title, $item ) );
    }
}
```
