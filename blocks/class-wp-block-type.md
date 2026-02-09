# WP_Block_Type

Core class representing a block type definition.

**Since:** 5.0.0  
**Source:** `wp-includes/class-wp-block-type.php`

## Description

`WP_Block_Type` defines a registered block type with its metadata, attributes schema, render callback, and asset handles. Block types are registered via `register_block_type()` and stored in `WP_Block_Type_Registry`.

## Constants

### GLOBAL_ATTRIBUTES

Attributes supported by every block.

```php
const GLOBAL_ATTRIBUTES = array(
    'lock'     => array( 'type' => 'object' ),
    'metadata' => array( 'type' => 'object' ),
);
```

**Since:** 6.0.0 - Added `lock`  
**Since:** 6.5.0 - Added `metadata`

---

## Properties

### $api_version

Block API version.

```php
public int $api_version = 1
```

**Since:** 5.6.0

---

### $name

Block type key (namespaced identifier).

```php
public string $name
```

**Example:** `"core/paragraph"`, `"my-plugin/my-block"`

**Since:** 5.0.0

---

### $title

Human-readable block type label.

```php
public string $title = ''
```

**Since:** 5.5.0

---

### $category

Block type category for search interfaces.

```php
public string|null $category = null
```

**Categories:** `text`, `media`, `design`, `widgets`, `theme`, `embed`, `reusable`

**Since:** 5.5.0

---

### $parent

Blocks that must be parents of this block type.

```php
public string[]|null $parent = null
```

**Since:** 5.5.0

---

### $ancestor

Block types that must be ancestors at any level.

```php
public string[]|null $ancestor = null
```

**Since:** 6.0.0

---

### $allowed_blocks

Block types that can be inserted as children.

```php
public string[]|null $allowed_blocks = null
```

**Since:** 6.5.0

---

### $icon

Block type icon (dashicon or SVG).

```php
public string|null $icon = null
```

**Since:** 5.5.0

---

### $description

Detailed block type description.

```php
public string $description = ''
```

**Since:** 5.5.0

---

### $keywords

Additional keywords for search.

```php
public string[] $keywords = array()
```

**Since:** 5.5.0

---

### $textdomain

Translation textdomain.

```php
public string|null $textdomain = null
```

**Since:** 5.5.0

---

### $styles

Alternative block styles.

```php
public array $styles = array()
```

**Since:** 5.5.0

---

### $variations (private)

Block variations. Access via `get_variations()`.

```php
private array[]|null $variations = null
```

**Since:** 5.8.0  
**Since:** 6.5.0 - Private, accessed via magic getter

---

### $variation_callback

Callback that returns block variations.

```php
public callable|null $variation_callback = null
```

**Since:** 6.5.0

---

### $selectors

Custom CSS selectors for theme.json style generation.

```php
public array $selectors = array()
```

**Since:** 6.3.0

---

### $supports

Supported features configuration.

```php
public array|null $supports = null
```

**Since:** 5.5.0

**Example:**
```php
$supports = array(
    'color'      => array( 'background' => true, 'text' => true ),
    'spacing'    => array( 'margin' => true, 'padding' => true ),
    'typography' => array( 'fontSize' => true ),
    'align'      => array( 'wide', 'full' ),
    'html'       => false,
    'multiple'   => true,
    'reusable'   => true,
    'interactivity' => true,
);
```

---

### $example

Structured data for block preview.

```php
public array|null $example = null
```

**Since:** 5.5.0

---

### $render_callback

Block type render callback.

```php
public callable $render_callback = null
```

**Signature:** `function( array $attributes, string $content, WP_Block $block ): string`

**Since:** 5.0.0

---

### $attributes

Block type attributes property schemas.

```php
public array|null $attributes = null
```

**Since:** 5.0.0

**Schema Example:**
```php
$attributes = array(
    'align' => array(
        'type'    => 'string',
        'default' => 'none',
        'enum'    => array( 'left', 'center', 'right', 'wide', 'full' ),
    ),
    'content' => array(
        'type'     => 'string',
        'source'   => 'html',
        'selector' => 'p',
    ),
    'url' => array(
        'type'      => 'string',
        'source'    => 'attribute',
        'selector'  => 'img',
        'attribute' => 'src',
    ),
);
```

---

### $uses_context (private)

Context values inherited by blocks of this type.

```php
private string[] $uses_context = array()
```

**Since:** 5.5.0

Access via `get_uses_context()`.

---

### $provides_context

Context provided to descendant blocks.

```php
public string[]|null $provides_context = null
```

**Since:** 5.5.0

**Example:**
```php
$provides_context = array(
    'myPlugin/postId' => 'postId',
);
```

---

### $block_hooks

Block hooks configuration for auto-insertion.

```php
public string[] $block_hooks = array()
```

**Since:** 6.4.0

**Example:**
```php
$block_hooks = array(
    'core/post-content' => 'after',      // Insert after post content
    'core/navigation'   => 'first_child', // Insert as first child
);
```

Positions: `before`, `after`, `first_child`, `last_child`

---

### Asset Handle Properties

```php
public string[] $editor_script_handles = array();  // Editor-only scripts (since 6.1.0)
public string[] $script_handles = array();         // Front & editor scripts (since 6.1.0)
public string[] $view_script_handles = array();    // Front-end only scripts (since 6.1.0)
public string[] $view_script_module_ids = array(); // Front-end script modules (since 6.5.0)
public string[] $editor_style_handles = array();   // Editor-only styles (since 6.1.0)
public string[] $style_handles = array();          // Front & editor styles (since 6.1.0)
public string[] $view_style_handles = array();     // Front-end only styles (since 6.5.0)
```

