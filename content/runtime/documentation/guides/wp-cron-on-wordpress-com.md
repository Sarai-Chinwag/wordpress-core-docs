---
type: document
title: WP‑Cron on WordPress.com
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wp-cron-on-wordpress-com/"
tags:
timestamp: "2026-06-16T19:29:18+00:00"
wordpress:
  id: 2433
  status: publish
  type: documentation
  author: 0
  date: "2026-06-16 19:29:18"
  date_gmt: "2026-06-16 19:29:18"
  modified: "2026-06-16 19:29:29"
  modified_gmt: "2026-06-16 19:29:29"
  slug: wp-cron-on-wordpress-com
  parent: 2479
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/developer-wordpress-com-documentation/wp-cron-on-wordpress-com/"
  comment_count: 0
---

WordPress includes a built-in scheduling system called [WP‑Cron](https://developer.wordpress.org/plugins/cron/). WP‑Cron simulates a system cron by running scheduled tasks inside WordPress. These tasks include publishing scheduled posts, running background processing initiated by plugins, and more.

On WordPress.com, WP‑Cron is the scheduling system that runs these tasks. Server-side cron is not available, so you cannot configure a traditional system `crontab` or replace WP‑Cron with one.

## How WP‑Cron runs

WP‑Cron is request-triggered. Scheduled events run when WordPress receives a request and detects an event is due. On low-traffic sites, scheduled events can run later than their scheduled time because there are fewer requests to trigger WP‑Cron.

## Managing WP‑Cron events

If you need more visibility or control over scheduled events from within WordPress, you can use a plugin such as [WP Crontrol](https://wordpress.org/plugins/wp-crontrol/).

Tools like this can help you view, run, and create your own WP‑Cron events in the WordPress admin. They still operate within WP‑Cron and do not provide server-side cron access.

## Triggering WP‑Cron more consistently

If you need WP‑Cron to run more consistently, you can use an external monitoring service such as [Jetpack](https://jetpack.com/features/security/downtime-monitoring/) or [Uptime Robot](https://uptimerobot.com/) that periodically requests your site. This increases the frequency of requests that trigger WP‑Cron and improves reliability.
