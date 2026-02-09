# WP_Image_Editor Classes

Abstract base class and implementations for image manipulation in WordPress.

**Source:** `wp-includes/class-wp-image-editor.php`, `wp-includes/class-wp-image-editor-gd.php`, `wp-includes/class-wp-image-editor-imagick.php`

---

## Class Hierarchy

```
WP_Image_Editor (abstract)
├── WP_Image_Editor_GD        (GD library implementation)
└── WP_Image_Editor_Imagick   (ImageMagick implementation)
```

## Getting an Editor Instance

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );

if ( is_wp_error( $editor ) ) {
    // Handle error: no suitable editor available
    $error_message = $editor->get_error_message();
} else {
    // Use the editor
    $editor->resize( 800, 600 );
}
```

---

## WP_Image_Editor (Base Class)

### Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$file` | string | null | Path to the loaded file |
| `$size` | array | null | `array( 'width' => int, 'height' => int )` |
| `$mime_type` | string | null | Source image mime type |
| `$output_mime_type` | string | null | Output mime type (if different) |
| `$default_mime_type` | string | `image/jpeg` | Fallback mime type |
| `$quality` | int\|false | false | Compression quality (1-100) |
| `$default_quality` | int | 82 | Default JPEG quality |

---

## Static Methods

### test()

Checks if the current environment supports this editor.

```php
static test( array $args = array() ): bool
```

Override in subclass. Returns `false` by default.

---

### supports_mime_type()

Checks if the editor supports a specific mime type.

```php
static supports_mime_type( string $mime_type ): bool
```

#### Example

```php
if ( WP_Image_Editor_Imagick::supports_mime_type( 'image/webp' ) ) {
    // Imagick can handle WebP
}
```

---

## Instance Methods

### load()

Loads image from file into editor memory.

```php
load(): true|WP_Error
```

Must be called before any manipulation. Called automatically by `wp_get_image_editor()`.

---

### save()

Saves current image to file.

```php
save( string $destfilename = null, string $mime_type = null ): array|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$destfilename` | string | Destination path (null = auto-generate) |
| `$mime_type` | string | Output format (null = same as source) |

#### Returns

```php
array(
    'path'      => '/path/to/saved-image.jpg',
    'file'      => 'saved-image.jpg',
    'width'     => 800,
    'height'    => 600,
    'mime-type' => 'image/jpeg',
    'filesize'  => 45000,  // Since 6.0.0
)
```

#### Example

```php
$editor = wp_get_image_editor( '/path/to/image.png' );
$editor->resize( 800, 600 );

// Save as JPEG
$result = $editor->save( '/path/to/output.jpg', 'image/jpeg' );

// Auto-generate filename with suffix
$result = $editor->save( null, null );  // Creates image-800x600.png
```

---

### resize()

Resizes the image to fit within dimensions.

```php
resize( int|null $max_w, int|null $max_h, bool|array $crop = false ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$max_w` | int\|null | Maximum width (null = no constraint) |
| `$max_h` | int\|null | Maximum height (null = no constraint) |
| `$crop` | bool\|array | Crop behavior |

#### Crop Values

| Value | Behavior |
|-------|----------|
| `false` | Scale proportionally to fit within bounds |
| `true` | Crop to exact dimensions from center |
| `array( 'left', 'top' )` | Crop from specific position |

#### Example

```php
$editor = wp_get_image_editor( $file );

// Proportional resize (fit within 800x600)
$editor->resize( 800, 600, false );

// Center crop to exact 400x400
$editor->resize( 400, 400, true );

// Crop from top-left corner
$editor->resize( 400, 300, array( 'left', 'top' ) );

// Resize width only, maintain aspect ratio
$editor->resize( 800, null );
```

---

### multi_resize()

Creates multiple resized versions from a single load.

```php
multi_resize( array $sizes ): array
```

#### Parameters

```php
$sizes = array(
    'thumbnail' => array( 'width' => 150, 'height' => 150, 'crop' => true ),
    'medium'    => array( 'width' => 300, 'height' => 300, 'crop' => false ),
    'large'     => array( 'width' => 1024, 'height' => 1024, 'crop' => false ),
);
```

#### Returns

Array of metadata by size name:

