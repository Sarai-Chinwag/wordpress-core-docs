# typography.php — Typography Block Support

The second-largest block support file. Handles font size (including fluid/responsive), font family, font style/weight, line height, text alignment, text columns, text decoration, text transform, letter spacing, writing mode, and fit text.

**Source:** `wp-includes/block-supports/typography.php`  
**Since:** 5.6.0

---

## Support Key

`supports.typography`

| Feature Key | Stable? | Description |
|-------------|---------|-------------|
| `fontSize` | Yes | Font size (preset or custom) |
| `lineHeight` | Yes | Line height |
| `textAlign` | Yes | Text alignment |
| `textColumns` | Yes | CSS columns (since 6.3.0) |
| `__experimentalFontFamily` | Experimental | Font family |
| `__experimentalFontStyle` | Experimental | Font style (italic, etc.) |
| `__experimentalFontWeight` | Experimental | Font weight |
| `__experimentalLetterSpacing` | Experimental | Letter spacing |
| `__experimentalTextDecoration` | Experimental | Text decoration |
| `__experimentalTextTransform` | Experimental | Text transform |
| `__experimentalWritingMode` | Experimental | Writing mode |

---

## Registered Attributes

| Attribute | Type | Condition |
|-----------|------|-----------|
| `style` | `object` | When any typography support exists |
| `fontSize` | `string` | When fontSize supported |
| `fontFamily` | `string` | When fontFamily supported |

---

## Functions

### wp_register_typography_support()

```php
function wp_register_typography_support( WP_Block_Type $block_type )
```

**Since:** 5.6.0  
**Since:** 6.3.0 Added support for text-columns.  
**Access:** private

---

### wp_apply_typography_support()

```php
function wp_apply_typography_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.6.0  
**Since:** 6.1.0 Used the style engine to generate CSS and classnames.  
**Since:** 6.3.0 Added support for text-columns.  
**Access:** private

For each typography feature:
1. Checks feature support flag
2. Checks serialization skip
3. Reads preset or custom value
4. For `fontSize`: preset → `var:preset|font-size|{slug}`, custom → processed through `wp_get_typography_font_size_value()` for fluid sizing
5. For `fontFamily`: preset → `var:preset|font-family|{slug}`, custom → through `wp_typography_get_preset_inline_style_value()`
6. For `textAlign`: adds `has-text-align-{value}` class in addition to inline style

Delegates to `wp_style_engine_get_styles()` with `convert_vars_to_classnames => true`.

**Returns:** Array with `class` and/or `style`.

---

### wp_typography_get_preset_inline_style_value()

```php
function wp_typography_get_preset_inline_style_value( string $style_value, string $css_property ): string
```

**Since:** 6.1.0

Backwards-compatibility function for blocks with preset typography values (removed in gutenberg#27555). Converts `var:preset|{property}|{slug}` to `var(--wp--preset--{property}--{slug})`.

---

### wp_render_typography_support()

```php
function wp_render_typography_support( string $block_content, array $block ): string
```

**Since:** 6.1.0

**Processing:**

1. **Fit Text** (since the code checks `$block['attrs']['fitText']`):
   - If `fitText` is truthy and not admin: enqueues `@wordpress/block-editor/utils/fit-text-frontend` script module
   - Adds Interactivity API directives: `data-wp-interactive`, `data-wp-context---core-fit-text`, `data-wp-init---core-fit-text`, `data-wp-style--font-size`
   - Returns early — fitText supersedes other typography features

2. **Fluid Font Size**:
   - If `style.typography.fontSize` is set, processes through `wp_get_typography_font_size_value()`
   - If fluid size differs from custom size, replaces first `font-size:{custom}` occurrence in markup with `font-size:{fluid}`

---

### wp_get_typography_value_and_unit()

```php
function wp_get_typography_value_and_unit( string|int|float $raw_value, array $options = array() ): ?array
```

**Since:** 6.1.0

Parses a size value into `value` and `unit` components. Supports `px`, `rem`, `em`. Can coerce between units using a configurable `root_size_value` (default 16).

**Options:**
| Key | Default | Description |
|-----|---------|-------------|
| `coerce_to` | `''` | Target unit for conversion |
| `root_size_value` | `16` | Root font size for rem/em ↔ px |
| `acceptable_units` | `['rem', 'px', 'em']` | Allowed units |

---

### wp_get_computed_fluid_typography_value()

```php
function wp_get_computed_fluid_typography_value( array $args = array() ): ?string
```

**Since:** 6.1.0  
**Since:** 6.3.0 Checks for unsupported min/max viewport values.  
**Since:** 6.5.0 Returns early on zero viewport subtraction to avoid division by zero.  
**Access:** private

Computes a `clamp()` CSS value for fluid typography:

```
clamp({min_font_size}, {min_font_size_rem} + ((1vw - {viewport_offset}) * {scale_factor}), {max_font_size})
```

**Args:**
| Key | Description |
|-----|-------------|
| `maximum_viewport_width` | Upper viewport bound |
| `minimum_viewport_width` | Lower viewport bound |
| `maximum_font_size` | Max font size |
| `minimum_font_size` | Min font size |
| `scale_factor` | How fast font scales |

---

### wp_get_typography_font_size_value()

```php
function wp_get_typography_font_size_value( array $preset, bool|array $settings = array() ): ?string
```

**Since:** 6.1.0  
**Since:** 6.1.1 Adjusted rules for min and max font sizes.  
**Since:** 6.2.0 Added `settings.typography.fluid.minFontSize` support.  
**Since:** 6.3.0 Using `layout.wideSize` as max viewport width; logarithmic scale factor for minimum font scale.  
**Since:** 6.4.0 Added configurable min/max viewport width to `typography.fluid` schema.  
**Since:** 6.6.0 Deprecated bool argument `$should_use_fluid_typography`.  
**Since:** 6.7.0 Font size presets can enable fluid individually even if disabled globally.

**Processing:**

1. Returns `null` if no `size` in preset
2. Returns early if `$preset['fluid']` is `false` or size is empty
3. If `$settings` is bool, triggers deprecation notice (since 6.6.0)
4. Falls back to global settings via `wp_get_global_settings()`
5. Returns early if fluid is disabled globally AND no local fluid settings

**Fluid calculation defaults:**
| Default | Value |
|---------|-------|
| Maximum viewport width | `1600px` (or `layout.wideSize` if valid, or `fluid.maxViewportWidth`) |
| Minimum viewport width | `320px` (or `fluid.minViewportWidth`) |
| Min font size factor max | `0.75` |
| Min font size factor min | `0.25` |
| Scale factor | `1` |
| Minimum font size limit | `14px` (or `fluid.minFontSize`) |

**Minimum font size calculation:** Uses logarithmic formula:
```
factor = min(max(1 - 0.075 * log2(preferred_px), 0.25), 0.75)
minimum = preferred_size * factor
```

---

## Generated CSS Classes

| Class | Condition |
|-------|-----------|
| `has-{slug}-font-size` | Preset font size |
| `has-{slug}-font-family` | Preset font family |
| `has-text-align-{value}` | Text alignment |

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | (via typography registration) | `wp_render_typography_support` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'typography',
    array(
        'register_attribute' => 'wp_register_typography_support',
        'apply'              => 'wp_apply_typography_support',
    )
);
```

Note: `wp_render_typography_support` is added as a `render_block` filter within the file (registered at the end alongside the block support).
