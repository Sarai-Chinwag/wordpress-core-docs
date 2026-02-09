# Walker (Base Class)

Abstract class for displaying hierarchical tree structures.

**Since:** 2.1.0  
**Source:** `wp-includes/class-wp-walker.php`

## Class Synopsis

```php
#[AllowDynamicProperties]
class Walker {
    // Properties
    public string   $tree_type;
    public string[] $db_fields;
    public int      $max_pages = 1;
    public bool     $has_children;
    
    // Abstract methods (override in child classes)
    public function start_lvl( &$output, $depth = 0, $args = [] );
    public function end_lvl( &$output, $depth = 0, $args = [] );
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 );
    public function end_el( &$output, $data_object, $depth = 0, $args = [] );
    
    // Traversal methods
    public function walk( $elements, $max_depth, ...$args ): string;
    public function paged_walk( $elements, $max_depth, $page_num, $per_page, ...$args ): string;
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output );
    public function get_number_of_root_elements( $elements ): int;
    public function unset_children( $element, &$children_elements );
}
```

## Properties

### `$tree_type`

```php
public string $tree_type;
```

Identifies what type of data this walker handles. Examples: `'category'`, `'page'`, `'comment'`.

---

### `$db_fields`

```php
public string[] $db_fields;
```

Maps the element's ID and parent fields:

```php
public $db_fields = [
    'parent' => 'parent',    // Field name containing parent ID
    'id'     => 'term_id',   // Field name containing element ID
];
```

---

### `$max_pages`

```php
public int $max_pages = 1;
```

Set by `paged_walk()` after traversal. Contains the total number of pages for the element set.

---

### `$has_children`

```php
public bool $has_children;
```

**Since:** 4.0.0

Set before calling `start_el()`. Indicates whether the current element has children. Useful for adding CSS classes like `'has-children'`.

## Abstract Methods

These methods are empty in the base class. Override them to generate output.

### `start_lvl()`

```php
public function start_lvl( &$output, $depth = 0, $args = [] )
```

Called before outputting child elements. Typically opens a `<ul>` or similar container.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | `string` | Passed by reference; append content here |
| `$depth` | `int` | Current nesting depth (0-indexed) |
| `$args` | `array` | Additional arguments passed to `walk()` |

---

### `end_lvl()`

```php
public function end_lvl( &$output, $depth = 0, $args = [] )
```

Called after outputting child elements. Closes the container opened by `start_lvl()`.

---

### `start_el()`

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 )
```

Outputs the beginning of an element.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output` | `string` | Passed by reference |
| `$data_object` | `object` | The current element (term, post, comment) |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Additional arguments |
| `$current_object_id` | `int` | ID of the "current" element (for highlighting) |

**Note:** Parameter was renamed from `$object` to `$data_object` in WP 5.9.0 for PHP 8 named parameter support.

---

### `end_el()`

```php
public function end_el( &$output, $data_object, $depth = 0, $args = [] )
```

Outputs the end of an element. Typically closes tags opened in `start_el()`.

## Traversal Methods

### `walk()`

```php
public function walk( $elements, $max_depth, ...$args ): string
```

Main entry point. Traverses elements and returns HTML output.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$elements` | `array` | Array of data objects to traverse |
| `$max_depth` | `int` | Maximum depth (-1=flat, 0=unlimited, >0=limit) |
| `...$args` | `mixed` | Additional arguments passed to element methods |

**Returns:** `string` — The generated HTML.

**Depth Values:**

| Value | Meaning |
|-------|---------|
| `-1` | Flat display, ignore hierarchy |
| `0` | Display all levels |
| `1` | Root elements only |
| `2` | Root + one level of children |
| `n` | Root + (n-1) levels |

---

### `paged_walk()`

```php
public function paged_walk( $elements, $max_depth, $page_num, $per_page, ...$args ): string
```

**Since:** 2.7.0

Produces a single page of nested elements. Used for paginated displays like threaded comments.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$elements` | `array` | All elements |
| `$max_depth` | `int` | Maximum nesting depth |
| `$page_num` | `int` | Page number (1-indexed) |
| `$per_page` | `int` | Root elements per page |
| `...$args` | `mixed` | Additional arguments |

**Returns:** `string` — HTML for the requested page.

After calling, `$this->max_pages` contains the total page count.

**Special args:**
- `$args[0]['reverse_top_level']` — Reverse root element order
- `$args[0]['reverse_children']` — Reverse child element order

---

### `display_element()`

```php
public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output )
```

Recursive method that renders a single element and its descendants. Called internally by `walk()`.

| Parameter | Type | Description |
|-----------|------|-------------|
| `$element` | `object` | Current element |
| `&$children_elements` | `array` | All children, keyed by parent ID (modified) |
| `$max_depth` | `int` | Maximum depth |
| `$depth` | `int` | Current depth |
| `$args` | `array` | Arguments array |
| `&$output` | `string` | Output buffer (modified) |

**Flow:**
1. Sets `$this->has_children`
2. Calls `start_el()`
3. If depth allows and children exist:
   - Calls `start_lvl()`
   - Recursively processes children
   - Removes processed children from `$children_elements`
   - Calls `end_lvl()`
4. Calls `end_el()`

---

### `get_number_of_root_elements()`

```php
public function get_number_of_root_elements( $elements ): int
```

**Since:** 2.7.0

Counts elements with an empty parent field.

---

### `unset_children()`

```php
public function unset_children( $element, &$children_elements )
```

**Since:** 2.7.0

Recursively removes an element's descendants from `$children_elements`. Used by `paged_walk()` to prevent orphans from appearing on wrong pages.

## Usage Example

```php
// Using with wp_list_categories()
$walker = new Walker_Category();
$output = $walker->walk(
    get_terms( [ 'taxonomy' => 'category', 'hide_empty' => false ] ),
    0,  // Unlimited depth
    [ 'style' => 'list', 'show_count' => true ]
);

// Custom walker
class Simple_Walker extends Walker {
    public $tree_type = 'item';
    public $db_fields = [ 'parent' => 'parent_id', 'id' => 'id' ];
    
    public function start_el( &$output, $item, $depth = 0, $args = [], $current = 0 ) {
        $indent = str_repeat( '  ', $depth );
        $output .= $indent . "- {$item->name}\n";
    }
}
```

## Implementation Notes

1. **Pass by reference** — Output is built by appending to `$output` reference, not by returning values
2. **Orphan recovery** — If no root elements exist, the first element's parent is treated as the root level
3. **Dynamic properties** — The `#[AllowDynamicProperties]` attribute allows child classes to add custom properties
4. **Backward compatibility** — `$args[0]['has_children']` is set for back-compat with older walker implementations
