# WP_Style_Engine_Processor

Compiles styles from stores or collections of CSS rules into a stylesheet.

**Source:** `wp-includes/style-engine/class-wp-style-engine-processor.php`  
**Since:** 6.1.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$stores` | array | protected | Collection of `WP_Style_Engine_CSS_Rules_Store` objects |
| `$css_rules` | array | protected | Set of `WP_Style_Engine_CSS_Rule` objects to process |

---

## Methods

### add_store()

Adds a store to the processor.

```php
public function add_store( WP_Style_Engine_CSS_Rules_Store $store ): WP_Style_Engine_Processor
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$store` | WP_Style_Engine_CSS_Rules_Store | Store to add |

#### Returns

`$this` for method chaining.

#### Notes

Triggers `_doing_it_wrong()` if `$store` is not a `WP_Style_Engine_CSS_Rules_Store` instance.

#### Example

```php
$processor = new WP_Style_Engine_Processor();
$store = WP_Style_Engine_CSS_Rules_Store::get_store( 'my-context' );
$processor->add_store( $store );
```

---

### add_rules()

Adds rules to be processed.

```php
public function add_rules( 
    WP_Style_Engine_CSS_Rule|WP_Style_Engine_CSS_Rule[] $css_rules 
): WP_Style_Engine_Processor
```

**Since:** 6.1.0  
**Since:** 6.6.0 Added support for rules_group

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$css_rules` | WP_Style_Engine_CSS_Rule\|array | Single rule or array of rules |

#### Returns

`$this` for method chaining.

#### Behavior

- Rules with the same selector are merged (declarations combined)
- Rules with a `rules_group` are keyed by `"$rules_group $selector"` to maintain separation
- Existing rules are updated with new declarations rather than duplicated

#### Example

```php
$processor = new WP_Style_Engine_Processor();

// Add single rule
$processor->add_rules( new WP_Style_Engine_CSS_Rule( '.a', array( 'color' => 'red' ) ) );

// Add multiple rules
$processor->add_rules( array(
    new WP_Style_Engine_CSS_Rule( '.b', array( 'color' => 'blue' ) ),
    new WP_Style_Engine_CSS_Rule( '.c', array( 'color' => 'green' ) ),
) );

// Merge declarations into existing selector
$processor->add_rules( new WP_Style_Engine_CSS_Rule( '.a', array( 'font-size' => '16px' ) ) );
// .a now has both color:red and font-size:16px
```

---

### get_css()

Gets the compiled CSS string.

```php
public function get_css( array $options = array() ): string
```

**Since:** 6.1.0  
**Since:** 6.4.0 Optimization no longer the default

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$options` | array | Configuration options |

#### Options

| Key | Type | Default | Description |
|-----|------|---------|-------------|
| `optimize` | bool | `false` | Combine rules with identical declarations |
| `prettify` | bool | `SCRIPT_DEBUG` | Add newlines and indentation |

#### Returns

Compiled CSS string.

#### Process

1. Collects rules from all added stores
2. If `optimize` is true, combines selectors with identical declarations
3. Compiles each rule to CSS
4. Concatenates all rules

#### Example

```php
$processor = new WP_Style_Engine_Processor();

$processor->add_rules( array(
    new WP_Style_Engine_CSS_Rule( '.a', array( 'color' => 'red' ) ),
    new WP_Style_Engine_CSS_Rule( '.b', array( 'color' => 'red' ) ),
    new WP_Style_Engine_CSS_Rule( '.c', array( 'font-size' => '16px' ) ),
) );

// Without optimization
echo $processor->get_css();
// Output: '.a{color:red}.b{color:red}.c{font-size:16px}'

// With optimization (combine .a and .b)
echo $processor->get_css( array( 'optimize' => true ) );
// Output: '.a,.b{color:red}.c{font-size:16px}'

// Prettified
echo $processor->get_css( array( 'prettify' => true ) );
// Output:
// .a {
// 	color: red;
// }
// .b {
// 	color: red;
// }
// .c {
// 	font-size: 16px;
// }
```

---

## Private Methods

### combine_rules_selectors()

Combines selectors from rules when they have identical declarations.

```php
private function combine_rules_selectors(): void
```

#### Behavior

1. Serializes each rule's declarations to JSON for comparison
2. Finds rules with identical declaration sets
3. Merges their selectors (comma-separated)
4. Removes duplicate rules, keeping combined version

#### Example Effect

Before:
```css
.a { color: red; }
.b { color: red; }
.c { color: blue; }
```

After optimization:
```css
.a, .b { color: red; }
.c { color: blue; }
```
