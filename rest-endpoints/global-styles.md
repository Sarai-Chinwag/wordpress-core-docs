# `/wp/v2/global-styles`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/global-styles`

## Routes

- Collection: `/wp/v2/global-styles`
- Single: `/wp/v2/global-styles/{id}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST, PUT, PATCH


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | The id of a template |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `styles` | object | false |  | Global styles. |
| `settings` | object | false |  | Global settings. |
| `title` | object, string | false |  | Title of the global styles variation. |

## Response Schema (Item)

Schema not available.

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/global-styles"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/global-styles/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/global-styles/1" }]
  }
}
```
