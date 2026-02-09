# WordPress Privacy System Overview

WordPress includes a comprehensive privacy and GDPR compliance system introduced in version 4.9.6. This system enables sites to handle personal data requests from users, including data export and erasure (right to be forgotten).

## Core Concepts

### Personal Data Requests

WordPress handles two types of privacy-related requests:

| Request Type | Action Name | Description |
|-------------|-------------|-------------|
| Export Personal Data | `export_personal_data` | Exports all personal data associated with an email address |
| Erase Personal Data | `remove_personal_data` | Anonymizes or deletes personal data associated with an email address |

### Request Workflow

1. **Request Creation** - Admin or user initiates a request via the privacy tools
2. **Email Verification** - A confirmation email is sent to the user's email address
3. **User Confirmation** - User clicks the confirmation link to verify ownership
4. **Admin Notification** - Site admin receives notification of the confirmed request
5. **Request Processing** - Admin processes the export or erasure
6. **User Notification** - User receives notification when their request is fulfilled

### Request Statuses

Requests are stored as a custom post type (`user_request`) with these statuses:

| Status | Description |
|--------|-------------|
| `request-pending` | Awaiting user email confirmation |
| `request-confirmed` | User confirmed, awaiting admin processing |
| `request-failed` | Email sending failed |
| `request-completed` | Request has been fulfilled |

## Personal Data Exporters

The export system uses a plugin-based architecture. Exporters are registered via the `wp_privacy_personal_data_exporters` filter.

### Built-in Exporters

| Exporter ID | Friendly Name | Source |
|-------------|---------------|--------|
| `wordpress-user` | WordPress User | `user.php` |
| `wordpress-comments` | WordPress Comments | `comment.php` |
| `wordpress-media` | WordPress Media | `media.php` |

### Exporter Callback Format

```php
function my_exporter_callback( $email_address, $page = 1 ) {
    return array(
        'data' => array(
            array(
                'group_id'          => 'my-group',
                'group_label'       => 'My Data Group',
                'group_description' => 'Description of this data group.',
                'item_id'           => 'item-123',
                'data'              => array(
                    array(
                        'name'  => 'Field Name',
                        'value' => 'Field Value',
                    ),
                ),
            ),
        ),
        'done' => true, // false if more pages exist
    );
}
```

### Registering a Custom Exporter

```php
add_filter( 'wp_privacy_personal_data_exporters', function( $exporters ) {
    $exporters['my-plugin'] = array(
        'exporter_friendly_name' => 'My Plugin Data',
        'callback'               => 'my_plugin_personal_data_exporter',
    );
    return $exporters;
} );
```

## Personal Data Erasers

Erasers handle anonymization or deletion of personal data. Registered via `wp_privacy_personal_data_erasers` filter.

### Built-in Erasers

| Eraser ID | Friendly Name | Source |
|-----------|---------------|--------|
| `wordpress-comments` | WordPress Comments | `comment.php` |

Note: WordPress does not include an eraser for user accounts or media by default, as deletion may have wider implications.

### Eraser Callback Format

```php
function my_eraser_callback( $email_address, $page = 1 ) {
    return array(
        'items_removed'  => true,  // Were items actually removed?
        'items_retained' => false, // Were items retained (couldn't delete)?
        'messages'       => array(), // Messages to include in results
        'done'           => true,  // false if more pages exist
    );
}
```

### Registering a Custom Eraser

```php
add_filter( 'wp_privacy_personal_data_erasers', function( $erasers ) {
    $erasers['my-plugin'] = array(
        'eraser_friendly_name' => 'My Plugin Data',
        'callback'             => 'my_plugin_personal_data_eraser',
    );
    return $erasers;
} );
```

## Data Anonymization

WordPress provides helper functions for consistent data anonymization:

```php
// Anonymize different data types
wp_privacy_anonymize_data( 'email' );    // Returns: 'deleted@site.invalid'
wp_privacy_anonymize_data( 'url' );      // Returns: 'https://site.invalid'
wp_privacy_anonymize_data( 'ip', $ip );  // Returns anonymized IP
wp_privacy_anonymize_data( 'date' );     // Returns: '0000-00-00 00:00:00'
wp_privacy_anonymize_data( 'text' );     // Returns: '[deleted]'
wp_privacy_anonymize_data( 'longtext' ); // Returns longer deletion message
```

## Privacy Policy Page

WordPress supports designating a Privacy Policy page:

```php
// Get the privacy policy URL
$url = get_privacy_policy_url();

// Display the privacy policy link
the_privacy_policy_link( 'Before text ', ' After text' );

// Get link markup
$link = get_the_privacy_policy_link( '<span>', '</span>' );
```

The privacy policy page ID is stored in the `wp_page_for_privacy_policy` option.

## Export File Management

Personal data exports are stored as files in `wp-content/uploads/wp-personal-data-exports/`.

- Files include a cryptographically secure random string in the filename
- Files are automatically deleted after 3 days via cron job
- The `wp_privacy_export_expiration` filter can modify the expiration time

## Admin Screens

The privacy system adds two admin screens:

| Screen | URL | Purpose |
|--------|-----|---------|
| Export Personal Data | `/wp-admin/export-personal-data.php` | Manage export requests |
| Erase Personal Data | `/wp-admin/erase-personal-data.php` | Manage erasure requests |

## GDPR Compliance Notes

While WordPress provides the technical infrastructure for GDPR compliance, site owners are responsible for:

1. **Privacy Policy** - Creating and maintaining an appropriate privacy policy
2. **Data Inventory** - Understanding what personal data is collected
3. **Consent** - Obtaining proper consent for data collection
4. **Third Parties** - Ensuring plugins and themes also comply
5. **Processing Requests** - Responding to data requests within required timeframes

## Related Files

| File | Contents |
|------|----------|
| `wp-includes/class-wp-user-request.php` | `WP_User_Request` class |
| `wp-includes/user.php` | Request handling functions |
| `wp-includes/functions.php` | Anonymization and export utilities |
| `wp-includes/comment.php` | Comment exporter/eraser |
| `wp-includes/media.php` | Media exporter |
| `wp-includes/link-template.php` | Privacy policy link functions |
| `wp-includes/default-filters.php` | Hook registrations |

## Version History

| Version | Changes |
|---------|---------|
| 4.9.6 | Initial privacy system introduced |
| 5.4.0 | Added Community Events Location and Session Tokens to user export |
| 5.7.0 | Added `$status` parameter to `wp_create_user_request()` |
| 5.8.0 | Deprecated some email content filters, added new ones |
| 6.2.0 | Added `privacy-policy` rel attribute to policy links |
| 6.8.0 | Confirmation keys now use `wp_fast_hash()` instead of phpass |
