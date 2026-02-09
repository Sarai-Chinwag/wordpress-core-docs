# WordPress Multisite Hooks Reference

Complete reference for all WordPress Multisite actions and filters.

## Site Lifecycle Hooks

### wp_insert_site

Fires once a site has been inserted into the database.

```php
do_action( 'wp_insert_site', WP_Site $new_site )
```

**Parameters:**
- `$new_site` (WP_Site) - New site object

**Since:** 5.1.0

---

### wp_initialize_site

Fires when a site's initialization routine should be executed.

```php
do_action( 'wp_initialize_site', WP_Site $new_site, array $args )
```

**Parameters:**
- `$new_site` (WP_Site) - New site object
- `$args` (array) - Arguments for initialization

**Since:** 5.1.0

**Note:** This is where database tables are created and defaults populated.

---

### wp_update_site

Fires once a site has been updated in the database.

```php
do_action( 'wp_update_site', WP_Site $new_site, WP_Site $old_site )
```

**Parameters:**
- `$new_site` (WP_Site) - New site object
- `$old_site` (WP_Site) - Old site object

**Since:** 5.1.0

---

### wp_delete_site

Fires once a site has been deleted from the database.

```php
do_action( 'wp_delete_site', WP_Site $old_site )
```

**Parameters:**
- `$old_site` (WP_Site) - Deleted site object

**Since:** 5.1.0

---

### wp_validate_site_deletion

Fires before a site is deleted. Use to add validation errors.

```php
do_action( 'wp_validate_site_deletion', WP_Error $errors, WP_Site $old_site )
```

**Parameters:**
- `$errors` (WP_Error) - Error object to add validation errors to
- `$old_site` (WP_Site) - Site object to be deleted

**Since:** 5.1.0

---

### wp_uninitialize_site

Fires when a site's uninitialization routine should be executed.

```php
do_action( 'wp_uninitialize_site', WP_Site $old_site )
```

**Parameters:**
- `$old_site` (WP_Site) - Deleted site object

**Since:** 5.1.0

---

### wpmu_new_blog (Deprecated)

Fires immediately after a new site is created.

```php
do_action_deprecated( 'wpmu_new_blog', array( $site_id, $user_id, $domain, $path, $network_id, $meta ), '5.1.0', 'wp_initialize_site' )
```

**Deprecated:** 5.1.0 - Use `wp_initialize_site` instead.

---

### delete_blog (Deprecated)

Fires before a site is deleted.

```php
do_action_deprecated( 'delete_blog', array( $site_id, true ), '5.1.0' )
```

**Deprecated:** 5.1.0

---

### deleted_blog (Deprecated)

Fires after a site is deleted from the network.

```php
do_action_deprecated( 'deleted_blog', array( $site_id, true ), '5.1.0' )
```

**Deprecated:** 5.1.0

---

## Site Status Hooks

### make_spam_blog

Fires when the 'spam' status is added to a site.

```php
do_action( 'make_spam_blog', int $site_id )
```

**Since:** MU (3.0.0)

---

### make_ham_blog

Fires when the 'spam' status is removed from a site.

```php
do_action( 'make_ham_blog', int $site_id )
```

**Since:** MU (3.0.0)

---

### mature_blog

Fires when the 'mature' status is added to a site.

```php
do_action( 'mature_blog', int $site_id )
```

**Since:** 3.1.0

---

### unmature_blog

Fires when the 'mature' status is removed from a site.

```php
do_action( 'unmature_blog', int $site_id )
```

**Since:** 3.1.0

---

### archive_blog

Fires when the 'archived' status is added to a site.

```php
do_action( 'archive_blog', int $site_id )
```

**Since:** MU (3.0.0)

---

### unarchive_blog

Fires when the 'archived' status is removed from a site.

```php
do_action( 'unarchive_blog', int $site_id )
```

**Since:** MU (3.0.0)

---

### make_delete_blog

Fires when the 'deleted' flag is added to a site.

```php
do_action( 'make_delete_blog', int $site_id )
```

**Since:** 3.5.0

---

### make_undelete_blog

Fires when the 'deleted' flag is removed from a site.

```php
do_action( 'make_undelete_blog', int $site_id )
```

**Since:** 3.5.0

---

### update_blog_public

Fires after the current blog's 'public' setting is updated.

