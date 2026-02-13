# elements.php — Elements Styles Block Support

Generates scoped CSS for inner element styles (buttons, links, headings) within blocks.

**Source:** `wp-includes/block-supports/elements.php`  
**Since:** 5.8.0

---

## Overview

This support handles per-block color styling for inner HTML elements: buttons (`.wp-element-button`), links (`a`), and headings (`h1`–`h6`). Unlike most block supports, it does not register via `WP_Block_Supports` — it operates entirely through `render_block_data` and `render_block` filters.

---

## Block Attributes Read

From `$block['attrs']['style']['elements']`:

| Element | Color Paths Checked |
|---------|-------------------|
| `button` | `color.text`, `color.background`, `color.gradient` |
| `link` | `color.text`, `:hover.color.text` |
| `heading` | `color.text`, `color.background`, `color.gradient` |
| `h1`–`h6` | `color.text`, `color.background`, `color.gradient` |

---

## Functions

### wp_get_elements_class_name()

```php
function wp_get_elements_class_name( array $block ): string
```

**Since:** 6.0.0  
**Access:** private

Returns `wp-elements-` followed by an MD5 hash of the serialized block.

---

### wp_should_add_elements_class_name()

```php
function wp_should_add_elements_class_name( array $block, array $options ): bool
```

**Since:** 6.6.0  
**Access:** private

Checks whether any element color property has a non-null value, respecting per-element `skip` options.

---

### wp_render_elements_support_styles()

```php
function wp_render_elements_support_styles( array $parsed_block ): array
```

**Since:** 6.0.0  
**Since:** 6.1.0 Implemented the style engine to generate CSS and classnames.  
**Since:** 6.6.0 Moved from `pre_render_block` to `render_block_data` filter.  
**Access:** private

**Processing:**

1. Checks serialization skip for `color.link`, `color.heading`, `color.button`
2. If all are skipped, returns early
3. Calls `wp_should_add_elements_class_name()` to check if any relevant styles exist
4. Generates unique class name via `wp_get_elements_class_name()`
5. Appends class to `$parsed_block['attrs']['className']`
6. For each element type, calls `wp_style_engine_get_styles()` with scoped selectors:

| Element | CSS Selector |
|---------|-------------|
| `button` | `.{class} .wp-element-button, .{class} .wp-block-button__link` |
| `link` | `.{class} a:where(:not(.wp-element-button))` |
| `link:hover` | `.{class} a:where(:not(.wp-element-button)):hover` |
| `heading` | `.{class} h1, .{class} h2, .{class} h3, .{class} h4, .{class} h5, .{class} h6` |
| `h1`–`h6` | `.{class} h1` through `.{class} h6` (individually) |

Styles are stored in the style engine's `block-supports` context for later enqueuing.

**Deprecation:** Using this function as a `pre_render_block` filter is deprecated since 6.6.0.

---

### wp_render_elements_class_name()

```php
function wp_render_elements_class_name( string $block_content, array $block ): string
```

**Since:** 6.6.0

Ensures the `wp-elements-{hash}` class from `render_block_data` is applied to the block's first HTML tag via `WP_HTML_Tag_Processor`.

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `wp_render_elements_class_name` |
| `render_block_data` | filter | 10 | `wp_render_elements_support_styles` |
