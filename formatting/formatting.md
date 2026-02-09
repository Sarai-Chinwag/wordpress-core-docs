# WordPress Formatting API Overview

The Formatting API is one of WordPress's largest and most critical subsystems, handling text transformation, sanitization, and escaping throughout the platform. It lives primarily in `wp-includes/formatting.php` (6,304 lines) and `wp-includes/kses.php` (3,046 lines).

## Core Concepts

### Escaping vs Sanitization

These terms are often confused but serve distinct purposes:

**Escaping** (Output Safety)
- Applied when *displaying* data
- Makes data safe for a specific context (HTML, attributes, URLs, JS)
- Does NOT alter the stored data
- Functions: `esc_html()`, `esc_attr()`, `esc_url()`, `esc_js()`, `esc_textarea()`, `esc_xml()`

**Sanitization** (Input Safety)
- Applied when *saving* data
- Permanently modifies data to be safe
- Removes or transforms dangerous content
- Functions: `sanitize_*()`, `wp_kses*()`, `wp_filter_*_kses()`

**The Golden Rule:**
> Sanitize early, escape late. Never trust user input. Always escape on output.

### The KSES System

KSES ("KSES Strips Evil Scripts") is WordPress's HTML filtering engine. It:

1. Maintains allowlists of safe HTML elements and attributes
2. Strips disallowed tags completely
3. Validates attribute values against allowed protocols
4. Removes malicious JavaScript and event handlers

```php
// Core KSES contexts
'post'     // Full HTML for post content ($allowedposttags)
'data'     // Basic HTML ($allowedtags - very limited)
'strip'    // Remove ALL HTML
'entities' // Return allowed entity names
```

### Autop (Auto-Paragraphing)

The `wpautop()` function converts double line breaks into HTML paragraphs and single line breaks into `<br />` tags. This is fundamental to how WordPress converts plain text content into proper HTML.

**Key behaviors:**
- Double newlines (`\n\n`) become `<p>` tags
- Single newlines become `<br />` (unless `$br = false`)
- Preserves content in `<pre>`, `<script>`, `<style>`, `<svg>`, `<math>` tags
- Properly handles block-level elements (won't wrap them in `<p>`)
- Applied via `the_content` filter

### Texturize (Typography Enhancement)

The `wptexturize()` function transforms plain text typography into typographically correct HTML entities:

| Plain Text | Transformed |
|------------|-------------|
| `"quotes"` | "smart quotes" (curly) |
| `'apostrophe'` | 'smart' |
| `--` | en-dash (–) |
| `---` | em-dash (—) |
| `...` | ellipsis (…) |
| `(tm)` | trademark (™) |
| `9x9` | 9×9 (multiplication sign) |

**Skip protection:** Content in `<pre>`, `<code>`, `<kbd>`, `<style>`, `<script>`, `<tt>` tags is NOT texturized.

## Security Model

### Trust Levels

WordPress uses capability-based trust:

```php
// Users with 'unfiltered_html' capability bypass KSES
if ( current_user_can( 'unfiltered_html' ) ) {
    // Full HTML allowed
} else {
    // KSES filters applied
}
```

### Allowed HTML by Context

**Post content (`$allowedposttags`):**
- Extensive HTML5 elements
- MathML support
- Media elements (`audio`, `video`, `source`, `track`)
- Semantic elements (`article`, `aside`, `section`, `nav`, `header`, `footer`)
- Interactive elements (`details`, `summary`, `dialog`)
- Form elements (limited)

**Basic content (`$allowedtags`):**
- Links (`<a>` with `href` and `title`)
- Basic formatting (`<b>`, `<strong>`, `<em>`, `<i>`)
- Block quotes, code, abbreviations
- NO block-level elements

**Global attributes** (added to all allowed elements):
- `class`, `id`, `style`, `title`, `role`
- `dir`, `lang`, `xml:lang`
- `aria-*`, `data-*`

### Protocol Filtering

URLs are validated against allowed protocols:

```php
$allowed_protocols = array(
    'http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'irc6', 'ircs',
    'gopher', 'nntp', 'feed', 'telnet', 'mms', 'rtsp', 'sms', 'svn', 'tel',
    'fax', 'xmpp', 'webcal', 'urn'
);
```

### CSS Filtering

The `safecss_filter_attr()` function filters inline `style` attributes, allowing only safe CSS properties and values. It supports:

- Layout: `display`, `position`, `flex`, `grid`, CSS variables
- Box model: `margin`, `padding`, `border`, `width`, `height`
- Typography: `font-*`, `text-*`, `color`
- Backgrounds: `background-*` (including gradients)
- Modern CSS: `calc()`, `var()`, `min()`, `max()`, `clamp()`

## Common Patterns

### Content Display Pipeline

```php
// Raw content from database
$content = get_post_field('post_content', $post_id);

// Apply filters (wpautop, wptexturize, shortcodes, embeds, blocks)
$content = apply_filters('the_content', $content);

// Content is now safe for display (filters include escaping)
echo $content;
```

### Manual Escaping Pattern

```php
// For attributes
echo '<input value="' . esc_attr($user_input) . '">';

// For HTML content
echo '<p>' . esc_html($user_input) . '</p>';

// For URLs
echo '<a href="' . esc_url($url) . '">';

// For JavaScript (inline)
echo '<div onclick="handleClick(\'' . esc_js($value) . '\')">'; 
```

### Sanitization Pattern

```php
// On form submission
$title = sanitize_text_field($_POST['title']);
$email = sanitize_email($_POST['email']);
$content = wp_kses_post($_POST['content']);

// Then save
update_post_meta($id, 'title', $title);
```

## Performance Considerations

1. **Static caching:** `wptexturize()` caches its character/replacement arrays
2. **Skip filters:** Use `run_wptexturize` filter to disable texturization site-wide
3. **KSES is expensive:** For trusted content, consider `wp_kses_post()` over full `wp_kses()`
4. **Batch operations:** `wp_kses_post_deep()` handles arrays efficiently

## Related APIs

- **Shortcodes API:** Processed before autop, can be protected from texturization
- **Blocks API:** Block content parsed separately, has its own sanitization
- **Comments API:** Uses stricter KSES rules by default
- **REST API:** Has its own sanitization callbacks per field
