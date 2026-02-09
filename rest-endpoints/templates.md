# `/wp/v2/templates`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/templates`

## Routes

- Collection: `/wp/v2/templates`
- Single: `/wp/v2/templates/{id}`


## HTTP Methods

Collection methods: GET, POST

Single methods: GET, POST


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `wp_id` | integer | false |  | Limit to the specified post id. |
| `area` | string | false |  | Limit to the specified template part area. |
| `post_type` | string | false |  | Post type to get the templates for. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `slug` | string | true |  | Unique slug identifying the template. |
| `theme` | string | false |  | Theme identifier for the template. |
| `type` | string | false |  | Type of template. |
| `content` | object, string | false |  | Content of template. |
| `title` | object, string | false |  | Title of template. |
| `description` | string | false |  | Description of template. |
| `status` | string | false | publish | Status of template. |
| `author` | integer | false |  | The ID for the author of the template. |

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

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | string | ID of template. (read-only) |
| `slug` | string | Unique slug identifying the template. |
| `theme` | string | Theme identifier for the template. |
| `type` | string | Type of template. |
| `source` | string | Source of template (read-only) |
| `origin` | string | Source of a customized template (read-only) |
| `content` | object, string | Content of template. |
| `title` | object, string | Title of template. |
| `description` | string | Description of template. |
| `status` | string | Status of template. |
| `wp_id` | integer | Post ID. (read-only) |
| `has_theme_file` | bool | Theme file exists. (read-only) |
| `author` | integer | The ID for the author of the template. |
| `modified` | string | The date the template was last modified, in the site's timezone. (read-only) |
| `author_text` | string | Human readable text for the author. (read-only) |
| `original_source` | string | Where the template originally comes from e.g. 'theme' (read-only) |
| `is_custom` | bool | Whether a template is a custom template. (read-only) |
| `plugin` | string | Plugin that registered the template. (read-only) |

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/templates"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/templates" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/templates/twentytwentyfour//index"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/templates/1" }]
  }
}
```
