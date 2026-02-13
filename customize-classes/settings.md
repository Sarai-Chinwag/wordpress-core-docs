# Customize Settings

Setting classes in `wp-includes/customize/` that extend `WP_Customize_Setting`.

---

## WP_Customize_Filter_Setting

A setting used to filter a value but will not save the results. Results should be handled using another setting or callback.

**Source:** `wp-includes/customize/class-wp-customize-filter-setting.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Setting`

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `update( $value )` | public | 3.4.0 | No-op. Does not save anything. |

---

## WP_Customize_Background_Image_Setting

Setting for background image thumbnail. Removes the `background_image_thumb` theme mod on update.

**Source:** `wp-includes/customize/class-wp-customize-background-image-setting.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Setting`  
**Final:** Yes

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$id` | string | public | `'background_image_thumb'` | 3.4.0 | Unique string identifier for the setting |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `update( $value )` | public | 3.4.0 | Removes `background_image_thumb` theme mod. `$value` parameter is not used. |

---

## WP_Customize_Header_Image_Setting

Setting for header image data. Delegates to `Custom_Image_Header::set_header_image()`.

**Source:** `wp-includes/customize/class-wp-customize-header-image-setting.php`  
**Since:** 3.4.0  
**Extends:** `WP_Customize_Setting`  
**Final:** Yes

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$id` | string | public | `'header_image_data'` | 3.4.0 | Unique string identifier for the setting |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `update( $value )` | public | 3.4.0 | Initializes `Custom_Image_Header` if needed, falls back to `header_image` setting if value is empty, then calls `set_header_image()` with the value or `$value['choice']` if array. |

---

## WP_Customize_Custom_CSS_Setting

Custom Setting to handle WP Custom CSS. Handles validation, sanitization and saving.

**Source:** `wp-includes/customize/class-wp-customize-custom-css-setting.php`  
**Since:** 4.7.0  
**Extends:** `WP_Customize_Setting`  
**Final:** Yes

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `'custom_css'` | 4.7.0 | The setting type |
| `$transport` | string | public | `'postMessage'` | 4.7.0 | Setting transport |
| `$capability` | string | public | `'edit_css'` | 4.7.0 | Capability required to edit this setting |
| `$stylesheet` | string | public | `''` | 4.7.0 | Stylesheet identifier, extracted from setting ID pattern `custom_css[$stylesheet]` |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.7.0 | Validates ID matches `custom_css[$stylesheet]` pattern. Throws `Exception` on mismatch. |
| `preview()` | public | 4.7.9 | Adds `wp_get_custom_css` filter for preview. Returns `false` if already previewed. |
| `filter_previewed_wp_get_custom_css( $css, $stylesheet )` | public | 4.7.0 | Filters `wp_get_custom_css` to return the customized value during preview. |
| `value()` | public | 4.7.0 | Returns CSS from `wp_get_custom_css_post()` post content, or default. Applies `customize_value_custom_css` filter. |
| `validate( $value )` | public | 4.7.0 | Checks for HTML markup in CSS (adds `illegal_markup` error). Delegates to parent for further validation. |
| `update( $value )` | public | 4.7.0 | Saves via `wp_update_custom_css_post()`. Caches post ID in theme mod `custom_css_post_id`. Returns post ID or `false`. |

### Hooks Used

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `wp_get_custom_css` | filter | 4.7.0 | Filtered during preview via `filter_previewed_wp_get_custom_css()` |
| `customize_value_custom_css` | filter | 4.7.0 | Applied in `value()` (documented in `class-wp-customize-setting.php`) |

---

## WP_Customize_Nav_Menu_Item_Setting

