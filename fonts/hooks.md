# Fonts API Hooks

## Filters

### font_dir

Filters the fonts directory data.

```php
apply_filters( 'font_dir', array $font_dir ): array
```

**Since:** 6.5.0

**Parameters:**

| Name | Type | Description |
|------|------|-------------|
| `$font_dir` | `array` | Font directory information |

**$font_dir Structure:**

```php
[
    'path'    => '/var/www/html/wp-content/uploads/fonts',
    'url'     => 'https://example.com/wp-content/uploads/fonts',
    'subdir'  => '',
    'basedir' => '/var/www/html/wp-content/uploads/fonts',
    'baseurl' => 'https://example.com/wp-content/uploads/fonts',
    'error'   => false,
]
```

**Example - Custom Font Directory:**

```php
add_filter( 'font_dir', function( $font_dir ) {
    // Store fonts in a custom location
    $font_dir['path']    = '/var/www/html/fonts';
    $font_dir['url']     = 'https://example.com/fonts';
    $font_dir['basedir'] = '/var/www/html/fonts';
    $font_dir['baseurl'] = 'https://example.com/fonts';
    
    return $font_dir;
});
```

**Example - CDN URL:**

```php
add_filter( 'font_dir', function( $font_dir ) {
    // Serve fonts from CDN
    $font_dir['url']     = 'https://cdn.example.com/fonts';
    $font_dir['baseurl'] = 'https://cdn.example.com/fonts';
    
    return $font_dir;
});
```

**Example - Subdirectory Per Site (Multisite):**

```php
add_filter( 'font_dir', function( $font_dir ) {
    $site_id = get_current_blog_id();
    
    $font_dir['path']    .= '/site-' . $site_id;
    $font_dir['url']     .= '/site-' . $site_id;
    $font_dir['basedir'] .= '/site-' . $site_id;
    $font_dir['baseurl'] .= '/site-' . $site_id;
    $font_dir['subdir']   = '/site-' . $site_id;
    
    return $font_dir;
});
```

---

## Internal Hooks

These hooks are used internally for font management:

### after_delete_post

Used by `_wp_after_delete_font_family()` to clean up child font faces when a `wp_font_family` post is deleted.

### before_delete_post

Used by `_wp_before_delete_font_face()` to delete font files when a `wp_font_face` post is deleted.

---

## Related Hooks

### upload_dir

The `upload_dir` filter is temporarily used internally by `wp_font_dir()` to redirect uploads to the fonts directory. The internal callback `_wp_filter_font_directory()` handles this.

**Note:** Do not use `upload_dir` to modify font paths. Use `font_dir` instead.
