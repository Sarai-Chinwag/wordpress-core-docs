# WordPress Formatting API Hooks

## Escaping Filters

### esc_html

Filters a string after HTML escaping.

```php
apply_filters( 'esc_html', string $safe_text, string $text )
```

**Parameters:**
- `$safe_text` - The escaped text
- `$text` - The original text

**Example:**
```php
add_filter( 'esc_html', function( $safe_text, $text ) {
    // Additional processing after HTML escaping
    return $safe_text;
}, 10, 2 );
```

---

### attribute_escape

Filters a string after attribute escaping (via `esc_attr()`).

```php
apply_filters( 'attribute_escape', string $safe_text, string $text )
```

---

### js_escape

Filters a string after JavaScript escaping (via `esc_js()`).

```php
apply_filters( 'js_escape', string $safe_text, string $text )
```

---

### esc_textarea

Filters a string after textarea escaping.

```php
apply_filters( 'esc_textarea', string $safe_text, string $text )
```

---

### esc_xml

Filters a string after XML escaping.

```php
apply_filters( 'esc_xml', string $safe_text, string $text )
```

**Since:** 5.5.0

---

### clean_url

Filters a URL after sanitization (via `esc_url()`).

```php
apply_filters( 'clean_url', string $good_protocol_url, string $original_url, string $_context )
```

**Parameters:**
- `$good_protocol_url` - The sanitized URL
- `$original_url` - The original URL
- `$_context` - 'display' or 'db'

---

### tag_escape

Filters an escaped HTML tag name.

```php
apply_filters( 'tag_escape', string $safe_tag, string $tag_name )
```

---

## Sanitization Filters

### sanitize_text_field

Filters a sanitized single-line text field.

```php
apply_filters( 'sanitize_text_field', string $filtered, string $str )
```

---

### sanitize_textarea_field

Filters a sanitized multi-line text field.

```php
apply_filters( 'sanitize_textarea_field', string $filtered, string $str )
```

**Since:** 4.7.0

---

### sanitize_email

Filters a sanitized email address.

```php
apply_filters( 'sanitize_email', string $sanitized_email, string $email, string|null $message )
```

**Parameters:**
- `$sanitized_email` - Empty string if invalid, sanitized email otherwise
- `$email` - The original email
- `$message` - Error context (e.g., 'email_too_short', 'local_invalid_chars') or null on success

---

### sanitize_file_name

Filters a sanitized filename.

```php
apply_filters( 'sanitize_file_name', string $filename, string $filename_raw )
```

---

### sanitize_file_name_chars

Filters the list of characters to remove from filenames.

```php
apply_filters( 'sanitize_file_name_chars', string[] $special_chars, string $filename_raw )
```

**Use case:** Customize which characters are stripped from uploads.

---

### sanitize_user

Filters a sanitized username.

```php
apply_filters( 'sanitize_user', string $username, string $raw_username, bool $strict )
```

---

### sanitize_key

Filters a sanitized string key.

```php
apply_filters( 'sanitize_key', string $sanitized_key, string $key )
```

---

### sanitize_title

Filters a sanitized title/slug.

```php
apply_filters( 'sanitize_title', string $title, string $raw_title, string $context )
```

**Parameters:**
- `$title` - The sanitized title
- `$raw_title` - The original title
- `$context` - 'save', 'query', or 'display'

---

### sanitize_html_class

Filters a sanitized HTML class name.

```php
apply_filters( 'sanitize_html_class', string $sanitized, string $classname, string $fallback )
```

---

### sanitize_locale_name

Filters a sanitized locale name.

```php
apply_filters( 'sanitize_locale_name', string $sanitized, string $locale_name )
```

**Since:** 6.2.1

---

### sanitize_mime_type

Filters a sanitized MIME type.

```php
apply_filters( 'sanitize_mime_type', string $sani_mime_type, string $mime_type )
```

---

### sanitize_trackback_urls

