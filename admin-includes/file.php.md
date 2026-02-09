# file.php

## Overview

Filesystem helpers for uploads, file editing, and WordPress file operations.

## Functions

- `get_file_description()` — Filesystem API: Top-level functionality
- `get_home_path()` — Gets the absolute filesystem path to the root of the WordPress installation.
- `list_files()` — Returns a listing of all files in the specified folder and all subdirectories up to 100 levels deep.
- `wp_get_plugin_file_editable_extensions()` — Gets the list of file extensions that are editable in plugins.
- `wp_get_theme_file_editable_extensions()` — Filters the list of file types allowed for editing in the plugin file editor.
- `wp_print_file_editor_templates()` — Filters the list of file types allowed for editing in the theme file editor.
- `wp_edit_theme_plugin_file()` — Attempts to edit a file for a theme or plugin.
- `wp_tempnam()` —  This filter is documented in wp-includes/class-wp-http-streams.php */
- `validate_file_to_edit()` — Makes sure that the file that was requested to be edited is allowed to be edited.
- `wp_handle_upload()` — Filters the data for a file before it is uploaded to WordPress.
- `wp_handle_sideload()` — Wrapper for _wp_handle_upload().
- `download_url()` — Downloads a URL to a local temporary file using the WordPress HTTP API.
- `verify_file_md5()` — Filters the maximum error response body size in `download_url()`.
- `verify_file_signature()` — Verifies the contents of a file against its ED25519 signature.
- `wp_trusted_keys()` — Retrieves the list of signing keys trusted by WordPress.
- `wp_zip_file_is_valid()` — Filters the valid signing keys used to verify the contents of files.
- `unzip_file()` —  This filter is documented in wp-admin/includes/file.php */
- `copy_dir()` —  This filter is documented in src/wp-admin/includes/file.php */
- `move_dir()` — Moves a directory from one location to another.
- `WP_Filesystem()` — Initializes and connects the WordPress Filesystem Abstraction classes.
- `get_filesystem_method()` — Filters the path for a specific filesystem method class file.
- `request_filesystem_credentials()` — Filters the filesystem method to use.
- `wp_print_request_filesystem_credentials_modal()` — Filters the filesystem credentials.
- `wp_opcache_invalidate()` — Attempts to clear the opcode cache for an individual PHP file.
- `wp_opcache_invalidate_directory()` — Filters whether to invalidate a file from the opcode cache.
