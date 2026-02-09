# InnerBlocks

InnerBlocks allows blocks to contain other blocks as children, creating nested block structures.

## Basic Usage

```js
import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <InnerBlocks />
        </div>
    );
}

export function Save() {
    return (
        <div { ...useBlockProps.save() }>
            <InnerBlocks.Content />
        </div>
    );
}
```

## InnerBlocks Props

### `allowedBlocks`

Restrict which blocks can be inserted:

```js
const ALLOWED_BLOCKS = [ 'core/paragraph', 'core/heading', 'core/image' ];

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <InnerBlocks allowedBlocks={ ALLOWED_BLOCKS } />
        </div>
    );
}
```

In block.json:

```json
{
    "allowedBlocks": [ "core/paragraph", "core/heading", "core/image" ]
}
```

### `template`

Define default block structure:

```js
const TEMPLATE = [
    [ 'core/heading', { level: 2, placeholder: 'Title' } ],
    [ 'core/paragraph', { placeholder: 'Description' } ],
    [ 'core/image', {} ],
];

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <InnerBlocks template={ TEMPLATE } />
        </div>
    );
}
```

Nested templates:

```js
const TEMPLATE = [
    [ 'core/columns', {}, [
        [ 'core/column', {}, [
            [ 'core/image', {} ],
        ] ],
        [ 'core/column', {}, [
            [ 'core/heading', { level: 3 } ],
            [ 'core/paragraph', {} ],
        ] ],
    ] ],
];
```

### `templateLock`

Control template modifications:

```js
// No new blocks, can't remove/reorder
<InnerBlocks templateLock="all" />

// Can reorder but can't add/remove
<InnerBlocks templateLock="insert" />

// Can't reorder but can add/remove (WordPress 6.3+)
<InnerBlocks templateLock="contentOnly" />

// No restrictions (default)
<InnerBlocks templateLock={ false } />
```

| Value | Add/Remove | Reorder | Edit Content |
|-------|------------|---------|--------------|
| `false` | ✓ | ✓ | ✓ |
| `"all"` | ✗ | ✗ | ✓ |
| `"insert"` | ✗ | ✓ | ✓ |
| `"contentOnly"` | ✓ | ✗ | ✓ |

### `orientation`

Set insertion orientation hint:

```js
// Horizontal layout (row)
<InnerBlocks orientation="horizontal" />

// Vertical layout (column) - default
<InnerBlocks orientation="vertical" />
```

### `renderAppender`

Customize the block appender:

```js
import { InnerBlocks, ButtonBlockAppender } from '@wordpress/block-editor';

// Default appender button
<InnerBlocks renderAppender={ InnerBlocks.DefaultBlockAppender } />

// Button appender
<InnerBlocks renderAppender={ ButtonBlockAppender } />

// No appender
<InnerBlocks renderAppender={ false } />

// Custom appender
<InnerBlocks
    renderAppender={ () => (
        <button onClick={ /* insert logic */ }>
            Add Custom Block
        </button>
    ) }
/>
```

### `placeholder`

Custom placeholder when empty:

```js
<InnerBlocks
    placeholder={
        <div className="my-placeholder">
            <p>Drag blocks here or click to add</p>
        </div>
    }
/>
```

### `defaultBlock`

Default block type when pressing Enter:

```js
<InnerBlocks
    defaultBlock={ [ 'core/paragraph', { placeholder: 'Type here...' } ] }
/>
```

### `directInsert`

Skip inserter modal for single allowed block:

```js
<InnerBlocks
    allowedBlocks={ [ 'core/paragraph' ] }
    directInsert={ true }
/>
```

### `prioritizedInserterBlocks`

Prioritize blocks in inserter:

```js
<InnerBlocks
    prioritizedInserterBlocks={ [ 'core/paragraph', 'core/image' ] }
/>
```

## useInnerBlocksProps Hook

For more control over the wrapper element:

```js
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps();
    const innerBlocksProps = useInnerBlocksProps( blockProps, {
        allowedBlocks: [ 'core/paragraph' ],
        template: [ [ 'core/paragraph', {} ] ],
    } );
    
    return <div { ...innerBlocksProps } />;
}
```

Separate wrapper and inner content:

```js
export default function Edit() {
    const blockProps = useBlockProps();
    const { children, ...innerBlocksProps } = useInnerBlocksProps(
        { className: 'inner-content' },
        { allowedBlocks: [ 'core/paragraph' ] }
    );
    
    return (
        <div { ...blockProps }>
            <header>Block Header</header>
            <div { ...innerBlocksProps }>
                { children }
            </div>
            <footer>Block Footer</footer>
        </div>
    );
}
```

Save with separate structure:

```js
export function Save() {
    const blockProps = useBlockProps.save();
    const innerBlocksProps = useInnerBlocksProps.save( {
        className: 'inner-content',
    } );
    
    return (
        <div { ...blockProps }>
            <header>Block Header</header>
            <div { ...innerBlocksProps } />
            <footer>Block Footer</footer>
        </div>
    );
}
```

## Dynamic Blocks with InnerBlocks

In render.php, inner blocks content is available as `$content`:

```php
<?php
// render.php
$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <header class="block-header">
        <?php echo esc_html( $attributes['title'] ); ?>
    </header>
    <div class="inner-content">
        <?php echo $content; // Inner blocks HTML ?>
    </div>
    <footer class="block-footer">
        Footer content
    </footer>
</div>
```

In render_callback:

