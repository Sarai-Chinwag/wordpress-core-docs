# embed.php

Base embed template — the skeleton for oEmbed post embeds.

**Source:** `wp-includes/theme-compat/embed.php`  
**Since:** 4.4.0  
**Subpackage:** oEmbed

---

## Purpose

Loaded when a post is embedded in an iframe and the active theme does not include an `embed.php` template. This is the orchestrating template that assembles header, content, and footer.

---

## Behavior

1. **Calls `get_header( 'embed' )`** — loads `header-embed.php`.

2. **Runs the WordPress loop:**
   - If `have_posts()` is true: iterates with `the_post()` and calls `get_template_part( 'embed', 'content' )` for each post.
   - If no posts: calls `get_template_part( 'embed', '404' )`.

3. **Calls `get_footer( 'embed' )`** — loads `footer-embed.php`.

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `get_header()` | Load embed header (with `'embed'` slug) |
| `have_posts()` | Check for posts in loop |
| `the_post()` | Set up post data |
| `get_template_part()` | Load embed-content or embed-404 |
| `get_footer()` | Load embed footer (with `'embed'` slug) |
