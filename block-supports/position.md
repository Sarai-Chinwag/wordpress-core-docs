# position.php — Position Block Support

Handles sticky and fixed positioning for blocks.

**Source:** `wp-includes/block-supports/position.php`  
**Since:** 6.2.0

---

## Support Key

`supports.position`

Position types are gated by **global theme settings** (not just block support):
- `settings.position.sticky` must be `true` for sticky
- `settings.position.fixed` must be `true` for fixed

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `style` | `object` |

---

## Block Attributes Read

From `$block['attrs']['style']['position']`:

| Key | Description |
|-----|-------------|
| `type` | `sticky` or `fixed` |
| `top` | Top offset |
| `right` | Right offset |
| `bottom` | Bottom offset |
| `left` | Left offset |

---

## Functions

### wp_register_position_support()

```php
function wp_register_position_support( WP_Block_Type $block_type )
```

**Since:** 6.2.0  
**Access:** private

---

### wp_render_position_support()

```php
function wp_render_position_support( string $block_content, array $block ): string
```

**Since:** 6.2.0  
**Access:** private

**Processing:**

1. Checks block support and non-empty `style.position`
2. Reads global settings to determine allowed position types
3. For each side (`top`, `right`, `bottom`, `left`):
   - If value is `0` or `'0'`, converts to `'0px'` for `calc()` compatibility
   - For `top` with `fixed` or `sticky`: wraps in `calc({value} + var(--wp-admin--admin-bar--position-offset, 0px))` to account for the admin bar
4. Sets `position: {type}` and `z-index: 10`
5. Stores CSS in style engine `block-supports` context
6. Adds unique class and `is-position-{type}` class via `WP_HTML_Tag_Processor`

---

## Generated CSS Classes

| Class | Condition |
|-------|-----------|
| `wp-container-{id}` | Unique position container |
| `is-position-sticky` | Sticky position |
| `is-position-fixed` | Fixed position |

## Generated Inline Styles

- `position: sticky` or `position: fixed`
- `z-index: 10`
- `top`, `right`, `bottom`, `left` values (with admin bar offset for top)

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `wp_render_position_support` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'position',
    array(
        'register_attribute' => 'wp_register_position_support',
    )
);
```
