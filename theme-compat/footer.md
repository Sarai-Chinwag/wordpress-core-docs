# footer.php

Fallback footer template for themes that do not provide their own.

**Source:** `wp-includes/theme-compat/footer.php`  
**Deprecated:** 3.0.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_footer()` when the active theme has no `footer.php`. Closes the HTML document opened by `header.php`.

---

## Behavior

1. **Calls `_deprecated_file()`** — deprecation notice urging themes to provide their own `footer.php`.

2. **Outputs:**
   - `<hr />`
   - `<div id="footer" role="contentinfo">` containing a `<p>` with "{site name} is proudly powered by WordPress" (with a link to `https://wordpress.org/`)
   - Closing `</div>` for footer
   - Closing `</div>` (for the `#page` div opened in `header.php`)
   - An HTML comment referencing designer Michael Heilemann / binarybonsai.com
   - A hidden comment: `"Just what do you think you're doing Dave?"`

3. **Calls `wp_footer()`**.

4. **Closes `</body>` and `</html>`**.

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `_deprecated_file()` | Deprecation notice |
| `__()` | Translation |
| `sprintf()` | String formatting |
| `basename()` | Get filename |
| `get_bloginfo()` | Site name |
| `wp_footer()` | Footer hook output |
