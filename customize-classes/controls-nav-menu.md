# Nav Menu Controls

Controls for managing navigation menus in the Customizer.

---

## WP_Customize_Nav_Menu_Control

Control for a complete nav menu, providing "Add Items" and "Reorder" functionality.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu'` | 4.3.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | public | 4.3.0 | No-op; uses JS template. |
| `content_template()` | public | 4.3.0 | Renders invitation text, "Add Items" button (controls `#available-menu-items`), and "Reorder"/"Done" toggle button. |
| `json()` | public | 4.3.0 | Returns parent JSON plus `menu_id` from `$this->setting->term_id`. |

---

## WP_Customize_Nav_Menu_Item_Control

Control for an individual nav menu item with full editing fields.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-item-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu_item'` | 4.3.0 | Control type |
| `$setting` | WP_Customize_Nav_Menu_Item_Setting | public | — | 4.3.0 | The nav menu item setting |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.3.0 | Calls parent constructor. |
| `render_content()` | public | 4.3.0 | No-op; uses JS template. |
| `content_template()` | public | 4.3.0 | Renders item bar (type label, title, sub-item indicator, edit/delete buttons) and settings panel (URL for custom items, navigation label, open-in-new-tab, title attribute, CSS classes, XFN, description, original link, remove button, hidden inputs for db-id and parent-id). Fires `wp_nav_menu_item_custom_fields_customize_template` action. |
| `json()` | public | 4.3.0 | Returns parent JSON plus `menu_item_id` from `$this->setting->post_id`. |

### Hooks

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `wp_nav_menu_item_custom_fields_customize_template` | action | 5.4.0 | Fires at end of menu item form for custom fields |

---

## WP_Customize_Nav_Menu_Name_Control

Control for the menu name input field.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-name-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu_name'` | 4.3.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | protected | 4.3.0 | No-op; uses JS template. |
| `content_template()` | protected | 4.3.0 | Text input with class `menu-name-field live-update-section-title`, optional label and description. |

---

## WP_Customize_Nav_Menu_Auto_Add_Control

Control for the auto-add top-level pages checkbox.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-auto-add-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu_auto_add'` | 4.3.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | protected | 4.3.0 | No-op; uses JS template. |
| `content_template()` | protected | 4.3.0 | Checkbox with label "Automatically add new top-level pages to this menu", under "Menu Options" title. |

---

## WP_Customize_Nav_Menu_Location_Control

Control for assigning a menu to a theme location. Renders as a select dropdown.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-location-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu_location'` | 4.3.0 | Control type |
| `$location_id` | string | public | `''` | 4.3.0 | Location ID |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `to_json()` | public | 4.3.0 | Exports parent JSON plus `locationId`. |
| `render_content()` | public | 4.3.0 | Renders label, description, `<select>` with choices, "+ Create New Menu" button (hidden when value set), and "Edit Menu" button (hidden when no value). |

---

## WP_Customize_Nav_Menu_Locations_Control

Control for displaying all registered menu locations with checkboxes for assignment.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-locations-control.php`  
**Since:** 4.9.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'nav_menu_locations'` | 4.9.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | public | 4.9.0 | No-op; uses JS template. |
| `content_template()` | public | 4.9.0 | Renders list of all registered nav menu locations (from `get_registered_nav_menus()`) as checkboxes. Shows contextual text based on `data.isCreating` state. Each checkbox has `data-menu-id` and `data-location-id` attributes. Only renders if `current_theme_supports('menus')`. |

---

## WP_Customize_New_Menu_Control

**DEPRECATED 4.9.0** — No longer used as of the menu creation UX introduced in #40104.

**Source:** `wp-includes/customize/class-wp-customize-new-menu-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'new_menu'` | 4.3.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.9.0 | **Deprecated 4.9.0.** Calls `_deprecated_function()`, then parent. |
| `render_content()` | public | 4.3.0 | **Deprecated 4.9.0.** Renders "Create Menu" button and spinner. |
