# WordPress Rewrite API Overview

The WordPress Rewrite API transforms human-readable URLs (permalinks) into query parameters that WordPress can process. It's the foundation of "pretty permalinks" and allows plugins/themes to create custom URL structures.

## Core Concepts

### Permalink Structures

A permalink structure is a template string containing rewrite tags that define how URLs map to content:

```php
// Default post permalink structure
/%year%/%monthnum%/%day%/%postname%/

// Example: /2024/01/15/hello-world/
```

**Common Permalink Structures:**

| Structure | Example URL | Use Case |
|-----------|-------------|----------|
| `/%postname%/` | `/hello-world/` | Simple, SEO-friendly |
| `/%year%/%monthnum%/%postname%/` | `/2024/01/hello-world/` | Date-based archives |
| `/%category%/%postname%/` | `/news/hello-world/` | Category-prefixed |
| `/%post_id%/` | `/123/` | Minimal, fast |

### Rewrite Tags

Rewrite tags are placeholders in permalink structures that get replaced with regex patterns:

| Tag | Regex Pattern | Query Variable |
|-----|---------------|----------------|
| `%year%` | `([0-9]{4})` | `year=` |
| `%monthnum%` | `([0-9]{1,2})` | `monthnum=` |
| `%day%` | `([0-9]{1,2})` | `day=` |
| `%hour%` | `([0-9]{1,2})` | `hour=` |
| `%minute%` | `([0-9]{1,2})` | `minute=` |
| `%second%` | `([0-9]{1,2})` | `second=` |
| `%postname%` | `([^/]+)` | `name=` |
| `%post_id%` | `([0-9]+)` | `p=` |
| `%author%` | `([^/]+)` | `author_name=` |
| `%pagename%` | `([^/]+?)` | `pagename=` |
| `%search%` | `(.+)` | `s=` |

### Endpoint Masks

Endpoint masks are bitmask constants that define where endpoints (like `/feed/` or `/trackback/`) are appended:

| Constant | Value | Description |
|----------|-------|-------------|
| `EP_NONE` | 0 | Matches nothing |
| `EP_PERMALINK` | 1 | Post permalinks |
| `EP_ATTACHMENT` | 2 | Attachment permalinks |
| `EP_DATE` | 4 | Any date archives |
| `EP_YEAR` | 8 | Yearly archives |
| `EP_MONTH` | 16 | Monthly archives |
| `EP_DAY` | 32 | Daily archives |
| `EP_ROOT` | 64 | Site root |
| `EP_COMMENTS` | 128 | Comment feeds |
| `EP_SEARCH` | 256 | Search results |
| `EP_CATEGORIES` | 512 | Category archives |
| `EP_TAGS` | 1024 | Tag archives |
| `EP_AUTHORS` | 2048 | Author archives |
| `EP_PAGES` | 4096 | Pages |
| `EP_ALL_ARCHIVES` | 7644 | All archive views (EP_DATE \| EP_YEAR \| EP_MONTH \| EP_DAY \| EP_CATEGORIES \| EP_TAGS \| EP_AUTHORS) |
| `EP_ALL` | 8191 | Everything |

**Using Endpoint Masks:**

```php
// Add endpoint to posts and pages only
add_rewrite_endpoint( 'json', EP_PERMALINK | EP_PAGES );

// Add endpoint to all archives
add_rewrite_endpoint( 'export', EP_ALL_ARCHIVES );
```

## How Rewrite Rules Work

### 1. Rule Generation

When `flush_rewrite_rules()` is called, WordPress:

1. Reads the permalink structure from `get_option('permalink_structure')`
2. Generates regex patterns for each URL type (posts, pages, archives, feeds)
3. Stores compiled rules in `get_option('rewrite_rules')`
4. Optionally updates `.htaccess` (Apache) or `web.config` (IIS)

### 2. Request Matching

When a request comes in:

1. The web server routes the request to `index.php` (via `.htaccess` or similar)
2. `WP::parse_request()` iterates through rewrite rules
3. First matching regex wins
4. Captured groups populate query variables
5. `WP_Query` executes with those variables

**Example Flow:**

```
URL: /2024/01/hello-world/

Rule: ^([0-9]{4})/([0-9]{1,2})/([^/]+)/?$
Query: index.php?year=$matches[1]&monthnum=$matches[2]&name=$matches[3]

Result: WP_Query with year=2024, monthnum=01, name=hello-world
```

### 3. Rule Priority

Rules are matched in order. Priority from highest to lowest:

1. `extra_rules_top` - Rules added with `add_rewrite_rule($regex, $query, 'top')`
2. Core rules (robots.txt, favicon.ico, sitemap.xml)
3. Root rules (homepage pagination, feeds)
4. Comments rules
5. Search rules
6. Author rules
7. Date rules
8. Post/Page rules (order depends on `use_verbose_page_rules`)
9. `extra_rules` - Rules added with `add_rewrite_rule($regex, $query, 'bottom')`

