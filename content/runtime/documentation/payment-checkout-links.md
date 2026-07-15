---
type: document
title: "Payment &amp; Checkout Links"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/payment-checkout-links/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2430
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:18"
  modified_gmt: "2026-06-16 19:29:18"
  slug: payment-checkout-links
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/payment-checkout-links/"
  comment_count: 0
---

This document describes how to construct URLs that take users directly to WordPress.com checkout to purchase a plan, product, domain, or renewal. These URLs work for both logged-in and logged-out users.

## Base URL patterns

There are two primary URL patterns for payment links.

**New purchase (unified checkout):**

 ```
https://wordpress.com/checkout/unified/{product_slugs}
```

 

 

The unified checkout flow handles account creation and site creation automatically. If the user is logged out, they’ll be prompted to log in or create an account. If no site exists, one is created as part of the purchase flow.

**Renewal:**

 ```
https://wordpress.com/checkout/renew/{subscription_id}
```

 

 

**Existing Site:**

 ```
https://wordpress.com/checkout/{site_domain}/{product_slugs}
```

 

 

## Product slug format

The `{product_slugs}` portion of the URL accepts one or more Store product slugs. Multiple products are separated by commas.

 ```
https://wordpress.com/checkout/unified/personalhttps://wordpress.com/checkout/unified/premium,domain_reg:example.com
```

 

 

Some products require additional metadata, appended with a colon separator:

 ```
{product_slug}:{meta}
```

 

 

For example, domain registrations require the domain name as meta:

 ```
dotlive_domain:example.livedomain_reg:example.com
```

 

 

Products that support a quantity use the `:-q-{quantity}` suffix:

 ```
ak_personal_yearly:-q-20wp_google_workspace_business_starter_yearly:example.com:-q-12
```

 

 

These can be combined. A product with both meta and quantity looks like:

 ```
{product_slug}:{meta}:-q-{quantity}
```

 

 

## Renewal URLs

To renew an existing subscription, use the subscription ID (the Store subscription ID, not the purchase ID visible in the UI):

 ```
https://wordpress.com/checkout/renew/1234
```

 

 

No site slug or product details are needed. The system resolves everything from the subscription ID.

## WordPress.com plans

Each plan has a `product_slug` (the internal Store identifier) and a `path_slug` (the URL-friendly alias used in checkout URLs). Either can be used in the checkout URL, but `path_slug` values are preferred for readability.

### Current plans

| Plan name | path\_slug | product\_slug | Billing |
|---|---|---|---|
| Personal | `personal` | `personal-bundle` | Yearly |
| Personal | `personal-monthly` | `personal-bundle-monthly` | Monthly |
| Personal | `personal-2-years` | `personal-bundle-2y` | 2-year |
| Personal | `personal-3-years` | `personal-bundle-3y` | 3-year |
| Premium | `premium` | `value_bundle` | Yearly |
| Premium | `premium-monthly` | `value_bundle-monthly` | Monthly |
| Premium | `premium-2-years` | `value_bundle-2y` | 2-year |
| Premium | `premium-3-years` | `value_bundle-3y` | 3-year |
| Business | `business` | `business-bundle` | Yearly |
| Business | `business-monthly` | `business-bundle-monthly` | Monthly |
| Business | `business-2-years` | `business-bundle-2y` | 2-year |
| Business | `business-3-years` | `business-bundle-3y` | 3-year |
| Commerce | `ecommerce` | `ecommerce-bundle` | Yearly |
| Commerce | `ecommerce-monthly` | `ecommerce-bundle-monthly` | Monthly |
| Commerce | `ecommerce-2-years` | `ecommerce-bundle-2y` | 2-year |
| Commerce | `ecommerce-3-years` | `ecommerce-bundle-3y` | 3-year |

## Domain products

Domain product slugs follow the pattern `dot{tld}_domain` where `{tld}` is the TLD with dots removed. For example:

| TLD | product\_slug | Example URL segment |
|---|---|---|
| .com | `dotcom_domain` | `dotcom_domain:example.com` |
| .live | `dotlive_domain` | `dotlive_domain:example.live` |
| .blog | `dotblog_domain` | `dotblog_domain:example.blog` |
| .net | `dotnet_domain` | `dotnet_domain:example.net` |
| .org | `dotorg_domain` | `dotorg_domain:example.org` |
| Any other TLD | `dot{tld}_domain` | Pattern applies to all supported TLDs |

There are also generic domain operations:

| Product | product\_slug | Notes |
|---|---|---|
| Domain registration | `domain_reg` | Generic registration; requires `:domain` meta |
| Domain mapping | `domain_map` | Map an existing domain; requires `:domain` meta |
| Domain transfer | `domain_transfer` | Transfer a domain in; requires `:domain` meta |

## Email products

| Product | product\_slug | Notes |
|---|---|---|
| Google Workspace (Starter, Yearly) | `wp_google_workspace_business_starter_yearly` | Requires `:domain` meta and `:-q-{seats}` |

Example:

 ```
https://wordpress.com/checkout/unified/wp_google_workspace_business_starter_yearly:example.com:-q-5
```

 

 

## Jetpack products

Jetpack products use their own slug namespace. Common products include:

### Jetpack plans

| Product | product\_slug |
|---|---|
| Jetpack Security (Yearly) | `jetpack_security_t1_yearly` |
| Jetpack Security (Monthly) | `jetpack_security_t1_monthly` |
| Jetpack Complete (Yearly) | `jetpack_complete` |
| Jetpack Complete (Monthly) | `jetpack_complete_monthly` |

### Jetpack standalone products

