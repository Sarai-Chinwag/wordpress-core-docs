# WP Docs

This repository publishes WordPress.com developer documentation and WordPress.org documentation from a Git-managed Markdown corpus.

The goal is to produce comprehensive, massively useful WordPress documentation that is accurate, source-verified, and pleasant to navigate. The output should meet the quality bar set by the best modern documentation sites while fitting the WordPress.org documentation ecosystem.

## Publishing Model

Markdown in Git is canonical. Markdown Database Integration (MDI) primary mode gives WordPress Studio and wp-admin a local editing interface for that same corpus; Studio Code is an optional client, not a dependency.

Blume reads `content/runtime/` directly and owns the generated Astro presentation, local search, and static SEO output. Spacefast receives only the checked `dist/` artifact through `sf deploy dist --prebuilt`. Hosted WordPress and Push MD are migration inputs, not steady-state build or publishing dependencies.

## Repository Layout

- `sources/` — project-specific source inventories and generation targets.
- `agent/` — WP Docs-specific agent scope and bundle selection notes.
- `content/` — generated and reviewed documentation outputs plus page-level metadata.
- `recipes/` — project-specific WP Codebox recipes for reproducible generation and review runs.
- `provenance/` — lightweight provenance conventions that belong with this corpus.
- `content/runtime/` — canonical MDI Markdown corpus: 89 WordPress.com documents and 314 WordPress.org HelpHub articles.
- `blume.config.ts` — Blume presentation, navigation, SEO, AI, and static deployment configuration.
- `studio/` — local MDI/Studio authoring contract.
- `scripts/` — build adapters and approval-gated publishing command.
- `docs/` — project architecture, decisions, and operating notes.

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

1. Install Node.js 22.12 or newer and run `bash tests/verify-studio-spacefast.sh`.
2. Inspect `dist/documentation/developer-tools/wp-cli/common-commands/index.html` and `dist/helphub_article/search-block/index.html` for representative nested and HelpHub routes.
3. Blume builds from Git Markdown without a running Studio site. Use Studio's MDI primary mode to edit the corpus locally, then commit those Markdown changes and rerun the build.
4. Before any human-approved publication, run `npm run publish:spacefast -- --dry-run`, which invokes `sf deploy dist --prebuilt --dry-run`. An approved publication invokes `sf deploy dist --prebuilt`; the wrapper only considers `dist/` and makes no mutation without `WP_DOCS_ALLOW_PUBLISH=1`.
