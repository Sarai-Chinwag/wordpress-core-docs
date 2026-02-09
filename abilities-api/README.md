# Abilities API

The Abilities API provides a unified, extensible framework for registering and executing discrete capabilities within WordPress. An "ability" is a self-contained unit of functionality with defined inputs, outputs, permissions, and execution logic.

**Since:** WordPress 6.9.0

## Overview

The Abilities API enables developers to:

- Register custom abilities with standardized interfaces
- Define permission checks and execution callbacks
- Organize abilities into logical categories
- Validate inputs and outputs using JSON Schema
- Expose abilities through the REST API

## Quick Start

```php
// 1. Register a category (on wp_abilities_api_categories_init)
add_action( 'wp_abilities_api_categories_init', function() {
    wp_register_ability_category( 'my-category', array(
        'label'       => __( 'My Category', 'my-plugin' ),
        'description' => __( 'Custom abilities for my plugin.', 'my-plugin' ),
    ) );
} );

// 2. Register an ability (on wp_abilities_api_init)
add_action( 'wp_abilities_api_init', function() {
    wp_register_ability( 'my-plugin/hello-world', array(
        'label'               => __( 'Hello World', 'my-plugin' ),
        'description'         => __( 'Returns a greeting message.', 'my-plugin' ),
        'category'            => 'my-category',
        'execute_callback'    => fn( $name ) => "Hello, {$name}!",
        'permission_callback' => '__return_true',
        'input_schema'        => array(
            'type'        => 'string',
            'description' => 'Name to greet',
            'required'    => true,
        ),
        'output_schema'       => array(
            'type'        => 'string',
            'description' => 'Greeting message',
        ),
        'meta'                => array( 'show_in_rest' => true ),
    ) );
} );
```

## Documentation

- [Functions Reference](./functions.md) — Core API functions
- [WP_Ability Class](./class-wp-ability.md) — Ability instance methods
- [WP_Abilities_Registry Class](./class-wp-abilities-registry.md) — Registry management
- [Categories](./categories.md) — Organizing abilities into categories
- [REST API Integration](./rest-api.md) — Exposing abilities via REST
- [JSON Schema](./schemas.md) — Input/output validation

## Core Concepts

### Naming Conventions

Ability names must:

- Include a namespace prefix: `my-plugin/my-ability`
- Use only lowercase alphanumeric characters, dashes, and forward slashes
- Be descriptive and action-oriented: `process-payment`, `generate-report`

### Registration Hooks

| Hook | Purpose |
|------|---------|
| `wp_abilities_api_categories_init` | Register ability categories |
| `wp_abilities_api_init` | Register abilities |

Categories must be registered before the abilities that reference them.

### Required Configuration

| Property | Type | Description |
|----------|------|-------------|
| `label` | string | Human-readable name |
| `description` | string | What the ability does |
| `category` | string | Category slug (must exist) |
| `execute_callback` | callable | Function that performs the work |
| `permission_callback` | callable | Function that checks authorization |

### Optional Configuration

| Property | Type | Description |
|----------|------|-------------|
| `input_schema` | array | JSON Schema for input validation |
| `output_schema` | array | JSON Schema for output validation |
| `meta` | array | Additional metadata |

## Callbacks

### Execute Callback

Performs the ability's core functionality. Receives optional input data and returns either a result or `WP_Error` on failure.

```php
function my_execute_callback( string $input ): string|WP_Error {
    if ( empty( $input ) ) {
        return new WP_Error( 'empty_input', 'Input cannot be empty.' );
    }
    return strtoupper( $input );
}
```

### Permission Callback

Determines whether the ability can be executed. Returns `true`, `false`, or `WP_Error`.

```php
function my_permission_callback( string $input ): bool|WP_Error {
    return current_user_can( 'edit_posts' );
}
```

## Meta Options

### Annotations

Semantic hints about ability behavior:

```php
'meta' => array(
    'annotations' => array(
        'readonly'    => true,  // Does not modify environment
        'destructive' => false, // Only additive changes
        'idempotent'  => true,  // Repeated calls have same effect
    ),
),
```

### REST API Exposure

```php
'meta' => array(
    'show_in_rest' => true,
),
```

When enabled, abilities are accessible at:

- `GET /wp-json/wp-abilities/v1/abilities` — List all abilities
- `GET /wp-json/wp-abilities/v1/abilities/{name}` — Get single ability
- `POST /wp-json/wp-abilities/v1/abilities/{name}/execute` — Execute ability

## Best Practices

1. **Always register on the correct hook** — Use `wp_abilities_api_init` for abilities, `wp_abilities_api_categories_init` for categories
2. **Use namespaced names** — Prevents conflicts with other plugins
3. **Implement robust permission checks** — Never assume the user has access
4. **Define schemas** — Enables automatic validation and documentation
5. **Return WP_Error for failures** — Don't throw exceptions
6. **Use internationalization** — All user-facing strings should be translatable
