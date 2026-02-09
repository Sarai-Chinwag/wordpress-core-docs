# File Upload Handling API

WordPress provides comprehensive APIs for handling file uploads, managing the filesystem, and processing media files in the admin.

## Core Upload Functions

### wp_handle_upload()

Handles an upload and moves the file to the uploads directory.

```php
$file = wp_handle_upload(
    array  $_FILES['field_name'],
    array  $overrides = array( 'test_form' => true ),
    string $time = null
);
```

**Returns:**

```php
// Success
array(
    'file' => '/path/to/uploaded/file.jpg',
    'url'  => 'https://example.com/wp-content/uploads/2024/01/file.jpg',
    'type' => 'image/jpeg',
)

// Error
array(
    'error' => 'Error message here',
)
```

**Overrides:**

| Key | Type | Description |
|-----|------|-------------|
| `test_form` | bool | Check if form action matches (default true) |
| `test_size` | bool | Check upload size limits |
| `test_type` | bool | Check file type |
| `mimes` | array | Allowed MIME types |
| `unique_filename_callback` | callable | Custom filename generator |

### media_handle_upload()

Complete upload handler: uploads file + creates attachment post.

```php
$attachment_id = media_handle_upload(
    string $file_id,     // Key in $_FILES
    int    $post_id,     // Parent post ID (0 for unattached)
    array  $post_data = array(),
    array  $overrides = array( 'test_form' => false )
);
```

**Example:**

```php
if ( ! empty( $_FILES['my_file']['name'] ) ) {
    // Required for media_handle_upload
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    
    $attachment_id = media_handle_upload( 'my_file', 0 );
    
    if ( is_wp_error( $attachment_id ) ) {
        // Handle error
        echo $attachment_id->get_error_message();
    } else {
        // Success
        $url = wp_get_attachment_url( $attachment_id );
    }
}
```

### media_handle_sideload()

Download a file from URL and add to media library.

```php
$attachment_id = media_handle_sideload(
    array  $file_array,   // Like $_FILES entry
    int    $post_id,
    string $desc = null,
    array  $post_data = array()
);
```

**Example: Sideload from URL**

```php
function sideload_image_from_url( $url, $post_id = 0 ) {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    
    // Download to temp location
    $tmp = download_url( $url );
    
    if ( is_wp_error( $tmp ) ) {
        return $tmp;
    }
    
    // Build file array
    $file_array = array(
        'name'     => basename( parse_url( $url, PHP_URL_PATH ) ),
        'tmp_name' => $tmp,
    );
    
    // Sideload the file
    $attachment_id = media_handle_sideload( $file_array, $post_id );
    
    // Clean up temp file on error
    if ( is_wp_error( $attachment_id ) ) {
        @unlink( $file_array['tmp_name'] );
    }
    
    return $attachment_id;
}
```

### download_url()

Downloads a URL to a local temp file.

```php
$tmp_file = download_url(
    string $url,
    int    $timeout = 300,
    bool   $signature_verification = false
);
```

## Custom Upload Form

### HTML Form

```php
function my_upload_form() {
    ?>
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'my_file_upload', 'my_upload_nonce' ); ?>
        
        <p>
            <label for="my_file"><?php _e( 'Select File:' ); ?></label>
            <input type="file" name="my_file" id="my_file">
        </p>
        
        <?php submit_button( __( 'Upload' ) ); ?>
    </form>
    <?php
}
```

### Processing Upload

```php
add_action( 'admin_init', 'process_my_upload' );

function process_my_upload() {
    if ( ! isset( $_POST['my_upload_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['my_upload_nonce'], 'my_file_upload' ) ) {
        wp_die( 'Security check failed' );
    }
    
    if ( ! current_user_can( 'upload_files' ) ) {
        wp_die( 'Permission denied' );
    }
    
    if ( empty( $_FILES['my_file']['name'] ) ) {
        return;
    }
    
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    
    $attachment_id = media_handle_upload( 'my_file', 0 );
    
    if ( is_wp_error( $attachment_id ) ) {
        add_settings_error(
            'my_upload',
            'upload_error',
            $attachment_id->get_error_message(),
            'error'
        );
    } else {
        add_settings_error(
            'my_upload',
            'upload_success',
            __( 'File uploaded successfully.' ),
            'success'
        );
    }
}
```

## File Type Validation

### Allowed MIME Types

```php
// Get allowed MIME types
$mimes = get_allowed_mime_types();

// Check specific file
$filetype = wp_check_filetype( 'file.pdf', $mimes );
// Returns: array( 'ext' => 'pdf', 'type' => 'application/pdf' )

// Check with full path
$filetype = wp_check_filetype_and_ext( $file, $filename, $mimes );
```

### Add Custom MIME Types

```php
add_filter( 'upload_mimes', 'add_custom_mimes' );

function add_custom_mimes( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    $mimes['json'] = 'application/json';
    
    return $mimes;
}
```

### Restrict File Types

```php
add_filter( 'upload_mimes', 'restrict_upload_mimes' );

function restrict_upload_mimes( $mimes ) {
    // Only allow images
    return array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png'          => 'image/png',
        'gif'          => 'image/gif',
    );
}
```

