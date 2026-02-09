# Admin Functions (admin.php)

`wp-admin/includes/admin.php` is the core loader for WordPress admin APIs. It does not define many public functions itself; instead it *loads* the admin-only APIs that developers use in the dashboard. This file is the primary entry point for admin functionality.

## Purpose

- Ensures admin localization is loaded when included outside `wp-admin/admin.php`.
- Requires all admin-only API modules (comments, plugins, themes, media, files, screen, list tables, etc.).
- Initializes multisite-specific admin APIs when multisite is enabled.

## Typical Usage

If you need admin APIs in a custom script (e.g., a CLI admin tool or a custom admin endpoint), you can include `admin.php` to load the full admin API stack:

```php
require_once ABSPATH . 'wp-admin/includes/admin.php';

// Now admin-only functions are available:
// - Settings API (register_setting, add_settings_section, ...)
// - List tables (WP_List_Table)
// - Meta boxes (add_meta_box)
// - File uploads (wp_handle_upload, media_handle_upload)
// - Plugin/theme upgraders
// - Dashboard widgets
```

**Note:** Most plugins do **not** need to include this directly because WordPress admin pages already load it. Use it when running admin logic outside the normal admin request context.

## What admin.php Loads

`admin.php` `require_once`s the following admin APIs:

### Core Admin Modules

- `admin-filters.php` — admin-only filters/hooks
- `bookmark.php` — links/bookmarks admin helpers
- `comment.php` — comment admin actions
- `file.php` — filesystem + editor helpers
- `image.php` — image handling helpers
- `media.php` — media upload helpers
- `import.php` — importer registration
- `misc.php` — misc admin utilities
- `options.php` — Settings API (core)
- `plugin.php` — plugin admin APIs
- `post.php` — post admin helpers
- `taxonomy.php` — taxonomy admin helpers
- `template.php` — admin template helpers
- `theme.php` — theme admin APIs
- `privacy-tools.php` — privacy export/erase tools
- `user.php` — user admin APIs
- `update.php` — update checks + updater helpers
- `deprecated.php` — admin deprecations

### Screen & List Tables

- `class-wp-screen.php` + `screen.php` — Screen Options and screen context
- `class-wp-list-table.php` + `class-wp-list-table-compat.php` + `list-table.php` — List table base and helpers

### Site Icon

- `class-wp-site-icon.php` — Site Icon helpers

### Privacy List Tables

- `class-wp-privacy-requests-table.php`
- `class-wp-privacy-data-export-requests-list-table.php`
- `class-wp-privacy-data-removal-requests-list-table.php`

### Multisite Admin (when `is_multisite()`)

- `ms-admin-filters.php`
- `ms.php`
- `ms-deprecated.php`

## Localization Handling

`admin.php` includes a guard for contexts where it is included directly (not via `wp-admin/admin.php`). In that case, it ensures the admin text domain is loaded:

```php
if ( ! defined( 'WP_ADMIN' ) ) {
    $admin_locale = get_locale();
    load_textdomain( 'default', WP_LANG_DIR . '/admin-' . $admin_locale . '.mo', $admin_locale );
    unset( $admin_locale );
}
```

This ensures admin UI strings are available even in non-standard entry points.

## When to Use `admin.php`

✅ Use it when:

- Running admin-only functions in a custom script.
- Building an admin-only endpoint outside standard admin pages.
- Writing maintenance tasks that need admin-only APIs (upgrader, media functions, etc.).

❌ Avoid using it when:

- Already inside `wp-admin` (it is loaded automatically).
- In front-end requests (unless you explicitly need admin-only APIs).

## Related Admin APIs

See other files in this directory for the specific APIs loaded by `admin.php`:

- Dashboard widgets
- List tables
- Screen options
- Meta boxes
- Admin notices
- Settings API
- File uploads
- Image editing
- Plugin/theme installation
- Update functions
- Export/import
