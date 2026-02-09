# Common Hooks

Categorized reference of frequently-used WordPress action and filter hooks.

---

## Initialization Actions

### Core Bootstrap

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `muplugins_loaded` | After MU plugins load | MU plugin initialization |
| `plugins_loaded` | After all plugins load | Plugin initialization, loading textdomains |
| `setup_theme` | Before theme loads | Theme prerequisites |
| `after_setup_theme` | After theme loads | Theme setup, add_theme_support() |
| `init` | After WP fully loads, before headers | Register CPTs, taxonomies, shortcodes |
| `wp_loaded` | After WP and all plugins/themes load | Late initialization |
| `wp` | After WP query is parsed | Query-dependent setup |

### Admin Initialization

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `admin_init` | First thing on admin pages | Admin-only setup, option registration |
| `admin_menu` | When admin menu is created | Add menu/submenu pages |
| `admin_bar_menu` | When admin bar is created | Add admin bar items |
| `current_screen` | After current screen is set | Screen-specific setup |

### REST API

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `rest_api_init` | When REST API initializes | Register REST routes |

---

## Request Lifecycle Actions

### Frontend

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `template_redirect` | Before template loads | Redirects, access control |
| `wp_enqueue_scripts` | Frontend script/style enqueue point | Enqueue CSS/JS |
| `wp_head` | Inside `<head>` | Meta tags, inline CSS |
| `wp_body_open` | After `<body>` opens | Skip links, tracking scripts |
| `wp_footer` | Before `</body>` | Deferred scripts, analytics |
| `shutdown` | After response sent | Cleanup, logging |

### Admin

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `admin_enqueue_scripts` | Admin script/style enqueue point | Enqueue admin CSS/JS |
| `admin_head` | Inside admin `<head>` | Admin-specific styles |
| `admin_footer` | Admin footer | Admin scripts |
| `admin_notices` | Top of admin pages | Display notices |

---

## Content Actions

### Posts

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `save_post` | Post is saved | Custom meta, validation |
| `save_post_{post_type}` | Specific post type saved | Type-specific processing |
| `wp_insert_post` | After post inserted/updated | Post processing |
| `before_delete_post` | Before post deleted | Cleanup related data |
| `delete_post` | Post is deleted | Remove related data |
| `trashed_post` | Post moved to trash | Soft-delete handling |
| `transition_post_status` | Post status changes | Status change notifications |

### Comments

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `comment_post` | Comment is saved | Comment processing |
| `wp_insert_comment` | Comment inserted | Comment notifications |
| `delete_comment` | Comment deleted | Cleanup |
| `transition_comment_status` | Comment status changes | Moderation handling |

### Terms & Taxonomies

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `create_term` | Term is created | Term processing |
| `edit_term` | Term is edited | Term updates |
| `delete_term` | Term is deleted | Cleanup |
| `set_object_terms` | Terms assigned to object | Relationship handling |

---

## User Actions

### Authentication

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `wp_login` | User logs in | Login tracking, redirects |
| `wp_logout` | User logs out | Cleanup |
| `wp_login_failed` | Login attempt fails | Security logging |
| `auth_cookie_valid` | Auth cookie validated | Session management |

### User Management

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `user_register` | New user created | Welcome emails, defaults |
| `profile_update` | User profile updated | Profile processing |
| `delete_user` | User deleted | Cleanup user data |
| `set_user_role` | User role changes | Role-based setup |

---

## Media Actions

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `add_attachment` | Attachment uploaded | Post-upload processing |
| `edit_attachment` | Attachment edited | Attachment updates |
| `delete_attachment` | Attachment deleted | Cleanup |
| `wp_handle_upload` | File uploaded | Custom upload handling |

---

## Widget & Block Actions

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `widgets_init` | Widget area registration | Register sidebars/widgets |
| `dynamic_sidebar` | Sidebar renders | Sidebar customization |
| `init` | Block registration point | Register blocks (with `register_block_type`) |

---

## Cron Actions

| Hook | When it Fires | Typical Use |
|------|---------------|-------------|
| `wp_scheduled_delete` | Daily | Trash cleanup |
| `wp_update_plugins` | Twice daily | Plugin update checks |
| `wp_update_themes` | Twice daily | Theme update checks |
| Custom hooks | As scheduled | Background tasks |

---

## Content Filters

### Titles & Content

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `the_title` | Post title | string |
| `the_content` | Post content | string |
| `the_excerpt` | Post excerpt | string |
| `get_the_excerpt` | Raw excerpt | string |
| `the_content_more_link` | "Read more" link | string |
| `wp_trim_excerpt` | Auto-generated excerpt | string |

