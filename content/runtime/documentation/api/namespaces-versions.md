---
type: document
title: "Namespaces &amp; versions"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/namespaces-versions/"
tags:
timestamp: "2026-06-16T19:29:20+00:00"
wordpress:
  id: 2444
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:20"
  date_gmt: "2026-06-16 19:29:20"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: namespaces-versions
  parent: 2499
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/namespaces-versions/"
  comment_count: 0
---

The WordPress.com REST API is organized into three distinct namespaces, each serving specific purposes and following independent versioning schemes. Understanding these namespaces is essential for choosing the right endpoints for your integration and ensuring compatibility with both WordPress.com and self-hosted WordPress sites.

 Check the [WordPress.com API Console](https://developer.wordpress.com/docs/api/console/) to see all endpoints, [organized](#Understanding-API-Console-Organization) by namespaces and its versions

## Overview of API Namespaces

The WordPress.com REST API provides three main namespaces, each targeting different use cases and levels of compatibility:

| **Namespace** | **Available Versions** | **Primary Purpose** | **WordPress Core Compatible** |
|---|---|---|---|
| `/rest/` | v1, v1.1, v1.2, v1.3, v1.4 | Legacy WordPress.com management and platform features | No |
| `/wp/` | v2 | Standard WordPress core resources following official REST API specification | Yes |
| `/wpcom/` | v2, v3, v4 | Modern WordPress.com-specific features and services | No |

## `/rest/` Namespace – Legacy WordPress.com API

The /rest/ namespace represents the original WordPress.com REST API, predating the WordPress core REST API. It provides comprehensive access to WordPress.com platform features and site management capabilities.

**Available Versions:** v1, v1.1, v1.2, v1.3, v1.4 (accessed via the **WP.COM API** option in the API Console)

**Base URLs:**

- `https://public-api.wordpress.com/rest/v1/`
- `https://public-api.wordpress.com/rest/v1.1/`
- `https://public-api.wordpress.com/rest/v1.2/`
- `https://public-api.wordpress.com/rest/v1.3/`
- `https://public-api.wordpress.com/rest/v1.4/`

**Key Features:**

- Comprehensive site and user management
- WordPress.com-specific features like Stats, Reader, and Notifications
- Advanced site configuration and domain management
- Jetpack integration capabilities

**Versioning Strategy:** Each version (v1.1–v1.4) introduced incremental improvements, new endpoints, and enhanced functionality while maintaining backward compatibility. When endpoints exist across multiple versions, newer versions typically offer additional fields, improved performance, or bug fixes.

**Best Used For:**

- Accessing WordPress.com-specific features not available elsewhere
- Advanced site management and configuration
- Maintaining compatibility with existing integrations
- Features like detailed stats, Reader functionality, and domain management

**Example Endpoints:**

- `/rest/v1.4/sites/{site}/posts`
- `/rest/v1.4/sites/{site}/stats`
- `/rest/v1.4/me/sites`
- `/rest/v1.3/read/following`

## `/wp/` Namespace – WordPress Core REST API

The /wp/ namespace implements the official WordPress REST API specification, ensuring full compatibility with both WordPress.com and self-hosted WordPress sites. This namespace follows the standards established by the WordPress core team.

**Available Version:** v2 (accessed via the **WP REST API** option in the API Console)

**Base URL:** `https://public-api.wordpress.com/wp/v2/`

**Key Features:**

- Standard WordPress resources (posts, pages, comments, taxonomies, users, media)
- Full compatibility with self-hosted WordPress sites
- Consistent endpoint structure following WordPress core standards
- Extensible through plugins on self-hosted sites

**Design Philosophy:** This namespace prioritizes standardization and compatibility over WordPress.com-specific features. It mirrors the REST API available on any WordPress installation, making it ideal for applications that need to work across different WordPress environments.

**Best Used For:**

- New projects requiring WordPress core functionality
- Applications that must work with both WordPress.com and self-hosted sites
- Standard content management (posts, pages, media, users)
- Integrations with existing WordPress tools and plugins

**Example Endpoints:**

- `/wp/v2/posts`
- `/wp/v2/pages`
- `/wp/v2/users`
- `/wp/v2/media`
- `/wp/v2/sites/{site}/posts`

## `/wpcom/` Namespace – Modern WordPress.com Platform API

The /wpcom/ namespace represents the evolution of WordPress.com-specific API functionality, featuring modern design patterns and advanced platform features not available in WordPress core.

**Available Versions:** v2, v3, v4 (accessed via the **WP REST API** option in the API Console)

**Base URLs:**

- `https://public-api.wordpress.com/wpcom/v2/`
- `https://public-api.wordpress.com/wpcom/v3/`
- `https://public-api.wordpress.com/wpcom/v4/`

**Key Features:**

- Modern API design with improved structure and performance
- Advanced WordPress.com services (Reader, enhanced Stats, Notifications)
- User engagement features (follows, likes, recommendations)
- Platform-specific functionality is not available in self-hosted WordPress

**Versioning Strategy:** Each version introduces new capabilities, security improvements, and refined data structures. Unlike the `/rest/` namespace, `/wpcom/` focuses on forward-looking functionality rather than legacy compatibility.

**Best Used For:**

- Modern WordPress.com platform features
- User engagement and social features
- Advanced analytics and recommendations
- New integrations requiring the latest WordPress.com capabilities

**Example Endpoints:**

- `/wpcom/v4/me/follows`
- `/wpcom/v3/notifications`
- `/wpcom/v2/read/tags`
- `/wpcom/v4/sites/{site}/stats/insights`

## Choosing the Right Namespace

The choice of namespace depends on your specific requirements and compatibility needs:

Use `/wp/v2/` when you need **Standard WordPress Functionality** like:

- Core WordPress features (posts, pages, users, media)
- Compatibility with self-hosted WordPress sites
- Standard REST API patterns and structures
- Integration with existing WordPress tools and plugins

Use `/wpcom/v4/` (or latest available) when you need **WordPress.com Platform Features** like:

- Advanced WordPress.com services and social features
- Modern API design and improved performance
- Latest platform capabilities and integrations
- Features unique to the WordPress.com ecosystem

Use `/rest/v1.4/` (or required version) when you need **Legacy Features and Compatibility** like:

- Specific functionality is only available in legacy endpoints
- Backward compatibility with existing integrations
- Advanced site management features have not yet been migrated to newer namespaces
- Comprehensive stats and analytics capabilities

## Version Selection Guidelines

Within each namespace, version selection follows these principles:

**Multiple Versions Available:** When endpoints exist across multiple versions, newer versions typically provide:

- Additional response fields and parameters
- Improved performance and reliability
- Bug fixes and security enhancements
- Enhanced functionality while maintaining backward compatibility

**Recommended Approach:** Always use the latest available version unless:

- Your integration depends on specific behavior in older versions
- You’re maintaining legacy code that requires specific API responses
- Compatibility requirements dictate a particular version

## Understanding API Console Organization

The [WordPress.com API Console](https://developer.wordpress.com/docs/api/console/) organizes namespaces into two main categories:

- **WP.COM API**: Contains all `/rest/` namespace versions (v1–v1.4)
- **WP REST API**: Contains `/wp/v2/` and all `/wpcom/` namespace versions (v2–v4)

This organization reflects the evolution from WordPress.com-specific APIs to standardized WordPress core APIs and modern platform features.

## Migration Considerations

When planning integrations or updating existing ones:

**New Projects:** Start with `/wp/v2/` for core functionality and `/wpcom/v4/` for platform-specific features.

**Existing Integrations:** Consider migrating from /rest/ endpoints to newer namespaces when:

- Equivalent functionality exists in `/wp/v2/` or `/wpcom/`
- You need improved performance or additional features
- Long-term maintenance and support are priorities

**Feature Availability:** Some advanced features remain exclusive to the /rest/ namespace. Evaluate feature requirements before migration to ensure all necessary functionality is available in target namespaces.
