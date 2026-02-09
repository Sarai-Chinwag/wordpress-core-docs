# WordPress Theme Functions Reference

Complete reference for WordPress theme-related functions.

## Theme Information Functions

### wp_get_theme()

Gets a WP_Theme object for a theme.

```php
wp_get_theme( string $stylesheet = '', string $theme_root = '' ): WP_Theme
```

**Parameters:**
- `$stylesheet` - Theme directory name. Defaults to active theme.
- `$theme_root` - Absolute path to theme root directory.

**Returns:** `WP_Theme` object. Check `exists()` method to confirm theme exists.

**Examples:**
```php
// Get active theme
$theme = wp_get_theme();
echo $theme->get( 'Name' );
echo $theme->get( 'Version' );
echo $theme->get( 'ThemeURI' );

// Get specific theme
$theme = wp_get_theme( 'twentytwentyfour' );
if ( $theme->exists() ) {
    echo $theme->get( 'Name' );
}

// Get parent theme info from child
$theme = wp_get_theme();
if ( $theme->parent() ) {
    echo $theme->parent()->get( 'Name' );
}
```

---

### wp_get_themes()

Returns array of WP_Theme objects.

```php
wp_get_themes( array $args = array() ): WP_Theme[]
```

**Parameters:**
```php
$args = array(
    'errors'  => false,  // true = only themes with errors, false = without, null = all
    'allowed' => null,   // Multisite: true, false, 'site', 'network', or null
    'blog_id' => 0,      // Multisite: blog ID for allowed calculation
);
```

**Example:**
```php
$themes = wp_get_themes();
foreach ( $themes as $stylesheet => $theme ) {
    echo $stylesheet . ': ' . $theme->get( 'Name' );
}
```

---

### get_stylesheet()

Gets the stylesheet name (directory) of the active theme.

```php
get_stylesheet(): string
```

**Example:**
```php
$stylesheet = get_stylesheet();
// Returns: 'my-theme' or 'my-child-theme'
```

---

### get_template()

Gets the template name (directory) of the active theme.

```php
get_template(): string
```

**Example:**
```php
$template = get_template();
// For parent theme: same as get_stylesheet()
// For child theme: returns parent theme directory
```

---

### is_child_theme()

Checks if a child theme is active.

```php
is_child_theme(): bool
```

**Example:**
```php
if ( is_child_theme() ) {
    // Child theme is active
    $parent = get_template();
    $child  = get_stylesheet();
}
```

---

## Theme Directory Functions

### get_stylesheet_directory()

Gets the absolute path to the stylesheet (child theme) directory.

```php
get_stylesheet_directory(): string
```

**Example:**
```php
$path = get_stylesheet_directory();
// Returns: /var/www/html/wp-content/themes/my-theme

require_once get_stylesheet_directory() . '/inc/custom.php';
```

---

### get_template_directory()

Gets the absolute path to the template (parent theme) directory.

```php
get_template_directory(): string
```

**Example:**
```php
$path = get_template_directory();
// For parent themes: same as get_stylesheet_directory()
// For child themes: path to parent theme

require_once get_template_directory() . '/inc/parent-functions.php';
```

---

### get_stylesheet_directory_uri()

Gets the URL to the stylesheet directory.

```php
get_stylesheet_directory_uri(): string
```

**Example:**
```php
$uri = get_stylesheet_directory_uri();
// Returns: https://example.com/wp-content/themes/my-theme

echo '<img src="' . esc_url( get_stylesheet_directory_uri() . '/images/logo.png' ) . '">';
```

---

### get_template_directory_uri()

Gets the URL to the template directory.

```php
get_template_directory_uri(): string
```

**Example:**
```php
$uri = get_template_directory_uri();

// Enqueue parent theme assets
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
```

---

### get_theme_file_path()

Gets path to a file in the theme, checking child before parent.

```php
get_theme_file_path( string $file = '' ): string
```

