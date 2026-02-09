# WP_Interactivity_API

Main class for server-side Interactivity API processing.

**Source:** `wp-includes/interactivity-api/class-wp-interactivity-api.php`  
**Since:** 6.5.0

```php
final class WP_Interactivity_API
```

## Properties

### $directive_processors
```php
private static array $directive_processors
```
Maps directive attribute names to their processor methods.

**Value:**
```php
array(
    'data-wp-interactive'   => 'data_wp_interactive_processor',
    'data-wp-router-region' => 'data_wp_router_region_processor',
    'data-wp-context'       => 'data_wp_context_processor',
    'data-wp-bind'          => 'data_wp_bind_processor',
    'data-wp-class'         => 'data_wp_class_processor',
    'data-wp-style'         => 'data_wp_style_processor',
    'data-wp-text'          => 'data_wp_text_processor',
    'data-wp-each'          => 'data_wp_each_processor',
)
```

### $state_data
```php
private array $state_data = array()
```
Initial state for each store namespace. Serialized and sent to client for hydration.

### $config_data
```php
private array $config_data = array()
```
Configuration for each store namespace. Accessible client-side via `getConfig()`.

### $derived_state_closures
```php
private array $derived_state_closures = array()
```
**Since:** 6.9.0. Tracks derived state closures accessed during SSR for lazy client hydration.

### $has_processed_router_region
```php
private bool $has_processed_router_region = false
```
Whether `data-wp-router-region` has been processed (triggers loading bar styles).

### $script_modules_that_can_load_on_client_navigation
```php
private array $script_modules_that_can_load_on_client_navigation = array()
```
**Since:** 6.9.0. Script modules compatible with client-side navigation.

### $namespace_stack
```php
private ?array $namespace_stack = null
```
**Since:** 6.6.0. Stack of namespaces from `data-wp-interactive` during processing.

### $context_stack
```php
private ?array $context_stack = null
```
**Since:** 6.6.0. Stack of contexts from `data-wp-context` during processing.

### $current_element
```php
private ?array $current_element = null
```
**Since:** 6.7.0. Array representation of element currently being processed.

---

## Public Methods

### state()

Gets and/or sets initial state for a store namespace.

```php
public function state( ?string $store_namespace = null, ?array $state = null ): array
```

**Since:** 6.5.0  
**Since:** 6.6.0 — `$store_namespace` is optional during directive processing.

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string\|null` | Store namespace identifier |
| `$state` | `array\|null` | State to merge |

**Returns:** `array` — Current state for namespace.

**Behavior:**
- If `$store_namespace` is null/empty and `$state` is provided → `_doing_it_wrong`
- If `$store_namespace` is omitted during processing → uses current namespace from stack
- Merges `$state` recursively with existing state via `array_replace_recursive()`

---

### config()

Gets and/or sets configuration for a store namespace.

```php
public function config( string $store_namespace, array $config = array() ): array
```

**Since:** 6.5.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string` | Store namespace identifier |
| `$config` | `array` | Config to merge |

**Returns:** `array` — Current config for namespace.

---

### get_context()

Returns context for a namespace from the context stack.

```php
public function get_context( ?string $store_namespace = null ): array
```

**Since:** 6.6.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$store_namespace` | `string\|null` | Namespace. Uses current if omitted. |

**Returns:** `array` — Context for namespace, or empty array.

**Note:** Only valid during `process_directives()`. Triggers `_doing_it_wrong` otherwise.

---

### get_element()

Returns array representation of current element being processed.

```php
public function get_element(): ?array
```

**Since:** 6.7.0

**Returns:** `array{attributes: array<string, string|bool>}|null`

**Note:** Only valid during `process_directives()`.

---

### add_hooks()

Registers necessary hooks for the Interactivity API.

```php
public function add_hooks(): void
```

**Since:** 6.5.0  
**Since:** 6.9.0 — Adds client-side navigation support.

**Hooks Added:**
- `script_module_data_@wordpress/interactivity` → `filter_script_module_interactivity_data()`
- `script_module_data_@wordpress/interactivity-router` → `filter_script_module_interactivity_router_data()`
- `wp_script_attributes` → `add_load_on_client_navigation_attribute_to_script_modules()`

---

### filter_script_module_interactivity_data()

Filters script module data for `@wordpress/interactivity`.

```php
public function filter_script_module_interactivity_data( array $data ): array
```

**Since:** 6.7.0  
**Since:** 6.9.0 — Serializes derived state props.

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$data` | `array` | Existing data |

