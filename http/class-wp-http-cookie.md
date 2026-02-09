# WP_Http_Cookie Class

Core class used to encapsulate a single cookie object for internal use.

**File:** `wp-includes/class-wp-http-cookie.php`  
**Since:** 2.8.0

## Overview

`WP_Http_Cookie` represents an HTTP cookie in WordPress. It handles parsing Set-Cookie headers, validating cookies for specific URLs, and formatting cookies for transmission.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_Http_Cookie {
    public $name;
    public $value;
    public $expires;
    public $path;
    public $domain;
    public $port;
    public $host_only;
}
```

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$name` | string | Cookie name |
| `$value` | string | Cookie value |
| `$expires` | string\|int\|null | Expiration (Unix timestamp or formatted date) |
| `$path` | string | URL path restriction |
| `$domain` | string | Domain restriction |
| `$port` | int\|string | Port or comma-separated list of ports |
| `$host_only` | bool | Host-only flag (since 5.2.0) |

## Constructor

```php
public function __construct( string|array $data, string $requested_url = '' )
```

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | string\|array | Raw cookie data (header string or data array) |
| `$requested_url` | string | The URL where the cookie was set |

### From Header String

```php
// Parse a Set-Cookie header
$cookie = new WP_Http_Cookie( 
    'session_id=abc123; path=/; domain=.example.com; expires=Thu, 01 Jan 2025 00:00:00 GMT; HttpOnly',
    'https://example.com/login'
);

echo $cookie->name;    // 'session_id'
echo $cookie->value;   // 'abc123'
echo $cookie->path;    // '/'
echo $cookie->domain;  // '.example.com'
```

### From Array

```php
$cookie = new WP_Http_Cookie( [
    'name'      => 'auth_token',
    'value'     => 'xyz789',
    'expires'   => time() + 3600,  // 1 hour
    'path'      => '/api/',
    'domain'    => 'api.example.com',
    'host_only' => true,
] );
```

### Array Parameters

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `name` | string | Required | Cookie name |
| `value` | mixed | - | Cookie value (not URL-encoded) |
| `expires` | string\|int\|null | null | Unix timestamp or date string |
| `path` | string | Path from URL | Path restriction |
| `domain` | string | Host from URL | Domain restriction |
| `port` | int\|string | null | Port restriction |
| `host_only` | bool | true | Host-only storage flag |

## Methods

### test()

Confirms that it's OK to send this cookie to the URL checked against.

```php
public function test( string $url ): bool
```

Validates based on RFC 2109/2965:
- Cookie not expired
- Domain matches
- Path matches
- Port matches (if specified)

**Example:**

```php
$cookie = new WP_Http_Cookie( [
    'name'    => 'session',
    'value'   => '123',
    'domain'  => '.example.com',
    'path'    => '/app/',
    'expires' => time() + 3600,
] );

$cookie->test( 'https://www.example.com/app/page' );  // true
$cookie->test( 'https://other.com/app/page' );        // false (wrong domain)
$cookie->test( 'https://www.example.com/other/' );    // false (wrong path)
```

---

### getHeaderValue()

Convert cookie name and value to header string format.

```php
public function getHeaderValue(): string
```

**Returns:** `name=value` formatted string.

**Example:**

```php
$cookie = new WP_Http_Cookie( [
    'name'  => 'user_id',
    'value' => '42',
] );

echo $cookie->getHeaderValue();  // 'user_id=42'
```

**Filter:**

```php
/**
 * Filters the header-encoded cookie value.
 *
 * @param string $value The cookie value.
 * @param string $name  The cookie name.
 */
apply_filters( 'wp_http_cookie_value', $value, $name );
```

---

### getFullHeader()

Retrieve complete Cookie header for HTTP requests.

```php
public function getFullHeader(): string
```

**Returns:** Full header string including "Cookie: " prefix.

**Example:**

```php
$cookie = new WP_Http_Cookie( [
    'name'  => 'auth',
    'value' => 'token123',
] );

echo $cookie->getFullHeader();  // 'Cookie: auth=token123'
```

---

### get_attributes()

Retrieves cookie attributes for use with the Requests library.

```php
public function get_attributes(): array
```

**Returns:**

```php
[
    'expires' => int|string|null,  // Expiration
    'path'    => string,           // Path restriction
    'domain'  => string,           // Domain restriction
]
```

**Example:**

```php
$cookie = new WP_Http_Cookie( [
    'name'    => 'session',
    'value'   => 'abc',
    'expires' => strtotime( '+1 hour' ),
    'path'    => '/app/',
    'domain'  => 'example.com',
] );

$attrs = $cookie->get_attributes();
// [
//     'expires' => 1234567890,
//     'path'    => '/app/',
//     'domain'  => 'example.com',
// ]
```

---

## Usage Examples

### Creating Cookies to Send

