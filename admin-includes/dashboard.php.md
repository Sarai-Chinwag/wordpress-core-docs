# dashboard.php

## Overview

Dashboard widgets, feeds, and screen logic for the main WP admin dashboard.

## Functions

- `wp_dashboard_setup()` — WordPress Dashboard Widget Administration Screen API
- `wp_add_dashboard_widget()` — Fires after core widgets for the Network Admin dashboard have been registered.
- `wp_dashboard()` — Displays the dashboard.
- `wp_dashboard_right_now()` — Dashboard widget that displays some basic stats about the site.
- `wp_network_dashboard_right_now()` — Filters the array of extra elements to list in the 'At a Glance'
- `wp_dashboard_quick_press()` — Fires in the Network Admin 'Right Now' dashboard widget
- `wp_dashboard_recent_drafts()` —  This filter is documented in wp-admin/edit-form-advanced.php */
- `wp_dashboard_site_activity()` —  This filter is documented in wp-admin/includes/class-wp-comments-list-table.php */
- `wp_dashboard_recent_posts()` — Generates Publishing Soon and Recently Published sections.
- `wp_dashboard_recent_comments()` — Filters the query arguments used for the Recent Posts widget.
- `wp_dashboard_rss_output()` — Display generic dashboard RSS widget feed.
- `wp_dashboard_cached_rss_widget()` — Checks to see if all of the feed url in $check_urls are cached.
- `wp_dashboard_trigger_widget_control()` — Calls widget control callback.
- `wp_dashboard_rss_control()` — Sets up the RSS dashboard widget control and $args to be used as input to wp_widget_rss_form().
- `wp_dashboard_events_news()` — Renders the Events and News dashboard widget.
- `wp_print_community_events_markup()` — Prints the markup for the Community Events section of the Events and News Dashboard widget.
- `wp_print_community_events_templates()` — Renders the events templates for the Event and News widget.
- `wp_dashboard_primary()` — 'WordPress Events and News' dashboard widget.
- `wp_dashboard_primary_output()` — Filters the primary link URL for the 'WordPress Events and News' dashboard widget.
- `wp_dashboard_quota()` — Displays file upload quota on dashboard.
- `wp_dashboard_browser_nag()` — Displays the browser update nag.
- `dashboard_browser_nag_class()` — Filters the notice output for the 'Browse Happy' nag meta box.
- `wp_check_browser_version()` — Checks if the user needs a browser update.
- `wp_dashboard_php_nag()` — Response should be an array with:
- `dashboard_php_nag_class()` — Adds an additional class to the PHP nag if the current version is insecure.
- `wp_dashboard_site_health()` — Displays the Site Health Status widget.
- `wp_dashboard_empty()` — Outputs empty dashboard widget to be populated by JS later.
- `wp_welcome_panel()` — Displays a welcome panel to introduce users to WordPress.
