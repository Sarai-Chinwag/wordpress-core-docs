# Settings API

The WordPress Settings API provides a standardized way to create and manage settings pages. It handles form generation, validation, sanitization, and storage.

## Core Concepts

1. **Settings** - Individual options stored in the database
2. **Sections** - Groups of related settings on a page
3. **Fields** - Individual form inputs within sections
4. **Pages** - Admin pages that display sections and fields

## Core Functions

### register_setting()

Registers a setting and its sanitization callback.

```php
register_setting(
    string   $option_group,
    string   $option_name,
    array    $args = array()
);
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$option_group` | string | Settings group name (matches page slug) |
| `$option_name` | string | Option name in wp_options table |
| `$args` | array | Configuration arguments |

**Args:**

| Key | Type | Description |
|-----|------|-------------|
| `type` | string | Data type ('string', 'boolean', 'integer', 'number', 'array', 'object') |
| `description` | string | Setting description (for REST API) |
| `sanitize_callback` | callable | Sanitization function |
| `show_in_rest` | bool/array | Whether to expose in REST API |
| `default` | mixed | Default value |

### add_settings_section()

Adds a section to a settings page.

```php
add_settings_section(
    string   $id,
    string   $title,
    callable $callback,
    string   $page,
    array    $args = array()
);
```

### add_settings_field()

Adds a field to a settings section.

```php
add_settings_field(
    string   $id,
    string   $title,
    callable $callback,
    string   $page,
    string   $section = 'default',
    array    $args = array()
);
```

### settings_fields()

Outputs security fields for a settings page (nonce, action, etc.).

```php
settings_fields( string $option_group );
```

### do_settings_sections()

Outputs all sections and fields for a page.

```php
do_settings_sections( string $page );
```

### do_settings_fields()

Outputs fields for a specific section.

```php
do_settings_fields( string $page, string $section );
```

## Complete Example

### Step 1: Create Settings Page

```php
add_action( 'admin_menu', 'my_plugin_add_settings_page' );

function my_plugin_add_settings_page() {
    add_options_page(
        __( 'My Plugin Settings' ),    // Page title
        __( 'My Plugin' ),             // Menu title
        'manage_options',              // Capability
        'my-plugin-settings',          // Menu slug
        'my_plugin_settings_page'      // Callback
    );
}

function my_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <form action="options.php" method="post">
            <?php
            // Output security fields
            settings_fields( 'my_plugin_options' );
            
            // Output sections and fields
            do_settings_sections( 'my-plugin-settings' );
            
            // Submit button
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
```

### Step 2: Register Settings

```php
add_action( 'admin_init', 'my_plugin_register_settings' );

function my_plugin_register_settings() {
    // Register the setting
    register_setting(
        'my_plugin_options',      // Option group
        'my_plugin_settings',     // Option name
        array(
            'type'              => 'array',
            'sanitize_callback' => 'my_plugin_sanitize_settings',
            'default'           => array(
                'text_field'     => '',
                'checkbox_field' => false,
                'select_field'   => 'option1',
            ),
        )
    );
    
    // Add section
    add_settings_section(
        'my_plugin_general_section',          // Section ID
        __( 'General Settings' ),             // Title
        'my_plugin_section_callback',         // Callback
        'my-plugin-settings'                  // Page slug
    );
    
    // Add fields
    add_settings_field(
        'text_field',                         // Field ID
        __( 'Text Field' ),                   // Title
        'my_plugin_text_field_callback',      // Callback
        'my-plugin-settings',                 // Page slug
        'my_plugin_general_section',          // Section ID
        array(
            'label_for' => 'text_field',
            'class'     => 'my-plugin-row',
        )
    );
    
    add_settings_field(
        'checkbox_field',
        __( 'Checkbox Field' ),
        'my_plugin_checkbox_field_callback',
        'my-plugin-settings',
        'my_plugin_general_section'
    );
    
    add_settings_field(
        'select_field',
        __( 'Select Field' ),
        'my_plugin_select_field_callback',
        'my-plugin-settings',
        'my_plugin_general_section',
        array( 'label_for' => 'select_field' )
    );
}
```

### Step 3: Section and Field Callbacks