```php
do_action( 'update_blog_public', int $site_id, string $is_public )
```

**Parameters:**
- `$site_id` (int) - Site ID
- `$is_public` (string) - '1' or '0'

**Since:** MU (3.0.0)

---

### wpmu_blog_updated

Fires after the blog details are updated.

```php
do_action( 'wpmu_blog_updated', int $blog_id )
```

**Since:** MU (3.0.0)

---

## Site Switching Hooks

### switch_blog

Fires when the blog is switched.

```php
do_action( 'switch_blog', int $new_blog_id, int $prev_blog_id, string $context )
```

**Parameters:**
- `$new_blog_id` (int) - New blog ID
- `$prev_blog_id` (int) - Previous blog ID
- `$context` (string) - 'switch' or 'restore'

**Since:** MU (3.0.0), 5.4.0 (added `$context`)

**Example:**
```php
add_action( 'switch_blog', function( $new_blog_id, $prev_blog_id, $context ) {
    if ( 'switch' === $context ) {
        // Switched to a different blog
    } else {
        // Restored from a switch
    }
}, 10, 3 );
```

---

## User Hooks

### add_user_to_blog

Fires immediately after a user is added to a site.

```php
do_action( 'add_user_to_blog', int $user_id, string $role, int $blog_id )
```

**Parameters:**
- `$user_id` (int) - User ID
- `$role` (string) - User role
- `$blog_id` (int) - Blog ID

**Since:** MU (3.0.0)

---

### remove_user_from_blog

Fires before a user is removed from a site.

```php
do_action( 'remove_user_from_blog', int $user_id, int $blog_id, int $reassign )
```

**Parameters:**
- `$user_id` (int) - User ID being removed
- `$blog_id` (int) - Blog ID
- `$reassign` (int) - User ID to reassign posts to

**Since:** MU (3.0.0), 5.4.0 (added `$reassign`)

---

### added_existing_user

Fires immediately after an existing user is added to a site.

```php
do_action( 'added_existing_user', int $user_id, true|WP_Error $result )
```

**Since:** MU (3.0.0)

---

### wpmu_new_user

Fires immediately after a new user is created.

```php
do_action( 'wpmu_new_user', int $user_id )
```

**Since:** MU (3.0.0)

**Note:** Only fires in Multisite. For all user creations, use `user_register`.

---

### wpmu_activate_user

Fires immediately after a new user is activated.

```php
do_action( 'wpmu_activate_user', int $user_id, string $password, array $meta )
```

**Parameters:**
- `$user_id` (int) - User ID
- `$password` (string) - User password
- `$meta` (array) - Signup meta data

**Since:** MU (3.0.0)

---

### wpmu_activate_blog

Fires immediately after a site is activated.

```php
do_action( 'wpmu_activate_blog', int $blog_id, int $user_id, string $password, string $title, array $meta )
```

**Since:** MU (3.0.0)

---

### make_spam_user

Fires when a user is marked as spam.

```php
do_action( 'make_spam_user', int $user_id )
```

---

### make_ham_user

Fires when a user is unmarked as spam.

```php
do_action( 'make_ham_user', int $user_id )
```

---

## Signup Hooks

### after_signup_site

Fires after site signup information has been written to the database.

```php
do_action( 'after_signup_site', string $domain, string $path, string $title, string $user, string $user_email, string $key, array $meta )
```

**Since:** 4.4.0

---

### after_signup_user

Fires after a user's signup information has been written to the database.

```php
do_action( 'after_signup_user', string $user, string $user_email, string $key, array $meta )
```

**Since:** 4.4.0

---

### signup_hidden_fields

Fires in the signup form for additional hidden fields.

```php
do_action( 'signup_hidden_fields' )
```

---

## Network Hooks

### ms_network_not_found

Fires when a network cannot be found based on the requested domain and path.

```php
do_action( 'ms_network_not_found', string $domain, string $path )
```

**Since:** 4.4.0

---

### ms_site_not_found

Fires when a network can be determined but a site cannot.

```php
do_action( 'ms_site_not_found', WP_Network $current_site, string $domain, string $path )
```

**Since:** 3.9.0

---

### clean_network_cache

Fires immediately after a network has been removed from the object cache.

```php
do_action( 'clean_network_cache', int $id )
```

**Since:** 4.6.0

