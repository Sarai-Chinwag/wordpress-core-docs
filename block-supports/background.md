# background.php — Background Block Support

Registers background image support and renders background styles via `render_block` filter.

**Source:** `wp-includes/block-supports/background.php`  
**Since:** 6.4.0

---

## Support Key

`supports.background` — top-level boolean/object  
`supports.background.backgroundImage` — checked for render output

---

## Registered Attribute

| Attribute | Type |
|-----------|------|
| `style` | `object` |

Only registered if no existing `style` attribute is defined on the block type.

---

## Block Attributes Used

Values read from `$block['attrs']['style']['background']`:

| Key | Description | Since |
|-----|-------------|-------|
| `backgroundImage` | Image URL/source | 6.4.0 |
| `backgroundSize` | CSS background-size (defaults to `cover`) | 6.4.0 |
| `backgroundPosition` | CSS background-position | 6.5.0 |
| `backgroundRepeat` | CSS background-repeat | 6.5.0 |
| `backgroundAttachment` | CSS background-attachment | 6.7.0 |

---

## Functions

### wp_register_background_support()

```php
function wp_register_background_support( WP_Block_Type $block_type )
```

**Since:** 6.4.0  
**Access:** private

---

### wp_render_background_support()

```php
function wp_render_background_support( string $block_content, array $block ): string
```

**Since:** 6.4.0  
**Since:** 6.5.0 Added `backgroundPosition` and `backgroundRepeat` output.  
**Since:** 6.6.0 Removed requirement for `backgroundImage.source`.  
**Since:** 6.7.0 Added `backgroundAttachment` output.  
**Access:** private

**Processing:**

1. Checks `block_has_support( $block_type, array( 'background', 'backgroundImage' ), false )`
2. Checks `wp_should_skip_block_supports_serialization()` for `backgroundImage`
3. If `backgroundSize` is `contain` and no position is set, defaults position to `50% 50%`
4. Delegates to `wp_style_engine_get_styles()` for CSS generation
5. Uses `WP_HTML_Tag_Processor` to inject inline `style` and `has-background` class to first tag

---

## Generated CSS

- Inline `style` attribute with `background-image`, `background-size`, `background-position`, `background-repeat`, `background-attachment`
- CSS class: `has-background`

---

## Hooks

| Hook | Type | Priority |
|------|------|----------|
| `render_block` | filter | 10 |

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'background',
    array(
        'register_attribute' => 'wp_register_background_support',
    )
);
add_filter( 'render_block', 'wp_render_background_support', 10, 2 );
```

Note: No `apply` callback — rendering is handled entirely via the `render_block` filter.
