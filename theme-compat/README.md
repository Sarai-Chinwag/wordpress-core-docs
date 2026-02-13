# Theme Compat — Fallback Templates

Overview of the WordPress core theme-compat subsystem.

**Source:** `wp-includes/theme-compat/`

---

## Purpose

The `theme-compat` directory provides **fallback template files** used when the active theme does not include its own version of a required template. There are two distinct groups:

### Legacy Templates (Deprecated 3.0.0)

These templates were created for backward compatibility with themes predating WordPress 3.0. Each triggers a `_deprecated_file()` notice when loaded, urging theme authors to provide their own. They use a **Kubrick-era** layout (the default theme from WordPress 1.5–2.9).

| File | Fallback For |
|------|-------------|
| [header.php](header.md) | `get_header()` |
| [footer.php](footer.md) | `get_footer()` |
| [sidebar.php](sidebar.md) | `get_sidebar()` |
| [comments.php](comments.md) | `comments_template()` |

### oEmbed / Embed Templates (Since 4.4.0 / 4.5.0)

These templates render the output when a WordPress post is embedded via oEmbed in an iframe. They form a complete mini-page (header → content/404 → footer).

| File | Fallback For |
|------|-------------|
| [embed.php](embed.md) | Base embed template (the page skeleton) |
| [header-embed.php](header-embed.md) | `get_header( 'embed' )` |
| [footer-embed.php](footer-embed.md) | `get_footer( 'embed' )` |
| [embed-content.php](embed-content.md) | `get_template_part( 'embed', 'content' )` |
| [embed-404.php](embed-404.md) | `get_template_part( 'embed', '404' )` |

---

## How Fallback Resolution Works

When WordPress calls `get_header()`, `get_footer()`, `get_sidebar()`, or `get_template_part()`, it first looks in the active theme. If no matching file exists there, it falls back to the corresponding file in `wp-includes/theme-compat/`.

For the embed system, `embed.php` is the entry point. It calls `get_header('embed')`, runs the loop with `get_template_part('embed', 'content')` or `get_template_part('embed', '404')`, then calls `get_footer('embed')`.

---

## Hooks Introduced

The embed templates define or reference these hooks:

| Hook | Type | Template | Since |
|------|------|----------|-------|
| `embed_head` | action | header-embed.php | 4.4.0 |
| `embed_footer` | action | footer-embed.php | 4.4.0 |
| `embed_content` | action | embed-content.php, embed-404.php | 4.4.0 |
| `embed_content_meta` | action | embed-content.php | 4.4.0 |
| `embed_thumbnail_id` | filter | embed-content.php | 4.9.0 |
| `embed_thumbnail_image_size` | filter | embed-content.php | 4.4.0 |
| `embed_thumbnail_image_shape` | filter | embed-content.php | 4.4.0 |

---

## File Index

- [comments.md](comments.md)
- [embed.md](embed.md)
- [embed-404.md](embed-404.md)
- [embed-content.md](embed-content.md)
- [footer.md](footer.md)
- [footer-embed.md](footer-embed.md)
- [header.md](header.md)
- [header-embed.md](header-embed.md)
- [sidebar.md](sidebar.md)