**Returns:** `array` — Data with `state`, `config`, and `derivedStateClosures` added.

---

### filter_script_module_interactivity_router_data()

Filters script module data for `@wordpress/interactivity-router`.

```php
public function filter_script_module_interactivity_router_data( array $data ): array
```

**Since:** 6.7.0

**Returns:** `array` — Data with i18n strings for loading/loaded messages.

---

### add_load_on_client_navigation_attribute_to_script_modules()

Adds `data-wp-router-options` attribute to compatible script modules.

```php
public function add_load_on_client_navigation_attribute_to_script_modules( $attributes ): array
```

**Since:** 6.9.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$attributes` | `array` | Script tag attributes |

**Returns:** `array` — Modified attributes with `data-wp-router-options` JSON.

---

### add_client_navigation_support_to_script_module()

Marks a script module as compatible with client-side navigation.

```php
public function add_client_navigation_support_to_script_module( string $script_module_id ): void
```

**Since:** 6.9.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$script_module_id` | `string` | The script module identifier |

---

### process_directives()

Processes interactivity directives in HTML content.

```php
public function process_directives( string $html ): string
```

**Since:** 6.5.0

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$html` | `string` | HTML content to process |

**Returns:** `string` — Processed HTML, or original if unbalanced tags.

**Behavior:**
1. Early return if no `data-wp-` found
2. Initializes namespace and context stacks
3. Calls `_process_directives()` for actual work
4. Cleans up stacks
5. Returns original HTML if processing returned null (unbalanced)

---

### print_router_markup()

Outputs loading bar markup for the interactivity router.

```php
public function print_router_markup(): void
```

**Since:** 6.7.0

**Output:**
```html
<div
    class="wp-interactivity-router-loading-bar"
    data-wp-interactive="core/router"
    data-wp-class--start-animation="state.navigation.hasStarted"
    data-wp-class--finish-animation="state.navigation.hasFinished"
></div>
```

---

## Deprecated Methods

### print_client_interactivity_data()
```php
public function print_client_interactivity_data(): void
```
**Deprecated:** 6.7.0. Use `script_module_data_{$module_id}` filter instead.

### register_script_modules()
```php
public function register_script_modules(): void
```
**Deprecated:** 6.7.0. Use `wp_default_script_modules()` instead.

### print_router_loading_and_screen_reader_markup()
```php
public function print_router_loading_and_screen_reader_markup(): void
```
**Deprecated:** 6.7.0. Use `print_router_markup()` instead.

---

## Private Methods

### _process_directives()

Internal processing of directives using shared stacks.

```php
private function _process_directives( string $html ): ?string
```

**Since:** 6.6.0

**Returns:** `string|null` — Processed HTML or null if unbalanced.

**Processing Order:**
1. Create `WP_Interactivity_API_Directives_Processor`
2. Skip SVG and MATH tags (incompatible with Tag Processor)
3. Track balanced tags via stack
4. For each tag with directives, run processors in order
5. On exit, run processors in reverse order
6. Return null if unbalanced tags detected

---

### evaluate()

Evaluates a directive reference path against state/context.

```php
private function evaluate( array $entry ): mixed
```

**Since:** 6.5.0  
**Since:** 6.6.0 — Supports derived state.  
**Since:** 6.9.0 — Receives `$entry` array instead of string.

**Parameters:**
| Name | Type | Description |
|------|------|-------------|
| `$entry` | `array` | Directive entry with namespace, value, suffix, unique_id |

**Returns:** `mixed|null` — Evaluated value, negated if prefixed with `!`.

**Special Cases:**
- `!path` → Returns negated value
- `.length` on arrays/strings → Returns count/strlen (since 6.8.0)
- Closures → Executed with namespace pushed to stack, tracked for hydration

---

### parse_directive_name()

Parses directive attribute name into components.

```php
private function parse_directive_name( string $directive_name ): ?array
```

**Since:** 6.9.0

**Returns:**
```php
array(
    'prefix'    => string,  // Main directive name without "data-wp-"
    'suffix'    => ?string, // After first "--"
    'unique_id' => ?string, // After "---"
)
```

**Examples:**
- `data-wp-bind--src` → `['prefix' => 'bind', 'suffix' => 'src', 'unique_id' => null]`
- `data-wp-class--active---123` → `['prefix' => 'class', 'suffix' => 'active', 'unique_id' => '123']`

---

### extract_directive_value()

Extracts namespace and value from directive attribute.

```php
private function extract_directive_value( $directive_value, $default_namespace = null ): array
```

**Since:** 6.5.0

**Returns:** `array` — `[namespace, value]`

**Examples:**
- `'state.foo'` → `['defaultNs', 'state.foo']`
- `'otherPlugin::state.foo'` → `['otherPlugin', 'state.foo']`
- `'{"isOpen": false}'` → `['defaultNs', ['isOpen' => false]]`

---

### get_directive_entries()

Gets all valid directive entries for a prefix from current element.

```php
private function get_directive_entries( WP_Interactivity_API_Directives_Processor $p, string $prefix ): array
```

**Since:** 6.9.0

**Returns:** `array` — Sorted array of entries with namespace, value, suffix, unique_id.

---

### kebab_to_camel_case()

Converts kebab-case to camelCase.

```php
private function kebab_to_camel_case( string $str ): string
```

**Since:** 6.5.0

**Example:** `'my-variable-name'` → `'myVariableName'`

---

### merge_style_property()

Merges a style property into a style attribute string.

```php
private function merge_style_property( string $style_attribute_value, string $style_property_name, $style_property_value ): string
```

**Since:** 6.5.0

**Examples:**
- `merge_style_property('color:green;', 'color', 'red')` → `'color:red;'`
- `merge_style_property('background:green;', 'color', 'red')` → `'background:green;color:red;'`
- `merge_style_property('color:green;', 'color', null)` → `''`

---

### get_router_animation_styles()

Returns CSS for the router loading bar animation.

```php
private function get_router_animation_styles(): string
```

**Since:** 6.5.0

---

## Directive Processors

All processors receive:
- `WP_Interactivity_API_Directives_Processor $p` — The processor instance
- `string $mode` — `'enter'` or `'exit'`
- `array &$tag_stack` — Reference to tag stack (only `data_wp_each_processor`)

### data_wp_interactive_processor()

Processes `data-wp-interactive` directive.

```php
private function data_wp_interactive_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- `enter`: Parses namespace from attribute value (string or JSON `{"namespace":"..."}`) and pushes to stack
- `exit`: Pops namespace from stack

