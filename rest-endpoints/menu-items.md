# `/wp/v2/menu-items`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/menu-items`

## Routes

- Collection: `/wp/v2/menu-items`
- Single: `/wp/v2/menu-items/{id}`


## HTTP Methods

Collection methods: Unknown

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `title` | string, object | false |  | The title for the object. |
| `type` | string | false |  | The family of objects originally represented, such as "post_type" or "taxonomy". |
| `status` | string | false |  | A named status for the object. |
| `parent` | integer | false |  | The ID for the parent of the object. |
| `attr_title` | string | false |  | Text for the title attribute of the link element for this menu item. |
| `classes` | array | false |  | Class names for the link element of this menu item. |
| `description` | string | false |  | The description of this menu item. |
| `menu_order` | integer | false |  | The DB ID of the nav_menu_item that is this item's menu parent, if any, otherwise 0. |
| `object` | string | false |  | The type of object originally represented, such as "category", "post", or "attachment". |
| `object_id` | integer | false |  | The database ID of the original object this menu item represents, for example the ID for posts or the term_id for categories. |
| `target` | string | false |  | The target attribute of the link element for this menu item. |
| `url` | string | false |  | The URL to which this menu item points. |
| `xfn` | array | false |  | The XFN relationship expressed in the link of this menu item. |
| `menus` | integer | false |  | The terms assigned to the object in the nav_menu taxonomy. |
| `meta` | object | false |  | Meta fields. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the post. |
| `force` | boolean | false | False | Whether to bypass Trash and force deletion. |

## Response Schema (Item)

Schema not available.

## Authentication

- Read/Write: `edit_theme_options`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menu-items"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menu-items/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/menu-items/1" }]
  }
}
```
