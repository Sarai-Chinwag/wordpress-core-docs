# Block Attributes

Attributes define the data structure for your block. They determine what gets saved and how values are extracted from saved content.

## Attribute Definition

Each attribute is defined with a type, optional source, and optional default:

```json
{
    "attributes": {
        "title": {
            "type": "string",
            "default": ""
        },
        "count": {
            "type": "number",
            "default": 5
        }
    }
}
```

## Attribute Types

### `string`

Text values:

```json
{
    "content": {
        "type": "string",
        "default": ""
    }
}
```

### `number`

Numeric values (integers or floats):

```json
{
    "columns": {
        "type": "number",
        "default": 3
    }
}
```

### `boolean`

True/false values:

```json
{
    "isVisible": {
        "type": "boolean",
        "default": true
    }
}
```

### `object`

Complex nested data:

```json
{
    "settings": {
        "type": "object",
        "default": {
            "showTitle": true,
            "showDate": false
        }
    }
}
```

### `array`

Lists of values:

```json
{
    "items": {
        "type": "array",
        "default": [],
        "items": {
            "type": "object"
        }
    }
}
```

Array with typed items:

```json
{
    "tags": {
        "type": "array",
        "items": {
            "type": "string"
        },
        "default": []
    }
}
```

### `integer`

Whole numbers only:

```json
{
    "postId": {
        "type": "integer"
    }
}
```

### `null`

Explicitly nullable:

```json
{
    "selectedItem": {
        "type": [ "object", "null" ],
        "default": null
    }
}
```

## Attribute Sources

Sources define how attribute values are extracted from saved HTML content.

### No Source (Block Comment)

When no source is specified, the value is stored in the block's HTML comment delimiter:

```json
{
    "mediaId": {
        "type": "number"
    }
}
```

Saved HTML:
```html
<!-- wp:my-plugin/block {"mediaId":123} -->
<div class="wp-block-my-plugin-block">...</div>
<!-- /wp:my-plugin/block -->
```

**Use for:** IDs, configuration options, non-visible data.

### `html`

Extracts innerHTML from an element:

```json
{
    "content": {
        "type": "string",
        "source": "html",
        "selector": "p"
    }
}
```

Saved HTML:
```html
<!-- wp:my-plugin/block -->
<div class="wp-block-my-plugin-block">
    <p>This content is extracted</p>
</div>
<!-- /wp:my-plugin/block -->
```

With `multiline` for multiple elements:

```json
{
    "content": {
        "type": "string",
        "source": "html",
        "selector": "ul",
        "multiline": "li"
    }
}
```

### `text`

Extracts text content (strips HTML):

```json
{
    "plainText": {
        "type": "string",
        "source": "text",
        "selector": ".title"
    }
}
```

### `attribute`

Extracts an HTML attribute value:

```json
{
    "url": {
        "type": "string",
        "source": "attribute",
        "selector": "a",
        "attribute": "href"
    }
}
```

```json
{
    "imageUrl": {
        "type": "string",
        "source": "attribute",
        "selector": "img",
        "attribute": "src"
    }
}
```

```json
{
    "altText": {
        "type": "string",
        "source": "attribute",
        "selector": "img",
        "attribute": "alt"
    }
}
```

### `query`

Extracts an array of values from multiple elements:

```json
{
    "images": {
        "type": "array",
        "source": "query",
        "selector": ".gallery-item",
        "query": {
            "url": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "src"
            },
            "alt": {
                "type": "string",
                "source": "attribute",
                "selector": "img",
                "attribute": "alt"
            },
            "caption": {
                "type": "string",
                "source": "html",
                "selector": "figcaption"
            }
        }
    }
}
```

Saved HTML:
```html
<div class="gallery">
    <figure class="gallery-item">
        <img src="image1.jpg" alt="First">
        <figcaption>Caption 1</figcaption>
    </figure>
    <figure class="gallery-item">
        <img src="image2.jpg" alt="Second">
        <figcaption>Caption 2</figcaption>
    </figure>
</div>
```

Extracted value:
```js
[
    { url: "image1.jpg", alt: "First", caption: "Caption 1" },
    { url: "image2.jpg", alt: "Second", caption: "Caption 2" }
]
```

### `meta` (Deprecated)

Links to post meta (deprecated, use block bindings instead):

```json
{
    "metaValue": {
        "type": "string",
        "source": "meta",
        "meta": "my_meta_key"
    }
}
```

Requires meta registration:

```php
register_post_meta( 'post', 'my_meta_key', [
    'show_in_rest' => true,
    'single'       => true,
    'type'         => 'string',
] );
```

## Selectors

Selectors determine which HTML element to extract from:

```json
{
    "title": {
        "type": "string",
        "source": "html",
        "selector": "h2.block-title"
    }
}
```

Selector types:
- Element: `"p"`, `"h2"`, `"img"`
- Class: `".my-class"`
- ID: `"#my-id"`
- Attribute: `"[data-type]"`
- Combined: `"div.content > p:first-child"`

**Important:** If multiple elements match, only the first is used (except with `query`).

## Default Values

Set default values for attributes:

```json
{
    "columns": {
        "type": "number",
        "default": 3
    },
    "alignment": {
        "type": "string",
        "default": "center"
    },
    "items": {
        "type": "array",
        "default": []
    },
    "settings": {
        "type": "object",
        "default": {
            "showImages": true,
            "maxItems": 10
        }
    }
}
```

