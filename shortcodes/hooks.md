# WordPress Shortcodes API Hooks

Filters and actions available in the WordPress Shortcodes API.

---

## Filters

### pre_do_shortcode_tag

Short-circuits shortcode processing before the callback is called.

```php
apply_filters( 'pre_do_shortcode_tag', false|string $output, string $tag, array $attr, array $m )
```

**Parameters:**
- `$output` *(false|string)* — Return value. `false` to continue, or string to short-circuit.
- `$tag` *(string)* — Shortcode name
- `$attr` *(array)* — Parsed attributes (always array since 6.5.0)
- `$m` *(array)* — Full regex match array

**Returns:** `false` to process normally, or string to replace the shortcode

**Since:** 4.7.0 (6.5.0: `$attr` is always array)

**Example:**

```php
// Cache shortcode output
add_filter( 'pre_do_shortcode_tag', function( $output, $tag, $attr, $m ) {
    if ( 'expensive_shortcode' !== $tag ) {
        return false; // Not our shortcode, continue normally
    }
    
    $cache_key = 'shortcode_' . md5( serialize( $attr ) );
    $cached = wp_cache_get( $cache_key );
    
    if ( false !== $cached ) {
        return $cached; // Return cached output
    }
    
    return false; // Not cached, process normally
}, 10, 4 );
```

---

### do_shortcode_tag

Filters the output after a shortcode callback executes.

```php
apply_filters( 'do_shortcode_tag', string $output, string $tag, array $attr, array $m )
```

**Parameters:**
- `$output` *(string)* — Shortcode output from callback
- `$tag` *(string)* — Shortcode name
- `$attr` *(array)* — Parsed attributes (always array since 6.5.0)
- `$m` *(array)* — Full regex match array

**Returns:** Modified output string

**Since:** 4.7.0 (6.5.0: `$attr` is always array)

**Example:**

```php
// Wrap all shortcode output in a container
add_filter( 'do_shortcode_tag', function( $output, $tag ) {
    return '<div class="shortcode-wrapper shortcode-' . esc_attr( $tag ) . '">' 
           . $output 
           . '</div>';
}, 10, 2 );
```

```php
// Cache shortcode output after processing
add_filter( 'do_shortcode_tag', function( $output, $tag, $attr ) {
    if ( 'expensive_shortcode' !== $tag ) {
        return $output;
    }
    
    $cache_key = 'shortcode_' . md5( serialize( $attr ) );
    wp_cache_set( $cache_key, $output, '', HOUR_IN_SECONDS );
    
    return $output;
}, 10, 3 );
```

---

### shortcode_atts_{$shortcode}

Filters the merged shortcode attributes for a specific shortcode.

```php
apply_filters( "shortcode_atts_{$shortcode}", array $out, array $pairs, array $atts, string $shortcode )
```

**Parameters:**
- `$out` *(array)* — Merged attributes (defaults + user values)
- `$pairs` *(array)* — Original defaults
- `$atts` *(array)* — User-provided attributes
- `$shortcode` *(string)* — Shortcode name

**Returns:** Modified attributes array

**Since:** 3.6.0 (4.4.0: added `$shortcode` parameter)

**Dynamic Hook:** The hook name includes the shortcode name. For `[gallery]`, the hook is `shortcode_atts_gallery`.

**Example:**

```php
// Force gallery to always show 4 columns
add_filter( 'shortcode_atts_gallery', function( $out, $pairs, $atts ) {
    $out['columns'] = 4;
    return $out;
}, 10, 3 );
```

```php
// Add custom attribute support to existing shortcode
add_filter( 'shortcode_atts_audio', function( $out, $pairs, $atts ) {
    // Allow a custom 'theme' attribute
    $out['theme'] = isset( $atts['theme'] ) ? $atts['theme'] : 'default';
    return $out;
}, 10, 3 );
```

**Note:** This filter only fires if the shortcode callback passes the third parameter to `shortcode_atts()`:

```php
// This enables the filter:
$atts = shortcode_atts( $defaults, $atts, 'my_shortcode' );

// This does NOT enable the filter:
$atts = shortcode_atts( $defaults, $atts );
```

---

### strip_shortcodes_tagnames

Filters which shortcode tags are stripped by `strip_shortcodes()`.

```php
apply_filters( 'strip_shortcodes_tagnames', string[] $tags_to_remove, string $content )
```

**Parameters:**
- `$tags_to_remove` *(string[])* — Array of shortcode tag names to strip
- `$content` *(string)* — Content being processed

**Returns:** Modified array of tag names

**Since:** 4.7.0

**Example:**

