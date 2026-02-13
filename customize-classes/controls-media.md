# Media Controls

Media-related Customizer controls for handling file uploads, images, cropping, and specific image contexts.

---

## WP_Customize_Media_Control

Base control for media selection using the WordPress media library.

**Source:** `wp-includes/customize/class-wp-customize-media-control.php`  
**Since:** 4.2.0  
**Extends:** `WP_Customize_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'media'` | 4.2.0 | Control type |
| `$mime_type` | string | public | `''` | 4.2.0 | Media control mime type |
| `$button_labels` | array | public | `array()` | 4.2.0 | Button labels, merged with defaults from `get_default_button_labels()` |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.1.0, 4.2.0 (moved) | Merges `$button_labels` with defaults via `get_default_button_labels()`. |
| `enqueue()` | public | 3.4.0, 4.2.0 (moved) | Enqueues `wp_enqueue_media()`. |
| `to_json()` | public | 3.4.0, 4.2.0 (moved) | Exports `label`, `mime_type`, `button_labels`, `canUpload`, `defaultAttachment`, and `attachment` (via `wp_prepare_attachment_for_js()`). |
| `render_content()` | public | 3.4.0, 4.2.0 (moved) | No-op; content rendered via JS template. |
| `content_template()` | public | 4.1.0, 4.2.0 (moved) | Renders JS template with attachment preview (image/audio/video/document), remove/change/select buttons. |
| `get_default_button_labels()` | public | 4.9.0 | Returns default button labels (`select`, `change`, `default`, `remove`, `placeholder`, `frame_title`, `frame_button`) based on mime type (`video`, `audio`, `image`, or default). Image type also includes `site_icon` label. |

---

## WP_Customize_Upload_Control

Upload control extending Media control. Resolves attachment from URL.

**Source:** `wp-includes/customize/class-wp-customize-upload-control.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Media_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'upload'` | 3.4.0 | Control type |
| `$mime_type` | string | public | `''` | 4.1.0 | Media control mime type |
| `$button_labels` | array | public | `array()` | 4.1.0 | Button labels |
| `$removed` | string | public | `''` | — | Unused property |
| `$context` | mixed | public | — | — | Unused property |
| `$extensions` | array | public | `array()` | — | Unused property |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `to_json()` | public | 3.4.0 | Calls parent, then resolves attachment ID from URL via `attachment_url_to_postid()` and adds `attachment` data via `wp_prepare_attachment_for_js()`. |

---

## WP_Customize_Image_Control

Image-specific upload control.

**Source:** `wp-includes/customize/class-wp-customize-image-control.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Upload_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'image'` | 3.4.0 | Control type |
| `$mime_type` | string | public | `'image'` | 4.1.0 | Media control mime type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `prepare_control()` | public | 3.4.2 | **Deprecated 4.1.0.** No-op. |
| `add_tab( $id, $label, $callback )` | public | 3.4.0 | **Deprecated 4.1.0.** No-op. |
| `remove_tab( $id )` | public | 3.4.0 | **Deprecated 4.1.0.** No-op. |
| `print_tab_image( $url, $thumbnail_url )` | public | 3.4.0 | **Deprecated 4.1.0.** No-op. |

---

## WP_Customize_Background_Image_Control

Control for the background image with theme support integration.

**Source:** `wp-includes/customize/class-wp-customize-background-image-control.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Image_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'background'` | 4.1.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager )` | public | 3.4.0 | Hardcodes ID `'background_image'`, label `'Background Image'`, section `'background_image'`. |
| `enqueue()` | public | 4.1.0 | Calls parent enqueue, then localizes `_wpCustomizeBackground` with theme's `custom-background` defaults and add nonce. |

---

## WP_Customize_Cropped_Image_Control

Control for images that require cropping to specific dimensions.

**Source:** `wp-includes/customize/class-wp-customize-cropped-image-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Image_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'cropped_image'` | 4.3.0 | Control type |
| `$width` | int | public | `150` | 4.3.0 | Suggested crop width |
| `$height` | int | public | `150` | 4.3.0 | Suggested crop height |
| `$flex_width` | bool | public | `false` | 4.3.0 | Whether width is flexible |
| `$flex_height` | bool | public | `false` | 4.3.0 | Whether height is flexible |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `enqueue()` | public | 4.3.0 | Enqueues `customize-views` script, then calls parent. |
| `to_json()` | public | 4.3.0 | Exports `width`, `height`, `flex_width`, `flex_height` (all as `absint`). |

---

## WP_Customize_Site_Icon_Control

Control for the site icon (favicon), with browser and app icon previews.

**Source:** `wp-includes/customize/class-wp-customize-site-icon-control.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Cropped_Image_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'site_icon'` | 4.3.0 | Control type |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.3.0 | Calls parent, adds `wp_site_icon` to `customize_controls_print_styles` at priority 99. |
| `content_template()` | public | 4.5.0 | Renders JS template with app icon preview, browser tab preview (with SVG browser chrome), site title display, and upload/remove/change buttons. |

---

## WP_Customize_Header_Image_Control

Control for the header image with support for uploaded and default headers, randomization, and cropping.

**Source:** `wp-includes/customize/class-wp-customize-header-image-control.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Image_Control`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'header'` | 4.2.0 | Control type |
| `$uploaded_headers` | string | public | — | 3.9.0 | Uploaded header images |
| `$default_headers` | string | public | — | 3.9.0 | Default header images |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager )` | public | 3.4.0 | Hardcodes ID `'header_image'`, settings `['default'=>'header_image', 'data'=>'header_image_data']`, section `'header_image'`. |
| `enqueue()` | public | — | Enqueues media and `customize-views`. Calls `prepare_control()`. Localizes `_wpCustomizeHeader` with dimensions, flex settings, current image, nonces, uploads, and defaults. |
| `prepare_control()` | public | — | Processes default/uploaded headers via `Custom_Image_Header`. Adds `print_header_image_template` to footer scripts. |
| `print_header_image_template()` | public | — | Outputs JS templates `#tmpl-header-choice` (with randomize and thumbnail buttons) and `#tmpl-header-current`. |
| `get_current_image_src()` | public | — | Returns current header image source URL using the `get_url` callback. |
| `render_content()` | public | — | Renders PHP content: instructions based on theme's custom-header dimensions, current header display, hide/add image buttons, previously uploaded and suggested headers lists. |
