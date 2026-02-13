# embed-content.php

Embed content template — renders a post's content within an oEmbed iframe.

**Source:** `wp-includes/theme-compat/embed-content.php`  
**Since:** 4.5.0  
**Subpackage:** Theme_Compat

---

## Purpose

Loaded by `get_template_part( 'embed', 'content' )` when the active theme has no `embed-content.php`. This is the main content template for embedded posts.

---

## Behavior

### 1. Wrapper

Opens `<div>` with `post_class( 'wp-embed' )`.

### 2. Thumbnail Resolution

Determines a thumbnail image to display:

- If `has_post_thumbnail()`: uses `get_post_thumbnail_id()`.
- If post type is `'attachment'` and `wp_attachment_is_image()`: uses `get_the_ID()`.
- The thumbnail ID is passed through the **`embed_thumbnail_id`** filter.

If a thumbnail ID is found:

- Retrieves attachment metadata via `wp_get_attachment_metadata()`.
- Iterates through `$meta['sizes']` to find the size with the **widest aspect ratio** (`width / height`). Starts with aspect ratio 1 and measurements `[1, 1]`, fallback image size `'full'`.
- The chosen size is passed through the **`embed_thumbnail_image_size`** filter.
- Determines **shape**: if `width / height >= 1.75`, shape is `'rectangular'`; otherwise `'square'`.
- The shape is passed through the **`embed_thumbnail_image_shape`** filter.

### 3. Rectangular Thumbnail (Above Title)

If thumbnail exists and shape is `'rectangular'`:
- Outputs `<div class="wp-embed-featured-image rectangular">` containing a link (`the_permalink()`, `target="_top"`) wrapping `wp_get_attachment_image()`.

### 4. Post Title

Outputs `<p class="wp-embed-heading">` with a link (`the_permalink()`, `target="_top"`) containing `the_title()`.

### 5. Square Thumbnail (After Title)

If thumbnail exists and shape is `'square'`:
- Outputs `<div class="wp-embed-featured-image square">` with the same link/image pattern.

### 6. Excerpt

Outputs `<div class="wp-embed-excerpt">` with `the_excerpt_embed()`.

### 7. `embed_content` Action

Fires after the excerpt. Documented here with `@since 4.4.0`.

### 8. Footer

Outputs `<div class="wp-embed-footer">` containing:
- `the_embed_site_title()` — site icon and name
- `<div class="wp-embed-meta">` containing the **`embed_content_meta`** action

### 9. Closes wrapper div.

---

## Hooks

### `embed_thumbnail_id` (filter)

```php
$thumbnail_id = apply_filters( 'embed_thumbnail_id', $thumbnail_id );
```

Filters the thumbnail image ID for use in the embed template.

**Since:** 4.9.0  
**Parameter:** `int|false $thumbnail_id` — Attachment ID, or false if none.

---

### `embed_thumbnail_image_size` (filter)

```php
$image_size = apply_filters( 'embed_thumbnail_image_size', $image_size, $thumbnail_id );
```

Filters the thumbnail image size for the embed template.

**Since:** 4.4.0 (added `$thumbnail_id` in 4.5.0)  
**Parameters:**
- `string $image_size` — Thumbnail image size slug.
- `int $thumbnail_id` — Attachment ID.

---

### `embed_thumbnail_image_shape` (filter)

```php
$shape = apply_filters( 'embed_thumbnail_image_shape', $shape, $thumbnail_id );
```

Filters the thumbnail shape. Rectangular images appear above the title; square images appear next to the content.

**Since:** 4.4.0 (added `$thumbnail_id` in 4.5.0)  
**Parameters:**
- `string $shape` — Either `'rectangular'` or `'square'`.
- `int $thumbnail_id` — Attachment ID.

---

### `embed_content` (action)

```php
do_action( 'embed_content' );
```

Prints additional content after the embed excerpt.

**Since:** 4.4.0

---

### `embed_content_meta` (action)

```php
do_action( 'embed_content_meta' );
```

Prints additional meta content in the embed template footer.

**Since:** 4.4.0

---

## Functions Called

| Function | Purpose |
|----------|---------|
| `post_class()` | CSS classes for wrapper |
| `has_post_thumbnail()` | Check for featured image |
| `get_post_thumbnail_id()` | Get featured image ID |
| `get_post_type()` | Check post type |
| `wp_attachment_is_image()` | Check if attachment is image |
| `get_the_ID()` | Current post ID |
| `apply_filters()` | Filter hooks |
| `wp_get_attachment_metadata()` | Image metadata |
| `wp_get_attachment_image()` | Render image tag |
| `the_permalink()` | Post permalink |
| `the_title()` | Post title |
| `the_excerpt_embed()` | Embed-specific excerpt |
| `do_action()` | Action hooks |
| `the_embed_site_title()` | Site icon and title |
