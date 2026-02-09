# Security Settings

WordPress security constants protect your site through authentication tokens, file access controls, and SSL/HTTPS enforcement.

## Security Keys and Salts

Security keys are used to encrypt information stored in cookies. Each key should be unique, random, and at least 64 characters long.

### Generate Keys

Get fresh keys from the official WordPress API:
```
https://api.wordpress.org/secret-key/1.1/salt/
```

### AUTH_KEY

```php
define( 'AUTH_KEY', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Signs the authentication cookie for admin and logged-in users on HTTP
- **When Changed**: All users must re-login

### SECURE_AUTH_KEY

```php
define( 'SECURE_AUTH_KEY', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Signs the authentication cookie for admin users on HTTPS
- **When Changed**: All admin users must re-login

### LOGGED_IN_KEY

```php
define( 'LOGGED_IN_KEY', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Signs the cookie that identifies a logged-in user (used client-side)
- **When Changed**: All logged-in users must re-login

### NONCE_KEY

```php
define( 'NONCE_KEY', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Protects nonces (number used once) for CSRF protection
- **When Changed**: All forms and AJAX requests need new nonces

### AUTH_SALT

```php
define( 'AUTH_SALT', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Additional randomness for AUTH_KEY

### SECURE_AUTH_SALT

```php
define( 'SECURE_AUTH_SALT', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Additional randomness for SECURE_AUTH_KEY

### LOGGED_IN_SALT

```php
define( 'LOGGED_IN_SALT', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Additional randomness for LOGGED_IN_KEY

### NONCE_SALT

```php
define( 'NONCE_SALT', 'unique-random-phrase-at-least-64-chars' );
```

- **Purpose**: Additional randomness for NONCE_KEY

### Complete Example

```php
define( 'AUTH_KEY',         'Xv$2k!9fPz@mQ#nR^wL&5jH*8cY(3bN>6gT<0sA+4dE=7iU' );
define( 'SECURE_AUTH_KEY',  'Qm#4nR@9wL$2jH&5cY^8bN*3gT!6sA<0dE>7iU+Xv=Pz(fK' );
define( 'LOGGED_IN_KEY',    'Wl&5jH$2cY@9bN#4gT^8sA*3dE!6iU<0Xv>7Pz+Qm=fK(nR' );
define( 'NONCE_KEY',        'Cy^8bN$2gT@9sA#4dE&5iU*3Xv!6Pz<0Qm>7fK+Wl=nR(jH' );
define( 'AUTH_SALT',        'Gt@9sA$2dE#4iU&5Xv^8Pz*3Qm!6fK<0Wl>7nR+Cy=jH(bN' );
define( 'SECURE_AUTH_SALT', 'Da#4iU$2Xv@9Pz&5Qm^8fK*3Wl!6nR<0Cy>7jH+Gt=bN(sA' );
define( 'LOGGED_IN_SALT',   'Iu&5Xv$2Pz@9Qm#4fK^8Wl*3nR!6Cy<0jH>7bN+Da=sA(iU' );
define( 'NONCE_SALT',       'Pz^8Qm$2fK@9Wl#4nR&5Cy*3jH!6bN<0sA>7iU+Iu=Xv(Da' );
```

### Rotating Keys

To force all users to log out, change any of the keys/salts. Useful when:
- Suspecting compromised credentials
- After removing a user with elevated access
- As a periodic security measure

## File Editing Controls

### DISALLOW_FILE_EDIT

```php
define( 'DISALLOW_FILE_EDIT', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Disables the Theme Editor and Plugin Editor in wp-admin
- **Recommendation**: Set to `true` in production
- **Effect**: Removes "Edit" links from themes/plugins; blocks `theme-editor.php` and `plugin-editor.php`

### DISALLOW_FILE_MODS

```php
define( 'DISALLOW_FILE_MODS', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Disables all file modifications through WordPress
- **Effect**:
  - Disables Theme/Plugin Editor (includes `DISALLOW_FILE_EDIT`)
  - Disables plugin/theme installation
  - Disables plugin/theme updates
  - Disables WordPress core updates
- **Use Case**: Managed hosting where updates are handled via deployment

**Note**: `DISALLOW_FILE_MODS` is more restrictive than `DISALLOW_FILE_EDIT`. You only need one or the other.

## SSL/HTTPS Settings

### FORCE_SSL_ADMIN

```php
define( 'FORCE_SSL_ADMIN', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Forces SSL/HTTPS for all admin and login pages
- **Effect**: Redirects all `/wp-admin/` and `/wp-login.php` requests to HTTPS
- **Requirement**: Valid SSL certificate must be installed

### FORCE_SSL_LOGIN (Deprecated)

```php
define( 'FORCE_SSL_LOGIN', true ); // Deprecated since WordPress 4.0
```

- **Status**: Deprecated
- **Replacement**: Use `FORCE_SSL_ADMIN` instead

## Cookie Settings

### COOKIE_DOMAIN

```php
define( 'COOKIE_DOMAIN', 'example.com' );
```

- **Type**: String
- **Default**: Current domain
- **Purpose**: Sets the domain for WordPress cookies
- **Use Case**: Sharing cookies across subdomains

```php
// Allow cookies for all subdomains
define( 'COOKIE_DOMAIN', '.example.com' );
```

### COOKIEPATH

```php
define( 'COOKIEPATH', '/' );
```

- **Type**: String
- **Default**: Path to WordPress installation
- **Purpose**: Path for standard WordPress cookies

### SITECOOKIEPATH

```php
define( 'SITECOOKIEPATH', '/' );
```

- **Type**: String
- **Default**: Site URL path
- **Purpose**: Path for site-wide cookies

### ADMIN_COOKIE_PATH

```php
define( 'ADMIN_COOKIE_PATH', '/wp-admin' );
```

- **Type**: String
- **Default**: `SITECOOKIEPATH . 'wp-admin'`
- **Purpose**: Path for admin area cookies

### PLUGINS_COOKIE_PATH

```php
define( 'PLUGINS_COOKIE_PATH', '/wp-content/plugins' );
```

- **Type**: String
- **Default**: `WP_PLUGIN_URL` path
- **Purpose**: Path for plugin cookies

### Cookie Name Constants

```php
define( 'USER_COOKIE', 'wordpressuser_' . COOKIEHASH );
define( 'PASS_COOKIE', 'wordpresspass_' . COOKIEHASH );
define( 'AUTH_COOKIE', 'wordpress_' . COOKIEHASH );
define( 'SECURE_AUTH_COOKIE', 'wordpress_sec_' . COOKIEHASH );
define( 'LOGGED_IN_COOKIE', 'wordpress_logged_in_' . COOKIEHASH );
define( 'TEST_COOKIE', 'wordpress_test_cookie' );
```

- **Purpose**: Customize cookie names (rarely needed)
- **Use Case**: Running multiple WordPress installations on the same domain

## Proxy Settings

For WordPress installations behind a reverse proxy, load balancer, or CDN.

### HTTP Proxy Configuration

```php
define( 'WP_PROXY_HOST', '192.168.1.100' );
define( 'WP_PROXY_PORT', '8080' );
```

- **Purpose**: Route outgoing HTTP requests through a proxy server

### WP_PROXY_USERNAME / WP_PROXY_PASSWORD

```php
define( 'WP_PROXY_USERNAME', 'proxy_user' );
define( 'WP_PROXY_PASSWORD', 'proxy_pass' );
```

- **Purpose**: Authentication for proxy server

### WP_PROXY_BYPASS_HOSTS

```php
define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, www.example.com, *.local' );
```

- **Type**: Comma-separated string
- **Purpose**: Hosts that should bypass the proxy
- **Wildcards**: Use `*.domain.com` for subdomains

### Complete Proxy Example

```php
define( 'WP_PROXY_HOST', '192.168.1.100' );
define( 'WP_PROXY_PORT', '8080' );
define( 'WP_PROXY_USERNAME', 'proxyuser' );
define( 'WP_PROXY_PASSWORD', 'proxypass' );
define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, *.local, api.wordpress.org' );
```

## Reverse Proxy / Load Balancer Detection

When behind a load balancer or reverse proxy, WordPress may not detect HTTPS correctly.

```php
// Trust X-Forwarded-Proto header from proxy
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
    $_SERVER['HTTPS'] = 'on';
}
```

Or for specific proxy IPs:

```php
// Only trust header from known proxy IPs
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) 
     && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO']
     && in_array( $_SERVER['REMOTE_ADDR'], array( '10.0.0.1', '10.0.0.2' ), true ) 
) {
    $_SERVER['HTTPS'] = 'on';
}
```

## Block External Requests

### WP_HTTP_BLOCK_EXTERNAL

```php
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Blocks all outgoing HTTP requests from WordPress
- **Effect**: Prevents updates, API calls, oEmbed, etc.

### WP_ACCESSIBLE_HOSTS

```php
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org, downloads.wordpress.org, *.github.com' );
```

- **Type**: Comma-separated string
- **Purpose**: Whitelist of allowed hosts when `WP_HTTP_BLOCK_EXTERNAL` is true
- **Wildcards**: Supports `*.domain.com` patterns

### Example: Allow Only Essential Hosts

```php
define( 'WP_HTTP_BLOCK_EXTERNAL', true );
define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org, downloads.wordpress.org, *.wordpress.org' );
```

## Additional Security Constants

### DISALLOW_UNFILTERED_HTML

```php
define( 'DISALLOW_UNFILTERED_HTML', true );
```

- **Type**: Boolean
- **Default**: Not defined (Administrators/Editors can post unfiltered HTML)
- **Purpose**: Prevents any user from posting unfiltered HTML, JavaScript, etc.
- **Effect**: All HTML is sanitized regardless of user capabilities
- **Multisite**: Always enabled for non-super-admins by default

### ALLOW_UNFILTERED_UPLOADS

```php
define( 'ALLOW_UNFILTERED_UPLOADS', true );
```

- **Type**: Boolean
- **Default**: Not defined (false)
- **Purpose**: Allows uploading any file type (extremely dangerous!)
- **Warning**: Never enable in production - allows PHP, executable uploads

### WP_SITEURL and WP_HOME

```php
define( 'WP_SITEURL', 'https://example.com' );
define( 'WP_HOME', 'https://example.com' );
```

- **Purpose**: Hardcode site URLs, preventing database tampering
- **Security Benefit**: Attackers can't redirect site by modifying database
- **Note**: Overrides database values in `wp_options`

## Security Best Practices Summary

1. **Always set unique security keys** - Generate from WordPress API
2. **Rotate keys periodically** - Especially after security incidents
3. **Enable FORCE_SSL_ADMIN** - Protect login credentials
4. **Set DISALLOW_FILE_EDIT** - Prevent code injection via admin
5. **Consider DISALLOW_FILE_MODS** - For managed deployments
6. **Hardcode WP_SITEURL/WP_HOME** - Prevent redirect attacks
7. **Configure proper cookie domains** - For subdomain setups
8. **Block external requests** - If external API calls aren't needed
9. **Set DISALLOW_UNFILTERED_HTML** - If users don't need script/iframe capability
