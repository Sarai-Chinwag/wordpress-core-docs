# WP_Style_Engine

Core class for parsing block styles and compiling CSS. This is a low-level internal API.

**Source:** `wp-includes/style-engine/class-wp-style-engine.php`  
**Since:** 6.1.0  
**Access:** Private (use `wp_style_engine_get_styles()` instead)

> **Note:** This class is final and should not be extended. It is for internal Core usage and may have breaking changes. Use the public functions in `style-engine.php` instead.

## Constants

### BLOCK_STYLE_DEFINITIONS_METADATA

Style definitions containing instructions for parsing and outputting valid Gutenberg styles from block attributes.

```php
const BLOCK_STYLE_DEFINITIONS_METADATA = array(
    'background' => array( /* ... */ ),
    'color'      => array( /* ... */ ),
    'border'     => array( /* ... */ ),
    'shadow'     => array( /* ... */ ),
    'dimensions' => array( /* ... */ ),
    'spacing'    => array( /* ... */ ),
    'typography' => array( /* ... */ ),
);
```

#### Definition Structure

| Key | Type | Description |
|-----|------|-------------|
| `classnames` | array | Classnames to return; key is pattern, value is `true` or property key for slug substitution |
| `css_vars` | array | CSS var patterns for preset conversion (e.g., `--wp--preset--color--$slug`) |
| `property_keys` | array | CSS properties (`default` and optionally `individual` for box-model styles) |
| `path` | array | Path to style value in block style object |
| `value_func` | callable | Custom function to generate CSS declarations |

---

## Methods

### parse_block_styles()

Returns classnames and CSS based on values in a styles object.

```php
public static function parse_block_styles( array $block_styles, array $options ): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$block_styles` | array | The style object |
| `$options` | array | Configuration options |

#### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `convert_vars_to_classnames` | bool | `false` | Skip converting `var:preset\|*` to CSS vars |
| `selector` | string | — | CSS selector (not used in parsing, passed through) |

#### Returns

| Key | Type | Description |
|-----|------|-------------|
| `classnames` | array | Array of CSS class names |
| `declarations` | array | Associative array of CSS property => value |

---

### compile_css()

Returns compiled CSS from CSS declarations.

```php
public static function compile_css( array $css_declarations, string $css_selector ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_declarations` | array | Associative array of CSS definitions |
| `$css_selector` | string | CSS selector; if empty, returns declarations only |

#### Returns

Compiled CSS string. If selector is provided, returns full rule: `$selector { declarations }`. Otherwise, returns concatenated declarations.

---

### compile_stylesheet_from_css_rules()

Returns compiled stylesheet from CSS rule objects.

```php
public static function compile_stylesheet_from_css_rules( 
    WP_Style_Engine_CSS_Rule[] $css_rules, 
    array $options = array() 
): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_rules` | array | Array of `WP_Style_Engine_CSS_Rule` objects |
| `$options` | array | Configuration options |

#### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `context` | string\|null | — | Store name |
| `optimize` | bool | `false` | Combine rules with identical declarations |
| `prettify` | bool | `SCRIPT_DEBUG` | Add formatting |

#### Returns

Compiled CSS string.

---

### store_css_rule()

Stores a CSS rule in a named store for later retrieval.

```php
public static function store_css_rule( 
    string $store_name, 
    string $css_selector, 
    array $css_declarations, 
    string $rules_group = '' 
): void
```

**Since:** 6.1.0  
**Since:** 6.6.0 Added `$rules_group` parameter

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$store_name` | string | Store key (e.g., `block-supports`) |
| `$css_selector` | string | CSS selector |
| `$css_declarations` | array | CSS property => value pairs |
| `$rules_group` | string | Parent selector or @rule (e.g., `@media (min-width: 80rem)`) |

---

### get_store()

Returns a store by its name.

```php
public static function get_store( string $store_name ): ?WP_Style_Engine_CSS_Rules_Store
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$store_name` | string | Store key |

#### Returns

`WP_Style_Engine_CSS_Rules_Store` instance, or `null` if invalid.

---

## Protected Methods

### get_slug_from_preset_value()

Extracts the slug in kebab-case from a preset string.

```php
protected static function get_slug_from_preset_value( string $style_value, string $property_key ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$style_value` | string | CSS preset value (e.g., `var:preset\|color\|heavenlyBlue`) |
| `$property_key` | string | Property key to match (e.g., `color`) |

#### Returns

Slug in kebab-case (e.g., `heavenly-blue`), or empty string if not found.

---

### get_css_var_value()

Generates a CSS var string from a preset string.

```php
protected static function get_css_var_value( string $style_value, array $css_vars ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$style_value` | string | Preset value (e.g., `var:preset\|color\|someSlug`) |
| `$css_vars` | array | CSS var patterns (e.g., `array( 'color' => '--wp--preset--color--$slug' )`) |

#### Returns

CSS var (e.g., `var(--wp--preset--color--some-slug)`), or empty string.

---

### is_valid_style_value()

Checks whether a style value is valid.

```php
protected static function is_valid_style_value( mixed $style_value ): bool
```

#### Returns

`true` if value is `'0'` or non-empty; `false` otherwise.

---

### get_classnames()

Returns classnames from a style value and definition.

```php
protected static function get_classnames( string $style_value, array $style_definition ): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$style_value` | string | Raw style value or preset |
| `$style_definition` | array | Style definition from `BLOCK_STYLE_DEFINITIONS_METADATA` |

#### Returns

Array of CSS class names.

---

### get_css_declarations()

Returns CSS declarations from a style value.

```php
protected static function get_css_declarations( 
    mixed $style_value, 
    array $style_definition, 
    array $options = array() 
): array
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$style_value` | mixed | Raw style value |
| `$style_definition` | array | Style definition |
| `$options` | array | Options including `convert_vars_to_classnames` |

#### Returns

Associative array of CSS declarations.

---

### get_individual_property_css_declarations()

Parser for individual property declarations (e.g., `border-top-color`).

```php
protected static function get_individual_property_css_declarations( 
    array $style_value, 
    array $individual_property_definition, 
    array $options = array() 
): array
```

Handles styles like:
- `border-{top|right|bottom|left}-{color|width|style}`
- `border-image-{outset|source|width|repeat|slice}`

---

### get_url_or_value_css_declaration()

Parser for URL-based style values (e.g., `background-image`).

```php
protected static function get_url_or_value_css_declaration( 
    mixed $style_value, 
    array $style_definition 
): array
```

**Since:** 6.4.0

#### Returns

If value contains `url` key, returns `array( 'background-image' => "url('...')" )`.
