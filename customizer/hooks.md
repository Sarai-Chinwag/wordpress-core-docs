# Customizer Hooks Reference

Comprehensive reference for all WordPress Customizer actions and filters.

## Registration Hooks

### customize_register

Primary hook for registering Customizer components.

```php
add_action( 'customize_register', function( WP_Customize_Manager $wp_customize ) {
    // Register panels, sections, settings, controls, partials
}, 10 );
```

**Priority notes:**
- Default: 10
- Core registers at 10
- Use 11+ to modify core components
- Dynamic settings registered at 11

### customize_loaded_components

Filters which core components to load.

```php
add_filter( 'customize_loaded_components', function( array $components, WP_Customize_Manager $manager ) {
    // Remove widgets component
    $components = array_diff( $components, array( 'widgets' ) );
    return $components;
}, 10, 2 );
```

**Default components:** `nav_menus`, `widgets` (classic themes only)

## Preview Hooks

### customize_preview_init

Fires when the Customizer preview initializes.

```php
add_action( 'customize_preview_init', function( WP_Customize_Manager $wp_customize ) {
    wp_enqueue_script( 'my-preview-js', get_template_directory_uri() . '/js/preview.js' );
} );
```

### start_previewing_theme

Fires when theme preview starts.

```php
add_action( 'start_previewing_theme', function( WP_Customize_Manager $manager ) {
    // Theme preview started
} );
```

### stop_previewing_theme

Fires when theme preview stops.

```php
add_action( 'stop_previewing_theme', function( WP_Customize_Manager $manager ) {
    // Theme preview ended
} );
```

### customize_controls_init

Fires when the Customizer controls are initialized.

```php
add_action( 'customize_controls_init', function() {
    // Controls ready
} );
```

### customize_controls_enqueue_scripts

Enqueue scripts for the Customizer pane.

```php
add_action( 'customize_controls_enqueue_scripts', function() {
    wp_enqueue_script( 'my-controls-js', get_template_directory_uri() . '/js/controls.js' );
    wp_enqueue_style( 'my-controls-css', get_template_directory_uri() . '/css/controls.css' );
} );
```

### customize_controls_print_footer_scripts

Print footer scripts in Customizer pane.

```php
add_action( 'customize_controls_print_footer_scripts', function() {
    ?>
    <script>
        // Footer scripts
    </script>
    <?php
} );
```

### customize_controls_print_styles

Print styles in Customizer pane.

```php
add_action( 'customize_controls_print_styles', function() {
    ?>
    <style>
        /* Custom styles */
    </style>
    <?php
} );
```

## Setting Hooks

### customize_sanitize_{$setting_id}

Filters a setting's value during sanitization.

```php
add_filter( 'customize_sanitize_my_setting', function( $value, WP_Customize_Setting $setting ) {
    return sanitize_text_field( $value );
}, 10, 2 );
```

### customize_validate_{$setting_id}

Validates a setting's value.

```php
add_filter( 'customize_validate_my_number', function( WP_Error $validity, $value, WP_Customize_Setting $setting ) {
    if ( $value < 0 ) {
        $validity->add( 'negative', __( 'Value must be positive.' ) );
    }
    return $validity;
}, 10, 3 );
```

### customize_sanitize_js_{$setting_id}

Filters a setting's value for JavaScript.

```php
add_filter( 'customize_sanitize_js_my_setting', function( $value, WP_Customize_Setting $setting ) {
    return esc_js( $value );
}, 10, 2 );
```

### customize_value_{$id_base}

Filters a custom setting type's value.

```php
add_filter( 'customize_value_my_custom_type', function( $value, WP_Customize_Setting $setting ) {
    return get_option( $setting->id, $setting->default );
}, 10, 2 );
```

### customize_update_{$setting_type}

Handle updates for custom setting types.

```php
add_action( 'customize_update_my_type', function( $value, WP_Customize_Setting $setting ) {
    // Save the value
    update_option( $setting->id, $value );
}, 10, 2 );
```

### customize_preview_{$setting_id}

Custom preview handling for a setting.

```php
add_action( 'customize_preview_my_setting', function( WP_Customize_Setting $setting ) {
    // Custom preview logic
} );
```

### customize_preview_{$setting_type}

Preview handling for a setting type.

