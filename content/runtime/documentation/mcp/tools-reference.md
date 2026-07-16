---
type: document
title: WordPress.com MCP tools reference
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/tools-reference/"
tags:
timestamp: "2026-06-16T19:29:19+00:00"
wordpress:
  id: 2441
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:19"
  date_gmt: "2026-06-16 19:29:19"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: tools-reference
  parent: 2442
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/tools-reference/"
  comment_count: 0
---

This document provides a comprehensive mapping of MCP tools available for WordPress.com developers. This is a living document and will be updated as new tools are added or existing ones are modified.

For exact input and output schemas, call the tool itself — every STRAP facade exposes `action: list` (operation catalog) and `action: describe` (full JSON Schema per operation). Schemas evolve, so always treat the live `describe` response as the source of truth.

## How WordPress.com MCP tools are organized

The WordPress.com MCP server exposes two kinds of tools:

- **STRAP facade tools** — A single MCP tool that wraps a family of related operations behind one entry point. Facades use a uniform action-based interface (`action: list | describe | execute`) so AI agents discover what’s available, fetch parameter schemas, and execute operations through one tool. This keeps the tool catalog small and predictable.
- **Standalone tools** — Single-purpose tools that take parameters directly. Used for operations that don’t fit a larger family (e.g. listing the user’s sites, generating a checkout URL).

⚠️ **Safety protocol:** All write, update, and delete operations require user confirmation. The agent must (1) describe exactly what it plans to do, (2) ask the user for explicit confirmation, and (3) include the user’s confirmation as `user_confirmed: true` in the execute `params`. Write operations are never auto-executed. Permanent deletions (taxonomy terms) additionally require `confirm_permanent_delete: true`.

## Action-based interface (STRAP facades)

Every STRAP facade tool accepts the same three top-level inputs:

- `action` (enum: `list` / `describe` / `execute`): What the agent wants to do.
- `list` — Discover available operations on this tool. Returns operation names, short descriptions, and disabled-operation reasons.
- `describe` — Get the full JSON Schema (parameters, types, required fields) for one operation.
- `execute` — Run an operation.
- `operation`: The operation name in `resource.action` form (e.g., `posts.create`, `theme.presets`).
- `params`: Operation-specific parameters. Write operations must include `user_confirmed: true`.

Most facades also require `wpcom_site` (a site ID or URL). The `wpcom-mcp-account` facade is the exception — it operates on the authenticated user.

All operations support an optional `include_fields` parameter to limit which fields are returned. Use it to keep responses context-efficient.

---

## STRAP facade tools

### Content Authoring ( `wpcom-mcp-content-authoring` )

Create, read, update, and delete content on a WordPress.com site — posts, pages, comments, media, categories, tags, block patterns, and content search.

💡 **Recommended sequence:** Call `wpcom-mcp-site-editor-context` first (`theme.active`, `theme.presets`) so content uses theme-aligned preset slugs (e.g. `"primary"`, `"large"`) instead of hard-coded colors and sizes.

#### Available operations

| Operation | Description |
|---|---|
| `posts.list` | List posts with optional filters (status, author, search, taxonomy, date range, ordering, pagination). |
| `posts.get` | Get a single post by ID or slug. Falls back to searching pages if a slug doesn’t match a post. |
| `posts.create` | Create a new post — creates as **draft** by default. Write. |
| `posts.update` | Update an existing post. Only provided fields change. If status is `publish`, changes go **live immediately**. Write. |
| `posts.delete` | Move a post to trash. Restorable from WordPress admin within 30 days. Write. |
| `pages.list` | List pages with optional filters (parent, status, search, ordering, pagination). |
| `pages.get` | Get a single page by ID or slug. |
| `pages.create` | Create a new page — creates as **draft** by default. Supports hierarchical structures and page templates. Write. |
| `pages.update` | Update an existing page. Only provided fields change. If status is `publish`, changes go live immediately. Write. |
| `pages.delete` | Move a page to trash. Restorable from WordPress admin within 30 days. Write. |
| `comments.list` | List comments with optional filters (status, post, author, search, date range, pagination). |
| `comments.get` | Get a single comment by ID. |
| `comments.create` | Create a comment on a post. Comments from authenticated users auto-populate author fields. Write. |
| `comments.update` | Update an existing comment. If status is `approved`, changes are visible immediately. Write. |
| `comments.delete` | Move a comment to trash. Write. |
| `media.list` | List media items with optional filters (mime type, post, author, search, date range, pagination). |
| `media.get` | Get a single media item by ID. |
| `media.create` | Upload a new media item (image, video, audio, document). Write. |
| `media.update` | Update media item metadata (not the file). Changes to `alt_text` and `caption` update **immediately** wherever the media is used. Write. |
| `media.delete` | Move a media item to trash. **May break content** that references it. Write. |
| `categories.list` | List categories with optional filters. |
| `categories.get` | Get a single category by ID. |
| `categories.create` | Create a new category. Supports hierarchical parent-child relationships. Write. |
| `categories.update` | Update an existing category. Changing the slug affects archive URLs **immediately** and may break links. Write. |
| `categories.delete` | **Permanently** delete a category — taxonomy terms have no trash. Assigned posts move to Uncategorized; child categories become top-level. Requires `confirm_permanent_delete: true`. |
| `tags.list` | List tags with optional filters. Tag search is case-insensitive. |
| `tags.get` | Get a single tag by ID. |
| `tags.create` | Create a new tag. Write. |
| `tags.update` | Update an existing tag. Changing the slug affects archive URLs immediately. Write. |
| `tags.delete` | **Permanently** delete a tag — removed from all associated posts. Requires `confirm_permanent_delete: true`. |
| `patterns.list` | List block patterns available on the site (theme, core, pattern directory). |
| `patterns.get` | Get a single block pattern by name, including its block markup. |
| `synced-patterns.list` | List the site’s synced (reusable) patterns. |
| `synced-patterns.get` | Get a single synced pattern by ID, including its block markup. |
| `content-search` | Free-text search across the site’s content (posts, pages, other post types). |

