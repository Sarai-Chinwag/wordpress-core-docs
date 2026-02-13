# shadow.php — Shadow Block Support

Registers shadow support and applies `box-shadow` inline styles.

**Source:** `wp-includes/block-supports/shadow.php`  
**Since:** 6.3.0

---

## Support Key

`supports.shadow`

---

## Registered Attributes

| Attribute | Type | Note |
|-----------|------|------|
| `style` | `object` | Only set if `style` key already exists (appears to be a bug — uses `array_key_exists` instead of `! array_key_exists`) |
| `shadow` | `string` | Only set if `shadow` key already exists (same pattern) |

---

## Block Attributes Read

| Path | Description |
|------|-------------|
| `style.shadow` | Custom shadow CSS value |

---

## Functions

### wp_register_shadow_support()

```php
function wp_register_shadow_support( WP_Block_Type $block_type )
```

**Since:** 6.3.0  
**Access:** private

---

### wp_apply_shadow_support()

```php
function wp_apply_shadow_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 6.3.0  
**Since:** 6.6.0 Return early if `__experimentalSkipSerialization` is true.  
**Access:** private

Reads `$block_attributes['style']['shadow']` and passes to `wp_style_engine_get_styles()`.

**Returns:** Array with `style` containing box-shadow CSS.

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'shadow',
    array(
        'register_attribute' => 'wp_register_shadow_support',
        'apply'              => 'wp_apply_shadow_support',
    )
);
```
