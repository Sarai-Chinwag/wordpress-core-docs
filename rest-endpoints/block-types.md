# `/wp/v2/block-types`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/block-types`

## Routes

- Collection: `/wp/v2/block-types`
- Single: `/wp/v2/block-types/{namespace}/{name}`


## HTTP Methods

Collection methods: GET

Single methods: GET


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `namespace` | string | false |  | Block namespace. |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |
| `namespace` | string | false |  | Block namespace. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `api_version` | integer | Version of block API. (read-only) |
| `title` | string | Title of block type. (read-only) |
| `name` | string | Unique name identifying the block type. (read-only) |
| `description` | string | Description of block type. (read-only) |
| `icon` | string, null | Icon of block type. (read-only) |
| `attributes` | object, null | Block attributes. (read-only) |
| `provides_context` | object | Context provided by blocks of this type. (read-only) |
| `uses_context` | array | Context values inherited by blocks of this type. (read-only) |
| `selectors` | object | Custom CSS selectors. (read-only) |
| `supports` | object | Block supports. (read-only) |
| `category` | string, null | Block category. (read-only) |
| `is_dynamic` | boolean | Is the block dynamically rendered. (read-only) |
| `editor_script_handles` | array | Editor script handles. (read-only) |
| `script_handles` | array | Public facing and editor script handles. (read-only) |
| `view_script_handles` | array | Public facing script handles. (read-only) |
| `view_script_module_ids` | array | Public facing script module IDs. (read-only) |
| `editor_style_handles` | array | Editor style handles. (read-only) |
| `style_handles` | array | Public facing and editor style handles. (read-only) |
| `view_style_handles` | array | Public facing style handles. (read-only) |
| `styles` | array | Block style variations. (read-only) |
| `variations` | array | Block variations. (read-only) |
| `textdomain` | string, null | Public text domain. (read-only) |
| `parent` | array, null | Parent blocks. (read-only) |
| `ancestor` | array, null | Ancestor blocks. (read-only) |
| `allowed_blocks` | array, null | Allowed child block types. (read-only) |
| `keywords` | array | Block keywords. (read-only) |
| `example` | object, null | Block example. (read-only) |
| `block_hooks` | object | This block is automatically inserted near any occurrence of the block types used as keys of this map, into a relative position given by the corresponding value. (read-only) |
| `editor_script` | string, null | Editor script handle. DEPRECATED: Use `editor_script_handles` instead. (read-only) |
| `script` | string, null | Public facing and editor script handle. DEPRECATED: Use `script_handles` instead. (read-only) |
| `view_script` | string, null | Public facing script handle. DEPRECATED: Use `view_script_handles` instead. (read-only) |
| `editor_style` | string, null | Editor style handle. DEPRECATED: Use `editor_style_handles` instead. (read-only) |
| `style` | string, null | Public facing and editor style handle. DEPRECATED: Use `style_handles` instead. (read-only) |

## Authentication

- Read: public (block registration metadata); no write methods.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/block-types"
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/block-types/core/paragraph"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/block-types/1" }]
  }
}
```
