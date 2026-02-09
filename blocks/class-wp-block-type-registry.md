# WP_Block_Type_Registry

Core class for interacting with registered block types.

**Since:** 5.0.0  
**Source:** `wp-includes/class-wp-block-type-registry.php`

## Description

`WP_Block_Type_Registry` is a singleton that stores all registered block types. It provides methods to register, unregister, and retrieve block types. Use `register_block_type()` wrapper function for typical registration.

## Properties

### $registered_block_types (private)

Registered block types as `$name => $instance` pairs.

```php
private WP_Block_Type[] $registered_block_types = array()
```

**Since:** 5.0.0

---

### $instance (private static)

Container for the main singleton instance.

```php
private static WP_Block_Type_Registry|null $instance = null
```

**Since:** 5.0.0

---

## Methods

### get_instance()

Utility method to retrieve the main singleton instance.

```php
public static function get_instance(): WP_Block_Type_Registry
```

**Returns:** *(WP_Block_Type_Registry)* - The main instance

**Since:** 5.0.0

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();
$paragraph = $registry->get_registered( 'core/paragraph' );
```

---

### register()

Registers a block type.

```php
public function register(
    string|WP_Block_Type $name,
    array $args = array()
): WP_Block_Type|false
```

**Parameters:**
- `$name` *(string|WP_Block_Type)* - Block type name including namespace, or complete `WP_Block_Type` instance
- `$args` *(array)* - Optional. Block type arguments (ignored if `WP_Block_Type` provided)

**Returns:** *(WP_Block_Type|false)* - Registered block type on success, false on failure

**Since:** 5.0.0

**Validation Rules:**
- Name must be a string
- Name must not contain uppercase characters
- Name must follow pattern: `namespace/block-name`
- Block must not already be registered

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();

// Register by name with args
$result = $registry->register( 'my-plugin/notice', array(
    'title'           => 'Notice',
    'render_callback' => 'render_notice_block',
) );

// Register existing block type instance
$block_type = new WP_Block_Type( 'my-plugin/alert', array(
    'title' => 'Alert',
) );
$result = $registry->register( $block_type );
```

---

### unregister()

Unregisters a block type.

```php
public function unregister( string|WP_Block_Type $name ): WP_Block_Type|false
```

**Parameters:**
- `$name` *(string|WP_Block_Type)* - Block type name or instance

**Returns:** *(WP_Block_Type|false)* - Unregistered block type on success, false on failure

**Since:** 5.0.0

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();

// Unregister by name
$unregistered = $registry->unregister( 'core/legacy-widget' );

// Unregister by instance
$block_type = $registry->get_registered( 'core/archives' );
$registry->unregister( $block_type );
```

---

### get_registered()

Retrieves a registered block type.

```php
public function get_registered( string|null $name ): WP_Block_Type|null
```

**Parameters:**
- `$name` *(string|null)* - Block type name including namespace

**Returns:** *(WP_Block_Type|null)* - Registered block type, or null if not registered

**Since:** 5.0.0

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();

$paragraph = $registry->get_registered( 'core/paragraph' );
if ( $paragraph ) {
    echo $paragraph->title; // "Paragraph"
}

// Check for custom block
$custom = $registry->get_registered( 'my-plugin/custom-block' );
if ( null === $custom ) {
    // Block not registered
}
```

---

### get_all_registered()

Retrieves all registered block types.

```php
public function get_all_registered(): WP_Block_Type[]
```

**Returns:** *(WP_Block_Type[])* - Associative array of `$block_type_name => $block_type` pairs

**Since:** 5.0.0

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();
$all_blocks = $registry->get_all_registered();

// Count registered blocks
echo count( $all_blocks ); // e.g., 150

// Find all dynamic blocks
$dynamic_blocks = array_filter( $all_blocks, function( $block ) {
    return $block->is_dynamic();
} );

// List all block names
$names = array_keys( $all_blocks );
```

---

### is_registered()

Checks if a block type is registered.

```php
public function is_registered( string|null $name ): bool
```

**Parameters:**
- `$name` *(string|null)* - Block type name

**Returns:** *(bool)* - True if registered, false otherwise

**Since:** 5.0.0

**Example:**
```php
$registry = WP_Block_Type_Registry::get_instance();

if ( $registry->is_registered( 'core/paragraph' ) ) {
    // Paragraph block is available
}

if ( ! $registry->is_registered( 'my-plugin/feature' ) ) {
    // Register the block
    $registry->register( 'my-plugin/feature', array( /* ... */ ) );
}
```

---

### __wakeup()

Validates data on unserialization (security).

```php
public function __wakeup(): void
```

**Throws:** `UnexpectedValueException` if data is invalid

**Since:** 5.0.0

---

## Usage Patterns

### Get All Core Blocks

```php
$registry = WP_Block_Type_Registry::get_instance();
$core_blocks = array();

foreach ( $registry->get_all_registered() as $name => $block ) {
    if ( str_starts_with( $name, 'core/' ) ) {
        $core_blocks[ $name ] = $block;
    }
}
```

### Find Blocks with Specific Support

```php
$registry = WP_Block_Type_Registry::get_instance();
$blocks_with_color = array();

foreach ( $registry->get_all_registered() as $name => $block ) {
    if ( isset( $block->supports['color'] ) && $block->supports['color'] ) {
        $blocks_with_color[] = $name;
    }
}
```

### Get Block Categories in Use

```php
$registry = WP_Block_Type_Registry::get_instance();
$categories = array();

foreach ( $registry->get_all_registered() as $block ) {
    if ( $block->category && ! in_array( $block->category, $categories, true ) ) {
        $categories[] = $block->category;
    }
}
```

### Modify Block After Registration

```php
add_action( 'init', function() {
    $registry = WP_Block_Type_Registry::get_instance();
    $paragraph = $registry->get_registered( 'core/paragraph' );
    
    if ( $paragraph ) {
        // Add custom support
        $paragraph->supports['customFeature'] = true;
    }
}, 20 );
```

### Conditional Block Registration

```php
add_action( 'init', function() {
    $registry = WP_Block_Type_Registry::get_instance();
    
    // Only register if dependency exists
    if ( $registry->is_registered( 'core/group' ) ) {
        $registry->register( 'my-plugin/group-variation', array(
            'parent' => array( 'core/group' ),
            // ...
        ) );
    }
} );
```

### List Dynamic vs Static Blocks

```php
$registry = WP_Block_Type_Registry::get_instance();
$all_blocks = $registry->get_all_registered();

$dynamic = array();
$static = array();

foreach ( $all_blocks as $name => $block ) {
    if ( $block->is_dynamic() ) {
        $dynamic[] = $name;
    } else {
        $static[] = $name;
    }
}

// Most core blocks are static (saved in post_content)
// Dynamic blocks render at runtime (e.g., latest-posts, search)
```
