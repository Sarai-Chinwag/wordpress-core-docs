# Navigation and Search Metadata

The static frontend renders navigation from published WordPress Page hierarchy. The deterministic build fixture is `frontend/fixtures/pages.json`; it is for CI and review only, not an authoring fallback.

Search/navigation entries use this shape:

```json
{
  "id": "stable page id or slug",
  "title": "display title",
  "url": "runtime URL or committed content path",
  "section": "top-level docs section label",
  "sectionOrder": 10,
  "order": 10,
  "parent": "optional parent id for nested IA",
  "excerpt": "short result summary",
  "headings": ["visible heading"],
  "body": "plain-text searchable content"
}
```

Ordering is predictable: `sectionOrder`, then `order`, then `title`. The shell integration points are `[data-wp-docs-shell]`, `[data-wp-docs-sidebar]`, `[data-wp-docs-content]`, `[data-wp-docs-toc]`, and `[data-wp-docs-search]`.
