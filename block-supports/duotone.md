# duotone.php — Duotone Block Support

Registers duotone filter support. All logic is delegated to the `WP_Duotone` class.

**Source:** `wp-includes/block-supports/duotone.php`  
**Since:** 5.8.0

Note: Parts of the original source were derived from TinyColor (MIT license, Brian Grinstead).

---

## Support Key

`supports.filter.duotone` (migrated from `supports.__experimentalDuotone`)

---

## Hooks

| Hook | Type | Priority | Callback |
|------|------|----------|----------|
| `render_block` | filter | 10 | `WP_Duotone::render_duotone_support` |
| `render_block_core/image` | filter | 10 | `WP_Duotone::restore_image_outer_container` |
| `wp_enqueue_scripts` | action | 9 | `WP_Duotone::output_block_styles` |
| `wp_enqueue_scripts` | action | 11 | `WP_Duotone::output_global_styles` |
| `wp_footer` | action | 10 | `WP_Duotone::output_footer_assets` |
| `block_editor_settings_all` | filter | 10 | `WP_Duotone::add_editor_settings` |
| `block_type_metadata_settings` | filter | 10 | `WP_Duotone::migrate_experimental_duotone_support_flag` |

### Enqueue Order

- Block styles (`core-block-supports-inline-css`) enqueue **before** the style engine (`wp_enqueue_stored_styles`) at priority 9
- Global styles (`global-styles-inline-css`) enqueue **after** other global styles (`wp_enqueue_global_styles`) at priority 11
- SVG filters and classic theme block styles output in `wp_footer` at priority 10

---

## Registration

```php
WP_Block_Supports::get_instance()->register(
    'duotone',
    array(
        'register_attribute' => array( 'WP_Duotone', 'register_duotone_support' ),
    )
);
```

All rendering, style output, and migration logic lives in the `WP_Duotone` class (defined elsewhere in core).
