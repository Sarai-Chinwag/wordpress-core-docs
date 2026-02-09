# WP_Font_Face

Generates and prints `@font-face` CSS styles for given fonts.

**Since:** 6.4.0  
**Source:** `wp-includes/fonts/class-wp-font-face.php`

## Description

This class handles the generation of CSS `@font-face` rules from font definitions. It validates font properties, orders sources for optimal browser support, and outputs the CSS in a style element.

## Properties

### $font_face_property_defaults

```php
private array $font_face_property_defaults = [
    'font-family'  => '',
    'font-style'   => 'normal',
    'font-weight'  => '400',
    'font-display' => 'fallback',
];
```

### $valid_font_face_properties

```php
private array $valid_font_face_properties = [
    'ascent-override',
    'descent-override',
    'font-display',
    'font-family',
    'font-stretch',
    'font-style',
    'font-weight',
    'font-variant',
    'font-feature-settings',
    'font-variation-settings',
    'line-gap-override',
    'size-adjust',
    'src',
    'unicode-range',
];
```

### $valid_font_display

```php
private array $valid_font_display = [
    'auto',
    'block',
    'fallback',
    'swap',
    'optional',
];
```

## Methods

### __construct()

Creates and initializes an instance of WP_Font_Face.

```php
public function __construct()
```

Sets up style tag attributes. Adds `type="text/css"` if the theme doesn't support HTML5 style elements.

---

### generate_and_print()

Generates and prints the `@font-face` styles for the given fonts.

```php
public function generate_and_print( array $fonts ): void
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$fonts` | `array[][]` | Font families with their font variations |

**Process:**

1. Validates all font faces
2. Generates CSS with optimized src ordering
3. Strips tags for security
4. Prints style element

**Example:**

```php
$wp_font_face = new WP_Font_Face();
$wp_font_face->generate_and_print([
    [
        [
            'font-family' => 'My Font',
            'src'         => 'https://example.com/font.woff2',
            'font-weight' => '400',
        ],
    ],
]);
```

**Output:**

```html
<style class='wp-fonts-local'>
@font-face{font-family:"My Font";src:url('https://example.com/font.woff2') format('woff2');font-style:normal;font-weight:400;font-display:fallback;}
</style>
```

---

## Private Methods

### validate_fonts()

Validates each font-face in the fonts array.

```php
private function validate_fonts( array $fonts ): array
```

---

### validate_font_face_declarations()

Validates individual font-face declarations.

```php
private function validate_font_face_declarations( array $font_face ): array|false
```

**Validation Rules:**

- `font-family` must be a non-empty string
- `src` must be a non-empty string or array of strings
- `font-weight` must be string or integer
- `font-display` must be a valid value (defaults if invalid)
- Invalid properties are removed

---

### get_style_element()

Returns the style element wrapper.

```php
private function get_style_element(): string
```

Returns: `<style class='wp-fonts-local'{attrs}>\n%s\n</style>\n`

---

### get_css()

Generates the `@font-face` CSS for all font faces.

```php
private function get_css( array $font_faces ): string
```

---

### order_src()

Orders `src` items for optimal browser support.

```php
private function order_src( array $font_face ): array
```

**Order:**

1. Data URIs
2. woff2
3. woff
4. ttf (truetype)
5. eot (embedded-opentype)
6. otf (opentype)

---

### build_font_face_css()

Builds the CSS declarations for a single font face.

```php
private function build_font_face_css( array $font_face ): string
```

**Processing:**

- Wraps font-family in quotes if it contains spaces
- Compiles src array to CSS format
- Converts font-variation-settings array to string

---

### compile_src()

Compiles the src array into valid CSS.

```php
private function compile_src( array $value ): string
```

**Output formats:**

- Data URI: `url(data:...)`
- File URL: `url('path') format('woff2')`

---

### compile_variations()

Compiles font variation settings array to CSS.

```php
private function compile_variations( array $font_variation_settings ): string
```

## Usage

This class is typically used internally by `wp_print_font_faces()`:

```php
// Automatic usage via function
wp_print_font_faces( $fonts );

// Direct usage
$font_face = new WP_Font_Face();
$font_face->generate_and_print( $fonts );
```
