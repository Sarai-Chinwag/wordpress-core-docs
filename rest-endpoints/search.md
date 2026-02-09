# `/wp/v2/search`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/search`

## Routes

- Collection: `/wp/v2/search`


## HTTP Methods

Collection methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `page` | integer | false | 1 | Current page of the collection. |
| `per_page` | integer | false | 10 | Maximum number of items to be returned in result set. |
| `search` | string | false |  | Limit results to those matching a string. |
| `type` | string | false | post | Limit results to items of an object type. |
| `subtype` | array | false | any | Limit results to items of one or more object subtypes. |
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | integer, string | Unique identifier for the object. (read-only) |
| `title` | string | The title for the object. (read-only) |
| `url` | string | URL to the object. (read-only) |
| `type` | string | Object type. (read-only) |
| `subtype` | string | Object subtype. (read-only) |

## Authentication

- Read: public.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/search"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/search/1" }]
  }
}
```
