# Fonts API Functions

## Font Face Output

### wp_print_font_faces()

Generates and prints `@font-face` styles for given fonts or theme.json fonts.

```php
wp_print_font_faces( array $fonts = array() ): void
```

**Since:** 6.4.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$fonts` | `array[][]` | Font families with their font faces. Empty = use theme.json fonts. |

**Font Face Structure:**

```php
$fonts = [
    'Inter' => [
        [
            'font-family'  => 'Inter',
            'src'          => 'https://example.com/fonts/inter.woff2',
            'font-style'   => 'normal',    // default: 'normal'
            'font-weight'  => '400',       // default: '400'
            'font-display' => 'fallback',  // default: 'fallback'
        ],
    ],
];
```

**Optional Font Face Properties:**

- `ascent-override`
- `descent-override`
- `font-stretch`
- `font-variant`
- `font-feature-settings`
- `font-variation-settings`
- `line-gap-override`
- `size-adjust`
- `unicode-range`

**Example:**

```php
// Print theme.json fonts (automatic)
wp_print_font_faces();

// Print custom fonts
wp_print_font_faces([
    'Custom Font' => [
        [
            'font-family' => 'Custom Font',
            'src'         => get_template_directory_uri() . '/fonts/custom.woff2',
            'font-weight' => '400',
        ],
        [
            'font-family' => 'Custom Font',
            'src'         => get_template_directory_uri() . '/fonts/custom-bold.woff2',
            'font-weight' => '700',
        ],
    ],
]);
```

**Output:**

```html
<style class='wp-fonts-local'>
@font-face{font-family:"Custom Font";src:url('...') format('woff2');font-style:normal;font-weight:400;font-display:fallback;}
@font-face{font-family:"Custom Font";src:url('...') format('woff2');font-style:normal;font-weight:700;font-display:fallback;}
</style>
```

---

### wp_print_font_faces_from_style_variations()

Prints font-face styles from theme style variations.

```php
wp_print_font_faces_from_style_variations(): void
```

**Since:** 6.7.0

**Description:**

Style variations (in `styles/` directory) can define additional fonts. This function outputs `@font-face` rules for fonts in those variations.

---

## Font Collections

### wp_register_font_collection()

Registers a new font collection in the Font Library.

```php
wp_register_font_collection( string $slug, array $args ): WP_Font_Collection|WP_Error
```

**Since:** 6.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug (alphanumeric, dashes, underscores) |
| `$args` | `array` | Collection data |

**Args:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `name` | `string` | Yes | Display name |
| `description` | `string` | No | Short description |
| `font_families` | `array\|string` | Yes | Font definitions or URL/path to JSON |
| `categories` | `array` | No | Categories with name and slug |

**Returns:** `WP_Font_Collection` on success, `WP_Error` on failure.

**Example - Inline Fonts:**

```php
wp_register_font_collection( 'my-fonts', [
    'name'          => 'My Font Collection',
    'description'   => 'Custom fonts for my site.',
    'font_families' => [
        [
            'font_family_settings' => [
                'name'       => 'My Font',
                'slug'       => 'my-font',
                'fontFamily' => 'My Font, sans-serif',
                'fontFace'   => [
                    [
                        'fontFamily' => 'My Font',
                        'fontWeight' => '400',
                        'fontStyle'  => 'normal',
                        'src'        => 'https://example.com/fonts/my-font.woff2',
                    ],
                ],
            ],
        ],
    ],
    'categories' => [
        [ 'name' => 'Sans Serif', 'slug' => 'sans-serif' ],
    ],
]);
```

**Example - JSON URL:**

```php
wp_register_font_collection( 'external-fonts', [
    'name'          => 'External Fonts',
    'font_families' => 'https://example.com/fonts/collection.json',
]);
```

**JSON Schema:** https://schemas.wp.org/trunk/font-collection.json

---

### wp_unregister_font_collection()

Unregisters a font collection from the Font Library.

```php
wp_unregister_font_collection( string $slug ): bool
```

**Since:** 6.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug |

**Returns:** `true` if unregistered, `false` if not found.

**Example:**

```php
// Remove Google Fonts collection
wp_unregister_font_collection( 'google-fonts' );
```

---

## Font Directory

### wp_get_font_dir()

Retrieves font uploads directory information (lightweight, doesn't create directory).

```php
wp_get_font_dir(): array
```

**Since:** 6.5.0

**Returns:**

```php
[
    'path'    => '/var/www/html/wp-content/uploads/fonts',
    'url'     => 'https://example.com/wp-content/uploads/fonts',
    'subdir'  => '',
    'basedir' => '/var/www/html/wp-content/uploads/fonts',
    'baseurl' => 'https://example.com/wp-content/uploads/fonts',
    'error'   => false,
]
```

**Example:**

```php
$font_dir = wp_get_font_dir();
$font_url = $font_dir['baseurl'] . '/my-font.woff2';
```

---

### wp_font_dir()

Returns font upload directory, optionally creating it.

```php
wp_font_dir( bool $create_dir = true ): array
```

**Since:** 6.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$create_dir` | `bool` | Whether to create the directory. Default `true`. |

**Returns:** Same structure as `wp_get_font_dir()`.

**Note:** Use `wp_get_font_dir()` when you only need path/URL info.

---

## Internal Functions

### _wp_filter_font_directory()

*Internal use only.* Callback for `upload_dir` filter to redirect to fonts directory.

```php
_wp_filter_font_directory( array $font_dir ): array
```

**Since:** 6.5.0

---

### _wp_after_delete_font_family()

*Internal use only.* Deletes child font faces when a font family is deleted.

```php
_wp_after_delete_font_family( int $post_id, WP_Post $post ): void
```

**Since:** 6.5.0

Hooked to `after_delete_post`.

---

### _wp_before_delete_font_face()

*Internal use only.* Deletes font files when a font face is deleted.

```php
_wp_before_delete_font_face( int $post_id, WP_Post $post ): void
```

**Since:** 6.5.0

Hooked to `before_delete_post`.

---

### _wp_register_default_font_collections()

*Internal use only.* Registers the default Google Fonts collection.

```php
_wp_register_default_font_collections(): void
```

**Since:** 6.5.0
