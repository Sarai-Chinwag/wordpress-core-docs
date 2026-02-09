# WP_Font_Utils

Utility functions for working with fonts.

**Since:** 6.5.0  
**Source:** `wp-includes/fonts/class-wp-font-utils.php`  
**Access:** Private (internal core usage)

## Description

Provides utility functions for font family sanitization, slug generation, schema-based sanitization, and MIME type handling. These utilities are intended for internal use.

## Methods

### sanitize_font_family()

Sanitizes and formats font family names.

```php
public static function sanitize_font_family( string $font_family ): string
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$font_family` | `string` | Font family name(s), comma-separated |

**Returns:** Sanitized and formatted font family string.

**Processing:**

1. Applies `sanitize_text_field()`
2. Splits comma-separated values
3. Adds quotes to names with special characters
4. Rejoins with proper formatting

**Examples:**

```php
WP_Font_Utils::sanitize_font_family( 'Inter' );
// 'Inter'

WP_Font_Utils::sanitize_font_family( 'Open Sans' );
// '"Open Sans"'

WP_Font_Utils::sanitize_font_family( 'Inter, sans-serif' );
// 'Inter, sans-serif'

WP_Font_Utils::sanitize_font_family( 'Open Sans, Arial, sans-serif' );
// '"Open Sans", Arial, sans-serif'
```

**Quoting Rules (CSS Fonts Module Level 4):**

- Generic families (serif, sans-serif, etc.) are not quoted
- Names with spaces or special characters are quoted
- `generic(family-name)` syntax is not quoted

---

### get_font_face_slug()

Generates a unique slug from font face properties.

```php
public static function get_font_face_slug( array $settings ): string
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$settings` | `array` | Font face settings |

**Settings:**

| Key | Default | Description |
|-----|---------|-------------|
| `fontFamily` | `''` | Font family name |
| `fontStyle` | `'normal'` | Font style |
| `fontWeight` | `'400'` | Font weight |
| `fontStretch` | `'100%'` | Font stretch |
| `unicodeRange` | `'U+0-10FFFF'` | Unicode range |

**Returns:** Slug in format `family;style;weight;stretch;range`

**Example:**

```php
WP_Font_Utils::get_font_face_slug([
    'fontFamily'  => 'Inter',
    'fontWeight'  => '700',
    'fontStyle'   => 'italic',
]);
// 'inter;italic;700;100%;U+0-10FFFF'
```

**Purpose:**

Used to detect duplicate font faces that would match the same CSS font matching criteria.

---

### sanitize_from_schema()

Sanitizes a data tree using a schema.

```php
public static function sanitize_from_schema( array $tree, array $schema ): array
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$tree` | `array` | Data to sanitize |
| `$schema` | `array` | Sanitization schema |

**Returns:** Sanitized data with unknown keys removed.

**Schema Structure:**

```php
$schema = [
    'name' => 'sanitize_text_field',
    'url'  => 'sanitize_url',
    'items' => [
        [
            'title' => 'sanitize_text_field',
            'count' => 'absint',
        ],
    ],
    'custom' => function( $value ) {
        return custom_sanitizer( $value );
    },
];
```

**Rules:**

- Each schema value is a callable (function name or closure)
- Nested arrays are traversed recursively
- Indexed arrays apply schema[0] to each item
- Keys not in schema are removed
- Empty values are removed

**Example:**

```php
$data = [
    'name'    => '<script>alert("xss")</script>Name',
    'url'     => 'https://example.com',
    'unknown' => 'will be removed',
];

$schema = [
    'name' => 'sanitize_text_field',
    'url'  => 'sanitize_url',
];

$result = WP_Font_Utils::sanitize_from_schema( $data, $schema );
// [
//     'name' => 'Name',
//     'url'  => 'https://example.com',
// ]
```

---

### get_allowed_font_mime_types()

Returns allowed MIME types for font files.

```php
public static function get_allowed_font_mime_types(): array
```

**Returns:** Array of MIME types keyed by extension.

**PHP Version Variations:**

MIME types vary by PHP version due to changes in `finfo_file()` detection.

| Extension | PHP < 7.3 | PHP 7.3-7.4 | PHP 8.1.12+ |
|-----------|-----------|-------------|-------------|
| `otf` | `application/vnd.ms-opentype` | `application/vnd.ms-opentype` | `application/vnd.ms-opentype` |
| `ttf` | `application/x-font-ttf` | `application/font-sfnt` | `font/sfnt` |
| `woff` | `application/font-woff` | `application/font-woff` | `font/woff` |
| `woff2` | `application/font-woff2` | `application/font-woff2` | `font/woff2` |

**Example:**

```php
$mime_types = WP_Font_Utils::get_allowed_font_mime_types();
// [
//     'otf'   => 'application/vnd.ms-opentype',
//     'ttf'   => 'font/sfnt',
//     'woff'  => 'font/woff',
//     'woff2' => 'font/woff2',
// ]
```

---

## Private Methods

### maybe_add_quotes()

Adds quotes to font family names with special characters.

```php
private static function maybe_add_quotes( string $item ): string
```

**Rules:**

- Names with only letters/hyphens: no quotes
- Names matching `generic(...)` syntax: no quotes
- All other names: wrapped in double quotes

---

### apply_sanitizer()

Applies a sanitizer function to a value.

```php
private static function apply_sanitizer( mixed $value, callable $sanitizer ): mixed
```

## Usage

```php
// Sanitize font family for CSS output
$family = WP_Font_Utils::sanitize_font_family( 'Open Sans, Arial' );

// Generate slug for deduplication
$slug = WP_Font_Utils::get_font_face_slug( $font_face_settings );

// Schema-based sanitization
$clean = WP_Font_Utils::sanitize_from_schema( $data, $schema );

// Get allowed MIME types for uploads
$types = WP_Font_Utils::get_allowed_font_mime_types();
```
