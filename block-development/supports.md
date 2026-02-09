# Block Supports

Block supports enable built-in WordPress features for your block. They add UI controls and automatically handle CSS generation.

## Basic Usage

```json
{
    "supports": {
        "align": true,
        "color": {
            "background": true,
            "text": true
        }
    }
}
```

## Alignment

### `align`

Enable block alignment options:

```json
{
    "supports": {
        "align": true
    }
}
```

Adds alignment toolbar with: left, center, right, wide, full.

Restrict to specific alignments:

```json
{
    "supports": {
        "align": [ "wide", "full" ]
    }
}
```

Set default alignment:

```json
{
    "attributes": {
        "align": {
            "type": "string",
            "default": "wide"
        }
    },
    "supports": {
        "align": true
    }
}
```

### `alignWide`

Allow wide and full alignments (default: true):

```json
{
    "supports": {
        "alignWide": false
    }
}
```

Note: Theme must also declare `wide-alignment` support.

## Color

### `color`

Enable color controls:

```json
{
    "supports": {
        "color": {
            "background": true,
            "text": true,
            "link": true,
            "gradients": true,
            "heading": true,
            "button": true,
            "enableContrastChecker": true
        }
    }
}
```

#### `color.background`

Background color picker:

```json
{
    "supports": {
        "color": {
            "background": true
        }
    }
}
```

Applies class: `has-{color-slug}-background-color`
Applies style: `background-color`

#### `color.text`

Text color picker:

```json
{
    "supports": {
        "color": {
            "text": true
        }
    }
}
```

Applies class: `has-{color-slug}-color`
Applies style: `color`

#### `color.link`

Link color picker:

```json
{
    "supports": {
        "color": {
            "link": true
        }
    }
}
```

#### `color.gradients`

Gradient picker:

```json
{
    "supports": {
        "color": {
            "gradients": true
        }
    }
}
```

Applies class: `has-{gradient-slug}-gradient-background`

#### `color.heading`

Heading text color:

```json
{
    "supports": {
        "color": {
            "heading": true
        }
    }
}
```

#### `color.button`

Button colors:

```json
{
    "supports": {
        "color": {
            "button": true
        }
    }
}
```

#### `color.enableContrastChecker`

Show contrast warnings:

```json
{
    "supports": {
        "color": {
            "background": true,
            "text": true,
            "enableContrastChecker": true
        }
    }
}
```

Disable specific color support:

```json
{
    "supports": {
        "color": {
            "background": false,
            "text": true
        }
    }
}
```

#### `__experimentalDuotone`

Apply duotone filter to images:

```json
{
    "supports": {
        "color": {
            "__experimentalDuotone": "img"
        }
    }
}
```

Value is a CSS selector within the block.

## Typography

### `typography`

Enable typography controls:

```json
{
    "supports": {
        "typography": {
            "fontSize": true,
            "lineHeight": true,
            "textAlign": true,
            "fontFamily": true,
            "fontWeight": true,
            "fontStyle": true,
            "textTransform": true,
            "textDecoration": true,
            "letterSpacing": true,
            "writingMode": true
        }
    }
}
```

#### `typography.fontSize`

Font size picker:

```json
{
    "supports": {
        "typography": {
            "fontSize": true
        }
    }
}
```

Applies class: `has-{size-slug}-font-size`
Applies style: `font-size`

#### `typography.lineHeight`

Line height control:

```json
{
    "supports": {
        "typography": {
            "lineHeight": true
        }
    }
}
```

#### `typography.textAlign`

Text alignment buttons:

```json
{
    "supports": {
        "typography": {
            "textAlign": true
        }
    }
}
```

Restrict alignments:

```json
{
    "supports": {
        "typography": {
            "textAlign": [ "left", "center", "right" ]
        }
    }
}
```

#### `typography.fontFamily`

Font family picker:

```json
{
    "supports": {
        "typography": {
            "fontFamily": true
        }
    }
}
```

#### `typography.fontWeight`

Font weight selector:

```json
{
    "supports": {
        "typography": {
            "fontWeight": true
        }
    }
}
```

#### `typography.fontStyle`

Italic/normal toggle:

