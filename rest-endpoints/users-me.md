# `/wp/v2/users/me`

**Namespace:** `wp/v2`  
**Route:** `/wp/v2/users/me`

## Routes

- Collection: `/wp/v2/users/me`


## HTTP Methods

Collection methods: GET, POST, PUT, PATCH, DELETE


## Request Parameters

### Collection GET

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
| `context` | string | false | view | Scope under which the request is made; determines fields present in response. |

### Collection POST, PUT, PATCH

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
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

### Collection DELETE

| Parameter | Type | Required | Default | Description |
|---|---|---|---|---|
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

- Requires authentication; returns current user or allows updating own profile with `edit_user`.

## Example Requests

```bash
curl -X GET "https://wordpress.org/news/wp-json/wp/v2/users/me"
```

```bash
curl -X POST "https://wordpress.org/news/wp-json/wp/v2/users/me" \
  -H 'Authorization: Basic <app-password>' \
  -H 'Content-Type: application/json' \
  -d '{"title":"Example"}'
```

## Example Response (trimmed)

```json
{
  "id": 1,
  "_links": {
    "self": [{ "href": "/wp/v2/users/me/1" }]
  }
}
```