```php
function my_plugin_section_callback( $args ) {
    ?>
    <p><?php _e( 'Configure the general settings for my plugin.' ); ?></p>
    <?php
}

function my_plugin_text_field_callback( $args ) {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['text_field'] ) ? $options['text_field'] : '';
    ?>
    <input type="text" 
           id="<?php echo esc_attr( $args['label_for'] ); ?>"
           name="my_plugin_settings[text_field]"
           value="<?php echo esc_attr( $value ); ?>"
           class="regular-text">
    <p class="description">
        <?php _e( 'Enter some text here.' ); ?>
    </p>
    <?php
}

function my_plugin_checkbox_field_callback( $args ) {
    $options = get_option( 'my_plugin_settings' );
    $checked = isset( $options['checkbox_field'] ) ? $options['checkbox_field'] : false;
    ?>
    <label>
        <input type="checkbox"
               name="my_plugin_settings[checkbox_field]"
               value="1"
               <?php checked( $checked, true ); ?>>
        <?php _e( 'Enable this feature' ); ?>
    </label>
    <?php
}

function my_plugin_select_field_callback( $args ) {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['select_field'] ) ? $options['select_field'] : 'option1';
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
            name="my_plugin_settings[select_field]">
        <option value="option1" <?php selected( $value, 'option1' ); ?>>
            <?php _e( 'Option 1' ); ?>
        </option>
        <option value="option2" <?php selected( $value, 'option2' ); ?>>
            <?php _e( 'Option 2' ); ?>
        </option>
        <option value="option3" <?php selected( $value, 'option3' ); ?>>
            <?php _e( 'Option 3' ); ?>
        </option>
    </select>
    <?php
}
```

### Step 4: Sanitization Callback

```php
function my_plugin_sanitize_settings( $input ) {
    $sanitized = array();
    
    // Text field
    if ( isset( $input['text_field'] ) ) {
        $sanitized['text_field'] = sanitize_text_field( $input['text_field'] );
    }
    
    // Checkbox (boolean)
    $sanitized['checkbox_field'] = ! empty( $input['checkbox_field'] );
    
    // Select field
    $valid_options = array( 'option1', 'option2', 'option3' );
    if ( isset( $input['select_field'] ) && in_array( $input['select_field'], $valid_options, true ) ) {
        $sanitized['select_field'] = $input['select_field'];
    } else {
        $sanitized['select_field'] = 'option1';
    }
    
    return $sanitized;
}
```

## Advanced Field Types

### Textarea

```php
function textarea_field_callback() {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['textarea_field'] ) ? $options['textarea_field'] : '';
    ?>
    <textarea name="my_plugin_settings[textarea_field]"
              rows="5"
              cols="50"
              class="large-text code"><?php echo esc_textarea( $value ); ?></textarea>
    <?php
}
```

### Number Field

```php
function number_field_callback() {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['number_field'] ) ? $options['number_field'] : 0;
    ?>
    <input type="number"
           name="my_plugin_settings[number_field]"
           value="<?php echo esc_attr( $value ); ?>"
           min="0"
           max="100"
           step="1"
           class="small-text">
    <?php
}
```

### Radio Buttons

```php
function radio_field_callback() {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['radio_field'] ) ? $options['radio_field'] : 'choice1';
    ?>
    <fieldset>
        <label>
            <input type="radio"
                   name="my_plugin_settings[radio_field]"
                   value="choice1"
                   <?php checked( $value, 'choice1' ); ?>>
            <?php _e( 'Choice 1' ); ?>
        </label><br>
        <label>
            <input type="radio"
                   name="my_plugin_settings[radio_field]"
                   value="choice2"
                   <?php checked( $value, 'choice2' ); ?>>
            <?php _e( 'Choice 2' ); ?>
        </label><br>
        <label>
            <input type="radio"
                   name="my_plugin_settings[radio_field]"
                   value="choice3"
                   <?php checked( $value, 'choice3' ); ?>>
            <?php _e( 'Choice 3' ); ?>
        </label>
    </fieldset>
    <?php
}
```

### Color Picker

```php
add_action( 'admin_enqueue_scripts', 'enqueue_color_picker' );

function enqueue_color_picker( $hook ) {
    if ( 'settings_page_my-plugin-settings' !== $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    wp_add_inline_script( 'wp-color-picker', "
        jQuery(document).ready(function($) {
            $('.my-color-picker').wpColorPicker();
        });
    " );
}

function color_field_callback() {
    $options = get_option( 'my_plugin_settings' );
    $value   = isset( $options['color_field'] ) ? $options['color_field'] : '#ffffff';
    ?>
    <input type="text"
           name="my_plugin_settings[color_field]"
           value="<?php echo esc_attr( $value ); ?>"
           class="my-color-picker"
           data-default-color="#ffffff">
    <?php
}
```

### Media/Image Upload

