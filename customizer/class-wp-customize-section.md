# WP_Customize_Section

A UI container for controls in the Customizer. Sections group related controls together and can optionally be placed inside panels for additional organization.

**File:** `wp-includes/class-wp-customize-section.php`  
**Since:** WordPress 3.4.0

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Customize_Section {
    protected static $instance_count = 0;    // Instance counter
    public $instance_number;                  // Instance order
    public $manager;                          // WP_Customize_Manager
    public $id;                               // Unique identifier
    public $priority = 160;                   // Display order
    public $panel = '';                       // Parent panel ID
    public $capability = 'edit_theme_options'; // Required capability
    public $theme_supports = '';              // Required theme features
    public $title = '';                       // UI title
    public $description = '';                 // UI description
    public $controls;                         // Contained controls
    public $type = 'default';                 // Section type
    public $active_callback = '';             // Active callback
    public $description_hidden = false;       // Hide description behind help icon
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
| `priority` | `int` | `160` | Display order (lower = earlier) |
| `panel` | `string` | `''` | Parent panel ID |
| `capability` | `string` | `'edit_theme_options'` | Required capability |
| `theme_supports` | `string\|array` | `''` | Required theme features |
| `title` | `string` | `''` | Section title shown in UI |
| `description` | `string` | `''` | Section description |
| `type` | `string` | `'default'` | Section type for JS templates |
| `active_callback` | `callable` | `''` | Callback to determine visibility |
| `description_hidden` | `bool` | `false` | Hide description behind help icon |

## Registration

### Adding a Section

```php
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'header_options', array(
        'title'       => __( 'Header Options' ),
        'description' => __( 'Configure the site header.' ),
        'priority'    => 30,
    ) );
} );
```

### Adding to a Panel

```php
$wp_customize->add_section( 'header_colors', array(
    'title' => __( 'Header Colors' ),
    'panel' => 'theme_options', // Parent panel ID
) );
```

## Core Methods

### active()

Checks if the section is active for the current preview.

```php
final public function active(): bool
```

Calls the `active_callback` and applies the `customize_section_active` filter.

### active_callback()

Default callback that always returns `true`.

```php
public function active_callback(): true
```

Override for conditional visibility:

```php
$wp_customize->add_section( 'header_options', array(
    'title'           => __( 'Header Options' ),
    'active_callback' => function( $section ) {
        return is_front_page();
    },
) );
```

### check_capabilities()

Validates user capabilities and theme support.

```php
final public function check_capabilities(): bool
```

### json()

Gathers parameters for JavaScript.

```php
public function json(): array
```

Returns:
```php
array(
    'id'                => $this->id,
    'title'             => html_entity_decode( $this->title ),
    'description'       => $this->description,
    'priority'          => $this->priority,
    'panel'             => $this->panel,
    'type'              => $this->type,
    'description_hidden' => $this->description_hidden,
    'content'           => $this->get_content(),
    'active'            => $this->active(),
    'instanceNumber'    => $this->instance_number,
    'customizeAction'   => __( 'Customizing' ) . ' ▸ ' . $panel_title,
)
```

### get_content()

Gets the section's content for the Customizer pane.

```php
final public function get_content(): string
```

### maybe_render()

Checks capabilities and renders if valid.

```php
final public function maybe_render(): void
```

### render()

Renders the section UI. Overridable in subclasses.

```php
protected function render(): void
```

Default implementation is empty (rendered via JS template).

### print_template()

Prints the section's JS template.

```php
public function print_template(): void
```

### render_template()

Underscore.js template for the section.

```php
protected function render_template(): void
```

## Default Priorities

Core sections use these default priorities:

| Section | Priority |
|---------|----------|
| `title_tagline` | 20 |
| `colors` | 40 |
| `header_image` | 60 |
| `background_image` | 80 |
| `static_front_page` | 120 |
| `custom_css` | 200 |

## Specialized Section Classes

The `customize/` directory contains specialized sections:

| Class | Purpose |
|-------|---------|
| `WP_Customize_Themes_Section` | Theme browser section |
| `WP_Customize_Sidebar_Section` | Widget area sections |
| `WP_Customize_Nav_Menu_Section` | Navigation menu sections |

### WP_Customize_Themes_Section

Section for browsing and previewing themes:

```php
$wp_customize->add_section( new WP_Customize_Themes_Section( $wp_customize, 'themes', array(
    'title'      => __( 'Themes' ),
    'capability' => 'switch_themes',
) ) );
```

### WP_Customize_Sidebar_Section

Sections for widget areas (sidebars):

```php
$wp_customize->add_section( new WP_Customize_Sidebar_Section( $wp_customize, 'sidebar-widgets-footer', array(
    'title' => __( 'Footer' ),
    'panel' => 'widgets',
) ) );
```

### WP_Customize_Nav_Menu_Section

Sections for navigation menus:

```php
$wp_customize->add_section( new WP_Customize_Nav_Menu_Section( $wp_customize, 'nav_menu[123]', array(
    'title' => 'Main Menu',
    'panel' => 'nav_menus',
) ) );
```

## Custom Section Types

Create custom section types for specialized UI:

```php
class My_Custom_Section extends WP_Customize_Section {
    public $type = 'my-custom';
    
    protected function render_template() {
        ?>
        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
            <h3 class="accordion-section-title">
                <button type="button" class="accordion-trigger" aria-expanded="false">
                    {{ data.title }}
                </button>
            </h3>
            <ul class="accordion-section-content">
                <!-- Custom content structure -->
                <li class="customize-section-description-container">
                    <div class="customize-section-title">
                        <button class="customize-section-back" tabindex="-1">
                            <span class="screen-reader-text"><?php _e( 'Back' ); ?></span>
                        </button>
                        <h3>{{ data.title }}</h3>
                    </div>
                    <# if ( data.description ) { #>
                        <div class="description">{{{ data.description }}}</div>
                    <# } #>
                </li>
            </ul>
        </li>
        <?php
    }
}

// Register the type
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->register_section_type( 'My_Custom_Section' );
    
    $wp_customize->add_section( new My_Custom_Section( $wp_customize, 'my_section', array(
        'title' => __( 'My Section' ),
    ) ) );
} );
```

## Active Callbacks

Control section visibility based on context:

### By Page Type

```php
$wp_customize->add_section( 'homepage_options', array(
    'title'           => __( 'Homepage Options' ),
    'active_callback' => 'is_front_page',
) );
```

### By Setting Value

```php
$wp_customize->add_section( 'slider_options', array(
    'title'           => __( 'Slider Options' ),
    'active_callback' => function() {
        return get_theme_mod( 'show_slider', false );
    },
) );
```

### Complex Logic

```php
$wp_customize->add_section( 'woocommerce_options', array(
    'title'           => __( 'Shop Options' ),
    'active_callback' => function( $section ) {
        return class_exists( 'WooCommerce' ) && is_shop();
    },
) );
```

## Removing Core Sections

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Remove the Colors section
    $wp_customize->remove_section( 'colors' );
    
    // Remove the Background Image section
    $wp_customize->remove_section( 'background_image' );
} );
```

## Modifying Existing Sections

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Change title
    $wp_customize->get_section( 'title_tagline' )->title = __( 'Site Identity' );
    
    // Change priority
    $wp_customize->get_section( 'colors' )->priority = 25;
    
    // Move to panel
    $wp_customize->get_section( 'colors' )->panel = 'my_panel';
    
    // Add description
    $wp_customize->get_section( 'header_image' )->description = __( 'Upload a header image.' );
} );
```

## Complete Example

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Create a panel
    $wp_customize->add_panel( 'theme_settings', array(
        'title'    => __( 'Theme Settings' ),
        'priority' => 30,
    ) );
    
    // Add sections to the panel
    $wp_customize->add_section( 'header_section', array(
        'title'       => __( 'Header' ),
        'description' => __( 'Configure header appearance.' ),
        'panel'       => 'theme_settings',
        'priority'    => 10,
    ) );
    
    $wp_customize->add_section( 'footer_section', array(
        'title'              => __( 'Footer' ),
        'description'        => __( 'Configure footer settings.' ),
        'description_hidden' => true, // Show behind help icon
        'panel'              => 'theme_settings',
        'priority'           => 20,
    ) );
    
    // Conditional section
    $wp_customize->add_section( 'blog_section', array(
        'title'           => __( 'Blog Options' ),
        'panel'           => 'theme_settings',
        'priority'        => 30,
        'active_callback' => function() {
            return is_home() || is_archive() || is_single();
        },
    ) );
} );
```
