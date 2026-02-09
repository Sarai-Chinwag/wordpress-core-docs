# REST API

The WordPress REST API provides a standardized interface for external applications to interact with WordPress using JSON over HTTP.

**Since:** WordPress 4.4.0 (infrastructure), 4.7.0 (content endpoints)

## Overview

The REST API enables developers to:

- Access WordPress content (posts, pages, users, etc.) via HTTP
- Create, read, update, and delete content programmatically
- Build decoupled frontends (headless WordPress)
- Integrate WordPress with external services
- Register custom endpoints for plugins and themes

## Quick Start

### Register a Custom Endpoint

```php
add_action( 'rest_api_init', function() {
    register_rest_route( 'my-plugin/v1', '/items', array(
        'methods'             => 'GET',
        'callback'            => 'my_plugin_get_items',
        'permission_callback' => '__return_true',
    ) );
} );

function my_plugin_get_items( WP_REST_Request $request ) {
    return array(
        array( 'id' => 1, 'name' => 'Item One' ),
        array( 'id' => 2, 'name' => 'Item Two' ),
    );
}
```

Access at: `GET /wp-json/my-plugin/v1/items`

## Documentation

- [Registering Routes](./registering-routes.md) — Creating custom endpoints
- [Request Handling](./requests.md) — Working with WP_REST_Request
- [Response Handling](./responses.md) — Returning WP_REST_Response
- [Authentication](./authentication.md) — Securing endpoints
- [Schema](./schema.md) — Defining data structures
- [Controllers](./controllers.md) — Building reusable endpoint classes

## Core Functions

### register_rest_route()

Registers a REST API route.

```php
register_rest_route(
    string $namespace,
    string $route,
    array  $args = array(),
    bool   $override = false
): bool
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$namespace` | string | Unique namespace (e.g., `my-plugin/v1`) |
| `$route` | string | Route pattern (e.g., `/items/(?P<id>\d+)`) |
| `$args` | array | Route configuration |
| `$override` | bool | Replace existing route if true |

**Route Configuration:**

| Key | Type | Required | Description |
|-----|------|----------|-------------|
| `methods` | string/array | Yes | HTTP methods (`GET`, `POST`, etc.) |
| `callback` | callable | Yes | Handler function |
| `permission_callback` | callable | Yes | Authorization check |
| `args` | array | No | Parameter definitions |

**Example:**

```php
add_action( 'rest_api_init', function() {
    register_rest_route( 'my-plugin/v1', '/items/(?P<id>\d+)', array(
        'methods'             => 'GET',
        'callback'            => 'get_item',
        'permission_callback' => '__return_true',
        'args'                => array(
            'id' => array(
                'required'          => true,
                'validate_callback' => fn( $v ) => is_numeric( $v ),
                'sanitize_callback' => 'absint',
            ),
        ),
    ) );
} );
```

---

### register_rest_field()

Adds a custom field to an existing object type.

```php
register_rest_field(
    string|array $object_type,
    string       $attribute,
    array        $args = array()
): void
```

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$object_type` | string/array | Object type(s): `post`, `term`, `comment`, etc. |
| `$attribute` | string | Field name |
| `$args` | array | Field configuration |

**Field Configuration:**

| Key | Type | Description |
|-----|------|-------------|
| `get_callback` | callable | Returns field value |
| `update_callback` | callable | Updates field value |
| `schema` | array | JSON Schema definition |

**Example:**

```php
add_action( 'rest_api_init', function() {
    register_rest_field( 'post', 'reading_time', array(
        'get_callback' => function( $post ) {
            $content = get_post_field( 'post_content', $post['id'] );
            $words = str_word_count( strip_tags( $content ) );
            return ceil( $words / 200 );
        },
        'schema' => array(
            'type'        => 'integer',
            'description' => 'Estimated reading time in minutes',
        ),
    ) );
} );
```

---

## Built-in Endpoints

### Content

| Endpoint | Methods | Description |
|----------|---------|-------------|
| `/wp/v2/posts` | GET, POST | Blog posts |
| `/wp/v2/posts/<id>` | GET, PUT, PATCH, DELETE | Single post |
| `/wp/v2/pages` | GET, POST | Pages |
| `/wp/v2/media` | GET, POST | Media attachments |
| `/wp/v2/blocks` | GET, POST | Reusable blocks |

### Taxonomy

| Endpoint | Methods | Description |
|----------|---------|-------------|
| `/wp/v2/categories` | GET, POST | Categories |
| `/wp/v2/tags` | GET, POST | Tags |
| `/wp/v2/taxonomies` | GET | Available taxonomies |

### Users

| Endpoint | Methods | Description |
|----------|---------|-------------|
| `/wp/v2/users` | GET, POST | Users |
| `/wp/v2/users/me` | GET | Current user |

### Site

| Endpoint | Methods | Description |
|----------|---------|-------------|
| `/wp/v2/settings` | GET, PUT | Site settings |
| `/wp/v2/types` | GET | Post types |

---

## Permission Callback

**Required since WordPress 5.5.** Every route must define authorization logic.

```php
register_rest_route( 'my-plugin/v1', '/private', array(
    'methods'             => 'GET',
    'callback'            => 'get_private_data',
    'permission_callback' => function() {
        return current_user_can( 'manage_options' );
    },
) );
```

For public endpoints:

```php
'permission_callback' => '__return_true',
```

---

## Request Parameters

### URL Parameters

```php
// Route: /items/(?P<id>\d+)
register_rest_route( 'my-plugin/v1', '/items/(?P<id>\d+)', array(
    'callback' => function( WP_REST_Request $request ) {
        $id = $request->get_param( 'id' );
        // or
        $id = $request['id'];
    },
) );
```

### Query Parameters

```php
// GET /items?page=2&per_page=10
$page = $request->get_param( 'page' );
$per_page = $request->get_param( 'per_page' );
```

### Body Parameters

```php
// POST with JSON body
$data = $request->get_json_params();

// Or get all params
$params = $request->get_params();
```

---

## Response Formats

### Simple Array (auto-converted)

```php
return array( 'status' => 'ok' );
```

### WP_REST_Response (full control)

```php
$response = new WP_REST_Response( $data );
$response->set_status( 201 );
$response->header( 'X-Custom-Header', 'value' );
return $response;
```

### WP_Error (for failures)

```php
return new WP_Error(
    'not_found',
    'Item not found',
    array( 'status' => 404 )
);
```

---

## Best Practices

1. **Always define permission_callback** — Required since WP 5.5
2. **Use namespaced routes** — `my-plugin/v1`, not just `/items`
3. **Version your API** — Include version in namespace
4. **Validate and sanitize** — Define args with validation callbacks
5. **Return proper status codes** — 200, 201, 400, 401, 403, 404, etc.
6. **Document with schema** — Helps with discovery and validation