---

## Methods

### __construct()

Constructor. Populates properties from arguments.

```php
public function __construct( string $block_type, array|string $args = array() )
```

**Parameters:**
- `$block_type` *(string)* - Block type name including namespace
- `$args` *(array|string)* - Block type arguments

**Since:** 5.0.0

**Example:**
```php
$block_type = new WP_Block_Type( 'my-plugin/notice', array(
    'api_version'     => 3,
    'title'           => 'Notice',
    'category'        => 'widgets',
    'attributes'      => array(
        'type' => array( 'type' => 'string', 'default' => 'info' ),
    ),
    'supports'        => array(
        'color' => array( 'background' => true ),
    ),
    'render_callback' => function( $attrs, $content ) {
        return sprintf( '<div class="notice-%s">%s</div>', $attrs['type'], $content );
    },
) );
```

---

### __get()

Proxies getting values for deprecated/private properties.

```php
public function __get( string $name )
```

**Parameters:**
- `$name` *(string)* - Property name

**Returns:**
- For `variations`: Calls `get_variations()`
- For `uses_context`: Calls `get_uses_context()`
- For deprecated script/style properties: Returns first handle or array

**Since:** 6.1.0

---

### __isset()

Checks if property is set (for deprecated/private properties).

```php
public function __isset( string $name ): bool
```

**Since:** 6.1.0

---

### __set()

Sets deprecated script/style properties to new handle arrays.

```php
public function __set( string $name, mixed $value ): void
```

**Since:** 6.1.0

---

### render()

Renders block type output for given attributes.

```php
public function render( array $attributes = array(), string $content = '' ): string
```

**Parameters:**
- `$attributes` *(array)* - Block attributes
- `$content` *(string)* - Block content

**Returns:** *(string)* - Rendered output (empty if not dynamic)

**Since:** 5.0.0

---

### is_dynamic()

Returns whether the block type is dynamic.

```php
public function is_dynamic(): bool
```

**Returns:** *(bool)* - True if `render_callback` is callable

**Since:** 5.0.0

---

### prepare_attributes_for_render()

Validates attributes and populates defaults.

```php
public function prepare_attributes_for_render( array $attributes ): array
```

**Parameters:**
- `$attributes` *(array)* - Original block attributes

**Returns:** *(array)* - Prepared attributes with defaults

**Since:** 5.0.0

**Process:**
1. Skip if no attribute definitions
2. Validate each attribute against JSON schema
3. Remove invalid attributes
4. Populate missing attributes with defaults

---

### set_props()

Sets block type properties.

```php
public function set_props( array|string $args ): void
```

**Parameters:**
- `$args` *(array|string)* - Block type arguments

**Since:** 5.0.0

Applies `register_block_type_args` filter and adds global attributes.

---

### get_attributes()

Get all available block attributes.

```php
public function get_attributes(): array
```

**Returns:** *(array)* - Array of attributes

**Since:** 5.0.0

---

### get_variations()

Get block variations.

```php
public function get_variations(): array[]
```

**Returns:** *(array[])* - Block variations

**Since:** 6.5.0

Calls `variation_callback` if set, then applies `get_block_type_variations` filter.

---

### get_uses_context()

Get block uses context array.

```php
public function get_uses_context(): string[]
```

**Returns:** *(string[])* - Context keys this block uses

**Since:** 6.5.0

Applies `get_block_type_uses_context` filter.

---

## Usage Examples

### Creating Dynamic Block

```php
$block_type = new WP_Block_Type( 'my-plugin/current-time', array(
    'title'           => 'Current Time',
    'category'        => 'widgets',
    'attributes'      => array(
        'format' => array(
            'type'    => 'string',
            'default' => 'Y-m-d H:i:s',
        ),
    ),
    'render_callback' => function( $attributes ) {
        return '<time>' . date( $attributes['format'] ) . '</time>';
    },
) );

WP_Block_Type_Registry::get_instance()->register( $block_type );
```

### Block with Context

```php
// Parent block provides context
$parent_type = new WP_Block_Type( 'my-plugin/product-list', array(
    'provides_context' => array(
        'my-plugin/productId' => 'selectedProduct',
    ),
    'attributes' => array(
        'selectedProduct' => array( 'type' => 'integer' ),
    ),
) );

// Child block uses context
$child_type = new WP_Block_Type( 'my-plugin/product-price', array(
    'uses_context' => array( 'my-plugin/productId' ),
    'render_callback' => function( $attrs, $content, $block ) {
        $product_id = $block->context['my-plugin/productId'];
        return '$' . get_product_price( $product_id );
    },
) );
```

### Block with Variations

```php
$block_type = new WP_Block_Type( 'my-plugin/icon', array(
    'variation_callback' => function() {
        return array(
            array(
                'name'       => 'star',
                'title'      => 'Star Icon',
                'icon'       => 'star-filled',
                'attributes' => array( 'icon' => 'star' ),
            ),
            array(
                'name'       => 'heart',
                'title'      => 'Heart Icon',
                'icon'       => 'heart',
                'attributes' => array( 'icon' => 'heart' ),
            ),
        );
    },
) );
```

### Block Hooks Example

```php
$block_type = new WP_Block_Type( 'my-plugin/newsletter-signup', array(
    'block_hooks' => array(
        'core/post-content' => 'after',      // After every post content
        'core/query'        => 'last_child', // At end of query loops
    ),
    'render_callback' => function() {
        return '<form class="newsletter"><!-- signup form --></form>';
    },
) );
```