---

### clean_site_cache

Fires immediately after a site has been removed from the object cache.

```php
do_action( 'clean_site_cache', string $blog_id, WP_Site $blog, string $domain_path_key )
```

**Since:** 4.6.0

---

### refresh_blog_details (Deprecated)

Fires after the blog details cache is cleared.

```php
do_action_deprecated( 'refresh_blog_details', array( $blog_id ), '4.9.0', 'clean_site_cache' )
```

**Deprecated:** 4.9.0 - Use `clean_site_cache` instead.

---

## Site Meta Hooks

### added_blog_meta

Fires after site meta is added.

```php
do_action( 'added_blog_meta', int $mid, int $object_id, string $meta_key, mixed $_meta_value )
```

---

### updated_blog_meta

Fires after site meta is updated.

```php
do_action( 'updated_blog_meta', int $meta_id, int $object_id, string $meta_key, mixed $_meta_value )
```

---

### deleted_blog_meta

Fires after site meta is deleted.

```php
do_action( 'deleted_blog_meta', string[] $meta_ids, int $object_id, string $meta_key, mixed $_meta_value )
```

---

## Filters

### get_site

Filters a site after it is retrieved.

```php
apply_filters( 'get_site', WP_Site $_site )
```

**Since:** 4.6.0

---

### get_network

Filters a network after it is retrieved.

```php
apply_filters( 'get_network', WP_Network $_network )
```

**Since:** 4.6.0

---

### blog_details (Deprecated)

Filters a blog's details.

```php
apply_filters_deprecated( 'blog_details', array( $details ), '4.7.0', 'site_details' )
```

**Deprecated:** 4.7.0 - Use `site_details` instead.

---

### blog_option_{$option}

Filters a blog option value.

```php
apply_filters( "blog_option_{$option}", string $value, int $id )
```

**Example:**
```php
add_filter( 'blog_option_blogname', function( $value, $blog_id ) {
    return strtoupper( $value );
}, 10, 2 );
```

---

### can_add_user_to_blog

Filters whether a user should be added to a site.

```php
apply_filters( 'can_add_user_to_blog', true|WP_Error $retval, int $user_id, string $role, int $blog_id )
```

**Returns:** True to allow, WP_Error to prevent

**Since:** 4.9.0

---

### wp_normalize_site_data

Filters passed site data for normalization.

```php
apply_filters( 'wp_normalize_site_data', array $data )
```

**Since:** 5.1.0

---

### wp_validate_site_data

Fires when data should be validated for a site.

```php
do_action( 'wp_validate_site_data', WP_Error $errors, array $data, WP_Site|null $old_site )
```

**Parameters:**
- `$errors` (WP_Error) - Error object to add validation errors to
- `$data` (array) - Site data
- `$old_site` (WP_Site|null) - Old site object if updating, null if inserting

**Since:** 5.1.0

---

### wp_initialize_site_args

Filters the arguments for initializing a site.

```php
apply_filters( 'wp_initialize_site_args', array $args, WP_Site $site, WP_Network $network )
```

**Since:** 5.1.0

---

### domain_exists

Filters whether a site name is taken.

```php
apply_filters( 'domain_exists', int|null $result, string $domain, string $path, int $network_id )
```

**Returns:** Site ID if exists, null otherwise

**Since:** 3.5.0

---

### site_by_path_segments_count

Filters the number of path segments to consider when searching for a site.

```php
apply_filters( 'site_by_path_segments_count', int|null $segments, string $domain, string $path )
```

**Since:** 3.9.0

---

### pre_get_site_by_path

Short-circuits the site lookup by domain and path.

```php
apply_filters( 'pre_get_site_by_path', null|false|WP_Site $site, string $domain, string $path, int|null $segments, string[] $paths )
```

**Returns:** Null to continue, false for no site, or WP_Site object

**Since:** 3.9.0

---

### ms_site_check

Filters checking the status of the current blog.

```php
apply_filters( 'ms_site_check', bool|null $check )
```

**Returns:** Non-null to bypass the check

**Since:** 3.0.0

---

### pre_wp_is_site_initialized

Filters the check for whether a site is initialized.

```php
apply_filters( 'pre_wp_is_site_initialized', bool|null $pre, int $site_id )
```

**Since:** 5.1.0

---

