# WP_HTTP_Proxy Class

Core class used to implement HTTP API proxy support.

**File:** `wp-includes/class-wp-http-proxy.php`  
**Since:** 2.8.0

## Overview

`WP_HTTP_Proxy` manages proxy configuration for WordPress HTTP requests. Proxy support is configured via `wp-config.php` constants and only supports BASIC authentication by default (cURL may support additional methods like NTLM).

## Class Definition

```php
#[AllowDynamicProperties]
class WP_HTTP_Proxy {
    // All methods read from constants
}
```

## Configuration Constants

Define these in `wp-config.php`:

```php
// Required for proxy
define( 'WP_PROXY_HOST', '192.168.1.100' );
define( 'WP_PROXY_PORT', '8080' );

// Optional: Authentication
define( 'WP_PROXY_USERNAME', 'proxyuser' );
define( 'WP_PROXY_PASSWORD', 'proxypass' );

// Optional: Bypass hosts
define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, www.example.com, *.wordpress.org' );
```

## Methods

### is_enabled()

Whether proxy connection should be used.

```php
public function is_enabled(): bool
```

Returns `true` if both `WP_PROXY_HOST` and `WP_PROXY_PORT` are defined.

**Example:**

```php
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() ) {
    echo 'Proxy is configured: ' . $proxy->host() . ':' . $proxy->port();
}
```

---

### use_authentication()

Whether proxy authentication should be used.

```php
public function use_authentication(): bool
```

Returns `true` if both `WP_PROXY_USERNAME` and `WP_PROXY_PASSWORD` are defined.

---

### host()

Retrieve the proxy host.

```php
public function host(): string
```

Returns the value of `WP_PROXY_HOST` or empty string.

---

### port()

Retrieve the proxy port.

```php
public function port(): string
```

Returns the value of `WP_PROXY_PORT` or empty string.

---

### username()

Retrieve the proxy username.

```php
public function username(): string
```

Returns the value of `WP_PROXY_USERNAME` or empty string.

---

### password()

Retrieve the proxy password.

```php
public function password(): string
```

Returns the value of `WP_PROXY_PASSWORD` or empty string.

---

### authentication()

Retrieve the authentication string (username:password).

```php
public function authentication(): string
```

**Example:**

```php
$proxy = new WP_HTTP_Proxy();

if ( $proxy->use_authentication() ) {
    $auth = $proxy->authentication();  // 'username:password'
}
```

---

### authentication_header()

Retrieve the complete proxy authentication header.

```php
public function authentication_header(): string
```

Returns: `Proxy-Authorization: Basic <base64-encoded-credentials>`

**Example:**

```php
$proxy = new WP_HTTP_Proxy();

if ( $proxy->use_authentication() ) {
    $header = $proxy->authentication_header();
    // 'Proxy-Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ='
}
```

---

### send_through_proxy()

Determines whether the request should be sent through the proxy.

```php
public function send_through_proxy( string $uri ): bool
```

**Automatically bypassed:**
- `localhost`
- Site's own host
- Hosts in `WP_PROXY_BYPASS_HOSTS`

**Supports wildcards:** `*.wordpress.org` matches `api.wordpress.org`, `downloads.wordpress.org`, etc.

**Example:**

```php
$proxy = new WP_HTTP_Proxy();

// These are typically bypassed
$proxy->send_through_proxy( 'http://localhost/api' );       // false
$proxy->send_through_proxy( 'https://example.com/page' );   // false (own site)

// External URLs go through proxy
$proxy->send_through_proxy( 'https://api.github.com/repos' ); // true

// Unless in bypass list
define( 'WP_PROXY_BYPASS_HOSTS', '*.github.com' );
$proxy->send_through_proxy( 'https://api.github.com/repos' ); // false
```

---

## Filter Hook

### pre_http_send_through_proxy

Allows overriding the proxy decision.

```php
/**
 * Filters whether to send the request through the proxy.
 *
 * @param bool|null $override Whether to send through proxy. Default null.
 * @param string    $uri      URL of the request.
 * @param array     $check    Parsed request URL (parse_url result).
 * @param array     $home     Parsed site URL (parse_url result).
 */
apply_filters( 'pre_http_send_through_proxy', null, $uri, $check, $home );
```

**Return values:**
- `null` - Use default logic
- `true` - Force through proxy
- `false` - Bypass proxy

**Example:**

```php
// Force all AWS S3 requests through proxy
add_filter( 'pre_http_send_through_proxy', function( $override, $uri, $check, $home ) {
    if ( isset( $check['host'] ) && str_ends_with( $check['host'], '.amazonaws.com' ) ) {
        return true;
    }
    return $override;
}, 10, 4 );

// Never proxy internal API requests
add_filter( 'pre_http_send_through_proxy', function( $override, $uri, $check, $home ) {
    if ( isset( $check['host'] ) && 'internal-api.company.com' === $check['host'] ) {
        return false;
    }
    return $override;
}, 10, 4 );
```

---

## Configuration Examples

### Basic Proxy

```php
// wp-config.php
define( 'WP_PROXY_HOST', 'proxy.company.com' );
define( 'WP_PROXY_PORT', '3128' );
```

### Authenticated Proxy

```php
// wp-config.php
define( 'WP_PROXY_HOST', 'proxy.company.com' );
define( 'WP_PROXY_PORT', '3128' );
define( 'WP_PROXY_USERNAME', 'wpuser' );
define( 'WP_PROXY_PASSWORD', 'secretpass' );
```

