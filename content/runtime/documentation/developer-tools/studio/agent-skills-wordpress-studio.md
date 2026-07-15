---
type: document
title: Agent Skills in WordPress Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/agent-skills-wordpress-studio/"
tags:
timestamp: "2026-06-16T19:29:17+00:00"
wordpress:
  id: 2426
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:17"
  date_gmt: "2026-06-16 19:29:17"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: agent-skills-wordpress-studio
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/agent-skills-wordpress-studio/"
  comment_count: 0
---

Agent Skills give your AI coding agent specialized knowledge about WordPress development. Studio bundles a set of skills you can install into your sites so agents like Claude Code or Cursor pick them up automatically.

## What are Agent Skills?

An Agent Skill is a `SKILL.md` file that tells the agent how to approach a specific area of WordPress development. When a skill is installed in a site, the agent reads it and applies the guidance it contains before starting work.

You can use skills to help agents handle tasks like:

- Building a custom block with the correct `block.json` structure
- Creating a plugin that follows WordPress coding standards and security practices
- Working with REST API routes and authentication

## Available skills in Studio

Studio ships with the following built-in skills:

- **Studio CLI**: WordPress development workflows using Studio CLI
- **Plugin Development**: Hooks, settings API, security, and packaging
- **Block Development**: `Block.json`, attributes, rendering, and deprecations
- **Block Themes**: Theme.json, templates, patterns, and style variations
- **REST API** — Routes, endpoints, schema, and authentication
- **WP-CLI &amp; Ops** — CLI commands, automation, and search-replace

## Where skills are stored

When a skill is installed, Studio copies it into the site directory:

![Folder structure of a web development project showing directories and files related to WordPress, including 'wp-config.php' and various folders like 'skills' and 'studio-cli'.](https://developer.wordpress.com/wp-content/uploads/2026/04/image-6.png?w=624)For agents that use Claude’s directory layout, Studio also creates a symlink at `.claude/skills/<skill-id>` pointing to the same location. No additional configuration is needed for Claude Code to pick up the skill.

## Installing and removing skills in Studio

There are two ways to manage skills in Studio – globally and per site.

You can find the global settings for skills under *Settings → Skills* modal:

![Settings menu for managing WordPress site skills, showing installed options like Studio CLI, Plugin Development, Block Development, and REST API, along with available skills.](https://developer.wordpress.com/wp-content/uploads/2026/04/screenshot-2026-04-21-at-14.49.53.png?w=1024)From that screen you can:

- Click *Install* next to an individual skill

![Interface for plugin development options including a brief description and install buttons.](https://developer.wordpress.com/wp-content/uploads/2026/04/image-5.png)- Click Install all to install every available skill at once
- Open the toggle menu next to an installed skill and select *Remove* to uninstall it

![Screenshot of a user interface showing installed WordPress tools, including 'Studio CLI' and 'Block Development', with a 'Remove' button highlighted.](https://developer.wordpress.com/wp-content/uploads/2026/04/image-7.png)Installing or removing a skill applies to all existing sites immediately. Any new site you create will also receive the currently installed skills automatically.

## Managing skills per site

The per-site modal reflects the actual state of the `.agents/skills/` directory on disk for a specific site. You can use it to manage skills for a specific site without changing the global selection.

You can access the per site skills selection from the **Overview** tab in the **Edit site** modal.
