# Core admin entry points

## admin.php
- **URL:** `/wp-admin/admin.php`
- **Capability required:** No single capability; uses `auth_redirect()` to require logged-in users, then defers to the current screen’s own capability checks. Raises memory limit if `manage_options`.
- **What it does:** Boots the admin, loads menus, sets the current screen, dispatches plugin pages, importers, or core screens, and handles `admin_action_*` requests.
- **Key hooks:** `admin_init`, `load-{$page_hook}`, `load-{$plugin_page}`, `load-{$pagenow}`, `admin_action_{$action}`, `after_db_upgrade`, `after_mu_upgrade`, `do_mu_upgrade`, `force_filtered_html_on_import`.

## admin-ajax.php
- **URL:** `/wp-admin/admin-ajax.php`
- **Capability required:** Depends on the AJAX action; authenticated actions use `wp_ajax_{$action}` with handler capability checks. Public actions use `wp_ajax_nopriv_{$action}`.
- **What it does:** Ajax dispatcher for admin and front-end requests. Loads admin bootstrap and runs the registered AJAX action callback.
- **Key hooks:** `admin_init`, `wp_ajax_{$action}`, `wp_ajax_nopriv_{$action}`.

## admin-post.php
- **URL:** `/wp-admin/admin-post.php`
- **Capability required:** Depends on handler; authenticated posts use `admin_post_{$action}` (user must be logged in). Public posts use `admin_post_nopriv_{$action}`.
- **What it does:** Handles generic form posts into the admin without page rendering. Dispatches by the `action` request parameter.
- **Key hooks:** `admin_init`, `admin_post`, `admin_post_{$action}`, `admin_post_nopriv`, `admin_post_nopriv_{$action}`.

## admin-header.php
- **URL:** Included by admin screens (not typically requested directly).
- **Capability required:** No direct checks; depends on the calling screen.
- **What it does:** Renders the admin header (title, menus, notices), enqueues scripts/styles, and outputs the opening admin markup.
- **Key hooks:** `admin_enqueue_scripts`, `admin_head`, `admin_head-{$hook_suffix}`, `admin_print_scripts`, `admin_print_scripts-{$hook_suffix}`, `admin_print_styles`, `admin_print_styles-{$hook_suffix}`, `admin_notices`, `all_admin_notices`, `network_admin_notices`, `user_admin_notices`, `in_admin_header`, `admin_body_class`, `admin_title`.

## admin-footer.php
- **URL:** Included by admin screens (not typically requested directly).
- **Capability required:** No direct checks; depends on the calling screen.
- **What it does:** Renders admin footer markup and prints footer scripts.
- **Key hooks:** `admin_footer`, `admin_footer-{$hook_suffix}`, `admin_print_footer_scripts`, `admin_print_footer_scripts-{$hook_suffix}`, `admin_footer_text`, `update_footer`, `in_admin_footer`.
