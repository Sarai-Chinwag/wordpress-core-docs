# Reusable/Pattern Blocks

Blocks for reusing content across posts.

## core/block

Synced pattern (formerly "reusable block").

References a `wp_block` post that can be reused across the site. Changes to the pattern update everywhere it's used.

**Attributes:**
- `ref` (integer) — Pattern post ID
- `content` (object) — Overridable content (since 6.5)

**Supports:** className, customClassName: false, html: false, inserter: false, renaming: false

### How It Works

1. User creates synced pattern → saved as `wp_block` post type
2. Block stores reference to post ID
3. When rendered, fetches and renders the `wp_block` post content
4. All instances stay in sync

### Content Overrides (6.5+)

Synced patterns can have "overridable" content:

```json
{
  "ref": 123,
  "content": {
    "abc123": {
      "content": "Custom text for this instance"
    }
  }
}
```

Block attributes with `"metadata": { "bindings": { "content": { "source": "core/pattern-overrides" } } }` can be overridden per-instance while keeping the pattern synced.

### Database Storage

| Field | Value |
|-------|-------|
| `post_type` | `wp_block` |
| `post_title` | Pattern name |
| `post_content` | Serialized block content |
| `post_status` | `publish` |

### Categories

Patterns can be categorized using `wp_pattern_category` taxonomy.

### REST API

- `GET /wp/v2/blocks` — List patterns
- `POST /wp/v2/blocks` — Create pattern
- `GET /wp/v2/blocks/{id}` — Get pattern
- `PUT /wp/v2/blocks/{id}` — Update pattern
- `DELETE /wp/v2/blocks/{id}` — Delete pattern

---

## core/pattern

Pattern placeholder (internal use only).

Used during pattern insertion to temporarily hold the pattern reference before it's replaced with actual block content.

**Attributes:**
- `slug` (string) — Pattern slug (e.g., `theme-slug/pattern-name`)

**Supports:**
- `inserter: false` — Not shown in inserter
- `html: false` — No HTML editing
- `customClassName: false` — No custom class

### How It Works

1. User inserts pattern from inserter
2. `core/pattern` block created with slug
3. Editor immediately fetches pattern content
4. Block replaced with actual pattern blocks

This is a transient block — you won't see it in saved content.

---

## Pattern vs Reusable Block

| Feature | Synced Pattern (core/block) | Unsynced Pattern |
|---------|----------------------------|------------------|
| Storage | `wp_block` post | Not stored (copies blocks) |
| Synced | Yes — edits update everywhere | No — independent copies |
| Block | `core/block` with `ref` | Actual content blocks |
| Use case | Shared headers, CTAs | Starting templates |

### Creating Patterns

**Synced (Reusable):**
```js
wp.data.dispatch('core').saveEntityRecord('postType', 'wp_block', {
  title: 'My Pattern',
  content: '<!-- wp:paragraph --><p>Hello</p><!-- /wp:paragraph -->',
  status: 'publish'
});
```

**Unsynced (Theme Pattern):**
In theme's `patterns/` directory:
```php
<?php
/**
 * Title: My Pattern
 * Slug: theme-slug/my-pattern
 * Categories: featured
 */
?>
<!-- wp:paragraph -->
<p>Hello</p>
<!-- /wp:paragraph -->
```