### With Bypass List

```php
// wp-config.php
define( 'WP_PROXY_HOST', 'proxy.company.com' );
define( 'WP_PROXY_PORT', '3128' );
define( 'WP_PROXY_BYPASS_HOSTS', 'localhost, 127.0.0.1, *.local, api.wordpress.org' );
```

### Internal Network Access

```php
// wp-config.php
define( 'WP_PROXY_HOST', '10.0.0.1' );
define( 'WP_PROXY_PORT', '8080' );
// Bypass all internal hosts
define( 'WP_PROXY_BYPASS_HOSTS', '*.company.local, 10.*, 192.168.*' );
```

---

## Usage in Transports

### cURL Transport

```php
// In WP_Http_Curl::request()
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() && $proxy->send_through_proxy( $url ) ) {
    curl_setopt( $handle, CURLOPT_PROXYTYPE, CURLPROXY_HTTP );
    curl_setopt( $handle, CURLOPT_PROXY, $proxy->host() );
    curl_setopt( $handle, CURLOPT_PROXYPORT, $proxy->port() );
    
    if ( $proxy->use_authentication() ) {
        curl_setopt( $handle, CURLOPT_PROXYAUTH, CURLAUTH_ANY );
        curl_setopt( $handle, CURLOPT_PROXYUSERPWD, $proxy->authentication() );
    }
}
```

### Streams Transport

```php
// In WP_Http_Streams::request()
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() && $proxy->send_through_proxy( $url ) ) {
    // Connect to proxy server
    $handle = stream_socket_client(
        'tcp://' . $proxy->host() . ':' . $proxy->port(),
        $errno, $errstr, $timeout
    );
    
    // Full URL in request for proxy
    $request = "GET {$url} HTTP/1.1\r\n";
    
    if ( $proxy->use_authentication() ) {
        $request .= $proxy->authentication_header() . "\r\n";
    }
}
```

### Requests Library (WP_Http)

```php
// In WP_Http::request()
$proxy = new WP_HTTP_Proxy();

if ( $proxy->is_enabled() && $proxy->send_through_proxy( $url ) ) {
    $options['proxy'] = new WpOrg\Requests\Proxy\Http(
        $proxy->host() . ':' . $proxy->port()
    );
    
    if ( $proxy->use_authentication() ) {
        $options['proxy']->use_authentication = true;
        $options['proxy']->user = $proxy->username();
        $options['proxy']->pass = $proxy->password();
    }
}
```

---

## Debugging Proxy Issues

```php
function debug_proxy_config() {
    $proxy = new WP_HTTP_Proxy();
    
    echo "Proxy Enabled: " . ( $proxy->is_enabled() ? 'Yes' : 'No' ) . "\n";
    
    if ( $proxy->is_enabled() ) {
        echo "Host: " . $proxy->host() . "\n";
        echo "Port: " . $proxy->port() . "\n";
        echo "Auth Required: " . ( $proxy->use_authentication() ? 'Yes' : 'No' ) . "\n";
        
        if ( defined( 'WP_PROXY_BYPASS_HOSTS' ) ) {
            echo "Bypass Hosts: " . WP_PROXY_BYPASS_HOSTS . "\n";
        }
    }
}

function test_proxy_routing( $url ) {
    $proxy = new WP_HTTP_Proxy();
    
    if ( ! $proxy->is_enabled() ) {
        echo "Proxy not configured\n";
        return;
    }
    
    if ( $proxy->send_through_proxy( $url ) ) {
        echo "{$url} -> Through proxy\n";
    } else {
        echo "{$url} -> Direct connection\n";
    }
}

// Test various URLs
test_proxy_routing( 'https://api.wordpress.org/plugins' );
test_proxy_routing( 'http://localhost/api' );
test_proxy_routing( 'https://api.github.com/repos' );
```

---

## Security Considerations

1. **Credentials in config:** Proxy credentials are stored in plain text in `wp-config.php`. Ensure proper file permissions.

2. **Bypass host validation:** Wildcard patterns use simple regex replacement. Very complex patterns may not work as expected.

3. **Authentication method:** Only BASIC authentication is supported by default. cURL may support additional methods depending on build options.

4. **SSL through proxy:** When using HTTPS through a proxy, the connection is tunneled (CONNECT method). The proxy cannot inspect encrypted traffic.

---

## Troubleshooting

### Proxy Not Working

1. Verify constants are defined:
   ```php
   var_dump( defined( 'WP_PROXY_HOST' ), defined( 'WP_PROXY_PORT' ) );
   ```

2. Check if request is being bypassed:
   ```php
   $proxy = new WP_HTTP_Proxy();
   var_dump( $proxy->send_through_proxy( $url ) );
   ```

3. Test connection to proxy:
   ```php
   $fp = @fsockopen( WP_PROXY_HOST, WP_PROXY_PORT, $errno, $errstr, 5 );
   if ( ! $fp ) {
       echo "Cannot connect to proxy: {$errstr}";
   }
   ```

### Authentication Failures

1. Verify credentials:
   ```php
   $proxy = new WP_HTTP_Proxy();
   echo $proxy->authentication_header();
   ```

2. Check if proxy requires different auth method (NTLM, Digest)

3. Ensure no special characters in password are causing issues
