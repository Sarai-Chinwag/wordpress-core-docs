# wp_comments

Stores comments and other comment-like content (pingbacks, trackbacks).

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `comment_ID` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `comment_post_ID` | bigint(20) unsigned | NO | 0 | Post ID (FK → wp_posts.ID) |
| `comment_author` | tinytext | NO | NULL | Author display name |
| `comment_author_email` | varchar(100) | NO | '' | Author email address |
| `comment_author_url` | varchar(200) | NO | '' | Author website URL |
| `comment_author_IP` | varchar(100) | NO | '' | Author IP address |
| `comment_date` | datetime | NO | 0000-00-00 00:00:00 | Comment date (local) |
| `comment_date_gmt` | datetime | NO | 0000-00-00 00:00:00 | Comment date (GMT) |
| `comment_content` | text | NO | NULL | Comment text |
| `comment_karma` | int(11) | NO | 0 | Rating/karma score |
| `comment_approved` | varchar(20) | NO | '1' | Status: 1, 0, spam, trash |
| `comment_agent` | varchar(255) | NO | '' | User agent string |
| `comment_type` | varchar(20) | NO | 'comment' | Type: comment, pingback, trackback |
| `comment_parent` | bigint(20) unsigned | NO | 0 | Parent comment ID (for threading) |
| `user_id` | bigint(20) unsigned | NO | 0 | User ID if logged in (FK → wp_users.ID) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | comment_ID | Yes | Primary key |
| `comment_post_ID` | comment_post_ID | No | Comments for a post |
| `comment_approved_date_gmt` | comment_approved, comment_date_gmt | No | Approved comments sorted by date |
| `comment_date_gmt` | comment_date_gmt | No | Global date ordering |
| `comment_parent` | comment_parent | No | Thread replies |
| `comment_author_email` | comment_author_email(10) | No | Lookup by email |

## Foreign Key Relationships

- `comment_post_ID` → `wp_posts.ID`
- `comment_parent` → `wp_comments.comment_ID` (self-referential)
- `user_id` → `wp_users.ID` (optional, 0 for guests)

Referenced by:
- `wp_commentmeta.comment_id` → `wp_comments.comment_ID`

## Comment Status Values

| Value | Description |
|-------|-------------|
| `1` | Approved |
| `0` | Pending moderation |
| `spam` | Marked as spam |
| `trash` | In trash |
| `post-trashed` | Comment's post is trashed |

## Comment Types

| Type | Description |
|------|-------------|
| `comment` | Standard comment (or empty string) |
| `pingback` | Automated pingback |
| `trackback` | Manual trackback |
| Custom types | Via plugins (e.g., reviews) |

## Common Queries

### Get approved comments for a post
```sql
SELECT * FROM wp_comments 
WHERE comment_post_ID = 123 
  AND comment_approved = '1'
ORDER BY comment_date ASC;
```

### Get threaded comments
```sql
SELECT * FROM wp_comments 
WHERE comment_post_ID = 123 
  AND comment_approved = '1'
ORDER BY comment_parent ASC, comment_date ASC;
```

### Get comment with author info
```sql
SELECT c.*, u.display_name as user_display_name
FROM wp_comments c
LEFT JOIN wp_users u ON c.user_id = u.ID
WHERE c.comment_ID = 456;
```

### Get recent comments
```sql
SELECT c.*, p.post_title
FROM wp_comments c
JOIN wp_posts p ON c.comment_post_ID = p.ID
WHERE c.comment_approved = '1'
  AND c.comment_type = 'comment'
ORDER BY c.comment_date_gmt DESC
LIMIT 10;
```

### Count comments by status
```sql
SELECT 
  comment_approved,
  COUNT(*) as count
FROM wp_comments
GROUP BY comment_approved;
```

### Get comments from specific user
```sql
SELECT c.*, p.post_title
FROM wp_comments c
JOIN wp_posts p ON c.comment_post_ID = p.ID
WHERE c.user_id = 1
ORDER BY c.comment_date DESC;
```

### Find spam patterns
```sql
SELECT comment_author_email, COUNT(*) as count
FROM wp_comments
WHERE comment_approved = 'spam'
GROUP BY comment_author_email
ORDER BY count DESC
LIMIT 20;
```

### Delete old spam
```sql
DELETE FROM wp_comments 
WHERE comment_approved = 'spam' 
  AND comment_date < DATE_SUB(NOW(), INTERVAL 30 DAY);
```

## WordPress API Functions

- `get_comment( $comment_id )` - Get single comment
- `get_comments( $args )` - Get comments matching criteria
- `wp_insert_comment( $commentdata )` - Insert comment
- `wp_update_comment( $commentarr )` - Update comment
- `wp_delete_comment( $comment_id )` - Delete comment
- `wp_set_comment_status( $comment_id, $status )` - Change status
- `get_comment_count( $post_id )` - Count comments for post

## Privacy/GDPR Notes

Comments store PII:
- IP addresses (`comment_author_IP`)
- Email addresses (`comment_author_email`)
- User agents (`comment_agent`)

Consider:
- Anonymizing old comments
- Providing data export/deletion for commenters
- Cookie consent for comment forms
