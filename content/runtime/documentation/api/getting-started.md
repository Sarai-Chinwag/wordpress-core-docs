---
type: document
title: Getting started with the REST API
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/getting-started/"
tags:
timestamp: "2026-06-16T19:29:27+00:00"
wordpress:
  id: 2497
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:27"
  date_gmt: "2026-06-16 19:29:27"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: getting-started
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/getting-started/"
  comment_count: 0
---

WordPress.com REST API allows you to view, create or edit content on any WordPress.com site, as well as any self-hosted (WordPress.org) site connected via [Jetpack](https://jetpack.me/). This includes not only blog posts and pages but also comments, tags, categories, media, site stats, notifications, sharing settings, user profiles, and many other WordPress.com features.

Some requests (e.g. listing public posts) do not need to be authenticated, but any action that would require a user to be logged in (such as creating a post) requires an authentication token.

To make authenticated requests, you’ll first need to [set up an account on WordPress.com](https://wordpress.com/start) if you don’t have one already.

 Looking for code examples? Check out the [WordPress.com REST API Examples repository](https://github.com/Automattic/wpcom-rest-api-examples), which contains sample projects demonstrating OAuth authentication and API usage in various programming languages and frameworks. The repository includes examples of both OAuth-based authentication for user-authorized operations and Application Password authentication for direct API endpoint access.

## How To Use It

There are two ways to explore the endpoints available for WordPress.com REST API:

- The [REST API Reference docs page](https://developer.wordpress.com/docs/api/rest-api-reference/) lists available endpoints and details the input and output of each one, along with example code in curl and PHP.
- The [REST API development console](https://developer.wordpress.com/docs/api/console/) allows you to construct and try out real API requests.

Making unauthenticated requests is simple. Since there are no special headers required, you can even open this one in your browser to see what it will return: [https://public-api.wordpress.com/rest/v1.1/sites/en.blog.wordpress.com/posts/?number=2&amp;pretty=true](https://public-api.wordpress.com/rest/v1.1/sites/en.blog.wordpress.com/posts/?number=2&pretty=true)

Making authenticated requests requires a few more steps. **All authenticated requests to the WordPress.com REST API require an OAuth2 access token.** This token must be obtained from WordPress.com’s OAuth2 endpoints and can be acquired through different flows, with the most relevant being:

1. [Full OAuth2 Flow](#Full-OAuth2-Flow) – Users authorize your application through WordPress.com’s interface, granting specific permissions. This is the most secure approach and required for third-party applications.
2. [](#Credentials-Direct-Token-Exchange)[Credentials Direct Token Exchange](#Credentials-Direct-Token-Exchange) – Use an Application Password with `grant_type=password` to directly obtain a token for your own sites. This bypasses the user authorization step but requires your WordPress.com credentials.

Both methods result in the same type of OAuth2 access token that you include in requests as `Authorization: Bearer YOUR_ACCESS_TOKEN`. The token-based approach ensures consistent security and enables per-application access control.

We recommend OAuth2 authentication as the most secure and granular way to access the WordPress.com REST API. If you’re already familiar with OAuth2, you can skip directly to the [technical documentation](https://developer.wordpress.com/docs/api/oauth2/).

OAuth2 lets your application act on behalf of a user without ever seeing their password. Here’s how it works: When someone wants to use your app with their WordPress.com account, your app sends them to WordPress.com to log in. WordPress.com shows them exactly what your app wants to do (like read their posts or create new ones) and asks if that’s okay. If they say yes, WordPress.com gives your app a special access token. This token is like a temporary key that lets your app do only the things the user agreed to.

You can think of it as a three-way conversation:

- **User:** “I’d like to make a post via this API client.”
- ***Client (App):*** “Okay. Hey, WordPress.com, I’d like to do something on behalf of this user. Can you ask them if it’s okay?”
- **WordPress.com:** “Sure. Hey, user, is it okay if Client acts on your behalf?”
- **User:** “Yes, that is okay. I trust this client to take actions for me in the future.”
- **WordPress.com:** “Okay, Client, here is a token that will allow you to take actions for this user. Keep it secret. Keep it safe.”

Once the Client (App) has obtained the token, it can make authenticated requests to WordPress.com. Here’s how a typical interaction works:

- ***Client (App):*** “Hello WordPress.com, I’d like to create a new post. Here’s my access token proving I’m authorized to act on behalf of the user, along with the post title, content, and other details.”
- **WordPress.com:** “I’ve validated your token and confirmed you have permission to create posts. The post has been successfully created and published. Here’s the response with the new post ID, URL, and other metadata.”

This OAuth2 token-based authentication workflow provides secure, granular access control – the Client can only perform actions that the user explicitly authorized during the OAuth flow. The token can be revoked at any time if needed, and WordPress.com validates the token’s permissions on every request.

The beauty of this system is that users stay in control. They can see exactly what your app is asking for, and they can revoke access anytime. Your app never stores passwords, and if a token gets compromised, it only affects that one app’s access—not the user’s entire account.

You’ve probably seen this before when logging into websites using your Google or Facebook account. The process works the same way: you click “Log in with Facebook,” get sent to Facebook to confirm, and then get redirected back to the original site.

From your app’s perspective, the process involves a few steps:

- First, you register your application on WordPress.com to get a client ID.
- Then you direct users to WordPress.com with a special link that includes your client ID and tells WordPress.com where to send the user back to.
- When users authorize your app, WordPress.com redirects them back to your app with an authorization code. You exchange this code for an access token using your client secret, and then you can use that token to make API requests on behalf of the user.

Once you have an access token, making authenticated requests is straightforward. You include the token in the Authorization header of your requests like this: `Authorization: Bearer your_token_here`.

For complete implementation details, code examples, and security best practices, check out the [OAuth2 authentication guide](https://developer.wordpress.com/docs/api/oauth2/).

## Base URL Structure

The WordPress.com REST API provides a standardized base URL structure that ensures consistent access across all site types, hosting configurations, and API namespaces. All available endpoints are organized and grouped under different namespaces (such as `wp`, `rest`, and `wpcom`) and their respective versions (like `v1`, `v1.4`, `v2`, `v4`), providing logical separation between different API functionalities and allowing for independent versioning strategies. This unified approach simplifies API integration and eliminates the need to determine different URL formats based on site characteristics or API versions.

For detailed information about available namespaces, their versions, and what endpoints each namespace provides, see the [Namespaces &amp; Versions](https://developer.wordpress.com/docs/api/namespaces-versions/) documentation.

### General URL Structure

All WordPress.com REST API endpoints follow this standardized pattern:

```
https://public-api.wordpress.com/{namespace}/{version}/{endpoint}
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;https://public-api.wordpress.com/{namespace}/{version}/{endpoint}&lt;/textarea&gt;CopyCopied

**Placeholders:**

- `{namespace}`: The API namespace (e.g., ‘rest’, ‘wp’, ‘wpcom’)
- `{version}`: The API version (e.g., ‘v1’, ‘v1.4’, ‘v2’, ‘v4’)
- `{endpoint}`: The specific API endpoint you want to access

**Examples:**

```
https://public-api.wordpress.com/rest/v1.4/me
https://public-api.wordpress.com/wpcom/v4/notifications
https://public-api.wordpress.com/wp/v2/posts
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;https://public-api.wordpress.com/rest/v1.4/me https://public-api.wordpress.com/wpcom/v4/notifications https://public-api.wordpress.com/wp/v2/posts&lt;/textarea&gt;CopyCopied

### Site-Specific URL Structure

When accessing endpoints that operate on specific WordPress.com sites, the URL structure includes a site identifier:

```
https://public-api.wordpress.com/{namespace}/{version}/sites/{site_id}/{endpoint}
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;https://public-api.wordpress.com/{namespace}/{version}/sites/{site_id}/{endpoint}&lt;/textarea&gt;CopyCopied

**Parameters:**

- `{namespace}`: The API namespace (e.g., ‘rest’, ‘wp’, ‘wpcom’)
- `{version}`: The API version (e.g., ‘v1’, ‘v1.4’, ‘v2’, ‘v4’)
- `{site_id}`: Your WordPress.com site’s unique numeric identifier
- `{endpoint}`: The specific site-related endpoint (e.g., ‘posts’, ‘pages’, ‘media’, ‘users’)

**Examples:**

```
https://public-api.wordpress.com/wp/v2/sites/241031857/posts
https://public-api.wordpress.com/rest/v1.4/sites/241031857/stats
https://public-api.wordpress.com/wpcom/v2/sites/241031857/follows
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;https://public-api.wordpress.com/wp/v2/sites/241031857/posts https://public-api.wordpress.com/rest/v1.4/sites/241031857/stats https://public-api.wordpress.com/wpcom/v2/sites/241031857/follows&lt;/textarea&gt;CopyCopied

#### Getting Your Site ID

To use site-specific endpoints, you’ll need to obtain your site’s unique numeric identifier. You can get this info by doing a request to `/rest/v1.1/me/sites` endpoint from the API Console:

1. Visit the [WordPress.com API Console](https://developer.wordpress.com/docs/api/console/)
2. Navigate to the `/rest/v1.1/me/sites` endpoint (that can be found at `WP.COM API - v1.1/me/sites` [in the Console](https://developer.wordpress.com/docs/api/namespaces-versions-versions/#Understanding-API-Console-Organization))
3. Execute the request to retrieve all sites associated with your account
4. Locate the `ID` field in the response for your desired site

The `/rest/v1.1/me/sites` endpoint returns comprehensive details about all sites associated with your WordPress.com account, including:

- `ID`: The unique numeric site identifier (what you need for API calls)
- `name`: The site’s display name
- `URL`: The site’s public URL
- `jetpack`: Whether the site is a Jetpack-connected site
- `is_private`: Whether the site is private
- `capabilities`: What actions you can perform on the site

**Example Response:**

```
{
  "sites": [
    {
      "ID": 241031857,
      "name": "My Blog",
      "URL": "https://myblog.wordpress.com",
      "jetpack": false,
      "is_private": false,
      "capabilities": {
        "edit_posts": true,
        "publish_posts": true
      }
    }
  ]
}
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;{ "sites": [ { "ID": 241031857, "name": "My Blog", "URL": "https://myblog.wordpress.com", "jetpack": false, "is_private": false, "capabilities": { "edit_posts": true, "publish_posts": true } } ] }&lt;/textarea&gt;CopyCopied

### Alternative URL Formats

You may encounter some alternative URL formats:

- **Direct site access**, like `https://yoursite.com/wp-json/wp/v2/posts` – This format works only for self-hosted sites with Jetpack. May fail due to security settings, firewall rules, or authentication issues.
- **Domain-based WordPress.com access**, like `https://public-api.wordpress.com/wp/v2/sites/yoursite.com/posts` – This format is unreliable for sites with custom domains, DNS configurations, or when domains change.

To avoid any issues the recommended approach is to use the format with numeric site IDs which is more reliable, faster, it works consistently across all site types, and supports full WordPress.com features and authentication methods.

## Authentication Requirements

The WordPress.com REST API supports both authenticated and unauthenticated requests, depending on the endpoint and the data you’re trying to access. Understanding when and how to authenticate is crucial for successful API integration.

**Unauthenticated requests** work for:

- Public site information (e.g., site details, public posts)
- Reading public content from WordPress.com sites
- Accessing publicly available stats and data

*Examples of unauthenticated requests:*

```
# Get public information about a site
curl https://public-api.wordpress.com/rest/v1.1/sites/en.blog.wordpress.com/
Get public posts from a site
curl https://public-api.wordpress.com/wp/v2/sites/en.blog.wordpress.com/posts?per_page=5
```

&lt;textarea aria-hidden="true" class="a8c-docs-syntax__copy-textarea"&gt;# Get public information about a site curl <https://public-api.wordpress.com/rest/v1.1/sites/en.blog.wordpress.com/># Get public posts from a site

curl [https://public-api.wordpress.com/wp/v2/sites/en.blog.wordpress.com/posts?per\_page=5](https://public-api.wordpress.com/wp/v2/sites/en.blog.wordpress.com/posts?per_page=5)&lt;/textarea&gt;CopyCopied
