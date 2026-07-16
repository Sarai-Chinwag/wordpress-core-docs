# WP Docs WordPress Plugin

`wp-docs` adds a private WordPress documentation model and registers it with Push MD. WordPress remains the content source of truth; Push MD supplies the authenticated Git remote, conflict handling, branch review, and Markdown round trips consumed by the static documentation build.

## Install

Install and activate a Push MD build with content-adapter support, copy this directory to `wp-content/plugins/wp-docs`, activate **WP Docs**, then set **Settings > Writing > Docs base URL** to an HTTPS hostname such as `https://docs.example.com`.

The plugin adds a private, hierarchical **Documents** type. Documents are editable in wp-admin and the block editor but have no WordPress public route, archive, search result, feed, rewrite, query variable, or sitemap entry. Their editor permalink and preview link point to the configured static hostname.

## Git Contract

Push MD exposes the site at `/wp-json/git/v1/md.git`. Documents use nested `wpdocs_document/<parent>/<document>.md` paths. Their `collections` and `topics` front matter values are sorted taxonomy slugs.

Taxonomy terms must already exist in WordPress before a Git push assigns them. Push MD rejects unknown or non-canonical term slugs before changing content. Existing Push MD hierarchy rules also require a nested document's parent to exist before the child is pushed.

The plugin does not implement a second REST, WP-CLI, manifest, or Git synchronization protocol. Provider hosting, DNS, Git mirrors, static builds, and deployment remain separate adapters.

## DNS And Static Hosting

Point `docs.example.com` DNS at the chosen static host and configure that host for HTTPS. Set the same hostname as the plugin's Docs base URL. The host serves the Blume-built static artifact; WordPress remains private editorial infrastructure. This POC stops at Push MD's Git transport boundary and does not publish static output or include deployment, provider, DNS, or external Git-mirror adapters.

## Verification

`bash tests/verify-wordpress-plugin.sh` is self-contained and verifies syntax, the private content model, Push MD adapter registration, deterministic taxonomy metadata, validation, assignment failures, and static URLs.
