# aria-label.php — ARIA Label Block Support

Registers the `ariaLabel` block attribute and applies the `aria-label` HTML attribute.

**Source:** `wp-includes/block-supports/aria-label.php`  
**Since:** 6.8.0

---

## Support Key

`supports.ariaLabel`

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `ariaLabel` | `string` |

---

## Functions

### wp_register_aria_label_support()

```php
function wp_register_aria_label_support( WP_Block_Type $block_type )
```

**Since:** 6.8.0  
**Access:** private

Checks `block_has_support( $block_type, array( 'ariaLabel' ), false )`. If supported, adds the `ariaLabel` attribute.

---

### wp_apply_aria_label_support()

```php
function wp_apply_aria_label_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 6.8.0  
**Access:** private

**Returns:** Array with `aria-label` key if the attribute is set. Returns empty array if block attributes are falsy, support is missing, or the attribute is absent.

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'aria-label',
    array(
        'register_attribute' => 'wp_register_aria_label_support',
        'apply'              => 'wp_apply_aria_label_support',
    )
);
```
