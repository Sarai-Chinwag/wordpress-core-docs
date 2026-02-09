# Blocks API Functions

Public functions for block registration, parsing, rendering, and utilities.

## Block Registration

### register_block_type()

Registers a block type. The recommended way is to register using `block.json` metadata.

```php
register_block_type(
    string|WP_Block_Type $block_type,
    array $args = array()
): WP_Block_Type|false
```

**Parameters:**
- `$block_type` *(string|WP_Block_Type)* - Block type name including namespace (e.g., `my-plugin/my-block`), path to `block.json`, or `WP_Block_Type` instance
- `$args` *(array)* - Optional. Block type arguments (ignored if `WP_Block_Type` provided)

**Returns:** `WP_Block_Type|false` - Registered block type or false on failure

**Since:** 5.0.0  
**Since:** 5.8.0 - First parameter accepts path to `block.json`

**Example:**
```php
// Register from block.json (recommended)
register_block_type( __DIR__ . '/build' );

// Register with inline definition
register_block_type( 'my-plugin/notice', array(
    'api_version'     => 3,
    'title'           => 'Notice',
    'category'        => 'widgets',
    'render_callback' => 'render_notice_block',
    'attributes'      => array(
        'message' => array( 'type' => 'string', 'default' => '' ),
    ),
) );
```

---

### register_block_type_from_metadata()

Registers a block type from the metadata in a `block.json` file.

```php
register_block_type_from_metadata(
    string $file_or_folder,
    array $args = array()
): WP_Block_Type|false
```

**Parameters:**
- `$file_or_folder` *(string)* - Path to `block.json` or folder containing it
- `$args` *(array)* - Optional. Array of block type arguments to merge with metadata

**Returns:** `WP_Block_Type|false` - Registered block type or false on failure

**Since:** 5.5.0  
**Since:** 5.7.0 - Added `textdomain` support and i18n handling  
**Since:** 5.9.0 - Added `variations` and `viewScript` support  
**Since:** 6.1.0 - Added `render` field support  
**Since:** 6.3.0 - Added `selectors` field  
**Since:** 6.4.0 - Added `blockHooks` support  
**Since:** 6.5.0 - Added `allowedBlocks`, `viewScriptModule`, `viewStyle` support

**Example:**
```php
// Register with additional render callback
register_block_type_from_metadata(
    __DIR__ . '/blocks/my-block',
    array(
        'render_callback' => 'my_block_render',
    )
);
```

---

### unregister_block_type()

Unregisters a block type.

```php
unregister_block_type( string|WP_Block_Type $name ): WP_Block_Type|false
```

**Parameters:**
- `$name` *(string|WP_Block_Type)* - Block type name or instance

**Returns:** `WP_Block_Type|false` - Unregistered block type or false on failure

**Since:** 5.0.0

**Example:**
```php
// Remove the core cover block
unregister_block_type( 'core/cover' );
```

---

### wp_register_block_metadata_collection()

Registers a block metadata collection for performance optimization.

```php
wp_register_block_metadata_collection(
    string $path,
    string $manifest
): void
```

**Parameters:**
- `$path` *(string)* - Base path where block files reside
- `$manifest` *(string)* - Path to the manifest file

**Since:** 6.7.0

---

### wp_register_block_types_from_metadata_collection()

Registers all block types from a metadata collection.

```php
wp_register_block_types_from_metadata_collection(
    string $path,
    string $manifest = ''
): void
```

**Parameters:**
- `$path` *(string)* - Absolute base path for the collection
- `$manifest` *(string)* - Optional. Path to manifest file

**Since:** 6.8.0

---

## Block Parsing

### parse_blocks()

Parses blocks out of a content string.

```php
parse_blocks( string $content ): array[]
```

**Parameters:**
- `$content` *(string)* - Post content containing blocks

**Returns:** *(array[])* - Array of parsed block structures

**Since:** 5.0.0

**Return Structure:**
```php
array(
    array(
        'blockName'    => 'core/paragraph',  // or null for freeform
        'attrs'        => array( 'align' => 'center' ),
        'innerBlocks'  => array( ... ),
        'innerHTML'    => '<p class="...">Content</p>',
        'innerContent' => array( 'Content', null, 'More' ),
    ),
    // ...
)
```

**Example:**
```php
$blocks = parse_blocks( $post->post_content );
foreach ( $blocks as $block ) {
    if ( 'core/image' === $block['blockName'] ) {
        $image_id = $block['attrs']['id'] ?? null;
    }
}
```

---

### has_blocks()

Determines whether a post or content string has blocks.

```php
has_blocks( int|string|WP_Post|null $post = null ): bool
```

