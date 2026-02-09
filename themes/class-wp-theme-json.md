# WP_Theme_JSON & WP_Theme_JSON_Resolver Reference

These classes handle the processing of `theme.json` configuration files, providing a structured way to manage global styles and settings.

## WP_Theme_JSON Class

Encapsulates processing of structures that adhere to the theme.json specification.

> **Note:** This is a low-level API for internal core usage. For most use cases, use the public functions: `wp_get_global_settings()`, `wp_get_global_styles()`, and `wp_get_global_stylesheet()`.

### Class Constants

#### Schema Version

```php
const LATEST_SCHEMA = 3;
```

Current schema version. Theme.json files specify their version:

```json
{
    "version": 3,
    ...
}
```

#### Valid Origins

```php
const VALID_ORIGINS = array(
    'default',  // WordPress core defaults
    'blocks',   // Block-level settings from block.json
    'theme',    // Theme theme.json
    'custom',   // User customizations
);
```

#### CSS Selectors

```php
const ROOT_CSS_PROPERTIES_SELECTOR = ':root';
const ROOT_BLOCK_SELECTOR = 'body';
```

#### Elements

```php
const ELEMENTS = array(
    'link'      => 'a:where(:not(.wp-element-button))',
    'heading'   => 'h1, h2, h3, h4, h5, h6',
    'h1'        => 'h1',
    'h2'        => 'h2',
    'h3'        => 'h3',
    'h4'        => 'h4',
    'h5'        => 'h5',
    'h6'        => 'h6',
    'button'    => '.wp-element-button, .wp-block-button__link',
    'caption'   => '.wp-element-caption, ...',
    'cite'      => 'cite',
    'textInput' => 'textarea, input:where([type=email],...)',
    'select'    => 'select',
);
```

### Presets Metadata

Defines how presets are processed:

```php
const PRESETS_METADATA = array(
    array(
        'path'              => array( 'dimensions', 'aspectRatios' ),
        'prevent_override'  => array( 'dimensions', 'defaultAspectRatios' ),
        'use_default_names' => false,
        'value_key'         => 'ratio',
        'css_vars'          => '--wp--preset--aspect-ratio--$slug',
        'classes'           => array(),
        'properties'        => array( 'aspect-ratio' ),
    ),
    array(
        'path'              => array( 'color', 'palette' ),
        'prevent_override'  => array( 'color', 'defaultPalette' ),
        'use_default_names' => false,
        'value_key'         => 'color',
        'css_vars'          => '--wp--preset--color--$slug',
        'classes'           => array(
            '.has-$slug-color'            => 'color',
            '.has-$slug-background-color' => 'background-color',
            '.has-$slug-border-color'     => 'border-color',
        ),
        'properties'        => array( 'color', 'background-color', 'border-color' ),
    ),
    // ... typography.fontSizes, typography.fontFamilies, 
    //     color.gradients, color.duotone, spacing.spacingSizes,
    //     shadow.presets, border.radiusSizes
);
```

### Valid Settings

