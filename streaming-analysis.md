# WordPress Core HTTP Streaming Analysis

## Full Call Chain

```
wp_remote_get($url, $args)                          # wp-includes/http.php
  └─► _wp_http_get_object()->get($url, $args)       # WP_Http singleton
        └─► WP_Http::request($url, $args)            # wp-includes/class-wp-http.php
              │
              ├─ apply_filters('pre_http_request')   # Short-circuit opportunity
              ├─ Build $options array with hooks, cookies, SSL, proxy
              │
              └─► Requests::request($url, $headers, $data, $type, $options)
                    │                                  # wp-includes/Requests/src/Requests.php
                    ├─ dispatch('requests.before_request')
                    ├─ get_transport() → Curl or Fsockopen
                    │
                    ├─► Transport::request($url, $headers, $data, $options)
                    │     │
                    │     │  [CURL TRANSPORT]           # Requests/src/Transport/Curl.php
                    │     ├─ setup_handle() → sets CURLOPT_WRITEFUNCTION = stream_body()
                    │     ├─ curl_exec()
                    │     │    └─ stream_body() called per chunk:
                    │     │         ├─ dispatch('request.progress', [$data, $bytes, $limit])
                    │     │         ├─ fwrite() to file  OR  $this->response_data .= $data
                    │     │         └─ return strlen($data)
                    │     ├─ process_response() → returns $this->headers (headers + body concatenated)
                    │     │
                    │     │  [FSOCKOPEN TRANSPORT]      # Requests/src/Transport/Fsockopen.php
                    │     ├─ fwrite($socket, $request)
                    │     ├─ while (!feof($socket)):
                    │     │    ├─ fread($socket, 1160)
                    │     │    ├─ dispatch('request.progress', [$block, $size, $max_bytes])
                    │     │    └─ $body .= $block  OR  fwrite($download, $block)
                    │     └─ return $headers . "\r\n\r\n" . $body
                    │
                    ├─ dispatch('requests.before_parse', [&$response, ...])
                    │
                    └─► Requests::parse_response($headers_string, ...)
                          │                            # Requests/src/Requests.php ~L390
                          ├─ new Response()
                          ├─ Split raw string at \r\n\r\n → headers vs body
                          ├─ decode_chunked($body)     # if transfer-encoding: chunked
                          ├─ decompress($body)         # if content-encoding: gzip/deflate
                          ├─ Handle redirects (recursive self::request())
                          ├─ dispatch('requests.after_request', [&$return, ...])
                          └─ return Response object
              │
              ├─► new WP_HTTP_Requests_Response($requests_response, $filename)
              │     └─ to_array() → ['headers'=>..., 'body'=>..., 'response'=>..., 'cookies'=>..., 'filename'=>...]
              │
              ├─ apply_filters('http_response', $response, $parsed_args, $url)
              └─ return $response array
```

## Layer-by-Layer Analysis

### Layer 1: `wp-includes/http.php` — Public API Functions

**What flows in/out:** URL + args array → response array with `headers`, `body`, `response`, `cookies`, `filename`.

**Buffering:** None at this layer — pure delegation.

**Streaming hooks:** None. These are thin wrappers around `WP_Http::request()`.

**Streaming impact:** This layer is fine as-is. A streaming API would likely be a new function (e.g., `wp_remote_get_stream()`) or a new arg like `'on_chunk' => callable`.

---

### Layer 2: `wp-includes/class-wp-http.php` — `WP_Http::request()` (Lines ~130-330)

**What flows in:** URL, args array with defaults (method, timeout, stream, filename, etc.)

**What flows out:** Response array: `['headers' => ..., 'body' => string, 'response' => [...], 'cookies' => [...]]`

**Buffering bottlenecks:**

1. **Line ~295:** `$requests_response = Requests::request(...)` — This is synchronous and blocking. The entire response must complete before control returns.

2. **Line ~298-299:** `$http_response = new WP_HTTP_Requests_Response($requests_response)` then `$response = $http_response->to_array()` — The `to_array()` call reads the complete `$response->body` into the array's `'body'` key.

