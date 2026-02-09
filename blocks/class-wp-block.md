# WP_Block

Class representing a parsed instance of a block ready for rendering.

**Since:** 5.5.0  
**Source:** `wp-includes/class-wp-block.php`

## Description

`WP_Block` represents a single parsed block with its attributes prepared for rendering, context resolved from ancestors, and inner blocks instantiated. It handles dynamic rendering via `render_callback`, block bindings, and asset enqueueing.

## Properties

### $parsed_block

Original parsed array representation of the block.

```php
public array $parsed_block
```

**Since:** 5.5.0

---

### $name

Name of the block.

```php
public string|null $name
```

**Example:** `"core/paragraph"`

**Since:** 5.5.0

---

### $block_type

Block type associated with this instance.

```php
public WP_Block_Type $block_type
```

**Since:** 5.5.0

---

### $context

Block context values inherited from ancestors.

```php
public array $context = array()
```

**Since:** 5.5.0

---

### $inner_blocks

List of inner blocks.

```php
public WP_Block_List $inner_blocks = array()
```

**Since:** 5.5.0

---

### $inner_html

HTML from inside block comment delimiters after removing inner blocks.

```php
public string $inner_html = ''
```

**Example:** `"...Just <!-- wp:test /--> testing..."` → `"Just testing..."`

**Since:** 5.5.0

---

### $inner_content

List of string fragments and null markers where inner blocks were found.

```php
public array $inner_content = array()
```

**Example:**
```php
array(
    'inner_html'    => 'BeforeInnerAfter',
    'inner_blocks'  => array( $block1, $block2 ),
    'inner_content' => array( 'Before', null, 'Inner', null, 'After' ),
)
```

**Since:** 5.5.0

---

### $attributes

Block attributes (lazily initialized via `__get`).

```php
public array $attributes
```

Accessed via magic method. Populated with defaults from block type schema.

**Since:** 5.5.0

---

### $available_context (protected)

All available context from the current hierarchy.

```php
protected array $available_context = array()
```

**Since:** 5.5.0

---

### $registry (protected)

Block type registry instance.

```php
protected WP_Block_Type_Registry $registry
```

**Since:** 5.9.0

---

## Methods

### __construct()

Constructor. Populates object properties from parsed block.

```php
public function __construct(
    array $block,
    array $available_context = array(),
    WP_Block_Type_Registry $registry = null
)
```

**Parameters:**
- `$block` *(array)* - Parsed block array with:
  - `blockName` *(string|null)* - Name of block
  - `attrs` *(array)* - Attributes from comment delimiters
  - `innerBlocks` *(array)* - List of inner blocks
  - `innerHTML` *(string)* - HTML from inside delimiters
  - `innerContent` *(array)* - String fragments and null markers
- `$available_context` *(array)* - Optional. Ancestry context values
- `$registry` *(WP_Block_Type_Registry)* - Optional. Block type registry

**Since:** 5.5.0

**Example:**
```php
$parsed = array(
    'blockName'    => 'core/paragraph',
    'attrs'        => array( 'align' => 'center' ),
    'innerBlocks'  => array(),
    'innerHTML'    => '<p>Hello</p>',
    'innerContent' => array( '<p>Hello</p>' ),
);

$block = new WP_Block( $parsed, array( 'postId' => 123 ) );
echo $block->render();
```

---

### __get()

Returns value for inaccessible properties. Used for lazy `$attributes` initialization.

```php
public function __get( string $name ): array|null
```

**Parameters:**
- `$name` *(string)* - Property name

**Returns:** *(array|null)* - Prepared attributes for `'attributes'`, null otherwise

**Since:** 5.5.0

---

### render()

Generates the render output for the block.

```php
public function render( array $options = array() ): string
```

**Parameters:**
- `$options` *(array)* - Optional. Render options:
  - `dynamic` *(bool)* - Whether to use `render_callback`. Default `true`

**Returns:** *(string)* - Rendered block output

**Since:** 5.5.0  
**Since:** 6.5.0 - Added block bindings processing

**Process:**
1. Process block bindings (replace attributes with source values)
2. Render inner blocks recursively (unless `skip_inner_blocks`)
3. Replace HTML with computed attribute values
4. Call `render_callback` if dynamic
5. Enqueue scripts and styles
6. Apply `render_block` and `render_block_{$name}` filters
7. Process Interactivity API directives if applicable
8. Clean up empty block assets

**Example:**
```php
$block = new WP_Block( $parsed_block, $context );

// Normal render
$html = $block->render();

// Static render (skip render_callback)
$html = $block->render( array( 'dynamic' => false ) );
```

---

### refresh_context_dependents()

Updates context for the current block and its inner blocks.

```php
public function refresh_context_dependents(): void
```

**Since:** 6.8.0

Updates `$context` with values from `$available_context` based on `uses_context`, then refreshes parsed block dependents including inner blocks.

---

### refresh_parsed_block_dependents()

Updates parsed block content for the block and inner blocks.

```php
public function refresh_parsed_block_dependents(): void
```

**Since:** 6.8.0

Sets `inner_html`, `inner_content`, and creates new `WP_Block_List` for inner blocks with updated context.

---

## Private Methods

### process_block_bindings()

Processes block bindings and updates attributes with values from sources.

```php
private function process_block_bindings(): array
```

**Returns:** *(array)* - Computed attributes from binding sources

**Since:** 6.5.0  
**Since:** 6.6.0 - Handle `__default` for pattern overrides  
**Since:** 6.7.0 - Return updated bindings metadata

Bindings connect block attributes to external data sources like post meta:

```json
{
  "metadata": {
    "bindings": {
      "content": {
        "source": "core/post-meta",
        "args": { "key": "custom_field" }
      }
    }
  }
}
```

---

### replace_html()

Replaces attribute value in HTML based on attribute source type.

```php
private function replace_html(
    string $block_content,
    string $attribute_name,
    mixed $source_value
): string
```

**Parameters:**
- `$block_content` *(string)* - Block content HTML
- `$attribute_name` *(string)* - Attribute to replace
- `$source_value` *(mixed)* - Replacement value

**Returns:** *(string)* - Modified block content

**Since:** 6.5.0

Handles attribute sources:
- `html` / `rich-text` - Replace inner content of matching selector
- `attribute` - Replace HTML attribute on matching selector

---

## Usage Examples

### Basic Rendering

```php
$blocks = parse_blocks( $post->post_content );

foreach ( $blocks as $parsed_block ) {
    $block = new WP_Block( $parsed_block, array(
        'postId'   => $post->ID,
        'postType' => $post->post_type,
    ) );
    
    echo $block->render();
}
```

### Accessing Attributes

```php
$block = new WP_Block( $parsed_block );

// Attributes are lazily initialized with defaults
$align = $block->attributes['align'] ?? 'none';
$className = $block->attributes['className'] ?? '';
```

### Context Propagation

```php
// Parent block provides context
$parent = new WP_Block( $parsed_parent, array(), null );

// Child blocks receive context through inner_blocks
foreach ( $parent->inner_blocks as $child ) {
    // $child->context contains values from provides_context
    echo $child->context['postId'];
}
```

### Working with Inner Blocks

```php
$block = new WP_Block( $parsed_block );

// Inner blocks are WP_Block_List (iterable)
foreach ( $block->inner_blocks as $inner ) {
    echo $inner->name . ': ' . $inner->render();
}

// Array access
$first_inner = $block->inner_blocks[0];

// Count
$count = count( $block->inner_blocks );
```
