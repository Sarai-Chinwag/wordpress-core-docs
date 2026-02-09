# `/wp/v2/blocks`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/blocks`

## Routes

- Collection: `/wp/v2/blocks`
- Single: `/wp/v2/blocks/{id}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `excerpt_length` | integer | false |  | Override the default excerpt length. |
| `password` | string | false |  | The password for the post if it is password protected. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `date` | string, null | false |  | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | false |  | The date the post was published, as GMT. |
| `slug` | string | false |  | An alphanumeric identifier for the post unique to its type. |
| `status` | string | false |  | A named status for the post. |
| `password` | string | false |  | A password to protect access to the content and excerpt. |
| `title` | object | false |  | The title for the post. |
| `content` | object | false |  | The content for the post. |
| `excerpt` | object | false |  | The excerpt for the post. |
| `meta` | object | false |  | Meta fields. |
| `template` | string | false |  | The theme file to use to display the post. |
| `wp_pattern_category` | array | false |  | The terms assigned to the post in the wp_pattern_category taxonomy. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `force` | boolean | false | False | Whether to bypass Trash and force deletion. |

## Response Schema (Item)

Schema not available.

## Authentication

- Read: public for published reusable blocks; `edit_posts` for private.
- Write: `edit_posts` (create/update), `delete_posts` (delete).

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/blocks"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/blocks/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/blocks/1" }]
  }
}
```
