# Screen Options API

Screen Options provide user-configurable settings for admin screens, appearing in the collapsible panel at the top of admin pages.

## Core Functions

### add_screen_option()

Register and configure a screen option.

```php
add_screen_option( string $option, array $args = array() );
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option` | string | Option name ('per_page', 'layout_columns') |
| `$args` | array | Option-dependent arguments |

### get_current_screen()

Get the current screen object.

```php
$screen = get_current_screen();
```

### set_current_screen()

Set the current screen object.

```php
set_current_screen( $hook_name );
```

## Per Page Options

The most common screen option — controls items displayed per page in list tables.

```php
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
    $hook = add_menu_page(
        'My Plugin',
        'My Plugin',
        'manage_options',
        'my-plugin',
        'my_plugin_page'
    );
    
    add_action( "load-$hook", 'my_screen_options' );
}

function my_screen_options() {
    add_screen_option( 'per_page', array(
        'label'   => __( 'Items per page' ),
        'default' => 20,
        'option'  => 'my_plugin_per_page',  // Option name in usermeta
    ) );
}
```

### Saving the Value

WordPress doesn't automatically save custom per_page options. Use the filter:

```php
add_filter( 'set_screen_option_my_plugin_per_page', 'save_my_per_page', 10, 3 );

function save_my_per_page( $status, $option, $value ) {
    if ( 'my_plugin_per_page' === $option ) {
        return absint( $value );
    }
    return $status;
}

// Alternative: Generic filter (WordPress 5.4.2+)
add_filter( 'set-screen-option', 'save_screen_options', 10, 3 );

function save_screen_options( $status, $option, $value ) {
    $valid_options = array(
        'my_plugin_per_page',
        'another_option',
    );
    
    if ( in_array( $option, $valid_options, true ) ) {
        return $value;
    }
    
    return $status;
}
```

### Retrieving the Value

```php
$per_page = get_user_meta( get_current_user_id(), 'my_plugin_per_page', true );

if ( empty( $per_page ) ) {
    $per_page = 20; // Default
}
```

## Layout Columns

Control how many columns are displayed in meta box layouts.

```php
add_action( "load-$hook", 'add_layout_columns' );

function add_layout_columns() {
    $screen = get_current_screen();
    
    // Enable layout columns (1-4)
    add_screen_option( 'layout_columns', array(
        'max'     => 2,
        'default' => 2,
    ) );
}
```

## WP_Screen Class

The `WP_Screen` class manages admin screen properties and options.

### Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `$id` | string | Unique screen ID |
| `$base` | string | Base screen type |
| `$action` | string | Screen action ('add' for new pages) |
| `$post_type` | string | Associated post type |
| `$taxonomy` | string | Associated taxonomy |
| `$is_block_editor` | bool | Whether using block editor |

### Static Method: get()

```php
// Get screen by hook name
$screen = WP_Screen::get( 'post' );

// Get current screen
$screen = WP_Screen::get();
```

### Instance Methods

```php
$screen = get_current_screen();

// Add a help tab
$screen->add_help_tab( array(
    'id'      => 'my-help-tab',
    'title'   => __( 'My Help Tab' ),
    'content' => '<p>This is help content.</p>',
) );

// Add help sidebar
$screen->set_help_sidebar( '<p>Sidebar content</p>' );

// Add option
$screen->add_option( 'per_page', array(
    'label'   => __( 'Items' ),
    'default' => 20,
    'option'  => 'my_per_page',
) );

// Get option
$value = $screen->get_option( 'per_page', 'default' );

// Get number of columns
$columns = $screen->get_columns();

// Check screen location
if ( $screen->in_admin( 'network' ) ) {
    // Network admin
}
```

## Help Tabs

Add contextual help to admin screens.

```php
add_action( 'admin_head', 'my_admin_help' );

function my_admin_help() {
    $screen = get_current_screen();
    
    // Only add to our screen
    if ( 'toplevel_page_my-plugin' !== $screen->id ) {
        return;
    }
    
    // Add help tab
    $screen->add_help_tab( array(
        'id'      => 'overview',
        'title'   => __( 'Overview' ),
        'content' => '<p>This plugin does amazing things...</p>',
    ) );
    
    $screen->add_help_tab( array(
        'id'       => 'settings',
        'title'    => __( 'Settings' ),
        'callback' => 'my_help_settings_callback',
    ) );
    
    // Help sidebar
    $screen->set_help_sidebar(
        '<p><strong>' . __( 'For more information:' ) . '</strong></p>' .
        '<p><a href="https://example.com/docs">' . __( 'Documentation' ) . '</a></p>'
    );
}

function my_help_settings_callback( $screen, $tab ) {
    echo '<p>Settings help content here.</p>';
}
```

