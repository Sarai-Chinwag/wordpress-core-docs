# WP_Block_List

Class representing a list of block instances.

**Since:** 5.5.0  
**Source:** `wp-includes/class-wp-block-list.php`

## Description

`WP_Block_List` is an iterable collection of `WP_Block` instances. It implements `Iterator`, `ArrayAccess`, and `Countable` interfaces for convenient traversal. Block instances are lazily created from parsed block arrays.

## Interfaces

- **Iterator** - Enables `foreach` iteration
- **ArrayAccess** - Enables array-style access (`$list[0]`)
- **Countable** - Enables `count($list)`

## Properties

### $blocks (protected)

Original array of parsed block data or block instances.

```php
protected array[]|WP_Block[] $blocks
```

**Since:** 5.5.0

---

### $available_context (protected)

All available context from the current hierarchy.

```php
protected array $available_context
```

**Since:** 5.5.0

---

### $registry (protected)

Block type registry instance.

```php
protected WP_Block_Type_Registry $registry
```

**Since:** 5.5.0

---

## Methods

### __construct()

Constructor. Initializes the block list.

```php
public function __construct(
    array[]|WP_Block[] $blocks,
    array $available_context = array(),
    WP_Block_Type_Registry $registry = null
)
```

**Parameters:**
- `$blocks` *(array[]|WP_Block[])* - Array of parsed block data or block instances
- `$available_context` *(array)* - Optional. Ancestry context values
- `$registry` *(WP_Block_Type_Registry)* - Optional. Block type registry

**Since:** 5.5.0

**Example:**
```php
$parsed_blocks = parse_blocks( $content );

$block_list = new WP_Block_List(
    $parsed_blocks,
    array( 'postId' => 123 )
);

foreach ( $block_list as $block ) {
    echo $block->render();
}
```

---

## ArrayAccess Methods

### offsetExists()

Checks if a block exists at the specified offset.

```php
public function offsetExists( int $offset ): bool
```

**Parameters:**
- `$offset` *(int)* - Offset to check

**Returns:** *(bool)* - Whether block exists

**Since:** 5.5.0

**Example:**
```php
if ( isset( $block_list[0] ) ) {
    // First block exists
}
```

---

### offsetGet()

Returns the block at the specified offset.

```php
public function offsetGet( int $offset ): WP_Block|null
```

**Parameters:**
- `$offset` *(int)* - Offset of block

**Returns:** *(WP_Block|null)* - Block instance or null

**Since:** 5.5.0

Lazily converts parsed array to `WP_Block` instance on first access.

**Example:**
```php
$first_block = $block_list[0];
$second_block = $block_list[1];

// Both are now WP_Block instances
echo $first_block->name;
```

---

### offsetSet()

Assigns a block at the specified offset.

```php
public function offsetSet( int $offset, array|WP_Block $value ): void
```

**Parameters:**
- `$offset` *(int)* - Offset to set
- `$value` *(array|WP_Block)* - Block data or instance

**Since:** 5.5.0

**Example:**
```php
// Set at specific index
$block_list[0] = $new_block;

// Append to end
$block_list[] = $another_block;
```

---

### offsetUnset()

Removes a block from the list.

```php
public function offsetUnset( int $offset ): void
```

**Parameters:**
- `$offset` *(int)* - Offset to unset

**Since:** 5.5.0

**Example:**
```php
unset( $block_list[2] );
```

---

## Iterator Methods

### rewind()

Rewinds to the first element.

```php
public function rewind(): void
```

**Since:** 5.5.0

---

### current()

Returns the current block.

```php
public function current(): WP_Block|null
```

**Returns:** *(WP_Block|null)* - Current block instance

**Since:** 5.5.0

---

### key()

Returns the key of the current element.

```php
public function key(): int|null
```

**Returns:** *(int|null)* - Current key

**Since:** 5.5.0

---

### next()

Moves to the next element.

```php
public function next(): void
```

**Since:** 5.5.0

---

### valid()

Checks if current position is valid.

```php
public function valid(): bool
```

**Returns:** *(bool)* - Whether current position is valid

**Since:** 5.5.0

---

## Countable Method

### count()

Returns the count of blocks in the list.

```php
public function count(): int
```

**Returns:** *(int)* - Block count

**Since:** 5.5.0

**Example:**
```php
$count = count( $block_list );

if ( $count > 0 ) {
    // Has blocks
}
```

---

## Usage Examples

### Basic Iteration

```php
$blocks = parse_blocks( $post->post_content );
$block_list = new WP_Block_List( $blocks );

foreach ( $block_list as $block ) {
    echo $block->name . ': ' . $block->render() . "\n";
}
```

### Array-Style Access

```php
$block_list = new WP_Block_List( $parsed_blocks );

// Get first block
$first = $block_list[0];

// Check count
if ( count( $block_list ) > 0 ) {
    echo "Has " . count( $block_list ) . " blocks";
}

// Iterate with index
for ( $i = 0; $i < count( $block_list ); $i++ ) {
    $block = $block_list[ $i ];
    echo "$i: {$block->name}\n";
}
```

### With Context

```php
$context = array(
    'postId'   => 123,
    'postType' => 'post',
);

$block_list = new WP_Block_List( $parsed_blocks, $context );

// Each block receives context
foreach ( $block_list as $block ) {
    // $block->context contains applicable context values
    echo $block->context['postId'] ?? 'No postId';
}
```

### Inner Blocks

`WP_Block::$inner_blocks` is a `WP_Block_List`:

```php
$parent = new WP_Block( $parsed_parent );

// inner_blocks is WP_Block_List
foreach ( $parent->inner_blocks as $child ) {
    echo "Child: " . $child->name . "\n";
    
    // Nested inner blocks
    foreach ( $child->inner_blocks as $grandchild ) {
        echo "  Grandchild: " . $grandchild->name . "\n";
    }
}
```

### Filter by Block Type

```php
$block_list = new WP_Block_List( $parsed_blocks );
$images = array();

foreach ( $block_list as $block ) {
    if ( 'core/image' === $block->name ) {
        $images[] = $block;
    }
}
```

### Lazy Instantiation

Blocks are only converted to `WP_Block` when accessed:

```php
$block_list = new WP_Block_List( $parsed_blocks );

// At this point, $parsed_blocks still contains raw arrays

// Access first block - now converted to WP_Block
$first = $block_list[0];

// Second block still a raw array until accessed
$second = $block_list[1]; // Now converted
```

### Modifying the List

```php
$block_list = new WP_Block_List( $parsed_blocks );

// Remove a block
unset( $block_list[0] );

// Add a new block
$new_block = array(
    'blockName'    => 'core/paragraph',
    'attrs'        => array(),
    'innerBlocks'  => array(),
    'innerHTML'    => '<p>New content</p>',
    'innerContent' => array( '<p>New content</p>' ),
);
$block_list[] = $new_block;
```
