# WordPress Themes API Overview

The Themes API provides comprehensive functionality for theme management, template loading, global styles, and the transition from classic to block-based themes.

## Architecture

WordPress themes operate through several interconnected systems:

```
┌─────────────────────────────────────────────────────────────────┐
│                        Theme System                              │
├─────────────────────────────────────────────────────────────────┤
│  Theme Loading         Template Resolution        Global Styles  │
│  ├─ WP_Theme           ├─ Template Hierarchy      ├─ theme.json  │
│  ├─ theme.php          ├─ template.php            ├─ WP_Theme_JSON│
│  └─ switch_theme()     ├─ template-loader.php     └─ Resolver    │
│                        └─ locate_template()                      │
├─────────────────────────────────────────────────────────────────┤
│  Classic Themes                    Block Themes                   │
│  ├─ PHP templates                  ├─ HTML block templates        │
│  ├─ style.css headers              ├─ theme.json configuration    │
│  ├─ functions.php                  ├─ templates/ directory        │
│  └─ add_theme_support()            └─ parts/ directory            │
└─────────────────────────────────────────────────────────────────┘
```

## Classic vs Block Themes

### Classic Themes

Traditional themes using PHP template files:

```php
// Required files
style.css        // Theme headers and styles
index.php        // Fallback template

// Optional files
functions.php    // Theme setup and functionality
header.php       // Site header
footer.php       // Site footer
sidebar.php      // Sidebar
single.php       // Single post
page.php         // Static page
archive.php      // Archives
```

**Theme Setup Example:**
```php
function mytheme_setup() {
    // Enable post thumbnails
    add_theme_support( 'post-thumbnails' );
    
    // Enable title tag management
    add_theme_support( 'title-tag' );
    
    // Custom logo support
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
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
    
    // Register nav menus
    register_nav_menus( array(
        'primary' => 'Primary Menu',
        'footer'  => 'Footer Menu',
    ) );
}
add_action( 'after_setup_theme', 'mytheme_setup' );
```

### Block Themes

Modern themes using HTML block templates and theme.json:

```
theme-name/
├── style.css              // Theme headers
├── theme.json             // Settings & styles
├── templates/             // Block templates
│   ├── index.html
│   ├── single.html
│   ├── page.html
│   └── archive.html
├── parts/                 // Template parts
│   ├── header.html
│   └── footer.html
├── patterns/              // Block patterns
│   └── hero.php
└── styles/                // Style variations
    └── dark.json
```

**Block Theme Detection:**
```php
// Check if current theme is a block theme
if ( wp_is_block_theme() ) {
    // Block theme specific code
}

// Check if theme has theme.json
if ( wp_theme_has_theme_json() ) {
    // Theme.json available
}
```

## Template Hierarchy

WordPress uses a hierarchical system to determine which template file to load. More specific templates take precedence over generic ones.

### Complete Hierarchy

| Query Type | Template Hierarchy (Most Specific → Generic) |
|------------|---------------------------------------------|
| **Front Page** | `front-page.php` → Page hierarchy or Home hierarchy |
| **Home (Blog)** | `home.php` → `index.php` |
| **Single Post** | `single-{post-type}-{slug}.php` → `single-{post-type}.php` → `single.php` → `singular.php` → `index.php` |
| **Page** | `{custom-template}.php` → `page-{slug}.php` → `page-{id}.php` → `page.php` → `singular.php` → `index.php` |
| **Category** | `category-{slug}.php` → `category-{id}.php` → `category.php` → `archive.php` → `index.php` |
| **Tag** | `tag-{slug}.php` → `tag-{id}.php` → `tag.php` → `archive.php` → `index.php` |
| **Taxonomy** | `taxonomy-{tax}-{term}.php` → `taxonomy-{tax}.php` → `taxonomy.php` → `archive.php` → `index.php` |
| **Author** | `author-{nicename}.php` → `author-{id}.php` → `author.php` → `archive.php` → `index.php` |
| **Date** | `date.php` → `archive.php` → `index.php` |
| **Archive** | `archive-{post-type}.php` → `archive.php` → `index.php` |
| **Search** | `search.php` → `index.php` |
| **404** | `404.php` → `index.php` |
| **Attachment** | `{mime-type}-{subtype}.php` → `{subtype}.php` → `{mime-type}.php` → `attachment.php` → `single.php` → `index.php` |
| **Embed** | `embed-{post-type}-{format}.php` → `embed-{post-type}.php` → `embed.php` |

### Template Loading Process