**Example:**
```php
// Checks child theme first, then parent
$config_path = get_theme_file_path( 'inc/config.php' );

if ( file_exists( get_theme_file_path( 'custom-template.php' ) ) ) {
    require get_theme_file_path( 'custom-template.php' );
}
```

---

### get_theme_file_uri()

Gets URL to a file in the theme, checking child before parent.

```php
get_theme_file_uri( string $file = '' ): string
```

**Example:**
```php
// Checks child theme first, then parent
$script_url = get_theme_file_uri( 'assets/js/custom.js' );

wp_enqueue_script( 'custom-script', get_theme_file_uri( 'js/custom.js' ) );
```

---

### get_theme_root()

Gets the path to themes directory.

```php
get_theme_root( string $stylesheet_or_template = '' ): string
```

**Example:**
```php
$themes_dir = get_theme_root();
// Returns: /var/www/html/wp-content/themes
```

---

### get_theme_root_uri()

Gets the URL to themes directory.

```php
get_theme_root_uri( string $stylesheet_or_template = '', string $theme_root = '' ): string
```

---

## Template Functions

### get_template_part()

Loads a template part into the template.

```php
get_template_part( string $slug, string $name = null, array $args = array() ): void|false
```

**Parameters:**
- `$slug` - The slug name for the generic template.
- `$name` - The name of the specialized template.
- `$args` - Arguments passed to the template.

**Template Search Order:**
1. `{slug}-{name}.php` in child theme
2. `{slug}-{name}.php` in parent theme
3. `{slug}.php` in child theme
4. `{slug}.php` in parent theme

**Examples:**
```php
// Loads template-parts/content.php
get_template_part( 'template-parts/content' );

// Loads template-parts/content-single.php
get_template_part( 'template-parts/content', 'single' );

// With post format
get_template_part( 'template-parts/content', get_post_format() );

// With arguments (WordPress 5.5+)
get_template_part( 'template-parts/content', 'product', array(
    'product_id' => 123,
    'show_price' => true,
) );

// In template-parts/content-product.php
$product_id = $args['product_id'];
$show_price = $args['show_price'];
```

---

### locate_template()

Finds the highest priority template file.

```php
locate_template( 
    string|array $template_names, 
    bool $load = false, 
    bool $load_once = true, 
    array $args = array() 
): string
```

**Parameters:**
- `$template_names` - Template file(s) to search for.
- `$load` - Whether to load the template if found.
- `$load_once` - Whether to use require_once.
- `$args` - Arguments passed to the template.

**Search Order:**
1. Stylesheet directory (child theme)
2. Template directory (parent theme)
3. `wp-includes/theme-compat/`

**Examples:**
```php
// Just locate, don't load
$template = locate_template( array( 'special.php', 'default.php' ) );
if ( $template ) {
    echo "Found: $template";
}

// Locate and load
locate_template( array( 'custom-header.php' ), true );

// With arguments
locate_template( 
    array( 'parts/card.php' ), 
    true, 
    false, 
    array( 'card_id' => 123 ) 
);
```

---

### load_template()

Loads a template file with WordPress environment.

```php
load_template( string $_template_file, bool $load_once = true, array $args = array() ): void
```

**Parameters:**
- `$_template_file` - Absolute path to template file.
- `$load_once` - Whether to use require_once.
- `$args` - Arguments passed to the template.

**Available in Template:**
- All query variables (extracted)
- `$posts`, `$post`, `$wp_query`, etc.
- `$args` array

**Example:**
```php
load_template( get_stylesheet_directory() . '/template-parts/header.php', true, array(
    'show_search' => true,
) );
```

---

### get_query_template()

Gets path to a template based on type.

```php
get_query_template( string $type, string[] $templates = array() ): string
```

**Example:**
```php
// Get archive template
$template = get_query_template( 'archive', array(
    'archive-product.php',
    'archive.php',
) );
```

---

### Template Type Functions

