# Walker_Category

Creates an HTML list of categories.

**Since:** 2.1.0  
**Source:** `wp-includes/class-walker-category.php`  
**Used by:** `wp_list_categories()`

## Class Synopsis

```php
class Walker_Category extends Walker {
    public $tree_type = 'category';
    public $db_fields = [
        'parent' => 'parent',
        'id'     => 'term_id',
    ];
    
    public function start_lvl( &$output, $depth = 0, $args = [] );
    public function end_lvl( &$output, $depth = 0, $args = [] );
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 );
    public function end_el( &$output, $data_object, $depth = 0, $args = [] );
}
```

## Configuration

### `$db_fields`

```php
public $db_fields = [
    'parent' => 'parent',    // WP_Term->parent
    'id'     => 'term_id',   // WP_Term->term_id
];
```

## Methods

### `start_lvl()`

Opens a child category list. Only outputs if `$args['style'] === 'list'`.

```php
public function start_lvl( &$output, $depth = 0, $args = [] )
```

**Output:**
```html
<ul class='children'>
```

---

### `end_lvl()`

Closes the child category list.

```php
public function end_lvl( &$output, $depth = 0, $args = [] )
```

**Output:**
```html
</ul>
```

---

### `start_el()`

Outputs a category list item with link.

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data_object` | `WP_Term` | Category term object |
| `$depth` | `int` | Nesting depth |
| `$args` | `array` | Arguments from `wp_list_categories()` |
| `$current_object_id` | `int` | Current category ID for highlighting |

**Args used:**
- `style` — `'list'` for `<li>`, otherwise uses separator
- `use_desc_for_title` — Use description as link title
- `feed` / `feed_image` / `feed_type` — Add RSS feed link
- `show_count` — Append post count
- `current_category` — ID(s) of current category for CSS classes
- `separator` — Text between categories when not list style

**Output formats:**

List style (`$args['style'] === 'list'`):
```html
<li class="cat-item cat-item-5 current-cat">
    <a href="/category/news/" aria-current="page">News</a> (42)
```

Separator style:
```html
    <a href="/category/news/">News</a> |
```

Default:
```html
    <a href="/category/news/">News</a><br />
```

---

### `end_el()`

Closes the list item (list style only).

```php
public function end_el( &$output, $data_object, $depth = 0, $args = [] )
```

**Output:**
```html
</li>
```

## CSS Classes

Applied to `<li>` elements:

| Class | Condition |
|-------|-----------|
| `cat-item` | Always |
| `cat-item-{id}` | Always |
| `current-cat` | Viewing this category |
| `current-cat-parent` | Viewing a direct child |
| `current-cat-ancestor` | Viewing any descendant |

## Usage Example

```php
// Direct usage
$walker = new Walker_Category();
$categories = get_terms( [
    'taxonomy'   => 'category',
    'hide_empty' => true,
] );

echo '<ul>';
echo $walker->walk( $categories, 0, [
    'style'             => 'list',
    'show_count'        => true,
    'use_desc_for_title' => true,
    'current_category'  => get_queried_object_id(),
] );
echo '</ul>';

// Via wp_list_categories() with custom walker
wp_list_categories( [
    'walker' => new My_Custom_Category_Walker(),
    'title_li' => '',
] );
```

## Extending

```php
class My_Category_Walker extends Walker_Category {
    public function start_el( &$output, $category, $depth = 0, $args = [], $current = 0 ) {
        // Add icon before category name
        $icon = get_term_meta( $category->term_id, 'icon', true );
        $output .= '<li>';
        $output .= '<a href="' . esc_url( get_term_link( $category ) ) . '">';
        if ( $icon ) {
            $output .= '<span class="icon">' . esc_html( $icon ) . '</span> ';
        }
        $output .= esc_html( $category->name );
        $output .= '</a>';
    }
}
```

## Related

- [`wp_list_categories()`](https://developer.wordpress.org/reference/functions/wp_list_categories/) — Main function using this walker
- [`Walker_CategoryDropdown`](./class-walker-category-dropdown.md) — Dropdown version
- [`list_cats`](./hooks.md#list_cats) filter — Modify category name
- [`category_css_class`](./hooks.md#category_css_class) filter — Modify CSS classes
