---
type: document
title: REST API URLs by site type
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-urls-by-site-type/"
tags:
timestamp: "2026-06-16T19:29:21+00:00"
wordpress:
  id: 2447
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:21"
  date_gmt: "2026-06-16 19:29:21"
  modified: "2026-06-16 19:29:21"
  modified_gmt: "2026-06-16 19:29:21"
  slug: rest-api-urls-by-site-type
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/rest-api-urls-by-site-type/"
  comment_count: 0
---

When interacting with the [WordPress.com REST API](https://developer.wordpress.com/docs/api/), it’s essential to understand that the base URL for your requests will vary based on your site’s hosting plan. WordPress.com distinguishes between “Public” sites (those on Free, Personal, and Premium plans) and “Atomic” sites (Business and eCommerce plans). This distinction affects how you access the REST API.

This guide will walk you through the correct REST API URL structure for each type of site.

## Public Sites on a WordPress.com Subdomain

Most sites on the WordPress.com free plan use a `wordpress.com` subdomain, for example, `example.wordpress.com`. For these public sites, the REST API endpoint is structured similarly to a self-hosted WordPress site.

You can access the API by appending `/wp-json/` to the end of your site’s URL.

The general URL format is:
`https://<your-site-name>.wordpress.com/wp-json/`

**Example**

For a site at `https://example.wordpress.com`, the REST API root can be found at:
`https://example.wordpress.com/wp-json/`

To retrieve a list of posts from this site, you would make a `GET` request to:
`https://example.wordpress.com/wp-json/wp/v2/posts`

## Public Sites with a Custom Domain

WordPress.com sites on Personal or Premium plans can use a custom domain, such as `www.example.com`. Although these are also public sites, they use a different REST API endpoint.

For these sites, you must use the WordPress.com public API proxy, which centralizes API access. You’ll need to include your site’s domain in the API request URL.

The general URL format is:
`https://public-api.wordpress.com/wp/v2/sites/<your-custom-domain.com>/`

**Example**

If your site’s custom domain is `www.example.com`, its REST API root is:
`https://public-api.wordpress.com/wp/v2/sites/www.example.com/`

A request to fetch posts from this site would be sent to:
`https://public-api.wordpress.com/wp/v2/sites/www.example.com/posts`

It is crucial to use your custom domain in the API URL, not any `.wordpress.com` subdomain that might still be linked to your account.

## Atomic Sites

Sites on the WordPress.com Business or eCommerce plans are designated as “Atomic” sites. They are hosted on a more flexible infrastructure that allows for installing custom plugins and themes, making them operate much like self-hosted WordPress installations.

This similarity extends to how you access the REST API. For Atomic sites, you can access the API directly through your custom domain, just like you would with a self-hosted site.

The general URL format is:
`https://<your-custom-domain.com>/wp-json/`

**Example**

For an Atomic site with the custom domain `www.my-atomic-site.com`, the REST API root is:
`https://www.my-atomic-site.com/wp-json/`

To fetch a list of posts from this site, the endpoint would be:
`https://www.my-atomic-site.com/wp-json/wp/v2/posts`

This direct API access is a key feature of the Atomic platform, offering developers greater control and more powerful integrations.

 Atomic sites continue to expose the default REST API endpoint at `https://<your-site-name>.wordpress.com/wp-json/wp/v2/posts` . However, any requests to this endpoint are automatically redirected with a `301 Moved Permanently` response to the corresponding endpoint on the site’s custom domain—for example, `https://www.my-atomic-site.com/wp-json/wp/v2/posts`. This redirection ensures that all API traffic is routed through the site’s canonical custom domain.

## Comparison Table: REST API URLs by Site Type

| Site Type | Example Site URL | REST API Base URL |
|---|---|---|
| Public (Free Plan) | `https://example.wordpress.com` | `https://example.wordpress.com/wp-json/` |
| Public (Custom Domain) | `https://www.example.com` | `https://public-api.wordpress.com/wp/v2/sites/www.example.com/` |
| Atomic (Business/eCommerce) | `https://www.my-atomic-site.com` | `https://www.my-atomic-site.com/wp-json/` |