### Post Data

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `the_permalink` | Post permalink | string |
| `post_link` | Post type permalink | string |
| `post_type_link` | CPT permalink | string |
| `the_author` | Author display name | string |
| `get_the_date` | Post date | string |
| `the_category` | Category list | string |
| `the_tags` | Tag list | string |

---

## Query Filters

### Pre-Query

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `pre_get_posts` | WP_Query before execution | void (modify $query) |
| `query_vars` | Registered query vars | array |
| `request` | Request query vars | array |

### SQL Modification

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `posts_where` | WHERE clause | string |
| `posts_join` | JOIN clause | string |
| `posts_orderby` | ORDER BY clause | string |
| `posts_distinct` | DISTINCT clause | string |
| `posts_fields` | SELECT fields | string |
| `posts_clauses` | All clauses | array |
| `posts_request` | Complete SQL query | string |

### Post-Query

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `the_posts` | Query results | WP_Post[] |
| `found_posts` | Total found posts | int |

---

## Template Filters

### Classes

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `body_class` | Body CSS classes | array |
| `post_class` | Post wrapper classes | array |
| `nav_menu_css_class` | Menu item classes | array |
| `comment_class` | Comment classes | array |

### Template Selection

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `template_include` | Template file path | string |
| `single_template` | Single post template | string |
| `archive_template` | Archive template | string |
| `search_template` | Search template | string |
| `404_template` | 404 template | string |

---

## Navigation Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `wp_nav_menu` | Complete menu HTML | string |
| `wp_nav_menu_items` | Menu items HTML | string |
| `wp_nav_menu_objects` | Menu item objects | array |
| `nav_menu_link_attributes` | Menu link attributes | array |
| `walker_nav_menu_start_el` | Menu item element | string |

---

## Media Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `upload_mimes` | Allowed MIME types | array |
| `wp_handle_upload_prefilter` | Upload before processing | array |
| `wp_generate_attachment_metadata` | Attachment metadata | array |
| `image_size_names_choose` | Image size options | array |
| `intermediate_image_sizes` | Image sizes to generate | array |
| `wp_get_attachment_image_attributes` | Image tag attributes | array |

---

## Authentication Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `authenticate` | Authentication result | WP_User\|WP_Error |
| `login_redirect` | Post-login redirect URL | string |
| `logout_redirect` | Post-logout redirect URL | string |
| `login_url` | Login page URL | string |
| `lostpassword_url` | Password reset URL | string |

---

## Permission Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `user_has_cap` | User capabilities | array |
| `map_meta_cap` | Meta capability mapping | array |
| `editable_roles` | Roles user can assign | array |
| `show_admin_bar` | Admin bar visibility | bool |

---

## REST API Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `rest_pre_dispatch` | Pre-dispatch (short-circuit) | mixed |
| `rest_request_before_callbacks` | Before route callbacks | WP_REST_Response\|WP_Error |
| `rest_request_after_callbacks` | After route callbacks | WP_REST_Response\|WP_Error |
| `rest_prepare_{post_type}` | Post response | WP_REST_Response |
| `rest_prepare_comment` | Comment response | WP_REST_Response |
| `rest_prepare_user` | User response | WP_REST_Response |

---

## Email Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `wp_mail` | Email arguments | array |
| `wp_mail_from` | From address | string |
| `wp_mail_from_name` | From name | string |
| `wp_mail_content_type` | Content type | string |

---

## Option Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `pre_option_{option}` | Before retrieving | mixed (short-circuit) |
| `option_{option}` | Retrieved value | mixed |
| `pre_update_option_{option}` | Before updating | mixed |
| `default_option_{option}` | Default value | mixed |

---

## Script & Style Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `script_loader_tag` | Script tag HTML | string |
| `style_loader_tag` | Style tag HTML | string |
| `script_loader_src` | Script URL | string |
| `style_loader_src` | Style URL | string |

---

## Cron Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `cron_schedules` | Available schedules | array |
| `pre_schedule_event` | Before scheduling | null\|bool |
| `pre_unschedule_event` | Before unscheduling | null\|bool |

---

## Block Editor Filters

| Hook | What it Filters | Return Type |
|------|-----------------|-------------|
| `allowed_block_types_all` | Allowed blocks | array\|bool |
| `block_editor_settings_all` | Editor settings | array |
| `render_block` | Block output HTML | string |
| `render_block_{block_name}` | Specific block output | string |
| `block_categories_all` | Block categories | array |
