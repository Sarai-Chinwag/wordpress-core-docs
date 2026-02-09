# `/wp/v2/statuses`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/statuses`

## Routes

- Collection: `/wp/v2/statuses`
- Single: `/wp/v2/statuses/{status}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `status` | string | false |  | An alphanumeric identifier for the status. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

## Response Schema (Item)

Schema not available.

## Authentication

- Read: public; no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/statuses"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/statuses/publish"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/statuses/1" }]
  }
}
```
