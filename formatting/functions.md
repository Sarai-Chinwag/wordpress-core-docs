# WordPress Formatting API Functions

## Escaping Functions

Escaping functions make data safe for output in a specific context. **Always escape on output.**

### esc_html()

Escapes a string for safe output in HTML content.

```php
function esc_html( $text )
```

**Escapes:** `&`, `<`, `>`, `"`, `'`

**Use case:** Displaying user-generated text within HTML tags.

```php
echo '<p>' . esc_html( $user_bio ) . '</p>';
```

**Filter:** `esc_html` - Applied to the escaped text.

---

### esc_attr()

Escapes a string for safe output in an HTML attribute.

```php
function esc_attr( $text )
```

**Escapes:** Same as `esc_html()` - `&`, `<`, `>`, `"`, `'`

**Use case:** Any HTML attribute value.

```php
echo '<input type="text" value="' . esc_attr( $value ) . '" name="' . esc_attr( $name ) . '">';
```

**Filter:** `attribute_escape` - Applied to the escaped text.

---

### esc_url()

Sanitizes and escapes a URL for safe output.

```php
function esc_url( $url, $protocols = null, $_context = 'display' )
```

**Parameters:**
- `$url` - The URL to escape
- `$protocols` - Allowed protocols (default: `wp_allowed_protocols()`)
- `$_context` - 'display' (encodes `&` and `'`) or 'db' (raw)

**Operations:**
1. Strips invalid characters (`%0d`, `%0a` - CRLF injection)
2. Adds `http://` or `https://` if no scheme present
3. Validates against allowed protocols
4. Encodes brackets, ampersands, quotes for display

```php
echo '<a href="' . esc_url( $link ) . '">Click here</a>';
```

**Filter:** `clean_url` - Applied with original URL and context.

---

### esc_url_raw() / sanitize_url()

Sanitizes a URL for database storage or redirects (no display encoding).

```php
function esc_url_raw( $url, $protocols = null )
function sanitize_url( $url, $protocols = null )
```

These are equivalent - use for database storage, `wp_redirect()`, or API calls.

```php
update_post_meta( $id, 'external_link', esc_url_raw( $url ) );
```

---

### esc_js()

Escapes a string for safe output in inline JavaScript.

```php
function esc_js( $text )
```

**Operations:**
- Escapes `"`, `'`, `<`, `>`, `&`
- Converts line breaks to `\n`
- Adds slashes

**Use case:** Inline JS attributes (NOT for `<script>` blocks).

```php
echo '<button onclick="alert(\'' . esc_js( $message ) . '\')">Click</button>';
```

**Filter:** `js_escape` - Applied to the escaped text.

---

### esc_textarea()

Escapes a string for output inside a `<textarea>` element.

```php
function esc_textarea( $text )
```

Uses `htmlspecialchars()` with `ENT_QUOTES`. Preserves newlines.

```php
echo '<textarea>' . esc_textarea( $content ) . '</textarea>';
```

**Filter:** `esc_textarea` - Applied to the escaped text.

---

### esc_xml()

Escapes a string for safe output in XML content.

```php
function esc_xml( $text )
```

**Since:** 5.5.0

Handles CDATA sections properly, converts HTML named entities to code points.

```php
echo '<item><title>' . esc_xml( $title ) . '</title></item>';
```

**Filter:** `esc_xml` - Applied to the escaped text.

---

### tag_escape()

Escapes an HTML tag name.

```php
function tag_escape( $tag_name )
```

Allows only alphanumeric, hyphens (for custom elements), underscores, and colons.

---

## Sanitization Functions

Sanitization functions clean data for storage. **Sanitize on input.**

### sanitize_text_field()

Sanitizes a string from user input for database storage.

```php
function sanitize_text_field( $str )
```

**Operations:**
1. Checks for invalid UTF-8
2. Converts lone `<` to entities
3. Strips ALL HTML tags
4. Removes line breaks, tabs, extra whitespace
5. Strips percent-encoded characters

```php
$title = sanitize_text_field( $_POST['title'] );
```

**Filter:** `sanitize_text_field` - Applied to sanitized string.

---

### sanitize_textarea_field()

Like `sanitize_text_field()` but preserves newlines.

```php
function sanitize_textarea_field( $str )
```

