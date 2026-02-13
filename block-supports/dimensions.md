# dimensions.php — Dimensions Block Support

Handles dimension-related styles including `minHeight` and `aspectRatio`.

**Source:** `wp-includes/block-supports/dimensions.php`  
**Since:** 5.9.0

Note: This does NOT include the `spacing` support (padding/margin) even though both appear under the "Dimensions" panel in the editor. Spacing remains in `spacing.php`.

---

## Support Key

`supports.dimensions`

| Feature Key | Description | Since |
|-------------|-------------|-------|
| `minHeight` | Minimum height | 6.2.0 |
| `aspectRatio` | Aspect ratio | 6.5.0 |

---

## Registered Attribute

| Attribute | Type | Condition |
|-----------|------|-----------|
| `style` | `object` | Only if not already defined |

---

## Functions

### wp_register_dimensions_support()

```php
function wp_register_dimensions_support( WP_Block_Type $block_type )
```

**Since:** 5.9.0  
**Access:** private

---

### wp_apply_dimensions_support()

```php
function wp_apply_dimensions_support( WP_Block_Type $block_type, array $block_attributes ): array
```

**Since:** 5.9.0  
**Since:** 6.2.0 Added `minHeight` support.  
**Access:** private

Handles `minHeight` via `wp_style_engine_get_styles()`. Width support is noted as "to be added in near future" in the source.

**Returns:** Array with `style` for inline CSS.

---

### wp_render_dimensions_support()

```php
function wp_render_dimensions_support( string $block_content, array $block ): string
```

**Since:** 6.5.0  
**Access:** private

Handles `aspectRatio` via `render_block` filter:

1. Checks support for `dimensions.aspectRatio`
2. If `aspectRatio` is set, forces `minHeight: unset` to prevent conflicts
3. If `minHeight` is set but not `aspectRatio`, forces `aspectRatio: unset`
4. Uses `WP_HTML_Tag_Processor` to inject inline styles and classnames to the first tag

---

## Block Attributes Read

| Path | Property |
|------|----------|
| `style.dimensions.minHeight` | Minimum height value |
| `style.dimensions.aspectRatio` | Aspect ratio value |

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `wp_render_dimensions_support` |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'dimensions',
    array(
        'register_attribute' => 'wp_register_dimensions_support',
        'apply'              => 'wp_apply_dimensions_support',
    )
);
add_filter( 'render_block', 'wp_render_dimensions_support', 10, 2 );
```
