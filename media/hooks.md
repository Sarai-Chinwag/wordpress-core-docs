# Media API Hooks

Actions and filters for media processing, image manipulation, and attachment handling.

**Source:** `wp-includes/media.php`, `wp-includes/class-wp-image-editor.php`

---

## Image Size Filters

### editor_max_image_size

Filters maximum dimensions for images in the editor.

```php
apply_filters( 'editor_max_image_size', int[] $max_image_size, string|int[] $size, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_image_size` | int[] | `array( max_width, max_height )` |
| `$size` | string\|int[] | Requested size name or dimensions |
| `$context` | string | `display` or `edit` |

---

### intermediate_image_sizes

Filters the list of intermediate image size names.

```php
apply_filters( 'intermediate_image_sizes', string[] $sizes )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$sizes` | string[] | Size names: `thumbnail`, `medium`, `medium_large`, `large`, custom |

**Example:**

```php
add_filter( 'intermediate_image_sizes', function( $sizes ) {
    // Remove medium_large
    return array_diff( $sizes, array( 'medium_large' ) );
} );
```

---

### max_srcset_image_width

Filters the maximum image width for srcset.

```php
apply_filters( 'max_srcset_image_width', int $max_width, int[] $size_array )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_width` | int | Maximum width in pixels (default: 2048) |
| `$size_array` | int[] | `array( width, height )` of displayed size |

---

### wp_constrain_dimensions

Filters calculated constrained dimensions.

```php
apply_filters( 'wp_constrain_dimensions', int[] $dimensions, int $current_width, int $current_height, int $max_width, int $max_height )
```

---

### image_resize_dimensions

Pre-filters resize dimension calculations.

```php
apply_filters( 'image_resize_dimensions', array|null $output, int $orig_w, int $orig_h, int $dest_w, int $dest_h, bool|array $crop )
```

Return non-null to short-circuit the default calculation.

---

## Attachment Filters

### wp_get_attachment_image_src

Filters the attachment image source array.

```php
apply_filters( 'wp_get_attachment_image_src', array|false $image, int $attachment_id, string|int[] $size, bool $icon )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$image` | array\|false | `array( url, width, height, is_intermediate )` |
| `$attachment_id` | int | Attachment ID |
| `$size` | string\|int[] | Requested size |
| `$icon` | bool | Whether to use icon fallback |

---

### wp_get_attachment_image

Filters the complete img element HTML.

```php
apply_filters( 'wp_get_attachment_image', string $html, int $attachment_id, string|int[] $size, bool $icon, string[] $attr )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$html` | string | Complete `<img>` tag |
| `$attachment_id` | int | Attachment ID |
| `$size` | string\|int[] | Requested size |
| `$icon` | bool | Whether icon was used |
| `$attr` | string[] | Applied attributes |

---

### wp_get_attachment_image_attributes

Filters image attributes before rendering.

```php
apply_filters( 'wp_get_attachment_image_attributes', string[] $attr, WP_Post $attachment, string|int[] $size )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$attr` | string[] | Attribute key/value pairs |
| `$attachment` | WP_Post | Attachment post object |
| `$size` | string\|int[] | Requested size |

**Example:**

```php
add_filter( 'wp_get_attachment_image_attributes', function( $attr, $attachment, $size ) {
    $attr['data-id'] = $attachment->ID;
    return $attr;
}, 10, 3 );
```

---

### image_downsize

Pre-filters image downsize before default processing.

```php
apply_filters( 'image_downsize', bool|array $out, int $id, string|int[] $size )
```

Return truthy array to short-circuit: `array( url, width, height, is_intermediate )`.

---

### wp_calculate_image_srcset

Filters srcset sources.

```php
apply_filters( 'wp_calculate_image_srcset', array $sources, int[] $size_array, string $image_src, array $image_meta, int $attachment_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$sources` | array | Source arrays with `url`, `descriptor`, `value` |
| `$size_array` | int[] | Displayed size `array( width, height )` |
| `$image_src` | string | Base image URL |
| `$image_meta` | array | Attachment metadata |
| `$attachment_id` | int | Attachment ID |

**Example:**

```php
add_filter( 'wp_calculate_image_srcset', function( $sources, $size_array, $image_src ) {
    // Add CDN prefix to all sources
    foreach ( $sources as &$source ) {
        $source['url'] = 'https://cdn.example.com' . $source['url'];
    }
    return $sources;
}, 10, 3 );
```

---

### wp_calculate_image_sizes

Filters the sizes attribute value.

```php
apply_filters( 'wp_calculate_image_sizes', string $sizes, string|int[] $size, string|null $image_src, array|null $image_meta, int $attachment_id )
```

---

### wp_prepare_attachment_for_js

Filters attachment data for JavaScript.

