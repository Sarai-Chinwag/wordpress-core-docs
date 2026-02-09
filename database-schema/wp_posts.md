# wp_posts

The central content table storing all WordPress content including posts, pages, attachments, revisions, and custom post types.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `ID` | bigint(20) unsigned | NO | auto_increment | Unique identifier for the post |
| `post_author` | bigint(20) unsigned | NO | 0 | User ID of the post author (FK → wp_users.ID) |
| `post_date` | datetime | NO | 0000-00-00 00:00:00 | Post creation date in local time |
| `post_date_gmt` | datetime | NO | 0000-00-00 00:00:00 | Post creation date in GMT |
| `post_content` | longtext | NO | NULL | Full post content (HTML/blocks) |
| `post_title` | text | NO | NULL | Post title |
| `post_excerpt` | text | NO | NULL | Post excerpt/summary |
| `post_status` | varchar(20) | NO | publish | Status: publish, draft, pending, private, trash, auto-draft, inherit |
| `comment_status` | varchar(20) | NO | open | Whether comments allowed: open, closed |
| `ping_status` | varchar(20) | NO | open | Whether pings allowed: open, closed |
| `post_password` | varchar(255) | NO | '' | Password for protected posts |
| `post_name` | varchar(200) | NO | '' | URL slug |
| `to_ping` | text | NO | NULL | URLs to ping |
| `pinged` | text | NO | NULL | URLs already pinged |
| `post_modified` | datetime | NO | 0000-00-00 00:00:00 | Last modification date (local) |
| `post_modified_gmt` | datetime | NO | 0000-00-00 00:00:00 | Last modification date (GMT) |
| `post_content_filtered` | longtext | NO | NULL | Filtered/processed content cache |
| `post_parent` | bigint(20) unsigned | NO | 0 | Parent post ID (FK → wp_posts.ID) |
| `guid` | varchar(255) | NO | '' | Global Unique ID (permalink) |
| `menu_order` | int(11) | NO | 0 | Order for pages/menu items |
| `post_type` | varchar(20) | NO | post | Content type: post, page, attachment, revision, nav_menu_item, or custom |
| `post_mime_type` | varchar(100) | NO | '' | MIME type for attachments |
| `comment_count` | bigint(20) | NO | 0 | Cached comment count |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | ID | Yes | Primary key |
| `post_name` | post_name(191) | No | URL slug lookups |
| `type_status_date` | post_type, post_status, post_date, ID | No | Main query index |
| `post_parent` | post_parent | No | Child post queries |
| `post_author` | post_author | No | Author archives |
| `type_status_author` | post_type, post_status, post_author | No | Author + type queries |

## Foreign Key Relationships

- `post_author` → `wp_users.ID` (author of the post)
- `post_parent` → `wp_posts.ID` (self-referential for hierarchical content)

## Post Types Stored

| Type | Description |
|------|-------------|
| `post` | Blog posts |
| `page` | Static pages |
| `attachment` | Media library items |
| `revision` | Post/page revisions |
| `nav_menu_item` | Navigation menu items |
| `custom_css` | Customizer CSS |
| `wp_navigation` | Block-based navigation menus |
| Custom types | Registered via `register_post_type()` |

## Post Statuses

| Status | Description |
|--------|-------------|
| `publish` | Published and visible |
| `draft` | Not published, visible to author |
| `pending` | Awaiting review |
| `private` | Visible only to logged-in users with permission |
| `trash` | In trash |
| `auto-draft` | Auto-saved draft |
| `inherit` | Used by attachments/revisions (inherits parent status) |
| `future` | Scheduled for future publication |

## Common Queries

### Get published posts
```sql
SELECT * FROM wp_posts 
WHERE post_type = 'post' 
  AND post_status = 'publish' 
ORDER BY post_date DESC 
LIMIT 10;
```

### Get post with author info
```sql
SELECT p.*, u.display_name, u.user_email 
FROM wp_posts p
JOIN wp_users u ON p.post_author = u.ID
WHERE p.ID = 123;
```

### Get post by slug
```sql
SELECT * FROM wp_posts 
WHERE post_name = 'my-post-slug' 
  AND post_type = 'post'
  AND post_status = 'publish';
```

### Get child posts (attachments)
```sql
SELECT * FROM wp_posts 
WHERE post_parent = 123 
  AND post_type = 'attachment';
```

### Count posts by type and status
```sql
SELECT post_type, post_status, COUNT(*) as count 
FROM wp_posts 
GROUP BY post_type, post_status 
ORDER BY count DESC;
```

### Get revisions for a post
```sql
SELECT * FROM wp_posts 
WHERE post_parent = 123 
  AND post_type = 'revision' 
ORDER BY post_modified DESC;
```

## WordPress API Functions

- `get_post()` - Retrieve post by ID
- `get_posts()` - Get posts matching criteria
- `WP_Query` - Full query class
- `wp_insert_post()` - Insert new post
- `wp_update_post()` - Update existing post
- `wp_delete_post()` - Delete post
- `get_post_field()` - Get specific field value
