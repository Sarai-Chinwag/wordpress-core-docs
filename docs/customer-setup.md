# Customer Publication Runner

This guide runs from a customer workstation or coding agent after Push MD and WP Docs are installed. WordPress is the durable authority for publication requests; WP Docs remains provider-neutral and contains no deployment provider code. This repository's Spacefast script is the first external publication adapter.

## Prerequisites

1. **WordPress.com Business or Commerce:** create a site administrator application password, install and activate Push MD with content-adapter support and WP Docs, and confirm the site can use installed plugins.
2. **Pressable:** ask the site owner or support to permit the two plugins, create an administrator application password, and use the site's HTTPS WordPress origin.
3. **Generic WP Cloud:** confirm WordPress REST application-password authentication is enabled, install and activate both plugins, and create an administrator application password for an administrator user.
4. Install Node.js 22.12+, npm, Git, and the authenticated `sf` CLI. Create or select the Spacefast target; it is `wp-docs` by default or `WP_DOCS_SPACEFAST_TARGET`.
5. Do not put the application password in a shell argument, URL, config file, or prompt transcript. Set `WP_DOCS_USERNAME` and `WP_DOCS_APP_PASSWORD` in the process environment, pipe the password with `WP_DOCS_APP_PASSWORD_STDIN=1`, or let the command securely prompt on a terminal.

## Agent And Runner Boundary

```text
Use the authenticated WordPress Ability `wpdocs/request-publication` after the review boundary is approved. Then invoke `npm run setup:customer` with `WP_DOCS_ALLOW_SETUP=1` from the credentialed external runner. The runner consumes the oldest queued request and exits without publishing when none exists. Do not publish from autosaves. Report only redacted results and never place secrets in arguments, files, or logs.
```

An Agents API client invokes `POST /wp-json/wp-abilities/v1/abilities/wpdocs/request-publication/run` with `{}` using administrator authentication. Queuing does not start a process on WordPress; customer automation invokes or schedules the external runner, which claims the queued request by reporting `running`, then reports `succeeded` or `failed` at the equivalent `wpdocs/report-publication` route. The runner, not WordPress, owns Node, Git, Blume, `sf`, DNS, and HTTPS probing.

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

After explicit review creates the durable request, the approved runner consumes it, reports `running`, clones the authenticated Push MD endpoint to an ephemeral directory, builds, publishes with `sf publish --json`, attaches an optional domain with `sf domains add`, checks its DNS/TLS diagnostics, and verifies its HTTPS response. It reports the exact Spacefast space ID, live version ID, immutable version URL, source Git revision, and serving URL through the Ability surface. Only that verified `succeeded` report changes `wpdocs_base_url`.

```sh
WP_DOCS_ALLOW_SETUP=1 npm run setup:customer
```

Hosted runs default to an ephemeral authenticated Push MD clone when `WP_DOCS_CONTENT_ROOT` is unset. This prevents the old bundled `documentation/` and `helphub_article/` snapshot from being published as current `wpdocs_document` content. The bundled corpus is only an explicit seed/demo mode:

```sh
export WP_DOCS_SEED_CONTENT=1
npm run setup:customer -- --dry-run
```

Operators with WP-CLI can use the same service without duplicated behavior: `wp wpdocs publication preview`, `wp wpdocs publication request`, `wp wpdocs publication status <request-id>`, and `wp wpdocs publication report --request-id=<id> --state=running`. Reports of success additionally require `--verified --serving-url=https://docs.example.com --version=<provider-version-id> --identifier=<provider-artifact-id> --immutable-url=https://immutable-version.example.com --source-revision=<git-sha>`.

## DNS, TLS, And Rollback

1. Add the DNS record Spacefast reports for `docs.example.com`.
2. Run the approved setup after propagation; following attachment it runs `sf domains check --wait` and `sf domains diagnostics` before changing WordPress.
3. Confirm `https://docs.example.com` returns a successful HTTPS response before approving the run. The command refuses to set WordPress's base URL otherwise.
4. To roll back, request and publish the prior reviewed Git revision, then report its verified success. Detach the custom domain only after traffic has moved.

Failures name the missing prerequisite: activate WP Docs/Push MD and use an administrator application password for REST or Git failures; run `sf login` for Spacefast authentication; correct the target for Spacefast target failures; and fix DNS/TLS before retrying hostname checks. The command never sends credentials as process arguments or prints them.