### wpmu_drop_tables

Filters the tables to drop when the site is deleted.

```php
apply_filters( 'wpmu_drop_tables', string[] $tables, int $site_id )
```

**Since:** MU (3.0.0)

---

### wpmu_delete_blog_upload_dir

Filters the upload base directory to delete when the site is deleted.

```php
apply_filters( 'wpmu_delete_blog_upload_dir', string $basedir, int $site_id )
```

**Since:** MU (3.0.0)

---

### subdirectory_reserved_names

Filters reserved site names on a sub-directory installation.

```php
apply_filters( 'subdirectory_reserved_names', string[] $names )
```

**Since:** 3.0.0

---

### newblogname

Filters the new site name during registration.

```php
apply_filters( 'newblogname', string $blogname )
```

**Since:** MU (3.0.0)

---

### minimum_site_name_length

Filters the minimum site name length required.

```php
apply_filters( 'minimum_site_name_length', int $length )
```

**Default:** 4

**Since:** 4.8.0

---

## Signup & Validation Filters

### wpmu_validate_user_signup

Filters the validated user registration details.

```php
apply_filters( 'wpmu_validate_user_signup', array $result )
```

**Result Array:**
- `user_name` (string) - Sanitized username
- `orig_username` (string) - Original username
- `user_email` (string) - User email
- `errors` (WP_Error) - Validation errors

**Since:** MU (3.0.0)

---

### wpmu_validate_blog_signup

Filters site details and error messages following registration.

```php
apply_filters( 'wpmu_validate_blog_signup', array $result )
```

**Result Array:**
- `domain` (string) - Site domain
- `path` (string) - Site path
- `blogname` (string) - Site name
- `blog_title` (string) - Site title
- `user` (WP_User|string) - User object or empty
- `errors` (WP_Error) - Validation errors

**Since:** MU (3.0.0)

---

### is_email_address_unsafe

Filters whether an email address is unsafe.

```php
apply_filters( 'is_email_address_unsafe', bool $is_unsafe, string $user_email )
```

**Since:** 3.5.0

---

### illegal_user_logins

Filters the list of illegal user logins.

```php
apply_filters( 'illegal_user_logins', array $logins )
```

---

### signup_site_meta

Filters the metadata for a site signup.

```php
apply_filters( 'signup_site_meta', array $meta, string $domain, string $path, string $title, string $user, string $user_email, string $key )
```

**Since:** 4.8.0

---

### signup_user_meta

Filters the metadata for a user signup.

```php
apply_filters( 'signup_user_meta', array $meta, string $user, string $user_email, string $key )
```

**Since:** 4.8.0

---

## Notification Filters

### wpmu_signup_blog_notification

Filters whether to bypass the new site email notification.

```php
apply_filters( 'wpmu_signup_blog_notification', string|false $domain, string $path, string $title, string $user_login, string $user_email, string $key, array $meta )
```

**Returns:** Domain to send, or false to prevent

**Since:** MU (3.0.0)

---

### wpmu_signup_blog_notification_email

Filters the message content of the new blog notification email.

```php
apply_filters( 'wpmu_signup_blog_notification_email', string $content, string $domain, string $path, string $title, string $user_login, string $user_email, string $key, array $meta )
```

**Since:** MU (3.0.0)

---

### wpmu_signup_blog_notification_subject

Filters the subject of the new blog notification email.

```php
apply_filters( 'wpmu_signup_blog_notification_subject', string $subject, string $domain, string $path, string $title, string $user_login, string $user_email, string $key, array $meta )
```

**Since:** MU (3.0.0)

---

### wpmu_signup_user_notification

Filters whether to bypass the email notification for new user sign-up.

```php
apply_filters( 'wpmu_signup_user_notification', string $user_login, string $user_email, string $key, array $meta )
```

**Since:** MU (3.0.0)

---

### wpmu_signup_user_notification_email

Filters the content of the notification email for new user sign-up.

```php
apply_filters( 'wpmu_signup_user_notification_email', string $content, string $user_login, string $user_email, string $key, array $meta )
```

**Since:** MU (3.0.0)

---

### wpmu_signup_user_notification_subject

Filters the subject of the notification email of new user signup.

```php
apply_filters( 'wpmu_signup_user_notification_subject', string $subject, string $user_login, string $user_email, string $key, array $meta )
```

