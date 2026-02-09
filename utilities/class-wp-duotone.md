# WP_Duotone

Manages duotone block supports and global styles.

**Source:** `wp-includes/class-wp-duotone.php`  
**Since:** 6.3.0  
**Access:** Private/Internal

## Overview

Duotone applies a two-color gradient effect to images using SVG filters. `WP_Duotone` handles:

1. Color parsing (hex, RGB, HSL)
2. SVG filter generation
3. CSS custom properties for presets
4. Block attribute processing

---

## Static Properties

| Property | Type | Description |
|----------|------|-------------|
| `$global_styles_block_names` | array | Block names using duotone presets |
| `$global_styles_presets` | array | All duotone presets from theme.json |
| `$used_global_styles_presets` | array | Presets used on current page |
| `$used_svg_filter_data` | array | SVG filter data for current page |
| `$block_css_declarations` | array | CSS declarations for block styles |

---

## Public Methods

### register_duotone_support()

Registers duotone block attributes.

```php
public static function register_duotone_support( WP_Block_Type $block_type )
```

Called during block type registration. Adds `style` attribute if block has `filter.duotone` support.

---

### render_duotone_support()

Renders duotone CSS and SVG for a block.

```php
public static function render_duotone_support( 
    string $block_content, 
    array $block, 
    WP_Block $wp_block 
): string
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$block_content` | string | Rendered block HTML |
| `$block` | array | Block data |
| `$wp_block` | WP_Block | Block instance |

**Returns:** Modified block content with duotone class.

**Processing Flow:**

1. Check block has duotone selector
2. Check for duotone attribute or global styles
3. Determine if preset, CSS string, or custom colors
4. Enqueue appropriate CSS/SVG
5. Add filter class to block wrapper

**Duotone Attribute Formats:**

```php
// Preset reference
'var:preset|duotone|blue-orange'
'var(--wp--preset--duotone--blue-orange)'

// Custom colors
array( '#000000', '#ffffff' )

// CSS value (e.g., to reset)
'unset'
```

---

### restore_image_outer_container()

Fixes duotone class placement in classic themes.

```php
public static function restore_image_outer_container( string $block_content ): string
```

Moves duotone class from inner element to wrapper div for `wp-block-image`.

---

### output_block_styles()

Outputs block CSS declarations.

```php
public static function output_block_styles()
```

Appends duotone filter declarations to inline block supports CSS.

---

### output_global_styles()

Outputs CSS custom properties for presets.

```php
public static function output_global_styles()
```

Adds duotone preset variables to global styles.

---

### output_footer_assets()

Outputs SVG definitions and CSS for classic themes.

```php
public static function output_footer_assets()
```

Renders:
- SVG filter definitions
- CSS custom properties (classic themes only)
- Block CSS declarations (classic themes only)

---

### add_editor_settings()

Adds duotone SVGs and CSS to block editor.

```php
public static function add_editor_settings( array $settings ): array
```

Injects duotone assets for editor preview rendering.

---

### migrate_experimental_duotone_support_flag()

Migrates legacy `color.__experimentalDuotone` to `filter.duotone`.

```php
public static function migrate_experimental_duotone_support_flag( 
    array $settings, 
    array $metadata 
): array
```

---

## Color Parsing (Private)

Ported from [colord](https://github.com/omgovich/colord) library.

### Supported Formats

| Format | Example |
|--------|---------|
| Hex3 | `#fff` |
| Hex4 | `#ffff` |
| Hex6 | `#ffffff` |
| Hex8 | `#ffffffff` |
| RGB | `rgb(255, 255, 255)` |
| RGBA | `rgba(255, 255, 255, 0.5)` |
| HSL | `hsl(0, 0%, 100%)` |
| HSLA | `hsla(0, 0%, 100%, 0.5)` |

### Internal Methods

| Method | Description |
|--------|-------------|
| `colord_parse()` | Parse any color string to RGBA |
| `colord_parse_hex()` | Parse hex colors |
| `colord_parse_rgba_string()` | Parse RGB/RGBA strings |
| `colord_parse_hsla_string()` | Parse HSL/HSLA strings |
| `colord_hsla_to_rgba()` | Convert HSLA to RGBA |
| `colord_clamp()` | Clamp value between min/max |
| `colord_clamp_hue()` | Normalize hue to 0-360 |

---

## SVG Filter Generation

### get_filter_svg()

Generates the SVG filter definition.

```php
private static function get_filter_svg( string $filter_id, array $colors ): string
```

**SVG Structure:**

```xml
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 0 0" 
     width="0" height="0" style="visibility: hidden; ...">
    <defs>
        <filter id="wp-duotone-blue-orange">
            <!-- Convert to grayscale -->
            <feColorMatrix type="matrix" values="
                .299 .587 .114 0 0
                .299 .587 .114 0 0
                .299 .587 .114 0 0
                .299 .587 .114 0 0
            "/>
            <!-- Map grayscale to duotone colors -->
            <feComponentTransfer>
                <feFuncR type="table" tableValues="0 1"/>
                <feFuncG type="table" tableValues="0 0.8"/>
                <feFuncB type="table" tableValues="1 0.5"/>
                <feFuncA type="table" tableValues="1 1"/>
            </feComponentTransfer>
            <feComposite in2="SourceGraphic" operator="in"/>
        </filter>
    </defs>
</svg>
```

---

## CSS Output

### CSS Custom Properties

```css
:root {
    --wp--preset--duotone--blue-orange: url('#wp-duotone-blue-orange');
}
```

### Block CSS

```css
.wp-duotone-blue-orange.wp-block-image img {
    filter: var(--wp--preset--duotone--blue-orange);
}
```

---

## theme.json Integration

### Defining Presets

```json
{
    "settings": {
        "color": {
            "duotone": [
                {
                    "slug": "blue-orange",
                    "colors": ["#0000ff", "#ffcc00"],
                    "name": "Blue and Orange"
                }
            ]
        }
    }
}
```

### Applying to Blocks

```json
{
    "styles": {
        "blocks": {
            "core/image": {
                "filter": {
                    "duotone": "var:preset|duotone|blue-orange"
                }
            }
        }
    }
}
```

---

## Block Support

Add duotone support to custom blocks:

```json
{
    "supports": {
        "filter": {
            "duotone": true
        }
    }
}
```

Or with custom selector:

```json
{
    "supports": {
        "filter": {
            "duotone": ".my-block img"
        }
    }
}
```

Legacy support (`color.__experimentalDuotone`) is automatically migrated.
