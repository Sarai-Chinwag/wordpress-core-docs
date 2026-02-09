# WP_Font_Face_Resolver

Extracts font definitions from theme.json and style variations.

**Since:** 6.4.0  
**Source:** `wp-includes/fonts/class-wp-font-face-resolver.php`  
**Access:** Private (internal core usage)

## Description

This class abstracts the processing of different data sources (such as theme.json) for font face processing. It converts theme.json font definitions into the format expected by `WP_Font_Face`.

## Methods

### get_fonts_from_theme_json()

Gets fonts defined in the active theme.json.

```php
public static function get_fonts_from_theme_json(): array
```

**Returns:** Array of font families with their font-face variations.

**Process:**

1. Retrieves global settings via `wp_get_global_settings()`
2. Extracts `typography.fontFamilies`
3. Parses and converts to font-face format

**Example Return:**

```php
[
    [
        [
            'font-family' => 'Inter',
            'font-weight' => '400',
            'font-style'  => 'normal',
            'src'         => ['https://example.com/fonts/inter.woff2'],
        ],
        [
            'font-family' => 'Inter',
            'font-weight' => '700',
            'font-style'  => 'normal',
            'src'         => ['https://example.com/fonts/inter-bold.woff2'],
        ],
    ],
]
```

---

### get_fonts_from_style_variations()

Gets fonts defined in theme style variations.

```php
public static function get_fonts_from_style_variations(): array
```

**Since:** 6.7.0

**Description:**

Style variations are JSON files in the theme's `styles/` directory. Each variation can define its own fonts. This method collects fonts from all variations.

---

## Private Methods

### parse_settings()

Parses theme.json settings to extract font definitions.

```php
private static function parse_settings( array $settings ): array
```

Iterates through `typography.fontFamilies` and converts each definition.

---

### maybe_parse_name_from_comma_separated_list()

Extracts the first font name from a comma-separated font-family list.

```php
private static function maybe_parse_name_from_comma_separated_list( string $font_family ): string
```

**Example:**

```php
// "Inter, sans-serif" → "Inter"
// "'Open Sans', Arial" → "Open Sans"
```

---

### convert_font_face_properties()

Converts font-face properties from theme.json format.

```php
private static function convert_font_face_properties( 
    array $font_face_definition, 
    string $font_family_property 
): array
```

**Transformations:**

1. Adds `font-family` property to each font face
2. Converts `file:./` placeholders to theme file URIs
3. Converts camelCase properties to kebab-case

---

### to_theme_file_uri()

Converts `file:./` placeholders to theme file URIs.

```php
private static function to_theme_file_uri( array $src ): array
```

**Example:**

```php
// Input:  ['file:./assets/fonts/inter.woff2']
// Output: ['https://example.com/wp-content/themes/my-theme/assets/fonts/inter.woff2']
```

Uses `get_theme_file_uri()` for the conversion.

---

### to_kebab_case()

Converts array keys from camelCase to kebab-case.

```php
private static function to_kebab_case( array $data ): array
```

**Example:**

```php
// ['fontWeight' => '400'] → ['font-weight' => '400']
// ['fontStyle' => 'normal'] → ['font-style' => 'normal']
```

## theme.json Font Format

Input format from theme.json:

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
              "src": ["file:./assets/fonts/inter.woff2"]
            }
          ]
        }
      ]
    }
  }
}
```

Output format for WP_Font_Face:

```php
[
    [
        [
            'font-family' => 'Inter',
            'font-weight' => '400',
            'font-style'  => 'normal',
            'src'         => ['https://example.com/.../inter.woff2'],
        ],
    ],
]
```

## Usage

This class is used internally:

```php
// Called by wp_print_font_faces() when no fonts provided
$fonts = WP_Font_Face_Resolver::get_fonts_from_theme_json();

// Called by wp_print_font_faces_from_style_variations()
$fonts = WP_Font_Face_Resolver::get_fonts_from_style_variations();
```
