# WordPress Privacy Hooks

This document covers all actions and filters related to WordPress's privacy and GDPR compliance system.

## Actions

### user_request_action_confirmed

Fires when a user confirms a privacy request via email link.

**File:** `wp-includes/default-filters.php`  
**Since:** 4.9.6

```php
do_action( 'user_request_action_confirmed', int $request_id )
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$request_id` | `int` | The ID of the confirmed request |

#### Default Callbacks

| Callback | Priority | Description |
|----------|----------|-------------|
| `_wp_privacy_account_request_confirmed` | 10 | Updates request status |
| `_wp_privacy_send_request_confirmation_notification` | 12 | Sends admin notification |

---

### wp_privacy_delete_old_export_files

Scheduled cron action to delete expired export files.

**File:** `wp-includes/default-filters.php`  
**Since:** 4.9.6

```php
do_action( 'wp_privacy_delete_old_export_files' )
```

#### Default Callbacks

| Callback | Priority | Description |
|----------|----------|-------------|
| `wp_privacy_delete_old_export_files` | 10 | Deletes files older than 3 days |

---

## Filters

### Exporter/Eraser Registration

#### wp_privacy_personal_data_exporters

Filters the array of personal data exporters.

**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_personal_data_exporters', array $exporters )
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$exporters` | `array` | Array of registered exporters |

#### Exporter Structure

```php
$exporters['exporter-id'] = array(
    'exporter_friendly_name' => 'Friendly Name',
    'callback'               => 'callback_function_name',
);
```

#### Default Exporters

| ID | Registered By |
|----|---------------|
| `wordpress-user` | `wp_register_user_personal_data_exporter()` |
| `wordpress-comments` | `wp_register_comment_personal_data_exporter()` |
| `wordpress-media` | `wp_register_media_personal_data_exporter()` |

---

#### wp_privacy_personal_data_erasers

Filters the array of personal data erasers.

**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_personal_data_erasers', array $erasers )
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$erasers` | `array` | Array of registered erasers |

#### Eraser Structure

```php
$erasers['eraser-id'] = array(
    'eraser_friendly_name' => 'Friendly Name',
    'callback'             => 'callback_function_name',
);
```

#### Default Erasers

| ID | Registered By |
|----|---------------|
| `wordpress-comments` | `wp_register_comment_personal_data_eraser()` |

---

### User Profile Export

#### wp_privacy_additional_user_profile_data

Filters additional user profile data for privacy export.

**File:** `wp-includes/user.php`  
**Since:** 5.4.0

```php
apply_filters( 
    'wp_privacy_additional_user_profile_data', 
    array $additional_data, 
    WP_User $user, 
    string[] $reserved_names 
)
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$additional_data` | `array` | Additional name-value pairs to export |
| `$user` | `WP_User` | The user being exported |
| `$reserved_names` | `string[]` | Field names already exported (cannot be duplicated) |

#### Example

```php
add_filter( 'wp_privacy_additional_user_profile_data', function( $data, $user, $reserved ) {
    $data[] = array(
        'name'  => 'Custom Field',
        'value' => get_user_meta( $user->ID, 'custom_field', true ),
    );
    return $data;
}, 10, 3 );
```

---

### Comment Anonymization

#### wp_anonymize_comment

Filters whether to anonymize a specific comment.

**File:** `wp-includes/comment.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'wp_anonymize_comment', 
    bool|string $anon_message, 
    WP_Comment $comment, 
    array $anonymized_comment 
)
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$anon_message` | `bool\|string` | `true` to anonymize, or message explaining why not |
| `$comment` | `WP_Comment` | The comment object |
| `$anonymized_comment` | `array` | The anonymized data that will be used |

#### Example

```php
// Prevent anonymizing comments on specific posts
add_filter( 'wp_anonymize_comment', function( $anon, $comment, $anon_data ) {
    if ( $comment->comment_post_ID === 123 ) {
        return 'Comments on this post cannot be anonymized.';
    }
    return $anon;
}, 10, 3 );
```

---