⚠️ **Destructive operations** (`posts.delete`, `pages.delete`, `comments.delete`, `media.delete`, `categories.delete`, `tags.delete`) require the agent to fetch and present the item being deleted (title, author, count of affected posts) before requesting confirmation.

💡 **Tip:** When creating pages, use `patterns.list` → `patterns.get` to fetch block patterns and compose full pages from multiple patterns. After every create or update, check the response’s `_content_warnings` field — WordPress may strip blocks or HTML during save.

---

### Site Editor Context ( `wpcom-mcp-site-editor-context` )

Query site design context — theme presets, applied styles, and registered block types. **Read-only** companion to Content Authoring. Use it **before** creating or updating content so the markup uses theme-aligned tokens rather than hard-coded values.

This facade uses `action: list | describe | get` (not `execute`, since it never writes).

💡 **Recommended sequence:** `theme.active` → `theme.presets` → (optionally) `blocks.allowed` → then create content via `wpcom-mcp-content-authoring`.

#### Available operations

| Operation | Description |
|---|---|
| `theme.active` | Get the active theme’s stylesheet slug and name. Use the `stylesheet` value when fetching `theme.presets` or `theme.styles`. |
| `theme.presets` | Get the site’s design tokens — color palette, font sizes, font families, gradients, spacing scale. Auto-resolves stylesheet from the active theme if omitted. |
| `theme.styles` | Get the site’s applied styles from `theme.json` — block-level overrides and element-level typography/colors. Complements `theme.presets`: presets are *what tokens exist*; styles are *how they’re applied*. |
| `blocks.allowed` | List block types registered on the site with name, title, description, category, and style variations. Apply a style variation as `is-style-{name}`. |

💡 **Tip:** Reference preset slugs in block markup — e.g., `has-primary-color` or `has-large-font-size` — rather than inline styles with raw hex or pixel values, so content adapts when the site’s design tokens change.

⚠️ **Important:** A block being registered does not guarantee its markup survives the REST API save pipeline unchanged. After every create or update via `wpcom-mcp-content-authoring`, check the `_content_warnings` field. If markup was stripped, use simpler block alternatives or ask the user how to proceed.

---

### Account ( `wpcom-mcp-account` )

Manage the authenticated user’s WordPress.com account — profile, notifications, achievements, domains, connections, security, and currency. Operates on the calling user; no `wpcom_site` parameter required.

#### Available operations

| Operation | Description |
|---|---|
| `profile.get` | Basic profile (username, email, display name, avatar, locale, timezone), optionally with preferences, stats, account info, social/activity data. |
| `profile.update` | Update profile fields (display name, bio, locale, etc.). Write. |
| `notifications.get` | Notification preferences across email, push, timeline, and other channels. Includes device list and delivery test. |
| `notifications.update` | Update notification settings. Write. |
| `inbox.get` | The user’s notification inbox (messages, alerts, mentions, likes, follows). Filter by type, unread, time range. |
| `achievements.get` | Earned badges, feats, gamification progress, and trophy case. |
| `domains.list` | List the authenticated user’s domains across all sites. |
| `domains.get` | Domain details: management capabilities, DNS configuration, DNSSEC, SSL status, maintenance state. |
| `domains.dns_records` | DNS records (A, AAAA, ALIAS, CAA, CNAME, MX, NS, SRV, TXT) for a single domain. |
| `domains.set_primary` | Set a custom domain as the primary domain for a site. Write. |
| `connections.get` | Social and third-party service connections (list, get details, test health). |
| `security.get` | Security status: 2FA, application passwords, active sessions, login history, account age. |
| `currency.preview` | Preview the impact of changing account currency (does not commit). |
| `currency.change` | Change account currency. Write. |

---

### Site ( `wpcom-mcp-site` )

