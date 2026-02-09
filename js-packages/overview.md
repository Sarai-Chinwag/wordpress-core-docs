# JavaScript Packages

Core `@wordpress/*` JavaScript packages bundled with WordPress.

**Source:** `wp-includes/js/dist/`

## Packages

| Package | Description |
|---------|-------------|
| [blocks.md](./blocks.md) | Block registration and serialization |
| [block-editor.md](./block-editor.md) | Block editor components |
| [components.md](./components.md) | Reusable UI components |
| [data.md](./data.md) | Redux-like data store |
| [element.md](./element.md) | React abstraction layer |
| [hooks.md](./hooks.md) | JavaScript hooks (actions/filters) |
| [api-fetch.md](./api-fetch.md) | REST API client |
| [i18n.md](./i18n.md) | Internationalization |
| [url.md](./url.md) | URL manipulation utilities |
| [dom-ready.md](./dom-ready.md) | DOM ready handler |
| [scripts.md](./scripts.md) | Script loading utilities |

## Usage

```js
import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { Button } from '@wordpress/components';
```

## wp.* Global

All packages are also available on the global `wp` object:

```js
wp.blocks.registerBlockType( ... );
wp.data.select( 'core' ).getCurrentUser();
wp.element.createElement( 'div', null, 'Hello' );
```
