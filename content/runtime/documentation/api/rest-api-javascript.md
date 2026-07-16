---
type: document
title: "Using the REST API from JavaScript &amp; the browser (CORS)"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-javascript/"
tags:
timestamp: "2026-06-16T19:29:26+00:00"
wordpress:
  id: 2490
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:26"
  date_gmt: "2026-06-16 19:29:26"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: rest-api-javascript
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-javascript/"
  comment_count: 0
---

The [REST API](https://developer.wordpress.com/docs/api/) can be used directly from the browser using Javascript. If you whitelist the domains you want to use for your application, we will send the correct [CORS](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) headers. Both authenticated and unauthenticated calls are supported. To make authenticated requests follow the [implicit section of the OAuth documentation](https://developer.wordpress.com/docs/api/oauth2/#Implicit-Flow) to get a user token.

All examples use plain JavaScript with the Fetch API.

## Unauthenticated Requests

You can make unauthenticated GET requests with no additional work. Just make a simple HTTP request:

```
fetch("https://public-api.wordpress.com/rest/v1/sites/en.blog.wordpress.com/")
  .then(response => response.json())
  .then(data => {
    // data contains site information
  })
  .catch(error => {
    console.error('Error:', error);
  });
```

fetch("https://public-api.wordpress.com/rest/v1/sites/en.blog.wordpress.com/") .then(response =&gt; response.json()) .then(data =&gt; { // data contains site information }) .catch(error =&gt; { console.error('Error:', error); });CopyCopied

## Authenticated Requests

To make authenticated requests, you must provide a token that verifies the resource owner has granted the app permission to act on their behalf.

### Get/Store User Token

To get a valid access token for the current user, your app must use the OAuth workflow, where the user explicitly grants permission. For client-side apps, you can use the [OAuth 2.0 implicit flow](https://developer.wordpress.com/docs/api/oauth2/), which doesn’t require a client secret.

### Make the request

When making the request you just need to pass the access token as a header.

```
fetch(`https://public-api.wordpress.com/rest/v1/sites/${site_id}/posts/new`, {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${access_token}`,
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    content: 'testing test'
  })
})
.then(response => response.json())
.then(data => {
  // Handle the response data
})
.catch(error => {
  console.error('Error:', error);
});
```

fetch(`https://public-api.wordpress.com/rest/v1/sites/${site\_id}/posts/new`, { method: 'POST', headers: { 'Authorization': `Bearer ${access\_token}`, 'Content-Type': 'application/json' }, body: JSON.stringify({ content: 'testing test' }) }) .then(response =&gt; response.json()) .then(data =&gt; { // Handle the response data }) .catch(error =&gt; { console.error('Error:', error); });CopyCopied

### Whitelist Origins

To prevent CORS errors when making authenticated API calls from your browser-based application, you must whitelist the domains that will be making those requests. If you don’t whitelist your domain, you’ll receive a CORS error like this:

```
Access to XMLHttpRequest at 'https://public-api.wordpress.com/rest/v1/me/' from origin 'https://www.my-demo-domain.com' has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.
```

Access to XMLHttpRequest at 'https://public-api.wordpress.com/rest/v1/me/' from origin 'https://www.my-demo-domain.com' has been blocked by CORS policy: No 'Access-Control-Allow-Origin' header is present on the requested resource.CopyCopied

You can whitelist your domain(s) while creating or configuring your application with the [application manager](https://developer.wordpress.com/apps/).

[![Text input field for whitelisting JavaScript origins with instructions for making authenticated GET requests.](https://wpdeveloperstaging.files.wordpress.com/2024/02/4e730-screen-shot-2014-05-15-at-12-39-29-pm.png)](https://wpdeveloperstaging.files.wordpress.com/2024/02/4e730-screen-shot-2014-05-15-at-12-39-29-pm.png)To whitelist multiple domains, enter each domain URL on a separate line in the “Javascript Origins” input field.
