# Media

## upload.php (Media Library)
- **URL:** `/wp-admin/upload.php`
- **Capability required:** `upload_files` (and `delete_post` for deleting attachments).
- **What it does:** Lists media items, handles bulk actions, and provides entry points to edit attachments.
- **Key hooks:** `handle_bulk_actions-{$screen}`.

## media.php (Deprecated media handler)
- **URL:** `/wp-admin/media.php`
- **Capability required:** None in file; defers to `upload.php` and will redirect.
- **What it does:** Deprecated action handler that redirects to `upload.php` for attachment editing.
- **Key hooks:** (none in file).

## media-new.php (Add New Media)
- **URL:** `/wp-admin/media-new.php`
- **Capability required:** `upload_files` (and `edit_post` if attaching to a post).
- **What it does:** Uploads new media (plupload or browser uploader) and redirects to the Media Library.
- **Key hooks:** (none in file; standard admin header/footer hooks apply).

## async-upload.php (Async upload handler)
- **URL:** `/wp-admin/async-upload.php`
- **Capability required:** `upload_files` (and `edit_post` when attaching to a post).
- **What it does:** Handles async uploads from Plupload or legacy uploaders, returns attachment HTML or ID.
- **Key hooks:** `async_upload_{$type}`.