```php
// 1. template-loader.php runs after query is parsed
// 2. Checks query conditionals in order:
$tag_templates = array(
    'is_embed'             => 'get_embed_template',
    'is_404'               => 'get_404_template',
    'is_search'            => 'get_search_template',
    'is_front_page'        => 'get_front_page_template',
    'is_home'              => 'get_home_template',
    'is_privacy_policy'    => 'get_privacy_policy_template',
    'is_post_type_archive' => 'get_post_type_archive_template',
    'is_tax'               => 'get_taxonomy_template',
    'is_attachment'        => 'get_attachment_template',
    'is_single'            => 'get_single_template',
    'is_page'              => 'get_page_template',
    'is_singular'          => 'get_singular_template',
    'is_category'          => 'get_category_template',
    'is_tag'               => 'get_tag_template',
    'is_author'            => 'get_author_template',
    'is_date'              => 'get_date_template',
    'is_archive'           => 'get_archive_template',
);

// 3. First match triggers template location
// 4. Falls back to index.php if nothing matches
```

### Block Template Resolution

For block themes, the system also checks for HTML templates:

```php
// Block templates are checked in:
// 1. templates/ directory (preferred)
// 2. block-templates/ directory (deprecated)

// Template lookup order for block themes:
// 1. User-customized templates (wp_template CPT)
// 2. Child theme templates/ directory
// 3. Parent theme templates/ directory
// 4. PHP fallback templates
```

## theme.json Configuration

The `theme.json` file is the central configuration for block themes and modern classic themes.

### Schema Structure

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "settings": {
        "color": {
            "palette": [],
            "gradients": [],
            "duotone": [],
            "custom": true,
            "customGradient": true,
            "defaultPalette": true
        },
        "typography": {
            "fontFamilies": [],
            "fontSizes": [],
            "customFontSize": true,
            "lineHeight": true
        },
        "spacing": {
            "padding": true,
            "margin": true,
            "blockGap": true,
            "units": ["px", "em", "rem", "%", "vw", "vh"]
        },
        "layout": {
            "contentSize": "800px",
            "wideSize": "1200px"
        },
        "appearanceTools": true
    },
    "styles": {
        "color": {
            "background": "#ffffff",
            "text": "#000000"
        },
        "typography": {
            "fontFamily": "var(--wp--preset--font-family--system)",
            "fontSize": "var(--wp--preset--font-size--medium)"
        },
        "spacing": {
            "padding": {
                "top": "2rem",
                "right": "2rem",
                "bottom": "2rem",
                "left": "2rem"
            }
        },
        "elements": {
            "link": {
                "color": {
                    "text": "#0073aa"
                }
            },
            "button": {
                "color": {
                    "background": "#0073aa",
                    "text": "#ffffff"
                }
            }
        },
        "blocks": {
            "core/paragraph": {
                "typography": {
                    "lineHeight": "1.8"
                }
            }
        }
    },
    "customTemplates": [],
    "templateParts": [],
    "patterns": []
}
```

### Settings Hierarchy

Settings cascade from global to block-specific:

```
1. WordPress Core Defaults
   └─ 2. Theme theme.json settings
       └─ 3. Block-level settings.blocks.{block}
           └─ 4. User customizations (wp_global_styles CPT)
```

### Appearance Tools

When `appearanceTools: true`, these settings are enabled:

```json
{
    "settings": {
        "background": { "backgroundImage": true, "backgroundSize": true },
        "border": { "color": true, "radius": true, "style": true, "width": true },
        "color": { "link": true, "heading": true, "button": true, "caption": true },
        "dimensions": { "aspectRatio": true, "minHeight": true },
        "position": { "sticky": true },
        "spacing": { "blockGap": true, "margin": true, "padding": true },
        "typography": { "lineHeight": true }
    }
}
```

### CSS Custom Properties

theme.json generates CSS custom properties:

```css
/* Preset variables */
--wp--preset--color--primary: #0073aa;
--wp--preset--font-size--medium: 1rem;
--wp--preset--spacing--40: 2rem;

/* Style variables */
--wp--style--root--padding-top: 2rem;
--wp--style--block-gap: 1.5rem;
```

## Global Styles API

### Accessing Global Settings

```php
// Get all settings
$settings = wp_get_global_settings();

// Get specific setting
$colors = wp_get_global_settings( array( 'color', 'palette' ) );

// Get block-specific setting
$paragraph_settings = wp_get_global_settings( 
    array( 'typography' ), 
    array( 'block_name' => 'core/paragraph' ) 
);

// Get base (theme-only) settings
$base_settings = wp_get_global_settings( 
    array(), 
    array( 'origin' => 'base' ) 
);
```

### Accessing Global Styles

```php
// Get all styles
$styles = wp_get_global_styles();

// Get specific style
$background = wp_get_global_styles( array( 'color', 'background' ) );

// Get with variable resolution
$resolved_styles = wp_get_global_styles(
    array(),
    array( 'transforms' => array( 'resolve-variables' ) )
);
```

### Global Stylesheet

```php
// Get the complete global stylesheet
$stylesheet = wp_get_global_stylesheet();

// Get specific types
$variables_only = wp_get_global_stylesheet( array( 'variables' ) );
$styles_only = wp_get_global_stylesheet( array( 'styles' ) );
$presets_only = wp_get_global_stylesheet( array( 'presets' ) );
```

## Theme Modifications (Mods)

Store and retrieve theme-specific settings:

```php
// Get a theme mod
$header_color = get_theme_mod( 'header_textcolor', '#000000' );

