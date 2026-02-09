# `/wp/v2/widgets`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/widgets`

## Routes

- Collection: `/wp/v2/widgets`
- Single: `/wp/v2/widgets/{id}`


## HTTP Methods

Collection methods: GET, POST

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `sidebar` | string | false |  | The sidebar to return widgets for. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | Unique identifier for the widget. |
| `id_base` | string | false |  | The type of the widget. Corresponds to ID in widget-types endpoint. |
| `sidebar` | string | true | wp_inactive_widgets | The sidebar the widget belongs to. |
| `instance` | object | false |  | Instance settings of the widget, if supported. |
| `form_data` | string | false |  | URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | string | false |  | Unique identifier for the widget. |
| `id_base` | string | false |  | The type of the widget. Corresponds to ID in widget-types endpoint. |
| `sidebar` | string | false |  | The sidebar the widget belongs to. |
| `instance` | object | false |  | Instance settings of the widget, if supported. |
| `form_data` | string | false |  | URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `force` | boolean | false |  | Whether to force removal of the widget, or move it to the inactive sidebar. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | string | Unique identifier for the widget. |
| `id_base` | string | The type of the widget. Corresponds to ID in widget-types endpoint. |
| `sidebar` | string | The sidebar the widget belongs to. |
| `rendered` | string | HTML representation of the widget. (read-only) |
| `rendered_form` | string | HTML representation of the widget admin form. (read-only) |
| `instance` | object | Instance settings of the widget, if supported. |
| `form_data` | string | URL-encoded form data from the widget admin form. Used to update a widget that does not support instance. Write only. |

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/widgets"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/widgets" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/widgets/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/widgets/1" }]
  }
}
```
