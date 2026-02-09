# WordPress HTTP API Hooks

This document covers all filters and actions available in the WordPress HTTP API.

## Request Filters

### http_request_timeout

Filters the timeout value for an HTTP request.

```php
apply_filters( 'http_request_timeout', float $timeout_value, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$timeout_value` | float | Timeout in seconds. Default 5. |
| `$url` | string | The request URL. |

**Example:**

```php
// Increase timeout for specific API
add_filter( 'http_request_timeout', function( $timeout, $url ) {
    if ( str_contains( $url, 'slow-api.example.com' ) ) {
        return 30;
    }
    return $timeout;
}, 10, 2 );
```

---

### http_request_redirection_count

Filters the number of redirects allowed.

```php
apply_filters( 'http_request_redirection_count', int $redirect_count, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$redirect_count` | int | Number of redirects. Default 5. |
| `$url` | string | The request URL. |

**Example:**

```php
// Allow more redirects for specific URLs
add_filter( 'http_request_redirection_count', function( $count, $url ) {
    if ( str_contains( $url, 'link-shortener.com' ) ) {
        return 10;
    }
    return $count;
}, 10, 2 );
```

---

### http_request_version

Filters the HTTP protocol version.

```php
apply_filters( 'http_request_version', string $version, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$version` | string | HTTP version. '1.0' or '1.1'. Default '1.0'. |
| `$url` | string | The request URL. |

**Example:**

```php
// Force HTTP/1.1 for specific APIs
add_filter( 'http_request_version', function( $version, $url ) {
    if ( str_contains( $url, 'modern-api.com' ) ) {
        return '1.1';
    }
    return $version;
}, 10, 2 );
```

---

### http_headers_useragent

Filters the user agent value sent with requests.

```php
apply_filters( 'http_headers_useragent', string $user_agent, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$user_agent` | string | WordPress user agent string. |
| `$url` | string | The request URL. |

**Example:**

```php
// Custom user agent for specific API
add_filter( 'http_headers_useragent', function( $ua, $url ) {
    if ( str_contains( $url, 'api.example.com' ) ) {
        return 'MyPlugin/1.0';
    }
    return $ua;
}, 10, 2 );
```

---

### http_request_reject_unsafe_urls

Filters whether URLs should be validated with `wp_http_validate_url()`.

```php
apply_filters( 'http_request_reject_unsafe_urls', bool $reject, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$reject` | bool | Whether to validate URLs. Default false. |
| `$url` | string | The request URL. |

**Example:**

```php
// Always validate URLs for untrusted sources
add_filter( 'http_request_reject_unsafe_urls', function( $reject, $url ) {
    // Force validation for user-submitted URLs
    if ( did_action( 'user_webhook_request' ) ) {
        return true;
    }
    return $reject;
}, 10, 2 );
```

---

### http_request_args

Filters all arguments used in an HTTP request.

```php
apply_filters( 'http_request_args', array $parsed_args, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$parsed_args` | array | All HTTP request arguments. |
| `$url` | string | The request URL. |

**Example:**

```php
// Add authentication header to specific API
add_filter( 'http_request_args', function( $args, $url ) {
    if ( str_contains( $url, 'api.example.com' ) ) {
        $args['headers']['Authorization'] = 'Bearer ' . get_option( 'api_token' );
    }
    return $args;
}, 10, 2 );

// Add custom header to all requests
add_filter( 'http_request_args', function( $args, $url ) {
    $args['headers']['X-Request-ID'] = wp_generate_uuid4();
    return $args;
}, 10, 2 );
```

---

## Response Filters

### pre_http_request

Short-circuits the HTTP request and returns a custom response.

```php
apply_filters( 'pre_http_request', false|array|WP_Error $response, array $parsed_args, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | false\|array\|WP_Error | Response to return. Default false (don't short-circuit). |
| `$parsed_args` | array | HTTP request arguments. |
| `$url` | string | The request URL. |

**Return:**
- `false` - Continue with normal request
- `array` - Return this as the response (must include headers, body, response, cookies, filename)
- `WP_Error` - Return this error

**Example:**

```php
// Mock API responses for testing
add_filter( 'pre_http_request', function( $response, $args, $url ) {
    if ( defined( 'WP_TESTS_RUNNING' ) && str_contains( $url, 'api.example.com' ) ) {
        return [
            'headers'  => [],
            'body'     => '{"mocked": true}',
            'response' => [ 'code' => 200, 'message' => 'OK' ],
            'cookies'  => [],
            'filename' => null,
        ];
    }
    return $response;
}, 10, 3 );

