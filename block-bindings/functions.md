# Block Bindings API Functions

Core functions for block bindings source registration and management.

**Source:** `wp-includes/block-bindings.php`

---

## register_block_bindings_source()

Registers a new block bindings source.

```php
register_block_bindings_source( string $source_name, array $source_properties ): WP_Block_Bindings_Source|false
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Namespaced source name (e.g., `my-plugin/my-source`) |
| `$source_properties` | array | Configuration array |

### Source Properties

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `label` | string | Yes | Human-readable label |
| `get_value_callback` | callable | Yes | Callback executed during block rendering |
| `uses_context` | string[] | No | Block context keys required by the source |

### Callback Signature

```php
function( array $source_args, WP_Block $block_instance, string $attribute_name ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_args` | array | Arguments from block's `metadata.bindings.{attr}.args` |
| `$block_instance` | WP_Block | The block being rendered |
| `$attribute_name` | string | Target attribute name |

**Returns:** String to override value, `null` for no change, `false` to remove attribute.

### Returns

`WP_Block_Bindings_Source` on success, `false` on failure.

### Name Requirements

- Must contain namespace prefix with forward slash
- Only lowercase alphanumeric characters, forward slash `/`, and dashes `-`
- Example: `my-plugin/my-custom-source`

### Example

```php
add_action( 'init', function() {
    register_block_bindings_source( 'my-plugin/user-data', array(
        'label'              => __( 'User Data', 'my-plugin' ),
        'get_value_callback' => function( $source_args, $block_instance, $attribute_name ) {
            $user = wp_get_current_user();
            if ( ! $user->exists() ) {
                return null;
            }
            
            switch ( $source_args['field'] ?? '' ) {
                case 'display_name':
                    return esc_html( $user->display_name );
                case 'email':
                    return esc_html( $user->user_email );
                default:
                    return null;
            }
        },
        'uses_context' => array( 'postId' ),
    ) );
} );
```

---

## unregister_block_bindings_source()

Removes a registered block bindings source.

```php
unregister_block_bindings_source( string $source_name ): WP_Block_Bindings_Source|false
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Source name including namespace |

### Returns

Unregistered `WP_Block_Bindings_Source` on success, `false` if not found.

### Example

```php
add_action( 'init', function() {
    // Remove a source (runs after default priority)
    unregister_block_bindings_source( 'some-plugin/unwanted-source' );
}, 20 );
```

---

## get_all_registered_block_bindings_sources()

Retrieves all registered block bindings sources.

```php
get_all_registered_block_bindings_sources(): WP_Block_Bindings_Source[]
```

### Returns

Array of `WP_Block_Bindings_Source` instances, keyed by source name.

### Example

```php
$sources = get_all_registered_block_bindings_sources();

foreach ( $sources as $name => $source ) {
    printf( "Source: %s (%s)\n", $name, $source->label );
}
```

---

## get_block_bindings_source()

Retrieves a single registered block bindings source.

```php
get_block_bindings_source( string $source_name ): WP_Block_Bindings_Source|null
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_name` | string | Source name |

### Returns

`WP_Block_Bindings_Source` or `null` if not registered.

### Example

```php
$source = get_block_bindings_source( 'core/post-meta' );

if ( $source ) {
    echo $source->label; // "Post Meta"
}
```

---

## get_block_bindings_supported_attributes()

Retrieves block attributes that support block bindings.

```php
get_block_bindings_supported_attributes( string $block_type ): array
```

**Since:** 6.9.0

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$block_type` | string | Block type name (e.g., `core/image`) |

### Returns

Array of attribute names that support bindings for the given block type.

### Default Supported Attributes

| Block Type | Attributes |
|------------|-----------|
| `core/paragraph` | `content` |
| `core/heading` | `content` |
| `core/image` | `id`, `url`, `title`, `alt`, `caption` |
| `core/button` | `url`, `text`, `linkTarget`, `rel` |
| `core/post-date` | `datetime` |
| `core/navigation-link` | `url` |
| `core/navigation-submenu` | `url` |

### Example

```php
$attrs = get_block_bindings_supported_attributes( 'core/image' );
// ['id', 'url', 'title', 'alt', 'caption']

$attrs = get_block_bindings_supported_attributes( 'core/paragraph' );
// ['content']

$attrs = get_block_bindings_supported_attributes( 'my/custom-block' );
// [] (empty unless extended via filter)
```
