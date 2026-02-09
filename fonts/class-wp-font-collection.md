# WP_Font_Collection

Represents a collection of fonts that can be installed from the Font Library.

**Since:** 6.5.0  
**Source:** `wp-includes/fonts/class-wp-font-collection.php`

## Description

A font collection is a group of font families that users can browse and install through the WordPress Font Library UI. Collections can define fonts inline or reference an external JSON file/URL.

## Properties

### $slug

```php
public string $slug;
```

The unique slug for the collection.

### $data

```php
private array|WP_Error|null $data;
```

Font collection data (lazy-loaded for JSON sources).

### $src

```php
private ?string $src;
```

JSON file path or URL for font families (if not inline).

## Methods

### __construct()

Creates a new font collection.

```php
public function __construct( string $slug, array $args )
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug |
| `$args` | `array` | Collection data |

**Args:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `name` | `string` | Yes | Display name |
| `description` | `string` | No | Short description |
| `font_families` | `array\|string` | Yes | Fonts or JSON path/URL |
| `categories` | `array` | No | Categories with name/slug |

**Slug Validation:**

Slugs are sanitized via `sanitize_title()`. Invalid characters trigger `_doing_it_wrong()`.

---

### get_data()

Retrieves the font collection data.

```php
public function get_data(): array|WP_Error
```

**Returns:**

```php
[
    'name'          => 'Collection Name',
    'description'   => 'Optional description',
    'font_families' => [...],
    'categories'    => [...],
]
```

Or `WP_Error` on failure.

**Lazy Loading:**

If `font_families` was a URL/path, data is fetched on first call.

---

## Private Methods

### load_from_json()

Loads font collection data from a JSON file or URL.

```php
private function load_from_json( string $file_or_url ): array|WP_Error
```

Determines if source is URL or file path, then delegates to appropriate loader.

---

### load_from_file()

Loads from a local JSON file.

```php
private function load_from_file( string $file ): array|WP_Error
```

Uses `wp_json_file_decode()`.

---

### load_from_url()

Loads from a remote JSON URL.

```php
private function load_from_url( string $url ): array|WP_Error
```

**Features:**

- Caches in site transient for 1 day
- Uses `wp_safe_remote_get()`
- Validates and sanitizes before caching

---

### sanitize_and_validate_data()

Sanitizes and validates collection data.

```php
private function sanitize_and_validate_data( 
    array $data, 
    array $required_properties = [] 
): array|WP_Error
```

Uses schema-based sanitization via `WP_Font_Utils::sanitize_from_schema()`.

---

### get_sanitization_schema()

Returns the sanitization schema for collection data.

```php
private static function get_sanitization_schema(): array
```

## Data Structure

### Collection Data

```php
[
    'name'          => 'string',           // Required
    'description'   => 'string',           // Optional
    'font_families' => [...],              // Required (or JSON source)
    'categories'    => [                   // Optional
        ['name' => 'Sans Serif', 'slug' => 'sans-serif'],
    ],
]
```

### Font Family Structure

```php
[
    'font_family_settings' => [
        'name'       => 'Inter',
        'slug'       => 'inter',
        'fontFamily' => 'Inter, sans-serif',
        'preview'    => 'https://example.com/preview.png',
        'fontFace'   => [
            [
                'fontFamily'  => 'Inter',
                'fontWeight'  => '400',
                'fontStyle'   => 'normal',
                'src'         => 'https://example.com/inter.woff2',
                'preview'     => 'https://example.com/inter-preview.png',
                'fontDisplay' => 'swap',
            ],
        ],
    ],
    'categories' => ['sans-serif'],
]
```

## Example

```php
// Create collection with inline fonts
$collection = new WP_Font_Collection( 'my-fonts', [
    'name'          => 'My Fonts',
    'description'   => 'Custom font collection',
    'font_families' => [
        [
            'font_family_settings' => [
                'name'       => 'Custom Sans',
                'slug'       => 'custom-sans',
                'fontFamily' => 'Custom Sans, sans-serif',
                'fontFace'   => [
                    [
                        'fontFamily' => 'Custom Sans',
                        'fontWeight' => '400',
                        'fontStyle'  => 'normal',
                        'src'        => 'https://example.com/custom-sans.woff2',
                    ],
                ],
            ],
            'categories' => ['sans-serif'],
        ],
    ],
    'categories' => [
        ['name' => 'Sans Serif', 'slug' => 'sans-serif'],
    ],
]);

// Create collection from JSON URL
$collection = new WP_Font_Collection( 'remote-fonts', [
    'name'          => 'Remote Fonts',
    'font_families' => 'https://example.com/fonts.json',
]);

// Get data (triggers lazy load for JSON sources)
$data = $collection->get_data();
if ( is_wp_error( $data ) ) {
    // Handle error
}
```

## JSON Schema

Collections must conform to the WordPress font collection schema:

https://schemas.wp.org/trunk/font-collection.json
