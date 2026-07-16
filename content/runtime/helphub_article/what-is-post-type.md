---
type: document
title: "What is Post Type?"
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/what-is-post-type/"
tags:
timestamp: "2026-06-16T19:29:11+00:00"
wordpress:
  id: 2410
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:11"
  date_gmt: "2026-06-16 19:29:11"
  modified: "2026-06-16 19:29:11"
  modified_gmt: "2026-06-16 19:29:11"
  slug: what-is-post-type
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/what-is-post-type/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

WordPress houses lots of different types of content and they are divided into something called ***Post Types﻿***. A single item is called a ***post*** however this is also the name of a standard post type called ***posts***. By default WordPress comes with a few different post types which are all stored in the database under the ***wp\_posts*** table.

## Default Post Types

The default post types that are always included within a WordPress installation unless otherwise removed are:

- Posts
- Pages
- Attachments
- Revisions
- Navigation Menus
- Custom CSS
- Changesets

### Posts

A ***post*** in WordPress is a *post type* that is typical for, and most used by blogs. *Posts* are normally displayed in a blog in reverse sequential order by time (newest posts first). Posts are also used for creating RSS feeds.

### Pages

A page is similar to posts however they have some very important differences. Pages aren’t displayed in a reversed time-based order. They can also be placed into a hierarchical order where a page can be the parent or child of another page creating a page structure. Traditionally, pages also do not make use of categories and tags like posts do.

### Attachments

Attachments are another post type that is special as these hold information about any media that is uploaded to your WordPress website. Not only is the main post information stored where other posts are, attachments also make use of the wp\_postmeta table for storing extra information like metadata for images and videos that you’ve added.

### Revisions

Revisions are a particularly special post type as they are used to create a history of other post types in case you make a mistake and want to rollback to a previous version. Whilst you technically can’t edit revisions directly unless you restore a revision, they are editable just like posts and are stored in the ***wp\_posts*** table like any other post type.

### Menus

Menus in WordPress are lists of links that can be used to navigate your website. This allows you to create custom lists of links to various locations on your website that is used by your visitors and are edited in the theme section of the dashboard away from traditional post types like posts or pages.

### Custom CSS

Custom CSS﻿ is a theme specific post type used to store CSS saved from The Customizers ***Additional CSS*** screen. Each theme can have its own custom CSS post but only the active themes `custom\_css` post is actually used.

### Changesets

Changesets are similar to revisions but specifically for the Customizer. This is to keep the Customizer in a persistent state. WordPress will attempt to keep content changes made through the Customizer during the user session in a `customize\_changeset` post and attempt to restore them should you exit your current session.

## Custom Post Types

Whilst there are already lots of standard post types within WordPress, you may want to extend the amount of post types you have if you want to break things down into smaller categories. For example, if you want to have a section on Books, it would be better suited to creating a custom post type for them. This can be done using the [register\_post\_type](https://developer.wordpress.org/reference/functions/register_post_type/) function.

It’s highly recommended that you define custom post types within a plugin or must-use plugin to ensure that if you switch themes, the post type isn’t lost. That way you can ensure your content is always accessible.

## Template Files

By default WordPress makes use of the index.php, single.php and archive.php files in a theme to display posts of any type of the front-end of a website. However, if you’ve made a custom post type, you may find that you want to show this information in a different way to other types. You can do this by using post type specific [custom templates](https://developer.wordpress.org/themes/template-files-section/custom-post-type-template-files/) within your theme.

If you create a post type called Books like in the example above, you can create a template file called single-books.php which will show the individual book posts that you publish. Again, to show all your books in a custom archive page (where they are all listed), you can create an archive-books.php template file and this will show all the book posts that you’ve published.

## Post Type Queries

In the event that you want to get a list of your custom posts called Books, you can create a new [WP\_Query](https://developer.wordpress.org/reference/classes/wp_query/) instance and fetch them all. This is handy if you want to create a custom loop somewhere on your website and show them in a different way to other posts.

## The Posts Query

You might find that in some cases you want to include custom posts into your main query of blog posts. You can do this by using the [pre\_get\_posts](https://developer.wordpress.org/reference/hooks/pre_get_posts/) filter hook which lets you customize the query that gets your posts before it’s shown on the front-end of the website.
