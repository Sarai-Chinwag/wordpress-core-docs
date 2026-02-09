# `/wp/v2/themes`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/themes`

## Routes

- Collection: `/wp/v2/themes`
- Single: `/wp/v2/themes/{stylesheet}`


## HTTP Methods

Collection methods: GET

Single methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `status` | array | false |  | Limit result set to themes assigned one or more statuses. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `stylesheet` | string | false |  | The theme's stylesheet. This uniquely identifies the theme. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `stylesheet` | string | The theme's stylesheet. This uniquely identifies the theme. (read-only) |
| `stylesheet_uri` | string | The uri for the theme's stylesheet directory. (read-only) |
| `template` | string | The theme's template. If this is a child theme, this refers to the parent theme, otherwise this is the same as the theme's stylesheet. (read-only) |
| `template_uri` | string | The uri for the theme's template directory. If this is a child theme, this refers to the parent theme, otherwise this is the same as the theme's stylesheet directory. (read-only) |
| `author` | object | The theme author. (read-only) |
| `author_uri` | object | The website of the theme author. (read-only) |
| `description` | object | A description of the theme. (read-only) |
| `is_block_theme` | boolean | Whether the theme is a block-based theme. (read-only) |
| `name` | object | The name of the theme. (read-only) |
| `requires_php` | string | The minimum PHP version required for the theme to work. (read-only) |
| `requires_wp` | string | The minimum WordPress version required for the theme to work. (read-only) |
| `screenshot` | string | The theme's screenshot URL. (read-only) |
| `tags` | object | Tags indicating styles and features of the theme. (read-only) |
| `textdomain` | string | The theme's text domain. (read-only) |
| `theme_supports` | object | Features supported by this theme. (read-only) |
| `theme_uri` | object | The URI of the theme's webpage. (read-only) |
| `version` | string | The theme's current version. (read-only) |
| `status` | string | A named status for the theme. |
| `default_template_types` | array | A list of default template types. (read-only) |
| `default_template_part_areas` | array | A list of allowed area values for template parts. (read-only) |

## Authentication

- Read: `switch_themes`.
- Write: `edit_theme_options` for updates; `switch_themes` for activation.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/themes"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/themes/twentytwentyfour"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/themes/1" }]
  }
}
```
