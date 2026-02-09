# Block Styles

Block styles provide visual variations that users can apply from the block toolbar.

## Defining Styles in block.json

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
        },
        {
            "name": "shadow",
            "label": "Shadow"
        }
    ]
}
```

## Style Properties

| Property | Type | Description |
|----------|------|-------------|
| `name` | string | CSS class suffix (required) |
| `label` | string | Display name (required) |
| `isDefault` | boolean | Applied by default |

## How Styles Work

When a user selects a style, WordPress adds a class to the block:

```
is-style-{style-name}
```

For a style named `outlined`:
```html
<div class="wp-block-my-plugin-card is-style-outlined">
    ...
</div>
```

## CSS for Block Styles

Style your variations in CSS:

```css
/* Default style (no class needed, but can target explicitly) */
.wp-block-my-plugin-card,
.wp-block-my-plugin-card.is-style-default {
    border: 1px solid #ddd;
    padding: 20px;
}

/* Outlined style */
.wp-block-my-plugin-card.is-style-outlined {
    border: 2px solid currentColor;
    background: transparent;
}

/* Shadow style */
.wp-block-my-plugin-card.is-style-shadow {
    border: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}
```

## Editor Preview Styles

Ensure styles work in the editor by including them in `style.css` (loads in both editor and frontend) or by adding styles to `editorStyle`.

## JavaScript Registration

For more control, register styles in JavaScript:

```js
import { registerBlockStyle } from '@wordpress/blocks';

registerBlockStyle( 'core/quote', {
    name: 'fancy',
    label: 'Fancy',
} );

registerBlockStyle( 'core/quote', {
    name: 'modern',
    label: 'Modern',
    isDefault: true,
} );
```

## Registering Styles for Core Blocks

Add styles to core blocks:

```js
import { registerBlockStyle } from '@wordpress/blocks';

wp.domReady( () => {
    // Add styles to core/button
    registerBlockStyle( 'core/button', {
        name: 'gradient',
        label: 'Gradient',
    } );
    
    // Add styles to core/image
    registerBlockStyle( 'core/image', {
        name: 'rounded',
        label: 'Rounded Corners',
    } );
    
    registerBlockStyle( 'core/image', {
        name: 'polaroid',
        label: 'Polaroid',
    } );
} );
```

CSS for core block styles:

```css
/* Gradient button */
.wp-block-button.is-style-gradient .wp-block-button__link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

/* Rounded image */
.wp-block-image.is-style-rounded img {
    border-radius: 16px;
}

/* Polaroid image */
.wp-block-image.is-style-polaroid {
    background: white;
    padding: 12px 12px 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
```

## Unregistering Styles

Remove existing styles:

```js
import { unregisterBlockStyle } from '@wordpress/blocks';

wp.domReady( () => {
    // Remove the "plain" style from core/quote
    unregisterBlockStyle( 'core/quote', 'plain' );
    
    // Remove default style from core/image
    unregisterBlockStyle( 'core/image', 'default' );
} );
```

## PHP Registration

Register styles from PHP:

```php
add_action( 'init', function() {
    register_block_style(
        'core/paragraph',
        [
            'name'  => 'highlight',
            'label' => __( 'Highlight', 'my-plugin' ),
        ]
    );
    
    register_block_style(
        'core/paragraph',
        [
            'name'       => 'large-text',
            'label'      => __( 'Large Text', 'my-plugin' ),
            'is_default' => false,
            'style_handle' => 'my-plugin-block-styles', // Optional: associated stylesheet
        ]
    );
} );
```

With inline styles:

```php
register_block_style(
    'core/paragraph',
    [
        'name'         => 'fancy',
        'label'        => __( 'Fancy', 'my-plugin' ),
        'inline_style' => '.is-style-fancy { 
            font-family: Georgia, serif;
            font-style: italic;
            border-left: 4px solid currentColor;
            padding-left: 1em;
        }',
    ]
);
```

## Unregistering Styles in PHP

```php
add_action( 'init', function() {
    unregister_block_style( 'core/quote', 'plain' );
} );
```

Note: Must run after the style is registered (priority matters).

## Style Variations via theme.json

Define styles in theme.json for theme-specific variations:

```json
{
    "version": 2,
    "styles": {
        "blocks": {
            "core/button": {
                "variations": {
                    "outline": {
                        "border": {
                            "width": "2px",
                            "style": "solid",
                            "color": "currentColor"
                        },
                        "color": {
                            "background": "transparent"
                        }
                    }
                }
            }
        }
    }
}
```

## Conditional Style Registration

Register styles based on context:

```php
add_action( 'init', function() {
    // Only for themes that support custom styles
    if ( current_theme_supports( 'custom-block-styles' ) ) {
        register_block_style( 'core/group', [
            'name'  => 'boxed',
            'label' => __( 'Boxed', 'my-plugin' ),
        ] );
    }
} );
```

## Style-Specific Attributes

Some styles might need attribute changes. Handle in edit component:

```js
import { useEffect } from '@wordpress/element';

