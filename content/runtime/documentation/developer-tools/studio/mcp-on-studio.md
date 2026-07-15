---
type: document
title: MCP on Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/mcp-on-studio/"
tags:
timestamp: "2026-06-16T19:29:17+00:00"
wordpress:
  id: 2427
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:17"
  date_gmt: "2026-06-16 19:29:17"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: mcp-on-studio
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/mcp-on-studio/"
  comment_count: 0
---

Agent instruction files tell agents how to work with a Studio site, but they do not give agents direct access to it. For that, Studio also exposes an MCP (Model Context Protocol) server that agents connect to in order to create, start, stop, and interact with your local WordPress sites.

To connect an agent, go to **Settings → MCP** in Studio and copy the JSON configuration shown there. Add it to your agent’s MCP settings. For example, for Claude Code or Codex you can also run the connection command directly from the terminal:

```
{
  "wordpress-studio": {
    "command": "studio",
    "args": ["mcp"]
  }
}
```

[![](https://developer.wordpress.com/wp-content/uploads/2026/04/screenshot-2026-04-17-at-11.10.34.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2026/04/screenshot-2026-04-17-at-11.10.34.png)Common configuration file locations are:

- Claude Desktop
    - macOS: `~/Library/Application Support/Claude/claude_desktop_config.json`
    - Windows: `%APPDATA%Claudeclaude_desktop_config.json`
- Cursor:
    - Project: `.cursor/mcp.json`
    - Global `~/.cursor/mcp.json`

See the full setup guides for [Claude Code](https://code.claude.com/docs/en/mcp), [Claude Desktop,](https://modelcontextprotocol.io/docs/develop/connect-local-servers) [Codex](https://developers.openai.com/codex/mcp), [Cursor](https://cursor.com/docs/mcp#installing-mcp-servers), [Windsurf](https://docs.windsurf.com/windsurf/cascade/mcp), [VS Code](https://code.visualstudio.com/docs/copilot/customization/mcp-servers).

Once connected, the agent can use Studio tools such as creating sites, running WP-CLI commands, and taking screenshots, in addition to reading the instruction files and skills already present in the site directory.
