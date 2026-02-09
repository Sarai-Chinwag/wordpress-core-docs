# Walker_Page

Creates an HTML list of hierarchical pages.

**Since:** 2.1.0  
**Source:** `wp-includes/class-walker-page.php`  
**Used by:** `wp_list_pages()`

## Class Synopsis

```php
class Walker_Page extends Walker {
    public $tree_type = 'page';
    public $db_fields = [
        'parent' => 'post_parent',
        'id'     => 'ID',
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
    'parent' => 'post_parent',  // WP_Post->post_parent
    'id'     => 'ID',           // WP_Post->ID
];
```

## Methods

### `start_lvl()`

Opens a child page list container.

```php
public function start_lvl( &$output, $depth = 0, $args = [] )
```

**Output:**
```html
<ul class='children'>
```

**Item spacing:** If `$args['item_spacing'] === 'preserve'`, includes tabs and newlines for formatting.

---

### `end_lvl()`

Closes the child page list container.

```php
public function end_lvl( &$output, $depth = 0, $args = [] )
```

**Output:**
```html
</ul>
```

---

### `start_el()`

Outputs a page list item with link.

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data_object` | `WP_Post` | Page post object |
| `$depth` | `int` | Nesting depth |
| `$args` | `array` | Arguments from `wp_list_pages()` |
| `$current_object_id` | `int` | Current page ID for highlighting |

**Args used:**
- `item_spacing` — `'preserve'` for formatted output
- `pages_with_children` — Array keyed by page IDs that have children
- `link_before` / `link_after` — Content inside `<a>` before/after title
- `show_date` — `'modified'` or truthy for post date

**Output:**
```html
<li class="page_item page-item-5 current_page_item page_item_has_children">
    <a href="/about/" aria-current="page">About</a>
```

---

### `end_el()`

Closes the list item.

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
| `page_item` | Always |
| `page-item-{id}` | Always |
| `page_item_has_children` | Has child pages |
| `current_page_item` | Viewing this page |
| `current_page_parent` | Viewing a direct child |
| `current_page_ancestor` | Viewing any descendant |

## Link Attributes

The `<a>` element includes:
- `href` — Page permalink
- `aria-current="page"` — When viewing this page

## Usage Example

```php
// Direct usage
$walker = new Walker_Page();
$pages = get_pages( [
    'sort_column' => 'menu_order',
    'sort_order'  => 'ASC',
] );

echo '<ul class="page-list">';
echo $walker->walk( $pages, 0, [
    'item_spacing'  => 'preserve',
    'link_before'   => '<span>',
    'link_after'    => '</span>',
    'show_date'     => true,
    'date_format'   => 'F j, Y',
] );
echo '</ul>';

// Via wp_list_pages()
wp_list_pages( [
    'title_li'    => '',
    'sort_column' => 'menu_order',
    'walker'      => new My_Custom_Page_Walker(),
] );
```

## Extending

```php
class My_Page_Walker extends Walker_Page {
    public function start_el( &$output, $page, $depth = 0, $args = [], $current = 0 ) {
        $classes = [ 'page-item', 'page-item-' . $page->ID ];
        
        if ( $page->ID === $current ) {
            $classes[] = 'is-active';
        }
        
        // Add thumbnail
        $thumb = get_the_post_thumbnail( $page->ID, 'thumbnail' );
        
        $output .= sprintf(
            '<li class="%s"><a href="%s">%s%s</a>',
            esc_attr( implode( ' ', $classes ) ),
            esc_url( get_permalink( $page->ID ) ),
            $thumb,
            esc_html( $page->post_title )
        );
    }
}
```

## Empty Title Handling

Pages without titles display as:
```
#123 (no title)
```

This is wrapped with the `the_title` filter.

## Related

- [`wp_list_pages()`](https://developer.wordpress.org/reference/functions/wp_list_pages/) — Main function using this walker
- [`Walker_PageDropdown`](./class-walker-page-dropdown.md) — Dropdown version
- [`page_css_class`](./hooks.md#page_css_class) filter — Modify CSS classes
- [`page_menu_link_attributes`](./hooks.md#page_menu_link_attributes) filter — Modify link attributes