```php
// Get specific template types
get_index_template();      // index.php
get_404_template();        // 404.php
get_archive_template();    // archive-{post_type}.php, archive.php
get_author_template();     // author-{nicename}.php, author-{id}.php, author.php
get_category_template();   // category-{slug}.php, category-{id}.php, category.php
get_tag_template();        // tag-{slug}.php, tag-{id}.php, tag.php
get_taxonomy_template();   // taxonomy-{tax}-{term}.php, taxonomy-{tax}.php, taxonomy.php
get_date_template();       // date.php
get_home_template();       // home.php, index.php
get_front_page_template(); // front-page.php
get_page_template();       // {custom}.php, page-{slug}.php, page-{id}.php, page.php
get_search_template();     // search.php
get_single_template();     // single-{post_type}-{slug}.php, single-{post_type}.php, single.php
get_embed_template();      // embed-{post_type}-{format}.php, embed-{post_type}.php, embed.php
get_singular_template();   // singular.php
get_attachment_template(); // {mime}-{subtype}.php, {subtype}.php, {mime}.php, attachment.php
```

---

### get_header() / get_footer() / get_sidebar()

Load theme parts.

```php
get_header( string $name = null, array $args = array() ): void|false
get_footer( string $name = null, array $args = array() ): void|false
get_sidebar( string $name = null, array $args = array() ): void|false
```

**Examples:**
```php
// Loads header.php
get_header();

// Loads header-home.php
get_header( 'home' );

// With arguments
get_header( null, array( 'is_landing' => true ) );

// Loads footer.php
get_footer();

// Loads sidebar.php
get_sidebar();

// Loads sidebar-shop.php
get_sidebar( 'shop' );
```

---

## Theme Modification Functions

### get_theme_mod()

Gets a theme modification value.

```php
get_theme_mod( string $name, mixed $default_value = false ): mixed
```

**Parameters:**
- `$name` - Theme modification name.
- `$default_value` - Default value if mod not set.

**Examples:**
```php
// Get custom color
$color = get_theme_mod( 'header_color', '#ffffff' );

// Get with sprintf support for URIs
$image = get_theme_mod( 'header_image', '%s/images/default.jpg' );
// %s is replaced with template directory URI
```

---

### set_theme_mod()

Sets a theme modification value.

```php
set_theme_mod( string $name, mixed $value ): bool
```

**Example:**
```php
set_theme_mod( 'header_color', '#000000' );
set_theme_mod( 'show_sidebar', false );
```

---

### remove_theme_mod()

Removes a theme modification.

```php
remove_theme_mod( string $name ): void
```

---

### get_theme_mods()

Gets all theme modifications.

```php
get_theme_mods(): array
```

**Example:**
```php
$mods = get_theme_mods();
print_r( $mods );
```

---

### remove_theme_mods()

Removes all theme modifications for the active theme.

```php
remove_theme_mods(): void
```

---

## Theme Support Functions

### add_theme_support()

Registers theme support for a feature.

```php
add_theme_support( string $feature, mixed ...$args ): void|false
```

**Core Features:**

