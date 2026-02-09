# WP_Ability Class

Encapsulates the properties and methods of a registered ability.

**Since:** WordPress 6.9.0

## Overview

`WP_Ability` instances are created by `wp_register_ability()` and retrieved via `wp_get_ability()`. Do not instantiate directly.

## Methods

### get_name()

Returns the namespaced ability name.

```php
public function get_name(): string
```

**Example:**

```php
$ability = wp_get_ability( 'my-plugin/export-users' );
echo $ability->get_name(); // "my-plugin/export-users"
```

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
public function get_meta_item( string $key, mixed $default = null ): mixed
```

**Example:**

```php
$show_in_rest = $ability->get_meta_item( 'show_in_rest', false );
```

---

### validate_input()

Validates input against the input schema.

```php
public function validate_input( mixed $input = null ): true|WP_Error
```

**Returns:** `true` if valid, `WP_Error` if validation fails.

---

### check_permissions()

Checks if the current user has permission to execute.

```php
public function check_permissions( mixed $input = null ): bool|WP_Error
```

**Note:** Does not automatically validate input. Call `validate_input()` first if needed.

---

### execute()

Executes the ability with full validation and permission checking.

```php
public function execute( mixed $input = null ): mixed|WP_Error
```

**Process:**

1. Normalizes input (applies schema defaults)
2. Validates input against schema
3. Checks permissions
4. Fires `wp_before_execute_ability` action
5. Executes the callback
6. Validates output against schema
7. Fires `wp_after_execute_ability` action
8. Returns result

**Example:**

```php
$ability = wp_get_ability( 'my-plugin/export-users' );
$result = $ability->execute( 'administrator' );

if ( is_wp_error( $result ) ) {
    echo 'Error: ' . $result->get_error_message();
} else {
    echo $result; // CSV data
}
```

---

## Hooks

### wp_before_execute_ability

Fires before ability execution, after validation and permission check.

```php
do_action( 'wp_before_execute_ability', string $ability_name, mixed $input );
```

### wp_after_execute_ability

Fires after successful ability execution.

```php
do_action( 'wp_after_execute_ability', string $ability_name, mixed $input, mixed $result );
```

---

## Extending WP_Ability

Create custom ability classes for advanced behavior:

```php
class My_Custom_Ability extends WP_Ability {
    protected function do_execute( $input = null ) {
        // Custom execution logic
        $result = parent::do_execute( $input );
        
        // Post-processing
        return $this->transform_result( $result );
    }
}

// Register with custom class
wp_register_ability( 'my-plugin/custom', array(
    'ability_class' => 'My_Custom_Ability',
    // ... other args
) );
```

## Security

`WP_Ability` implements `__sleep()` and `__wakeup()` to prevent serialization, protecting against object injection attacks.