Filters sanitized trackback URLs.

```php
apply_filters( 'sanitize_trackback_urls', string $urls_to_ping, string $to_ping )
```

---

### sanitize_option_{$option}

Filters a sanitized option value by option name.

```php
apply_filters( "sanitize_option_{$option}", mixed $value, string $option, mixed $original_value )
```

**Example:**
```php
add_filter( 'sanitize_option_my_plugin_email', function( $value, $option, $original ) {
    return sanitize_email( $value );
}, 10, 3 );
```

---

### is_email

Filters email validation result.

```php
apply_filters( 'is_email', string|false $is_email, string $email, string $context )
```

**Contexts:**
- `email_too_short`
- `email_no_at`
- `local_invalid_chars`
- `domain_period_sequence`
- `domain_period_limits`
- `domain_no_periods`
- `sub_hyphen_limits`
- `sub_invalid_chars`

---

## KSES Filters

### wp_kses_allowed_html

Filters allowed HTML elements for a context.

```php
apply_filters( 'wp_kses_allowed_html', array[] $html, string $context )
```

**Use case:** Add custom allowed elements/attributes.

```php
add_filter( 'wp_kses_allowed_html', function( $tags, $context ) {
    if ( 'post' === $context ) {
        $tags['custom-element'] = array(
            'data-value' => true,
            'class' => true,
        );
    }
    return $tags;
}, 10, 2 );
```

---

### pre_kses

Filters content before KSES processing.

```php
apply_filters( 'pre_kses', string $content, array[]|string $allowed_html, string[] $allowed_protocols )
```

**Use case:** Pre-process content before sanitization.

---

### wp_kses_uri_attributes

Filters the list of attributes that contain URLs.

```php
apply_filters( 'wp_kses_uri_attributes', string[] $uri_attributes )
```

**Use case:** Add `data-*` attributes that should be validated as URLs.

```php
add_filter( 'wp_kses_uri_attributes', function( $attrs ) {
    $attrs[] = 'data-video-src';
    return $attrs;
} );
```

---

### safe_style_css

Filters the list of allowed CSS properties in inline styles.

```php
apply_filters( 'safe_style_css', string[] $attr )
```

**Use case:** Allow additional CSS properties.

```php
add_filter( 'safe_style_css', function( $styles ) {
    $styles[] = 'clip-path';
    $styles[] = 'mask';
    return $styles;
} );
```

---

### safecss_filter_attr_allow_css

Filters whether a specific CSS value is allowed.

```php
apply_filters( 'safecss_filter_attr_allow_css', bool $allow_css, string $css_test_string )
```

**Use case:** Allow specific CSS values that would otherwise be blocked.

---

## Texturization Filters

### run_wptexturize

Filters whether to run wptexturize.

```php
apply_filters( 'run_wptexturize', bool $run_texturize )
```

**Only runs once.** Return `false` to disable texturization site-wide.

```php
add_filter( 'run_wptexturize', '__return_false' );
```

---

### no_texturize_tags

Filters HTML elements that should NOT be texturized.

```php
apply_filters( 'no_texturize_tags', string[] $default_no_texturize_tags )
```

**Default tags:** `pre`, `code`, `kbd`, `style`, `script`, `tt`

```php
add_filter( 'no_texturize_tags', function( $tags ) {
    $tags[] = 'textarea';
    $tags[] = 'samp';
    return $tags;
} );
```

---

### no_texturize_shortcodes

Filters shortcodes that should NOT be texturized.

```php
apply_filters( 'no_texturize_shortcodes', string[] $default_no_texturize_shortcodes )
```

**Default shortcodes:** `code`

```php
add_filter( 'no_texturize_shortcodes', function( $shortcodes ) {
    $shortcodes[] = 'raw';
    $shortcodes[] = 'highlight';
    return $shortcodes;
} );
```

---

## Content Filters

### the_content

Main content filter (includes wpautop, wptexturize, shortcodes, blocks).