```php
array(
    'thumbnail' => array(
        'file'      => 'image-150x150.jpg',
        'width'     => 150,
        'height'    => 150,
        'mime-type' => 'image/jpeg',
        'filesize'  => 5000,
    ),
    'medium' => array( ... ),
    'large'  => array( ... ),
)
```

---

### crop()

Crops a region from the image.

```php
crop( int $src_x, int $src_y, int $src_w, int $src_h, int $dst_w = null, int $dst_h = null, bool $src_abs = false ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$src_x` | int | Source X position |
| `$src_y` | int | Source Y position |
| `$src_w` | int | Width to crop |
| `$src_h` | int | Height to crop |
| `$dst_w` | int | Destination width (scales crop) |
| `$dst_h` | int | Destination height (scales crop) |
| `$src_abs` | bool | If true, `$src_w`/`$src_h` are absolute end coordinates |

#### Example

```php
$editor = wp_get_image_editor( $file );

// Crop 400x300 region starting at (100, 50)
$editor->crop( 100, 50, 400, 300 );

// Crop and scale to 200x150
$editor->crop( 100, 50, 400, 300, 200, 150 );

// Using absolute coordinates (crop from 100,50 to 500,350)
$editor->crop( 100, 50, 500, 350, null, null, true );
```

---

### rotate()

Rotates the image counter-clockwise.

```php
rotate( float $angle ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$angle` | float | Rotation angle in degrees |

#### Example

```php
$editor = wp_get_image_editor( $file );

// Rotate 90° counter-clockwise (same as 270° clockwise)
$editor->rotate( 90 );

// Rotate 180°
$editor->rotate( 180 );
```

**Note:** Requires `imagerotate()` function in GD. Check with:

```php
wp_image_editor_supports( array( 'methods' => array( 'rotate' ) ) )
```

---

### flip()

Flips the image along an axis.

```php
flip( bool $horz, bool $vert ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$horz` | bool | Flip along horizontal axis (upside down) |
| `$vert` | bool | Flip along vertical axis (mirror) |

#### Example

```php
$editor = wp_get_image_editor( $file );

// Mirror horizontally
$editor->flip( false, true );

// Flip upside down
$editor->flip( true, false );

// Both (180° rotation)
$editor->flip( true, true );
```

---

### stream()

Outputs the image directly to browser.

```php
stream( string $mime_type = null ): true|WP_Error
```

#### Example

```php
$editor = wp_get_image_editor( $file );
$editor->resize( 800, 600 );

header( 'Content-Type: image/jpeg' );
$editor->stream( 'image/jpeg' );
exit;
```

---

### get_size()

Returns current image dimensions.

```php
get_size(): int[]
```

#### Returns

```php
array(
    'width'  => 800,
    'height' => 600,
)
```

---

### set_quality()

Sets compression quality for output.

```php
set_quality( int $quality = null, array $dims = array() ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$quality` | int | Quality 1-100 (null = default) |
| `$dims` | array | Optional dimensions for quality filtering |

#### Default Quality

| Format | Default |
|--------|---------|
| JPEG | 82 |
| WebP | 86 |

#### Example

```php
$editor = wp_get_image_editor( $file );
$editor->set_quality( 90 );  // High quality
$editor->save( $output, 'image/jpeg' );
```

---

### get_quality()

Returns current quality setting.

```php
get_quality(): int
```

---

### maybe_exif_rotate()

Automatically corrects image orientation based on EXIF data.

```php
maybe_exif_rotate(): bool|WP_Error
```

Called automatically during upload processing. Handles EXIF orientation values 1-8.

---

### generate_filename()

Generates output filename with size suffix.

```php
generate_filename( string $suffix = null, string $dest_path = null, string $extension = null ): string
```

#### Example

```php
$editor = wp_get_image_editor( '/uploads/image.jpg' );
$editor->resize( 800, 600 );

$filename = $editor->generate_filename();
// '/uploads/image-800x600.jpg'

$filename = $editor->generate_filename( 'thumb', '/custom/path/', 'png' );
// '/custom/path/image-thumb.png'
```

---

### get_suffix()

Returns dimension-based suffix for current size.

```php
get_suffix(): string|false
```

#### Example

