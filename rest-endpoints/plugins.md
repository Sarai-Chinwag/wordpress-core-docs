# `/wp/v2/plugins`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/plugins`

## Routes

- Collection: `/wp/v2/plugins`
- Single: `/wp/v2/plugins/{plugin}`


## HTTP Methods

Collection methods: GET, POST

Single methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `search` | string | false |  | Limit results to those matching a string. |
| `status` | array | false |  | Limits results to plugins with the given status. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `slug` | string | true |  | WordPress.org plugin directory slug. |
| `status` | string | false | inactive | The plugin activation status. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `plugin` | string | false |  |  |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `plugin` | string | false |  |  |
| `status` | string | false |  | The plugin activation status. |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `plugin` | string | false |  |  |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `plugin` | string | The plugin file. (read-only) |
| `status` | string | The plugin activation status. |
| `name` | string | The plugin name. (read-only) |
| `plugin_uri` | string | The plugin's website address. (read-only) |
| `author` | string | The plugin author. (read-only) |
| `author_uri` | string | Plugin author's website address. (read-only) |
| `description` | object | The plugin description. (read-only) |
| `version` | string | The plugin version number. (read-only) |
| `network_only` | boolean | Whether the plugin can only be activated network-wide. (read-only) |
| `requires_wp` | string | Minimum required version of WordPress. (read-only) |
| `requires_php` | string | Minimum required version of PHP. (read-only) |
| `textdomain` | string | The plugin's text domain. (read-only) |

## Authentication

- Read: `activate_plugins`.
- Write: `install_plugins` (install), `activate_plugins` (activate/deactivate), `delete_plugins` (delete).

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/plugins"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/plugins" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/plugins/akismet/akismet"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/plugins/1" }]
  }
}
```
