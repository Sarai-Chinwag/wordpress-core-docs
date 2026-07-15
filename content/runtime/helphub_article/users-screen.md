---
type: document
title: Users screen
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/users-screen/"
tags:
timestamp: "2026-06-16T19:29:01+00:00"
wordpress:
  id: 2352
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:01"
  date_gmt: "2026-06-16 19:29:01"
  modified: "2026-06-16 19:29:01"
  modified_gmt: "2026-06-16 19:29:01"
  slug: users-screen
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/users-screen/"
  comment_count: 0
  terms:
    category:
      - dashboard
      - support-guides
---

The **Users Screen** allows you to add, change, or delete your site’s users. In addition, you can search for users and make bulk changes and deletions to a selected group of users.

[![](https://i1.wp.com/wordpress.org/documentation/files/2019/01/users-screen.png?fit=1236%2C560&ssl=1)](https://wordpress.org/support/?attachment_id=11149341)Users screen## Table of users

The main part of the **Users Screen** displays a table of all the users listed by Username order.

The table of Users contains the following columns:

- **\[ \] check box:** Check this box if this user is to be affected by the Delete or Change User Role functions. There is also a checkbox in the column header to the left of the text Username—click that checkbox to cause all Users to be checked.
- **User Image:** Avatar for this particular user.
- **Username:** The login of the User. To edit a User, click on the Username link, the Users Your Profile Screen will then display for you to make the necessary changes. Also note that if you hover the mouse anywhere over the whole row for a particular user, the Edit and Delete links will be made visible for use. The current logged in user will not have the Delete link revealed.
- **Name:** The first and last names of the User.
- **E-mail:** The User’s e-mail address.
- **Role:** The Role assigned to that User. A user’s role determines their [capabilities](https://wordpress.org/documentation/article/roles-and-capabilities/) in WordPress.
- **Posts:** The number of Posts written by that User. Click on that number to be directed to the Posts Screen to view or edit the Posts written by this User. All users have a unique identification number, which WordPress uses to identify users internally. To determine that **User ID**, hover the mouse over the Posts number link, and the User ID (author=x) will be revealed as part of the URL in the browser status bar.

### Sortable columns

Some column headings, such as the Username, Name, and Email, can be clicked to sort the Table of Users in ascending or descending order. Hover over the column title, for example Username, to see the up-arrow or down-arrow. Click the heading to change the sort order.

### Page navigation

Under the Screen Options, the number of Users displayed per page is determined. If more than one page of Users is available, two double-arrow boxes to move to the first and last page are provided. Also two single-arrow boxes are displayed to move one page backward or forward. Finally, a box showing the current page number can be used to enter a page to directly display.

### Screen options

Under the top shaded area is the Screen Options hanging tab. Clicking on that hanging tab reveals the **Show on screen** choices of E-Mail, Role, and Posts check boxes. Unchecking a box causes a column to be not shown in the Table below, and, of course, checking a box causes that column to be displayed in the Table below.

### Search

At the top right of the User Table is a search box to help find users. Enter a string in the box and click the “Search users” box. Any User that contains the search string in the Username, Name, E-mail, or Website fields will be displayed, by [Role](/support/articles/roles-and-capabilities). You can then add, change, and delete those users. A “No matching users were found! ” message will be displayed if no Users can be found that match the search string you entered.

## Filtering options

Just above the User Table, are filter links to All Users, and to links to Users belonging to the each of the various Roles. Clicking on one of those links, say Subscribers, will display all the Users assigned the Subscriber Role. Click on All Users to again display all the Users in the table.

## Using selection, actions, and apply

### Selection

This Screen allows Bulk Actions to be performed on one or more Users selected in the Table. For Bulk Actions to be performed on multiple Users at once, those users must be first **selected** via one of these methods:

- **Select one User at a time:** To select a User, the
    checkbox to the left of the User entry must be checked (clicked). It is
     possible to keep selecting more Users by checking their respective
    checkbox.
- **Select all Users in given Table:** All Users in a given table
    can be selected by checking the checkbox in the Table’s title, or footer
     bar. Of course, unchecking the header or footer title bar checkbox
    will cause all entries in that Table to be unchecked (NOT selected).
- **Reverse Selection:** A Reverse Selection means checked items
    become unchecked, and unchecked items become checked. A Reverse
    Selection is accomplished by holding the Shift key on the keyboard and
    clicking the header or footer title bar checkbox.

### Actions

Actions describe the process to be performed on particular Users. There are two styles of Actions that will be referred to as *Bulk Actions* and *Immediate Actions*. The follow describes these Actions:

- **Bulk Actions:** These Actions can be performed on one, or more Users, at one time, if those Users have been previously selected. Bulk Actions are available, when appropriate, as choices in the Bulk Actions pull down box, above the Table. The only Bulk Action allowed is Delete.
- **Immediate Actions:** Immediate Actions are performed immediately, on an individual User. Hovering the mouse cursor over the User row reveals the Edit or Delete options under the Username column, in that User row. Clicking on a Username Name will also initiate the Edit Action.

The available Actions are described below:

- **Edit:** This Immediate Action displays the Edit User Screen. This Action can be initiated by click on the Username or clicking on the Edit option just below the Username.
- **Delete:** This Action deletes the User.

### Apply

After one or more Users are *selected*, and after a *Bulk* Action is specified, the **Apply** button performs the given Action on the selected Users.

- **Apply:** Click the Apply button to execute the Bulk Action, specified in the Actions pull down, on the selected Users. Remember, prior to executing Actions, one or more Users must be **selected**, as described before.

## Delete users

Available as both Bulk Action and an Immediate Action, the delete user capability is allowed on all but the current user (you cannot delete the user doing the deletion!). After the Delete action has begun, a Delete Users Screen will display with a message “You have specified these users for deletion:” with a list of the Users you are deleting with the following question: **What should be done with posts and links owned by this user?**

- **Delete all posts and links:** Check this radio button and click the Confirm Deletion button to delete the User(s) as well as any posts and links attributed to those User(s).
- **Attribute all posts and links to:** Check this radio button, select a User from the adjacent drop-down box, and click the Confirm Deletion button to attribute all the posts and links for the Deleted User(s) to the User you selected in the pull down box.

Upon successful completion of the deletion process, a splash message box near the top of the Screen will display “x user(s) deleted”.

## Change roles to

To the right of the Action pull-down box is the **Change role to** pull-down box. Select a Role, and all the Users that have been selected (checked), will be changed to that Role upon clicking the Change button. At successful completion of the changes, a splash box with the message “Changed roles.” displays.

## Edit users

The Edit Users Screen is similar to editing your profile.
