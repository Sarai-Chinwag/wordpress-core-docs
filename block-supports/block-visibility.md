# block-visibility.php — Block Visibility Support

Allows blocks to be hidden on the front-end by returning empty content when visibility is set to `false`.

**Source:** `wp-includes/block-supports/block-visibility.php`  
**Since:** 6.9.0

---

## Support Key

`supports.visibility` — defaults to `true` when checking support.

The visibility value is stored in block metadata: `$block['attrs']['metadata']['blockVisibility']`.

---

## Functions

### wp_render_block_visibility_support()

```php
function wp_render_block_visibility_support( string $block_content, array $block ): string
```

**Since:** 6.9.0  
**Access:** private

**Logic:**

1. Gets the registered block type
2. Checks `block_has_support( $block_type, 'visibility', true )` — note the `true` default
3. If `$block['attrs']['metadata']['blockVisibility']` is exactly `false`, returns `''` (empty string)
4. Otherwise returns the block content unchanged

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `wp_render_block_visibility_support` |

---

## Notes

- No `WP_Block_Supports::register()` call — this support is entirely filter-based.
- The default support value is `true`, meaning blocks support visibility unless they explicitly opt out.
- Only `false` (boolean) triggers hiding; any other value or absence of the attribute renders normally.