// Set a theme mod
set_theme_mod( 'header_textcolor', '#ffffff' );

// Remove a theme mod
remove_theme_mod( 'header_textcolor' );

// Get all theme mods
$all_mods = get_theme_mods();

// Remove all theme mods
remove_theme_mods();
```

## Style Variations

Block themes can include style variations in the `styles/` directory:

```json
// styles/dark.json
{
    "version": 3,
    "title": "Dark Mode",
    "settings": {},
    "styles": {
        "color": {
            "background": "#1a1a1a",
            "text": "#ffffff"
        }
    }
}
```

Access style variations programmatically:

```php
// Get available style variations
$variations = WP_Theme_JSON_Resolver::get_style_variations();

// Each variation has 'title', 'settings', and 'styles'
foreach ( $variations as $variation ) {
    echo $variation['title'];
}
```

## Block Template Parts

Template parts allow reusable sections:

```html
<!-- parts/header.html -->
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- wp:site-title /-->
    <!-- wp:navigation /-->
</div>
<!-- /wp:group -->
```

**Register template parts in theme.json:**
```json
{
    "templateParts": [
        {
            "name": "header",
            "title": "Header",
            "area": "header"
        },
        {
            "name": "footer", 
            "title": "Footer",
            "area": "footer"
        }
    ]
}
```

**Include in templates:**
```html
<!-- wp:template-part {"slug":"header","area":"header"} /-->
```

## Child Themes

Child themes inherit from parent themes:

```php
// style.css header
/*
 Theme Name:   My Child Theme
 Template:     parent-theme-slug
 Version:      1.0.0
*/

// Child theme template files override parent
// Child theme theme.json merges with parent
// styles/ variations from both are available
```

**Child Theme Functions:**
```php
// Enqueue parent and child styles
function child_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', 
        get_template_directory_uri() . '/style.css' 
    );
}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );
```

## Theme Features

### Core Theme Features

| Feature | Description |
|---------|-------------|
| `title-tag` | Let WordPress manage the document title |
| `post-thumbnails` | Enable featured images |
| `custom-logo` | Site logo support |
| `custom-header` | Header image/video customization |
| `custom-background` | Background customization |
| `html5` | HTML5 markup for various elements |
| `automatic-feed-links` | RSS feed links in head |
| `post-formats` | Post format support |
| `menus` | Navigation menu support |
| `widgets` | Widget area support |

### Block Editor Features

| Feature | Description |
|---------|-------------|
| `editor-styles` | Load editor stylesheets |
| `dark-editor-style` | Indicate dark editor UI |
| `align-wide` | Wide/full alignment support |
| `responsive-embeds` | Responsive embed support |
| `wp-block-styles` | Default block styles |
| `block-templates` | Block-based templates |
| `block-template-parts` | Block-based template parts |
| `appearance-tools` | Enable design tools |

### Color & Typography Features

| Feature | Description |
|---------|-------------|
| `editor-color-palette` | Custom color palette |
| `editor-gradient-presets` | Custom gradients |
| `editor-font-sizes` | Custom font sizes |
| `disable-custom-colors` | Disable custom colors |
| `disable-custom-font-sizes` | Disable custom font sizes |
| `disable-custom-gradients` | Disable custom gradients |

## Theme Directory Structure

### Recommended Classic Theme Structure

```
theme-name/
├── style.css
├── index.php
├── functions.php
├── screenshot.png
├── header.php
├── footer.php
├── sidebar.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── 404.php
├── comments.php
├── inc/
│   ├── customizer.php
│   └── template-functions.php
├── template-parts/
│   ├── content.php
│   └── content-single.php
├── assets/
│   ├── css/
│   └── js/
└── languages/
```

### Recommended Block Theme Structure

```
theme-name/
├── style.css
├── theme.json
├── screenshot.png
├── functions.php (optional)
├── templates/
│   ├── index.html
│   ├── single.html
│   ├── page.html
│   ├── archive.html
│   ├── search.html
│   └── 404.html
├── parts/
│   ├── header.html
│   ├── footer.html
│   └── sidebar.html
├── patterns/
│   ├── hero.php
│   └── call-to-action.php
├── styles/
│   ├── dark.json
│   └── contrast.json
└── assets/
    └── fonts/
```

## Security Considerations

1. **Escape Output** - Always escape theme output
2. **Sanitize Input** - Sanitize customizer settings
3. **Use Nonces** - Protect form submissions
4. **Validate Files** - Validate uploaded theme files
5. **Check Capabilities** - Verify user permissions

```php
// Safe output example
echo esc_html( get_theme_mod( 'site_title' ) );
echo esc_url( get_theme_mod( 'logo_url' ) );
echo esc_attr( get_theme_mod( 'class_name' ) );
echo wp_kses_post( get_theme_mod( 'description' ) );
```