**Since:** MU (3.0.0)

---

### wpmu_welcome_notification

Filters whether to bypass the welcome email sent to site administrators.

```php
apply_filters( 'wpmu_welcome_notification', int|false $blog_id, int $user_id, string $password, string $title, array $meta )
```

**Since:** MU (3.0.0)

---

### update_welcome_email

Filters the content of the welcome email sent to site administrator.

```php
apply_filters( 'update_welcome_email', string $welcome_email, int $blog_id, int $user_id, string $password, string $title, array $meta )
```

**Since:** MU (3.0.0)

---

### update_welcome_subject

Filters the subject of the welcome email sent to site administrator.

```php
apply_filters( 'update_welcome_subject', string $subject )
```

**Since:** MU (3.0.0)

---

### wpmu_welcome_user_notification

Filters whether to bypass the welcome email after user activation.

```php
apply_filters( 'wpmu_welcome_user_notification', int $user_id, string $password, array $meta )
```

**Since:** MU (3.0.0)

---

### update_welcome_user_email

Filters the content of the welcome email after user activation.

```php
apply_filters( 'update_welcome_user_email', string $welcome_email, int $user_id, string $password, array $meta )
```

**Since:** MU (3.0.0)

---

### update_welcome_user_subject

Filters the subject of the welcome email after user activation.

```php
apply_filters( 'update_welcome_user_subject', string $subject )
```

**Since:** MU (3.0.0)

---

### newblog_notify_siteadmin

Filters the message body of the new site activation email.

```php
apply_filters( 'newblog_notify_siteadmin', string $msg, int|string $blog_id )
```

**Since:** MU (3.0.0), 5.4.0 (added `$blog_id`)

---

### newuser_notify_siteadmin

Filters the message body of the new user activation email.

```php
apply_filters( 'newuser_notify_siteadmin', string $msg, WP_User $user )
```

**Since:** MU (3.0.0)

---

### send_new_site_email

Filters whether to send an email to the network admin when a new site is created.

```php
apply_filters( 'send_new_site_email', bool $send, WP_Site $site, WP_User $user )
```

**Since:** 5.6.0

---

### new_site_email

Filters the content of the email sent to network admin when a new site is created.

```php
apply_filters( 'new_site_email', array $new_site_email, WP_Site $site, WP_User $user )
```

**Array Keys:** `to`, `subject`, `message`, `headers`

**Since:** 5.6.0

---

## Network Counts Filters

### enable_live_network_counts

Filters whether to update network site or user counts when a new site is created.

```php
apply_filters( 'enable_live_network_counts', bool $small_network, string $context )
```

**Parameters:**
- `$small_network` (bool) - Whether the network is considered small
- `$context` (string) - 'users' or 'sites'

**Since:** 3.7.0

---

### wp_is_large_network

Filters whether the network is considered large.

```php
apply_filters( 'wp_is_large_network', bool $is_large, string $component, int $count, int $network_id )
```

**Parameters:**
- `$is_large` (bool) - Whether >10,000 sites or users
- `$component` (string) - 'users' or 'sites'
- `$count` (int) - Count of items
- `$network_id` (int) - Network ID

**Since:** 3.3.0, 4.8.0 (added `$network_id`)

---

## Upload Filters

### pre_get_space_used

Filters the amount of storage space used by the current site.

```php
apply_filters( 'pre_get_space_used', int|false $space_used )
```

**Returns:** Space in megabytes, or false to calculate

**Since:** 3.5.0

---

### get_space_allowed

Filters the upload quota for the current site.

```php
apply_filters( 'get_space_allowed', int $space_allowed )
```

**Returns:** Quota in megabytes

**Since:** 3.7.0

---

## Redirect Filters

### blog_redirect_404

Filters the redirect URL for 404s on the main site.

```php
apply_filters( 'blog_redirect_404', string $destination )
```

**Since:** 3.0.0

---

### allowed_redirect_hosts

Filters the list of allowed redirect hosts.

```php
apply_filters( 'allowed_redirect_hosts', string[] $hosts, string $host )
```

---

## Site Meta Filters

### get_blog_metadata

Filters site meta before it's retrieved.

```php
apply_filters( 'get_blog_metadata', null|array|string $value, int $blog_id, string $meta_key, bool $single )
```

---

