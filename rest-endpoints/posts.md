# `/wp/v2/posts`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/posts`

## Routes

- Collection: `/wp/v2/posts`
- Single: `/wp/v2/posts/{id}`


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
| `search_semantics` | string | false |  | How to interpret the search input. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | desc | Order sort attribute ascending or descending. |
| `orderby` | string | false | date | Sort collection by post attribute. |
| `search_columns` | array | false | [] | Array of column names to be searched. |
| `slug` | array | false |  | Limit result set to posts with one or more specific slugs. |
| `status` | array | false | publish | Limit result set to posts assigned one or more statuses. |
| `tax_relation` | string | false |  | Limit result set based on relationship between multiple taxonomies. |
| `categories` | object, array | false |  | Limit result set to items with specific terms assigned in the categories taxonomy. |
| `categories_exclude` | object, array | false |  | Limit result set to items except those with specific terms assigned in the categories taxonomy. |
| `tags` | object, array | false |  | Limit result set to items with specific terms assigned in the tags taxonomy. |
| `tags_exclude` | object, array | false |  | Limit result set to items except those with specific terms assigned in the tags taxonomy. |
| `sticky` | boolean | false |  | Limit result set to items that are sticky. |
| `ignore_sticky` | boolean | false | True | Whether to ignore sticky posts or not. |
| `format` | array | false |  | Limit result set to items assigned one or more given formats. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `date` | string, null | false |  | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | false |  | The date the post was published, as GMT. |
| `slug` | string | false |  | An alphanumeric identifier for the post unique to its type. |
| `status` | string | false |  | A named status for the post. |
| `password` | string | false |  | A password to protect access to the content and excerpt. |
| `title` | object | false |  | The title for the post. |
| `content` | object | false |  | The content for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `excerpt` | object | false |  | The excerpt for the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `format` | string | false |  | The format for the post. |
| `meta` | object | false |  | Meta fields. |
| `sticky` | boolean | false |  | Whether or not the post should be treated as sticky. |
| `template` | string | false |  | The theme file to use to display the post. |
| `categories` | array | false |  | The terms assigned to the post in the category taxonomy. |
| `tags` | array | false |  | The terms assigned to the post in the post_tag taxonomy. |
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
| `title` | object | false |  | The title for the post. |
| `content` | object | false |  | The content for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `excerpt` | object | false |  | The excerpt for the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `format` | string | false |  | The format for the post. |
| `meta` | object | false |  | Meta fields. |
| `sticky` | boolean | false |  | Whether or not the post should be treated as sticky. |
| `template` | string | false |  | The theme file to use to display the post. |
| `categories` | array | false |  | The terms assigned to the post in the category taxonomy. |
| `tags` | array | false |  | The terms assigned to the post in the post_tag taxonomy. |
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
| `title` | object | The title for the post. |
| `content` | object | The content for the post. |
| `author` | integer | The ID for the author of the post. |
| `excerpt` | object | The excerpt for the post. |
| `featured_media` | integer | The ID of the featured media for the post. |
| `comment_status` | string | Whether or not comments are open on the post. |
| `ping_status` | string | Whether or not the post can be pinged. |
| `format` | string | The format for the post. |
| `meta` | object | Meta fields. |
| `sticky` | boolean | Whether or not the post should be treated as sticky. |
| `template` | string | The theme file to use to display the post. |
| `categories` | array | The terms assigned to the post in the category taxonomy. |
| `tags` | array | The terms assigned to the post in the post_tag taxonomy. |
| `jetpack_sharing_enabled` | boolean | Are sharing buttons enabled? |

## Authentication

- Read: public for published posts; `edit_posts` required to view protected/private posts.
- Write: `edit_posts` (create/update), `publish_posts` (publish), `delete_posts` (delete).

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/posts"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/posts" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/posts/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/posts/1" }]
  }
}
```
