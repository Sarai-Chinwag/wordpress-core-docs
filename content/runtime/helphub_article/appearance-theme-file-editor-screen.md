---
type: document
title: Appearance Theme File Editor Screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/appearance-theme-file-editor-screen/"
tags:
timestamp: "2026-06-16T19:29:01+00:00"
wordpress:
  id: 2356
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:01"
  date_gmt: "2026-06-16 19:29:01"
  modified: "2026-06-16 19:29:01"
  modified_gmt: "2026-06-16 19:29:01"
  slug: appearance-theme-file-editor-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/appearance-theme-file-editor-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

Among the many user editable files in a standard WordPress installation are a Theme’s Template and Stylesheet files. The **Appearance Theme File Editor Screen** allows you to edit those Theme files.

[![appearance-editor](https://wordpress.org/documentation/files/2019/01/appearance-editor-1024x554.png)](https://wordpress.org/documentation/files/2019/01/appearance-editor.png)Appearance Editor### Edit Themes

The built-in Theme File Editor allows you to view or change (see next paragraph) any code kept in a Theme Template or Stylesheet files. The particular file contents are displayed in the large text (or edit) box that dominates this Screen.

If a specific file is writable, changes can be made, and saved. If a file is not writable, the message **You need to make this file writable before you can save your changes.** You need to change the File Permissions before changes can be saved.

The name of the Theme file being edited is displayed at the top of the text box. If the full text of the file cannot be viewed, a scroll bar to the right of the text box is provided. Since Theme files are pure text, no images or pictures can be inserted into the text box.

**Select theme to edit**

From this pull-down box, select the Theme that needs to be edited and click the Select button on the right. Once the Select button is clicked that Themes Template and Styles files will be listed on the right side of the text box and the Stylesheet (style.css) file for that Theme will be placed in the text box.

**Theme Files**

Listed to the right of the large text box is a list of the Theme Template or Stylesheet files that can be edited. Click on any of the file links to place the text of that file in the edit box.

Be very careful editing PHP files of your current theme. The editor does not make backup copies. If you introduce an error that crashes your site, you cannot use the editor to fix the problem. In such a case, use FTP to either upload a functional backup of the problem file or change the folder name of the current theme so WordPress is forced to use a different theme.

### Update File

Remember to click this button to save the changes you have made to the file. After clicking this button you should see a splash message at the top of the screen saying File Edited Successfully. If you don’t see that message, then your changes are not saved! Note that if a file is not writeable the Update File button will not be available.

**Note:** Changing files in this manner is not recommended. If you update the theme all of your changes will be lost. The best way to avoid this is through the use of a [child theme](https://developer.wordpress.org/themes/advanced-topics/child-themes/).
