# `/wp/v2/sidebars`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/sidebars`

## Routes

- Collection: `/wp/v2/sidebars`
- Single: `/wp/v2/sidebars/{id}`


## HTTP Methods

Collection methods: GET

Single methods: GET, POST, PUT, PATCH


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | The id of a registered sidebar |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `widgets` | array | false |  | Nested widgets. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | string | ID of sidebar. (read-only) |
| `name` | string | Unique name identifying the sidebar. (read-only) |
| `description` | string | Description of sidebar. (read-only) |
| `class` | string | Extra CSS class to assign to the sidebar in the Widgets interface. (read-only) |
| `before_widget` | string | HTML content to prepend to each widget's HTML output when assigned to this sidebar. Default is an opening list item element. (read-only) |
| `after_widget` | string | HTML content to append to each widget's HTML output when assigned to this sidebar. Default is a closing list item element. (read-only) |
| `before_title` | string | HTML content to prepend to the sidebar title when displayed. Default is an opening h2 element. (read-only) |
| `after_title` | string | HTML content to append to the sidebar title when displayed. Default is a closing h2 element. (read-only) |
| `status` | string | Status of sidebar. (read-only) |
| `widgets` | array | Nested widgets. |

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/sidebars"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/sidebars/sidebar-1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/sidebars/1" }]
  }
}
```
