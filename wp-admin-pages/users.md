# Users

## users.php
- **URL:** `/wp-admin/users.php`
- **Capability required:** `list_users` (and related caps like `edit_users`, `delete_users`, `promote_users`, `remove_users`).
- **What it does:** Lists users, handles bulk actions (delete, remove, change role), and filtering/search.
- **Key hooks:** `handle_bulk_actions-{$screen}`, `delete_user_form`, `users_have_additional_content`.

## user-new.php
- **URL:** `/wp-admin/user-new.php`
- **Capability required:** `create_users` (or `promote_users` in multisite).
- **What it does:** Adds new users or invites existing users to the site; supports multisite invite flow.
- **Key hooks:** `user_new_form`, `user_new_form_tag`, `invite_user`, `invited_user_email`, `pre_user_login`, `autocomplete_users_for_site_admins`.

## user-edit.php
- **URL:** `/wp-admin/user-edit.php?user_id={ID}`
- **Capability required:** `edit_user` for target user (and `edit_users` to edit other users).
- **What it does:** User profile editor for any user; handles role changes and application passwords.
- **Key hooks:** `show_user_profile`, `edit_user_profile`, `personal_options`, `profile_personal_options`, `show_password_fields`, `additional_capabilities_display`, `user_edit_form_tag`, `edit_user_profile_update`, `personal_options_update`, `admin_color_scheme_picker`, `wp_create_application_password_form`, `user_profile_picture_description`.

## profile.php
- **URL:** `/wp-admin/profile.php`
- **Capability required:** `read` (own profile).
- **What it does:** Redirects to or renders the current user’s profile editor (self-profile).
- **Key hooks:** (none in file; profile screen hooks come from `user-edit.php`).
