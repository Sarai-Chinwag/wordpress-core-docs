# custom-classname.php — Custom Class Name Block Support

Allows users to add custom CSS class names to blocks.

**Source:** `wp-includes/block-supports/custom-classname.php`  
**Since:** 5.6.0

---

## Support Key

`supports.customClassName` — defaults to `true`.

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `className` | `string` |

---

## Functions

### wp_register_custom_classname_support()

```php
function wp_register_custom_classname_support( WP_Block_Type $block_type )
```

**Since:** 5.6.0  
**Access:** private

Checks `block_has_support( $block_type, 'customClassName', true )`. Default is `true`, so most blocks get this attribute unless they explicitly opt out.

---

### wp_apply_custom_classname_support()

```php
function wp_apply_custom_classname_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.6.0  
**Access:** private

**Returns:** Array with `class` set to the value of the `className` attribute, if present.

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'custom-classname',
    array(
        'register_attribute' => 'wp_register_custom_classname_support',
        'apply'              => 'wp_apply_custom_classname_support',
    )
);
```
