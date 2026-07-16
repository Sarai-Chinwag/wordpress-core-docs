---
type: document
title: WordPress and WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wordpress-and-wordpress-com/"
tags:
timestamp: "2026-06-16T19:29:24+00:00"
wordpress:
  id: 2475
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:24"
  date_gmt: "2026-06-16 19:29:24"
  modified: "2026-06-16 19:29:30"
  modified_gmt: "2026-06-16 19:29:30"
  slug: wordpress-and-wordpress-com
  parent: 2476
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wordpress-and-wordpress-com/"
  comment_count: 0
---

[WordPress](https://wordpress.org) is an open-source content management system (CMS) that powers over 43% of websites on the internet. It’s a flexible, extensible platform built for publishing—from blogs and portfolios to enterprise-level applications.

**WordPress.com**, on the other hand, is a managed hosting platform that runs the open-source WordPress software. It offers a streamlined, secure, and performance-optimized environment where you can build and manage WordPress websites without worrying about server setup, software updates, or maintenance.

This page explains how WordPress and WordPress.com relate to one another and outlines what developers can expect when working on WordPress sites hosted on WordPress.com.

## What is WordPress?

WordPress is a free, open-source CMS developed by a global community of contributors. Originally launched in 2003 as a blogging platform, it has since evolved into a powerful system for building everything from personal websites to complex applications.

Key benefits of WordPress include:

- **Open Source:** Anyone can view, modify, and redistribute the WordPress code.
- **User-Friendly:** Built with an intuitive interface for users of all skill levels.
- **Customizable:** Thousands of themes and plugins let you tailor the look and functionality of your site.
- **SEO-Friendly:** Designed with SEO in mind, with support from numerous SEO plugins.
- **Developer Ecosystem:** A vast and active global community contributes to core development, plugin and theme creation, and community support.
- **Secure and Up-to-Date:** Regular security patches and updates help keep sites safe.
- **Mobile Ready:** Most themes are responsive by default for a better experience across devices.

You can download the WordPress software for free at [WordPress.org](https://wordpress.org) and install it on the web host of your choice.

## Hosting WordPress on WordPress.com

[WordPress.com](https://wordpress.com/hosting/) is a managed hosting service created by Automattic, a company founded by one of the original WordPress co-creators. It runs the open-source WordPress software but removes the complexity of server configuration, performance tuning, manual updates, and more.

With WordPress.com, you can:

- Create and manage multiple sites from a single dashboard.
- Get built-in support for [real-time backups](https://developer.wordpress.com/docs/platform-features/real-time-backup-restore/), [staging sites](https://wordpress.com/support/how-to-create-a-staging-site/), and object caching.
- Access a suite of [essential developer tools](https://developer.wordpress.com/docs/developer-tools/), including [WP-CLI](https://developer.wordpress.com/docs/developer-tools/wp-cli/), [GitHub deployments](https://wordpress.com/support/github-deployments/), and [SFTP](https://wordpress.com/support/sftp/)/[SSH](https://wordpress.com/support/ssh/).
- Benefit from automatic WordPress updates and unmetered bandwidth.
- Rely on enterprise-grade security, 99.999% uptime, and [global edge caching](https://wordpress.com/support/clear-your-sites-cache/) for performance.
- Reach out to [24/7 expert support](https://developer.wordpress.com/docs/glance/support/) for help when needed.

To take full advantage of the developer tools and performance features, we recommend choosing a **Business** or **Commerce** plan.

## Working with databases on WordPress.com

WordPress uses a MySQL database to store site content and configuration settings—everything from posts and pages to plugin settings and user data. Tables such as `wp_posts`, `wp_users`, and `wp_options` are foundational to any WordPress installation. MySQL is known for its speed and reliability, making it suitable for handling all types of WordPress sites.

On WordPress.com, database access is provided through **phpMyAdmin**, a web-based tool for managing MySQL databases. This allows you to view and interact with your database using a graphical interface, without needing to use command-line tools. For full instructions, [visit our Database Access support page](https://developer.wordpress.comhttps://wordpress.com/support/database/).

## PHP versioning on WordPress.com

WordPress is primarily written in PHP. Like any programming language, PHP evolves over time, with new versions offering performance improvements, new features, and security fixes.

While self-hosted WordPress sites require developers to manage their own PHP versions, WordPress.com takes care of this for you. Your sites will always run on a secure, actively supported PHP version without the need for manual upgrades.

You can view the currently supported PHP versions on our [PHP environment support page](https://wordpress.com/support/php-environment/).
