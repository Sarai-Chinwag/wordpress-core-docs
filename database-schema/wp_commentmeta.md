# wp_commentmeta

Key-value storage for comment metadata. Extends comments with custom data.

## Schema

| Column | Type | Null | Default | Description |
|--------|------|------|---------|-------------|
| `meta_id` | bigint(20) unsigned | NO | auto_increment | Unique identifier |
| `comment_id` | bigint(20) unsigned | NO | 0 | Comment ID (FK → wp_comments.comment_ID) |
| `meta_key` | varchar(255) | YES | NULL | Meta key name |
| `meta_value` | longtext | YES | NULL | Meta value (can be serialized) |

## Indexes

| Key Name | Columns | Unique | Purpose |
|----------|---------|--------|---------|
| `PRIMARY` | meta_id | Yes | Primary key |
| `comment_id` | comment_id | No | All meta for a comment |
| `meta_key` | meta_key(191) | No | Lookup by key name |

## Foreign Key Relationships

- `comment_id` → `wp_comments.comment_ID`

## Common Use Cases

Comment meta is used for:
- **Spam scores** - Akismet confidence levels
- **Ratings** - Star ratings attached to comments
- **Voting** - Upvotes/downvotes
- **Moderation flags** - Reports, review notes
- **Plugin data** - Subscription preferences, notification settings

## Common Meta Keys

| Key | Plugin/Core | Description |
|-----|-------------|-------------|
| `akismet_result` | Akismet | Spam check result |
| `akismet_history` | Akismet | Moderation history |
| `rating` | Custom | Star rating (1-5) |
| `verified_buyer` | WooCommerce | Verified purchase flag |

## Common Queries

### Get all meta for a comment
```sql
SELECT meta_key, meta_value 
FROM wp_commentmeta 
WHERE comment_id = 456;
```

### Get specific meta value
```sql
SELECT meta_value 
FROM wp_commentmeta 
WHERE comment_id = 456 
  AND meta_key = 'rating';
```

### Get comments with ratings
```sql
SELECT c.*, cm.meta_value as rating
FROM wp_comments c
JOIN wp_commentmeta cm ON c.comment_ID = cm.comment_id
WHERE cm.meta_key = 'rating'
  AND c.comment_approved = '1'
ORDER BY CAST(cm.meta_value AS SIGNED) DESC;
```

### Calculate average rating for a post
```sql
SELECT 
  c.comment_post_ID,
  AVG(CAST(cm.meta_value AS DECIMAL)) as avg_rating,
  COUNT(*) as review_count
FROM wp_comments c
JOIN wp_commentmeta cm ON c.comment_ID = cm.comment_id
WHERE cm.meta_key = 'rating'
  AND c.comment_approved = '1'
GROUP BY c.comment_post_ID;
```

### Delete orphaned commentmeta
```sql
DELETE cm FROM wp_commentmeta cm
LEFT JOIN wp_comments c ON cm.comment_id = c.comment_ID
WHERE c.comment_ID IS NULL;
```

## WordPress API Functions

- `get_comment_meta( $comment_id, $key, $single )` - Get meta value(s)
- `add_comment_meta( $comment_id, $key, $value, $unique )` - Add meta
- `update_comment_meta( $comment_id, $key, $value )` - Update meta
- `delete_comment_meta( $comment_id, $key, $value )` - Delete meta

## Example: Comment Ratings

```php
// Save rating with comment
add_action( 'comment_post', function( $comment_id ) {
    if ( isset( $_POST['rating'] ) ) {
        $rating = intval( $_POST['rating'] );
        if ( $rating >= 1 && $rating <= 5 ) {
            add_comment_meta( $comment_id, 'rating', $rating, true );
        }
    }
});

// Display rating
$rating = get_comment_meta( $comment_id, 'rating', true );
if ( $rating ) {
    echo str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating );
}
```

## Performance Notes

- Comment meta table is often small compared to postmeta
- Spam comments can accumulate meta from anti-spam plugins
- Clean orphaned meta when bulk-deleting spam
