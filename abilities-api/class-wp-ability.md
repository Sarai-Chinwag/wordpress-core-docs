# WP_Ability

Represents a registered ability with its configuration, callbacks, and execution logic.

**Source:** `wp-includes/abilities-api/class-wp-ability.php`  
**Since:** 6.9.0

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$name` | string | protected | Namespaced ability name |
| `$label` | string | protected | Human-readable label |
| `$description` | string | protected | Detailed description |
| `$category` | string | protected | Category slug |
| `$input_schema` | array | protected | JSON Schema for input |
| `$output_schema` | array | protected | JSON Schema for output |
| `$execute_callback` | callable | protected | Execution function |
| `$permission_callback` | callable | protected | Permission check function |
| `$meta` | array | protected | Additional metadata |

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `DEFAULT_SHOW_IN_REST` | `false` | Default REST API visibility |

## Static Properties

| Property | Type | Description |
|----------|------|-------------|
| `$default_annotations` | array | Default annotation values (`readonly`, `destructive`, `idempotent` = `null`) |

---

## Methods

### __construct()

Instantiates an ability. Do not call directly; use `wp_register_ability()`.

```php
public function __construct( string $name, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name with namespace |
| `$args` | array | Configuration array |

---

### get_name()

Returns the namespaced ability name.

```php
public function get_name(): string
```

**Returns:** Ability name (e.g., `my-plugin/my-ability`)

---

### get_label()

Returns the human-readable label.

```php
public function get_label(): string
```

---

### get_description()

Returns the detailed description.

```php
public function get_description(): string
```

---

### get_category()

Returns the category slug.

```php
public function get_category(): string
```

---

### get_input_schema()

Returns the JSON Schema for input validation.

```php
public function get_input_schema(): array
```

---

### get_output_schema()

Returns the JSON Schema for output validation.

```php
public function get_output_schema(): array
```

---

### get_meta()

Returns all metadata.

```php
public function get_meta(): array
```

---

### get_meta_item()

Returns a specific metadata value.

```php
public function get_meta_item( string $key, mixed $default_value = null ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Metadata key |
| `$default_value` | mixed | Default if key not found |

---

### normalize_input()

Applies default value from input schema when no input provided.

```php
public function normalize_input( mixed $input = null ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | mixed | Raw input value |

**Returns:** Input value, or schema default, or `null`.

---

### validate_input()

Validates input against the input schema.

```php
public function validate_input( mixed $input = null ): true|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | mixed | Input to validate |

**Returns:** `true` if valid, `WP_Error` if validation fails.

**Error Codes:**
- `ability_missing_input_schema` — Input provided but no schema defined
- `ability_invalid_input` — Input fails schema validation

---

### check_permissions()

Checks if execution is permitted. Does not validate input.

```php
public function check_permissions( mixed $input = null ): bool|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | mixed | Input for permission check |

**Returns:** `true` if permitted, `false` or `WP_Error` if denied.

**Error Codes:**
- `ability_invalid_permission_callback` — Callback not callable

---

### execute()

Executes the ability with full validation and permission checking.

```php
public function execute( mixed $input = null ): mixed|WP_Error
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$input` | mixed | Input data |

**Returns:** Execution result or `WP_Error` on failure.

**Execution Flow:**

1. `normalize_input()` — Apply schema defaults
2. `validate_input()` — Validate against schema
3. `check_permissions()` — Verify authorization
4. `do_action('wp_before_execute_ability')` — Pre-execution hook
5. `do_execute()` — Call execute_callback
6. `validate_output()` — Validate result against output schema
7. `do_action('wp_after_execute_ability')` — Post-execution hook

**Error Codes:**
- `ability_invalid_input` — Input validation failed
- `ability_invalid_permissions` — Permission denied
- `ability_invalid_execute_callback` — Execute callback not callable
- `ability_invalid_output` — Output validation failed

---

### prepare_properties() <small>(protected)</small>

Validates and prepares configuration arguments.

```php
protected function prepare_properties( array $args ): array
```

**Throws:** `InvalidArgumentException` if required args missing or invalid.

---

### invoke_callback() <small>(protected)</small>

Invokes a callback, passing input only if input schema is defined.

```php
protected function invoke_callback( callable $callback, mixed $input = null ): mixed
```

---

### do_execute() <small>(protected)</small>

Executes the execute_callback.

```php
protected function do_execute( mixed $input = null ): mixed|WP_Error
```

---

### validate_output() <small>(protected)</small>

Validates output against output schema.

```php
protected function validate_output( mixed $output ): true|WP_Error
```

---

### __wakeup()

Prevents unserialization (security hardening).

```php
public function __wakeup(): void
```

**Throws:** `LogicException`

---

### __sleep()

Prevents serialization (security hardening).

```php
public function __sleep(): array
```

**Throws:** `LogicException`

---

## Extending

Custom ability classes must extend `WP_Ability`:

```php
class My_Custom_Ability extends WP_Ability {
    protected function do_execute( $input = null ) {
        $result = parent::do_execute( $input );
        // Custom post-processing
        return $this->transform( $result );
    }
}

// Register with custom class
wp_register_ability( 'my-plugin/custom', array(
    'ability_class' => 'My_Custom_Ability',
    // ... other args
) );
```
