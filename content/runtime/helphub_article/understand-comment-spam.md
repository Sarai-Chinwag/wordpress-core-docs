---
type: document
title: Understanding comment spam
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/understand-comment-spam/"
tags:
timestamp: "2026-06-16T19:28:59+00:00"
wordpress:
  id: 2337
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:59"
  date_gmt: "2026-06-16 19:28:59"
  modified: "2026-06-16 19:28:59"
  modified_gmt: "2026-06-16 19:28:59"
  slug: understand-comment-spam
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/understand-comment-spam/"
  comment_count: 0
  terms:
    category:
      - publishing
      - support-guides
---

If you’ve spent any time online, you’ve probably come across spam in one form or another. In general, spam is unwanted content posted for promotional, misleading, or abusive purposes.

The same thing can happen in your site’s comment section. Comment spam often shows up as irrelevant messages, suspicious links, repeated keywords, or generic comments posted just to promote another site, product, or service.

Some spam comments are posted manually, but many are generated automatically by bots. Either way, they can clutter your site, disrupt discussion, and create extra work for site owners and administrators.

## Fighting comment spam

WordPress includes several built-in settings that can help you reduce or manage comment spam.

### Moderate comments before they appear

Comment moderation is one of the simplest and most effective ways to deal with spam. When moderation is enabled, comments won’t appear on your site until an administrator approves them.

You can manage this in **Settings &gt; Discussion**.

### Require commenters to provide details

You can make commenting a little harder for spammers by requiring people to enter a name and email address, or by requiring them to be registered and logged in before they can comment.

These settings can help reduce some automated spam, although they may not stop every spammer.

### Limit the number of links allowed

Because many spam comments include links, WordPress lets you hold comments for moderation if they contain more than a set number of links.

This can be useful for catching spam, but keep in mind that it may also affect legitimate comments that include multiple links.

### Add words or terms to moderation lists

You can add words, IP addresses, email addresses, names, or other terms to your moderation or disallowed comment key lists. Comments containing those items can then be held for review or blocked automatically.

### Disable comments where they are not needed

If a page or post does not need comments, you may decide to turn comments off completely. This can be a simple way to avoid spam on content where discussion is not important.

If you want more detailed guidance, see [Comments in WordPress](https://wordpress.org/documentation/article/comments-in-wordpress/) and [Comment Moderation](https://wordpress.org/documentation/article/comment-moderation/).

## FAQ

Why are they spamming me?Usually, they are not targeting your site personally. Most comment spam is posted in bulk across many websites. The goal is often to place links in as many places as possible.

Where can I find WordPress anti-spam plugins?[Plugins for handling comment spam](https://wordpress.org/plugins/tags/anti-spam) can be found in the [Official WordPress Plugin Directory](https://wordpress.org/plugins/).

Which is the best plugin?There is no single answer to that. Spammers use different tactics, and plugins respond in different ways. A plugin that works well for one site may not be the best fit for another.

A good place to start is by looking at how recently the plugin has been updated, whether it is compatible with your version of WordPress, and whether the author offers clear documentation or support.

I have a problem with a pluginFirst, check the plugin’s documentation or support page. You can also search its support forum to see whether the issue has already been reported or solved.

What happens to comments that are marked as “Spam”?That depends on the tools and plugins you use. In many cases, spam comments are kept for a period of time before being deleted, which gives you a chance to review them.

I have spam appearing as soon as I publish a postThis can happen if comments are open and your site is being targeted by bots or spammers. Make sure WordPress and your plugins are up to date, review your discussion settings, and consider using moderation or an anti-spam plugin.

Why is every comment going into the moderation queue?This is often caused by your discussion settings. For example:

- Comment moderation may be enabled for all comments
- The comment may contain more links than your allowed limit
- The comment may include words or phrases from your moderation list

Check **Settings &gt; Discussion** to review the rules currently applied to comments.

I have disabled comments, but comments continue to be postedDisabling comments in **Settings &gt; Discussion** usually applies only to future content. Older posts or pages may still have comments enabled unless you update them individually.

To completely disable comments, you will have to edit each past post and uncheck **Allow Comments**. Alternatively, you could delete the wp-comments-post.php file, or run this MySQL query, from the command line on a shell account, or using [phpMyAdmin](https://codex.wordpress.org/phpMyAdmin): `UPDATE wp_posts SET comment_status="closed";`

I have disabled trackbacks, but trackbacks continue to be postedIf you have unchecked **Allow link notifications from other Weblogs (pingbacks and trackbacks.)** on the Options &gt; Discussion panel, then you have only disabled trackbacks on *future posts*. To completely disable trackbacks, you will have to edit each past post and uncheck **Allow Pings** from the Write Post SubPanel. Alternatively, you could just simply delete the wp-trackback.php file, or run this MySQL query, from the command line on a shell account, or using PHPMyAdmin: `UPDATE wp_posts SET ping_status="closed";`
