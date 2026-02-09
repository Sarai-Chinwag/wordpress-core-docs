# Block Variations

Block variations create alternative versions of a block with pre-configured attributes and settings.

## Basic Variation

Define in block.json:

```json
{
    "variations": [
        {
            "name": "blue",
            "title": "Blue Card",
            "attributes": {
                "backgroundColor": "blue",
                "textColor": "white"
            }
        }
    ]
}
```

## Variation Properties

| Property | Type | Description |
|----------|------|-------------|
| `name` | string | Unique identifier (required) |
| `title` | string | Display name (required) |
| `description` | string | Variation description |
| `attributes` | object | Pre-set attribute values |
| `innerBlocks` | array | Pre-set inner blocks |
| `icon` | string/object | Custom icon |
| `category` | string | Block category override |
| `keywords` | array | Additional search terms |
| `isDefault` | boolean | Is this the default variation? |
| `isActive` | function/array | Determine if variation is active |
| `scope` | array | Where variation appears |
| `example` | object | Preview content |

## Defining Variations in JavaScript

For complex variations, define in JavaScript:

```js
import { registerBlockVariation } from '@wordpress/blocks';

registerBlockVariation( 'core/embed', {
    name: 'youtube',
    title: 'YouTube',
    icon: 'video-alt3',
    keywords: [ 'video', 'youtube' ],
    description: 'Embed a YouTube video.',
    attributes: {
        providerNameSlug: 'youtube',
        responsive: true,
    },
    isActive: ( blockAttributes, variationAttributes ) =>
        blockAttributes.providerNameSlug === variationAttributes.providerNameSlug,
} );
```

## Variation Scope

Control where variations appear:

```js
registerBlockVariation( 'my-plugin/card', {
    name: 'featured-card',
    title: 'Featured Card',
    scope: [ 'inserter', 'block', 'transform' ],
    attributes: {
        isFeatured: true,
    },
} );
```

Scope values:
- `inserter` - Show in block inserter
- `block` - Show in block toolbar's transform options
- `transform` - Available via block transforms

## isActive

Determines which variation a block instance matches.

### Array Form (Simple)

Match by attribute values:

```json
{
    "variations": [
        {
            "name": "youtube",
            "title": "YouTube",
            "attributes": {
                "providerNameSlug": "youtube"
            },
            "isActive": [ "providerNameSlug" ]
        }
    ]
}
```

### Function Form (Complex)

```js
registerBlockVariation( 'core/embed', {
    name: 'youtube',
    title: 'YouTube',
    attributes: {
        providerNameSlug: 'youtube',
    },
    isActive: ( blockAttributes, variationAttributes ) => {
        return blockAttributes.providerNameSlug === 'youtube';
    },
} );
```

Multiple conditions:

```js
isActive: ( blockAttributes ) => {
    return (
        blockAttributes.providerNameSlug === 'youtube' &&
        blockAttributes.responsive === true
    );
},
```

## Inner Blocks in Variations

Pre-configure nested blocks:

```js
registerBlockVariation( 'core/columns', {
    name: 'two-columns-equal',
    title: 'Two Columns (Equal)',
    innerBlocks: [
        [ 'core/column', { width: '50%' } ],
        [ 'core/column', { width: '50%' } ],
    ],
    scope: [ 'inserter' ],
} );

registerBlockVariation( 'core/columns', {
    name: 'two-columns-sidebar',
    title: 'Two Columns (Sidebar)',
    innerBlocks: [
        [ 'core/column', { width: '66.66%' } ],
        [ 'core/column', { width: '33.33%' } ],
    ],
    scope: [ 'inserter' ],
} );
```

With content in inner blocks:

```js
registerBlockVariation( 'core/group', {
    name: 'hero-section',
    title: 'Hero Section',
    attributes: {
        align: 'full',
        style: {
            spacing: {
                padding: {
                    top: 'var:preset|spacing|80',
                    bottom: 'var:preset|spacing|80',
                },
            },
        },
    },
    innerBlocks: [
        [ 'core/heading', { 
            level: 1, 
            placeholder: 'Hero Title',
            textAlign: 'center',
        } ],
        [ 'core/paragraph', { 
            placeholder: 'Hero subtitle or description',
            align: 'center',
        } ],
        [ 'core/buttons', { layout: { justifyContent: 'center' } }, [
            [ 'core/button', { placeholder: 'Call to Action' } ],
        ] ],
    ],
    scope: [ 'inserter' ],
} );
```

## Variation Icons

Custom icons per variation:

```js
registerBlockVariation( 'my-plugin/card', {
    name: 'horizontal-card',
    title: 'Horizontal Card',
    icon: 'align-left',
    attributes: {
        layout: 'horizontal',
    },
} );

// Or with custom SVG
registerBlockVariation( 'my-plugin/card', {
    name: 'vertical-card',
    title: 'Vertical Card',
    icon: (
        <svg viewBox="0 0 24 24">
            <path d="M4 4h16v16H4z" />
        </svg>
    ),
    attributes: {
        layout: 'vertical',
    },
} );
```

## Setting Default Variation

Mark one variation as default:

