# Studio Authoring Contract

Git Markdown is canonical. WordPress Studio is an optional local MDI primary-mode editing interface, not a build-time backend. This repository does not create, start, or alter a Studio site; a human or compatible agent performs those actions using the Studio interface available in its environment.

## Minimal Site Contract

- Create a local WordPress Studio site with no required theme, plugin, credentials, or hosted service.
- Enable MDI primary mode against this repository's `content/runtime/` corpus.
- Authors edit the synchronized Markdown through wp-admin and commit the resulting Markdown changes to Git.
- Blume builds directly from Git; it does not call the local REST API.

## Agent-Neutral Sequence

1. Use the locally available Studio CLI or Studio MCP server to create or select a local site. Do not record credentials in this repository.
2. Configure MDI primary mode to use this checkout's `content/runtime/` directory.
3. Edit through wp-admin or the same local interface, review the Markdown changes, and commit them to Git.
4. Run `npm run build`; it requires neither Studio nor credentials.
5. Run `bash tests/verify-studio-spacefast.sh`; it uses the committed corpus and needs neither Studio nor credentials.
6. After a human explicitly approves publication, build the approved artifact and run `WP_DOCS_ALLOW_PUBLISH=1 npm run publish:spacefast`, which invokes `sf deploy dist --prebuilt`. Use `npm run publish:spacefast -- --dry-run` first; it invokes `sf deploy dist --prebuilt --dry-run`.

Studio Code is one possible client for these operations, not a required dependency. Any agent with stable Studio CLI/MCP and local WordPress access can use the same sequence.
