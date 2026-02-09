# WordPress Multisite Functions Reference

Complete reference for all WordPress Multisite API functions.

## Site Retrieval Functions

### get_site()

Retrieves site data given a site ID or site object.

```php
get_site( $site = null ): WP_Site|null
```

**Parameters:**
- `$site` (WP_Site|int|null) - Site to retrieve. Default: current site

**Returns:** WP_Site object or null if not found

**Example:**
```php
// Get current site
$site = get_site();

// Get specific site
$site = get_site( 5 );

// Access properties
echo $site->domain;
echo $site->path;
echo $site->blogname; // Requires full details
```

**Source:** `ms-site.php`

---

### get_sites()

Retrieves a list of sites matching requested arguments.

```php
get_sites( $args = array() ): WP_Site[]|int[]|int
```

**Parameters:**
- `$args` (array) - Query arguments (see WP_Site_Query)

**Common Arguments:**
| Argument | Type | Description |
|----------|------|-------------|
| `network_id` | int | Network ID |
| `domain` | string | Site domain |
| `path` | string | Site path |
| `public` | int | Public status (0/1) |
| `archived` | int | Archived status |
| `mature` | int | Mature status |
| `spam` | int | Spam status |
| `deleted` | int | Deleted status |
| `number` | int | Number to return |
| `offset` | int | Offset |
| `orderby` | string | Order field |
| `order` | string | ASC/DESC |
| `fields` | string | 'ids' for IDs only |
| `count` | bool | Return count only |

**Returns:** Array of WP_Site objects, site IDs, or count

**Example:**
```php
// Get all public, active sites
$sites = get_sites( array(
    'public'   => 1,
    'archived' => 0,
    'spam'     => 0,
    'deleted'  => 0,
    'number'   => 100,
) );

// Count sites
$count = get_sites( array(
    'network_id' => 1,
    'count'      => true,
) );

// Get site IDs only
$ids = get_sites( array(
    'fields' => 'ids',
) );
```

**Source:** `ms-site.php`

---

### get_blog_details()

Retrieves the details for a blog from the blogs table and blog options.

```php
get_blog_details( $fields = null, $get_all = true ): WP_Site|false
```

**Parameters:**
- `$fields` (int|string|array) - Blog ID, slug, or array of fields. Default: current blog
- `$get_all` (bool) - Retrieve all details including options. Default: true

**Returns:** WP_Site object or false

**Example:**
```php
// By ID
$blog = get_blog_details( 5 );

// By slug
$blog = get_blog_details( 'myblog' );

// By domain/path
$blog = get_blog_details( array(
    'domain' => 'example.com',
    'path'   => '/blog/',
) );

// Access extended properties (when $get_all = true)
echo $blog->blogname;
echo $blog->siteurl;
echo $blog->home;
echo $blog->post_count;
```

**Source:** `ms-blogs.php`

---

### get_site_by_path()

Retrieves the closest matching site by domain and path.

```php
get_site_by_path( $domain, $path, $segments = null ): WP_Site|false
```

**Parameters:**
- `$domain` (string) - Domain to check
- `$path` (string) - Path to check
- `$segments` (int|null) - Path segments to use

**Returns:** WP_Site or false

**Example:**
```php
$site = get_site_by_path( 'example.com', '/blog/about/' );
```

**Source:** `ms-load.php`

---

### get_blog_id_from_url()

Gets a blog's numeric ID from its URL.

```php
get_blog_id_from_url( $domain, $path = '/' ): int
```

**Parameters:**
- `$domain` (string) - Website domain
- `$path` (string) - Path. Default: '/'

**Returns:** Blog ID or 0 if not found

**Example:**
```php
$blog_id = get_blog_id_from_url( 'blog.example.com', '/' );
$blog_id = get_blog_id_from_url( 'example.com', '/myblog/' );
```

**Source:** `ms-functions.php`

---

### get_id_from_blogname()

Retrieves a site's ID given its slug.

```php
get_id_from_blogname( $slug ): int|null
```

**Parameters:**
- `$slug` (string) - Site's slug (subdomain or subdirectory name)

**Returns:** Site ID or null

**Example:**
```php
$id = get_id_from_blogname( 'myblog' );
```

**Source:** `ms-blogs.php`

---

### get_current_blog_id()

