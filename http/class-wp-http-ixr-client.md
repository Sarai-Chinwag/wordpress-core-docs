# WP_HTTP_IXR_Client

**Source:** `wp-includes/class-wp-http-ixr-client.php`  
**Since:** 3.1.0  
**Extends:** `IXR_Client`

## Purpose

WordPress's XML-RPC client implementation that uses the WordPress HTTP API (`wp_remote_post()`) instead of the parent `IXR_Client`'s raw socket/cURL calls. This ensures XML-RPC requests benefit from WordPress's proxy support, SSL certificate handling, timeout management, and HTTP API filters.

Used internally for pingbacks, trackbacks, and any XML-RPC communication between WordPress sites.

## Class Definition

```php
#[AllowDynamicProperties]
class WP_HTTP_IXR_Client extends IXR_Client
```

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$scheme` | `string` | `public` | URL scheme (`http` or `https`), parsed from constructor URL |
| `$error` | `IXR_Error` | `public` | Error object set when `query()` fails |

Inherited from `IXR_Client`: `$server`, `$port`, `$path`, `$useragent`, `$timeout`, `$headers`, `$debug`, `$message`.

## Constructor

```php
public function __construct( string $server, string|false $path = false, int|false $port = false, int $timeout = 15 )
```

**Two modes:**

1. **URL mode** (`$path === false`): Parses `$server` as a full URL via `parse_url()`. Extracts `scheme`, `host`, `port`, `path`, and `query`. If path is empty, defaults to `'/'`. Query string is appended to path.

2. **Component mode** (`$path` provided): Sets `scheme` to `'http'`, uses `$server` as hostname, `$path` as-is, `$port` as-is.

Sets `$this->useragent` to `'The Incutio XML-RPC PHP Library'` and `$this->timeout` to the provided value (default 15 seconds).

## Methods

### `query( ...$args )`

**@since 3.1.0**  
**@since 5.5.0** — Formalized the existing `...$args` parameter by adding it to the function signature.

**Returns:** `bool` — `true` on success, `false` on error (with `$this->error` set).

**Flow:**

1. **Build XML-RPC request:** Shifts the method name from `$args`, creates an `IXR_Request` object, serializes to XML via `$request->getXml()`.

2. **Construct URL:** `"{$this->scheme}://{$this->server}{$port}{$this->path}"`

3. **Build request args:**
   ```php
   $args = [
       'headers'    => ['Content-Type' => 'text/xml'],
       'user-agent' => $this->useragent,
       'body'       => $xml,
   ];
   ```

4. **Merge custom headers:** Iterates `$this->headers` and adds them to `$args['headers']`. Comment references Trac ticket #8145.

5. **Filter headers:**
   ```php
   $args['headers'] = apply_filters( 'wp_http_ixr_client_headers', $args['headers'] );
   ```
   **@since 4.4.0** — Filters the headers collection to be sent to the XML-RPC server.

6. **Set timeout:** If `$this->timeout !== false`, sets `$args['timeout']`.

7. **Debug output:** If `$this->debug` is truthy, echoes the raw XML request in a `<pre>` tag.

8. **Send via WordPress HTTP API:** `$response = wp_remote_post( $url, $args )`

9. **Error handling** — three failure modes:
   - **WP_Error:** Sets `$this->error = new IXR_Error( -32300, "transport error: {$errno} {$errorstr}" )`
   - **Non-200 status:** Sets `$this->error = new IXR_Error( -32301, "transport error - HTTP status code was not 200 ({$code})" )`
   - **XML parse failure:** Sets `$this->error = new IXR_Error( -32700, 'parse error. not well formed' )`

10. **Parse response:** Creates `IXR_Message` from response body, calls `->parse()`. If message type is `'fault'`, sets error from fault code/string.

11. **Returns `true`** on success — parsed response accessible via `$this->message`.

## Error Codes

| Code | Meaning | When |
|------|---------|------|
| -32300 | Transport error | `wp_remote_post()` returns `WP_Error` |
| -32301 | HTTP status not 200 | Server returned non-200 response |
| -32700 | Parse error | Response XML is malformed |
| Varies | XML-RPC fault | Server returned a fault response |

## Hooks

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `wp_http_ixr_client_headers` | `apply_filters` | 4.4.0 | Filters headers array before sending. Receives `string[] $headers`. |

## Streaming Relevance

**None.** This class is a synchronous XML-RPC client that:
- Sends a complete XML body via `wp_remote_post()`
- Expects a complete XML response
- Parses the full response body as XML via `IXR_Message`

XML-RPC is inherently request-response and has no streaming equivalent. This class exists for WordPress's legacy pingback/trackback/XML-RPC API functionality.

## Usage Context

Used by WordPress core for:
- **Pingbacks:** `wp-includes/comment.php` sends pingback notifications
- **Trackbacks:** Similar outbound notification mechanism  
- **XML-RPC multicall:** When WordPress communicates with other WordPress sites

Not commonly used by plugins — most modern plugin-to-plugin communication uses the REST API instead.