```php
add_action( 'customize_preview_my_type', function( WP_Customize_Setting $setting ) {
    // Preview logic for all settings of this type
} );
```

## Dynamic Settings

### customize_dynamic_setting_args

Filters arguments for dynamic settings.

```php
add_filter( 'customize_dynamic_setting_args', function( $args, string $setting_id ) {
    if ( preg_match( '/^my_dynamic_(.+)$/', $setting_id ) ) {
        return array(
            'type'              => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        );
    }
    return $args;
}, 10, 2 );
```

### customize_dynamic_setting_class

Filters the class for dynamic settings.

```php
add_filter( 'customize_dynamic_setting_class', function( string $class, string $setting_id, $args ) {
    if ( strpos( $setting_id, 'my_special_' ) === 0 ) {
        return 'My_Custom_Setting';
    }
    return $class;
}, 10, 3 );
```

## Save Hooks

### customize_save

Fires before settings are saved.

```php
add_action( 'customize_save', function( WP_Customize_Manager $manager ) {
    // Before save
} );
```

### customize_save_{$id_base}

Fires when a specific setting is saved.

```php
add_action( 'customize_save_my_setting', function( WP_Customize_Setting $setting ) {
    // Setting being saved
} );
```

### customize_save_after

Fires after settings are saved.

```php
add_action( 'customize_save_after', function( WP_Customize_Manager $manager ) {
    // After save - good for cache clearing
    wp_cache_flush();
} );
```

### customize_save_validation_before

Fires before validation during save.

```php
add_action( 'customize_save_validation_before', function( WP_Customize_Manager $manager ) {
    // Add just-in-time validation filters
} );
```

### customize_save_response

Filters the save response.

```php
add_filter( 'customize_save_response', function( array $response, WP_Customize_Manager $manager ) {
    $response['my_data'] = 'custom data';
    return $response;
}, 10, 2 );
```

## Post Value Hooks

### customize_post_value_set_{$setting_id}

Fires when a specific setting's post value is set.

```php
add_action( 'customize_post_value_set_my_setting', function( $value, WP_Customize_Manager $manager ) {
    // Value was set
}, 10, 2 );
```

### customize_post_value_set

Fires when any setting's post value is set.

```php
add_action( 'customize_post_value_set', function( string $setting_id, $value, WP_Customize_Manager $manager ) {
    // Any setting value was set
}, 10, 3 );
```

## Changeset Hooks

### customize_changeset_branching

Filters whether changeset branching is allowed.

```php
add_filter( 'customize_changeset_branching', function( bool $allow, WP_Customize_Manager $manager ) {
    return true; // Enable branching
}, 10, 2 );
```

### customize_changeset_save_data

Filters changeset data before saving.

```php
add_filter( 'customize_changeset_save_data', function( array $data, array $context ) {
    // Modify data before saving
    return $data;
}, 10, 2 );
```

**Context array:**
- `uuid` - Changeset UUID
- `title` - Post title
- `status` - Post status
- `date_gmt` - Date in GMT
- `post_id` - Post ID or false
- `previous_data` - Previous data
- `manager` - WP_Customize_Manager instance

## Rendering Hooks

### customize_render_section

Fires before rendering any section.

```php
add_action( 'customize_render_section', function( WP_Customize_Section $section ) {
    // Before section renders
} );
```

### customize_render_section_{$section_id}

Fires before rendering a specific section.

```php
add_action( 'customize_render_section_my_section', function() {
    // Before my_section renders
} );
```

### customize_render_panel

Fires before rendering any panel.

```php
add_action( 'customize_render_panel', function( WP_Customize_Panel $panel ) {
    // Before panel renders
} );
```

### customize_render_panel_{$panel_id}

Fires before rendering a specific panel.

```php
add_action( 'customize_render_panel_my_panel', function() {
    // Before my_panel renders
} );
```

### customize_render_control

Fires before rendering any control.

```php
add_action( 'customize_render_control', function( WP_Customize_Control $control ) {
    // Before control renders
} );
```

### customize_render_control_{$control_id}

Fires before rendering a specific control.

```php
add_action( 'customize_render_control_my_control', function( WP_Customize_Control $control ) {
    // Before my_control renders
} );
```

## Active State Filters

### customize_section_active

