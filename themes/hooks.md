# WordPress Theme Hooks Reference

Complete reference for theme-related action hooks and filters.

## Template Loading Actions

### template_redirect

Fires before determining which template to load.

```php
do_action( 'template_redirect' );
```

**Use Cases:**
- Redirects based on query conditions
- Early exits for specific requests
- Custom template handling

```php
add_action( 'template_redirect', function() {
    if ( is_singular( 'secret' ) && ! is_user_logged_in() ) {
        wp_redirect( wp_login_url( get_permalink() ) );
        exit;
    }
} );
```

**Warning:** Do not load alternative templates here with `exit()`. Use `template_include` filter instead.

---

### wp_before_include_template

Fires immediately before including the template.

```php
do_action( 'wp_before_include_template', string $template );
```

**Parameters:**
- `$template` - Path to the template file.

```php
add_action( 'wp_before_include_template', function( $template ) {
    // Start output buffering, performance monitoring, etc.
}, 10, 1 );
```

---

### wp_before_load_template

Fires before a template file is loaded.

```php
do_action( 'wp_before_load_template', string $_template_file, bool $load_once, array $args );
```

**Parameters:**
- `$_template_file` - Full path to the template.
- `$load_once` - Whether using require_once.
- `$args` - Arguments passed to template.

---

### wp_after_load_template

Fires after a template file is loaded.

```php
do_action( 'wp_after_load_template', string $_template_file, bool $load_once, array $args );
```

---

### get_template_part_{$slug}

Fires before the template part file is loaded.

```php
do_action( "get_template_part_{$slug}", string $slug, string|null $name, array $args );
```

**Example:**
```php
// For get_template_part( 'template-parts/content', 'single' )
add_action( 'get_template_part_template-parts/content', function( $slug, $name, $args ) {
    // Runs before loading content template part
}, 10, 3 );
```

---

### get_header

Fires before the header template part is loaded.

```php
do_action( 'get_header', string|null $name, array $args );
```

---

### get_footer

Fires before the footer template part is loaded.

```php
do_action( 'get_footer', string|null $name, array $args );
```

---

### get_sidebar

Fires before the sidebar template part is loaded.

```php
do_action( 'get_sidebar', string|null $name, array $args );
```

---

## Template Filters

### template_include

Filters the path of the current template.

```php
apply_filters( 'template_include', string $template ): string
```

**Use Case:** Override which template file is loaded.

```php
add_filter( 'template_include', function( $template ) {
    if ( is_singular( 'product' ) ) {
        $custom = locate_template( 'product-template.php' );
        if ( $custom ) {
            return $custom;
        }
    }
    return $template;
} );
```

---

### {$type}_template_hierarchy

Filters the template hierarchy for a specific type.

```php
apply_filters( "{$type}_template_hierarchy", array $templates ): array
```

**Available Hooks:**
- `404_template_hierarchy`
- `archive_template_hierarchy`
- `attachment_template_hierarchy`
- `author_template_hierarchy`
- `category_template_hierarchy`
- `date_template_hierarchy`
- `embed_template_hierarchy`
- `frontpage_template_hierarchy`
- `home_template_hierarchy`
- `index_template_hierarchy`
- `page_template_hierarchy`
- `paged_template_hierarchy`
- `privacypolicy_template_hierarchy`
- `search_template_hierarchy`
- `single_template_hierarchy`
- `singular_template_hierarchy`
- `tag_template_hierarchy`
- `taxonomy_template_hierarchy`

```php
add_filter( 'single_template_hierarchy', function( $templates ) {
    // Add custom template to hierarchy
    array_unshift( $templates, 'single-custom.php' );
    return $templates;
} );
```

---

### {$type}_template

Filters the path of the queried template by type.

```php
apply_filters( "{$type}_template", string $template, string $type, array $templates ): string
```

**Available Hooks:**
- `404_template`, `archive_template`, `attachment_template`
- `author_template`, `category_template`, `date_template`
- `embed_template`, `frontpage_template`, `home_template`
- `index_template`, `page_template`, `paged_template`
- `privacypolicy_template`, `search_template`, `single_template`
- `singular_template`, `tag_template`, `taxonomy_template`

```php
add_filter( 'page_template', function( $template, $type, $templates ) {
    // Custom logic to modify template path
    return $template;
}, 10, 3 );
```

---

## Theme Switching Actions

### switch_theme

Fires immediately after the theme is switched.

```php
do_action( 'switch_theme', string $new_name, WP_Theme $new_theme, WP_Theme $old_theme );
```

**Parameters:**
- `$new_name` - Name of the new theme.
- `$new_theme` - WP_Theme instance of new theme.
- `$old_theme` - WP_Theme instance of old theme.