**Parameters:**
- `$post` *(int|string|WP_Post|null)* - Post content, ID, or object. Defaults to global `$post`

**Returns:** *(bool)* - Whether the post has blocks

**Since:** 5.0.0

**Example:**
```php
if ( has_blocks() ) {
    // Current post uses blocks
}

if ( has_blocks( '<!-- wp:paragraph -->Test<!-- /wp:paragraph -->' ) ) {
    // String contains blocks
}
```

---

### has_block()

Determines whether a post or string contains a specific block type.

```php
has_block( string $block_name, int|string|WP_Post|null $post = null ): bool
```

**Parameters:**
- `$block_name` *(string)* - Full block type name (e.g., `core/paragraph`)
- `$post` *(int|string|WP_Post|null)* - Post content, ID, or object

**Returns:** *(bool)* - Whether the block type exists

**Since:** 5.0.0

**Example:**
```php
if ( has_block( 'core/gallery' ) ) {
    wp_enqueue_style( 'gallery-lightbox' );
}
```

---

## Block Rendering

### render_block()

Renders a single block into HTML.

```php
render_block( array $parsed_block ): string
```

**Parameters:**
- `$parsed_block` *(array)* - Parsed block array (from `parse_blocks()`)

**Returns:** *(string)* - Rendered HTML

**Since:** 5.0.0

**Example:**
```php
$block = array(
    'blockName'    => 'core/paragraph',
    'attrs'        => array( 'align' => 'center' ),
    'innerBlocks'  => array(),
    'innerHTML'    => '<p class="has-text-align-center">Hello</p>',
    'innerContent' => array( '<p class="has-text-align-center">Hello</p>' ),
);
echo render_block( $block );
```

---

### do_blocks()

Parses dynamic blocks and re-renders them.

```php
do_blocks( string $content ): string
```

**Parameters:**
- `$content` *(string)* - Post content

**Returns:** *(string)* - Updated post content with blocks rendered

**Since:** 5.0.0

**Note:** This is hooked to `the_content` filter at priority 9.

---

## Block Serialization

### serialize_block()

Returns the content of a block including comment delimiters.

```php
serialize_block( array $block ): string
```

**Parameters:**
- `$block` *(array)* - Parsed block array

**Returns:** *(string)* - Serialized block markup

**Since:** 5.3.1

**Example:**
```php
$block = array(
    'blockName'    => 'core/paragraph',
    'attrs'        => array(),
    'innerBlocks'  => array(),
    'innerHTML'    => '<p>Hello</p>',
    'innerContent' => array( '<p>Hello</p>' ),
);
echo serialize_block( $block );
// Output: <!-- wp:paragraph --><p>Hello</p><!-- /wp:paragraph -->
```

---

### serialize_blocks()

Returns the aggregate serialization of parsed blocks.

```php
serialize_blocks( array[] $blocks ): string
```

**Parameters:**
- `$blocks` *(array[])* - Array of parsed block structures

**Returns:** *(string)* - Serialized markup

**Since:** 5.3.1

---

### serialize_block_attributes()

Serializes block attributes to JSON format for block comments.

```php
serialize_block_attributes( array $block_attributes ): string
```

**Parameters:**
- `$block_attributes` *(array)* - Attributes object

**Returns:** *(string)* - JSON-encoded string with escaped characters

**Since:** 5.3.1

---

### get_comment_delimited_block_content()

Returns content with block comment delimiters.

```php
get_comment_delimited_block_content(
    string|null $block_name,
    array $block_attributes,
    string $block_content
): string
```

**Parameters:**
- `$block_name` *(string|null)* - Block name (null for classic/freeform)
- `$block_attributes` *(array)* - Block attributes
- `$block_content` *(string)* - Block inner content

**Returns:** *(string)* - Comment-delimited block content

**Since:** 5.3.1

---

### strip_core_block_namespace()

Removes the `core/` namespace prefix from block names.

```php
strip_core_block_namespace( string|null $block_name = null ): string
```

**Parameters:**
- `$block_name` *(string|null)* - Original block name

**Returns:** *(string)* - Block name without `core/` prefix

**Since:** 5.3.1

---

## Block Styles

### register_block_style()

Registers a new block style.

```php
register_block_style(
    string|string[] $block_name,
    array $style_properties
): bool
```

**Parameters:**
- `$block_name` *(string|string[])* - Block type name(s) including namespace
- `$style_properties` *(array)* - Style properties:
  - `name` *(string)* - Style identifier
  - `label` *(string)* - Human-readable label
  - `style_handle` *(string)* - Stylesheet handle to enqueue
  - `inline_style` *(string)* - Inline CSS
  - `style_data` *(array)* - theme.json-like data for CSS generation
  - `is_default` *(bool)* - Whether this is the default style

