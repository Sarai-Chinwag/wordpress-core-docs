# WordPress Editorial Plugin

`plugins/wp-docs` is a distributable WordPress plugin that provides the first local artifact and synchronization contract. It adds private hierarchical documentation records in wp-admin, serializes them as deterministic JSON-frontmatter Markdown, and plans safe imports. It does not replace the Git Markdown corpus or the existing Blume frontend.

Install by copying `plugins/wp-docs` into `wp-content/plugins/wp-docs`, activating it, and setting an HTTPS Docs base URL in **Settings > Writing**. Configure DNS for `docs.example.com` to the static host and serve the Blume artifact there. WordPress document links then use the static hostname while the WordPress frontend never exposes documents.

Export/import REST and WP-CLI interfaces exchange local artifacts only. External orchestration commits accepted Markdown to Git; that accepted commit is the publication record. Remote Git transport, host providers, DNS APIs, credentials, and deployment adapters are intentionally follow-up scope.
