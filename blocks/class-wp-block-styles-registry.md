# WP_Block_Styles_Registry

Class used for interacting with block styles.

**Since:** 5.3.0  
**Source:** `wp-includes/class-wp-block-styles-registry.php`

## Description

`WP_Block_Styles_Registry` is a singleton that manages alternative visual styles for block types. Block styles provide different appearance options that users can select in the editor.

## Properties

### $registered_block_styles (private)

Registered block styles as nested arrays.

```php
private array[] $registered_block_styles = array()
```

Structure: `$block_name => $block_style_name => $block_style_properties`

**Since:** 5.3.0

---

### $instance (private static)

Container for the main singleton instance.

```php
private static WP_Block_Styles_Registry|null $instance = null
```

**Since:** 5.3.0

---

## Methods

### get_instance()

Retrieves the main singleton instance.

```php
public static function get_instance(): WP_Block_Styles_Registry
```

**Returns:** *(WP_Block_Styles_Registry)* - The main instance

**Since:** 5.3.0

---

### register()

Registers a block style for the given block type.

```php
public function register(
    string|string[] $block_name,
    array $style_properties
): bool
```

**Parameters:**
- `$block_name` *(string|string[])* - Block type name(s) including namespace
- `$style_properties` *(array)* - Style properties:
  - `name` *(string)* - Required. Style identifier (no spaces)
  - `label` *(string)* - Human-readable label
  - `inline_style` *(string)* - Inline CSS code
  - `style_handle` *(string)* - Handle of registered stylesheet
  - `is_default` *(bool)* - Whether this is the default style
  - `style_data` *(array)* - theme.json-like data for CSS generation (since 6.6.0)

**Returns:** *(bool)* - True on success

**Since:** 5.3.0  
**Since:** 6.6.0 - Added multiple block types and `style_data` support

**Example:**
```php
// Register with inline CSS
WP_Block_Styles_Registry::get_instance()->register(
    'core/quote',
    array(
        'name'         => 'fancy',
        'label'        => 'Fancy Quote',
        'inline_style' => '.is-style-fancy { border-left: 4px solid gold; font-style: italic; }',
    )
);

// Register with external stylesheet
WP_Block_Styles_Registry::get_instance()->register(
    'core/button',
    array(
        'name'         => 'gradient',
        'label'        => 'Gradient',
        'style_handle' => 'my-button-gradient-style',
    )
);

// Register for multiple blocks
WP_Block_Styles_Registry::get_instance()->register(
    array( 'core/paragraph', 'core/heading', 'core/list' ),
    array(
        'name'  => 'highlighted',
        'label' => 'Highlighted',
        'inline_style' => '.is-style-highlighted { background: yellow; }',
    )
);
```

---

### unregister()

Unregisters a block style.

```php
public function unregister( string $block_name, string $block_style_name ): bool
```

**Parameters:**
- `$block_name` *(string)* - Block type name
- `$block_style_name` *(string)* - Style name to unregister

**Returns:** *(bool)* - True on success

**Since:** 5.3.0

**Example:**
```php
// Remove the outline button style
WP_Block_Styles_Registry::get_instance()->unregister( 'core/button', 'outline' );
```

---

### get_registered()

Retrieves a registered block style's properties.

```php
public function get_registered(
    string $block_name,
    string $block_style_name
): array|null
```

**Parameters:**
- `$block_name` *(string)* - Block type name
- `$block_style_name` *(string)* - Style name

**Returns:** *(array|null)* - Style properties or null if not registered

**Since:** 5.3.0

**Example:**
```php
$registry = WP_Block_Styles_Registry::get_instance();

$fancy = $registry->get_registered( 'core/quote', 'fancy' );
if ( $fancy ) {
    echo $fancy['label']; // "Fancy Quote"
    echo $fancy['inline_style'];
}
```

---

### get_all_registered()

Retrieves all registered block styles.

```php
public function get_all_registered(): array[]
```

**Returns:** *(array[])* - Styles grouped by block type

**Since:** 5.3.0

**Example:**
```php
$all_styles = WP_Block_Styles_Registry::get_instance()->get_all_registered();

// Structure:
// array(
//     'core/quote' => array(
//         'fancy' => array( 'name' => 'fancy', 'label' => 'Fancy Quote', ... ),
//         'plain' => array( 'name' => 'plain', 'label' => 'Plain', ... ),
//     ),
//     'core/button' => array( ... ),
// )
```

---

### get_registered_styles_for_block()

Retrieves all registered styles for a specific block type.

```php
public function get_registered_styles_for_block( string $block_name ): array[]
```

**Parameters:**
- `$block_name` *(string)* - Block type name

