# WordPress Multisite Architecture

WordPress Multisite enables running multiple sites from a single WordPress installation. This document covers the core architecture, terminology, and fundamental concepts.

## Core Concepts

### Network

A **Network** (historically called "site") is the top-level container that holds multiple sites. A WordPress installation can have one or multiple networks (multi-network setup).

**Key properties:**
- `id` - Unique network identifier
- `domain` - Network's primary domain
- `path` - Network's path (usually `/`)
- `site_name` - Human-readable network name
- `blog_id` - ID of the network's main site

**Class:** `WP_Network`
**Table:** `wp_site`

### Site

A **Site** (historically called "blog") is an individual WordPress site within a network. Each site has its own content, settings, and users with roles.

**Key properties:**
- `blog_id` / `id` - Unique site identifier
- `site_id` / `network_id` - Parent network ID
- `domain` - Site's domain
- `path` - Site's path
- `registered` - Registration timestamp
- `last_updated` - Last content update timestamp
- `public` - Visibility (1 = public, 0 = private)
- `archived` - Archive status
- `mature` - Mature content flag
- `spam` - Spam flag
- `deleted` - Deletion flag
- `lang_id` - Language identifier

**Class:** `WP_Site`
**Table:** `wp_blogs`

### Installation Types

#### Subdomain Installation
Each site gets its own subdomain:
- Main site: `example.com`
- Child sites: `blog1.example.com`, `blog2.example.com`

```php
define( 'SUBDOMAIN_INSTALL', true );
```

#### Subdirectory Installation
Each site gets its own path:
- Main site: `example.com`
- Child sites: `example.com/blog1/`, `example.com/blog2/`

```php
define( 'SUBDOMAIN_INSTALL', false );
```

Check installation type:
```php
if ( is_subdomain_install() ) {
    // Subdomain installation
}
```

## Database Structure

### Global Tables (Network-wide)

These tables are shared across all sites:

| Table | Purpose |
|-------|---------|
| `wp_site` | Networks |
| `wp_sitemeta` | Network metadata |
| `wp_blogs` | Sites |
| `wp_blogmeta` | Site metadata |
| `wp_users` | All users |
| `wp_usermeta` | User metadata |
| `wp_signups` | Pending registrations |
| `wp_registration_log` | Registration log |

### Per-Site Tables

Each site gets its own prefixed tables:
- Main site: `wp_posts`, `wp_options`, etc.
- Site 2: `wp_2_posts`, `wp_2_options`, etc.
- Site N: `wp_N_posts`, `wp_N_options`, etc.

## Global Variables

### `$current_site`
The current `WP_Network` object. Access via `get_current_site()` or `get_network()`.

### `$current_blog`
The current `WP_Site` object. Access via `get_site()`.

### `$blog_id`
Current site ID. Access via `get_current_blog_id()`.

### `$_wp_switched_stack`
Stack of site IDs when using `switch_to_blog()`.

### `$switched`
Boolean indicating if currently switched to another blog.

## Site Switching

The site switching mechanism allows code to operate in the context of different sites:

```php
// Switch to site 5
switch_to_blog( 5 );

// Do work in site 5's context
$posts = get_posts();
$option = get_option( 'blogname' );

// Switch back
restore_current_blog();
```

**What switches:**
- Database table prefix (`$wpdb->prefix`)
- Object cache context
- User capabilities (after `init`)
- Current blog global (`$blog_id`)

**What doesn't switch:**
- Loaded plugins
- Active theme
- Loaded PHP files

### Nested Switching

Switches can be nested; `restore_current_blog()` returns to the previous context:

```php
switch_to_blog( 2 );
    switch_to_blog( 3 );
        // Now in site 3
    restore_current_blog(); // Back to site 2
restore_current_blog(); // Back to original
```

Check switch status:
```php
if ( ms_is_switched() ) {
    // Currently switched to another blog
}
```

## Site Lifecycle

### 1. Signup (Optional)
User requests a new site via `wp-signup.php`:
```php
wpmu_signup_blog( $domain, $path, $title, $user, $user_email, $meta );
```
Creates pending record in `wp_signups`.

### 2. Activation
Signup is activated:
```php
wpmu_activate_signup( $key );
```

### 3. Site Creation
Site is created in the database:
```php
$blog_id = wpmu_create_blog( $domain, $path, $title, $user_id, $options, $network_id );
// Or directly:
$site_id = wp_insert_site( $data );
```

### 4. Initialization
Database tables are created and populated:
```php
wp_initialize_site( $site_id, $args );
```

### 5. Update
Site properties are updated:
```php
wp_update_site( $site_id, $data );
update_blog_status( $blog_id, 'public', 0 );
```

### 6. Deletion
Site is deleted:
```php
wp_delete_site( $site_id );
```
This triggers `wp_uninitialize_site()` to drop tables and remove files.

## Site Status Flags

Sites can have various status flags:

| Flag | Meaning |
|------|---------|
| `public` | Site is publicly visible |
| `archived` | Site is archived (read-only) |
| `mature` | Site contains mature content |
| `spam` | Site is marked as spam |
| `deleted` | Site is deleted (soft delete) |

