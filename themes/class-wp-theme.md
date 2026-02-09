# WP_Theme Class Reference

The `WP_Theme` class encapsulates theme data and provides methods for accessing theme information, files, and configuration.

## Class Overview

```php
final class WP_Theme implements ArrayAccess {
    // Properties
    public bool $update = false;
    
    // File Headers
    private static array $file_headers = array(
        'Name'        => 'Theme Name',
        'ThemeURI'    => 'Theme URI',
        'Description' => 'Description',
        'Author'      => 'Author',
        'AuthorURI'   => 'Author URI',
        'Version'     => 'Version',
        'Template'    => 'Template',
        'Status'      => 'Status',
        'Tags'        => 'Tags',
        'TextDomain'  => 'Text Domain',
        'DomainPath'  => 'Domain Path',
        'RequiresWP'  => 'Requires at least',
        'RequiresPHP' => 'Requires PHP',
        'UpdateURI'   => 'Update URI',
    );
}
```

## Constructor

```php
public function __construct( 
    string $theme_dir, 
    string $theme_root, 
    WP_Theme|null $_child = null 
)
```

**Parameters:**
- `$theme_dir` - Directory name of the theme within theme root.
- `$theme_root` - Absolute path to the theme root directory.
- `$_child` - For internal use: child theme passed for parent validation.

**Example:**
```php
// Create theme object
$theme = new WP_Theme( 'twentytwentyfour', WP_CONTENT_DIR . '/themes' );

// Recommended: use wp_get_theme() instead
$theme = wp_get_theme( 'twentytwentyfour' );
```

## Getting Theme Headers

### get()

Gets a raw, unformatted theme header value.

```php
public function get( string $header ): string|array|false
```

**Available Headers:**
| Header | Description |
|--------|-------------|
| `Name` | Theme name |
| `ThemeURI` | Theme homepage URL |
| `Description` | Theme description |
| `Author` | Author name |
| `AuthorURI` | Author website |
| `Version` | Theme version |
| `Template` | Parent theme directory (child themes only) |
| `Status` | Theme status (usually 'publish') |
| `Tags` | Array of tags |
| `TextDomain` | Translation text domain |
| `DomainPath` | Path to translations directory |
| `RequiresWP` | Minimum WordPress version |
| `RequiresPHP` | Minimum PHP version |
| `UpdateURI` | Custom update server URI |

**Examples:**
```php
$theme = wp_get_theme();

// Get basic info
$name = $theme->get( 'Name' );        // 'My Theme'
$version = $theme->get( 'Version' );  // '1.0.0'
$author = $theme->get( 'Author' );    // 'Developer Name'

// Get requirements
$requires_wp = $theme->get( 'RequiresWP' );   // '6.0'
$requires_php = $theme->get( 'RequiresPHP' ); // '8.0'

// Get tags (returns array)
$tags = $theme->get( 'Tags' );
// array( 'blog', 'two-columns', 'responsive' )

// Returns false if header doesn't exist
$unknown = $theme->get( 'NonExistent' ); // false
```

### display()

Gets a theme header formatted and translated for display.

```php
public function display( 
    string $header, 
    bool $markup = true, 
    bool $translate = true 
): string|array|false
```

**Parameters:**
- `$header` - Header name.
- `$markup` - Whether to apply markup (links, formatting).
- `$translate` - Whether to translate the value.

**Examples:**
```php
$theme = wp_get_theme();

// With markup and translation (default)
$author = $theme->display( 'Author' );
// Returns: '<a href="https://author.com">Author Name</a>'

// Without markup
$author = $theme->display( 'Author', false );
// Returns: 'Author Name'

// Tags with markup become comma-separated string
$tags = $theme->display( 'Tags' );
// Returns: 'Blog, Two Columns, Responsive'

// Tags without markup return array
$tags = $theme->display( 'Tags', false );
// Returns: array( 'Blog', 'Two Columns', 'Responsive' )
```

## Directory & Path Methods

### get_stylesheet()

Gets the stylesheet directory name.

```php
public function get_stylesheet(): string
```

For child themes, this is the child theme directory. For parent themes, same as `get_template()`.

```php
$theme = wp_get_theme();
echo $theme->get_stylesheet(); // 'my-child-theme'
```

### get_template()

Gets the template directory name.

```php
public function get_template(): string
```

For child themes, returns the parent theme directory. For parent themes, same as `get_stylesheet()`.

```php
$theme = wp_get_theme();
echo $theme->get_template(); // 'parent-theme'
```

