# WordPress Core Documentation

AI-generated documentation from WordPress core source code using [Homeboy](https://github.com/Extra-Chill/homeboy).

## Purpose

This documentation is generated directly from WordPress source code to provide accurate, up-to-date reference material. The generation process follows the principle of **code-first verification** — every documented feature is verified to exist in code.

## Index

- [Getting Started](#getting-started)
- [Content](#content)
- [Users](#users)
- [Queries](#queries)
- [Themes](#themes)
- [Blocks](#blocks)
- [REST API](#rest-api)
- [JavaScript](#javascript)
- [Plugins](#plugins)
- [Infrastructure](#infrastructure)
- [Security](#security)
- [Admin](#admin)
- [Multisite](#multisite)
- [Legacy](#legacy)
- [Internals](#internals)
- [Development](#development)

## Getting Started

- [`bootstrap/`](./bootstrap/) — WordPress bootstrap process
- [`wp-config/`](./wp-config/) — Configuration constants and setup
- [`database-schema/`](./database-schema/) — Core database tables and schema

## Content

- [`posts/`](./posts/) — Post APIs and helpers
- [`post-types/`](./post-types/) — Post type registration and management
- [`taxonomies/`](./taxonomies/) — Taxonomy registration and terms
- [`metadata/`](./metadata/) — Metadata APIs
- [`comments/`](./comments/) — Comment APIs
- [`media/`](./media/) — Media library and uploads
- [`shortcodes/`](./shortcodes/) — Shortcode APIs
- [`embeds/`](./embeds/) — oEmbed and embed helpers

## Users

- [`users/`](./users/) — User APIs
- [`abilities-api/`](./abilities-api/) — Capabilities and abilities
- [`application-passwords/`](./application-passwords/) — Application passwords
- [`privacy/`](./privacy/) — Privacy tools and APIs

## Queries

- [`query/`](./query/) — Query classes and helpers
- [`database/`](./database/) — Database access and abstraction

## Themes

- [`themes/`](./themes/) — Theme APIs
- [`theme-json/`](./theme-json/) — Global styles and theme.json
- [`template-tags/`](./template-tags/) — Template tag functions
- [`customizer/`](./customizer/) — Customizer APIs
- [`widgets/`](./widgets/) — Widget APIs
- [`nav-menus/`](./nav-menus/) — Navigation menus
- [`style-engine/`](./style-engine/) — Style Engine
- [`fonts/`](./fonts/) — Web fonts and font collections

## Blocks

- [`blocks/`](./blocks/) — Block editor internals
- [`block-bindings/`](./block-bindings/) — Block bindings
- [`block-patterns/`](./block-patterns/) — Block patterns
- [`block-templates/`](./block-templates/) — Block templates
- [`block-development/`](./block-development/) — Block development utilities
- [`interactivity-api/`](./interactivity-api/) — Interactivity API
- [`editor/`](./editor/) — Editor APIs

## REST API

- [`rest-api/`](./rest-api/) — REST API
- [`rest-api-controllers/`](./rest-api-controllers/) — REST controllers
- [`rest-endpoints/`](./rest-endpoints/) — REST endpoints

## JavaScript

- [`scripts-styles/`](./scripts-styles/) — Script/style enqueueing
- [`script-modules/`](./script-modules/) — Script modules
- [`js-packages/`](./js-packages/) — Core JavaScript packages

## Plugins

- [`plugins/`](./plugins/) — Plugin APIs
- [`plugin-dependencies/`](./plugin-dependencies/) — Plugin dependency management
- [`hooks/`](./hooks/) — Actions and filters

## Infrastructure

- [`http/`](./http/) — HTTP API
- [`cache/`](./cache/) — Object cache APIs
- [`cron/`](./cron/) — WP-Cron
- [`rewrite/`](./rewrite/) — Rewrite rules
- [`l10n/`](./l10n/) — Localization
- [`formatting/`](./formatting/) — Formatting helpers
- [`errors/`](./errors/) — WP_Error and error handling
- [`options/`](./options/) — Options API
- [`email/`](./email/) — Email functions
- [`sitemaps/`](./sitemaps/) — XML sitemaps
- [`robots/`](./robots/) — Robots.txt handling
- [`site-health/`](./site-health/) — Site Health checks
- [`updates/`](./updates/) — Core update APIs

## Security

- [`recovery-mode/`](./recovery-mode/) — Recovery mode
- [`https/`](./https/) — HTTPS detection and enforcement

## Admin

- [`admin-api/`](./admin-api/) — Admin APIs
- [`admin-bar/`](./admin-bar/) — Admin bar
- [`ajax/`](./ajax/) — Admin AJAX handlers

## Multisite

- [`multisite/`](./multisite/) — Multisite APIs

## Legacy

- [`xmlrpc/`](./xmlrpc/) — XML-RPC API
- [`bookmarks/`](./bookmarks/) — Bookmarks (Blogroll)
- [`feeds/`](./feeds/) — Feed generation
- [`links/`](./links/) — Link manager

## Internals

- [`internals/`](./internals/) — Internal APIs
- [`walkers/`](./walkers/) — Walker classes
- [`diff/`](./diff/) — Diff utilities
- [`utilities/`](./utilities/) — Core utilities
- [`html-api/`](./html-api/) — HTML processing API

## Development

- [`coding-standards/`](./coding-standards/) — Core coding standards
- [`wp-cli/`](./wp-cli/) — WP-CLI integration

## Generation

Documentation is generated using:

```bash
homeboy docs scaffold wp-includes  # Analyze structure
# AI reads source, generates markdown
homeboy docs audit wp-includes     # Verify alignment
```

## Contributing

To regenerate or update documentation:

1. Ensure WordPress core source is available
2. Run scaffold to identify gaps
3. Generate docs from source following [Homeboy guidelines](https://github.com/Extra-Chill/homeboy/blob/main/docs/documentation/generation.md)
4. Run audit to verify

## Version

Generated from WordPress 6.9 (Development)
