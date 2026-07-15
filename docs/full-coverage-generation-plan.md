# Full-Coverage Generation Plan

## Goal

Build a full-coverage WordPress documentation system that starts as an internal Automattic docs site and can later generate high-quality documentation for WordPress Core, canonical plugins, and other products.

The goal is not a one-off generated page. The goal is a repeatable system that can inventory source material, plan documentation coverage, generate source-backed pages, track review state, and publish a modern docs experience comparable to leading documentation products.

## Quality Bar

WP Docs should be judged against strong docs products such as Next.js, shadcn/ui, Astro, and Laravel.

Common traits to match:

- Organize by reader intent, not source-file layout.
- Separate getting-started paths, guides, recipes, concepts, and reference.
- Make navigation, search, and page hierarchy feel intentionally designed.
- Keep API/reference coverage exhaustive and source-backed.
- Include examples that solve real developer and site-builder tasks.
- Show provenance, freshness, and review status clearly enough to build trust.

## Product Shape

```text
WP Docs
├── Start
│   ├── Local development
│   ├── Project structure
│   ├── Hooks and lifecycle
│   └── First plugin/theme/block paths
├── Build Sites
│   ├── Site Editor
│   ├── Themes
│   ├── Patterns
│   ├── Navigation
│   ├── Media
│   └── Performance basics
├── Extend WordPress
│   ├── Plugins
│   ├── Hooks
│   ├── Blocks
│   ├── REST API
│   ├── Script Modules
│   ├── Interactivity API
│   ├── Data stores
│   └── Admin screens
├── APIs
│   ├── Functions
│   ├── Classes
│   ├── Hooks
│   ├── REST endpoints
│   ├── Blocks
│   ├── CLI commands
│   └── Configuration constants
├── Core Internals
│   ├── Bootstrap
│   ├── Query system
│   ├── Rewrite and routing
│   ├── Roles and capabilities
│   ├── Options and metadata
│   ├── Cron
│   ├── Filesystem
│   └── Install, upgrade, and updates
├── Recipes
│   ├── Add an admin page
│   ├── Register a block
│   ├── Add a REST endpoint
│   ├── Enqueue assets
│   ├── Build a settings screen
│   └── Debug common failures
└── Upgrade and Compatibility
    ├── Version changes
    ├── Deprecations
    ├── Migration guides
    └── Compatibility tables
```

## Coverage Model

Full coverage means every important source surface is accounted for, even before every page is reviewed.

Initial WordPress Core coverage dimensions:

- Public PHP functions, classes, interfaces, traits, methods, and constants.
- Hooks, including actions, filters, dynamic hook families, parameters, and call sites.
- Blocks, block supports, block metadata, and editor behavior.
- REST API routes, controllers, schemas, permissions, and examples.
- Script Modules and classic asset APIs.
- Interactivity API and related packages.
- Options, constants, configuration files, and filesystem conventions.
- WP-CLI commands where the source product includes them.
- Core subsystems: bootstrap, query, rewrite, users, roles/caps, cron, updates, media, editor, themes, plugins, HTTP, filesystem, database, and multisite.
- Tests and fixtures as behavioral evidence.
- Dev notes, make/core posts, handbooks, and existing docs as explanatory context.
- Deprecations, version history, and migration notes.

Coverage state should be explicit:

```text
discovered -> classified -> page spec drafted -> generated -> source verified -> reviewed -> publish candidate -> accepted
```

## Generation Pipeline

```text
Source repos
  ├── wordpress-develop
  ├── gutenberg
  ├── wp-cli
  ├── canonical plugins
  └── existing public docs/dev notes
        |
        v
Source inventory extractor
  ├── symbols
  ├── hooks
  ├── blocks
  ├── REST routes
  ├── CLI commands
  ├── tests/examples
  └── docs references
        |
        v
Coverage map
  ├── source entity IDs
  ├── owning docs area
  ├── audience lane
  ├── review state
  └── freshness metadata
        |
        v
Page specs
  ├── page intent
  ├── required source evidence
  ├── required examples
  ├── output path
  ├── page template
  └── acceptance criteria
        |
        v
docs-agent generation
  ├── concepts
  ├── guides
  ├── recipes
  ├── reference pages
  └── metadata/source maps
        |
        v
Review and publish
  ├── local Studio Page review
  ├── Git review/PR to wp-docs
  ├── static artifact verification
  └── approval-gated Spacefast publication
```

## Runtime Architecture

Local WordPress Studio is the authoring kitchen. The `wp-docs` repository is the durable corpus, provenance, and review surface; Spacefast is only a destination for a prebuilt static artifact.

```text
Local Studio WordPress
├── wp-admin Page authoring
├── core Pages REST API
└── compatible Studio CLI/MCP clients
      |
      v
Astro static build
├── hierarchy-aware navigation and breadcrumbs
├── copied local media
└── dist/ artifact
      |
      v
Spacefast static publication after approval
```

## Responsibilities

`wp-docs` owns:

- Source manifests and coverage targets.
- Information architecture and content lanes.
- Page specs, schemas, and source maps.
- Generated and reviewed docs content.
- Static frontend and local authoring contract.
- Project-specific recipes and review policy.

`Automattic/docs-agent` owns:

- Reusable technical/user docs agent behavior.
- Agent prompts and audience-specific writing standards.
- Portable agent bundles, flows, and pipelines.

Local Studio tooling owns local site lifecycle and WordPress access. It is not configured or controlled by this repository.

## Page Specs

Generated pages must start from page specs. The system should avoid direct `source file -> prompt -> page` generation except for disposable experiments.

Page specs should define:

- Stable page ID and output path.
- Audience and lane.
- Reader intent.
- Required source files and source entities.
- Required examples.
- Required related pages.
- Page template.
- Acceptance criteria.
- Review state.

Example:

```json
{
  "id": "developer/script-modules/overview",
  "title": "Script Modules",
  "lane": "developer",
  "audience": "plugin, theme, and block developers",
  "intent": "Decide when and how to use Script Modules",
  "sources": [
    "wordpress-develop:src/wp-includes/script-modules.php",
    "wordpress-develop:src/wp-includes/class-wp-script-modules.php"
  ],
  "page_type": "guide",
  "output_path": "content/developer/script-modules/README.md",
  "must_include": [
    "when to use Script Modules",
    "register vs enqueue",
    "imports and dependencies",
    "comparison with classic scripts",
    "working examples",
    "common mistakes"
  ]
}
```

## Initial Milestones

1. Create the canonical planning issue and this plan document.
2. Define the first page-spec schema and information architecture file.
3. Build a WordPress Core coverage inventory from `wordpress-develop`.
4. Generate page specs for the Script Modules vertical slice.
5. Run docs-agent through the WP Docs runtime to generate Script Modules pages and provenance metadata.
6. Submit generated output through Git as a reviewable PR.
7. Expand from Script Modules to one complete subsystem at a time.
8. Add coverage dashboard/reporting so gaps are visible.
9. Add Gutenberg and canonical plugin source inventories.
10. Generalize the same bundle model for any product documentation set.

## Success Criteria

- Every source entity is either documented, intentionally excluded, or mapped to a future page spec.
- Generated pages include source-backed claims and usable examples.
- Review status is visible at page and coverage-map levels.
- The prebuilt static artifact provides useful navigation and reading without client JavaScript.
- The process can regenerate docs after upstream source changes without losing reviewed status.
- The same source inventory, provenance, and static-publication model can be reused for other WordPress documentation products.
