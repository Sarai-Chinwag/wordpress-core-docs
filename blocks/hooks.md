# Blocks API Hooks

Actions and filters for the WordPress Blocks API.

## Block Registration Filters

### register_block_type_args

Filters the arguments for registering a block type.

```php
apply_filters( 'register_block_type_args', array $args, string $block_type )
```

**Parameters:**
- `$args` *(array)* - Block type arguments
- `$block_type` *(string)* - Block type name including namespace

**Since:** 5.5.0

**Example:**
```php
add_filter( 'register_block_type_args', function( $args, $block_type ) {
    // Add custom support to all blocks
    if ( ! isset( $args['supports'] ) ) {
        $args['supports'] = array();
    }
    $args['supports']['customFeature'] = true;
    
    return $args;
}, 10, 2 );
```

---

### block_type_metadata

Filters metadata provided for registering a block type from `block.json`.

```php
apply_filters( 'block_type_metadata', array $metadata )
```

**Parameters:**
- `$metadata` *(array)* - Metadata from `block.json`

**Since:** 5.7.0

**Example:**
```php
add_filter( 'block_type_metadata', function( $metadata ) {
    // Modify metadata before registration
    if ( 'my-plugin/block' === $metadata['name'] ) {
        $metadata['supports']['align'] = array( 'wide', 'full' );
    }
    return $metadata;
} );
```

---

### block_type_metadata_settings

Filters settings determined from block type metadata.

```php
apply_filters( 'block_type_metadata_settings', array $settings, array $metadata )
```

**Parameters:**
- `$settings` *(array)* - Determined settings
- `$metadata` *(array)* - Original metadata

**Since:** 5.7.0

**Example:**
```php
add_filter( 'block_type_metadata_settings', function( $settings, $metadata ) {
    // Add render callback based on metadata
    if ( ! empty( $metadata['render'] ) ) {
        $settings['render_callback'] = 'my_custom_render';
    }
    return $settings;
}, 10, 2 );
```

---

### get_block_type_variations

Filters registered variations for a block type.

```php
apply_filters( 'get_block_type_variations', array $variations, WP_Block_Type $block_type )
```

**Parameters:**
- `$variations` *(array)* - Registered variations
- `$block_type` *(WP_Block_Type)* - Block type object

**Since:** 6.5.0

---

### get_block_type_uses_context

Filters registered uses context for a block type.

```php
apply_filters( 'get_block_type_uses_context', string[] $uses_context, WP_Block_Type $block_type )
```

**Parameters:**
- `$uses_context` *(string[])* - Context keys the block uses
- `$block_type` *(WP_Block_Type)* - Block type object

**Since:** 6.5.0

---

## Block Parsing Filters

### block_parser_class

Filters the block parser class.

```php
apply_filters( 'block_parser_class', string $parser_class )
```

**Parameters:**
- `$parser_class` *(string)* - Parser class name. Default `'WP_Block_Parser'`

**Since:** 5.0.0

**Example:**
```php
add_filter( 'block_parser_class', function() {
    return 'My_Custom_Block_Parser';
} );
```

---

## Block Rendering Filters

### pre_render_block

Allows short-circuiting block rendering.

```php
apply_filters( 'pre_render_block', string|null $pre_render, array $parsed_block, WP_Block|null $parent_block )
```

**Parameters:**
- `$pre_render` *(string|null)* - Pre-rendered content. Return non-null to skip rendering
- `$parsed_block` *(array)* - Parsed block array
- `$parent_block` *(WP_Block|null)* - Parent block if nested

**Since:** 5.1.0  
**Since:** 5.9.0 - Added `$parent_block` parameter

**Example:**
```php
add_filter( 'pre_render_block', function( $pre_render, $block, $parent ) {
    // Replace specific block with custom content
    if ( 'my-plugin/premium-content' === $block['blockName'] ) {
        if ( ! current_user_can( 'access_premium' ) ) {
            return '<p>Premium content - please subscribe</p>';
        }
    }
    return $pre_render;
}, 10, 3 );
```

---

### render_block_data

Filters the block before rendering.

```php
apply_filters( 'render_block_data', array $parsed_block, array $source_block, WP_Block|null $parent_block )
```

**Parameters:**
- `$parsed_block` *(array)* - Block being rendered (modifiable)
- `$source_block` *(array)* - Unmodified copy of block
- `$parent_block` *(WP_Block|null)* - Parent block if nested

**Since:** 5.1.0  
**Since:** 5.9.0 - Added `$parent_block` parameter