## Permalink Structure Components

### Front

The static portion before the first rewrite tag:

```php
// Permalink: /blog/%postname%/
// Front: /blog/

// Permalink: /%postname%/
// Front: /
```

### Root

The prefix for all permalink structures. Empty for mod_rewrite; `index.php/` for PATHINFO permalinks:

```php
// mod_rewrite: root = ''
// PATHINFO: root = 'index.php/'
```

### Trailing Slashes

Controlled by whether the permalink structure ends with `/`:

```php
// With trailing slash: /%postname%/
// URL: /hello-world/

// Without trailing slash: /%postname%
// URL: /hello-world
```

## Common URL Patterns

### Post URLs

```
/2024/01/15/hello-world/     → year, monthnum, day, name
/hello-world/                 → name
/archives/123                 → p (post ID)
```

### Archive URLs

```
/2024/                        → year archive
/2024/01/                     → month archive
/2024/01/15/                  → day archive
/author/admin/                → author archive
/category/news/               → category archive
/tag/wordpress/               → tag archive
```

### Feed URLs

```
/feed/                        → main feed
/feed/atom/                   → Atom feed
/category/news/feed/          → category feed
/hello-world/feed/            → post comments feed
```

### Pagination URLs

```
/page/2/                      → homepage page 2
/category/news/page/3/        → category page 3
/hello-world/2/               → post page 2 (nextpage)
/hello-world/comment-page-2/  → comments page 2
```

## Regex Patterns Reference

### Pattern Syntax

WordPress uses PCRE (Perl Compatible Regular Expressions):

| Pattern | Matches |
|---------|---------|
| `([0-9]+)` | One or more digits |
| `([0-9]{4})` | Exactly 4 digits (year) |
| `([0-9]{1,2})` | 1-2 digits (month/day) |
| `([^/]+)` | One or more non-slash characters |
| `([^/]+?)` | Non-greedy version (pages) |
| `(.+)` | One or more of anything |
| `(.*)` | Zero or more of anything |
| `/?$` | Optional trailing slash, end of string |

### Capture Groups

Each `()` creates a capture group referenced as `$matches[N]`:

```php
// Regex: ^category/([^/]+)/page/([0-9]+)/?$
// URL: /category/news/page/2/
// $matches[1] = 'news'
// $matches[2] = '2'

// Query: index.php?category_name=$matches[1]&paged=$matches[2]
```

## Server Configuration

### Apache (.htaccess)

```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

### Nginx

```nginx
location / {
    try_files $uri $uri/ /index.php?$args;
}
```

### IIS (web.config)

```xml
<rule name="WordPress" patternSyntax="Wildcard">
    <match url="*" />
    <conditions>
        <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
        <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
    </conditions>
    <action type="Rewrite" url="index.php" />
</rule>
```

## Global Variables

### $wp_rewrite

The global `WP_Rewrite` instance:

```php
global $wp_rewrite;

// Check if using permalinks
if ( $wp_rewrite->using_permalinks() ) {
    // Pretty permalinks enabled
}

// Get current permalink structure
$structure = $wp_rewrite->permalink_structure;
```

## Best Practices

### 1. Always Flush Rules on Activation/Deactivation

```php
register_activation_hook( __FILE__, 'myplugin_activate' );
function myplugin_activate() {
    myplugin_register_post_type(); // Register CPT first
    flush_rewrite_rules();
}

register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
function myplugin_deactivate() {
    flush_rewrite_rules();
}
```

### 2. Never Flush on Every Page Load

```php
// BAD - flushes on every request
add_action( 'init', function() {
    add_rewrite_rule( '...', '...' );
    flush_rewrite_rules(); // DON'T DO THIS
});

// GOOD - flush only on activation
add_action( 'init', function() {
    add_rewrite_rule( '...', '...' );
});
```

### 3. Use Specific Endpoint Masks

```php
// BAD - adds endpoint everywhere
add_rewrite_endpoint( 'json', EP_ALL );

// GOOD - adds only where needed
add_rewrite_endpoint( 'json', EP_PERMALINK | EP_PAGES );
```

### 4. Test Rules with Query Monitor

Use the Query Monitor plugin to inspect matched rewrite rules and query variables.

## Debugging

### View All Rewrite Rules

```php
global $wp_rewrite;
print_r( $wp_rewrite->wp_rewrite_rules() );
```

### Check Which Rule Matched

```php
add_action( 'parse_request', function( $wp ) {
    echo 'Matched rule: ' . $wp->matched_rule;
    echo 'Query: ' . $wp->matched_query;
});
```

### Force Regenerate Rules

Visit **Settings → Permalinks** and click "Save Changes" to trigger a flush.

Or programmatically:

```php
flush_rewrite_rules( true ); // true = hard flush (update .htaccess)
```
