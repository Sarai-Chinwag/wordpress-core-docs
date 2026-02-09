# `/wp/v2/block-patterns`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/block-patterns`

## Routes

- Collection: `/wp/v2/block-patterns`
- Single: `/wp/v2/block-patterns/{namespace}/{name}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST, PUT, PATCH, DELETE (route-specific)


## Request Parameters

No parameter metadata available.

## Response Schema (Item)

Schema not available.

## Authentication

- Read: public (pattern metadata); no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/block-patterns"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/block-patterns/core/large-header"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/block-patterns/1" }]
  }
}
```
