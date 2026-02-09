# comment.php

## Overview

Admin comment management helpers (moderation, edit screens, bulk actions).

## Functions

- `comment_exists()` — WordPress Comment Administration API.
- `edit_comment()` — Updates a comment with values provided in $_POST.
- `get_comment_to_edit()` — Returns a WP_Comment object based on comment ID.
- `get_pending_comments_num()` — Filters the comment content before editing.
- `floated_admin_avatar()` — Adds avatars to relevant places in admin.
- `enqueue_comment_hotkeys_js()` — Enqueues comment shortcuts jQuery script.
- `comment_footer_die()` — Displays error message at bottom of comments.
