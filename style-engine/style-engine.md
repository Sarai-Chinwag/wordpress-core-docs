# Style Engine

Consistent API for rendering CSS styles for blocks across client-side and server-side applications.

**Since:** 6.1.0  
**Source:** `wp-includes/style-engine.php`, `wp-includes/style-engine/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Public API functions |
| [class-wp-style-engine.md](./class-wp-style-engine.md) | Core parsing and compilation engine |
| [class-wp-style-engine-css-rule.md](./class-wp-style-engine-css-rule.md) | CSS rule representation |
| [class-wp-style-engine-css-declarations.md](./class-wp-style-engine-css-declarations.md) | CSS declaration collection |
| [class-wp-style-engine-processor.md](./class-wp-style-engine-processor.md) | Stylesheet compilation |

## Architecture

```
Block Style Object (theme.json / block attributes)
    │
    ├── wp_style_engine_get_styles()
    │       └── WP_Style_Engine::parse_block_styles()
    │               ├── get_classnames()
    │               └── get_css_declarations()
    │
    └── wp_style_engine_get_stylesheet_from_css_rules()
            └── WP_Style_Engine_Processor
                    ├── add_rules()
                    ├── combine_rules_selectors() [optional]
                    └── get_css()
```

## Supported Style Properties

| Category | Properties |
|----------|------------|
| **background** | backgroundImage, backgroundPosition, backgroundRepeat, backgroundSize, backgroundAttachment |
| **color** | text, background, gradient |
| **border** | color, radius, style, width, top, right, bottom, left |
| **shadow** | shadow (box-shadow) |
| **dimensions** | aspectRatio, minHeight |
| **spacing** | padding, margin |
| **typography** | fontSize, fontFamily, fontStyle, fontWeight, lineHeight, textColumns, textDecoration, textTransform, letterSpacing, writingMode |

## Preset Variables

The engine converts preset references to CSS custom properties:

```php
// Input
'var:preset|color|vivid-red'

// Output
'var(--wp--preset--color--vivid-red)'
```

## CSS Storage

Styles can be stored in named contexts for later retrieval:

```php
// Store during parsing
wp_style_engine_get_styles( $styles, array(
    'context'  => 'block-supports',
    'selector' => '.wp-block-example',
) );

// Retrieve compiled stylesheet
$css = wp_style_engine_get_stylesheet_from_context( 'block-supports' );
```
