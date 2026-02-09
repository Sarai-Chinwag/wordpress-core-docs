# Block Bindings API

Framework for connecting block attributes to external data sources, allowing dynamic content override during block rendering.

**Since:** 6.5.0  
**Source:** `wp-includes/block-bindings.php`, `wp-includes/block-bindings/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration and retrieval functions |
| [class-wp-block-bindings-registry.md](./class-wp-block-bindings-registry.md) | Registry singleton for managing sources |
| [class-wp-block-bindings-source.md](./class-wp-block-bindings-source.md) | Individual source instance |
| [hooks.md](./hooks.md) | Filters for customization |

## Registration Flow

```
init action
    └── register_block_bindings_source()
            └── WP_Block_Bindings_Registry::register()
                    └── new WP_Block_Bindings_Source()
```

## Value Resolution Flow

```
Block rendering
    └── WP_Block_Bindings_Source::get_value()
            ├── get_value_callback( $source_args, $block_instance, $attribute_name )
            └── apply_filters( 'block_bindings_source_value', $value, ... )
```

## Supported Blocks (Default)

| Block | Supported Attributes |
|-------|---------------------|
| `core/paragraph` | `content` |
| `core/heading` | `content` |
| `core/image` | `id`, `url`, `title`, `alt`, `caption` |
| `core/button` | `url`, `text`, `linkTarget`, `rel` |
| `core/post-date` | `datetime` |
| `core/navigation-link` | `url` |
| `core/navigation-submenu` | `url` |

## Built-in Sources

| Source | Since | Description |
|--------|-------|-------------|
| `core/post-meta` | 6.5.0 | Post custom field values |
| `core/pattern-overrides` | 6.5.0 | Pattern content overrides |
| `core/post-data` | 6.9.0 | Post date, modified, link |
| `core/term-data` | 6.9.0 | Term name, link, slug, description, parent, count |

## Block Markup Example

```html
<!-- wp:paragraph {
  "metadata": {
    "bindings": {
      "content": {
        "source": "my-plugin/my-source",
        "args": {
          "key": "custom_value"
        }
      }
    }
  }
} -->
<p>Fallback text replaced by binding.</p>
<!-- /wp:paragraph -->
```

## Quick Start

```php
// Register a custom source
add_action( 'init', function() {
    register_block_bindings_source( 'my-plugin/site-info', array(
        'label'              => __( 'Site Info', 'my-plugin' ),
        'get_value_callback' => function( $source_args, $block_instance, $attribute_name ) {
            switch ( $source_args['field'] ?? '' ) {
                case 'name':
                    return get_bloginfo( 'name' );
                case 'description':
                    return get_bloginfo( 'description' );
                default:
                    return null;
            }
        },
    ) );
} );
```