```php
const VALID_SETTINGS = array(
    'appearanceTools'               => null,
    'useRootPaddingAwareAlignments' => null,
    'background'                    => array(
        'backgroundImage' => null,
        'backgroundSize'  => null,
    ),
    'border'                        => array(
        'color'       => null,
        'radius'      => null,
        'radiusSizes' => null,
        'style'       => null,
        'width'       => null,
    ),
    'color'                         => array(
        'background'       => null,
        'custom'           => null,
        'customDuotone'    => null,
        'customGradient'   => null,
        'defaultDuotone'   => null,
        'defaultGradients' => null,
        'defaultPalette'   => null,
        'duotone'          => null,
        'gradients'        => null,
        'link'             => null,
        'heading'          => null,
        'button'           => null,
        'caption'          => null,
        'palette'          => null,
        'text'             => null,
    ),
    'custom'                        => null,
    'dimensions'                    => array(
        'aspectRatio'         => null,
        'aspectRatios'        => null,
        'defaultAspectRatios' => null,
        'minHeight'           => null,
    ),
    'layout'                        => array(
        'contentSize'                   => null,
        'wideSize'                      => null,
        'allowEditing'                  => null,
        'allowCustomContentAndWideSize' => null,
    ),
    'spacing'                       => array(
        'customSpacingSize'   => null,
        'defaultSpacingSizes' => null,
        'spacingSizes'        => null,
        'spacingScale'        => null,
        'blockGap'            => null,
        'margin'              => null,
        'padding'             => null,
        'units'               => null,
    ),
    'typography'                    => array(
        'fluid'            => null,
        'customFontSize'   => null,
        'defaultFontSizes' => null,
        'dropCap'          => null,
        'fontFamilies'     => null,
        'fontSizes'        => null,
        'fontStyle'        => null,
        'fontWeight'       => null,
        'letterSpacing'    => null,
        'lineHeight'       => null,
        'textAlign'        => null,
        'textColumns'      => null,
        'textDecoration'   => null,
        'textTransform'    => null,
        'writingMode'      => null,
    ),
    // ... plus lightbox, position, shadow
);
```

### Valid Styles

```php
const VALID_STYLES = array(
    'background' => array(
        'backgroundImage'      => null,
        'backgroundPosition'   => null,
        'backgroundRepeat'     => null,
        'backgroundSize'       => null,
        'backgroundAttachment' => null,
    ),
    'border'     => array(
        'color'  => null,
        'radius' => null,
        'style'  => null,
        'width'  => null,
        'top'    => null,
        'right'  => null,
        'bottom' => null,
        'left'   => null,
    ),
    'color'      => array(
        'background' => null,
        'gradient'   => null,
        'text'       => null,
    ),
    'dimensions' => array(
        'aspectRatio' => null,
        'minHeight'   => null,
    ),
    'filter'     => array(
        'duotone' => null,
    ),
    'outline'    => array(
        'color'  => null,
        'offset' => null,
        'style'  => null,
        'width'  => null,
    ),
    'shadow'     => null,
    'spacing'    => array(
        'margin'   => null,
        'padding'  => null,
        'blockGap' => null,
    ),
    'typography' => array(
        'fontFamily'     => null,
        'fontSize'       => null,
        'fontStyle'      => null,
        'fontWeight'     => null,
        'letterSpacing'  => null,
        'lineHeight'     => null,
        'textAlign'      => null,
        'textColumns'    => null,
        'textDecoration' => null,
        'textTransform'  => null,
        'writingMode'    => null,
    ),
    'css'        => null,
);
```

### Appearance Tools

When `appearanceTools: true`, these settings are enabled:

```php
const APPEARANCE_TOOLS_OPT_INS = array(
    array( 'background', 'backgroundImage' ),
    array( 'background', 'backgroundSize' ),
    array( 'border', 'color' ),
    array( 'border', 'radius' ),
    array( 'border', 'style' ),
    array( 'border', 'width' ),
    array( 'color', 'link' ),
    array( 'color', 'heading' ),
    array( 'color', 'button' ),
    array( 'color', 'caption' ),
    array( 'dimensions', 'aspectRatio' ),
    array( 'dimensions', 'minHeight' ),
    array( 'position', 'sticky' ),
    array( 'spacing', 'blockGap' ),
    array( 'spacing', 'margin' ),
    array( 'spacing', 'padding' ),
    array( 'typography', 'lineHeight' ),
);
```

### Constructor

```php
public function __construct( 
    array $theme_json = array( 'version' => self::LATEST_SCHEMA ), 
    string $origin = 'theme' 
)
```

**Parameters:**
- `$theme_json` - Array following theme.json specification.
- `$origin` - One of: 'default', 'blocks', 'theme', 'custom'.

### Key Methods

#### get_settings()

Gets the settings.

```php
public function get_settings(): array
```

```php
$theme_json = WP_Theme_JSON_Resolver::get_merged_data();
$settings = $theme_json->get_settings();

// Access specific settings
$palette = $settings['color']['palette'] ?? array();
$font_sizes = $settings['typography']['fontSizes'] ?? array();
```

