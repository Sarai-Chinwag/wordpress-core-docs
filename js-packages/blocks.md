# @wordpress/blocks

Block registration and serialization utilities.

## Key APIs

### `registerBlockType( name, settings )`
Registers a block type.

- `name` `string` (namespace/block)
- `settings` `object`
  - `title`, `description`, `category`, `icon`, `keywords`
  - `attributes`: attribute schema
  - `supports`: support flags
  - `edit`, `save`
  - `transforms`

### `unregisterBlockType( name )`
Removes a previously registered block.

### `getBlockType( name )` / `getBlockTypes()`
Get registered block definitions.

### `createBlock( name, attributes?, innerBlocks? )`
Creates a block object.

### `parse( html )` / `serialize( blocks )`
Convert between block objects and block HTML.

## Attributes

Attributes define how block data is stored and parsed.

```js
attributes: {
  content: {
    type: 'string',
    source: 'html',
    selector: 'p',
    default: '',
  },
  align: { type: 'string' },
}
```

Common fields:
- `type`: `string | number | boolean | object | array`
- `source`: `attribute | html | text | children | query | meta`
- `selector`, `attribute`, `meta`, `default`

## Transforms

Define how blocks convert to/from other blocks.

```js
transforms: {
  from: [
    { type: 'block', blocks: [ 'core/paragraph' ], transform: ( attrs ) => ... },
    { type: 'raw', selector: 'p', transform: ( node ) => ... },
  ],
  to: [
    { type: 'block', blocks: [ 'core/heading' ], transform: ( attrs ) => ... },
  ],
}
```

Transform types:
- `block` (block-to-block)
- `raw` (HTML → block)
- `shortcode` (shortcode → block)
- `prefix` (typed prefix → block)
