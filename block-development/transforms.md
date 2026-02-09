# Block Transforms

Block transforms allow converting blocks between different types, enabling flexible content editing.

## Transform Types

| Type | Description |
|------|-------------|
| `block` | Transform from/to another block |
| `enter` | Transform when pressing Enter on empty block |
| `files` | Transform from dropped/pasted files |
| `prefix` | Transform based on text prefix (like `##` for heading) |
| `raw` | Transform from raw HTML |
| `shortcode` | Transform from legacy shortcode |

## Basic Block Transform

Register transforms in your block's JavaScript:

```js
import { registerBlockType } from '@wordpress/blocks';
import { createBlock } from '@wordpress/blocks';

registerBlockType( 'my-plugin/callout', {
    // ... other settings
    transforms: {
        from: [
            {
                type: 'block',
                blocks: [ 'core/paragraph' ],
                transform: ( { content } ) => {
                    return createBlock( 'my-plugin/callout', {
                        content,
                    } );
                },
            },
        ],
        to: [
            {
                type: 'block',
                blocks: [ 'core/paragraph' ],
                transform: ( { content } ) => {
                    return createBlock( 'core/paragraph', {
                        content,
                    } );
                },
            },
        ],
    },
} );
```

## Transform From Multiple Blocks

Transform multiple selected blocks:

```js
transforms: {
    from: [
        {
            type: 'block',
            blocks: [ 'core/paragraph' ],
            isMultiBlock: true,
            transform: ( paragraphs ) => {
                // paragraphs is an array of attributes
                const combinedContent = paragraphs
                    .map( ( { content } ) => content )
                    .join( '<br>' );
                
                return createBlock( 'my-plugin/callout', {
                    content: combinedContent,
                } );
            },
        },
    ],
},
```

## Transform to Multiple Blocks

Create multiple blocks from one:

```js
transforms: {
    to: [
        {
            type: 'block',
            blocks: [ 'core/paragraph' ],
            transform: ( { items } ) => {
                // Create a paragraph for each item
                return items.map( ( item ) =>
                    createBlock( 'core/paragraph', {
                        content: item.text,
                    } )
                );
            },
        },
    ],
},
```

## Wildcard Transform

Transform from any block:

```js
transforms: {
    from: [
        {
            type: 'block',
            blocks: [ '*' ],
            transform: ( attributes, innerBlocks ) => {
                return createBlock( 'my-plugin/wrapper', {}, innerBlocks );
            },
        },
    ],
},
```

## Conditional Transforms

Use `isMatch` to conditionally enable transforms:

```js
transforms: {
    from: [
        {
            type: 'block',
            blocks: [ 'core/paragraph' ],
            isMatch: ( { content } ) => {
                // Only transform if content starts with "Note:"
                return content?.startsWith( 'Note:' );
            },
            transform: ( { content } ) => {
                return createBlock( 'my-plugin/note', {
                    content: content.replace( 'Note:', '' ).trim(),
                } );
            },
        },
    ],
},
```

## Priority

Control transform order with priority:

```js
transforms: {
    from: [
        {
            type: 'block',
            blocks: [ 'core/paragraph' ],
            priority: 1, // Lower = higher priority (default is 10)
            transform: ( attributes ) => {
                return createBlock( 'my-plugin/special', attributes );
            },
        },
    ],
},
```

## Prefix Transforms

Transform when typing a prefix:

```js
transforms: {
    from: [
        {
            type: 'prefix',
            prefix: '>>',
            transform: ( content ) => {
                return createBlock( 'my-plugin/callout', {
                    content,
                } );
            },
        },
    ],
},
```

