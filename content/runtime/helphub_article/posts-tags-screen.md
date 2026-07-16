---
type: document
title: Posts Tags screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/posts-tags-screen/"
tags:
timestamp: "2026-06-16T19:29:02+00:00"
wordpress:
  id: 2359
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:02"
  date_gmt: "2026-06-16 19:29:02"
  modified: "2026-06-16 19:29:02"
  modified_gmt: "2026-06-16 19:29:02"
  slug: posts-tags-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/posts-tags-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

Every post in WordPress can be filed under one or more Tags. This aids in navigation and allows posts and to be grouped with others of similar content.

Unlike Categories, Tags have no hierarchy so there is no Parent-&gt;Child relationship like that of Categories. But like Categories, Tag names must be unique.

Assuming you are using the WordPress [Twenty Seventeen theme](/themes/twentyseventeen/), Tags are displayed under each post. When someone viewing your blog clicks on one of these Tag links, a Tag archive page with all the posts belonging to that Tag, will be displayed. In addition, if using Widgets, the Tag Cloud Widget can be added to the sidebar to display all the Tags used in a cloud (Tags sized by number of times reference in posts).

[![Posts Tag Screen](https://i2.wp.com/wordpress.org/documentation/files/2019/01/tag-screen.png?fit=1168%2C600&ssl=1)](https://wordpress.org/support/?attachment_id=11108222)Posts Tag ScreenThis Screen allows you to create new Tags, and to edit or delete existing ones.

## Manage Tags

This Screen is divided into the Popular Tags, Add New Tag and Tag Table sections.

### Popular Tags

In this section, a Tag Cloud displays the forty-five (45) most popular Tags–meaning the Tags that are most used on posts. With the proper capability, each Tag can be clicked to edit that Tag. Of course, if no Tags have been assigned to posts, then this section will not appear.

### Add New Tag

This part of the Screen, which is conveniently linked to from the top of the Table of Tags, allows you to create a new Tag. There are three pieces of information associated with each new Tag: the name, description, slug, and number of posts containing that Tag.

**Tag Name**: To reiterate, the Tag Name *must* be unique.

**Tag Slug**: The Tag slug *must* be unique. The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens. For example, setting a Tag Name of “Recipes” and a Tag Slug of “food” would show all “Recipes” posts with a URL like **example.com/blog/food/**.

**Description**: A description for the Tag. Note: In many themes the Tag Description not displayed, however some themes may show it.

**Add New Tag**: Click this button to save your new Tag.

### Table of Tags

This table lists all of your Tags by row. Tags are displayed alphabetically by Tag Name.

The table of Tags contains the following columns:

- **\[ \]** – A checkbox that when clicked (checked), ‘selects’ that particular Tag to be deleted when the Delete Action is Applied.
- **Name** – The name of the Tag. Remember each Name must be unique. Click on the Tag’s Name to edit the Tag.
- **Description** – The description of the Tag.
- **Slug** – The slug of a Tag, and must be unique.
- **Count** – The number of posts which have this Tag assigned. Click on the number in the Count column to be directed to the Posts Screen to manage the Posts in that Tag.

#### Screen Options

The Screen Options allow you to choose which columns are displayed, or not displayed, in the underlying Table. Clicking on the Screen Options tab shows a list of the columns with a check-box next to each column. Check the box for each column you want displayed in the Table, or uncheck the box to not display that column. In addition, the number of Tags to display in the Table of Tags can be set. Click the Screen Options tab again to close the Screen Options.

#### Search

Above the Table, to the right, is a search box where you can enter a word, or series of words, and click the “Search Tags” button to search and display all the Tags meeting your search words.

### Using Selection, Actions, and Apply

#### Selection

This section allows Actions to be performed on one or more Tags displayed in the Table. For Actions to be performed on multiple Tags at once, those Tags must be first **selected** via one of these methods:

- **Select one Tag at a time** – To select a Tag, the checkbox to the left of the Tag entry must be checked (clicked). It is possible to keep selecting more Tags by checking their respective checkbox.
- **Select all Tags in given Table** – All Tags in a given table can be selected by checking the checkbox in the Table’s title, or footer bar. Of course, unchecking the header or footer title bar checkbox will cause all entries in that Table to be unchecked (NOT selected).
- **Reverse Selection** – A Reverse Selection means checked items become unchecked, and unchecked items become checked. A Reverse Selection is accomplished by holding the Shift key on the keyboard and clicking the header or footer title bar checkbox.

#### Actions

Actions describe the process to be performed on particular Tags. There are two styles of Actions that will be referred to as *Bulk Actions* and *Immediate Actions*. The follow describes these Actions:

- **Bulk Actions** – These Actions can be performed on one, or more Tags, at one time, if those Tags have been previously selected. Bulk Actions are available, when appropriate, as choices in the Actions pulldown box, above each Table. The only Bulk Action allowed is Delete.
- **Immediate Actions** – Immediate Actions are performed immediately, on an individual Tag. Hovering the mouse cursor over the Tag row reveals the Edit, Quick Edit, and Delete options under the Name column in that Tag row. Clicking on a Tag Name will also initiate the Edit Action.

The available Actions are described below:

- **Edit** – This Immediate Action displays the Edit Tag Screen to edit the Tag fields. This Action can be initiated by click on the Tag Name or clicking on the Edit option just below the Tag Name. See the Edit Tag section for details on editing a Tag.
- **Quick Edit** – This Immediate Action initiates the Quick Edit of that Tag. See the Quick Edit section for details doing a Quick Edit on a Tag.
- **Delete** – This Action deletes the Tags files. Note: Deleting a Tag does not delete the posts in that Tag.

#### Apply

After one or more Tags are *selected*, and after a *Bulk* Action is specified, the **Apply** button performs the given Action on the selected Tags.

- **Apply** – Click the Apply button to execute the Bulk Action, specified in the Actions pull-down, on the selected Tags. Remember, prior to executing Actions, one or more Tags must be **selected**, as described before.

### Quick Edit

The following fields can be change via the Quick Edit Action:

**Tag name:** The Tag name *must* be unique.

**Tag slug:** The Tag slug *must* be unique. Cancel: Click this button to cancel any changes and return to the Table of Tags

**Update Tag:** Once you’ve edited all the information about the Tag, use this button to save the changes.

### Edit Tag

This Screen is displayed by clicking on a Tags’ **Name** in the Table of Tags or clicking on the Edit option just below the Tag Name. It is possible to edit three pieces of information associated with each Tag: the name, the slug, and the description.

**Tag name**: The Tag name *must* be unique.

**Tag Slug:** The Tag slug *must* be unique.

**Description**: Text describing this Tag.

**Update:** Once you’ve changed the Tag information, use this button to save the changes.