#### get_stylesheet()

Gets the generated CSS stylesheet.

```php
public function get_stylesheet( 
    array $types = array( 'variables', 'styles', 'presets' ), 
    array $origins = null, 
    array $options = array() 
): string
```

**Types:**
- `'variables'` - CSS custom properties for presets.
- `'styles'` - Style declarations.
- `'presets'` - Preset classes.
- `'base-layout-styles'` - Base layout CSS.
- `'custom-css'` - Custom CSS.

**Options:**
- `'scope'` - Scope all styles to a selector.
- `'root_selector'` - Override the root selector.
- `'skip_root_layout_styles'` - Omit root layout styles.
- `'include_block_style_variations'` - Include block style variations.

```php
$theme_json = WP_Theme_JSON_Resolver::get_merged_data();

// Get full stylesheet
$css = $theme_json->get_stylesheet();

// Get only variables
$variables_css = $theme_json->get_stylesheet( array( 'variables' ) );

// Get only styles from theme origin
$theme_css = $theme_json->get_stylesheet( 
    array( 'styles' ), 
    array( 'theme' ) 
);
```

#### get_raw_data()

Gets the raw theme.json data.

```php
public function get_raw_data(): array
```

#### merge()

Merges another WP_Theme_JSON instance.

```php
public function merge( WP_Theme_JSON $incoming ): void
```

```php
$base = new WP_Theme_JSON( $base_data );
$override = new WP_Theme_JSON( $override_data );

$base->merge( $override );
// $base now contains merged data
```

#### get_custom_templates()

Gets custom templates defined in theme.json.

```php
public function get_custom_templates(): array
```

```php
$templates = $theme_json->get_custom_templates();
/*
array(
    'page-no-title' => array(
        'title'     => 'Page No Title',
        'postTypes' => array( 'page' ),
    ),
)
*/
```

#### get_template_parts()

Gets template parts defined in theme.json.

```php
public function get_template_parts(): array
```

```php
$parts = $theme_json->get_template_parts();
/*
array(
    'header' => array(
        'title' => 'Header',
        'area'  => 'header',
    ),
    'footer' => array(
        'title' => 'Footer',
        'area'  => 'footer',
    ),
)
*/
```

#### get_patterns()

Gets pattern slugs for directory registration.

```php
public function get_patterns(): array
```

Returns pattern slugs defined in theme.json's `patterns` array.

### Static Methods

#### get_element_class_name()

Gets class name for an element.

```php
public static function get_element_class_name( string $element ): string
```

```php
$class = WP_Theme_JSON::get_element_class_name( 'button' );
// Returns: 'wp-element-button'

$class = WP_Theme_JSON::get_element_class_name( 'caption' );
// Returns: 'wp-element-caption'
```

#### scope_selector()

Scopes a selector with a root selector.

```php
public static function scope_selector( 
    string $root_selector, 
    string $selector 
): string
```

```php
$scoped = WP_Theme_JSON::scope_selector( '.my-block', 'p, span' );
// Returns: '.my-block p, .my-block span'
```

#### resolve_variables()

Resolves CSS variable references in a theme.json instance.

```php
public static function resolve_variables( WP_Theme_JSON $theme_json ): WP_Theme_JSON
```

```php
$resolved = WP_Theme_JSON::resolve_variables( $theme_json );
// Variables like "var:preset|color|primary" are resolved to actual values
```

---

## WP_Theme_JSON_Resolver Class

Abstracts the processing of different data sources for site-level configuration.

### Data Sources

```
1. Core (default)     → WordPress default settings
2. Blocks             → block.json __experimentalStyle
3. Theme              → theme.json + style variations
4. User (custom)      → Global Styles CPT (wp_global_styles)
```

### Getting Data by Origin

#### get_core_data()

Gets WordPress core defaults.

```php
public static function get_core_data(): WP_Theme_JSON
```

```php
$core = WP_Theme_JSON_Resolver::get_core_data();
```