**Returns:** *(bool)* - True on success

**Since:** 5.3.0  
**Since:** 6.6.0 - Added support for multiple block types

**Example:**
```php
register_block_style( 'core/quote', array(
    'name'         => 'fancy',
    'label'        => 'Fancy Quote',
    'inline_style' => '.is-style-fancy { border-left: 4px solid gold; }',
) );

// Register for multiple blocks
register_block_style(
    array( 'core/paragraph', 'core/heading' ),
    array(
        'name'  => 'gradient-text',
        'label' => 'Gradient Text',
    )
);
```

---

### unregister_block_style()

Unregisters a block style.

```php
unregister_block_style( string $block_name, string $block_style_name ): bool
```

**Parameters:**
- `$block_name` *(string)* - Block type name
- `$block_style_name` *(string)* - Style name

**Returns:** *(bool)* - True on success

**Since:** 5.3.0

---

## Block Support Utilities

### block_has_support()

Checks whether a block type supports a feature.

```php
block_has_support(
    WP_Block_Type $block_type,
    string|array $feature,
    mixed $default_value = false
): bool
```

**Parameters:**
- `$block_type` *(WP_Block_Type)* - Block type to check
- `$feature` *(string|array)* - Feature slug or path
- `$default_value` *(mixed)* - Fallback value

**Returns:** *(bool)* - Whether the feature is supported

**Since:** 5.8.0  
**Since:** 6.4.0 - `$feature` accepts string

**Example:**
```php
$block_type = WP_Block_Type_Registry::get_instance()->get_registered( 'core/paragraph' );

if ( block_has_support( $block_type, 'color' ) ) {
    // Block supports color
}

if ( block_has_support( $block_type, array( 'typography', 'fontSize' ) ) ) {
    // Block supports font size
}
```

---

### get_block_wrapper_attributes()

Generates HTML attributes string for block wrapper.

```php
get_block_wrapper_attributes( string[] $extra_attributes = array() ): string
```

**Parameters:**
- `$extra_attributes` *(string[])* - Extra attributes to merge

**Returns:** *(string)* - HTML attribute string

**Since:** 5.6.0

**Example:**
```php
function render_my_block( $attributes ) {
    $wrapper_attributes = get_block_wrapper_attributes( array(
        'class' => 'my-custom-class',
    ) );
    return sprintf( '<div %s>Content</div>', $wrapper_attributes );
}
```

---

## Block Hooks

### get_hooked_blocks()

Retrieves block types hooked into given blocks.

```php
get_hooked_blocks(): array[]
```

**Returns:** *(array[])* - Hooked blocks grouped by anchor block and position

**Since:** 6.4.0

---

### get_dynamic_block_names()

Returns names of all registered dynamic block types.

```php
get_dynamic_block_names(): string[]
```

**Returns:** *(string[])* - Array of dynamic block names

**Since:** 5.0.0

---

## Block Editor

### get_default_block_categories()

Returns default block categories.

```php
get_default_block_categories(): array[]
```

**Returns:** *(array[])* - Array of category definitions

**Since:** 5.8.0

**Categories:** `text`, `media`, `design`, `widgets`, `theme`, `embed`, `reusable`

---

### get_block_categories()

Returns all block categories for the editor.

```php
get_block_categories( WP_Post|WP_Block_Editor_Context $post_or_context ): array[]
```

**Parameters:**
- `$post_or_context` - Post object or block editor context

**Returns:** *(array[])* - Block categories

**Since:** 5.0.0  
**Since:** 5.8.0 - Accepts `WP_Block_Editor_Context`

---

### get_allowed_block_types()

Gets list of allowed block types for the editor.

```php
get_allowed_block_types( WP_Block_Editor_Context $context ): bool|string[]
```

**Parameters:**
- `$context` *(WP_Block_Editor_Context)* - Editor context

**Returns:** *(bool|string[])* - Array of block slugs, or boolean to enable/disable all

**Since:** 5.8.0

---

### get_block_editor_settings()

Returns contextualized block editor settings.

```php
get_block_editor_settings(
    array $custom_settings,
    WP_Block_Editor_Context $context
): array
```

**Parameters:**
- `$custom_settings` *(array)* - Custom settings to merge
- `$context` *(WP_Block_Editor_Context)* - Editor context

**Returns:** *(array)* - Editor settings

**Since:** 5.8.0

---

## Utility Functions

### block_version()

