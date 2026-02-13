# WP_HTTP_Requests_Hooks

**Source:** `wp-includes/class-wp-http-requests-hooks.php`  
**Since:** 4.7.0  
**Extends:** `WpOrg\Requests\Hooks`

## Purpose

Bridge between the Requests library's internal hook system and WordPress's action/filter system. Every outbound HTTP request made through `WP_Http::request()` gets an instance of this class as `$options['hooks']` (set at `class-wp-http.php` ~line 345: `'hooks' => new WP_HTTP_Requests_Hooks( $url, $parsed_args )`).

When Requests dispatches internal hooks (e.g., `request.progress`, `curl.before_send`), they flow through this class's `dispatch()` method, which:
1. Calls the parent `WpOrg\Requests\Hooks::dispatch()` (fires any directly-registered callbacks)
2. Maps specific hooks to WordPress back-compat actions
3. Fires a generic WordPress action `"requests-{$hook}"` for every hook

## Class Definition

```php
#[AllowDynamicProperties]
class WP_HTTP_Requests_Hooks extends WpOrg\Requests\Hooks
```

## Properties

| Property | Type | Visibility | Description |
|----------|------|------------|-------------|
| `$url` | `string` | `protected` | The URL being requested |
| `$request` | `array` | `protected` | Request data in `WP_Http` format (the `$parsed_args` array from `WP_Http::request()`) |

## Constructor

```php
public function __construct( string $url, array $request )
```

Stores the URL and request args for later use in `dispatch()`. Does **not** call `parent::__construct()` — the parent class (`WpOrg\Requests\Hooks`) has no constructor logic (it initializes `$hooks = []` as a property default).

## Methods

### `dispatch( $hook, $parameters = array() )`

**Returns:** `bool` — True if hooks were run, false if nothing was hooked.

**Flow:**

1. **`parent::dispatch( $hook, $parameters )`** — Fires any callbacks registered directly on this `Hooks` instance via `$hooks->register()`. This is how `request.progress` callbacks work — they're registered directly on the hooks object, NOT through WordPress's `add_action()`.

2. **Back-compat switch** — Currently handles one case:
   - `'curl.before_send'`: Fires the WordPress action `'http_api_curl'` with args `[ &$curl_handle, $this->request, $this->url ]`. This is documented in `class-wp-http-curl.php` (the deprecated transport).

3. **Generic WordPress action** — Fires `do_action_ref_array( "requests-{$hook}", $parameters, $this->request, $this->url )` for every hook. The action name uses hyphens (not underscores), with a phpcs ignore comment for `WordPress.NamingConventions.ValidHookName.UseUnderscores`.

**@since 4.7.0**

## Available Hooks Dispatched Through This Class

These are the Requests library hooks that pass through `dispatch()`:

| Hook Name | WordPress Action | When It Fires | Parameters |
|-----------|-----------------|---------------|------------|
| `requests.before_request` | `requests-requests.before_request` | Before transport sends request | `[&$url, &$headers, &$data, &$type, &$options]` |
| `request.progress` | `requests-request.progress` | Per chunk during body reception | `[$data, $bytes_so_far, $byte_limit]` |
| `curl.before_send` | `requests-curl.before_send` + `http_api_curl` (back-compat) | After cURL handle is configured, before `curl_exec()` | `[&$curl_handle]` |
| `curl.before_multi_add` | `requests-curl.before_multi_add` | Before adding handle to multi stack | `[&$curl_handle]` |
| `curl.before_multi_exec` | `requests-curl.before_multi_exec` | Before `curl_multi_exec()` | `[&$curl_multi_handle]` |
| `curl.after_multi_exec` | `requests-curl.after_multi_exec` | After `curl_multi_exec()` | `[&$curl_multi_handle]` |
| `fsockopen.before_send` | `requests-fsockopen.before_send` | Before writing to socket | `[&$handle]` |
| `fsockopen.after_send` | `requests-fsockopen.after_send` | After writing to socket | `[&$fake_headers]` |
| `requests.before_parse` | `requests-requests.before_parse` | After transport completes, before response parsing | `[&$response, $url, $headers, $data, $type, $options]` |
| `requests.after_request` | `requests-requests.after_request` | After full response parsing | `[&$return, $headers, $data, $type, $options]` |
| `requests.before_redirect_check` | `requests-requests.before_redirect_check` | Before redirect evaluation | `[&$return, $headers, $data, $type, $options]` |

## Streaming Significance

**`request.progress` is the critical hook for streaming.** It fires per-chunk in both transports:

- **cURL:** Called from `Curl::stream_body()` which is set as `CURLOPT_WRITEFUNCTION`. Data is already decompressed by cURL (via `CURLOPT_ENCODING`).
- **Fsockopen:** Called from the `fread()` loop. Data is raw (possibly compressed).

### Direct Registration vs WordPress Actions

There are **two ways** to hook into `request.progress`:

1. **Direct registration** (recommended for streaming):
   ```php
   // Register directly on the hooks object
   $hooks = new WP_HTTP_Requests_Hooks( $url, $args );
   $hooks->register( 'request.progress', $callback );
   // Pass as $options['hooks']
   ```

2. **WordPress action** (less useful):
   ```php
   add_action( 'requests-request.progress', function( $data, $bytes, $limit ) {
       // This fires for ALL requests — no URL filtering possible
       // Parameters are NOT passed by reference in the WordPress action
   }, 10, 3 );
   ```

**Key limitation:** The WordPress action `requests-request.progress` fires for every HTTP request, with no way to filter by URL at the action level. For targeted streaming, direct registration on the hooks object (via `pre_http_request` filter to intercept and rebuild the request) is the only practical approach.

### Why This Class Matters for Streaming Architecture

This class is the **only bridge** between WordPress's hook system and the Requests library's transport-level hooks. Any streaming solution that wants to work within WordPress's HTTP API (rather than bypassing it with raw cURL) must flow through this class.

The proposed `stream_callback` / `on_data` option (see `streaming-analysis.md`) would be registered directly on this hooks object at the `WP_Http::request()` level, or passed through `$options` to be picked up by the transport — bypassing the WordPress action system entirely for performance.
