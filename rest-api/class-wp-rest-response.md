# WP_REST_Response

Core class implementing a REST response object. Extends `WP_HTTP_Response` with link handling and route matching.

**Source:** `wp-includes/rest-api/class-wp-rest-response.php`  
**Since:** 4.4.0

**Extends:** `WP_HTTP_Response`

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$links` | array | protected | Links related to response |
| `$matched_route` | string | protected | Route that created this response |
| `$matched_handler` | array\|null | protected | Handler that created this response |

## Inherited Properties

From `WP_HTTP_Response`:

| Property | Type | Description |
|----------|------|-------------|
| `$data` | mixed | Response data |
| `$headers` | array | Response headers |
| `$status` | int | HTTP status code |

---

## Methods

### add_link()

Adds a link to the response.

```php
public function add_link( string $rel, string $href, array $attributes = array() ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rel` | string | Link relation (IANA type or absolute URL) |
| `$href` | string | Target URI |
| `$attributes` | array | Additional link attributes |

**Common Relations:**
- `self` — Link to this resource
- `collection` — Link to parent collection
- `author` — Link to author resource
- `up` — Link to parent resource

**Attributes:**
- `embeddable` — Whether link can be embedded (boolean)
- `title` — Human-readable link title
- `templated` — Whether href is a URI template

**Example:**

```php
$response->add_link( 'self', rest_url( '/wp/v2/posts/123' ) );
$response->add_link( 'author', rest_url( '/wp/v2/users/1' ), array(
    'embeddable' => true,
) );
```

---

### remove_link()

Removes a link from the response.

```php
public function remove_link( string $rel, string|null $href = null ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rel` | string | Link relation |
| `$href` | string\|null | Only remove links with this href |

**Example:**

```php
// Remove all author links
$response->remove_link( 'author' );

// Remove specific author link
$response->remove_link( 'author', rest_url( '/wp/v2/users/1' ) );
```

---

### add_links()

Adds multiple links at once.

```php
public function add_links( array $links ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$links` | array | Map of relation to link data |

**Link Format:**
- Single: `array( 'href' => '...', 'embeddable' => true )`
- Multiple: `array( array( 'href' => '...' ), array( 'href' => '...' ) )`

**Example:**

```php
$response->add_links( array(
    'self' => array(
        'href' => rest_url( '/wp/v2/posts/123' ),
    ),
    'replies' => array(
        array( 'href' => rest_url( '/wp/v2/comments?post=123' ), 'embeddable' => true ),
    ),
) );
```

---

### get_links()

Retrieves all links.

```php
public function get_links(): array
```

**Returns:** Map of relation to link arrays.

**Structure:**

```php
array(
    'self' => array(
        array( 'href' => '...', 'attributes' => array() ),
    ),
    'author' => array(
        array( 'href' => '...', 'attributes' => array( 'embeddable' => true ) ),
    ),
)
```

---

### link_header()

Sets a Link HTTP header.

```php
public function link_header( string $rel, string $link, array $other = array() ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$rel` | string | Link relation |
| `$link` | string | Target IRI |
| `$other` | array | Additional parameters |

Adds header like: `Link: <url>; rel="relation"; title="Title"`

**Example:**

```php
$response->link_header( 'alternate', 'https://example.com/feed/', array(
    'type' => 'application/rss+xml',
) );
```

---

### get_matched_route()

Retrieves the matched route pattern.

```php
public function get_matched_route(): string
```

**Returns:** Route regex that handled the request.

---

### set_matched_route()

Sets the matched route.

```php
public function set_matched_route( string $route ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$route` | string | Route pattern |

---

### get_matched_handler()

Retrieves the matched handler.

```php
public function get_matched_handler(): null|array
```

**Returns:** Handler array from route registration, or `null`.

---

### set_matched_handler()

Sets the matched handler.

```php
public function set_matched_handler( array $handler ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$handler` | array | Handler configuration |

---

### is_error()

Checks if response is an error (status >= 400).

```php
public function is_error(): bool
```

**Returns:** `true` if error response.

---

### as_error()

Converts response to `WP_Error` object.

```php
public function as_error(): WP_Error|null
```

**Returns:** `WP_Error` if error response, `null` otherwise.

**Example:**

```php
$response = rest_do_request( $request );
if ( $response->is_error() ) {
    $error = $response->as_error();
    // Handle WP_Error
}
```

---

### get_curies()

Retrieves CURIEs (Compact URIs) for relations.

```php
public function get_curies(): array
```

**Returns:** Array of CURIE definitions.

**Default CURIE:**

```php
array(
    'name'      => 'wp',
    'href'      => 'https://api.w.org/{rel}',
    'templated' => true,
)
```

CURIEs allow `wp:term` instead of `https://api.w.org/term`.

Additional CURIEs can be added via `rest_response_link_curies` filter.

---

## Inherited Methods

From `WP_HTTP_Response`:

### get_data()

Retrieves response data.

```php
public function get_data(): mixed
```

**Returns:** Response body data.

---

### set_data()

Sets response data.

```php
public function set_data( mixed $data ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$data` | mixed | Response data |

---

### get_status()

Retrieves HTTP status code.

```php
public function get_status(): int
```

**Returns:** Status code (e.g., `200`, `404`).

---

### set_status()

Sets HTTP status code.

```php
public function set_status( int $code ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$code` | int | HTTP status code |

---

### get_headers()

Retrieves response headers.

```php
public function get_headers(): array
```

**Returns:** Map of header name to value.

---

### header()

Sets a response header.

```php
public function header( string $key, string $value, bool $replace = true ): void
```

| Parameter | Type | Description |
|-----------|------|-------------|
| `$key` | string | Header name |
| `$value` | string | Header value |
| `$replace` | bool | Replace existing header |

---

## Usage Examples

### Creating a Response

```php
function my_endpoint_callback( WP_REST_Request $request ) {
    $data = array(
        'id'    => 123,
        'title' => 'Hello World',
    );
    
    $response = new WP_REST_Response( $data, 200 );
    
    // Add links
    $response->add_link( 'self', rest_url( '/my-plugin/v1/items/123' ) );
    $response->add_link( 'collection', rest_url( '/my-plugin/v1/items' ) );
    
    // Add headers
    $response->header( 'X-Custom-Header', 'value' );
    
    return $response;
}
```

### Returning from Callback

```php
// Simple array return (auto-wrapped)
return array( 'success' => true );

// Explicit response with status
return new WP_REST_Response( array( 'success' => true ), 201 );

// Error response
return new WP_Error( 'not_found', 'Item not found', array( 'status' => 404 ) );
```

### Collection Response with Pagination

```php
function get_items( WP_REST_Request $request ) {
    $items = get_items_from_db( $request['per_page'], $request['page'] );
    $total = get_total_items();
    
    $response = new WP_REST_Response( $items );
    
    // Pagination headers
    $response->header( 'X-WP-Total', $total );
    $response->header( 'X-WP-TotalPages', ceil( $total / $request['per_page'] ) );
    
    // Pagination links
    $base = rest_url( '/my-plugin/v1/items' );
    if ( $request['page'] > 1 ) {
        $response->link_header( 'prev', add_query_arg( 'page', $request['page'] - 1, $base ) );
    }
    if ( $request['page'] < ceil( $total / $request['per_page'] ) ) {
        $response->link_header( 'next', add_query_arg( 'page', $request['page'] + 1, $base ) );
    }
    
    return $response;
}
```
