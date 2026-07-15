---
type: document
title: Revisions
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/revisions/"
tags:
timestamp: "2026-06-16T19:29:00+00:00"
wordpress:
  id: 2344
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:00"
  date_gmt: "2026-06-16 19:29:00"
  modified: "2026-06-16 19:29:00"
  modified_gmt: "2026-06-16 19:29:00"
  slug: revisions
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/revisions/"
  comment_count: 0
  terms:
    category:
      - publishing
      - support-guides
---

The WordPress revisions system stores a record of each saved draft or published update. The revision system allows you to see what changes were made in each revision by dragging a slider. The display indicates what has changed in each revision – what was added, what remained unchanged, and what was removed. Lines added or removed are highlighted, and individual character changes get additional highlighting. Click the ‘Restore This Revision’ button to restore a revision.

## View revisions

To view revisions:

1. Open the Settings sidebar.
2. Select the Page or Post tab.
3. Click the number next to Revisions.

Since WordPress 7.0, clicking the revision opens a new revisions screen. If you are using WordPress 6.9 or earlier, see Classic Revisions below.

![Revisions screen with highlighted texts.](https://wordpress.org/documentation/files/2019/02/revisions-1-7.0-1024x569.jpg)## Revisions screen

### Top slider

The revisions screen lets you see what changed in each revision by dragging the top slider.

### Color indicators

Next to the scrollbar, you will see colored markers that indicate where changes were made and how large they are. Click a marker to jump to that location.
Color meanings:

- Green: inserted content
- Red: deleted content
- Yellow: changed content

### Show changes

The Show changes icon on the left side of the slider toggles the colored highlights on and off.

![Show changes icon](https://wordpress.org/documentation/files/2019/02/revisions-3-7.0-1024x376.jpg)## Restore a revision

To restore a revision:

1. Use the top slider to find the revision you want to restore.
2. Click Restore.

## Classic Revisions

In WordPress 6.9 and earlier, clicking the revisions number in the sidebar opens the classic revisions screen. In WordPress 7.0, you can also open this screen by clicking Open classic revisions screen in the sidebar.
The classic revisions screen shows a side-by-side comparison of the HTML version of the content.

![Classic revisions screen](https://wordpress.org/documentation/files/2019/02/revisions-2-7.0-1024x577.jpg)Like the new revisions screen, you can see what changed in each revision by dragging the slider or using the Next and Previous buttons.

The revisions page also includes a Compare any two revisions mode that lets you compare any two revisions. In this mode, the slider has two handles: one for the revision you are comparing from and one for the revision you are comparing to. Drag the handles to see the changes between any two specific revisions.

## Autosaves

There is only ever a maximum of one [autosave ](/support/article/glossary#autosave)per user for any given post. New autosaves overwrite old autosaves. This means that no, your tables do not grow by one row every 60 seconds. In multi-user settings, one autosave is stored for each user.

Autosaves are enabled for all posts and pages but do not overwrite published content. Autosaves are stored as a special type of revision; they do not overwrite the actual post. In fact, whether your power goes out, your browser crashes, or you lose your internet connection, when you go back to edit that post, WP will toss up a warning telling you that it has a backup of your post and a link to restore the backup. When reviewing revisions, autosaves are clearly marked.

## Revision Options

Limit the number of posts revisions that WordPress stores in the database.

The [wp\_revisions\_to\_keep](https://codex.wordpress.org/Plugin_API/Filter_Reference/wp_revisions_to_keep) filter allows developers to easily alter how many revisions are kept for a given post.

Alternately, the limit can be set in wp-config.php:

```
define( 'WP_POST_REVISIONS', 3 );
```

WP\_POST\_REVISIONS:

- true (default), -1: store every revision
- false, 0: do not store any revisions (except the one autosave per post)
- (int) &gt; 0: store that many revisions (+1 autosave per user) per post. Old revisions are automatically deleted when the post is updated again.

## Revision Storage Method

Revisions are stored in the posts table.

Revisions are stored as children of their associated post (the same thing we do for attachments). They are given a post\_status of ‘inherit’, a post\_type of ‘revision’, and a post\_name of {parent ID}- revision(-#) for regular revisions and {parent ID}-autosave for autosaves.

By default, WP keeps track of the changes to title, author, content, excerpt.

## Revision Management

Deleting: There is an API function to delete revisions, but there is no UI. That can certainly change.

## Displaying Rendered Revisions

Currently revision comparison “diffs” are rendered in Text (or HTML) view; proposed filters would allow plugin developers to customize diff encoding/rendering. (see Trac ticket [\#24908](https://core.trac.wordpress.org/ticket/24908))

## Changelog

- Updated 2026-05-01
    - New revisions screen for WordPress 7.0