Retrieve the current site ID.

```php
get_current_blog_id(): int
```

**Returns:** Current blog ID

**Example:**
```php
$blog_id = get_current_blog_id();
```

**Source:** Core (not multisite-specific but essential)

---

### get_blogaddress_by_id()

Gets a full site URL given a site ID.

```php
get_blogaddress_by_id( $blog_id ): string
```

**Parameters:**
- `$blog_id` (int) - Site ID

**Returns:** Full site URL or empty string

**Example:**
```php
$url = get_blogaddress_by_id( 5 );
// Returns: https://blog.example.com/
```

**Source:** `ms-blogs.php`

---

### get_blogaddress_by_name()

Gets a full site URL given a site name.

```php
get_blogaddress_by_name( $blogname ): string
```

**Parameters:**
- `$blogname` (string) - Name of subdomain/directory

**Returns:** Full URL

**Example:**
```php
$url = get_blogaddress_by_name( 'myblog' );
```

**Source:** `ms-blogs.php`

---

## Site Creation Functions

### wp_insert_site()

Inserts a new site into the database.

```php
wp_insert_site( array $data ): int|WP_Error
```

**Parameters:**
- `$data` (array) - Site data

**Data Array:**
| Key | Type | Description |
|-----|------|-------------|
| `domain` | string | Site domain |
| `path` | string | Site path. Default: '/' |
| `network_id` | int | Network ID. Default: current |
| `registered` | string | Registration date |
| `last_updated` | string | Last updated date |
| `public` | int | Public status. Default: 1 |
| `archived` | int | Archive status. Default: 0 |
| `mature` | int | Mature status. Default: 0 |
| `spam` | int | Spam status. Default: 0 |
| `deleted` | int | Deleted status. Default: 0 |
| `lang_id` | int | Language ID. Default: 0 |
| `user_id` | int | Admin user ID |
| `title` | string | Site title |
| `options` | array | Initial options |
| `meta` | array | Site metadata |

**Returns:** Site ID or WP_Error

**Example:**
```php
$site_id = wp_insert_site( array(
    'domain'     => 'example.com',
    'path'       => '/newsite/',
    'network_id' => 1,
    'user_id'    => 1,
    'title'      => 'My New Site',
    'options'    => array(
        'WPLANG' => 'en_US',
    ),
) );
```

**Source:** `ms-site.php`

---

### wpmu_create_blog()

Creates a site (higher-level wrapper).

```php
wpmu_create_blog( $domain, $path, $title, $user_id, $options = array(), $network_id = 1 ): int|WP_Error
```

**Parameters:**
- `$domain` (string) - Site domain
- `$path` (string) - Site path
- `$title` (string) - Site title
- `$user_id` (int) - Admin user ID
- `$options` (array) - Site options
- `$network_id` (int) - Network ID. Default: 1

**Returns:** Blog ID or WP_Error

**Example:**
```php
$blog_id = wpmu_create_blog(
    'example.com',
    '/myblog/',
    'My Blog',
    1,
    array( 'public' => 1 )
);
```

**Source:** `ms-functions.php`

---

### wp_initialize_site()

Runs the initialization routine for a site (creates tables, populates defaults).

```php
wp_initialize_site( $site_id, array $args = array() ): true|WP_Error
```

**Parameters:**
- `$site_id` (int|WP_Site) - Site ID or object
- `$args` (array) - Initialization arguments

**Args Array:**
| Key | Type | Description |
|-----|------|-------------|
| `user_id` | int | Administrator user ID |
| `title` | string | Site title |
| `options` | array | Initial option key=>value pairs |
| `meta` | array | Site metadata key=>value pairs |

**Returns:** True on success, WP_Error on failure

**Example:**
```php
wp_initialize_site( $site_id, array(
    'user_id' => 1,
    'title'   => 'New Site',
    'options' => array(
        'blogdescription' => 'A great site',
    ),
) );
```

**Source:** `ms-site.php`

---

### wp_is_site_initialized()

Checks whether a site is initialized (database tables exist).

```php
wp_is_site_initialized( $site_id ): bool
```

**Source:** `ms-site.php`

---

## Site Update Functions

### wp_update_site()

Updates a site in the database.

```php
wp_update_site( $site_id, array $data ): int|WP_Error
```

