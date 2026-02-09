# Plugins

## plugins.php
- **URL:** `/wp-admin/plugins.php`
- **Capability required:** `activate_plugins` (and related caps like `deactivate_plugins`, `delete_plugins`, `update_plugins`).
- **What it does:** Lists installed plugins, handles activation/deactivation, deletion, auto-updates, and plugin bulk actions.
- **Key hooks:** `activate_{$plugin}`, `pre_current_active_plugins`, `all_plugins`, `handle_bulk_actions-{$screen}`.

## plugin-install.php
- **URL:** `/wp-admin/plugin-install.php`
- **Capability required:** `install_plugins` (plus `upload_plugins` for upload tab).
- **What it does:** Plugin installer UI (search, featured, upload) and installs plugins from WordPress.org or zip uploads.
- **Key hooks:** `install_plugins_pre_{$tab}`, `install_plugins_{$tab}`, `install_plugins_upload`, `install_plugins_pre_upload`.

## plugin-editor.php
- **URL:** `/wp-admin/plugin-editor.php`
- **Capability required:** `edit_plugins`.
- **What it does:** Built-in plugin file editor.
- **Key hooks:** (none in file; standard admin hooks apply).
