# `/wp/v2/menus`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/menus`

## Routes

- Collection: `/wp/v2/menus`
- Single: `/wp/v2/menus/{id}`


## HTTP Methods

Collection methods: GET, POST

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `page` | integer | false | 1 | Current page of the collection. |
| `per_page` | integer | false | 10 | Maximum number of items to be returned in result set. |
| `search` | string | false |  | Limit results to those matching a string. |
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | asc | Order sort attribute ascending or descending. |
| `orderby` | string | false | name | Sort collection by term attribute. |
| `hide_empty` | boolean | false | False | Whether to hide terms not assigned to any posts. |
| `post` | integer | false | None | Limit result set to terms assigned to a specific post. |
| `slug` | array | false |  | Limit result set to terms with one or more specific slugs. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `description` | string | false |  | HTML description of the term. |
| `name` | string | true |  | HTML title for the term. |
| `slug` | string | false |  | An alphanumeric identifier for the term unique to its type. |
| `meta` | object | false |  | Meta fields. |
| `locations` | array | false |  | The locations assigned to the menu. |
| `auto_add` | boolean | false |  | Whether to automatically add top level pages to this menu. |

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
| `locations` | array | false |  | The locations assigned to the menu. |
| `auto_add` | boolean | false |  | Whether to automatically add top level pages to this menu. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the term. |
| `force` | boolean | false | False | Required to be true, as terms do not support trashing. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | integer | Unique identifier for the term. (read-only) |
| `description` | string | HTML description of the term. |
| `name` | string | HTML title for the term. |
| `slug` | string | An alphanumeric identifier for the term unique to its type. |
| `meta` | object | Meta fields. |
| `locations` | array | The locations assigned to the menu. |
| `auto_add` | boolean | Whether to automatically add top level pages to this menu. |

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menus"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/menus" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menus/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/menus/1" }]
  }
}
```
