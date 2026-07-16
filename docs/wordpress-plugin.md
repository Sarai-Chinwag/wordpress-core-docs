# WordPress Plugin

`plugins/wp-docs` owns the WordPress documentation content model. It registers an admin-only hierarchical `wpdocs_document` post type, hierarchical collections, flat topics, and static documentation URLs.

Push MD owns Git transport, repository history, Markdown conversion, conflict detection, branch review, and WordPress mutations. WP Docs registers a content adapter that adds:

- nested `wpdocs_document/<parent>/<document>.md` paths;
- sorted `collections` and `topics` front matter values;
- pre-mutation rejection of invalid or missing taxonomy slugs;
- explicit taxonomy assignment errors.

The POC requires the Push MD content-adapter branch tracked by [Automattic/php-toolkit#79](https://github.com/Automattic/php-toolkit/issues/79). It does not maintain the earlier parallel WP Docs REST/CLI artifact protocol.

## Current limits

- Collections and topics must already exist in WordPress before Git assigns them.
- A parent document must exist before a nested child document can be pushed.
- Push MD-to-Blume translation, Git hosting mirrors, static deployment, and DNS remain setup-prompt steps rather than plugin behavior.

## Verification

Run `bash tests/verify-wordpress-plugin.sh` for the self-contained contract. Against an installed WordPress runtime with both plugins active, run `bash tests/verify-wordpress-plugin-runtime.sh /path/to/wordpress`.
