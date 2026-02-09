# WordPress Shortcodes API Overview

The Shortcodes API provides a bbcode-like tag system for WordPress. It allows developers to create custom macros that users can insert into content using bracket notation. The parser is based on the Textpattern tag parser.

**Since:** WordPress 2.5.0

**Source:** `wp-includes/shortcodes.php`

---

## Shortcode Syntax

WordPress supports three shortcode formats:

### Self-Closing Shortcodes

```
[shortcode]
[shortcode /]
```

Both forms are equivalent. The trailing slash is optional.

### Shortcodes with Attributes

```
[shortcode foo="bar" baz="bing"]
[shortcode foo="bar" baz="bing" /]
```

Attributes support three quote styles:
- Double quotes: `foo="bar"`
- Single quotes: `foo='bar'`
- No quotes: `foo=bar` (value cannot contain spaces)

Attribute names are case-insensitive and converted to lowercase.

### Enclosing Shortcodes

```
[shortcode]content here[/shortcode]
[shortcode foo="bar"]content here[/shortcode]
```

The content between opening and closing tags is passed to the callback as `$content`.

---

## Attribute Parsing

The attribute parser handles several formats:

| Format | Example | Result |
|--------|---------|--------|
| Double-quoted | `name="value"` | `['name' => 'value']` |
| Single-quoted | `name='value'` | `['name' => 'value']` |
| Unquoted | `name=value` | `['name' => 'value']` |
| Positional (quoted) | `"value"` | `[0 => 'value']` |
| Positional (unquoted) | `value` | `[0 => 'value']` |

**Important behaviors:**
- Attribute names are lowercased automatically
- Non-breaking spaces and zero-width spaces are normalized to regular spaces
- Unclosed HTML elements in attribute values are rejected (value becomes empty string)
- C-style escape sequences are processed via `stripcslashes()`

---

## Shortcode Nesting

WordPress shortcodes have **limited nesting support**. The core parser does not automatically process nested shortcodes—the outer shortcode's callback must explicitly call `do_shortcode()` on its content.

### How to Support Nesting

```php
function my_outer_shortcode( $atts, $content = null ) {
    // Process any nested shortcodes in $content
    $content = do_shortcode( $content );
    
    return '<div class="outer">' . $content . '</div>';
}
add_shortcode( 'outer', 'my_outer_shortcode' );
```

### Nesting Limitations

1. **Same-tag nesting is NOT supported:**
   ```
   [gallery][gallery][/gallery][/gallery]  ❌ Will not work correctly
   ```

2. **Different-tag nesting works** (when callbacks process content):
   ```
   [outer][inner][/inner][/outer]  ✓ Works if outer calls do_shortcode()
   ```

3. **Detection functions recurse:** `has_shortcode()` and `get_shortcode_tags_in_content()` do check nested content (in `$m[5]`).

---

## Escaping Shortcodes

To display a shortcode literally without processing, wrap it in double brackets:

```
[[shortcode]]           → [shortcode]
[[shortcode /]]         → [shortcode /]
[[shortcode]]...[/shortcode]]  → [shortcode]...[/shortcode]
```

The parser strips the outer brackets and returns the inner content as-is.

---

## Shortcode Names

### Valid Names

Shortcode names can contain:
- Letters (a-z, A-Z)
- Numbers (0-9)
- Hyphens (-)
- Underscores (_)

### Invalid Characters

The following characters are forbidden in shortcode names:
- `<` `>` (angle brackets)
- `&` (ampersand)
- `/` (forward slash)
- `[` `]` (square brackets)
- `=` (equals sign)
- Whitespace (spaces, tabs, newlines)
- Control characters (0x00-0x20)

Attempting to register a shortcode with invalid characters triggers `_doing_it_wrong()`.

---

## Processing Pipeline

When `do_shortcode()` is called:

1. **Quick exit check:** If no `[` in content, return immediately
2. **Tag discovery:** Find all potential shortcode names in content
3. **Intersection:** Only process registered shortcodes found in content
4. **HTML context filter:** Add filter for `wp_get_attachment_image_context`
5. **HTML tag processing:** Handle shortcodes inside HTML attributes
6. **Main replacement:** `preg_replace_callback()` with shortcode regex
7. **Escape restoration:** Convert `&#91;` and `&#93;` back to brackets
8. **Cleanup:** Remove context filter

---

## Regex Match Groups

The shortcode regex (`get_shortcode_regex()`) captures 6 groups:

| Group | Description | Example Match |
|-------|-------------|---------------|
| `$m[0]` | Entire matched shortcode | `[gallery ids="1,2,3"]` |
| `$m[1]` | Extra `[` for escaping | `[` (from `[[gallery]]`) |
| `$m[2]` | Shortcode name | `gallery` |
| `$m[3]` | Attribute string | ` ids="1,2,3"` |
| `$m[4]` | Self-closing `/` | `/` (from `[gallery /]`) |
| `$m[5]` | Enclosed content | `...` (from `[tag]...[/tag]`) |
| `$m[6]` | Extra `]` for escaping | `]` (from `[[gallery]]`) |

---

## Shortcodes in HTML

The function `do_shortcodes_in_html_tags()` handles shortcodes inside HTML elements:

### With `$ignore_html = false` (default)

- Shortcodes in unquoted attributes are processed
- Shortcodes in quoted attributes are processed with KSES sanitization
- Comments (`<!-- -->`) and CDATA sections are protected

### With `$ignore_html = true`

- All square brackets inside HTML tags are encoded
- Prevents shortcode processing within HTML elements

### Bracket Encoding

During processing, brackets are temporarily encoded:
- `[` → `&#91;`
- `]` → `&#93;`

After processing, `unescape_invalid_shortcodes()` restores them to preserve things like `<!--[if IE]>`.

---

## Global Variable

```php
global $shortcode_tags;
```

The `$shortcode_tags` array stores all registered shortcodes:

```php
$shortcode_tags = [
    'gallery' => 'gallery_shortcode',
    'caption' => 'img_caption_shortcode',
    'embed'   => '__return_false',
    // ... plugin shortcodes
];
```

**Keys:** Shortcode tag names  
**Values:** Callable functions/methods

---

## Best Practices

1. **Prefix shortcode names** to avoid conflicts: `[myplugin_gallery]` not `[gallery]`

2. **Always escape output** in shortcode callbacks:
   ```php
   return '<div>' . esc_html( $content ) . '</div>';
   ```

3. **Use `shortcode_atts()`** to merge defaults with user attributes

4. **Call `do_shortcode()` on content** if you want to support nesting

5. **Don't process shortcodes too early**—wait until content is ready

6. **Check before adding:** Use `shortcode_exists()` to avoid overwriting

7. **Clean up on deactivation:** Call `remove_shortcode()` when disabling functionality
