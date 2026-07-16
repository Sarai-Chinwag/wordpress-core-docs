---
type: document
title: Navigation block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/navigation-block/"
tags:
timestamp: "2026-06-16T19:28:34+00:00"
wordpress:
  id: 2220
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:34"
  date_gmt: "2026-06-16 19:28:34"
  modified: "2026-06-16 19:28:34"
  modified_gmt: "2026-06-16 19:28:34"
  slug: navigation-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/navigation-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

The Navigation block is an advanced block in WordPress 5.9 that enables you to edit your site’s navigation menu, both in terms of structure and design. The Navigation block can be used with a [block theme](https://wordpress.org/themes/tags/full-site-editing/) or a theme that has support for [template editing](https://wordpress.org/themes/tags/template-editing/).

In order to add a Navigation block, click on the add block button and select the Navigation block. You can also type `/navigation` and hit enter in a new paragraph block to add one quickly.

[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

The Navigation block has a dedicated list view tab in the settings panel where you can configure and customize the navigation.

## Block Configuration

When you add a Navigation block for the first time and don’t have any existing menu, it will start with a Page List block.

To start editing the menu, open the **Settings** panel, and select **Page List** from the list view. Click **Edit**, and the page list items will transform into Page Link blocks.

![The navigation block with the "Page List" visible and the "Edit" button highlighted.](https://wordpress.org/documentation/files/2023/03/navigation-block-page-list.png)### Creating a new menu

You can create a new menu from scratch via the Navigation block’s list view in the settings panel. Click the **Menu** options button and select **Create a new menu**.

The next step is to add individual blocks to your navigation. You can do so from the editor canvas or the list view in the settings panel.

Adding menu items using the sidebarAdding menu items using the canvas editor### Selecting an existing menu

To use another menu for a navigation block, you can select different menus from the list view in the settings panel. Click the **Menu** options button and select the available menus from the drop-down.

The Navigation block now shows the **menu name** next to its label in the **List View** (e.g., `Navigation (Header Menu)`), making it easier to identify which menu is used.

![](https://wordpress.org/documentation/files/2022/01/Menu-name-in-List-View.png)**Benefits**

- Quickly distinguish multiple Navigation blocks.
- Menu names update automatically if renamed.
- Improves editing flow in the Site Editor.

**How to Use**

- Add a Navigation block in the editor.
- Assign or create a menu.
- Open **List View** — you’ll see the menu name beside the block label.
- Renaming the menu updates the label automatically.

**Before:**

![List View without the menu name for navigation block.](https://wordpress.org/documentation/files/2022/01/menu-name-before.png)

**After:**

![List View showing the menu name for navigation block.](https://wordpress.org/documentation/files/2022/01/menu-name-after.png)

### Deleting and managing menus

If you want to delete the selected menu, go to the **Settings** tab on the block settings panel and open the **Advanced** section.

Click the **Delete menu** button, and a prompt will appear to confirm your action.

Once you’ve clicked **Confirm**, the menu will be deleted, and the navigation block will be replaced with a placeholder. You can then start creating a new menu or selecting an existing one from the settings panel.

## Block customization

You can customize the Navigation block content from the block settings list view and the editor canvas.

### Adding menu items

**Create and publish a new page to add to the menu**

When adding an item to the navigation block using either method below, there is an option to publish the page immediately. Doing so will publish an empty page that you can then edit later that will appear in the menu. If you choose not to publish the page when you’re creating a new one, this page will not appear in the navigation menu until it’s published as only published items appear in the menu.

**Using the block settings view**

To add a menu item from the block settings view, click the **Add block** icon (**+**) and you’ll see the option to select recently created pages, the ability to create and publish a page, and the option to add additional blocks. You can use the search to find and add any pages you’d like. If you select “Add blocks” and add a block like Page Link or Custom Link, a pop-up will appear where you can search or enter the URL for the menu item, toggle the **Open in new tab** option, and transform the block to another type.

You can also use the “Add Block” option to add a range of blocks from buttons to site logo to the Navigation block.

**Using the editor canvas**

To add a menu item from the editor canvas, click the **Add block** icon (**+**) inside the Navigation block. It will insert a new Custom Link block, and a pop-up will appear where you can search or enter the URL for the menu item, toggle the **Open in new tab** option, and transform the block to another type.

### Adding submenu items

**Using the block settings view**

To add a submenu for a menu item, click the **Options** button on the menu and select **Add submenu link**. It will add a Custom Link block as a submenu, and a pop-up will appear where you can search or enter the URL for the menu item, toggle the **Open in new tab** option, and transform the block to Page List.

![Adding a submenu item using the navigation block settings in the sidebar](https://wordpress.org/documentation/files/2023/03/navigation-block-adding-submenu-items.gif)**Using the editor canvas**

To add a submenu from the editor canvas, select the page link where you want to add the submenu and click **Add submenu** button on the toolbar.

It will add a Custom Link block as a submenu, and a pop-up will appear where you can search or enter the URL for the menu item, toggle the **Open in new tab** option, and transform the block to Page List.

![Open link in new tab](https://wordpress.org/documentation/files/2023/03/navigation-block-open-new-tab-edited.png)

You can add more submenu items by clicking the **Add block** button on the submenu drop-down.

![Add submenu item to an existing submenu.](https://wordpress.org/documentation/files/2023/03/navigation-block-open-new-submenu-1024x705.png)

### Rearranging menu items

**Using the block settings view**

The list view in the Navigation block settings panel lets you rearrange the menu items by dragging and dropping each of them. To rearrange the order of the menu items, simply drag and drop them to the new position.

To rearrange a menu item to create a new submenu, drag the menu item slightly right before dropping it. You will notice the blue line will shift towards the right. To move a menu item into an existing submenu, drag the menu item into the submenu list.

**Using the editor canvas**

To rearrange the menu items in the editor canvas, you can use the block moving tools in the menu item’s block toolbar.

![Moving a menu item in the canvas](https://wordpress.org/documentation/files/2023/03/navigation-move-items-canvas-1.gif)

### Removing menu items

**Using the block settings view**

To remove a menu or submenu item via the list view, click the **Options** button on the item and select **Remove \[menu item name\]**.

![Navigation menu item sidebar settings with selected option for removing the custom link.](https://wordpress.org/documentation/files/2023/03/navigation-block-remove-item.png)Navigation menu item sidebar settings with selected option for removing the custom link.

**Using the editor canvas**

To remove a menu or submenu item from the editor canvas, select the menu item block you want to remove. Open the **Options** menu from the block toolbar and select **Remove \[menu item name\]**.

![cccccccc](https://wordpress.org/documentation/files/2023/03/navigation-block-remove-item-sidebar-1024x820.png)Navigation menu item toolbar with selected option for removing the custom link.

### Editing link settings

**Using the block settings view**

To edit the link settings, click on the menu item in the list view, and it will open the settings panel for the selected link block. Here are the settings available:

- Label
- URL
- Description
- Link title
- Link rel

![Links settings](https://wordpress.org/documentation/files/2023/03/navigation-menu-link-settings-1024x817.png)You can also add a custom CSS class and customize the link typography and dimensions from the settings panel.

![Adding a custom CSS class](https://wordpress.org/documentation/files/2023/03/Screen-Shot-on-2023-03-28-at-154625.png)

**Using the editor canvas**

To edit the link from the editor canvas, select the menu item block you want to edit and click the **Link** button on the block toolbar. It will open a pop-up where you can edit or remove the link and toggle the **Open in new tab** option.If you click the **Edit** button for the link, you can change the menu item text and URL.

## Block toolbar

Every block has unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor.

The *Navigation block* has the following options:

- Transform
- Block moving tools
- Items justification
- Options

### Transform

When you click the **Transform** button, you can convert the *Navigation block* into *Columns* and *Group* blocks.

![Options to convert the navigation menu into a different block](https://wordpress.org/documentation/files/2023/03/navigation-block-transform.png)

### Block moving tools

To drag and drop the block to a new location on the page template, click and hold the **Drag** button, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block. The **Move up** and**Move down** buttons can be used to move the block up and down on the page. If the Navigation block is in a Row block, the buttons will change to left and right.

### Change items justification

Click the **Change items justification** button in the block toolbar to display the justification drop-down. You can justify the block text to the left, make it center-justified, align it to the right or leave a space between items.

![Navigation block toolbar with selected Justification option.](https://wordpress.org/documentation/files/2023/03/navigation-block-justification.png)Navigation block toolbar with selected Justification option.Alignment options can also be changed from the sidebar settings.

### Navigation item toolbar

Navigation Link and Submenu blocks now support all non-interactive RichText formats. This change removes the previous hardcoded allowlist, enabling more formatting flexibility and supporting custom-registered formats.

**Usage**

Select text inside a Navigation Link or Submenu and apply any of the formats above using the block toolbar or registered format plugins.

![Navigation item toolbar with dropdown of all non-interactive RichText formats.](https://wordpress.org/documentation/files/2022/01/navigation-formats.png)Navigation item toolbar with dropdown of all non-interactive RichText formats.

### Options

The **Options** button on a block toolbar gives you more features to customize the block.

[Read about these and other settings.](https://wordpress.org/support/article/more-options/) When you enable the block lock for the *Navigation block*, you will find the **Restrict editing** option, which will prevent menu items from getting edited.

## Block Settings

Every block has a specific settings panel to customize the block. To open it, click the **Settings** button next to the **Publish** button.

### Display

Currently, this section consists of one setting that allows you to control what is shown for the *Navigation block* across different screen sizes, allowing for a responsive menu option:

- **Off:** This turns off displaying a menu icon when on smaller screen sizes.
- **Mobile:** This enables a menu icon to be displayed when viewing your site on smaller screens that one can click on to see the entire menu.
- **Always:** This enables the menu icon to be displayed regardless of screen size.

By default, this option is set to **Mobile**, which will automatically show a menu icon on smaller screen sizes. When you click on the menu icon, it will open up an overlay that shows your entire menu.

![Display options on the Navigation block](https://wordpress.org/documentation/files/2023/03/navigation-block-mobile.png)

There are two additional settings specifically for submenus:

- **Open on click:** By default, submenus will open on hover. You can activate this option if you prefer them to open by clicking on them.
- **Show arrow:** By default, menu items that have submenus beneath them will display an arrow to indicate this. You can de-activate this option to hide those arrows.

### Layout

Layout settings allow you to change the justification and orientation of child blocks nested inside their parent blocks, with layout controls found on the parent blocks.

[This article provides details about layout settings.](https://wordpress.org/documentation/article/layout-settings-overview/)

### Color

These color settings allow you to customize the appearance of your Navigation block. Pick a color from the suggestions, or add a custom color using the color picker or by adding a color code.

[See this guide for more information about changing colors.](https://wordpress.org/documentation/article/colors-settings-overview/)

The Navigation block’s color picker now includes a **clear button**, allowing users to remove applied background and text colors with a single click. This improves design flexibility and aligns the behavior with the Sub Menu color controls.

### Typography

Typography settings allow you to change a block’s font size, appearance, line height, letter casing, and spacing.

[](https://wordpress.org/documentation/article/colors-settings-overview/)[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

### Dimensions

The Navigation block currently supports Block Spacing, which allows you to add custom spacing between each block. This makes it easy to set a uniform appearance across the entire block.

[](https://wordpress.org/documentation/article/colors-settings-overview/)[](https://wordpress.org/documentation/article/typography-settings-overview/)[Learn more about dimension controls.](https://wordpress.org/documentation/article/dimension-controls-overview/)

### Advanced

The Navigation block provides the following Advanced settings options: HTML anchor, Additional CSS Class(es), Additional CSS, Menu name, Delete menu, Manage menus, and Styles.

The following settings affect the selected menu used by the Navigation block:

- **Menu name** — Rename the selected menu.
- **Delete menu** — Delete the selected menu. This does not delete the pages, posts, or other content linked from it.
- **Manage menus** — View, create, and update menus used on your site.

![](https://wordpress.org/documentation/files/2022/01/nav-block-advanced-settings.png)[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)