### add_blog_metadata

Filters before site meta is added.

```php
apply_filters( 'add_blog_metadata', null|bool $check, int $object_id, string $meta_key, mixed $meta_value, bool $unique )
```

---

### update_blog_metadata

Filters before site meta is updated.

```php
apply_filters( 'update_blog_metadata', null|bool $check, int $object_id, string $meta_key, mixed $meta_value, mixed $prev_value )
```

---

### delete_blog_metadata

Filters before site meta is deleted.

```php
apply_filters( 'delete_blog_metadata', null|bool $check, int $object_id, string $meta_key, mixed $meta_value, bool $delete_all )
```

---

### update_blog_metadata_cache

Filters before the site metadata cache is updated.

```php
apply_filters( 'update_blog_metadata_cache', null|array $cache, int[] $blog_ids )
```

---

## Email Change Filters

### new_network_admin_email_content

Filters the text of the email sent when a change of network admin email address is attempted.

```php
apply_filters( 'new_network_admin_email_content', string $email_text, array $new_admin_email )
```

**Placeholders:** `###USERNAME###`, `###ADMIN_URL###`, `###EMAIL###`, `###SITENAME###`, `###SITEURL###`

**Since:** 4.9.0

---

### send_network_admin_email_change_email

Filters whether to send the network admin email change notification email.

```php
apply_filters( 'send_network_admin_email_change_email', bool $send, string $old_email, string $new_email, int $network_id )
```

**Since:** 4.9.0

---

### network_admin_email_change_email

Filters the contents of the email notification sent when the network admin email address is changed.

```php
apply_filters( 'network_admin_email_change_email', array $email_change_email, string $old_email, string $new_email, int $network_id )
```

**Since:** 4.9.0

---

## Default Filters (ms-default-filters.php)

These filters and actions are registered by default:

### Actions

