# comments.php

Fallback comments template for themes that do not provide their own.

**Source:** `wp-includes/theme-compat/comments.php`  
**Deprecated:** 3.0.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `comments_template()` when the active theme has no `comments.php`. Renders the comment list, navigation, and comment form for a post.

---

## Behavior

1. **Calls `_deprecated_file()`** — deprecation notice.

2. **Direct access protection:** If `$_SERVER['SCRIPT_FILENAME']` basename is `'comments.php'`, calls `die()` with a message preventing direct loading.

3. **Password-protected posts:** If `post_password_required()` returns true, outputs a `<p class="nocomments">` message asking for the password, then `return`s early.

4. **If `have_comments()` is true:**
   - Outputs an `<h3 id="comments">` heading:
     - If `get_comments_number()` is `'1'`: "One response to {title}" (using `get_the_title()`)
     - Otherwise: "{n} responses to {title}" using `_n()` for pluralization and `number_format_i18n()`
   - **Comment navigation** (top): `<div class="navigation">` with `previous_comments_link()` and `next_comments_link()`
   - **Comment list:** `<ol class="commentlist">` with `wp_list_comments()` (no arguments)
   - **Comment navigation** (bottom): identical to top

5. **If `have_comments()` is false:**
   - If `comments_open()`: outputs an empty HTML comment ("If comments are open, but there are no comments.")
   - If comments closed: outputs `<p class="nocomments">Comments are closed.</p>`

6. **Always calls `comment_form()`** at the end (no arguments).

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `_deprecated_file()` | Deprecation notice |
| `__()`, `_e()`, `_n()` | Translation (including pluralization) |
| `sprintf()`, `basename()` | String formatting |
| `post_password_required()` | Check if post needs password |
| `have_comments()` | Check if comments exist |
| `get_comments_number()` | Comment count |
| `get_the_title()` | Post title |
| `number_format_i18n()` | Localized number formatting |
| `previous_comments_link()` | Older comments pagination |
| `next_comments_link()` | Newer comments pagination |
| `wp_list_comments()` | Render comment list |
| `comments_open()` | Check if commenting is open |
| `comment_form()` | Render comment form |

---

## Variables Referenced

| Variable | Purpose |
|----------|---------|
| `$_SERVER['SCRIPT_FILENAME']` | Direct access protection |
