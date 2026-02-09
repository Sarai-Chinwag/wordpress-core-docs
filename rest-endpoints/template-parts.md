# `/wp/v2/template-parts`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/template-parts`

## Routes

- Collection: `/wp/v2/template-parts`
- Single: `/wp/v2/template-parts/{id}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | The id of a template |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | The id of a template |
| `slug` | string | false |  | Unique slug identifying the template. |
| `theme` | string | false |  | Theme identifier for the template. |
| `type` | string | false |  | Type of template. |
| `content` | object, string | false |  | Content of template. |
| `title` | object, string | false |  | Title of template. |
| `description` | string | false |  | Description of template. |
| `status` | string | false |  | Status of template. |
| `author` | integer | false |  | The ID for the author of the template. |
| `area` | string | false |  | Where the template part is intended for use (header, footer, etc.) |

## Response Schema (Item)

Schema not available.

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/template-parts"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/template-parts/twentytwentyfour//header"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/template-parts/1" }]
  }
}
```
