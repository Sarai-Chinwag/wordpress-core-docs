# WordPress Privacy Functions

This document covers the core privacy-related functions in WordPress for handling personal data requests, exports, erasures, and anonymization.

## Request Management Functions

### wp_create_user_request()

Creates and logs a user request to perform a specific action.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_create_user_request( 
    string $email_address = '', 
    string $action_name = '', 
    array $request_data = array(), 
    string $status = 'pending' 
): int|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$email_address` | `string` | User email address (registered or non-registered) |
| `$action_name` | `string` | Action name: `export_personal_data` or `remove_personal_data` |
| `$request_data` | `array` | Misc data to include with the request |
| `$status` | `string` | Initial status: `pending` or `confirmed`. Since 5.7.0 |

#### Returns

- `int` - Request ID on success
- `WP_Error` - On failure

#### Errors

| Error Code | Description |
|------------|-------------|
| `invalid_email` | Email address is invalid |
| `invalid_action` | Action name is not recognized |
| `invalid_status` | Status is not `pending` or `confirmed` |
| `duplicate_request` | An incomplete request already exists |

#### Example

```php
$request_id = wp_create_user_request( 
    'user@example.com', 
    'export_personal_data',
    array( 'source' => 'my-form' )
);

if ( is_wp_error( $request_id ) ) {
    echo $request_id->get_error_message();
} else {
    wp_send_user_request( $request_id );
}
```

---

### wp_send_user_request()

Sends a confirmation email for a user request.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_send_user_request( int $request_id ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request_id` | `int` | Request ID from `wp_create_user_request()` |

#### Returns

- `true` - On success
- `WP_Error` - On failure

#### Notes

- Generates a new confirmation key
- Updates the request status to `request-pending`
- Sends a localized email based on user's locale

---

### wp_get_user_request()

Returns the user request object for a specified request ID.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_get_user_request( int $request_id ): WP_User_Request|false
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request_id` | `int` | The request ID |

#### Returns

- `WP_User_Request` - On success
- `false` - If not found or not a user_request post type

---

### wp_validate_user_request_key()

Validates a user request confirmation key.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_validate_user_request_key( int $request_id, string $key ): true|WP_Error
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request_id` | `int` | Request ID being confirmed |
| `$key` | `string` | Confirmation key to validate |

#### Returns

- `true` - If key is valid
- `WP_Error` - On failure

#### Errors

| Error Code | Description |
|------------|-------------|
| `invalid_request` | Request not found or missing data |
| `expired_request` | Request already processed |
| `missing_key` | No key provided |
| `invalid_key` | Key doesn't match |
| `expired_key` | Key has expired (default: 24 hours) |

---

### wp_generate_user_request_key()