### get_stylesheet_directory()

Gets the absolute path to the stylesheet directory.

```php
public function get_stylesheet_directory(): string
```

```php
$path = $theme->get_stylesheet_directory();
// /var/www/html/wp-content/themes/my-theme
```

### get_template_directory()

Gets the absolute path to the template directory.

```php
public function get_template_directory(): string
```

```php
$path = $theme->get_template_directory();
// For child: /var/www/html/wp-content/themes/parent-theme
// For parent: /var/www/html/wp-content/themes/my-theme
```

### get_stylesheet_directory_uri()

Gets the URL to the stylesheet directory.

```php
public function get_stylesheet_directory_uri(): string
```

```php
$uri = $theme->get_stylesheet_directory_uri();
// https://example.com/wp-content/themes/my-theme
```

### get_template_directory_uri()

Gets the URL to the template directory.

```php
public function get_template_directory_uri(): string
```

### get_theme_root()

Gets the absolute path to the theme root.

```php
public function get_theme_root(): string
```

```php
$root = $theme->get_theme_root();
// /var/www/html/wp-content/themes
```

### get_theme_root_uri()

Gets the URL to the theme root.

```php
public function get_theme_root_uri(): string
```

### get_file_path()

Gets path to a file in the theme (checks child before parent).

```php
public function get_file_path( string $file = '' ): string
```

```php
$theme = wp_get_theme();

// Get path to theme root
$path = $theme->get_file_path();

// Get path to specific file
$config = $theme->get_file_path( 'inc/config.php' );
// Checks child theme first, then parent
```

## Theme State Methods

### exists()

Checks if the theme exists.

```php
public function exists(): bool
```

A theme with errors still "exists" unless the error is 'theme_not_found'.

```php
$theme = wp_get_theme( 'maybe-theme' );
if ( $theme->exists() ) {
    echo 'Theme found!';
}
```

### errors()

Gets theme errors.

```php
public function errors(): WP_Error|false
```

**Error Codes:**
| Code | Description |
|------|-------------|
| `theme_not_found` | Theme directory doesn't exist |
| `theme_no_stylesheet` | style.css missing |
| `theme_stylesheet_not_readable` | style.css not readable |
| `theme_no_index` | Missing index.php or templates/index.html |
| `theme_no_parent` | Parent theme not found |
| `theme_parent_invalid` | Invalid parent theme |
| `theme_child_invalid` | Theme references itself as parent |
| `theme_paused` | Theme paused due to fatal error |
| `theme_wp_incompatible` | WordPress version too low |
| `theme_php_incompatible` | PHP version too low |
| `theme_wp_php_incompatible` | Both versions too low |

```php
$theme = wp_get_theme( 'broken-theme' );
if ( $errors = $theme->errors() ) {
    foreach ( $errors->get_error_codes() as $code ) {
        echo "Error: $code - " . $errors->get_error_message( $code );
    }
}
```

### parent()

Gets the parent theme object.

```php
public function parent(): WP_Theme|false
```

```php
$theme = wp_get_theme();
if ( $parent = $theme->parent() ) {
    echo 'Parent theme: ' . $parent->get( 'Name' );
} else {
    echo 'This is not a child theme';
}
```

### is_block_theme()

Checks if this is a block-based theme.

```php
public function is_block_theme(): bool
```

```php
$theme = wp_get_theme();
if ( $theme->is_block_theme() ) {
    echo 'This is a block theme';
}
```

A block theme requires `templates/index.html` or deprecated `block-templates/index.html`.

### is_allowed()

Checks if theme is allowed (multisite).

```php
public function is_allowed( string $check = 'both', int $blog_id = null ): bool
```

**Parameters:**
- `$check` - 'network', 'site', or 'both'
- `$blog_id` - Blog ID for site-level check

```php
// On multisite
if ( $theme->is_allowed() ) {
    echo 'Theme is allowed on this site';
}

if ( $theme->is_allowed( 'network' ) ) {
    echo 'Theme is network-enabled';
}
```

## File & Template Methods

### get_files()

Gets files in the theme directory.

```php
public function get_files( 
    string|array|null $type = null, 
    int $depth = 0, 
    bool $search_parent = false 
): array
```

**Parameters:**
- `$type` - File extension(s) to find, or null for all.
- `$depth` - How deep to search (0 = flat, -1 = infinite).
- `$search_parent` - Include parent theme files.

**Returns:** Array keyed by relative path with absolute path values.

