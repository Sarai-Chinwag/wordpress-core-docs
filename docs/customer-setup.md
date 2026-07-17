# Customer One-Shot Setup

This guide runs from a customer workstation or coding agent after Push MD and WP Docs are installed. WP Docs remains provider-neutral: it owns the private WordPress model and the core settings option; this repository's Spacefast script is only the first static publication adapter.

## Prerequisites

1. **WordPress.com Business or Commerce:** create a site administrator application password, install and activate Push MD with content-adapter support and WP Docs, and confirm the site can use installed plugins.
2. **Pressable:** ask the site owner or support to permit the two plugins, create an administrator application password, and use the site's HTTPS WordPress origin.
3. **Generic WP Cloud:** confirm WordPress REST application-password authentication is enabled, install and activate both plugins, and create an administrator application password for an administrator user.
4. Install Node.js 22.12+, npm, Git, and the authenticated `sf` CLI. Create or select the Spacefast target; it is `wp-docs` by default or `WP_DOCS_SPACEFAST_TARGET`.
5. Do not put the application password in a shell argument, URL, config file, or prompt transcript. Set `WP_DOCS_USERNAME` and `WP_DOCS_APP_PASSWORD` in the process environment, pipe the password with `WP_DOCS_APP_PASSWORD_STDIN=1`, or let the command securely prompt on a terminal.

## Canonical Agent Prompt

```text
From this WP Docs checkout, run the customer setup preflight only. Use environment variables for the WordPress administrator username and application password; never place secrets in command arguments, files, logs, or error reports. Report only the redacted preflight result. Do not approve or run mutations until I explicitly approve the published build plan.
```

## Commands

The preflight validates local commands, the normalized origin, authenticated WP Docs core settings REST access, the Push MD Git endpoint, content shape, build/publication plan, Spacefast login and target, and any existing domain attachment. It performs no mutation.

```sh
export WP_DOCS_ORIGIN='https://example.wordpress.com'
export WP_DOCS_USERNAME='administrator'
export WP_DOCS_APP_PASSWORD='application-password'
export WP_DOCS_SPACEFAST_TARGET='wp-docs'
export WP_DOCS_CUSTOM_HOSTNAME='docs.example.com' # optional
export WP_DOCS_DOCS_URL='https://docs.example.com' # required for an approved run
npm run setup:customer -- --dry-run
```

After explicit review, the approved run validates every destination before mutation, builds, publishes with `sf publish`, attaches an optional domain with `sf domains add`, checks its DNS/TLS diagnostics, verifies its HTTPS response, and only then updates `wpdocs_base_url` through `/wp-json/wp/v2/settings`.

```sh
WP_DOCS_ALLOW_SETUP=1 npm run setup:customer
```

To build a Push MD clone instead of the bundled corpus, clone it using normal Git credential handling and point the command at the clone root. Its `wpdocs_document/` hierarchy is copied as Blume input; the bundled `documentation/` and `helphub_article/` trees are unchanged when `WP_DOCS_CONTENT_ROOT` is unset.

```sh
export WP_DOCS_CONTENT_ROOT="$PWD/customer-push-md-clone"
npm run setup:customer -- --dry-run
```

## DNS, TLS, And Rollback

1. Add the DNS record Spacefast reports for `docs.example.com`.
2. Run the approved setup after propagation; following attachment it runs `sf domains check --wait` and `sf domains diagnostics` before changing WordPress.
3. Confirm `https://docs.example.com` returns a successful HTTPS response before approving the run. The command refuses to set WordPress's base URL otherwise.
4. To roll back, republish the prior reviewed Git revision, confirm its hostname serves, then `PUT /wp-json/wp/v2/settings` with the prior `wpdocs_base_url` (or clear it). Detach the custom domain only after traffic has moved.

Failures name the missing prerequisite: activate WP Docs/Push MD and use an administrator application password for REST or Git failures; run `sf login` for Spacefast authentication; correct the target for Spacefast target failures; and fix DNS/TLS before retrying hostname checks. The command never sends credentials as process arguments or prints them.
