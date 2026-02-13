# colors.php — Color Block Support

Registers color-related attributes and generates CSS classes/inline styles for text, background, and gradient colors.

**Source:** `wp-includes/block-supports/colors.php`  
**Since:** 5.6.0

---

## Support Key

`supports.color`

Can be `true` (all color features) or an object:

| Feature Key | Default | Description |
|-------------|---------|-------------|
| `text` | `true` (when `color` is array) | Text color |
| `background` | `true` (when `color` is array) | Background color |
| `gradients` | `false` | Gradient background |
| `link` | `false` | Link color (handled by elements.php) |
| `button` | `false` | Button color (handled by elements.php) |
| `heading` | `false` | Heading color (handled by elements.php) |

Note: `text` and `background` default to `true` when `color` support is an array and the key is not explicitly set.

---

## Registered Attributes

| Attribute | Type | Condition |
|-----------|------|-----------|
| `style` | `object` | When any color support exists |
| `backgroundColor` | `string` | When background color supported |
| `textColor` | `string` | When text color supported |
| `gradient` | `string` | When gradients supported |

---

## Functions

### wp_register_colors_support()

```php
function wp_register_colors_support( WP_Block_Type $block_type )
```

**Since:** 5.6.0  
**Since:** 6.1.0 Improved `$color_support` assignment optimization.  
**Access:** private

---

### wp_apply_colors_support()

```php
function wp_apply_colors_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.6.0  
**Since:** 6.1.0 Implemented the style engine to generate CSS and classnames.  
**Access:** private

**Processing:**

1. Checks top-level serialization skip for `color`
2. For text: uses `var:preset|color|{slug}` for preset, custom from `style.color.text`
3. For background: uses `var:preset|color|{slug}` for preset, custom from `style.color.background`
4. For gradient: uses `var:preset|gradient|{slug}` for preset, custom from `style.color.gradient`
5. Each feature checks individual serialization skip
6. Delegates to `wp_style_engine_get_styles()` with `convert_vars_to_classnames => true`

**Returns:** Array with `class` and/or `style`.

---

## Generated CSS

Via `wp_style_engine_get_styles()` with `convert_vars_to_classnames`:

**Classes** (examples):
- `has-text-color`, `has-{slug}-color`
- `has-background`, `has-{slug}-background-color`
- `has-{slug}-gradient-background`

**Inline styles** (for custom values):
- `color: #ff0000`
- `background-color: #00ff00`
- `background: linear-gradient(...)`

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'colors',
    array(
        'register_attribute' => 'wp_register_colors_support',
        'apply'              => 'wp_apply_colors_support',
    )
);
```