```js
registerBlockVariation( 'my-plugin/container', {
    name: 'standard',
    title: 'Standard Container',
    isDefault: true,
    attributes: {
        padding: 'medium',
    },
} );
```

## Unregistering Variations

Remove existing variations:

```js
import { unregisterBlockVariation } from '@wordpress/blocks';

// Remove the YouTube embed variation
wp.domReady( () => {
    unregisterBlockVariation( 'core/embed', 'youtube' );
} );
```

## Overriding Core Variations

Modify existing variations:

```js
import { getBlockVariations, unregisterBlockVariation, registerBlockVariation } from '@wordpress/blocks';

wp.domReady( () => {
    // Get existing variation
    const variations = getBlockVariations( 'core/embed' );
    const youtube = variations.find( v => v.name === 'youtube' );
    
    if ( youtube ) {
        // Unregister original
        unregisterBlockVariation( 'core/embed', 'youtube' );
        
        // Register modified version
        registerBlockVariation( 'core/embed', {
            ...youtube,
            title: 'Custom YouTube',
            keywords: [ ...youtube.keywords, 'custom' ],
        } );
    }
} );
```

## Variation Example Content

Provide preview in inserter:

```js
registerBlockVariation( 'my-plugin/testimonial', {
    name: 'customer-review',
    title: 'Customer Review',
    attributes: {
        style: 'card',
    },
    example: {
        attributes: {
            quote: 'This product exceeded my expectations!',
            author: 'Jane Smith',
            rating: 5,
        },
    },
} );
```

## Complete Example: Social Links Variations

```js
const socialVariations = [
    {
        name: 'facebook',
        title: 'Facebook',
        icon: 'facebook',
        attributes: {
            service: 'facebook',
            url: 'https://facebook.com/',
        },
    },
    {
        name: 'twitter',
        title: 'Twitter',
        icon: 'twitter',
        attributes: {
            service: 'twitter',
            url: 'https://twitter.com/',
        },
    },
    {
        name: 'instagram',
        title: 'Instagram',
        attributes: {
            service: 'instagram',
            url: 'https://instagram.com/',
        },
        icon: (
            <svg viewBox="0 0 24 24">
                <path d="M12 2c2.717 0 3.056.01 4.122.06..." />
            </svg>
        ),
    },
];

socialVariations.forEach( ( variation ) => {
    registerBlockVariation( 'core/social-link', {
        ...variation,
        isActive: ( blockAttributes ) => 
            blockAttributes.service === variation.attributes.service,
    } );
} );
```

## Query Loop Variations

Create custom query patterns:

```js
registerBlockVariation( 'core/query', {
    name: 'recent-posts-grid',
    title: 'Recent Posts Grid',
    description: 'Display recent posts in a grid layout',
    attributes: {
        query: {
            perPage: 6,
            postType: 'post',
            orderBy: 'date',
            order: 'desc',
        },
        displayLayout: {
            type: 'flex',
            columns: 3,
        },
    },
    innerBlocks: [
        [ 'core/post-template', {}, [
            [ 'core/post-featured-image' ],
            [ 'core/post-title' ],
            [ 'core/post-excerpt' ],
        ] ],
        [ 'core/query-pagination' ],
    ],
    scope: [ 'inserter' ],
    isActive: ( { query } ) => query.perPage === 6 && query.orderBy === 'date',
} );
```

## PHP Registration

Register variations from PHP:

```php
add_action( 'init', function() {
    $block_type = WP_Block_Type_Registry::get_instance()->get_registered( 'core/group' );
    
    if ( $block_type ) {
        $block_type->variations = array_merge(
            $block_type->variations ?? [],
            [
                [
                    'name'       => 'full-width-section',
                    'title'      => __( 'Full Width Section', 'my-plugin' ),
                    'attributes' => [
                        'align' => 'full',
                        'layout' => [
                            'type' => 'constrained',
                        ],
                    ],
                    'scope'      => [ 'inserter' ],
                ],
            ]
        );
    }
} );
```

Or use the filter:

```php
add_filter( 'get_block_type_variations', function( $variations, $block_type ) {
    if ( $block_type->name === 'core/columns' ) {
        $variations[] = [
            'name'        => 'three-equal',
            'title'       => __( 'Three Equal Columns', 'my-plugin' ),
            'innerBlocks' => [
                [ 'core/column', [ 'width' => '33.33%' ] ],
                [ 'core/column', [ 'width' => '33.33%' ] ],
                [ 'core/column', [ 'width' => '33.33%' ] ],
            ],
            'scope'       => [ 'inserter' ],
        ];
    }
    return $variations;
}, 10, 2 );
```

## Best Practices

1. **Use meaningful names:** Variation names should clearly indicate their purpose.

2. **Set isActive correctly:** Ensure variations are properly identified when editing.

3. **Provide good descriptions:** Help users understand what each variation does.

4. **Use appropriate scope:** Don't clutter the inserter with every variation.

5. **Include example content:** Makes variations easier to understand in the inserter.

6. **Group related variations:** Keep variations for the same block together.

7. **Consider transforms:** Enable variations in transform scope when switching makes sense.
