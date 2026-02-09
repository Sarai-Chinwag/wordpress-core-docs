# WordPress Shortcodes API Functions

Complete reference for all functions in the WordPress Shortcodes API.

---

## Registration Functions

### add_shortcode()

Registers a new shortcode handler.

```php
add_shortcode( string $tag, callable $callback )
```

**Parameters:**
- `$tag` *(string)* — Shortcode tag to register
- `$callback` *(callable)* — Function to call when shortcode is found

**Callback Signature:**

```php
function my_shortcode_handler( array $atts, ?string $content, string $tag ): string
```

- `$atts` — Parsed attributes array
- `$content` — Content between opening/closing tags (null if self-closing)
- `$tag` — The shortcode tag name

**Returns:** void

**Since:** 2.5.0

**Example:**

```php
function greeting_shortcode( $atts, $content = null ) {
    $atts = shortcode_atts( [
        'name' => 'World',
    ], $atts, 'greeting' );
    
    return '<p>Hello, ' . esc_html( $atts['name'] ) . '!</p>';
}
add_shortcode( 'greeting', 'greeting_shortcode' );

// Usage: [greeting name="Alice"] → <p>Hello, Alice!</p>
```

**Invalid Names:**

```php
// These will trigger _doing_it_wrong():
add_shortcode( '', $callback );           // Empty name
add_shortcode( 'my tag', $callback );     // Contains space
add_shortcode( 'my[tag', $callback );     // Contains [
add_shortcode( 'my/tag', $callback );     // Contains /
```

---

### remove_shortcode()

Removes a registered shortcode.

```php
remove_shortcode( string $tag )
```

**Parameters:**
- `$tag` *(string)* — Shortcode tag to remove

**Returns:** void

**Since:** 2.5.0

**Example:**

```php
// Remove WordPress core gallery shortcode
remove_shortcode( 'gallery' );

// Replace with custom implementation
add_shortcode( 'gallery', 'my_custom_gallery' );
```

---

### remove_all_shortcodes()

Removes all registered shortcodes.

```php
remove_all_shortcodes()
```

**Returns:** void

**Since:** 2.5.0

**Example:**

```php
// Disable all shortcodes for API output
remove_all_shortcodes();
echo do_shortcode( $content ); // Returns content unchanged
```

**Warning:** This removes ALL shortcodes including core WordPress ones like `[gallery]`, `[caption]`, `[embed]`, etc.

---

## Detection Functions

### shortcode_exists()

Checks if a shortcode is registered.

```php
shortcode_exists( string $tag ): bool
```

**Parameters:**
- `$tag` *(string)* — Shortcode tag to check

**Returns:** `true` if shortcode exists, `false` otherwise

**Since:** 3.6.0

**Example:**

```php
if ( ! shortcode_exists( 'my_shortcode' ) ) {
    add_shortcode( 'my_shortcode', 'my_handler' );
}
```

---

### has_shortcode()

Checks if content contains a specific shortcode.

```php
has_shortcode( string $content, string $tag ): bool
```

**Parameters:**
- `$content` *(string)* — Content to search
- `$tag` *(string)* — Shortcode tag to find

**Returns:** `true` if shortcode is found (including nested), `false` otherwise

**Since:** 3.6.0

**Example:**

```php
// Conditionally enqueue scripts
if ( has_shortcode( $post->post_content, 'gallery' ) ) {
    wp_enqueue_script( 'gallery-lightbox' );
}
```

**Note:** This function recurses into nested shortcode content to find matches.

---

### get_shortcode_tags_in_content()

Returns all registered shortcode tags found in content.

```php
get_shortcode_tags_in_content( string $content ): string[]
```

**Parameters:**
- `$content` *(string)* — Content to search

**Returns:** Array of shortcode tag names found

**Since:** 6.3.2

**Example:**

```php
$content = '[audio src="file.mp3"][/audio] [foo] [gallery ids="1,2,3"]';
$tags = get_shortcode_tags_in_content( $content );
// Returns: ['audio', 'gallery'] (if 'foo' is not registered)
```

**Note:** Only returns tags that are actually registered. Unregistered shortcode-like text is ignored. Recurses into nested content.

---

## Processing Functions

### do_shortcode()

Processes shortcodes in content.

```php
do_shortcode( string $content, bool $ignore_html = false ): string
```

