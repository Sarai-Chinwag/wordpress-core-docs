# header.php

Fallback header template for themes that do not provide their own.

**Source:** `wp-includes/theme-compat/header.php`  
**Deprecated:** 3.0.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_header()` when the active theme has no `header.php`. Outputs a complete HTML document opening with Kubrick-era styling.

---

## Behavior

1. **Calls `_deprecated_file()`** — triggers a deprecation notice telling theme authors to include their own `header.php`.

2. **Outputs `<!DOCTYPE html>` and `<html>` tag** with `language_attributes()`.

3. **`<head>` section includes:**
   - XFN profile link (`https://gmpg.org/xfn/11`)
   - Content-Type meta tag via `bloginfo( 'html_type' )` and `bloginfo( 'charset' )`
   - Document title via `wp_get_document_title()`
   - Stylesheet link via `bloginfo( 'stylesheet_url' )`
   - Pingback link via `bloginfo( 'pingback_url' )`

4. **Kubrick background image logic:**
   - Checks if `get_stylesheet_directory() . '/images/kubrickbgwide.jpg'` exists via `file_exists()`
   - If it does, outputs an inline `<style>` block:
     - If `$withcomments` is empty AND `is_single()` is false: uses `kubrickbg-{text_direction}.jpg` (narrow, with sidebar)
     - Otherwise: uses `kubrickbgwide.jpg` (wide, no sidebar)

5. **Enqueues `comment-reply` script** if `is_singular()` returns true.

6. **Calls `wp_head()`**.

7. **Opens `<body>` tag** with `body_class()`.

8. **Outputs header markup:**
   - `<div id="page">`
   - `<div id="header" role="banner">` containing `<div id="headerimg">`
   - `<h1>` linking to `home_url()` with `bloginfo( 'name' )`
   - `<div class="description">` with `bloginfo( 'description' )`
   - Closing `</div>`s for headerimg and header
   - `<hr />`

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `_deprecated_file()` | Deprecation notice |
| `__()` | Translation |
| `sprintf()` | String formatting |
| `basename()` | Get filename |
| `language_attributes()` | HTML lang attribute |
| `bloginfo()` | Site info (html_type, charset, stylesheet_url, pingback_url, stylesheet_directory, text_direction, name, description, url) |
| `wp_get_document_title()` | Page title |
| `get_stylesheet_directory()` | Theme directory path |
| `file_exists()` | Check Kubrick background image |
| `is_single()` | Check if single post |
| `is_singular()` | Check if singular content |
| `wp_enqueue_script()` | Enqueue comment-reply JS |
| `wp_head()` | Head hook output |
| `body_class()` | Body CSS classes |
| `home_url()` | Site home URL |

---

## Variables Referenced

| Variable | Purpose |
|----------|---------|
| `$withcomments` | Global; if empty and not single, uses narrow background |
