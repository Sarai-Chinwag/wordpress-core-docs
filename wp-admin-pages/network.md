# Network Admin (Multisite)

All Network Admin screens require multisite. Files load `/wp-admin/network/admin.php`, which ensures multisite and applies the `redirect_network_admin_request` filter.

## admin.php
- **URL:** `/wp-admin/network/admin.php`
- **Capability required:** Multisite only (no direct cap check here; individual screens enforce caps).
- **What it does:** Network admin bootstrap; redirects to the canonical network admin URL if needed.
- **Key hooks:** `redirect_network_admin_request`.

## index.php
- **URL:** `/wp-admin/network/index.php`
- **Capability required:** `manage_network`.
- **What it does:** Network Dashboard landing page.
- **Key hooks:** (none in file).

## settings.php
- **URL:** `/wp-admin/network/settings.php`
- **Capability required:** `manage_network_options`.
- **What it does:** Network settings (registration, uploads, language, etc.).
- **Key hooks:** `mu_menu_items`, `wpmu_options`, `update_wpmu_options`, `wpmuadminedit`.

## sites.php
- **URL:** `/wp-admin/network/sites.php`
- **Capability required:** `manage_sites` (plus `delete_sites`/`delete_site` for deletions).
- **What it does:** Network sites list and bulk actions.
- **Key hooks:** `handle_network_bulk_actions-{$screen}`, `network_sites_updated_message_{$action}`, `wpmuadminedit`, `activate_blog`, `deactivate_blog`.

## site-new.php
- **URL:** `/wp-admin/network/site-new.php`
- **Capability required:** `create_sites`.
- **What it does:** Create a new site in the network.
- **Key hooks:** `network_site_new_form`, `pre_network_site_new_created_user`, `network_site_new_created_user`.

## site-info.php
- **URL:** `/wp-admin/network/site-info.php?id={SITE_ID}`
- **Capability required:** `manage_sites`.
- **What it does:** Edit basic site info (domain/path, status flags).
- **Key hooks:** `network_site_info_form`.

## site-settings.php
- **URL:** `/wp-admin/network/site-settings.php?id={SITE_ID}`
- **Capability required:** `manage_sites`.
- **What it does:** Edit site-specific options in the network.
- **Key hooks:** `wpmu_update_blog_options`, `wpmueditblogaction`.

## site-users.php
- **URL:** `/wp-admin/network/site-users.php?id={SITE_ID}`
- **Capability required:** `manage_sites` (plus `promote_users`/`remove_users` for actions).
- **What it does:** Manage users for a specific site in the network.
- **Key hooks:** `handle_network_bulk_actions-{$screen}`, `network_site_users_after_list_table`, `network_site_users_created_user`, `show_network_site_users_add_existing_form`, `show_network_site_users_add_new_form`.

## site-themes.php
- **URL:** `/wp-admin/network/site-themes.php?id={SITE_ID}`
- **Capability required:** `manage_sites`.
- **What it does:** Enable/disable themes for an individual site.
- **Key hooks:** `handle_network_bulk_actions-{$screen}`.

## users.php
- **URL:** `/wp-admin/network/users.php`
- **Capability required:** `manage_network_users` (plus `delete_users`/`delete_user` for deletion).
- **What it does:** Network-wide user management.
- **Key hooks:** `handle_network_bulk_actions-{$screen}`, `wpmuadminedit`.

## user-new.php
- **URL:** `/wp-admin/network/user-new.php`
- **Capability required:** `create_users` (and `manage_network_users` for some actions).
- **What it does:** Create users at the network level.
- **Key hooks:** `network_user_new_form`, `network_user_new_created_user`.

## user-edit.php
- **URL:** `/wp-admin/network/user-edit.php?user_id={ID}`
- **Capability required:** `manage_network_users` (edit specific user).
- **What it does:** Network-level user edit screen.
- **Key hooks:** (none in file; standard profile hooks from `user-edit.php` apply).

## themes.php
- **URL:** `/wp-admin/network/themes.php`
- **Capability required:** `manage_network_themes` (plus `delete_themes`, `update_themes`, `install_themes`).
- **What it does:** Network-wide theme enable/disable and auto-update controls.
- **Key hooks:** `handle_network_bulk_actions-{$screen}`.

## theme-install.php
- **URL:** `/wp-admin/network/theme-install.php`
- **Capability required:** `install_themes`.
- **What it does:** Network theme installer UI.
- **Key hooks:** (inherits core `theme-install.php` hooks via include).

## theme-editor.php
- **URL:** `/wp-admin/network/theme-editor.php`
- **Capability required:** `edit_themes`.
- **What it does:** Network theme editor (same as core theme editor under network context).
- **Key hooks:** (none in file; standard admin hooks apply).

## plugins.php
- **URL:** `/wp-admin/network/plugins.php`
- **Capability required:** `activate_plugins` (network context; typically super admin for network-wide activation).
- **What it does:** Network plugins list and actions (wraps core `plugins.php`).
- **Key hooks:** (inherits core plugins hooks via include).

## plugin-install.php
- **URL:** `/wp-admin/network/plugin-install.php`
- **Capability required:** `install_plugins`.
- **What it does:** Network plugin installer UI.
- **Key hooks:** (inherits core plugin install hooks via include).

## plugin-editor.php
- **URL:** `/wp-admin/network/plugin-editor.php`
- **Capability required:** `edit_plugins`.
- **What it does:** Network plugin editor (same as core plugin editor under network context).
- **Key hooks:** (none in file; standard admin hooks apply).

## update-core.php
- **URL:** `/wp-admin/network/update-core.php`
- **Capability required:** `update_core` (network context).
- **What it does:** Network updates for core, themes, plugins, translations.
- **Key hooks:** (none in file; standard update hooks apply).

## update.php
- **URL:** `/wp-admin/network/update.php`
- **Capability required:** `update_plugins`/`update_themes`/`update_core` (based on action).
- **What it does:** Network update handler for single updates (wraps core update handler).
- **Key hooks:** (none in file; standard update hooks apply).

## upgrade.php
- **URL:** `/wp-admin/network/upgrade.php`
- **Capability required:** `upgrade_network`.
- **What it does:** Runs network database upgrades.
- **Key hooks:** `after_mu_upgrade`, `wpmu_upgrade_page`, `wpmu_upgrade_site`.

## edit.php
- **URL:** `/wp-admin/network/edit.php?action={action}`
- **Capability required:** Varies by action; uses network admin edit handlers.
- **What it does:** Handles network-level action routing (e.g., site/user edits).
- **Key hooks:** `wpmuadminedit`, `network_admin_edit_{$action}`.

## profile.php
- **URL:** `/wp-admin/network/profile.php`
- **Capability required:** `read` (self profile in network context).
- **What it does:** Redirects to the profile editor under network admin.
- **Key hooks:** (none in file; profile hooks from `user-edit.php` apply).

## menu.php
- **URL:** Included by network admin screens.
- **Capability required:** none directly; constructs menus based on update caps.
- **What it does:** Builds the Network Admin menu.
- **Key hooks:** (none in file; uses capability checks internally).

## About/credits/freedoms/privacy/contribute pages
- **Files:** `about.php`, `credits.php`, `freedoms.php`, `privacy.php`, `contribute.php`
- **URL:** `/wp-admin/network/{file}`
- **Capability required:** `read` (network context).
- **What they do:** Network admin informational screens (WordPress about/credits/freedoms/privacy/contribute).
- **Key hooks:** (none in files).
