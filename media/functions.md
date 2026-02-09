# Media API Functions

Core functions for attachment retrieval, image sizing, and media output.

**Source:** `wp-includes/media.php`

---

## Attachment Retrieval

### wp_get_attachment_image()

Returns an HTML `<img>` element for an attachment.

```php
wp_get_attachment_image( int $attachment_id, string|int[] $size = 'thumbnail', bool $icon = false, string|array $attr = '' ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$attachment_id` | int | Attachment post ID |
| `$size` | string\|int[] | Size name or `array( width, height )` |
| `$icon` | bool | Use mime type icon if no image |
| `$attr` | string\|array | Additional attributes |

#### Attributes

| Key | Type | Description |
|-----|------|-------------|
| `src` | string | Override image URL |
| `class` | string | CSS classes |
| `alt` | string | Alt text |
| `srcset` | string | Responsive sources |
| `sizes` | string | Responsive sizes |
| `loading` | string\|false | `lazy`, `eager`, or `false` to omit |
| `decoding` | string | `async`, `sync`, or `auto` |
| `fetchpriority` | string | `high`, `low`, or `auto` |

#### Example

```php
echo wp_get_attachment_image( 123, 'medium', false, array(
    'class' => 'featured-image',
    'alt'   => 'Featured product image',
    'loading' => 'eager',
) );
```

---

### wp_get_attachment_image_src()

Returns an array of image data for a size.

```php
wp_get_attachment_image_src( int $attachment_id, string|int[] $size = 'thumbnail', bool $icon = false ): array|false
```

#### Returns

```php
array(
    0 => 'https://example.com/image-300x200.jpg',  // URL
    1 => 300,   // Width
    2 => 200,   // Height
    3 => true,  // Is resized (not full size)
)
```

---

### wp_get_attachment_image_url()

Returns just the URL for an attachment size.

```php
wp_get_attachment_image_url( int $attachment_id, string|int[] $size = 'thumbnail', bool $icon = false ): string|false
```

#### Example

```php
$url = wp_get_attachment_image_url( 123, 'large' );
// 'https://example.com/wp-content/uploads/2024/01/image-1024x683.jpg'
```

---

### wp_get_attachment_url()

Returns the URL for the original attachment file.

```php
wp_get_attachment_url( int $attachment_id ): string|false
```

---

### wp_get_attachment_metadata()

Retrieves attachment metadata array.

```php
wp_get_attachment_metadata( int $attachment_id, bool $unfiltered = false ): array|false
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$attachment_id` | int | Attachment ID |
| `$unfiltered` | bool | Skip `wp_get_attachment_metadata` filter |

---

### get_attached_file()

Returns the absolute server path to an attachment.

```php
get_attached_file( int $attachment_id, bool $unfiltered = false ): string|false
```

#### Example

```php
$path = get_attached_file( 123 );
// '/var/www/html/wp-content/uploads/2024/01/image.jpg'
```

---

### wp_attachment_is_image()

Checks if an attachment is an image.

```php
wp_attachment_is_image( int|WP_Post $post = null ): bool
```

---

### wp_attachment_is()

Checks if an attachment is a specific type.

```php
wp_attachment_is( string $type, int|WP_Post $post = null ): bool
```

#### Example

```php
if ( wp_attachment_is( 'video', $attachment_id ) ) {
    // Handle video
}
// Types: 'image', 'video', 'audio', 'pdf'
```

---

## Image Sizing

### add_image_size()

Registers a new image size.