---

### data_wp_context_processor()

Processes `data-wp-context` directive.

```php
private function data_wp_context_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- `enter`: Merges context JSON into stack with namespace key
- `exit`: Pops context from stack

---

### data_wp_bind_processor()

Processes `data-wp-bind--{attr}` directives.

```php
private function data_wp_bind_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- Evaluates reference and sets/removes attribute
- Boolean values for `aria-*` and `data-*` become `"true"`/`"false"` strings
- `false` removes non-aria/data attributes

---

### data_wp_class_processor()

Processes `data-wp-class--{classname}` directives.

```php
private function data_wp_class_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- Truthy value adds class
- Falsy value removes class
- Supports unique IDs: `data-wp-class--active---123` → class `active---123`

---

### data_wp_style_processor()

Processes `data-wp-style--{property}` directives.

```php
private function data_wp_style_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- Updates or removes style property in `style` attribute
- Removes entire `style` attribute if empty after modification

---

### data_wp_text_processor()

Processes `data-wp-text` directive.

```php
private function data_wp_text_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- Replaces element content with evaluated value (escaped)
- Only processes strings and numbers (per Preact behavior)
- Other types clear the content

---

### data_wp_router_region_processor()

Processes `data-wp-router-region` directive.

```php
private function data_wp_router_region_processor( WP_Interactivity_API_Directives_Processor $p, string $mode ): void
```

**Since:** 6.5.0

**Behavior:**
- Only runs once per page
- Registers and enqueues `wp-interactivity-router-animations` styles
- Adds `print_router_markup()` to `wp_footer`

---

### data_wp_each_processor()

Processes `data-wp-each` directive on `<template>` tags.

```php
private function data_wp_each_processor( WP_Interactivity_API_Directives_Processor $p, string $mode, array &$tag_stack ): void
```

**Since:** 6.5.0  
**Since:** 6.9.0 — Includes list path in `data-wp-each-child`.

**Behavior:**
1. Only processes `<template>` tags
2. Evaluates array reference
3. Skips if: manual SSR (`data-wp-each-child` exists), non-list array, or invalid template content
4. For each item:
   - Creates context with item (name from suffix, default `item`)
   - Recursively processes inner content
   - Adds `data-wp-each-child` to top-level rendered elements
5. Appends all processed content after template closer

**Example:**
```html
<template data-wp-each="state.items" data-wp-each-key="context.item.id">
    <li data-wp-text="context.item.name"></li>
</template>
```
