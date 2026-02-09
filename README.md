# WordPress Core Documentation

AI-generated documentation from WordPress core source code using [Homeboy](https://github.com/Extra-Chill/homeboy).

## Purpose

This documentation is generated directly from WordPress source code to provide accurate, up-to-date reference material. The generation process follows the principle of **code-first verification** — every documented feature is verified to exist in code.

## Structure

Documentation mirrors WordPress core's code organization:

- [`abilities-api/`](./abilities-api/) — Abilities API (WP 6.9+)
- [`rest-api/`](./rest-api/) — REST API
- [`html-api/`](./html-api/) — HTML API
- [`blocks/`](./blocks/) — Block Editor (Gutenberg) internals
- [`interactivity-api/`](./interactivity-api/) — Interactivity API

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