```php
// Post thumbnails
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'product' ) );

// Custom logo
add_theme_support( 'custom-logo', array(
    'height'               => 100,
    'width'                => 400,
    'flex-height'          => true,
    'flex-width'           => true,
    'header-text'          => array( 'site-title', 'site-description' ),
    'unlink-homepage-logo' => true,
) );

// Custom header
add_theme_support( 'custom-header', array(
    'default-image'          => '',
    'random-default'         => false,
    'width'                  => 1920,
    'height'                 => 600,
    'flex-height'            => true,
    'flex-width'             => true,
    'default-text-color'     => '000000',
    'header-text'            => true,
    'uploads'                => true,
    'wp-head-callback'       => 'my_header_style',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
    'video'                  => true,
    'video-active-callback'  => 'is_front_page',
) );

// Custom background
add_theme_support( 'custom-background', array(
    'default-image'          => '',
    'default-preset'         => 'default',
    'default-position-x'     => 'left',
    'default-position-y'     => 'top',
    'default-size'           => 'auto',
    'default-repeat'         => 'repeat',
    'default-attachment'     => 'scroll',
    'default-color'          => 'ffffff',
    'wp-head-callback'       => '_custom_background_cb',
    'admin-head-callback'    => '',
    'admin-preview-callback' => '',
) );

// HTML5 markup
add_theme_support( 'html5', array(
    'comment-list',
    'comment-form',
    'search-form',
    'gallery',
    'caption',
    'style',
    'script',
) );

// Post formats
add_theme_support( 'post-formats', array(
    'aside',
    'gallery',
    'link',
    'image',
    'quote',
    'status',
    'video',
    'audio',
    'chat',
) );

// Title tag
add_theme_support( 'title-tag' );

// Automatic feed links
add_theme_support( 'automatic-feed-links' );

// Navigation menus
add_theme_support( 'menus' );

// Widgets
add_theme_support( 'widgets' );
add_theme_support( 'widgets-block-editor' );

// Selective refresh for widgets
add_theme_support( 'customize-selective-refresh-widgets' );

// Starter content
add_theme_support( 'starter-content', array(
    'widgets' => array(
        'sidebar-1' => array( 'search', 'text_about' ),
    ),
    'posts' => array(
        'home',
        'about',
        'contact',
    ),
    'nav_menus' => array(
        'primary' => array(
            'name'  => 'Primary Menu',
            'items' => array( 'page_home', 'page_about', 'page_contact' ),
        ),
    ),
) );
```

**Block Editor Features:**

```php
// Editor styles
add_theme_support( 'editor-styles' );
add_editor_style( 'editor-style.css' );

// Wide/full alignment
add_theme_support( 'align-wide' );

// Block editor color palette
add_theme_support( 'editor-color-palette', array(
    array(
        'name'  => 'Primary',
        'slug'  => 'primary',
        'color' => '#0073aa',
    ),
    array(
        'name'  => 'Secondary',
        'slug'  => 'secondary',
        'color' => '#23282d',
    ),
) );

// Gradient presets
add_theme_support( 'editor-gradient-presets', array(
    array(
        'name'     => 'Blue to Purple',
        'gradient' => 'linear-gradient(135deg, #0073aa 0%, #6b46c1 100%)',
        'slug'     => 'blue-to-purple',
    ),
) );

// Font sizes
add_theme_support( 'editor-font-sizes', array(
    array(
        'name' => 'Small',
        'size' => 14,
        'slug' => 'small',
    ),
    array(
        'name' => 'Medium',
        'size' => 18,
        'slug' => 'medium',
    ),
    array(
        'name' => 'Large',
        'size' => 24,
        'slug' => 'large',
    ),
) );

// Spacing sizes
add_theme_support( 'editor-spacing-sizes', array(
    array(
        'name' => 'Small',
        'size' => '1rem',
        'slug' => 'small',
    ),
    array(
        'name' => 'Medium',
        'size' => '2rem',
        'slug' => 'medium',
    ),
) );

// Disable custom colors
add_theme_support( 'disable-custom-colors' );

// Disable custom font sizes
add_theme_support( 'disable-custom-font-sizes' );

// Disable custom gradients
add_theme_support( 'disable-custom-gradients' );

// Disable layout styles
add_theme_support( 'disable-layout-styles' );

// Responsive embeds
add_theme_support( 'responsive-embeds' );

// Block styles
add_theme_support( 'wp-block-styles' );

// Dark editor style
add_theme_support( 'dark-editor-style' );

// Block templates (block themes)
add_theme_support( 'block-templates' );
add_theme_support( 'block-template-parts' );

// Appearance tools
add_theme_support( 'appearance-tools' );

// Link color
add_theme_support( 'link-color' );

// Border support
add_theme_support( 'border' );

// Core block patterns
add_theme_support( 'core-block-patterns' );
```

---

### get_theme_support()

Gets the arguments for a theme feature.

```php
get_theme_support( string $feature, mixed ...$args ): mixed
```

**Examples:**
```php
// Check if feature is supported
$support = get_theme_support( 'custom-logo' );

// Get specific property
$width = get_theme_support( 'custom-header', 'width' );
$flex  = get_theme_support( 'custom-logo', 'flex-width' );
```