```php
add_action( 'switch_theme', function( $new_name, $new_theme, $old_theme ) {
    // Migrate settings
    $old_mods = get_option( 'theme_mods_' . $old_theme->get_stylesheet() );
    // Process migration...
}, 10, 3 );
```

---

### after_switch_theme

Fires on the next WP load after theme switch.

```php
do_action( 'after_switch_theme', string $old_name, WP_Theme $old_theme );
```

**Parameters:**
- `$old_name` - Old theme name (or slug if theme missing).
- `$old_theme` - WP_Theme instance of old theme.

```php
add_action( 'after_switch_theme', function( $old_name, $old_theme ) {
    // Theme activation logic
    // Set default options, create pages, etc.
} );
```

---

## Theme Support Filters

### current_theme_supports-{$feature}

Filters whether the theme supports a specific feature.

```php
apply_filters( "current_theme_supports-{$feature}", bool $supports, array $args, mixed $feature_value ): bool
```

```php
add_filter( 'current_theme_supports-custom-header', function( $supports, $args, $feature ) {
    // Conditionally disable custom header
    if ( some_condition() ) {
        return false;
    }
    return $supports;
}, 10, 3 );
```

---

## Theme Modification Filters

### theme_mod_{$name}

Filters a theme modification value.

```php
apply_filters( "theme_mod_{$name}", mixed $current_mod ): mixed
```

**Examples:**
- `theme_mod_header_textcolor`
- `theme_mod_header_image`
- `theme_mod_background_color`
- `theme_mod_custom_logo`

```php
add_filter( 'theme_mod_header_textcolor', function( $color ) {
    // Force white header text
    return 'ffffff';
} );

add_filter( 'theme_mod_custom_logo', function( $logo_id ) {
    // Use default logo on certain pages
    if ( is_404() ) {
        return get_option( 'default_logo_id' );
    }
    return $logo_id;
} );
```

---

### pre_set_theme_mod_{$name}

Filters theme modification value before saving.

```php
apply_filters( "pre_set_theme_mod_{$name}", mixed $value, mixed $old_value ): mixed
```

```php
add_filter( 'pre_set_theme_mod_header_textcolor', function( $value, $old_value ) {
    // Validate color format
    if ( ! preg_match( '/^[a-fA-F0-9]{6}$/', $value ) ) {
        return $old_value;
    }
    return $value;
}, 10, 2 );
```

---

## Directory & Path Filters

### stylesheet

Filters the name of the current stylesheet.

```php
apply_filters( 'stylesheet', string $stylesheet ): string
```

---

### template

Filters the name of the active theme.

```php
apply_filters( 'template', string $template ): string
```

---

### stylesheet_directory

Filters the stylesheet directory path.

```php
apply_filters( 'stylesheet_directory', string $stylesheet_dir, string $stylesheet, string $theme_root ): string
```

---

### template_directory

Filters the active theme directory path.

```php
apply_filters( 'template_directory', string $template_dir, string $template, string $theme_root ): string
```

---

### stylesheet_directory_uri

Filters the stylesheet directory URI.

```php
apply_filters( 'stylesheet_directory_uri', string $stylesheet_dir_uri, string $stylesheet, string $theme_root_uri ): string
```

---

### template_directory_uri

Filters the active theme directory URI.

```php
apply_filters( 'template_directory_uri', string $template_dir_uri, string $template, string $theme_root_uri ): string
```

---

### stylesheet_uri

Filters the URI of the active theme stylesheet.

```php
apply_filters( 'stylesheet_uri', string $stylesheet_uri, string $stylesheet_dir_uri ): string
```

---

### theme_root

Filters the absolute path to themes directory.

```php
apply_filters( 'theme_root', string $theme_root ): string
```

---

### theme_root_uri

Filters the URI for themes directory.

```php
apply_filters( 'theme_root_uri', string $theme_root_uri, string $siteurl, string $stylesheet_or_template ): string
```

---

### theme_file_path

Filters the path to a file in the theme.

```php
apply_filters( 'theme_file_path', string $path, string $file ): string
```

```php
add_filter( 'theme_file_path', function( $path, $file ) {
    // Override specific file location
    if ( $file === 'config.php' ) {
        return '/custom/path/config.php';
    }
    return $path;
}, 10, 2 );
```

---

### theme_file_uri

Filters the URL to a file in the theme.

```php
apply_filters( 'theme_file_uri', string $url, string $file ): string
```

---

## Custom Header Filters

### get_header_image

Filters the header image URL.

```php
apply_filters( 'get_header_image', string $url ): string
```

---

### get_header_image_tag

Filters the markup of header images.

```php
apply_filters( 'get_header_image_tag', string $html, object $header, array $attr ): string
```

---

### get_header_image_tag_attributes

