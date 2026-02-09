# wp_options

Key-value store for site settings, plugin options, and transient data.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `option_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `option_name` | varchar(191) | NO | '' | Option key (unique) |
| `option_value` | longtext | NO | NULL | Option value (can be serialized) |
| `autoload` | varchar(20) | NO | 'yes' | Whether to load on every page |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | option_id | Yes | Primary key |
| `option_name` | option_name | Yes | Unique constraint + lookup |
| `autoload` | autoload | No | Filter autoloaded options |

## Foreign Key Relationships

None—standalone configuration table.

## Autoload Behavior

Options with `autoload = 'yes'` are loaded into memory on every WordPress request via:
```php
wp_load_alloptions()
```

This is cached in object cache. Setting `autoload = 'no'` for rarely-used options improves performance.

## Core Option Categories

### Site Settings

| Option | Description |
|--------|-------------|
| `siteurl` | WordPress installation URL |
| `home` | Site homepage URL |
| `blogname` | Site title |
| `blogdescription` | Site tagline |
| `admin_email` | Admin email address |
| `timezone_string` | Timezone setting |
| `date_format` | Date display format |
| `time_format` | Time display format |

### Reading/Writing

| Option | Description |
|--------|-------------|
| `posts_per_page` | Posts per archive page |
| `posts_per_rss` | Posts per RSS feed |
| `show_on_front` | 'posts' or 'page' |
| `page_on_front` | Static front page ID |
| `page_for_posts` | Blog page ID |
| `default_category` | Default post category |
| `default_comment_status` | Default comment status |

### Permalinks

| Option | Description |
|--------|-------------|
| `permalink_structure` | Permalink pattern |
| `category_base` | Category URL prefix |
| `tag_base` | Tag URL prefix |
| `rewrite_rules` | Serialized rewrite rules |

### Theme/Appearance

| Option | Description |
|--------|-------------|
| `template` | Active theme directory |
| `stylesheet` | Active child theme directory |
| `current_theme` | Theme display name |
| `sidebars_widgets` | Widget assignments |
| `theme_mods_{theme}` | Theme customization |
| `nav_menu_options` | Navigation menu settings |

### Cron & Transients

| Pattern | Description |
|---------|-------------|
| `cron` | Scheduled tasks |
| `_transient_{name}` | Cached data |
| `_transient_timeout_{name}` | Transient expiration |
| `_site_transient_{name}` | Network transient |

### Plugin Settings

Plugins typically use patterns like:
- `{plugin_slug}_settings`
- `{plugin_slug}_options`
- `{plugin_slug}_version`

## Common Queries

### Get option value
```sql
SELECT option_value 
FROM wp_options 
WHERE option_name = 'siteurl';
```

### Get all autoloaded options
```sql
SELECT option_name, option_value 
FROM wp_options 
WHERE autoload = 'yes';
```

### Calculate autoload size
```sql
SELECT 
  SUM(LENGTH(option_value)) as total_bytes,
  COUNT(*) as option_count
FROM wp_options 
WHERE autoload = 'yes';
```

### Find large options
```sql
SELECT option_name, LENGTH(option_value) as size_bytes
FROM wp_options 
ORDER BY size_bytes DESC 
LIMIT 20;
```

### Find expired transients
```sql
SELECT o.option_name, o.option_value
FROM wp_options o
JOIN wp_options t ON t.option_name = CONCAT('_transient_timeout_', 
  SUBSTRING(o.option_name, 12))
WHERE o.option_name LIKE '_transient_%'
  AND o.option_name NOT LIKE '_transient_timeout_%'
  AND t.option_value < UNIX_TIMESTAMP();
```

### Delete expired transients
```sql
DELETE a, b FROM wp_options a
LEFT JOIN wp_options b ON b.option_name = CONCAT('_transient_timeout_', 
  SUBSTRING(a.option_name, 12))
WHERE a.option_name LIKE '_transient_%'
  AND a.option_name NOT LIKE '_transient_timeout_%'
  AND b.option_value IS NOT NULL
  AND b.option_value < UNIX_TIMESTAMP();
```

### Optimize autoload
```sql
-- Find options that shouldn't autoload
SELECT option_name, LENGTH(option_value) as size
FROM wp_options 
WHERE autoload = 'yes' 
  AND LENGTH(option_value) > 10000
ORDER BY size DESC;

-- Disable autoload for specific option
UPDATE wp_options 
SET autoload = 'no' 
WHERE option_name = 'large_serialized_option';
```

## WordPress API Functions

- `get_option( $option, $default )` - Get option value
- `add_option( $option, $value, $deprecated, $autoload )` - Add option
- `update_option( $option, $value, $autoload )` - Update/add option
- `delete_option( $option )` - Delete option
- `set_transient( $name, $value, $expiration )` - Set transient
- `get_transient( $name )` - Get transient
- `delete_transient( $name )` - Delete transient

## Performance Notes

### Autoload Optimization

Large sites should audit autoloaded options:
```sql
SELECT SUM(LENGTH(option_value))/1024 as kb FROM wp_options WHERE autoload='yes';
```

Target: Keep autoload under 1MB total.

### Transient Cleanup

Transients without expiration never auto-delete. Periodically clean:
```php
delete_transient( 'my_cached_data' );
// or
wp_cache_flush(); // if using object cache
```

### Option Name Limit

The 191-character limit on `option_name` accommodates UTF-8 in InnoDB with `utf8mb4`. Longer names will be truncated.
