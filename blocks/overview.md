# Blocks API

Framework for registering, parsing, and rendering block-based content in WordPress.

**Since:** 5.0.0  
**Source:** `wp-includes/blocks.php`, `wp-includes/block-editor.php`, `wp-includes/class-wp-block*.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core block registration, parsing, and rendering functions |
| [class-wp-block.md](./class-wp-block.md) | Parsed block instance for rendering |
| [class-wp-block-type.md](./class-wp-block-type.md) | Block type definition with metadata |
| [class-wp-block-type-registry.md](./class-wp-block-type-registry.md) | Block type registry singleton |
| [class-wp-block-parser.md](./class-wp-block-parser.md) | Block content parser |
| [class-wp-block-list.md](./class-wp-block-list.md) | Iterable block collection |
| [class-wp-block-supports.md](./class-wp-block-supports.md) | Block feature support system |
| [class-wp-block-styles-registry.md](./class-wp-block-styles-registry.md) | Block style variations registry |
| [class-wp-block-template.md](./class-wp-block-template.md) | Block template instance |
| [class-wp-block-templates-registry.md](./class-wp-block-templates-registry.md) | Block templates registry |
| [hooks.md](./hooks.md) | Actions and filters |

## Architecture Overview

The Blocks API is the foundation of the WordPress Block Editor (Gutenberg). It provides:

1. **Block Type Registration** - Define block types with attributes, supports, and render callbacks
2. **Block Parsing** - Parse HTML content containing block comment delimiters
3. **Block Rendering** - Convert parsed blocks to final HTML output
4. **Block Supports** - Common features like colors, spacing, typography
5. **Block Styles** - Alternative visual styles for blocks
6. **Block Templates** - Full-page templates built with blocks

## Block Content Format

Blocks are stored as HTML with special comment delimiters:

```html
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Hello World</p>
<!-- /wp:paragraph -->

<!-- wp:image {"id":123} /-->
```

**Void blocks** use self-closing syntax: `<!-- wp:block-name {"attrs"} /-->`

**Container blocks** wrap inner content or other blocks.

## Registration Flow

```
register_block_type()
    ├── File path detected? → register_block_type_from_metadata()
    │                              ├── Load block.json
    │                              ├── Apply 'block_type_metadata' filter
    │                              ├── register_block_script_handle()
    │                              ├── register_block_style_handle()
    │                              ├── Apply 'block_type_metadata_settings' filter
    │                              └── WP_Block_Type_Registry::register()
    │
    └── Block name/type provided → WP_Block_Type_Registry::register()
                                       └── new WP_Block_Type()
                                            ├── Apply 'register_block_type_args' filter
                                            └── Store in registry
```

## Parsing Flow

```
parse_blocks( $content )
    └── WP_Block_Parser::parse()
           ├── Tokenize block delimiters (RegExp)
           ├── Build stack of WP_Block_Parser_Frame
           ├── Handle void-block / block-opener / block-closer
           └── Return array of WP_Block_Parser_Block
                    └── { blockName, attrs, innerBlocks, innerHTML, innerContent }
```

## Rendering Flow

```
do_blocks( $content )
    ├── parse_blocks()
    └── For each top-level block:
            render_block()
                ├── Apply 'pre_render_block' filter (short-circuit)
                ├── Apply 'render_block_data' filter
                ├── Apply 'render_block_context' filter
                ├── new WP_Block( $parsed_block, $context )
                └── WP_Block::render()
                        ├── process_block_bindings()
                        ├── Render inner blocks (recursive)
                        ├── Call render_callback if dynamic
                        ├── Enqueue scripts/styles
                        ├── Apply 'render_block' filter
                        ├── Apply 'render_block_{$name}' filter
                        └── Return HTML string
```

## Block Hooks Flow (Since 6.4.0)

Blocks can hook into other blocks at specific positions:

```
apply_block_hooks_to_content()
    ├── get_hooked_blocks()
    │       └── Collect blocks with block_hooks property
    │
    ├── make_before_block_visitor()
    │       └── Insert 'before' and 'first_child' hooked blocks
    │
    ├── make_after_block_visitor()
    │       └── Insert 'after' and 'last_child' hooked blocks
    │
    └── traverse_and_serialize_blocks()
            └── Apply visitors during serialization
```

## Context System

Blocks can share data with descendants:

```
Parent Block (provides_context)
    │
    ├── context['postId'] = 123
    │
    └── Child Block (uses_context: ['postId'])
            └── $this->context['postId'] === 123
```

## Block Supports

Common features are defined in `block.json` under `supports`:

```json
{
  "supports": {
    "color": { "background": true, "text": true },
    "spacing": { "margin": true, "padding": true },
    "typography": { "fontSize": true, "lineHeight": true },
    "align": ["wide", "full"],
    "html": false
  }
}
```

Supports are processed by files in `wp-includes/block-supports/`:
- `align.php` - Alignment
- `background.php` - Background images
- `border.php` - Border styles
- `colors.php` - Text/background colors
- `dimensions.php` - Min/max height
- `duotone.php` - Duotone filters
- `elements.php` - Link/button styling
- `layout.php` - Layout/flex
- `position.php` - Sticky/fixed position
- `shadow.php` - Box shadows
- `spacing.php` - Margin/padding
- `typography.php` - Font settings

## Key Concepts

### Dynamic Blocks
Blocks with a `render_callback` that generates HTML at runtime:
```php
register_block_type('my/block', [
    'render_callback' => function($attributes, $content, $block) {
        return '<div>' . esc_html($attributes['title']) . '</div>';
    }
]);
```

### Static Blocks
Blocks without `render_callback` that save their HTML directly in post content.

### Block Bindings (Since 6.5.0)
Connect block attributes to external data sources:
```json
{
  "metadata": {
    "bindings": {
      "content": {
        "source": "core/post-meta",
        "args": { "key": "custom_field" }
      }
    }
  }
}
```

### Block Patterns
Reusable block layouts registered with `register_block_pattern()`.

### Block Variations
Alternative configurations of a block type registered via `variations` in block.json.
