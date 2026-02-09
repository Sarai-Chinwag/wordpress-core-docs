# Block Bindings API

The Block Bindings API allows block attributes to be dynamically populated from external data sources, enabling dynamic content without custom block development.

**Since:** WordPress 6.5.0

## Overview

Block Bindings enables:

- Connecting block attributes to custom data sources
- Dynamic content from post meta, site options, or custom sources
- Reusable binding sources across multiple blocks
- Server-side value resolution during rendering

## How It Works

1. **Register a source** — Define where data comes from
2. **Bind blocks to source** — Connect block attributes via `metadata.bindings`
3. **Render** — WordPress resolves bindings during block rendering

## Quick Start

### Registering a Source

```php
add_action( 'init', function() {
    register_block_bindings_source( 'my-plugin/user-meta', array(
        'label'              => __( 'User Meta', 'my-plugin' ),
        'get_value_callback' => function( $source_args, $block_instance, $attribute_name ) {
            $meta_key = $source_args['key'] ?? '';
            return get_user_meta( get_current_user_id(), $meta_key, true );
        },
    ) );
} );
```

### Using in Block Markup

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "my-plugin/user-meta",
                "args": {
                    "key": "biography"
                }
            }
        }
    }
} -->
<p>Fallback content shown if binding fails</p>
<!-- /wp:paragraph -->
```

## Core Functions

### register_block_bindings_source()

Registers a new block bindings source.

```php
register_block_bindings_source( 
    string $source_name, 
    array $source_properties 
): WP_Block_Bindings_Source|false
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$source_name` | string | Namespaced identifier (e.g., `my-plugin/source`) |
| `$source_properties` | array | Configuration array |

**Source Properties:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `get_value_callback` | callable | Yes | Function to retrieve the value |
| `uses_context` | string[] | No | Block context values needed |

**Callback Signature:**

```php
function( array $source_args, WP_Block $block_instance, string $attribute_name ): mixed
```

- `$source_args` — Arguments from the binding definition
- `$block_instance` — The block being rendered
- `$attribute_name` — Which attribute is being bound
- **Returns:** Value to use, `null` to skip, `false` to remove attribute

---

### unregister_block_bindings_source()

Removes a registered source.

```php
unregister_block_bindings_source( string $source_name ): WP_Block_Bindings_Source|false
```

---

### get_block_bindings_source()

Retrieves a registered source.

```php
get_block_bindings_source( string $source_name ): ?WP_Block_Bindings_Source
```

---

### get_all_registered_block_bindings_sources()

Returns all registered sources.

```php
get_all_registered_block_bindings_sources(): WP_Block_Bindings_Source[]
```

---

### get_block_bindings_supported_attributes()

Returns supported attributes for a block type.

```php
get_block_bindings_supported_attributes( string $block_type ): array
```

---

## Built-in Sources

WordPress includes these sources by default:

| Source | Description |
|--------|-------------|
| `core/post-meta` | Post meta fields |
| `core/pattern-overrides` | Pattern override values |

### Using Post Meta

```html
<!-- wp:paragraph {
    "metadata": {
        "bindings": {
            "content": {
                "source": "core/post-meta",
                "args": {
                    "key": "custom_excerpt"
                }
            }
        }
    }
} -->
<p></p>
<!-- /wp:paragraph -->
```

## Supported Blocks & Attributes

| Block | Supported Attributes |
|-------|---------------------|
| `core/paragraph` | `content` |
| `core/heading` | `content` |
| `core/image` | `id`, `url`, `title`, `alt`, `caption` |
| `core/button` | `url`, `text`, `linkTarget`, `rel` |
| `core/post-date` | `datetime` |
| `core/navigation-link` | `url` |
| `core/navigation-submenu` | `url` |

### Adding Support for Custom Blocks

```php
add_filter( 'block_bindings_supported_attributes', function( $attrs, $block_type ) {
    if ( 'my-plugin/custom-block' === $block_type ) {
        return array( 'title', 'description', 'imageUrl' );
    }
    return $attrs;
}, 10, 2 );
```

Or use the block-specific filter:

```php
add_filter( 'block_bindings_supported_attributes_my-plugin/custom-block', function( $attrs ) {
    return array( 'title', 'description', 'imageUrl' );
} );
```

## Examples

### ACF Field Binding

```php
add_action( 'init', function() {
    register_block_bindings_source( 'my-plugin/acf', array(
        'label'              => __( 'ACF Field', 'my-plugin' ),
        'get_value_callback' => function( $args, $block ) {
            if ( ! function_exists( 'get_field' ) ) {
                return null;
            }
            return get_field( $args['field'], $block->context['postId'] ?? get_the_ID() );
        },
        'uses_context'       => array( 'postId' ),
    ) );
} );
```

Usage:

```html
<!-- wp:image {
    "metadata": {
        "bindings": {
            "url": {
                "source": "my-plugin/acf",
                "args": { "field": "hero_image" }
            },
            "alt": {
                "source": "my-plugin/acf", 
                "args": { "field": "hero_alt" }
            }
        }
    }
} -->
<figure class="wp-block-image"><img src="" alt=""/></figure>
<!-- /wp:image -->
```

### Site Option Binding

```php
add_action( 'init', function() {
    register_block_bindings_source( 'my-plugin/option', array(
        'label'              => __( 'Site Option', 'my-plugin' ),
        'get_value_callback' => function( $args ) {
            return get_option( $args['name'], $args['default'] ?? '' );
        },
    ) );
} );
```

### Conditional Value

```php
register_block_bindings_source( 'my-plugin/membership', array(
    'label'              => __( 'Membership Content', 'my-plugin' ),
    'get_value_callback' => function( $args ) {
        if ( current_user_can( 'access_premium_content' ) ) {
            return $args['premium'] ?? '';
        }
        return $args['default'] ?? 'Upgrade to view this content';
    },
) );
```

## Best Practices

1. **Namespace your sources** — Use `plugin-name/source-name` format
2. **Provide fallback content** — Block content serves as fallback when binding returns null
3. **Use `uses_context` for post data** — Access `postId` from block context
4. **Return appropriate types** — Match the expected attribute type
5. **Handle missing data gracefully** — Return null to use fallback, not empty string
