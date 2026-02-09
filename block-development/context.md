# Block Context

Block context allows parent blocks to share data with descendant blocks without prop drilling.

## How It Works

1. Parent block declares which attributes to expose via `providesContext`
2. Child blocks declare which context values they need via `usesContext`
3. WordPress handles the value passing automatically

## Providing Context

### In block.json

```json
{
    "name": "my-plugin/query-container",
    "attributes": {
        "queryId": {
            "type": "string"
        },
        "postType": {
            "type": "string",
            "default": "post"
        }
    },
    "providesContext": {
        "my-plugin/queryId": "queryId",
        "my-plugin/postType": "postType"
    }
}
```

The format is:
```
"context-key": "attribute-name"
```

### Namespace Your Context Keys

Always namespace context keys to avoid conflicts:

```json
{
    "providesContext": {
        "my-plugin/recordId": "recordId",
        "my-plugin/layout": "layout"
    }
}
```

## Consuming Context

### In block.json

```json
{
    "name": "my-plugin/query-item",
    "usesContext": [ "my-plugin/queryId", "my-plugin/postType" ]
}
```

### In JavaScript

Context is passed to the edit function:

```js
export default function Edit( { context } ) {
    const queryId = context[ 'my-plugin/queryId' ];
    const postType = context[ 'my-plugin/postType' ];
    
    return (
        <div { ...useBlockProps() }>
            <p>Query ID: { queryId }</p>
            <p>Post Type: { postType }</p>
        </div>
    );
}
```

### In PHP (Dynamic Blocks)

Context is available in the `$block` parameter:

```php
// render.php
$query_id = $block->context['my-plugin/queryId'] ?? '';
$post_type = $block->context['my-plugin/postType'] ?? 'post';
```

Or in render_callback:

```php
function render_query_item( $attributes, $content, $block ) {
    $query_id = $block->context['my-plugin/queryId'] ?? '';
    $post_type = $block->context['my-plugin/postType'] ?? 'post';
    
    return sprintf(
        '<div class="query-item" data-query="%s">%s</div>',
        esc_attr( $query_id ),
        esc_html( $post_type )
    );
}
```

## Core Context Values

WordPress core provides these context values:

| Context Key | Provided By | Description |
|-------------|-------------|-------------|
| `postId` | Query Loop | Current post ID |
| `postType` | Query Loop | Current post type |
| `queryId` | Query Loop | Query block instance ID |
| `query` | Query Loop | Query parameters |
| `displayLayout` | Query Loop | Layout settings |
| `templateSlug` | Template | Current template slug |
| `tagName` | Group | HTML tag name |
| `commentId` | Comments | Current comment ID |
| `groupId` | Group | Group block instance ID |

### Using Core Context

```json
{
    "name": "my-plugin/post-data",
    "usesContext": [ "postId", "postType" ]
}
```

```js
export default function Edit( { context } ) {
    const { postId, postType } = context;
    
    // Use post ID to fetch data
    const post = useSelect(
        ( select ) => select( 'core' ).getEntityRecord( 'postType', postType, postId ),
        [ postId, postType ]
    );
    
    return (
        <div { ...useBlockProps() }>
            { post?.title?.rendered }
        </div>
    );
}
```

## Complete Example: Product Display

### Parent Block (Product Container)

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/product",
    "title": "Product",
    "category": "widgets",
    "attributes": {
        "productId": {
            "type": "number"
        },
        "showPrice": {
            "type": "boolean",
            "default": true
        },
        "currency": {
            "type": "string",
            "default": "USD"
        }
    },
    "providesContext": {
        "my-plugin/productId": "productId",
        "my-plugin/showPrice": "showPrice",
        "my-plugin/currency": "currency"
    },
    "editorScript": "file:./index.js"
}
```

```js
// edit.js
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

const TEMPLATE = [
    [ 'my-plugin/product-title' ],
    [ 'my-plugin/product-image' ],
    [ 'my-plugin/product-price' ],
    [ 'my-plugin/product-description' ],
];

const ALLOWED = [
    'my-plugin/product-title',
    'my-plugin/product-image',
    'my-plugin/product-price',
    'my-plugin/product-description',
    'my-plugin/product-add-to-cart',
];

