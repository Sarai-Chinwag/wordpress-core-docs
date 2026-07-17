# WP Docs

This repository publishes WordPress.com developer documentation and WordPress.org documentation from a Git-managed Markdown corpus.

The goal is to produce comprehensive, massively useful WordPress documentation that is accurate, source-verified, and pleasant to navigate. The output should meet the quality bar set by the best modern documentation sites while fitting the WordPress.org documentation ecosystem.

## Publishing Model

For the hosted editorial workflow, WordPress is the editorial source of truth. Push MD is the Markdown export boundary and WordPress submits the deterministic static source archive directly to Spacefast. Markdown Database Integration (MDI) primary mode gives WordPress Studio and wp-admin a local editing interface for the bundled corpus; Studio Code is an optional client, not a dependency.

Blume reads `content/runtime/` directly (or `WP_DOCS_CONTENT_ROOT` when building a Push MD clone) and owns the generated Astro presentation, local search, and static SEO output. Spacefast is the first publication adapter and receives only the checked `dist/` artifact through `sf publish dist`.

## Repository Layout

- `sources/` — project-specific source inventories and generation targets.
- `agent/` — WP Docs-specific agent scope and bundle selection notes.
- `content/` — generated and reviewed documentation outputs plus page-level metadata.
- `recipes/` — project-specific WP Codebox recipes for reproducible generation and review runs.
- `provenance/` — lightweight provenance conventions that belong with this corpus.
- `content/runtime/` — canonical MDI Markdown corpus: 89 WordPress.com documents and 314 WordPress.org HelpHub articles.
- `blume.config.ts` — Blume presentation, navigation, SEO, AI, and static deployment configuration.
- `studio/` — local MDI/Studio authoring contract.
- `scripts/` — local Blume build adapters. Hosted publication runs inside WordPress.
- `docs/` — project architecture, decisions, and operating notes.
- `plugins/wp-docs/` — installable local WordPress editorial and Markdown artifact plugin; see `docs/wordpress-plugin.md`.

The full-coverage generation plan is tracked in `docs/full-coverage-generation-plan.md`.

## Archived Corpus

The previous generated corpus is preserved at:

- Branch: `archive/sarai-v1-generated-corpus`
- Tag: `sarai-v1-generated-corpus`

That archive is useful as seed material and historical context, but it is not the target information architecture for this project.

## Principles

- Generate from public WordPress source and public documentation sources.
- Keep generated drafts reproducible and disposable.
- Preserve provenance in generated page metadata and WP Codebox artifacts rather than inventing another artifact format here.
- Separate user-facing docs, developer docs, reference material, and internals.
- Treat navigation, search, examples, and information architecture as first-class product work.
- Compare the result against leading documentation sites, not against the minimum viable generated output.
- Optimize for eventual WordPress.org compatibility, not a standalone side project.
- Use strong documentation sites as structural references for information architecture and navigation, not as code or dependency templates.

## Boundaries

- `docs-agent` owns reusable agent behavior, prompts, and bundle mechanics.
- `wp-codebox` owns isolated WordPress execution, recipes, previews, and artifact bundles.
- This repo owns WordPress core and canonical plugin docs inputs, generated content, project-specific recipes, the Studio-to-static build, and publishing direction.

## Verify A Fresh Checkout

1. Install Node.js 22.12 or newer and run `npm ci`.
2. Run `npm test`.
3. Confirm the deterministic archive, request idempotency, upload, state mapping, resume, success, failure, and redaction tests pass.
4. See `plugins/wp-docs/README.md` for WordPress runtime steps.

## AI assistance

- **AI assistance:** Yes
- **Tool(s):** OpenAI gpt-5.6-terra via OpenCode
- **Used for:** Implementing and testing the WordPress-owned hosted publication candidate.
