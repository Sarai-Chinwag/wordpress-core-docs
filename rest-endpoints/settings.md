# `/wp/v2/settings`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/settings`

## Routes

- Collection: `/wp/v2/settings`


## HTTP Methods

Collection methods: GET, POST, PUT, PATCH


## Request Parameters

### Collection GET

None.

### Collection POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `active_templates` | object | false |  |  |
| `public_post_preview_expiration_time` | integer | false |  | Default expiration time in seconds. |
| `title` | string | false |  | Site title. |
| `description` | string | false |  | Site tagline. |
| `timezone` | string | false |  | A city in the same timezone as you. |
| `date_format` | string | false |  | A date format for all date strings. |
| `time_format` | string | false |  | A time format for all time strings. |
| `start_of_week` | integer | false |  | A day number of the week that the week should start on. |
| `language` | string | false |  | WordPress locale code. |
| `use_smilies` | boolean | false |  | Convert emoticons like :-) and :-P to graphics on display. |
| `default_category` | integer | false |  | Default post category. |
| `default_post_format` | string | false |  | Default post format. |
| `posts_per_page` | integer | false |  | Blog pages show at most. |
| `show_on_front` | string | false |  | What to show on the front page |
| `page_on_front` | integer | false |  | The ID of the page that should be displayed on the front page |
| `page_for_posts` | integer | false |  | The ID of the page that should display the latest posts |
| `default_ping_status` | string | false |  | Allow link notifications from other blogs (pingbacks and trackbacks) on new articles. |
| `default_comment_status` | string | false |  | Allow people to submit comments on new posts. |
| `site_logo` | integer | false |  | Site logo. |
| `site_icon` | integer | false |  | Site icon. |
| `cookie_consent_template` | string | false |  |  |
| `Blogroll Recommendations` | array | false |  | Site Recommendations |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `active_templates` | object |  |
| `public_post_preview_expiration_time` | integer | Default expiration time in seconds. |
| `title` | string | Site title. |
| `description` | string | Site tagline. |
| `timezone` | string | A city in the same timezone as you. |
| `date_format` | string | A date format for all date strings. |
| `time_format` | string | A time format for all time strings. |
| `start_of_week` | integer | A day number of the week that the week should start on. |
| `language` | string | WordPress locale code. |
| `use_smilies` | boolean | Convert emoticons like :-) and :-P to graphics on display. |
| `default_category` | integer | Default post category. |
| `default_post_format` | string | Default post format. |
| `posts_per_page` | integer | Blog pages show at most. |
| `show_on_front` | string | What to show on the front page |
| `page_on_front` | integer | The ID of the page that should be displayed on the front page |
| `page_for_posts` | integer | The ID of the page that should display the latest posts |
| `default_ping_status` | string | Allow link notifications from other blogs (pingbacks and trackbacks) on new articles. |
| `default_comment_status` | string | Allow people to submit comments on new posts. |
| `site_logo` | integer | Site logo. |
| `site_icon` | integer | Site icon. |
| `cookie_consent_template` | string |  |
| `Blogroll Recommendations` | array | Site Recommendations |

## Authentication

- Read/Write: `manage_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/settings"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/settings" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/settings/1" }]
  }
}
```
