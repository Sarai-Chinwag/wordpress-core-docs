# wp_termmeta

Key-value storage for term metadata. Added in WordPress 4.4 to extend terms with custom data.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `meta_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `term_id` | bigint(20) unsigned | NO | 0 | Term ID (FK → wp_terms.term_id) |
| `meta_key` | varchar(255) | YES | NULL | Meta key name |
| `meta_value` | longtext | YES | NULL | Meta value (can be serialized) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | meta_id | Yes | Primary key |
| `term_id` | term_id | No | All meta for a term |
| `meta_key` | meta_key(191) | No | Lookup by key name |

## Foreign Key Relationships

- `term_id` → `wp_terms.term_id`

## Common Use Cases

Term meta is often used for:
- **Category images** - Thumbnail or banner for archive pages
- **SEO data** - Meta descriptions, custom titles
- **Display options** - Color schemes, icons, layout preferences
- **Custom fields** - Any taxonomy-specific data

## Common Queries

### Get all meta for a term
```sql
SELECT meta_key, meta_value 
FROM wp_termmeta 
WHERE term_id = 5;
```

### Get specific meta value
```sql
SELECT meta_value 
FROM wp_termmeta 
WHERE term_id = 5 
  AND meta_key = 'category_image';
```

### Get terms with specific meta
```sql
SELECT t.*, tm.meta_value as image_url
FROM wp_terms t
JOIN wp_termmeta tm ON t.term_id = tm.term_id
WHERE tm.meta_key = 'category_image';
```

### Get terms ordered by meta value
```sql
SELECT t.*, tm.meta_value as sort_order
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
LEFT JOIN wp_termmeta tm ON t.term_id = tm.term_id 
  AND tm.meta_key = 'sort_order'
WHERE tt.taxonomy = 'category'
ORDER BY CAST(tm.meta_value AS SIGNED);
```

### Delete orphaned termmeta
```sql
DELETE tm FROM wp_termmeta tm
LEFT JOIN wp_terms t ON tm.term_id = t.term_id
WHERE t.term_id IS NULL;
```

## WordPress API Functions

- `get_term_meta( $term_id, $key, $single )` - Get meta value(s)
- `add_term_meta( $term_id, $key, $value, $unique )` - Add meta
- `update_term_meta( $term_id, $key, $value )` - Update meta
- `delete_term_meta( $term_id, $key, $value )` - Delete meta

## Example: Category Image

```php
// Save category image
update_term_meta( $term_id, 'category_image', $attachment_id );

// Get category image
$image_id = get_term_meta( $term_id, 'category_image', true );
if ( $image_id ) {
    echo wp_get_attachment_image( $image_id, 'medium' );
}
```

## History

Term meta was added in WordPress 4.4 (December 2015). Before that, plugins stored term data in:
- `wp_options` with serialized arrays
- Custom tables
- Taxonomy description field (hack)

The official term meta table made term extensions first-class citizens.

## Performance Notes

- Index on `meta_key` limited to 191 characters
- Multiple values per key are allowed
- Consider caching frequently accessed term meta
- Term queries with meta filters can be slow—index custom tables for high-volume use