```php
$editor = wp_get_image_editor( $file );
$editor->resize( 800, 600 );
echo $editor->get_suffix();  // '800x600'
```

---

## WP_Image_Editor_GD

GD library implementation. Uses PHP's built-in GD extension.

### Additional Support

- Basic image operations
- PNG transparency preservation
- WebP support (PHP 7.0+ with GD compiled for WebP)
- AVIF support (PHP 8.1+ with GD compiled for AVIF)

### GD-Specific Behavior

- Uses `imagecopyresampled()` for resizing
- Handles WebP lossless quality via `IMG_WEBP_LOSSLESS` constant
- Preserves alpha channel for PNG/WebP

---

## WP_Image_Editor_Imagick

ImageMagick implementation. Preferred when available due to better quality.

### Additional Features

- Better color management
- PDF rendering (first page → image)
- Metadata stripping on resize (configurable)
- Efficient resampling with FILTER_TRIANGLE
- HEIC/HEIF support
- Better indexed PNG handling

### Imagick-Specific Methods

#### thumbnail_image()

Efficiently resizes with optional metadata stripping.

```php
protected thumbnail_image( int $dst_w, int $dst_h, string $filter_name = 'FILTER_TRIANGLE', bool $strip_meta = true ): void|WP_Error
```

#### Supported Filters

- `FILTER_POINT`, `FILTER_BOX`
- `FILTER_TRIANGLE` (default)
- `FILTER_HERMITE`, `FILTER_HANNING`, `FILTER_HAMMING`
- `FILTER_BLACKMAN`, `FILTER_GAUSSIAN`
- `FILTER_QUADRATIC`, `FILTER_CUBIC`
- `FILTER_CATROM`, `FILTER_MITCHELL`
- `FILTER_LANCZOS`, `FILTER_BESSEL`, `FILTER_SINC`

---

## Common Patterns

### Batch Processing

```php
$files = array( '/path/to/image1.jpg', '/path/to/image2.jpg' );
$sizes = array(
    'thumb' => array( 'width' => 150, 'height' => 150, 'crop' => true ),
    'large' => array( 'width' => 1024, 'height' => 1024, 'crop' => false ),
);

foreach ( $files as $file ) {
    $editor = wp_get_image_editor( $file );
    if ( ! is_wp_error( $editor ) ) {
        $metadata = $editor->multi_resize( $sizes );
        // Save metadata...
    }
}
```

### Format Conversion

```php
$editor = wp_get_image_editor( '/path/to/image.png' );
if ( ! is_wp_error( $editor ) ) {
    $editor->set_quality( 85 );
    $editor->save( '/path/to/image.jpg', 'image/jpeg' );
}
```

### Watermarking (Imagick only)

```php
$editor = wp_get_image_editor( $file );
if ( $editor instanceof WP_Image_Editor_Imagick ) {
    $image = $editor->image;  // Access Imagick object
    
    $watermark = new Imagick( '/path/to/watermark.png' );
    $image->compositeImage( $watermark, Imagick::COMPOSITE_OVER, 10, 10 );
    
    $editor->save( $output );
}
```

### Check Specific Editor Availability

```php
// Check if Imagick is available
if ( class_exists( 'Imagick' ) && WP_Image_Editor_Imagick::test() ) {
    // Imagick is available
}

// Force specific editor (not recommended)
add_filter( 'wp_image_editors', function( $editors ) {
    return array( 'WP_Image_Editor_Imagick' );
} );
```

---

## Error Handling

Common WP_Error codes:

| Code | Description |
|------|-------------|
| `error_loading_image` | File doesn't exist or unreadable |
| `invalid_image` | File is not a valid image |
| `image_resize_error` | Resize operation failed |
| `image_crop_error` | Crop operation failed |
| `image_rotate_error` | Rotation failed (GD may lack support) |
| `image_flip_error` | Flip operation failed |
| `image_save_error` | Could not save output file |
| `image_no_editor` | No suitable editor available |

```php
$editor = wp_get_image_editor( $file );

if ( is_wp_error( $editor ) ) {
    $code = $editor->get_error_code();
    $message = $editor->get_error_message();
    error_log( "Image editor error [{$code}]: {$message}" );
}
```
