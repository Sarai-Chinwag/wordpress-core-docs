---
type: document
title: Use keyboard shortcuts (Classic Editor)
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/keyboard-shortcuts-classic-editor/"
tags:
timestamp: "2026-06-16T19:29:10+00:00"
wordpress:
  id: 2405
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:10"
  date_gmt: "2026-06-16 19:29:10"
  modified: "2026-06-16 19:29:10"
  modified_gmt: "2026-06-16 19:29:10"
  slug: keyboard-shortcuts-classic-editor
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/keyboard-shortcuts-classic-editor/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

## Editor Shortcuts

- **Note: This page lists keyboard Shortcuts for the Classic editor.**
- **For the Block Editor, [the list of Keyboard Shortcuts is here](https://wordpress.org/documentation/article/block-editor-keyboard-shortcuts/)**

In the WordPress visual editor you can use a combination of keys to do things that normally need a mouse, trackpad or other input device. Rather than reaching for your mouse to click on the toolbar, you can use the following keyboard shortcuts:

Windows and Linux use “Ctrl + letter”, Mac uses “Command (⌘) + letter”.

### Ctrl + key

```
Letter Actionc ... Copyv ... Pastea ... Select allx ... Cutz ... Undoy ... Redob ... Boldi ... Italicu ... Underlinek ... Insert/edit link
```

### Alt + Shift + key

The following shortcuts use a different key combination: Windows/Linux: “Alt + Shift (⇧) + letter”. Mac: “Ctrl + Option (alt ⌥) + letter”. (Macs running any WordPress version below 4.2 use “Alt + Shift (⇧) + letter”).

```
Letter Actionn ... Check Spelling (This requires a plugin.)l ... Align Leftj ... Justify Textc ... Align Centerd ... Strikethroughr ... Align Rightu ... • Lista ... Insert linko ... 1. Lists ... Remove linkq ... Quotem ... Insert Imagew ... Distraction Free Writing modet ... Insert More Tagp ... Insert Page Break tagh ... Helpx ... Add/remove code tag1 ... Heading 12 ... Heading 23 ... Heading 34 ... Heading 45 ... Heading 56 ... Heading 69 ... Address
```

### Formatting Shortcuts

Formatting Shortcuts while using visual editor (Since [Version 4.3](<https://codex.wordpress.org/Version 4.3>))

```
Letter . Action* ...... Start an unordered list- ...... Start an unordered list1. ..... Start an ordered list1) ..... Start an ordered list## ..... H2### .... H3#### ... H4##### .. H5###### . H6> ...... transform text into blockquote--- .... horizontal line`..` ... transform text into code block
```

## Keyboard Shortcuts for Comments

Beginning with [WordPress Version 2.7](<https://codex.wordpress.org/Version 2.7>), the ability to use keyboard shortcuts to browse and moderate comments was introduced. These keyboard shortcuts are designed to save time by allowing you to rapidly navigate and perform actions on comments. If your blog gets a large number of comments, you will find these shortcuts especially useful.

### Activating Keyboard Shortcuts

Keyboard shortcuts are enabled on a per-user setting, and can be turned on by visiting the Profile panel in [Administration Screens](/support/article/administration-screens/) &gt; [Users](/support/article/administration-screens/#your-profile) &gt; [Your Profile](/support/article/users-your-profile-screen/). Check the [Keyboard Shortcuts](/support/article/users-your-profile-screen/#your-profile-and-personal-options) checkbox to enable keyboard shortcuts for comment moderation.

Please note, the keyboard shortcuts are designed to use both hands, simultaneously, on a QWERTY style keyboard layout.

### The Meaning of Selected

The keyboard shortcuts are used for navigation and for actions. For any action to affect a comment, that comment must be first **selected**. The comment that is considered **selected** is indicated with a light-blue background. By default, no comment is selected, so, you will need to press either the letter **j** key, or letter **k** key, to start navigating.

### Using Keyboard Shortcuts to Navigate Comments

Navigating comments is accomplished with the **j** and **k** keys. When you first visit the Comments page, no comments is selected, so, first press the letter **j**, or the letter **k**, to select the first comment. After that, just press the letter **j** to move the select to the next comment.

- Pressing **j** moves the current selection (light-blue background) down.
- Pressing **k** moves the current selection (light-blue background) up.

Note that if you come to the bottom of a page of comments and press **j** again, you will be taken to the next page and the first comment of that next page will be selected. Likewise, pressing **k** at the top of a comment page will zoom you to the previous page, selecting the comment at the bottom of that previous page. This makes it very easy to navigate through a long list of comments to perform the necessary actions.

### Using Keyboard Shortcuts to Perform Actions on Comments

For one of these actions to affect a comment, make sure the comment is first selected (see above).

- Pressing **a** approves the currently selected comment.
- Pressing **s** marks the current comment as spam.
- Pressing **d** moves the comment to the trash (WordPress 2.9) or deletes the current comment.
- Pressing **z** restores the current comment from the trash or activates the Undo when that row is selected.
- Pressing **u** unapproves the currently selected comment, placing it back into moderation.
- Pressing **r** initiates an inline reply to the current comment (you can press **Esc** to cancel the reply).
- Pressing **q** activates “Quick Edit” which allows for rapid inline editing of the current comment.
- Pressing **e** navigates to the edit screen for the current comment.

### Bulk Actions

You can also perform an action on multiple comments at once. First, you’ll need to select the comments for the bulk action, using the **x** key to check the checkbox for the currently selected comment. **Shift-x** can be used to toggle the checkboxes, inverting their state. Once you have some comments checked:

- Pressing **Shift-a** approves the checked comments.
- Pressing **Shift-s** marks the checked comments as spam.
- Pressing **Shift-d** deletes the checked comments.
- Pressing **Shift-u** unapproves the checked comments.
- Pressing **Shift-t** moves the checked comments to the Trash.
- Pressing **Shift-z** restores the checked comments from the Trash.
