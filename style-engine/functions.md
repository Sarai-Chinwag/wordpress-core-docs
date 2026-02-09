# Style Engine Functions

Public API functions for generating and compiling CSS styles.

**Source:** `wp-includes/style-engine.php`

---

## wp_style_engine_get_styles()

Generates styles from a block style object (e.g., block attributes or theme.json styles).

```php
wp_style_engine_get_styles( array $block_styles, array $options = array() ): array
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$block_styles` | array | The style object |
| `$options` | array | Optional configuration |

### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `selector` | string\|null | `null` | CSS selector; when provided, returns full CSS rule |
| `context` | string\|null | `null` | Store name for CSS caching (e.g., `block-supports`, `global-styles`) |
| `convert_vars_to_classnames` | bool | `false` | When `true`, skips converting `var:preset\|*` to CSS vars |

### Returns

| Key | Type | Description |
|-----|------|-------------|
| `css` | string | CSS declarations or full rule (if selector provided) |
| `declarations` | array | Associative array of CSS property => value pairs |
| `classnames` | string | Space-separated class names |

### Example

```php
$styles = wp_style_engine_get_styles(
    array(
        'color' => array( 'text' => '#cccccc' ),
    )
);
// Returns:
// array(
//     'css'          => 'color: #cccccc',
//     'declarations' => array( 'color' => '#cccccc' ),
//     'classnames'   => 'has-text-color',
// )
```

### With Selector

```php
$styles = wp_style_engine_get_styles(
    array(
        'spacing' => array(
            'padding' => array(
                'top'    => '1em',
                'bottom' => '1em',
            ),
        ),
    ),
    array(
        'selector' => '.my-block',
    )
);
// Returns:
// array(
//     'css'          => '.my-block{padding-top:1em;padding-bottom:1em}',
//     'declarations' => array(
//         'padding-top'    => '1em',
//         'padding-bottom' => '1em',
//     ),
// )
```

### With Preset Variables

```php
$styles = wp_style_engine_get_styles(
    array(
        'color' => array(
            'background' => 'var:preset|color|vivid-red',
        ),
    )
);
// Returns:
// array(
//     'css'          => 'background-color: var(--wp--preset--color--vivid-red)',
//     'declarations' => array( 'background-color' => 'var(--wp--preset--color--vivid-red)' ),
//     'classnames'   => 'has-background has-vivid-red-background-color',
// )
```

---

## wp_style_engine_get_stylesheet_from_css_rules()

Compiles CSS from an array of selector/declaration pairs.

```php
wp_style_engine_get_stylesheet_from_css_rules( array $css_rules, array $options = array() ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_rules` | array | Collection of CSS rules |
| `$options` | array | Optional configuration |

### CSS Rules Format

```php
array(
    array(
        'selector'     => '.my-selector',
        'declarations' => array( 'color' => 'red' ),
        'rules_group'  => '@media (min-width: 80rem)', // Optional, since 6.6.0
    ),
)
```

### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `context` | string\|null | `null` | Store name for CSS caching |
| `optimize` | bool | `false` | Combine rules with identical declarations |
| `prettify` | bool | `SCRIPT_DEBUG` | Add newlines and indentation |

### Returns

Compiled CSS string.

### Example

```php
$css_rules = array(
    array(
        'selector'     => '.elephant-are-cool',
        'declarations' => array(
            'color' => 'gray',
            'width' => '3em',
        ),
    ),
);

$css = wp_style_engine_get_stylesheet_from_css_rules( $css_rules );
// Returns: '.elephant-are-cool{color:gray;width:3em}'
```

### With Rules Group (Since 6.6.0)

```php
$css_rules = array(
    array(
        'rules_group'  => '@media (min-width: 80rem)',
        'selector'     => '.responsive-block',
        'declarations' => array( 'font-size' => '2rem' ),
    ),
);

$css = wp_style_engine_get_stylesheet_from_css_rules( $css_rules );
// Returns: '@media (min-width: 80rem){.responsive-block{font-size:2rem}}'
```

---

## wp_style_engine_get_stylesheet_from_context()

Retrieves compiled CSS from a named store.

```php
wp_style_engine_get_stylesheet_from_context( string $context, array $options = array() ): string
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$context` | string | Store name (e.g., `block-supports`) |
| `$options` | array | Optional configuration |

### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `optimize` | bool | `false` | Combine rules with identical declarations |
| `prettify` | bool | `SCRIPT_DEBUG` | Add newlines and indentation |

### Returns

Compiled CSS string from all rules in the store.

### Example

```php
// First, store styles during block rendering
wp_style_engine_get_styles(
    array( 'color' => array( 'text' => 'red' ) ),
    array(
        'context'  => 'my-context',
        'selector' => '.block-a',
    )
);

wp_style_engine_get_styles(
    array( 'color' => array( 'text' => 'blue' ) ),
    array(
        'context'  => 'my-context',
        'selector' => '.block-b',
    )
);

// Later, retrieve all styles
$css = wp_style_engine_get_stylesheet_from_context( 'my-context' );
// Returns: '.block-a{color:red}.block-b{color:blue}'
```
