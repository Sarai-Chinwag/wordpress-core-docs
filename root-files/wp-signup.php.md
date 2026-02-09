# wp-signup.php

## Purpose
Multisite signup handler for new users and/or new sites, including validation and form rendering.

## Flow
- Loads WordPress (`wp-load.php`) and front-end context (`wp-blog-header.php`).
- Ensures multisite and main-site context; otherwise redirects.
- Registers `signup_header` and default stylesheet output via `wp_head`.
- Outputs signup forms and handles submission:
  - Validates user/site data via `wpmu_validate_user_signup()` and `wpmu_validate_blog_signup()`.
  - Creates signup records via `wpmu_signup_user()` / `wpmu_signup_blog()`.
  - Optionally creates site immediately for logged-in users (`wpmu_create_blog()`).

## Key functions called
- `wpmu_validate_user_signup()`
- `wpmu_validate_blog_signup()`
- `wpmu_signup_user()`
- `wpmu_signup_blog()`
- `wpmu_create_blog()`
- `signup_get_available_languages()`

## Hooks fired
- Actions:
  - `signup_header`
  - `before_signup_header`
  - `before_signup_form`
  - `signup_blogform`
  - `signup_extra_fields`
  - `signup_hidden_fields`
  - `signup_finished`
  - `preprocess_signup_form`
  - `after_signup_form`
- Filters (selected):
  - `add_signup_meta`
  - `wpmu_active_signup`
