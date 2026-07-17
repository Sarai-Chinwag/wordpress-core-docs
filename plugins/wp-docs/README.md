# WP Docs WordPress Plugin

`wp-docs` adds a private WordPress documentation model and registers it with Push MD. WordPress remains the content source of truth; Push MD supplies the authenticated Git remote, conflict handling, branch review, and Markdown round trips consumed by the static documentation build.

## Install

Install and activate a Push MD build with content-adapter support, copy this directory to `wp-content/plugins/wp-docs`, and activate **WP Docs**. The Docs base URL is available in **Settings > Writing** and through the authenticated core `GET`/`PUT /wp-json/wp/v2/settings` endpoint as `wpdocs_base_url`; there is no plugin-specific settings API.

The plugin adds a private, hierarchical **Documents** type. Documents are editable in wp-admin and the block editor but have no WordPress public route, archive, search result, feed, rewrite, query variable, or sitemap entry. Their editor permalink and preview link point to the configured static hostname.

## Git Contract

Push MD exposes the site at `/wp-json/git/v1/md.git`. Documents use nested `wpdocs_document/<parent>/<document>.md` paths. Their `collections` and `topics` front matter values are sorted taxonomy slugs.

Taxonomy terms must already exist in WordPress before a Git push assigns them. Push MD rejects unknown or non-canonical term slugs before changing content. Existing Push MD hierarchy rules also require a nested document's parent to exist before the child is pushed.

The plugin registers provider-neutral WordPress 6.9+ Abilities for previewing, requesting, inspecting, and reporting publication. WordPress stores a bounded request history and updates the Docs base URL only after a credentialed external runner reports verified success. Provider hosting, DNS, Git mirrors, static builds, and deployment remain separate adapters. Spacefast is currently one adapter; a future Pressable or static-host adapter belongs outside this plugin.

## DNS And Static Hosting

Point `docs.example.com` DNS at the chosen static host and configure that host for HTTPS. Set the same hostname as the plugin's Docs base URL only after it serves the static artifact. The host serves the Blume-built static artifact; WordPress remains private editorial infrastructure. See `docs/customer-setup.md` for the provider-neutral setup command.

## Verification

`bash tests/verify-wordpress-plugin.sh` is self-contained and verifies syntax, the private content model, Push MD adapter registration, deterministic taxonomy metadata, validation, assignment failures, and static URLs.