Filters whether a section is active.

```php
add_filter( 'customize_section_active', function( bool $active, WP_Customize_Section $section ) {
    if ( $section->id === 'my_section' ) {
        return is_front_page();
    }
    return $active;
}, 10, 2 );
```

### customize_panel_active

Filters whether a panel is active.

```php
add_filter( 'customize_panel_active', function( bool $active, WP_Customize_Panel $panel ) {
    return $active;
}, 10, 2 );
```

### customize_control_active

Filters whether a control is active.

```php
add_filter( 'customize_control_active', function( bool $active, WP_Customize_Control $control ) {
    return $active;
}, 10, 2 );
```

## Selective Refresh Hooks

### customize_render_partials_before

Fires before rendering partials.

```php
add_action( 'customize_render_partials_before', function( WP_Customize_Selective_Refresh $refresh, array $partials ) {
    // Before partials render
}, 10, 2 );
```

### customize_render_partials_after

Fires after rendering partials.

```php
add_action( 'customize_render_partials_after', function( WP_Customize_Selective_Refresh $refresh, array $partials ) {
    // After partials render
}, 10, 2 );
```

### customize_render_partials_response

Filters the partial render response.

```php
add_filter( 'customize_render_partials_response', function( array $response, WP_Customize_Selective_Refresh $refresh, array $partials ) {
    // Add scripts/styles to response
    $response['scripts'] = array();
    $response['styles'] = array();
    return $response;
}, 10, 3 );
```

### customize_partial_render

Filters partial rendering.

```php
add_filter( 'customize_partial_render', function( $rendered, WP_Customize_Partial $partial, array $container_context ) {
    return $rendered;
}, 10, 3 );
```

### customize_partial_render_{$partial_id}

Filters specific partial rendering.

```php
add_filter( 'customize_partial_render_my_partial', function( $rendered, WP_Customize_Partial $partial, array $context ) {
    return $rendered;
}, 10, 3 );
```

### customize_dynamic_partial_args

Filters dynamic partial arguments.

```php
add_filter( 'customize_dynamic_partial_args', function( $args, string $partial_id ) {
    if ( strpos( $partial_id, 'widget_' ) === 0 ) {
        return array(
            'selector' => '.widget',
            'render_callback' => 'my_widget_render',
        );
    }
    return $args;
}, 10, 2 );
```

### customize_dynamic_partial_class

Filters the class for dynamic partials.

```php
add_filter( 'customize_dynamic_partial_class', function( string $class, string $partial_id, $args ) {
    return $class;
}, 10, 3 );
```

## Theme Hooks

### customize_allowed_urls

Filters URLs allowed for preview.

```php
add_filter( 'customize_allowed_urls', function( array $urls ) {
    $urls[] = 'https://cdn.example.com/';
    return $urls;
} );
```

## Common Patterns

### Conditional Component Registration

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Only register if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        $wp_customize->add_section( 'woo_options', array(
            'title' => __( 'Shop Options' ),
        ) );
    }
} );
```

### Modifying Core Components

```php
add_action( 'customize_register', function( $wp_customize ) {
    // Change title of Site Identity section
    $wp_customize->get_section( 'title_tagline' )->title = __( 'Branding' );
    
    // Move colors section into a panel
    $wp_customize->get_section( 'colors' )->panel = 'my_panel';
    
    // Remove a core control
    $wp_customize->remove_control( 'display_header_text' );
}, 20 ); // Priority 20 to run after core
```

### Cache Clearing on Save

```php
add_action( 'customize_save_after', function( $wp_customize ) {
    // Clear page cache
    if ( function_exists( 'wp_cache_clear_cache' ) ) {
        wp_cache_clear_cache();
    }
    
    // Clear transients
    delete_transient( 'my_cached_data' );
    
    // Regenerate CSS file
    my_generate_dynamic_css();
} );
```

### Cross-Setting Dependencies

```php
add_action( 'customize_controls_enqueue_scripts', function() {
    wp_add_inline_script( 'customize-controls', "
        wp.customize( 'show_feature', function( setting ) {
            wp.customize.control( 'feature_title', function( control ) {
                var visibility = function() {
                    control.active.set( setting.get() );
                };
                visibility();
                setting.bind( visibility );
            } );
        } );
    " );
} );
```
