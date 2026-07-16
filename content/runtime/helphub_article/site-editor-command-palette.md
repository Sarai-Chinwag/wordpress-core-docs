---
type: document
title: Command Palette
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor-command-palette/"
tags:
timestamp: "2026-06-16T19:28:18+00:00"
wordpress:
  id: 2154
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:18"
  date_gmt: "2026-06-16 19:28:18"
  modified: "2026-06-16 19:28:18"
  modified_gmt: "2026-06-16 19:28:18"
  slug: site-editor-command-palette
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor-command-palette/"
  comment_count: 0
  terms:
    category:
      - customization
      - site-editor
---

The **Command Palette** offers you a way to quickly navigate and manage your entire site with the ability to invoke different actions such as:

- Navigate to a different part of your dashboard, like Media Library to creating a new post.
- Search for individual posts or pages and create new ones.
- Search through templates, template parts and patterns.
- Add custom CSS.
- Access Styles and style revisions.
- Transform and manipulate blocks.
- Toggle settings and preferences.
- Reset customisations.

It exists in any admin screen, the Site Editor, and the Post/Page editor. It is not available when you view the front end of your site.

## How to access the Command Palette

To access the Command Palette, use the keyboard shortcut `Cmd+k` on Mac or `Ctrl+k` on Windows anywhere in your site. Once the command line opens, you can start typing to search for the action or content you want. Please note that the [keyboard shortcut is not available in some environments](https://github.com/WordPress/gutenberg/issues/51737) at the moment.

You can also invoke it specifically when you’re in the Site Editor and click on the title, at the top center of the editor.

You will also find it available when in the Site View in the sidebar by clicking on the search icon.

## List of available commands

Here’s a list of all available commands:

- *Edit Template* when editing a page.
- *Back to page* to return to editing a page from a template.
- *Reset template*
- *Reset template part*
- *Reset styles to default*
- *Delete template*
- *Delete template part*
- *Toggle settings sidebar*
- *Toggle block inspector*
- *Toggle spotlight mode*
- *Toggle distraction free*
- *Toggle top toolbar*
- *Open code editor*
- *Exit code editor*
- *Toggle list view*
- *Toggle fullscreen mode*
- *Editor preferences*
- *Keyboard shortcuts*
- *Show/Hide block breadcrumbs*
- *Customize CSS*
- *Style revisions*
- *Open styles*
- *Learn about styles* to trigger the welcome guide for Styles
- *Reset styles*
- *View site*
- *View templates*
- *View template parts*
- *Open Navigation Menus*
- *Rename Pattern*
- *Duplicate Pattern*
- *Manage all custom patterns*
- *Go to Site Editor*
- *Add new page*
- View site
- *Individual Pages (searchable by title)*
- *Individual Posts (searchable by title)*
- *Individual Templates (searchable by title)*
- *Individual Template Parts (searchable by title)*
- *Go to: Dashboard*
- *Go to: Posts*
- *Go to: Posts&gt; All posts*
- *Go to: Posts&gt; Add post*
- *Go to: Posts&gt; Tags*
- *Go to: Posts&gt; Categories*
- *Go to: Media &gt; Library*
- *Go to: Media &gt; Add media file*
- *Go to: Pages*
- *Go to: Pages &gt; All pages*
- *Go to: Pages &gt; Add page*
- *Go to: Comments*
- *Go to: Appearance*
- *Go to: Plugins*
- *Go to: Plugins &gt; Add plugin*
- *Go to: Plugins &gt; Installed plugin*s
- *Go to: Users*
- *Go to: Users &gt; All Users*
- *Go to: Users &gt; Add User*
- *Go to: Users &gt; Profile*
- *Go to: Tools*
- *Go to: Tools* &gt; *Available Tools*
- *Go to: Tools* &gt; *Import*
- *Go to: Tools* &gt; *Export*
- *Go to: Tools* &gt; *Site Health*
- *Go to: Tools* &gt; *Import*
- *Go to: Tools &gt; Export Personal Data*
- *Go to: Tools &gt; Erase Personal Data*
- *Go to: Tools* &gt; *Theme File Editor*
- *Go to: Tools* &gt; *Plugin File Editor*
- *Go to: Settings*
- *Go to: Settings &gt; General*
- *Go to: Settings &gt; Writing*
- *Go to: Settings &gt; Reading*
- *Go to: Settings &gt; Discussion*
- *Go to: Settings &gt; Media*
- *Go to: Settings &gt; Permalinks*
- *Go to: Settings &gt; Privacy*

An up-to-date list of all the available commands can be found [here](https://github.com/WordPress/gutenberg/tree/trunk/packages/edit-site/src/hooks/commands).

## Demo

Please watch the demo below for more details.

## Registering custom commands

It is possible to extend the Command Palette by registering your own commands. You can read more details on how to register your own commands [here](https://make.wordpress.org/core/2023/07/17/introducing-the-wordpress-command-palette-api/).

## Changelog

- Update 2025-11-27 (props @annezazu)
    - Updated doc in light of command palette everywhere work for 6.9
- Update 2025-11-10 (props @karthickmurugan)
    - Add new commands for 6.8: Go to Site Editor and Add new page
- Updated 2023-11-27
    - Changed wording to refer to Site *and* Post Editor
    - Updated list of Commands
- Updated 2023-08-24
    - Updated headings formatting
    - Added category and subcategory
- Created 2023-08-08