```php
// Preserve gallery shortcodes when stripping
add_filter( 'strip_shortcodes_tagnames', function( $tags ) {
    $key = array_search( 'gallery', $tags, true );
    if ( false !== $key ) {
        unset( $tags[ $key ] );
    }
    return $tags;
} );
```

```php
// Only strip specific shortcodes
add_filter( 'strip_shortcodes_tagnames', function( $tags, $content ) {
    // Only strip embed and video shortcodes
    return array_intersect( $tags, [ 'embed', 'video', 'audio' ] );
}, 10, 2 );
```

---

### wp_get_attachment_image_context

Filters the context when getting attachment images during shortcode processing.

```php
apply_filters( 'wp_get_attachment_image_context', string $context )
```

**Parameters:**
- `$context` *(string)* — Current context

**Returns:** Modified context string

**Since:** 6.3.0

**Shortcode Value:** During `do_shortcode()`, this filter returns `'do_shortcode'`.

**Purpose:** Allows themes and plugins to detect when `wp_get_attachment_image()` is called from within a shortcode versus template code.

**Example:**

```php
add_filter( 'wp_get_attachment_image_attributes', function( $attr, $attachment, $size ) {
    // Check if we're in a shortcode context
    if ( 'do_shortcode' === apply_filters( 'wp_get_attachment_image_context', '' ) ) {
        // Add lazy loading only for shortcode images
        $attr['loading'] = 'lazy';
    }
    return $attr;
}, 10, 3 );
```

---

## Hook Quick Reference

| Hook | Type | Purpose | Since |
|------|------|---------|-------|
| `pre_do_shortcode_tag` | Filter | Short-circuit before callback | 4.7.0 |
| `do_shortcode_tag` | Filter | Modify output after callback | 4.7.0 |
| `shortcode_atts_{$shortcode}` | Filter | Modify merged attributes | 3.6.0 |
| `strip_shortcodes_tagnames` | Filter | Control which tags are stripped | 4.7.0 |

---

## Usage Patterns

### Caching Pattern

Complete caching implementation using both pre and post filters:

```php
class Shortcode_Cache {
    
    private static $cache_group = 'shortcodes';
    
    public static function init() {
        add_filter( 'pre_do_shortcode_tag', [ __CLASS__, 'get_cache' ], 10, 4 );
        add_filter( 'do_shortcode_tag', [ __CLASS__, 'set_cache' ], 10, 4 );
    }
    
    public static function get_cache( $output, $tag, $attr, $m ) {
        if ( ! self::should_cache( $tag ) ) {
            return false;
        }
        
        $cached = wp_cache_get( self::cache_key( $tag, $attr ), self::$cache_group );
        return ( false !== $cached ) ? $cached : false;
    }
    
    public static function set_cache( $output, $tag, $attr, $m ) {
        if ( self::should_cache( $tag ) ) {
            wp_cache_set( 
                self::cache_key( $tag, $attr ), 
                $output, 
                self::$cache_group, 
                HOUR_IN_SECONDS 
            );
        }
        return $output;
    }
    
    private static function should_cache( $tag ) {
        return in_array( $tag, [ 'gallery', 'playlist', 'embed' ], true );
    }
    
    private static function cache_key( $tag, $attr ) {
        return $tag . '_' . md5( serialize( $attr ) );
    }
}

Shortcode_Cache::init();
```

### Debugging Pattern

Log all shortcode processing for debugging:

```php
add_filter( 'do_shortcode_tag', function( $output, $tag, $attr, $m ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        error_log( sprintf(
            'Shortcode [%s] processed with attributes: %s',
            $tag,
            wp_json_encode( $attr )
        ) );
    }
    return $output;
}, 10, 4 );
```

### Security Pattern

Block specific shortcodes for certain user roles:

```php
add_filter( 'pre_do_shortcode_tag', function( $output, $tag, $attr, $m ) {
    $restricted = [ 'code', 'script', 'include' ];
    
    if ( in_array( $tag, $restricted, true ) && ! current_user_can( 'unfiltered_html' ) ) {
        return '<!-- shortcode restricted -->';
    }
    
    return false;
}, 10, 4 );
```

### Attribute Extension Pattern

Add custom attributes to core shortcodes:

```php
// Add 'lightbox' attribute to gallery
add_filter( 'shortcode_atts_gallery', function( $out, $pairs, $atts ) {
    $out['lightbox'] = isset( $atts['lightbox'] ) ? $atts['lightbox'] : 'true';
    return $out;
}, 10, 3 );

// Then in your gallery output filter:
add_filter( 'post_gallery', function( $output, $attr, $instance ) {
    if ( 'true' === $attr['lightbox'] ) {
        // Add lightbox wrapper
        $output = '<div class="lightbox-gallery">' . $output . '</div>';
    }
    return $output;
}, 10, 3 );
```
