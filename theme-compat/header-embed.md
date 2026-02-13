# header-embed.php

Embed header template — HTML document opening for oEmbed iframes.

**Source:** `wp-includes/theme-compat/header-embed.php`  
**Since:** 4.5.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_header( 'embed' )` when the active theme has no `header-embed.php`. Opens the HTML document for embed output.

---

## Behavior

1. **Sets HTTP header:** If `headers_sent()` is false, sends `X-WP-embed: true` via `header()`.

2. **Outputs `<!DOCTYPE html>` and `<html>` tag** with `language_attributes()` and class `no-js`.

3. **`<head>` section:**
   - `<title>` via `wp_get_document_title()`
   - `<meta http-equiv="X-UA-Compatible" content="IE=edge">`
   - Fires the **`embed_head`** action

4. **Opens `<body>` tag** with `body_class()`.

---

## Hooks

### `embed_head` (action)

```php
do_action( 'embed_head' );
```

Fires in the `<head>` of the embed template. Used to print scripts, styles, or meta tags for embeds.

**Since:** 4.4.0

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `headers_sent()` | Check if HTTP headers already sent |
| `header()` | Send X-WP-embed header |
| `language_attributes()` | HTML lang attribute |
| `wp_get_document_title()` | Page title |
| `do_action()` | Fire `embed_head` |
| `body_class()` | Body CSS classes |
