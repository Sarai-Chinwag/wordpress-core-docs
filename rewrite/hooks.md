# WordPress Rewrite Hooks

Filters and actions for customizing URL rewriting and permalink generation.

---

## Actions

### generate_rewrite_rules

Fires after rewrite rules are generated.

```php
do_action_ref_array( 'generate_rewrite_rules', array( &$wp_rewrite ) )
```

**Parameters:**
- `$wp_rewrite` (WP_Rewrite) - Current WP_Rewrite instance (passed by reference)

**Description:**

Called at the end of `WP_Rewrite::rewrite_rules()` after all rules are built. Allows direct manipulation of the `WP_Rewrite` object before rules are finalized.

**Example:**

```php
add_action( 'generate_rewrite_rules', function( $wp_rewrite ) {
    // Add custom rules directly
    $wp_rewrite->rules = array_merge(
        array( 'custom/([^/]+)/?$' => 'index.php?custom=$matches[1]' ),
        $wp_rewrite->rules
    );
});
```

**Since:** 1.5.0

---

### permalink_structure_changed

Fires after the permalink structure is updated.

```php
do_action( 'permalink_structure_changed', string $old_permalink_structure, string $permalink_structure )
```

**Parameters:**
- `$old_permalink_structure` (string) - The previous permalink structure
- `$permalink_structure` (string) - The new permalink structure

**Example:**

```php
add_action( 'permalink_structure_changed', function( $old, $new ) {
    // Log permalink changes
    error_log( sprintf( 'Permalinks changed from "%s" to "%s"', $old, $new ) );
    
    // Notify admin
    if ( ! empty( $new ) && empty( $old ) ) {
        // Pretty permalinks just enabled
    }
}, 10, 2 );
```

**Since:** 2.8.0

---

## Filters

### url_to_postid

Filters the URL before determining the post ID.

```php
apply_filters( 'url_to_postid', string $url )
```

**Parameters:**
- `$url` (string) - The URL to derive the post ID from

**Example:**

```php
add_filter( 'url_to_postid', function( $url ) {
    // Handle custom URL redirects
    if ( str_contains( $url, '/old-path/' ) ) {
        $url = str_replace( '/old-path/', '/new-path/', $url );
    }
    return $url;
});
```

**Since:** 2.2.0

---

### rewrite_rules_array

Filters the full set of generated rewrite rules.

```php
apply_filters( 'rewrite_rules_array', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Compiled array of rewrite rules, keyed by regex pattern

**Description:**

The most commonly used hook for modifying rewrite rules. Called after all rules are generated but before they're saved. Rules are processed in order; first match wins.

**Example:**

```php
add_filter( 'rewrite_rules_array', function( $rules ) {
    // Add rule at the beginning (highest priority)
    $new_rules = array(
        'api/v1/([^/]+)/?$' => 'index.php?api_version=1&api_action=$matches[1]',
    );
    
    return array_merge( $new_rules, $rules );
});

