# wp_term_taxonomy

Links terms to their taxonomies and stores taxonomy-specific data. Each term can appear in multiple taxonomies.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `term_taxonomy_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `term_id` | bigint(20) unsigned | NO | 0 | Term ID (FK → wp_terms.term_id) |
| `taxonomy` | varchar(32) | NO | '' | Taxonomy name (category, post_tag, etc.) |
| `description` | longtext | NO | NULL | Term description |
| `parent` | bigint(20) unsigned | NO | 0 | Parent term_taxonomy_id (for hierarchical) |
| `count` | bigint(20) | NO | 0 | Cached count of associated objects |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | term_taxonomy_id | Yes | Primary key |
| `term_id_taxonomy` | term_id, taxonomy | Yes | Unique constraint |
| `taxonomy` | taxonomy | No | Filter by taxonomy |

## Foreign Key Relationships

- `term_id` → `wp_terms.term_id`
- `parent` → `wp_term_taxonomy.term_taxonomy_id` (self-referential)

Referenced by:
- `wp_term_relationships.term_taxonomy_id` → `wp_term_taxonomy.term_taxonomy_id`

## Built-in Taxonomies

| Taxonomy | Description | Hierarchical |
|----------|-------------|--------------|
| `category` | Post categories | Yes |
| `post_tag` | Post tags | No |
| `nav_menu` | Navigation menus | No |
| `link_category` | Link categories (legacy) | No |
| `post_format` | Post formats | No |

Custom taxonomies are registered via `register_taxonomy()`.

## Common Queries

### Get all terms for a taxonomy
```sql
SELECT t.*, tt.description, tt.count 
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
WHERE tt.taxonomy = 'category'
ORDER BY t.name;
```

### Get taxonomy counts
```sql
SELECT taxonomy, COUNT(*) as term_count 
FROM wp_term_taxonomy 
GROUP BY taxonomy 
ORDER BY term_count DESC;
```

### Get hierarchical terms (categories with parents)
```sql
SELECT t.name, t.slug, tt.term_taxonomy_id, 
       tt.parent, p.name as parent_name
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
LEFT JOIN wp_term_taxonomy ptt ON tt.parent = ptt.term_taxonomy_id
LEFT JOIN wp_terms p ON ptt.term_id = p.term_id
WHERE tt.taxonomy = 'category'
ORDER BY tt.parent, t.name;
```

### Get term with post count
```sql
SELECT t.name, t.slug, tt.count
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
WHERE tt.taxonomy = 'post_tag'
  AND tt.count > 0
ORDER BY tt.count DESC
LIMIT 20;
```

### Get child terms
```sql
SELECT t.*, tt.term_taxonomy_id
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
WHERE tt.parent = 5
  AND tt.taxonomy = 'category';
```

### Get full term path (breadcrumb)
```sql
-- Recursive CTE for term ancestry
WITH RECURSIVE term_path AS (
  SELECT tt.term_taxonomy_id, tt.parent, t.name, t.slug, 1 as depth
  FROM wp_term_taxonomy tt
  JOIN wp_terms t ON tt.term_id = t.term_id
  WHERE tt.term_taxonomy_id = 10
  
  UNION ALL
  
  SELECT ptt.term_taxonomy_id, ptt.parent, pt.name, pt.slug, tp.depth + 1
  FROM term_path tp
  JOIN wp_term_taxonomy ptt ON tp.parent = ptt.term_taxonomy_id
  JOIN wp_terms pt ON ptt.term_id = pt.term_id
)
SELECT * FROM term_path ORDER BY depth DESC;
```

## Count Maintenance

The `count` column is a cached value. WordPress updates it when:
- Posts are added/removed from terms
- Posts change status (publish/unpublish)

To manually recount:
```php
wp_update_term_count( $term_taxonomy_ids, $taxonomy );
```

Or via SQL:
```sql
UPDATE wp_term_taxonomy tt
SET count = (
  SELECT COUNT(*) 
  FROM wp_term_relationships tr
  JOIN wp_posts p ON tr.object_id = p.ID
  WHERE tr.term_taxonomy_id = tt.term_taxonomy_id
    AND p.post_status = 'publish'
    AND p.post_type IN ('post', 'page')
)
WHERE tt.taxonomy = 'category';
```

## WordPress API Functions

- `get_term( $term, $taxonomy )` - Returns term with taxonomy data
- `get_term_children( $term_id, $taxonomy )` - Get child term IDs
- `get_ancestors( $term_id, $taxonomy )` - Get ancestor term IDs
- `wp_count_terms( $taxonomy )` - Count terms in taxonomy
