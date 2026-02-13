# footer-embed.php

Embed footer template — closes the HTML document for oEmbed iframes.

**Source:** `wp-includes/theme-compat/footer-embed.php`  
**Since:** 4.5.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_footer( 'embed' )` when the active theme has no `footer-embed.php`. Fires the footer hook and closes the document.

---

## Behavior

1. **Fires the `embed_footer` action.**
2. **Outputs closing `</body>` and `</html>` tags.**

---

## Hooks

### `embed_footer` (action)

```php
do_action( 'embed_footer' );
```

Fires before the closing `</body>` tag in the embed template. Used to print scripts or data for embeds.

**Since:** 4.4.0

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `do_action()` | Fire `embed_footer` |