**Parameters:**
- `$content` *(string)* — Content to process
- `$ignore_html` *(bool)* — Skip shortcodes inside HTML elements (default: false)

**Returns:** Content with shortcodes replaced by their output

**Since:** 2.5.0

**Example:**

```php
// Process shortcodes in widget text
$output = do_shortcode( $widget_text );

// Process shortcodes but ignore those in HTML attributes
$output = do_shortcode( $content, true );
```

**Automatic Usage:**

WordPress automatically applies `do_shortcode` to:
- `the_content` filter (priority 11)
- `widget_text_content` filter
- Various other content areas depending on theme/plugins

---

### apply_shortcodes()

Alias for `do_shortcode()`.

```php
apply_shortcodes( string $content, bool $ignore_html = false ): string
```

**Since:** 5.4.0

Introduced for naming consistency with other WordPress functions like `apply_filters()`.

---

### do_shortcodes_in_html_tags()

Processes shortcodes found inside HTML elements.

```php
do_shortcodes_in_html_tags( string $content, bool $ignore_html, array $tagnames ): string
```

**Parameters:**
- `$content` *(string)* — Content to process
- `$ignore_html` *(bool)* — If true, encode all brackets in HTML
- `$tagnames` *(array)* — List of shortcode tags to process

**Returns:** Processed content

**Since:** 4.2.3

**Internal:** This is primarily used internally by `do_shortcode()`.

**Behavior:**
- Normalizes bracket entities (`&#91;` → `&#091;`)
- Processes shortcodes in unquoted attributes directly
- Processes shortcodes in quoted attributes with KSES sanitization
- Encodes remaining brackets to prevent interference

---

### do_shortcode_tag()

Callback function for shortcode regex replacement.

```php
do_shortcode_tag( array $m ): string
```

**Parameters:**
- `$m` *(array)* — Regex match array from `get_shortcode_regex()`

**Returns:** Shortcode output or original text if escaped

**Since:** 2.5.0

**Access:** Private (used internally)

**Match Array Structure:**

| Index | Content |
|-------|---------|
| `$m[0]` | Full match |
| `$m[1]` | Optional `[` for escaping |
| `$m[2]` | Shortcode name |
| `$m[3]` | Attributes string |
| `$m[4]` | Self-closing `/` |
| `$m[5]` | Enclosed content |
| `$m[6]` | Optional `]` for escaping |

---

## Attribute Functions

### shortcode_parse_atts()

Parses shortcode attributes string into an array.

```php
shortcode_parse_atts( string $text ): array
```

**Parameters:**
- `$text` *(string)* — Attribute string from shortcode

**Returns:** Associative array of attributes. Always returns array (since 6.5.0).

**Since:** 2.5.0

**Example:**

```php
$atts = shortcode_parse_atts( 'foo="bar" baz=\'qux\' id=123 "positional"' );
// Returns:
// [
//     'foo' => 'bar',
//     'baz' => 'qux',
//     'id'  => '123',
//     0     => 'positional',
// ]
```

**Parsing Rules:**
- Attribute names are lowercased
- Supports double quotes, single quotes, or no quotes
- Positional values get numeric keys
- Non-breaking spaces normalized to regular spaces
- C-style escapes processed (`\n`, `\"`, etc.)
- Unclosed HTML in values is rejected

---

### shortcode_atts()

Merges user attributes with defaults.

```php
shortcode_atts( array $pairs, array $atts, string $shortcode = '' ): array
```

**Parameters:**
- `$pairs` *(array)* — Default attribute values
- `$atts` *(array)* — User-provided attributes
- `$shortcode` *(string)* — Shortcode name (enables filtering)

**Returns:** Merged attributes (only keys from `$pairs` are included)

**Since:** 2.5.0

**Example:**

```php
function my_shortcode( $atts ) {
    $atts = shortcode_atts( [
        'id'    => 0,
        'class' => 'default',
        'title' => '',
    ], $atts, 'my_shortcode' );
    
    // $atts now has guaranteed keys with defaults filled in
    return sprintf(
        '<div id="%d" class="%s">%s</div>',
        intval( $atts['id'] ),
        esc_attr( $atts['class'] ),
        esc_html( $atts['title'] )
    );
}
```

**Important:** Unknown attributes (not in `$pairs`) are silently discarded.

---

