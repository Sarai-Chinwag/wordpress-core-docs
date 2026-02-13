# Customize Panels

Panel classes in `wp-includes/customize/` that extend `WP_Customize_Panel`.

---

## WP_Customize_Themes_Panel

Panel for browsing and switching themes. Displays active/previewing theme with a "Change" button.

**Source:** `wp-includes/customize/class-wp-customize-themes-panel.php`  
**Since:** 4.9.0  
**Extends:** `WP_Customize_Panel`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'themes'` | 4.9.0 | Panel type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_template()` | protected | 4.9.0 | Renders panel container (`control-panel-themes`). Shows "Active theme" or "Previewing theme" label based on `$this->manager->is_theme_active()`. Includes "Change" button if user has `switch_themes` capability. |
| `content_template()` | protected | 4.9.0 | Renders panel content with back button, "You are browsing Themes" notice, optional help toggle and description (only for users with `install_themes` cap, non-multisite), notifications container, and full-width themes container. |

---

## WP_Customize_Nav_Menus_Panel

Panel for managing navigation menus. Includes screen options for menu item field visibility.

**Source:** `wp-includes/customize/class-wp-customize-nav-menus-panel.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Panel`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menus'` | 4.3.0 | Panel type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_screen_options()` | public | 4.3.0 | Requires `wp-admin/includes/nav-menu.php`, adds `wp_nav_menu_manage_columns` filter on `manage_nav-menus_columns`, then renders screen options via `WP_Screen::get('nav-menus.php')->render_screen_options()`. |
| `wp_nav_menu_manage_columns()` | public | 4.3.0 | **Deprecated 4.5.0** in favor of `wp_nav_menu_manage_columns()`. Requires nav-menu include and delegates. |
| `content_template()` | protected | 4.3.0 | Renders panel content: back button, "You are customizing" title with panel name, help toggle, screen options toggle, optional description, screen options wrap (via `render_screen_options()`), and "Menus" heading for the sections list. |
