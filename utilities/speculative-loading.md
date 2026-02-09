# Speculative Loading

Prefetch and prerender API using the Speculation Rules API.

**Source:** `wp-includes/speculative-loading.php`  
**Since:** 6.8.0

## Overview

Speculative loading allows browsers to prefetch or prerender pages before user navigation, enabling near-instant page loads. WordPress implements this via the [Speculation Rules API](https://developer.chrome.com/docs/web-platform/prerender-pages).

**Modes:**
- `prefetch` — Downloads page resources ahead of time
- `prerender` — Fully renders page in hidden tab

**Eagerness Levels:**
- `immediate` — Load immediately (not allowed for document rules)
- `eager` — Load quickly after page load
- `moderate` — Load on pointer hover
- `conservative` — Load only on pointer down/touch

---

## Functions

### wp_get_speculation_rules_configuration()

Returns the speculation rules configuration.

```php
function wp_get_speculation_rules_configuration(): ?array
```

**Returns:** Configuration array or `null` if disabled.

```php
array(
    'mode'      => 'prefetch',    // or 'prerender'
    'eagerness' => 'conservative' // or 'moderate', 'eager'
)
```

**Default Behavior:**
- Enabled only for logged-out users with pretty permalinks
- Returns `null` (disabled) for logged-in users or plain permalinks

**Example:**

```php
$config = wp_get_speculation_rules_configuration();
if ( $config ) {
    echo "Mode: {$config['mode']}, Eagerness: {$config['eagerness']}";
}
```

---

### wp_get_speculation_rules()

Returns the full speculation rules object.

```php
function wp_get_speculation_rules(): ?WP_Speculation_Rules
```

**Returns:** `WP_Speculation_Rules` object or `null` if disabled.

**Default Exclusions:**

| Pattern | Reason |
|---------|--------|
| `/wp-*.php` | Core PHP files |
| `/wp-admin/*` | Admin area |
| `/wp-content/uploads/*` | Media files |
| `/wp-content/*` | Content directory |
| `/wp-content/plugins/*` | Plugins |
| Theme directories | Theme files |
| URLs with query params | Dynamic content (pretty permalinks) |
| URLs with `nonce` params | Security tokens (plain permalinks) |

**Selector Exclusions:**
- `a[rel~="nofollow"]` — Nofollow links
- `.no-prefetch a` — Opt-out class
- `.no-prerender a` — Opt-out class (prerender mode)

---

### wp_print_speculation_rules()

Outputs the speculation rules script tag.

```php
function wp_print_speculation_rules(): void
```

Outputs:

```html
<script type="speculationrules">
{
    "prefetch": [{
        "source": "document",
        "where": {
            "and": [
                {"href_matches": "/*"},
                {"not": {"href_matches": ["/wp-admin/*", ...]}},
                {"not": {"selector_matches": "a[rel~=\"nofollow\"]"}}
            ]
        },
        "eagerness": "conservative"
    }]
}
</script>
```

Hooked to `wp_footer`.

---

## Configuration Examples

### Force Prerender Mode

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    if ( null === $config ) {
        return null; // Keep disabled
    }
    return array(
        'mode'      => 'prerender',
        'eagerness' => 'moderate',
    );
} );
```

### Disable for Specific Pages

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    if ( is_checkout() || is_cart() ) {
        return null; // Disable on checkout/cart
    }
    return $config;
} );
```

### Enable for Logged-in Users

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    // Enable for everyone with pretty permalinks
    if ( get_option( 'permalink_structure' ) ) {
        return array(
            'mode'      => 'prefetch',
            'eagerness' => 'conservative',
        );
    }
    return null;
} );
```

---

## Excluding Paths

### Plugin Integration

```php
add_filter( 'wp_speculation_rules_href_exclude_paths', function( $paths, $mode ) {
    // Exclude WooCommerce dynamic pages
    $paths[] = '/cart/*';
    $paths[] = '/checkout/*';
    $paths[] = '/my-account/*';
    
    // Exclude logout URLs
    $paths[] = '/*logout*';
    
    return $paths;
}, 10, 2 );
```

### Path Pattern Syntax

- `*` — Wildcard (matches any characters)
- Paths are relative to site root
- Automatically prefixed for subdirectory installs

---

## Adding Custom Rules

```php
add_action( 'wp_load_speculation_rules', function( WP_Speculation_Rules $rules ) {
    // Add eager prefetch for priority pages
    $rules->add_rule( 'prefetch', 'priority-pages', array(
        'source'    => 'document',
        'where'     => array(
            'href_matches' => array(
                '/products/*',
                '/services/*',
            ),
        ),
        'eagerness' => 'eager',
    ) );
} );
```

---

## Opting Out

### Per-Element

Add class to link or ancestor:

```html
<!-- Opt out of prefetch -->
<a href="/dynamic-page" class="no-prefetch">Dynamic</a>

<!-- Opt out of prerender (also excludes prefetch) -->
<div class="no-prerender">
    <a href="/expensive-page">Expensive</a>
</div>

<!-- Using nofollow -->
<a href="/action-link" rel="nofollow">Action</a>
```

### Per-Page

```php
add_filter( 'wp_speculation_rules_configuration', function( $config ) {
    if ( is_page( 'no-prefetch' ) ) {
        return null;
    }
    return $config;
} );
```

---

## Browser Support

The Speculation Rules API is supported in:
- Chrome 109+
- Edge 109+

Unsupported browsers ignore the `<script type="speculationrules">` tag.

---

## Related Classes

### WP_Speculation_Rules

Object representing speculation rules data. Implements `JsonSerializable`.

```php
$rules = new WP_Speculation_Rules();
$rules->add_rule( 'prefetch', 'my-rule', $config );
echo wp_json_encode( $rules ); // Outputs JSON
```

### WP_URL_Pattern_Prefixer

Prefixes URL patterns for subdirectory installs.

```php
$prefixer = new WP_URL_Pattern_Prefixer();

// Prefix relative to home URL
$pattern = $prefixer->prefix_path_pattern( '/products/*' );

// Prefix relative to specific location
$pattern = $prefixer->prefix_path_pattern( '/*', 'uploads' );
// Returns: /wp-content/uploads/*
```

**Location Types:**
- `home` — Site home URL
- `site` — WordPress install URL
- `uploads` — Uploads directory
- `content` — wp-content directory
- `plugins` — Plugins directory
- `template` — Parent theme directory
- `stylesheet` — Active theme directory
