# Block Deprecations and Migrations

Deprecations allow you to update block structure while maintaining backward compatibility with previously saved content.

## Why Deprecations

When you change:
- Attribute structure
- Save function output (HTML)
- Attribute sources or selectors
- Block markup structure

You need deprecations to ensure old content still loads and displays correctly.

## Basic Deprecation

```js
import { registerBlockType } from '@wordpress/blocks';

registerBlockType( 'my-plugin/card', {
    // Current version
    attributes: {
        title: { type: 'string' },
        content: { type: 'string' },
        // New attribute (wasn't in v1)
        subtitle: { type: 'string' },
    },
    save: ( { attributes } ) => {
        const { title, subtitle, content } = attributes;
        return (
            <div className="card">
                <h2>{ title }</h2>
                { subtitle && <h3>{ subtitle }</h3> }
                <p>{ content }</p>
            </div>
        );
    },
    
    // Previous versions
    deprecated: [
        {
            // Version 1: no subtitle
            attributes: {
                title: { type: 'string' },
                content: { type: 'string' },
            },
            save: ( { attributes } ) => {
                const { title, content } = attributes;
                return (
                    <div className="card">
                        <h2>{ title }</h2>
                        <p>{ content }</p>
                    </div>
                );
            },
        },
    ],
} );
```

## Deprecation Properties

| Property | Type | Description |
|----------|------|-------------|
| `attributes` | object | Attribute definitions for this version |
| `supports` | object | Block supports for this version |
| `save` | function | Save function for this version |
| `migrate` | function | Transform old attributes to new |
| `isEligible` | function | Check if block matches this deprecation |

## Attribute Migration

Transform old attributes to new structure:

```js
deprecated: [
    {
        attributes: {
            text: { type: 'string' },
            textColor: { type: 'string' },
        },
        migrate: ( oldAttributes ) => {
            // Transform to new structure
            return {
                content: oldAttributes.text,
                style: {
                    color: {
                        text: oldAttributes.textColor,
                    },
                },
            };
        },
        save: ( { attributes } ) => {
            // Old save function
            return <p style={ { color: attributes.textColor } }>{ attributes.text }</p>;
        },
    },
],
```

### Returning Inner Blocks

When migration creates inner blocks:

```js
migrate: ( oldAttributes, innerBlocks ) => {
    const newAttributes = {
        title: oldAttributes.heading,
    };
    
    // Create new inner blocks from old content
    const newInnerBlocks = [
        createBlock( 'core/paragraph', {
            content: oldAttributes.content,
        } ),
        ...innerBlocks,
    ];
    
    return [ newAttributes, newInnerBlocks ];
},
```

## isEligible

Check if a block instance matches this deprecation:

```js
deprecated: [
    {
        attributes: {
            content: { type: 'string' },
            align: { type: 'string' },
        },
        isEligible: ( attributes ) => {
            // This deprecation applies if 'align' attribute exists
            return typeof attributes.align !== 'undefined';
        },
        migrate: ( attributes ) => {
            return {
                content: attributes.content,
                alignment: attributes.align, // Renamed attribute
            };
        },
        save: ( { attributes } ) => {
            return <div className={ `align-${ attributes.align }` }>{ attributes.content }</div>;
        },
    },
],
```

### Complex Eligibility

```js
isEligible: ( attributes, innerBlocks ) => {
    // Check attributes
    if ( attributes.version && attributes.version >= 2 ) {
        return false;
    }
    
    // Check inner blocks structure
    if ( innerBlocks.some( block => block.name === 'core/paragraph' ) ) {
        return true;
    }
    
    return false;
},
```

## Multiple Deprecations

Order matters - WordPress tries each deprecation in array order:

```js
deprecated: [
    // Most recent deprecation first
    {
        // Version 2 -> 3 migration
        attributes: { /* v2 attributes */ },
        save: /* v2 save */,
        migrate: /* v2 -> v3 migration */,
    },
    {
        // Version 1 -> 2 migration (then 2->3 will run)
        attributes: { /* v1 attributes */ },
        save: /* v1 save */,
        migrate: /* v1 -> v2 migration */,
    },
],
```

## Complete Example: Multi-Version Migration

