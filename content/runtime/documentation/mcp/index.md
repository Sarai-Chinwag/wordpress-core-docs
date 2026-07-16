---
type: document
title: MCP on WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/mcp/"
tags:
timestamp: "2026-06-16T19:29:19+00:00"
wordpress:
  id: 2442
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:19"
  date_gmt: "2026-06-16 19:29:19"
  modified: "2026-06-16 19:29:19"
  modified_gmt: "2026-06-16 19:29:19"
  slug: mcp
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/mcp/"
  comment_count: 0
---

WordPress.com includes a built-in MCP ([Model Context Protocol](https://modelcontextprotocol.io/docs/getting-started/intro)) server, enabling seamless integration with MCP-enabled AI agents like Claude Desktop, VS Code, Cursor, and more.

MCP access is available on [all WordPress.com paid plans](http://WordPress.com).

## What is MCP?

MCP is an open protocol that standardizes how applications provide context to LLMs (Large Language Models). Connecting your AI agent to WordPress.com allows you to interact with your WordPress.com account and websites using the natural language interfaces that these AI applications provide.

At a high level, here’s how MCP adds context to your AI requests:

- You ask your AI agent for some information about your WordPress.com account or sites
- The AI agent uses an LLM to understand the request and determines that it needs more context. It checks if there are MCP tools it can use to enable that context.
- It finds the right MCP tool and attempts to request it. The AI agent asks for your permission to make that request.
- Once you give permission, the MCP tool request is made, and the specific data the tool can provide is returned. That data is then included in the request to the LLM.
- The LLM uses your original request and the context from the MCP tool to generate its response.

At no point in time is data shared between the MCP server and the LLM that you don’t have complete control over. It also does not use the data from the MCP tools to train AI models; the data is used only once as part of the original request.

## Requirements

To connect your AI agent application to WordPress.com, you simply need:

- A WordPress.com account with a paid plan
- MCP enabled on your account (see [Enable MCP on WordPress.com](#enable-mcp-on-wordpresscom) below)
- An MCP-enabled AI client such as [Claude Desktop](#claude-desktop), [ChatGPT](#chatGPT), [VS Code](https://code.visualstudio.com/docs/copilot/customization/mcp-servers), or [Cursor](https://docs.cursor.com/en/context/mcp)

The WordPress.com MCP server uses OAuth 2.1 for authentication, which handles the connection and authorization through your web browser; no additional software installation is required.

## Connecting Your AI Client

After enabling MCP on your WordPress.com account, you can connect any MCP-enabled AI client using the WordPress.com MCP server URL:

```
https://public-api.wordpress.com/wpcom/v2/mcp/v1
```

https://public-api.wordpress.com/wpcom/v2/mcp/v1CopyCopied

### Claude desktop

Claude Desktop connects to WordPress.com through the built-in Connectors Directory. For step-by-step setup instructions, see [Edit your site with Claude](https://wordpress.com/support/model-context-protocol-mcp-settings/connect-claude/).

### Claude Code

Claude Code connects by adding the WordPress.com MCP server to your local config file.

Run the following command in your terminal to add the MCP server

```
claude mcp add --transport http wpcom-mcp https://public-api.wordpress.com/wpcom/v2/mcp/v1
```

claude mcp add --transport http wpcom-mcp https://public-api.wordpress.com/wpcom/v2/mcp/v1CopyCopied

Then, when using Claude Code, run the `/mcp` slash command to authenticate the `wpcom-mcp` server with your WordPress.com account.

### ChatGPT

Connecting ChatGPT to WordPress.com requires enabling Developer Mode, creating a WordPress.com app via the MCP URL, and selecting the connector. A ChatGPT Plus, Pro, Team, or Enterprise plan is required. For the full walkthrough, see [Edit your site with ChatGPT](https://wordpress.com/support/connect-chatgpt/).

### Codex

Codex connects by adding the WordPress.com MCP server to your local config file.

Run the following command in your terminal to add the MCP server:

```
codex mcp add wpcom-mcp --url https://public-api.wordpress.com/wpcom/v2/mcp/v1
```

codex mcp add wpcom-mcp --url https://public-api.wordpress.com/wpcom/v2/mcp/v1CopyCopied

Codex will auto-detect that the WordPress.com MCP server needs to be authenticated, and trigger the OAuth authentication flow.

However, if you need to authenticate manually, you can run the following terminal command:

```
codex mcp login wpcom-mcp
```

codex mcp login wpcom-mcpCopyCopied

### Cursor

To connect Cursor to WordPress.com using the Cursor MCP Directory:

1. Open a web browser and navigate to <https://cursor.com/docs/context/mcp/directory>

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/cursor-mcp-directory.png)](https://developer.wordpress.com/wp-content/uploads/2025/10/cursor-mcp-directory.png)1. Search for “WordPress” and click on the **“+Add to Cursor”** button.

[![WordPress in the Cursor MCP directory](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-01-select-wordpress.jpg)](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-01-select-wordpress.jpg)1. This will trigger a browser action that will open your Cursor app and add the MCP configuration to the Tools &amp; MCP settings.

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/cursor-mcp-add-connection.png)](https://developer.wordpress.com/wp-content/uploads/2025/10/cursor-mcp-add-connection.png)1. Click **Install** to begin the authorization flow between Cursor and your WordPress.com account.
2. Grant Cursor access to your WordPress.com account through your browser.

[![Connect Cursor to WordPress.com](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-02-connect-wordpress.com_.jpg)](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-02-connect-wordpress.com_.jpg)1. Once the connection is complete, Cursor will have access to your WordPress.com sites through the MCP tools.

[![WordPress.com connected to Cursor](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-03-wordpress.com_.connected.jpg)](https://developer.wordpress.com/wp-content/uploads/2026/02/cursor-03-wordpress.com_.connected.jpg)### Other Clients

For other MCP-enabled clients, consult your client’s documentation for how to add an MCP server, then use the URL:

```
https://public-api.wordpress.com/wpcom/v2/mcp/v1
```

https://public-api.wordpress.com/wpcom/v2/mcp/v1CopyCopied

The OAuth 2.1 authentication flow will automatically guide you through browser-based authorization.

## Supported clients

You can use any MCP-enabled AI client application to connect to WordPress.com. If you don’t already have one, we’ve listed some of the most popular below.

- [Claude Desktop](https://modelcontextprotocol.io/quickstart/user#claude-desktop)
- [VS Code](https://code.visualstudio.com/docs/copilot/customization/mcp-servers)
- [Cursor](https://docs.cursor.com/en/context/mcp)

## Available MCP Tools

All WordPress.com MCP Tools are listed in the [WordPress.com MCP Tools Reference](https://developer.wordpress.com/docs/mcp/tools-reference/) doc.

## Enable MCP on WordPress.com

To use MCP on WordPress.com, you need to complete the following steps:

1. Enable MCP either on your WordPress.com account
2. Connect your MCP-enabled AI client
3. Accept the OAuth authentication request

To enable MCP on your WordPress.com account, navigate to your MCP settings [here](https://wordpress.com/me/mcp), or:

1. Log in to your WordPress.com dashboard.
2. Hover over your name in the top right-hand corner and then click “**My WordPress.com Account.”**
3. Click **MCP** on the *My Profile* page.

![Screenshot of a user profile page on WordPress.com, displaying profile details such as name, public display name, web address, and an 'About me' section. Features an option to edit the public avatar and a side menu with navigation links.](https://developer.wordpress.com/wp-content/uploads/2025/10/01-wordpress.com-account.png)To enable MCP on your account:

1. Toggle **“Enable MCP access.”**

[![AI and MCP settings showing the Enable MCP Access toggle](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-01.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-01.png)1. By default, all read-only [MCP tools](https://developer.wordpress.com/docs/mcp/tools-reference/) are enabled, and write tools are disabled.

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-02.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-02.png)1. You can enable or disable specific read or write tools by clicking on the relevant panel.

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-03.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-03.png)1. To configure an MCP client, click on the **“Connect external AI assistant”** button.
2. On the *Connect AI agent* page, select the client you wish to configure from the drop-down menu. The page will display a **Quick Setup** option and/or a **Manual Setup** option.
    - **Quick Setup**: This option allows you to set up the MCP configuration in just one click for a few of the available clients.
    - **Manual Setup**: This is a manual JSON configuration you’ll need to paste into your client application. View the linked setup instructions to ensure that you configure the MCP connection in your client application correctly.

![](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-04.png)## Disable MCP Access for specific sites

Underneath the read and write tool settings, you can also disable MCP access to specific sites.

Disabling access to specific sites will block all MCP tools for all users on that site, and override your account settings for that site.

To block MCP access for a site:

1. Search for, or select, a site from the list of available sites
2. The site will automatically be added to the list of *Restricted sites*

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-05.png)](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-05.png)1. You can enable MCP access for specific sites in the same way, by clicking **“Remove”** next to the site in the *Restricted sites* list.

[![](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-07.png?w=1024)](https://developer.wordpress.com/wp-content/uploads/2025/10/wordpress.com-mcp-07.png)## Authentication

The WordPress.com MCP server uses OAuth 2.1 for secure authentication. OAuth 2.1 is the latest OAuth standard, incorporating modern security best practices including:

- **PKCE (Proof Key for Code Exchange)**: Protects against authorization code interception
- **Dynamic Client Registration**: Your AI client can register automatically
- **Token Rotation**: Enhanced security through automatic token refresh
- **No Client Secrets Required**: Secure authentication without storing sensitive credentials

### How it works

1. When you add the WordPress.com MCP server to your AI client, the client will attempt to connect
2. Your web browser will automatically open to the WordPress.com authorization page
3. Log in to your WordPress.com account (if you aren’t already logged in)
4. Review and authorize the connection
5. You’ll be redirected back to your AI client, which can now access your WordPress.com sites

[![Authorization request from ChatGPT to connect to a WordPress.com site, offering options to approve or deny access.](https://developer.wordpress.com/wp-content/uploads/2025/10/chatgpt-approve-access.png)](https://developer.wordpress.com/wp-content/uploads/2025/10/chatgpt-approve-access.png)### Managing Connections

You can disconnect your AI client at any time through your WordPress.com account:

1. Go to **Security → [Connected Apps](https://wordpress.com/me/security/connected-applications)**
2. Find your AI client in the list (it may appear as “MCP Client” or with your client’s name)
3. Click **Disconnect** to revoke access

The OAuth 2.1 flow ensures your WordPress.com credentials are never stored on your computer or shared with your AI client; only secure, expiring access tokens are used.

## Troubleshooting

### Connection Issues

If you’re having trouble connecting to the WordPress.com MCP server:

1. **Verify MCP is enabled**: Check that MCP is enabled on your [WordPress.com account](https://wordpress.com/me/mcp)
2. **Check the URL**: Ensure you’re using the correct server URL: `https://public-api.wordpress.com/wpcom/v2/mcp/v1`
3. **Review authorization**: Make sure you completed the OAuth authorization flow in your browser
4. **Check connected apps**: Visit [Connected Apps](https://wordpress.com/me/security/connected-applications) to verify your client is connected
5. **Restart your client**: Try restarting your AI client application
6. **Check client logs**: Consult your AI client’s documentation for how to view connection logs

### Disabling tools

If you disable any tools on your [account](https://wordpress.com/me/mcp) or disable MCP on any sites, you will need to restart the MCP server connection in your AI client. This allows the application client to refresh the list of available tools.

Use WordPress.com MCP and our [other MCP servers](https://automattic.ai/mcp) to enhance your AI-powered workflows across all Automattic products