// Cache API responses
add_filter( 'pre_http_request', function( $response, $args, $url ) {
    if ( 'GET' !== $args['method'] ) {
        return $response;
    }
    
    $cache_key = 'http_cache_' . md5( $url );
    $cached = get_transient( $cache_key );
    
    if ( false !== $cached ) {
        return $cached;
    }
    
    return $response;
}, 10, 3 );
```

---

### http_response

Filters a successful HTTP response before it's returned.

```php
apply_filters( 'http_response', array $response, array $parsed_args, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | array | HTTP response array. |
| `$parsed_args` | array | HTTP request arguments. |
| `$url` | string | The request URL. |

**Example:**

```php
// Log all API responses
add_filter( 'http_response', function( $response, $args, $url ) {
    if ( str_contains( $url, 'api.example.com' ) ) {
        $log = [
            'url'    => $url,
            'method' => $args['method'],
            'status' => $response['response']['code'],
            'time'   => current_time( 'mysql' ),
        ];
        // Log to database or file
    }
    return $response;
}, 10, 3 );

// Cache successful responses
add_filter( 'http_response', function( $response, $args, $url ) {
    if ( 'GET' !== $args['method'] ) {
        return $response;
    }
    
    $code = $response['response']['code'];
    if ( $code >= 200 && $code < 300 ) {
        $cache_key = 'http_cache_' . md5( $url );
        set_transient( $cache_key, $response, HOUR_IN_SECONDS );
    }
    
    return $response;
}, 10, 3 );
```

---

## SSL Filters

### https_ssl_verify

Filters whether SSL should be verified for non-local requests.

```php
apply_filters( 'https_ssl_verify', bool|string $ssl_verify, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ssl_verify` | bool\|string | Whether to verify SSL, or path to certificate. |
| `$url` | string | The request URL. |

**Example:**

```php
// Disable SSL verification for development (NEVER in production!)
add_filter( 'https_ssl_verify', function( $verify, $url ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        if ( str_contains( $url, 'dev.example.com' ) ) {
            return false;
        }
    }
    return $verify;
}, 10, 2 );

// Use custom CA certificate
add_filter( 'https_ssl_verify', function( $verify, $url ) {
    if ( str_contains( $url, 'internal-api.company.com' ) ) {
        return '/path/to/company-ca.crt';
    }
    return $verify;
}, 10, 2 );
```

---

### https_local_ssl_verify

Filters SSL verification for local requests.

```php
apply_filters( 'https_local_ssl_verify', bool|string $ssl_verify, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$ssl_verify` | bool\|string | Whether to verify SSL for local requests. |
| `$url` | string | The request URL. |

---

## URL Validation Filters

### http_request_host_is_external

Checks if a host is external (allows request to private IPs when filtering).

```php
apply_filters( 'http_request_host_is_external', bool $is_external, string $host, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$is_external` | bool | Whether host is external. |
| `$host` | string | Host name. |
| `$url` | string | The request URL. |

**Example:**

```php
// Allow internal network requests
add_filter( 'http_request_host_is_external', function( $is_external, $host, $url ) {
    // Allow company internal services
    if ( str_ends_with( $host, '.internal.company.com' ) ) {
        return true;
    }
    return $is_external;
}, 10, 3 );
```

---

### http_allowed_safe_ports

Controls which ports are allowed for HTTP requests.

```php
apply_filters( 'http_allowed_safe_ports', int[] $allowed_ports, string $host, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$allowed_ports` | int[] | Allowed ports. Default: [80, 443, 8080]. |
| `$host` | string | Host name. |
| `$url` | string | The request URL. |

**Example:**

```php
// Allow additional ports
add_filter( 'http_allowed_safe_ports', function( $ports, $host, $url ) {
    // Allow custom API port
    if ( 'api.example.com' === $host ) {
        $ports[] = 3000;
    }
    return $ports;
}, 10, 3 );
```

---

## Blocking Filters

### block_local_requests

Filters whether to block local requests.

```php
apply_filters( 'block_local_requests', bool $block )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$block` | bool | Whether to block local requests. Default false. |

**Example:**

```php
// Block localhost requests in production
add_filter( 'block_local_requests', function( $block ) {
    if ( 'production' === wp_get_environment_type() ) {
        return true;
    }
    return $block;
} );
```

---

## Transport Filters

### http_api_transports

Filters available HTTP transports.

```php
apply_filters( 'http_api_transports', string[] $transports, array $args, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$transports` | string[] | Transport classes. Default: ['curl', 'streams']. |
| `$args` | array | Request arguments. |
| `$url` | string | The request URL. |

**Deprecated:** 6.4.0 - Use Requests library transport handling.

---

### use_curl_transport

Filters whether cURL can be used.

```php
apply_filters( 'use_curl_transport', bool $use_class, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$use_class` | bool | Whether to use cURL. Default true. |
| `$args` | array | Request arguments. |

**Example:**

```php
// Force streams transport
add_filter( 'use_curl_transport', '__return_false' );
```

---

### use_streams_transport

Filters whether PHP Streams can be used.

```php
apply_filters( 'use_streams_transport', bool $use_class, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$use_class` | bool | Whether to use Streams. Default true. |
| `$args` | array | Request arguments. |

---

## Encoding Filters

### wp_http_accept_encoding

Filters allowed encoding types.

```php
apply_filters( 'wp_http_accept_encoding', string[] $type, string $url, array $args )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$type` | string[] | Encoding types with priorities. |
| `$url` | string | Request URL. |
| `$args` | array | Request arguments. |

**Example:**

```php
// Disable all compression
add_filter( 'wp_http_accept_encoding', '__return_empty_array' );

// Only allow gzip
add_filter( 'wp_http_accept_encoding', function( $types ) {
    return [ 'gzip;q=1.0' ];
} );
```

---

## Cookie Filters

### wp_http_cookie_value

Filters the cookie value before sending.

```php
apply_filters( 'wp_http_cookie_value', string $value, string $name )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$value` | string | Cookie value. |
| `$name` | string | Cookie name. |

**Example:**

```php
// Encode special characters in cookies
add_filter( 'wp_http_cookie_value', function( $value, $name ) {
    return rawurlencode( $value );
}, 10, 2 );
```

---

## Proxy Filters

### pre_http_send_through_proxy

Filters whether to send request through proxy.

```php
apply_filters( 'pre_http_send_through_proxy', bool|null $override, string $uri, array $check, array $home )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$override` | bool\|null | null to use default, true/false to override. |
| `$uri` | string | Request URL. |
| `$check` | array | Parsed request URL. |
| `$home` | array | Parsed site URL. |

**Example:**

```php
// Force certain requests through proxy
add_filter( 'pre_http_send_through_proxy', function( $override, $uri ) {
    if ( str_contains( $uri, 'external-api.com' ) ) {
        return true;
    }
    return $override;
}, 10, 2 );
```

---

## CORS Filters

### http_origin

Filters the HTTP origin of current request.

```php
apply_filters( 'http_origin', string $origin )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$origin` | string | HTTP origin from request. |

---

### allowed_http_origins

Filters list of allowed HTTP origins.

```php
apply_filters( 'allowed_http_origins', string[] $allowed_origins )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$allowed_origins` | string[] | Array of allowed origin URLs. |

**Example:**

```php
// Add additional allowed origins
add_filter( 'allowed_http_origins', function( $origins ) {
    $origins[] = 'https://app.example.com';
    $origins[] = 'https://mobile.example.com';
    return $origins;
} );
```

---

### allowed_http_origin

Filters the allowed HTTP origin result.

```php
apply_filters( 'allowed_http_origin', string $origin, string $origin_arg )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$origin` | string | Origin URL if allowed, empty if not. |
| `$origin_arg` | string | Original origin argument. |

---

## Actions

### http_api_debug

Fires after HTTP response is received.

```php
do_action( 'http_api_debug', array|WP_Error $response, string $context, string $class, array $parsed_args, string $url )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$response` | array\|WP_Error | Response or error. |
| `$context` | string | Context ('response'). |
| `$class` | string | Transport class used. |
| `$parsed_args` | array | Request arguments. |
| `$url` | string | Request URL. |

**Example:**

```php
// Log all HTTP requests
add_action( 'http_api_debug', function( $response, $context, $class, $args, $url ) {
    $log_entry = [
        'time'   => current_time( 'mysql' ),
        'url'    => $url,
        'method' => $args['method'],
        'class'  => $class,
        'error'  => is_wp_error( $response ) ? $response->get_error_message() : null,
        'status' => is_wp_error( $response ) ? null : $response['response']['code'],
    ];
    
    error_log( wp_json_encode( $log_entry ) );
}, 10, 5 );
```

---

### http_api_curl

Fires before cURL request is executed.

```php
do_action_ref_array( 'http_api_curl', array( &$handle, $parsed_args, $url ) )
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handle` | resource | cURL handle (by reference). |
| `$parsed_args` | array | Request arguments. |
| `$url` | string | Request URL. |

**Example:**

```php
// Add custom cURL options
add_action( 'http_api_curl', function( &$handle, $args, $url ) {
    // Force IPv4
    curl_setopt( $handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
    
    // Enable verbose debugging
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        curl_setopt( $handle, CURLOPT_VERBOSE, true );
    }
    
    // Client certificate authentication
    if ( str_contains( $url, 'secure.example.com' ) ) {
        curl_setopt( $handle, CURLOPT_SSLCERT, '/path/to/cert.pem' );
        curl_setopt( $handle, CURLOPT_SSLKEY, '/path/to/key.pem' );
    }
}, 10, 3 );
```

---

## Common Hook Patterns

### Request Logging

```php
add_filter( 'http_request_args', function( $args, $url ) {
    $args['_request_time'] = microtime( true );
    return $args;
}, 10, 2 );

add_action( 'http_api_debug', function( $response, $context, $class, $args, $url ) {
    $duration = isset( $args['_request_time'] ) 
        ? microtime( true ) - $args['_request_time'] 
        : null;
    
    error_log( sprintf(
        '[HTTP] %s %s - %s (%.2fs)',
        $args['method'],
        $url,
        is_wp_error( $response ) ? 'ERROR' : $response['response']['code'],
        $duration
    ) );
}, 10, 5 );
```

### API Authentication

```php
add_filter( 'http_request_args', function( $args, $url ) {
    $api_configs = [
        'api.github.com'   => [ 'header' => 'Authorization', 'value' => 'token ' . GITHUB_TOKEN ],
        'api.stripe.com'   => [ 'header' => 'Authorization', 'value' => 'Bearer ' . STRIPE_KEY ],
        'api.sendgrid.com' => [ 'header' => 'Authorization', 'value' => 'Bearer ' . SENDGRID_KEY ],
    ];
    
    $host = parse_url( $url, PHP_URL_HOST );
    
    if ( isset( $api_configs[ $host ] ) ) {
        $config = $api_configs[ $host ];
        $args['headers'][ $config['header'] ] = $config['value'];
    }
    
    return $args;
}, 10, 2 );
```

### Response Caching

```php
add_filter( 'pre_http_request', function( $response, $args, $url ) {
    if ( 'GET' !== $args['method'] ) {
        return $response;
    }
    
    $cache_key = 'http_' . md5( $url );
    $cached = wp_cache_get( $cache_key, 'http_api' );
    
    return false !== $cached ? $cached : $response;
}, 10, 3 );

add_filter( 'http_response', function( $response, $args, $url ) {
    if ( 'GET' !== $args['method'] ) {
        return $response;
    }
    
    $code = $response['response']['code'];
    if ( $code >= 200 && $code < 300 ) {
        $cache_key = 'http_' . md5( $url );
        wp_cache_set( $cache_key, $response, 'http_api', 300 );
    }
    
    return $response;
}, 10, 3 );
```

### Rate Limiting

```php
add_filter( 'pre_http_request', function( $response, $args, $url ) {
    $host = parse_url( $url, PHP_URL_HOST );
    $rate_key = 'rate_limit_' . $host;
    
    $requests = get_transient( $rate_key ) ?: 0;
    
    if ( $requests >= 100 ) {  // 100 requests per minute
        return new WP_Error( 
            'rate_limited', 
            'Too many requests to ' . $host 
        );
    }
    
    set_transient( $rate_key, $requests + 1, MINUTE_IN_SECONDS );
    
    return $response;
}, 10, 3 );
```
