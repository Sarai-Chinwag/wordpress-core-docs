# `/wp/v2/media`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/media`

## Routes

- Collection: `/wp/v2/media`
- Single: `/wp/v2/media/{id}`


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
| `parent` | array | false | [] | Limit result set to items with particular parent IDs. |
| `parent_exclude` | array | false | [] | Limit result set to all items except those of a particular parent ID. |
| `search_columns` | array | false | [] | Array of column names to be searched. |
| `slug` | array | false |  | Limit result set to posts with one or more specific slugs. |
| `status` | array | false | inherit | Limit result set to posts assigned one or more statuses. |
| `media_type` | array | false | None | Limit result set to attachments of a particular media type or media types. |
| `mime_type` | array | false | None | Limit result set to attachments of a particular MIME type or MIME types. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `date` | string, null | false |  | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | false |  | The date the post was published, as GMT. |
| `slug` | string | false |  | An alphanumeric identifier for the post unique to its type. |
| `status` | string | false |  | A named status for the post. |
| `title` | object | false |  | The title for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `meta` | object | false |  | Meta fields. |
| `template` | string | false |  | The theme file to use to display the post. |
| `jetpack_sharing_enabled` | boolean | false |  | Are sharing buttons enabled? |
| `alt_text` | string | false |  | Alternative text to display when attachment is not displayed. |
| `caption` | object | false |  | The attachment caption. |
| `description` | object | false |  | The attachment description. |
| `post` | integer | false |  | The ID for the associated post of the attachment. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `date` | string, null | false |  | The date the post was published, in the site's timezone. |
| `date_gmt` | string, null | false |  | The date the post was published, as GMT. |
| `slug` | string | false |  | An alphanumeric identifier for the post unique to its type. |
| `status` | string | false |  | A named status for the post. |
| `title` | object | false |  | The title for the post. |
| `author` | integer | false |  | The ID for the author of the post. |
| `featured_media` | integer | false |  | The ID of the featured media for the post. |
| `comment_status` | string | false |  | Whether or not comments are open on the post. |
| `ping_status` | string | false |  | Whether or not the post can be pinged. |
| `meta` | object | false |  | Meta fields. |
| `template` | string | false |  | The theme file to use to display the post. |
| `jetpack_sharing_enabled` | boolean | false |  | Are sharing buttons enabled? |
| `alt_text` | string | false |  | Alternative text to display when attachment is not displayed. |
| `caption` | object | false |  | The attachment caption. |
| `description` | object | false |  | The attachment description. |
| `post` | integer | false |  | The ID for the associated post of the attachment. |

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
| `permalink_template` | string | Permalink template for the post. (read-only) |
| `generated_slug` | string | Slug automatically generated from the post title. (read-only) |
| `class_list` | array | An array of the class names for the post container element. (read-only) |
| `title` | object | The title for the post. |
| `author` | integer | The ID for the author of the post. |
| `featured_media` | integer | The ID of the featured media for the post. |
| `comment_status` | string | Whether or not comments are open on the post. |
| `ping_status` | string | Whether or not the post can be pinged. |
| `meta` | object | Meta fields. |
| `template` | string | The theme file to use to display the post. |
| `jetpack_videopress_guid` | string | Unique VideoPress ID (read-only) |
| `jetpack_videopress` | object | VideoPress Data (read-only) |
| `jetpack_sharing_enabled` | boolean | Are sharing buttons enabled? |
| `alt_text` | string | Alternative text to display when attachment is not displayed. |
| `caption` | object | The attachment caption. |
| `description` | object | The attachment description. |
| `media_type` | string | Attachment type. (read-only) |
| `mime_type` | string | The attachment MIME type. (read-only) |
| `media_details` | object | Details about the media file, specific to its type. (read-only) |
| `post` | integer | The ID for the associated post of the attachment. |
| `source_url` | string | URL to the original attachment file. (read-only) |
| `missing_image_sizes` | array | List of the missing image sizes of the attachment. (read-only) |

## Authentication

- Read: public for public media; private attachments require `edit_posts`.
- Write: `upload_files` to create; `edit_posts`/`delete_posts` for update/delete.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/media"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/media" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/media/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/media/1" }]
  }
}
```
