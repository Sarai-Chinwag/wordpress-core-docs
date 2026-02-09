# WP_Customize_Control

The UI element class for the Customizer. Controls provide the interface for users to modify settings, including input fields, dropdowns, color pickers, and media selectors.

**File:** `wp-includes/class-wp-customize-control.php`  
**Since:** WordPress 3.4.0

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Customize_Control {
    protected static $instance_count = 0;    // Instance counter
    public $instance_number;                  // Instance order
    public $manager;                          // WP_Customize_Manager
    public $id;                               // Control ID
    public $settings;                         // All linked settings
    public $setting = 'default';              // Primary setting
    public $capability;                       // Required capability
    public $priority = 10;                    // Display order
    public $section = '';                     // Parent section ID
    public $label = '';                       // Control label
    public $description = '';                 // Control description
    public $choices = array();                // Options for select/radio
    public $input_attrs = array();            // HTML input attributes
    public $allow_addition = false;           // Allow adding content
    public $type = 'text';                    // Control type
    public $active_callback = '';             // Active callback
    public $json = array();                   // JSON export data
}
```

## Constructor

```php
public function __construct( 
    WP_Customize_Manager $manager, 
    string $id, 
    array $args = array() 
)
```

### Arguments

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `settings` | `string\|array` | ID | Setting ID(s) to link |
| `setting` | `string` | `'default'` | Primary setting key |
| `capability` | `string` | `''` | Override capability (usually inherited) |
| `priority` | `int` | `10` | Display order |
| `section` | `string` | `''` | Parent section ID (required) |
| `label` | `string` | `''` | Control label |
| `description` | `string` | `''` | Control description |
| `choices` | `array` | `array()` | Options for select/radio |
| `input_attrs` | `array` | `array()` | HTML attributes |
| `allow_addition` | `bool` | `false` | Allow adding (dropdown-pages) |
| `type` | `string` | `'text'` | Control type |
| `active_callback` | `callable` | `''` | Visibility callback |

## Built-in Control Types

### Basic Types (via `type` argument)

| Type | Description |
|------|-------------|
| `text` | Text input (default) |
| `checkbox` | Single checkbox |
| `textarea` | Multi-line text |
| `radio` | Radio buttons (requires `choices`) |
| `select` | Dropdown select (requires `choices`) |
| `dropdown-pages` | WordPress page selector |
| `email` | Email input |
| `url` | URL input |
| `number` | Number input |
| `hidden` | Hidden field |
| `date` | Date input |

### Examples

```php
// Text input
$wp_customize->add_control( 'site_title', array(
    'label'   => __( 'Site Title' ),
    'section' => 'title_tagline',
    'type'    => 'text',
) );

// Checkbox
$wp_customize->add_control( 'show_title', array(
    'label'   => __( 'Display Site Title' ),
    'section' => 'title_tagline',
    'type'    => 'checkbox',
) );

// Select dropdown
$wp_customize->add_control( 'layout', array(
    'label'   => __( 'Layout' ),
    'section' => 'layout_section',
    'type'    => 'select',
    'choices' => array(
        'left'  => __( 'Left Sidebar' ),
        'right' => __( 'Right Sidebar' ),
        'full'  => __( 'Full Width' ),
    ),
) );

// Radio buttons
$wp_customize->add_control( 'blog_style', array(
    'label'   => __( 'Blog Style' ),
    'section' => 'blog_section',
    'type'    => 'radio',
    'choices' => array(
        'grid' => __( 'Grid' ),
        'list' => __( 'List' ),
    ),
) );

// Textarea
$wp_customize->add_control( 'footer_text', array(
    'label'       => __( 'Footer Text' ),
    'section'     => 'footer_section',
    'type'        => 'textarea',
    'input_attrs' => array(
        'rows' => 5,
    ),
) );

