# ajax-actions.php

## Overview

Defines wp-admin AJAX handlers for authenticated and unauthenticated requests. Handlers are named `wp_ajax_*()` and are invoked by `admin-ajax.php` when the `action` request parameter matches the suffix.

## Usage

Request handlers by sending `action=...` to `admin-ajax.php`. The handler name is `wp_ajax_{action}` (or `wp_ajax_nopriv_{action}` for unauthenticated requests).

```php
$.post(ajaxurl, {
  action: "get_comments",
  post_id: 123,
  _ajax_nonce: myNonce
});
```

## AJAX Handlers

- `wp_ajax_nopriv_heartbeat()` — Administration API: Core Ajax handlers
- `wp_ajax_fetch_list()` — Filters Heartbeat Ajax response in no-privilege environments.
- `wp_ajax_ajax_tag_search()` — Handles tag search via AJAX.
- `wp_ajax_wp_compression_test()` — Filters the minimum number of characters required to fire a tag search via Ajax.
- `wp_ajax_imgedit_preview()` — Handles image editor previews via AJAX.
- `wp_ajax_oembed_cache()` — Handles oEmbed caching via AJAX.
- `wp_ajax_autocomplete_user()` — Handles user autocomplete via AJAX.
- `wp_ajax_get_community_events()` —  This filter is documented in wp-admin/user-new.php */
- `wp_ajax_dashboard_widgets()` — Handles dashboard widgets via AJAX.
- `wp_ajax_logged_in()` — Handles Customizer preview logged-in status via AJAX.
- `wp_ajax_delete_comment()` —  This filter is documented in wp-admin/includes/meta-boxes.php */
- `wp_ajax_delete_tag()` — Handles deleting a tag via AJAX.
- `wp_ajax_delete_link()` — Handles deleting a link via AJAX.
- `wp_ajax_delete_meta()` — Handles deleting meta via AJAX.
- `wp_ajax_delete_post()` — Handles deleting a post via AJAX.
- `wp_ajax_trash_post()` — Handles sending a post to the Trash via AJAX.
- `wp_ajax_untrash_post()` — Handles restoring a post from the Trash via AJAX.
- `wp_ajax_delete_page()` — Handles deleting a page via AJAX.
- `wp_ajax_dim_comment()` — Handles dimming a comment via AJAX.
- `wp_ajax_add_link_category()` — Handles adding a link category via AJAX.
- `wp_ajax_add_tag()` — Handles adding a tag via AJAX.
- `wp_ajax_get_tagcloud()` — Handles getting a tagcloud via AJAX.
- `wp_ajax_get_comments()` — Handles getting comments via AJAX.
- `wp_ajax_replyto_comment()` — Handles replying to a comment via AJAX.
- `wp_ajax_edit_comment()` — Handles editing a comment via AJAX.
- `wp_ajax_add_menu_item()` — Handles adding a menu item via AJAX.
- `wp_ajax_add_meta()` —  This filter is documented in wp-admin/includes/nav-menu.php */
- `wp_ajax_add_user()` — Handles adding a user via AJAX.
- `wp_ajax_closed_postboxes()` — Handles closed post boxes via AJAX.
- `wp_ajax_hidden_columns()` — Handles hidden columns via AJAX.
- `wp_ajax_update_welcome_panel()` — Handles updating whether to display the welcome panel via AJAX.
- `wp_ajax_menu_get_metabox()` — Handles for retrieving menu meta boxes via AJAX.
- `wp_ajax_wp_link_ajax()` —  This filter is documented in wp-admin/includes/nav-menu.php */
- `wp_ajax_menu_locations_save()` — Handles saving menu locations via AJAX.
- `wp_ajax_meta_box_order()` — Handles saving the meta box order via AJAX.
- `wp_ajax_menu_quick_search()` — Handles menu quick searching via AJAX.
- `wp_ajax_get_permalink()` — Handles retrieving a permalink via AJAX.
- `wp_ajax_sample_permalink()` — Handles retrieving a sample permalink via AJAX.
- `wp_ajax_inline_save()` — Handles Quick Edit saving a post from a list table via AJAX.
- `wp_ajax_inline_save_tax()` —  This filter is documented in wp-admin/includes/class-wp-posts-list-table.php */
- `wp_ajax_find_posts()` — Handles querying posts for the Find Posts modal via AJAX.
- `wp_ajax_widgets_order()` — Handles saving the widgets order via AJAX.
- `wp_ajax_save_widget()` — Handles saving a widget via AJAX.
- `wp_ajax_update_widget()` — Fires early when editing the widgets displayed in sidebars.
- `wp_ajax_delete_inactive_widgets()` — Handles removing inactive widgets via AJAX.
- `wp_ajax_media_create_image_subsizes()` —  This action is documented in wp-admin/includes/ajax-actions.php */
- `wp_ajax_upload_attachment()` — Handles uploading attachments via AJAX.
- `wp_ajax_image_editor()` — Handles image editing via AJAX.
- `wp_ajax_set_post_thumbnail()` — Handles setting the featured image via AJAX.
- `wp_ajax_get_post_thumbnail_html()` — Handles retrieving HTML for the featured image via AJAX.
- `wp_ajax_set_attachment_thumbnail()` — Handles setting the featured image for an attachment via AJAX.
- `wp_ajax_date_format()` — Handles formatting a date via AJAX.
- `wp_ajax_time_format()` — Handles formatting a time via AJAX.
- `wp_ajax_wp_fullscreen_save_post()` — Handles saving posts from the fullscreen editor via AJAX.
- `wp_ajax_wp_remove_post_lock()` — Handles removing a post lock via AJAX.
- `wp_ajax_dismiss_wp_pointer()` — Filters the post lock window duration.
- `wp_ajax_get_attachment()` — Handles getting an attachment via AJAX.
- `wp_ajax_query_attachments()` — Handles querying attachments via AJAX.
- `wp_ajax_save_attachment()` — Filters the arguments passed to WP_Query during an Ajax
- `wp_ajax_save_attachment_compat()` — Handles saving backward compatible attachment attributes via AJAX.
- `wp_ajax_save_attachment_order()` —  This filter is documented in wp-admin/includes/media.php */
- `wp_ajax_send_attachment_to_editor()` — Handles sending an attachment to the editor via AJAX.
- `wp_ajax_send_link_to_editor()` —  This filter is documented in wp-admin/includes/media.php */
- `wp_ajax_heartbeat()` —  This filter is documented in wp-admin/includes/media.php */
- `wp_ajax_get_revision_diffs()` — Filters the nonces to send to the New/Edit Post screen.
- `wp_ajax_save_user_color_scheme()` — Handles auto-saving the selected color scheme for
- `wp_ajax_query_themes()` — Handles getting themes from themes_api() via AJAX.
- `wp_ajax_parse_embed()` —  This filter is documented in wp-admin/includes/class-wp-theme-install-list-table.php */
- `wp_ajax_parse_media_shortcode()` — function wp_ajax_parse_media_shortcode(
- `wp_ajax_destroy_sessions()` — Handles destroying multiple open sessions for a user via AJAX.
- `wp_ajax_crop_image()` — Handles cropping an image via AJAX.
- `wp_ajax_generate_password()` —  This filter is documented in wp-admin/includes/class-custom-image-header.php */
- `wp_ajax_nopriv_generate_password()` — Handles generating a password in the no-privilege context via AJAX.
- `wp_ajax_save_wporg_username()` — Handles saving the user's WordPress.org username via AJAX.
- `wp_ajax_install_theme()` — Handles installing a theme via AJAX.
- `wp_ajax_update_theme()` — Handles updating a theme via AJAX.
- `wp_ajax_delete_theme()` — Handles deleting a theme via AJAX.
- `wp_ajax_install_plugin()` — Handles installing a plugin via AJAX.
- `wp_ajax_activate_plugin()` — Handles activating a plugin via AJAX.
- `wp_ajax_update_plugin()` — Handles updating a plugin via AJAX.
- `wp_ajax_delete_plugin()` — Handles deleting a plugin via AJAX.
- `wp_ajax_search_plugins()` — Handles searching plugins via AJAX.
- `wp_ajax_search_install_plugins()` —  @var WP_Plugins_List_Table $wp_list_table */
- `wp_ajax_edit_theme_plugin_file()` —  @var WP_Plugin_Install_List_Table $wp_list_table */
- `wp_ajax_wp_privacy_export_personal_data()` — Handles exporting a user's personal data via AJAX.
- `wp_ajax_wp_privacy_erase_personal_data()` — Filters the array of exporter callbacks.
- `wp_ajax_health_check_dotorg_communication()` — Filters the array of personal data eraser callbacks.
- `wp_ajax_health_check_background_updates()` — Handles site health checks on background updates via AJAX.
- `wp_ajax_health_check_loopback_requests()` — Handles site health checks on loopback requests via AJAX.
- `wp_ajax_health_check_site_status_result()` — Handles site health check to update the result status via AJAX.
- `wp_ajax_health_check_get_sizes()` — Handles site health check to get directories and database sizes via AJAX.
- `wp_ajax_rest_nonce()` — Handles renewing the REST API nonce via AJAX.
- `wp_ajax_toggle_auto_updates()` — Handles enabling or disable plugin and theme auto-updates via AJAX.
- `wp_ajax_send_password_reset()` —  This filter is documented in wp-admin/includes/class-wp-plugins-list-table.php */
