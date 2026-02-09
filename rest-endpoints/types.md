# `/wp/v2/types`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/types`

## Routes

- Collection: `/wp/v2/types`
- Single: `/wp/v2/types/{type}`


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
| `type` | string | false |  | An alphanumeric identifier for the post type. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `capabilities` | object | All capabilities used by the post type. (read-only) |
| `description` | string | A human-readable description of the post type. (read-only) |
| `hierarchical` | boolean | Whether or not the post type should have children. (read-only) |
| `viewable` | boolean | Whether or not the post type can be viewed. (read-only) |
| `labels` | object | Human-readable labels for the post type for various contexts. (read-only) |
| `name` | string | The title for the post type. (read-only) |
| `slug` | string | An alphanumeric identifier for the post type. (read-only) |
| `supports` | object | All features, supported by the post type. (read-only) |
| `has_archive` | string, boolean | If the value is a string, the value will be used as the archive slug. If the value is false the post type has no archive. (read-only) |
| `taxonomies` | array | Taxonomies associated with post type. (read-only) |
| `rest_base` | string | REST base route for the post type. (read-only) |
| `rest_namespace` | string | REST route's namespace for the post type. (read-only) |
| `visibility` | object | The visibility settings for the post type. (read-only) |
| `icon` | string, null | The icon for the post type. (read-only) |
| `template` | array | The block template associated with the post type. (read-only) |
| `template_lock` | string, boolean | The template_lock associated with the post type, or false if none. (read-only) |

## Authentication

- Read: public; no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/types"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/types/post"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/types/1" }]
  }
}
```
