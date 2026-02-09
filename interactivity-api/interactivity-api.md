# Interactivity API

Server-side processing of interactive directives for WordPress blocks.

**Since:** 6.5.0  
**Source:** `wp-includes/interactivity-api/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Global wrapper functions |
| [class-wp-interactivity-api.md](./class-wp-interactivity-api.md) | Main API class with all processing logic |
| [directives.md](./directives.md) | All `data-wp-*` directive attributes |
| [hooks.md](./hooks.md) | Filters for script module data |

## Architecture

The Interactivity API enables reactive, client-side interactions in WordPress blocks while maintaining server-side rendering. It processes HTML containing `data-wp-*` directives, evaluates state/context references, and outputs hydration data for the client.

## Processing Flow

```
wp_interactivity_process_directives( $html )
    └── WP_Interactivity_API::process_directives()
            ├── Initialize namespace_stack, context_stack
            ├── WP_Interactivity_API_Directives_Processor( $html )
            └── For each tag with data-wp-* attributes:
                    ├── data_wp_interactive_processor (namespace)
                    ├── data_wp_router_region_processor
                    ├── data_wp_context_processor (context)
                    ├── data_wp_bind_processor
                    ├── data_wp_class_processor
                    ├── data_wp_style_processor
                    ├── data_wp_text_processor
                    └── data_wp_each_processor (templating)
```

## State & Config Flow

```
wp_interactivity_state( 'myPlugin', $state )
    └── WP_Interactivity_API::state()
            └── Merges into $state_data[ 'myPlugin' ]

wp_interactivity_config( 'myPlugin', $config )
    └── WP_Interactivity_API::config()
            └── Merges into $config_data[ 'myPlugin' ]

filter: script_module_data_@wordpress/interactivity
    └── filter_script_module_interactivity_data()
            └── Returns { state, config, derivedStateClosures }
```

## Key Concepts

### Namespaces
Each interactive block defines a namespace via `data-wp-interactive`. Nested elements inherit the parent namespace unless they define their own.

### State vs Context
- **State** (`wp_interactivity_state`): Global data shared across all instances of a block type
- **Context** (`data-wp-context`): Local data scoped to a specific element and its descendants

### Directive References
Directives reference state/context using dot notation:
- `state.isOpen` → Looks up `$state_data['namespace']['isOpen']`
- `context.item.name` → Looks up current context's `['namespace']['item']['name']`
- `!state.isOpen` → Negates the value

### Derived State
State values can be closures that compute derived values. These are tracked and serialized for client-side hydration.
