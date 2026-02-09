# WP_Block_Pattern_Categories_Registry

The `WP_Block_Pattern_Categories_Registry` class manages pattern categories that organize block patterns in the inserter. Like its pattern counterpart, it implements the singleton pattern.

**File:** `wp-includes/class-wp-block-pattern-categories-registry.php`  
**Since:** 5.5.0

## Class Synopsis

```php
final class WP_Block_Pattern_Categories_Registry {
    // Properties
    private array $registered_categories = [];
    private array $registered_categories_outside_init = [];
    private static ?WP_Block_Pattern_Categories_Registry $instance = null;

    // Methods
    public function register( string $category_name, array $category_properties ): bool;
    public function unregister( string $category_name ): bool;
    public function get_registered( string $category_name ): ?array;
    public function get_all_registered( bool $outside_init_only = false ): array;
    public function is_registered( string $category_name ): bool;
    public static function get_instance(): WP_Block_Pattern_Categories_Registry;
}
```

## Properties

### $registered_categories

```php
private array $registered_categories = [];
```

Stores all registered pattern categories keyed by category slug.

**Since:** 5.5.0

---

### $registered_categories_outside_init

```php
private array $registered_categories_outside_init = [];
```

Stores categories registered outside the `init` action. Used to detect deprecated registration timing.

**Since:** 6.0.0

---

### $instance

```php
private static ?WP_Block_Pattern_Categories_Registry $instance = null;
```

Container for the singleton instance.

**Since:** 5.5.0

---

## Methods

### get_instance()

Retrieves the singleton instance of the category registry.

```php
public static function get_instance(): WP_Block_Pattern_Categories_Registry
```

