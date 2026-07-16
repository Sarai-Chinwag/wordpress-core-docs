---
type: document
title: Add HTTP headers
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/add-http-headers/"
tags:
timestamp: "2026-06-16T19:29:25+00:00"
wordpress:
  id: 2482
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:25"
  date_gmt: "2026-06-16 19:29:25"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: add-http-headers
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/add-http-headers/"
  comment_count: 0
---

This guide will show you how to add HTTP Headers to your WordPress.com website to handle various requests and responses.

This feature is available on sites with the [WordPress.com Business or Commerce plan](https://wordpress.com/hosting/?ref=developer-docs#pricing-grid).

## About HTTP headers

HTTP Headers pass additional information alongside an HTTP request or response on your website. HTTP headers will instruct your site on how to handle certain requests and gather information, depending on the source, service, or social network that the header code originates from.

Most HTTP headers are optimized on WordPress.com and will not require changing, but many can also be applied or modified on your website if you require it. Bear in mind that some HTTP header codes are not modifiable on WordPress.com if they present a security threat or if they conflict with other functions on the WordPress.com platform.

### List of common HTTP headers

Below is a table displaying common HTTP headers that can be applied to your site, with applicable notes on which HTTP headers cannot be modified on WordPress.com. You may also learn more about different [HTTP Headers from MDN](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers).

| Header | Description |
|---|---|
| **X-Robots-Tag** | Indicates how a web page will be indexed within public search engine results. The HTTP header is effectively equivalent to `<meta name="robots" content="...">`. |
| [Access-Control-Allow-Headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Headers) | Used in response to a preflight request, which includes the Access-Control-Request-Headers to indicate which HTTP headers can be used during the actual request. |
| [Access-Control-Allow-Methods](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Methods) | Specifies one or more methods allowed when accessing a resource in response to a preflight request. |
| [Access-Control-Allow-Credentials](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Credentials) | Tells browsers whether to expose the response to the frontend JavaScript code when the request’s credentials mode (Request.credentials) is `include`. |
| [Access-Control-Allow-Origin](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Allow-Origin) | Indicates whether the response can be shared with requesting code from the given origin. |
| [Access-Control-Expose-Headers](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Access-Control-Expose-Headers) | Allows a server to indicate which response headers should be made available to scripts running in the browser in response to a cross-origin request. |
| [X-Frame-Options](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options) | Indicates whether or not a browser should be allowed to render a page in a `<frame>`, `<iframe>`, `<embed>`, or `<object>`. Sites can use this to avoid click-jacking attacks, by ensuring that their content is not embedded into other sites. |
| [X-XSS-Protection](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection) | A feature of Internet Explorer, Chrome, and Safari that stops pages from loading when they detect reflected cross-site scripting (XSS) attacks. These protections are largely unnecessary in modern browsers when sites implement a strong Content-Security-Policy that disables the use of inline JavaScript (‘unsafe-inline’). |
| [X-Content-Type-Options](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options) | Indicates that the MIME types advertised in the Content-Type headers should be followed and not be changed. The HTTP header lets you avoid MIME type sniffing by saying that the MIME types are deliberately configured. |
| [Strict-Transport-Security](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security) | Informs browsers that the site should only be accessed using HTTPS and that any future attempts to access it using HTTP should automatically be converted to HTTPS. ***Note:** [Contact support](https://wordpress.com/sites?help-center=wapuu) to add `includeSubdomains` and `preload` directives*. |
| [Referrer-Policy](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy) | Controls how much referrer information (sent with the Referer header) should be included with requests. Aside from the HTTP header, you can set this policy in HTML. |
| [Content-Security-Policy](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Security-Policy) | Allows website administrators to control resources the user agent can load for a given page. With a few exceptions, policies mostly involve specifying server origins and script endpoints. This helps guard against cross-site scripting attacks.  This can be modified with a plugin like [Redirection](https://wordpress.org/plugins/redirection/) or using `custom-redirects.php`. |

## Add HTTP headers to a website

There are two methods you can use to add an HTTP response header to your site.

### Add HTTP headers with a redirection plugin

While there are several ways to add HTTP headers to a plugin-enabled website, our best recommendation is to use the [Redirection plugin](https://wordpress.com/plugins/redirection/).

While the name of the Redirection plugin suggests that it is solely for redirects, you can safely use this plugin to apply HTTP headers without using redirects at all. If you choose to only apply HTTP headers, then your pages will not be affected by any redirection.

After [installing](https://wordpress.com/support/plugins/install-a-plugin/) the Redirection plugin, you can take the following steps to add an HTTP header:

1. Visit the plugin settings by navigating to *Tools → Redirection*.
2. Click on the “**Site**” tab.
3. Scroll down to the “*HTTP Headers*” section at the bottom of the screen. Here, you will then find a table displaying a row for each HTTP header on your site.
4. Click the “**Add Header**” button to add a row to the table for another HTTP header.
5. Choose the following information:
    - *Location***:** Where should this HTTP header apply? Generally, `site` is the correct option for most HTTP headers.
    - *Header***:** Clicking this option gives a dropdown of common HTTP headers.
        - If the option you want to use is not available, you may also add a custom header, which will open a new box to add the custom HTTP header and the value.
        - Even if an option appears in the dropdown selection, it may not be available to use on the WordPress.com platform [as explained above](#about-http-headers).
    - *Value***:** This will show the options available for a given HTTP header. However, in the case of custom headers, this may appear as a blank field for you to complete.
6. Click the “**Update**” button, and the HTTP headers will be added to the requests and responses for your website.

It may take some time for the HTTP header changes to apply to your live website. While the changes will eventually update over time, you may also consider [clearing your browser cache](https://wordpress.com/support/browser-issues/#clear-your-browser-cache) and [clearing your website’s cache](https://wordpress.com/support/clear-your-sites-cache/#1-clear-your-site-s-cache).

### Add HTTP headers with PHP code

If you’re looking for a more advanced solution or if you wish to avoid the use of [plugins](https://wordpress.com/support/plugins/), you can also set HTTP headers via a `custom-redirects.php` file using the PHP `<a href="https://www.php.net/manual/en/function.header.php">header()</a>` function. This can be added to the root folder of the site using [SFTP](https://wordpress.com/support/sftp/).

Any modifications using SFTP are considered advanced site customization. You should not edit files unless you know exactly what the change will do, and we advise you to only use this method if you are familiar with using SFTP.

Here’s a general overview of how to add HTTP headers to your site files using SFTP:

1. Connect to your WordPress site using [your preferred SFTP](https://wordpress.com/support/sftp/) client.
2. By default, you should be in the root folder. Verify that you are in the `htdocs` folder (root) for WordPress.com sites. In that folder, create a new file called `custom-redirects.php`
3. Use a text editor from your device (such as TextEdit or Notepad) to edit the file as needed.
4. Save the file to the server.

An example of a valid `custom-redirects.php` file can be seen below:

```
<?php
header('X-XSS-Protection: 1; mode=block');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: no-referrer-when-downgrade');
```

&lt;?php header('X-XSS-Protection: 1; mode=block'); header('X-Content-Type-Options: nosniff'); header('X-Frame-Options: SAMEORIGIN'); header('Referrer-Policy: no-referrer-when-downgrade');CopyCopied
