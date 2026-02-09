# @wordpress/scripts

Build tooling for WordPress block development.

## CLI Commands

Run via `wp-scripts` (installed by `@wordpress/scripts`).

- `wp-scripts start` — dev build with watch
- `wp-scripts build` — production build
- `wp-scripts lint-js` — ESLint
- `wp-scripts lint-style` — Stylelint
- `wp-scripts format` — Prettier
- `wp-scripts test-unit-js` — Jest
- `wp-scripts test-e2e` — Playwright/Cypress (when configured)

## Configuration Hooks

Customize behavior by providing config files in your project:

- `webpack.config.js` (extends default webpack config)
- `.babelrc` / `babel.config.js` (Babel overrides)
- `.eslintrc` (ESLint rules)
- `.stylelintrc` (Stylelint rules)
- `jest.config.js` (Jest overrides)

## Entry Points

Default entry is `src/index.js` and output goes to `build/` unless overridden by webpack config.