Core examples:
- `#` → Heading 1
- `##` → Heading 2
- `*` or `-` → List
- `1.` → Ordered list
- `>` → Quote
- ``` → Code

## Enter Transforms

Transform when pressing Enter on empty block:

```js
transforms: {
    from: [
        {
            type: 'enter',
            regExp: /^---$/,
            transform: () => {
                return createBlock( 'core/separator' );
            },
        },
    ],
},
```

## File Transforms

Transform dropped or pasted files:

```js
transforms: {
    from: [
        {
            type: 'files',
            isMatch: ( files ) => {
                return files.length === 1 && 
                       files[ 0 ].type.startsWith( 'image/' );
            },
            transform: ( files ) => {
                const file = files[ 0 ];
                return createBlock( 'core/image', {
                    // Handle file upload separately
                } );
            },
        },
    ],
},
```

With priority for specific file types:

```js
transforms: {
    from: [
        {
            type: 'files',
            priority: 5, // Higher priority than core image block
            isMatch: ( files ) => {
                return files.every( ( file ) => 
                    file.type === 'image/svg+xml'
                );
            },
            transform: ( files ) => {
                return files.map( () =>
                    createBlock( 'my-plugin/svg-image' )
                );
            },
        },
    ],
},
```

## Raw HTML Transforms

Transform pasted HTML:

```js
transforms: {
    from: [
        {
            type: 'raw',
            selector: 'figure.my-custom-figure',
            transform: ( node ) => {
                const image = node.querySelector( 'img' );
                const caption = node.querySelector( 'figcaption' );
                
                return createBlock( 'my-plugin/custom-image', {
                    url: image?.src,
                    caption: caption?.innerHTML,
                } );
            },
        },
    ],
},
```

Using schema for automatic parsing:

```js
transforms: {
    from: [
        {
            type: 'raw',
            isMatch: ( node ) => 
                node.nodeName === 'P' && 
                node.classList.contains( 'my-class' ),
            schema: {
                p: {
                    classes: [ 'my-class' ],
                    children: {
                        strong: {},
                        em: {},
                        a: {
                            attributes: [ 'href' ],
                        },
                    },
                },
            },
            transform: ( node ) => {
                return createBlock( 'my-plugin/styled-paragraph', {
                    content: node.innerHTML,
                } );
            },
        },
    ],
},
```

## Shortcode Transforms

Transform legacy shortcodes:

```js
transforms: {
    from: [
        {
            type: 'shortcode',
            tag: 'my_gallery',
            attributes: {
                ids: {
                    type: 'array',
                    shortcode: ( { named: { ids } } ) => {
                        return ids.split( ',' ).map( Number );
                    },
                },
                columns: {
                    type: 'number',
                    shortcode: ( { named: { columns = 3 } } ) => {
                        return parseInt( columns, 10 );
                    },
                },
            },
            transform: ( { ids, columns } ) => {
                return createBlock( 'my-plugin/gallery', {
                    images: ids,
                    columns,
                } );
            },
        },
    ],
},
```

With content:

```js
transforms: {
    from: [
        {
            type: 'shortcode',
            tag: 'my_box',
            attributes: {
                title: {
                    type: 'string',
                    shortcode: ( { named: { title } } ) => title,
                },
                content: {
                    type: 'string',
                    shortcode: ( attrs, { content } ) => content,
                },
            },
        },
    ],
},
```

## Preserving Inner Blocks

Transform while keeping inner blocks:

```js
transforms: {
    from: [
        {
            type: 'block',
            blocks: [ 'core/group' ],
            transform: ( attributes, innerBlocks ) => {
                return createBlock( 'my-plugin/container', {
                    // Map relevant attributes
                    backgroundColor: attributes.backgroundColor,
                }, innerBlocks );
            },
        },
    ],
},
```

## Transform with Async Operations

Handle async operations like file uploads:

```js
import { mediaUpload } from '@wordpress/editor';

