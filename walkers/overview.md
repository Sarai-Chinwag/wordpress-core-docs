# Walker Classes

Abstract pattern for traversing and rendering hierarchical tree structures.

**Since:** 2.1.0  
**Source:** `wp-includes/class-wp-walker.php`, `wp-includes/class-walker-*.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-walker.md](./class-wp-walker.md) | Base abstract Walker class |
| [class-walker-category.md](./class-walker-category.md) | HTML list of categories |
| [class-walker-category-dropdown.md](./class-walker-category-dropdown.md) | Category dropdown `<select>` |
| [class-walker-comment.md](./class-walker-comment.md) | Threaded comment list |
| [class-walker-page.md](./class-walker-page.md) | Hierarchical page list |
| [class-walker-page-dropdown.md](./class-walker-page-dropdown.md) | Page dropdown `<select>` |
| [hooks.md](./hooks.md) | Walker-related filters |

## The Walker Pattern

Walker is WordPress's implementation of the Visitor pattern for tree traversal. It separates:

1. **Traversal logic** — How to walk the tree (handled by base class)
2. **Rendering logic** — How to output each element (handled by child classes)

```
Walker (base)
    ├── walk()           → Entry point, builds parent/child buckets
    ├── paged_walk()     → Paginated traversal
    ├── display_element() → Recursive descent
    │       ├── start_el()   → Open element
    │       ├── start_lvl()  → Open child list
    │       │     └── [recurse children]
    │       ├── end_lvl()    → Close child list
    │       └── end_el()     → Close element
    └── get_number_of_root_elements()
```

## Tree Traversal Algorithm

### 1. Bucket Sort

`walk()` first separates elements into two buckets:

```php
$top_level_elements = [];  // parent field is empty
$children_elements  = [];  // keyed by parent ID
```

### 2. Recursive Descent

For each top-level element, `display_element()` recursively:

1. Calls `start_el()` to open the element
2. If children exist and depth allows:
   - Calls `start_lvl()` to open the child container
   - Recursively processes each child
   - Calls `end_lvl()` to close the child container
3. Calls `end_el()` to close the element

### 3. Orphan Handling

Elements whose parents don't exist in the set are displayed as root elements (orphan recovery).

## Depth Control

| `$max_depth` | Behavior |
|--------------|----------|
| `-1` | Flat display (no hierarchy) |
| `0` | Display all levels (unlimited) |
| `> 0` | Display that many levels |

## Required Properties

Child classes must define:

```php
public $tree_type = 'category';  // What type of data
public $db_fields = [
    'parent' => 'parent',        // Field containing parent ID
    'id'     => 'term_id',       // Field containing element ID
];
```

## Output Pattern

All methods append to `$output` by reference:

```php
public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ) {
    $output .= '<li>' . esc_html( $data_object->name );
}
```

## Creating a Custom Walker

```php
class My_Walker extends Walker {
    public $tree_type = 'my_type';
    public $db_fields = [
        'parent' => 'parent_id',
        'id'     => 'id',
    ];
    
    public function start_lvl( &$output, $depth = 0, $args = [] ) {
        $output .= '<ul class="depth-' . $depth . '">';
    }
    
    public function end_lvl( &$output, $depth = 0, $args = [] ) {
        $output .= '</ul>';
    }
    
    public function start_el( &$output, $data_object, $depth = 0, $args = [], $current_object_id = 0 ) {
        $output .= '<li>';
        $output .= esc_html( $data_object->title );
    }
    
    public function end_el( &$output, $data_object, $depth = 0, $args = [] ) {
        $output .= '</li>';
    }
}

// Usage
$walker = new My_Walker();
echo $walker->walk( $items, 0 );  // 0 = unlimited depth
```

## Built-in Walkers Comparison

| Walker | Data Type | Output Format | Used By |
|--------|-----------|---------------|---------|
| `Walker_Category` | `WP_Term` | `<ul>/<li>` or separator | `wp_list_categories()` |
| `Walker_CategoryDropdown` | `WP_Term` | `<option>` | `wp_dropdown_categories()` |
| `Walker_Comment` | `WP_Comment` | `<ul>/<li>` or `<div>` | `wp_list_comments()` |
| `Walker_Page` | `WP_Post` | `<ul>/<li>` | `wp_list_pages()` |
| `Walker_PageDropdown` | `WP_Post` | `<option>` | `wp_dropdown_pages()` |
| `Walker_Nav_Menu` | `WP_Post` | `<ul>/<li>` | `wp_nav_menu()` |

## Paged Walking

For paginated tree display (e.g., threaded comments):

```php
$walker = new Walker_Comment();
$output = $walker->paged_walk(
    $comments,
    $max_depth,    // Max nesting depth
    $page_num,     // Current page (1-indexed)
    $per_page,     // Items per page
    $args
);

// After walking, check total pages:
$total_pages = $walker->max_pages;
```
