# Custom Tables Best Practices

Guidelines for creating and managing custom database tables in WordPress plugins and themes.

## When to Use Custom Tables

### Use Custom Tables When:
- Data has complex relationships (many-to-many beyond taxonomies)
- High volume of records (millions+)
- Need specific indexes for query patterns
- Data doesn't fit post/meta model
- Performance is critical
- Third-party integrations expect specific schema

### Use Core Tables When:
- Data fits content model (posts + meta)
- Need WP Query compatibility
- Want built-in REST API
- Standard CRUD operations
- Search integration needed

## Table Creation

### Using dbDelta()

```php
function myplugin_create_tables() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'my_custom_table';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL DEFAULT 0,
        title varchar(200) NOT NULL DEFAULT '',
        content longtext NOT NULL,
        status varchar(20) NOT NULL DEFAULT 'active',
        created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        updated_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY  (id),
        KEY user_id (user_id),
        KEY status_created (status, created_at)
    ) $charset_collate;";
    
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'myplugin_create_tables' );
```

### dbDelta Requirements

`dbDelta()` is picky about SQL formatting:

1. Each field on its own line
2. Two spaces between PRIMARY KEY and `(`
3. KEY instead of INDEX
4. Use `$wpdb->get_charset_collate()`
5. No trailing commas
6. Must have PRIMARY KEY

### Schema Version Tracking

```php
define( 'MYPLUGIN_DB_VERSION', '1.2' );

function myplugin_check_db_version() {
    if ( get_option( 'myplugin_db_version' ) !== MYPLUGIN_DB_VERSION ) {
        myplugin_create_tables();
        update_option( 'myplugin_db_version', MYPLUGIN_DB_VERSION );
    }
}
add_action( 'plugins_loaded', 'myplugin_check_db_version' );
```

## Naming Conventions

### Table Names
```php
// Always use prefix
$wpdb->prefix . 'myplugin_items'
$wpdb->prefix . 'myplugin_item_meta'
$wpdb->prefix . 'myplugin_relationships'
```

### Column Names
- Lowercase with underscores
- Descriptive but concise
- Common suffixes: `_id`, `_at`, `_count`

```php
// Good
'user_id', 'created_at', 'post_count', 'is_active'

// Avoid
'UserID', 'createdAt', 'cnt', 'active'  
```

## Column Types

### Recommended Types

| Use Case | Type | Notes |
|----------|------|-------|
| ID/FK | bigint(20) unsigned | Match WP core |
| Short text | varchar(200) | Match post_title |
| Long text | longtext | Match post_content |
| Status | varchar(20) | Match post_status |
| Boolean | tinyint(1) | 0 or 1 |
| Date/time | datetime | Match WP format |
| Money | decimal(10,2) | Avoid float |
| Counter | bigint(20) | For large counts |
| JSON | longtext | Serialize in PHP |

### Match WordPress Patterns

```sql
-- Match wp_posts structure
id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
author_id bigint(20) unsigned NOT NULL DEFAULT 0,
title varchar(200) NOT NULL DEFAULT '',
content longtext NOT NULL,
status varchar(20) NOT NULL DEFAULT 'draft',
created_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
```

## Indexes

### Index Strategy

```sql
-- Primary key
PRIMARY KEY  (id),

-- Foreign key lookups
KEY user_id (user_id),
KEY post_id (post_id),

-- Status + date for filtered queries
KEY status_created (status, created_at),

-- Compound key for common filters
KEY type_status_date (type, status, created_at),

-- Full-text for search (optional)
FULLTEXT KEY content_search (title, content)
```

### Index Tips

1. Index columns in WHERE, JOIN, ORDER BY
2. Put most selective column first in compound indexes
3. Don't over-index (slows inserts/updates)
4. Monitor slow query log for missing indexes

## CRUD Operations

### Prepared Statements (Always)

```php
// INSERT
$wpdb->insert(
    $wpdb->prefix . 'my_table',
    [
        'user_id' => $user_id,
        'title' => $title,
        'created_at' => current_time( 'mysql' ),
    ],
    [ '%d', '%s', '%s' ]
);
$insert_id = $wpdb->insert_id;

// UPDATE
$wpdb->update(
    $wpdb->prefix . 'my_table',
    [ 'title' => $new_title, 'updated_at' => current_time( 'mysql' ) ],
    [ 'id' => $id ],
    [ '%s', '%s' ],
    [ '%d' ]
);

// DELETE
$wpdb->delete(
    $wpdb->prefix . 'my_table',
    [ 'id' => $id ],
    [ '%d' ]
);

// SELECT with prepare
$results = $wpdb->get_results( $wpdb->prepare(
    "SELECT * FROM {$wpdb->prefix}my_table 
     WHERE user_id = %d AND status = %s
     ORDER BY created_at DESC
     LIMIT %d",
    $user_id,
    'active',
    10
) );
```

