---
type: document
title: Pages screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/pages-screen/"
tags:
timestamp: "2026-06-16T19:29:09+00:00"
wordpress:
  id: 2394
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:09"
  date_gmt: "2026-06-16 19:29:09"
  modified: "2026-06-16 19:29:09"
  modified_gmt: "2026-06-16 19:29:09"
  slug: pages-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/pages-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The Pages Screen provides the facility to manage all the [Pages](/support/article/pages/) in a blog. Via this Screen, Pages can be edited, deleted, and viewed. Filtering, and searching, also makes it easy to quickly find Pages matching certain criteria.

Several powerful features allow Pages to be edited in bulk (en masse) allowing fields such as Author, Parent, Template, Comments Allowed, Status, and Pings Allowed, to be changed for a whole batch of Pages. In addition, a Quick Edit feature provides an easy method to change a multitude of values, such as Title, Slug, Date, and Author, for a given Page.

![](https://wordpress.org/documentation/files/2018/11/managepages-enV4.4.2.png)## Pages Screen

### Table of Pages

A table lists all of your Pages, by row. The Pages are listed with the newest Page first.

The table of Pages contains the following columns:

- **\[ \]** – This checkbox, when clicked (checked), ‘selects’ that particular Page to be processed by a Bulk Action.
- **Title** – This is the Page’s Title displayed as a link. Click the Title link to allow this Page to be edited in the Edit Page screen. Next to the Title, if a Page is of a Draft, Pending, or Password Protected nature, text will display showing that.
- **“ID”** – This is not a column in the Table, but by hovering the mouse over the Page Title, the Page ID is revealed as part of the URL displayed in the browser status bar (in Firefox the status bar is displayed at the bottom of the screen). A Page’s ID number is the unique number WordPress’ database uses to identify individual Pages.
- **Author** – Displayed in the form of a link, this is the [author](https://codex.wordpress.org/Users_Screen) who wrote the Page. Clicking the author link causes all the Pages authored by that user to be displayed in the Table of Pages (thus allowing a Bulk Action to be applied to all Pages for a given author).
- **comment bubble** – A comment bubble is the column heading, and each Page row has comment bubble with the number of comments for that Page. If a Pages has any comments, then the number comments is displayed in a blue bubble. Clicking on a blue comment bubble causes the [Comments Screen](https://codex.wordpress.org/Comments_Screen) to be displayed to allow moderation of those comments.
- **Date** – The Date column for each Page shows the Date ‘Published’ for Published Pages and the Date ‘Last Modified’ for other Pages.

#### Sortable Columns

Some column headings, such as the Title, Author, and Date, can be clicked to sort the Table of Pages in ascending or descending order. Hover over the column title, for example Title, to see the up-arrow or down-arrow. Click the heading to change the sort order.

#### Page Navigation

Under the Screen Options, the number of Pages displayed per page is determined. If more then one page of Pages is available, two double-arrow boxes to move to the first and last page are provided. Also two single-arrow boxes are displayed to move one page backward or forward. Finally, a box showing the current page number can be used to enter a page to directly display.

#### Screen Options

The [Screen Options](/support/article/administration-screens/#screen-options) allow you to choose which columns are displayed, or not displayed, in the underlying Table. Clicking on the Screen Options tab shows a list of the columns with a check-box next to each column. Check the box for each column you want displayed in the Table, or uncheck the box to not display that column. In addition, the number of Pages per page can be set. Click the Screen Options tab again to close the Screen Options.

#### Search

Above the Table, to the right, is a search box where you can enter a word, or series of words, and click the “Search Pages” button to search and display all the Pages meeting your search words.

### Filtering Options

At the top of this Screen are links such as All, Published, Pending Review, Draft, Private, that when clicked, will cause just the Pages of that type to be displayed in the underlying Table.

Below that, and to the right of the [Bulk Actions](#actions) [Apply button](#apply), are one other filter option:

**Show all dates**

This dropdown allows you to select, by date, which Pages are displayed in the [Table of Pages](#table-of-pages). By default, “Show all dates” is selected and all of your Posts are displayed.

**Filter**

Clicking this button applies the settings you select in the dropdowns.

### Using Selection, Actions, and Apply

#### Selection

This Screen allows Bulk Actions to be performed on one or more Pages selected in the Table. For Bulk Actions to be performed on multiple Pages at once, those Pages must be first **selected** via one of these methods:

- **Select one Page at a time** – To select a Page, the checkbox to the left of the Page entry must be checked (clicked). It is possible to keep selecting more Pages by checking their respective checkbox.

#### Actions

Actions describe the process to be performed on particular Pages. There are two styles of Actions that will be referred to as *Bulk Actions* and *Immediate Actions*. The following describes these Actions:

- **Bulk Actions** – These Actions can be performed on one, or more Pages, at one time, if those Pages have been previously [selected](/support/article/pages-screen/#Selection). Bulk Actions are available, when appropriate, as choices in the Bulk Actions pulldown box, above the Table. The only Bulk Actions allowed are Edit and Delete.

The available Actions are described below:

- **Edit** – This Action can be either an “Immediate Action” or a “Bulk Action”. The Immediate Action, initiated by click on the Title or clicking on the Edit option just below the Title, causes the Edit Pages screen to display. Edit is also available as a Bulk Action for the selected Pages, so see the Bulk Edit section for details on the Bulk Editing process.

##### Bulk Edit

The Bulk Edit Pages ‘screen’ is displayed below the Table Of Pages header once, one, or more, Pages have been [selected](#selection), and the [Bulk Action](#action) of Edit is [Applied](/support/article/pages-screen/#Apply). Bulk Edit allows the fields Author, Parent, Template, Comments Allowed, Status, and Pings Allowed, to be changed for all the selected Pages.

- **Cancel** – Click Cancel to cancel and abort the Bulk Edit of these Pages.

##### Quick Edit

Quick Edit is an Immediate Action performed on one Page by clicking the Quick Edit link under the Page Title in the Table of Pages. Quick Edit is just an in-line edit that allows you to change the following items–Title, Slug, Date, Author, Password or Private page box, Parent, Order, Template, Allow Comments, Allow Pings, Status.

- **Cancel** – Click Cancel to cancel and abort the Edit of this Page.

##### Editing Individual Pages

This mode is essentially the same as the [Pages Add New Screen](/support/article/pages-add-new-screen/) so see that Screen for the specific details of writing a Page. The only difference is that the button to save your work is called “**Update**” instead of “**Publish**“.

#### Apply

After one or more Pages are *selected*, and after a *Bulk* Action is specified, the **Apply** button performs the given Action on the selected Pages.

- **Apply** – Click the Apply button to execute the Bulk Action, specified in the Actions pulldown, on the selected Pages. Remember, prior to executing Actions, one or more Pages must be **selected**, as described before.
