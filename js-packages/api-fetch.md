# @wordpress/api-fetch

HTTP client for WordPress REST API with middleware support.

## `apiFetch( options )`
Performs a request and returns a Promise.

`options` fields:
- `path` (REST path, e.g. `/wp/v2/posts`)
- `url` (absolute URL override)
- `method` (`GET`, `POST`, etc.)
- `data` (request body for non-GET)
- `headers`
- `parse` (default `true`, parse JSON)
- `signal` (AbortController signal)

## Middleware

### `apiFetch.use( middleware )`
Registers middleware. Middleware receives `( options, next )`.

### Common middleware helpers

- `createNonceMiddleware( nonce )`
- `createRootURLMiddleware( rootUrl )`
- `createPreloadingMiddleware( preloadedData )`
- `createUserLocaleMiddleware()`

## Error Handling

Errors include `code`, `message`, and `data` when returned by the REST API.