#### get_block_data()

Gets block-level styles from block.json files.

```php
public static function get_block_data(): WP_Theme_JSON
```

```php
$blocks = WP_Theme_JSON_Resolver::get_block_data();
```

#### get_theme_data()

Gets theme's theme.json data.

```php
public static function get_theme_data( 
    array $deprecated = array(), 
    array $options = array() 
): WP_Theme_JSON
```

**Options:**
- `'with_supports'` - Include theme support data (default true).

```php
// With theme supports merged
$theme = WP_Theme_JSON_Resolver::get_theme_data();

// Without theme supports
$theme_only = WP_Theme_JSON_Resolver::get_theme_data( 
    array(), 
    array( 'with_supports' => false ) 
);
```

#### get_user_data()

Gets user customizations from Global Styles CPT.

```php
public static function get_user_data(): WP_Theme_JSON
```

```php
$user = WP_Theme_JSON_Resolver::get_user_data();
```

### Merged Data

#### get_merged_data()

Gets data merged from all origins.

```php
public static function get_merged_data( string $origin = 'custom' ): WP_Theme_JSON
```

**Origin Parameter:**
- `'default'` - Core only.
- `'blocks'` - Core + blocks.
- `'theme'` - Core + blocks + theme.
- `'custom'` - All sources (default).

```php
// Get all merged data
$all = WP_Theme_JSON_Resolver::get_merged_data();

// Get up to theme level (no user customizations)
$theme_level = WP_Theme_JSON_Resolver::get_merged_data( 'theme' );

// Get core + blocks only
$base = WP_Theme_JSON_Resolver::get_merged_data( 'blocks' );
```

### Style Variations

#### get_style_variations()

Gets style variations from the `styles/` directory.

```php
public static function get_style_variations( string $scope = 'theme' ): array
```

**Scope:**
- `'theme'` - Top-level theme variations.
- `'block'` - Block style variations with `blockTypes`.

```php
// Get theme style variations
$variations = WP_Theme_JSON_Resolver::get_style_variations();

foreach ( $variations as $variation ) {
    echo $variation['title'];
    // Access $variation['settings'] and $variation['styles']
}

// Get block style variations
$block_variations = WP_Theme_JSON_Resolver::get_style_variations( 'block' );
```

### User Global Styles

#### get_user_data_from_wp_global_styles()

Gets the Global Styles CPT for a theme.

```php
public static function get_user_data_from_wp_global_styles( 
    WP_Theme $theme, 
    bool $create_post = false, 
    array $post_status_filter = array( 'publish' ) 
): array
```

```php
$theme = wp_get_theme();
$user_cpt = WP_Theme_JSON_Resolver::get_user_data_from_wp_global_styles( $theme );

if ( ! empty( $user_cpt ) ) {
    $content = json_decode( $user_cpt['post_content'], true );
}
```

#### get_user_global_styles_post_id()

Gets the ID of the user's Global Styles CPT.

```php
public static function get_user_global_styles_post_id(): int|null
```

```php
$post_id = WP_Theme_JSON_Resolver::get_user_global_styles_post_id();
if ( $post_id ) {
    $post = get_post( $post_id );
}
```

### Theme File URIs

#### get_resolved_theme_uris()

Resolves relative paths to absolute URLs.

```php
public static function get_resolved_theme_uris( WP_Theme_JSON $theme_json ): array
```

Resolves `file:./` paths in background images.

```php
$resolved = WP_Theme_JSON_Resolver::get_resolved_theme_uris( $theme_json );
/*
array(
    array(
        'name'   => 'file:./assets/bg.jpg',
        'href'   => 'https://example.com/wp-content/themes/my-theme/assets/bg.jpg',
        'target' => 'styles.background.backgroundImage.url',
        'type'   => 'image/jpeg',
    ),
)
*/
```

#### resolve_theme_file_uris()

Returns a new WP_Theme_JSON with resolved URIs.

```php
public static function resolve_theme_file_uris( WP_Theme_JSON $theme_json ): WP_Theme_JSON
```

