# WP_Customize_Manager

The central orchestrator class for the WordPress Customizer. It serves as a factory for settings, sections, panels, and controls, and manages the entire customization workflow including theme preview, changesets, and the save process.

**File:** `wp-includes/class-wp-customize-manager.php`  
**Since:** WordPress 3.4.0

## Class Synopsis

```php
final class WP_Customize_Manager {
    // Properties
    protected $theme;                        // WP_Theme being previewed
    protected $original_stylesheet;          // Original active theme
    protected $previewing = false;           // Whether previewing
    public $widgets;                         // WP_Customize_Widgets instance
    public $nav_menus;                       // WP_Customize_Nav_Menus instance
    public $selective_refresh;               // WP_Customize_Selective_Refresh instance
    protected $settings = array();           // Registered settings
    protected $panels = array();             // Registered panels
    protected $sections = array();           // Registered sections
    protected $controls = array();           // Registered controls
    protected $containers = array();         // Sorted panels/sections
    
    // Core methods documented below...
}
```

## Constructor

```php
public function __construct( array $args = array() )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `changeset_uuid` | `string\|false\|null` | Changeset UUID. `null` generates new. `false` determines at runtime. |
| `theme` | `string` | Theme to preview (for theme switching) |
| `messenger_channel` | `string` | Messenger channel for pane-preview communication |
| `settings_previewed` | `bool` | Whether settings should be previewed. Default `true` |
| `branching` | `bool` | Whether changeset branching is allowed. Default `true` |
| `autosaved` | `bool` | Load autosave revision data. Default `false` |

## Settings Methods

### add_setting()

Registers a customize setting.

```php
public function add_setting( $id, array $args = array() ): WP_Customize_Setting
```

**Parameters:**
- `$id` - Setting ID or `WP_Customize_Setting` instance
- `$args` - Setting arguments (see `WP_Customize_Setting`)

**Example:**
```php
$wp_customize->add_setting( 'site_title_color', array(
    'default'           => '#000000',
    'type'              => 'theme_mod',
    'capability'        => 'edit_theme_options',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
) );
```

### get_setting()

Retrieves a registered setting.

```php
public function get_setting( string $id ): WP_Customize_Setting|void
```

### remove_setting()

Removes a registered setting.

```php
public function remove_setting( string $id ): void
```

### settings()

Returns all registered settings.

```php
public function settings(): array
```

### add_dynamic_settings()

Registers dynamically-created settings from POST data.

```php
public function add_dynamic_settings( array $setting_ids ): array
```

## Panel Methods

### add_panel()

Registers a customize panel.

```php
public function add_panel( $id, array $args = array() ): WP_Customize_Panel
```

**Example:**
```php
$wp_customize->add_panel( 'theme_options', array(
    'title'       => __( 'Theme Options' ),
    'description' => __( 'Configure theme settings' ),
    'priority'    => 10,
) );
```

### get_panel()

```php
public function get_panel( string $id ): WP_Customize_Panel|void
```

### remove_panel()

```php
public function remove_panel( string $id ): void
```

### panels()

```php
public function panels(): array
```

### register_panel_type()

Registers a panel type for JS rendering.

```php
public function register_panel_type( string $panel ): void
```

## Section Methods

### add_section()

Registers a customize section.

```php
public function add_section( $id, array $args = array() ): WP_Customize_Section
```

**Example:**
```php
$wp_customize->add_section( 'header_settings', array(
    'title'    => __( 'Header' ),
    'panel'    => 'theme_options',
    'priority' => 20,
) );
```

### get_section()

```php
public function get_section( string $id ): WP_Customize_Section|void
```

### remove_section()

```php
public function remove_section( string $id ): void
```

### sections()

```php
public function sections(): array
```

### register_section_type()

```php
public function register_section_type( string $section ): void
```

## Control Methods

### add_control()

Registers a customize control.

```php
public function add_control( $id, array $args = array() ): WP_Customize_Control
```

**Examples:**
```php
// Basic control
$wp_customize->add_control( 'site_title_color', array(
    'label'   => __( 'Title Color' ),
    'section' => 'header_settings',
    'type'    => 'text',
) );

