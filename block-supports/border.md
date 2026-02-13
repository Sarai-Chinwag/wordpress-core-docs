# border.php — Border Block Support

Registers border-related attributes and generates CSS classes/inline styles for border properties.

**Source:** `wp-includes/block-supports/border.php`  
**Since:** 5.8.0

---

## Support Key

`supports.__experimentalBorder`

Can be set to `true` (all border features) or an object with individual feature flags:

| Feature Key | Description |
|-------------|-------------|
| `color` | Border color |
| `radius` | Border radius |
| `style` | Border style (solid, dashed, etc.) |
| `width` | Border width |

---

## Registered Attributes

| Attribute | Type | Condition |
|-----------|------|-----------|
| `style` | `object` | When `__experimentalBorder` support exists |
| `borderColor` | `string` | When `color` feature is supported |

---

## Functions

### wp_register_border_support()

```php
function wp_register_border_support( WP_Block_Type $block_type )
```

**Since:** 5.8.0  
**Since:** 6.1.0 Improved conditional blocks optimization.  
**Access:** private

---

### wp_apply_border_support()

```php
function wp_apply_border_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.8.0  
**Since:** 6.1.0 Implemented the style engine to generate CSS and classnames.  
**Access:** private

**Processing:**

1. Checks serialization skip for `border`
2. For each feature (radius, style, width, color), checks individual feature support and serialization skip
3. Handles both shorthand and per-side (`top`, `right`, `bottom`, `left`) border values
4. For radius: appends `px` to numeric values
5. For width: appends `px` to numeric values
6. For color: uses `var:preset|color|{slug}` for preset colors, falls back to custom color
7. Delegates to `wp_style_engine_get_styles()` for CSS generation

**Returns:** Array with `class` (classnames) and/or `style` (inline CSS).

---

### wp_has_border_feature_support()

```php
function wp_has_border_feature_support( WP_Block_Type $block_type, string $feature, mixed $default_value = false ): bool
```

**Since:** 5.8.0  
**Access:** private

Returns `true` if:
- `__experimentalBorder` is boolean `true` (all features enabled), OR
- The specific feature flag is set under `__experimentalBorder`

---

## Block Attributes Read

From `$block_attributes['style']['border']`:

| Path | Feature |
|------|---------|
| `radius` | Border radius (string/numeric or object for per-corner) |
| `style` | Border style |
| `width` | Border width |
| `color` | Custom border color |
| `top`, `right`, `bottom`, `left` | Per-side border objects with `width`, `color`, `style` |

From `$block_attributes['borderColor']`: Preset border color slug.

---

## Generated CSS

Via `wp_style_engine_get_styles()`:
- Classnames (e.g. `has-border-color`)
- Inline styles (e.g. `border-radius:5px;border-width:2px;border-color:var(--wp--preset--color--vivid-red)`)

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'border',
    array(
        'register_attribute' => 'wp_register_border_support',
        'apply'              => 'wp_apply_border_support',
    )
);
```
