---
type: document
title: Agent Skills
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/agent-skills/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2431
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:18"
  modified_gmt: "2026-06-16 19:29:18"
  slug: agent-skills
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/agent-skills/"
  comment_count: 0
---

Agent Skills are a curated set of reusable “skills” (prompt/tooling packages) you can add to an AI coding agent’s toolbox to help it work more effectively on WordPress-related development tasks.

They standardize *how* an AI agent is instructed to perform common WordPress workflows, so you don’t have to re-explain context every time (e.g., how to approach UI design, static analysis, caching, and database optimization, etc.).

They aim to make agents:

- Safer, because they bake in best practices and guardrails
- More consistent and accounts for repeatable workflows
- Faster to onboard, as agents get immediate context

## How they’re installed

Agent Skills are pulled into your agent’s environment in one of two ways:

1. **Project-local install**: Skills live inside your project directory, so everyone on the project can use the same behaviors.
2. **Global install**: Skills live in the user’s coding agent configuration directory, so they apply across all projects.

In both cases, the coding agent reads the skills from disk and incorporates them into its operating instructions.

Because skills are content files, the safest update model is:

- Treat skills as versioned assets
- Periodically pull updates
- Review diffs before rolling them out broadly (especially for team-wide/shared setups)

If you’re using [WordPress Studio](https://developer.wordpress.com/docs/developer-tools/studio), check out our [Agent Skills in WordPress Studio doc](https://developer.wordpress.com/docs/developer-tools/studio/agent-skills-wordpress-studio/) to learn how to install skills globally or per site.

## What WordPress Agent Skills are available?

The list of available Agent Skills may change, so be sure to visit the[ public repo ](https://github.com/WordPress/agent-skills/)for the most up-to-date information.

There are skills for many WordPress fundamentals, including:

- Block development
- Plugin development
- REST API
- WordPress Playground
- Performance
- Interactivity API
- Design

## Installation options

There are a few ways to integrate `agent-skills`, depending on your environment and how you prefer to manage dependencies.

### Option 1: skills.sh

If you want a quick install without cloning and building the repo manually, use [skills.sh](https://skills.sh/), an installation helper that makes it easy to add agent skill files into your local environment.

Prerequisite: [Node.js](https://nodejs.org/en) (so you can run npx commands)

1. [Choose the skills](https://github.com/WordPress/agent-skills#available-skills) you want to install. You can also run `npx skills add https://github.com/WordPress/agent-skills --list` to view the names of all available skills.
2. Install skills. For example, the following would install `wordpress-router`, `wp-project-triage`, `wp-block-development`, `wp-block-themes`, and `wp-plugin-development` for Claude Code:

```
npx skills add https://github.com/WordPress/agent-skills 
  --agent claude-code 
  --skill wordpress-router 
  --skill wp-project-triage 
  --skill wp-block-development 
  --skill wp-block-themes 
  --skill wp-plugin-development
```

To target a different agent, swap `--agent claude-code` for your agent (for example, `--agent cursor`). You can also install to multiple agents by passing multiple `--agent` arguments.

During installation, you’ll be asked whether to install the skills globally or per project. Install skills globally by default by using the `--global` argument

To remove a skill, run `npx skills remove wp-block-themes`, swapping `wp-block-themes` for the skill you wish to remove.

To check for updates, run `npx skills check` and then `npx skills update` to update.

When removing skills or running updates, use the same scope as when you installed them. Global installs (`--global`) affects your machine-wide skills, while project installs affect the skills checked stored alongside that codebase.

### Option 2:

If you need full control, or you’re contributing to the skills themselves, [clone the skills repo](https://github.com/WordPress/agent-skills) and follow [the manual build/install steps](https://github.com/WordPress/agent-skills?tab=readme-ov-file#quick-start).

## Choosing skills: “all” vs “relevant” skills

You may not need all of the available Agent Skills for your project. Instead, you can add skills based on what you’re working on. For example:

- **Blocks / Gutenberg development**: `wp-block-developmen`t and `wp-interactivity-api`
- **Block themes/site editing**: `wp-block-themes` and `wpds`
- **Plugin development**: `wp-plugin-development` and `wp-abilities-api`

Install all skills when you’re:

- Doing broad refactors across multiple areas (blocks + themes + plugins), or
- Building platform tooling where you want maximum coverage.
