# WordPress Media API

Comprehensive system for managing media files including image manipulation, upload handling, and attachment management.

**Source:** `wp-includes/media.php`, `wp-includes/class-wp-image-editor.php`, `wp-includes/media-template.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Attachment retrieval, image sizing, shortcodes |
| [class-wp-image-editor.md](./class-wp-image-editor.md) | Image manipulation (resize, crop, rotate, flip) |
| [hooks.md](./hooks.md) | Actions and filters for media processing |

## Attachments

WordPress stores media files as the `attachment` post type. Key metadata:

| Meta Key | Description |
|----------|-------------|
| `_wp_attached_file` | Relative path from uploads directory |
| `_wp_attachment_metadata` | Serialized array with sizes, dimensions, EXIF |
| `_wp_attachment_image_alt` | Alt text for images |
| `_wp_attachment_context` | Usage context (e.g., `site-icon`) |

### Attachment Metadata Structure

```php
array(
    'width'      => 1920,           // Original width
    'height'     => 1080,           // Original height
    'file'       => '2024/01/image.jpg',  // Relative path
    'filesize'   => 245000,         // Bytes (since 6.0.0)
    'sizes'      => array(
        'thumbnail' => array(
            'file'      => 'image-150x150.jpg',
            'width'     => 150,
            'height'    => 150,
            'mime-type' => 'image/jpeg',
            'filesize'  => 5000,
        ),
        'medium' => array( ... ),
        'large'  => array( ... ),
    ),
    'image_meta' => array(          // EXIF/IPTC data
        'aperture'     => '2.8',
        'camera'       => 'Canon EOS R5',
        'caption'      => '',
        'copyright'    => '',
        'created_timestamp' => 1704067200,
        'credit'       => '',
        'focal_length' => '50',
        'iso'          => '100',
        'shutter_speed' => '0.001',
        'orientation'  => '1',
    ),
    'original_image' => 'original-image.jpg',  // If scaled down
)
```

## Image Sizes

### Default Sizes

| Size | Width | Height | Crop | Description |
|------|-------|--------|------|-------------|
| `thumbnail` | 150 | 150 | Yes | Small square crop |
| `medium` | 300 | 300 | No | Proportional scale |
| `medium_large` | 768 | 0 | No | Responsive breakpoint |
| `large` | 1024 | 1024 | No | Full content width |
| `1536x1536` | 1536 | 1536 | No | 2x medium_large |
| `2048x2048` | 2048 | 2048 | No | 2x large |
| `full` | — | — | No | Original dimensions |

### Registering Custom Sizes

```php
add_action( 'after_setup_theme', function() {
    // Simple size
    add_image_size( 'featured-thumb', 600, 400, true );
    
    // Proportional (height auto)
    add_image_size( 'wide-banner', 1200, 0, false );
    
    // Custom crop position
    add_image_size( 'hero', 1920, 600, array( 'center', 'top' ) );
    
    // Post thumbnail size
    set_post_thumbnail_size( 800, 600, true );
});
```

### Crop Positions

| X Position | Y Position |
|------------|------------|
| `left` | `top` |
| `center` | `center` |
| `right` | `bottom` |

## Upload Handling

### Upload Directory Structure

```
wp-content/uploads/
├── 2024/
│   ├── 01/
│   │   ├── image.jpg           # Original
│   │   ├── image-150x150.jpg   # thumbnail
│   │   ├── image-300x200.jpg   # medium
│   │   ├── image-768x512.jpg   # medium_large
│   │   └── image-1024x683.jpg  # large
│   └── 02/
└── sites/                       # Multisite
    └── 2/
```

### Getting Upload Info

```php
$upload_dir = wp_get_upload_dir();
// Returns:
array(
    'path'    => '/var/www/html/wp-content/uploads/2024/01',
    'url'     => 'https://example.com/wp-content/uploads/2024/01',
    'subdir'  => '/2024/01',
    'basedir' => '/var/www/html/wp-content/uploads',
    'baseurl' => 'https://example.com/wp-content/uploads',
    'error'   => false,
)
```

### Max Upload Size

```php
$max_size = wp_max_upload_size();  // Bytes (respects php.ini)
```

## Responsive Images

WordPress automatically adds `srcset` and `sizes` attributes to images.

### Generated Markup

```html
<img src="image-1024x683.jpg"
     srcset="image-300x200.jpg 300w,
             image-768x512.jpg 768w,
             image-1024x683.jpg 1024w,
             image-1536x1024.jpg 1536w,
             image-2048x1366.jpg 2048w"
     sizes="(max-width: 1024px) 100vw, 1024px"
     width="1024"
     height="683"
     loading="lazy"
     decoding="async"
     alt="Description">
```

### Loading Optimization (Since 5.9.0)

| Attribute | Value | Applied When |
|-----------|-------|--------------|
| `loading` | `lazy` | Below-the-fold images |
| `fetchpriority` | `high` | First large image in viewport |
| `decoding` | `async` | All images |

## Image Editor Selection

WordPress selects the best available image editor:

```php
$editors = apply_filters( 'wp_image_editors', array(
    'WP_Image_Editor_Imagick',  // Preferred (better quality)
    'WP_Image_Editor_GD',       // Fallback
) );
```

### Checking Editor Support

```php
// Check if any editor supports a mime type
if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
    // WebP is supported
}

// Check for specific methods
if ( wp_image_editor_supports( array( 'methods' => array( 'rotate' ) ) ) ) {
    // Rotation is available
}
```

## Supported Formats

| Format | GD | Imagick | Notes |
|--------|-----|---------|-------|
| JPEG | ✓ | ✓ | Universal support |
| PNG | ✓ | ✓ | Transparency preserved |
| GIF | ✓ | ✓ | Animation flattened on resize |
| WebP | ✓* | ✓* | PHP 7.0+ with extension |
| AVIF | ✓* | ✓* | PHP 8.1+ with extension |
| HEIC/HEIF | ✗ | ✓* | Converted to JPEG on upload |

*Requires library support

## Media Templates

JavaScript templates for the Media Library modal are printed via `wp_print_media_templates()`:

| Template ID | Purpose |
|-------------|---------|
| `tmpl-media-frame` | Main frame layout |
| `tmpl-media-modal` | Modal wrapper |
| `tmpl-attachment` | Grid item |
| `tmpl-attachment-details` | Sidebar details |
| `tmpl-attachment-details-two-column` | Edit view |
| `tmpl-uploader-inline` | Upload dropzone |
| `tmpl-gallery-settings` | Gallery configuration |

## Common Patterns

### Get Featured Image URL

```php
$url = get_the_post_thumbnail_url( $post_id, 'large' );
```

### Display Attachment Image

```php
echo wp_get_attachment_image( $attachment_id, 'medium', false, array(
    'class' => 'custom-class',
    'alt'   => 'Custom alt text',
) );
```

### Process Uploaded Image

```php
$editor = wp_get_image_editor( $file_path );
if ( ! is_wp_error( $editor ) ) {
    $editor->resize( 800, 600, true );
    $editor->set_quality( 85 );
    $editor->save( $destination_path );
}
```

### Convert URL to Attachment ID

```php
$attachment_id = attachment_url_to_postid( $url );
```
