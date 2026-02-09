# Block Template Hooks

## Template Query Hooks

### pre_get_block_templates

Filters templates before the database query, allowing complete bypass of WordPress queries.

```php
apply_filters( 
    'pre_get_block_templates', 
    ?WP_Block_Template[] $block_templates, 
    array $query, 
    string $template_type 
)
```

**Parameters:**
- `$block_templates` - Return array to short-circuit, or `null` to run normal query
- `$query` - Query arguments (`slug__in`, `wp_id`, `area`, `post_type`)
- `$template_type` - `'wp_template'` or `'wp_template_part'`

**Example:**
```php
add_filter( 'pre_get_block_templates', function( $templates, $query, $type ) {
    // Return cached templates for specific slugs
    if ( isset( $query['slug__in'] ) && in_array( 'single', $query['slug__in'] ) ) {
        return get_transient( 'my_cached_templates' );
    }
    return null; // Let WordPress handle it
}, 10, 3 );
```

---

### get_block_templates

Filters the array of queried block templates after they've been fetched.

```php
apply_filters( 
    'get_block_templates', 
    WP_Block_Template[] $query_result, 
    array $query, 
    string $template_type 
)
```

**Example:**
```php
add_filter( 'get_block_templates', function( $templates, $query, $type ) {
    // Remove templates from specific sources
    return array_filter( $templates, function( $template ) {
        return 'plugin' !== $template->source;
    } );
}, 10, 3 );
```

---

### pre_get_block_template

Filters a single block template before the query.

```php
apply_filters( 
    'pre_get_block_template', 
    ?WP_Block_Template $block_template, 
    string $id, 
    string $template_type 
)
```

**Parameters:**
- `$block_template` - Return template to short-circuit, or `null` for normal query
- `$id` - Template ID (e.g., `theme_slug//template_slug`)
- `$template_type` - `'wp_template'` or `'wp_template_part'`

**Example:**
```php
add_filter( 'pre_get_block_template', function( $template, $id, $type ) {
    // Inject a custom template for a specific ID
    if ( 'my-theme//custom-landing' === $id ) {
        $template = new WP_Block_Template();
        $template->id = $id;
        $template->slug = 'custom-landing';
        $template->content = '<!-- wp:paragraph --><p>Custom content</p><!-- /wp:paragraph -->';
        return $template;
    }
    return null;
}, 10, 3 );
```

---

### get_block_template

Filters a single block template after it's been fetched.

```php
apply_filters( 
    'get_block_template', 
    ?WP_Block_Template $block_template, 
    string $id, 
    string $template_type 
)
```

---

### pre_get_block_file_template

Filters block template before theme file discovery.

```php
apply_filters( 
    'pre_get_block_file_template', 
    ?WP_Block_Template $block_template, 
    string $id, 
    string $template_type 
)
```

---

### get_block_file_template

Filters block template after potential theme file fetch.

```php
apply_filters( 
    'get_block_file_template', 
    ?WP_Block_Template $block_template, 
    string $id, 
    string $template_type 
)
```

---

## Template Part Area Hooks

### default_wp_template_part_areas

Filters the list of allowed template part area values.

```php
apply_filters( 'default_wp_template_part_areas', array[] $default_area_definitions )
```

**Default Areas:**
- `uncategorized` - General templates
- `header` - Site header
- `footer` - Site footer

**Example - Add Custom Area:**
```php
add_filter( 'default_wp_template_part_areas', function( $areas ) {
    $areas[] = array(
        'area'        => 'sidebar',
        'label'       => __( 'Sidebar', 'my-theme' ),
        'description' => __( 'Sidebar template parts.', 'my-theme' ),
        'icon'        => 'sidebar',
        'area_tag'    => 'aside',
    );
    return $areas;
} );
```

---

## Template Type Hooks

### default_template_types

Filters the list of default template types with their titles and descriptions.

```php
apply_filters( 'default_template_types', array[] $default_template_types )
```

**Example - Add Custom Template Type:**
```php
add_filter( 'default_template_types', function( $types ) {
    $types['product'] = array(
        'title'       => __( 'Product', 'my-plugin' ),
        'description' => __( 'Displays a single product.', 'my-plugin' ),
    );
    return $types;
} );
```

---

## Template Hierarchy Hooks

These filters mirror the classic template hierarchy filters:

### {$type}_template_hierarchy

Filters the template hierarchy for a specific template type.

