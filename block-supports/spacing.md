# spacing.php — Spacing Block Support

Handles padding and margin styles for blocks.

**Source:** `wp-includes/block-supports/spacing.php`  
**Since:** 5.8.0

Note: This remains separate from `dimensions.php` for backwards compatibility, even though both appear under the "Dimensions" panel in the editor.

---

## Support Key

`supports.spacing`

| Feature Key | Description |
|-------------|-------------|
| `padding` | Block padding |
| `margin` | Block margin |
| `blockGap` | Block gap (handled by layout.php, not here) |

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `style` | `object` |

---

## Block Attributes Read

| Path | Property |
|------|----------|
| `style.spacing.padding` | Padding values (string or object with `top`/`right`/`bottom`/`left`) |
| `style.spacing.margin` | Margin values (string or object with `top`/`right`/`bottom`/`left`) |

---

## Functions

### wp_register_spacing_support()

```php
function wp_register_spacing_support( WP_Block_Type $block_type )
```

**Since:** 5.8.0  
**Access:** private

---

### wp_apply_spacing_support()

```php
function wp_apply_spacing_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.8.0  
**Since:** 6.1.0 Implemented the style engine to generate CSS and classnames.  
**Access:** private

**Processing:**

1. Checks top-level serialization skip for `spacing`
2. Checks individual support for `spacing.padding` and `spacing.margin`
3. Checks individual serialization skip for each
4. Delegates to `wp_style_engine_get_styles()`

**Returns:** Array with `style` containing padding/margin CSS.

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'spacing',
    array(
        'register_attribute' => 'wp_register_spacing_support',
        'apply'              => 'wp_apply_spacing_support',
    )
);
```
