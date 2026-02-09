# `/wp/v2/pages`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/pages`

## Routes

- Collection: `/wp/v2/pages`
- Single: `/wp/v2/pages/{id}`


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
| `after` | string | false |  | Limit response to posts published after a given ISO8601 compliant date. |
| `modified_after` | string | false |  | Limit response to posts modified after a given ISO8601 compliant date. |
| `author` | array | false | [] | Limit result set to posts assigned to specific authors. |
| `author_exclude` | array | false | [] | Ensure result set excludes posts assigned to specific authors. |
| `before` | string | false |  | Limit response to posts published before a given ISO8601 compliant date. |
| `modified_before` | string | false |  | Limit response to posts modified before a given ISO8601 compliant date. |
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |
| `menu_order` | integer | false |  | Limit result set to posts with a specific menu_order value. |
| `search_semantics` | string | false |  | How to interpret the search input. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | desc | Order sort attribute ascending or descending. |
| `orderby` | string | false | date | Sort collection by post attribute. |
| `parent` | array | false | [] | Limit result set to items with particular parent IDs. |
| `parent_exclude` | array | false | [] | Limit result set to all items except those of a particular parent ID. |
| `search_columns` | array | false | [] | Array of column names to be searched. |
| `slug` | array | false |  | Limit result set to posts with one or more specific slugs. |
| `status` | array | false | publish | Limit result set to posts assigned one or more statuses. |
| `orderby_hierarchy` | boolean | false | False | Sort pages by hierarchy. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `date` | string, null | false |  | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | false |  | The date the post was published, as GMT. |
| `slug` | string | false |  | An alphanumeric identifier for the post unique to its type. |
| `status` | string | false |  | A named status for the post. |
| `password` | string | false |  | A password to protect access to the content and excerpt. |
| `parent` | integer | false |  | The ID for the parent of the post. |
| `title` | object | false |  | The title for the post. |
| `content` | object | false |  | The content for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `excerpt` | object | false |  | The excerpt for the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `menu_order` | integer | false |  | The order of the post in relation to other posts. |
| `meta` | object | false |  | Meta fields. |
| `template` | string | false |  | The theme file to use to display the post. |
| `jetpack_sharing_enabled` | boolean | false |  | Are sharing buttons enabled? |

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
| `parent` | integer | false |  | The ID for the parent of the post. |
| `title` | object | false |  | The title for the post. |
| `content` | object | false |  | The content for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `excerpt` | object | false |  | The excerpt for the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `menu_order` | integer | false |  | The order of the post in relation to other posts. |
| `meta` | object | false |  | Meta fields. |
| `template` | string | false |  | The theme file to use to display the post. |
| `jetpack_sharing_enabled` | boolean | false |  | Are sharing buttons enabled? |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `force` | boolean | false | False | Whether to bypass Trash and force deletion. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `date` | string, null | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | The date the post was published, as GMT. |
| `guid` | object | The globally unique identifier for the post. (read-only) |
| `id` | integer | Unique identifier for the post. (read-only) |
| `link` | string | URL to the post. (read-only) |
| `modified` | string | The date the post was last modified, in the site's timezone. (read-only) |
| `modified_gmt` | string | The date the post was last modified, as GMT. (read-only) |
| `slug` | string | An alphanumeric identifier for the post unique to its type. |
| `status` | string | A named status for the post. |
| `type` | string | Type of post. (read-only) |
| `password` | string | A password to protect access to the content and excerpt. |
| `permalink_template` | string | Permalink template for the post. (read-only) |
| `generated_slug` | string | Slug automatically generated from the post title. (read-only) |
| `class_list` | array | An array of the class names for the post container element. (read-only) |
| `parent` | integer | The ID for the parent of the post. |
| `title` | object | The title for the post. |
| `content` | object | The content for the post. |
| `author` | integer | The ID for the author of the post. |
| `excerpt` | object | The excerpt for the post. |
| `featured_media` | integer | The ID of the featured media for the post. |
| `comment_status` | string | Whether or not comments are open on the post. |
| `ping_status` | string | Whether or not the post can be pinged. |
| `menu_order` | integer | The order of the post in relation to other posts. |
| `meta` | object | Meta fields. |
| `template` | string | The theme file to use to display the post. |
| `jetpack_sharing_enabled` | boolean | Are sharing buttons enabled? |

## Authentication

- Read: public for published pages; `edit_pages` required to view protected/private pages.
- Write: `edit_pages` (create/update), `publish_pages` (publish), `delete_pages` (delete).

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/pages"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/pages" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/pages/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/pages/1" }]
  }
}
```