```php
function render_my_block( $attributes, $content, $block ) {
    $wrapper_attributes = get_block_wrapper_attributes();
    
    ob_start();
    ?>
    <div <?php echo $wrapper_attributes; ?>>
        <div class="inner-content">
            <?php echo $content; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
```

## Accessing Inner Blocks Data

### In JavaScript (Editor)

```js
import { useSelect } from '@wordpress/data';
import { store as blockEditorStore } from '@wordpress/block-editor';

export default function Edit( { clientId } ) {
    const innerBlocks = useSelect(
        ( select ) => select( blockEditorStore ).getBlocks( clientId ),
        [ clientId ]
    );
    
    const hasInnerBlocks = innerBlocks.length > 0;
    
    return (
        <div { ...useBlockProps() }>
            { ! hasInnerBlocks && <p>Add some blocks!</p> }
            <InnerBlocks />
        </div>
    );
}
```

### In PHP

```php
function render_my_block( $attributes, $content, $block ) {
    // Access parsed inner blocks
    $inner_blocks = $block->inner_blocks;
    
    foreach ( $inner_blocks as $inner_block ) {
        $block_name = $inner_block->name;
        $block_attrs = $inner_block->attributes;
        $block_html = render_block( $inner_block );
    }
    
    return '<div>' . $content . '</div>';
}
```

## Conditional InnerBlocks

Show InnerBlocks based on attributes:

```js
export default function Edit( { attributes } ) {
    const { showContent } = attributes;
    
    return (
        <div { ...useBlockProps() }>
            { showContent && <InnerBlocks /> }
        </div>
    );
}
```

## Multiple InnerBlocks Areas

A block can only have one InnerBlocks. For multiple areas, use nested blocks:

```js
// Parent block
const TEMPLATE = [
    [ 'my-plugin/header-area', {} ],
    [ 'my-plugin/content-area', {} ],
    [ 'my-plugin/footer-area', {} ],
];

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <InnerBlocks
                template={ TEMPLATE }
                templateLock="all"
            />
        </div>
    );
}

// Each area block has its own InnerBlocks
// my-plugin/header-area
export function HeaderEdit() {
    return (
        <header { ...useBlockProps() }>
            <InnerBlocks allowedBlocks={ [ 'core/heading', 'core/image' ] } />
        </header>
    );
}
```

## Layout Support with InnerBlocks

Enable layout controls for inner blocks:

```json
{
    "supports": {
        "layout": true
    }
}
```

```js
import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export default function Edit() {
    const blockProps = useBlockProps();
    const innerBlocksProps = useInnerBlocksProps( blockProps, {
        // Layout is automatically handled via supports
    } );
    
    return <div { ...innerBlocksProps } />;
}
```

With default layout:

```json
{
    "supports": {
        "layout": {
            "default": {
                "type": "flex",
                "flexWrap": "nowrap"
            }
        }
    }
}
```

## Complete Example: Card Block with InnerBlocks

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/card",
    "title": "Card",
    "category": "design",
    "attributes": {
        "title": {
            "type": "string"
        }
    },
    "supports": {
        "color": {
            "background": true,
            "text": true
        },
        "spacing": {
            "padding": true
        }
    },
    "allowedBlocks": [ "core/paragraph", "core/heading", "core/image", "core/button" ],
    "editorScript": "file:./index.js",
    "style": "file:./style.css",
    "render": "file:./render.php"
}
```

```js
// edit.js
import { useBlockProps, useInnerBlocksProps, RichText } from '@wordpress/block-editor';

const TEMPLATE = [
    [ 'core/paragraph', { placeholder: 'Card content...' } ],
];

export default function Edit( { attributes, setAttributes } ) {
    const { title } = attributes;
    const blockProps = useBlockProps( { className: 'card-block' } );
    const innerBlocksProps = useInnerBlocksProps(
        { className: 'card-content' },
        {
            template: TEMPLATE,
            templateLock: false,
        }
    );
    
    return (
        <div { ...blockProps }>
            <RichText
                tagName="h3"
                className="card-title"
                value={ title }
                onChange={ ( value ) => setAttributes( { title: value } ) }
                placeholder="Card Title"
            />
            <div { ...innerBlocksProps } />
        </div>
    );
}
```

```js
// save.js
import { useBlockProps, useInnerBlocksProps, RichText } from '@wordpress/block-editor';

export default function Save( { attributes } ) {
    const { title } = attributes;
    const blockProps = useBlockProps.save( { className: 'card-block' } );
    const innerBlocksProps = useInnerBlocksProps.save( {
        className: 'card-content',
    } );
    
    return (
        <div { ...blockProps }>
            <RichText.Content
                tagName="h3"
                className="card-title"
                value={ title }
            />
            <div { ...innerBlocksProps } />
        </div>
    );
}
```

```php
<?php
// render.php
$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'card-block' ] );
$title = $attributes['title'] ?? '';
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php if ( $title ) : ?>
        <h3 class="card-title"><?php echo wp_kses_post( $title ); ?></h3>
    <?php endif; ?>
    <div class="card-content">
        <?php echo $content; ?>
    </div>
</div>
```

## Best Practices

1. **Always use `InnerBlocks.Content` in Save:** The save function must render inner blocks content.

2. **Use templates for structure:** Define templates to guide content creation.

3. **Consider template locking:** Lock templates when structure is important.

4. **Restrict allowed blocks:** Limit to relevant blocks for better UX.

5. **Use `useInnerBlocksProps` for control:** Provides more flexibility than `<InnerBlocks />` component.

6. **Handle empty state:** Show placeholder or instructions when no inner blocks exist.

7. **Test with various content:** Ensure your block handles different combinations of inner blocks.
