# Abilities API Functions

Core functions for ability registration and management.

**Source:** `wp-includes/abilities-api.php`

---

## wp_register_ability()

Registers a new ability. Must be called during `wp_abilities_api_init` action.

```php
wp_register_ability( string $name, array $args ): ?WP_Ability
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Namespaced ability name (e.g., `my-plugin/my-ability`) |
| `$args` | array | Configuration array |

### Args

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `description` | string | Yes | Detailed description |
| `category` | string | Yes | Category slug (must be registered) |
| `execute_callback` | callable | Yes | Execution function |
| `permission_callback` | callable | Yes | Permission check function |
| `input_schema` | array | No | JSON Schema for input validation |
| `output_schema` | array | No | JSON Schema for output validation |
| `meta` | array | No | Additional metadata |
| `meta.annotations` | array | No | `readonly`, `destructive`, `idempotent` hints |
| `meta.show_in_rest` | bool | No | Expose via REST API (default: false) |
| `ability_class` | string | No | Custom class extending WP_Ability |

### Returns

`WP_Ability` on success, `null` on failure.

### Example

```php
add_action( 'wp_abilities_api_init', function() {
    wp_register_ability( 'my-plugin/analyze-text', array(
        'label'               => __( 'Analyze Text', 'my-plugin' ),
        'description'         => __( 'Performs sentiment analysis.', 'my-plugin' ),
        'category'            => 'text-processing',
        'execute_callback'    => 'my_plugin_analyze_text',
        'permission_callback' => fn() => current_user_can( 'edit_posts' ),
        'input_schema'        => array(
            'type'      => 'string',
            'minLength' => 10,
            'required'  => true,
        ),
        'output_schema'       => array(
            'type' => 'string',
            'enum' => array( 'positive', 'negative', 'neutral' ),
        ),
        'meta'                => array(
            'annotations'  => array( 'readonly' => true ),
            'show_in_rest' => true,
        ),
    ) );
} );
```

---

## wp_unregister_ability()

Removes a registered ability.

```php
wp_unregister_ability( string $name ): ?WP_Ability
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name to unregister |

### Returns

Unregistered `WP_Ability` on success, `null` if not found.

---

## wp_has_ability()

Checks if an ability is registered.

```php
wp_has_ability( string $name ): bool
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name to check |

### Returns

`true` if registered, `false` otherwise.

---

## wp_get_ability()

Retrieves a registered ability.

```php
wp_get_ability( string $name ): ?WP_Ability
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Ability name |

### Returns

`WP_Ability` instance or `null` if not registered.

---

## wp_get_abilities()

Retrieves all registered abilities.

```php
wp_get_abilities(): array
```

### Returns

Array of `WP_Ability` instances.

---

## wp_register_ability_category()

Registers a new ability category. Must be called during `wp_abilities_api_categories_init` action.

```php
wp_register_ability_category( string $slug, array $args ): ?WP_Ability_Category
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$slug` | string | Category slug |
| `$args` | array | Configuration array |

### Args

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `description` | string | Yes | Category description |
| `meta` | array | No | Additional metadata |

### Returns

`WP_Ability_Category` on success, `null` on failure.

### Example

```php
add_action( 'wp_abilities_api_categories_init', function() {
    wp_register_ability_category( 'text-processing', array(
        'label'       => __( 'Text Processing', 'my-plugin' ),
        'description' => __( 'Abilities for analyzing text.', 'my-plugin' ),
    ) );
} );
```

---

## wp_unregister_ability_category()

Removes a registered category.

```php
wp_unregister_ability_category( string $slug ): ?WP_Ability_Category
```

---

## wp_has_ability_category()

Checks if a category is registered.

```php
wp_has_ability_category( string $slug ): bool
```

---

## wp_get_ability_category()

Retrieves a registered category.

```php
wp_get_ability_category( string $slug ): ?WP_Ability_Category
```

---

## wp_get_ability_categories()

Retrieves all registered categories.

```php
wp_get_ability_categories(): array
```
