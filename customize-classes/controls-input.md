# Input Controls

Controls for color pickers, code editors, date/time selectors, and background position.

---

## WP_Customize_Color_Control

Color picker control supporting full color and hue-only modes.

**Source:** `wp-includes/customize/class-wp-customize-color-control.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'color'` | — | Control type |
| `$statuses` | array | public | — | — | Statuses array. Set to `['' => 'Default']` in constructor. |
| `$mode` | string | public | `'full'` | 4.7.0 | Mode: `'full'` for hex color picker, `'hue'` for hue slider |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 3.4.0 | Initializes `$statuses` with default entry. |
| `enqueue()` | public | 3.4.0 | Enqueues `wp-color-picker` script and style. |
| `to_json()` | public | 3.4.0 | Exports `statuses`, `defaultValue` (from `$this->setting->default`), and `mode`. |
| `render_content()` | public | 3.4.0 | No-op; rendered via JS. |
| `content_template()` | public | 4.1.0 | JS template: hex input (`maxlength="7"`) for full mode, number input (`min="1" max="359"`) for hue mode. |

---

## WP_Customize_Code_Editor_Control

Code editor control using CodeMirror.

**Source:** `wp-includes/customize/class-wp-customize-code-editor-control.php`  
**Since:** 4.9.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'code_editor'` | 4.9.0 | Control type |
| `$code_type` | string | public | `''` | 4.9.0 | Type of code being edited |
| `$editor_settings` | array\|false | public | `array()` | 4.9.0 | Code editor settings. See `wp_enqueue_code_editor()`. |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `enqueue()` | public | 4.9.0 | Calls `wp_enqueue_code_editor()` with `$code_type` and default `indentUnit`/`tabSize` of 2. Stores result in `$editor_settings`. |
| `json()` | public | 4.9.0 | Returns parent JSON plus `editor_settings` and `input_attrs`. |
| `render_content()` | public | 4.9.0 | No-op; rendered via JS. |
| `content_template()` | public | 4.9.0 | JS template with label, description, notifications container, and textarea with class `code`. |

---

## WP_Customize_Date_Time_Control

Date and time picker control with configurable year range, time display, and 12/24 hour format.

**Source:** `wp-includes/customize/class-wp-customize-date-time-control.php`  
**Since:** 4.9.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'date_time'` | 4.9.0 | Control type |
| `$min_year` | int | public | `1000` | 4.9.0 | Minimum year |
| `$max_year` | int | public | `9999` | 4.9.0 | Maximum year |
| `$allow_past_date` | bool | public | `true` | 4.9.0 | Whether past dates are allowed |
| `$include_time` | bool | public | `true` | 4.9.0 | Whether to show hours, minutes, meridian |
| `$twelve_hour_format` | bool | public | `true` | 4.9.0 | Whether to use 12-hour format. Value still saved as `Y-m-d H:i:s`. |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | public | 4.9.0 | No-op; rendered via JS. |
| `json()` | public | 4.9.0 | Returns parent JSON plus `maxYear`, `minYear`, `allowPastDate`, `twelveHourFormat`, `includeTime`. |
| `content_template()` | public | 4.9.0 | JS template with date fields (year, month select, day) arranged per site's `date_format` option, optional time fields (hour, minute, meridian select), and timezone info. Falls back to ISO format if date_format lacks components. |
| `get_month_choices()` | public | 4.9.0 | Returns array of month choices with text (number-abbreviation) and value. Based on `touch_time()`. |
| `get_timezone_info()` | public | 4.9.0 | Returns timezone info array with `abbr` and `description` (HTML). Uses `timezone_string` option or `gmt_offset`. |
| `format_gmt_offset( $offset )` | public | 4.9.0 | Formats numeric offset to string with `+`/`-` prefix and `:15`/`:30`/`:45` for fractional hours. |

---

## WP_Customize_Background_Position_Control

Control for selecting background image position via a 3×3 radio button grid.

**Source:** `wp-includes/customize/class-wp-customize-background-position-control.php`  
**Since:** 4.7.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'background_position'` | 4.7.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `render_content()` | public | 4.7.0 | No-op; rendered via JS. |
| `content_template()` | public | 4.7.0 | JS template with 3×3 grid of radio buttons for positions: `left top`, `center top`, `right top`, `left center`, `center center`, `right center`, `left bottom`, `center bottom`, `right bottom`. Uses dashicons for directional arrows. |