**Parameters:**
- `$site_id` (int) - Site ID to update
- `$data` (array) - Site data (see wp_insert_site)

**Returns:** Site ID or WP_Error

**Example:**
```php
wp_update_site( 5, array(
    'public' => 0,
    'spam'   => 1,
) );
```

**Source:** `ms-site.php`

---

### update_blog_details()

Updates the details for a blog (wrapper for wp_update_site).

```php
update_blog_details( $blog_id, $details = array() ): bool
```

**Parameters:**
- `$blog_id` (int) - Blog ID
- `$details` (array) - Blog details

**Returns:** True on success, false on failure

**Source:** `ms-blogs.php`

---

### update_blog_status()

Updates a single blog status field.

```php
update_blog_status( $blog_id, $pref, $value, $deprecated = null ): string|false
```

**Parameters:**
- `$blog_id` (int) - Blog ID
- `$pref` (string) - Field name
- `$value` (string) - New value

**Allowed Fields:** `site_id`, `domain`, `path`, `registered`, `last_updated`, `public`, `archived`, `mature`, `spam`, `deleted`, `lang_id`

**Example:**
```php
update_blog_status( 5, 'public', 0 );
update_blog_status( 5, 'archived', 1 );
```

**Source:** `ms-blogs.php`

---

### get_blog_status()

Gets a blog details field.

```php
get_blog_status( $id, $pref ): bool|string|null
```

**Source:** `ms-blogs.php`

---

### update_archived()

Updates the 'archived' status of a blog.

```php
update_archived( $id, $archived ): string
```

**Source:** `ms-blogs.php`

---

### is_archived()

Checks if a blog is archived.

```php
is_archived( $id ): string
```

**Source:** `ms-blogs.php`

---

## Site Deletion Functions

### wp_delete_site()

Deletes a site from the database.

```php
wp_delete_site( $site_id ): WP_Site|WP_Error
```

**Parameters:**
- `$site_id` (int) - Site ID to delete

**Returns:** Deleted site object or WP_Error

**Example:**
```php
$deleted_site = wp_delete_site( 5 );
```

**Source:** `ms-site.php`

---

### wp_uninitialize_site()

Runs the uninitialization routine (drops tables, removes uploads).

```php
wp_uninitialize_site( $site_id ): true|WP_Error
```

**Source:** `ms-site.php`

---

## Site Switching Functions

### switch_to_blog()

Switches the current blog context.

```php
switch_to_blog( $new_blog_id, $deprecated = null ): true
```

**Parameters:**
- `$new_blog_id` (int) - Blog ID to switch to

**Returns:** Always true

**What Changes:**
- `$wpdb->prefix` and table references
- Object cache context
- `$blog_id` global
- User capabilities (after `init`)

**Example:**
```php
switch_to_blog( 5 );
$posts = get_posts();
$title = get_option( 'blogname' );
restore_current_blog();
```

**Source:** `ms-blogs.php`

---

### restore_current_blog()

Restores the current blog after switch_to_blog().

```php
restore_current_blog(): bool
```

**Returns:** True on success, false if no previous blog to restore

**Source:** `ms-blogs.php`

---

### ms_is_switched()

Determines if switch_to_blog() is in effect.

```php
ms_is_switched(): bool
```

**Example:**
```php
if ( ms_is_switched() ) {
    // Currently in a switched context
}
```

**Source:** `ms-blogs.php`

---

## Network Functions

### get_network()

Retrieves network data given a network ID or object.

```php
get_network( $network = null ): WP_Network|null
```

**Parameters:**
- `$network` (WP_Network|int|null) - Network to retrieve. Default: current

**Returns:** WP_Network or null

**Example:**
```php
$network = get_network();
$network = get_network( 2 );
```

**Source:** `ms-network.php`

---

### get_networks()

Retrieves a list of networks.

```php
get_networks( $args = array() ): array|int
```

**Parameters:**
- `$args` (array) - Query arguments (see WP_Network_Query)

**Example:**
```php
$networks = get_networks( array(
    'number' => 10,
) );
```

**Source:** `ms-network.php`

---

### get_current_site()

Gets the current network.

```php
get_current_site(): WP_Network
```

**Source:** `ms-functions.php`

---

### get_current_network_id()

