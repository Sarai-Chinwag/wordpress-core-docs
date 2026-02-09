# WP_oEmbed Class

Core class for fetching HTML embeds from oEmbed provider APIs.

**Since:** 2.9.0  
**Source:** `wp-includes/class-wp-oembed.php`

## Overview

`WP_oEmbed` is the consumer-side oEmbed implementation. It:

- Maintains list of trusted oEmbed providers
- Fetches embed data from provider APIs
- Discovers oEmbed endpoints via `<link>` tags
- Converts oEmbed data to HTML

## Properties

| Property | Type | Description |
|----------|------|-------------|
| `$providers` | array | URL patterns → provider endpoints |
| `$early_providers` | array (static) | Providers added before `plugins_loaded` |
| `$compat_methods` | array (private) | Backward-compatible private methods |

## Provider Format

```php
$providers = [
    '#https?://youtube\.com/watch.*#i' => [ 
        'https://www.youtube.com/oembed',  // endpoint
        true                                // is_regex
    ],
    'https://vimeo.com/*' => [
        'https://vimeo.com/api/oembed.{format}',
        false  // is_wildcard
    ],
];
```

## Constructor

```php
public function __construct()
```

Initializes provider list with 30+ sanctioned providers.

**Built-in providers include:**
- YouTube, Vimeo, Dailymotion
- Twitter/X, Bluesky, TikTok
- Spotify, SoundCloud, Mixcloud
- Flickr, Imgur, SmugMug
- Reddit, Tumblr, Pinterest
- Scribd, Speaker Deck, Issuu
- VideoPress, WordPress.tv
- Amazon (Kindle), Kickstarter
- And more...

**Filter:** `oembed_providers` for customization.

---

## Methods

### Provider Discovery

#### get_provider()

```php
public function get_provider( string $url, string|array $args = '' ): string|false
```

Finds oEmbed provider endpoint for a URL.

**Parameters:**
- `$url` - Content URL
- `$args['discover']` - Whether to attempt `<link>` discovery (default true)

**Process:**
1. Loop through registered providers
2. Convert wildcard patterns to regex
3. Test URL against each pattern
4. If no match and discovery enabled, call `discover()`

**Wildcard conversion:**
```php
// Input: 'https://example.com/*'
// Output: '#https?\://example\.com/(.+)#i'
```

**Returns:** Provider endpoint URL or `false`.

---

#### discover()

```php
public function discover( string $url ): string|false
```

Attempts to find oEmbed endpoint via `<link>` tags in page HTML.

**Since:** 2.9.0

**Process:**
1. Fetch page content (limited to 150KB)
2. Extract `<head>` section
3. Parse `<link rel="alternate">` tags
4. Look for `type="application/json+oembed"` or `type="text/xml+oembed"`
5. Return `href` value

**Preference:** JSON over XML.

**Example link tag:**
```html
<link rel="alternate" type="application/json+oembed" 
      href="https://example.com/oembed?url=...&format=json" />
```

---

### Data Fetching

#### get_html()

```php
public function get_html( string $url, string|array $args = '' ): string|false
```

Main entry point - fetches and returns embed HTML.

**Parameters:**
- `$url` - Content URL to embed
- `$args` - Optional width, height, discover settings

**Process:**
1. Apply `pre_oembed_result` filter (short-circuit)
2. Call `get_data()` to fetch oEmbed response
3. Call `data2html()` to convert response to HTML
4. Apply `oembed_result` filter

**Returns:** HTML string or `false`.

---

#### get_data()

```php
public function get_data( string $url, string|array $args = '' ): object|false
```

Fetches raw oEmbed data from provider.

**Since:** 4.8.0

**Process:**
1. Get provider endpoint via `get_provider()`
2. Call `fetch()` to make HTTP request
3. Return parsed data object

---

#### fetch()

```php
public function fetch( 
    string $provider, 
    string $url, 
    string|array $args = '' 
): object|false
```

Makes HTTP request to oEmbed provider.

**Query parameters added:**
- `maxwidth` - From args or defaults
- `maxheight` - From args or defaults
- `url` - The content URL (urlencoded)
- `dnt` - Do Not Track (always 1)

**Filter:** `oembed_fetch_url` before request.

**Tries both JSON and XML formats** (prefers JSON).

---

### Private Fetch Methods

#### _fetch_with_format()

```php
private function _fetch_with_format( 
    string $provider_url_with_args, 
    string $format 
): object|false|WP_Error
```

Fetches from provider with specific format.

**Returns:**
- `WP_Error('not-implemented')` if 501 response
- `false` on other failures
- Parsed data object on success

---

#### _parse_json()

```php
private function _parse_json( string $response_body ): object|false
```

Parses JSON response body.

---

#### _parse_xml()

```php
private function _parse_xml( string $response_body ): object|false
```

Parses XML response body.

**Security:**
- Disables external entity loading (PHP < 8.0)
- Uses internal error handling
- Rejects documents with DOCTYPE

---

#### _parse_xml_body()

```php
private function _parse_xml_body( string $response_body ): stdClass|false
```

Helper for XML parsing using DOMDocument and SimpleXML.

---

### HTML Generation

#### data2html()

```php
public function data2html( object $data, string $url ): string|false
```

Converts oEmbed data object to HTML.

**Response types:**

| Type | Required Fields | Output |
|------|-----------------|--------|
| `photo` | url, width, height | `<a><img></a>` |
| `video` | html | Raw HTML from provider |
| `rich` | html | Raw HTML from provider |
| `link` | title | `<a>title</a>` |

