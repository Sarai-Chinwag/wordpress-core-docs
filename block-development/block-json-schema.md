# block.json Schema Reference

The `block.json` file is the canonical way to register blocks in WordPress. It defines metadata, assets, and behavior for your block.

## File Location

Place `block.json` in your block's root directory:

```
my-plugin/
├── blocks/
│   └── my-block/
│       ├── block.json
│       ├── index.js
│       ├── edit.js
│       ├── save.js
│       └── style.css
```

## Complete Schema

### Required Fields

#### `$schema`

JSON Schema URL for IDE autocompletion:

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json"
}
```

Use version-specific schemas:
- `https://schemas.wp.org/wp/6.5/block.json`
- `https://schemas.wp.org/wp/6.4/block.json`

#### `apiVersion`

Block API version. Currently `3` is latest:

```json
{
    "apiVersion": 3
}
```

| Version | WordPress | Key Changes |
|---------|-----------|-------------|
| 1 | 5.0+ | Original API |
| 2 | 5.6+ | `useBlockProps`, block wrapper handling |
| 3 | 6.3+ | `render` field, improved selectors support |

#### `name`

Unique block identifier in `namespace/block-name` format:

```json
{
    "name": "my-plugin/testimonial"
}
```

Rules:
- Lowercase alphanumeric with hyphens
- Must include namespace and block name
- Namespace should match your plugin/theme
- Cannot use `core/` namespace (reserved)

#### `title`

Human-readable block name (translatable):

```json
{
    "title": "Testimonial"
}
```

### Recommended Fields

#### `version`

Block version for cache busting:

```json
{
    "version": "1.0.0"
}
```

#### `category`

Block category in inserter:

```json
{
    "category": "widgets"
}
```

Core categories:
- `text` - Text blocks
- `media` - Image, video, audio
- `design` - Layout and design elements
- `widgets` - Dynamic widgets
- `theme` - Theme-specific blocks
- `embed` - Embed blocks

Register custom categories:

```php
add_filter( 'block_categories_all', function( $categories ) {
    return array_merge(
        $categories,
        [
            [
                'slug'  => 'my-custom-category',
                'title' => __( 'My Custom Category', 'my-plugin' ),
                'icon'  => 'star-filled',
            ],
        ]
    );
} );
```

#### `icon`

Block icon (Dashicon or custom SVG):

```json
{
    "icon": "star-filled"
}
```

Using Dashicons (without `dashicons-` prefix):

```json
{
    "icon": "admin-comments"
}
```

Custom SVG (in JavaScript registration, not block.json):

```js
registerBlockType( 'my-plugin/block', {
    icon: {
        src: <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>,
        foreground: '#ff0000',
        background: '#ffffff',
    },
    // ...
} );
```

#### `description`

Block description for inserter tooltip:

```json
{
    "description": "Display customer testimonials with photo and quote."
}
```

#### `keywords`

Search terms for block inserter (max 3):

```json
{
    "keywords": [ "quote", "review", "feedback" ]
}
```

#### `textdomain`

Text domain for translations:

```json
{
    "textdomain": "my-plugin"
}
```

### Block Behavior Fields

#### `parent`

Restrict block to specific parent blocks:

```json
{
    "parent": [ "core/group", "my-plugin/container" ]
}
```

The block only appears in inserter when inside specified parents.

#### `ancestor`

Restrict block to be nested within ancestor (any depth):

```json
{
    "ancestor": [ "core/columns" ]
}
```

Unlike `parent`, ancestor allows any nesting depth.

#### `allowedBlocks`

Restrict which blocks can be inserted as children:

```json
{
    "allowedBlocks": [ "core/paragraph", "core/heading", "core/image" ]
}
```

### Attributes

Define block data storage:

```json
{
    "attributes": {
        "content": {
            "type": "string",
            "source": "html",
            "selector": "p"
        },
        "alignment": {
            "type": "string",
            "default": "left"
        },
        "count": {
            "type": "number",
            "default": 3
        }
    }
}
```

See [attributes.md](./attributes.md) for complete documentation.

### Supports

Enable/disable block features:

```json
{
    "supports": {
        "align": true,
        "color": {
            "background": true,
            "text": true
        },
        "typography": {
            "fontSize": true,
            "lineHeight": true
        }
    }
}
```

See [supports.md](./supports.md) for complete documentation.

### Asset Fields

#### `editorScript`

JavaScript for editor only:

```json
{
    "editorScript": "file:./index.js"
}
```

Multiple files:

```json
{
    "editorScript": [
        "file:./index.js",
        "file:./sidebar.js"
    ]
}
```

Registered handle:

```json
{
    "editorScript": "my-plugin-editor"
}
```

#### `editorStyle`

CSS for editor only:

```json
{
    "editorStyle": "file:./editor.css"
}
```

#### `script`

JavaScript for both editor and frontend:

```json
{
    "script": "file:./script.js"
}
```

#### `style`

CSS for both editor and frontend:

