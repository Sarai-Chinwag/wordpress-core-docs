# xmlrpc.php

## Purpose
XML-RPC endpoint for remote publishing and legacy APIs (MetaWeblog, Blogger, MovableType, etc.).

## Flow
- Defines `XMLRPC_REQUEST` and clears cookies.
- Reads raw POST body and loads WordPress.
- If `?rsd` is requested, outputs RSD discovery document and exits.
- Loads admin includes and XML-RPC server classes.
- Instantiates the XML-RPC server class (filterable) and serves the request.

## Key functions called
- `site_url()` / `bloginfo_rss()`
- `apply_filters( 'wp_xmlrpc_server_class', ... )`
- `$wp_xmlrpc_server->serve_request()`

## Hooks fired
- Actions:
  - `xmlrpc_rsd_apis`
- Filters:
  - `wp_xmlrpc_server_class`