### Email Filters - Request Confirmation

#### user_request_action_email_subject

Filters the subject of the confirmation request email sent to users.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_request_action_email_subject', 
    string $subject, 
    string $sitename, 
    array $email_data 
)
```

---

#### user_request_action_email_content

Filters the body of the confirmation request email.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_request_action_email_content', 
    string $content, 
    array $email_data 
)
```

#### Placeholders

| Placeholder | Replacement |
|-------------|-------------|
| `###DESCRIPTION###` | Action description |
| `###CONFIRM_URL###` | Confirmation link |
| `###SITENAME###` | Site name |
| `###SITEURL###` | Site URL |

---

#### user_request_action_email_headers

Filters the headers of the confirmation request email.

**File:** `wp-includes/user.php`  
**Since:** 5.4.0

```php
apply_filters( 
    'user_request_action_email_headers', 
    string|array $headers, 
    string $subject, 
    string $content, 
    int $request_id, 
    array $email_data 
)
```

---

### Email Filters - Admin Notification

#### user_request_confirmed_email_to

Filters the admin email recipient for confirmed requests.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_request_confirmed_email_to', 
    string $admin_email, 
    WP_User_Request $request 
)
```

#### Notes

- In multisite, defaults to network admin email
- Use to delegate to a dedicated privacy officer

---

#### user_request_confirmed_email_subject

Filters the subject of the admin notification email.

**File:** `wp-includes/user.php`  
**Since:** 4.9.8

```php
apply_filters( 
    'user_request_confirmed_email_subject', 
    string $subject, 
    string $sitename, 
    array $email_data 
)
```

---

#### user_request_confirmed_email_content

Filters the body of the admin notification email.

**File:** `wp-includes/user.php`  
**Since:** 5.8.0

```php
apply_filters( 
    'user_request_confirmed_email_content', 
    string $content, 
    array $email_data 
)
```

#### Placeholders

| Placeholder | Replacement |
|-------------|-------------|
| `###SITENAME###` | Site name |
| `###USER_EMAIL###` | User's email address |
| `###DESCRIPTION###` | Action description |
| `###MANAGE_URL###` | Admin management URL |
| `###SITEURL###` | Site URL |

---

#### user_request_confirmed_email_headers

Filters the headers of the admin notification email.

**File:** `wp-includes/user.php`  
**Since:** 5.4.0

```php
apply_filters( 
    'user_request_confirmed_email_headers', 
    string|array $headers, 
    string $subject, 
    string $content, 
    int $request_id, 
    array $email_data 
)
```

---

### Email Filters - Erasure Fulfillment

#### user_erasure_fulfillment_email_to

Filters the recipient of the erasure completion notification.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_erasure_fulfillment_email_to', 
    string $user_email, 
    WP_User_Request $request 
)
```

---

#### user_erasure_fulfillment_email_subject

Filters the subject of the erasure completion email.

**File:** `wp-includes/user.php`  
**Since:** 5.8.0

```php
apply_filters( 
    'user_erasure_fulfillment_email_subject', 
    string $subject, 
    string $sitename, 
    array $email_data 
)
```

---

#### user_erasure_fulfillment_email_content

Filters the body of the erasure completion email.

**File:** `wp-includes/user.php`  
**Since:** 5.8.0

```php
apply_filters( 
    'user_erasure_fulfillment_email_content', 
    string $content, 
    array $email_data 
)
```

#### Placeholders

| Placeholder | Replacement |
|-------------|-------------|
| `###SITENAME###` | Site name |
| `###PRIVACY_POLICY_URL###` | Privacy policy URL |
| `###SITEURL###` | Site URL |

---

#### user_erasure_fulfillment_email_headers

Filters the headers of the erasure completion email.

**File:** `wp-includes/user.php`  
**Since:** 5.8.0

```php
apply_filters( 
    'user_erasure_fulfillment_email_headers', 
    string|array $headers, 
    string $subject, 
    string $content, 
    int $request_id, 
    array $email_data 
)
```

---

### Confirmation Message

#### user_request_action_confirmed_message