```json
{
    "supports": {
        "typography": {
            "fontStyle": true
        }
    }
}
```

#### `typography.textTransform`

Uppercase/lowercase/capitalize:

```json
{
    "supports": {
        "typography": {
            "textTransform": true
        }
    }
}
```

#### `typography.textDecoration`

Underline/strikethrough:

```json
{
    "supports": {
        "typography": {
            "textDecoration": true
        }
    }
}
```

#### `typography.letterSpacing`

Letter spacing control:

```json
{
    "supports": {
        "typography": {
            "letterSpacing": true
        }
    }
}
```

#### `typography.writingMode`

Vertical text support:

```json
{
    "supports": {
        "typography": {
            "writingMode": true
        }
    }
}
```

## Spacing

### `spacing`

Enable spacing controls:

```json
{
    "supports": {
        "spacing": {
            "margin": true,
            "padding": true,
            "blockGap": true
        }
    }
}
```

#### `spacing.margin`

Margin controls:

```json
{
    "supports": {
        "spacing": {
            "margin": true
        }
    }
}
```

Restrict to specific sides:

```json
{
    "supports": {
        "spacing": {
            "margin": [ "top", "bottom" ]
        }
    }
}
```

#### `spacing.padding`

Padding controls:

```json
{
    "supports": {
        "spacing": {
            "padding": true
        }
    }
}
```

Restrict to specific sides:

```json
{
    "supports": {
        "spacing": {
            "padding": [ "top", "bottom", "left", "right" ]
        }
    }
}
```

#### `spacing.blockGap`

Gap between child blocks:

```json
{
    "supports": {
        "spacing": {
            "blockGap": true
        }
    }
}
```

Restrict to axis:

```json
{
    "supports": {
        "spacing": {
            "blockGap": [ "horizontal", "vertical" ]
        }
    }
}
```

## Dimensions

### `dimensions`

Enable dimension controls:

```json
{
    "supports": {
        "dimensions": {
            "minHeight": true,
            "aspectRatio": true
        }
    }
}
```

#### `dimensions.minHeight`

Minimum height control:

```json
{
    "supports": {
        "dimensions": {
            "minHeight": true
        }
    }
}
```

#### `dimensions.aspectRatio`

Aspect ratio selector:

```json
{
    "supports": {
        "dimensions": {
            "aspectRatio": true
        }
    }
}
```

## Border

### `__experimentalBorder`

Enable border controls:

```json
{
    "supports": {
        "__experimentalBorder": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        }
    }
}
```

Shorthand for all:

```json
{
    "supports": {
        "__experimentalBorder": true
    }
}
```

Applies styles:
- `border-color`
- `border-radius`
- `border-style`
- `border-width`

## Position

### `position`

Enable position controls:

```json
{
    "supports": {
        "position": {
            "sticky": true
        }
    }
}
```

#### `position.sticky`

Sticky positioning:

```json
{
    "supports": {
        "position": {
            "sticky": true
        }
    }
}
```

## Layout

### `layout`

Enable layout controls for child blocks:

```json
{
    "supports": {
        "layout": true
    }
}
```

With specific options:

```json
{
    "supports": {
        "layout": {
            "allowSwitching": true,
            "allowEditing": true,
            "allowInheriting": true,
            "allowSizingOnChildren": true,
            "allowVerticalAlignment": true,
            "allowJustification": true,
            "allowOrientation": true,
            "allowCustomContentAndWideSize": true,
            "default": {
                "type": "flex",
                "flexWrap": "nowrap"
            }
        }
    }
}
```

Layout types:
- `constrained` - Width-constrained with content/wide sizes
- `flex` - Flexbox layout
- `grid` - CSS Grid layout (experimental)

## Interactivity

### `interactivity`

Enable Interactivity API:

```json
{
    "supports": {
        "interactivity": true
    }
}
```

With interactive namespace:

```json
{
    "supports": {
        "interactivity": {
            "clientNavigation": true,
            "interactive": true
        }
    }
}
```

## HTML Features

### `html`

Allow editing block as HTML (default: true):

```json
{
    "supports": {
        "html": false
    }
}
```

### `customClassName`

