# Export & Import API

WordPress provides APIs for exporting and importing content in WXR (WordPress eXtended RSS) format.

## Export API

### export_wp()

Main function to generate a WXR export file.

```php
export_wp( array $args = array() );
```

**Parameters:**

| Key | Type | Description |
|-----|------|-------------|
| `content` | string | Content type: 'all', 'post', 'page', 'attachment', or custom post type |
| `author` | int/false | Author ID or false for all |
| `category` | string/false | Category slug or false for all |
| `start_date` | string/false | Start date (Y-m-d) |
| `end_date` | string/false | End date (Y-m-d) |
| `status` | string/false | Post status or false for all |

**Example:**

```php
// Export all content
export_wp( array( 'content' => 'all' ) );

// Export posts from specific author
export_wp( array(
    'content' => 'post',
    'author'  => 1,
) );

// Export posts from date range
export_wp( array(
    'content'    => 'post',
    'start_date' => '2024-01-01',
    'end_date'   => '2024-06-30',
) );

// Export specific category
export_wp( array(
    'content'  => 'post',
    'category' => 'news',
) );

// Export specific status
export_wp( array(
    'content' => 'post',
    'status'  => 'publish',
) );
```

### Programmatic Export

```php
function generate_export_file( $args = array() ) {
    require_once ABSPATH . 'wp-admin/includes/export.php';
    
    // Capture output
    ob_start();
    export_wp( $args );
    $xml = ob_get_clean();
    
    return $xml;
}

// Save to file
function save_export_to_file( $args = array() ) {
    $xml = generate_export_file( $args );
    
    $upload_dir = wp_upload_dir();
    $filename   = 'export-' . date( 'Y-m-d' ) . '.xml';
    $filepath   = $upload_dir['path'] . '/' . $filename;
    
    file_put_contents( $filepath, $xml );
    
    return array(
        'file' => $filepath,
        'url'  => $upload_dir['url'] . '/' . $filename,
    );
}
```

### WXR Version

```php
// Current WXR version
define( 'WXR_VERSION', '1.2' );
```

### Export Hooks

| Hook | Description |
|------|-------------|
| `export_wp` | Fires at beginning of export |
| `export_wp_filename` | Filter export filename |
| `wxr_export_skip_postmeta` | Skip specific post meta |
| `wxr_export_skip_termmeta` | Skip specific term meta |
| `wxr_export_skip_commentmeta` | Skip specific comment meta |

### Custom Export Filters

```php
// Custom filename
add_filter( 'export_wp_filename', function( $filename, $sitename, $date ) {
    return $sitename . '-backup-' . $date . '.xml';
}, 10, 3 );

// Skip specific post meta
add_filter( 'wxr_export_skip_postmeta', function( $skip, $meta_key, $meta ) {
    // Skip sensitive data
    if ( in_array( $meta_key, array( '_api_key', '_secret' ), true ) ) {
        return true;
    }
    return $skip;
}, 10, 3 );
```

## Import API

### Register an Importer

```php
register_importer(
    string   $id,
    string   $name,
    string   $description,
    callable $callback
);
```

**Example:**

```php
add_action( 'admin_init', 'register_my_importer' );

function register_my_importer() {
    register_importer(
        'my-importer',
        __( 'My Custom Importer' ),
        __( 'Import content from My Format.' ),
        'my_importer_callback'
    );
}

function my_importer_callback() {
    // Display importer interface
    // Handle file upload and processing
}
```

### Get Registered Importers

```php
$importers = get_importers();

foreach ( $importers as $id => $data ) {
    echo $data[0]; // Name
    echo $data[1]; // Description
    // $data[2] is the callback
}
```

### Popular Importers

```php
// Get list of popular importers from wordpress.org
$importers = wp_get_popular_importers();

/*
array(
    'wordpress' => array(
        'name'        => 'WordPress',
        'description' => 'Import posts, pages...',
        'plugin-slug' => 'wordpress-importer',
        'importer-id' => 'wordpress',
    ),
    'blogger' => array(...),
    // ...
)
*/
```

### Import Upload Handling

```php
// Handle importer file upload
$result = wp_import_handle_upload();

if ( isset( $result['error'] ) ) {
    echo $result['error'];
} else {
    $file = $result['file']; // File path
    $id   = $result['id'];   // Attachment ID
    
    // Process the file...
    
    // Clean up when done
    wp_import_cleanup( $id );
}
```

