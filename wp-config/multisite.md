# Multisite Settings

WordPress Multisite (formerly WPMU) allows running multiple sites from a single WordPress installation. These constants configure and control the network.

## Enabling Multisite

### Step 1: Allow Multisite

```php
define( 'WP_ALLOW_MULTISITE', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Enables the Network Setup screen in Tools menu
- **Effect**: Shows "Network Setup" option in wp-admin
- **Note**: This just enables the setup screen, doesn't create the network

### Step 2: Run Network Setup

After adding `WP_ALLOW_MULTISITE`, go to:
`Tools → Network Setup`

WordPress will provide the additional constants to add.

### Step 3: Add Network Constants

After running setup, WordPress provides these constants:

```php
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
```

## Core Multisite Constants

### MULTISITE

```php
define( 'MULTISITE', true );
```

- **Type**: Boolean
- **Default**: `false`
- **Purpose**: Indicates this is a multisite installation
- **Effect**: Enables all multisite functionality

### SUBDOMAIN_INSTALL

```php
define( 'SUBDOMAIN_INSTALL', true );  // Subdomain: site1.example.com
define( 'SUBDOMAIN_INSTALL', false ); // Subdirectory: example.com/site1
```

- **Type**: Boolean
- **Purpose**: Determines URL structure for network sites

#### Subdomain Mode (true)

```
example.com         → Main site
blog.example.com    → Site 2
shop.example.com    → Site 3
```

**Requirements**:
- Wildcard DNS: `*.example.com` pointing to server
- Wildcard SSL certificate (or per-subdomain certs)
- Server configured to handle wildcard subdomains

#### Subdirectory Mode (false)

```
example.com/        → Main site
example.com/blog/   → Site 2
example.com/shop/   → Site 3
```

**Requirements**:
- WordPress installed in root (not subdirectory)
- Proper permalink structure

### DOMAIN_CURRENT_SITE

```php
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
```

- **Type**: String
- **Purpose**: Primary domain for the network
- **Note**: Do not include protocol or trailing slash

### PATH_CURRENT_SITE

```php
define( 'PATH_CURRENT_SITE', '/' );
```

- **Type**: String
- **Purpose**: Path to WordPress installation
- **Value**: Usually `/` for root installation
- **Example**: `/blog/` if WordPress is in subdirectory

### SITE_ID_CURRENT_SITE

```php
define( 'SITE_ID_CURRENT_SITE', 1 );
```

- **Type**: Integer
- **Default**: `1`
- **Purpose**: ID of the current network
- **Note**: Usually `1` unless running multiple networks

### BLOG_ID_CURRENT_SITE

```php
define( 'BLOG_ID_CURRENT_SITE', 1 );
```

- **Type**: Integer
- **Default**: `1`
- **Purpose**: ID of the main site on the network
- **Note**: Main site is always ID `1`

## Additional Multisite Constants

### SUNRISE

```php
define( 'SUNRISE', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Loads `wp-content/sunrise.php` before multisite is fully loaded
- **Use Cases**:
  - Domain mapping
  - Custom routing logic
  - Early multisite modifications

#### sunrise.php Example

```php
<?php
// wp-content/sunrise.php
// Custom domain mapping logic
if ( 'custom-domain.com' === $_SERVER['HTTP_HOST'] ) {
    define( 'COOKIE_DOMAIN', 'custom-domain.com' );
}
```

### NOBLOGREDIRECT

```php
define( 'NOBLOGREDIRECT', 'https://example.com' );
```

- **Type**: String (URL)
- **Purpose**: Redirect URL for non-existent sites
- **Effect**: When someone accesses a subdomain/path that doesn't exist, redirect here
- **Example**: `notasite.example.com` → redirects to `https://example.com`

### WP_DEFAULT_THEME

```php
define( 'WP_DEFAULT_THEME', 'twentytwentyfour' );
```

- **Type**: String
- **Purpose**: Default theme for new sites in the network
- **Note**: Also affects single-site installations

### BLOG_ID_CURRENT_SITE vs get_current_blog_id()

```php
// Constant (main site ID)
BLOG_ID_CURRENT_SITE // Always 1 (main site)

// Function (current site being viewed)
get_current_blog_id() // Returns ID of current site context
```

## Registration Settings

### ALLOW_SUBDIRECTORY_INSTALL

```php
define( 'ALLOW_SUBDIRECTORY_INSTALL', true );
```

- **Type**: Boolean
- **Default**: `true` for fresh installs, `false` for upgrades
- **Purpose**: Allow subdirectory mode even if WordPress is not at root
- **Warning**: Can cause URL conflicts with existing content

## User and Registration Settings

These are typically set via Network Admin, but can be overridden:

### Programmatic Network Options

```php
// In a plugin or mu-plugin
add_filter( 'site_option_registration', function() {
    return 'user'; // 'none', 'user', 'blog', 'all'
});
```

## Cookie Configuration for Multisite

### COOKIE_DOMAIN

```php
// For subdomain installs - share cookies across subdomains
define( 'COOKIE_DOMAIN', '.example.com' );

// For subdirectory installs - usually not needed
define( 'COOKIE_DOMAIN', 'example.com' );
```

### COOKIEPATH and SITECOOKIEPATH

```php
define( 'COOKIEPATH', '/' );
define( 'SITECOOKIEPATH', '/' );
```

- **Purpose**: Ensure cookies work across the network

### ADMIN_COOKIE_PATH

```php
define( 'ADMIN_COOKIE_PATH', '/' );
```

- **Purpose**: Allow admin cookies to work across network sites

## Network Admin Constants

### Network vs Site Admin

```php
// Check if current user is super admin
if ( is_super_admin() ) {
    // Network-level access
}

// Check if in network admin
if ( is_network_admin() ) {
    // Currently in network admin screens
}
```

## Complete Multisite Configuration Examples

### Subdomain Installation

```php
<?php
// Database settings...

// Multisite Configuration
define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

// Cookie settings for subdomain
define( 'COOKIE_DOMAIN', '.example.com' );
define( 'COOKIEPATH', '/' );
define( 'SITECOOKIEPATH', '/' );
define( 'ADMIN_COOKIE_PATH', '/' );

// Redirect non-existent subdomains
define( 'NOBLOGREDIRECT', 'https://example.com' );

// Security
define( 'FORCE_SSL_ADMIN', true );

// ABSPATH...
```

### Subdirectory Installation

```php
<?php
// Database settings...

// Multisite Configuration
define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

// Redirect non-existent paths
define( 'NOBLOGREDIRECT', 'https://example.com' );

// Security
define( 'FORCE_SSL_ADMIN', true );

// ABSPATH...
```

### WordPress in Subdirectory (Subdirectory Mode)

```php
// WordPress installed in /cms/
define( 'WP_HOME', 'https://example.com' );
define( 'WP_SITEURL', 'https://example.com/cms' );

define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
define( 'DOMAIN_CURRENT_SITE', 'example.com' );
define( 'PATH_CURRENT_SITE', '/cms/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
```

## Domain Mapping

For mapping custom domains to network sites:

### Traditional (sunrise.php)

```php
// wp-config.php
define( 'SUNRISE', true );

// wp-content/sunrise.php
<?php
global $wpdb;

$domain = $_SERVER['HTTP_HOST'];
$mapped = $wpdb->get_row( 
    $wpdb->prepare( 
        "SELECT blog_id FROM {$wpdb->dmtable} WHERE domain = %s", 
        $domain 
    ) 
);

if ( $mapped ) {
    define( 'COOKIE_DOMAIN', $domain );
}
```

### Modern Plugins

Use plugins like "WordPress MU Domain Mapping" or "Mercator" for easier domain mapping.

## Multisite Database Tables

Multisite adds these tables per site (where N is site ID):

| Table | Purpose |
|-------|---------|
| `wp_blogs` | List of all sites |
| `wp_blog_versions` | Database version per site |
| `wp_registration_log` | Registration logs |
| `wp_signups` | Pending signups |
| `wp_site` | Network information |
| `wp_sitemeta` | Network-level options |
| `wp_N_posts` | Posts for site N |
| `wp_N_options` | Options for site N |
| `wp_N_*` | All tables duplicated per site |

## Troubleshooting Multisite

### Common Issues

1. **Cookies not working across sites**
   - Check `COOKIE_DOMAIN` setting
   - Ensure leading dot for subdomains: `.example.com`

2. **Redirect loops**
   - Verify `DOMAIN_CURRENT_SITE` matches actual domain
   - Check SSL configuration

3. **Can't add new sites**
   - Verify `SUBDOMAIN_INSTALL` matches your setup
   - Check DNS (for subdomains) or permalinks (for subdirectories)

4. **404 on subsites**
   - Check `.htaccess` rules (provided during setup)
   - Verify server supports required rewrite rules

### Required .htaccess (Apache)

**Subdirectory Install:**
```apache
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]

# add a trailing slash to /wp-admin
RewriteRule ^([_0-9a-zA-Z-]+/)?wp-admin$ $1wp-admin/ [R=301,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?(wp-(content|admin|includes).*) $2 [L]
RewriteRule ^([_0-9a-zA-Z-]+/)?(.*\.php)$ $2 [L]
RewriteRule . index.php [L]
```

**Subdomain Install:**
```apache
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]

# add a trailing slash to /wp-admin
RewriteRule ^wp-admin$ wp-admin/ [R=301,L]

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]
RewriteRule ^(wp-(content|admin|includes).*) $1 [L]
RewriteRule ^(.*\.php)$ $1 [L]
RewriteRule . index.php [L]
```

## Security Considerations

1. **Super Admins have full access** to all sites - assign carefully
2. **Plugins activated network-wide** affect all sites
3. **Theme availability** is controlled at network level
4. **File upload types** can be restricted network-wide
5. **Consider subdomain isolation** - easier to contain compromised sites