Filters header image tag attributes.

```php
apply_filters( 'get_header_image_tag_attributes', array $attr, object $header ): array
```

```php
add_filter( 'get_header_image_tag_attributes', function( $attr, $header ) {
    $attr['class'] = 'custom-header-image';
    $attr['loading'] = 'eager';
    return $attr;
}, 10, 2 );
```

---

### get_header_video_url

Filters the header video URL.

```php
apply_filters( 'get_header_video_url', string $url ): string
```

---

### header_video_settings

Filters header video settings.

```php
apply_filters( 'header_video_settings', array $settings ): array
```

---

### is_header_video_active

Filters whether header video is active on current page.

```php
apply_filters( 'is_header_video_active', bool $show_video ): bool
```

```php
add_filter( 'is_header_video_active', function( $show ) {
    // Only show video on front page
    return is_front_page();
} );
```

---

## Custom Logo Filters

### get_custom_logo

Filters the custom logo output.

```php
apply_filters( 'get_custom_logo', string $html, int $blog_id ): string
```

---

### get_custom_logo_image_attributes

Filters custom logo image attributes.

```php
apply_filters( 'get_custom_logo_image_attributes', array $custom_logo_attr, int $custom_logo_id, int $blog_id ): array
```

---

## Theme Templates Filters

### theme_templates

Filters list of page templates.

```php
apply_filters( 'theme_templates', array $post_templates, WP_Theme $theme, WP_Post|null $post, string $post_type ): array
```

---

### theme_{$post_type}_templates

Filters templates for a specific post type.

```php
apply_filters( "theme_{$post_type}_templates", array $post_templates, WP_Theme $theme, WP_Post|null $post, string $post_type ): array
```

**Examples:**
- `theme_post_templates`
- `theme_page_templates`
- `theme_attachment_templates`

```php
add_filter( 'theme_page_templates', function( $templates, $theme, $post, $post_type ) {
    // Add dynamic template
    $templates['my-template.php'] = 'My Custom Template';
    return $templates;
}, 10, 4 );
```

---

## Global Styles & Theme.json Filters

### wp_theme_json_data_default

Filters core's default theme.json data.

```php
apply_filters( 'wp_theme_json_data_default', WP_Theme_JSON_Data $theme_json ): WP_Theme_JSON_Data
```

```php
add_filter( 'wp_theme_json_data_default', function( $theme_json ) {
    $data = $theme_json->get_data();
    // Modify core defaults
    $data['settings']['color']['defaultPalette'] = false;
    return $theme_json->update_with( $data );
} );
```

---

### wp_theme_json_data_blocks

Filters block-level theme.json data.

```php
apply_filters( 'wp_theme_json_data_blocks', WP_Theme_JSON_Data $theme_json ): WP_Theme_JSON_Data
```

---

### wp_theme_json_data_theme

Filters theme's theme.json data.

```php
apply_filters( 'wp_theme_json_data_theme', WP_Theme_JSON_Data $theme_json ): WP_Theme_JSON_Data
```

```php
add_filter( 'wp_theme_json_data_theme', function( $theme_json ) {
    $data = $theme_json->get_data();
    // Add dynamic color based on option
    $primary = get_option( 'brand_color', '#0073aa' );
    $data['settings']['color']['palette'][] = array(
        'name'  => 'Brand Color',
        'slug'  => 'brand',
        'color' => $primary,
    );
    return $theme_json->update_with( $data );
} );
```

---

### wp_theme_json_data_user

Filters user's Global Styles data.

```php
apply_filters( 'wp_theme_json_data_user', WP_Theme_JSON_Data $theme_json ): WP_Theme_JSON_Data
```

---

### wp_should_output_buffer_template_for_enhancement

Filters whether template should be output-buffered.

```php
apply_filters( 'wp_should_output_buffer_template_for_enhancement', bool $use_output_buffer ): bool
```

---

### wp_template_enhancement_output_buffer

Filters the template enhancement output buffer.

```php
apply_filters( 'wp_template_enhancement_output_buffer', string $filtered_output, string $output ): string
```

---

## Theme Caching Filters

### wp_cache_themes_persistently

Filters whether to persistently cache theme data.

```php
apply_filters( 'wp_cache_themes_persistently', bool|int $cache_expiration, string $context ): bool|int
```

**Contexts:**
- `'WP_Theme'`
- `'search_theme_directories'`

```php
add_filter( 'wp_cache_themes_persistently', function( $cache, $context ) {
    return 3600; // Cache for 1 hour
}, 10, 2 );
```

---

### theme_scandir_exclusions

Filters directories/files excluded when scanning theme folders.

```php
apply_filters( 'theme_scandir_exclusions', array $exclusions ): array
```

