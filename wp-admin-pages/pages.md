# Pages (Post Type: page)

Pages use the same core files as posts, with `post_type=page` in the URL and page-specific capabilities.

## edit.php (Pages list)
- **URL:** `/wp-admin/edit.php?post_type=page`
- **Capability required:** `$post_type_object->cap->edit_posts` for pages (typically `edit_pages`).
- **What it does:** Lists pages with filters and bulk actions.
- **Key hooks:** `handle_bulk_actions-{$screen}`, `bulk_post_updated_messages`.

## post.php (Edit existing page)
- **URL:** `/wp-admin/post.php?post={ID}&action=edit&post_type=page`
- **Capability required:** `edit_post` mapped to page caps (typically `edit_page`).
- **What it does:** Handles edit/update/trash/restore for pages.
- **Key hooks:** `post_action_{$action}`, `replace_editor`.

## post-new.php (Add new page)
- **URL:** `/wp-admin/post-new.php?post_type=page`
- **Capability required:** `$post_type_object->cap->edit_posts` and `$post_type_object->cap->create_posts` for pages (typically `edit_pages`/`create_pages`).
- **What it does:** Initializes a new page and launches the editor.
- **Key hooks:** `replace_editor`.

## edit-form-advanced.php (Classic editor form)
- **URL:** Included by `post.php`/`post-new.php` when the classic editor is used for pages.
- **Capability required:** Same as the parent screen.
- **What it does:** Renders the classic page editor form, meta boxes, and publish box.
- **Key hooks:** `edit_form_top`, `edit_form_before_permalink`, `edit_form_after_title`, `edit_form_after_editor`, `edit_form_advanced`, `edit_page_form`, `dbx_post_sidebar`, `post_edit_form_tag`, `post_updated_messages`, `submitpost_box`, `submitpage_box`, `enter_title_here`, `wp_editor_expand`.

## edit-form-blocks.php (Block editor bootstrap)
- **URL:** Included by `post.php`/`post-new.php` when the block editor is used for pages.
- **Capability required:** Same as the parent screen.
- **What it does:** Bootstraps the block editor for pages.
- **Key hooks:** `enqueue_block_editor_assets`, `enter_title_here`, `block_editor_no_javascript_message`, `default_page_template_title`, `show_post_locked_dialog`, `write_your_story`.

## revision.php (Revision viewer)
- **URL:** `/wp-admin/revision.php?revision={ID}`
- **Capability required:** `edit_post` for the parent page, `read_post` for the revision.
- **What it does:** Displays page revision comparisons.
- **Key hooks:** (none in file; standard `load-revision.php`/admin hooks apply via `admin.php`).
