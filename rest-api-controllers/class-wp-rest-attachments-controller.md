# WP_REST_Attachments_Controller

Core controller used to access attachments (media) via the REST API. Extends `WP_REST_Posts_Controller` with media-specific functionality.

## Class Synopsis

```php
class WP_REST_Attachments_Controller extends WP_REST_Posts_Controller {
    protected $allow_batch = false;
    
    public function register_routes();
    
    // Permission Checks
    public function create_item_permissions_check( $request );
    public function post_process_item_permissions_check( $request );
    public function edit_media_item_permissions_check( $request );
    
    // CRUD Operations
    public function create_item( $request );
    public function update_item( $request );
    public function post_process_item( $request );
    public function edit_media_item( $request );
    
    // Data Preparation
    protected function prepare_items_query( $prepared_args, $request );
    protected function prepare_item_for_database( $request );
    public function prepare_item_for_response( $item, $request );
    protected function insert_attachment( $request );
    
    // Schema & Parameters
    public function get_item_schema();
    public function get_collection_params();
    protected function get_edit_media_item_args();
    
    // File Handling
    protected function upload_from_file( $files, $headers, $time );
    protected function upload_from_data( $data, $headers, $time );
    protected function get_media_types();
    protected function get_filename_from_disposition( $disposition_header );
    
    // Utilities
    protected function handle_featured_media( $featured_media, $post_id );
}
```

## Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/wp/v2/media` | List media items |
| POST | `/wp/v2/media` | Upload a media item |
| GET | `/wp/v2/media/{id}` | Get a single media item |
| POST/PUT/PATCH | `/wp/v2/media/{id}` | Update a media item |
| DELETE | `/wp/v2/media/{id}` | Delete a media item |
| POST | `/wp/v2/media/{id}/post-process` | Post-process media (create subsizes) |
| POST | `/wp/v2/media/{id}/edit` | Edit media (crop, rotate, etc.) |

## Constructor

Inherits from `WP_REST_Posts_Controller` with `'attachment'` post type.

**Note:** Batching is disabled (`$allow_batch = false`) for attachments.

## Collection Parameters

Inherits all parameters from `WP_REST_Posts_Controller`, plus:

| Parameter | Type | Description |
|-----------|------|-------------|
| `media_type` | string/array | Filter by media type (image, video, audio, application) |
| `mime_type` | string/array | Filter by specific MIME type |

### Media Types

- `image` - image/jpeg, image/png, image/gif, etc.
- `video` - video/mp4, video/mpeg, etc.
- `audio` - audio/mpeg, audio/ogg, etc.
- `application` - application/pdf, etc.

## Schema Properties

Inherits from posts, plus attachment-specific properties:

| Property | Type | Context | Description |
|----------|------|---------|-------------|
| `alt_text` | string | view, edit, embed | Alt text for images |
| `caption` | object | view, edit, embed | Media caption (raw/rendered) |
| `description` | object | view, edit | Media description (raw/rendered) |
| `media_type` | string | view, edit, embed | Media type (image, file, etc.) |
| `mime_type` | string | view, edit, embed | MIME type |
| `media_details` | object | view, edit, embed | Details (sizes, dimensions, etc.) |
| `post` | integer | view, edit | Parent post ID |
| `source_url` | string | view, edit, embed | Original file URL |
| `missing_image_sizes` | array | edit | Missing image sizes |

### media_details Structure

```json
{
    "media_details": {
        "width": 1920,
        "height": 1080,
        "file": "2024/01/image.jpg",
        "filesize": 245760,
        "sizes": {
            "thumbnail": {
                "file": "image-150x150.jpg",
                "width": 150,
                "height": 150,
                "mime_type": "image/jpeg",
                "source_url": "https://..."
            },
            "medium": { ... },
            "large": { ... },
            "full": { ... }
        },
        "image_meta": {
            "aperture": "2.8",
            "camera": "Canon EOS 5D",
            ...
        }
    }
}
```

## Permission Checks

### create_item_permissions_check()
- Inherits parent checks
- Requires `upload_files` capability
- Requires `edit_post` for attaching to a post
- Validates image types are supported by server

### post_process_item_permissions_check()
- Requires `edit_post` capability for the attachment

### edit_media_item_permissions_check()
- Requires `edit_post` capability for the attachment

## Upload Methods

### File Upload (multipart/form-data)

```bash
curl -X POST https://example.com/wp-json/wp/v2/media \
  -H "Authorization: Bearer TOKEN" \
  -F "file=@/path/to/image.jpg" \
  -F "title=My Image" \
  -F "alt_text=Description of image"
```