```php
apply_filters( 'the_content', string $content )
```

**Default priority hooks:**
- `do_blocks` (9)
- `wptexturize` (10)
- `wpautop` (10)
- `shortcode_unautop` (10)
- `prepend_attachment` (10)
- `wp_filter_content_tags` (12)
- `convert_smilies` (20)
- `do_shortcode` (11)

---

### format_to_edit

Filters text being prepared for editing.

```php
apply_filters( 'format_to_edit', string $content )
```

---

### excerpt_length

Filters the maximum word count for excerpts.

```php
apply_filters( 'excerpt_length', int $number )
```

**Default:** 55 words

---

### excerpt_more

Filters the "read more" string in excerpts.

```php
apply_filters( 'excerpt_more', string $more_string )
```

**Default:** ` [&hellip;]`

---

### wp_trim_excerpt

Filters the final trimmed excerpt.

```php
apply_filters( 'wp_trim_excerpt', string $text, string $raw_excerpt )
```

---

### wp_trim_words

Filters text after word trimming.

```php
apply_filters( 'wp_trim_words', string $text, int $num_words, string $more, string $original_text )
```

---

## Link Filters

### make_clickable_rel

Filters the `rel` attribute for auto-linked URLs.

```php
apply_filters( 'make_clickable_rel', string $rel, string $url )
```

**Use case:** Add or remove `nofollow` on generated links.

```php
add_filter( 'make_clickable_rel', function( $rel, $url ) {
    if ( wp_is_internal_link( $url ) ) {
        return ''; // No rel for internal links
    }
    return 'nofollow noopener';
}, 10, 2 );
```

---

### smilies_src

Filters the smiley image URL.

```php
apply_filters( 'smilies_src', string $smiley_url, string $img, string $site_url )
```

---

## Miscellaneous Filters

### human_time_diff

Filters human-readable time difference.

```php
apply_filters( 'human_time_diff', string $since, int $diff, int $from, int $to )
```

---

### pre_ent2ncr

Filters text before named-to-numeric entity conversion.

```php
apply_filters( 'pre_ent2ncr', string|null $converted_text, string $text )
```

Return non-null string to short-circuit.

---

### wp_spaces_regexp

Filters the regexp for matching whitespace characters.

```php
apply_filters( 'wp_spaces_regexp', string $spaces )
```

**Default pattern:** `[\r\n\t ]|\xC2\xA0|&nbsp;`

---

## Pre-Save Filters

These filters run when saving content to the database:

### content_save_pre

Filters post content before saving.

```php
apply_filters( 'content_save_pre', string $content )
```

**Attached:** `wp_filter_post_kses`, `wp_filter_global_styles_post`

---

### excerpt_save_pre

Filters post excerpt before saving.

```php
apply_filters( 'excerpt_save_pre', string $excerpt )
```

**Attached:** `wp_filter_post_kses`

---

### title_save_pre

Filters post title before saving.

```php
apply_filters( 'title_save_pre', string $title )
```

**Attached:** `wp_filter_kses`

---

### pre_comment_content

Filters comment content before saving.

```php
apply_filters( 'pre_comment_content', string $content )
```

**Attached:** `wp_filter_kses` or `wp_filter_post_kses` (depending on user capability)

---

## KSES Initialization Actions

### kses_init

Runs when KSES is initialized (on `init` and `set_current_user`).

Calls `kses_remove_filters()` then conditionally `kses_init_filters()` based on user capability.

### kses_init_filters()

Adds all KSES content filters:
- `title_save_pre` → `wp_filter_kses`
- `pre_comment_content` → `wp_filter_kses` or `wp_filter_post_kses`
- `content_save_pre` → `wp_filter_post_kses`
- `excerpt_save_pre` → `wp_filter_post_kses`
- `content_filtered_save_pre` → `wp_filter_post_kses`

### kses_remove_filters()

Removes all KSES content filters (call before `kses_init_filters()` to reset).
