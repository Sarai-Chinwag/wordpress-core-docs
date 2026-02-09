# WP_Style_Engine_CSS_Rule

Represents a CSS rule with selector, declarations, and optional rules group (for nested CSS).

**Source:** `wp-includes/style-engine/class-wp-style-engine-css-rule.php`  
**Since:** 6.1.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$selector` | string | protected | CSS selector |
| `$declarations` | WP_Style_Engine_CSS_Declarations | protected | Declarations object |
| `$rules_group` | string | protected | Parent selector or @rule (since 6.6.0) |

---

## Methods

### __construct()

Creates a new CSS rule.

```php
public function __construct( 
    string $selector = '', 
    array|WP_Style_Engine_CSS_Declarations $declarations = array(), 
    string $rules_group = '' 
)
```

**Since:** 6.1.0  
**Since:** 6.6.0 Added `$rules_group` parameter

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$selector` | string | CSS selector |
| `$declarations` | array\|WP_Style_Engine_CSS_Declarations | CSS definitions or declarations object |
| `$rules_group` | string | Parent CSS selector or nested @rule |

#### Example

```php
// Simple rule
$rule = new WP_Style_Engine_CSS_Rule( '.my-class', array(
    'color' => 'red',
) );

// With rules group (media query)
$rule = new WP_Style_Engine_CSS_Rule(
    '.responsive',
    array( 'font-size' => '2rem' ),
    '@media (min-width: 80rem)'
);
```

---

### set_selector()

Sets the CSS selector.

```php
public function set_selector( string $selector ): WP_Style_Engine_CSS_Rule
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$selector` | string | CSS selector |

#### Returns

`$this` for method chaining.

---

### get_selector()

Gets the full selector.

```php
public function get_selector(): string
```

#### Returns

The CSS selector string.

---

### add_declarations()

Adds declarations to the rule.

```php
public function add_declarations( 
    array|WP_Style_Engine_CSS_Declarations $declarations 
): WP_Style_Engine_CSS_Rule
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$declarations` | array\|WP_Style_Engine_CSS_Declarations | CSS definitions or declarations object |

#### Returns

`$this` for method chaining.

If the rule has no declarations yet and a `WP_Style_Engine_CSS_Declarations` object is passed, it is used directly. Otherwise, declarations are merged into the existing object.

---

### get_declarations()

Gets the declarations object.

```php
public function get_declarations(): WP_Style_Engine_CSS_Declarations
```

#### Returns

The `WP_Style_Engine_CSS_Declarations` instance.

---

### set_rules_group()

Sets the rules group.

```php
public function set_rules_group( string $rules_group ): WP_Style_Engine_CSS_Rule
```

**Since:** 6.6.0

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rules_group` | string | Parent selector or @rule (e.g., `@media (min-width: 80rem)`, `@layer module`) |

#### Returns

`$this` for method chaining.

---

### get_rules_group()

Gets the rules group.

```php
public function get_rules_group(): string
```

**Since:** 6.6.0

#### Returns

The rules group string.

---

### get_css()

Compiles the rule to a CSS string.

```php
public function get_css( bool $should_prettify = false, int $indent_count = 0 ): string
```

**Since:** 6.1.0  
**Since:** 6.6.0 Added support for nested CSS with rules groups

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$should_prettify` | bool | `false` | Add spacing, newlines, and indents |
| `$indent_count` | int | `0` | Number of tab indents |

#### Returns

Compiled CSS string, or empty string if no declarations.

#### Examples

**Simple rule:**

```php
$rule = new WP_Style_Engine_CSS_Rule( '.my-class', array(
    'color'      => 'red',
    'font-size'  => '16px',
) );

echo $rule->get_css();
// Output: '.my-class{color:red;font-size:16px}'

echo $rule->get_css( true );
// Output:
// .my-class {
// 	color: red;
// 	font-size: 16px;
// }
```

**With rules group (media query):**

```php
$rule = new WP_Style_Engine_CSS_Rule(
    '.responsive',
    array( 'font-size' => '2rem' ),
    '@media (min-width: 80rem)'
);

echo $rule->get_css();
// Output: '@media (min-width: 80rem){.responsive{font-size:2rem}}'

echo $rule->get_css( true );
// Output:
// @media (min-width: 80rem) {
// 	.responsive {
// 		font-size: 2rem;
// 	}
// }
```

**Multiple selectors (prettified):**

```php
$rule = new WP_Style_Engine_CSS_Rule( '.a, .b, .c', array(
    'color' => 'blue',
) );

echo $rule->get_css( true );
// Output:
// .a,
// .b,
// .c {
// 	color: blue;
// }
```
