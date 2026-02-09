# Themes

## themes.php
- **URL:** `/wp-admin/themes.php`
- **Capability required:** `switch_themes` or `edit_theme_options` (and related caps like `install_themes`, `delete_themes`, `update_themes`).
- **What it does:** Displays installed themes, handles theme activation, deletion, auto-updates, and links to the Customizer/Site Editor.
- **Key hooks:** `theme_auto_update_setting_template`.

## theme-install.php
- **URL:** `/wp-admin/theme-install.php`
- **Capability required:** `install_themes` (plus `upload_themes` for upload tab).
- **What it does:** Theme installer UI (search, featured, upload) and installs themes from WordPress.org or zip uploads.
- **Key hooks:** `install_themes_tabs`, `install_themes_pre_{$tab}`, `install_themes_{$tab}`.

## customize.php
- **URL:** `/wp-admin/customize.php`
- **Capability required:** `customize` (and `edit_post` for the changeset).
- **What it does:** Boots the Customizer controls iframe, loads changeset, and prints Customizer controls UI.
- **Key hooks:** `customize_controls_init`, `customize_controls_enqueue_scripts`, `customize_controls_print_styles`, `customize_controls_print_scripts`, `customize_controls_print_footer_scripts`, `customize_controls_head`.

## custom-background.php
- **URL:** `/wp-admin/custom-background.php`
- **Capability required:** `edit_theme_options` (via admin bootstrap).
- **What it does:** Legacy background image/color settings page for classic themes.
- **Key hooks:** (none in file; standard admin hooks apply).

## custom-header.php
- **URL:** `/wp-admin/custom-header.php`
- **Capability required:** `edit_theme_options` (via admin bootstrap).
- **What it does:** Legacy header image settings page for classic themes.
- **Key hooks:** (none in file; standard admin hooks apply).

## site-editor.php
- **URL:** `/wp-admin/site-editor.php`
- **Capability required:** `edit_theme_options`.
- **What it does:** Boots the Site Editor (full-site editing) for block themes.
- **Key hooks:** `enqueue_block_editor_assets`, `site_editor_no_javascript_message`.
