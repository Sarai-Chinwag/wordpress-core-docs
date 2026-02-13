# settings.php — Block Level Presets Support

Allows blocks to override theme preset CSS variables and classes at the block level.

**Source:** `wp-includes/block-supports/settings.php`  
**Since:** 6.2.0

---

## Support Key

`supports.__experimentalSettings`

---

## Block Attributes Read

`$block['attrs']['settings']` — A theme.json-compatible settings object applied to this specific block instance.

---

## Functions

### _wp_get_presets_class_name()

```php
function _wp_get_presets_class_name( array $block ): string
```

**Since:** 6.2.0  
**Access:** private (internal)

Returns `wp-settings-` followed by an MD5 hash of the serialized block.

---

### _wp_add_block_level_presets_class()

```php
function _wp_add_block_level_presets_class( string $block_content, array $block ): string
```

**Since:** 6.2.0  
**Access:** private (internal)

Adds the presets class name to the block's first HTML tag via `WP_HTML_Tag_Processor`. Returns early if the block doesn't support `__experimentalSettings` or has no settings attribute.

---

### _wp_add_block_level_preset_styles()

```php
function _wp_add_block_level_preset_styles( ?string $pre_render, array $block ): null
```

**Since:** 6.2.0  
**Since:** 6.3.0 Updated preset styles to use Selectors API.  
**Access:** private (internal)

**Processing:**

1. Returns `null` early if block lacks `__experimentalSettings` support or has no settings
2. Builds a root selector for preset variables: `*,[class*="wp-block"]` plus custom selectors from all registered block types that use `__experimentalSelector` or `selectors.root`
3. Scopes the root selector under the block's unique class via `WP_Theme_JSON::scope_selector()`
4. Sanitizes settings via `WP_Theme_JSON::remove_insecure_properties()`
5. Creates a `WP_Theme_JSON` instance and generates two stylesheets:
   - **Variables** stylesheet: CSS custom properties scoped to the block
   - **Presets** stylesheet: preset CSS classes scoped to the block and its descendants
6. Enqueues styles via `wp_enqueue_block_support_styles()`

Always returns `null` (does not short-circuit block rendering).

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `_wp_add_block_level_presets_class` |
| `pre_render_block` | filter | 10 | `_wp_add_block_level_preset_styles` |

---

## Notes

- No `WP_Block_Supports::register()` call in this file.
- The `pre_render_block` filter is used for style generation so styles are available before the block renders.
- The `render_block` filter adds the class name after rendering.
