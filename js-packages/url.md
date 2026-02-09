# @wordpress/url

URL utilities for query strings and path handling.

## Key APIs

### `addQueryArgs( url, args )`
Adds/updates query arguments and returns a new URL.

- `url` `string`
- `args` `object` (key → value)

### `getQueryArg( url, arg )`
Returns the value for a specific query arg.

### `getQueryArgs( url )`
Returns an object of all query args.

### `removeQueryArgs( url, ...args )`
Removes specified query args and returns a new URL.

### `isURL( string )`
Checks if a string is a valid URL.
