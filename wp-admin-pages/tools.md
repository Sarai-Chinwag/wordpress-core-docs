# Tools

## tools.php
- **URL:** `/wp-admin/tools.php`
- **Capability required:** Varies by tool; base page is available to admins. Import section requires `import`; category/tag conversion requires term management caps.
- **What it does:** Tools hub for legacy tools, importers, and category/tag converter.
- **Key hooks:** `tool_box`.

## import.php
- **URL:** `/wp-admin/import.php`
- **Capability required:** `import` (and `install_plugins` to install importer plugins).
- **What it does:** Lists available importers, installs importer plugins, and launches importer screens (actual import runs via `admin.php?import=...`).
- **Key hooks:** `import_filters`.

## export.php
- **URL:** `/wp-admin/export.php`
- **Capability required:** `export`.
- **What it does:** Exports content as WXR (posts, pages, media, etc.).
- **Key hooks:** `export_args`, `export_filters`.

## site-health.php
- **URL:** `/wp-admin/site-health.php`
- **Capability required:** `view_site_health_checks` (and `update_https` for HTTPS tests).
- **What it does:** Site Health dashboard and tools; loads health checks and debugging info UI.
- **Key hooks:** `site_health_navigation_tabs`, `site_health_tab_content`.

## erase-personal-data.php
- **URL:** `/wp-admin/erase-personal-data.php`
- **Capability required:** `erase_others_personal_data` and `delete_users`.
- **What it does:** Handles personal data erasure requests (privacy tools).
- **Key hooks:** (none in file).

## export-personal-data.php
- **URL:** `/wp-admin/export-personal-data.php`
- **Capability required:** `export_others_personal_data`.
- **What it does:** Handles personal data export requests (privacy tools).
- **Key hooks:** (none in file).