## Building a Custom Importer

### Basic Structure

```php
class My_Custom_Importer {
    
    public function __construct() {
        // Initialize
    }
    
    public function dispatch() {
        $step = isset( $_GET['step'] ) ? (int) $_GET['step'] : 0;
        
        switch ( $step ) {
            case 0:
                $this->upload_form();
                break;
            case 1:
                check_admin_referer( 'import-upload' );
                $this->handle_upload();
                break;
            case 2:
                check_admin_referer( 'import-my-format' );
                $this->import();
                break;
        }
    }
    
    private function upload_form() {
        ?>
        <div class="wrap">
            <h1><?php _e( 'My Format Importer' ); ?></h1>
            
            <form enctype="multipart/form-data" method="post" 
                  action="<?php echo esc_url( admin_url( 'admin.php?import=my-importer&step=1' ) ); ?>">
                <?php wp_nonce_field( 'import-upload' ); ?>
                
                <p>
                    <label for="upload"><?php _e( 'Choose a file:' ); ?></label>
                    <input type="file" name="import" id="upload">
                </p>
                
                <?php submit_button( __( 'Upload and Import' ) ); ?>
            </form>
        </div>
        <?php
    }
    
    private function handle_upload() {
        $file = wp_import_handle_upload();
        
        if ( isset( $file['error'] ) ) {
            echo '<p class="error">' . esc_html( $file['error'] ) . '</p>';
            return;
        }
        
        // Store file info for next step
        $this->id   = $file['id'];
        $this->file = $file['file'];
        
        // Show mapping options or proceed to import
        $this->show_options();
    }
    
    private function show_options() {
        ?>
        <form method="post" 
              action="<?php echo esc_url( admin_url( 'admin.php?import=my-importer&step=2' ) ); ?>">
            <?php wp_nonce_field( 'import-my-format' ); ?>
            
            <input type="hidden" name="import_id" value="<?php echo esc_attr( $this->id ); ?>">
            
            <h3><?php _e( 'Import Options' ); ?></h3>
            
            <p>
                <label>
                    <input type="checkbox" name="import_attachments" value="1" checked>
                    <?php _e( 'Download and import attachments' ); ?>
                </label>
            </p>
            
            <?php submit_button( __( 'Submit' ) ); ?>
        </form>
        <?php
    }
    
    private function import() {
        $import_id = isset( $_POST['import_id'] ) ? (int) $_POST['import_id'] : 0;
        
        $file = get_attached_file( $import_id );
        
        if ( ! $file || ! file_exists( $file ) ) {
            echo '<p class="error">' . __( 'Import file not found.' ) . '</p>';
            return;
        }
        
        // Process the import
        $this->process_file( $file );
        
        // Clean up
        wp_import_cleanup( $import_id );
        
        echo '<p>' . __( 'Import complete!' ) . '</p>';
    }
    
    private function process_file( $file ) {
        // Read and parse the file
        $content = file_get_contents( $file );
        
        // Process content...
        // Insert posts, terms, etc.
    }
}

// Register the importer
add_action( 'admin_init', function() {
    $importer = new My_Custom_Importer();
    
    register_importer(
        'my-importer',
        __( 'My Format' ),
        __( 'Import from My Format' ),
        array( $importer, 'dispatch' )
    );
} );
```

## WP_Importer Base Class

WordPress provides a base class for importers.

```php
require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';

class My_Importer extends WP_Importer {
    
    // Get authors from import file
    function get_authors_from_import( $import_data ) {
        // Return array of authors
    }
    
    // Map import users to existing users
    function get_author_mapping() {
        // Return author mapping array
    }
}
```

## Inserting Imported Content

### Posts

```php
function import_post( $data ) {
    $post_data = array(
        'post_title'    => sanitize_text_field( $data['title'] ),
        'post_content'  => wp_kses_post( $data['content'] ),
        'post_excerpt'  => sanitize_text_field( $data['excerpt'] ),
        'post_status'   => $data['status'] ?? 'publish',
        'post_type'     => $data['type'] ?? 'post',
        'post_date'     => $data['date'] ?? current_time( 'mysql' ),
        'post_author'   => $data['author'] ?? get_current_user_id(),
    );
    
    $post_id = wp_insert_post( $post_data, true );
    
    if ( is_wp_error( $post_id ) ) {
        return $post_id;
    }
    
    // Add meta
    if ( isset( $data['meta'] ) ) {
        foreach ( $data['meta'] as $key => $value ) {
            update_post_meta( $post_id, $key, $value );
        }
    }
    
    // Add terms
    if ( isset( $data['categories'] ) ) {
        wp_set_post_categories( $post_id, $data['categories'] );
    }
    
    if ( isset( $data['tags'] ) ) {
        wp_set_post_tags( $post_id, $data['tags'] );
    }
    
    return $post_id;
}
```