// Register the query vars
add_filter( 'query_vars', function( $vars ) {
    $vars[] = 'api_version';
    $vars[] = 'api_action';
    return $vars;
});
```

**Since:** 1.5.0

---

### mod_rewrite_rules

Filters the mod_rewrite rules formatted for .htaccess output.

```php
apply_filters( 'mod_rewrite_rules', string $rules )
```

**Parameters:**
- `$rules` (string) - mod_rewrite rules formatted for .htaccess

**Example:**

```php
add_filter( 'mod_rewrite_rules', function( $rules ) {
    // Add custom Apache directives
    $custom = "
# Custom security rules
RewriteCond %{REQUEST_URI} ^/wp-admin/install\.php [NC]
RewriteRule .* - [F]
";
    
    return str_replace( '</IfModule>', $custom . '</IfModule>', $rules );
});
```

**Since:** 1.5.0

---

### iis7_url_rewrite_rules

Filters the IIS7 URL Rewrite rules for web.config.

```php
apply_filters( 'iis7_url_rewrite_rules', string $rules )
```

**Parameters:**
- `$rules` (string) - Rewrite rules formatted for IIS web.config

**Since:** 2.8.0

---

### flush_rewrite_rules_hard

Filters whether a "hard" rewrite rule flush should be performed.

```php
apply_filters( 'flush_rewrite_rules_hard', bool $hard )
```

**Parameters:**
- `$hard` (bool) - Whether to flush rewrite rules "hard". Default true.

**Description:**

A "hard" flush updates `.htaccess` (Apache) or `web.config` (IIS). Return `false` to prevent file modifications.

**Example:**

```php
// Prevent .htaccess modifications in staging
add_filter( 'flush_rewrite_rules_hard', function( $hard ) {
    if ( defined( 'WP_ENV' ) && WP_ENV === 'staging' ) {
        return false;
    }
    return $hard;
});
```

**Since:** 3.7.0

---

### Category-Specific Rule Filters

### post_rewrite_rules

Filters rewrite rules used for "post" archives.

```php
apply_filters( 'post_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for posts

**Since:** 1.5.0

---

### date_rewrite_rules

Filters rewrite rules used for date archives.

```php
apply_filters( 'date_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for date archives (yyyy, yyyy/mm, yyyy/mm/dd)

**Since:** 1.5.0

---

### root_rewrite_rules

Filters rewrite rules used for root-level archives.

```php
apply_filters( 'root_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of root-level rewrite rules (homepage pagination, site feeds)

**Since:** 1.5.0

---

### comments_rewrite_rules

Filters rewrite rules used for comment feed archives.

```php
apply_filters( 'comments_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for site-wide comment feeds

**Since:** 1.5.0

---

### search_rewrite_rules

Filters rewrite rules used for search archives.

```php
apply_filters( 'search_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for search queries

**Since:** 1.5.0

---

### author_rewrite_rules

Filters rewrite rules used for author archives.

```php
apply_filters( 'author_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for author archives

**Since:** 1.5.0

---

### page_rewrite_rules

Filters rewrite rules used for "page" post type archives.

```php
apply_filters( 'page_rewrite_rules', string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for pages

**Since:** 1.5.0

---

### {$permastructname}_rewrite_rules

Filters rewrite rules for individual permastructs (dynamic hook).

```php
apply_filters( "{$permastructname}_rewrite_rules", string[] $rules )
```

**Parameters:**
- `$rules` (string[]) - Array of rewrite rules for the permastruct

**Description:**

Called for each registered permastruct. The `$permastructname` is the name used when registering the permastruct.

**Common Hook Names:**
- `category_rewrite_rules` - Category archive rules
- `post_tag_rewrite_rules` - Tag archive rules
- `post_format_rewrite_rules` - Post format archive rules
- `{custom_taxonomy}_rewrite_rules` - Custom taxonomy rules
- `{custom_post_type}_rewrite_rules` - Custom post type rules

**Example:**

```php
// Modify category rules
add_filter( 'category_rewrite_rules', function( $rules ) {
    // Add custom rule for category feeds
    $new_rules = array(
        'category/([^/]+)/newsletter/?$' => 'index.php?category_name=$matches[1]&newsletter=1',
    );
    return array_merge( $new_rules, $rules );
});

// Modify custom post type rules
add_filter( 'product_rewrite_rules', function( $rules ) {
    // Remove feed rules for products
    foreach ( $rules as $pattern => $query ) {
        if ( str_contains( $query, 'feed=' ) ) {
            unset( $rules[ $pattern ] );
        }
    }
    return $rules;
});
```

**Since:** 3.1.0

---

### tag_rewrite_rules (Deprecated)

Filters rewrite rules used specifically for tags.

```php
apply_filters_deprecated( 'tag_rewrite_rules', array( $rules ), '3.1.0', 'post_tag_rewrite_rules' )
```

**Deprecated:** 3.1.0 - Use `post_tag_rewrite_rules` instead.

---

### rewrite_rules (Deprecated)

Filters the mod_rewrite rules.

```php
apply_filters_deprecated( 'rewrite_rules', array( $rules ), '1.5.0', 'mod_rewrite_rules' )
```

**Deprecated:** 1.5.0 - Use `mod_rewrite_rules` instead.

---

## Hook Usage Patterns

### Adding Custom Rewrite Rules

The preferred method for adding rules:

```php
// Method 1: Using add_rewrite_rule() on init
add_action( 'init', function() {
    add_rewrite_rule(
        '^events/([0-9]{4})/([0-9]{2})/?$',
        'index.php?post_type=event&year=$matches[1]&monthnum=$matches[2]',
        'top'
    );
});

// Method 2: Using rewrite_rules_array filter
add_filter( 'rewrite_rules_array', function( $rules ) {
    $custom = array(
        '^events/([0-9]{4})/([0-9]{2})/?$' => 'index.php?post_type=event&year=$matches[1]&monthnum=$matches[2]',
    );
    return array_merge( $custom, $rules );
});
```

### Removing Specific Rules

```php
add_filter( 'rewrite_rules_array', function( $rules ) {
    // Remove all feed rules
    foreach ( $rules as $pattern => $query ) {
        if ( preg_match( '/feed/', $query ) ) {
            unset( $rules[ $pattern ] );
        }
    }
    return $rules;
});
```

### Modifying Category Rules

```php
add_filter( 'category_rewrite_rules', function( $rules ) {
    $modified = array();
    
    foreach ( $rules as $pattern => $query ) {
        // Change category base from 'category' to 'topics'
        $new_pattern = str_replace( 'category/', 'topics/', $pattern );
        $modified[ $new_pattern ] = $query;
    }
    
    return $modified;
});
```

### Debugging Rewrite Rules

```php
// Log all rules when they're generated
add_filter( 'rewrite_rules_array', function( $rules ) {
    if ( WP_DEBUG ) {
        error_log( 'Rewrite rules generated: ' . count( $rules ) );
        
        // Log first 10 rules
        $i = 0;
        foreach ( $rules as $pattern => $query ) {
            error_log( sprintf( 'Rule %d: %s => %s', ++$i, $pattern, $query ) );
            if ( $i >= 10 ) break;
        }
    }
    return $rules;
});
```

### Conditional Rule Modification

```php
add_filter( 'rewrite_rules_array', function( $rules ) {
    // Only modify for specific conditions
    if ( ! is_multisite() ) {
        return $rules;
    }
    
    // Remove author archives for security
    foreach ( $rules as $pattern => $query ) {
        if ( str_contains( $query, 'author_name=' ) ) {
            unset( $rules[ $pattern ] );
        }
    }
    
    return $rules;
});
```

### Full Rewrite Replacement

```php
// Complete control over rewrite rules
add_action( 'generate_rewrite_rules', function( $wp_rewrite ) {
    // Replace all rules with minimal set
    $wp_rewrite->rules = array(
        '^$'                      => 'index.php',
        '^([^/]+)/?$'             => 'index.php?name=$matches[1]',
        '^([^/]+)/([0-9]+)/?$'    => 'index.php?name=$matches[1]&page=$matches[2]',
        '^page/([0-9]+)/?$'       => 'index.php?paged=$matches[1]',
        '^feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?feed=$matches[1]',
    );
});
```

---

## Performance Considerations

### Rule Count Impact

More rules = slower request parsing. Keep rules minimal:

```php
// Monitor rule count
add_filter( 'rewrite_rules_array', function( $rules ) {
    $count = count( $rules );
    
    if ( $count > 500 ) {
        error_log( "Warning: High rewrite rule count: $count" );
    }
    
    return $rules;
});
```

### Caching Considerations

Rules are cached in `wp_options`. Avoid flushing unnecessarily:

```php
// BAD: Flushes on every page load
add_action( 'init', function() {
    add_rewrite_rule( '...', '...' );
    flush_rewrite_rules(); // DON'T
});

// GOOD: Flush only on activation/deactivation
register_activation_hook( __FILE__, function() {
    add_rewrite_rule( '...', '...' );
    flush_rewrite_rules();
});
```

### Rule Priority Optimization

Put most-matched rules first:

```php
add_filter( 'rewrite_rules_array', function( $rules ) {
    // Move frequently-accessed patterns to the top
    $priority = array();
    $normal = array();
    
    foreach ( $rules as $pattern => $query ) {
        // Single posts are most common
        if ( str_contains( $query, 'name=' ) && ! str_contains( $query, 'category' ) ) {
            $priority[ $pattern ] = $query;
        } else {
            $normal[ $pattern ] = $query;
        }
    }
    
    return array_merge( $priority, $normal );
});
```
