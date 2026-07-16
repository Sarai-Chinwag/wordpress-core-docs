# Studio Authoring Contract

Git Markdown is canonical. WordPress Studio is an optional local MDI primary-mode editing interface, not a build-time backend. This repository does not create, start, or alter a Studio site; a human or compatible agent performs those actions using the Studio interface available in its environment.

## Minimal Site Contract

- Create a local WordPress Studio site with no required theme, plugin, credentials, or hosted service.
- Enable MDI primary mode against this repository's `content/runtime/` corpus.
- Authors edit the synchronized Markdown through wp-admin and commit the resulting Markdown changes to Git.
- Blume builds directly from Git; it does not call the local REST API.

## Verify A Configured Site

The live verifier is separate from the offline `tests/verify-studio-spacefast.sh` gate. It never creates or starts a Studio site, embeds a site URL, or sends credentials or content to a hosted service.

1. Create or select a compatible local Studio site and configure MDI `primary` mode with `MARKDOWN_DB_CONTENT_DIR` set to this checkout's `content/runtime/` directory and a distinct `MARKDOWN_DB_STATE_DIR`.
2. Ensure its MDI state root contains `markdown-index.sqlite`, `_options/`, and `_tables/`. MDI creates `_schema/` only when it persists non-core plugin table DDL, so that directory is optional; never allow it or any other state artifact in `content/runtime/`.
3. Run the read-only contract check with `npm run verify:studio -- --site-dir /path/to/wordpress`, or set `WP_DOCS_STUDIO_SITE_DIR` and run `npm run verify:studio`. The verifier prefers `studio wp --path` and falls back to `wp --path` when WP-CLI is installed separately.
4. Opt in to the reversible authoring-loop proof with `npm run verify:studio:mutate -- --site-dir /path/to/wordpress`, or pass `--mutate` to the verifier directly. It uses post `2431` (`documentation/agent-skills.md`), rejects a dirty or already-marked fixture, verifies both round-trip markers through fresh WordPress reads, then restores exact bytes, verifies neither marker remains, and checks Git cleanliness.
5. Run `bash tests/verify-studio-spacefast.sh` for the independent Git/Blume/Spacefast mock gate. It needs Node, Git content, Blume, and its mocked `sf` command only.

## Agent-Neutral Sequence

1. Use the locally available Studio CLI or Studio MCP server to create or select a local site. Do not record credentials in this repository.
2. Configure MDI primary mode to use this checkout's `content/runtime/` directory.
3. Edit through wp-admin or the same local interface, review the Markdown changes, and commit them to Git.
4. Run `npm run build`; it requires neither Studio nor credentials.
5. Run `bash tests/verify-studio-spacefast.sh`; it uses the committed corpus and needs neither Studio nor credentials.
6. After a human explicitly approves publication, build the approved artifact and run `WP_DOCS_ALLOW_PUBLISH=1 npm run publish:spacefast`, which invokes `sf deploy dist --prebuilt`. Use `npm run publish:spacefast -- --dry-run` first; it invokes `sf deploy dist --prebuilt --dry-run`.

Studio Code is one possible client for these operations, not a required dependency. Any agent with stable Studio CLI/MCP and local WordPress access can use the same sequence.
