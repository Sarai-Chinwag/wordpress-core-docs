# @wordpress/block-editor

React components and hooks for building block editor UIs.

## Key APIs

### `useBlockProps( props? )`
Returns props required for block wrapper elements.

- Typically spread onto the block’s root element.
- Accepts additional props (className, style, etc.).

### `InnerBlocks`
Component for nested blocks.

Common props:
- `allowedBlocks` `string[]`
- `template` `Array`
- `templateLock` `'all' | 'insert' | false`
- `renderAppender` `Component | false`

### `RichText`
Editable rich text component.

Common props:
- `tagName` `string`
- `value` `string`
- `onChange( value )`
- `placeholder` `string`
- `allowedFormats` `string[]`
- `multiline` `string | false`

## Frequently Used Components

- `BlockControls`, `InspectorControls`
- `MediaUpload`, `MediaPlaceholder`
- `URLInput`
- `AlignmentToolbar`
- `ColorPalette`
- `PanelColorSettings`
- `ToolbarGroup`, `ToolbarButton`

## Selection & Data Hooks

- `useBlockEditingMode()`
- `useBlockEditContext()`
- `useInnerBlocksProps()`
