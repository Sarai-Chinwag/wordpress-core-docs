# Block Supports Subsystem

The block supports subsystem provides server-side rendering of block-level design features (colors, typography, spacing, etc.) by registering attributes, generating CSS classes/inline styles, and injecting them into block markup.

**Source:** `wp-includes/block-supports/`  
**Since:** 5.6.0 (earliest files)

---

## Architecture

Each block support file follows a common pattern:

1. **Register** — A `register_attribute` callback adds block attributes (e.g. `style`, `backgroundColor`) to block types that declare support.
2. **Apply** — An `apply` callback reads block attributes and returns CSS classes/inline styles to merge into the block wrapper.
3. **Render** — Some supports use `render_block` or `render_block_data` filters to inject styles via `WP_HTML_Tag_Processor` for non-server-rendered blocks.

All supports register themselves via `WP_Block_Supports::get_instance()->register()`.

---

## Files Overview

| File | Support Key(s) | Since | Registration Method |
|------|---------------|-------|-------------------|
| [align.php](align.md) | `align` | 5.6.0 | `register_attribute` + `apply` |
| [aria-label.php](aria-label.md) | `ariaLabel` | 6.8.0 | `register_attribute` + `apply` |
| [background.php](background.md) | `background`, `background.backgroundImage` | 6.4.0 | `register_attribute` + `render_block` filter |
| [block-style-variations.php](block-style-variations.md) | `block-style-variation` | 6.6.0 | `render_block_data` + `render_block` filters |
| [block-visibility.php](block-visibility.md) | `visibility` | 6.9.0 | `render_block` filter |
| [border.php](border.md) | `__experimentalBorder` | 5.8.0 | `register_attribute` + `apply` |
| [colors.php](colors.md) | `color` (text, background, gradients, link, button, heading) | 5.6.0 | `register_attribute` + `apply` |
| [custom-classname.php](custom-classname.md) | `customClassName` | 5.6.0 | `register_attribute` + `apply` |
| [dimensions.php](dimensions.md) | `dimensions` (minHeight, aspectRatio) | 5.9.0 | `register_attribute` + `apply` + `render_block` filter |
| [duotone.php](duotone.md) | `duotone` (via `WP_Duotone` class) | 5.8.0 | `register_attribute` + multiple filters/actions |
| [elements.php](elements.md) | Element styles (button, link, heading colors) | 5.8.0 | `render_block_data` + `render_block` filters |
| [generated-classname.php](generated-classname.md) | `className` | 5.6.0 | `apply` only |
| [layout.php](layout.md) | `layout`, `__experimentalLayout` | 5.8.0 | `register_attribute` + `render_block` filter |
| [position.php](position.md) | `position` | 6.2.0 | `register_attribute` + `render_block` filter |
| [settings.php](settings.md) | `__experimentalSettings` | 6.2.0 | `render_block` + `pre_render_block` filters |
| [shadow.php](shadow.md) | `shadow` | 6.3.0 | `register_attribute` + `apply` |
| [spacing.php](spacing.md) | `spacing` (padding, margin) | 5.8.0 | `register_attribute` + `apply` |
| [typography.php](typography.md) | `typography` (fontSize, fontFamily, lineHeight, textAlign, etc.) | 5.6.0 | `register_attribute` + `apply` + `render_block` filter |
| [utils.php](utils.md) | Utility functions | 6.0.0 | N/A |

---

## Common Patterns

### Serialization Skipping

Blocks can opt out of server-side serialization of specific support features via `__experimentalSkipSerialization` in their `supports` definition. The utility function `wp_should_skip_block_supports_serialization()` (in `utils.php`) checks this flag. Nearly every apply/render function checks it before generating output.

### Style Engine Integration

Most supports delegate CSS generation to `wp_style_engine_get_styles()`, which returns both `classnames` and `css` (inline styles). Supports that generate layout or position CSS use `wp_style_engine_get_stylesheet_from_css_rules()` to store styles in the style engine for later enqueuing.

### WP_HTML_Tag_Processor

Supports that use `render_block` filters inject classes and inline styles into block markup using `WP_HTML_Tag_Processor`, targeting the first tag (presumed wrapper element).

---

## Hook Summary

### Filters

| Hook | File | Description |
|------|------|-------------|
| `block_default_classname` | generated-classname.php | Filters the default block class name |
| `render_block` | background, block-style-variations, block-visibility, dimensions, elements, layout, position, settings, typography | Modifies rendered block content |
| `render_block_data` | block-style-variations, elements, layout | Modifies parsed block data before rendering |
| `pre_render_block` | settings | Adds block-level preset styles before rendering |
| `render_block_core/group` | layout | Restores inner container for classic themes |
| `render_block_core/image` | duotone, layout | Image-specific rendering |
| `block_editor_settings_all` | duotone | Adds editor settings |
| `block_type_metadata_settings` | duotone | Migrates experimental duotone flag |
| `wp_theme_json_get_style_nodes` | block-style-variations | Temporarily removed/re-added during variation processing |

### Actions

| Hook | File | Description |
|------|------|-------------|
| `wp_enqueue_scripts` | block-style-variations, duotone | Enqueues block style variation and duotone styles |
| `wp_footer` | duotone | Outputs SVG filters and block styles |