```php
apply_filters( 'wp_prepare_attachment_for_js', array $response, WP_Post $attachment, array|false $meta )
```

Used by Media Library modal. Modify to add custom fields.

---

## Image Processing Filters

### wp_image_editors

Filters available image editor classes.

```php
apply_filters( 'wp_image_editors', string[] $editors )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$editors` | string[] | Class names in priority order |

Default: `array( 'WP_Image_Editor_Imagick', 'WP_Image_Editor_GD' )`

**Example:**

```php
// Force GD only
add_filter( 'wp_image_editors', function() {
    return array( 'WP_Image_Editor_GD' );
} );
```

---

### image_editor_output_format

Filters output format mapping for image conversion.

```php
apply_filters( 'image_editor_output_format', string[] $output_format, string $filename, string $mime_type )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$output_format` | string[] | Mime type mappings |
| `$filename` | string | Source filename |
| `$mime_type` | string | Source mime type |

Default converts HEIC/HEIF to JPEG:

```php
array(
    'image/heic'          => 'image/jpeg',
    'image/heif'          => 'image/jpeg',
    'image/heic-sequence' => 'image/jpeg',
    'image/heif-sequence' => 'image/jpeg',
)
```

**Example:**

```php
add_filter( 'image_editor_output_format', function( $formats ) {
    // Convert PNG to WebP
    $formats['image/png'] = 'image/webp';
    return $formats;
} );
```

---

### image_editor_default_mime_type

Filters the default output mime type.

```php
apply_filters( 'image_editor_default_mime_type', string $mime_type )
```

Default: `image/jpeg`

---

### wp_editor_set_quality

Filters image compression quality.

```php
apply_filters( 'wp_editor_set_quality', int $quality, string $mime_type, array $size )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$quality` | int | Quality 1-100 |
| `$mime_type` | string | Output mime type |
| `$size` | array | Image dimensions |

**Example:**

```php
add_filter( 'wp_editor_set_quality', function( $quality, $mime_type ) {
    if ( 'image/webp' === $mime_type ) {
        return 90;  // Higher quality for WebP
    }
    return $quality;
}, 10, 2 );
```

---

### jpeg_quality

Filters JPEG compression quality (legacy).

```php
apply_filters( 'jpeg_quality', int $quality, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$quality` | int | Quality 0-100 |
| `$context` | string | `image_resize` or `edit_image` |

---

### image_strip_meta

Filters whether to strip metadata on resize (Imagick only).

```php
apply_filters( 'image_strip_meta', bool $strip_meta )
```

Default: `true`

---

### image_save_progressive

Filters whether to save as progressive/interlaced image.

```php
apply_filters( 'image_save_progressive', bool $interlace, string $mime_type )
```

Default: `false`

---

### image_max_bit_depth

Filters maximum bit depth for resized images (Imagick only).

```php
apply_filters( 'image_max_bit_depth', int $max_depth, int $image_depth )
```

---

### image_make_intermediate_size

Filters the intermediate size filename.

```php
apply_filters( 'image_make_intermediate_size', string $filename )
```

---

### wp_image_maybe_exif_rotate

Filters EXIF orientation before auto-rotation.

```php
apply_filters( 'wp_image_maybe_exif_rotate', int $orientation, string $file )
```

Return `false` or `1` to prevent rotation.

---

## Loading Optimization Filters

### wp_lazy_loading_enabled

Filters whether lazy loading is enabled.

```php
apply_filters( 'wp_lazy_loading_enabled', bool $default, string $tag_name, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$default` | bool | Default enabled state |
| `$tag_name` | string | `img` or `iframe` |
| `$context` | string | Filter context |

---

### wp_img_tag_add_loading_attr

Filters the loading attribute value.

