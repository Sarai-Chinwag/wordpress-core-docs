# Image Editing API

WordPress provides a built-in image editor for cropping, rotating, flipping, and scaling images. The API can be used programmatically and integrates with the media library.

## WP_Image_Editor Class

The base class for image manipulation. WordPress uses GD or Imagick depending on server configuration.

### Getting an Editor Instance

```php
$editor = wp_get_image_editor( $file_path );

if ( is_wp_error( $editor ) ) {
    // Handle error - no editor available
    echo $editor->get_error_message();
} else {
    // Use the editor
}
```

### Checking Editor Support

```php
// Check if specific features are supported
$supports = wp_image_editor_supports( array(
    'mime_type' => 'image/png',
    'methods'   => array( 'resize', 'rotate' ),
) );

if ( $supports ) {
    // Proceed with operation
}
```

## Core Image Operations

### Resize

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    // Resize to max 800x600, maintaining aspect ratio
    $result = $editor->resize( 800, 600, false );
    
    if ( ! is_wp_error( $result ) ) {
        $saved = $editor->save( '/path/to/resized.jpg' );
    }
}
```

**Parameters:**

```php
$editor->resize(
    int  $max_w,      // Maximum width
    int  $max_h,      // Maximum height
    bool $crop = false // Whether to crop (true) or resize (false)
);
```

### Crop

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    // Crop 200x200 from position 50,50
    $result = $editor->crop( 50, 50, 200, 200 );
    
    if ( ! is_wp_error( $result ) ) {
        $saved = $editor->save( '/path/to/cropped.jpg' );
    }
}
```

**Parameters:**

```php
$editor->crop(
    int $src_x,        // Source X position
    int $src_y,        // Source Y position
    int $src_w,        // Source width
    int $src_h,        // Source height
    int $dst_w = null, // Destination width (optional)
    int $dst_h = null  // Destination height (optional)
);
```

### Rotate

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    // Rotate 90 degrees clockwise
    $result = $editor->rotate( -90 );
    
    if ( ! is_wp_error( $result ) ) {
        $saved = $editor->save( '/path/to/rotated.jpg' );
    }
}
```

### Flip

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    // Flip horizontally
    $result = $editor->flip( true, false );
    
    // Flip vertically
    $result = $editor->flip( false, true );
    
    // Both
    $result = $editor->flip( true, true );
}
```

### Multi-Size Generation

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    $sizes = array(
        'thumbnail' => array(
            'width'  => 150,
            'height' => 150,
            'crop'   => true,
        ),
        'medium' => array(
            'width'  => 300,
            'height' => 300,
            'crop'   => false,
        ),
        'large' => array(
            'width'  => 1024,
            'height' => 1024,
            'crop'   => false,
        ),
    );
    
    $result = $editor->multi_resize( $sizes );
    
    // Returns array of generated files
    /*
    array(
        'thumbnail' => array(
            'file'      => 'image-150x150.jpg',
            'width'     => 150,
            'height'    => 150,
            'mime-type' => 'image/jpeg',
        ),
        ...
    )
    */
}
```

## Image Quality

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( ! is_wp_error( $editor ) ) {
    // Set quality (1-100)
    $editor->set_quality( 85 );
    
    // Save with new quality
    $editor->save( '/path/to/output.jpg' );
}
```

### Filter Default Quality

```php
add_filter( 'jpeg_quality', function( $quality ) {
    return 90;
} );

add_filter( 'wp_editor_set_quality', function( $quality, $mime_type ) {
    if ( 'image/webp' === $mime_type ) {
        return 85;
    }
    return $quality;
}, 10, 2 );
```

## Attachment Image Editing

### wp_save_image()

Save edited image from the media library editor.

```php
// Called via AJAX in media library
$result = wp_save_image( $attachment_id );
```

### wp_image_editor()

Render the image editor interface.

```php
wp_image_editor( $post_id, $msg = false );
```

### Image Edit Actions (AJAX)

WordPress handles these via AJAX:

| Action | Function |
|--------|----------|
| `image-editor` | `wp_ajax_image_editor()` |
| `imgedit-preview` | Preview edited image |
| `edit-attachment` | Apply edits |

## Programmatic Attachment Editing

### Update Attachment After Editing

```php
function programmatic_image_edit( $attachment_id ) {
    $file = get_attached_file( $attachment_id );
    
    if ( ! $file ) {
        return new WP_Error( 'no_file', 'Attachment file not found' );
    }
    
    $editor = wp_get_image_editor( $file );
    
    if ( is_wp_error( $editor ) ) {
        return $editor;
    }
    
    // Make edits
    $editor->rotate( 90 );
    $editor->resize( 800, 800 );
    
    // Save back to original file
    $saved = $editor->save( $file );
    
    if ( is_wp_error( $saved ) ) {
        return $saved;
    }
    
    // Regenerate metadata (thumbnails, etc.)
    $metadata = wp_generate_attachment_metadata( $attachment_id, $file );
    wp_update_attachment_metadata( $attachment_id, $metadata );
    
    return true;
}
```

### Regenerate Thumbnails