export default function Edit( { attributes, setAttributes } ) {
    const { productId } = attributes;
    
    return (
        <div { ...useBlockProps() }>
            <TextControl
                label="Product ID"
                type="number"
                value={ productId }
                onChange={ ( value ) => setAttributes( { productId: parseInt( value ) } ) }
            />
            <InnerBlocks
                template={ TEMPLATE }
                allowedBlocks={ ALLOWED }
            />
        </div>
    );
}
```

### Child Block (Product Price)

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/product-price",
    "title": "Product Price",
    "category": "widgets",
    "parent": [ "my-plugin/product" ],
    "usesContext": [ "my-plugin/productId", "my-plugin/showPrice", "my-plugin/currency" ],
    "editorScript": "file:./index.js",
    "render": "file:./render.php"
}
```

```js
// edit.js
export default function Edit( { context } ) {
    const productId = context[ 'my-plugin/productId' ];
    const showPrice = context[ 'my-plugin/showPrice' ];
    const currency = context[ 'my-plugin/currency' ];
    
    if ( ! showPrice ) {
        return null;
    }
    
    // In real implementation, fetch price from API
    const price = 99.99;
    
    return (
        <div { ...useBlockProps() }>
            <span className="price">
                { currency } { price }
            </span>
        </div>
    );
}
```

```php
<?php
// render.php
$product_id = $block->context['my-plugin/productId'] ?? 0;
$show_price = $block->context['my-plugin/showPrice'] ?? true;
$currency = $block->context['my-plugin/currency'] ?? 'USD';

if ( ! $show_price || ! $product_id ) {
    return '';
}

// In real implementation, get price from database
$price = get_post_meta( $product_id, '_price', true );

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <span class="price">
        <?php echo esc_html( $currency ); ?> 
        <?php echo esc_html( number_format( $price, 2 ) ); ?>
    </span>
</div>
```

## Context with Query Loop

Using context with WordPress Query Loop:

```json
{
    "name": "my-plugin/post-reading-time",
    "title": "Reading Time",
    "usesContext": [ "postId" ]
}
```

```php
<?php
// render.php
$post_id = $block->context['postId'] ?? get_the_ID();

if ( ! $post_id ) {
    return '';
}

$content = get_post_field( 'post_content', $post_id );
$word_count = str_word_count( wp_strip_all_tags( $content ) );
$reading_time = ceil( $word_count / 200 ); // 200 words per minute

$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php printf( esc_html__( '%d min read', 'my-plugin' ), $reading_time ); ?>
</div>
```

## Dynamic Context Values

Context values update when parent attributes change:

```js
// Parent block
export default function Edit( { attributes, setAttributes } ) {
    const { layout } = attributes;
    
    return (
        <div { ...useBlockProps() }>
            <ToggleControl
                label="Grid Layout"
                checked={ layout === 'grid' }
                onChange={ () => setAttributes( { 
                    layout: layout === 'grid' ? 'list' : 'grid'
                } ) }
            />
            <InnerBlocks />
        </div>
    );
}

// Child block automatically receives updated layout value
export default function ChildEdit( { context } ) {
    const layout = context[ 'my-plugin/layout' ];
    
    // Automatically re-renders when parent changes layout
    return (
        <div { ...useBlockProps( { className: `layout-${ layout }` } ) }>
            Current layout: { layout }
        </div>
    );
}
```

## Context Inheritance Depth

Context passes through unlimited nesting levels:

```
Parent (provides context)
└── Child A
    └── Child B
        └── Child C (can still access Parent's context)
```

Any descendant can consume context from any ancestor.

## Overriding Context

A block can both consume and provide the same context:

```json
{
    "name": "my-plugin/nested-container",
    "usesContext": [ "my-plugin/level" ],
    "providesContext": {
        "my-plugin/level": "level"
    },
    "attributes": {
        "level": {
            "type": "number",
            "default": 1
        }
    }
}
```

```js
export default function Edit( { attributes, setAttributes, context } ) {
    const parentLevel = context[ 'my-plugin/level' ] || 0;
    
    // Auto-set level based on parent
    useEffect( () => {
        setAttributes( { level: parentLevel + 1 } );
    }, [ parentLevel ] );
    
    return (
        <div { ...useBlockProps() }>
            <p>Level: { attributes.level }</p>
            <InnerBlocks />
        </div>
    );
}
```

## Best Practices

1. **Namespace context keys:** Always use `plugin-name/context-key` format.

2. **Provide defaults:** Handle missing context gracefully.

3. **Limit context scope:** Only expose what child blocks actually need.

4. **Document context:** Clearly document what context your block provides/consumes.

5. **Consider performance:** Context changes re-render all consuming descendants.

6. **Use for configuration:** Context is ideal for settings that affect multiple child blocks.

7. **Combine with parent restriction:** Use `parent` in block.json to ensure context is available.
