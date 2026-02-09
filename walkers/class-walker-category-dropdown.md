# Walker_CategoryDropdown

Creates an HTML dropdown (`<option>` elements) for categories.

**Since:** 2.1.0  
**Source:** `wp-includes/class-walker-category-dropdown.php`  
**Used by:** `wp_dropdown_categories()`

## Class Synopsis

```php
class Walker_CategoryDropdown extends Walker {
    public $tree_type = 'category';
    public $db_fields = [
        'parent' => 'parent',
        'id'     => 'term_id',
    ];
    
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 );
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

### `start_el()`

Outputs a single `<option>` element for a category.

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data_object` | `WP_Term` | Category term object |
| `$depth` | `int` | Nesting depth (used for indentation) |
| `$args` | `array` | Arguments from `wp_dropdown_categories()` |
| `$current_object_id` | `int` | Not used |

**Args used:**
- `selected` — Value to mark as selected
- `show_count` — Append post count
- `value_field` — Term field to use for option value (default: `'term_id'`)

**Output:**
```html
<option class="level-0" value="5">News</option>
<option class="level-1" value="8">&nbsp;&nbsp;&nbsp;Local News</option>
<option class="level-1" value="9" selected="selected">&nbsp;&nbsp;&nbsp;World News&nbsp;&nbsp;(42)</option>
```

## No List Methods

This walker only implements `start_el()`. Dropdowns don't need:
- `start_lvl()` / `end_lvl()` — No container elements between levels
- `end_el()` — `<option>` is self-closing in the context

## Depth Indication

Hierarchy is shown through `&nbsp;` padding:
- Depth 0: No padding
- Depth 1: 3 `&nbsp;` characters
- Depth 2: 6 `&nbsp;` characters
- Depth n: `n * 3` `&nbsp;` characters

## Usage Example

```php
// Direct usage
$walker = new Walker_CategoryDropdown();
$categories = get_terms( [
    'taxonomy'   => 'category',
    'hide_empty' => false,
] );

echo '<select name="cat">';
echo '<option value="">Select Category</option>';
echo $walker->walk( $categories, 0, [
    'selected'    => get_query_var( 'cat' ),
    'show_count'  => true,
    'value_field' => 'slug',  // Use slug instead of term_id
] );
echo '</select>';

// Via wp_dropdown_categories()
wp_dropdown_categories( [
    'show_option_none' => 'Select Category',
    'selected'         => $current_cat,
    'hierarchical'     => true,
    'value_field'      => 'term_id',
] );
```

## Custom Value Field

The `value_field` argument lets you change what's used for the option value:

```php
// Use term slug
wp_dropdown_categories( [
    'value_field' => 'slug',
] );
// Output: <option value="news">News</option>

// Use term_id (default)
wp_dropdown_categories( [
    'value_field' => 'term_id',
] );
// Output: <option value="5">News</option>
```

## Extending

```php
class My_Category_Dropdown extends Walker_CategoryDropdown {
    public function start_el( &$output, $category, $depth = 0, $args = [], $current = 0 ) {
        $pad = str_repeat( '— ', $depth );  // Use dashes instead of spaces
        
        $output .= sprintf(
            '<option value="%s"%s>%s%s</option>',
            esc_attr( $category->term_id ),
            selected( $args['selected'], $category->term_id, false ),
            $pad,
            esc_html( $category->name )
        );
    }
}
```

## Related

- [`wp_dropdown_categories()`](https://developer.wordpress.org/reference/functions/wp_dropdown_categories/) — Main function using this walker
- [`Walker_Category`](./class-walker-category.md) — List version
- [`list_cats`](./hooks.md#list_cats) filter — Modify category name