| Product | product\_slug |
|---|---|
| Jetpack Backup | `jetpack_backup_t1_yearly` |
| Jetpack Backup (Monthly) | `jetpack_backup_t1_monthly` |
| Jetpack Scan (Yearly) | `jetpack_scan` |
| Jetpack Scan (Monthly) | `jetpack_scan_monthly` |
| Jetpack Search (Free) | `jetpack_search_free` |

### Jetpack AI

Jetpack AI uses the quantity suffix to set the tier:

| Product | product\_slug |
|---|---|
| Jetpack AI (Yearly, 100 requests) | `jetpack_ai_yearly:-q-100` |
| Jetpack AI (Yearly, 200 requests) | `jetpack_ai_yearly:-q-200` |
| Jetpack AI (Yearly, 500 requests) | `jetpack_ai_yearly:-q-500` |
| Jetpack AI (Yearly, 750 requests) | `jetpack_ai_yearly:-q-750` |
| Jetpack AI (Yearly, 1000 requests) | `jetpack_ai_yearly:-q-1000` |
| Jetpack AI (Monthly, 100 requests) | `jetpack_ai_monthly:-q-100` |
| Jetpack AI (Bi-Yearly, 100 requests) | `jetpack_ai_bi_yearly:-q-100` |

### Jetpack Stats

Jetpack Stats uses quantity to set the page views tier:

| Product | product\_slug |
|---|---|
| Jetpack Stats (Yearly, 10K views) | `jetpack_stats_yearly:-q-10000` |
| Jetpack Stats (Yearly, 100K views) | `jetpack_stats_yearly:-q-100000` |
| Jetpack Stats (Yearly, 250K views) | `jetpack_stats_yearly:-q-250000` |
| Jetpack Stats (Yearly, 500K views) | `jetpack_stats_yearly:-q-500000` |
| Jetpack Stats (Yearly, 1M views) | `jetpack_stats_yearly:-q-1000000` |
| Jetpack Stats (Monthly, 10K views) | `jetpack_stats_monthly:-q-10000` |
| Jetpack Stats (Bi-Yearly, 10K views) | `jetpack_stats_bi_yearly:-q-10000` |

## Akismet products

| Product | product\_slug |
|---|---|
| Akismet Personal (Yearly) | `ak_personal_yearly` |

Akismet products also support the `:-q-` quantity suffix for volume pricing.

## Example URLs

**Buy the Personal plan (yearly):**

 ```
https://wordpress.com/checkout/unified/personal
```

 

 

**Buy Premium with a .com domain:**

 ```
https://wordpress.com/checkout/unified/premium,dotcom_domain:myblog.com
```

 

 

**Buy Business with a domain registration and Google Workspace (5 seats):**

 ```
https://wordpress.com/checkout/unified/business,domain_reg:mybusiness.com,wp_google_workspace_business_starter_yearly:mybusiness.com:-q-5
```

 

 

**Renew subscription #98765:**

 ```
https://wordpress.com/checkout/renew/98765
```

 

 

**Buy Jetpack AI (yearly, 500 tier) for an existing site:**

 ```
https://wordpress.com/checkout/mysite.wordpress.com/jetpack_ai_yearly:-q-500
```

 

 

## Notes for API and agent implementors

1. **Use `path_slug` values for plans.** They’re shorter and more readable. Both `personal` and `personal-bundle` resolve to the same product, but `personal` is preferred in URLs.
2. **Unified checkout creates accounts and sites.** The `/checkout/unified/` path handles logged-out users. If the user has no site, one is created during checkout.
3. **Site-specific checkout works.** For purchases tied to an existing site, use the pattern: `https://wordpress.com/checkout/{site_slug}/{product_slugs}`. The site slug is either `example.wordpress.com` or a custom domain.
4. **Comma-separate multiple products.** Each product in the URL is separated by a comma, not a slash or ampersand.
5. **Domain meta is required.** Domain products (registrations, mappings, transfers) must include the domain name after a colon. Without it, checkout will fail.
6. **Quantity is optional.** The `:-q-{n}` suffix only applies to products that support volume pricing or tiered quantities (Jetpack AI, Jetpack Stats, Google Workspace, Akismet).
7. **Renewal URLs are self-contained.** Pass only the subscription ID. The system resolves the product, site, and billing details.
8. **Post-checkout behavior.** After a successful purchase on unified checkout, logged-in users are redirected to their newly created or existing site. Logged-out users who log in during checkout are returned to checkout with their cart preserved.

## Source references

Product slug constants are defined in the `@automattic/calypso-products` package in [wp-calypso](https://github.com/Automattic/wp-calypso):

- [`packages/calypso-products/src/constants/wpcom.ts`](https://github.com/Automattic/wp-calypso/blob/trunk/packages/calypso-products/src/constants/wpcom.ts) (WordPress.com plans)
- [`packages/calypso-products/src/constants/jetpack.ts`](https://github.com/Automattic/wp-calypso/blob/trunk/packages/calypso-products/src/constants/jetpack.ts) (Jetpack products)
- [`packages/calypso-products/src/constants/akismet.ts`](https://github.com/Automattic/wp-calypso/blob/trunk/packages/calypso-products/src/constants/akismet.ts) (Akismet products)
- [`packages/calypso-products/src/constants/google.ts`](https://github.com/Automattic/wp-calypso/blob/trunk/packages/calypso-products/src/constants/google.ts) (Google Workspace)

Checkout URL documentation: [`client/my-sites/checkout/README.md`](https://github.com/Automattic/wp-calypso/blob/trunk/client/my-sites/checkout/README.md)
