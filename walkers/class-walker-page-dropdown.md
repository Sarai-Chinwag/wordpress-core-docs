# Walker_PageDropdown

Creates an HTML dropdown (`<option>` elements) for hierarchical pages.

**Since:** 2.1.0  
**Source:** `wp-includes/class-walker-page-dropdown.php`  
**Used by:** `wp_dropdown_pages()`

## Class Synopsis

```php
class Walker_PageDropdown extends Walker {
    public $tree_type = 'page';
    public $db_fields = [
        'parent' => 'post_parent',
        'id'     => 'ID',
    ];
    
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 );
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

### `start_el()`

Outputs a single `<option>` element for a page.

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data_object` | `WP_Post` | Page post object |
| `$depth` | `int` | Nesting depth (used for indentation) |
| `$args` | `array` | Arguments from `wp_dropdown_pages()` |
| `$current_object_id` | `int` | Not used |

**Args used:**
- `selected` — Page ID to mark as selected
- `value_field` — Post field for option value (default: `'ID'`)

**Output:**
```html
<option class="level-0" value="2">About Us</option>
<option class="level-1" value="5">&nbsp;&nbsp;&nbsp;Our Team</option>
<option class="level-1" value="7" selected="selected">&nbsp;&nbsp;&nbsp;Contact</option>
```

## No List Methods

This walker only implements `start_el()`. Dropdowns don't need container methods.

## Depth Indication

Hierarchy is shown through `&nbsp;` padding:
- Depth 0: No padding
- Depth 1: 3 `&nbsp;` characters
- Depth n: `n * 3` `&nbsp;` characters

## Empty Title Handling

Pages without titles display as:
```
#123 (no title)
```

## Usage Example

```php
// Direct usage
$walker = new Walker_PageDropdown();
$pages = get_pages( [
    'sort_column' => 'menu_order',
] );

echo '<select name="page_id">';
echo '<option value="">Select a page</option>';
echo $walker->walk( $pages, 0, [
    'selected'    => get_the_ID(),
    'value_field' => 'ID',
] );
echo '</select>';

// Via wp_dropdown_pages()
wp_dropdown_pages( [
    'name'              => 'parent_page',
    'show_option_none'  => '(no parent)',
    'option_none_value' => '0',
    'selected'          => $post->post_parent,
] );
```

## Custom Value Field

The `value_field` argument lets you change what's used for the option value:

```php
// Use post_name (slug)
wp_dropdown_pages( [
    'value_field' => 'post_name',
] );
// Output: <option value="about-us">About Us</option>

// Use ID (default)
wp_dropdown_pages( [
    'value_field' => 'ID',
] );
// Output: <option value="2">About Us</option>
```

## Extending

```php
class My_Page_Dropdown extends Walker_PageDropdown {
    public function start_el( &$output, $page, $depth = 0, $args = [], $current = 0 ) {
        $pad = str_repeat( '— ', $depth );  // Use dashes instead of spaces
        
        $title = $page->post_title ?: sprintf( '#%d (no title)', $page->ID );
        
        $output .= sprintf(
            '<option value="%d"%s data-template="%s">%s%s</option>',
            $page->ID,
            selected( $args['selected'], $page->ID, false ),
            esc_attr( get_page_template_slug( $page->ID ) ),
            $pad,
            esc_html( $title )
        );
    }
}
```

## Related

- [`wp_dropdown_pages()`](https://developer.wordpress.org/reference/functions/wp_dropdown_pages/) — Main function using this walker
- [`Walker_Page`](./class-walker-page.md) — List version
- [`list_pages`](./hooks.md#list_pages) filter — Modify page title in dropdown