### Never Use Raw User Input

```php
// DANGEROUS
$wpdb->query( "DELETE FROM {$wpdb->prefix}my_table WHERE id = $id" );

// SAFE
$wpdb->delete( $wpdb->prefix . 'my_table', [ 'id' => $id ], [ '%d' ] );

// or
$wpdb->query( $wpdb->prepare(
    "DELETE FROM {$wpdb->prefix}my_table WHERE id = %d",
    $id
) );
```

## Data Cleanup

### On Plugin Uninstall

```php
// uninstall.php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;

// Drop custom tables
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}myplugin_items" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}myplugin_meta" );

// Delete options
delete_option( 'myplugin_db_version' );
delete_option( 'myplugin_settings' );

// Delete user meta
$wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE 'myplugin_%'" );

// Delete post meta
$wpdb->query( "DELETE FROM {$wpdb->postmeta} WHERE meta_key LIKE 'myplugin_%'" );
```

### Optional: Deactivation Cleanup

```php
// Generally, don't delete data on deactivate (user might reactivate)
// Only clean up temporary data, caches, cron jobs

register_deactivation_hook( __FILE__, function() {
    wp_clear_scheduled_hook( 'myplugin_cron_event' );
    delete_transient( 'myplugin_cache' );
} );
```

## Multisite Considerations

### Network-Wide Tables

```php
// Use base_prefix for network tables
$network_table = $wpdb->base_prefix . 'myplugin_network_data';

// Per-site tables use regular prefix
$site_table = $wpdb->prefix . 'myplugin_site_data';
```

### Create Tables for Each Site

```php
function myplugin_create_site_tables( $blog_id ) {
    switch_to_blog( $blog_id );
    myplugin_create_tables();
    restore_current_blog();
}
add_action( 'wpmu_new_blog', 'myplugin_create_site_tables' );
```

## Migration & Updates

### Schema Migrations

```php
function myplugin_migrate_to_1_2() {
    global $wpdb;
    $table = $wpdb->prefix . 'myplugin_items';
    
    // Check if column exists
    $column = $wpdb->get_results( $wpdb->prepare(
        "SELECT * FROM information_schema.COLUMNS 
         WHERE TABLE_SCHEMA = %s 
         AND TABLE_NAME = %s 
         AND COLUMN_NAME = %s",
        DB_NAME,
        $table,
        'new_column'
    ) );
    
    if ( empty( $column ) ) {
        $wpdb->query( "ALTER TABLE $table ADD new_column varchar(100) DEFAULT ''" );
    }
}
```

### Data Migrations

```php
function myplugin_migrate_data() {
    global $wpdb;
    $table = $wpdb->prefix . 'myplugin_items';
    
    // Batch update for large tables
    $batch_size = 100;
    $offset = 0;
    
    do {
        $rows = $wpdb->get_results( $wpdb->prepare(
            "SELECT id, old_column FROM $table 
             WHERE new_column IS NULL 
             LIMIT %d OFFSET %d",
            $batch_size,
            $offset
        ) );
        
        foreach ( $rows as $row ) {
            $wpdb->update(
                $table,
                [ 'new_column' => transform( $row->old_column ) ],
                [ 'id' => $row->id ]
            );
        }
        
        $offset += $batch_size;
    } while ( count( $rows ) === $batch_size );
}
```

## Performance Tips

1. **Batch inserts** for bulk operations
2. **Use transactions** for atomic operations
3. **Index foreign keys** used in JOINs
4. **Paginate results** instead of loading all
5. **Cache expensive queries** with transients
6. **Monitor slow queries** in development

```php
// Batch insert
$values = [];
$placeholders = [];
foreach ( $items as $item ) {
    $values[] = $item['user_id'];
    $values[] = $item['title'];
    $placeholders[] = "(%d, %s)";
}

$wpdb->query( $wpdb->prepare(
    "INSERT INTO {$wpdb->prefix}my_table (user_id, title) VALUES " . 
    implode( ', ', $placeholders ),
    $values
) );
```