**Example:**
```php
add_filter( 'render_block_data', function( $block, $source, $parent ) {
    // Modify block attributes before render
    if ( 'core/paragraph' === $block['blockName'] ) {
        $block['attrs']['className'] = ( $block['attrs']['className'] ?? '' ) . ' custom-class';
    }
    return $block;
}, 10, 3 );
```

---

### render_block_context

Filters the default context provided to a block.

```php
apply_filters( 'render_block_context', array $context, array $parsed_block, WP_Block|null $parent_block )
```

**Parameters:**
- `$context` *(array)* - Default context
- `$parsed_block` *(array)* - Block being rendered
- `$parent_block` *(WP_Block|null)* - Parent block if nested

**Since:** 5.5.0  
**Since:** 5.9.0 - Added `$parent_block` parameter

**Example:**
```php
add_filter( 'render_block_context', function( $context, $block, $parent ) {
    // Add custom context for specific blocks
    if ( 'my-plugin/product' === $block['blockName'] ) {
        $context['productId'] = $block['attrs']['productId'] ?? null;
    }
    return $context;
}, 10, 3 );
```

---

### render_block

Filters the content of a single block.

```php
apply_filters( 'render_block', string $block_content, array $block, WP_Block $instance )
```

**Parameters:**
- `$block_content` *(string)* - Block content HTML
- `$block` *(array)* - Full block including name and attributes
- `$instance` *(WP_Block)* - Block instance

**Since:** 5.0.0  
**Since:** 5.9.0 - Added `$instance` parameter

**Example:**
```php
add_filter( 'render_block', function( $content, $block, $instance ) {
    // Wrap all paragraphs in a container
    if ( 'core/paragraph' === $block['blockName'] ) {
        $content = '<div class="paragraph-wrapper">' . $content . '</div>';
    }
    return $content;
}, 10, 3 );
```

---

### render_block_{$name}

Filters content of a specific block type.

```php
apply_filters( "render_block_{$name}", string $block_content, array $block, WP_Block $instance )
```

**Parameters:** Same as `render_block`

**Since:** 5.7.0  
**Since:** 5.9.0 - Added `$instance` parameter

**Example:**
```php
add_filter( 'render_block_core/image', function( $content, $block, $instance ) {
    // Add lazy loading to all images
    return str_replace( '<img ', '<img loading="lazy" ', $content );
}, 10, 3 );
```

---

## Block Hooks Filters

### hooked_block_types

Filters hooked block types for an anchor block.

```php
apply_filters( 'hooked_block_types', string[] $hooked_block_types, string $relative_position, string $anchor_block_type, WP_Block_Template|WP_Post|array $context )
```

**Parameters:**
- `$hooked_block_types` *(string[])* - List of hooked block types
- `$relative_position` *(string)* - Position: `before`, `after`, `first_child`, `last_child`
- `$anchor_block_type` *(string)* - Anchor block type name
- `$context` - Template, post, or pattern context

**Since:** 6.4.0

**Example:**
```php
add_filter( 'hooked_block_types', function( $hooked, $position, $anchor, $context ) {
    // Add newsletter block after every post content
    if ( 'core/post-content' === $anchor && 'after' === $position ) {
        $hooked[] = 'my-plugin/newsletter-signup';
    }
    return $hooked;
}, 10, 4 );
```

---

### hooked_block

Filters the parsed block array for a hooked block.

```php
apply_filters( 'hooked_block', array|null $parsed_hooked_block, string $hooked_block_type, string $relative_position, array $parsed_anchor_block, WP_Block_Template|WP_Post|array $context )
```

**Parameters:**
- `$parsed_hooked_block` *(array|null)* - Parsed block array, or null to suppress
- `$hooked_block_type` *(string)* - Hooked block type name
- `$relative_position` *(string)* - Position
- `$parsed_anchor_block` *(array)* - Anchor block
- `$context` - Template/post/pattern context

**Since:** 6.5.0

---

### hooked_block_{$hooked_block_type}

Filters a specific hooked block type.

```php
apply_filters( "hooked_block_{$hooked_block_type}", array|null $parsed_hooked_block, string $hooked_block_type, string $relative_position, array $parsed_anchor_block, WP_Block_Template|WP_Post|array $context )
```

**Since:** 6.5.0

---

## Block Editor Filters

### block_categories_all

Filters default array of block categories.

```php
apply_filters( 'block_categories_all', array[] $block_categories, WP_Block_Editor_Context $block_editor_context )
```

**Parameters:**
- `$block_categories` *(array[])* - Array of categories
- `$block_editor_context` *(WP_Block_Editor_Context)* - Editor context