**Filter:** `oembed_dataparse` for custom type handling.

---

### Provider Management

#### _add_provider_early()

```php
public static function _add_provider_early( 
    string $format, 
    string $provider, 
    bool $regex = false 
): void
```

Adds provider before `plugins_loaded`.

Called by `wp_oembed_add_provider()` when used early.

---

#### _remove_provider_early()

```php
public static function _remove_provider_early( string $format ): void
```

Removes provider before `plugins_loaded`.

---

### Utility Methods

#### _strip_newlines()

```php
public function _strip_newlines( 
    string|false $html, 
    object $data, 
    string $url 
): string|false
```

Strips newlines that break `wpautop()`.

**Process:**
1. Preserve content in `<pre>` tags with tokens
2. Strip `\r\n` and `\n` from rest
3. Restore `<pre>` content

Hooked to `oembed_dataparse` filter.

---

#### __call()

```php
public function __call( string $name, array $arguments ): mixed|false
```

Magic method for backward compatibility with renamed private methods.

Allows calling: `_fetch_with_format`, `_parse_json`, `_parse_xml`, `_parse_xml_body`

---

## oEmbed Response Format

Standard oEmbed response fields:

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| `type` | string | Yes | photo, video, link, rich |
| `version` | string | Yes | Always "1.0" |
| `title` | string | No | Resource title |
| `author_name` | string | No | Creator name |
| `author_url` | string | No | Creator profile URL |
| `provider_name` | string | No | Provider name |
| `provider_url` | string | No | Provider URL |
| `cache_age` | int | No | Suggested cache duration |
| `thumbnail_url` | string | No | Thumbnail image |
| `thumbnail_width` | int | No | Thumbnail width |
| `thumbnail_height` | int | No | Thumbnail height |

**Photo-specific:**
| Field | Description |
|-------|-------------|
| `url` | Image URL |
| `width` | Image width |
| `height` | Image height |

**Video/Rich-specific:**
| Field | Description |
|-------|-------------|
| `html` | Embed HTML (iframe, etc.) |
| `width` | Embed width |
| `height` | Embed height |

---

## Usage Examples

### Basic Embed Fetch

```php
$oembed = _wp_oembed_get_object();

$html = $oembed->get_html( 
    'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
    [ 'width' => 600 ]
);
```

### Get Raw Data

```php
$oembed = _wp_oembed_get_object();

$data = $oembed->get_data( 'https://vimeo.com/123456789' );
// $data->title, $data->author_name, $data->thumbnail_url, etc.
```

### Check Provider Availability

```php
$oembed = _wp_oembed_get_object();

$provider = $oembed->get_provider( 
    'https://example.com/video/123',
    [ 'discover' => false ]  // Don't try discovery
);

if ( $provider ) {
    // URL matches a known provider
}
```

### Custom Provider

```php
// After plugins_loaded
$oembed = _wp_oembed_get_object();
$oembed->providers['#https?://custom\.com/v/\d+#i'] = [
    'https://custom.com/oembed',
    true  // is regex
];
```

---

## Filters Applied

| Filter | Location | Purpose |
|--------|----------|---------|
| `oembed_providers` | Constructor | Modify provider list |
| `pre_oembed_result` | `get_html()` | Short-circuit fetching |
| `oembed_result` | `get_html()` | Filter final HTML |
| `oembed_remote_get_args` | `discover()`, `_fetch_with_format()` | HTTP request args |
| `oembed_linktypes` | `discover()` | Discoverable link types |
| `oembed_fetch_url` | `fetch()` | Filter provider URL |
| `oembed_dataparse` | `data2html()` | Custom data→HTML |

---

## Provider List (Complete)

As of WordPress 6.8:

| Provider | Pattern |
|----------|---------|
| YouTube | youtube.com/watch, youtu.be, /shorts, /live, /playlist |
| Vimeo | vimeo.com |
| Dailymotion | dailymotion.com, dai.ly |
| Flickr | flickr.com, flic.kr |
| SmugMug | smugmug.com |
| Scribd | scribd.com/doc |
| WordPress.tv | wordpress.tv |
| Crowdsignal | crowdsignal.net, polldaddy.com, poll.fm, survey.fm |
| Twitter/X | twitter.com (status, profile, likes, lists, moments) |
| SoundCloud | soundcloud.com |
| Spotify | spotify.com |
| Imgur | imgur.com |
| Issuu | issuu.com |
| Mixcloud | mixcloud.com |
| TED | ted.com/talks |
| Animoto | animoto.com, video214.com |
| Tumblr | tumblr.com |
| Kickstarter | kickstarter.com, kck.st |
| Cloudup | cloudup.com |
| ReverbNation | reverbnation.com |
| VideoPress | videopress.com |
| Reddit | reddit.com/r/.../comments |
| Speaker Deck | speakerdeck.com |
| Amazon | amazon.* domains, a.co, amzn.to, z.cn |
| Someecards | someecards.com, some.ly |
| TikTok | tiktok.com |
| Pinterest | pinterest.com |
| WolframCloud | wolframcloud.com |
| Pocket Casts | pca.st |
| Anghami | anghami.com |
| Bluesky | bsky.app |
| Canva | canva.com/design |

---

## Removed Providers

| Provider | Removed In | Reason |
|----------|------------|--------|
| Instagram | 5.5.2 | Requires authentication |
| Facebook | 5.5.2 | Requires authentication |
| SlideShare | 6.6.0 | Service discontinued |
| Vine | 4.9.0 | Service discontinued |
| Screencast | 6.8.2 | Service changes |
