# wp_terms

Stores the basic term data (name and slug) for categories, tags, and custom taxonomies.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `term_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier for the term |
| `name` | varchar(200) | NO | '' | Human-readable term name |
| `slug` | varchar(200) | NO | '' | URL-friendly slug |
| `term_group` | bigint(10) | NO | 0 | Group ID for term aliases (rarely used) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | term_id | Yes | Primary key |
| `slug` | slug(191) | No | URL slug lookups |
| `name` | name(191) | No | Name searches |

## Foreign Key Relationships

Referenced by:
- `wp_term_taxonomy.term_id` → `wp_terms.term_id`
- `wp_termmeta.term_id` → `wp_terms.term_id`

## Design Notes

WordPress separates term data from taxonomy assignments:

1. **wp_terms** - The term itself (name, slug)
2. **wp_term_taxonomy** - Which taxonomy it belongs to
3. **wp_term_relationships** - Links to posts/objects

This allows the same term name to exist in different taxonomies (e.g., "News" category and "News" tag are separate).

## Common Queries

### Get all terms
```sql
SELECT * FROM wp_terms ORDER BY name;
```

### Get term by slug
```sql
SELECT * FROM wp_terms WHERE slug = 'my-category';
```

### Get term by ID
```sql
SELECT * FROM wp_terms WHERE term_id = 5;
```

### Search terms by name
```sql
SELECT * FROM wp_terms 
WHERE name LIKE '%nature%' 
ORDER BY name;
```

### Get terms with their taxonomy
```sql
SELECT t.*, tt.taxonomy, tt.count 
FROM wp_terms t
JOIN wp_term_taxonomy tt ON t.term_id = tt.term_id
ORDER BY t.name;
```

### Find duplicate slugs
```sql
SELECT slug, COUNT(*) as count 
FROM wp_terms 
GROUP BY slug 
HAVING count > 1;
```

## WordPress API Functions

- `get_term( $term_id, $taxonomy )` - Get single term
- `get_terms( $args )` - Get terms matching criteria
- `get_term_by( $field, $value, $taxonomy )` - Get term by field
- `wp_insert_term( $name, $taxonomy, $args )` - Create term
- `wp_update_term( $term_id, $taxonomy, $args )` - Update term
- `wp_delete_term( $term_id, $taxonomy )` - Delete term
- `term_exists( $term, $taxonomy )` - Check if term exists

## Term Groups

The `term_group` column was intended for term aliases (same meaning, different words). In practice, this feature is rarely used. Most implementations use:
- Custom meta for synonyms
- Plugins for term merging
- Parent/child hierarchies instead