```php
apply_filters( 'wp_img_tag_add_loading_attr', string|bool $value, string $image, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | string\|bool | `lazy`, `eager`, or `false` |
| `$image` | string | The `<img>` tag HTML |
| `$context` | string | Filter context |

---

### wp_img_tag_add_decoding_attr

Filters the decoding attribute value.

```php
apply_filters( 'wp_img_tag_add_decoding_attr', string|false $value, string $image, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | string\|false | `async`, `sync`, `auto`, or `false` |

---

### wp_img_tag_add_width_and_height_attr

Filters whether to add width/height attributes.

```php
apply_filters( 'wp_img_tag_add_width_and_height_attr', bool $value, string $image, string $context, int $attachment_id )
```

---

### wp_img_tag_add_srcset_and_sizes_attr

Filters whether to add srcset/sizes attributes.

```php
apply_filters( 'wp_img_tag_add_srcset_and_sizes_attr', bool $value, string $image, string $context, int $attachment_id )
```

---

### wp_omit_loading_attr_threshold

Filters how many images skip lazy loading.

```php
apply_filters( 'wp_omit_loading_attr_threshold', int $threshold )
```

Default: `3` (first 3 content images not lazy-loaded)

---

### wp_min_priority_img_pixels

Filters minimum pixels for fetchpriority="high".

```php
apply_filters( 'wp_min_priority_img_pixels', int $threshold )
```

Default: `50000` (roughly 224×224 pixels)

---

### wp_get_loading_optimization_attributes

Filters all loading optimization attributes.

```php
apply_filters( 'wp_get_loading_optimization_attributes', array $loading_attrs, string $tag_name, array $attr, string $context )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$loading_attrs` | array | Attributes to add: `loading`, `fetchpriority`, `decoding` |
| `$tag_name` | string | `img` or `iframe` |
| `$attr` | array | Existing attributes |
| `$context` | string | Filter context |

---

### pre_wp_get_loading_optimization_attributes

Pre-filters to short-circuit optimization attributes.

```php
apply_filters( 'pre_wp_get_loading_optimization_attributes', array|false $loading_attrs, string $tag_name, array $attr, string $context )
```

Return array to bypass default logic.

---

## Content Filters

### wp_content_img_tag

Filters each img tag in post content.

```php
apply_filters( 'wp_content_img_tag', string $filtered_image, string $context, int $attachment_id )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$filtered_image` | string | Modified `<img>` HTML |
| `$context` | string | Current filter name |
| `$attachment_id` | int | Attachment ID (0 if unknown) |

---

### get_image_tag_class

Filters image CSS class in `get_image_tag()`.

```php
apply_filters( 'get_image_tag_class', string $class, int $id, string $align, string|int[] $size )
```

---

### get_image_tag

Filters complete img tag from `get_image_tag()`.

```php
apply_filters( 'get_image_tag', string $html, int $id, string $alt, string $title, string $align, string|int[] $size )
```

---

## Shortcode Filters

### post_gallery

Filters gallery shortcode output (pre-render).

```php
apply_filters( 'post_gallery', string $output, array $attr, int $instance )
```

Return non-empty string to replace default gallery.

---

### gallery_style

Filters gallery CSS and opening div.

```php
apply_filters( 'gallery_style', string $gallery_style )
```

---

### use_default_gallery_style

Filters whether to print default gallery CSS.

```php
apply_filters( 'use_default_gallery_style', bool $print )
```

---

### img_caption_shortcode

Filters caption shortcode output.

```php
apply_filters( 'img_caption_shortcode', string $output, array $attr, string $content )
```

---

### img_caption_shortcode_width

Filters caption container width.

```php
apply_filters( 'img_caption_shortcode_width', int $width, array $atts, string $content )
```

---

### wp_audio_shortcode_override

Pre-filters audio shortcode output.

```php
apply_filters( 'wp_audio_shortcode_override', string $html, array $attr, string $content, int $instance )
```

---

### wp_audio_shortcode

Filters final audio shortcode output.

```php
apply_filters( 'wp_audio_shortcode', string $html, array $atts, string $audio, int $post_id, string $library )
```

---

### wp_video_shortcode_override

Pre-filters video shortcode output.

```php
apply_filters( 'wp_video_shortcode_override', string $html, array $attr, string $content, int $instance )
```

---

### wp_video_shortcode

Filters final video shortcode output.

```php
apply_filters( 'wp_video_shortcode', string $output, array $atts, string $video, int $post_id, string $library )
```

---

### post_playlist

Pre-filters playlist shortcode output.

```php
apply_filters( 'post_playlist', string $output, array $attr, int $instance )
```

---

## Upload Filters

### upload_size_limit

Filters maximum upload size.

```php
apply_filters( 'upload_size_limit', int $size, int $u_bytes, int $p_bytes )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$size` | int | Calculated limit (bytes) |
| `$u_bytes` | int | `upload_max_filesize` value |
| `$p_bytes` | int | `post_max_size` value |

---

### plupload_default_settings

Filters Plupload JavaScript settings.

```php
apply_filters( 'plupload_default_settings', array $defaults )
```

---

### plupload_default_params

Filters Plupload upload parameters.

```php
apply_filters( 'plupload_default_params', array $params )
```

---

## Actions

### wp_enqueue_media

Fires after media scripts are enqueued.

```php
do_action( 'wp_enqueue_media' )
```

---

### print_media_templates

Fires when media modal templates are printed.

```php
do_action( 'print_media_templates' )
```

Use to add custom Backbone templates.

---

### wp_playlist_scripts

Fires when playlist scripts should be enqueued.

```php
do_action( 'wp_playlist_scripts', string $type, string $style )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$type` | string | `audio` or `video` |
| `$style` | string | `light` or `dark` |
