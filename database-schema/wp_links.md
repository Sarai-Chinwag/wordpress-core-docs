# wp_links

Legacy blogroll/links table. Deprecated since WordPress 3.5 (2012) but still present for backward compatibility.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `link_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `link_url` | varchar(255) | NO | '' | Link URL |
| `link_name` | varchar(255) | NO | '' | Link title/name |
| `link_image` | varchar(255) | NO | '' | Image URL for link |
| `link_target` | varchar(25) | NO | '' | Target: _blank, _top, etc. |
| `link_description` | varchar(255) | NO | '' | Short description |
| `link_visible` | varchar(20) | NO | 'Y' | Visibility: Y or N |
| `link_owner` | bigint(20) unsigned | NO | 1 | User ID who created link |
| `link_rating` | int(11) | NO | 0 | Rating (0-10) |
| `link_updated` | datetime | NO | 0000-00-00 00:00:00 | Last update timestamp |
| `link_rel` | varchar(255) | NO | '' | Relationship (XFN values) |
| `link_notes` | mediumtext | NO | NULL | Private notes |
| `link_rss` | varchar(255) | NO | '' | RSS feed URL |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | link_id | Yes | Primary key |
| `link_visible` | link_visible | No | Filter visible links |

## Foreign Key Relationships

- `link_owner` → `wp_users.ID`

Links can be categorized using the taxonomy system:
- `wp_term_relationships.object_id` = `wp_links.link_id`
- Taxonomy: `link_category`

## Deprecation Status

The Links Manager was hidden in WordPress 3.5 (December 2012):
- UI removed from core
- Table still created for new installations
- API functions still work
- **Link Manager plugin** can restore the UI

## Common Queries

### Get all visible links
```sql
SELECT * FROM wp_links 
WHERE link_visible = 'Y' 
ORDER BY link_name;
```

### Get links with categories
```sql
SELECT l.*, t.name as category
FROM wp_links l
JOIN wp_term_relationships tr ON l.link_id = tr.object_id
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE tt.taxonomy = 'link_category'
  AND l.link_visible = 'Y'
ORDER BY t.name, l.link_name;
```

### Get links by category
```sql
SELECT l.*
FROM wp_links l
JOIN wp_term_relationships tr ON l.link_id = tr.object_id
JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
JOIN wp_terms t ON tt.term_id = t.term_id
WHERE t.slug = 'blogroll'
  AND tt.taxonomy = 'link_category'
  AND l.link_visible = 'Y';
```

## WordPress API Functions

These functions still work but may require the Link Manager plugin for UI:

- `get_bookmarks( $args )` - Get links/bookmarks
- `wp_insert_link( $linkdata )` - Insert link
- `wp_update_link( $linkdata )` - Update link
- `wp_delete_link( $link_id )` - Delete link
- `get_bookmark( $link_id )` - Get single link

## XFN Relationships

The `link_rel` column supports XFN (XHTML Friends Network) values:

| Value | Meaning |
|-------|---------|
| `friend` | Friend |
| `acquaintance` | Acquaintance |
| `contact` | Contact |
| `met` | Have met in person |
| `co-worker` | Co-worker |
| `colleague` | Colleague |
| `co-resident` | Co-resident |
| `neighbor` | Neighbor |
| `child` | Child |
| `parent` | Parent |
| `sibling` | Sibling |
| `spouse` | Spouse |
| `kin` | Family |
| `muse` | Muse |
| `crush` | Crush |
| `date` | Date |
| `sweetheart` | Sweetheart |
| `me` | Another site of mine |

Multiple values can be space-separated.

## Migration Alternatives

For modern link collections, consider:
- Custom post type for links
- Navigation menus
- Block pattern with link blocks
- Third-party bookmark plugins

## Removal

If not using links, the table can be safely ignored. To remove:
```sql
-- Only if you're sure you don't need it
DROP TABLE IF EXISTS wp_links;
```

Note: This is generally not recommended as it may confuse future debugging.
