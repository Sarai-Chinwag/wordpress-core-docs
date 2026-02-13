# align.php — Alignment Block Support

Registers the `align` block attribute and applies alignment CSS classes.

**Source:** `wp-includes/block-supports/align.php`  
**Since:** 5.6.0

---

## Support Key

`supports.align`

When a block declares `"align": true` (or an array of allowed values) in its `supports`, this file registers the `align` attribute and generates the corresponding CSS class.

---

## Registered Attribute

| Attribute | Type | Enum Values |
|-----------|------|-------------|
| `align` | `string` | `left`, `center`, `right`, `wide`, `full`, `""` |

---

## Functions

### wp_register_alignment_support()

Registers the `align` block attribute for block types that support it.

```php
function wp_register_alignment_support( WP_Block_Type $block_type )
```

**Since:** 5.6.0  
**Access:** private

Checks `block_has_support( $block_type, 'align', false )`. If supported, adds the `align` attribute with type `string` and an enum of valid alignment values.

---

### wp_apply_alignment_support()

Adds alignment CSS classes to block markup.

```php
function wp_apply_alignment_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.6.0  
**Access:** private

**Returns:** Array with `class` key set to `align{value}` (e.g. `alignwide`, `alignfull`, `aligncenter`).

---

## Generated CSS Classes

| Attribute Value | CSS Class |
|----------------|-----------|
| `left` | `alignleft` |
| `center` | `aligncenter` |
| `right` | `alignright` |
| `wide` | `alignwide` |
| `full` | `alignfull` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'align',
    array(
        'register_attribute' => 'wp_register_alignment_support',
        'apply'              => 'wp_apply_alignment_support',
    )
);
```