```php
add_image_size( string $name, int $width = 0, int $height = 0, bool|array $crop = false ): void
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Size identifier |
| `$width` | int | Max width in pixels (0 = no limit) |
| `$height` | int | Max height in pixels (0 = no limit) |
| `$crop` | bool\|array | Crop behavior |

#### Crop Values

| Value | Behavior |
|-------|----------|
| `false` | Proportional resize |
| `true` | Center crop |
| `array( 'left', 'top' )` | Crop from position |

#### Example

```php
add_action( 'after_setup_theme', function() {
    add_image_size( 'hero-banner', 1920, 600, array( 'center', 'center' ) );
    add_image_size( 'card-thumb', 400, 300, true );
});
```

---

### has_image_size()

Checks if a custom image size exists.

```php
has_image_size( string $name ): bool
```

---

### remove_image_size()

Removes a registered image size.

```php
remove_image_size( string $name ): bool
```

---

### set_post_thumbnail_size()

Sets dimensions for the `post-thumbnail` size.

```php
set_post_thumbnail_size( int $width = 0, int $height = 0, bool|array $crop = false ): void
```

---

### get_intermediate_image_sizes()

Returns all registered size names.

```php
get_intermediate_image_sizes(): string[]
```

#### Returns

```php
array( 'thumbnail', 'medium', 'medium_large', 'large', 'custom-size' )
```

---

### wp_get_registered_image_subsizes()

Returns all sizes with their dimensions.

```php
wp_get_registered_image_subsizes(): array[]
```

#### Returns

```php
array(
    'thumbnail' => array( 'width' => 150, 'height' => 150, 'crop' => true ),
    'medium'    => array( 'width' => 300, 'height' => 300, 'crop' => false ),
    // ...
)
```

---

### image_get_intermediate_size()

Gets data for a specific intermediate size.

```php
image_get_intermediate_size( int $post_id, string|int[] $size = 'thumbnail' ): array|false
```

#### Returns

```php
array(
    'file'   => 'image-300x200.jpg',
    'width'  => 300,
    'height' => 200,
    'path'   => '2024/01/image-300x200.jpg',
    'url'    => 'https://example.com/wp-content/uploads/2024/01/image-300x200.jpg',
)
```

---

## Dimension Calculations

### wp_constrain_dimensions()

Calculates dimensions to fit within max bounds.

```php
wp_constrain_dimensions( int $current_width, int $current_height, int $max_width = 0, int $max_height = 0 ): int[]
```

#### Example

```php
list( $w, $h ) = wp_constrain_dimensions( 1920, 1080, 800, 600 );
// $w = 800, $h = 450 (maintains aspect ratio)
```

---

### image_resize_dimensions()

Calculates resize dimensions for cropping.

```php
image_resize_dimensions( int $orig_w, int $orig_h, int $dest_w, int $dest_h, bool|array $crop = false ): array|false
```

#### Returns

Array matching `imagecopyresampled()` parameters:

```php
array( $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h )
```

---

### wp_image_matches_ratio()

Checks if two images have matching aspect ratios.

```php
wp_image_matches_ratio( int $source_width, int $source_height, int $target_width, int $target_height ): bool
```

---

## Responsive Images

### wp_get_attachment_image_srcset()

Gets the `srcset` attribute value for an attachment.

```php
wp_get_attachment_image_srcset( int $attachment_id, string|int[] $size = 'medium', array $image_meta = null ): string|false
```

#### Example

```php
$srcset = wp_get_attachment_image_srcset( 123, 'medium' );
// 'image-300x200.jpg 300w, image-768x512.jpg 768w, image-1024x683.jpg 1024w'
```

---

### wp_calculate_image_srcset()

Calculates srcset sources from image metadata.

```php
wp_calculate_image_srcset( int[] $size_array, string $image_src, array $image_meta, int $attachment_id = 0 ): string|false
```

---

### wp_get_attachment_image_sizes()

Gets the `sizes` attribute value for an attachment.

```php
wp_get_attachment_image_sizes( int $attachment_id, string|int[] $size = 'medium', array $image_meta = null ): string|false
```

---

### wp_calculate_image_sizes()

Calculates the sizes attribute value.

```php
wp_calculate_image_sizes( string|int[] $size, string $image_src = null, array $image_meta = null, int $attachment_id = 0 ): string|false
```

---

## Image Processing

### wp_get_image_editor()

Returns a WP_Image_Editor instance for a file.

```php
wp_get_image_editor( string $path, array $args = array() ): WP_Image_Editor|WP_Error
```

#### Example

```php
$editor = wp_get_image_editor( '/path/to/image.jpg' );
if ( ! is_wp_error( $editor ) ) {
    $editor->resize( 800, 600, true );
    $editor->rotate( 90 );
    $editor->save( '/path/to/output.jpg' );
}
```

---

### wp_image_editor_supports()

Checks if any editor supports given requirements.

```php
wp_image_editor_supports( string|array $args = array() ): bool
```

#### Example

```php
// Check mime type support
if ( wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) ) ) {
    // WebP editing available
}

