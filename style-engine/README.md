# Style Engine

The Style Engine provides a consistent API for generating and managing CSS styles in WordPress, particularly for block styles and theme.json.

**Since:** WordPress 6.1.0

## Overview

The Style Engine:

- Parses block style objects into CSS declarations
- Generates classnames for preset values
- Compiles CSS rules from collections of selectors and declarations
- Stores and retrieves CSS rules by context
- Supports CSS optimization and formatting

## Core Functions

### wp_style_engine_get_styles()

Generates styles from a block style object.

```php
wp_style_engine_get_styles( array $block_styles, array $options = array() ): array
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$block_styles` | array | Style object (e.g., `attributes.style`) |
| `$options` | array | Configuration options |

**Options:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `selector` | string | null | CSS selector for full rule output |
| `context` | string | null | Store context for CSS caching |
| `convert_vars_to_classnames` | bool | false | Skip CSS var conversion |

**Returns:**

```php
array(
    'css'          => 'color: #cccccc;',           // CSS declarations/rule
    'declarations' => array( 'color' => '#cccccc' ), // Key-value pairs
    'classnames'   => 'has-text-color',            // Generated classnames
)
```

**Example:**

```php
$styles = wp_style_engine_get_styles( array(
    'color' => array(
        'text'       => '#333333',
        'background' => '#ffffff',
    ),
    'spacing' => array(
        'padding' => '20px',
        'margin'  => array(
            'top'    => '10px',
            'bottom' => '10px',
        ),
    ),
    'typography' => array(
        'fontSize'   => '16px',
        'fontWeight' => 'bold',
    ),
) );

// Result:
// array(
//     'css' => 'color:#333333;background-color:#ffffff;padding:20px;margin-top:10px;margin-bottom:10px;font-size:16px;font-weight:bold;',
//     'declarations' => array( ... ),
//     'classnames' => 'has-text-color has-background',
// )
```

---

### wp_style_engine_get_stylesheet_from_css_rules()

Compiles CSS from a collection of rules.

```php
wp_style_engine_get_stylesheet_from_css_rules( array $css_rules, array $options = array() ): string
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$css_rules` | array | Collection of CSS rules |
| `$options` | array | Configuration options |

**Rule Structure:**

```php
array(
    'selector'     => '.my-class',
    'declarations' => array( 'color' => 'red', 'font-size' => '16px' ),
    'rules_group'  => '@media (min-width: 768px)', // Optional, for nested rules
)
```

**Options:**

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `context` | string | null | Store context for CSS caching |
| `optimize` | bool | false | Combine duplicate rules |
| `prettify` | bool | SCRIPT_DEBUG | Format with newlines/indents |

**Example:**

```php
$css_rules = array(
    array(
        'selector'     => '.button',
        'declarations' => array(
            'background-color' => 'blue',
            'color'            => 'white',
            'padding'          => '10px 20px',
        ),
    ),
    array(
        'selector'     => '.button:hover',
        'declarations' => array(
            'background-color' => 'darkblue',
        ),
    ),
    array(
        'selector'     => '.button',
        'declarations' => array(
            'font-size' => '18px',
        ),
        'rules_group'  => '@media (min-width: 768px)',
    ),
);

$css = wp_style_engine_get_stylesheet_from_css_rules( $css_rules );

// Output:
// .button{background-color:blue;color:white;padding:10px 20px;}
// .button:hover{background-color:darkblue;}
// @media (min-width: 768px){.button{font-size:18px;}}
```

---

### wp_style_engine_get_stylesheet_from_context()

Retrieves compiled CSS from a stored context.

```php
wp_style_engine_get_stylesheet_from_context( string $context, array $options = array() ): string
```

**Example:**

```php
// First, store rules with a context
wp_style_engine_get_styles(
    array( 'color' => array( 'text' => 'red' ) ),
    array(
        'context'  => 'my-plugin-styles',
        'selector' => '.my-element',
    )
);

// Later, retrieve all styles for that context
$css = wp_style_engine_get_stylesheet_from_context( 'my-plugin-styles' );
// Output: .my-element{color:red;}
```

---

## Supported Style Properties

### Color

```php
'color' => array(
    'text'       => '#333',      // color
    'background' => '#fff',      // background-color
    'gradient'   => 'linear-gradient(...)', // background
)
```

### Spacing

```php
'spacing' => array(
    'padding' => '20px',         // padding (all sides)
    'padding' => array(          // individual sides
        'top'    => '10px',
        'right'  => '15px',
        'bottom' => '10px',
        'left'   => '15px',
    ),
    'margin'  => '20px',         // margin
    'blockGap' => '1em',         // gap
)
```

### Typography

```php
'typography' => array(
    'fontSize'       => '16px',
    'fontFamily'     => 'Arial, sans-serif',
    'fontWeight'     => 'bold',
    'fontStyle'      => 'italic',
    'lineHeight'     => '1.5',
    'textDecoration' => 'underline',
    'textTransform'  => 'uppercase',
    'letterSpacing'  => '0.5px',
)
```

### Border

```php
'border' => array(
    'color'  => '#000',
    'width'  => '1px',
    'style'  => 'solid',
    'radius' => '4px',           // border-radius
    'radius' => array(           // individual corners
        'topLeft'     => '4px',
        'topRight'    => '4px',
        'bottomRight' => '4px',
        'bottomLeft'  => '4px',
    ),
    'top'    => array(           // individual sides
        'color' => '#000',
        'width' => '1px',
        'style' => 'solid',
    ),
)
```

### Dimensions

```php
'dimensions' => array(
    'minHeight' => '100vh',
    'aspectRatio' => '16/9',
)
```

### Outline

```php
'outline' => array(
    'color'  => 'blue',
    'width'  => '2px',
    'style'  => 'solid',
    'offset' => '2px',
)
```

### Shadow

```php
'shadow' => '0 4px 6px rgba(0,0,0,0.1)'  // box-shadow
```

## CSS Variables

The Style Engine handles CSS custom property patterns:

```php
$styles = wp_style_engine_get_styles( array(
    'color' => array(
        'text' => 'var:preset|color|primary',
    ),
) );

// Converts to: color: var(--wp--preset--color--primary);
```

## Classes

| Class | Description |
|-------|-------------|
| `WP_Style_Engine` | Main engine class |
| `WP_Style_Engine_CSS_Rule` | Single CSS rule |
| `WP_Style_Engine_CSS_Declarations` | CSS declarations collection |
| `WP_Style_Engine_CSS_Rules_Store` | Rule storage by context |
| `WP_Style_Engine_Processor` | Rule processing and compilation |

## Use Cases

### Block Supports

```php
// In a block's render callback
$styles = wp_style_engine_get_styles( $attributes['style'] ?? array() );

$wrapper_attributes = get_block_wrapper_attributes( array(
    'class' => $styles['classnames'] ?? '',
    'style' => $styles['css'] ?? '',
) );
```

### Custom Stylesheet Generation

```php
add_action( 'wp_enqueue_scripts', function() {
    $rules = array(
        array(
            'selector'     => ':root',
            'declarations' => array(
                '--primary-color'   => get_theme_mod( 'primary_color', '#0073aa' ),
                '--secondary-color' => get_theme_mod( 'secondary_color', '#23282d' ),
            ),
        ),
    );
    
    $css = wp_style_engine_get_stylesheet_from_css_rules( $rules );
    wp_add_inline_style( 'theme-style', $css );
} );
```