**Since:** 4.7.0

```php
$description = sanitize_textarea_field( $_POST['description'] );
```

**Filter:** `sanitize_textarea_field` - Applied to sanitized string.

---

### sanitize_email()

Strips out all characters not allowed in an email address.

```php
function sanitize_email( $email )
```

Validates local part, domain structure, and TLD. Returns empty string if invalid.

```php
$email = sanitize_email( $_POST['email'] );
if ( empty( $email ) ) {
    // Invalid email
}
```

**Filter:** `sanitize_email` - Applied with email and context.

---

### sanitize_file_name()

Sanitizes a filename for safe storage.

```php
function sanitize_file_name( $filename )
```

**Operations:**
- Removes accents
- Removes special characters (`?`, `[`, `]`, `/`, `\`, `=`, `<`, `>`, `:`, `;`, etc.)
- Replaces spaces with dashes
- Handles multiple extensions safely
- Trims leading/trailing periods, dashes, underscores

```php
$safe_name = sanitize_file_name( $uploaded_file['name'] );
```

**Filters:**
- `sanitize_file_name_chars` - Modify characters to remove
- `sanitize_file_name` - Applied to final filename

---

### sanitize_user()

Sanitizes a username.

```php
function sanitize_user( $username, $strict = false )
```

**Parameters:**
- `$strict = false` - Basic sanitization (strips tags, accents, HTML entities)
- `$strict = true` - Only allows alphanumeric, `_`, space, `.`, `-`, `@`

```php
$username = sanitize_user( $_POST['username'], true );
```

**Filter:** `sanitize_user` - Applied with original and strict flag.

---

### sanitize_key()

Sanitizes a string key (internal identifiers).

```php
function sanitize_key( $key )
```

Lowercase, only allows `a-z`, `0-9`, `_`, `-`.

```php
$meta_key = sanitize_key( $input );
```

**Filter:** `sanitize_key` - Applied to sanitized key.

---

### sanitize_title()

Sanitizes a string into a URL-safe slug.

```php
function sanitize_title( $title, $fallback_title = '', $context = 'save' )
```

**Parameters:**
- `$context = 'save'` - Runs through `remove_accents()` first
- `$context = 'query'` - For database queries (via `sanitize_title_for_query()`)

```php
$slug = sanitize_title( 'Hello World!' ); // 'hello-world'
```

**Filter:** `sanitize_title` - Applied with raw title and context.

---

### sanitize_title_with_dashes()

The workhorse behind `sanitize_title()`. Creates URL-safe slugs.

```php
function sanitize_title_with_dashes( $title, $raw_title = '', $context = 'display' )
```

**Operations:**
- Strips tags
- Preserves escaped octets
- Converts to lowercase
- In 'save' context: converts special spaces/dashes to hyphens
- Removes HTML entities
- Only keeps `a-z`, `0-9`, `_`, `-`, spaces (converted to dashes)

---

### sanitize_html_class()

Sanitizes an HTML class name.

```php
function sanitize_html_class( $classname, $fallback = '' )
```

Only allows `A-Z`, `a-z`, `0-9`, `_`, `-`.

```php
echo '<div class="' . sanitize_html_class( $class ) . '">';
```

**Filter:** `sanitize_html_class` - Applied to sanitized class.

---

### sanitize_mime_type()

Sanitizes a MIME type string.

```php
function sanitize_mime_type( $mime_type )
```

Only allows alphanumeric, `-`, `+`, `*`, `.`, `/`.

**Filter:** `sanitize_mime_type` - Applied to sanitized MIME type.

---

### sanitize_option()

Sanitizes option values based on option name.

```php
function sanitize_option( $option, $value )
```

Handles WordPress core options with specific validation rules (email, URLs, integers, etc.).

**Filter:** `sanitize_option_{$option}` - Per-option sanitization.

---

### sanitize_sql_orderby()

Validates an SQL ORDER BY clause.

```php
function sanitize_sql_orderby( $orderby )
```

Returns `$orderby` if valid, `false` if invalid. Accepts column names with optional ASC/DESC, or `RAND()`.

---

### sanitize_locale_name()

Sanitizes a locale name.

```php
function sanitize_locale_name( $locale_name )
```

**Since:** 6.2.1

Only allows `A-Z`, `a-z`, `0-9`, `_`, `-`.

---

## KSES Functions

### wp_kses()

The main KSES filtering function.

```php
function wp_kses( $content, $allowed_html, $allowed_protocols = array() )
```

**Parameters:**
- `$content` - HTML to filter (expects unslashed data)
- `$allowed_html` - Array of allowed elements/attributes OR context string
- `$allowed_protocols` - Allowed URL protocols

**Context strings:**
- `'post'` - Post content rules
- `'strip'` - Remove all HTML
- `'data'` - Basic HTML only
- `'entities'` - Return allowed entity names

```php
// Using context
$safe = wp_kses( $html, 'post' );

// Custom allowlist
$safe = wp_kses( $html, array(
    'a' => array( 'href' => true, 'title' => true ),
    'em' => array(),
    'strong' => array(),
) );
```

---

### wp_kses_post()

Filters HTML using post content rules.

```php
function wp_kses_post( $data )
```

Expects unslashed data. Shorthand for `wp_kses( $data, 'post' )`.

```php
$safe_content = wp_kses_post( $_POST['content'] );
```

---

### wp_kses_post_deep()

Recursively filters arrays of HTML content.

```php
function wp_kses_post_deep( $data )
```

**Since:** 4.4.2

```php
$safe_data = wp_kses_post_deep( $form_data );
```

---

### wp_kses_data()

Filters HTML using basic rules (unslashed data).

```php
function wp_kses_data( $data )
```

Uses `current_filter()` to determine context.

---

### wp_filter_kses()

Filters HTML using basic rules (slashed data).

```php
function wp_filter_kses( $data )
```

Expects slashed data, returns slashed data. Used in pre-save filters.

---

### wp_filter_post_kses()

Filters HTML using post rules (slashed data).

```php
function wp_filter_post_kses( $data )
```

Expects slashed data, returns slashed data. Used in `content_save_pre` filter.

---

### wp_filter_nohtml_kses()

Strips ALL HTML (slashed data).

```php
function wp_filter_nohtml_kses( $data )
```

---

### wp_kses_allowed_html()

Returns allowed HTML elements for a context.

```php
function wp_kses_allowed_html( $context = '' )
```

**Contexts:** `'post'`, `'strip'`, `'data'`, `'entities'`, `'user_description'`, `'pre_user_description'`

```php
$allowed = wp_kses_allowed_html( 'post' );
// Returns array of elements with their allowed attributes
```

**Filter:** `wp_kses_allowed_html` - Modify allowed elements per context.

---

### wp_kses_attr()

Filters a single element's attributes.

```php
function wp_kses_attr( $element, $attr, $allowed_html, $allowed_protocols )
```

Validates each attribute against the allowlist.

---

### wp_kses_hair()

Parses an attribute string into an array.

```php
function wp_kses_hair( $attr, $allowed_protocols )
```

Returns array with `name`, `value`, `whole`, `vless` for each attribute.

---

### wp_kses_bad_protocol()

Validates a URL against allowed protocols.

```php
function wp_kses_bad_protocol( $content, $allowed_protocols )
```

Removes disallowed protocols from URLs.

---

### wp_kses_uri_attributes()

Returns list of attributes that contain URLs.

```php
function wp_kses_uri_attributes()
```

Returns: `action`, `archive`, `background`, `cite`, `classid`, `codebase`, `data`, `formaction`, `href`, `icon`, `longdesc`, `manifest`, `poster`, `profile`, `src`, `usemap`, `xmlns`

**Filter:** `wp_kses_uri_attributes` - Add custom data-* attributes.

---

### safecss_filter_attr()

Filters inline CSS style attributes.

```php
function safecss_filter_attr( $css, $deprecated = '' )
```

Removes disallowed CSS properties and validates values.

**Filter:** `safe_style_css` - Modify allowed CSS properties.

---

## Text Formatting Functions

### wpautop()

Converts double line breaks to paragraphs.

```php
function wpautop( $text, $br = true )
```

**Parameters:**
- `$text` - Text to convert
- `$br` - Convert remaining single breaks to `<br />` (default: true)

**Preserves content in:** `<pre>`, `<script>`, `<style>`, `<svg>`, `<math>`

---

### wptexturize()

Converts plain text to typographically correct entities.

```php
function wptexturize( $text, $reset = false )
```

**Conversions:**
- Smart quotes (curly)
- Apostrophes
- Dashes (en/em)
- Ellipsis
- Trademark symbol
- Multiplication sign

**Skips:** `<pre>`, `<code>`, `<kbd>`, `<style>`, `<script>`, `<tt>`

**Filters:**
- `run_wptexturize` - Return false to disable
- `no_texturize_tags` - HTML elements to skip
- `no_texturize_shortcodes` - Shortcodes to skip

---

### shortcode_unautop()

Prevents shortcodes from being wrapped in `<p>` tags.

```php
function shortcode_unautop( $text )
```

Applied after `wpautop()` to fix standalone shortcodes.

---

### wp_strip_all_tags()

Strips ALL HTML tags, including script/style contents.

```php
function wp_strip_all_tags( $text, $remove_breaks = false )
```

**Difference from `strip_tags()`:** Also removes content inside `<script>` and `<style>`.

```php
$text = wp_strip_all_tags( $html ); // Tags gone, content preserved
$text = wp_strip_all_tags( $html, true ); // Also normalizes whitespace
```

---

### convert_chars()

Converts lone `&` characters to `&#038;`.

```php
function convert_chars( $content, $deprecated = '' )
```

---

### convert_smilies()

Converts text smileys to image smileys.

```php
function convert_smilies( $text )
```

Only runs if `use_smilies` option is enabled.

---

### make_clickable()

Converts plain text URLs and emails to links.

```php
function make_clickable( $text )
```

Handles `http://`, `https://`, `ftp://`, `www.`, `ftp.`, and email addresses.

**Filters:**
- `make_clickable_rel` - Modify rel attribute on generated links

---

### force_balance_tags()

Balances HTML tags (closes unclosed tags).

```php
function force_balance_tags( $text )
```

Handles self-closing tags, nested elements, and custom elements.

---

### wp_rel_nofollow()

Adds `rel="nofollow"` to all links.

```php
function wp_rel_nofollow( $text )
```

Pre-save filter function.

---

### wp_rel_ugc()

Adds `rel="nofollow ugc"` to all links.

```php
function wp_rel_ugc( $text )
```

**Since:** 5.3.0 - For user-generated content.

---

## Utility Functions

### remove_accents()

Converts accented characters to ASCII equivalents.

```php
function remove_accents( $text, $locale = '' )
```

Handles Latin, Vietnamese, German, Danish characters.

---

### is_email()

Validates an email address.

```php
function is_email( $email, $deprecated = false )
```

Returns email if valid, `false` if invalid. NOT RFC compliant (simpler validation).

**Filter:** `is_email` - Override validation with context.

---

### wp_trim_words()

Trims text to a specified word count.

```php
function wp_trim_words( $text, $num_words = 55, $more = null )
```

```php
$excerpt = wp_trim_words( $content, 20, '...' );
```

**Filter:** `wp_trim_words` - Applied to trimmed text.

---

### wp_trim_excerpt()

Generates an excerpt from content.

```php
function wp_trim_excerpt( $text = '', $post = null )
```

Strips shortcodes, blocks, footnotes. Applies 55-word limit.

**Filters:**
- `excerpt_length` - Modify word count
- `excerpt_more` - Modify "more" string
- `wp_trim_excerpt` - Applied to final excerpt

---

### normalize_whitespace()

Normalizes EOL characters and strips duplicate whitespace.

```php
function normalize_whitespace( $str )
```

---

### zeroise()

Pads a number with leading zeros.

```php
function zeroise( $number, $threshold )
```

```php
zeroise( 5, 3 ); // '005'
```

---

### human_time_diff()

Returns human-readable time difference.

```php
function human_time_diff( $from, $to = 0 )
```

```php
echo human_time_diff( $post_time, time() ); // "2 hours"
```

**Filter:** `human_time_diff` - Modify output.

---

### wp_slash() / wp_unslash()

Adds or removes slashes for WordPress APIs.

```php
function wp_slash( $value )
function wp_unslash( $value )
```

Handles both strings and arrays recursively.

---

### capital_P_dangit()

Corrects "Wordpress" to "WordPress".

```php
function capital_P_dangit( $text )
```

Applied to titles and content automatically.
