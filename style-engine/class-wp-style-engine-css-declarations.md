# WP_Style_Engine_CSS_Declarations

Holds, sanitizes, processes, and prints CSS declarations for the style engine.

**Source:** `wp-includes/style-engine/class-wp-style-engine-css-declarations.php`  
**Since:** 6.1.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$declarations` | array | protected | CSS declarations as property => value pairs |

---

## Methods

### __construct()

Creates a new declarations collection.

```php
public function __construct( array $declarations = array() )
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$declarations` | array | Initial CSS definitions (property => value pairs) |

#### Example

```php
$declarations = new WP_Style_Engine_CSS_Declarations( array(
    'color'            => '#fff',
    'background-color' => '#000',
) );
```

---

### add_declaration()

Adds a single CSS declaration.

```php
public function add_declaration( string $property, string $value ): WP_Style_Engine_CSS_Declarations
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$property` | string | CSS property (sanitized via `sanitize_key()`) |
| `$value` | string | CSS value (trimmed; empty values ignored) |

#### Returns

`$this` for method chaining.

#### Example

```php
$declarations
    ->add_declaration( 'color', 'red' )
    ->add_declaration( 'font-size', '16px' );
```

---

### remove_declaration()

Removes a single declaration.

```php
public function remove_declaration( string $property ): WP_Style_Engine_CSS_Declarations
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$property` | string | CSS property to remove |

#### Returns

`$this` for method chaining.

---

### add_declarations()

Adds multiple declarations.

```php
public function add_declarations( array $declarations ): WP_Style_Engine_CSS_Declarations
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$declarations` | array | CSS definitions (property => value pairs) |

#### Returns

`$this` for method chaining.

---

### remove_declarations()

Removes multiple declarations.

```php
public function remove_declarations( array $properties = array() ): WP_Style_Engine_CSS_Declarations
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$properties` | array | Array of property names to remove |

#### Returns

`$this` for method chaining.

---

### get_declarations()

Gets the declarations array.

```php
public function get_declarations(): array
```

#### Returns

Associative array of CSS property => value pairs.

---

### get_declarations_string()

Filters and compiles the CSS declarations into a string.

```php
public function get_declarations_string( bool $should_prettify = false, int $indent_count = 0 ): string
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$should_prettify` | bool | `false` | Add spacing, newlines, and indents |
| `$indent_count` | int | `0` | Number of tab indents (applies if prettify is true) |

#### Returns

Compiled CSS declarations string.

#### Example

```php
$declarations = new WP_Style_Engine_CSS_Declarations( array(
    'color'      => 'red',
    'font-size'  => '16px',
) );

echo $declarations->get_declarations_string();
// Output: 'color:red;font-size:16px;'

echo $declarations->get_declarations_string( true, 1 );
// Output (prettified with 1 indent):
// 	color: red;
// 	font-size: 16px;
```

---

## Protected Methods

### filter_declaration()

Filters a CSS property + value pair for safety.

```php
protected static function filter_declaration( 
    string $property, 
    string $value, 
    string $spacer = '' 
): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$property` | string | CSS property |
| `$value` | string | CSS value |
| `$spacer` | string | Spacer between colon and value (for prettify) |

#### Returns

Filtered declaration string, or empty string if invalid.

Uses `wp_strip_all_tags()` and `safecss_filter_attr()` for sanitization.

---

### sanitize_property()

Sanitizes property names.

```php
protected function sanitize_property( string $property ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$property` | string | CSS property |

#### Returns

Sanitized property name via `sanitize_key()`.