transforms: {
    from: [
        {
            type: 'files',
            isMatch: ( files ) => files.every( 
                ( file ) => file.type.startsWith( 'image/' ) 
            ),
            transform: ( files ) => {
                const blocks = files.map( () => 
                    createBlock( 'my-plugin/image' )
                );
                
                // Return blocks immediately, upload async
                files.forEach( ( file, index ) => {
                    mediaUpload( {
                        filesList: [ file ],
                        onFileChange: ( [ media ] ) => {
                            if ( media.id ) {
                                // Update block attributes via dispatch
                            }
                        },
                    } );
                } );
                
                return blocks;
            },
        },
    ],
},
```

## Complete Example: FAQ Block

```js
import { registerBlockType, createBlock } from '@wordpress/blocks';

registerBlockType( 'my-plugin/faq', {
    title: 'FAQ',
    category: 'text',
    attributes: {
        question: { type: 'string' },
        answer: { type: 'string' },
    },
    transforms: {
        from: [
            // From paragraph
            {
                type: 'block',
                blocks: [ 'core/paragraph' ],
                transform: ( { content } ) => {
                    return createBlock( 'my-plugin/faq', {
                        question: '',
                        answer: content,
                    } );
                },
            },
            // From multiple paragraphs (Q&A pair)
            {
                type: 'block',
                blocks: [ 'core/paragraph' ],
                isMultiBlock: true,
                isMatch: ( paragraphs ) => paragraphs.length === 2,
                transform: ( paragraphs ) => {
                    return createBlock( 'my-plugin/faq', {
                        question: paragraphs[ 0 ].content,
                        answer: paragraphs[ 1 ].content,
                    } );
                },
            },
            // From heading + paragraph
            {
                type: 'block',
                blocks: [ 'core/heading', 'core/paragraph' ],
                isMultiBlock: true,
                transform: ( blocks ) => {
                    const heading = blocks.find( b => b.name === 'core/heading' );
                    const paragraph = blocks.find( b => b.name === 'core/paragraph' );
                    
                    return createBlock( 'my-plugin/faq', {
                        question: heading?.content || '',
                        answer: paragraph?.content || '',
                    } );
                },
            },
            // From shortcode
            {
                type: 'shortcode',
                tag: 'faq',
                attributes: {
                    question: {
                        shortcode: ( { named: { question } } ) => question,
                    },
                    answer: {
                        shortcode: ( attrs, { content } ) => content,
                    },
                },
            },
            // From raw HTML
            {
                type: 'raw',
                selector: 'div.faq-item',
                transform: ( node ) => {
                    return createBlock( 'my-plugin/faq', {
                        question: node.querySelector( '.faq-question' )?.textContent,
                        answer: node.querySelector( '.faq-answer' )?.innerHTML,
                    } );
                },
            },
        ],
        to: [
            // To paragraphs
            {
                type: 'block',
                blocks: [ 'core/paragraph' ],
                transform: ( { question, answer } ) => {
                    return [
                        createBlock( 'core/paragraph', {
                            content: `<strong>${ question }</strong>`,
                        } ),
                        createBlock( 'core/paragraph', {
                            content: answer,
                        } ),
                    ];
                },
            },
            // To heading + paragraph
            {
                type: 'block',
                blocks: [ 'core/heading' ],
                transform: ( { question, answer } ) => {
                    return [
                        createBlock( 'core/heading', {
                            level: 3,
                            content: question,
                        } ),
                        createBlock( 'core/paragraph', {
                            content: answer,
                        } ),
                    ];
                },
            },
        ],
    },
    // ... edit and save
} );
```

## Best Practices

1. **Preserve content:** Never lose user content during transforms.

2. **Map attributes intelligently:** Convert related attributes between block types.

3. **Support bidirectional transforms:** If A transforms to B, B should transform to A.

4. **Use isMatch wisely:** Only match when transform makes semantic sense.

5. **Handle edge cases:** Empty content, missing attributes, malformed input.

6. **Consider inner blocks:** Preserve nested content when possible.

7. **Test paste behavior:** Ensure raw transforms work with common HTML sources.

8. **Document shortcode conversions:** Help users migrate from legacy shortcodes.