```php
// Initialization
add_action( 'init', 'ms_subdomain_constants' );

// Blog public option
add_action( 'update_option_blog_public', 'update_blog_public', 10, 2 );

// User signup
add_filter( 'wpmu_validate_user_signup', 'signup_nonce_check' );
add_action( 'init', 'maybe_add_existing_user_to_blog' );
add_action( 'wpmu_new_user', 'newuser_notify_siteadmin' );
add_action( 'wpmu_activate_user', 'add_new_user_to_blog', 10, 3 );
add_action( 'wpmu_activate_user', 'wpmu_welcome_user_notification', 10, 3 );
add_action( 'after_signup_user', 'wpmu_signup_user_notification', 10, 4 );

// New user notifications
add_action( 'network_site_new_created_user', 'wp_send_new_user_notifications' );
add_action( 'network_site_users_created_user', 'wp_send_new_user_notifications' );
add_action( 'network_user_new_created_user', 'wp_send_new_user_notifications' );

// Roles
add_action( 'switch_blog', 'wp_switch_roles_and_user', 1, 2 );

// Site lifecycle
add_filter( 'wpmu_validate_blog_signup', 'signup_nonce_check' );
add_action( 'wpmu_activate_blog', 'wpmu_welcome_notification', 10, 5 );
add_action( 'after_signup_site', 'wpmu_signup_blog_notification', 10, 7 );
add_filter( 'wp_normalize_site_data', 'wp_normalize_site_data', 10, 1 );
add_action( 'wp_validate_site_data', 'wp_validate_site_data', 10, 3 );
add_action( 'wp_insert_site', 'wp_maybe_update_network_site_counts_on_update', 10, 1 );
add_action( 'wp_update_site', 'wp_maybe_update_network_site_counts_on_update', 10, 2 );
add_action( 'wp_delete_site', 'wp_maybe_update_network_site_counts_on_update', 10, 1 );
add_action( 'wp_insert_site', 'wp_maybe_transition_site_statuses_on_update', 10, 1 );
add_action( 'wp_update_site', 'wp_maybe_transition_site_statuses_on_update', 10, 2 );
add_action( 'wp_update_site', 'wp_maybe_clean_new_site_cache_on_update', 10, 2 );
add_action( 'wp_initialize_site', 'wp_initialize_site', 10, 2 );
add_action( 'wp_initialize_site', 'wpmu_log_new_registrations', 100, 2 );
add_action( 'wp_initialize_site', 'newblog_notify_siteadmin', 100, 1 );
add_action( 'wp_uninitialize_site', 'wp_uninitialize_site', 10, 1 );
add_action( 'update_blog_public', 'wp_update_blog_public_option_on_site_update', 1, 2 );

// Site meta
add_action( 'added_blog_meta', 'wp_cache_set_sites_last_changed' );
add_action( 'updated_blog_meta', 'wp_cache_set_sites_last_changed' );
add_action( 'deleted_blog_meta', 'wp_cache_set_sites_last_changed' );

// Template
add_action( 'template_redirect', 'maybe_redirect_404' );

// Administration
add_action( 'after_delete_post', '_update_posts_count_on_delete', 10, 2 );
add_action( 'delete_post', '_update_blog_date_on_post_delete' );
add_action( 'transition_post_status', '_update_blog_date_on_post_publish', 10, 3 );
add_action( 'transition_post_status', '_update_posts_count_on_transition_post_status', 10, 3 );

// Network counts
add_action( 'admin_init', 'wp_schedule_update_network_counts' );
add_action( 'update_network_counts', 'wp_update_network_counts', 10, 0 );
foreach ( array( 'wpmu_new_user', 'make_spam_user', 'make_ham_user' ) as $action ) {
    add_action( $action, 'wp_maybe_update_network_user_counts', 10, 0 );
}
foreach ( array( 'make_spam_blog', 'make_ham_blog', 'archive_blog', 'unarchive_blog', 'make_delete_blog', 'make_undelete_blog' ) as $action ) {
    add_action( $action, 'wp_maybe_update_network_site_counts', 10, 0 );
}

// Files
add_filter( 'wp_upload_bits', 'upload_is_file_too_big' );
add_filter( 'import_upload_size_limit', 'fix_import_form_size' );
add_filter( 'upload_mimes', 'check_upload_mimes' );
add_filter( 'upload_size_limit', 'upload_size_limit_filter' );

// Mail
add_action( 'phpmailer_init', 'fix_phpmailer_messageid' );

// Disabled features
add_filter( 'enable_update_services_configuration', '__return_false' );
add_filter( 'force_filtered_html_on_import', '__return_true' );

// Site details cache
add_action( 'update_option_blogname', 'clean_site_details_cache', 10, 0 );
add_action( 'update_option_siteurl', 'clean_site_details_cache', 10, 0 );
add_action( 'update_option_post_count', 'clean_site_details_cache', 10, 0 );
add_action( 'update_option_home', 'clean_site_details_cache', 10, 0 );

// HTTP requests
add_filter( 'http_request_host_is_external', 'ms_allowed_http_request_hosts', 20, 2 );
```

### Filters

```php
add_filter( 'option_users_can_register', 'users_can_register_signup_filter' );
add_filter( 'site_option_welcome_user_email', 'welcome_user_msg_filter' );
add_filter( 'sanitize_user', 'strtolower' );
add_filter( 'allowed_redirect_hosts', 'redirect_this_site' );
add_filter( 'default_site_option_ms_files_rewriting', '__return_true' );

// Site meta support checks
add_filter( 'get_blog_metadata', 'wp_check_site_meta_support_prefilter' );
add_filter( 'add_blog_metadata', 'wp_check_site_meta_support_prefilter' );
add_filter( 'update_blog_metadata', 'wp_check_site_meta_support_prefilter' );
add_filter( 'delete_blog_metadata', 'wp_check_site_meta_support_prefilter' );
add_filter( 'get_blog_metadata_by_mid', 'wp_check_site_meta_support_prefilter' );
add_filter( 'update_blog_metadata_by_mid', 'wp_check_site_meta_support_prefilter' );
add_filter( 'delete_blog_metadata_by_mid', 'wp_check_site_meta_support_prefilter' );
add_filter( 'update_blog_metadata_cache', 'wp_check_site_meta_support_prefilter' );
```

### Removed Filters

```php
// WP_HOME and WP_SITEURL should not have any effect in MS
remove_filter( 'option_siteurl', '_config_wp_siteurl' );
remove_filter( 'option_home', '_config_wp_home' );

// User counts handled by network counts in MS
remove_action( 'admin_init', 'wp_schedule_update_user_counts' );
remove_action( 'wp_update_user_counts', 'wp_schedule_update_user_counts' );
```