### Binary Upload

```bash
curl -X POST https://example.com/wp-json/wp/v2/media \
  -H "Authorization: Bearer TOKEN" \
  -H "Content-Type: image/jpeg" \
  -H "Content-Disposition: attachment; filename=image.jpg" \
  --data-binary @/path/to/image.jpg
```

### Key File Handling Methods

#### upload_from_file()
```php
protected function upload_from_file( array $files, array $headers, string $time = null ): array|WP_Error
```
Handles multipart file uploads via `$_FILES`.

#### upload_from_data()
```php
protected function upload_from_data( string $data, array $headers, string $time = null ): array|WP_Error
```
Handles raw binary uploads via request body.

## Post-Processing

### POST /wp/v2/media/{id}/post-process

Regenerates image subsizes after upload. Useful for recovering from PHP timeout during initial upload.

**Parameters:**
- `action` - Required. Currently only `'create-image-subsizes'` supported.

**Response Headers:**
- `X-WP-Upload-Attachment-ID` - Set during upload for recovery

## Media Editing

### POST /wp/v2/media/{id}/edit

Edit images with transformations.

**Parameters:**
- `src` - Source URL of image to edit
- `modifiers` - Array of edit operations
- `rotation` - Rotation angle (0, 90, 180, 270)
- `x`, `y`, `width`, `height` - Crop coordinates

**Modifiers:**
```json
{
    "modifiers": [
        { "type": "rotate", "args": { "angle": 90 } },
        { "type": "crop", "args": { "left": 10, "top": 10, "width": 80, "height": 80 } }
    ]
}
```

## Default Status

Attachments default to `'inherit'` status (not `'publish'` like posts).

## Featured Media (Thumbnails for Audio/Video)

Audio and video attachments can have their own featured media (cover images):

```php
// Set cover image for audio/video
$request = new WP_REST_Request( 'POST', '/wp/v2/media/123' );
$request->set_param( 'featured_media', 456 ); // Cover image ID
```

Requires theme support:
- `post-thumbnails` for `attachment:audio` or `attachment:video`

## Usage Example

```php
// Upload an image
$request = new WP_REST_Request( 'POST', '/wp/v2/media' );
$request->set_file_params( array(
    'file' => array(
        'name'     => 'image.jpg',
        'type'     => 'image/jpeg',
        'tmp_name' => '/tmp/phpXXXX',
        'error'    => 0,
        'size'     => 12345,
    ),
));
$request->set_param( 'title', 'My Image' );
$request->set_param( 'alt_text', 'A beautiful landscape' );
$request->set_param( 'post', 123 ); // Attach to post

$controller = new WP_REST_Attachments_Controller( 'attachment' );
$response = $controller->create_item( $request );

// Get images only
$request = new WP_REST_Request( 'GET', '/wp/v2/media' );
$request->set_param( 'media_type', 'image' );
$request->set_param( 'per_page', 50 );

$response = $controller->get_items( $request );

// Update alt text
$request = new WP_REST_Request( 'POST', '/wp/v2/media/456' );
$request->set_param( 'alt_text', 'Updated alt text' );
$request->set_param( 'caption', 'New caption text' );

$response = $controller->update_item( $request );

// Post-process (regenerate sizes)
$request = new WP_REST_Request( 'POST', '/wp/v2/media/456/post-process' );
$request->set_param( 'action', 'create-image-subsizes' );

$response = $controller->post_process_item( $request );
```

## Unsupported Image Types

WordPress validates that the server can process uploaded image types. Unsupported types (e.g., HEIC on servers without support) return an error:

```json
{
    "code": "rest_upload_image_type_not_supported",
    "message": "The web server cannot generate responsive image sizes for this image. Convert it to JPEG or PNG before uploading.",
    "data": { "status": 400 }
}
```

Override with filter:
```php
add_filter( 'wp_prevent_unsupported_mime_type_uploads', '__return_false' );
```

## EXIF/IPTC Data

Image metadata is automatically read and can populate:
- `title` - From EXIF/IPTC title (if not provided)
- `caption` - From EXIF/IPTC caption (if not provided)

## Source

`wp-includes/rest-api/endpoints/class-wp-rest-attachments-controller.php`

## Since

WordPress 4.7.0

## Changelog

| Version | Description |
|---------|-------------|
| 4.7.0 | Introduced |
| 5.3.0 | Added post-process endpoint |
| 5.5.0 | Added edit endpoint |
| 6.5.0 | Added featured_media support for audio/video |
| 6.8.0 | Added unsupported image type validation |
| 6.9.0 | Extended media_type and mime_type to support arrays |