```php
function image_field_callback() {
    $options  = get_option( 'my_plugin_settings' );
    $image_id = isset( $options['image_field'] ) ? $options['image_field'] : 0;
    $image    = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : '';
    ?>
    <div class="image-preview">
        <?php if ( $image ) : ?>
            <img src="<?php echo esc_url( $image ); ?>" style="max-width: 150px;">
        <?php endif; ?>
    </div>
    <input type="hidden"
           name="my_plugin_settings[image_field]"
           id="image_field"
           value="<?php echo esc_attr( $image_id ); ?>">
    <button type="button" class="button" id="upload_image">
        <?php _e( 'Select Image' ); ?>
    </button>
    <button type="button" class="button" id="remove_image" 
            style="<?php echo $image_id ? '' : 'display:none;'; ?>">
        <?php _e( 'Remove' ); ?>
    </button>
    <?php
}
```

## Multiple Sections

```php
add_action( 'admin_init', 'register_multiple_sections' );

function register_multiple_sections() {
    // General section
    add_settings_section(
        'general_section',
        __( 'General' ),
        'general_section_callback',
        'my-plugin-settings'
    );
    
    // Display section
    add_settings_section(
        'display_section',
        __( 'Display' ),
        'display_section_callback',
        'my-plugin-settings'
    );
    
    // Advanced section
    add_settings_section(
        'advanced_section',
        __( 'Advanced' ),
        'advanced_section_callback',
        'my-plugin-settings'
    );
}
```

## Tabbed Settings Page

```php
function my_plugin_tabbed_settings_page() {
    $active_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'general';
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <h2 class="nav-tab-wrapper">
            <a href="?page=my-plugin-settings&tab=general"
               class="nav-tab <?php echo $active_tab === 'general' ? 'nav-tab-active' : ''; ?>">
                <?php _e( 'General' ); ?>
            </a>
            <a href="?page=my-plugin-settings&tab=display"
               class="nav-tab <?php echo $active_tab === 'display' ? 'nav-tab-active' : ''; ?>">
                <?php _e( 'Display' ); ?>
            </a>
            <a href="?page=my-plugin-settings&tab=advanced"
               class="nav-tab <?php echo $active_tab === 'advanced' ? 'nav-tab-active' : ''; ?>">
                <?php _e( 'Advanced' ); ?>
            </a>
        </h2>
        
        <form action="options.php" method="post">
            <?php
            switch ( $active_tab ) {
                case 'display':
                    settings_fields( 'my_plugin_display_options' );
                    do_settings_sections( 'my-plugin-display' );
                    break;
                case 'advanced':
                    settings_fields( 'my_plugin_advanced_options' );
                    do_settings_sections( 'my-plugin-advanced' );
                    break;
                default:
                    settings_fields( 'my_plugin_general_options' );
                    do_settings_sections( 'my-plugin-general' );
            }
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
```

## Settings Errors

### add_settings_error()

Display error/success messages.

```php
add_settings_error(
    string $setting,
    string $code,
    string $message,
    string $type = 'error'  // 'error', 'success', 'warning', 'info'
);
```

**Example in Sanitization:**

```php
function my_plugin_sanitize_settings( $input ) {
    $sanitized = array();
    
    if ( empty( $input['required_field'] ) ) {
        add_settings_error(
            'my_plugin_settings',
            'required_field_error',
            __( 'Required field cannot be empty.' ),
            'error'
        );
        // Keep old value
        $old = get_option( 'my_plugin_settings' );
        $sanitized['required_field'] = $old['required_field'] ?? '';
    } else {
        $sanitized['required_field'] = sanitize_text_field( $input['required_field'] );
    }
    
    return $sanitized;
}
```

### settings_errors()

Display registered errors:

```php
function my_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        
        <?php settings_errors(); ?>
        
        <form action="options.php" method="post">
            <!-- ... -->
        </form>
    </div>
    <?php
}
```

## REST API Integration

```php
register_setting( 'my_plugin_options', 'my_plugin_api_setting', array(
    'type'         => 'string',
    'show_in_rest' => true,
    'default'      => '',
) );

// Or with detailed schema
register_setting( 'my_plugin_options', 'my_plugin_complex_setting', array(
    'type'         => 'object',
    'show_in_rest' => array(
        'schema' => array(
            'type'       => 'object',
            'properties' => array(
                'enabled' => array(
                    'type' => 'boolean',
                ),
                'count' => array(
                    'type' => 'integer',
                ),
            ),
        ),
    ),
) );
```

## Hooks

| Hook | Description |
|------|-------------|
| `pre_update_option_{option}` | Before option is updated |
| `update_option_{option}` | After option is updated |
| `add_option_{option}` | When option is first added |
| `admin_init` | When to register settings |

## Best Practices

1. **Group Related Settings**: Use a single option for related settings (array)
2. **Sanitize Everything**: Always validate and sanitize input
3. **Use Nonces**: `settings_fields()` handles this automatically
4. **Provide Defaults**: Use `default` in `register_setting()`
5. **Check Capabilities**: Use appropriate capability for menu page
6. **Escape Output**: Always escape when displaying values
