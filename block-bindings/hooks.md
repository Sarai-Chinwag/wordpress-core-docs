# Block Bindings API Hooks

Filters for customizing block bindings behavior.

---

## Filters

### block_bindings_source_value

Filters the output value of a block bindings source.

```php
apply_filters( 
    'block_bindings_source_value', 
    mixed $value, 
    string $name, 
    array $source_args, 
    WP_Block $block_instance, 
    string $attribute_name 
): mixed
```

**Since:** 6.7.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | mixed | Computed value from the source callback |
| `$name` | string | Source name (e.g., `core/post-meta`) |
| `$source_args` | array | Arguments from block binding configuration |
| `$block_instance` | WP_Block | The block being rendered |
| `$attribute_name` | string | Target attribute name |

**Returns:** Modified value.

**Example:**

```php
// Add tracking parameters to all bound URLs
add_filter( 'block_bindings_source_value', function( $value, $name, $args, $block, $attr ) {
    if ( 'url' === $attr && is_string( $value ) && filter_var( $value, FILTER_VALIDATE_URL ) ) {
        return add_query_arg( 'ref', 'block-binding', $value );
    }
    return $value;
}, 10, 5 );
```

**Example:**

```php
// Transform post meta values
add_filter( 'block_bindings_source_value', function( $value, $name, $args, $block, $attr ) {
    if ( 'core/post-meta' !== $name ) {
        return $value;
    }
    
    // Format price fields
    if ( isset( $args['key'] ) && str_ends_with( $args['key'], '_price' ) ) {
        return '$' . number_format( (float) $value, 2 );
    }
    
    return $value;
}, 10, 5 );
```

---

### block_bindings_supported_attributes

Filters supported attributes for block bindings globally.

```php
apply_filters( 
    'block_bindings_supported_attributes', 
    string[] $supported_block_attributes, 
    string $block_type 
): string[]
```

**Since:** 6.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$supported_block_attributes` | string[] | Default supported attributes for the block |
| `$block_type` | string | Block type name |

**Returns:** Modified array of attribute names.

**Example:**

```php
// Add custom attribute support to all blocks
add_filter( 'block_bindings_supported_attributes', function( $attrs, $block_type ) {
    // Add 'className' binding support to all blocks
    if ( ! in_array( 'className', $attrs, true ) ) {
        $attrs[] = 'className';
    }
    return $attrs;
}, 10, 2 );
```

---

### block_bindings_supported_attributes_{$block_type}

Filters supported attributes for a specific block type.

```php
apply_filters( 
    "block_bindings_supported_attributes_{$block_type}", 
    string[] $supported_block_attributes 
): string[]
```

**Since:** 6.9.0

| Parameter | Type | Description |
|-----------|------|-------------|
| `$supported_block_attributes` | string[] | Current supported attributes |

**Returns:** Modified array of attribute names.

**Example:**

```php
// Add 'anchor' support to paragraphs
add_filter( 'block_bindings_supported_attributes_core/paragraph', function( $attrs ) {
    $attrs[] = 'anchor';
    return $attrs;
} );
```

**Example:**

```php
// Add custom block binding support
add_filter( 'block_bindings_supported_attributes_my-plugin/testimonial', function( $attrs ) {
    return array( 'author', 'quote', 'rating', 'avatarUrl' );
} );
```

---

## Built-in Source Registration

Built-in sources are registered during the `init` action at default priority (10).

| Source | Registration Function |
|--------|----------------------|
| `core/post-meta` | `_register_block_bindings_post_meta_source()` |
| `core/pattern-overrides` | `_register_block_bindings_pattern_overrides_source()` |
| `core/post-data` | `_register_block_bindings_post_data_source()` |
| `core/term-data` | `_register_block_bindings_term_data_source()` |

To override or extend built-in sources, use a later priority:

```php
// Modify core source behavior
add_action( 'init', function() {
    // Unregister and re-register with modified callback
    $source = unregister_block_bindings_source( 'core/post-meta' );
    
    if ( $source ) {
        register_block_bindings_source( 'core/post-meta', array(
            'label'              => $source->label,
            'get_value_callback' => 'my_custom_post_meta_callback',
            'uses_context'       => $source->uses_context,
        ) );
    }
}, 20 );
```
