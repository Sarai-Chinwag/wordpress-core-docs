---
type: document
title: Settings Discussion screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-discussion-screen/"
tags:
timestamp: "2026-06-16T19:29:08+00:00"
wordpress:
  id: 2388
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:08"
  date_gmt: "2026-06-16 19:29:08"
  modified: "2026-06-16 19:29:08"
  modified_gmt: "2026-06-16 19:29:08"
  slug: settings-discussion-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/settings-discussion-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The **Settings Discussion Screen** allows you to set the options concerning comments (also called discussion). It is here the administrator decides if [comments](/support/article/glossary/#comments) are allowed, if [pingbacks](/support/article/glossary/#pingback) and [trackbacks](/support/article/glossary/#trackback) are acceptable, and what constitutes [Comment Spam](https://codex.wordpress.org/Combating_Comment_Spam). On this Screen you also control the circumstances under which your blog sends you e-mail notification of certain events at your site.

![](https://wordpress.org/documentation/files/2018/11/320px-options-discussion1.png)

## Discussion Settings

### Default article Setting

These settings may be overridden for individual articles.

- **Attempt to notify any blogs linked to from the article** – If you check this box, WordPress will send out a ping to a site or article you have linked to in your post. Your mention of their site or article will show up in the comment section of their site, if that site allows [pingbacks](/support/article/glossary/#pingback). The notification occurs during the process of publishing your article to the internet. An article with many hyperlinks will slow the posting process as WordPress contacts all of the sites before the post is published.
- **Allow link notifications from other blogs (pingbacks and trackbacks)** – Check this box so WordPress to accepts or declines the pings from other sites which may reference your site or an article on your site. If this box is checked, [pingbacks](/support/article/glossary/#pingback) and [trackbacks](/support/article/glossary/#trackback) will appear in the comments section of your posts.
- **Allow people to post comments on new articles** – Check this box if you wish to allow comments to your posts. Remember that this can be overridden for individual articles. Comments can also be controlled by making an article PRIVATE, which requires the appropriate password before a comment is allowed. If you don’t wish to allow comments uncheck this setting.

### Other comment settings

- **Comment author must fill out name and e-mail** – Check this box as a way to force spammers to do a bit of extra work. In reality, the name and e-mail address are not verified in any way prior to the comment being submitted. Most legitimate commenters are more than willing to fill out a name and e-mail address.
- **Users must be registered and logged in to comment** – If this checkbox is checked, only logged in *registered users* will be able to write comments on your site.
- **Automatically close comments on articles older than \[X\] days** – Check the box and enter the number of days (e.g. 14 days) after which WordPress will automatically flag eligible posts so that no more comments are accepted.
- **Enable threaded (nested) comments \[X\] levels deep** – Check this box to enable threaded comments, then from the drop-down box, select the number of levels deep (maximum of 10 levels) you will allow for nested comments. Note that themes need to be specially coded to properly display threaded comments.
- **Break comments into pages with \[X\] top level comments per page and the \[last/first\] page displayed by default. Comments should be displayed with the \[older/newer\] comments at the top of each page** – Check this box to cause comments to display in a paginated format with the specified number of comments per page. In addition, specify if the pages should be ordered “first to last” or “last to first”, and within each page, whether the oldest, or newest, comment is to be displayed first.

### Email me whenever

These two settings give you control of when authors and administrators receive notification that comments have been made, or that comments are held for moderation. Please note that the use of “me” refers to either a post author or the administrator (person whose email address is used for admin purposes).

- **Anyone posts a comment** – Check this box so that every single comment posted will generate an email to the author of that post. Be warned that if your posts receive a large number of comments, post authors may find a very full email Inbox. If you wish to micromanage comments, then by all means, activate this setting by checking the box.
- **A comment is held for moderation** – Check this box if you want WordPress to send notification that a comment is being held for moderation. The email notification is sent to the E-mail address listed in the [Administration](/support/article/administration-screens/) &gt; [Settings](/support/article/administration-screens/#general) &gt; [General](/support/article/settings-general-screen/) Screen. This is useful if your blog has multiple authors and each author is authorized to allow or decline comments. That way, you, the owner of the site, can review what comments are being allowed or denied.

### Before a comment appears

These settings provide you even more control over the instances of when and how comments are posted.

- **An administrator must always approve the comment** – Select this option to force comments to be approved by a blog user or owner having the proper [Role](/support/article/roles-and-capabilities/) to approve comments, even if the comments appear to be spam . See the Comment Moderation options below regarding spam.
- **Comment author must have a previously approved comment** – Check the box to insure comments are only posted if the comment author’s email address matches the address of a previously approved comment, otherwise, the comment is held for moderation. Comments from blocked email addresses (those listed in the Local Spam Words Text Box) are held for moderation regardless of whitelist status.

### Comment Moderation

In the [Comment Moderation](https://codex.wordpress.org/Comment_Moderation) section you specify these options to help you deal with [Comment Spam](https://codex.wordpress.org/Comment_Spam).

- **Hold a comment in the queue if it contains \[X\] or more links (A common characteristic of comment spam is a large number of hyperlinks.)** – Not too long ago, comment spammers would have five, ten, or more hyperlinks in their comment spam. This made it very easy for bloggers to quickly screen comments but spammers recognized that and commonly use only one or two hyperlinks. You can enter a number in this box to tell WordPress how many links you allow in a comment before holding it for moderation.
- **When a comment contains any of these words in its content, name, URL, e-mail, IP or browser’s user-agent string it will be held in the moderation queue. One word or IP per line. It will match inside words, so “press” will match “WordPress”** – In this text box you can add your own spam words which will filter the comments when posted.

### Comment Blocklist

Previous to WordPress version 5.4, this was named “Comment Blacklist”.

- **When a comment contains any of these words in its content, author name, URL, e-mail, IP address or browser’s user-agent string, it will be marked as spam. One word or IP per line. It will match inside words, so “press” will match “WordPress”**. This text box acts the same as “When a comment conatins any of these words…” except comments which match these words will be **deleted without warning**. You may want to use this as a last resort, as genuine comments can end up deleted

### Avatars

An avatar is an image that follows you from weblog to weblog appearing beside your name when you comment on avatar enabled sites. Here you can enable the display of avatars for people who comment on your blog. By default WordPress uses Gravatars — short for Globally Recognized Avatars — for the pictures that show up next to comments. Plugins may override this.

#### Avatar display

- **Don’t show Avatars** – Check this radio button to suppress avatar display in comments.
- **Show Avatars** – Check this so comment author avatars are displayed along with the comments.

#### Maximum Rating

This setting controls (or limits) the ‘highest’ level or rating of gravatar you allow to be displayed.

- **G — Suitable for all audiences**
- **PG — Possibly offensive, usually for audiences 13 and above**
- **R — Intended for adult audiences above 17**
- **﻿X — Even more mature than above**

#### Default Avatar

For users without a custom avatar of their own, you can either display a generic logo or a generated one based on their e-mail address.

- **Mystery Man**
- **Blank**
- **Gravatar Logo**
- **Identicon (Generated)**
- **Wavatar (Generated)**
- **MonsterID (Generated)**
- **﻿Retro (Generated)**

### Save Changes

Click the **Save Changes** button to ensure any changes you have made to your Settings are saved to your database. Once you click the button, a confirmation text box will appear at the top of the page telling you your settings have been saved.
