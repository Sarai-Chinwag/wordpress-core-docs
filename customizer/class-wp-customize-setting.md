# WP_Customize_Setting

Handles saving and sanitizing of Customizer settings. Settings are the data layer of the Customizer, responsible for storing values, applying sanitization/validation, and managing the live preview.

**File:** `wp-includes/class-wp-customize-setting.php`  
**Since:** WordPress 3.4.0

## Class Synopsis

```php
#[AllowDynamicProperties]
class WP_Customize_Setting {
    public $manager;                         // WP_Customize_Manager instance
    public $id;                              // Unique identifier
    public $type = 'theme_mod';              // Storage type
    public $capability = 'edit_theme_options'; // Required capability
    public $theme_supports = '';             // Required theme features
    public $default = '';                    // Default value
    public $transport = 'refresh';           // Preview transport method
    public $validate_callback = '';          // Validation callback
    public $sanitize_callback = '';          // Sanitization callback
    public $sanitize_js_callback = '';       // JS serialization callback
    public $dirty = false;                   // Initially dirty flag
    
    protected $id_data = array();            // Parsed ID data
    protected $is_previewed = false;         // Preview status
}
```

## Constructor

```php
public function __construct( 
    WP_Customize_Manager $manager, 
    string $id, 
    array $args = array() 
)
```

### Arguments

| Argument | Type | Default | Description |
|----------|------|---------|-------------|
| `type` | `string` | `'theme_mod'` | Storage type: `theme_mod`, `option`, or custom |
| `capability` | `string` | `'edit_theme_options'` | Required capability |
| `theme_supports` | `string\|array` | `''` | Required theme support features |
| `default` | `mixed` | `''` | Default value |
| `transport` | `string` | `'refresh'` | Preview method: `refresh` or `postMessage` |
| `validate_callback` | `callable` | `''` | Server-side validation callback |
| `sanitize_callback` | `callable` | `''` | Sanitization callback |
| `sanitize_js_callback` | `callable` | `''` | JS value conversion callback |
| `dirty` | `bool` | `false` | Whether initially dirty |

## Setting Types

### theme_mod

Theme modifications stored per-theme:

```php
$wp_customize->add_setting( 'header_color', array(
    'type'    => 'theme_mod',
    'default' => '#ffffff',
) );
```

Stored in: `theme_mods_{$stylesheet}` option

### option

WordPress options stored globally:

```php
$wp_customize->add_setting( 'blogname', array(
    'type' => 'option',
) );
```

Stored in: `wp_options` table

### Multidimensional Settings

Settings can reference nested array values:

```php
// Access $options['colors']['primary']
$wp_customize->add_setting( 'my_options[colors][primary]', array(
    'type' => 'option',
) );
```

The ID format `base[key1][key2]` is parsed into:
- `id_data['base']` = `'my_options'`
- `id_data['keys']` = `['colors', 'primary']`

## Transport Methods

### refresh

Reloads the entire preview iframe when the setting changes:

```php
$wp_customize->add_setting( 'my_setting', array(
    'transport' => 'refresh',
) );
```

### postMessage

Uses JavaScript to update preview without page reload:

```php
$wp_customize->add_setting( 'my_setting', array(
    'transport' => 'postMessage',
) );
```

Requires corresponding JavaScript:

```javascript
wp.customize( 'my_setting', function( setting ) {
    setting.bind( function( value ) {
        $( '.my-element' ).css( 'color', value );
    } );
} );
```

## Core Methods

### value()

Fetches the current setting value.

```php
public function value(): mixed
```

Returns value from:
1. POST value if previewing
2. Stored value (theme_mod or option)
3. Default value as fallback

### preview()

Adds filters to supply the setting's preview value.

```php
public function preview(): bool
```

Returns `false` if preview short-circuits (no change to preview).

### save()

Checks capabilities and saves the value.

```php
final public function save(): void|false
```

Returns `false` if capability check fails or value isn't set.

### post_value()

Fetches the sanitized value from POST/changeset.

```php
final public function post_value( $default = null ): mixed
```

### sanitize()

Sanitizes an input value.

```php
public function sanitize( $value ): mixed|null|WP_Error
```

### validate()

Validates an input value.

```php
public function validate( $value ): true|WP_Error
```

Returns `true` on success, `WP_Error` on failure.

### js_value()

Gets value sanitized for JavaScript export.

```php
public function js_value(): mixed
```

### json()

Retrieves data for JSON export.

```php
public function json(): array
```

Returns:
```php
array(
    'value'     => $this->js_value(),
    'transport' => $this->transport,
    'dirty'     => $this->dirty,
    'type'      => $this->type,
)
```

### check_capabilities()

Validates user capabilities and theme support.

```php
final public function check_capabilities(): bool
```