```json
{
    "style": "file:./style.css"
}
```

#### `viewScript`

JavaScript for frontend only (when block is present):

```json
{
    "viewScript": "file:./view.js"
}
```

#### `viewScriptModule`

ES Module for frontend (WordPress 6.5+):

```json
{
    "viewScriptModule": "file:./view.js"
}
```

#### `viewStyle`

CSS for frontend only (WordPress 6.5+):

```json
{
    "viewStyle": "file:./view.css"
}
```

See [scripts-styles.md](./scripts-styles.md) for detailed comparison.

### Rendering

#### `render`

PHP template for server rendering (API version 3):

```json
{
    "render": "file:./render.php"
}
```

Available variables in render.php:
- `$attributes` - Block attributes
- `$content` - InnerBlocks content
- `$block` - WP_Block instance

See [dynamic-blocks.md](./dynamic-blocks.md) for details.

### Block Variations

#### `variations`

Define block variations:

```json
{
    "variations": [
        {
            "name": "blue",
            "title": "Blue Testimonial",
            "attributes": {
                "backgroundColor": "blue"
            }
        }
    ]
}
```

See [variations.md](./variations.md) for complete documentation.

### Block Styles

#### `styles`

Register visual style variants:

```json
{
    "styles": [
        {
            "name": "default",
            "label": "Default",
            "isDefault": true
        },
        {
            "name": "outlined",
            "label": "Outlined"
        }
    ]
}
```

See [styles.md](./styles.md) for complete documentation.

### Example Content

#### `example`

Preview content for inserter:

```json
{
    "example": {
        "attributes": {
            "content": "This is an example testimonial.",
            "author": "Jane Doe"
        }
    }
}
```

With nested blocks:

```json
{
    "example": {
        "attributes": {
            "title": "My Block"
        },
        "innerBlocks": [
            {
                "name": "core/paragraph",
                "attributes": {
                    "content": "Nested paragraph content."
                }
            }
        ]
    }
}
```

Disable preview:

```json
{
    "example": {}
}
```

### Block Hooks

#### `blockHooks`

Automatically insert block relative to others:

```json
{
    "blockHooks": {
        "core/post-content": "after",
        "core/navigation": "firstChild"
    }
}
```

Positions:
- `before` - Insert before target
- `after` - Insert after target
- `firstChild` - Insert as first child
- `lastChild` - Insert as last child

See [hooks.md](./hooks.md) for complete documentation.

### Selectors

#### `selectors`

Custom CSS selectors for block styling:

```json
{
    "selectors": {
        "root": ".wp-block-my-plugin-testimonial",
        "border": ".wp-block-my-plugin-testimonial__border",
        "typography": {
            "root": ".wp-block-my-plugin-testimonial__text"
        }
    }
}
```

### Provides Context / Uses Context

#### `providesContext`

Expose attributes to descendant blocks:

```json
{
    "providesContext": {
        "my-plugin/recordId": "recordId"
    }
}
```

#### `usesContext`

Consume context from ancestors:

```json
{
    "usesContext": [ "postId", "postType", "my-plugin/recordId" ]
}
```

See [context.md](./context.md) for complete documentation.

## Complete Example

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/testimonial",
    "version": "1.2.0",
    "title": "Testimonial",
    "category": "widgets",
    "icon": "format-quote",
    "description": "Display customer testimonials with photo, quote, and attribution.",
    "keywords": [ "quote", "review", "customer" ],
    "textdomain": "my-plugin",
    "attributes": {
        "quote": {
            "type": "string",
            "source": "html",
            "selector": "blockquote"
        },
        "author": {
            "type": "string",
            "source": "html",
            "selector": ".author-name"
        },
        "imageId": {
            "type": "number"
        },
        "imageUrl": {
            "type": "string",
            "source": "attribute",
            "selector": "img",
            "attribute": "src"
        }
    },
    "supports": {
        "align": [ "wide", "full" ],
        "color": {
            "background": true,
            "text": true,
            "gradients": true
        },
        "spacing": {
            "margin": true,
            "padding": true
        },
        "typography": {
            "fontSize": true,
            "lineHeight": true
        }
    },
    "styles": [
        {
            "name": "default",
            "label": "Default",
            "isDefault": true
        },
        {
            "name": "card",
            "label": "Card"
        }
    ],
    "example": {
        "attributes": {
            "quote": "This product changed my life!",
            "author": "Happy Customer"
        }
    },
    "editorScript": "file:./index.js",
    "editorStyle": "file:./editor.css",
    "style": "file:./style.css",
    "render": "file:./render.php"
}
```

## PHP Registration

Register the block in PHP:

```php
add_action( 'init', function() {
    register_block_type( __DIR__ . '/blocks/testimonial' );
} );
```

The function reads `block.json` automatically and registers all defined assets.

## Validation

Validate your block.json:

```bash
npx @wordpress/scripts check-block-json ./blocks/my-block/block.json
```

Use IDE schema support for real-time validation.
