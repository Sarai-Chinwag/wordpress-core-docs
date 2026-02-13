# embed-404.php

Embed 404 template — displayed when an embedded post cannot be found.

**Source:** `wp-includes/theme-compat/embed-404.php`  
**Since:** 4.5.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_template_part( 'embed', '404' )` when the active theme has no `embed-404.php`. Shown in the embed iframe when `have_posts()` returns false.

---

## Behavior

1. **Opens `<div class="wp-embed">`.**

2. **Heading:** `<p class="wp-embed-heading">` with text "Oops! That embed cannot be found."

3. **Excerpt area:** `<div class="wp-embed-excerpt">` with a paragraph suggesting the user visit the site directly. Contains a link to `home_url()` with the site name from `get_bloginfo( 'name' )`.

4. **Fires the `embed_content` action** (documented in embed-content.php).

5. **Footer:** `<div class="wp-embed-footer">` containing `the_embed_site_title()`.

6. **Closes wrapper div.**

---

## Hooks

### `embed_content` (action)

```php
do_action( 'embed_content' );
```

Same hook as in embed-content.php. The PHPDoc comment in this file references the documentation in `wp-includes/theme-compat/embed-content.php`.

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `_e()` | Translated heading text |
| `__()` | Translated paragraph text |
| `printf()` | String formatting |
| `esc_url()` | Escape home URL |
| `home_url()` | Site home URL |
| `esc_html()` | Escape site name |
| `get_bloginfo()` | Site name |
| `do_action()` | Fire `embed_content` |
| `the_embed_site_title()` | Site icon and title |
