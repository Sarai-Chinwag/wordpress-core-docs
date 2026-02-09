# wp_term_relationships

Junction table linking posts (objects) to terms. Implements the many-to-many relationship between content and taxonomies.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `object_id` | bigint(20) unsigned | NO | 0 | Post ID (FK → wp_posts.ID) |
| `term_taxonomy_id` | bigint(20) unsigned | NO | 0 | Term taxonomy ID (FK → wp_term_taxonomy) |
| `term_order` | int(11) | NO | 0 | Term display order for this object |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | object_id, term_taxonomy_id | Yes | Composite primary key |
| `term_taxonomy_id` | term_taxonomy_id | No | Lookup by term |

## Foreign Key Relationships

- `object_id` → `wp_posts.ID` (typically, can be any object type)
- `term_taxonomy_id` → `wp_term_taxonomy.term_taxonomy_id`

## Design Notes

The `object_id` column usually references `wp_posts.ID`, but the taxonomy system is designed to be flexible:
- Links can be created for any integer object ID
- Custom implementations can link terms to users, comments, or custom tables

## Common Queries

### Get terms for a post
```sql
SELECT t.name, t.slug, tt.taxonomy
FROM wp_term_relationships tr
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE tr.object_id = 123;
```

### Get categories for a post
```sql
SELECT t.term_id, t.name, t.slug
FROM wp_term_relationships tr
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE tr.object_id = 123
  AND tt.taxonomy = 'category';
```

### Get posts in a category
```sql
SELECT p.*
FROM wp_posts p
JOIN wp_term_relationships tr ON p.ID = tr.object_id
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE t.slug = 'technology'
  AND tt.taxonomy = 'category'
  AND p.post_status = 'publish'
  AND p.post_type = 'post'
ORDER BY p.post_date DESC;
```

### Get posts with multiple terms (AND)
```sql
SELECT p.ID, p.post_title
FROM wp_posts p
WHERE p.post_status = 'publish'
  AND EXISTS (
    SELECT 1 FROM wp_term_relationships tr
    JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN wp_terms t ON tt.term_id = t.term_id
    WHERE tr.object_id = p.ID 
      AND t.slug = 'featured'
      AND tt.taxonomy = 'post_tag'
  )
  AND EXISTS (
    SELECT 1 FROM wp_term_relationships tr
    JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN wp_terms t ON tt.term_id = t.term_id
    WHERE tr.object_id = p.ID 
      AND t.slug = 'news'
      AND tt.taxonomy = 'category'
  );
```

### Get posts with any of multiple terms (OR)
```sql
SELECT DISTINCT p.*
FROM wp_posts p
JOIN wp_term_relationships tr ON p.ID = tr.object_id
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE t.slug IN ('news', 'featured', 'popular')
  AND tt.taxonomy IN ('category', 'post_tag')
  AND p.post_status = 'publish';
```

### Get related posts (share terms)
```sql
SELECT p.ID, p.post_title, COUNT(*) as shared_terms
FROM wp_posts p
JOIN wp_term_relationships tr ON p.ID = tr.object_id
WHERE tr.term_taxonomy_id IN (
  SELECT term_taxonomy_id 
  FROM wp_term_relationships 
  WHERE object_id = 123
)
AND p.ID != 123
AND p.post_status = 'publish'
AND p.post_type = 'post'
GROUP BY p.ID
ORDER BY shared_terms DESC
LIMIT 5;
```

### Delete orphaned relationships
```sql
-- Orphaned from posts
DELETE tr FROM wp_term_relationships tr
LEFT JOIN wp_posts p ON tr.object_id = p.ID
WHERE p.ID IS NULL;

-- Orphaned from terms
DELETE tr FROM wp_term_relationships tr
LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
WHERE tt.term_taxonomy_id IS NULL;
```

## WordPress API Functions

- `wp_get_object_terms( $object_ids, $taxonomies )` - Get terms for objects
- `wp_set_object_terms( $object_id, $terms, $taxonomy )` - Set object terms
- `wp_add_object_terms( $object_id, $terms, $taxonomy )` - Add terms to object
- `wp_remove_object_terms( $object_id, $terms, $taxonomy )` - Remove terms
- `is_object_in_term( $object_id, $taxonomy, $terms )` - Check if object has term

## Performance Notes

- No index on `object_id` alone—compound primary key starts with it
- Queries by `term_taxonomy_id` alone use the dedicated index
- For large sites, consider adding an index on `object_id` if querying frequently
