# Studio Authoring Contract

WordPress Studio is the local canonical authoring backend. This repository does not create, start, or alter a Studio site; a human or compatible agent performs those actions using the Studio interface available in its environment.

## Minimal Site Contract

- Create a local WordPress Studio site with no required theme, plugin, credentials, or hosted service.
- Ensure the core REST API is available at `/wp-json/wp/v2/pages`.
- Seed the published hierarchical Pages in `studio/seed-pages.json`, preserving `slug`, `parent_slug`, and `menu_order`.
- Authors subsequently edit those Pages in wp-admin. The static builder reads published Pages only.

## Agent-Neutral Sequence

1. Use the locally available Studio CLI or Studio MCP server to create or select a local site. Do not record credentials in this repository.
2. Use its WordPress command or local WordPress REST interface to create the parent Pages before their children, using `studio/seed-pages.json` as the bounded source of truth.
3. Edit and publish Pages in wp-admin or through the same local interface.
4. Set `WP_DOCS_WORDPRESS_URL` to the site's local URL and run `npm run build:studio`.
5. Run `bash tests/verify-studio-spacefast.sh`; it uses the fixture and needs neither Studio nor credentials.
6. After a human explicitly approves publication, build the approved artifact and run `WP_DOCS_ALLOW_PUBLISH=1 npm run publish:spacefast`. Use `npm run publish:spacefast -- --dry-run` first.

Studio Code is one possible client for these operations, not a required dependency. Any agent with stable Studio CLI/MCP and local WordPress access can use the same sequence.
