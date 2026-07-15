# WP Docs

This repository generates WordPress core and canonical plugin documentation with `docs-agent`. WordPress Pages are the canonical authoring surface; the repository preserves the corpus, source inventories, provenance, review policy, and static frontend.

The goal is to produce comprehensive, massively useful WordPress documentation that is accurate, source-verified, and pleasant to navigate. The output should meet the quality bar set by the best modern documentation sites while fitting the WordPress.org documentation ecosystem.

## Publishing Model

WordPress Studio runs locally because it gives human authors a familiar hierarchical Page editor and compatible agents a stable local CLI/MCP and WordPress interface. Studio Code is an optional client, not a dependency.

The frontend reads published hierarchical Pages through the core REST API and builds fully static HTML. Spacefast receives only the checked artifact in `dist/`; it never connects to local WordPress. This first proof deliberately is not a replacement for Git plus static hosting: WordPress adds local editorial hierarchy and wp-admin authoring, while Git remains the reviewable corpus and build contract.

## Repository Layout

- `sources/` — project-specific source inventories and generation targets.
- `agent/` — WP Docs-specific agent scope and bundle selection notes.
- `content/` — generated and reviewed documentation outputs plus page-level metadata.
- `recipes/` — project-specific WP Codebox recipes for reproducible generation and review runs.
- `provenance/` — lightweight provenance conventions that belong with this corpus.
- `frontend/` — bounded Astro static documentation frontend and deterministic fixture.
- `studio/` — local authoring-site and seed hierarchy contract.
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
2. Inspect `dist/developer/script-modules/index.html`; it is a complete nested static route with navigation, breadcrumbs, semantic content, and copied media.
3. To use a local Studio site after following `studio/README.md`, run `WP_DOCS_WORDPRESS_URL=http://localhost:8888 npm run build:studio`.
4. Before any human-approved publication, run `npm run publish:spacefast -- --dry-run`, which invokes `sf deploy dist --prebuilt --dry-run`. An approved publication invokes `sf deploy dist --prebuilt`; the wrapper only considers `dist/` and makes no mutation without `WP_DOCS_ALLOW_PUBLISH=1`.