## Hidden Columns

Manage which columns are hidden by default.

### Filter Default Hidden Columns

```php
add_filter( 'default_hidden_columns', 'my_default_hidden_columns', 10, 2 );

function my_default_hidden_columns( $hidden, $screen ) {
    if ( 'edit-post' === $screen->id ) {
        $hidden[] = 'tags';
        $hidden[] = 'comments';
    }
    return $hidden;
}
```

### Get/Set Hidden Columns

```php
// Get hidden columns for current user
$hidden = get_hidden_columns( $screen );

// Get column headers
$columns = get_column_headers( $screen );
```

## Hidden Meta Boxes

Manage which meta boxes are hidden by default.

```php
add_filter( 'default_hidden_meta_boxes', 'my_default_hidden_meta_boxes', 10, 2 );

function my_default_hidden_meta_boxes( $hidden, $screen ) {
    if ( 'post' === $screen->base ) {
        $hidden[] = 'postcustom';
        $hidden[] = 'trackbacksdiv';
    }
    return $hidden;
}
```

### Get Hidden Meta Boxes

```php
$hidden = get_hidden_meta_boxes( $screen );
```

## Screen Reader Content

Add accessible hidden text for screen readers.

```php
$screen = get_current_screen();

$screen->set_screen_reader_content( array(
    'heading_views'      => __( 'Filter items list' ),
    'heading_pagination' => __( 'Items list navigation' ),
    'heading_list'       => __( 'Items list' ),
) );
```

## Checking Screen Context

```php
$screen = get_current_screen();

// Check base
if ( 'post' === $screen->base ) {
    // On single post edit screen
}

// Check post type
if ( 'page' === $screen->post_type ) {
    // Working with pages
}

// Check if in specific admin context
if ( $screen->in_admin( 'network' ) ) {
    // Network admin
} elseif ( $screen->in_admin( 'user' ) ) {
    // User admin (multisite)
} elseif ( $screen->in_admin( 'site' ) ) {
    // Regular site admin
}

// Check if block editor
if ( $screen->is_block_editor ) {
    // Block editor screen
}
```

## Common Screen IDs

| Screen ID | Description |
|-----------|-------------|
| `dashboard` | Main dashboard |
| `edit-post` | Posts list |
| `edit-page` | Pages list |
| `post` | Single post edit |
| `page` | Single page edit |
| `upload` | Media library |
| `edit-category` | Categories |
| `edit-post_tag` | Tags |
| `plugins` | Plugins list |
| `themes` | Themes page |
| `users` | Users list |
| `options-general` | General settings |

## Custom Screen Options Content

Add custom content to the screen options panel:

```php
add_filter( 'screen_settings', 'my_screen_settings', 10, 2 );

function my_screen_settings( $settings, $screen ) {
    if ( 'toplevel_page_my-plugin' !== $screen->id ) {
        return $settings;
    }
    
    $option = get_user_meta( get_current_user_id(), 'my_custom_option', true );
    
    $settings .= '<fieldset class="my-screen-option">';
    $settings .= '<legend>' . __( 'My Custom Option' ) . '</legend>';
    $settings .= '<label>';
    $settings .= '<input type="checkbox" name="my_custom_option" value="1" ' . checked( $option, 1, false ) . '>';
    $settings .= __( 'Enable custom feature' );
    $settings .= '</label>';
    $settings .= '</fieldset>';
    
    return $settings;
}

// Save the custom option
add_action( 'wp_ajax_my_save_screen_option', 'save_my_screen_option' );

function save_my_screen_option() {
    check_ajax_referer( 'screen-options-nonce', 'screenoptionnonce' );
    
    $value = isset( $_POST['my_custom_option'] ) ? 1 : 0;
    update_user_meta( get_current_user_id(), 'my_custom_option', $value );
    
    wp_die();
}
```