// Number with attributes
$wp_customize->add_control( 'posts_per_page', array(
    'label'       => __( 'Posts Per Page' ),
    'section'     => 'blog_section',
    'type'        => 'number',
    'input_attrs' => array(
        'min'  => 1,
        'max'  => 50,
        'step' => 1,
    ),
) );
```

## Specialized Control Classes

### WP_Customize_Color_Control

Color picker with alpha support:

```php
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'header_color',
    array(
        'label'   => __( 'Header Color' ),
        'section' => 'colors',
    )
) );
```

### WP_Customize_Media_Control

Media library attachment selector:

```php
$wp_customize->add_control( new WP_Customize_Media_Control(
    $wp_customize,
    'featured_video',
    array(
        'label'     => __( 'Featured Video' ),
        'section'   => 'media_section',
        'mime_type' => 'video',
    )
) );
```

### WP_Customize_Image_Control

Image uploader:

```php
$wp_customize->add_control( new WP_Customize_Image_Control(
    $wp_customize,
    'logo',
    array(
        'label'   => __( 'Logo' ),
        'section' => 'title_tagline',
    )
) );
```

### WP_Customize_Upload_Control

File uploader:

```php
$wp_customize->add_control( new WP_Customize_Upload_Control(
    $wp_customize,
    'custom_file',
    array(
        'label'   => __( 'Upload File' ),
        'section' => 'files_section',
    )
) );
```

### WP_Customize_Cropped_Image_Control

Image with cropping:

```php
$wp_customize->add_control( new WP_Customize_Cropped_Image_Control(
    $wp_customize,
    'banner_image',
    array(
        'label'       => __( 'Banner Image' ),
        'section'     => 'header_section',
        'width'       => 1200,
        'height'      => 400,
        'flex_width'  => true,
        'flex_height' => false,
    )
) );
```

### WP_Customize_Code_Editor_Control

Syntax-highlighted code editor:

```php
$wp_customize->add_control( new WP_Customize_Code_Editor_Control(
    $wp_customize,
    'custom_css_control',
    array(
        'label'       => __( 'Custom CSS' ),
        'section'     => 'custom_css',
        'code_type'   => 'text/css',
        'input_attrs' => array(
            'aria-describedby' => 'custom-css-description',
        ),
    )
) );
```

### WP_Customize_Date_Time_Control

Date/time picker:

```php
$wp_customize->add_control( new WP_Customize_Date_Time_Control(
    $wp_customize,
    'event_date',
    array(
        'label'        => __( 'Event Date' ),
        'section'      => 'events_section',
        'include_time' => true,
        'twelve_hour_format' => true,
    )
) );
```

## Core Methods

### active()

Checks if the control is active.

```php
final public function active(): bool
```

### active_callback()

Default callback returning `true`.

```php
public function active_callback(): true
```

### value()

Gets the setting's value.

```php
final public function value( string $setting_key = 'default' ): mixed
```

### check_capabilities()

Validates user can use this control.

```php
final public function check_capabilities(): bool
```

### enqueue()

Enqueues control-specific scripts/styles.

```php
public function enqueue(): void
```

Override in custom controls:

```php
public function enqueue() {
    wp_enqueue_script( 'my-control-js', get_template_directory_uri() . '/js/control.js' );
    wp_enqueue_style( 'my-control-css', get_template_directory_uri() . '/css/control.css' );
}
```

### json() / to_json()

Gets/prepares data for JavaScript.

```php
public function json(): array
public function to_json(): void
```

### get_content()

Gets the control's HTML content.

```php
final public function get_content(): string
```

### maybe_render()

Checks capabilities and renders.

```php
final public function maybe_render(): void
```

### render()

Renders the control wrapper.

```php
protected function render(): void
```

### render_content()

Renders the control's content.

```php
protected function render_content(): void
```

### get_link()

Gets the data-link attribute for a setting.

```php
public function get_link( string $setting_key = 'default' ): string
```

### link()

Outputs the data-link attribute.

```php
public function link( string $setting_key = 'default' ): void
```

### input_attrs()

Renders custom input attributes.

```php
public function input_attrs(): void
```

### print_template()

Prints the JS template.

```php
final public function print_template(): void
```

### content_template()

Underscore.js template for content.

```php
protected function content_template(): void
```

## Creating Custom Controls

### Basic Custom Control

```php
class My_Range_Control extends WP_Customize_Control {
    public $type = 'range';
    
    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <input type="range" 
                   <?php $this->input_attrs(); ?>
                   value="<?php echo esc_attr( $this->value() ); ?>"
                   <?php $this->link(); ?>>
        </label>
        <?php
    }
}

