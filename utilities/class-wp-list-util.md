# WP_List_Util

Utility class for performing operations on arrays of objects or arrays.

**Source:** `wp-includes/class-wp-list-util.php`  
**Since:** 4.7.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$input` | array | private | Original input array |
| `$output` | array | private | Current output array (after operations) |
| `$orderby` | string[] | private | Temporary sort fields |

---

## Methods

### __construct()

Sets the input array.

```php
public function __construct( array $input )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | array | Array of objects or arrays to operate on |

---

### get_input()

Returns the original input array.

```php
public function get_input(): array
```

**Returns:** The unmodified input array.

---

### get_output()

Returns the current output array.

```php
public function get_output(): array
```

**Returns:** The array after any filter/pluck/sort operations.

---

### filter()

Filters the list based on key => value arguments.

```php
public function filter( array $args = array(), string $operator = 'AND' ): array
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$args` | array | `[]` | Key-value pairs to match |
| `$operator` | string | `'AND'` | Logical operator: `'AND'`, `'OR'`, or `'NOT'` |

**Returns:** Array of matching elements.

**Operators:**
- `AND` — All conditions must match
- `OR` — At least one condition must match
- `NOT` — No conditions may match

**Example:**

```php
$posts = array(
    array( 'ID' => 1, 'post_status' => 'publish', 'post_type' => 'post' ),
    array( 'ID' => 2, 'post_status' => 'draft', 'post_type' => 'post' ),
    array( 'ID' => 3, 'post_status' => 'publish', 'post_type' => 'page' ),
);

$util = new WP_List_Util( $posts );

// AND: published posts only
$published = $util->filter( array( 'post_status' => 'publish' ) );
// Returns IDs 1 and 3

// OR: published OR pages
$util = new WP_List_Util( $posts );
$result = $util->filter( 
    array( 'post_status' => 'publish', 'post_type' => 'page' ), 
    'OR' 
);
// Returns IDs 1, 3 (both match at least one condition)

// NOT: exclude drafts
$util = new WP_List_Util( $posts );
$not_draft = $util->filter( array( 'post_status' => 'draft' ), 'NOT' );
// Returns IDs 1 and 3
```

---

### pluck()

Extracts a specific field from each element.

```php
public function pluck( int|string $field, int|string $index_key = null ): array
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$field` | int\|string | — | Field to extract |
| `$index_key` | int\|string | `null` | Field to use as array keys |

**Returns:** Array of extracted values.

**Example:**

```php
$users = array(
    (object) array( 'ID' => 1, 'user_login' => 'admin', 'user_email' => 'admin@example.com' ),
    (object) array( 'ID' => 2, 'user_login' => 'editor', 'user_email' => 'editor@example.com' ),
);

$util = new WP_List_Util( $users );

// Extract all logins
$logins = $util->pluck( 'user_login' );
// Returns: ['admin', 'editor']

// Extract emails keyed by ID
$util = new WP_List_Util( $users );
$emails = $util->pluck( 'user_email', 'ID' );
// Returns: [1 => 'admin@example.com', 2 => 'editor@example.com']
```

---

### sort()

Sorts the array by one or more fields.

```php
public function sort( 
    string|array $orderby = array(), 
    string $order = 'ASC', 
    bool $preserve_keys = false 
): array
```

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$orderby` | string\|array | `[]` | Field name or `['field' => 'ASC\|DESC']` |
| `$order` | string | `'ASC'` | Sort direction (if `$orderby` is string) |
| `$preserve_keys` | bool | `false` | Whether to preserve array keys |

**Returns:** Sorted array.

**Example:**

```php
$items = array(
    array( 'title' => 'Banana', 'price' => 1.50, 'stock' => 10 ),
    array( 'title' => 'Apple', 'price' => 2.00, 'stock' => 5 ),
    array( 'title' => 'Cherry', 'price' => 3.00, 'stock' => 10 ),
);

$util = new WP_List_Util( $items );

// Sort by title ascending
$by_title = $util->sort( 'title' );

// Sort by price descending
$util = new WP_List_Util( $items );
$by_price = $util->sort( 'price', 'DESC' );

// Multi-field sort: stock DESC, then title ASC
$util = new WP_List_Util( $items );
$multi = $util->sort( array(
    'stock' => 'DESC',
    'title' => 'ASC',
) );
// Cherry, Banana (stock=10), then Apple (stock=5)
```

---

### sort_callback() <small>(private)</small>

Comparison callback used by `sort()`.

```php
private function sort_callback( object|array $a, object|array $b ): int
```

Handles both numeric and string comparisons.

---

## Chaining

Methods modify `$output` and return the result, enabling chaining:

```php
$util = new WP_List_Util( $posts );

$result = $util
    ->filter( array( 'post_status' => 'publish' ) )
    ->sort( 'post_date', 'DESC' )
    ->pluck( 'post_title', 'ID' );
```

Note: Each method operates on the current `$output`, not the original `$input`.

---

## Helper Functions

WordPress provides wrapper functions that instantiate `WP_List_Util`:

| Function | Method |
|----------|--------|
| `wp_list_filter( $input, $args, $operator )` | `filter()` |
| `wp_list_pluck( $input, $field, $index_key )` | `pluck()` |
| `wp_list_sort( $input, $orderby, $order, $preserve_keys )` | `sort()` |

**Example:**

```php
// Equivalent operations
$filtered = wp_list_filter( $posts, array( 'post_status' => 'publish' ) );

$util = new WP_List_Util( $posts );
$filtered = $util->filter( array( 'post_status' => 'publish' ) );
```