## Enum Validation

Restrict values to specific options:

```json
{
    "size": {
        "type": "string",
        "enum": [ "small", "medium", "large" ],
        "default": "medium"
    }
}
```

## Role Attribute

Identify special attributes for WordPress features:

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "p",
        "__experimentalRole": "content"
    }
}
```

Roles:
- `content` - Block's main content (for synced patterns)
- `style` - Style-related data
- `other` - General configuration

## Rich Text Source

For RichText content (WordPress 6.5+):

```json
{
    "content": {
        "type": "rich-text",
        "source": "rich-text",
        "selector": "p"
    }
}
```

This preserves formatting data better than `html` source.

## Working with Attributes in JavaScript

### Reading Attributes

```js
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit( { attributes } ) {
    const { title, count, isVisible } = attributes;
    
    return (
        <div { ...useBlockProps() }>
            <h2>{ title }</h2>
            <p>Count: { count }</p>
        </div>
    );
}
```

### Setting Attributes

```js
export default function Edit( { attributes, setAttributes } ) {
    const { title } = attributes;
    
    return (
        <div { ...useBlockProps() }>
            <TextControl
                label="Title"
                value={ title }
                onChange={ ( newTitle ) => setAttributes( { title: newTitle } ) }
            />
        </div>
    );
}
```

### Setting Multiple Attributes

```js
setAttributes( {
    title: 'New Title',
    count: 5,
    isVisible: true,
} );
```

### Setting Nested Object Attributes

```js
const { settings } = attributes;

setAttributes( {
    settings: {
        ...settings,
        showTitle: false,
    },
} );
```

### Setting Array Attributes

```js
const { items } = attributes;

// Add item
setAttributes( {
    items: [ ...items, { id: Date.now(), text: 'New item' } ],
} );

// Remove item
setAttributes( {
    items: items.filter( ( item ) => item.id !== idToRemove ),
} );

// Update item
setAttributes( {
    items: items.map( ( item ) =>
        item.id === idToUpdate ? { ...item, text: 'Updated' } : item
    ),
} );
```

## PHP Access

In render.php or render_callback:

```php
<?php
// $attributes is available automatically in render.php
$title = $attributes['title'] ?? '';
$count = $attributes['count'] ?? 3;
$items = $attributes['items'] ?? [];

echo '<h2>' . esc_html( $title ) . '</h2>';
echo '<p>Count: ' . absint( $count ) . '</p>';

foreach ( $items as $item ) {
    echo '<li>' . esc_html( $item['text'] ) . '</li>';
}
```

## Complete Example

```json
{
    "attributes": {
        "mediaId": {
            "type": "number"
        },
        "mediaUrl": {
            "type": "string",
            "source": "attribute",
            "selector": "img",
            "attribute": "src"
        },
        "title": {
            "type": "string",
            "source": "html",
            "selector": ".card-title"
        },
        "description": {
            "type": "string",
            "source": "html",
            "selector": ".card-description"
        },
        "linkUrl": {
            "type": "string",
            "source": "attribute",
            "selector": "a.card-link",
            "attribute": "href"
        },
        "linkTarget": {
            "type": "string",
            "source": "attribute",
            "selector": "a.card-link",
            "attribute": "target"
        },
        "features": {
            "type": "array",
            "source": "query",
            "selector": ".feature-item",
            "query": {
                "icon": {
                    "type": "string",
                    "source": "attribute",
                    "selector": "svg",
                    "attribute": "data-icon"
                },
                "text": {
                    "type": "string",
                    "source": "html",
                    "selector": "span"
                }
            }
        },
        "layout": {
            "type": "string",
            "enum": [ "horizontal", "vertical" ],
            "default": "vertical"
        },
        "showFeatures": {
            "type": "boolean",
            "default": true
        }
    }
}
```

Save component:

```js
export default function Save( { attributes } ) {
    const {
        mediaUrl,
        title,
        description,
        linkUrl,
        linkTarget,
        features,
        showFeatures,
    } = attributes;
    
    return (
        <div { ...useBlockProps.save() }>
            { mediaUrl && <img src={ mediaUrl } alt="" /> }
            <h3 className="card-title">{ title }</h3>
            <p className="card-description">{ description }</p>
            { showFeatures && (
                <ul>
                    { features.map( ( feature, index ) => (
                        <li key={ index } className="feature-item">
                            <svg data-icon={ feature.icon } />
                            <span>{ feature.text }</span>
                        </li>
                    ) ) }
                </ul>
            ) }
            { linkUrl && (
                <a className="card-link" href={ linkUrl } target={ linkTarget }>
                    Learn More
                </a>
            ) }
        </div>
    );
}
```

## Best Practices

1. **Use appropriate sources:** Store visible content in HTML (with sources), configuration in block comment (no source).

2. **Provide defaults:** Always set sensible defaults, especially for new attributes.

3. **Keep it flat:** Avoid deeply nested objects when possible.

4. **Type correctly:** Use `number` for numbers, `boolean` for flags, `array` for lists.

5. **Validate with enum:** Restrict string values when there's a finite set of options.

6. **Consider migrations:** When changing attribute structure, add deprecations.
