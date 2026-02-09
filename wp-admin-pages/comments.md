# Comments

## edit-comments.php
- **URL:** `/wp-admin/edit-comments.php`
- **Capability required:** `edit_posts` (and `edit_comment` for specific comment actions).
- **What it does:** Lists comments for moderation, with bulk actions and filters.
- **Key hooks:** `handle_bulk_actions-{$screen}`.

## comment.php
- **URL:** `/wp-admin/comment.php?action=editcomment&c={COMMENT_ID}` (action varies)
- **Capability required:** `edit_comment` for the target comment; may check `edit_post` for the parent post.
- **What it does:** Handles comment actions (edit, approve, unapprove, spam, trash, delete).
- **Key hooks:** `comment_edit_redirect`.