// Check method support
if ( wp_image_editor_supports( array( 'methods' => array( 'rotate', 'flip' ) ) ) ) {
    // Rotation and flipping available
}
```

---

### image_make_intermediate_size()

Creates a resized image file.

```php
image_make_intermediate_size( string $file, int $width, int $height, bool|array $crop = false ): array|false
```

#### Returns

```php
array(
    'file'      => 'image-300x200.jpg',
    'width'     => 300,
    'height'    => 200,
    'mime-type' => 'image/jpeg',
    'filesize'  => 15000,
)
```

---

## Content Filtering

### wp_filter_content_tags()

Processes img/iframe tags in content for optimization.

```php
wp_filter_content_tags( string $content, string $context = null ): string
```

Adds:
- `srcset` and `sizes` attributes
- `loading="lazy"` for below-fold images
- `fetchpriority="high"` for first large image
- `decoding="async"` to images

---

### wp_img_tag_add_loading_optimization_attrs()

Adds loading optimization attributes to an img tag.

```php
wp_img_tag_add_loading_optimization_attrs( string $image, string $context ): string
```

---

### wp_lazy_loading_enabled()

Checks if lazy loading is enabled for a tag type.

```php
wp_lazy_loading_enabled( string $tag_name, string $context ): bool
```

---

## Shortcodes

### gallery_shortcode()

Outputs the `[gallery]` shortcode.

```php
gallery_shortcode( array $attr ): string
```

#### Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `ids` | string | — | Comma-separated attachment IDs |
| `columns` | int | 3 | Number of columns |
| `size` | string | `thumbnail` | Image size |
| `link` | string | — | Link target: `file`, `none`, or attachment page |
| `orderby` | string | `menu_order ID` | Sort field |
| `order` | string | `ASC` | Sort order |

---

### wp_audio_shortcode()

Outputs the `[audio]` shortcode.

```php
wp_audio_shortcode( array $attr, string $content = '' ): string|void
```

#### Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `src` | string | — | Audio file URL |
| `loop` | bool | false | Loop playback |
| `autoplay` | bool | false | Auto-start |
| `preload` | string | `none` | `none`, `metadata`, `auto` |

---

### wp_video_shortcode()

Outputs the `[video]` shortcode.

```php
wp_video_shortcode( array $attr, string $content = '' ): string|void
```

#### Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `src` | string | — | Video file URL |
| `poster` | string | — | Poster image URL |
| `width` | int | 640 | Player width |
| `height` | int | 360 | Player height |
| `loop` | bool | false | Loop playback |
| `autoplay` | bool | false | Auto-start |
| `muted` | bool | false | Mute audio |
| `preload` | string | `metadata` | Preload behavior |

---

### wp_playlist_shortcode()

Outputs the `[playlist]` shortcode.

```php
wp_playlist_shortcode( array $attr ): string
```

#### Attributes

| Attribute | Type | Default | Description |
|-----------|------|---------|-------------|
| `type` | string | `audio` | `audio` or `video` |
| `ids` | string | — | Comma-separated attachment IDs |
| `style` | string | `light` | `light` or `dark` |
| `tracklist` | bool | true | Show track list |
| `tracknumbers` | bool | true | Show track numbers |
| `images` | bool | true | Show thumbnails |
| `artists` | bool | true | Show artist names |

---

## Utility Functions

### image_hwstring()

Returns width/height attributes string.

```php
image_hwstring( int $width, int $height ): string
```

#### Example

```php
echo image_hwstring( 800, 600 );
// 'width="800" height="600" '
```

---

### get_image_tag()

Builds an img tag for an attachment.

```php
get_image_tag( int $id, string $alt, string $title, string $align, string|int[] $size = 'medium' ): string
```

---

### wp_get_attachment_link()

Returns an anchor element linking to an attachment.

```php
wp_get_attachment_link( int|WP_Post $post = 0, string|int[] $size = 'thumbnail', bool $permalink = false, bool $icon = false, string|false $text = false, array $attr = '' ): string
```

---

### attachment_url_to_postid()

Converts an attachment URL to its post ID.

```php
attachment_url_to_postid( string $url ): int
```

---

### wp_prepare_attachment_for_js()

Prepares attachment data for JavaScript (Media Library).

```php
wp_prepare_attachment_for_js( int|WP_Post $attachment ): array|void
```

---

### get_attached_media()

Gets media attachments for a post.

```php
get_attached_media( string $type, int|WP_Post $post = 0 ): WP_Post[]
```

#### Example

```php
$images = get_attached_media( 'image', $post_id );
$videos = get_attached_media( 'video', $post_id );
```

---

### get_post_galleries()

Extracts galleries from post content.

```php
get_post_galleries( int|WP_Post $post, bool $html = true ): array
```

---

### wp_max_upload_size()

Returns the maximum upload size allowed.

```php
wp_max_upload_size(): int
```

Returns the smaller of `upload_max_filesize` and `post_max_size` from php.ini.

---

### wp_getimagesize()

Wrapper for `getimagesize()` with extended format support.

```php
wp_getimagesize( string $filename, array &$image_info = null ): array|false
```

Adds support for WebP, AVIF, and HEIC when PHP doesn't natively support them.

---

### wp_get_webp_info()

Extracts dimensions and type from a WebP file.

```php
wp_get_webp_info( string $filename ): array
```

#### Returns

```php
array(
    'width'  => 800,
    'height' => 600,
    'type'   => 'lossy',  // 'lossy', 'lossless', or 'animated-alpha'
)
```

---

### wp_get_avif_info()

Extracts information from an AVIF file.

```php
wp_get_avif_info( string $filename ): array
```

#### Returns

```php
array(
    'width'        => 800,
    'height'       => 600,
    'bit_depth'    => 8,
    'num_channels' => 3,
)
```
