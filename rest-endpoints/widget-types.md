# `/wp/v2/widget-types`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/widget-types`

## Routes

- Collection: `/wp/v2/widget-types`
- Single: `/wp/v2/widget-types/{id}`


## HTTP Methods

Collection methods: GET

Single methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | The widget type id. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | string | Unique slug identifying the widget type. (read-only) |
| `name` | string | Human-readable name identifying the widget type. (read-only) |
| `description` | string | Description of the widget. |
| `is_multi` | boolean | Whether the widget supports multiple instances (read-only) |
| `classname` | string | Class name (read-only) |

## Authentication

- Read: `edit_theme_options`; no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/widget-types"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/widget-types/text"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/widget-types/1" }]
  }
}
```
