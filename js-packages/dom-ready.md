# @wordpress/dom-ready

Runs a callback when the DOM is ready.

## API

### `domReady( callback )`
Invokes `callback` once the document is ready. Equivalent to `DOMContentLoaded` handling.

```js
import domReady from '@wordpress/dom-ready';

domReady( () => {
  // DOM is ready
} );
```
