# Widget Controls

Controls for managing widgets in the Customizer.

---

## WP_Widget_Area_Customize_Control

Control representing a widget area (sidebar) with add/reorder widget functionality.

**Source:** `wp-includes/customize/class-wp-widget-area-customize-control.php`  
**Since:** 3.9.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'sidebar_widgets'` | 3.9.0 | Control type |
| `$sidebar_id` | int\|string | public | — | 3.9.0 | Sidebar ID |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `to_json()` | public | 3.9.0 | Exports parent JSON plus `sidebar_id`. |
| `render_content()` | public | 3.9.0 | Renders "Add a Widget" button (controls `#available-widgets`), "Reorder"/"Done" toggle button, and screen reader description text. |

---

## WP_Widget_Form_Customize_Control

Control for an individual widget form, with deferred rendering via JSON export.

**Source:** `wp-includes/customize/class-wp-widget-form-customize-control.php`  
**Since:** 3.9.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'widget_form'` | 3.9.0 | Control type |
| `$widget_id` | string | public | — | 3.9.0 | Widget ID |
| `$widget_id_base` | string | public | — | 3.9.0 | Widget ID base |
| `$sidebar_id` | string | public | — | 3.9.0 | Sidebar ID |
| `$is_new` | bool | public | `false` | 3.9.0 | Whether this is a new widget |
| `$width` | int | public | — | 3.9.0 | Widget width |
| `$height` | int | public | — | 3.9.0 | Widget height |
| `$is_wide` | bool | public | `false` | 3.9.0 | Whether widget is wide |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `to_json()` | public | 3.9.0 | Exports parent JSON plus `widget_id`, `widget_id_base`, `sidebar_id`, `width`, `height`, `is_wide`. Also generates `widget_control` and `widget_content` HTML via `wp_list_widget_controls_dynamic_sidebar()` and `$this->manager->widgets->get_widget_control_parts()`. Requires `wp-admin/includes/widgets.php`. |
| `render_content()` | public | 3.9.0 | No-op; content exported via `to_json()` for deferred embedding. |
| `active_callback()` | public | 4.0.0 | Returns `true` if the widget is rendered on the page, via `$this->manager->widgets->is_widget_rendered( $this->widget_id )`. |

---

## WP_Sidebar_Block_Editor_Control

Control for the widgets block editor in the Customizer. Renders an empty container; the block editor is initialized by `@wordpress/customize-widgets` JavaScript.

**Source:** `wp-includes/customize/class-wp-sidebar-block-editor-control.php`  
**Since:** 5.8.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'sidebar_block_editor'` | 5.8.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | public | 5.8.0 | Renders empty content. JavaScript in `@wordpress/customize-widgets` handles the rest. |
