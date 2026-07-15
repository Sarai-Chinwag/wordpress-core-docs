---
type: document
title: Notes
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/notes/"
tags:
timestamp: "2026-06-16T19:28:13+00:00"
wordpress:
  id: 2124
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:13"
  date_gmt: "2026-06-16 19:28:13"
  modified: "2026-06-16 19:28:13"
  modified_gmt: "2026-06-16 19:28:13"
  slug: notes
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/notes/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

Notes let you and your team leave contextual feedback directly on individual blocks while editing a post or page. You can add notes, reply in threads, resolve conversations when they’re done, and keep collaboration inside WordPress. Notes never appear on the frontend of your site. Currently, Notes can only be added on a per block basis, meaning you can’t add notes for an individual item with a block.

## What you need

- WordPress 6.9 or later.
- A user role that can edit the post or page (see “Permissions and visibility” below).

## Where Notes are available

- Post and page editors.
- Notes are not shown on the frontend and are not available in the Site Editor (templates, template parts) in WordPress 6.9.
- Custom post types can support Notes if enabled by a theme or plugin author. If you don’t see Notes on a custom post type you use, please follow [these instructions](https://make.wordpress.org/core/2025/11/15/notes-feature-in-wordpress-6-9/) to add support.

## How to use notes

### Add a note

1. Open a post or page in the block editor.
2. Select the block you want to discuss.
3. In the toolbar, select the three dot menu, and choose “Add Note”
4. Type your message and submit to create the note.

![Block toolbar opened with an arrow pointing to the Add Note option.](https://wordpress.org/documentation/files/2025/11/Add-note.png)### Reply to a note

Open the note thread attached to the block or from the Notes panel and add your reply. Replies stay threaded with the original note.

### Edit or delete your note

1. Select the note you want to edit or delete.
2. Select the three dot menu in the note.
3. This will reveal two options: edit or delete.
4. Select which option you want and proceed to edit or delete. Deleting a note removes it from the thread.

![](https://wordpress.org/documentation/files/2025/11/Edit-or-delete-note.png)### Resolve and reopen a note

To resolve, follow these steps:

1. Select the note you want to resolve.
2. Select the check option. This will resolve the note.
3. Resolved notes are hidden from active views but remain available in the post’s history for reference.

To reopen a resolved note, follow these steps:

1. Select the dedicated Notes view in the top toolbar. This displays all notes, including any that were resolved.
2. Select the note you want to reopen.
3. Write a new note in the text field and then select “Reopen and reply”.
4. This will reopen the note with your new message.

### View notes for a block

1. If a block has a note attached, you’ll see an indication in the block toolbar that shows the users avatar.
2. Select the avatar and it will display related notes.

Otherwise, you can also select the dedicated Notes view in the top toolbar. This displays all notes, including any that were resolved, and you can select different notes to see their respective blocks.

## Email notifications

- By default, the post author receives an email when another user leaves a new note on their post.
- To change this behavior, go to Settings &gt; Discussion and adjust “Email me whenever &gt; Anyone posts a note.”
- Site administrators can fine-tune notifications with plugins or custom code by [following these instructions](https://make.wordpress.org/core/2025/11/15/notes-feature-in-wordpress-6-9/). End users can ask an administrator if they need different notification behavior.

## Permissions and visibility

- Only users who can edit a post can see or add notes on that post.
    - Administrators and Editors: can view and add notes on all posts.
    - Authors and Contributors: can view and add notes on their own posts.
    - Subscribers: cannot view or add notes.
- Notes are internal to your site and never appear to visitors.

## Tips for effective collaboration

- Use one note per topic to keep conversations focused.
- Resolve notes when tasks are complete to reduce clutter.
- Use replies instead of creating new notes when continuing the same conversation.

## Demo

## Troubleshooting

**I don’t see Notes:**

- Confirm the site is running WordPress 6.9 or later.
- Make sure you’re editing a post or page (Notes are not available in templates in 6.9).
- Verify you’re logged in and have permission to edit the post.
- Open the Notes panel in the editor sidebar, or select a block and look for the Notes control in the toolbar.
- Temporarily disable plugins or switch themes to rule out conflicts.

**Team members aren’t getting emails:**

- Check Settings &gt; Discussion: “Email me whenever &gt; Anyone posts a note” must be enabled.
- Verify the user is the post author or ask an administrator to customize notification behavior if different recipients are needed.

**Notes on my custom post type are missing:**

Please follow [these instructions](https://make.wordpress.org/core/2025/11/15/notes-feature-in-wordpress-6-9/) to add support.

## Frequently asked questions

**Do notes show on the live site?**

No. Notes are only visible in the editor to users who can edit the post.

**Can I leave a note on part of a paragraph or selected text?**

In WordPress 6.9, notes attach to entire blocks, not specific items within a block. This is a planned enhancement for the future.

**Can I see all notes assigned to me?**

WordPress 6.9 does not include user assignment or mentions in Notes. Your site may add similar features via plugins.

## For site owners and developers

- Notes are on by default for posts and pages. Custom post types can add support programmatically.
- Notification and other behaviors can be customized with existing comment-related filters.
- Technical details are available in the [WordPress 6.9 developer note](https://make.wordpress.org/core/2025/11/15/notes-feature-in-wordpress-6-9/) for this feature.

## Changelog:

- Created 2025-11-27
