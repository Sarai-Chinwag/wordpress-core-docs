---
type: document
title: Connect a custom MCP client to WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/connect-custom-mcp-client/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2434
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: connect-custom-mcp-client
  parent: 2442
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/connect-custom-mcp-client/"
  comment_count: 0
---

If you’re building an MCP (Model Context Protocol) client or extending an existing one, integrating with WordPress.com lets your users bring their WordPress.com site data into your AI tool through a standard MCP interface. This enables workflows like searching across a site’s content, retrieving posts and pages for summarization or analysis, answering questions grounded in what’s published, and generally using WordPress.com as a trusted content source inside an MCP-enabled assistant.

This guide focuses on the WordPress.com-specific pieces: how to authenticate and which MCP endpoint to call. For general guidance on building an MCP client, see the [official MCP client documentation](https://modelcontextprotocol.io/docs/develop/build-client).

## Overview

WordPress.com exposes an MCP server over HTTPS and protects it with [OAuth 2.1](https://oauth.net/2.1/) using:

- **Dynamic Client Registration**: This allows you to register clients programmatically.
- **Authorization Code flow with PKCE**: Proof Key for Code Exchange (PKCE) is recommended for public clients like desktop and CLI applications.

The flow looks like this:

1. Register your client with WordPress.com to obtain a `client_id`
2. Send the user through the OAuth authorization step (with PKCE)
3. Exchange the authorization `code` for an `access_token`
4. Call the WordPress.com MCP endpoint with `Authorization: Bearer …`

## WordPress.com endpoints

All endpoints below are hosted on:

- **Base URL:** `https://public-api.wordpress.com`

### OAuth 2.1

- **Register client:** `POST /oauth2-1/register`
- **Authorize:** `GET /oauth2-1/authorize`
- **Token:** `POST /oauth2-1/token`

### MCP

- **WordPress.com MCP server:** `POST /wpcom/v2/mcp/v1`

## Step 1: Register your OAuth client

WordPress.com supports dynamic client registration, which means your MCP client can register itself without a separate manual setup step.

### Request

- `POST https://public-api.wordpress.com/oauth2-1/register`
- `Content-Type: application/json`

Example:

```
curl -X POST "https://public-api.wordpress.com/oauth2-1/register" 
  -H "Content-Type: application/json" 
  --data '{
    "client_name": "My MCP Client",
    "redirect_uris": ["http://localhost:8080/callback"],
    "grant_types": ["authorization_code", "refresh_token"]
  }'
```

### What you get back

The response includes a `client_id` and other metadata. WordPress.com is designed to support **public clients**, and registration responses typically indicate:

- `token_endpoint_auth_method: "none"`

That is, token requests do not require a client secret. PKCE provides the security for the authorization code exchange.

At a minimum, store the `client_id` you receive during registration and ensure you consistently use one of the exact `redirect_uri` values you registered. You can optionally keep the rest of the registration response (for example, timestamps or the registration client URI) if it helps with troubleshooting or inspecting client configuration later.

## Step 2: Send the user through authorization

To authenticate a user, your client will:

1. Generate a PKCE `code_verifier`
2. Derive a `code_challenge` using the `S256` method
3. Open (or redirect) the user to WordPress.com’s authorization page

### Authorize request

- `GET https://public-api.wordpress.com/oauth2-1/authorize`

Example:

```
https://public-api.wordpress.com/oauth2-1/authorize?
  response_type=code&
  client_id=YOUR_CLIENT_ID&
  redirect_uri=http://localhost:8080/callback&
  code_challenge=YOUR_CODE_CHALLENGE&
  code_challenge_method=S256&
  scope=auth
```

After the user approves access, WordPress.com redirects the browser back to your `redirect_uri` with a `code` query parameter. Your `redirect_uri` **must exactly match** one of the URIs you registered.

## Step 3: Exchange the authorization code for tokens

Once your client receives the authorization code, exchange it for an access token at the token endpoint.

### Token request

- `POST https://public-api.wordpress.com/oauth2-1/token`
- `Content-Type: application/x-www-form-urlencoded`

Example:

```
curl -X POST "https://public-api.wordpress.com/oauth2-1/token" 
  -H "Content-Type: application/x-www-form-urlencoded" 
  --data "grant_type=authorization_code&code=AUTHORIZATION_CODE&redirect_uri=http://localhost:8080/callback&code_verifier=YOUR_CODE_VERIFIER&client_id=YOUR_CLIENT_ID"
```

### Result

The token endpoint returns an OAuth response containing an `access_token` and may also include fields like `expires_in` and a `refresh_token`.

Use the `access_token` to authenticate calls to the WordPress.com MCP endpoint via `Authorization: Bearer YOUR_ACCESS_TOKEN`.

## Step 4: Call the WordPress.com MCP server

WordPress.com’s MCP server is accessed over HTTP by POSTing MCP requests to the MCP endpoint, authenticated with your OAuth access token.

### MCP request

- `POST https://public-api.wordpress.com/wpcom/v2/mcp/v1`

Headers:

- `Authorization: Bearer YOUR_ACCESS_TOKEN`
- `Content-Type: application/json`

Example:

```
{
  "method": "tools/call",
  "params": {
    "name": "wpcom-mcp-posts-search",
    "arguments": {
      "wpcom_site": "yoursite.wordpress.com",
      "search": "recent updates"
    }
  }
}
```

In this example, your client is asking WordPress.com’s MCP server to run the tool named `wpcom-mcp-posts-search` with the given arguments.

## Implementation notes

- **PKCE is required for public clients.** Don’t embed secrets in distributed apps.
- **All MCP calls must include `Authorization: Bearer …`** with a valid WordPress.com access token.
- **Redirect URIs must match registration.** If you use `http://localhost` during development, register that exact callback URL.