---

### current_theme_supports()

Checks if the theme supports a feature.

```php
current_theme_supports( string $feature, mixed ...$args ): bool
```

**Examples:**
```php
if ( current_theme_supports( 'post-thumbnails' ) ) {
    the_post_thumbnail();
}

// Check specific post type support
if ( current_theme_supports( 'post-thumbnails', 'product' ) ) {
    // Product thumbnails supported
}

// Check HTML5 element support
if ( current_theme_supports( 'html5', 'gallery' ) ) {
    // HTML5 gallery markup
}
```

---

### remove_theme_support()

Removes theme support for a feature.

```php
remove_theme_support( string $feature ): bool|void
```

**Example:**
```php
// In child theme
function child_theme_setup() {
    remove_theme_support( 'custom-header' );
    remove_theme_support( 'post-formats' );
}
add_action( 'after_setup_theme', 'child_theme_setup', 11 );
```

---

## Theme Switching Functions

### switch_theme()

Switches the active theme.

```php
switch_theme( string $stylesheet ): void
```

**Example:**
```php
switch_theme( 'twentytwentyfour' );
```

**Important:** Triggers `switch_theme` action, which fires immediately. The `after_switch_theme` action fires on the next page load.

---

### validate_current_theme()

Validates the active theme has required files.

```php
validate_current_theme(): bool
```

Returns `false` and switches to fallback if theme is invalid.

---

### validate_theme_requirements()

Checks WordPress and PHP version requirements.

```php
validate_theme_requirements( string $stylesheet ): true|WP_Error
```

---

## Custom Header Functions

### get_header_image()

Gets the header image URL.

```php
get_header_image(): string|false
```

---

### has_header_image()

Checks if a header image is set.

```php
has_header_image(): bool
```

---

### get_header_image_tag()

Gets the HTML img tag for header image.

```php
get_header_image_tag( array $attr = array() ): string
```

---

### the_header_image_tag()

Outputs the header image tag.

```php
the_header_image_tag( array $attr = array() ): void
```

---

### register_default_headers()

Registers default header images.

```php
register_default_headers( array $headers ): void
```

**Example:**
```php
register_default_headers( array(
    'sunset' => array(
        'url'           => get_theme_file_uri( 'images/headers/sunset.jpg' ),
        'thumbnail_url' => get_theme_file_uri( 'images/headers/sunset-thumb.jpg' ),
        'description'   => 'Sunset',
    ),
) );
```

---

### has_header_video()

Checks if header video is set.

```php
has_header_video(): bool
```

---

### is_header_video_active()

Checks if header video should display on current page.

```php
is_header_video_active(): bool
```

---

### get_header_video_url()

Gets the header video URL.

```php
get_header_video_url(): string|false
```

---

### has_custom_header()

Checks if any custom header (image or video) is set.

```php
has_custom_header(): bool
```

---

## Custom Logo Functions

### get_custom_logo()

Gets the custom logo HTML.

```php
get_custom_logo( int $blog_id = 0 ): string
```

---

### the_custom_logo()

Displays the custom logo.

```php
the_custom_logo( int $blog_id = 0 ): void
```

---

### has_custom_logo()

Checks if a custom logo is set.

```php
has_custom_logo( int $blog_id = 0 ): bool
```

---

### get_custom_logo_url()

Gets the custom logo image URL.

```php
get_custom_logo_url( int $blog_id = 0 ): string
```

---

## Custom Background Functions

### get_background_image()

Gets the background image URL.

```php
get_background_image(): string
```

---

### get_background_color()

Gets the background color value.

```php
get_background_color(): string
```

---

## Global Styles Functions

### wp_get_global_settings()

Gets merged global settings.

```php
wp_get_global_settings( array $path = array(), array $context = array() ): mixed
```

**Context Options:**
- `block_name` - Get settings for specific block.
- `origin` - 'all' (default) or 'base' (theme only).

