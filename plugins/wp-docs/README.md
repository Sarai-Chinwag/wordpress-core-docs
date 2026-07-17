# WP Docs WordPress Plugin

`wp-docs` adds a private WordPress documentation model and registers it with Push MD. WordPress owns hosted publication: it exports its published documents through Push MD, creates a deterministic Blume source archive, and submits, uploads, and reconciles a Spacefast build.

## Install

Install and activate a Push MD build with content-adapter support, copy this directory to `wp-content/plugins/wp-docs`, and activate **WP Docs**. The Docs base URL is available in **Settings > Writing** and through the authenticated core `GET`/`PUT /wp-json/wp/v2/settings` endpoint as `wpdocs_base_url`; there is no plugin-specific settings API.

The plugin adds a private, hierarchical **Documents** type. Documents are editable in wp-admin and the block editor but have no WordPress public route, archive, search result, feed, rewrite, query variable, or sitemap entry. Their editor permalink and preview link point to the configured static hostname.

## Publication Contract

Documents use the Push MD `build_markdown_path()` and `export_post_to_markdown()` APIs. Only published `wpdocs_document` posts are exported to `wpdocs_document/` in the source archive. The archive also contains the minimal Blume scaffold and has fixed metadata and lexical file order. Existing `documentation` and `helphub_article` content is never migrated or published by this plugin.

Taxonomy terms must already exist in WordPress before a Git push assigns them. Push MD rejects unknown or non-canonical term slugs before changing content. Existing Push MD hierarchy rules also require a nested document's parent to exist before the child is pushed.

Configure the server-only constants or environment variables `WPDOCS_SPACEFAST_API_URL`, `WPDOCS_SPACEFAST_TOKEN`, and `WPDOCS_SPACEFAST_SPACE_ID`. They are never read from WordPress options or copied into request records. A publication request sends `POST /v1/spaces/{spaceId}/builds` with an archive input, `live` channel, `preview: false`, and the WordPress request ID as `Idempotency-Key`; it uploads the returned source instruction as `application/gzip`, polls the build, and records only safe state, build ID, and produced or reused version ID.

WordPress 6.9+ Abilities expose `request-publication`, `get-publication-status`, `reconcile-publication`, `resume-publication`, `retry-publication`, and `cancel-publication`. Equivalent WP-CLI commands are `wp wpdocs publication request`, `status <request-id>`, `reconcile <request-id>`, `resume <request-id>`, `retry <request-id>`, and `cancel <request-id>`. `wpdocs_base_url` changes only after Spacefast returns `succeeded` with a version ID and an HTTPS serving URL.

The response adapter currently expects the documented task field names `data.buildId`, `data.status`, `data.upload.url`, `data.upload.method`, `data.upload.headers`, `data.producedVersionId`, `data.reusedVersionId`, and `data.siteUrl`. No public Spacefast build API schema was available in this checkout to verify those fields. `skipped` is retained as a terminal provider state and may record `reusedVersionId`; it never changes `wpdocs_base_url` until the provider contract confirms that it carries equivalent verified serving evidence.

## DNS And Static Hosting

Point `docs.example.com` DNS at the chosen static host and configure that host for HTTPS. Spacefast must return its verified HTTPS serving URL in the completed build response before WordPress changes document links.

## Verification

1. Install dependencies with `npm ci`.
2. Run `npm test`.
3. Confirm it reports `WP Docs hosted publication tests passed.`
4. For a WordPress runtime, activate Push MD and WP Docs, configure the three server-only Spacefast values, create and publish a `wpdocs_document`, then run `wp wpdocs publication request` and `wp wpdocs publication reconcile <request-id>` until it succeeds.

## Backwards Compatibility

The private CPT, taxonomies, URL behavior, and durable request option remain. The external `report-publication` Ability and CLI command are replaced by WordPress-owned request, reconcile, resume, retry, and cancel operations; callers using the report workflow must move to those operations. No existing `documentation` or `helphub_article` content is imported.
