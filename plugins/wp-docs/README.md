# WP Docs WordPress Plugin

`wp-docs` is the first local artifact and synchronization contract for the WP Docs project. It makes an existing WordPress installation an editorial control plane while Git Markdown remains the publishing model consumed by the existing Blume frontend.

## Install

Copy this directory to `wp-content/plugins/wp-docs`, activate **WP Docs**, then set **Settings > Writing > Docs base URL** to an HTTPS hostname such as `https://docs.example.com`.

The plugin adds a private, hierarchical **Documents** type. Documents are editable in wp-admin and the block editor but have no WordPress public route, archive, search result, feed, rewrite, query variable, or sitemap entry. Their editor permalink and preview link point to the configured static hostname.

## Artifact Contract

`POST /wp-json/wpdocs/v1/export` emits sorted Markdown records and a versioned publication manifest. Records use a JSON object between `---` delimiters, requiring no YAML parser. The manifest includes deterministic collection and topic records (`taxonomy`, `slug`, `name`, `description`, and `parent_slug`), while each document carries sorted collection/topic slug relationships.

REST imports accept inline Markdown artifact content in `records`. `POST /wp-json/wpdocs/v1/import/preview` validates identities, paths, parents, and hierarchy before returning a plan. Send that exact plan plus the same records to `/apply`; apply rejects stale plans and content conflicts before changing WordPress records. Imports never create missing parents implicitly.

WP-CLI uses files rather than treating argument text as record content:

```sh
wp wpdocs export > export.json
wp wpdocs import-preview records/root.md records/root/section.md > plan.json
wp wpdocs import-apply plan.json records/root.md records/root/section.md
```

The preview command reads each `<record.md>` path. Apply reads `<plan.json>` followed by `<record.md>` paths and reports missing, unreadable, or invalid files clearly.

An external orchestrator writes exported records into the Git Markdown corpus, reviews and accepts a Git commit, then lets Blume build it. That accepted Git commit is the publication record. The plugin intentionally has no GitHub, DNS, credentials, Git mutation, Spacefast, Hetzner, Pressable, WordPress.com, or deployment adapter.

## DNS And Static Hosting

Point `docs.example.com` DNS at the chosen static host and configure that host for HTTPS. Set the same hostname as the plugin's Docs base URL. The host serves the Blume-built static artifact; WordPress remains private editorial infrastructure. This first slice stops at deterministic export/import artifacts and does not publish static output, mutate Git, or include deployment, provider, DNS, or remote transport adapters.

## Verification

`bash tests/verify-wordpress-plugin.sh` is self-contained and verifies syntax plus the public artifact, hierarchy, collision, taxonomy, and file-input contracts. For an installed WordPress runtime, run `bash tests/verify-wordpress-plugin-runtime.sh /path/to/wordpress`; it activates the local plugin, checks registration and REST routes, and performs a read-only export without creating or editing content.