### id_data()

Gets parsed ID data for multidimensional settings.

```php
final public function id_data(): array
```

Returns:
```php
array(
    'base' => 'setting_base',
    'keys' => array( 'key1', 'key2' ),
)
```

## Sanitization

Settings should always have a sanitization callback:

```php
$wp_customize->add_setting( 'my_email', array(
    'sanitize_callback' => 'sanitize_email',
) );

// Custom callback
$wp_customize->add_setting( 'my_number', array(
    'sanitize_callback' => function( $value ) {
        return absint( $value );
    },
) );
```

### Common Sanitization Functions

| Function | Purpose |
|----------|---------|
| `sanitize_hex_color` | Hex color values |
| `sanitize_email` | Email addresses |
| `sanitize_text_field` | Generic text |
| `sanitize_textarea_field` | Multi-line text |
| `absint` | Positive integers |
| `esc_url_raw` | URLs |
| `wp_kses_post` | HTML with allowed tags |

## Validation (Since 4.6)

Validation runs before sanitization and can provide error messages:

```php
$wp_customize->add_setting( 'my_number', array(
    'validate_callback' => function( $validity, $value ) {
        if ( ! is_numeric( $value ) ) {
            $validity->add( 'not_numeric', 'Value must be a number.' );
        }
        if ( $value < 0 || $value > 100 ) {
            $validity->add( 'out_of_range', 'Value must be between 0 and 100.' );
        }
        return $validity;
    },
) );
```

The callback receives:
- `$validity` - `WP_Error` object to add errors to
- `$value` - The value being validated
- `$setting` - The `WP_Customize_Setting` instance

## JavaScript Callback

Convert PHP values for JavaScript:

```php
$wp_customize->add_setting( 'my_array', array(
    'sanitize_js_callback' => function( $value ) {
        return wp_json_encode( $value );
    },
) );
```

## Multidimensional Methods

### get_root_value()

Gets the root value for multidimensional settings.

```php
protected function get_root_value( $default = null ): mixed
```

### set_root_value()

Sets the root value for multidimensional settings.

```php
protected function set_root_value( $value ): bool
```

### multidimensional_get()

Fetches a specific value from a multidimensional array.

```php
final protected function multidimensional_get( $root, $keys, $default = null ): mixed
```

### multidimensional_replace()

Replaces a specific value in a multidimensional array.

```php
final protected function multidimensional_replace( $root, $keys, $value ): mixed
```

## Aggregated Multidimensionals

For performance, multidimensional settings are aggregated:

```php
protected static $aggregated_multidimensionals = array();
```

This combines multiple settings with the same base into single preview/update operations.

## Specialized Setting Classes

The `customize/` directory contains specialized setting types:

| Class | Purpose |
|-------|---------|
| `WP_Customize_Filter_Setting` | Settings that filter values |
| `WP_Customize_Header_Image_Setting` | Header image handling |
| `WP_Customize_Background_Image_Setting` | Background image handling |
| `WP_Customize_Nav_Menu_Item_Setting` | Menu item settings |
| `WP_Customize_Nav_Menu_Setting` | Menu settings |
| `WP_Customize_Custom_CSS_Setting` | Custom CSS settings |

## Dynamic Settings

Settings can be created dynamically:

```php
add_filter( 'customize_dynamic_setting_args', function( $args, $setting_id ) {
    if ( preg_match( '/^my_dynamic_(.+)$/', $setting_id, $matches ) ) {
        return array(
            'type'              => 'option',
            'sanitize_callback' => 'sanitize_text_field',
        );
    }
    return $args;
}, 10, 2 );

add_filter( 'customize_dynamic_setting_class', function( $class, $setting_id, $args ) {
    // Return custom class if needed
    return $class;
}, 10, 3 );
```

## Complete Example

```php
add_action( 'customize_register', function( $wp_customize ) {
    $wp_customize->add_setting( 'footer_text', array(
        'type'                 => 'theme_mod',
        'capability'           => 'edit_theme_options',
        'default'              => '© 2024 My Site',
        'transport'            => 'postMessage',
        'sanitize_callback'    => 'wp_kses_post',
        'sanitize_js_callback' => 'esc_html',
        'validate_callback'    => function( $validity, $value ) {
            if ( strlen( $value ) > 500 ) {
                $validity->add( 'too_long', 'Footer text must be under 500 characters.' );
            }
            return $validity;
        },
    ) );
} );

// Preview JS
add_action( 'customize_preview_init', function() {
    wp_add_inline_script( 'customize-preview', "
        wp.customize( 'footer_text', function( setting ) {
            setting.bind( function( value ) {
                document.querySelector( '.site-footer' ).innerHTML = value;
            } );
        } );
    " );
} );
```