Generates and stores a confirmation key for a request.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_generate_user_request_key( int $request_id ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request_id` | `int` | Request ID |

#### Returns

- `string` - The plain-text confirmation key

#### Notes

- Generates a 20-character random key
- Stores the hashed version in `post_password`
- Updates status to `request-pending`
- Since 6.8.0: Uses `wp_fast_hash()` instead of phpass

---

### wp_user_request_action_description()

Gets human-readable description for an action name.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_user_request_action_description( string $action_name ): string
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$action_name` | `string` | Action name |

#### Returns

| Action Name | Description |
|-------------|-------------|
| `export_personal_data` | "Export Personal Data" |
| `remove_personal_data` | "Erase Personal Data" |
| (other) | "Confirm the '{action}' action" |

---

### _wp_privacy_action_request_types()

Returns the list of core privacy action request types.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6  
**Access:** Private

```php
_wp_privacy_action_request_types(): string[]
```

#### Returns

```php
array( 'export_personal_data', 'remove_personal_data' )
```

---

## Personal Data Exporters

### wp_register_user_personal_data_exporter()

Registers the user data exporter.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_register_user_personal_data_exporter( array $exporters ): array
```

---

### wp_user_personal_data_exporter()

Exports personal data from the users and user_meta tables.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
wp_user_personal_data_exporter( string $email_address ): array
```

#### Exported Data Groups

| Group ID | Group Label | Fields |
|----------|-------------|--------|
| `user` | User | ID, Login, Nice Name, Email, URL, Registration Date, Display Name, Nickname, First Name, Last Name, Description |
| `community-events-location` | Community Events Location | City, Country, Latitude, Longitude, IP |
| `session-tokens` | Session Tokens | Expiration, IP, User Agent, Last Login |

---

### wp_register_comment_personal_data_exporter()

Registers the comment data exporter.

**File:** `wp-includes/comment.php`  
**Since:** 4.9.6

```php
wp_register_comment_personal_data_exporter( array $exporters ): array
```

---

### wp_comments_personal_data_exporter()

Exports personal data from the comments table.

**File:** `wp-includes/comment.php`  
**Since:** 4.9.6

```php
wp_comments_personal_data_exporter( string $email_address, int $page = 1 ): array
```

#### Exported Fields

- Comment Author
- Comment Author Email
- Comment Author URL
- Comment Author IP
- Comment Author User Agent
- Comment Date
- Comment Content
- Comment URL

#### Pagination

Processes 500 comments per page to avoid timeouts.

---

### wp_register_media_personal_data_exporter()

Registers the media attachment exporter.

**File:** `wp-includes/media.php`  
**Since:** 4.9.6

```php
wp_register_media_personal_data_exporter( array $exporters ): array
```

---

### wp_media_personal_data_exporter()

Exports media attachments uploaded by a user.

**File:** `wp-includes/media.php`  
**Since:** 4.9.6

```php
wp_media_personal_data_exporter( string $email_address, int $page = 1 ): array
```

#### Exported Fields

- Attachment URL

#### Pagination

Processes 50 attachments per page.

---

## Personal Data Erasers

### wp_register_comment_personal_data_eraser()

Registers the comment data eraser.

**File:** `wp-includes/comment.php`  
**Since:** 4.9.6

```php
wp_register_comment_personal_data_eraser( array $erasers ): array
```

---

### wp_comments_personal_data_eraser()

Erases personal data from comments by anonymizing them.

**File:** `wp-includes/comment.php`  
**Since:** 4.9.6

```php
wp_comments_personal_data_eraser( string $email_address, int $page = 1 ): array
```

#### Anonymization

| Field | Anonymized Value |
|-------|------------------|
| `comment_author` | "Anonymous" |
| `comment_author_email` | (empty) |
| `comment_author_url` | (empty) |
| `comment_author_IP` | Anonymized via `wp_privacy_anonymize_data()` |
| `comment_agent` | (empty) |
| `user_id` | 0 |

#### Pagination

Processes 500 comments per page.

---

## Anonymization Functions

### wp_privacy_anonymize_data()

Returns anonymous data by type.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_privacy_anonymize_data( string $type, string $data = '' ): string
```

#### Type Values

| Type | Anonymized Value |
|------|------------------|
| `email` | `deleted@site.invalid` |
| `url` | `https://site.invalid` |
| `ip` | Anonymized IP via `wp_privacy_anonymize_ip()` |
| `date` | `0000-00-00 00:00:00` |
| `text` | `[deleted]` |
| `longtext` | "This content was deleted by the author." |

---

### wp_privacy_anonymize_ip()

Anonymizes an IPv4 or IPv6 address.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_privacy_anonymize_ip( string $ip_addr, bool $ipv6_fallback = false ): string
```

#### Anonymization Method

- **IPv4:** Last octet replaced with `0` (e.g., `192.168.1.100` → `192.168.1.0`)
- **IPv6:** Masked to /64 network ID (e.g., first 64 bits preserved)

---

## Export File Management

### wp_privacy_exports_dir()

Returns the directory for storing personal data exports.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_privacy_exports_dir(): string
```

#### Returns

Default: `{uploads_basedir}/wp-personal-data-exports/`

---

### wp_privacy_exports_url()

Returns the URL for the exports directory.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_privacy_exports_url(): string
```

---

### wp_schedule_delete_old_privacy_export_files()

Schedules the cron job to delete expired exports.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_schedule_delete_old_privacy_export_files(): void
```

#### Notes

- Runs hourly
- Hook: `wp_privacy_delete_old_export_files`

---

### wp_privacy_delete_old_export_files()

Deletes export files older than the expiration time.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
wp_privacy_delete_old_export_files(): void
```

#### Notes

- Default expiration: 3 days
- Excludes `index.php`
- Limited to 100 files per run

---

## Privacy Policy Functions

### get_privacy_policy_url()

Retrieves the URL to the privacy policy page.

**File:** `wp-includes/link-template.php`  
**Since:** 4.9.6

```php
get_privacy_policy_url(): string
```

#### Returns

- Privacy policy page URL if set and published
- Empty string if not configured

---

### the_privacy_policy_link()

Displays the privacy policy link with formatting.

**File:** `wp-includes/link-template.php`  
**Since:** 4.9.6

```php
the_privacy_policy_link( string $before = '', string $after = '' ): void
```

---

### get_the_privacy_policy_link()

Returns the privacy policy link markup.

**File:** `wp-includes/link-template.php`  
**Since:** 4.9.6

```php
get_the_privacy_policy_link( string $before = '', string $after = '' ): string
```

#### Returns

```html
<a class="privacy-policy-link" href="{url}" rel="privacy-policy">{Page Title}</a>
```

---

## Internal/Notification Functions

### _wp_privacy_account_request_confirmed()

Updates the request when user confirms.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6  
**Access:** Private

```php
_wp_privacy_account_request_confirmed( int $request_id ): void
```

---

### _wp_privacy_send_request_confirmation_notification()

Sends admin notification when request is confirmed.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6  
**Access:** Private

```php
_wp_privacy_send_request_confirmation_notification( int $request_id ): void
```

---

### _wp_privacy_send_erasure_fulfillment_notification()

Notifies user when their erasure request is complete.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6  
**Access:** Private

```php
_wp_privacy_send_erasure_fulfillment_notification( int $request_id ): void
```

---

### _wp_privacy_account_request_confirmed_message()

Returns the confirmation message HTML.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6  
**Access:** Private

```php
_wp_privacy_account_request_confirmed_message( int $request_id ): string
```
