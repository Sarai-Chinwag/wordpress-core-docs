# WP_Block_Patterns_Registry

The `WP_Block_Patterns_Registry` class manages all registered block patterns in WordPress. It follows the singleton pattern, providing a centralized registry for pattern storage and retrieval.

**File:** `wp-includes/class-wp-block-patterns-registry.php`  
**Since:** 5.5.0

## Class Synopsis

```php
final class WP_Block_Patterns_Registry {
    // Properties
    private array $registered_patterns = [];
    private array $registered_patterns_outside_init = [];
    private static ?WP_Block_Patterns_Registry $instance = null;

    // Methods
    public function register( string $pattern_name, array $pattern_properties ): bool;
    public function unregister( string $pattern_name ): bool;
    public function get_registered( string $pattern_name ): ?array;
    public function get_all_registered( bool $outside_init_only = false ): array;
    public function is_registered( string $pattern_name ): bool;
    public static function get_instance(): WP_Block_Patterns_Registry;
    
    // Private methods
    private function get_content( string $pattern_name, bool $outside_init_only = false ): string;
}
```

## Properties

### $registered_patterns

```php
private array $registered_patterns = [];
```

Stores all registered block patterns keyed by pattern name.

**Since:** 5.5.0

---

### $registered_patterns_outside_init

```php
private array $registered_patterns_outside_init = [];
```

Stores patterns registered outside the `init` action. Used to detect deprecated registration timing (e.g., during `admin_init` or `current_screen`).

**Since:** 6.0.0

---

### $instance

```php
private static ?WP_Block_Patterns_Registry $instance = null;
```

Container for the singleton instance.

**Since:** 5.5.0

---

## Methods

### get_instance()

Retrieves the singleton instance of the registry.

```php
public static function get_instance(): WP_Block_Patterns_Registry
```