3. **Return value is an array with `'body' => string`** — Fundamentally incompatible with streaming. The body is a completed string.

**Existing hooks that could help:**

- `'pre_http_request'` filter (line ~245): Can short-circuit the entire request. Not useful for streaming.
- `'http_request_args'` filter (line ~231): Can modify args before the request. Could inject a callback.
- `'http_response'` filter (line ~327): Fires after the complete response. Too late for streaming.
- `'http_api_debug'` action (line ~313): Fires with complete response. Too late.

**Key observation:** `WP_Http::request()` already supports `'stream' => true` with `'filename'` (line ~260-270), which sets `$options['filename']` passed down to Requests. This streams to a **file** but provides no mechanism for processing chunks in memory.

**What would need to change:**
- Accept a new arg like `'on_data'` or `'stream_callback'`
- Pass it through `$options` to the transport layer
- The return value needs rethinking — perhaps return a generator or an object with `->read()` method instead of a flat array

---

### Layer 3: `Requests/src/Requests.php` — `Requests::request()` (Lines ~280-320)

**What flows in:** URL, headers, data, type, options array.

**What flows out:** `Response` object (body as string property).

**Buffering bottlenecks:**

1. **Line ~310:** `$response = $transport->request(...)` — Returns raw HTTP string (headers + body concatenated).

2. **Line ~314:** `parse_response($response, ...)` — Splits the raw string, creates `Response` object. At line ~405: `$return->body = $body` — the entire body is stored as a string on the Response object.

3. **Decompression (line ~430):** `$return->body = self::decompress($return->body)` — operates on the complete body string. This is a hard blocker for true streaming of compressed responses.

4. **Chunked decoding (line ~426):** `$return->body = self::decode_chunked($return->body)` — also operates on complete body.

**Hooks:**

- `'requests.before_request'` — fires before transport, args passed by reference. Could inject streaming config.
- `'requests.before_parse'` — fires with the raw response string, before parsing. The raw response is passed by reference (`[&$response, ...]`). This is **interesting** — if the transport populated body chunks via callback instead, this hook could be bypassed.
- `'requests.after_request'` — fires after full parse. Too late.
- `'requests.before_redirect_check'` — after parse, before redirect logic.

**What would need to change:**
- The transport would need to NOT concatenate the body into a string
- `parse_response()` would need a streaming-aware path that skips body accumulation
- Decompression would need a streaming decompressor (e.g., `inflate_init()`/`inflate_add()` in PHP 7+)
- Chunked decoding would need incremental implementation

---

### Layer 4: `Requests/src/Transport/Curl.php` — The Most Important Layer

**This is where streaming already partially exists.**

#### `stream_body()` method (Lines ~370-400)

```php
public function stream_body($handle, $data) {
    $this->hooks->dispatch('request.progress', [$data, $this->response_bytes, $this->response_byte_limit]);
    $data_length = strlen($data);
    // ... byte limit checks ...
    if ($this->stream_handle) {
        fwrite($this->stream_handle, $data);
    } else {
        $this->response_data .= $data;     // ← BUFFERING BOTTLENECK
    }
    $this->response_bytes += strlen($data);
    return $data_length;
}
```

**This is the key insight:** cURL already calls `stream_body()` chunk-by-chunk via `CURLOPT_WRITEFUNCTION` (set at line ~340). Each chunk fires `'request.progress'` with the raw chunk data.

**The `request.progress` hook** receives:
1. `$data` — the raw chunk bytes
2. `$this->response_bytes` — bytes received so far
3. `$this->response_byte_limit` — max bytes limit

**This hook is the most viable insertion point for streaming without core changes.** A consumer could:

```php
$options['hooks']->register('request.progress', function($data, $bytes_so_far, $limit) {
    // Process each chunk of SSE data as it arrives
    parse_sse_chunk($data);
});
```

