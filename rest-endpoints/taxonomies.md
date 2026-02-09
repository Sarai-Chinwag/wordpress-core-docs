# `/wp/v2/taxonomies`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/taxonomies`

## Routes

- Collection: `/wp/v2/taxonomies`
- Single: `/wp/v2/taxonomies/{taxonomy}`


## HTTP Methods

Collection methods: GET

Single methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `type` | string | false |  | Limit results to taxonomies associated with a specific post type. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `taxonomy` | string | false |  | An alphanumeric identifier for the taxonomy. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `capabilities` | object | All capabilities used by the taxonomy. (read-only) |
| `description` | string | A human-readable description of the taxonomy. (read-only) |
| `hierarchical` | boolean | Whether or not the taxonomy should have children. (read-only) |
| `labels` | object | Human-readable labels for the taxonomy for various contexts. (read-only) |
| `name` | string | The title for the taxonomy. (read-only) |
| `slug` | string | An alphanumeric identifier for the taxonomy. (read-only) |
| `show_cloud` | boolean | Whether or not the term cloud should be displayed. (read-only) |
| `types` | array | Types associated with the taxonomy. (read-only) |
| `rest_base` | string | REST base route for the taxonomy. (read-only) |
| `rest_namespace` | string | REST namespace route for the taxonomy. (read-only) |
| `visibility` | object | The visibility settings for the taxonomy. (read-only) |

## Authentication

- Read: public; no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/taxonomies"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/taxonomies/category"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/taxonomies/1" }]
  }
}
```
