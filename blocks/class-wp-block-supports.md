# WP_Block_Supports

Class encapsulating and implementing Block Supports.

**Since:** 5.6.0  
**Source:** `wp-includes/class-wp-block-supports.php`

## Description

`WP_Block_Supports` is a singleton that registers and applies block support features. Block supports provide common functionality like colors, spacing, typography, and alignment that blocks can opt into via their `supports` configuration.

## Properties

### $block_supports (private)

Registered block support configurations.

```php
private array $block_supports = array()
```

**Since:** 5.6.0

---

### $block_to_render (public static)

Tracks the current block being rendered.

```php
public static array $block_to_render = null
```

**Since:** 5.6.0

Used by support handlers to access current block attributes.

---

### $instance (private static)

Container for the main singleton instance.

```php
private static WP_Block_Supports|null $instance = null
```

**Since:** 5.6.0

---

## Methods

### get_instance()

Retrieves the main singleton instance.

```php
public static function get_instance(): WP_Block_Supports
```

**Returns:** *(WP_Block_Supports)* - The main instance

**Since:** 5.6.0

---

### init()

Initializes block supports and registers attributes.

```php
public static function init(): void
```

**Since:** 5.6.0

Called during WordPress initialization to register support attributes on all block types.

---

### register()

Registers a block support.

```php
public function register( string $block_support_name, array $block_support_config ): void
```

**Parameters:**
- `$block_support_name` *(string)* - Support name
- `$block_support_config` *(array)* - Support configuration with:
  - `register_attribute` *(callable)* - Adds attributes to block types
  - `apply` *(callable)* - Generates HTML attributes during render

**Since:** 5.6.0

**Example:**
```php
WP_Block_Supports::get_instance()->register( 'custom-feature', array(
    'register_attribute' => function( $block_type ) {
        if ( block_has_support( $block_type, 'customFeature' ) ) {
            $block_type->attributes['customValue'] = array(
                'type' => 'string',
            );
        }
    },
    'apply' => function( $block_type, $block_attributes ) {
        if ( ! empty( $block_attributes['customValue'] ) ) {
            return array(
                'class' => 'has-custom-' . $block_attributes['customValue'],
            );
        }
        return array();
    },
) );
```

---

### apply_block_supports()

Generates HTML attributes by applying all block supports.

```php
public function apply_block_supports(): string[]
```

**Returns:** *(string[])* - Array of HTML attribute values keyed by name

**Since:** 5.6.0

Returns attributes for the block in `$block_to_render`.

---

### register_attributes() (private)

Registers attributes for all block supports on all block types.

```php
private function register_attributes(): void
```

**Since:** 5.6.0

---

## get_block_wrapper_attributes()

Global function that generates block wrapper attributes.

```php
function get_block_wrapper_attributes( string[] $extra_attributes = array() ): string
```

**Parameters:**
- `$extra_attributes` *(string[])* - Extra attributes to merge

**Returns:** *(string)* - HTML attribute string

**Since:** 5.6.0

**Merged Attributes:** `style`, `class`, `id`, `aria-label`

**Example:**
```php
function render_my_block( $attributes, $content, $block ) {
    $wrapper_attributes = get_block_wrapper_attributes( array(
        'class' => 'my-extra-class',
        'data-custom' => 'value',
    ) );
    
    return sprintf(
        '<div %s>%s</div>',
        $wrapper_attributes,
        $content
    );
}
// Output: <div class="my-extra-class wp-block-my-block has-text-color" style="color:#000">...</div>
```

---

## Built-in Block Supports

Located in `wp-includes/block-supports/`:

### align.php

Alignment support (`align`).

```json
{ "supports": { "align": ["wide", "full"] } }
```

Adds class: `alignwide`, `alignfull`, `alignleft`, `aligncenter`, `alignright`

---

### background.php

Background image support.

```json
{ "supports": { "background": { "backgroundImage": true, "backgroundSize": true } } }
```

---

### border.php

Border support (`border`).

```json
{
  "supports": {
    "border": {
      "color": true,
      "radius": true,
      "style": true,
      "width": true
    }
  }
}
```

Generates inline styles for border properties.

---

### colors.php

Color support (`color`).

```json
{
  "supports": {
    "color": {
      "background": true,
      "text": true,
      "link": true,
      "gradient": true
    }
  }
}
```

Adds classes: `has-text-color`, `has-{slug}-color`, `has-background`, `has-{slug}-background-color`

---

### custom-classname.php

Custom CSS class support.

```json
{ "supports": { "className": true } }
```

Default: `true`. Allows users to add custom class names.

---

### dimensions.php

Dimensions support (`dimensions`).

```json
{
  "supports": {
    "dimensions": {
      "minHeight": true
    }
  }
}
```

---

### duotone.php

Duotone filter support.

```json
{ "supports": { "filter": { "duotone": true } } }
```

---

### elements.php

Element styling (links, headings, buttons).

```json
{
  "supports": {
    "color": {
      "link": true,
      "heading": true,
      "button": true
    }
  }
}
```

---

### generated-classname.php

Auto-generated block class name.

Adds: `wp-block-{namespace}-{name}` (e.g., `wp-block-my-plugin-notice`)

---

### layout.php

Layout support (`layout`).

```json
{
  "supports": {
    "layout": {
      "default": { "type": "constrained" },
      "allowSwitching": true,
      "allowEditing": true
    }
  }
}
```

Layout types: `default`, `constrained`, `flex`, `grid`

---

### position.php

Position support (`position`).

```json
{ "supports": { "position": { "sticky": true } } }
```

---

### shadow.php

Shadow support (`shadow`).

```json
{ "supports": { "shadow": true } }
```

---

### spacing.php

Spacing support (`spacing`).

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

Generates inline styles for margin/padding.

---

### typography.php

Typography support (`typography`).

```json
{
  "supports": {
    "typography": {
      "fontSize": true,
      "lineHeight": true,
      "fontFamily": true,
      "fontWeight": true,
      "fontStyle": true,
      "textTransform": true,
      "textDecoration": true,
      "letterSpacing": true
    }
  }
}
```

Adds classes: `has-{slug}-font-size`, `has-{slug}-font-family`  
Adds inline styles for custom values.

---

## Usage Example

### Block with Multiple Supports

```json
{
  "name": "my-plugin/card",
  "supports": {
    "align": ["wide", "full"],
    "color": {
      "background": true,
      "text": true
    },
    "spacing": {
      "padding": true,
      "margin": ["top", "bottom"]
    },
    "typography": {
      "fontSize": true
    },
    "border": {
      "radius": true
    }
  }
}
```

### Render Callback Using Supports

```php
function render_card_block( $attributes, $content, $block ) {
    // get_block_wrapper_attributes() automatically includes
    // all classes and styles from enabled supports
    $wrapper_attributes = get_block_wrapper_attributes();
    
    return sprintf(
        '<div %s><div class="card-content">%s</div></div>',
        $wrapper_attributes,
        $content
    );
}
```

Output might include:
```html
<div class="wp-block-my-plugin-card alignwide has-text-color has-primary-color has-background has-white-background-color has-medium-font-size" style="padding:20px;border-radius:8px">
    <div class="card-content">...</div>
</div>
```

### Checking Support Availability

```php
$block_type = WP_Block_Type_Registry::get_instance()->get_registered( 'core/paragraph' );

if ( block_has_support( $block_type, 'color' ) ) {
    // Block supports color
}

if ( block_has_support( $block_type, array( 'typography', 'fontSize' ) ) ) {
    // Block supports fontSize
}
```