Gets the current network ID.

```php
get_current_network_id(): int
```

**Source:** Core

---

### get_network_by_path()

Retrieves the closest matching network for a domain and path.

```php
get_network_by_path( $domain, $path, $segments = null ): WP_Network|false
```

**Source:** `ms-load.php`

---

### get_main_site_id()

Gets the main site ID for a network.

```php
get_main_site_id( $network_id = null ): int
```

**Source:** Core

---

## Blog Options Functions

### get_blog_option()

Retrieves option value for a given blog.

```php
get_blog_option( $id, $option, $default_value = false ): mixed
```

**Parameters:**
- `$id` (int) - Blog ID (null = current)
- `$option` (string) - Option name
- `$default_value` (mixed) - Default if not found

**Example:**
```php
$title = get_blog_option( 5, 'blogname' );
```

**Source:** `ms-blogs.php`

---

### add_blog_option()

Adds a new option for a given blog.

```php
add_blog_option( $id, $option, $value ): bool
```

**Source:** `ms-blogs.php`

---

### update_blog_option()

Updates an option for a blog.

```php
update_blog_option( $id, $option, $value, $deprecated = null ): bool
```

**Source:** `ms-blogs.php`

---

### delete_blog_option()

Removes an option by name for a given blog.

```php
delete_blog_option( $id, $option ): bool
```

**Source:** `ms-blogs.php`

---

## Site Meta Functions

### add_site_meta()

Adds metadata to a site.

```php
add_site_meta( $site_id, $meta_key, $meta_value, $unique = false ): int|false
```

**Source:** `ms-site.php`

---

### get_site_meta()

Retrieves metadata for a site.

```php
get_site_meta( $site_id, $key = '', $single = false ): mixed
```

**Source:** `ms-site.php`

---

### update_site_meta()

Updates metadata for a site.

```php
update_site_meta( $site_id, $meta_key, $meta_value, $prev_value = '' ): int|bool
```

**Source:** `ms-site.php`

---

### delete_site_meta()

Removes metadata from a site.

```php
delete_site_meta( $site_id, $meta_key, $meta_value = '' ): bool
```

**Source:** `ms-site.php`

---

### delete_site_meta_by_key()

Deletes all site meta matching a key.

```php
delete_site_meta_by_key( $meta_key ): bool
```

**Source:** `ms-site.php`

---

## User Functions

### add_user_to_blog()

Adds a user to a blog with a specified role.

```php
add_user_to_blog( $blog_id, $user_id, $role ): true|WP_Error
```

**Parameters:**
- `$blog_id` (int) - Blog ID
- `$user_id` (int) - User ID
- `$role` (string) - Role name

**Example:**
```php
add_user_to_blog( 5, 10, 'editor' );
```

**Source:** `ms-functions.php`

---

### remove_user_from_blog()

Removes a user from a blog.

```php
remove_user_from_blog( $user_id, $blog_id = 0, $reassign = 0 ): true|WP_Error
```

**Parameters:**
- `$user_id` (int) - User ID
- `$blog_id` (int) - Blog ID. Default: current
- `$reassign` (int) - User ID to reassign posts to

**Source:** `ms-functions.php`

---

### get_blogs_of_user()

Gets the sites a user belongs to.

```php
get_blogs_of_user( $user_id, $all = false ): WP_Site[]
```

**Parameters:**
- `$user_id` (int) - User ID
- `$all` (bool) - Include all sites, even spam/deleted. Default: false

**Returns:** Array of WP_Site objects keyed by blog ID

**Example:**
```php
$blogs = get_blogs_of_user( 10 );
foreach ( $blogs as $blog_id => $blog ) {
    echo $blog->blogname;
}
```

**Source:** Core user functions

---

### get_active_blog_for_user()

Gets one of a user's active blogs.

```php
get_active_blog_for_user( $user_id ): WP_Site|void
```

**Source:** `ms-functions.php`

---

### is_user_member_of_blog()

Determines if a user is a member of a blog.

```php
is_user_member_of_blog( $user_id = 0, $blog_id = 0 ): bool
```

**Source:** Core user functions

---

### is_user_spammy()

Determines whether a user is marked as spam.

```php
is_user_spammy( $user = null ): bool
```

**Parameters:**
- `$user` (string|WP_User) - User login or object. Default: current