```php
function regenerate_thumbnails( $attachment_id ) {
    $file = get_attached_file( $attachment_id );
    
    if ( ! $file ) {
        return false;
    }
    
    // Delete old sizes
    $old_metadata = wp_get_attachment_metadata( $attachment_id );
    
    if ( isset( $old_metadata['sizes'] ) ) {
        $upload_dir = wp_upload_dir();
        $base_dir   = trailingslashit( dirname( $file ) );
        
        foreach ( $old_metadata['sizes'] as $size ) {
            @unlink( $base_dir . $size['file'] );
        }
    }
    
    // Generate new sizes
    require_once ABSPATH . 'wp-admin/includes/image.php';
    
    $metadata = wp_generate_attachment_metadata( $attachment_id, $file );
    wp_update_attachment_metadata( $attachment_id, $metadata );
    
    return true;
}
```

## Image Metadata Functions

### wp_read_image_metadata()

Extract EXIF/IPTC data from an image.

```php
$meta = wp_read_image_metadata( '/path/to/image.jpg' );

/*
array(
    'aperture'          => '2.8',
    'credit'            => 'Photographer Name',
    'camera'            => 'Canon EOS 5D',
    'caption'           => 'Image caption',
    'created_timestamp' => 1234567890,
    'copyright'         => '© 2024',
    'focal_length'      => '50',
    'iso'               => '100',
    'shutter_speed'     => '0.004',
    'title'             => 'Image Title',
    'orientation'       => '1',
    'keywords'          => array( 'tag1', 'tag2' ),
)
*/
```

### wp_get_attachment_metadata()

Get attachment metadata including sizes.

```php
$metadata = wp_get_attachment_metadata( $attachment_id );

/*
array(
    'width'      => 1920,
    'height'     => 1080,
    'file'       => '2024/01/image.jpg',
    'filesize'   => 245678,
    'sizes'      => array(
        'thumbnail' => array(
            'file'      => 'image-150x150.jpg',
            'width'     => 150,
            'height'    => 150,
            'mime-type' => 'image/jpeg',
            'filesize'  => 12345,
        ),
        // ... other sizes
    ),
    'image_meta' => array( ... ),
)
*/
```

## Image Size Registration

### add_image_size()

Register custom image sizes.

```php
add_action( 'after_setup_theme', 'register_custom_sizes' );

function register_custom_sizes() {
    // Hard crop (centered)
    add_image_size( 'custom-square', 400, 400, true );
    
    // Soft resize (proportional)
    add_image_size( 'custom-large', 800, 600, false );
    
    // Custom crop position (left, top)
    add_image_size( 'custom-crop', 400, 300, array( 'left', 'top' ) );
}
```

### get_intermediate_image_sizes()

Get all registered image sizes.

```php
$sizes = get_intermediate_image_sizes();
// array( 'thumbnail', 'medium', 'medium_large', 'large', 'custom-square', ... )
```

## Editor Implementation Classes

### WP_Image_Editor_GD

GD library implementation (default fallback).

### WP_Image_Editor_Imagick

ImageMagick implementation (preferred when available).

### Checking Available Editors

```php
// Get list of available editors
$editors = _wp_image_editor_choose();
// Returns class name like 'WP_Image_Editor_Imagick'

// Check what the image will use
$editor = wp_get_image_editor( $file );
echo get_class( $editor ); // WP_Image_Editor_Imagick or WP_Image_Editor_GD
```

## Hooks

| Hook | Description |
|------|-------------|
| `wp_image_editors` | Filter available editor classes |
| `image_editor_save_pre` | Before saving edited image |
| `wp_save_image_editor_file` | Override image save |
| `wp_save_image_file` | After saving image file |
| `jpeg_quality` | Filter JPEG quality |
| `wp_editor_set_quality` | Filter any image quality |
| `image_make_intermediate_size` | After making intermediate size |

## Error Handling

```php
$editor = wp_get_image_editor( $file );

if ( is_wp_error( $editor ) ) {
    switch ( $editor->get_error_code() ) {
        case 'error_loading_image':
            // Could not load image
            break;
        case 'image_size_unsupported':
            // Image too large
            break;
        case 'error_getting_dimensions':
            // Could not read dimensions
            break;
    }
}
```

## Complete Example: Image Processing Pipeline

```php
function process_uploaded_image( $attachment_id ) {
    $file = get_attached_file( $attachment_id );
    
    if ( ! $file || ! file_exists( $file ) ) {
        return new WP_Error( 'no_file', 'File not found' );
    }
    
    $editor = wp_get_image_editor( $file );
    
    if ( is_wp_error( $editor ) ) {
        return $editor;
    }
    
    // Get original dimensions
    $size = $editor->get_size();
    
    // Auto-rotate based on EXIF
    $meta = wp_read_image_metadata( $file );
    if ( isset( $meta['orientation'] ) ) {
        switch ( $meta['orientation'] ) {
            case 3:
                $editor->rotate( 180 );
                break;
            case 6:
                $editor->rotate( -90 );
                break;
            case 8:
                $editor->rotate( 90 );
                break;
        }
    }
    
    // Limit max dimensions
    $max_dim = 2048;
    if ( $size['width'] > $max_dim || $size['height'] > $max_dim ) {
        $editor->resize( $max_dim, $max_dim, false );
    }
    
    // Set quality
    $editor->set_quality( 85 );
    
    // Save
    $saved = $editor->save( $file );
    
    if ( is_wp_error( $saved ) ) {
        return $saved;
    }
    
    // Regenerate metadata
    require_once ABSPATH . 'wp-admin/includes/image.php';
    
    $metadata = wp_generate_attachment_metadata( $attachment_id, $file );
    wp_update_attachment_metadata( $attachment_id, $metadata );
    
    return true;
}
```
