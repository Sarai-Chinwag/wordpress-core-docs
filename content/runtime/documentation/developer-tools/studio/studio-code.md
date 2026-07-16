---
type: document
title: Studio Code
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/studio-code/"
tags:
timestamp: "2026-06-16T19:29:17+00:00"
wordpress:
  id: 2428
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:17"
  date_gmt: "2026-06-16 19:29:17"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: studio-code
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/studio-code/"
  comment_count: 0
---

Studio Code is currently in early access. Features, capabilities, and usage limits may change as it evolves.

Studio Code is an AI-powered coding agent built into the [Studio CLI](https://developer.wordpress.com/docs/developer-tools/studio/cli/). It gives you an interactive chat in your terminal where you can build, customize, and manage WordPress sites conversationally, creating themes, editing files, running WP-CLI commands, deploying previews and publishing your site, all through natural language.

## Getting started

Studio Code is available as part of the standalone Studio CLI npm package.

If you have the Studio desktop app installed with the [CLI enabled](https://developer.wordpress.com/docs/developer-tools/studio/cli/#0-installation), you can directly use `studio code` from the terminal.

You can run it directly with `npx`:

```
npx wp-studio@latest code
```

And can install it globally to use `studio code` directly:

```
npm i -g wp-studio@latest
studio code
```

### Connect to WordPress.com

By default, Studio Code uses WordPress.com infrastructure to generate AI responses. Log in to WordPress.com to get started:

1. Run studio code from your terminal.
2. Type /login in the chat.
3. A browser window will open. Log into your WordPress.com account and approve the connection.
4. Paste the authorization token back into the terminal to complete the login.

Alternatively, you can use your own Anthropic API key by typing /api-key in the chat.

## Using Studio Code

Once launched, Studio Code presents an interactive chat interface in your terminal. Type your request in natural language and the AI agent will carry it out, creating files, running commands, and making changes to your site.

You can press the ↓ arrow to select your Studio sites, or ↓ and → to select your WordPress.com remote sites.

### Example workflows

**Create a new site and customize it:**

```
> Create a new WordPress site called "My Portfolio" with PHP 8.2

> Build a minimal portfolio theme with a dark color scheme

> Add a homepage with a hero section and project grid
```

**Work with an existing site:**

```
studio code
```

**Share your work:**

```
> Create a preview site so I can share this with my client

> Update the preview site with my latest changes
```

**Publish your work:**

```
> Publish "My Portfolio" site to examplesite.com
```

The agent can read and write files in your site directory, run WP-CLI commands, take screenshots of your site, and push changes to WordPress.com, all based on your instructions.

### Slash commands

While chatting, you can use slash commands for quick actions:

| **Command** | **Description** |
|---|---|
| `/browser` | Open the active site in your browser |
| `/login` | Log in to WordPress.com |
| `/logout` | Log out of WordPress.com |
| `/api-key` | Set or update your Anthropic API key |
| `/model` | Switch the AI model (Sonnet or Opus) |
| `/provider` | Switch between WordPress.com and Anthropic API |
| `/preview` | Push the active site to WordPress.com as a preview |
| `/need-for-speed` | Run a performance audit on your site |
| `/annotate` | Open a visual inspector to annotate page elements and give the AI agent instructions |
| `/exit` | Exit the chat |

### AI providers

You can choose how AI responses are generated:

- **WordPress.com** (default): uses your WordPress.com account. No additional setup required beyond logging in. Limits will change after early access.
- **Anthropic API key**: uses your own API key for direct access to Claude. Set it with the /api-key command.

Switch providers with the `/provider` command.

### AI models

Studio Code supports two AI models:

- **Claude Sonnet 4.6** (default): fast and efficient for most tasks.
- **Claude Opus 4.6**: more capable for complex, multi-step tasks.

Switch models at any time with the `/model` command.

### Visual Inspector

`/annotate` opens your active site in a browser window with an annotation toolbar. Click “Annotate”, then click any element on the page and type an instruction. You can annotate multiple elements in one session — picking mode stays on after each save. When you’re done, click Done and the browser closes automatically.

The agent then prints a numbered summary of your annotations and asks for confirmation before making any file edits.

## Sessions

Studio Code automatically saves your conversation history so you can pick up where you left off.

### Resume a session

```
studio code sessions list                  # View all saved sessions

studio code sessions resume                # Interactive picker

studio code sessions resume latest         # Resume the most recent session

studio code sessions resume <id>           # Resume a specific session by ID
```

### Delete a session

```
studio code sessions delete                # Interactive picker

studio code sessions delete <id>           # Delete a specific session
```

### Disable session recording

If you prefer not to save conversations, use the –no-session-persistence flag:

```
studio code --no-session-persistence
```

## What Studio Code can do

Studio Code has access to a set of tools that let the AI agent interact with your WordPress environment:

**Site management**

- Create, start, stop, and delete local sites.
- List all local sites and view site details.

**File operations**

- Read, create, and edit theme and plugin files.
- Search files by name or content.

**WordPress CLI**

- Run any WP-CLI command (install plugins, manage posts, update settings, etc.).

**Content validation**

- Validate generated block content for correctness.

**Screenshots and performance**

- Take screenshots of your site (desktop and mobile).
- Run performance audits with Lighthouse-style metrics.

**Preview sites**

- Create, update, and delete preview sites on WordPress.com.

**Sync**

- Push your local site to WordPress.com.
- Pull a WordPress.com site to your local environment.

**Import and export**

- Import and export site backups.

## Command reference

```
studio code                                # Start a new chat session

studio code --path /path/to/site           # Start with a specific site directory

studio code --no-session-persistence       # Start without saving the session

studio code sessions list                  # List saved sessions

studio code sessions resume [id]           # Resume a session

studio code sessions delete [id]           # Delete a session
```

For the full set of options:

```
studio code --help
```