Filters the message shown after a user confirms their request.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_request_action_confirmed_message', 
    string $message, 
    int $request_id 
)
```

---

### Request Description

#### user_request_action_description

Filters the human-readable action description.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 
    'user_request_action_description', 
    string $description, 
    string $action_name 
)
```

---

### Key Expiration

#### user_request_key_expiration

Filters the expiration time for confirmation keys.

**File:** `wp-includes/user.php`  
**Since:** 4.9.6

```php
apply_filters( 'user_request_key_expiration', int $expiration )
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$expiration` | `int` | `DAY_IN_SECONDS` | Expiration time in seconds |

#### Example

```php
// Extend confirmation key validity to 3 days
add_filter( 'user_request_key_expiration', function() {
    return 3 * DAY_IN_SECONDS;
} );
```

---

### Export File Expiration

#### wp_privacy_export_expiration

Filters the lifetime of personal data export files.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_export_expiration', int $expiration )
```

#### Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `$expiration` | `int` | `3 * DAY_IN_SECONDS` | File lifetime in seconds |

---

### Export Directories

#### wp_privacy_exports_dir

Filters the directory for storing exports.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_exports_dir', string $exports_dir )
```

---

#### wp_privacy_exports_url

Filters the URL for the exports directory.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_exports_url', string $exports_url )
```

---

### Privacy Policy

#### privacy_policy_url

Filters the privacy policy page URL.

**File:** `wp-includes/link-template.php`  
**Since:** 4.9.6

```php
apply_filters( 'privacy_policy_url', string $url, int $policy_page_id )
```

---

#### the_privacy_policy_link

Filters the privacy policy link HTML.

**File:** `wp-includes/link-template.php`  
**Since:** 4.9.6

```php
apply_filters( 'the_privacy_policy_link', string $link, string $privacy_policy_url )
```

---

### Anonymization

#### wp_privacy_anonymize_data

Filters anonymized data values.

**File:** `wp-includes/functions.php`  
**Since:** 4.9.6

```php
apply_filters( 'wp_privacy_anonymize_data', string $anonymous, string $type, string $data )
```

#### Parameters

| Parameter | Type | Description |
|-----------|------|-------------|
| `$anonymous` | `string` | The anonymized value |
| `$type` | `string` | Type of data (email, url, ip, date, text, longtext) |
| `$data` | `string` | Original data |

---

## Deprecated Filters

### user_confirmed_action_email_content

**Deprecated:** 5.8.0  
**Replacement:** `user_request_confirmed_email_content` or `user_erasure_fulfillment_email_content`

---

### user_erasure_complete_email_subject

**Deprecated:** 5.8.0  
**Replacement:** `user_erasure_fulfillment_email_subject`

---

### user_erasure_complete_email_headers

**Deprecated:** 5.8.0  
**Replacement:** `user_erasure_fulfillment_email_headers`

---

## Email Data Arrays

Most email filters receive an `$email_data` array. Here are the common structures:

### Request Confirmation Email

```php
$email_data = array(
    'request'     => WP_User_Request,
    'email'       => 'user@example.com',
    'description' => 'Export Personal Data',
    'confirm_url' => 'https://example.com/wp-login.php?action=confirmaction&...',
    'sitename'    => 'Example Site',
    'siteurl'     => 'https://example.com',
);
```

### Admin Notification Email

```php
$email_data = array(
    'request'     => WP_User_Request,
    'user_email'  => 'user@example.com',
    'description' => 'Export Personal Data',
    'manage_url'  => 'https://example.com/wp-admin/export-personal-data.php',
    'sitename'    => 'Example Site',
    'siteurl'     => 'https://example.com',
    'admin_email' => 'admin@example.com',
);
```

### Erasure Fulfillment Email

```php
$email_data = array(
    'request'            => WP_User_Request,
    'message_recipient'  => 'user@example.com',
    'privacy_policy_url' => 'https://example.com/privacy-policy/',
    'sitename'           => 'Example Site',
    'siteurl'            => 'https://example.com',
);
```
