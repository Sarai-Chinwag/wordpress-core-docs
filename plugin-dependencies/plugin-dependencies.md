# Plugin Dependencies API

Framework for declaring and resolving plugin dependencies in WordPress.

**Since:** 6.5.0  
**Source:** `wp-includes/class-wp-plugin-dependencies.php`

## Components

| Component | Description |
|-----------|-------------|
| [class-wp-plugin-dependencies.md](./class-wp-plugin-dependencies.md) | Static class for dependency resolution |
| [hooks.md](./hooks.md) | Actions and filters |

## Declaring Dependencies

Plugins declare dependencies via the `Requires Plugins` header:

```php
/**
 * Plugin Name: My Plugin
 * Requires Plugins: woocommerce, jetpack
 */
```

Dependencies are listed as comma-separated slugs matching WordPress.org format.

## Initialization Flow

```
plugins_loaded
    └── WP_Plugin_Dependencies::initialize()
            ├── read_dependencies_from_plugin_headers()
            │       ├── Parse 'Requires Plugins' headers
            │       ├── Sanitize slugs via wp_plugin_dependencies_slug filter
            │       └── Build dependency/dependent maps
            └── get_dependency_api_data()
                    └── Fetch plugin info from WordPress.org API
```

## Dependency Resolution

```
Plugin Activation Check
    ├── has_dependencies( $plugin_file )
    │       └── Does plugin require other plugins?
    ├── has_unmet_dependencies( $plugin_file )
    │       └── Are any dependencies missing/inactive?
    ├── has_circular_dependency( $plugin_file )
    │       └── Detect A→B→A loops
    └── get_dependency_filepath( $slug )
            └── Find installed dependency location
```

## Key Concepts

| Term | Description |
|------|-------------|
| **Dependency** | A plugin that another plugin requires |
| **Dependent** | A plugin that requires another plugin |
| **Slug** | Plugin identifier matching WordPress.org format (lowercase, hyphenated) |
| **Filepath** | Plugin file relative to plugins directory (e.g., `woocommerce/woocommerce.php`) |

## Admin Integration

The class displays admin notices for:

- Unmet dependencies (missing or inactive required plugins)
- Circular dependencies (plugins that depend on each other)

AJAX handler validates dependencies after plugin installation.