Setting to represent a `nav_menu_item` post. Handles previewing, sanitizing, and CRUD for individual menu items.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-item-setting.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Setting`

### Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `ID_PATTERN` | `/^nav_menu_item\[(?P<id>-?\d+)\]$/` | Regex for valid setting IDs |
| `POST_TYPE` | `'nav_menu_item'` | Associated post type |
| `TYPE` | `'nav_menu_item'` | Setting type identifier |

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `self::TYPE` | 4.3.0 | Setting type |
| `$default` | array | public | *(see below)* | 4.3.0 | Default menu item data |
| `$transport` | string | public | `'refresh'` | 4.3.0 | Default transport. Changed to `'refresh'` in 4.5.0. |
| `$post_id` | int | public | — | 4.3.0 | The post ID (db_id). Negative = placeholder for unsaved item. |
| `$value` | array\|null | protected | — | 4.3.0 | Cached pre-setup menu item |
| `$previous_post_id` | int | public | — | 4.3.0 | Previous placeholder post ID before insert |
| `$original_nav_menu_term_id` | int | public | — | 4.3.0 | Previous nav_menu_term_id for preview filtering |
| `$is_updated` | bool | protected | `false` | 4.3.0 | Whether `update()` was called |
| `$update_status` | string | public | — | 4.3.0 | Status: `updated\|inserted\|deleted\|error` |
| `$update_error` | WP_Error | public | — | 4.3.0 | Error from `wp_update_nav_menu_item()` |

**Default value array:**
```php
array(
    'object_id'        => 0,
    'object'           => '',
    'menu_item_parent' => 0,
    'position'         => 0,
    'type'             => 'custom',
    'title'            => '',
    'url'              => '',
    'target'           => '',
    'attr_title'       => '',
    'description'      => '',
    'classes'          => '',
    'xfn'              => '',
    'status'           => 'publish',
    'nav_menu_term_id' => 0,
    '_invalid'         => false,
)
```

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.3.0 | Validates ID pattern, extracts `$post_id`, adds `wp_update_nav_menu_item` flush hook. Throws `Exception` on invalid ID or missing `nav_menus`. |
| `flush_cached_value( $menu_id, $menu_item_id )` | public | 4.3.0 | Clears cached `$value` when this item is updated. |
| `value()` | public | 4.3.0 | Returns menu item data array (or `false` for deletion). Adds read-only `type_label` and `original_title`. Uses `wp_setup_nav_menu_item()` for existing items. |
| `js_value()` | public | 6.8.3 | Prepares value for JS client; decodes `original_title` entities. |
| `get_original_title( $item )` | protected | 4.7.0 | Gets original title for post_type, taxonomy, or post_type_archive items. |
| `get_type_label( $item )` | protected | 4.7.0 | Gets human-readable type label. |
| `populate_value()` | protected | 4.3.0 | Normalizes value array: translates `menu_order`→`position`, `post_status`→`status`, resolves `nav_menu_term_id`, casts types, detects `_invalid` items, strips irrelevant post properties. |
| `preview()` | public | 4.3.0 | Sets up preview filters on `wp_get_nav_menu_items`. Returns `false` if no-op. |
| `filter_wp_get_nav_menu_items( $items, $menu, $args )` | public | 4.3.0 | Filters menu items for preview: removes deleted/moved items, updates modified items, appends new items. |
| `sort_wp_get_nav_menu_items( $items, $menu, $args )` | public static | 4.3.0 | Re-applies sort/filter logic from `wp_get_nav_menu_items()`. Removes invalid items on front end. |
| `value_as_wp_post_nav_menu_item()` | public | 4.3.0 | Converts setting value to a `WP_Post` object set up as a nav_menu_item via `wp_setup_nav_menu_item()`. |
| `sanitize( $value )` | public | 4.3.0 | Sanitizes menu item value. Returns `false` for deletion, `null` for invalid, `WP_Error` for invalid URL, or sanitized array. |
| `update( $value )` | protected | 4.3.0 | Creates/updates/deletes the nav_menu_item post. Resolves placeholder IDs for newly-created parent menus and items. Uses `wp_update_nav_menu_item()` / `wp_delete_post()`. |
| `amend_customize_save_response( $data )` | public | 4.3.0 | Exports `post_id`, `previous_post_id`, `error`, `status` to JS via `customize_save_response` filter. |

### Hooks

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `wp_nav_menu_item_custom_fields_customize_template` | action | 5.4.0 | Fires at end of menu item form template for additional custom fields |
| `customize_save_response` | filter | 4.3.0 | Used via `amend_customize_save_response()` to export save results |
| `wp_get_nav_menu_items` | filter | 4.3.0 | Filtered during preview |
| `the_title` | filter | — | Applied when getting original title (documented in `wp-includes/post-template.php`) |
| `nav_menu_attr_title` | filter | — | Applied in `value_as_wp_post_nav_menu_item()` (documented in `wp-includes/nav-menu.php`) |
| `nav_menu_description` | filter | — | Applied in `value_as_wp_post_nav_menu_item()` (documented in `wp-includes/nav-menu.php`) |
| `wp_setup_nav_menu_item` | filter | — | Applied in `value_as_wp_post_nav_menu_item()` (documented in `wp-includes/nav-menu.php`) |
| `title_save_pre` | filter | — | Applied during sanitization (documented in `wp-includes/post.php`) |
| `excerpt_save_pre` | filter | — | Applied during sanitization (documented in `wp-includes/post.php`) |
| `content_save_pre` | filter | — | Applied during sanitization (documented in `wp-includes/post.php`) |
| `customize_sanitize_{$this->id}` | filter | — | Applied at end of sanitize (documented in `class-wp-customize-setting.php`) |

---

## WP_Customize_Nav_Menu_Setting

Setting to represent a `nav_menu` taxonomy term.

**Source:** `wp-includes/customize/class-wp-customize-nav-menu-setting.php`  
**Since:** 4.3.0  
**Extends:** `WP_Customize_Setting`

### Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `ID_PATTERN` | `/^nav_menu\[(?P<id>-?\d+)\]$/` | Regex for valid setting IDs |
| `TAXONOMY` | `'nav_menu'` | Associated taxonomy |
| `TYPE` | `'nav_menu'` | Setting type identifier |

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$type` | string | public | `self::TYPE` | 4.3.0 | Setting type |
| `$default` | array | public | `['name'=>'', 'description'=>'', 'parent'=>0, 'auto_add'=>false]` | 4.3.0 | Default menu data |
| `$transport` | string | public | `'postMessage'` | 4.3.0 | Default transport |
| `$term_id` | int | public | — | 4.3.0 | Term ID. Negative = placeholder. |
| `$previous_term_id` | int | public | — | 4.3.0 | Previous placeholder term ID |
| `$is_updated` | bool | protected | `false` | 4.3.0 | Whether `update()` was called |
| `$update_status` | string | public | — | 4.3.0 | Status: `updated\|inserted\|deleted\|error` |
| `$update_error` | WP_Error | public | — | 4.3.0 | Error from `wp_update_nav_menu_object()` |
| `$_current_menus_sort_orderby` | string | protected | — | 4.3.0 | Temp storage for orderby (workaround for lack of closures) |
| `$_widget_nav_menu_updates` | array | protected | `array()` | 4.3.0 | Data for `customize_save_response` |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager, $id, $args )` | public | 4.3.0 | Validates ID pattern, extracts `$term_id`. Throws `Exception` on invalid. |
| `value()` | public | 4.3.0 | Returns menu data array from `wp_get_nav_menu_object()` including `auto_add` from `nav_menu_options`. |
| `preview()` | public | 4.3.0 | Adds filters on `wp_get_nav_menus`, `wp_get_nav_menu_object`, `nav_menu_options`. Returns `false` if no-op. |
| `filter_wp_get_nav_menus( $menus, $args )` | public | 4.3.0 | Inserts/updates/removes menu in the menus list during preview. Re-sorts by `$args['orderby']`. |
| `_sort_menus_by_orderby( $menu1, $menu2 )` | protected | 4.3.0 | **Deprecated 4.7.0.** Use `wp_list_sort()`. |
| `filter_wp_get_nav_menu_object( $menu_obj, $menu_id )` | public | 4.3.0 | Returns previewed menu object. Only handles integer ID lookups. |
| `filter_nav_menu_options( $nav_menu_options )` | public | 4.3.0 | Filters `nav_menu_options` to reflect auto_add preference. |
| `sanitize( $value )` | public | 4.3.0 | Sanitizes menu value. Names unnamed menus as `(unnamed)`. Returns `false` for deletion, `null` for invalid. |
| `update( $value )` | protected | 4.3.0 | Creates/updates/deletes nav menu via `wp_update_nav_menu_object()` / `wp_delete_nav_menu()`. Handles name conflicts by appending suffix. Updates nav_menu_locations and widget references for inserted menus. |
| `filter_nav_menu_options_value( $nav_menu_options, $menu_id, $auto_add )` | protected | 4.3.0 | Adds/removes menu ID from `nav_menu_options['auto_add']` array. |
| `amend_customize_save_response( $data )` | public | 4.3.0 | Exports `term_id`, `previous_term_id`, `error`, `status`, `saved_value` and widget updates to JS. |
