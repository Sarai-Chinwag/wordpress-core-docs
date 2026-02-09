# `/wp/v2/comments`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/comments`

## Routes

- Collection: `/wp/v2/comments`
- Single: `/wp/v2/comments/{id}`


## HTTP Methods

Collection methods: GET, POST, GET, POST

Single methods: GET, POST, PUT, PATCH, DELETE, GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `page` | integer | false | 1 | Current page of the collection. |
| `per_page` | integer | false | 10 | Maximum number of items to be returned in result set. |
| `search` | string | false |  | Limit results to those matching a string. |
| `after` | string | false |  | Limit response to comments published after a given ISO8601 compliant date. |
| `author` | array | false |  | Limit result set to comments assigned to specific user IDs. Requires authorization. |
| `author_exclude` | array | false |  | Ensure result set excludes comments assigned to specific user IDs. Requires authorization. |
| `author_email` | string | false | None | Limit result set to that from a specific author email. Requires authorization. |
| `before` | string | false |  | Limit response to comments published before a given ISO8601 compliant date. |
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | desc | Order sort attribute ascending or descending. |
| `orderby` | string | false | date_gmt | Sort collection by comment attribute. |
| `parent` | array | false | [] | Limit result set to comments of specific parent IDs. |
| `parent_exclude` | array | false | [] | Ensure result set excludes specific parent IDs. |
| `post` | array | false | [] | Limit result set to comments assigned to specific post IDs. |
| `status` | string | false | approve | Limit result set to comments assigned a specific status. Requires authorization. |
| `type` | string | false | comment | Limit result set to comments assigned a specific type. Requires authorization. |
| `password` | string | false |  | The password for the post if it is password protected. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `author` | integer | false |  | The ID of the user object, if author was a user. |
| `author_email` | string | false |  | Email address for the comment author. |
| `author_ip` | string | false |  | IP address for the comment author. |
| `author_name` | string | false |  | Display name for the comment author. |
| `author_url` | string | false |  | URL for the comment author. |
| `author_user_agent` | string | false |  | User agent for the comment author. |
| `content` | object | false |  | The content for the comment. |
| `date` | string | false |  | The date the comment was published, in the site's timezone. |
| `date_gmt` | string | false |  | The date the comment was published, as GMT. |
| `parent` | integer | false | 0 | The ID for the parent of the comment. |
| `post` | integer | false | 0 | The ID of the associated post object. |
| `status` | string | false |  | State of the comment. |
| `meta` | object | false |  | Meta fields. |

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `page` | integer | false | 1 | Current page of the collection. |
| `per_page` | integer | false | 10 | Maximum number of items to be returned in result set. |
| `search` | string | false |  | Limit results to those matching a string. |
| `after` | string | false |  | Limit response to comments published after a given ISO8601 compliant date. |
| `author` | array | false |  | Limit result set to comments assigned to specific user IDs. Requires authorization. |
| `author_exclude` | array | false |  | Ensure result set excludes comments assigned to specific user IDs. Requires authorization. |
| `author_email` | string | false | None | Limit result set to that from a specific author email. Requires authorization. |
| `before` | string | false |  | Limit response to comments published before a given ISO8601 compliant date. |
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | desc | Order sort attribute ascending or descending. |
| `orderby` | string | false | date_gmt | Sort collection by comment attribute. |
| `parent` | array | false | [] | Limit result set to comments of specific parent IDs. |
| `parent_exclude` | array | false | [] | Ensure result set excludes specific parent IDs. |
| `post` | array | false | [] | Limit result set to comments assigned to specific post IDs. |
| `status` | string | false | approve | Limit result set to comments assigned a specific status. Requires authorization. |
| `type` | string | false | comment | Limit result set to comments assigned a specific type. Requires authorization. |
| `password` | string | false |  | The password for the post if it is password protected. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `author` | integer | false |  | The ID of the user object, if author was a user. |
| `author_email` | string | false |  | Email address for the comment author. |
| `author_ip` | string | false |  | IP address for the comment author. |
| `author_name` | string | false |  | Display name for the comment author. |
| `author_url` | string | false |  | URL for the comment author. |
| `author_user_agent` | string | false |  | User agent for the comment author. |
| `content` | object | false |  | The content for the comment. |
| `date` | string | false |  | The date the comment was published, in the site's timezone. |
| `date_gmt` | string | false |  | The date the comment was published, as GMT. |
| `parent` | integer | false | 0 | The ID for the parent of the comment. |
| `post` | integer | false | 0 | The ID of the associated post object. |
| `status` | string | false |  | State of the comment. |
| `meta` | object | false |  | Meta fields. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `password` | string | false |  | The password for the parent post of the comment (if the post is password protected). |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `author` | integer | false |  | The ID of the user object, if author was a user. |
| `author_email` | string | false |  | Email address for the comment author. |
| `author_ip` | string | false |  | IP address for the comment author. |
| `author_name` | string | false |  | Display name for the comment author. |
| `author_url` | string | false |  | URL for the comment author. |
| `author_user_agent` | string | false |  | User agent for the comment author. |
| `content` | object | false |  | The content for the comment. |
| `date` | string | false |  | The date the comment was published, in the site's timezone. |
| `date_gmt` | string | false |  | The date the comment was published, as GMT. |
| `parent` | integer | false |  | The ID for the parent of the comment. |
| `post` | integer | false |  | The ID of the associated post object. |
| `status` | string | false |  | State of the comment. |
| `meta` | object | false |  | Meta fields. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `force` | boolean | false | False | Whether to bypass Trash and force deletion. |
| `password` | string | false |  | The password for the parent post of the comment (if the post is password protected). |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `password` | string | false |  | The password for the parent post of the comment (if the post is password protected). |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `author` | integer | false |  | The ID of the user object, if author was a user. |
| `author_email` | string | false |  | Email address for the comment author. |
| `author_ip` | string | false |  | IP address for the comment author. |
| `author_name` | string | false |  | Display name for the comment author. |
| `author_url` | string | false |  | URL for the comment author. |
| `author_user_agent` | string | false |  | User agent for the comment author. |
| `content` | object | false |  | The content for the comment. |
| `date` | string | false |  | The date the comment was published, in the site's timezone. |
| `date_gmt` | string | false |  | The date the comment was published, as GMT. |
| `parent` | integer | false |  | The ID for the parent of the comment. |
| `post` | integer | false |  | The ID of the associated post object. |
| `status` | string | false |  | State of the comment. |
| `meta` | object | false |  | Meta fields. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the comment. |
| `force` | boolean | false | False | Whether to bypass Trash and force deletion. |
| `password` | string | false |  | The password for the parent post of the comment (if the post is password protected). |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | integer | Unique identifier for the comment. (read-only) |
| `author` | integer | The ID of the user object, if author was a user. |
| `author_email` | string | Email address for the comment author. |
| `author_ip` | string | IP address for the comment author. |
| `author_name` | string | Display name for the comment author. |
| `author_url` | string | URL for the comment author. |
| `author_user_agent` | string | User agent for the comment author. |
| `content` | object | The content for the comment. |
| `date` | string | The date the comment was published, in the site's timezone. |
| `date_gmt` | string | The date the comment was published, as GMT. |
| `link` | string | URL to the comment. (read-only) |
| `parent` | integer | The ID for the parent of the comment. |
| `post` | integer | The ID of the associated post object. |
| `status` | string | State of the comment. |
| `type` | string | Type of the comment. (read-only) |
| `author_avatar_urls` | object | Avatar URLs for the comment author. (read-only) |
| `meta` | object | Meta fields. |

## Authentication

- Read: public for approved comments; unapproved requires `moderate_comments`.
- Write: create allowed when site permits; update/delete requires `moderate_comments` or `edit_posts`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/comments"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/comments" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/comments/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/comments/1" }]
  }
}
```