Each flag triggers corresponding hooks when changed:
- `make_spam_blog` / `make_ham_blog`
- `archive_blog` / `unarchive_blog`
- `mature_blog` / `unmature_blog`
- `make_delete_blog` / `make_undelete_blog`

## User Management

### Network Users
Users are global across the network but have roles per-site.

Add user to a site:
```php
add_user_to_blog( $blog_id, $user_id, $role );
```

Remove user from a site:
```php
remove_user_from_blog( $user_id, $blog_id, $reassign );
```

Get user's blogs:
```php
$blogs = get_blogs_of_user( $user_id );
```

### Primary Blog
Each user has a primary blog stored in user meta:
```php
$primary = get_user_meta( $user_id, 'primary_blog', true );
```

### Super Admins
Network administrators with full access to all sites:
```php
if ( is_super_admin() ) {
    // Has network-wide privileges
}
```

## Constants

### Required Constants

```php
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false ); // or true
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
```

### Upload Constants (Legacy)

```php
define( 'UPLOADBLOGSDIR', 'wp-content/blogs.dir' ); // Legacy
define( 'UPLOADS', 'wp-content/blogs.dir/2/files/' ); // Per-site
```

### Cookie Constants

Set by `ms_cookie_constants()`:
```php
define( 'COOKIEPATH', '/' );
define( 'SITECOOKIEPATH', '/' );
define( 'ADMIN_COOKIE_PATH', '/wp-admin' );
define( 'COOKIE_DOMAIN', '.example.com' ); // Subdomain only
```

### File Upload Constants

```php
define( 'WPMU_SENDFILE', false );     // X-Sendfile header
define( 'WPMU_ACCEL_REDIRECT', false ); // X-Accel-Redirect header
```

## Loading Sequence

1. **`ms-load.php`** - Core loading functions
2. **`ms-default-constants.php`** - Define multisite constants
3. **`ms-settings.php`** - Bootstrap network and site
4. **`ms-blogs.php`** - Blog/site functions
5. **`ms-site.php`** - Site API (CRUD)
6. **`ms-network.php`** - Network API
7. **`ms-functions.php`** - General multisite functions
8. **`ms-default-filters.php`** - Default hooks

## Query Classes

### WP_Site_Query

Query sites with flexible parameters:

```php
$sites = get_sites( array(
    'network_id' => 1,
    'public'     => 1,
    'archived'   => 0,
    'spam'       => 0,
    'deleted'    => 0,
    'number'     => 100,
    'orderby'    => 'last_updated',
    'order'      => 'DESC',
) );
```

### WP_Network_Query

Query networks:

```php
$networks = get_networks( array(
    'number' => 10,
) );
```

## Caching

### Site Cache
Sites are cached in the `sites` cache group:
```php
$site = wp_cache_get( $blog_id, 'sites' );
```

Clear site cache:
```php
clean_blog_cache( $blog_id );
```

### Network Cache
Networks are cached in the `networks` cache group:
```php
$network = wp_cache_get( $network_id, 'networks' );
```

Clear network cache:
```php
clean_network_cache( $network_id );
```

### Global Cache Groups

These cache groups are shared network-wide:
- `sites`, `site-details`, `site-options`
- `networks`, `blog-details`, `blog-lookup`
- `users`, `usermeta`, `userlogins`, `useremail`, `userslugs`
- `site-transient`, `global-posts`

## Large Network Considerations

Networks with >10,000 sites or users are considered "large":

```php
if ( wp_is_large_network( 'sites' ) ) {
    // Optimize for large site count
}

if ( wp_is_large_network( 'users' ) ) {
    // Optimize for large user count
}
```

Live counts are disabled for large networks to improve performance. Counts are updated via scheduled events instead.

## Error Handling

### Site Validation

Before creating sites, validate the domain/path:
```php
if ( domain_exists( $domain, $path, $network_id ) ) {
    // Site already exists
}
```

### Site Status Checks

The `ms_site_check()` function validates site status during bootstrap:
- Returns drop-in file path for deleted/inactive/suspended sites
- Super admins bypass these checks

### Database Errors

Site creation can fail:
```php
$result = wp_insert_site( $data );
if ( is_wp_error( $result ) ) {
    // Handle: db_insert_error, site_taken, etc.
}
```

## Network Options vs Site Options

### Network Options (Shared)
Stored in `wp_sitemeta`, shared across all sites:
```php
get_site_option( 'admin_email' );
update_site_option( 'registration', 'user' );
get_network_option( $network_id, 'option_name' );
```

### Site Options (Per-Site)
Stored in each site's `wp_N_options`:
```php
get_option( 'blogname' );
get_blog_option( $blog_id, 'option_name' );
```

## Site Meta

Site metadata (stored in `wp_blogmeta`):

```php
add_site_meta( $site_id, 'key', 'value' );
get_site_meta( $site_id, 'key', true );
update_site_meta( $site_id, 'key', 'new_value' );
delete_site_meta( $site_id, 'key' );
```

Check if site meta is supported:
```php
if ( is_site_meta_supported() ) {
    // wp_blogmeta table exists
}
```
