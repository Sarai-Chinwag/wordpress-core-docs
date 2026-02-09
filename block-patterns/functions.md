# Block Pattern Functions

WordPress provides wrapper functions for registering and managing block patterns and pattern categories.

## Pattern Functions

### register_block_pattern()

Registers a new block pattern.

```php
register_block_pattern( string $pattern_name, array $pattern_properties ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string | Block pattern name including namespace |
| `$pattern_properties` | array | List of pattern properties |

**Pattern Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `title` | string | Yes | Human-readable title |
| `content` | string | Yes* | Block HTML markup |
| `filePath` | string | Yes* | Path to PHP file containing content |
| `description` | string | No | Hidden description for search |
| `viewportWidth` | int | No | Preview width in inserter |
| `inserter` | bool | No | Show in inserter (default: true) |
| `categories` | string[] | No | Category slugs |
| `keywords` | string[] | No | Search keywords |
| `blockTypes` | string[] | No | Associated block types |
| `postTypes` | string[] | No | Restrict to post types |
| `templateTypes` | string[] | No | Template type associations |

*Either `content` or `filePath` is required, not both.

**Returns:** `true` on success, `false` on failure.

**Example:**

```php
add_action( 'init', function() {
    register_block_pattern(
        'my-plugin/hero-section',
        array(
            'title'       => __( 'Hero Section', 'my-plugin' ),
            'description' => __( 'A full-width hero with heading and CTA.', 'my-plugin' ),
            'categories'  => array( 'banner', 'featured' ),
            'keywords'    => array( 'hero', 'header', 'intro', 'cta' ),
            'blockTypes'  => array( 'core/post-content' ),
            'content'     => '<!-- wp:cover {"overlayColor":"primary"} -->
                <div class="wp-block-cover">
                    <div class="wp-block-cover__inner-container">
                        <!-- wp:heading {"level":1} -->
                        <h1>Welcome to Our Site</h1>
                        <!-- /wp:heading -->
                        <!-- wp:buttons -->
                        <div class="wp-block-buttons">
                            <!-- wp:button -->
                            <div class="wp-block-button">
                                <a class="wp-block-button__link">Get Started</a>
                            </div>
                            <!-- /wp:button -->
                        </div>
                        <!-- /wp:buttons -->
                    </div>
                </div>
                <!-- /wp:cover -->',
        )
    );
});
```

**Example with filePath:**

```php
register_block_pattern(
    'my-plugin/complex-layout',
    array(
        'title'    => __( 'Complex Layout', 'my-plugin' ),
        'filePath' => __DIR__ . '/patterns/complex-layout.php',
    )
);
```

**Since:** 5.5.0

---

### unregister_block_pattern()

Unregisters a block pattern.

```php
unregister_block_pattern( string $pattern_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern_name` | string | Block pattern name including namespace |

**Returns:** `true` on success, `false` if pattern not found.

**Example:**

```php
add_action( 'init', function() {
    // Remove a core pattern
    unregister_block_pattern( 'core/query-standard-posts' );
    
    // Remove a theme pattern
    unregister_block_pattern( 'theme-slug/unwanted-pattern' );
}, 20 ); // Priority 20 to run after pattern registration
```

**Since:** 5.5.0

---

## Category Functions

### register_block_pattern_category()

Registers a new pattern category.

```php
register_block_pattern_category( string $category_name, array $category_properties ): bool
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

**Example:**

```php
add_action( 'init', function() {
    register_block_pattern_category(
        'my-plugin-layouts',
        array(
            'label'       => __( 'My Plugin Layouts', 'my-plugin' ),
            'description' => __( 'Custom layouts from My Plugin.', 'my-plugin' ),
        )
    );
});
```

**Since:** 5.5.0

---

### unregister_block_pattern_category()

Unregisters a pattern category.

```php
unregister_block_pattern_category( string $category_name ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$category_name` | string | Category slug |

**Returns:** `true` on success, `false` if category not found.

**Example:**

```php
add_action( 'init', function() {
    // Remove unused core category
    unregister_block_pattern_category( 'testimonials' );
}, 20 );
```

**Since:** 5.5.0

---

## Internal Functions

These functions are used internally by WordPress and prefixed with underscore.

### _register_core_block_patterns_and_categories()

Registers core block patterns and all default categories.

```php
_register_core_block_patterns_and_categories(): void
```

**Behavior:**
- Checks for `core-block-patterns` theme support
- Registers query patterns (standard, medium, small, grid, large-title, offset)
- Registers all core categories (banner, buttons, columns, etc.)
- Adds `source => 'core'` to each pattern

**Since:** 5.5.0, 6.3.0 (added source)

---

### _register_theme_block_patterns()

Registers patterns from the active theme's `patterns/` directory.

```php
_register_theme_block_patterns(): void
```

**Behavior:**
- Scans theme's `patterns/` directory for PHP files
- Parses file headers for pattern metadata
- Child theme patterns override parent theme patterns with same slug
- Translates title and description using theme's text domain
- Hooked to `init` action

**Since:** 6.0.0

---

### _load_remote_block_patterns()

Loads core-tagged patterns from wordpress.org Pattern Directory.

```php
_load_remote_block_patterns( WP_Screen $deprecated = null ): void
```

**Behavior:**
- Requires `core-block-patterns` theme support
- Respects `should_load_remote_block_patterns` filter
- Fetches patterns with keyword ID 11 (core)
- Sets source to `pattern-directory/core`

**Since:** 5.8.0

---

### _load_remote_featured_patterns()

Loads featured patterns from wordpress.org Pattern Directory.

```php
_load_remote_featured_patterns(): void
```

**Behavior:**
- Fetches patterns from category ID 26 (Featured)
- Skips already-registered patterns
- Sets source to `pattern-directory/featured`

**Since:** 5.9.0

---

### _register_remote_theme_patterns()

Registers patterns referenced in theme.json from Pattern Directory.

```php
_register_remote_theme_patterns(): void
```

**Behavior:**
- Requires theme.json with patterns array
- Fetches patterns by slug
- Sets source to `pattern-directory/theme`

**Since:** 6.0.0

---

### wp_normalize_remote_block_pattern()

Converts Pattern Directory API response to camelCase format.

```php
wp_normalize_remote_block_pattern( array $pattern ): array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$pattern` | array | Pattern from Pattern Directory API |

**Returns:** Normalized pattern array.

**Conversions:**
- `block_types` → `blockTypes`
- `viewport_width` → `viewportWidth`

**Since:** 6.2.0

---

## Registry Access

For direct registry access, use the singleton instances:

```php
// Patterns registry
$patterns_registry = WP_Block_Patterns_Registry::get_instance();

// Categories registry  
$categories_registry = WP_Block_Pattern_Categories_Registry::get_instance();
```

See [WP_Block_Patterns_Registry](class-wp-block-patterns-registry.md) and [WP_Block_Pattern_Categories_Registry](class-wp-block-pattern-categories-registry.md) for registry methods.

---

## Common Patterns

### Registering Multiple Patterns

```php
add_action( 'init', function() {
    $patterns = array(
        'hero'    => array(
            'title'      => __( 'Hero', 'my-plugin' ),
            'categories' => array( 'banner' ),
            'filePath'   => __DIR__ . '/patterns/hero.php',
        ),
        'pricing' => array(
            'title'      => __( 'Pricing Table', 'my-plugin' ),
            'categories' => array( 'columns' ),
            'filePath'   => __DIR__ . '/patterns/pricing.php',
        ),
    );
    
    foreach ( $patterns as $slug => $props ) {
        register_block_pattern( "my-plugin/{$slug}", $props );
    }
});
```

### Post Type Restriction

```php
register_block_pattern(
    'my-plugin/product-showcase',
    array(
        'title'     => __( 'Product Showcase', 'my-plugin' ),
        'postTypes' => array( 'product' ), // Only available for products
        'content'   => '<!-- wp:columns -->...',
    )
);
```

### Template-Specific Pattern

```php
register_block_pattern(
    'my-theme/404-content',
    array(
        'title'         => __( '404 Content', 'my-theme' ),
        'templateTypes' => array( '404' ),
        'content'       => '<!-- wp:heading -->...',
    )
);
```

### Hidden Pattern (Programmatic Only)

```php
register_block_pattern(
    'my-plugin/internal-layout',
    array(
        'title'    => __( 'Internal Layout', 'my-plugin' ),
        'inserter' => false, // Hidden from inserter
        'content'  => '<!-- wp:group -->...',
    )
);
```

---

## Version History

| Version | Function Changes |
|---------|-----------------|
| 5.5.0 | All base functions introduced |
| 5.8.0 | `_load_remote_block_patterns()` added |
| 5.9.0 | `_load_remote_featured_patterns()` added |
| 6.0.0 | `_register_theme_block_patterns()`, `_register_remote_theme_patterns()` added |
| 6.2.0 | `wp_normalize_remote_block_pattern()` added |
| 6.3.0 | Source tracking added to internal functions |
