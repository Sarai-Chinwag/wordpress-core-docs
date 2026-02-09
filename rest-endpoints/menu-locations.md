# `/wp/v2/menu-locations`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/menu-locations`

## Routes

- Collection: `/wp/v2/menu-locations`
- Single: `/wp/v2/menu-locations/{location}`


## HTTP Methods

Collection methods: GET

Single methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `location` | string | false |  | An alphanumeric identifier for the menu location. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `name` | string | The name of the menu location. (read-only) |
| `description` | string | The description of the menu location. (read-only) |
| `menu` | integer | The ID of the assigned menu. (read-only) |

## Authentication

- Read/Write: `edit_theme_options` (location assignments).

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menu-locations"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/menu-locations/primary"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/menu-locations/1" }]
  }
}
```