```php
$theme = wp_get_theme();

// Get PHP files in root directory
$php_files = $theme->get_files( 'php' );

// Get all PHP files recursively
$all_php = $theme->get_files( 'php', -1 );

// Get CSS and JS files
$assets = $theme->get_files( array( 'css', 'js' ), -1 );

// Include parent theme files
$all_files = $theme->get_files( 'php', -1, true );

// Result structure:
// array(
//     'index.php' => '/path/to/theme/index.php',
//     'inc/functions.php' => '/path/to/theme/inc/functions.php',
// )
```

### get_post_templates()

Gets all post templates defined by the theme.

```php
public function get_post_templates(): array
```

Returns array keyed by post type, then by template file.

```php
$templates = $theme->get_post_templates();
/*
array(
    'page' => array(
        'templates/full-width.php' => 'Full Width',
        'templates/landing.php' => 'Landing Page',
    ),
    'post' => array(
        'templates/featured.php' => 'Featured Post',
    ),
)
*/
```

### get_page_templates()

Gets templates for a specific post type.

```php
public function get_page_templates( 
    WP_Post|null $post = null, 
    string $post_type = 'page' 
): array
```

```php
$page_templates = $theme->get_page_templates( null, 'page' );
$post_templates = $theme->get_page_templates( null, 'post' );
```

### get_screenshot()

Gets the theme screenshot.

```php
public function get_screenshot( string $uri = 'uri' ): string|false
```

**Parameters:**
- `$uri` - 'uri' for absolute URL, 'relative' for relative path.

Supported formats: png, gif, jpg, jpeg, webp, avif

```php
$screenshot = $theme->get_screenshot();
// https://example.com/wp-content/themes/my-theme/screenshot.png

$relative = $theme->get_screenshot( 'relative' );
// screenshot.png
```

## Block Theme Methods

### get_block_template_folders()

Gets the block template directory names.

```php
public function get_block_template_folders(): array
```

```php
$folders = $theme->get_block_template_folders();
/*
array(
    'wp_template'      => 'templates',      // or 'block-templates' (deprecated)
    'wp_template_part' => 'parts',          // or 'block-template-parts' (deprecated)
)
*/
```

### get_block_patterns()

Gets block patterns from the theme's patterns directory.

```php
public function get_block_patterns(): array
```

```php
$patterns = $theme->get_block_patterns();
/*
array(
    'hero.php' => array(
        'title' => 'Hero Section',
        'slug' => 'theme-slug/hero',
        'categories' => array( 'featured' ),
        'keywords' => array( 'hero', 'banner' ),
        'blockTypes' => array( 'core/cover' ),
        'postTypes' => array( 'page' ),
        'viewportWidth' => 1200,
        'inserter' => true,
    ),
)
*/
```

## Cache Methods

### cache_delete()

Clears the theme cache.

```php
public function cache_delete(): void
```

Forces re-reading of theme data from disk on next access.

```php
$theme = wp_get_theme();
$theme->cache_delete();
```

### delete_pattern_cache()

Clears the block pattern cache.

```php
public function delete_pattern_cache(): void
```

## Static Methods

### get_core_default_theme()

Gets the latest installed WordPress default theme.

```php
public static function get_core_default_theme(): WP_Theme|false
```

```php
$default = WP_Theme::get_core_default_theme();
if ( $default ) {
    echo 'Latest default: ' . $default->get( 'Name' );
}
```

### get_allowed()

Gets themes allowed for a site (multisite).

```php
public static function get_allowed( int $blog_id = null ): array
```

```php
$allowed = WP_Theme::get_allowed();
// array( 'theme-slug' => true, 'another-theme' => true )
```

### get_allowed_on_network()

Gets themes allowed network-wide.

```php
public static function get_allowed_on_network(): array
```

### get_allowed_on_site()

Gets themes allowed on a specific site.

```php
public static function get_allowed_on_site( int $blog_id = null ): array
```

### network_enable_theme()

Enables theme(s) network-wide.

```php
public static function network_enable_theme( string|array $stylesheets ): void
```

```php
WP_Theme::network_enable_theme( 'twentytwentyfour' );
WP_Theme::network_enable_theme( array( 'theme-one', 'theme-two' ) );
```

### network_disable_theme()

Disables theme(s) network-wide.

```php
public static function network_disable_theme( string|array $stylesheets ): void
```

### sort_by_name()

Sorts themes array by name.

```php
public static function sort_by_name( array &$themes ): void
```