**BUT there are problems:**
1. The hook receives raw data that may be compressed (cURL handles decompression via `CURLOPT_ENCODING`, but this is before the Requests library's decompression)
2. The data is still accumulated in `$this->response_data .= $data` regardless of the hook
3. After `curl_exec()` completes, `process_response()` (line ~200) concatenates headers + body: `$this->headers .= $response`
4. The concatenated string is returned up the chain where it's re-parsed

**File streaming path (`$options['filename']`):** When a filename is set (line ~163), `stream_handle` is opened and chunks are written to the file instead of accumulated in memory. This proves the architecture CAN support per-chunk processing — it just only supports writing to files.

#### `setup_handle()` method (Lines ~230-340)

Sets `CURLOPT_WRITEFUNCTION` to `[$this, 'stream_body']` only when `$options['blocking'] === true` (line ~338-340). Also sets `CURLOPT_BUFFERSIZE` to `Requests::BUFFER_SIZE` (1160 bytes).

**Note:** `CURLOPT_ENCODING` is set to `''` in the constructor (line ~100), which tells cURL to handle decompression automatically. This means `stream_body()` receives **decompressed** data when cURL handles gzip. This is actually beneficial for streaming.

---

### Layer 5: `Requests/src/Transport/Fsockopen.php`

**The read loop (lines ~215-260):**

```php
while (!feof($socket)) {
    $block = fread($socket, Requests::BUFFER_SIZE);
    if ($doingbody) {
        $options['hooks']->dispatch('request.progress', [$block, $size, $this->max_bytes]);
        // ... byte limit checks ...
        if ($download) {
            fwrite($download, $block);
        } else {
            $body .= $block;    // ← BUFFERING BOTTLENECK
        }
    }
}
```

**Same pattern as cURL:** `request.progress` hook fires per chunk, but data is still accumulated into `$body` string. Same file-streaming path exists via `$options['filename']`.

**Critical difference from cURL:** fsockopen does NOT handle decompression. Raw compressed data arrives in chunks. The decompression happens later in `Requests::parse_response()` on the complete body. This makes fsockopen harder to stream through.

---

### Layer 6: `Requests/src/Response.php`

Simple data container with `public $body = ''` (string). No streaming awareness. The `decode_body()` method (JSON parsing) also expects a complete string.

---

### Layer 7: `Requests/src/Hooks.php`

Standard event dispatcher. `dispatch()` calls registered callbacks synchronously with `$callback(...$parameters)`. Parameters can be passed by reference (the caller uses `[&$var]` syntax).

**Important:** Hooks are dispatched synchronously, so a streaming callback registered on `request.progress` would execute during the transport's data reception, which is exactly what we want.

---

### Layer 8: `wp-includes/class-wp-http-requests-response.php`

`WP_HTTP_Requests_Response::to_array()` (lines ~165-175):

```php
return array(
    'headers'  => $this->get_headers(),
    'body'     => $this->get_data(),    // ← $this->response->body (complete string)
    'response' => array(
        'code'    => $this->get_status(),
        'message' => get_status_header_desc($this->get_status()),
    ),
    'cookies'  => $this->get_cookies(),
    'filename' => $this->filename,
);
```

**Final buffering point:** Even if streaming worked below, this method returns the body as a string.

---

## Identified Bottlenecks (Where Streaming Breaks)

| # | Location | Issue | Severity |
|---|----------|-------|----------|
| 1 | `Curl::stream_body()` line ~393 | `$this->response_data .= $data` accumulates all chunks | **Low** — easy to skip |
| 2 | `Fsockopen::request()` line ~252 | `$body .= $block` accumulates all chunks | **Low** — easy to skip |
| 3 | `Curl::process_response()` line ~213 | `$this->headers .= $response` concatenates headers+body | **Medium** — need to separate |
| 4 | `Requests::parse_response()` line ~405 | `$return->body = $body` expects complete string | **High** — architectural |
| 5 | `Requests::parse_response()` line ~426 | `decode_chunked()` on complete body | **Medium** — needs incremental impl |
| 6 | `Requests::parse_response()` line ~430 | `decompress()` on complete body | **High** for fsockopen, **Low** for cURL (cURL decompresses in-flight) |
| 7 | `WP_HTTP_Requests_Response::to_array()` | `'body' => string` in return array | **High** — API contract |
| 8 | `WP_Http::request()` return value | Returns flat array with string body | **High** — API contract |

---

## Proposed Insertion Points for Streaming Support

### Option A: Zero Core Changes — Use `request.progress` Hook (Works TODAY)

The `request.progress` hook in both Curl and Fsockopen transports already fires per-chunk during data reception. You can use it via `WP_HTTP_Requests_Hooks`:

```php
add_action('http_request_args', function($args, $url) {
    if ($url === 'https://api.openai.com/v1/chat/completions') {
        // Store a callback in the args to be picked up below
        $args['_stream_callback'] = function($chunk) {
            // Process SSE chunk
            if (str_starts_with($chunk, 'data: ')) {
                $json = json_decode(substr($chunk, 6));
                // Handle token...
            }
        };
    }
    return $args;
}, 10, 2);

add_action('requests-requests.before_request', function(&$url, &$headers, &$data, &$type, &$options) {
    // This won't work — WP_HTTP_Requests_Hooks doesn't expose request.progress to WP hooks
}, 10, 5);
```

**Problem:** `WP_HTTP_Requests_Hooks` (the WordPress wrapper for Requests hooks) maps Requests hook names to WordPress `do_action()` calls, but `request.progress` dispatches through the Requests `Hooks` object directly, NOT through WordPress's action system. You'd need to register directly on the `$options['hooks']` object.

**Practical approach:**

```php
add_filter('http_request_args', function($args, $url) {
    if (str_contains($url, 'api.openai.com')) {
        $args['_streaming_callback'] = function($data, $bytes, $limit) {
            // Process chunk
            echo $data;
            flush();
        };
    }
    return $args;
}, 10, 2);

// In a custom class or mu-plugin that can intercept the hooks object:
add_filter('pre_http_request', function($pre, $args, $url) {
    if (empty($args['_streaming_callback'])) return $pre;
    
    $callback = $args['_streaming_callback'];
    
    // Build a custom Requests call with our hook registered
    $options = [/* ... build from $args ... */];
    $hooks = new WP_HTTP_Requests_Hooks($url, $args);
    $hooks->register('request.progress', $callback);
    $options['hooks'] = $hooks;
    
    $response = WpOrg\Requests\Requests::request($url, $args['headers'] ?? [], $args['body'], $args['method'], $options);
    // Convert to WP format...
    $http_response = new WP_HTTP_Requests_Response($response);
    return $http_response->to_array();
}, 10, 3);
```

**Limitations of Option A:**
- Body is still fully accumulated in memory (both in transport AND in Response object)
- You get the chunks AND the full body at the end — double memory usage
- For SSE, the connection stays open until timeout or server close — the WP timeout default of 5 seconds will kill most SSE streams
- Decompression may interfere (though cURL with `CURLOPT_ENCODING` handles this)

### Option B: Minimal Transport-Level Change

Add a `'stream_callback'` option recognized by both transports:

**In `Curl::stream_body()`:**
```php
public function stream_body($handle, $data) {
    $this->hooks->dispatch('request.progress', [$data, $this->response_bytes, $this->response_byte_limit]);
    
    // NEW: If a stream callback is set, call it and optionally skip accumulation
    if ($this->stream_callback) {
        call_user_func($this->stream_callback, $data);
        if ($this->stream_callback_only) {
            $this->response_bytes += strlen($data);
            return strlen($data);  // Don't accumulate
        }
    }
    
    // ... existing code ...
}
```

**In `Fsockopen::request()` read loop:** Same pattern.

**In `Requests::parse_response()`:** If streaming was used, skip body processing (chunked decode, decompress) since chunks were already processed.

**Estimated changes:** ~30 lines across 3 files in Requests library, ~10 lines in `WP_Http::request()`, ~5 lines in new public API function.

### Option C: Full Streaming API (Ideal for AI/LLM Use Cases)

```php
// New public API
$stream = wp_remote_post_stream('https://api.openai.com/v1/chat/completions', [
    'headers' => ['Authorization' => 'Bearer ...', 'Content-Type' => 'application/json'],
    'body'    => json_encode(['model' => 'gpt-4', 'stream' => true, 'messages' => [...]]),
    'timeout' => 120,  // SSE needs long timeouts
]);

// Generator-based consumption
foreach ($stream as $event) {
    // $event = parsed SSE event object
    if ($event->data === '[DONE]') break;
    $token = json_decode($event->data);
    echo $token->choices[0]->delta->content ?? '';
}

// Or callback-based
wp_remote_post_stream('https://api.openai.com/v1/chat/completions', [
    'body'      => json_encode([...]),
    'timeout'   => 120,
    'on_data'   => function(string $chunk, array $headers, int $status_code) {
        // Raw chunk processing
    },
    'on_event'  => function(object $sse_event) {
        // Parsed SSE event
    },
]);
```

**Required changes for Option C:**

| Layer | File | Changes | Complexity |
|-------|------|---------|------------|
| Transport | `Transport/Curl.php` | Add `stream_callback` support in `stream_body()`, skip accumulation | Low |
| Transport | `Transport/Fsockopen.php` | Add `stream_callback` in read loop, skip accumulation | Low |
| Library | `Requests.php` | New `request_streaming()` method or option flag, skip `parse_response()` body processing | Medium |
| Library | `Response.php` | Add `$body_streamed = true` flag to skip body expectations | Low |
| WP Core | `class-wp-http.php` | New `stream_request()` method, handle streaming args, don't call `to_array()` for body | Medium |
| WP Core | `http.php` | New `wp_remote_post_stream()` / `wp_remote_get_stream()` functions | Low |
| WP Core | New file | SSE parser class, streaming response wrapper | Medium |
| Total | | ~200-400 lines of new/changed code | **Medium** |

---

## What a Streaming API Needs for AI/LLM Use Cases

### SSE (Server-Sent Events) Requirements:
1. **Long timeouts** — SSE streams can last minutes. Default 5s timeout is a non-starter.
2. **Chunked processing** — Each `data: {...}\n\n` event must be processable independently.
3. **No body accumulation** — LLM responses can be large; accumulating defeats the purpose.
4. **Decompression in-flight** — cURL already does this with `CURLOPT_ENCODING`. fsockopen would need `inflate_init()`/`inflate_add()` (PHP 7.0+).
5. **SSE protocol parsing** — Split on `\n\n`, parse `event:`, `data:`, `id:`, `retry:` fields.
6. **Early termination** — Ability to abort the stream (return -1 from cURL write callback, or close socket).

### Immediate Workaround (No Core Changes)

For plugins that need SSE streaming today, bypass `wp_remote_*` entirely:

```php
function wp_streaming_request($url, $args, $on_data) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $args['body'],
        CURLOPT_HTTPHEADER     => $args['headers'],
        CURLOPT_WRITEFUNCTION  => function($ch, $data) use ($on_data) {
            $on_data($data);
            return strlen($data);
        },
        CURLOPT_TIMEOUT        => $args['timeout'] ?? 120,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_CAINFO         => ABSPATH . WPINC . '/certificates/ca-bundle.crt',
    ]);
    curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if ($error) return new WP_Error('curl_error', $error);
    return true;
}
```

This is what most AI plugins (e.g., AI Engine, Jeanie) actually do — they bypass the WordPress HTTP API entirely because it fundamentally cannot stream.

---

## Summary

| Approach | Core Changes? | Effort | Usability |
|----------|--------------|--------|-----------|
| `request.progress` hook | No | Low | Poor (still accumulates, awkward API) |
| Bypass WP HTTP, use cURL directly | No | Low | Good (but loses WP proxy/SSL/cookie handling) |
| Transport-level `stream_callback` | Requests lib only | Medium | Good |
| Full streaming API | WP Core + Requests | Medium-High | Excellent |

**The fundamental architectural problem** is that WordPress's HTTP API was designed around a request-response model where the response is a completed string. Every layer — from the transport return value (concatenated string) through `Requests::parse_response()` (splits string) to `WP_HTTP_Requests_Response::to_array()` (body as string) — assumes the body is available in its entirety.

**The most promising existing hook** is `request.progress` in both transports, which already fires per-chunk with raw data. With cURL's automatic decompression, this data is already usable. The missing piece is preventing accumulation and providing a clean API surface.
