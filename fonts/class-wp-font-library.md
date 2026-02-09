# WP_Font_Library

Singleton registry for font collections.

**Since:** 6.5.0  
**Source:** `wp-includes/fonts/class-wp-font-library.php`

## Description

The Font Library manages the registration and retrieval of font collections. It follows the singleton pattern to ensure a single global registry.

## Properties

### $collections

```php
private array $collections = [];
```

Registered font collections, keyed by slug.

### $instance

```php
private static ?WP_Font_Library $instance = null;
```

Singleton instance.

## Methods

### get_instance()

Retrieves the main instance of the class.

```php
public static function get_instance(): WP_Font_Library
```

**Returns:** The singleton instance.

**Example:**

```php
$library = WP_Font_Library::get_instance();
$collections = $library->get_font_collections();
```

---

### register_font_collection()

Registers a new font collection.

```php
public function register_font_collection( string $slug, array $args ): WP_Font_Collection|WP_Error
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug (alphanumeric, dashes, underscores) |
| `$args` | `array` | Collection data (see `wp_register_font_collection()`) |

**Returns:**

- `WP_Font_Collection` on success
- `WP_Error` if slug already registered

**Example:**

```php
$library = WP_Font_Library::get_instance();
$collection = $library->register_font_collection( 'my-fonts', [
    'name'          => 'My Fonts',
    'font_families' => [...],
]);
```

---

### unregister_font_collection()

Unregisters a font collection.

```php
public function unregister_font_collection( string $slug ): bool
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug |

**Returns:** `true` if unregistered, `false` if not found.

**Example:**

```php
$library = WP_Font_Library::get_instance();
$library->unregister_font_collection( 'google-fonts' );
```

---

### get_font_collections()

Gets all registered font collections.

```php
public function get_font_collections(): array
```

**Returns:** Array of `WP_Font_Collection` objects keyed by slug.

**Example:**

```php
$library = WP_Font_Library::get_instance();
$collections = $library->get_font_collections();

foreach ( $collections as $slug => $collection ) {
    $data = $collection->get_data();
    echo $data['name'];
}
```

---

### get_font_collection()

Gets a specific font collection.

```php
public function get_font_collection( string $slug ): ?WP_Font_Collection
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | `string` | Collection slug |

**Returns:** `WP_Font_Collection` or `null` if not found.

**Example:**

```php
$library = WP_Font_Library::get_instance();
$google = $library->get_font_collection( 'google-fonts' );

if ( $google ) {
    $data = $google->get_data();
    // Access $data['font_families']
}
```

---

## Private Methods

### is_collection_registered()

Checks if a collection slug is already registered.

```php
private function is_collection_registered( string $slug ): bool
```

## Usage

Typically accessed via wrapper functions:

```php
// Register
wp_register_font_collection( 'my-fonts', [...] );

// Unregister  
wp_unregister_font_collection( 'my-fonts' );

// Direct access
$library = WP_Font_Library::get_instance();
$all = $library->get_font_collections();
$one = $library->get_font_collection( 'google-fonts' );
```

## Default Registration

WordPress registers Google Fonts by default via `_wp_register_default_font_collections()`:

```php
wp_register_font_collection( 'google-fonts', [
    'name'          => 'Google Fonts',
    'description'   => 'Install from Google Fonts. Fonts are copied to and served from your site.',
    'font_families' => 'https://s.w.org/images/fonts/wp-6.9/collections/google-fonts-with-preview.json',
    'categories'    => [
        [ 'name' => 'Sans Serif', 'slug' => 'sans-serif' ],
        [ 'name' => 'Display', 'slug' => 'display' ],
        [ 'name' => 'Serif', 'slug' => 'serif' ],
        [ 'name' => 'Handwriting', 'slug' => 'handwriting' ],
        [ 'name' => 'Monospace', 'slug' => 'monospace' ],
    ],
]);
```
