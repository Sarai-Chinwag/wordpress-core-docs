# Customize Sections

Section classes in `wp-includes/customize/` that extend `WP_Customize_Section`.

---

## WP_Customize_Themes_Section

UI container for theme controls with search, filter, and feature-filter capabilities.

**Source:** `wp-includes/customize/class-wp-customize-themes-section.php`  
**Since:** 4.2.0  
**Extends:** `WP_Customize_Section`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'themes'` | 4.2.0 | Section type |
| `$action` | string | public | `''` | 4.9.0 | Theme section action — defines type of themes to load (e.g., `'installed'`, `'wporg'`) |
| `$filter_type` | string | public | `'local'` | 4.9.0 | Filter type: `'local'` (filters loaded themes) or `'remote'` (initiates new remote query). Local filtering disables pagination by default. |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `json()` | public | 4.9.0 | Returns parent JSON plus `action` and `filter_type`. |
| `render_template()` | protected | 4.9.0 | Renders section container with theme overlay, theme browser, search bar, error messages, theme list, "no themes found" messages, and spinner. |
| `filter_bar_content_template()` | protected | 4.9.0 | Renders filter bar: back button, search input, "Filter themes" toggle button (for wporg), and theme count display. Wporg sections get a different search input with live search. |
| `filter_drawer_content_template()` | protected | 4.9.0 | Renders feature filter checkboxes for wporg sections, grouped by feature category from `get_theme_feature_list( false )`. |

---

## WP_Customize_Sidebar_Section

Section representing a widget area (sidebar). Active state depends on whether the sidebar is rendered.

**Source:** `wp-includes/customize/class-wp-customize-sidebar-section.php`  
**Since:** 4.1.0  
**Extends:** `WP_Customize_Section`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'sidebar'` | 4.1.0 | Section type |
| `$sidebar_id` | string | public | — | 4.1.0 | Unique sidebar identifier |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `json()` | public | 4.1.0 | Returns parent JSON plus `sidebarId`. |
| `active_callback()` | public | 4.1.0 | Returns `$this->manager->widgets->is_sidebar_rendered( $this->sidebar_id )`. |

---

## WP_Customize_Nav_Menu_Section

Section for a single nav menu. Custom section only needed in JS.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-section.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Section`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu'` | 4.3.0 | Section type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `json()` | public | 4.3.0 | Returns parent JSON plus `menu_id` (extracted from ID pattern `nav_menu[-?\d+]`). |

---

## WP_Customize_New_Menu_Section

**DEPRECATED 4.9.0** — No longer used as of the menu creation UX introduced in #40104.

**Source:** `wp-includes/customize/class-wp-customize-new-menu-section.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Section`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'new_menu'` | 4.3.0 | Section type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.9.0 | **Deprecated 4.9.0.** Calls `_deprecated_function()`, then parent. |
| `render()` | protected | 4.3.0 | **Deprecated 4.9.0.** Renders accordion section with "add menu" toggle button. |