**Source:** `ms-functions.php`

---

## Signup & Registration Functions

### wpmu_validate_user_signup()

Validates user signup data.

```php
wpmu_validate_user_signup( $user_name, $user_email ): array
```

**Returns:** Array with `user_name`, `orig_username`, `user_email`, `errors`

**Source:** `ms-functions.php`

---

### wpmu_validate_blog_signup()

Validates blog signup data.

```php
wpmu_validate_blog_signup( $blogname, $blog_title, $user = '' ): array
```

**Returns:** Array with `domain`, `path`, `blogname`, `blog_title`, `user`, `errors`

**Source:** `ms-functions.php`

---

### wpmu_signup_blog()

Records site signup information for future activation.

```php
wpmu_signup_blog( $domain, $path, $title, $user, $user_email, $meta = array() )
```

**Source:** `ms-functions.php`

---

### wpmu_signup_user()

Records user signup information.

```php
wpmu_signup_user( $user, $user_email, $meta = array() )
```

**Source:** `ms-functions.php`

---

### wpmu_activate_signup()

Activates a signup.

```php
wpmu_activate_signup( $key ): array|WP_Error
```

**Returns:** Array with `blog_id`/`user_id`, `password`, `title`, `meta`

**Source:** `ms-functions.php`

---

### wpmu_create_user()

Creates a user.

```php
wpmu_create_user( $user_name, $password, $email ): int|false
```

**Returns:** User ID or false

**Source:** `ms-functions.php`

---

### domain_exists()

Checks whether a site name is already taken.

```php
domain_exists( $domain, $path, $network_id = 1 ): int|null
```

**Returns:** Site ID if exists, null otherwise

**Source:** `ms-functions.php`

---

### is_email_address_unsafe()

Checks email against banned domains.

```php
is_email_address_unsafe( $user_email ): bool
```

**Source:** `ms-functions.php`

---

## Notification Functions

### wpmu_signup_blog_notification()

Sends confirmation email for new site signup.

```php
wpmu_signup_blog_notification( $domain, $path, $title, $user_login, $user_email, $key, $meta = array() ): bool
```

**Source:** `ms-functions.php`

---

### wpmu_signup_user_notification()

Sends confirmation email for new user signup.

```php
wpmu_signup_user_notification( $user_login, $user_email, $key, $meta = array() ): bool
```

**Source:** `ms-functions.php`

---

### wpmu_welcome_notification()

Notifies site admin of successful site activation.

```php
wpmu_welcome_notification( $blog_id, $user_id, $password, $title, $meta = array() ): bool
```

**Source:** `ms-functions.php`

---

### wpmu_welcome_user_notification()

Notifies user of successful account activation.

```php
wpmu_welcome_user_notification( $user_id, $password, $meta = array() ): bool
```

**Source:** `ms-functions.php`

---

### newblog_notify_siteadmin()

Notifies network admin of new site activation.

```php
newblog_notify_siteadmin( $blog_id, $deprecated = '' ): bool
```

**Source:** `ms-functions.php`

---

### newuser_notify_siteadmin()

Notifies network admin of new user activation.

```php
newuser_notify_siteadmin( $user_id ): bool
```

**Source:** `ms-functions.php`

---

### wpmu_new_site_admin_notification()

Sends email to network admin when a new site is created.

```php
wpmu_new_site_admin_notification( $site_id, $user_id ): bool
```

**Source:** `ms-functions.php`

---

## Cross-Blog Content Functions

### get_blog_post()

Gets a blog post from any site on the network.

```php
get_blog_post( $blog_id, $post_id ): WP_Post|null
```

**Example:**
```php
$post = get_blog_post( 5, 123 );
```

**Source:** `ms-functions.php`

---

### get_blog_permalink()

Gets the permalink for a post on another blog.

```php
get_blog_permalink( $blog_id, $post_id ): string
```

**Source:** `ms-functions.php`

---

### get_most_recent_post_of_user()

Gets a user's most recent post across all their blogs.

```php
get_most_recent_post_of_user( $user_id ): array
```

**Returns:** Array with `blog_id`, `post_id`, `post_date_gmt`, `post_gmt_ts`

**Source:** `ms-functions.php`

---

## Statistics Functions

### get_sitestats()