### get_shortcode_atts_regex()

Returns the regex pattern for parsing attributes.

```php
get_shortcode_atts_regex(): string
```

**Returns:** Regex pattern string

**Since:** 4.4.0

**Pattern Matches:**
1. `name="value"` (double-quoted)
2. `name='value'` (single-quoted)
3. `name=value` (unquoted)
4. `"value"` (positional double-quoted)
5. `'value'` (positional single-quoted)
6. `value` (positional unquoted)

---

## Stripping Functions

### strip_shortcodes()

Removes all shortcode tags from content.

```php
strip_shortcodes( string $content ): string
```

**Parameters:**
- `$content` *(string)* — Content to strip

**Returns:** Content with shortcodes removed (content between tags is also removed)

**Since:** 2.5.0

**Example:**

```php
$content = 'Hello [gallery ids="1,2,3"] World [caption]Photo[/caption]';
echo strip_shortcodes( $content );
// Output: "Hello  World "
```

**Use Cases:**
- Generating excerpts
- Search indexing
- Plain text output

---

### strip_shortcode_tag()

Callback for stripping individual shortcode matches.

```php
strip_shortcode_tag( array $m ): string|false
```

**Parameters:**
- `$m` *(array)* — Regex match array

**Returns:** Empty string (shortcode removed) or content for escaped shortcodes

**Since:** 3.3.0

**Access:** Private (used internally by `strip_shortcodes()`)

---

## Regex Functions

### get_shortcode_regex()

Returns the regex pattern for finding shortcodes.

```php
get_shortcode_regex( ?array $tagnames = null ): string
```

**Parameters:**
- `$tagnames` *(array|null)* — Specific tags to match (default: all registered)

**Returns:** Regex pattern string (without delimiters)

**Since:** 2.5.0, 4.4.0 added `$tagnames` parameter

**Example:**

```php
// Match all registered shortcodes
$pattern = get_shortcode_regex();
preg_match_all( "/$pattern/", $content, $matches );

// Match only specific shortcodes
$pattern = get_shortcode_regex( [ 'gallery', 'audio' ] );
```

**Warning:** The regex is complex. Changes to it must be synchronized with:
- `do_shortcode_tag()`
- `strip_shortcode_tag()`
- `shortcode_unautop()`
- `shortcode.js` (JavaScript equivalent)

---

## Utility Functions

### unescape_invalid_shortcodes()

Restores bracket characters after processing.

```php
unescape_invalid_shortcodes( string $content ): string
```

**Parameters:**
- `$content` *(string)* — Content with encoded brackets

**Returns:** Content with brackets restored

**Since:** 4.2.3

**Conversions:**
- `&#91;` → `[`
- `&#93;` → `]`

**Purpose:** Preserves IE conditional comments like `<!--[if IE]>` that would otherwise be broken by shortcode processing.

---

### _filter_do_shortcode_context()

Internal filter for attachment image context.

```php
_filter_do_shortcode_context(): string
```

**Returns:** `'do_shortcode'`

**Since:** 6.3.0

**Access:** Private

**Purpose:** When `wp_get_attachment_image()` is called during shortcode rendering, this filter sets the context to `'do_shortcode'` so themes/plugins can distinguish shortcode context from template rendering.

---

## Function Quick Reference

| Function | Purpose | Since |
|----------|---------|-------|
| `add_shortcode()` | Register shortcode | 2.5.0 |
| `remove_shortcode()` | Unregister shortcode | 2.5.0 |
| `remove_all_shortcodes()` | Clear all shortcodes | 2.5.0 |
| `shortcode_exists()` | Check if registered | 3.6.0 |
| `has_shortcode()` | Check content for tag | 3.6.0 |
| `get_shortcode_tags_in_content()` | List tags in content | 6.3.2 |
| `do_shortcode()` | Process shortcodes | 2.5.0 |
| `apply_shortcodes()` | Alias for do_shortcode | 5.4.0 |
| `shortcode_parse_atts()` | Parse attribute string | 2.5.0 |
| `shortcode_atts()` | Merge with defaults | 2.5.0 |
| `strip_shortcodes()` | Remove all shortcodes | 2.5.0 |
| `get_shortcode_regex()` | Get matching pattern | 2.5.0 |
| `get_shortcode_atts_regex()` | Get attribute pattern | 4.4.0 |
