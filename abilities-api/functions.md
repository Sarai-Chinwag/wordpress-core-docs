# Abilities API Functions

Core functions for registering and managing abilities.

## Ability Functions

### wp_register_ability()

Registers a new ability.

```php
wp_register_ability( string $name, array $args ): ?WP_Ability
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$name` | string | Namespaced ability name (e.g., `my-plugin/my-ability`) |
| `$args` | array | Configuration array (see below) |

**Configuration Options:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `description` | string | Yes | Detailed description |
| `category` | string | Yes | Category slug |
| `execute_callback` | callable | Yes | Execution function |
| `permission_callback` | callable | Yes | Permission check function |
| `input_schema` | array | No | JSON Schema for input |
| `output_schema` | array | No | JSON Schema for output |
| `meta` | array | No | Additional metadata |
| `ability_class` | string | No | Custom class extending WP_Ability |

**Returns:** `WP_Ability` instance on success, `null` on failure.

**Example:**

```php
add_action( 'wp_abilities_api_init', function() {
    wp_register_ability( 'my-plugin/export-users', array(
        'label'               => __( 'Export Users', 'my-plugin' ),
        'description'         => __( 'Exports user data to CSV.', 'my-plugin' ),
        'category'            => 'data-export',
        'execute_callback'    => 'my_plugin_export_users',
        'permission_callback' => fn() => current_user_can( 'export' ),
        'input_schema'        => array(
            'type' => 'string',
            'enum' => array( 'subscriber', 'author', 'editor', 'administrator' ),
        ),
        'output_schema'       => array(
            'type' => 'string',
        ),
        'meta'                => array( 'show_in_rest' => true ),
    ) );
} );
```

---

### wp_unregister_ability()

Removes a registered ability.

```php
wp_unregister_ability( string $name ): ?WP_Ability
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$name` | string | Ability name to unregister |

**Returns:** The unregistered `WP_Ability` instance, or `null` if not found.

**Example:**

```php
if ( wp_has_ability( 'other-plugin/some-ability' ) ) {
    wp_unregister_ability( 'other-plugin/some-ability' );
}
```

---

### wp_has_ability()

Checks if an ability is registered.

```php
wp_has_ability( string $name ): bool
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$name` | string | Ability name to check |

**Returns:** `true` if registered, `false` otherwise.

**Example:**

```php
if ( wp_has_ability( 'premium-plugin/advanced-export' ) ) {
    echo 'Premium export available';
}
```

---

### wp_get_ability()

Retrieves a registered ability.

```php
wp_get_ability( string $name ): ?WP_Ability
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$name` | string | Ability name to retrieve |

**Returns:** `WP_Ability` instance, or `null` if not registered.

**Example:**

```php
$ability = wp_get_ability( 'my-plugin/export-data' );
if ( $ability ) {
    echo $ability->get_label() . ': ' . $ability->get_description();
}
```

---

### wp_get_abilities()

Retrieves all registered abilities.

```php
wp_get_abilities(): array
```

**Returns:** Array of `WP_Ability` instances.

**Example:**

```php
foreach ( wp_get_abilities() as $ability ) {
    printf( "%s: %s\n", $ability->get_label(), $ability->get_description() );
}
```

---

## Category Functions

### wp_register_ability_category()

Registers a new ability category.

```php
wp_register_ability_category( string $slug, array $args ): ?WP_Ability_Category
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$slug` | string | Unique category slug |
| `$args` | array | Configuration array |

**Configuration Options:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `description` | string | Yes | Category description |
| `meta` | array | No | Additional metadata |

**Returns:** `WP_Ability_Category` instance on success, `null` on failure.

**Example:**

```php
add_action( 'wp_abilities_api_categories_init', function() {
    wp_register_ability_category( 'content-management', array(
        'label'       => __( 'Content Management', 'my-plugin' ),
        'description' => __( 'Abilities for managing content.', 'my-plugin' ),
    ) );
} );
```

---

### wp_unregister_ability_category()

Removes a registered ability category.

```php
wp_unregister_ability_category( string $slug ): ?WP_Ability_Category
```

---

### wp_has_ability_category()

Checks if an ability category is registered.

```php
wp_has_ability_category( string $slug ): bool
```

---

### wp_get_ability_category()

Retrieves a registered ability category.

```php
wp_get_ability_category( string $slug ): ?WP_Ability_Category
```

---

### wp_get_ability_categories()

Retrieves all registered ability categories.

```php
wp_get_ability_categories(): array
```
