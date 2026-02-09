# deprecated.php

## Overview

Deprecated admin functions and shims kept for backward compatibility.

## Classes

- `WP_User_Search` — Deprecated admin functions from past WordPress versions. You shouldn't use these
- `WP_Privacy_Data_Export_Requests_Table` — {@internal Missing Description}}
- `WP_Privacy_Data_Removal_Requests_Table` — Previous class for list table for privacy data erasure requests.

## Functions

- `tinymce_include()` — Deprecated admin functions from past WordPress versions. You shouldn't use these
- `documentation_link()` — Unused Admin function.
- `wp_shrink_dimensions()` — Calculates the new dimensions for a downsampled image.
- `get_udims()` — Calculates the new dimensions for a downsampled image.
- `dropdown_categories()` — Legacy function used to generate the categories checklist control.
- `dropdown_link_categories()` — Legacy function used to generate a link categories checklist control.
- `get_real_file_to_edit()` — Get the real filesystem path to a file to edit within the admin.
- `wp_dropdown_cats()` — Legacy function used for generating a categories drop-down control.
- `add_option_update_handler()` — Register a setting and its sanitization callback
- `remove_option_update_handler()` — Unregister a setting
- `codepress_get_lang()` — Determines the language to use for CodePress syntax highlighting.
- `codepress_footer_js()` — Adds JavaScript required to make CodePress work on the theme/plugin file editors.
- `use_codepress()` — Determine whether to use CodePress.
- `get_author_user_ids()` — Get all user IDs.
- `get_editable_authors()` — Gets author users who can edit posts.
- `get_editable_user_ids()` — Gets the IDs of any users who can edit posts.
- `get_nonauthor_user_ids()` — Gets all users who are not authors.
- `prepare_vars_for_template_usage()` — PHP4 Constructor - Sets up the object properties.
- `page_links()` — Handles paging for the user search query.
- `results_are_paged()` — Whether paging is enabled.
- `is_search()` — Whether there are search terms.
- `get_others_unpublished_posts()` — Retrieves editable posts from other users.
- `get_others_drafts()` — Retrieve drafts from other users.
- `get_others_pending()` — Retrieve pending review posts from other users.
- `wp_dashboard_quick_press_output()` — Output the QuickPress dashboard widget.
- `wp_tiny_mce()` — Outputs the TinyMCE editor.
- `wp_preload_dialogs()` — Preloads TinyMCE dialogs.
- `wp_print_editor_js()` — Prints TinyMCE editor JS.
- `wp_quicktags()` — Handles quicktags.
- `screen_layout()` — Returns the screen layout options.
- `screen_options()` — Returns the screen's per-page options.
- `screen_meta()` — Renders the screen's help.
- `favorite_actions()` — Favorite actions were deprecated in version 3.2. Use the admin bar instead.
- `media_upload_image()` — Handles uploading an image.
- `media_upload_audio()` — Handles uploading an audio file.
- `media_upload_video()` — Handles uploading a video file.
- `media_upload_file()` — Handles uploading a generic file.
- `type_url_form_image()` — Handles retrieving the insert-from-URL form for an image.
- `type_url_form_audio()` — Handles retrieving the insert-from-URL form for an audio file.
- `type_url_form_video()` — Handles retrieving the insert-from-URL form for a video file.
- `type_url_form_file()` — Handles retrieving the insert-from-URL form for a generic file.
- `add_contextual_help()` — Add contextual help text for a page.
- `get_allowed_themes()` — Get the allowed themes for the current site.
- `get_broken_themes()` — Retrieves a list of broken themes.
- `current_theme_info()` — Retrieves information on the current active theme.
- `get_post_to_edit()` — Gets an existing post and format it for editing.
- `get_default_page_to_edit()` — Gets the default page information to use.
- `wp_create_thumbnail()` — This was once used to create a thumbnail from an Image given a maximum side size.
- `wp_nav_menu_locations_meta_box()` — This was once used to display a meta box for the nav menu theme locations.
- `wp_update_core()` — This was once used to kick-off the Core Updater.
- `wp_update_plugin()` — This was once used to kick-off the Plugin Updater.
- `wp_update_theme()` — This was once used to kick-off the Theme Updater.
- `the_attachment_links()` — This was once used to display attachment links. Now it is deprecated and stubbed.
- `screen_icon()` — Displays a screen icon.
- `get_screen_icon()` — Retrieves the screen icon (no longer used in 3.8+).
- `wp_dashboard_incoming_links_output()` — Deprecated dashboard widget controls.
- `wp_dashboard_secondary_output()` — Deprecated dashboard secondary output.
- `wp_dashboard_incoming_links()` — Deprecated dashboard widget controls.
- `wp_dashboard_incoming_links_control()` — Deprecated dashboard incoming links control.
- `wp_dashboard_plugins()` — Deprecated dashboard plugins control.
- `wp_dashboard_primary_control()` — Deprecated dashboard primary control.
- `wp_dashboard_recent_comments_control()` — Deprecated dashboard recent comments control.
- `wp_dashboard_secondary()` — Deprecated dashboard secondary section.
- `wp_dashboard_secondary_control()` — Deprecated dashboard secondary control.
- `wp_dashboard_plugins_output()` — Display plugins text for the WordPress news widget.
- `add_object_page()` — Add a top-level menu page in the 'objects' section.
- `add_utility_page()` — Add a top-level menu page in the 'utility' section.
- `post_form_autocomplete_off()` — Disables autocomplete on the 'post' form (Add/Edit Post screens) for WebKit browsers,
- `options_permalink_add_js()` — Display JavaScript on the page.
- `image_attachment_fields_to_save()` — Was used to filter input from media_upload_form_handler() and to assign a default
