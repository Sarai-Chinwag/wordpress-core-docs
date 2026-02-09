# Block Patterns Hooks

Filters and actions for customizing block pattern behavior.

## Filters

### should_load_remote_block_patterns

Controls whether patterns are loaded from the WordPress.org Pattern Directory.

```php
apply_filters( 'should_load_remote_block_patterns', bool $should_load_remote ): bool
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$should_load_remote` | bool | Whether to load remote patterns (default: true) |

**Returns:** Whether to proceed with loading remote patterns.

**Used By:**
- `_load_remote_block_patterns()` - Core patterns from Pattern Directory
- `_load_remote_featured_patterns()` - Featured patterns
- `_register_remote_theme_patterns()` - Theme-referenced patterns

**Example - Disable Remote Patterns:**

```php
// Completely disable Pattern Directory integration
add_filter( 'should_load_remote_block_patterns', '__return_false' );
```

**Example - Conditional Loading:**

```php
add_filter( 'should_load_remote_block_patterns', function( $should_load ) {
    // Disable on multisite subsites
    if ( is_multisite() && ! is_main_site() ) {
        return false;
    }
    
    // Disable if site has custom patterns defined
    if ( get_option( 'my_custom_patterns_enabled' ) ) {
        return false;
    }
    
    return $should_load;
} );
```

**Example - Performance Optimization:**

```php
// Disable remote patterns in development
add_filter( 'should_load_remote_block_patterns', function( $should_load ) {
    return ! defined( 'WP_DEBUG' ) || ! WP_DEBUG;
} );
```

**Since:** 5.8.0

---

### theme_block_pattern_files

Filters the list of pattern files found in a theme's `patterns/` directory.

```php
apply_filters( 'theme_block_pattern_files', array $files, string $dirpath ): array
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$files` | array | Array of pattern filenames |
| `$dirpath` | string | Path to patterns directory |

**Returns:** Modified array of pattern filenames.

**Location:** `WP_Theme::get_block_patterns()`

**Example - Exclude Patterns:**

```php
add_filter( 'theme_block_pattern_files', function( $files, $dirpath ) {
    // Exclude specific patterns
    $exclude = array( 'deprecated-hero.php', 'old-footer.php' );
    
    return array_diff( $files, $exclude );
}, 10, 2 );
```

**Example - Add Dynamic Patterns:**

```php
add_filter( 'theme_block_pattern_files', function( $files, $dirpath ) {
    // Add patterns from a custom location
    $custom_dir = get_stylesheet_directory() . '/custom-patterns/';
    
    if ( is_dir( $custom_dir ) ) {
        $custom_files = glob( $custom_dir . '*.php' );
        $files = array_merge( $files, $custom_files );
    }
    
    return $files;
}, 10, 2 );
```

**Since:** 6.4.0

---

### wp_theme_files_cache_ttl

Controls the cache duration for theme pattern files.

```php
apply_filters( 'wp_theme_files_cache_ttl', int $expiration, string $cache_type ): int
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$expiration` | int | Cache expiration in seconds (default: 1800 / 30 minutes) |
| `$cache_type` | string | Type of cache (e.g., 'theme_block_patterns') |

**Returns:** Modified cache expiration in seconds.

**Location:** `WP_Theme::get_block_patterns()`

**Example - Extend Cache:**

```php
add_filter( 'wp_theme_files_cache_ttl', function( $expiration, $cache_type ) {
    if ( 'theme_block_patterns' === $cache_type ) {
        // Cache patterns for 1 hour in production
        return HOUR_IN_SECONDS;
    }
    return $expiration;
}, 10, 2 );
```

**Example - Disable Cache During Development:**

```php
add_filter( 'wp_theme_files_cache_ttl', function( $expiration, $cache_type ) {
    if ( 'theme_block_patterns' === $cache_type && WP_DEBUG ) {
        return 0; // No caching
    }
    return $expiration;
}, 10, 2 );
```

**Since:** 6.4.0

---

## Actions

### init

Patterns should be registered during the `init` action.

```php
add_action( 'init', 'my_register_patterns' );

function my_register_patterns() {
    register_block_pattern( 'my-plugin/hero', array(
        'title'   => 'Hero',
        'content' => '<!-- wp:cover -->...',
    ) );
    
    register_block_pattern_category( 'my-layouts', array(
        'label' => 'My Layouts',
    ) );
}
```

**Priority Considerations:**
- Default priority (10): Standard registration
- Priority 5-9: Register before theme patterns
- Priority 11+: Modify/remove existing patterns

**Example - Remove Core Pattern:**

```php
// Use priority > 10 to run after core registration
add_action( 'init', function() {
    unregister_block_pattern( 'core/query-standard-posts' );
}, 20 );
```

---

## Theme Support

### core-block-patterns

Controls whether core block patterns are registered.

