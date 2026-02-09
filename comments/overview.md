# Comments API

WordPress comment system for managing user discussions on posts and pages.

**Since:** 1.0.0  
**Source:** `wp-includes/comment.php`, `wp-includes/class-wp-comment.php`, `wp-includes/class-wp-comment-query.php`, `wp-includes/comment-template.php`

## Components

| Component | Description |
|-----------|-------------|
| [functions.md](./functions.md) | Core comment functions |
| [class-wp-comment.md](./class-wp-comment.md) | Comment object representation |
| [class-wp-comment-query.md](./class-wp-comment-query.md) | Comment query system |
| [hooks.md](./hooks.md) | Actions and filters |

## Comment System Overview

WordPress comments enable threaded discussions on posts and pages. The system supports:

- **Regular comments** - User-submitted responses to content
- **Pingbacks** - Automatic notifications when another blog links to your post
- **Trackbacks** - Manual notifications between blogs
- **Notes** - Internal comments (since 6.9.0) excluded from public counts

## Database Schema

Comments are stored in the `wp_comments` table:

| Column | Type | Description |
|--------|------|-------------|
| `comment_ID` | bigint(20) | Primary key |
| `comment_post_ID` | bigint(20) | Associated post ID |
| `comment_author` | tinytext | Author display name |
| `comment_author_email` | varchar(100) | Author email |
| `comment_author_url` | varchar(200) | Author website |
| `comment_author_IP` | varchar(100) | Author IP address |
| `comment_date` | datetime | Local time submitted |
| `comment_date_gmt` | datetime | GMT time submitted |
| `comment_content` | text | Comment body |
| `comment_karma` | int(11) | Karma score (rarely used) |
| `comment_approved` | varchar(20) | Status: 1, 0, spam, trash, post-trashed |
| `comment_agent` | varchar(255) | Browser user agent |
| `comment_type` | varchar(20) | Type: comment, pingback, trackback, note |
| `comment_parent` | bigint(20) | Parent comment ID for threading |
| `user_id` | bigint(20) | Registered user ID (0 for guests) |

Comment metadata is stored in `wp_commentmeta`.

## Comment Statuses

| Status | `comment_approved` Value | Description |
|--------|--------------------------|-------------|
| Approved | `1` | Visible on site |
| Pending/Hold | `0` | Awaiting moderation |
| Spam | `spam` | Marked as spam |
| Trash | `trash` | In trash |
| Post-trashed | `post-trashed` | Post is trashed |

## Comment Types

| Type | Description |
|------|-------------|
| `comment` | Regular user comment (default) |
| `pingback` | Automatic blog-to-blog notification |
| `trackback` | Manual blog-to-blog notification |
| `note` | Internal note (since 6.9.0), excluded from comment counts |

## Threading Model

Comments support hierarchical threading:

```
Comment (parent = 0)
├── Reply (parent = Comment ID)
│   └── Reply to reply (parent = Reply ID)
└── Another reply (parent = Comment ID)
```

Threading is controlled by:
- `thread_comments` option - Enable/disable threading
- `thread_comments_depth` option - Maximum nesting depth (default 5)

## Comment Flow

### Submission Flow

```
User submits form
    └── wp-comments-post.php
        └── wp_new_comment()
            ├── preprocess_comment filter
            ├── wp_allow_comment() - duplicate/flood checks
            ├── wp_filter_comment() - sanitization
            ├── wp_check_comment_data() - approval decision
            ├── wp_insert_comment() - database insert
            └── comment_post action
```

### Approval Decision

```
wp_allow_comment()
    ├── Check for duplicates
    ├── Check for flooding
    └── wp_check_comment_data()
        ├── check_comment() - moderation keywords, links
        ├── wp_check_comment_disallowed_list() - blocklist
        └── pre_comment_approved filter
```

## Moderation System

### Automatic Moderation

Comments are held for moderation when:
- `comment_moderation` option is enabled (all comments moderated)
- Comment contains more links than `comment_max_links` allows
- Comment matches words in `moderation_keys` option
- Author has no previously approved comments (if `comment_previously_approved` enabled)

### Blocklist/Disallowed Words

Comments matching `disallowed_keys` are automatically marked as:
- `spam` if `EMPTY_TRASH_DAYS` is 0
- `trash` if trash is enabled

## Caching

Comments use WordPress object cache:

| Cache Group | Keys | Description |
|-------------|------|-------------|
| `comment` | Comment ID | Individual comment objects |
| `comment-queries` | Query hash | Query result sets |
| `counts` | `comments-{post_id}` | Comment counts |
| `timeinfo` | `lastcommentmodified:*` | Last modified timestamps |

## Comment Pagination

Pagination is controlled by:
- `page_comments` option - Enable pagination
- `comments_per_page` option - Comments per page
- `default_comments_page` option - Show `newest` or `oldest` first
- `cpage` query var - Current comment page

## Security Considerations

### Validation
- Author name: 245 characters max
- Email: 100 characters max
- URL: 200 characters max
- Content: 65525 characters max

### Sanitization
- All fields filtered via `pre_comment_*` filters
- Content filtered via `pre_comment_content`
- HTML filtered based on user capabilities (`unfiltered_html`)

### Flood Protection
- `wp_check_comment_flood()` prevents rapid submissions
- Configurable via `comment_flood_filter` filter
- Admins/moderators bypass flood checks

## Cookie Handling

Commenter info stored in cookies:
- `comment_author_{COOKIEHASH}`
- `comment_author_email_{COOKIEHASH}`
- `comment_author_url_{COOKIEHASH}`

Consent tracked via `wp-comment-cookies-consent` checkbox when `show_comments_cookies_opt_in` is enabled.

## Related Options

| Option | Default | Description |
|--------|---------|-------------|
| `comment_moderation` | 0 | Hold all comments for moderation |
| `comment_previously_approved` | 1 | Comment author must have prior approval |
| `comment_max_links` | 2 | Max links before moderation hold |
| `moderation_keys` | '' | Words triggering moderation |
| `disallowed_keys` | '' | Words triggering spam/trash |
| `comments_notify` | 1 | Email post author on new comment |
| `moderation_notify` | 1 | Email on comments needing moderation |
| `require_name_email` | 1 | Require name and email |
| `comment_registration` | 0 | Require login to comment |
| `close_comments_for_old_posts` | 0 | Auto-close comments |
| `close_comments_days_old` | 14 | Days until comments close |