Returns the block format version of content.

```php
block_version( string $content ): int
```

**Parameters:**
- `$content` *(string)* - Content to test

**Returns:** *(int)* - 1 if content has blocks, 0 otherwise

**Since:** 5.0.0

---

### excerpt_remove_blocks()

Parses blocks and renders only those appropriate for excerpts.

```php
excerpt_remove_blocks( string $content ): string
```

**Parameters:**
- `$content` *(string)* - Content to parse

**Returns:** *(string)* - Filtered content

**Since:** 5.0.0

---

### filter_block_content()

Filters and sanitizes block content to remove non-allowable HTML.

```php
filter_block_content(
    string $text,
    array[]|string $allowed_html = 'post',
    string[] $allowed_protocols = array()
): string
```

**Parameters:**
- `$text` *(string)* - Text with block content
- `$allowed_html` *(array[]|string)* - Allowed HTML or context name
- `$allowed_protocols` *(string[])* - Allowed URL protocols

**Returns:** *(string)* - Filtered content

**Since:** 5.3.1

---

### traverse_and_serialize_blocks()

Traverses parsed blocks and applies callbacks during serialization.

```php
traverse_and_serialize_blocks(
    array[] $blocks,
    callable $pre_callback = null,
    callable $post_callback = null
): string
```

**Parameters:**
- `$blocks` *(array[])* - Parsed blocks
- `$pre_callback` *(callable)* - Called before each block
- `$post_callback` *(callable)* - Called after each block

**Returns:** *(string)* - Serialized markup

**Since:** 6.4.0

---

### resolve_pattern_blocks()

Replaces pattern blocks with their content.

```php
resolve_pattern_blocks( array $blocks ): array
```

**Parameters:**
- `$blocks` *(array)* - Array of blocks

**Returns:** *(array)* - Blocks with patterns resolved

**Since:** 6.6.0

---

## Asset Handling

### generate_block_asset_handle()

Generates handle name for block assets.

```php
generate_block_asset_handle(
    string $block_name,
    string $field_name,
    int $index = 0
): string
```

**Parameters:**
- `$block_name` *(string)* - Block name
- `$field_name` *(string)* - Metadata field (e.g., `editorScript`)
- `$index` *(int)* - Index when multiple items

**Returns:** *(string)* - Asset handle

**Since:** 5.5.0  
**Since:** 6.1.0 - Added `$index` parameter

---

### register_block_script_handle()

Finds and registers a script handle for block metadata.

```php
register_block_script_handle(
    array $metadata,
    string $field_name,
    int $index = 0
): string|false
```

**Parameters:**
- `$metadata` *(array)* - Block metadata
- `$field_name` *(string)* - Field name
- `$index` *(int)* - Script index

**Returns:** *(string|false)* - Script handle or false

**Since:** 5.5.0

---

### register_block_style_handle()

Finds and registers a style handle for block metadata.

```php
register_block_style_handle(
    array $metadata,
    string $field_name,
    int $index = 0
): string|false
```

**Parameters:**
- `$metadata` *(array)* - Block metadata
- `$field_name` *(string)* - Field name
- `$index` *(int)* - Style index

**Returns:** *(string|false)* - Style handle or false

**Since:** 5.5.0

---

### get_block_asset_url()

Gets the URL to a block asset.

```php
get_block_asset_url( string $path ): string|false
```

**Parameters:**
- `$path` *(string)* - Normalized path to asset

**Returns:** *(string|false)* - URL or false

**Since:** 6.4.0

---

## Query Block Helpers

### build_query_vars_from_query_block()

Constructs WP_Query args from Query block properties.

```php
build_query_vars_from_query_block( WP_Block $block, int $page ): array
```

**Parameters:**
- `$block` *(WP_Block)* - Block instance
- `$page` *(int)* - Current page number

**Returns:** *(array)* - WP_Query arguments

**Since:** 5.8.0

---

### get_query_pagination_arrow()

Returns pagination arrow HTML for Query blocks.

```php
get_query_pagination_arrow( WP_Block $block, bool $is_next ): string|null
```

**Parameters:**
- `$block` *(WP_Block)* - Block instance
- `$is_next` *(bool)* - Whether this is the "next" arrow

**Returns:** *(string|null)* - Arrow HTML or null

**Since:** 5.9.0

---

### build_comment_query_vars_from_block()

Constructs comment query vars from block properties.

```php
build_comment_query_vars_from_block( WP_Block $block ): array
```

**Parameters:**
- `$block` *(WP_Block)* - Block instance

**Returns:** *(array)* - WP_Comment_Query parameters

**Since:** 6.0.0