Allow custom CSS class (default: true):

```json
{
    "supports": {
        "customClassName": false
    }
}
```

### `className`

Add default block class (default: true):

```json
{
    "supports": {
        "className": false
    }
}
```

### `anchor`

Enable HTML anchor/ID field:

```json
{
    "supports": {
        "anchor": true
    }
}
```

## Other Supports

### `multiple`

Allow multiple instances (default: true):

```json
{
    "supports": {
        "multiple": false
    }
}
```

### `reusable`

Allow converting to reusable block (default: true):

```json
{
    "supports": {
        "reusable": false
    }
}
```

### `lock`

Allow locking the block (default: true):

```json
{
    "supports": {
        "lock": false
    }
}
```

### `inserter`

Show in block inserter (default: true):

```json
{
    "supports": {
        "inserter": false
    }
}
```

### `renaming`

Allow renaming the block (default: true):

```json
{
    "supports": {
        "renaming": false
    }
}
```

### `splitting`

Allow splitting block with Enter (WordPress 6.5+):

```json
{
    "supports": {
        "splitting": true
    }
}
```

### `background`

Enable background image controls (WordPress 6.4+):

```json
{
    "supports": {
        "background": {
            "backgroundImage": true,
            "backgroundSize": true
        }
    }
}
```

### `shadow`

Enable box shadow controls:

```json
{
    "supports": {
        "shadow": true
    }
}
```

### `filter`

Enable CSS filter controls:

```json
{
    "supports": {
        "filter": {
            "duotone": true
        }
    }
}
```

## Selectors for Supports

Override which element receives support styles:

```json
{
    "supports": {
        "color": {
            "text": true,
            "background": true
        },
        "typography": {
            "fontSize": true
        }
    },
    "selectors": {
        "root": ".wp-block-my-plugin-card",
        "color": {
            "text": ".wp-block-my-plugin-card__content"
        },
        "typography": {
            "root": ".wp-block-my-plugin-card__title"
        }
    }
}
```

## Complete Example

```json
{
    "supports": {
        "align": [ "wide", "full" ],
        "anchor": true,
        "className": true,
        "color": {
            "background": true,
            "text": true,
            "link": true,
            "gradients": true,
            "enableContrastChecker": true
        },
        "spacing": {
            "margin": [ "top", "bottom" ],
            "padding": true,
            "blockGap": true
        },
        "typography": {
            "fontSize": true,
            "lineHeight": true,
            "textAlign": true,
            "fontFamily": true
        },
        "__experimentalBorder": {
            "color": true,
            "radius": true,
            "style": true,
            "width": true
        },
        "dimensions": {
            "minHeight": true
        },
        "layout": {
            "default": {
                "type": "constrained"
            }
        },
        "shadow": true,
        "html": false,
        "multiple": true
    }
}
```

## Using Block Props

Support styles are automatically applied via `useBlockProps`:

```js
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit( { attributes } ) {
    const blockProps = useBlockProps();
    
    // blockProps includes:
    // - className (with support classes)
    // - style (with support inline styles)
    
    return (
        <div { ...blockProps }>
            Content here
        </div>
    );
}

export function Save( { attributes } ) {
    const blockProps = useBlockProps.save();
    
    return (
        <div { ...blockProps }>
            Content here
        </div>
    );
}
```

## Dynamic Blocks

For dynamic blocks, use `get_block_wrapper_attributes()`:

```php
<?php
// render.php
$wrapper_attributes = get_block_wrapper_attributes();
?>
<div <?php echo $wrapper_attributes; ?>>
    <?php echo esc_html( $attributes['content'] ); ?>
</div>
```

With additional classes:

```php
<?php
$wrapper_attributes = get_block_wrapper_attributes( [
    'class' => 'my-custom-class',
    'data-id' => $attributes['id'],
] );
?>
```

## Checking Support Values in PHP

```php
$block_type = WP_Block_Type_Registry::get_instance()->get_registered( 'my-plugin/block' );

// Check if block supports color
if ( $block_type->supports['color']['background'] ?? false ) {
    // Block supports background color
}

// Get all supports
$supports = $block_type->supports;
```