**Returns:** The main `WP_Block_Patterns_Registry` instance.

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();
```

**Since:** 5.5.0

---

### register()

Registers a block pattern.

```php
public function register( string $pattern_name, array $pattern_properties ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string | Block pattern name including namespace |
| `$pattern_properties` | array | Pattern properties (see below) |

**Pattern Properties:**

| Property | Type | Required | Since | Description |
|----------|------|----------|-------|-------------|
| `title` | string | Yes | 5.5.0 | Human-readable pattern title |
| `content` | string | Conditional | 5.5.0 | Block HTML markup |
| `filePath` | string | Conditional | 6.5.0 | Path to PHP file with content |
| `description` | string | No | 5.5.0 | Hidden description for discovery |
| `viewportWidth` | int | No | 5.5.0 | Preview width in inserter |
| `inserter` | bool | No | 5.5.0 | Show in inserter (default: true) |
| `categories` | string[] | No | 5.5.0 | Category slugs |
| `keywords` | string[] | No | 5.5.0 | Search keywords |
| `blockTypes` | string[] | No | 5.8.0 | Associated block types |
| `postTypes` | string[] | No | 6.1.0 | Post type restrictions |
| `templateTypes` | string[] | No | 6.2.0 | Template type associations |

**Returns:** `true` on success, `false` on failure.

**Validation:**
- Pattern name must be a string
- Title must be a string
- Either `content` or `filePath` must be provided

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();

$registry->register(
    'my-plugin/hero',
    array(
        'title'      => 'Hero Section',
        'categories' => array( 'banner' ),
        'content'    => '<!-- wp:cover -->...',
    )
);
```

**Since:** 5.5.0

---

### unregister()

Unregisters a block pattern.

```php
public function unregister( string $pattern_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string | Pattern name to unregister |

**Returns:** `true` on success, `false` if pattern not found.

**Behavior:**
- Removes from both `$registered_patterns` and `$registered_patterns_outside_init`
- Triggers `_doing_it_wrong()` if pattern doesn't exist

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();
$registry->unregister( 'core/query-standard-posts' );
```

**Since:** 5.5.0

---

### get_registered()

Retrieves properties of a registered pattern.

```php
public function get_registered( string $pattern_name ): ?array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string | Pattern name to retrieve |

**Returns:** Pattern properties array, or `null` if not registered.

**Behavior:**
- Resolves `filePath` to actual content if needed
- Processes content through Block Hooks system
- Returns complete pattern with `name` property added

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();
$pattern = $registry->get_registered( 'core/query-grid-posts' );

if ( $pattern ) {
    echo $pattern['title'];   // "Grid"
    echo $pattern['content']; // Block markup
}
```

**Since:** 5.5.0

---

### get_all_registered()

Retrieves all registered patterns.

```php
public function get_all_registered( bool $outside_init_only = false ): array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$outside_init_only` | bool | Return only patterns registered outside `init` |

**Returns:** Indexed array of pattern property arrays.

**Behavior:**
- Resolves all `filePath` patterns to content
- Processes all content through Block Hooks
- Returns array values (not keyed by name)

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();

// Get all patterns
$all_patterns = $registry->get_all_registered();
foreach ( $all_patterns as $pattern ) {
    echo $pattern['name'] . ': ' . $pattern['title'] . "\n";
}

// Get only patterns registered late (debugging)
$late_patterns = $registry->get_all_registered( true );
```

**Since:** 5.5.0

---

### is_registered()

Checks if a pattern is registered.

```php
public function is_registered( ?string $pattern_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string\|null | Pattern name to check |

**Returns:** `true` if registered, `false` otherwise.

**Example:**

```php
$registry = WP_Block_Patterns_Registry::get_instance();

if ( $registry->is_registered( 'core/query-standard-posts' ) ) {
    // Pattern exists
}

if ( ! $registry->is_registered( 'my-plugin/hero' ) ) {
    // Register it
    $registry->register( 'my-plugin/hero', $props );
}
```

**Since:** 5.5.0

---

### get_content() (private)

Retrieves and caches pattern content.

```php
private function get_content( string $pattern_name, bool $outside_init_only = false ): string
```

**Behavior:**
- If pattern has `filePath` but no `content`, includes the file and captures output
- Caches the content in the pattern array
- Removes `filePath` after content is resolved

**Since:** 6.5.0

---

### __wakeup()

Handles unserialization security.

```php
public function __wakeup(): void
```

**Behavior:**
- Validates `$registered_patterns` is an array
- Validates each pattern is an array
- Throws `UnexpectedValueException` on invalid data
- Clears `$registered_patterns_outside_init`

---

## Block Hooks Integration

When retrieving patterns via `get_registered()` or `get_all_registered()`, content is processed through the Block Hooks system:

```php
$pattern['content'] = apply_block_hooks_to_content(
    $content,
    $pattern,
    'insert_hooked_blocks_and_set_ignored_hooked_blocks_metadata'
);
```

This allows hooked blocks to be automatically inserted into pattern content.

---

## Usage Patterns

### Check Before Register

```php
$registry = WP_Block_Patterns_Registry::get_instance();

if ( ! $registry->is_registered( 'my-plugin/hero' ) ) {
    $registry->register( 'my-plugin/hero', array(
        'title'   => 'Hero',
        'content' => '<!-- wp:cover -->...',
    ) );
}
```

### Override Existing Pattern

```php
add_action( 'init', function() {
    $registry = WP_Block_Patterns_Registry::get_instance();
    
    // Unregister and re-register with modifications
    if ( $registry->is_registered( 'theme/hero' ) ) {
        $original = $registry->get_registered( 'theme/hero' );
        $registry->unregister( 'theme/hero' );
        
        $registry->register( 'theme/hero', array_merge(
            $original,
            array( 'categories' => array( 'featured' ) )
        ) );
    }
}, 20 );
```

### List Pattern Names

```php
$registry = WP_Block_Patterns_Registry::get_instance();
$all_patterns = $registry->get_all_registered();

$pattern_names = array_column( $all_patterns, 'name' );
// ['core/query-standard-posts', 'core/query-grid-posts', ...]
```

### Filter Patterns by Category

```php
$registry = WP_Block_Patterns_Registry::get_instance();
$all_patterns = $registry->get_all_registered();

$banner_patterns = array_filter( $all_patterns, function( $pattern ) {
    return isset( $pattern['categories'] ) 
        && in_array( 'banner', $pattern['categories'], true );
});
```

---

## Wrapper Functions

For convenience, use these wrapper functions instead of accessing the registry directly:

```php
// Register pattern
register_block_pattern( $name, $properties );

// Unregister pattern
unregister_block_pattern( $name );
```

See [Pattern Functions](functions.md) for details.

---

## Version History

| Version | Changes |
|---------|---------|
| 5.5.0 | Class introduced |
| 5.8.0 | `blockTypes` property support |
| 6.0.0 | `$registered_patterns_outside_init` tracking |
| 6.1.0 | `postTypes` property support |
| 6.2.0 | `templateTypes` property support |
| 6.5.0 | `filePath` property and `get_content()` method |
