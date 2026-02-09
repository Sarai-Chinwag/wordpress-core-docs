# Meta Boxes API

Meta boxes are draggable content boxes that appear on edit screens in WordPress admin. They're used for custom fields, taxonomies, and additional post/page options.

## Core Functions

### add_meta_box()

Adds a meta box to an edit screen.

```php
add_meta_box(
    string            $id,
    string            $title,
    callable          $callback,
    string|array|null $screen = null,
    string            $context = 'advanced',
    string            $priority = 'default',
    array             $callback_args = null
);
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$id` | string | Unique ID for the meta box |
| `$title` | string | Title displayed in the meta box header |
| `$callback` | callable | Function that outputs the meta box content |
| `$screen` | string/array/null | Screen(s) to show the meta box on |
| `$context` | string | 'normal', 'side', or 'advanced' |
| `$priority` | string | 'high', 'core', 'default', or 'low' |
| `$callback_args` | array | Data passed to the callback |

### remove_meta_box()

Removes a meta box.

```php
remove_meta_box( string $id, string|array|WP_Screen $screen, string $context );
```

### do_meta_boxes()

Outputs meta boxes for a screen.

```php
do_meta_boxes( string|WP_Screen $screen, string $context, mixed $data_object );
```

## Basic Meta Box

```php
add_action( 'add_meta_boxes', 'my_custom_meta_box' );

function my_custom_meta_box() {
    add_meta_box(
        'my_custom_meta_box',           // ID
        __( 'My Custom Meta Box' ),     // Title
        'my_custom_meta_box_callback',  // Callback
        'post',                         // Screen (post type)
        'normal',                       // Context
        'high'                          // Priority
    );
}

function my_custom_meta_box_callback( $post ) {
    // Add nonce for security
    wp_nonce_field( 'my_custom_meta_box', 'my_custom_meta_box_nonce' );
    
    // Get existing value
    $value = get_post_meta( $post->ID, '_my_custom_field', true );
    
    // Output form fields
    ?>
    <p>
        <label for="my_custom_field"><?php _e( 'Custom Field:' ); ?></label>
        <input type="text" id="my_custom_field" name="my_custom_field" 
               value="<?php echo esc_attr( $value ); ?>" class="widefat">
    </p>
    <?php
}

// Save the meta box data
add_action( 'save_post', 'my_save_custom_meta_box' );

function my_save_custom_meta_box( $post_id ) {
    // Verify nonce
    if ( ! isset( $_POST['my_custom_meta_box_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['my_custom_meta_box_nonce'], 'my_custom_meta_box' ) ) {
        return;
    }
    
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Sanitize and save
    if ( isset( $_POST['my_custom_field'] ) ) {
        $value = sanitize_text_field( $_POST['my_custom_field'] );
        update_post_meta( $post_id, '_my_custom_field', $value );
    }
}
```

## Contexts and Priorities

### Contexts

| Context | Description |
|---------|-------------|
| `normal` | Below the editor (main column) |
| `side` | Sidebar column |
| `advanced` | Below normal context |

### Priorities

| Priority | Description |
|----------|-------------|
| `high` | Displayed first |
| `core` | Core WordPress meta boxes |
| `default` | Standard priority |
| `low` | Displayed last |

## Multiple Post Types

```php
add_action( 'add_meta_boxes', 'add_to_multiple_types' );

function add_to_multiple_types() {
    $screens = array( 'post', 'page', 'my_custom_type' );
    
    foreach ( $screens as $screen ) {
        add_meta_box(
            'shared_meta_box',
            __( 'Shared Settings' ),
            'shared_meta_box_callback',
            $screen,
            'side',
            'default'
        );
    }
}

// Or use array syntax
add_meta_box(
    'shared_meta_box',
    __( 'Shared Settings' ),
    'shared_meta_box_callback',
    array( 'post', 'page', 'my_custom_type' ),
    'side'
);
```

## Complex Meta Box Example

```php
add_action( 'add_meta_boxes', 'product_meta_boxes' );

function product_meta_boxes() {
    add_meta_box(
        'product_details',
        __( 'Product Details' ),
        'product_details_callback',
        'product',
        'normal',
        'high'
    );
}

function product_details_callback( $post ) {
    wp_nonce_field( 'product_details', 'product_details_nonce' );
    
    // Get meta values
    $price    = get_post_meta( $post->ID, '_product_price', true );
    $sku      = get_post_meta( $post->ID, '_product_sku', true );
    $stock    = get_post_meta( $post->ID, '_product_stock', true );
    $featured = get_post_meta( $post->ID, '_product_featured', true );
    ?>
    
    <table class="form-table">
        <tr>
            <th><label for="product_price"><?php _e( 'Price' ); ?></label></th>
            <td>
                <input type="number" id="product_price" name="product_price" 
                       value="<?php echo esc_attr( $price ); ?>" 
                       step="0.01" min="0" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="product_sku"><?php _e( 'SKU' ); ?></label></th>
            <td>
                <input type="text" id="product_sku" name="product_sku" 
                       value="<?php echo esc_attr( $sku ); ?>" class="regular-text">
            </td>
        </tr>
        <tr>
            <th><label for="product_stock"><?php _e( 'Stock' ); ?></label></th>
            <td>
                <input type="number" id="product_stock" name="product_stock" 
                       value="<?php echo esc_attr( $stock ); ?>" min="0">
            </td>
        </tr>
        <tr>
            <th><label for="product_featured"><?php _e( 'Featured' ); ?></label></th>
            <td>
                <label>
                    <input type="checkbox" id="product_featured" name="product_featured" 
                           value="1" <?php checked( $featured, '1' ); ?>>
                    <?php _e( 'Mark as featured product' ); ?>
                </label>
            </td>
        </tr>
    </table>
    
    <?php
}

add_action( 'save_post_product', 'save_product_details' );

function save_product_details( $post_id ) {
    if ( ! isset( $_POST['product_details_nonce'] ) ) {
        return;
    }
    
    if ( ! wp_verify_nonce( $_POST['product_details_nonce'], 'product_details' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save fields
    if ( isset( $_POST['product_price'] ) ) {
        update_post_meta( $post_id, '_product_price', floatval( $_POST['product_price'] ) );
    }
    
    if ( isset( $_POST['product_sku'] ) ) {
        update_post_meta( $post_id, '_product_sku', sanitize_text_field( $_POST['product_sku'] ) );
    }
    
    if ( isset( $_POST['product_stock'] ) ) {
        update_post_meta( $post_id, '_product_stock', absint( $_POST['product_stock'] ) );
    }
    
    $featured = isset( $_POST['product_featured'] ) ? '1' : '0';
    update_post_meta( $post_id, '_product_featured', $featured );
}
```

