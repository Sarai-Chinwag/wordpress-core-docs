# Settings

## options.php (Settings handler)
- **URL:** `/wp-admin/options.php`
- **Capability required:** Varies by option page; uses `option_page_capability_{$option_page}` filter and checks `manage_network_options` on multisite.
- **What it does:** Processes settings form submissions, validates option pages, and updates options.
- **Key hooks:** `option_page_capability_{$option_page}`, `allowed_options`, `enable_post_by_email_configuration`.

## options-general.php
- **URL:** `/wp-admin/options-general.php`
- **Capability required:** `manage_options`.
- **What it does:** General site settings (title, tagline, URL, admin email, timezone, language).
- **Key hooks:** `date_formats`, `time_formats`.

## options-writing.php
- **URL:** `/wp-admin/options-writing.php`
- **Capability required:** `manage_options`.
- **What it does:** Writing settings (default categories, post formats, post-by-email, update services).
- **Key hooks:** `enable_post_by_email_configuration`, `enable_update_services_configuration`.

## options-reading.php
- **URL:** `/wp-admin/options-reading.php`
- **Capability required:** `manage_options`.
- **What it does:** Reading settings (front page display, blog pages, RSS, search visibility).
- **Key hooks:** `blog_privacy_selector`.

## options-discussion.php
- **URL:** `/wp-admin/options-discussion.php`
- **Capability required:** `manage_options`.
- **What it does:** Discussion settings (comments, avatars, moderation).
- **Key hooks:** `thread_comments_depth_max`, `default_avatar_select`, `avatar_defaults`.

## options-media.php
- **URL:** `/wp-admin/options-media.php`
- **Capability required:** `manage_options`.
- **What it does:** Media settings (image sizes, uploads, organization).
- **Key hooks:** (none in file).

## options-permalink.php
- **URL:** `/wp-admin/options-permalink.php`
- **Capability required:** `manage_options`.
- **What it does:** Permalink settings and rewrite rules.
- **Key hooks:** `available_permalink_structure_tags`.

## options-privacy.php
- **URL:** `/wp-admin/options-privacy.php`
- **Capability required:** `manage_privacy_options`.
- **What it does:** Privacy policy page settings and related guidance.
- **Key hooks:** (none in file).
