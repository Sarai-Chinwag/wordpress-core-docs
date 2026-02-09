# Block Development

Guides for developing custom WordPress blocks.

**Source:** Various block-related files in `wp-includes/`

## Topics

| Topic | Description |
|-------|-------------|
| [block-json-schema.md](./block-json-schema.md) | block.json schema and fields |
| [attributes.md](./attributes.md) | Block attributes system |
| [supports.md](./supports.md) | Block supports (color, spacing, etc.) |
| [context.md](./context.md) | Block context passing |
| [inner-blocks.md](./inner-blocks.md) | Nested block support |
| [variations.md](./variations.md) | Block variations |
| [transforms.md](./transforms.md) | Block transforms |
| [deprecations.md](./deprecations.md) | Block deprecations |
| [dynamic-blocks.md](./dynamic-blocks.md) | Server-rendered blocks |
| [bindings.md](./bindings.md) | Block bindings API |
| [styles.md](./styles.md) | Block styles |
| [scripts-styles.md](./scripts-styles.md) | Block asset loading |
| [hooks.md](./hooks.md) | Block development hooks |

## Quick Reference

### Registration
```php
register_block_type( __DIR__ . '/build' );
register_block_type_from_metadata( __DIR__ );
```

### Key Functions
- `register_block_type()` - Register a block type
- `register_block_style()` - Register block style variation
- `register_block_pattern()` - Register block pattern