## Removing Core Meta Boxes

```php
add_action( 'admin_menu', 'remove_meta_boxes' );

function remove_meta_boxes() {
    // Post meta boxes
    remove_meta_box( 'submitdiv', 'post', 'side' );         // Publish box
    remove_meta_box( 'commentsdiv', 'post', 'normal' );     // Comments
    remove_meta_box( 'revisionsdiv', 'post', 'normal' );    // Revisions
    remove_meta_box( 'authordiv', 'post', 'normal' );       // Author
    remove_meta_box( 'slugdiv', 'post', 'normal' );         // Slug
    remove_meta_box( 'postexcerpt', 'post', 'normal' );     // Excerpt
    remove_meta_box( 'trackbacksdiv', 'post', 'normal' );   // Trackbacks
    remove_meta_box( 'postcustom', 'post', 'normal' );      // Custom Fields
    remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // Discussion
    remove_meta_box( 'postimagediv', 'post', 'side' );      // Featured Image
    remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );  // Tags
    remove_meta_box( 'categorydiv', 'post', 'side' );       // Categories
    
    // Page meta boxes
    remove_meta_box( 'pageparentdiv', 'page', 'side' );     // Page Attributes
    
    // Dashboard meta boxes
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
```

## Callback Arguments

Pass data to your callback function:

```php
add_meta_box(
    'my_meta_box',
    __( 'My Meta Box' ),
    'my_meta_box_callback',
    'post',
    'normal',
    'default',
    array(
        'options' => array( 'a', 'b', 'c' ),
        'default' => 'a',
    )
);

function my_meta_box_callback( $post, $meta_box ) {
    $args    = $meta_box['args'];
    $options = $args['options'];
    $default = $args['default'];
    
    // Use $options and $default in your output
}
```

## Meta Boxes with Media Uploader

```php
add_action( 'add_meta_boxes', 'image_upload_meta_box' );
add_action( 'admin_enqueue_scripts', 'enqueue_media_uploader' );

function enqueue_media_uploader( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }
    
    wp_enqueue_media();
    wp_enqueue_script(
        'my-meta-box-image',
        plugin_dir_url( __FILE__ ) . 'js/meta-box-image.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}

function image_upload_meta_box() {
    add_meta_box(
        'custom_image_box',
        __( 'Custom Image' ),
        'custom_image_callback',
        'post',
        'side'
    );
}

function custom_image_callback( $post ) {
    wp_nonce_field( 'custom_image_box', 'custom_image_nonce' );
    
    $image_id = get_post_meta( $post->ID, '_custom_image_id', true );
    $image    = $image_id ? wp_get_attachment_image( $image_id, 'thumbnail' ) : '';
    ?>
    
    <div class="custom-image-container">
        <?php echo $image; ?>
    </div>
    
    <input type="hidden" name="custom_image_id" id="custom_image_id" 
           value="<?php echo esc_attr( $image_id ); ?>">
    
    <p>
        <button type="button" class="button" id="upload_image_button">
            <?php _e( 'Select Image' ); ?>
        </button>
        <button type="button" class="button" id="remove_image_button" 
                style="<?php echo $image_id ? '' : 'display:none'; ?>">
            <?php _e( 'Remove Image' ); ?>
        </button>
    </p>
    
    <?php
}
```

## Hooks

### Actions

| Hook | Description |
|------|-------------|
| `add_meta_boxes` | Fires when meta boxes should be added |
| `add_meta_boxes_{post_type}` | Post type specific |
| `do_meta_boxes` | Fires before meta boxes are output |

### Filters

| Filter | Description |
|--------|-------------|
| `postbox_classes_{screen_id}_{meta_box_id}` | Filter meta box CSS classes |
| `default_hidden_meta_boxes` | Set default hidden meta boxes |
| `hidden_meta_boxes` | Filter hidden meta boxes |

## Block Editor Compatibility

For Gutenberg compatibility, use the `__block_editor_compatible_meta_box` flag:

```php
add_meta_box(
    'my_classic_meta_box',
    __( 'Classic Meta Box' ),
    'my_classic_callback',
    'post',
    'side',
    'default',
    array(
        '__block_editor_compatible_meta_box' => true,
        '__back_compat_meta_box'             => false,
    )
);
```

Or use `register_post_meta()` for block editor native handling:

```php
register_post_meta( 'post', '_my_custom_field', array(
    'show_in_rest'  => true,
    'single'        => true,
    'type'          => 'string',
    'auth_callback' => function() {
        return current_user_can( 'edit_posts' );
    },
) );
```
