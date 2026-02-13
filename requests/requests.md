# Requests Library Overview

The Requests library is an HTTP client for PHP, bundled with WordPress. It provides a clean API for making HTTP requests with support for multiple transports, cookies, authentication, proxies, and parallel requests.

**Source:** `wp-includes/Requests/`  
**Namespace:** `WpOrg\Requests`  
**Version:** 2.0.11

---

## Architecture

```
┌─────────────────────────────────────────────────────┐
│                   Requests (static)                  │
│  Main entry point — get(), post(), request(), etc.  │
├──────────────┬──────────────────────────────────────┤
│              │                                       │
│   Session    │   Wraps Requests with shared          │
│              │   defaults, base URL, cookie jar      │
├──────────────┴──────────────────────────────────────┤
│                Transport Layer                        │
│  ┌──────────────────┐  ┌─────────────────────────┐  │
│  │  Transport\Curl  │  │  Transport\Fsockopen    │  │
│  │  (preferred)     │  │  (fallback)             │  │
│  └──────────────────┘  └─────────────────────────┘  │
├─────────────────────────────────────────────────────┤
│                Support Classes                        │
│  Response / Response\Headers / Cookie / Cookie\Jar   │
│  Hooks / HookManager / Capability                    │
└─────────────────────────────────────────────────────┘
```

### Request Flow

1. `Requests::request()` receives URL, headers, data, type, options
2. Options merged with defaults (`OPTION_DEFAULTS`)
3. `set_defaults()` normalizes auth, proxy, cookies, IDN encoding
4. Hook: `requests.before_request`
5. Transport selected (cURL preferred, fsockopen fallback) based on capabilities
6. Transport executes request, returns raw HTTP response
7. Hook: `requests.before_parse`
8. `parse_response()` splits headers/body, handles chunked encoding, decompression, redirects
9. Hook: `requests.after_request`
10. Returns `Response` object

---

## Component Reference

| Component | Documentation | Source | Description |
|-----------|---------------|--------|-------------|
| `Requests` | [class-requests.md](class-requests.md) | `src/Requests.php` | Static entry point — HTTP methods, transport selection, response parsing |
| `Response` | [class-requests-response.md](class-requests-response.md) | `src/Response.php` | Response data object with body, headers, status, cookies |
| `Response\Headers` | [class-requests-response-headers.md](class-requests-response-headers.md) | `src/Response/Headers.php` | Case-insensitive header dictionary with multi-value support |
| `Session` | [class-requests-session.md](class-requests-session.md) | `src/Session.php` | Persistent session with shared defaults and cookie jar |
| `HookManager` / `Hooks` | [class-requests-hooks.md](class-requests-hooks.md) | `src/HookManager.php`, `src/Hooks.php` | Event dispatcher interface and implementation |
| `Cookie` | [class-requests-cookie.md](class-requests-cookie.md) | `src/Cookie.php` | Cookie parsing, validation, and formatting (RFC 6265) |
| `Cookie\Jar` | [class-requests-cookie-jar.md](class-requests-cookie-jar.md) | `src/Cookie/Jar.php` | Cookie collection with automatic request/response handling |
| `Transport\Curl` | [class-requests-transport-curl.md](class-requests-transport-curl.md) | `src/Transport/Curl.php` | cURL-based HTTP transport with multi-request support |
| `Transport\Fsockopen` | [class-requests-transport-fsockopen.md](class-requests-transport-fsockopen.md) | `src/Transport/Fsockopen.php` | Socket-based HTTP transport (fallback) |
| `Transport` | [class-requests-transport-curl.md](class-requests-transport-curl.md) | `src/Transport.php` | Transport interface |
| `Capability` | — | `src/Capability.php` | Interface defining capability constants (`SSL`) |

---

## Legacy Compatibility

The file `library/Requests.php` is a legacy/compat wrapper. It simply includes WordPress's `class-requests.php` (`wp-includes/class-requests.php`), which existed before the library was namespaced. This bridges the old PSR-0 `Requests` class name to the new `WpOrg\Requests\Requests` namespace.

```php
// library/Requests.php — deprecated since WordPress 6.2.0
include_once ABSPATH . WPINC . '/class-requests.php';
```

---

## Hook Points

The library dispatches hooks at key points during request processing:

| Hook | Parameters | When |
|------|-----------|------|
| `requests.before_request` | `&$url, &$headers, &$data, &$type, &$options` | Before transport executes |
| `requests.before_parse` | `&$response, $url, $headers, $data, $type, $options` | After transport, before parsing |
| `requests.before_redirect_check` | `&$return, $req_headers, $req_data, $options` | Before redirect evaluation |
| `requests.before_redirect` | `&$location, &$headers, &$data, &$options, $return` | Before following a redirect |
| `requests.after_request` | `&$return, $req_headers, $req_data, $options` | After parsing complete |
| `request.progress` | `$data, $size, $max_bytes` | During body streaming |
| `transport.internal.parse_response` | `&$response, $request` | Internal: multi-request parsing |
| `transport.internal.parse_error` | `&$response, $request` | Internal: multi-request error |
| `multiple.request.complete` | `&$response, $id` | Each request in a batch completes |
| `curl.before_request` | `&$handle` | cURL: before handle setup |
| `curl.before_send` | `&$handle` | cURL: before curl_exec |
| `curl.after_send` | (none) | cURL: after curl_exec |
| `curl.after_request` | `&$headers, &$info` | cURL: after processing |
| `curl.before_multi_add` | `&$subhandle` | cURL: before adding to multi handle |
| `curl.before_multi_exec` | `&$multihandle` | cURL: before multi exec loop |
| `curl.after_multi_exec` | `&$multihandle` | cURL: after multi exec loop |
| `fsockopen.before_request` | (none) | fsockopen: before request |
| `fsockopen.remote_socket` | `&$remote_socket` | fsockopen: socket address |
| `fsockopen.remote_host_path` | `&$path, $url` | fsockopen: request path |
| `fsockopen.after_headers` | `&$out` | fsockopen: after header construction |
| `fsockopen.before_send` | `&$out` | fsockopen: before socket write |
| `fsockopen.after_send` | `$out` | fsockopen: after socket write |
| `fsockopen.after_request` | `&$headers, &$info` | fsockopen: after request complete |

---

## Default Options

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `timeout` | float | `10` | Response timeout (seconds) |
| `connect_timeout` | float | `10` | Connection timeout (seconds) |
| `useragent` | string | `php-requests/2.0.11` | User-Agent header |
| `protocol_version` | float | `1.1` | HTTP protocol version |
| `redirected` | int | `0` | Current redirect count (internal) |
| `redirects` | int | `10` | Maximum redirects to follow |
| `follow_redirects` | bool | `true` | Follow 3xx redirects |
| `blocking` | bool | `true` | Block for response |
| `type` | string | `GET` | HTTP method |
| `filename` | string\|false | `false` | File to stream body to |
| `auth` | Auth\|array\|false | `false` | Authentication handler |
| `proxy` | Proxy\|array\|string\|false | `false` | Proxy configuration |
| `cookies` | Jar\|array\|false | `false` | Cookie jar |
| `max_bytes` | int\|false | `false` | Response body size limit |
| `idn` | bool | `true` | Enable IDN parsing |
| `hooks` | HookManager\|null | `null` | Hook dispatcher (auto-created) |
| `transport` | Transport\|string\|null | `null` | Custom transport |
| `verify` | string\|bool\|null | `certificates/cacert.pem` | SSL certificate verification |
| `verifyname` | bool | `true` | Verify SSL common name |