**Examples:**
```php
// All settings
$settings = wp_get_global_settings();

// Specific path
$palette = wp_get_global_settings( array( 'color', 'palette' ) );

// Block-specific
$heading_sizes = wp_get_global_settings( 
    array( 'typography', 'fontSizes' ),
    array( 'block_name' => 'core/heading' )
);
```

---

### wp_get_global_styles()

Gets merged global styles.

```php
wp_get_global_styles( array $path = array(), array $context = array() ): mixed
```

**Context Options:**
- `block_name` - Get styles for specific block.
- `origin` - 'all' or 'base'.
- `transforms` - Array with 'resolve-variables' to resolve CSS variables.

**Examples:**
```php
$styles = wp_get_global_styles();
$background = wp_get_global_styles( array( 'color', 'background' ) );

// With resolved variables
$resolved = wp_get_global_styles( array(), array(
    'transforms' => array( 'resolve-variables' ),
) );
```

---

### wp_get_global_stylesheet()

Gets the global stylesheet CSS.

```php
wp_get_global_stylesheet( array $types = array() ): string
```

**Types:**
- `'variables'` - CSS custom properties
- `'styles'` - Style declarations
- `'presets'` - Preset classes

**Example:**
```php
$all_css = wp_get_global_stylesheet();
$variables = wp_get_global_stylesheet( array( 'variables' ) );
```

---

### wp_theme_has_theme_json()

Checks if theme has theme.json.

```php
wp_theme_has_theme_json(): bool
```

---

### wp_is_block_theme()

Checks if active theme is a block theme.

```php
wp_is_block_theme(): bool
```

---

### wp_get_block_css_selector()

Gets CSS selector for a block type.

```php
wp_get_block_css_selector( 
    WP_Block_Type $block_type, 
    string|array $target = 'root', 
    bool $fallback = false 
): string|null
```

---

## Editor Style Functions

### add_editor_style()

Adds editor stylesheet.

```php
add_editor_style( string|array $stylesheet = 'editor-style.css' ): void
```

**Example:**
```php
function my_theme_editor_styles() {
    add_theme_support( 'editor-styles' );
    add_editor_style( 'editor-style.css' );
    add_editor_style( 'custom-fonts.css' );
}
add_action( 'after_setup_theme', 'my_theme_editor_styles' );
```

---

### remove_editor_styles()

Removes all editor stylesheets.

```php
remove_editor_styles(): bool
```

---

### get_editor_stylesheets()

Gets registered editor stylesheet URLs.

```php
get_editor_stylesheets(): string[]
```

---

## Custom CSS Functions

### wp_get_custom_css()

Gets custom CSS for a theme.

```php
wp_get_custom_css( string $stylesheet = '' ): string
```

---

### wp_get_custom_css_post()

Gets the custom CSS post object.

```php
wp_get_custom_css_post( string $stylesheet = '' ): WP_Post|null
```

---

### wp_update_custom_css_post()

Updates custom CSS for a theme.

```php
wp_update_custom_css_post( string $css, array $args = array() ): WP_Post|WP_Error
```

---

## Utility Functions

### wp_clean_themes_cache()

Clears theme cache.

```php
wp_clean_themes_cache( bool $clear_update_cache = true ): void
```

---

### search_theme_directories()

Searches for themes in registered directories.

```php
search_theme_directories( bool $force = false ): array|false
```

---

### register_theme_directory()

Registers additional theme directory.

```php
register_theme_directory( string $directory ): bool
```

**Example:**
```php
// Register custom themes directory
register_theme_directory( WP_CONTENT_DIR . '/custom-themes' );
```

---

### wp_theme_get_element_class_name()

Gets class name for theme.json element.

```php
wp_theme_get_element_class_name( string $element ): string
```

**Example:**
```php
$button_class = wp_theme_get_element_class_name( 'button' );
// Returns: 'wp-element-button'
```

---

### require_if_theme_supports()

Conditionally requires file based on theme support.

```php
require_if_theme_supports( string $feature, string $file ): bool
```

**Example:**
```php
require_if_theme_supports( 'custom-header', get_template_directory() . '/inc/custom-header.php' );
```