Gets the network's site and user counts.

```php
get_sitestats(): int[]
```

**Returns:** Array with `blogs` and `users` counts

**Source:** `ms-functions.php`

---

### get_blog_count()

Gets the number of active sites on the installation.

```php
get_blog_count( $network_id = null ): int
```

**Source:** `ms-functions.php`

---

### get_user_count()

Gets the number of users on the network.

```php
get_user_count( $network_id = null ): int
```

**Source:** Core

---

### wp_count_sites()

Counts sites grouped by status.

```php
wp_count_sites( $network_id = null ): int[]
```

**Returns:** Array with `all`, `public`, `archived`, `mature`, `spam`, `deleted`

**Source:** `ms-blogs.php`

---

### get_last_updated()

Gets a list of most recently updated blogs.

```php
get_last_updated( $deprecated = '', $start = 0, $quantity = 40 ): array
```

**Source:** `ms-blogs.php`

---

## Upload & Space Functions

### get_space_used()

Returns the space used by the current site in megabytes.

```php
get_space_used(): int
```

**Source:** `ms-functions.php`

---

### get_space_allowed()

Returns the upload quota for the current blog in megabytes.

```php
get_space_allowed(): int
```

**Source:** `ms-functions.php`

---

### get_upload_space_available()

Returns available upload space in bytes.

```php
get_upload_space_available(): int
```

**Source:** `ms-functions.php`

---

### is_upload_space_available()

Determines if there is any upload space left.

```php
is_upload_space_available(): bool
```

**Source:** `ms-functions.php`

---

### upload_is_file_too_big()

Checks whether an upload is too big.

```php
upload_is_file_too_big( $upload ): string|array
```

**Source:** `ms-functions.php`

---

### upload_size_limit_filter()

Filters the maximum upload file size.

```php
upload_size_limit_filter( $size ): int
```

**Source:** `ms-functions.php`

---

### check_upload_mimes()

Checks MIME types against allowed list.

```php
check_upload_mimes( $mimes ): array
```

**Source:** `ms-functions.php`

---

## Network Count Functions

### wp_update_network_counts()

Updates all network-wide counts.

```php
wp_update_network_counts( $network_id = null )
```

**Source:** `ms-functions.php`

---

### wp_update_network_site_counts()

Updates the network-wide site count.

```php
wp_update_network_site_counts( $network_id = null )
```

**Source:** `ms-functions.php`

---

### wp_update_network_user_counts()

Updates the network-wide user count.

```php
wp_update_network_user_counts( $network_id = null )
```

**Source:** `ms-functions.php`

---

### wp_maybe_update_network_site_counts()

Updates site counts if enabled.

```php
wp_maybe_update_network_site_counts( $network_id = null )
```

**Source:** `ms-functions.php`

---

### wp_maybe_update_network_user_counts()

Updates user counts if enabled.

```php
wp_maybe_update_network_user_counts( $network_id = null )
```

**Source:** `ms-functions.php`

---

### wp_is_large_network()

Determines whether this is a large network.

```php
wp_is_large_network( $using = 'sites', $network_id = null ): bool
```

**Parameters:**
- `$using` (string) - 'sites' or 'users'
- `$network_id` (int|null) - Network ID

**Returns:** True if >10,000 sites/users

**Source:** `ms-functions.php`

---

## Cache Functions

### clean_blog_cache()

Clears the blog cache.

```php
clean_blog_cache( $blog )
```

**Parameters:**
- `$blog` (WP_Site|int) - Site object or ID

**Source:** `ms-site.php`

---

### refresh_blog_details()

Clears the blog details cache (wrapper for clean_blog_cache).

```php
refresh_blog_details( $blog_id = 0 )
```

**Source:** `ms-blogs.php`

---

### clean_site_details_cache()

Cleans the site details cache.

```php
clean_site_details_cache( $site_id = 0 )
```

**Source:** `ms-blogs.php`

---

### update_site_cache()

Updates sites in cache.

```php
update_site_cache( $sites, $update_meta_cache = true )
```

**Source:** `ms-site.php`

---

### update_sitemeta_cache()

Updates metadata cache for site IDs.

```php
update_sitemeta_cache( $site_ids ): array|false
```

**Source:** `ms-site.php`

---

