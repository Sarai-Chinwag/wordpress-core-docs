# wp_postmeta

Key-value storage for post metadata. Extends wp_posts with arbitrary custom fields.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `meta_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier for the meta entry |
| `post_id` | bigint(20) unsigned | NO | 0 | Associated post ID (FK → wp_posts.ID) |
| `meta_key` | varchar(255) | YES | NULL | Meta key name |
| `meta_value` | longtext | YES | NULL | Meta value (can be serialized) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | meta_id | Yes | Primary key |
| `post_id` | post_id | No | All meta for a post |
| `meta_key` | meta_key(191) | No | Lookup by key name |

## Foreign Key Relationships

- `post_id` → `wp_posts.ID` (the post this meta belongs to)

## Common Meta Keys

### Core WordPress

| Key | Description |
|-----|-------------|
| `_thumbnail_id` | Featured image attachment ID |
| `_wp_attached_file` | Relative path to attachment file |
| `_wp_attachment_metadata` | Serialized attachment data (sizes, dimensions) |
| `_wp_attachment_image_alt` | Alt text for images |
| `_edit_lock` | User currently editing (user_id:timestamp) |
| `_edit_last` | Last user who edited |
| `_wp_page_template` | Page template file |
| `_wp_old_slug` | Previous slugs for redirects |
| `_wp_old_date` | Previous publish dates |
| `_encloseme` | Flag for enclosure processing |
| `_menu_item_*` | Navigation menu item settings |

### Custom Fields (no underscore prefix)

User-defined custom fields appear in the post editor. Keys starting with `_` are hidden from the custom fields UI.

## Serialized Values

Many meta values store serialized PHP arrays:

```php
// _wp_attachment_metadata example
a:5:{
  s:5:"width";i:1920;
  s:6:"height";i:1080;
  s:4:"file";s:25:"2024/01/my-image.jpg";
  s:5:"sizes";a:4:{...}
  s:10:"image_meta";a:12:{...}
}
```

Use `maybe_unserialize()` when reading, `maybe_serialize()` when writing.

## Common Queries

### Get all meta for a post
```sql
SELECT meta_key, meta_value 
FROM wp_postmeta 
WHERE post_id = 123;
```

### Get specific meta value
```sql
SELECT meta_value 
FROM wp_postmeta 
WHERE post_id = 123 
  AND meta_key = '_thumbnail_id';
```

### Get posts with specific meta
```sql
SELECT p.* 
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE pm.meta_key = 'featured' 
  AND pm.meta_value = '1'
  AND p.post_status = 'publish';
```

### Get posts ordered by meta value
```sql
SELECT p.*, pm.meta_value as price
FROM wp_posts p
JOIN wp_postmeta pm ON p.ID = pm.post_id
WHERE pm.meta_key = 'price'
  AND p.post_type = 'product'
  AND p.post_status = 'publish'
ORDER BY CAST(pm.meta_value AS DECIMAL) DESC;
```

### Count posts by meta key
```sql
SELECT meta_key, COUNT(*) as count 
FROM wp_postmeta 
GROUP BY meta_key 
ORDER BY count DESC 
LIMIT 20;
```

### Delete orphaned postmeta
```sql
DELETE pm FROM wp_postmeta pm
LEFT JOIN wp_posts p ON pm.post_id = p.ID
WHERE p.ID IS NULL;
```

## WordPress API Functions

- `get_post_meta( $post_id, $key, $single )` - Get meta value(s)
- `add_post_meta( $post_id, $key, $value, $unique )` - Add meta
- `update_post_meta( $post_id, $key, $value )` - Update meta
- `delete_post_meta( $post_id, $key, $value )` - Delete meta
- `get_post_custom()` - Get all custom fields
- `get_post_custom_keys()` - Get all meta keys for a post

## Performance Notes

- Multiple values per key allowed (use `$single = false` in `get_post_meta()`)
- Index on `meta_key` is limited to 191 characters
- Large serialized values can bloat the table
- Consider dedicated tables for high-volume custom data
