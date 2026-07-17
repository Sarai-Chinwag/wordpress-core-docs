# Hosted Publication

WordPress is the durable authority and publication runner. WP Cloud requires no Node.js, Git client, `sf` CLI, application password, or workstation report ability for hosted publication.

## Prerequisites

1. Install and activate Push MD with content-adapter support and WP Docs.
2. Set `WPDOCS_SPACEFAST_API_URL`, `WPDOCS_SPACEFAST_TOKEN`, and `WPDOCS_SPACEFAST_SPACE_ID` as server constants or environment variables.
3. Configure DNS and Spacefast so the provider returns an HTTPS serving URL when a build succeeds.

## Run A Publication

```text
Use the authenticated WordPress Ability `wpdocs/request-publication` after the review boundary is approved. WordPress exports only published `wpdocs_document` posts, creates the archive, creates the Spacefast build, uploads it, and polls its status.
```

An Agents API client invokes `POST /wp-json/wp-abilities/v1/abilities/wpdocs/request-publication/run` with `{}` using administrator authentication. Use `reconcile-publication` to poll, `resume-publication` if the provider requests a resumed upload, `retry-publication` after an unsuccessful terminal state, and `cancel-publication` where the provider supports cancellation.

Operators with WP-CLI use the same service: `wp wpdocs publication request`, `wp wpdocs publication status <request-id>`, `wp wpdocs publication reconcile <request-id>`, `wp wpdocs publication resume <request-id>`, `wp wpdocs publication retry <request-id>`, and `wp wpdocs publication cancel <request-id>`.

## DNS, TLS, And Rollback

1. Add the DNS record Spacefast reports for `docs.example.com`.
2. Request publication after propagation and reconcile until Spacefast returns `succeeded` with a version and HTTPS serving URL.
3. Confirm WordPress updated `wpdocs_base_url` only for that succeeded request.
4. To roll back, publish an earlier reviewed document revision as a new request.

Failures retain only a redacted provider message. Correct server configuration or provider state, then retry through WordPress.
