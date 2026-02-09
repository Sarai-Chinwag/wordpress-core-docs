# Fonts API

Framework for managing web fonts, font faces, and font collections in WordPress.

**Since:** 6.4.0 (core), 6.5.0 (Font Library/Collections)  
**Source:** `wp-includes/fonts.php`, `wp-includes/fonts/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core font functions |
| [class-wp-font-face.md](./class-wp-font-face.md) | Generates @font-face CSS |
| [class-wp-font-face-resolver.md](./class-wp-font-face-resolver.md) | Extracts fonts from theme.json |
| [class-wp-font-library.md](./class-wp-font-library.md) | Font collection registry singleton |
| [class-wp-font-collection.md](./class-wp-font-collection.md) | Individual font collection |
| [class-wp-font-utils.md](./class-wp-font-utils.md) | Font utility functions |
| [hooks.md](./hooks.md) | Filters |

## Architecture

The Fonts API has two main subsystems:

### 1. Font Face Generation (6.4.0+)

Handles outputting `@font-face` CSS rules for fonts defined in theme.json:

```
theme.json
    └── WP_Font_Face_Resolver::get_fonts_from_theme_json()
            └── WP_Font_Face::generate_and_print()
                    └── <style class="wp-fonts-local">@font-face{...}</style>
```

### 2. Font Library (6.5.0+)

Manages font collections (like Google Fonts) that users can install:

```
wp_register_font_collection()
    └── WP_Font_Library::register_font_collection()
            └── new WP_Font_Collection()

WP_Font_Collection::get_data()
    └── load_from_json() (file or URL)
            └── Sanitize and cache font families
```

## Font Face Properties

Supported CSS `@font-face` properties:

| Property | Default | Description |
|----------|---------|-------------|
| `font-family` | (required) | Font family name |
| `src` | (required) | URL(s) to font files |
| `font-style` | `normal` | Font style |
| `font-weight` | `400` | Font weight |
| `font-display` | `fallback` | Display strategy |
| `font-stretch` | - | Font stretch |
| `font-variant` | - | Font variant |
| `font-feature-settings` | - | OpenType features |
| `font-variation-settings` | - | Variable font settings |
| `unicode-range` | - | Unicode range subset |
| `ascent-override` | - | Ascent metric override |
| `descent-override` | - | Descent metric override |
| `line-gap-override` | - | Line gap override |
| `size-adjust` | - | Size adjustment |

## Font Display Values

| Value | Behavior |
|-------|----------|
| `auto` | Browser default |
| `block` | Block period, then swap |
| `swap` | Minimal block, then swap |
| `fallback` | Short block, short swap, then fail |
| `optional` | Minimal block, no swap |

## Font File Formats

Source ordering (browser optimization):

1. **woff2** - Best compression, modern browsers
2. **woff** - Good compression, wide support
3. **ttf/truetype** - Uncompressed, universal
4. **eot** - Legacy IE
5. **otf/opentype** - OpenType format

## Font Directory

Uploaded fonts are stored in `wp-content/uploads/fonts/`:

```php
$font_dir = wp_get_font_dir();
// [
//     'path'    => '/var/www/html/wp-content/uploads/fonts',
//     'url'     => 'https://example.com/wp-content/uploads/fonts',
//     'subdir'  => '',
//     'basedir' => '/var/www/html/wp-content/uploads/fonts',
//     'baseurl' => 'https://example.com/wp-content/uploads/fonts',
//     'error'   => false,
// ]
```

## Post Types

Fonts are stored as custom post types:

| Post Type | Description |
|-----------|-------------|
| `wp_font_family` | Font family container |
| `wp_font_face` | Individual font face (child of family) |

## Default Collections

WordPress registers the Google Fonts collection by default:

```php
wp_register_font_collection( 'google-fonts', [
    'name'          => 'Google Fonts',
    'description'   => 'Install from Google Fonts...',
    'font_families' => 'https://s.w.org/images/fonts/.../google-fonts-with-preview.json',
    'categories'    => [ 'Sans Serif', 'Display', 'Serif', 'Handwriting', 'Monospace' ],
]);
```

## theme.json Integration

Define fonts in theme.json:

```json
{
  "settings": {
    "typography": {
      "fontFamilies": [
        {
          "fontFamily": "Inter, sans-serif",
          "slug": "inter",
          "name": "Inter",
          "fontFace": [
            {
              "fontFamily": "Inter",
              "fontWeight": "400",
              "fontStyle": "normal",
              "src": [ "file:./assets/fonts/inter-regular.woff2" ]
            },
            {
              "fontFamily": "Inter",
              "fontWeight": "700",
              "fontStyle": "normal",
              "src": [ "file:./assets/fonts/inter-bold.woff2" ]
            }
          ]
        }
      ]
    }
  }
}
```

The `file:./` prefix is replaced with the theme's URL.
