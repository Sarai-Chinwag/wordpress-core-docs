---
type: document
title: Create a static front page
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/create-a-static-front-page/"
tags:
timestamp: "2026-06-16T19:28:38+00:00"
wordpress:
  id: 2241
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:38"
  date_gmt: "2026-06-16 19:28:38"
  modified: "2026-06-16 19:28:38"
  modified_gmt: "2026-06-16 19:28:38"
  slug: create-a-static-front-page
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/create-a-static-front-page/"
  comment_count: 0
  terms:
    category:
      - publishing
      - support-guides
---

The purpose of this document is to explain the process of setting up a static page on your WordPress site. This document doesn’t discuss the automatic display of posts on the Home page. It is a pre-requisite that you understand the difference between the [Pages](https://wordpress.org/documentation/article/create-pages/) and Posts.

## What is a Static Front Page

By default, WordPress displays a list of *Posts* on the home page of your site. This list of posts is *automatically updated* as soon as new posts are published, thus this is not static. Also, there is no need to create any page in order to have WordPress displaying this list of posts.

A Static Front Page is **a specific Page** used as *the Home Page* of the site.

## How to create a Static Front Page

*Reminder: to create a page, go to **Pages &gt; Add New***

![How to create a Static Front Page](https://wordpress.org/documentation/files/2021/06/Screen-Shot-2021-06-23-at-2.04.35-PM-1024x327.png)1. **Home Page**: (if not already created) create **the Page you want to use** as the Static Front (Home) Page.
2. **Posts Page**: (if not already created) create an **empty page**. Give it **a title** that will be used on top of your posts list. **This step is mandatory** as you are modifying WordPress default setting. *Any other content other than Title will not be displayed* at all on this specific page.
3. **Setting**: go to **Settings &gt; Reading**, then ‘Home page displays’.
    1. Static Page setting: **select a static page** (instead of the default *Your latest posts*).
    2. Home Page setting: in ‘Home page’ list, **select the page you want** for Static Front(Home) Page.
    3. Posts Page setting: in ‘Posts page’ list, **select the empty page** you created. *Do not select any page with content*, as it will not be displayed.
4. **Save your settings** by clicking ‘Save Changes’ button.

Connect to your site home page: you should now see the Page you selected.

## Changelog

- Update 2026-04-05
    - Fix the intro paragraph (props @noumantech, @estelaris)