```php
// For index template
apply_filters( 'index_template_hierarchy', array( 'index' ) )

// For page template  
apply_filters( 'page_template_hierarchy', array $template_hierarchy )

// For single template
apply_filters( 'single_template_hierarchy', array $template_hierarchy )

// For archive template
apply_filters( 'archive_template_hierarchy', array $template_hierarchy )

// For frontpage template
apply_filters( 'frontpage_template_hierarchy', array $template_hierarchy )

// For home template
apply_filters( 'home_template_hierarchy', array $template_hierarchy )

// For 404 template
apply_filters( '404_template_hierarchy', array $template_hierarchy )

// For search template
apply_filters( 'search_template_hierarchy', array $template_hierarchy )

// For category template
apply_filters( 'category_template_hierarchy', array $template_hierarchy )

// For tag template
apply_filters( 'tag_template_hierarchy', array $template_hierarchy )

// For taxonomy template
apply_filters( 'taxonomy_template_hierarchy', array $template_hierarchy )

// For author template
apply_filters( 'author_template_hierarchy', array $template_hierarchy )

// For date template
apply_filters( 'date_template_hierarchy', array $template_hierarchy )

// For attachment template
apply_filters( 'attachment_template_hierarchy', array $template_hierarchy )

// For singular template
apply_filters( 'singular_template_hierarchy', array $template_hierarchy )

// For embed template
apply_filters( 'embed_template_hierarchy', array $template_hierarchy )

// For paged template
apply_filters( 'paged_template_hierarchy', array $template_hierarchy )

// For privacy policy template
apply_filters( 'privacypolicy_template_hierarchy', array $template_hierarchy )
```

**Example:**
```php
add_filter( 'single_template_hierarchy', function( $templates ) {
    // Add custom single template before default
    array_unshift( $templates, 'single-custom' );
    return $templates;
} );
```

---

## Navigation Fallback Hooks

### wp_navigation_should_create_fallback

Controls whether a fallback navigation should be automatically created.

```php
apply_filters( 'wp_navigation_should_create_fallback', bool $create )
```

**Default:** `true`

**Example:**
```php
// Disable automatic navigation creation
add_filter( 'wp_navigation_should_create_fallback', '__return_false' );
```

---

## REST API Schema Hook

### rest_wp_navigation_item_schema

Filters the `wp_navigation` post type REST API schema.

```php
apply_filters( 'rest_wp_navigation_item_schema', array $schema )
```

Used by `WP_Navigation_Fallback::update_wp_navigation_post_schema()` to expose additional fields for embedded navigation responses.

---

## Common Hook Patterns

### Add Plugin Templates

```php
add_filter( 'get_block_templates', function( $templates, $query, $type ) {
    if ( 'wp_template' !== $type ) {
        return $templates;
    }

    // Add a plugin-provided template
    $plugin_template = new WP_Block_Template();
    $plugin_template->id = 'my-plugin//landing-page';
    $plugin_template->theme = get_stylesheet();
    $plugin_template->slug = 'landing-page';
    $plugin_template->source = 'plugin';
    $plugin_template->title = 'Landing Page';
    $plugin_template->content = file_get_contents( __DIR__ . '/templates/landing-page.html' );
    $plugin_template->type = 'wp_template';
    $plugin_template->status = 'publish';
    $plugin_template->has_theme_file = false;
    $plugin_template->is_custom = true;

    $templates[] = $plugin_template;
    return $templates;
}, 10, 3 );
```

### Override Template Content

```php
add_filter( 'get_block_template', function( $template, $id, $type ) {
    if ( 'my-theme//single' === $id ) {
        // Inject additional blocks
        $template->content = '<!-- wp:my-plugin/banner /-->' . $template->content;
    }
    return $template;
}, 10, 3 );
```

### Register Custom Template Part Area

```php
add_filter( 'default_wp_template_part_areas', function( $areas ) {
    $areas[] = array(
        'area'        => 'hero',
        'label'       => __( 'Hero', 'my-theme' ),
        'description' => __( 'Hero section at the top of pages.', 'my-theme' ),
        'icon'        => 'cover-image',
        'area_tag'    => 'section',
    );
    return $areas;
} );
```

### Cache Template Queries

```php
add_filter( 'pre_get_block_templates', function( $templates, $query, $type ) {
    $cache_key = 'block_templates_' . md5( serialize( $query ) . $type );
    $cached = wp_cache_get( $cache_key, 'themes' );
    
    if ( false !== $cached ) {
        return $cached;
    }
    
    return null; // Let WordPress query
}, 10, 3 );

add_filter( 'get_block_templates', function( $templates, $query, $type ) {
    $cache_key = 'block_templates_' . md5( serialize( $query ) . $type );
    wp_cache_set( $cache_key, $templates, 'themes', HOUR_IN_SECONDS );
    return $templates;
}, 10, 3 );
```
