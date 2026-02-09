# Table Prefixes

WordPress uses configurable table prefixes for security and multi-installation support.

## Default Prefix

```php
// wp-config.php
$table_prefix = 'wp_';
```

All core tables will be named `wp_posts`, `wp_users`, etc.

## Why Use Custom Prefixes

### Security Through Obscurity
```php
$table_prefix = 'mysite_';
```

Makes automated SQL injection attacks slightly harder (they often target `wp_` tables directly).

### Multiple Installations
```php
// Site 1 wp-config.php
$table_prefix = 'site1_';

// Site 2 wp-config.php
$table_prefix = 'site2_';
```

Allows multiple WordPress installations in one database.

### Best Practices

- Use alphanumeric characters and underscores only
- Keep it short but unique
- End with underscore for readability
- Set before installation (changing later is complex)

## Accessing Table Names in Code

### Using $wpdb

```php
global $wpdb;

// Core tables (use properties, not hardcoded names)
$wpdb->posts         // wp_posts
$wpdb->postmeta      // wp_postmeta
$wpdb->users         // wp_users
$wpdb->usermeta      // wp_usermeta
$wpdb->comments      // wp_comments
$wpdb->commentmeta   // wp_commentmeta
$wpdb->terms         // wp_terms
$wpdb->termmeta      // wp_termmeta
$wpdb->term_taxonomy // wp_term_taxonomy
$wpdb->term_relationships // wp_term_relationships
$wpdb->options       // wp_options
$wpdb->links         // wp_links

// Current prefix
$wpdb->prefix        // "wp_" (or custom)

// For custom tables
$custom_table = $wpdb->prefix . 'my_custom_table';
```

### Never Hardcode Table Names

```php
// BAD - breaks with custom prefixes
$wpdb->get_results( "SELECT * FROM wp_posts" );

// GOOD - uses dynamic prefix
$wpdb->get_results( "SELECT * FROM {$wpdb->posts}" );

// GOOD - custom table with prefix
$wpdb->get_results( 
    "SELECT * FROM {$wpdb->prefix}my_custom_table" 
);
```

## Multisite Prefixes

### Base vs Site Prefix

```php
global $wpdb;

// Base prefix (network tables)
$wpdb->base_prefix;  // "wp_"

// Site prefix (per-site tables)
$wpdb->prefix;       // "wp_" (main site) or "wp_2_" (site 2)

// Get prefix for specific site
$wpdb->get_blog_prefix( 2 );  // "wp_2_"
$wpdb->get_blog_prefix( 1 );  // "wp_"
```

### Network vs Site Tables

```php
// Network tables (always base_prefix)
$wpdb->blogs         // wp_blogs
$wpdb->site          // wp_site
$wpdb->sitemeta      // wp_sitemeta
$wpdb->signups       // wp_signups
$wpdb->registration_log // wp_registration_log

// User tables (shared, base_prefix)
$wpdb->users         // wp_users
$wpdb->usermeta      // wp_usermeta

// Site tables (use current prefix)
$wpdb->posts         // wp_posts or wp_2_posts
$wpdb->options       // wp_options or wp_2_options
```

## Changing Prefix After Installation

**Not recommended** but possible:

1. Export database
2. Update `$table_prefix` in wp-config.php
3. Rename all tables
4. Update `wp_options.option_name` references
5. Update `wp_usermeta.meta_key` references

### SQL to Rename Tables

```sql
-- Generate rename statements
SELECT CONCAT(
    'RENAME TABLE `', table_name, '` TO `newprefix_', 
    SUBSTRING(table_name, 4), '`;'
)
FROM information_schema.tables
WHERE table_schema = 'your_database'
  AND table_name LIKE 'wp\_%';
```

### Update Option References

```sql
-- Update options table references
UPDATE newprefix_options 
SET option_name = REPLACE(option_name, 'wp_', 'newprefix_')
WHERE option_name LIKE 'wp\_%';

-- Update user meta references
UPDATE newprefix_usermeta 
SET meta_key = REPLACE(meta_key, 'wp_', 'newprefix_')
WHERE meta_key LIKE 'wp\_%';
```

## Prefix in Queries

### Prepared Statements

```php
$wpdb->prepare(
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d",
    $post_id
);
```

### Complex Joins

```php
$sql = $wpdb->prepare(
    "SELECT p.*, pm.meta_value
     FROM {$wpdb->posts} p
     LEFT JOIN {$wpdb->postmeta} pm 
         ON p.ID = pm.post_id AND pm.meta_key = %s
     WHERE p.post_type = %s",
    '_thumbnail_id',
    'post'
);
```

## Prefix Validation

Valid prefix characters:
- Letters (a-z, A-Z)
- Numbers (0-9)
- Underscore (_)

```php
// WordPress validates prefix during install
if ( preg_match( '|[^a-z0-9_]|i', $prefix ) ) {
    // Invalid prefix
}
```

## Common Issues

### Plugin Hardcoding
Some poorly-written plugins hardcode `wp_` prefix. These break with custom prefixes.

### Export/Import
When migrating, update prefixes in:
- SQL dump files
- Serialized data (use proper search-replace tools)

### PHPMyAdmin
Remember your actual prefix when browsing tables.