```php
// Enable core patterns (default)
add_theme_support( 'core-block-patterns' );

// Disable core patterns
remove_theme_support( 'core-block-patterns' );
```

**Affects:**
- Core query patterns (`query-standard-posts`, `query-grid-posts`, etc.)
- Remote patterns from Pattern Directory (requires this support)

**Example - Theme Setup:**

```php
add_action( 'after_setup_theme', function() {
    // Disable core patterns - using only custom patterns
    remove_theme_support( 'core-block-patterns' );
} );
```

---

## REST API Hooks

Patterns are exposed via the REST API at `/wp/v2/block-patterns/patterns`.

### rest_pre_dispatch

Filter REST requests for patterns.

```php
add_filter( 'rest_pre_dispatch', function( $result, $server, $request ) {
    if ( strpos( $request->get_route(), '/wp/v2/block-patterns' ) === 0 ) {
        // Log pattern requests
        error_log( 'Pattern request: ' . $request->get_route() );
    }
    return $result;
}, 10, 3 );
```

---

## Block Hooks Integration

Pattern content is processed through the Block Hooks system when retrieved.

### hooked_block_types

Filter blocks that get hooked into pattern content.

```php
add_filter( 'hooked_block_types', function( $hooked_blocks, $position, $anchor_block, $context ) {
    // $context contains pattern data when processing patterns
    if ( isset( $context['name'] ) && str_starts_with( $context['name'], 'my-plugin/' ) ) {
        // Add a block after headings in my plugin's patterns
        if ( 'after' === $position && 'core/heading' === $anchor_block ) {
            $hooked_blocks[] = 'my-plugin/cta-button';
        }
    }
    return $hooked_blocks;
}, 10, 4 );
```

---

## Common Patterns

### Disable All Remote Patterns

```php
// In theme's functions.php or plugin
add_filter( 'should_load_remote_block_patterns', '__return_false' );
```

### Register Patterns from Custom Directory

```php
add_action( 'init', function() {
    $pattern_dir = plugin_dir_path( __FILE__ ) . 'patterns/';
    
    foreach ( glob( $pattern_dir . '*.php' ) as $file ) {
        $pattern = require $file;
        $slug = 'my-plugin/' . basename( $file, '.php' );
        
        if ( ! WP_Block_Patterns_Registry::get_instance()->is_registered( $slug ) ) {
            register_block_pattern( $slug, $pattern );
        }
    }
} );
```

### Modify Existing Pattern

```php
add_action( 'init', function() {
    $registry = WP_Block_Patterns_Registry::get_instance();
    
    // Get existing pattern
    $pattern = $registry->get_registered( 'theme/hero' );
    
    if ( $pattern ) {
        // Unregister and modify
        $registry->unregister( 'theme/hero' );
        
        // Add custom category
        $pattern['categories'][] = 'my-featured';
        
        // Re-register
        $registry->register( 'theme/hero', $pattern );
    }
}, 20 );
```

### Conditional Pattern Registration

```php
add_action( 'init', function() {
    // Only register WooCommerce patterns if WooCommerce is active
    if ( class_exists( 'WooCommerce' ) ) {
        register_block_pattern( 'my-plugin/product-grid', array(
            'title'     => 'Product Grid',
            'postTypes' => array( 'product' ),
            'content'   => '<!-- wp:woocommerce/product-collection -->...',
        ) );
    }
    
    // Only register for specific user roles
    if ( current_user_can( 'manage_options' ) ) {
        register_block_pattern( 'my-plugin/admin-only', array(
            'title'   => 'Admin Dashboard',
            'content' => '...',
        ) );
    }
} );
```

---

## Debugging

### List All Registered Patterns

```php
add_action( 'admin_init', function() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    
    $patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();
    
    error_log( 'Registered patterns: ' . count( $patterns ) );
    foreach ( $patterns as $pattern ) {
        error_log( sprintf(
            '  %s (%s) - Categories: %s',
            $pattern['name'],
            $pattern['title'],
            implode( ', ', $pattern['categories'] ?? array( 'none' ) )
        ) );
    }
} );
```

### Check Late Registrations

```php
add_action( 'admin_init', function() {
    $late = WP_Block_Patterns_Registry::get_instance()->get_all_registered( true );
    
    if ( ! empty( $late ) ) {
        error_log( 'Patterns registered outside init: ' . count( $late ) );
        foreach ( $late as $pattern ) {
            error_log( '  - ' . $pattern['name'] );
        }
    }
} );
```

---

## Version History

| Version | Hook | Change |
|---------|------|--------|
| 5.5.0 | `core-block-patterns` theme support | Introduced |
| 5.8.0 | `should_load_remote_block_patterns` | Introduced |
| 6.4.0 | `theme_block_pattern_files` | Introduced |
| 6.4.0 | `wp_theme_files_cache_ttl` | Added pattern cache context |