**Returns:** The main `WP_Block_Pattern_Categories_Registry` instance.

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();
```

**Since:** 5.5.0

---

### register()

Registers a pattern category.

```php
public function register( string $category_name, array $category_properties ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$category_name` | string | Category slug |
| `$category_properties` | array | Category properties |

**Category Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `label` | string | Yes | Human-readable category name |
| `description` | string | No | Category description |

**Returns:** `true` on success, `false` on failure.

**Validation:**
- Category name must be a string
- No validation on label (but should be provided)

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();

$registry->register(
    'my-plugin-layouts',
    array(
        'label'       => __( 'My Plugin Layouts', 'my-plugin' ),
        'description' => __( 'Custom block layouts.', 'my-plugin' ),
    )
);
```

**Since:** 5.5.0

---

### unregister()

Unregisters a pattern category.

```php
public function unregister( string $category_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$category_name` | string | Category slug to unregister |

**Returns:** `true` on success, `false` if category not found.

**Behavior:**
- Removes from both `$registered_categories` and `$registered_categories_outside_init`
- Triggers `_doing_it_wrong()` if category doesn't exist
- Does NOT automatically unregister patterns using this category

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();
$registry->unregister( 'testimonials' );
```

**Since:** 5.5.0

---

### get_registered()

Retrieves properties of a registered category.

```php
public function get_registered( string $category_name ): ?array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$category_name` | string | Category slug |

**Returns:** Category properties array with `name` included, or `null` if not registered.

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();
$category = $registry->get_registered( 'banner' );

if ( $category ) {
    echo $category['label'];       // "Banners"
    echo $category['description']; // "Bold sections designed to showcase key content."
    echo $category['name'];        // "banner"
}
```

**Since:** 5.5.0

---

### get_all_registered()

Retrieves all registered categories.

```php
public function get_all_registered( bool $outside_init_only = false ): array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$outside_init_only` | bool | Return only categories registered outside `init` |

**Returns:** Indexed array of category property arrays.

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();

// Get all categories
$all_categories = $registry->get_all_registered();
foreach ( $all_categories as $category ) {
    echo $category['name'] . ': ' . $category['label'] . "\n";
}

// Example output:
// banner: Banners
// buttons: Buttons
// columns: Columns
// ...
```

**Since:** 5.5.0

---

### is_registered()

Checks if a category is registered.

```php
public function is_registered( ?string $category_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$category_name` | string\|null | Category slug to check |

**Returns:** `true` if registered, `false` otherwise.

**Example:**

```php
$registry = WP_Block_Pattern_Categories_Registry::get_instance();

if ( ! $registry->is_registered( 'my-layouts' ) ) {
    $registry->register( 'my-layouts', array(
        'label' => 'My Layouts'
    ) );
}
```

**Since:** 5.5.0

---

## Core Categories

WordPress registers these categories by default via `_register_core_block_patterns_and_categories()`:

| Slug | Label | Description |
|------|-------|-------------|
| `banner` | Banners | Bold sections designed to showcase key content |
| `buttons` | Buttons | Patterns that contain buttons and call to actions |
| `columns` | Columns | Multi-column patterns with more complex layouts |
| `text` | Text | Patterns containing mostly text |
| `query` | Posts | Display your latest posts in lists, grids or other layouts |
| `featured` | Featured | A set of high quality curated patterns |
| `call-to-action` | Call to action | Sections whose purpose is to trigger a specific action |
| `team` | Team | A variety of designs to display your team members |
| `testimonials` | Testimonials | Share reviews and feedback about your brand/business |
| `services` | Services | Briefly describe what your business does |
| `contact` | Contact | Display your contact information |
| `about` | About | Introduce yourself |
| `portfolio` | Portfolio | Showcase your latest work |
| `gallery` | Gallery | Different layouts for displaying images |
| `media` | Media | Different layouts containing video or audio |
| `videos` | Videos | Different layouts containing videos |
| `audio` | Audio | Different layouts containing audio |
| `posts` | Posts | Display your latest posts |
| `footer` | Footers | Footer designs with information and navigation |
| `header` | Headers | Header designs with site title and navigation |

---

## Usage Patterns

### Register Category Before Patterns

```php
add_action( 'init', function() {
    // Register category first
    register_block_pattern_category( 'my-layouts', array(
        'label' => 'My Layouts',
    ) );
    
    // Then register patterns using it
    register_block_pattern( 'my-plugin/hero', array(
        'title'      => 'Hero',
        'categories' => array( 'my-layouts' ),
        'content'    => '...',
    ) );
} );
```

### List All Categories with Pattern Counts

```php
$patterns_registry = WP_Block_Patterns_Registry::get_instance();
$categories_registry = WP_Block_Pattern_Categories_Registry::get_instance();

$all_patterns = $patterns_registry->get_all_registered();
$all_categories = $categories_registry->get_all_registered();

foreach ( $all_categories as $category ) {
    $count = count( array_filter( $all_patterns, function( $p ) use ( $category ) {
        return isset( $p['categories'] ) 
            && in_array( $category['name'], $p['categories'], true );
    } ) );
    
    echo "{$category['label']}: {$count} patterns\n";
}
```

### Remove Unused Categories

```php
add_action( 'init', function() {
    $registry = WP_Block_Pattern_Categories_Registry::get_instance();
    
    // Remove categories not used by your site
    $unused = array( 'testimonials', 'team', 'portfolio', 'audio' );
    
    foreach ( $unused as $category ) {
        if ( $registry->is_registered( $category ) ) {
            $registry->unregister( $category );
        }
    }
}, 20 );
```

### Rename a Category

```php
add_action( 'init', function() {
    $registry = WP_Block_Pattern_Categories_Registry::get_instance();
    
    // Unregister original
    $registry->unregister( 'call-to-action' );
    
    // Re-register with new label
    $registry->register( 'call-to-action', array(
        'label'       => __( 'CTAs', 'my-theme' ),
        'description' => __( 'Conversion sections.', 'my-theme' ),
    ) );
}, 20 );
```

---

## Wrapper Functions

For convenience, use these wrapper functions:

```php
// Register category
register_block_pattern_category( $name, $properties );

// Unregister category
unregister_block_pattern_category( $name );
```

See [Pattern Functions](functions.md) for details.

---

## Comparison with Patterns Registry

| Feature | Patterns Registry | Categories Registry |
|---------|------------------|---------------------|
| Required properties | `title`, `content`/`filePath` | `label` |
| Namespace convention | `plugin/pattern-name` | Simple slug |
| Content processing | Block Hooks integration | None |
| Lazy loading | Via `filePath` | N/A |
| Core defaults | 6 query patterns | 20 categories |

---

## Version History

| Version | Changes |
|---------|---------|
| 5.5.0 | Class introduced |
| 6.0.0 | `$registered_categories_outside_init` tracking |