```php
$themes = wp_get_themes();
WP_Theme::sort_by_name( $themes );
```

## ArrayAccess Interface

`WP_Theme` implements `ArrayAccess` for backward compatibility:

```php
$theme = wp_get_theme();

// These work like get_themes() return format
echo $theme['Name'];           // Theme name
echo $theme['Version'];        // Version
echo $theme['Author'];         // Author with link
echo $theme['Author Name'];    // Author without link
echo $theme['Author URI'];     // Author URI
echo $theme['Description'];    // Description
echo $theme['Template'];       // Template directory
echo $theme['Stylesheet'];     // Stylesheet directory
echo $theme['Template Dir'];   // Template directory path
echo $theme['Stylesheet Dir']; // Stylesheet directory path
echo $theme['Screenshot'];     // Screenshot relative path
echo $theme['Tags'];           // Tags array
echo $theme['Theme Root'];     // Theme root path
echo $theme['Theme Root URI']; // Theme root URL
echo $theme['Parent Theme'];   // Parent theme name
```

## Magic Properties

These properties are available via `__get()`:

```php
$theme = wp_get_theme();

echo $theme->name;           // Theme name
echo $theme->title;          // Same as name
echo $theme->version;        // Version
echo $theme->parent_theme;   // Parent theme name
echo $theme->template_dir;   // Template directory path
echo $theme->stylesheet_dir; // Stylesheet directory path
echo $theme->template;       // Template directory name
echo $theme->stylesheet;     // Stylesheet directory name
echo $theme->screenshot;     // Screenshot relative path
echo $theme->description;    // Description (translated)
echo $theme->author;         // Author (translated)
echo $theme->tags;           // Tags array
echo $theme->theme_root;     // Theme root path
echo $theme->theme_root_uri; // Theme root URL
```

## Default Themes

WordPress maintains a list of default themes:

```php
private static $default_themes = array(
    'classic'           => 'WordPress Classic',
    'default'           => 'WordPress Default',
    'twentyten'         => 'Twenty Ten',
    'twentyeleven'      => 'Twenty Eleven',
    'twentytwelve'      => 'Twenty Twelve',
    'twentythirteen'    => 'Twenty Thirteen',
    'twentyfourteen'    => 'Twenty Fourteen',
    'twentyfifteen'     => 'Twenty Fifteen',
    'twentysixteen'     => 'Twenty Sixteen',
    'twentyseventeen'   => 'Twenty Seventeen',
    'twentynineteen'    => 'Twenty Nineteen',
    'twentytwenty'      => 'Twenty Twenty',
    'twentytwentyone'   => 'Twenty Twenty-One',
    'twentytwentytwo'   => 'Twenty Twenty-Two',
    'twentytwentythree' => 'Twenty Twenty-Three',
    'twentytwentyfour'  => 'Twenty Twenty-Four',
    'twentytwentyfive'  => 'Twenty Twenty-Five',
);
```

## String Conversion

Converting to string returns the translated theme name:

```php
$theme = wp_get_theme();
echo $theme; // Outputs: "My Theme Name"
echo (string) $theme; // Same
```

## Complete Usage Example

```php
function analyze_theme( $stylesheet = '' ) {
    $theme = wp_get_theme( $stylesheet );
    
    if ( ! $theme->exists() ) {
        return new WP_Error( 'theme_not_found', 'Theme does not exist' );
    }
    
    if ( $errors = $theme->errors() ) {
        return $errors;
    }
    
    $info = array(
        'name'        => $theme->get( 'Name' ),
        'version'     => $theme->get( 'Version' ),
        'author'      => $theme->display( 'Author', false ),
        'description' => $theme->get( 'Description' ),
        'tags'        => $theme->get( 'Tags' ),
        'is_block'    => $theme->is_block_theme(),
        'is_child'    => (bool) $theme->parent(),
        'requires_wp' => $theme->get( 'RequiresWP' ),
        'requires_php'=> $theme->get( 'RequiresPHP' ),
        'screenshot'  => $theme->get_screenshot(),
        'directory'   => $theme->get_stylesheet_directory(),
    );
    
    if ( $theme->parent() ) {
        $info['parent'] = $theme->parent()->get( 'Name' );
    }
    
    if ( $theme->is_block_theme() ) {
        $info['patterns'] = count( $theme->get_block_patterns() );
        $info['template_folders'] = $theme->get_block_template_folders();
    }
    
    return $info;
}

// Usage
$info = analyze_theme( 'twentytwentyfour' );
print_r( $info );
```