**Since:** 5.8.0

**Example:**
```php
add_filter( 'block_categories_all', function( $categories, $context ) {
    return array_merge( $categories, array(
        array(
            'slug'  => 'my-plugin',
            'title' => __( 'My Plugin', 'my-plugin' ),
            'icon'  => 'star-filled',
        ),
    ) );
}, 10, 2 );
```

---

### allowed_block_types_all

Filters allowed block types for all editor types.

```php
apply_filters( 'allowed_block_types_all', bool|string[] $allowed_block_types, WP_Block_Editor_Context $block_editor_context )
```

**Parameters:**
- `$allowed_block_types` *(bool|string[])* - Array of slugs, or boolean to enable/disable all
- `$block_editor_context` *(WP_Block_Editor_Context)* - Editor context

**Since:** 5.8.0

**Example:**
```php
add_filter( 'allowed_block_types_all', function( $allowed, $context ) {
    // Limit blocks for specific post type
    if ( isset( $context->post ) && 'landing_page' === $context->post->post_type ) {
        return array(
            'core/paragraph',
            'core/heading',
            'core/image',
            'core/button',
        );
    }
    return $allowed;
}, 10, 2 );
```

---

### block_editor_settings_all

Filters block editor settings.

```php
apply_filters( 'block_editor_settings_all', array $editor_settings, WP_Block_Editor_Context $block_editor_context )
```

**Parameters:**
- `$editor_settings` *(array)* - Editor settings
- `$block_editor_context` *(WP_Block_Editor_Context)* - Editor context

**Since:** 5.8.0

**Example:**
```php
add_filter( 'block_editor_settings_all', function( $settings, $context ) {
    // Disable code editing
    $settings['codeEditingEnabled'] = false;
    
    // Add custom settings
    $settings['myPluginSettings'] = array(
        'apiUrl' => rest_url( 'my-plugin/v1/' ),
    );
    
    return $settings;
}, 10, 2 );
```

---

### block_editor_rest_api_preload_paths

Filters REST API paths to preload for the editor.

```php
apply_filters( 'block_editor_rest_api_preload_paths', (string|string[])[] $preload_paths, WP_Block_Editor_Context $block_editor_context )
```

**Since:** 5.8.0

---

## Content Processing Filters

### excerpt_allowed_blocks

Filters blocks that can contribute to excerpt.

```php
apply_filters( 'excerpt_allowed_blocks', string[] $allowed_blocks )
```

**Parameters:**
- `$allowed_blocks` *(string[])* - List of allowed block names

**Since:** 5.0.0

---

### excerpt_allowed_wrapper_blocks

Filters wrapper blocks allowed in excerpts.

```php
apply_filters( 'excerpt_allowed_wrapper_blocks', string[] $allowed_wrapper_blocks )
```

**Since:** 5.8.0

---

### enqueue_empty_block_content_assets

Filters whether to enqueue assets for empty blocks.

```php
apply_filters( 'enqueue_empty_block_content_assets', bool $enqueue, string $block_name )
```

**Parameters:**
- `$enqueue` *(bool)* - Whether to enqueue
- `$block_name` *(string)* - Block name

**Since:** 6.9.0

---

### interactivity_process_directives

Filters whether Interactivity API processes directives.

```php
apply_filters( 'interactivity_process_directives', bool $enabled )
```

**Parameters:**
- `$enabled` *(bool)* - Whether processing is enabled

**Since:** 6.6.0

---

## Query Block Filters

### query_loop_block_query_vars

Filters WP_Query arguments for Query Loop Block.

```php
apply_filters( 'query_loop_block_query_vars', array $query, WP_Block $block, int $page )
```

**Parameters:**
- `$query` *(array)* - WP_Query arguments
- `$block` *(WP_Block)* - Block instance
- `$page` *(int)* - Current page number

**Since:** 6.1.0

**Example:**
```php
add_filter( 'query_loop_block_query_vars', function( $query, $block, $page ) {
    // Only show posts from last 30 days
    $query['date_query'] = array(
        array(
            'after' => '30 days ago',
        ),
    );
    return $query;
}, 10, 3 );
```

---

## Deprecated Hooks

### block_categories (deprecated 5.8.0)

Use `block_categories_all` instead.

### allowed_block_types (deprecated 5.8.0)

Use `allowed_block_types_all` instead.

### block_editor_settings (deprecated 5.8.0)

Use `block_editor_settings_all` instead.

### block_editor_preload_paths (deprecated 5.8.0)

Use `block_editor_rest_api_preload_paths` instead.