// Usage
$wp_customize->add_control( new My_Range_Control(
    $wp_customize,
    'opacity',
    array(
        'label'       => __( 'Opacity' ),
        'section'     => 'my_section',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 5,
        ),
    )
) );
```

### JS-Rendered Control

```php
class My_Advanced_Control extends WP_Customize_Control {
    public $type = 'my-advanced';
    
    public function enqueue() {
        wp_enqueue_script( 
            'my-advanced-control', 
            get_template_directory_uri() . '/js/my-control.js',
            array( 'customize-controls' ),
            '1.0',
            true
        );
    }
    
    public function to_json() {
        parent::to_json();
        $this->json['myCustomData'] = $this->get_custom_data();
    }
    
    protected function content_template() {
        ?>
        <label>
            <# if ( data.label ) { #>
                <span class="customize-control-title">{{ data.label }}</span>
            <# } #>
            <# if ( data.description ) { #>
                <span class="description customize-control-description">{{{ data.description }}}</span>
            <# } #>
            <div class="my-advanced-control-content">
                <!-- Custom template -->
            </div>
        </label>
        <?php
    }
}

// Register the type for JS rendering
$wp_customize->register_control_type( 'My_Advanced_Control' );
```

## Multiple Settings

Controls can link to multiple settings:

```php
$wp_customize->add_control( 'background_position', array(
    'label'    => __( 'Background Position' ),
    'section'  => 'background_image',
    'settings' => array(
        'x' => 'background_position_x',
        'y' => 'background_position_y',
    ),
) );
```

Access in template:
```php
<input type="text" <?php $this->link( 'x' ); ?>>
<input type="text" <?php $this->link( 'y' ); ?>>
```

## Active Callbacks

Control visibility based on context:

```php
$wp_customize->add_control( 'sidebar_position', array(
    'label'           => __( 'Sidebar Position' ),
    'section'         => 'layout_section',
    'type'            => 'select',
    'choices'         => array( 'left' => 'Left', 'right' => 'Right' ),
    'active_callback' => function( $control ) {
        return $control->manager->get_setting( 'show_sidebar' )->value();
    },
) );
```

## Input Attributes

Add custom HTML attributes:

```php
$wp_customize->add_control( 'custom_width', array(
    'label'       => __( 'Width' ),
    'section'     => 'dimensions',
    'type'        => 'number',
    'input_attrs' => array(
        'min'         => 100,
        'max'         => 2000,
        'step'        => 10,
        'class'       => 'my-custom-class',
        'placeholder' => __( 'Enter width...' ),
        'data-unit'   => 'px',
    ),
) );
```

## Complete Example

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Add section
    $wp_customize->add_section( 'hero_section', array(
        'title' => __( 'Hero Section' ),
    ) );
    
    // Show/hide toggle
    $wp_customize->add_setting( 'show_hero', array(
        'default' => true,
    ) );
    $wp_customize->add_control( 'show_hero', array(
        'label'   => __( 'Show Hero Section' ),
        'section' => 'hero_section',
        'type'    => 'checkbox',
    ) );
    
    // Hero title
    $wp_customize->add_setting( 'hero_title', array(
        'default'           => 'Welcome',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'hero_title', array(
        'label'           => __( 'Hero Title' ),
        'section'         => 'hero_section',
        'type'            => 'text',
        'active_callback' => function( $control ) {
            return $control->manager->get_setting( 'show_hero' )->value();
        },
    ) );
    
    // Hero image
    $wp_customize->add_setting( 'hero_image' );
    $wp_customize->add_control( new WP_Customize_Image_Control(
        $wp_customize,
        'hero_image',
        array(
            'label'           => __( 'Hero Image' ),
            'section'         => 'hero_section',
            'active_callback' => function( $control ) {
                return $control->manager->get_setting( 'show_hero' )->value();
            },
        )
    ) );
    
    // Hero overlay color
    $wp_customize->add_setting( 'hero_overlay_color', array(
        'default'           => 'rgba(0,0,0,0.5)',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'hero_overlay_color',
        array(
            'label'           => __( 'Overlay Color' ),
            'section'         => 'hero_section',
            'active_callback' => function( $control ) {
                return $control->manager->get_setting( 'show_hero' )->value();
            },
        )
    ) );
} );
```