// Specialized control
$wp_customize->add_control( new WP_Customize_Color_Control(
    $wp_customize,
    'header_bg',
    array(
        'label'   => __( 'Background Color' ),
        'section' => 'header_settings',
    )
) );
```

### get_control()

```php
public function get_control( string $id ): WP_Customize_Control|void
```

### remove_control()

```php
public function remove_control( string $id ): void
```

### controls()

```php
public function controls(): array
```

### register_control_type()

Registers a control type for JS rendering.

```php
public function register_control_type( string $control ): void
```

## Changeset Methods

### changeset_uuid()

Gets the changeset UUID.

```php
public function changeset_uuid(): string
```

### changeset_post_id()

Gets the changeset post ID.

```php
public function changeset_post_id(): int|null
```

### changeset_data()

Gets the changeset data array.

```php
public function changeset_data(): array
```

### save_changeset_post()

Saves the changeset post.

```php
public function save_changeset_post( array $args = array() ): array|WP_Error
```

**Parameters:**
- `status` - Post status (draft, pending, publish, future)
- `title` - Post title
- `date_gmt` - Date in GMT
- `data` - Additional changeset data
- `user_id` - User ID saving the changeset
- `starter_content` - Whether this is starter content
- `autosave` - Create autosave revision

### find_changeset_post_id()

Finds changeset post by UUID.

```php
public function find_changeset_post_id( string $uuid ): int|null
```

### trash_changeset_post()

Trashes or deletes a changeset.

```php
public function trash_changeset_post( $post ): WP_Post|mixed
```

## Preview Methods

### is_preview()

Checks if currently previewing.

```php
public function is_preview(): bool
```

### is_theme_active()

Checks if previewing the active theme.

```php
public function is_theme_active(): bool
```

### theme()

Gets the theme being previewed.

```php
public function theme(): WP_Theme
```

### start_previewing_theme()

Begins theme preview mode.

```php
public function start_previewing_theme(): void
```

### stop_previewing_theme()

Ends theme preview mode.

```php
public function stop_previewing_theme(): void
```

## Value Methods

### post_value()

Gets the sanitized value for a setting from POST/changeset.

```php
public function post_value( WP_Customize_Setting $setting, $default = null ): mixed
```

### set_post_value()

Overrides a setting's value in the customized state.

```php
public function set_post_value( string $setting_id, $value ): void
```

### unsanitized_post_values()

Gets dirty pre-sanitized values from all sources.

```php
public function unsanitized_post_values( array $args = array() ): array
```

### validate_setting_values()

Validates multiple setting values.

```php
public function validate_setting_values( array $setting_values, array $options = array() ): array
```

## Theme Methods

### get_template()

Gets the template name.

```php
public function get_template(): string
```

### get_stylesheet()

Gets the stylesheet name.

```php
public function get_stylesheet(): string
```

### get_template_root()

Gets the template root directory.

```php
public function get_template_root(): string
```

### get_stylesheet_root()

Gets the stylesheet root directory.

```php
public function get_stylesheet_root(): string
```

## State Methods

### settings_previewed()

Whether settings are being previewed.

```php
public function settings_previewed(): bool
```

### autosaved()

Whether loading autosave data.

```php
public function autosaved(): bool
```

### branching()

Whether changeset branching is allowed.

```php
public function branching(): bool
```

### doing_ajax()

Whether this is a Customizer Ajax request.

```php
public function doing_ajax( string $action = null ): bool
```

## Nonce Methods

### get_nonces()

Gets all Customizer nonces.

```php
public function get_nonces(): array
```

Returns nonces for:
- `save` - Saving changeset
- `preview` - Preview operations
- `dismiss_autosave_or_lock` - Dismissing autosaves
- `override_lock` - Taking over locked changesets
- `trash` - Trashing changesets

## URL Methods

### get_return_url()

Gets the URL to return to after closing Customizer.

```php
public function get_return_url(): string
```

### set_return_url()

Sets the return URL.

```php
public function set_return_url( string $return_url ): void
```

### get_preview_url()

Gets the initial preview URL.

```php
public function get_preview_url(): string
```

### set_preview_url()

Sets the preview URL.

```php
public function set_preview_url( string $preview_url ): void
```

### get_allowed_urls()

Gets URLs allowed for preview.

```php
public function get_allowed_urls(): array
```

## Autofocus

### get_autofocus()

Gets autofocus targets.

```php
public function get_autofocus(): array
```

### set_autofocus()

Sets autofocus targets.

```php
public function set_autofocus( array $autofocus ): void
```

**Example:**
```php
$wp_customize->set_autofocus( array(
    'section' => 'header_settings',
    'control' => 'site_title_color',
) );
```

## Registered Types

The manager automatically registers core panel, section, and control types:

### Panels
- `WP_Customize_Panel`
- `WP_Customize_Themes_Panel`

### Sections
- `WP_Customize_Section`
- `WP_Customize_Sidebar_Section`
- `WP_Customize_Themes_Section`

### Controls
- `WP_Customize_Color_Control`
- `WP_Customize_Media_Control`
- `WP_Customize_Upload_Control`
- `WP_Customize_Image_Control`
- `WP_Customize_Background_Image_Control`
- `WP_Customize_Background_Position_Control`
- `WP_Customize_Cropped_Image_Control`
- `WP_Customize_Site_Icon_Control`
- `WP_Customize_Theme_Control`
- `WP_Customize_Code_Editor_Control`
- `WP_Customize_Date_Time_Control`

## Core Components

The manager instantiates these component classes:

```php
$this->selective_refresh = new WP_Customize_Selective_Refresh( $this );
$this->widgets = new WP_Customize_Widgets( $this ); // If not block theme
$this->nav_menus = new WP_Customize_Nav_Menus( $this );
```

## Global Instance

WordPress creates a global manager instance:

```php
global $wp_customize;
// or
$wp_customize = $GLOBALS['wp_customize'];
```

Access it in the `customize_register` action:

```php
add_action( 'customize_register', function( $wp_customize ) {
    // $wp_customize is the manager instance
} );
```