```php
add_filter( 'theme_scandir_exclusions', function( $exclusions ) {
    $exclusions[] = 'src';
    $exclusions[] = 'tests';
    return $exclusions;
} );
```

Default exclusions: `CVS`, `node_modules`, `vendor`, `bower_components`

---

### wp_theme_files_cache_ttl

Filters cache expiration for theme files.

```php
apply_filters( 'wp_theme_files_cache_ttl', int $cache_expiration, string $cache_type ): int
```

---

### theme_block_pattern_files

Filters list of block pattern files.

```php
apply_filters( 'theme_block_pattern_files', array $files, string $dirpath ): array
```

---

## Multisite Theme Filters

### allowed_themes

Filters themes allowed network-wide.

```php
apply_filters( 'allowed_themes', array $allowed_themes ): array
```

---

### network_allowed_themes

Filters network-allowed themes with site context.

```php
apply_filters( 'network_allowed_themes', array $allowed_themes, int $blog_id ): array
```

---

### site_allowed_themes

Filters site-allowed themes.

```php
apply_filters( 'site_allowed_themes', array $allowed_themes, int $blog_id ): array
```

---

## Editor Styles Filters

### editor_stylesheets

Filters array of editor stylesheets.

```php
apply_filters( 'editor_stylesheets', array $stylesheets ): array
```

```php
add_filter( 'editor_stylesheets', function( $stylesheets ) {
    $stylesheets[] = get_theme_file_uri( 'editor-fonts.css' );
    return $stylesheets;
} );
```

---

## Custom CSS Filters

### wp_get_custom_css

Filters custom CSS output.

```php
apply_filters( 'wp_get_custom_css', string $css, string $stylesheet ): string
```

---

### update_custom_css_data

Filters custom CSS data before saving.

```php
apply_filters( 'update_custom_css_data', array $data, array $args ): array
```

**Data Array:**
- `'css'` - CSS stored in post_content.
- `'preprocessed'` - Pre-processed CSS in post_content_filtered.

---

## Theme Validation Filters

### validate_current_theme

Filters whether to validate the active theme.

```php
apply_filters( 'validate_current_theme', bool $validate ): bool
```

```php
// Skip validation in development
add_filter( 'validate_current_theme', '__return_false' );
```

---

### validate_theme_requirements

Filters theme requirement validation response.

```php
apply_filters( 'validate_theme_requirements', bool|WP_Error $met_requirements, string $stylesheet ): bool|WP_Error
```

---

## Starter Content Filters

### get_theme_starter_content

Filters expanded starter content array.

```php
apply_filters( 'get_theme_starter_content', array $content, array $config ): array
```

---

## Customizer Actions

### customize_register

Fires when Customizer controls should be registered.

```php
do_action( 'customize_register', WP_Customize_Manager $wp_customize );
```

```php
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_section( 'theme_options', array(
        'title'    => 'Theme Options',
        'priority' => 30,
    ) );
    
    $wp_customize->add_setting( 'accent_color', array(
        'default'   => '#0073aa',
        'transport' => 'refresh',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( 
        $wp_customize, 
        'accent_color', 
        array(
            'label'   => 'Accent Color',
            'section' => 'theme_options',
        ) 
    ) );
} );
```

---

### customize_preview_init

Fires when Customizer preview is initialized.

```php
do_action( 'customize_preview_init', WP_Customize_Manager $wp_customize );
```

---

### customize_controls_enqueue_scripts

Fires when Customizer control scripts should be enqueued.

```php
do_action( 'customize_controls_enqueue_scripts' );
```

---

### customize_controls_print_scripts

Fires when Customizer control scripts are printed.

```php
do_action( 'customize_controls_print_scripts' );
```

---

## Hook Priority Guide

```
after_setup_theme (hooks for add_theme_support)
├── Priority 10: Theme setup
└── Priority 11+: Child theme overrides

init (for registering features)
├── Priority 10: General registration
└── Priority 999: Late registration

wp_enqueue_scripts (for theme assets)
├── Priority 10: Theme styles
├── Priority 20: Theme scripts
└── Priority 100: Overrides

template_redirect (early template logic)
└── Priority 10: Redirects and exits

template_include (template selection)
└── Priority 10: Template overrides
```

## Common Hook Combinations

```php
// Complete theme setup
add_action( 'after_setup_theme', 'my_theme_setup' );
add_action( 'customize_register', 'my_customizer_settings' );
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );
add_filter( 'body_class', 'my_body_classes' );

// Template customization
add_filter( 'single_template_hierarchy', 'my_template_hierarchy' );
add_filter( 'template_include', 'my_template_override' );

// Global styles modification
add_filter( 'wp_theme_json_data_theme', 'my_theme_json_modifications' );
```