### clean_network_cache()

Removes a network from the object cache.

```php
clean_network_cache( $ids )
```

**Source:** `ms-network.php`

---

### update_network_cache()

Updates the network cache.

```php
update_network_cache( $networks )
```

**Source:** `ms-network.php`

---

### wp_cache_set_sites_last_changed()

Sets the last changed time for the 'sites' cache group.

```php
wp_cache_set_sites_last_changed()
```

**Source:** `ms-site.php`

---

## Utility Functions

### is_subdomain_install()

Whether a subdomain configuration is enabled.

```php
is_subdomain_install(): bool
```

**Source:** `ms-load.php`

---

### is_multisite()

Whether Multisite is enabled.

```php
is_multisite(): bool
```

**Source:** Core

---

### is_main_site()

Whether this is the main site of the network.

```php
is_main_site( $site_id = null, $network_id = null ): bool
```

**Source:** Core

---

### is_main_network()

Whether this is the main network.

```php
is_main_network( $network_id = null ): bool
```

**Source:** Core

---

### ms_site_check()

Checks status of current blog (deleted, inactive, archived, spammed).

```php
ms_site_check(): true|string
```

**Returns:** True on success, or drop-in file path

**Source:** `ms-load.php`

---

### get_subdirectory_reserved_names()

Retrieves reserved site names for subdirectory installations.

```php
get_subdirectory_reserved_names(): string[]
```

**Returns:** Array including 'wp-admin', 'wp-content', 'wp-includes', 'wp-json', etc.

**Source:** `ms-functions.php`

---

### wp_get_active_network_plugins()

Returns array of network plugin files to include.

```php
wp_get_active_network_plugins(): string[]
```

**Source:** `ms-load.php`

---

### users_can_register_signup_filter()

Determines if users can self-register.

```php
users_can_register_signup_filter(): bool
```

**Source:** `ms-functions.php`

---

### wpmu_update_blogs_date()

Updates the last_updated field for the current site.

```php
wpmu_update_blogs_date()
```

**Source:** `ms-blogs.php`

---

### update_posts_count()

Updates a blog's post count.

```php
update_posts_count( $deprecated = '' )
```

**Source:** `ms-functions.php`

---

### wpmu_log_new_registrations()

Logs new site registration information.

```php
wpmu_log_new_registrations( $blog_id, $user_id )
```

**Source:** `ms-functions.php`

---

### redirect_this_site()

Ensures current site's domain is in allowed redirect hosts.

```php
redirect_this_site( $deprecated = '' ): string[]
```

**Source:** `ms-functions.php`

---

### maybe_redirect_404()

Corrects 404 redirects when NOBLOGREDIRECT is defined.

```php
maybe_redirect_404()
```

**Source:** `ms-functions.php`

---

### maybe_add_existing_user_to_blog()

Adds a user via /newbloguser/{key}/ URL.

```php
maybe_add_existing_user_to_blog()
```

**Source:** `ms-functions.php`

---

### add_existing_user_to_blog()

Adds a user to the current blog.

```php
add_existing_user_to_blog( $details = false ): true|WP_Error|void
```

**Source:** `ms-functions.php`

---

### add_new_user_to_blog()

Adds a newly created user to the appropriate blog.

```php
add_new_user_to_blog( $user_id, $password, $meta )
```

**Source:** `ms-functions.php`

---

### fix_phpmailer_messageid()

Corrects mail From host to match site domain.

```php
fix_phpmailer_messageid( $phpmailer )
```

**Source:** `ms-functions.php`

---

### update_blog_public()

Updates blog's 'public' setting in global blogs table.

```php
update_blog_public( $old_value, $value )
```

**Source:** `ms-functions.php`

---

### force_ssl_content()

Determines whether to force SSL on content.

```php
force_ssl_content( $force = null ): bool
```

**Source:** `ms-functions.php`

---

### filter_SSL()

Formats a URL to use https.

```php
filter_SSL( $url ): string
```

**Source:** `ms-functions.php`

---

## Deprecated Functions

### wp_get_network()

**Deprecated:** 4.7.0 - Use `get_network()` instead.

### get_current_site_name()

**Deprecated:** 3.9.0 - Use `get_current_site()` instead.

### wpmu_current_site()

**Deprecated:** 3.9.0
