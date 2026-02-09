# WP_User_Request Class

The `WP_User_Request` class represents a user data privacy request loaded from a `WP_Post` object. It provides a structured interface for accessing request data stored in the `user_request` custom post type.

**File:** `wp-includes/class-wp-user-request.php`  
**Since:** 4.9.6

## Class Definition

```php
#[AllowDynamicProperties]
final class WP_User_Request {
    public $ID = 0;
    public $user_id = 0;
    public $email = '';
    public $action_name = '';
    public $status = '';
    public $created_timestamp = null;
    public $modified_timestamp = null;
    public $confirmed_timestamp = null;
    public $completed_timestamp = null;
    public $request_data = array();
    public $confirm_key = '';
}
```

## Properties

### `$ID`
- **Type:** `int`
- **Default:** `0`
- **Description:** The request post ID

### `$user_id`
- **Type:** `int`
- **Default:** `0`
- **Description:** The WordPress user ID associated with the request. `0` for guest/non-registered users.
- **Mapped From:** `post_author`

### `$email`
- **Type:** `string`
- **Default:** `''`
- **Description:** The email address for the privacy request
- **Mapped From:** `post_title`

### `$action_name`
- **Type:** `string`
- **Default:** `''`
- **Description:** The action being requested
- **Values:** `export_personal_data` or `remove_personal_data`
- **Mapped From:** `post_name`

### `$status`
- **Type:** `string`
- **Default:** `''`
- **Description:** Current request status
- **Values:** `request-pending`, `request-confirmed`, `request-failed`, `request-completed`
- **Mapped From:** `post_status`

### `$created_timestamp`
- **Type:** `int|null`
- **Default:** `null`
- **Description:** Unix timestamp when the request was created
- **Mapped From:** `strtotime( post_date_gmt )`

### `$modified_timestamp`
- **Type:** `int|null`
- **Default:** `null`
- **Description:** Unix timestamp when the request was last modified
- **Mapped From:** `strtotime( post_modified_gmt )`

### `$confirmed_timestamp`
- **Type:** `int|null`
- **Default:** `null`
- **Description:** Unix timestamp when the user confirmed the request
- **Mapped From:** `_wp_user_request_confirmed_timestamp` post meta

### `$completed_timestamp`
- **Type:** `int|null`
- **Default:** `null`
- **Description:** Unix timestamp when the request was completed
- **Mapped From:** `_wp_user_request_completed_timestamp` post meta

### `$request_data`
- **Type:** `array`
- **Default:** `array()`
- **Description:** Miscellaneous data associated with the request
- **Mapped From:** JSON-decoded `post_content`

### `$confirm_key`
- **Type:** `string`
- **Default:** `''`
- **Description:** Hashed confirmation key used to verify the request
- **Mapped From:** `post_password`
- **Since 6.8.0:** Now hashed using `wp_fast_hash()` instead of phpass

## Constructor

```php
public function __construct( $post )
```

### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$post` | `WP_Post\|object` | Post object containing request data |

### Mapping

The constructor maps `WP_Post` properties to the request object:

| WP_Post Property | WP_User_Request Property |
|------------------|--------------------------|
| `ID` | `ID` |
| `post_author` | `user_id` |
| `post_title` | `email` |
| `post_name` | `action_name` |
| `post_status` | `status` |
| `post_date_gmt` | `created_timestamp` (converted) |
| `post_modified_gmt` | `modified_timestamp` (converted) |
| `post_content` | `request_data` (JSON decoded) |
| `post_password` | `confirm_key` |

## Usage Examples

### Retrieving a Request

```php
// Get a request by ID
$request = wp_get_user_request( $request_id );

if ( $request instanceof WP_User_Request ) {
    echo 'Email: ' . $request->email;
    echo 'Action: ' . $request->action_name;
    echo 'Status: ' . $request->status;
}
```

### Checking Request Status

```php
$request = wp_get_user_request( $request_id );

if ( $request ) {
    switch ( $request->status ) {
        case 'request-pending':
            echo 'Awaiting user confirmation';
            break;
        case 'request-confirmed':
            echo 'Ready for processing';
            break;
        case 'request-completed':
            echo 'Request fulfilled';
            break;
        case 'request-failed':
            echo 'Request failed';
            break;
    }
}
```

### Checking Timestamps

```php
$request = wp_get_user_request( $request_id );

if ( $request && $request->confirmed_timestamp ) {
    $confirmed_date = date_i18n( 
        get_option( 'date_format' ), 
        $request->confirmed_timestamp 
    );
    echo "Request confirmed on: $confirmed_date";
}
```

### Working with Request Data

```php
$request = wp_get_user_request( $request_id );

if ( $request && ! empty( $request->request_data ) ) {
    // Access custom data stored with the request
    $custom_value = $request->request_data['custom_key'] ?? null;
}
```

## Post Type Details

Requests are stored using WordPress's post system with these characteristics:

| Post Property | Usage |
|---------------|-------|
| `post_type` | Always `user_request` |
| `post_author` | User ID (0 for guests) |
| `post_title` | Email address |
| `post_name` | Action name (slug) |
| `post_content` | JSON-encoded request data |
| `post_status` | Request status with `request-` prefix |
| `post_password` | Hashed confirmation key |

## Related Functions

| Function | Description |
|----------|-------------|
| `wp_get_user_request()` | Retrieve a `WP_User_Request` by ID |
| `wp_create_user_request()` | Create a new request |
| `wp_send_user_request()` | Send confirmation email |
| `wp_validate_user_request_key()` | Validate confirmation key |
| `wp_generate_user_request_key()` | Generate new confirmation key |

## Post Meta

The following post meta keys are used:

| Meta Key | Description |
|----------|-------------|
| `_wp_user_request_confirmed_timestamp` | When user confirmed |
| `_wp_user_request_completed_timestamp` | When request completed |
| `_wp_admin_notified` | Whether admin was notified |
| `_wp_user_notified` | Whether user was notified of completion |

## Notes

- The class is marked `final` and cannot be extended
- Uses `#[AllowDynamicProperties]` attribute for PHP 8.2+ compatibility
- Request posts are never publicly queryable
- The confirmation key is stored hashed; the plain key is only available when generated