Manage a WordPress.com site — settings, statistics, plugins, activity log, themes, and Jetpack module configuration. Requires `wpcom_site` (site ID or URL).

#### Available operations

| Operation | Description |
|---|---|
| `settings.get` | General, writing, reading, discussion, media, permalink, and privacy settings. |
| `settings.update` | Update site settings. Write. |
| `statistics.get` | Site totals — published posts, pages, subscribers — plus optional views, visitors, posts published, and pages published for a date range. Does NOT include top-posts, referrers, geo, or per-URL breakdowns. |
| `plugin.list` | Installed plugins with status, version, update availability, and permissions. |
| `activity.get` | Activity log entries (posts, comments, plugin updates, backups, user actions). Reverse-chronological. Defaults to the last 6 months. Filter by `activity_group` and `activity_action`. |
| `theme.list` | Installed themes on the site. |
| `theme.set` | Switch the active theme. Write. |
| `monitor.status` / `monitor.activate` / `monitor.deactivate` | Jetpack Monitor uptime checks. Activate/deactivate are writes. |
| `newsletter.status` / `newsletter.get_settings` | Jetpack Newsletter status and settings. |
| `account-protection.status` / `account-protection.activate` / `account-protection.deactivate` | Jetpack Account Protection. Activate/deactivate are writes. |
| `manage-site.status` / `manage-site.launch` / `manage-site.set-visibility` | Site lifecycle — coming-soon status, launch, visibility. Writes. |

💡 **Tip for `activity.get`:** combine `activity_group` (e.g. `["plugin"]`) and `activity_action` (e.g. `["activated", "deactivated"]`) to narrow investigations. Call without filters first to discover what’s available for a given site.

---

## Standalone tools

### List user sites ( `wpcom-user-sites` )

List the authenticated user’s accessible sites across WordPress.com and self-hosted Jetpack-connected sites. Use this to discover site IDs before calling site-scoped tools. Supports pagination, search, status and privacy filters, sorting, and optional site metrics.

---

### Search domain availability ( `wpcom-domain-purchase` )

Search for available domains and generate checkout links for registration on WordPress.com. Returns matching domains with prices and pre-built checkout URLs.

---

### Update DNS records ( `wpcom-domain-update-dns-records` )

Add or remove DNS records (A, AAAA, ALIAS, CAA, CNAME, MX, NS, SRV, TXT) for a single custom domain you manage.

⚠️ **Destructive operation.** Misconfigured DNS can break email and websites. Always fetch the current records (via `wpcom-mcp-account` → `domains.dns_records`) and describe the diff before requesting confirmation.

---

### Restore default DNS records ( `wpcom-domain-restore-default-dns-records` )

Restore the WordPress.com default A records (apex IPs) or the default `www` CNAME for a single custom domain. Gated by the “Update DNS records” setting.

---

### Update nameservers ( `wpcom-domain-update-nameservers` )

Set the nameservers for a single custom domain. Requires the caller to manage the site the domain is connected to. Accepts between 2 and 13 valid nameserver hostnames.

⚠️ Changing nameservers transfers DNS control away from WordPress.com. Email, websites, and other services may break if the new nameservers aren’t configured to serve the same records.

---

### Set external mail service ( `wpcom-domain-set-mail-service` )

Configure DNS records on a domain for an external mail service: Google Workspace, iCloud Mail, Office 365, or Zoho Mail.

⚠️ Overwrites the domain’s existing MX and related DNS records. Existing mail flow stops as soon as the new records propagate.

---

### Generate checkout URL ( `wpcom-checkout-url` )

Generate a pre-configured WordPress.com checkout URL for one or more products (new purchase) or for a subscription renewal. The URL takes the user to the WordPress.com checkout — payment happens in the browser, not via this tool.

---

### List WordPress.com plans ( `wpcom-plans-list` )

List WordPress.com plans with prices and per-tier feature lists. Read-only; useful for surfacing plan options before generating a checkout URL.

---

## Safety protocol summary

All write/delete operations enforce a mandatory confirmation flow. The agent must describe the action, get explicit user approval, and pass that approval as `user_confirmed: true` in the execute `params`.

| Behavior | Read | Create | Update | Delete (trash) | Delete (permanent) |
|---|---|---|---|---|---|
| Confirmation required | ❌ | ✅ | ✅ | ✅ | ✅ |
| Reversible | N/A | N/A | Partially (previous values lost) | ✅ Within 30 days | ❌ Permanent |
| Default status (content) | N/A | draft | No change | trash | Removed entirely |
| Extra flag | — | — | — | — | `confirm_permanent_delete: true` |

Permanent deletions (taxonomy terms like categories and tags) additionally require `confirm_permanent_delete: true` in `params`.

Accepted forms of `user_confirmed`: the boolean `true` (preferred), or one of the strings `"true"`, `"yes"`, `"on"`, `"1"`. Free-form approval phrases like `"yes do it"` are rejected — the agent must translate the user’s approval into one of these accepted forms.
