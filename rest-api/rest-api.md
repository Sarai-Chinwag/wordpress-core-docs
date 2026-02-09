# REST API

WordPress REST API for building and consuming HTTP-based JSON endpoints.

**Since:** 4.4.0  
**Source:** `wp-includes/rest-api.php`, `wp-includes/rest-api/`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core registration, URL, and utility functions |
| [class-wp-rest-server.md](./class-wp-rest-server.md) | REST server singleton handling dispatch |
| [class-wp-rest-request.md](./class-wp-rest-request.md) | Request object with parameters, headers, body |
| [class-wp-rest-response.md](./class-wp-rest-response.md) | Response object with links and data |
| [hooks.md](./hooks.md) | Actions and filters |

## Request Flow

```
HTTP Request
    └── rest_api_loaded()
            └── WP_REST_Server::serve_request()
                    ├── check_authentication()
                    ├── dispatch()
                    │       ├── rest_pre_dispatch filter
                    │       ├── match_request_to_handler()
                    │       ├── has_valid_params()
                    │       ├── sanitize_params()
                    │       └── respond_to_request()
                    │               ├── rest_request_before_callbacks
                    │               ├── permission_callback
                    │               ├── callback
                    │               └── rest_request_after_callbacks
                    ├── rest_post_dispatch filter
                    └── response_to_data()
```

## Route Registration

```php
add_action( 'rest_api_init', function() {
    register_rest_route( 'my-plugin/v1', '/items', array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => 'my_plugin_get_items',
        'permission_callback' => '__return_true',
        'args'                => array(
            'per_page' => array(
                'type'    => 'integer',
                'default' => 10,
            ),
        ),
    ) );
} );
```

## Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `REST_API_VERSION` | `'2.0'` | API version number |
| `WP_REST_Server::READABLE` | `'GET'` | GET method |
| `WP_REST_Server::CREATABLE` | `'POST'` | POST method |
| `WP_REST_Server::EDITABLE` | `'POST, PUT, PATCH'` | Writable methods |
| `WP_REST_Server::DELETABLE` | `'DELETE'` | DELETE method |
| `WP_REST_Server::ALLMETHODS` | `'GET, POST, PUT, PATCH, DELETE'` | All methods |

## URL Structure

Default prefix: `/wp-json/`

```
/wp-json/                          → Site index
/wp-json/wp/v2/                    → Core namespace index
/wp-json/wp/v2/posts               → Posts collection
/wp-json/wp/v2/posts/123           → Single post
/wp-json/my-plugin/v1/items        → Custom route
```

## Authentication

Authentication flows through the `rest_authentication_errors` filter:

```php
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( ! empty( $result ) ) {
        return $result; // Another auth already handled
    }
    
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'Not authenticated', array( 'status' => 401 ) );
    }
    
    return true;
} );
```

Built-in methods:
- Cookie + nonce (via `X-WP-Nonce` header)
- Application passwords (HTTP Basic auth)

## Response Formats

Standard response with `_links`:

```json
{
    "id": 123,
    "title": { "rendered": "Hello World" },
    "_links": {
        "self": [{ "href": "/wp-json/wp/v2/posts/123" }],
        "author": [{ "href": "/wp-json/wp/v2/users/1", "embeddable": true }]
    }
}
```

With `?_embed`:

```json
{
    "id": 123,
    "_embedded": {
        "author": [{ "id": 1, "name": "admin" }]
    }
}
```

## Batch Requests

POST to `/wp-json/batch/v1` with `requests` array:

```json
{
    "requests": [
        { "path": "/wp/v2/posts/1", "method": "PUT", "body": { "title": "New" } },
        { "path": "/wp/v2/posts/2", "method": "DELETE" }
    ]
}
```