export default function Edit( { attributes, setAttributes } ) {
    const { className } = attributes;
    
    // Adjust attributes based on style
    useEffect( () => {
        if ( className?.includes( 'is-style-compact' ) ) {
            setAttributes( { padding: 'small' } );
        }
    }, [ className ] );
    
    // ...
}
```

## Complete Example: Card Block with Styles

```json
{
    "$schema": "https://schemas.wp.org/trunk/block.json",
    "apiVersion": 3,
    "name": "my-plugin/card",
    "title": "Card",
    "category": "design",
    "styles": [
        {
            "name": "default",
            "label": "Default",
            "isDefault": true
        },
        {
            "name": "bordered",
            "label": "Bordered"
        },
        {
            "name": "elevated",
            "label": "Elevated"
        },
        {
            "name": "filled",
            "label": "Filled"
        }
    ],
    "style": "file:./style.css",
    "editorScript": "file:./index.js"
}
```

```css
/* style.css */

/* Base styles for all cards */
.wp-block-my-plugin-card {
    padding: 24px;
    border-radius: 8px;
}

/* Default style */
.wp-block-my-plugin-card.is-style-default {
    background: #ffffff;
    border: 1px solid #e2e8f0;
}

/* Bordered style */
.wp-block-my-plugin-card.is-style-bordered {
    background: transparent;
    border: 2px solid currentColor;
}

/* Elevated style */
.wp-block-my-plugin-card.is-style-elevated {
    background: #ffffff;
    border: none;
    box-shadow: 
        0 4px 6px -1px rgba(0, 0, 0, 0.1),
        0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Filled style */
.wp-block-my-plugin-card.is-style-filled {
    background: #f1f5f9;
    border: none;
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .wp-block-my-plugin-card.is-style-default {
        background: #1e293b;
        border-color: #334155;
    }
    
    .wp-block-my-plugin-card.is-style-elevated {
        background: #1e293b;
        box-shadow: 
            0 4px 6px -1px rgba(0, 0, 0, 0.3),
            0 2px 4px -1px rgba(0, 0, 0, 0.2);
    }
    
    .wp-block-my-plugin-card.is-style-filled {
        background: #334155;
    }
}
```

## Programmatic Style Detection

Check active style in PHP:

```php
function render_my_block( $attributes, $content, $block ) {
    $class_name = $attributes['className'] ?? '';
    
    // Check for specific style
    if ( str_contains( $class_name, 'is-style-elevated' ) ) {
        // Add extra markup for elevated style
    }
    
    return $content;
}
```

In JavaScript:

```js
export default function Edit( { attributes } ) {
    const { className } = attributes;
    
    const isElevated = className?.includes( 'is-style-elevated' );
    const isBordered = className?.includes( 'is-style-bordered' );
    
    return (
        <div { ...useBlockProps() }>
            { isElevated && <div className="shadow-overlay" /> }
            {/* ... */}
        </div>
    );
}
```

## Style Previews

Styles appear in the Styles panel with previews. The preview uses your block's `example`:

```json
{
    "example": {
        "attributes": {
            "title": "Card Title",
            "content": "Preview content for the card."
        }
    },
    "styles": [
        { "name": "default", "label": "Default", "isDefault": true },
        { "name": "bordered", "label": "Bordered" }
    ]
}
```

## Best Practices

1. **Consistent naming:** Use descriptive, lowercase names with hyphens.

2. **Always include default:** Mark one style as `isDefault: true`.

3. **Base styles first:** Write base styles that apply to all variations.

4. **Use specificity wisely:** `.block.is-style-name` is usually enough.

5. **Support dark mode:** Consider color scheme preferences.

6. **Test in editor:** Ensure styles render correctly in the block editor.

7. **Keep it visual:** Styles should create visible differences.

8. **Limit options:** 3-5 styles is usually plenty.
