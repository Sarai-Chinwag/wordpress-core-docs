# `/wp/v2/categories`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/categories`

## Routes

- Collection: `/wp/v2/categories`
- Single: `/wp/v2/categories/{id}`


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
| `order` | string | false | asc | Order sort attribute ascending or descending. |
| `orderby` | string | false | name | Sort collection by term attribute. |
| `hide_empty` | boolean | false | False | Whether to hide terms not assigned to any posts. |
| `parent` | integer | false |  | Limit result set to terms assigned to a specific parent. |
| `post` | integer | false | None | Limit result set to terms assigned to a specific post. |
| `slug` | array | false |  | Limit result set to terms with one or more specific slugs. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `description` | string | false |  | HTML description of the term. |
| `name` | string | true |  | HTML title for the term. |
| `slug` | string | false |  | An alphanumeric identifier for the term unique to its type. |
| `parent` | integer | false |  | The parent term ID. |
| `meta` | object | false |  | Meta fields. |

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
| `parent` | integer | false |  | The parent term ID. |
| `meta` | object | false |  | Meta fields. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the term. |
| `force` | boolean | false | False | Required to be true, as terms do not support trashing. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | integer | Unique identifier for the term. (read-only) |
| `count` | integer | Number of published posts for the term. (read-only) |
| `description` | string | HTML description of the term. |
| `link` | string | URL of the term. (read-only) |
| `name` | string | HTML title for the term. |
| `slug` | string | An alphanumeric identifier for the term unique to its type. |
| `taxonomy` | string | Type attribution for the term. (read-only) |
| `parent` | integer | The parent term ID. |
| `meta` | object | Meta fields. |

## Authentication

- Read: public.
- Write: `manage_categories`/`edit_terms` for create/update/delete.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/categories"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/categories" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/categories/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/categories/1" }]
  }
}
```
