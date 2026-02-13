# block-style-variations.php — Block Style Variation Support

Enables per-section styling of blocks via block style variations defined in theme.json.

**Source:** `wp-includes/block-supports/block-style-variations.php`  
**Since:** 6.6.0

---

## Support Key

Registered as `block-style-variation` with an empty config array. Variations are detected via CSS class names matching `is-style-{name}` on blocks.

---

## Functions

### wp_get_block_style_variation_name_from_class()

```php
function wp_get_block_style_variation_name_from_class( string $class_string ): ?array
```

**Since:** 6.6.0

Extracts block style variation names from a CSS class string using regex `/\bis-style-(?!default)(\S+)\b/`. Returns array of matched variation slugs, or `null` if input is not a string.

---

### wp_resolve_block_style_variation_ref_values()

```php
function wp_resolve_block_style_variation_ref_values( array &$variation_data, array $theme_json )
```

**Since:** 6.6.0  
**Access:** private

Recursively resolves `ref` values within variation data by looking up the referenced path in theme.json data. Invalid or unresolvable refs are unset.

---

### wp_render_block_style_variation_support_styles()

```php
function wp_render_block_style_variation_support_styles( array $parsed_block ): array
```

**Since:** 6.6.0  
**Access:** private

**Processing flow:**

1. Extracts variation names from `className` attribute via `wp_get_block_style_variation_name_from_class()`
2. Looks up variation data in merged theme.json (`WP_Theme_JSON_Resolver::get_merged_data()`) under `styles.blocks.{blockName}.variations.{variation}`
3. Only the **first** variation with data is processed
4. Resolves `ref` values via `wp_resolve_block_style_variation_ref_values()`
5. Generates a unique instance ID via `wp_unique_id()`
6. Relocates root variation styles under a `blocks` property to leverage custom selectors
7. Creates a `WP_Theme_JSON` instance and generates a scoped stylesheet
8. Temporarily registers/unregisters the variation instance in `WP_Block_Styles_Registry`
9. Temporarily removes `wp_filter_out_block_nodes` filter (non-admin only) to include block nodes
10. Enqueues styles as inline CSS on `block-style-variation-styles` handle (depends on `wp-block-library` and `global-styles`)
11. Appends the unique instance class to `className`

---

### wp_render_block_style_variation_class_name()

```php
function wp_render_block_style_variation_class_name( string $block_content, array $block ): string
```

**Since:** 6.6.0  
**Access:** private

Ensures the variation instance class name (pattern: `is-style-{slug}--{id}`) is applied to the block's first HTML tag via `WP_HTML_Tag_Processor`.

---

### wp_enqueue_block_style_variation_styles()

```php
function wp_enqueue_block_style_variation_styles()
```

**Since:** 6.6.0  
**Access:** private

Enqueues the `block-style-variation-styles` stylesheet.

---

### wp_register_block_style_variations_from_theme_json_partials()

```php
function wp_register_block_style_variations_from_theme_json_partials( array $variations )
```

**Since:** 6.6.0  
**Access:** private

Registers block style variations from theme.json partial data. For each variation with `blockTypes` and `styles`, registers the style via `register_block_style()` if not already registered. Uses `slug` (or kebab-cased `title`) as the variation name.

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block_data` | filter | 10 | `wp_render_block_style_variation_support_styles` |
| `render_block` | filter | 10 | `wp_render_block_style_variation_class_name` |
| `wp_enqueue_scripts` | action | 1 | `wp_enqueue_block_style_variation_styles` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register( 'block-style-variation', array() );
```