```js
const v1Attributes = {
    text: { type: 'string' },
    color: { type: 'string' },
};

const v1Save = ( { attributes } ) => {
    return (
        <div style={ { color: attributes.color } }>
            { attributes.text }
        </div>
    );
};

const v2Attributes = {
    content: { type: 'string' },
    textColor: { type: 'string' },
};

const v2Save = ( { attributes } ) => {
    return (
        <div className={ `has-${ attributes.textColor }-color` }>
            { attributes.content }
        </div>
    );
};

// Current version (v3)
const v3Attributes = {
    content: {
        type: 'string',
        source: 'html',
        selector: 'p',
    },
    style: {
        type: 'object',
    },
};

registerBlockType( 'my-plugin/text-block', {
    attributes: v3Attributes,
    
    save: ( { attributes } ) => {
        const { content, style } = attributes;
        return (
            <div { ...useBlockProps.save() }>
                <p>{ content }</p>
            </div>
        );
    },
    
    deprecated: [
        // v2 -> v3
        {
            attributes: v2Attributes,
            save: v2Save,
            migrate: ( { content, textColor } ) => {
                return {
                    content,
                    style: {
                        color: { text: textColor },
                    },
                };
            },
        },
        // v1 -> v2 (will then migrate to v3)
        {
            attributes: v1Attributes,
            save: v1Save,
            migrate: ( { text, color } ) => {
                return {
                    content: text,
                    textColor: color,
                };
            },
        },
    ],
} );
```

## Supports Changes

When supports change, include old supports in deprecation:

```js
deprecated: [
    {
        attributes: { /* same */ },
        supports: {
            // Old supports - no color support
            align: true,
        },
        save: ( { attributes } ) => {
            // Old save without color classes
            return <div>{ attributes.content }</div>;
        },
    },
],

// Current block has new supports
supports: {
    align: true,
    color: {
        text: true,
        background: true,
    },
},
```

## HTML Structure Changes

When markup changes:

```js
// Old save wrapped content in <section>
const oldSave = ( { attributes } ) => {
    return (
        <section className="old-wrapper">
            <p>{ attributes.content }</p>
        </section>
    );
};

// New save uses <div>
const newSave = ( { attributes } ) => {
    return (
        <div className="new-wrapper">
            <p>{ attributes.content }</p>
        </div>
    );
};

deprecated: [
    {
        attributes: { content: { type: 'string' } },
        save: oldSave,
        // No migrate needed if attributes unchanged
    },
],
```

## InnerBlocks Migration

Convert old content to inner blocks:

```js
deprecated: [
    {
        attributes: {
            items: {
                type: 'array',
                default: [],
            },
        },
        migrate: ( attributes ) => {
            const innerBlocks = attributes.items.map( ( item ) =>
                createBlock( 'my-plugin/item', {
                    title: item.title,
                    content: item.content,
                } )
            );
            
            return [
                {}, // New attributes (empty, items now in inner blocks)
                innerBlocks,
            ];
        },
        save: ( { attributes } ) => {
            return (
                <ul>
                    { attributes.items.map( ( item, i ) => (
                        <li key={ i }>{ item.title }</li>
                    ) ) }
                </ul>
            );
        },
    },
],
```

## Dynamic Block Deprecations

For dynamic blocks, deprecations still matter for the save function:

```js
registerBlockType( 'my-plugin/dynamic', {
    attributes: {
        postId: { type: 'number' },
        showMeta: { type: 'boolean', default: true }, // New attribute
    },
    
    // Save returns null for dynamic blocks
    save: () => null,
    
    deprecated: [
        {
            attributes: {
                postId: { type: 'number' },
                // No showMeta in old version
            },
            // Even dynamic blocks need old save
            save: () => null,
            migrate: ( attributes ) => {
                return {
                    ...attributes,
                    showMeta: true, // Default for migrated blocks
                };
            },
        },
    ],
} );
```

## Testing Deprecations

Create test cases for each deprecation:

```js
// In your test file
import { registerBlockType, createBlock, serialize } from '@wordpress/blocks';
import { deprecated } from './deprecations';

describe( 'Block Deprecations', () => {
    it( 'migrates v1 to current', () => {
        const v1Block = createBlock( 'my-plugin/card', {
            text: 'Hello',
            color: 'red',
        } );
        
        // Trigger migration
        const [ newAttributes ] = deprecated[ 1 ].migrate( v1Block.attributes );
        
        expect( newAttributes.content ).toBe( 'Hello' );
        expect( newAttributes.style.color.text ).toBe( 'red' );
    } );
} );
```

## Avoiding Deprecations

Minimize deprecations by:

1. **Use `meta` source sparingly:** Meta changes don't need deprecations
2. **Plan attribute structure:** Think about future additions
3. **Use object attributes:** Easier to extend than flat attributes
4. **Save minimal HTML:** Less markup = fewer breaking changes
5. **Consider dynamic blocks:** No HTML to deprecate

## Best Practices

1. **Keep all deprecations:** Never remove old deprecations.

2. **Test migrations:** Verify old content migrates correctly.

3. **Order by version:** Newest deprecation first.

4. **Include old save:** Must match exactly what old version saved.

5. **Handle all attributes:** Migrate all attributes, not just changed ones.

6. **Document versions:** Comment which version each deprecation handles.

7. **Use isEligible carefully:** Only when save functions look identical.

8. **Test in real content:** Try with actual posts using old block versions.
