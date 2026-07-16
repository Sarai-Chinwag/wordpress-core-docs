# WP Docs WordPress Plugin

`wp-docs` is the first local artifact and synchronization contract for the WP Docs project. It makes an existing WordPress installation an editorial control plane while Git Markdown remains the publishing model consumed by the existing Blume frontend.

## Install

Copy this directory to `wp-content/plugins/wp-docs`, activate **WP Docs**, then set **Settings > Writing > Docs base URL** to an HTTPS hostname such as `https://docs.example.com`.

The plugin adds a private, hierarchical **Documents** type. Documents are editable in wp-admin and the block editor but have no WordPress public route, archive, search result, feed, rewrite, query variable, or sitemap entry. Their editor permalink and preview link point to the configured static hostname.

## Artifact Contract

`POST /wp-json/wpdocs/v1/export` emits sorted Markdown records and a versioned publication manifest. Records use a JSON object between `---` delimiters, requiring no YAML parser. The import endpoints are `POST /wp-json/wpdocs/v1/import/preview` and `/apply`; apply requires the exact preview plan and rejects stale state or conflicts. Equivalent `wpdocs export`, `wpdocs import-preview`, and `wpdocs import-apply` commands are registered for authenticated WP-CLI contexts.

An external orchestrator writes exported records into the Git Markdown corpus, reviews and accepts a Git commit, then lets Blume build it. That accepted Git commit is the publication record. The plugin intentionally has no GitHub, DNS, credentials, Git mutation, Spacefast, Hetzner, Pressable, WordPress.com, or deployment adapter.

## DNS And Static Hosting

Point `docs.example.com` DNS at the chosen static host and configure that host for HTTPS. Set the same hostname as the plugin's Docs base URL. The host serves the Blume-built static artifact; WordPress remains private editorial infrastructure. Provider adapters and remote Git transport are follow-up scope.