```php
$resolved_theme_json = WP_Theme_JSON_Resolver::resolve_theme_file_uris( $theme_json );
```

### Cache Management

#### clean_cached_data()

Clears all cached data.

```php
public static function clean_cached_data(): void
```

```php
// After modifying theme.json programmatically
WP_Theme_JSON_Resolver::clean_cached_data();
```

---

## Public Functions

These are the recommended APIs for working with global styles.

### wp_get_global_settings()

```php
function wp_get_global_settings( 
    array $path = array(), 
    array $context = array() 
): mixed
```

**Context:**
- `'block_name'` - Get settings for a specific block.
- `'origin'` - 'all' (default) or 'base' (theme only).

```php
// All settings
$settings = wp_get_global_settings();

// Specific path
$palette = wp_get_global_settings( array( 'color', 'palette' ) );
$layout = wp_get_global_settings( array( 'layout' ) );

// Block-specific settings
$button_colors = wp_get_global_settings(
    array( 'color', 'palette' ),
    array( 'block_name' => 'core/button' )
);

// Theme-only (no user customizations)
$theme_settings = wp_get_global_settings(
    array(),
    array( 'origin' => 'base' )
);
```

### wp_get_global_styles()

```php
function wp_get_global_styles( 
    array $path = array(), 
    array $context = array() 
): mixed
```

**Context:**
- `'block_name'` - Get styles for a specific block.
- `'origin'` - 'all' or 'base'.
- `'transforms'` - Array with 'resolve-variables' to resolve CSS variables.

```php
// All styles
$styles = wp_get_global_styles();

// Specific path
$background = wp_get_global_styles( array( 'color', 'background' ) );

// Block styles
$paragraph_styles = wp_get_global_styles(
    array(),
    array( 'block_name' => 'core/paragraph' )
);

// With resolved variables
$resolved = wp_get_global_styles(
    array(),
    array( 'transforms' => array( 'resolve-variables' ) )
);
```

### wp_get_global_stylesheet()

```php
function wp_get_global_stylesheet( array $types = array() ): string
```

**Types:**
- Empty array: `'variables', 'presets', 'base-layout-styles'` for classic themes, `'variables', 'styles', 'presets'` for block themes.
- `'variables'` - CSS custom properties.
- `'styles'` - Style rules.
- `'presets'` - Preset classes.
- `'base-layout-styles'` - Base layout CSS.

```php
// Default styles
$stylesheet = wp_get_global_stylesheet();

// Only variables
$variables = wp_get_global_stylesheet( array( 'variables' ) );

// Variables and presets
$base = wp_get_global_stylesheet( array( 'variables', 'presets' ) );
```

### wp_theme_has_theme_json()

```php
function wp_theme_has_theme_json(): bool
```

```php
if ( wp_theme_has_theme_json() ) {
    // Theme uses theme.json
}
```

### wp_clean_theme_json_cache()

Clears all theme.json related caches.

```php
function wp_clean_theme_json_cache(): void
```

---

## Complete Usage Example

```php
// Get merged theme.json data with resolved paths
$theme_json = WP_Theme_JSON_Resolver::resolve_theme_file_uris(
    WP_Theme_JSON_Resolver::get_merged_data()
);

// Generate stylesheet
$stylesheet = $theme_json->get_stylesheet(
    array( 'variables', 'styles', 'presets' ),
    array( 'default', 'theme', 'custom' )
);

// Get settings for a specific feature
$font_sizes = wp_get_global_settings( array( 'typography', 'fontSizes' ) );

// Get styles with resolved variables
$colors = wp_get_global_styles(
    array( 'color' ),
    array( 'transforms' => array( 'resolve-variables' ) )
);

// Get custom templates
$custom_templates = $theme_json->get_custom_templates();

// Get style variations
$variations = WP_Theme_JSON_Resolver::get_style_variations();

// Check for theme.json support
if ( wp_theme_has_theme_json() ) {
    // Use global styles
} else {
    // Fall back to theme supports
}
```
