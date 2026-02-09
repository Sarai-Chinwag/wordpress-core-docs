# WP_Block_Bindings_Source

Represents a registered block bindings source.

**Source:** `wp-includes/class-wp-block-bindings-source.php`  
**Since:** 6.5.0  
**Access:** private (internal use by registry)

## Overview

This class is created internally by `WP_Block_Bindings_Registry::register()`. Do not instantiate directly; use `register_block_bindings_source()` instead.

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$name` | string | public | Source name (e.g., `core/post-meta`) |
| `$label` | string | public | Human-readable label |
| `$get_value_callback` | callable | private | Callback to retrieve values |
| `$uses_context` | string[]\|null | public | Required block context keys |

---

## Methods

### __construct()

Creates a new source instance.

```php
public function __construct( string $name, array $source_properties )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$name` | string | Source name |
| `$source_properties` | array | Configuration properties |

**Note:** Do not use directly. Use `register_block_bindings_source()` or `WP_Block_Bindings_Registry::register()`.

**Example (internal usage):**

```php
$source = new WP_Block_Bindings_Source( 'my-plugin/data', array(
    'label'              => 'My Data',
    'get_value_callback' => 'my_callback_function',
    'uses_context'       => array( 'postId' ),
) );
```

---

### get_value()

Retrieves a value from the source for a given block attribute.

```php
public function get_value( array $source_args, WP_Block $block_instance, string $attribute_name ): mixed
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$source_args` | array | Arguments from block's binding configuration |
| `$block_instance` | WP_Block | The block being rendered |
| `$attribute_name` | string | Target attribute name |

**Returns:** The computed value for the source (filtered by `block_bindings_source_value`).

**Process:**

1. Calls `$get_value_callback` with provided arguments
2. Applies `block_bindings_source_value` filter (since 6.7.0)
3. Returns filtered value

**Example:**

```php
$source = get_block_bindings_source( 'core/post-meta' );

$value = $source->get_value(
    array( 'key' => 'custom_field' ),
    $block_instance,
    'content'
);
```

---

### __wakeup()

Prevents unserialization (security hardening).

```php
public function __wakeup(): void
```

**Throws:** `LogicException` — sources should never be unserialized.

---

## Usage Context

The `uses_context` property declares which block context values the source needs. When a source is used, WordPress ensures these context values are available to the block.

### Common Context Keys

| Context Key | Description |
|-------------|-------------|
| `postId` | Current post ID |
| `postType` | Current post type |
| `termId` | Current term ID (6.9.0+) |
| `taxonomy` | Current taxonomy (6.9.0+) |
| `pattern/overrides` | Pattern override data |

### Example

```php
register_block_bindings_source( 'my-plugin/related-post', array(
    'label'              => 'Related Post',
    'get_value_callback' => function( $args, $block, $attr ) {
        $post_id = $block->context['postId'] ?? null;
        if ( ! $post_id ) {
            return null;
        }
        // Use post_id to find related content
        return get_related_post_title( $post_id );
    },
    'uses_context' => array( 'postId', 'postType' ),
) );
```
