# `/wp/v2/users`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/users`

## Routes

- Collection: `/wp/v2/users`
- Single: `/wp/v2/users/{id}`


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
| `exclude` | array | false | [] | Ensure result set excludes specific IDs. |
| `include` | array | false | [] | Limit result set to specific IDs. |
| `offset` | integer | false |  | Offset the result set by a specific number of items. |
| `order` | string | false | asc | Order sort attribute ascending or descending. |
| `orderby` | string | false | name | Sort collection by user attribute. |
| `slug` | array | false |  | Limit result set to users with one or more specific slugs. |
| `roles` | array | false |  | Limit result set to users matching at least one specific role provided. Accepts csv list or single role. |
| `capabilities` | array | false |  | Limit result set to users matching at least one specific capability provided. Accepts csv list or single capability. |
| `who` | string | false |  | Limit result set to users who are considered authors. |
| `has_published_posts` | boolean, array | false |  | Limit result set to users who have published posts. |
| `search_columns` | array | false | [] | Array of column names to be searched. |

### Collection POST

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `username` | string | true |  | Login name for the user. |
| `name` | string | false |  | Display name for the user. |
| `first_name` | string | false |  | First name for the user. |
| `last_name` | string | false |  | Last name for the user. |
| `email` | string | true |  | The email address for the user. |
| `url` | string | false |  | URL of the user. |
| `description` | string | false |  | Description of the user. |
| `locale` | string | false |  | Locale for the user. |
| `nickname` | string | false |  | The nickname for the user. |
| `slug` | string | false |  | An alphanumeric identifier for the user. |
| `roles` | array | false |  | Roles assigned to the user. |
| `password` | string | true |  | Password for the user (never included). |
| `meta` | object | false |  | Meta fields. |
| `pending_email` | string | false |  |  |
| `2fa_required` | boolean | false |  |  |
| `2fa_available_providers` | array | false |  |  |
| `2fa_primary_provider` | array | false |  |  |
| `2fa_backup_codes_remaining` | int | false |  |  |
| `2fa_revalidation` | array | false |  |  |
| `2fa_webauthn_keys` | array | false |  |  |
| `2fa_webauthn_register_nonce` | array | false |  |  |
| `svn_password_required` | boolean | false |  |  |
| `svn_password_created` | boolean, string | false |  |  |

### Single GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the user. |
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Single POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the user. |
| `username` | string | false |  | Login name for the user. |
| `name` | string | false |  | Display name for the user. |
| `first_name` | string | false |  | First name for the user. |
| `last_name` | string | false |  | Last name for the user. |
| `email` | string | false |  | The email address for the user. |
| `url` | string | false |  | URL of the user. |
| `description` | string | false |  | Description of the user. |
| `locale` | string | false |  | Locale for the user. |
| `nickname` | string | false |  | The nickname for the user. |
| `slug` | string | false |  | An alphanumeric identifier for the user. |
| `roles` | array | false |  | Roles assigned to the user. |
| `password` | string | false |  | Password for the user (never included). |
| `meta` | object | false |  | Meta fields. |
| `pending_email` | string | false |  |  |
| `2fa_required` | boolean | false |  |  |
| `2fa_available_providers` | array | false |  |  |
| `2fa_primary_provider` | array | false |  |  |
| `2fa_backup_codes_remaining` | int | false |  |  |
| `2fa_revalidation` | array | false |  |  |
| `2fa_webauthn_keys` | array | false |  |  |
| `2fa_webauthn_register_nonce` | array | false |  |  |
| `svn_password_required` | boolean | false |  |  |
| `svn_password_created` | boolean, string | false |  |  |

### Single DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `id` | integer | false |  | Unique identifier for the user. |
| `force` | boolean | false | False | Required to be true, as users do not support trashing. |
| `reassign` | integer | true |  | Reassign the deleted user's posts and links to this user ID. |

## Response Schema (Item)

| Field | Type | Description |
|---|---|---|
| `id` | integer | Unique identifier for the user. (read-only) |
| `username` | string | Login name for the user. |
| `name` | string | Display name for the user. |
| `first_name` | string | First name for the user. |
| `last_name` | string | Last name for the user. |
| `email` | string | The email address for the user. |
| `url` | string | URL of the user. |
| `description` | string | Description of the user. |
| `link` | string | Author URL of the user. (read-only) |
| `locale` | string | Locale for the user. |
| `nickname` | string | The nickname for the user. |
| `slug` | string | An alphanumeric identifier for the user. |
| `registered_date` | string | Registration date for the user. (read-only) |
| `roles` | array | Roles assigned to the user. |
| `password` | string | Password for the user (never included). |
| `capabilities` | object | All capabilities assigned to the user. (read-only) |
| `extra_capabilities` | object | Any extra capabilities assigned to the user. (read-only) |
| `avatar_urls` | object | Avatar URLs for the user. (read-only) |
| `meta` | object | Meta fields. |
| `pending_email` | string |  |
| `2fa_required` | boolean |  |
| `2fa_available_providers` | array |  |
| `2fa_primary_provider` | array |  |
| `2fa_backup_codes_remaining` | int |  |
| `2fa_revalidation` | array |  |
| `2fa_webauthn_keys` | array |  |
| `2fa_webauthn_register_nonce` | array |  |
| `svn_password_required` | boolean |  |
| `svn_password_created` | boolean, string |  |

## Authentication

- Read: `list_users` to list; `edit_user` to view another user in edit context.
- Write: `create_users`, `edit_users`, `delete_users` for create/update/delete.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/users"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/users" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/users/1"
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/users/1" }]
  }
}
```
