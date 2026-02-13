# Theme Control

---

## WP_Customize_Theme_Control

Control for displaying a theme in the Customizer's theme browser. Handles active, installed, and remote (wporg) themes with update notices and compatibility checks.

**Source:** `wp-includes/customize/class-wp-customize-theme-control.php`  
**Since:** 4.2.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'theme'` | 4.2.0 | Control type |
| `$theme` | WP_Theme | public | — | 4.2.0 | Theme object |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `to_json()` | public | 4.2.0 | Exports parent JSON plus `theme` object. |
| `render_content()` | public | 4.2.0 | No-op; rendered via JS template. |
| `content_template()` | public | 4.2.0 | Complex JS template handling multiple theme states: |

### Template States

The `content_template()` renders different UI based on theme state:

1. **Active theme**: Shows "Previewing:" label, "Customize" button, "Installed" success notice.
2. **Installed (classic theme)**: Shows "Live Preview" button (disabled if incompatible WP/PHP), "Installed" notice.
3. **Installed (block theme)**: Shows "Activate" link, "This theme doesn't support Customizer" error notice with link to activate and use Site Editor.
4. **Not installed (wporg)**: Shows "Install & Preview" button (disabled if incompatible).

### Update Notices

For installed themes with updates (`data.theme.hasUpdate`):
- **Compatible**: Warning notice with "Update now" button (single site only).
- **Incompatible WP**: Error with link to Updates screen.
- **Incompatible PHP**: Error with link to Update PHP page.
- **Both incompatible**: Combined error message.

### Compatibility Notices

For themes incompatible with current WP/PHP versions, displays error notice with appropriate guidance and links based on user capabilities (`update_core`, `update_php`).