**Returns:** *(array[])* - Array of style properties keyed by style name

**Since:** 5.3.0

**Example:**
```php
$registry = WP_Block_Styles_Registry::get_instance();

$button_styles = $registry->get_registered_styles_for_block( 'core/button' );

foreach ( $button_styles as $style_name => $style_props ) {
    echo $style_name . ': ' . $style_props['label'] . "\n";
}
// fill: Fill
// outline: Outline
```

---

### is_registered()

Checks if a block style is registered.

```php
public function is_registered(
    string|null $block_name,
    string|null $block_style_name
): bool
```

**Parameters:**
- `$block_name` *(string|null)* - Block type name
- `$block_style_name` *(string|null)* - Style name

**Returns:** *(bool)* - True if registered

**Since:** 5.3.0

**Example:**
```php
$registry = WP_Block_Styles_Registry::get_instance();

if ( $registry->is_registered( 'core/image', 'rounded' ) ) {
    // Rounded style exists for images
}
```

---

## Wrapper Function

### register_block_style()

Global function that wraps the registry's register method.

```php
function register_block_style(
    string|string[] $block_name,
    array $style_properties
): bool
```

**Since:** 5.3.0

**Example:**
```php
// Preferred way to register styles
register_block_style( 'core/paragraph', array(
    'name'         => 'drop-cap-large',
    'label'        => 'Large Drop Cap',
    'inline_style' => '.is-style-drop-cap-large:first-letter { font-size: 4em; }',
) );
```

### unregister_block_style()

Global function to unregister a style.

```php
function unregister_block_style( string $block_name, string $block_style_name ): bool
```

**Since:** 5.3.0

---

## How Block Styles Work

### In the Editor

When a block style is selected:
1. The block receives `className` attribute with `is-style-{name}`
2. Style CSS is loaded via inline or enqueued stylesheet

### CSS Class Convention

Block styles add the class `is-style-{style-name}` to the block wrapper.

```html
<!-- Quote with "fancy" style selected -->
<blockquote class="wp-block-quote is-style-fancy">
    <p>Quote text</p>
</blockquote>
```

---

## Usage Examples

### Complete Style Registration

```php
add_action( 'init', function() {
    // Style with external stylesheet
    wp_register_style(
        'my-custom-image-styles',
        plugins_url( 'css/image-styles.css', __FILE__ )
    );
    
    register_block_style( 'core/image', array(
        'name'         => 'polaroid',
        'label'        => __( 'Polaroid', 'my-plugin' ),
        'style_handle' => 'my-custom-image-styles',
    ) );
    
    // Style with inline CSS
    register_block_style( 'core/separator', array(
        'name'         => 'fancy-dots',
        'label'        => __( 'Fancy Dots', 'my-plugin' ),
        'inline_style' => '
            .is-style-fancy-dots {
                border: none;
                text-align: center;
            }
            .is-style-fancy-dots::before {
                content: "• • •";
                font-size: 1.5em;
                letter-spacing: 0.5em;
            }
        ',
    ) );
} );
```

### Default Style

```php
register_block_style( 'core/list', array(
    'name'       => 'checkmark',
    'label'      => __( 'Checkmark', 'my-plugin' ),
    'is_default' => true, // Selected by default in editor
    'inline_style' => '
        .is-style-checkmark li {
            list-style-type: none;
        }
        .is-style-checkmark li::before {
            content: "✓";
            margin-right: 0.5em;
            color: green;
        }
    ',
) );
```

### Theme.json Style Data (Since 6.6.0)

```php
register_block_style( 'core/group', array(
    'name'       => 'card',
    'label'      => 'Card',
    'style_data' => array(
        'border' => array(
            'radius' => '8px',
        ),
        'shadow' => 'var(--wp--preset--shadow--natural)',
        'spacing' => array(
            'padding' => '20px',
        ),
    ),
) );
```

### Remove Core Styles

```php
add_action( 'init', function() {
    // Remove the outline button style
    unregister_block_style( 'core/button', 'outline' );
    
    // Remove all quote styles
    $registry = WP_Block_Styles_Registry::get_instance();
    $quote_styles = $registry->get_registered_styles_for_block( 'core/quote' );
    foreach ( array_keys( $quote_styles ) as $style_name ) {
        unregister_block_style( 'core/quote', $style_name );
    }
} );
```

### List All Registered Styles

```php
add_action( 'admin_init', function() {
    $registry = WP_Block_Styles_Registry::get_instance();
    
    foreach ( $registry->get_all_registered() as $block_name => $styles ) {
        echo "$block_name:\n";
        foreach ( $styles as $style_name => $props ) {
            echo "  - $style_name ({$props['label']})\n";
        }
    }
} );
```
