# sidebar.php

Fallback sidebar template for themes that do not provide their own.

**Source:** `wp-includes/theme-compat/sidebar.php`  
**Deprecated:** 3.0.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_sidebar()` when the active theme has no `sidebar.php`. Outputs a widgetized sidebar with contextual archive information and navigation.

---

## Behavior

1. **Calls `_deprecated_file()`** — deprecation notice.

2. **Opens `<div id="sidebar" role="complementary">` with a `<ul>`.**

3. **Dynamic sidebar check:** Calls `dynamic_sidebar()` — if the function doesn't exist or returns false (no widgets assigned), outputs the static fallback content below.

4. **Static fallback content (inside the `if` block):**

   a. **Search form** via `get_search_form()`.

   b. **Commented-out Author section** — HTML comment suggesting an author bio block.

   c. **Contextual archive messages** — checks page type and outputs a descriptive paragraph:
      - `is_404()` — no message (empty block)
      - `is_category()` — "You are currently browsing the archives for the {category} category." via `single_cat_title()`
      - `is_day()` — "You are currently browsing the {site} blog archives for the day {date}." Date formatted with `__( 'l, F jS, Y' )`
      - `is_month()` — "...archives for {month}." Date formatted with `__( 'F, Y' )`
      - `is_year()` — "...archives for the year {year}." via `get_the_time( 'Y' )`
      - `is_search()` — "You have searched the {site} blog archives for '{query}'." via `get_search_query()`
      - `is_paged()` (via `$_GET['paged']`) — "You are currently browsing the {site} blog archives."

5. **Navigation `<ul role="navigation">`:**
   - **Pages** via `wp_list_pages()` with title "Pages"
   - **Archives** (monthly) via `wp_get_archives( array( 'type' => 'monthly' ) )`
   - **Categories** via `wp_list_categories()` with `show_count => 1`

6. **Home/Page-specific content** (when `is_home()` or `is_page()`):
   - **Bookmarks** via `wp_list_bookmarks()`
   - **Meta section** with:
     - `wp_register()` — registration/admin link
     - `wp_loginout()` — login/logout link
     - `wp_meta()` — meta hook output

7. **Closes the sidebar divs.**

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `_deprecated_file()` | Deprecation notice |
| `__()`, `_e()` | Translation |
| `sprintf()`, `basename()` | String formatting |
| `dynamic_sidebar()` | Attempt to render widgets |
| `get_search_form()` | Search form |
| `is_404()`, `is_category()`, `is_day()`, `is_month()`, `is_year()`, `is_search()`, `is_paged()`, `is_home()`, `is_page()`, `is_single()` | Conditional tags |
| `single_cat_title()` | Current category name |
| `get_bloginfo()` | Site name and URL |
| `get_the_time()` | Formatted date |
| `get_search_query()` | Current search query |
| `esc_html()` | Escape search query for display |
| `wp_list_pages()` | List pages |
| `wp_get_archives()` | Monthly archive list |
| `wp_list_categories()` | Category list with counts |
| `wp_list_bookmarks()` | Blogroll/links |
| `wp_register()` | Registration/admin link |
| `wp_loginout()` | Login/logout link |
| `wp_meta()` | Sidebar meta hook |

---

## Variables Referenced

| Variable | Purpose |
|----------|---------|
| `$_GET['paged']` | Checked directly (not sanitized) to detect paginated views |