## WP_Filesystem API

For file operations that might require FTP credentials.

### Initialize Filesystem

```php
function init_filesystem() {
    global $wp_filesystem;
    
    if ( ! function_exists( 'WP_Filesystem' ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
    }
    
    // Request credentials if needed
    $creds = request_filesystem_credentials( '', '', false, false, null );
    
    if ( ! $creds ) {
        return false;
    }
    
    // Initialize
    if ( ! WP_Filesystem( $creds ) ) {
        request_filesystem_credentials( '', '', true, false, null );
        return false;
    }
    
    return true;
}
```

### Filesystem Operations

```php
global $wp_filesystem;

// Read file
$content = $wp_filesystem->get_contents( $file_path );

// Write file
$wp_filesystem->put_contents( $file_path, $content, FS_CHMOD_FILE );

// Check if file exists
if ( $wp_filesystem->exists( $file_path ) ) {
    // ...
}

// Create directory
$wp_filesystem->mkdir( $dir_path );

// Delete file
$wp_filesystem->delete( $file_path );

// Delete directory (recursive)
$wp_filesystem->delete( $dir_path, true );

// Copy file
$wp_filesystem->copy( $source, $destination );

// Move file
$wp_filesystem->move( $source, $destination );

// Get directory listing
$files = $wp_filesystem->dirlist( $dir_path );
```

## Upload Directory Functions

```php
// Get upload directory info
$upload_dir = wp_upload_dir();
/*
array(
    'path'    => '/var/www/wp-content/uploads/2024/01',
    'url'     => 'https://example.com/wp-content/uploads/2024/01',
    'subdir'  => '/2024/01',
    'basedir' => '/var/www/wp-content/uploads',
    'baseurl' => 'https://example.com/wp-content/uploads',
    'error'   => false,
)
*/

// Get for specific date
$upload_dir = wp_upload_dir( '2023/06' );
```

## Media Library Integration

### Using wp.media JavaScript

```php
add_action( 'admin_enqueue_scripts', 'enqueue_media_uploader' );

function enqueue_media_uploader( $hook ) {
    if ( 'toplevel_page_my-plugin' !== $hook ) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script(
        'my-media-uploader',
        plugin_dir_url( __FILE__ ) . 'js/uploader.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
```

**JavaScript (uploader.js):**

```javascript
jQuery(document).ready(function($) {
    var frame;
    
    $('#upload_button').on('click', function(e) {
        e.preventDefault();
        
        if (frame) {
            frame.open();
            return;
        }
        
        frame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use this image'
            },
            multiple: false,
            library: {
                type: 'image'
            }
        });
        
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            
            $('#image_id').val(attachment.id);
            $('#image_preview').attr('src', attachment.url);
        });
        
        frame.open();
    });
    
    $('#remove_button').on('click', function(e) {
        e.preventDefault();
        
        $('#image_id').val('');
        $('#image_preview').attr('src', '');
    });
});
```

## Import Uploads

### wp_import_handle_upload()

For importer file uploads.

```php
$result = wp_import_handle_upload();

if ( isset( $result['error'] ) ) {
    echo $result['error'];
} else {
    $file = $result['file'];
    $id   = $result['id'];
    
    // Process import file...
    
    // Clean up when done
    wp_import_cleanup( $id );
}
```

## Hooks

| Hook | Description |
|------|-------------|
| `upload_mimes` | Filter allowed MIME types |
| `wp_handle_upload_prefilter` | Filter file data before upload |
| `wp_handle_upload` | After upload, before moving |
| `wp_upload_bits` | After wp_upload_bits() |
| `upload_dir` | Filter upload directory paths |
| `pre_move_uploaded_file` | Before moving uploaded file |

## Best Practices

1. **Verify Nonces**: Always use nonce verification for uploads
2. **Check Capabilities**: Verify user can upload files
3. **Validate File Types**: Use MIME type checking
4. **Sanitize Filenames**: WordPress does this, but validate extensions
5. **Handle Errors**: Check for WP_Error returns
6. **Clean Up**: Delete temp files on failure
7. **Use Overrides**: Set appropriate overrides for context

```php
function secure_file_upload( $file_input ) {
    // Verify nonce
    check_admin_referer( 'my_upload_action' );
    
    // Check capability
    if ( ! current_user_can( 'upload_files' ) ) {
        return new WP_Error( 'no_permission', 'You cannot upload files.' );
    }
    
    // Validate file presence
    if ( empty( $_FILES[ $file_input ]['name'] ) ) {
        return new WP_Error( 'no_file', 'No file was uploaded.' );
    }
    
    // Custom MIME type restriction
    $allowed = array( 'image/jpeg', 'image/png', 'image/gif' );
    
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    
    $overrides = array(
        'test_form' => false,
        'mimes'     => array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'png'          => 'image/png',
            'gif'          => 'image/gif',
        ),
    );
    
    return media_handle_upload( $file_input, 0, array(), $overrides );
}
```
