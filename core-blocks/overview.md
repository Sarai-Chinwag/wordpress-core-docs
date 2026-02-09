# Core Blocks

WordPress core blocks shipped with every installation.

**Source:** `wp-includes/blocks/*/block.json`  
**Total:** 106 blocks

## Blocks by Category

| Category | Count | Description |
|----------|-------|-------------|
| [text](./text-blocks.md) | 14 | Content blocks (paragraph, heading, list, etc.) |
| [media](./media-blocks.md) | 7 | Images, video, audio, galleries |
| [design](./design-blocks.md) | 17 | Layout and structure (columns, group, buttons) |
| [widgets](./widgets-blocks.md) | 16 | Dynamic content (archives, search, RSS) |
| [theme](./theme-blocks.md) | 48 | Site structure (query loop, navigation, post content) |
| [embed](./embed-blocks.md) | 1 | External content embeds |
| [reusable](./reusable-blocks.md) | 1 | Pattern/reusable block |

## Block Registration

Core blocks are registered via:
```php
register_block_type( 'core/paragraph', array( ... ) );
```

Or from block.json:
```php
register_block_type( __DIR__ . '/paragraph/block.json' );
```

## Common Block Properties

All blocks define in block.json:

| Property | Type | Description |
|----------|------|-------------|
| `$schema` | string | JSON schema URL |
| `apiVersion` | int | Block API version (currently 3) |
| `name` | string | Block identifier (e.g., `core/paragraph`) |
| `title` | string | Human-readable name |
| `category` | string | Block category |
| `description` | string | Block description |
| `textdomain` | string | Translation domain |
| `attributes` | object | Block attributes schema |
| `supports` | object | Editor features |
| `styles` | array | Block style variations |
| `example` | object | Preview example |
| `render` | string | PHP render file |
| `viewScript` | string/array | Frontend JavaScript |
| `editorScript` | string/array | Editor JavaScript |
| `style` | string/array | Frontend CSS |
| `editorStyle` | string/array | Editor CSS |