### Terms

```php
function import_term( $data ) {
    $term = wp_insert_term(
        $data['name'],
        $data['taxonomy'],
        array(
            'description' => $data['description'] ?? '',
            'slug'        => $data['slug'] ?? '',
            'parent'      => $data['parent'] ?? 0,
        )
    );
    
    if ( is_wp_error( $term ) ) {
        // Term might already exist
        $existing = get_term_by( 'slug', $data['slug'], $data['taxonomy'] );
        if ( $existing ) {
            return $existing->term_id;
        }
        return $term;
    }
    
    return $term['term_id'];
}
```

### Users

```php
function import_user( $data ) {
    // Check if user exists
    $user = get_user_by( 'email', $data['email'] );
    
    if ( $user ) {
        return $user->ID;
    }
    
    $user_data = array(
        'user_login' => $data['username'],
        'user_email' => $data['email'],
        'user_pass'  => wp_generate_password(),
        'first_name' => $data['first_name'] ?? '',
        'last_name'  => $data['last_name'] ?? '',
        'role'       => $data['role'] ?? 'subscriber',
    );
    
    return wp_insert_user( $user_data );
}
```

### Attachments

```php
function import_attachment( $url, $post_id = 0 ) {
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    
    // Download file
    $tmp = download_url( $url );
    
    if ( is_wp_error( $tmp ) ) {
        return $tmp;
    }
    
    $file_array = array(
        'name'     => basename( parse_url( $url, PHP_URL_PATH ) ),
        'tmp_name' => $tmp,
    );
    
    // Sideload
    $attachment_id = media_handle_sideload( $file_array, $post_id );
    
    if ( is_wp_error( $attachment_id ) ) {
        @unlink( $file_array['tmp_name'] );
    }
    
    return $attachment_id;
}
```

## Import Progress

For large imports, track progress:

```php
class Progressive_Importer {
    
    private $batch_size = 50;
    private $progress_option = 'my_import_progress';
    
    public function start_import( $file ) {
        $data = $this->parse_file( $file );
        
        update_option( $this->progress_option, array(
            'total'     => count( $data ),
            'processed' => 0,
            'data'      => $data,
        ) );
        
        return $this->process_batch();
    }
    
    public function process_batch() {
        $progress = get_option( $this->progress_option );
        
        if ( ! $progress ) {
            return array( 'complete' => true );
        }
        
        $start = $progress['processed'];
        $batch = array_slice( $progress['data'], $start, $this->batch_size );
        
        foreach ( $batch as $item ) {
            $this->import_item( $item );
            $progress['processed']++;
        }
        
        if ( $progress['processed'] >= $progress['total'] ) {
            delete_option( $this->progress_option );
            return array(
                'complete' => true,
                'total'    => $progress['total'],
            );
        }
        
        update_option( $this->progress_option, $progress );
        
        return array(
            'complete'  => false,
            'processed' => $progress['processed'],
            'total'     => $progress['total'],
            'percent'   => round( ( $progress['processed'] / $progress['total'] ) * 100 ),
        );
    }
}
```

## Best Practices

1. **Validate Input**: Always validate imported data
2. **Sanitize**: Sanitize all content before insertion
3. **Handle Duplicates**: Check for existing content
4. **Batch Processing**: Process large imports in batches
5. **Progress Feedback**: Show import progress to users
6. **Error Logging**: Log import errors for debugging
7. **Cleanup**: Always clean up temporary files
8. **Memory Management**: Use `wp_suspend_cache_addition()` for large imports

```php
function large_import() {
    // Disable cache during import
    wp_suspend_cache_addition( true );
    
    // Disable term counting
    wp_defer_term_counting( true );
    
    // Process import...
    
    // Re-enable
    wp_defer_term_counting( false );
    wp_suspend_cache_addition( false );
    
    // Clean up term counts
    wp_update_term_count_now();
}
```
