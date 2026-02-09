# Application Passwords Overview

Application Passwords provide a secure way to authenticate REST API requests without exposing your main WordPress password. Introduced in WordPress 5.6.0, they enable third-party applications, mobile apps, and automation scripts to interact with your site securely.

## What Are Application Passwords?

Application passwords are:

- **24-character random strings** generated specifically for API access
- **Separate from your main password** — revoking one doesn't affect others
- **Per-application** — each app gets its own password with a descriptive name
- **Trackable** — WordPress records last used time and IP address

## When to Use Them

Application passwords are ideal for:

- **REST API authentication** via HTTP Basic Auth
- **Mobile apps** connecting to your WordPress site
- **Automation scripts** (CI/CD, content publishing)
- **Third-party integrations** (Zapier, IFTTT, custom tools)
- **Agents and bots** that need authenticated access

## How They Work

### Authentication Flow

1. User creates an application password in their profile
2. Application stores the password securely
3. API requests include credentials via HTTP Basic Auth
4. WordPress validates and records usage

### HTTP Basic Auth Format

```
Authorization: Basic base64(username:application_password)
```

Example with cURL:

```bash
curl -X GET https://example.com/wp-json/wp/v2/posts \
  -u "username:xxxx xxxx xxxx xxxx xxxx xxxx"
```

The password can include spaces (formatted in 4-character chunks for readability) or be provided without them.

## Creating Application Passwords

### Via User Profile (UI)

1. Go to **Users → Profile**
2. Scroll to **Application Passwords** section
3. Enter a name (e.g., "My Mobile App")
4. Click **Add New Application Password**
5. Copy the generated password immediately (shown only once)

### Via REST API

```http
POST /wp-json/wp/v2/users/<user_id>/application-passwords
Authorization: Basic <existing_credentials>
Content-Type: application/json

{
  "name": "My Integration",
  "app_id": "550e8400-e29b-41d4-a716-446655440000"
}
```

### Programmatically

```php
$result = WP_Application_Passwords::create_new_application_password(
    $user_id,
    array(
        'name'   => 'My Script',
        'app_id' => '550e8400-e29b-41d4-a716-446655440000', // Optional UUID
    )
);

if ( is_wp_error( $result ) ) {
    // Handle error
} else {
    list( $password, $item ) = $result;
    // $password is the plain text password (store securely!)
    // $item contains uuid, name, created timestamp, etc.
}
```

## Security Considerations

### Password Storage

- Passwords are hashed using `wp_fast_hash()` (since 6.8.0) or phpass (older versions)
- Plain text is shown **only once** at creation time
- WordPress cannot recover a lost application password

### Best Practices

1. **Use descriptive names** — "iPhone WordPress App" not "test"
2. **One password per application** — easier to revoke if compromised
3. **Revoke unused passwords** — audit periodically
4. **Use HTTPS** — Basic Auth is only secure over TLS
5. **Limit scope** — application passwords inherit user capabilities

### Revoking Access

To revoke an application password:

```php
WP_Application_Passwords::delete_application_password( $user_id, $uuid );
```

Or delete all passwords for a user:

```php
WP_Application_Passwords::delete_all_application_passwords( $user_id );
```

## Storage Details

Application passwords are stored in user meta under the key `_application_passwords`. Each password record contains:

| Field       | Type        | Description                                    |
|-------------|-------------|------------------------------------------------|
| `uuid`      | string      | Unique identifier for this password            |
| `app_id`    | string      | Optional UUID provided by the application      |
| `name`      | string      | Human-readable name                            |
| `password`  | string      | One-way hash of the password                   |
| `created`   | int         | Unix timestamp of creation                     |
| `last_used` | int\|null   | Unix timestamp of last use (updated daily)     |
| `last_ip`   | string\|null| IP address of last use                         |

## Checking If In Use

To determine if any application passwords have been created on the site:

```php
if ( WP_Application_Passwords::is_in_use() ) {
    // At least one application password exists
}
```

This checks a network option (`using_application_passwords`) set when the first password is created.

## Related Functions

- `wp_authenticate_application_password()` — Authenticates a request using application password
- `wp_is_application_passwords_available()` — Checks if feature is available
- `wp_is_application_passwords_available_for_user()` — Checks if available for specific user

## Version History

| Version | Changes |
|---------|---------|
| 5.6.0   | Feature introduced |
| 5.7.0   | Returns WP_Error if application name already exists |
| 6.8.0   | Switched to `wp_fast_hash()` for new passwords |
