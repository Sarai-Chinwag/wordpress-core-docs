# Abilities API Hooks

Actions and filters for the Abilities API.

---

## Actions

### wp_abilities_api_categories_init

Fires when the category registry initializes. Register categories here.

```php
do_action( 'wp_abilities_api_categories_init', WP_Ability_Categories_Registry $registry )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$registry` | WP_Ability_Categories_Registry | Registry instance |

**Example:**

```php
add_action( 'wp_abilities_api_categories_init', function( $registry ) {
    wp_register_ability_category( 'my-category', array(
        'label'       => 'My Category',
        'description' => 'Custom abilities.',
    ) );
} );
```

---

### wp_abilities_api_init

Fires when the ability registry initializes. Register abilities here.

```php
do_action( 'wp_abilities_api_init', WP_Abilities_Registry $registry )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$registry` | WP_Abilities_Registry | Registry instance |

**Example:**

```php
add_action( 'wp_abilities_api_init', function( $registry ) {
    wp_register_ability( 'my-plugin/my-ability', array( ... ) );
} );
```

---

### wp_before_execute_ability

Fires before ability execution, after validation and permission check.

```php
do_action( 'wp_before_execute_ability', string $ability_name, mixed $input )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ability_name` | string | Ability being executed |
| `$input` | mixed | Input data |

**Example:**

```php
add_action( 'wp_before_execute_ability', function( $name, $input ) {
    error_log( "Executing ability: {$name}" );
}, 10, 2 );
```

---

### wp_after_execute_ability

Fires after successful ability execution.

```php
do_action( 'wp_after_execute_ability', string $ability_name, mixed $input, mixed $result )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ability_name` | string | Ability that was executed |
| `$input` | mixed | Input data |
| `$result` | mixed | Execution result |

**Example:**

```php
add_action( 'wp_after_execute_ability', function( $name, $input, $result ) {
    // Log successful executions
    do_action( 'my_plugin_ability_log', $name, $result );
}, 10, 3 );
```

---

## Filters

### wp_register_ability_args

Filters ability configuration before registration.

```php
apply_filters( 'wp_register_ability_args', array $args, string $name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Configuration array |
| `$name` | string | Ability name |

**Returns:** Modified configuration array.

**Example:**

```php
add_filter( 'wp_register_ability_args', function( $args, $name ) {
    // Force all abilities to require authentication
    if ( ! isset( $args['meta']['show_in_rest'] ) ) {
        $args['meta']['show_in_rest'] = false;
    }
    return $args;
}, 10, 2 );
```

---

### wp_register_ability_category_args

Filters category configuration before registration.

```php
apply_filters( 'wp_register_ability_category_args', array $args, string $slug )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$args` | array | Configuration array |
| `$slug` | string | Category slug |

**Returns:** Modified configuration array.

**Example:**

```php
add_filter( 'wp_register_ability_category_args', function( $args, $slug ) {
    // Add default meta to all categories
    $args['meta']['registered_by'] = 'my-plugin';
    return $args;
}, 10, 2 );
```
