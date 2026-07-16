---
type: document
title: Xdebug in WordPress Studio
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/xdebug/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2435
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: xdebug
  parent: 2481
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/xdebug/"
  comment_count: 0
---

[Xdebug](https://xdebug.org/) is a debugging extension for PHP that enables you to set breakpoints, inspect variables, and step through your code. WordPress Studio includes Xdebug support, powered by WordPress Playground’s WebAssembly version of PHP.

## Enabling Xdebug

1. Select the site you want to debug.
2. Navigate to the **Settings** tab.
3. Click “**Edit site**.”
4. Check the “**Enable Xdebug**” checkbox.
5. Click **Save**.

The site will restart automatically with Xdebug enabled.

## Important limitations

- **Only one site at a time**: Xdebug can only be enabled for a single site at once. To enable it for a different site, you must first disable it on the current site.
- **Performance impact**: Xdebug may slow down site performance. Disable it when not actively debugging.

## Using Xdebug with your IDE

Once Xdebug is enabled for a site, you can connect your IDE (code editor) to debug WordPress plugins, themes, and core code.

### Visual Studio Code setup

1. Install the [PHP Debug extension](https://marketplace.visualstudio.com/items?itemName=xdebug.php-debug).
2. Create a `.vscode/launch.json` file in your project with the following configuration:

```
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/wordpress": "${workspaceFolder}"
      }
    }
  ]
}
```

1. Set breakpoints in your code.
2. Start the debugging session in Visual Studio Code (**Run** → **Start Debugging**).
3. Navigate to your site in the browser to trigger the breakpoints.

### PhpStorm Setup

1. Go to **Settings** → **PHP** → **Debug**.
2. Verify that the Xdebug port is set to **9003**.
3. To stop breaking at the first line:
    - Disable “Force break at first line when no path mapping specified”
    - Disable “Force break at first line when a script is outside the project”
4. Navigate to **Settings** -&gt; **PHP → Servers** and configure mapping for your site’s server:
    - Host: localhost:8884
    - Port: 80
    - File directory: /Users/USERNAME/Studio/SITEDIR
    - Absolute path on the server: `/wordpress`
5. Enable “**Start listening for PHP Debug Connections**” from the toolbar.
6. Set breakpoints in your code.
7. Navigate to your site in the browser to trigger the breakpoints.

## Learn more

For additional information about Xdebug integration, see the [WordPress Playground Xdebug documentation](https://wordpress.github.io/wordpress-playground/developers/xdebug/introduction).

Studio does not support WordPress Playground’s experimental flags or Chrome DevTools integration at this time.