```php
// Simple name-value cookie
$cookies = [
    new WP_Http_Cookie( [
        'name'  => 'session_id',
        'value' => 'abc123',
    ] ),
];

// Send with request
$response = wp_remote_get( 'https://api.example.com/data', [
    'cookies' => $cookies,
] );
```

### Using Cookies from Response

```php
$response = wp_remote_get( 'https://api.example.com/login', [
    'body' => [ 'user' => 'test', 'pass' => 'secret' ],
] );

// Get all cookies from response
$cookies = wp_remote_retrieve_cookies( $response );

// Filter valid cookies for next request
$next_url = 'https://api.example.com/dashboard';
$valid_cookies = array_filter( $cookies, function( $cookie ) use ( $next_url ) {
    return $cookie->test( $next_url );
} );

// Use cookies in subsequent request
$response = wp_remote_get( $next_url, [
    'cookies' => $valid_cookies,
] );
```

### Persisting Cookies

```php
function store_api_cookies( $cookies ) {
    $serializable = [];
    
    foreach ( $cookies as $cookie ) {
        $serializable[] = [
            'name'      => $cookie->name,
            'value'     => $cookie->value,
            'expires'   => $cookie->expires,
            'path'      => $cookie->path,
            'domain'    => $cookie->domain,
            'host_only' => $cookie->host_only,
        ];
    }
    
    update_option( 'api_cookies', $serializable );
}

function restore_api_cookies() {
    $stored = get_option( 'api_cookies', [] );
    $cookies = [];
    
    foreach ( $stored as $data ) {
        $cookie = new WP_Http_Cookie( $data );
        
        // Skip expired cookies
        if ( $cookie->expires && time() > $cookie->expires ) {
            continue;
        }
        
        $cookies[] = $cookie;
    }
    
    return $cookies;
}
```

### Session Management Pattern

```php
class API_Client {
    private $base_url = 'https://api.example.com';
    private $cookies = [];
    
    public function login( $username, $password ) {
        $response = wp_remote_post( $this->base_url . '/auth/login', [
            'body' => [
                'username' => $username,
                'password' => $password,
            ],
        ] );
        
        if ( is_wp_error( $response ) ) {
            return $response;
        }
        
        // Store session cookies
        $this->cookies = wp_remote_retrieve_cookies( $response );
        
        return 200 === wp_remote_retrieve_response_code( $response );
    }
    
    public function request( $endpoint, $args = [] ) {
        $url = $this->base_url . '/' . ltrim( $endpoint, '/' );
        
        // Add session cookies
        $args['cookies'] = $this->filter_cookies_for_url( $url );
        
        $response = wp_remote_request( $url, $args );
        
        // Update cookies from response
        if ( ! is_wp_error( $response ) ) {
            $new_cookies = wp_remote_retrieve_cookies( $response );
            $this->merge_cookies( $new_cookies );
        }
        
        return $response;
    }
    
    private function filter_cookies_for_url( $url ) {
        return array_filter( $this->cookies, function( $cookie ) use ( $url ) {
            return $cookie->test( $url );
        } );
    }
    
    private function merge_cookies( $new_cookies ) {
        foreach ( $new_cookies as $new ) {
            // Replace existing cookie with same name
            $this->cookies = array_filter( 
                $this->cookies, 
                function( $existing ) use ( $new ) {
                    return $existing->name !== $new->name;
                }
            );
            $this->cookies[] = $new;
        }
    }
}
```

### Checking Cookie Expiration

```php
function is_cookie_valid( WP_Http_Cookie $cookie ) {
    // No expiration = session cookie (always valid during session)
    if ( ! isset( $cookie->expires ) || null === $cookie->expires ) {
        return true;
    }
    
    return time() < $cookie->expires;
}

function get_cookie_expiry_info( WP_Http_Cookie $cookie ) {
    if ( ! isset( $cookie->expires ) || null === $cookie->expires ) {
        return 'Session cookie (expires when browser closes)';
    }
    
    $expires = $cookie->expires;
    $now = time();
    
    if ( $expires < $now ) {
        return 'Expired ' . human_time_diff( $expires, $now ) . ' ago';
    }
    
    return 'Expires in ' . human_time_diff( $now, $expires );
}
```

## Cookie Parsing Notes

### Domain Handling

- Leading dot (`.example.com`) allows subdomains
- Without dot, exact match required (when `host_only` is true)
- `.local` is appended to single-label domains

### Path Handling

- Path from URL is used as default
- Trailing slash is normalized
- Cookie path must be prefix of request path

### Port Handling

- Comma-separated list supported: `"80,8080,443"`
- If not specified, any port matches

## Related

- `WP_HTTP_Requests_Response::get_cookies()` - Extracts cookies from response
- `WP_Http::buildCookieHeader()` - Builds Cookie header from array
- `WP_Http::normalize_cookies()` - Converts to Requests library format
