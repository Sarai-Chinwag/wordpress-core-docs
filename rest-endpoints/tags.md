# `/wp/v2/tags`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/tags`

## Routes

- Collection: `/wp/v2/tags`
- Single: `/wp/v2/tags/{id}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the term. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the term. |
| `description` | string | false |  | HTML description of the term. |
| `name` | string | false |  | HTML title for the term. |
| `slug` | string | false |  | An alphanumeric identifier for the term unique to its type. |
| `meta` | object | false |  | Meta fields. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the term. |
| `force` | boolean | false | False | Required to be true, as terms do not support trashing. |

## Response Schema (Item)

Schema not available.

## Authentication

- Read: public.
- Write: `manage_categories`/`edit_terms` for create/update/delete.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/tags"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/tags/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/tags/1" }]
  }
}
```
