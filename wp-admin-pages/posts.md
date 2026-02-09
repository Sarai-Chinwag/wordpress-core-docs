# Posts (Post Type: post)

## edit.php (Posts list)
- **URL:** `/wp-admin/edit.php`
- **Capability required:** `$post_type_object->cap->edit_posts` (typically `edit_posts`).
- **What it does:** Lists posts for the `post` post type, handles bulk actions (trash, delete, edit), and surfaces filters/search for the list table.
- **Key hooks:** `handle_bulk_actions-{$screen}`, `bulk_post_updated_messages`.

## post.php (Edit existing post)
- **URL:** `/wp-admin/post.php?post={ID}&action=edit`
- **Capability required:** `edit_post` (and action-specific caps like `delete_post`).
- **What it does:** Handles actions for existing posts (edit, update, trash/delete, restore). Dispatches `post_action_*` requests.
- **Key hooks:** `post_action_{$action}`, `replace_editor`.

## post-new.php (Add new post)
- **URL:** `/wp-admin/post-new.php`
- **Capability required:** `$post_type_object->cap->edit_posts` and `$post_type_object->cap->create_posts` (typically `edit_posts`/`create_posts`).
- **What it does:** Initializes a new post, loads the editor, and routes through the block/classic editor selection.
- **Key hooks:** `replace_editor`.

## edit-form-advanced.php (Classic editor form)
- **URL:** Included by `post.php`/`post-new.php` when using the classic editor.
- **Capability required:** Same as the parent screen (edit/create posts).
- **What it does:** Renders the classic editor form, meta boxes, publish box, and the post edit layout.
- **Key hooks:** `edit_form_top`, `edit_form_before_permalink`, `edit_form_after_title`, `edit_form_after_editor`, `edit_form_advanced`, `edit_page_form`, `dbx_post_sidebar`, `post_edit_form_tag`, `post_updated_messages`, `submitpost_box`, `submitpage_box`, `enter_title_here`, `wp_editor_expand`.

## edit-form-blocks.php (Block editor bootstrap)
- **URL:** Included by `post.php`/`post-new.php` when using the block editor.
- **Capability required:** Same as the parent screen (edit/create posts). May check `edit_theme_options` to set global styles context.
- **What it does:** Bootstraps the block editor, passes boot data, and loads editor scripts/styles.
- **Key hooks:** `enqueue_block_editor_assets`, `enter_title_here`, `block_editor_no_javascript_message`, `default_page_template_title`, `show_post_locked_dialog`, `write_your_story`.

## revision.php (Revision viewer)
- **URL:** `/wp-admin/revision.php?revision={ID}`
- **Capability required:** `edit_post` for the parent post, `read_post` for the revision.
- **What it does:** Displays revision comparisons for a post and controls navigation between revisions.
- **Key hooks:** (none in file; standard `load-revision.php`/admin hooks apply via `admin.php`).
