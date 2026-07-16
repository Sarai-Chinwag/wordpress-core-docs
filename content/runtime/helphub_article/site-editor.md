---
type: document
title: Site Editor
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor/"
tags:
timestamp: "2026-06-16T19:28:34+00:00"
wordpress:
  id: 2223
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:34"
  date_gmt: "2026-06-16 19:28:34"
  modified: "2026-06-16 19:28:34"
  modified_gmt: "2026-06-16 19:28:34"
  slug: site-editor
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/site-editor/"
  comment_count: 0
  terms:
    category:
      - appearance
      - customization
---

The Site editor allows you to design the entire site including the header, footer, and everything in between, with [blocks](https://wordpress.org/documentation/article/blocks/). It gives you greater control over how your site looks.

The Site Editor is **only** available when you install and activate a [Block theme](https://wordpress.org/documentation/article/block-themes/) on your site.

## How to access the Site editor

To work with the Site editor, you need to use a [block theme](https://wordpress.org/documentation/article/block-themes/) on your site. A block theme is a theme that uses [blocks](https://wordpress.org/documentation/article/blocks/) for all parts of a site, including navigation menus, header, content, and site footer.

All [blocks](https://wordpress.org/documentation/article/blocks/) that are available in the [WordPress Block editor](https://wordpress.org/documentation/article/wordpress-editor/) can be used in the Site editor. A set of blocks called [Theme blocks](https://wordpress.org/documentation/article/blocks/#theme-blocks) are specifically built for the Site editor.

To find block themes, from the WordPress dashboard, go to **Appearance** &gt; **Themes** and click **Add New**. In the **Add Themes** page, select **Block Themes** to find the growing list of [Block themes](https://wordpress.org/documentation/article/block-themes/) in the [WordPress theme directory](https://wordpress.org/themes/tags/full-site-editing/).

![Appearance > Themes showing block theme options](https://wordpress.org/documentation/files/2022/01/Appearance-Themes-showing-block-themes-1024x517.png)How to find a block themeOnce you install and activate a Block theme on your site, go to **Appearance** &gt; **Editor** to open the Site Editor.

![Appearance section of the admin interface showing the Themes and Editor entry points after activating a block theme. ](https://wordpress.org/documentation/files/2022/01/Screen-Shot-2023-03-27-at-6.23.05-PM.png)Appearance menu after activating a block theme## Things to do in the Site Editor

Once you enter the Site Editor, you will see five menu items.

![Main menu screen in the Site Editor.](https://wordpress.org/documentation/files/2023/08/Site-Editor-sections-6-3.png)- [Navigation](https://wordpress.org/documentation/article/site-editor-navigation): Allows you to browse your menus and make basic changes.
- [Styles](https://wordpress.org/documentation/article/styles-overview/): Provides a direct access to edit your site’s style variations.
- [Pages](https://wordpress.org/documentation/article/site-editor-pages): You can now edit the content of your pages inside the Site Editor itself.
- [Templates](https://wordpress.org/documentation/article/template-editor/): Review the different default layouts for the different sections on your site, as well as custom pages (search results, 404, etc).
- [Patterns](https://wordpress.org/documentation/article/site-editor-patterns): Your Synced patterns and template parts can be managed here.

You will also see an icon of a magnifying glass. Click on it to access the [Command Palette.](https://wordpress.org/support/article/site-editor-command-palette)

Below is an overview of the different sections in the Site Editor.

## The Site Editor workspace

The Site editor loads the home page of your site (based on what you have set in the [Reading Settings](https://wordpress.org/documentation/article/settings-reading-screen/#reading-settings)) to start editing.

The top menu in the Site editor includes the following options:

![Site editor toolbar with numbers indicating various options to explore. ](https://wordpress.org/documentation/files/2023/08/Site-Editor-Toolbar.png)1. The site icon (or the W icon, if no site icon is set for the site): Return to the dashboard or switch to the other section of the Site Editor: [Navigation](https://wordpress.org/documentation/article/site-editor-navigation), [Styles](https://wordpress.org/documentation/article/styles-overview/), [Pages](https://wordpress.org/documentation/article/https://wordpress.org/documentation/article/site-editor-pages), [Templates](https://wordpress.org/documentation/article/template-editor/), or [Patterns](https://wordpress.org/documentation/article/site-editor-patterns). If you choose to return to the dashboard, it will prompt you to save the changes or leave the Site editor without saving the changes.

1. The **+** Block inserter button: Add a new [block](https://wordpress.org/documentation/article/blocks/), [block pattern](https://wordpress.org/documentation/article/block-pattern/), Media, or synced pattern (if the site has synched patterns) to the Site editor.

![Block Inserter Panel](https://wordpress.org/documentation/files/2023/08/6-3-inserter-662x1024.png)Block inserter panel1. Tools: Switch between editing a block and selecting a block. Choose the **Select** tool (or press the `Escape` key on your keyboard) to select individual blocks. Once a block is selected, press the `Enter` key on your keyboard to return to editing.

![Edit/select buttons in the WordPress block editor workspace](https://wordpress.org/documentation/files/2022/05/Screen-Shot-2022-05-12-at-2.52.04-PM.png)Edit/Select buttons1. Undo**:** Undo the most recent action taken.
2. Redo**:** Redo an action you reversed using the **Undo** button.
3. [List View](https://wordpress.org/documentation/article/list-view/): See a list of all of the blocks that are on the page and easily navigate between the blocks on your page. This is useful for seeing the page’s structure and editing, moving, and removing blocks.
4. [Command Palette](https://wordpress.org/support/article/site-editor-command-palette): Click here to access all your site’s content, templates, and patterns quickly, as well as invoking other actions (settings, new page, etc).

1. Save**:** Save the changes you made in the Site editor.
    - When you click the **Save** button, you will get a list of all the [synced patterns](https://wordpress.org/documentation/article/reusable-blocks/), [navigation menus](https://wordpress.org/documentation/article/site-editor-navigation), [templates](https://wordpress.org/documentation/article/template-editor/) and [template parts](https://wordpress.org/documentation/article/template-part-block/) where you have made changes.
    - You can choose to save all or just some of them.
    - Note that some changes (like changes to the Header and Footer templates) will apply to all pages of your site that use those templates, and not just the page you were working on.

1. Settings: Show or hide the Template and Block Settings sidebar menu.

1. [Styles](https://wordpress.org/documentation/article/styles-overview/)**:** Browse style variations available for the theme you have, set the typography, color palettes, and layout for the entire site, or customize the appearance of specific blocks for the whole site.
2. More Options**:** Click the three vertical dots icon to open additional settings and tools.

![Site editor with an arrow pointing to the three dot menu where extra settings can be found. ](https://wordpress.org/documentation/files/2023/08/Site-Editor-More-options-432x1024.png)**View top toolbar**: Display or hide the top toolbar in the editor. When you enable this option, block toolbars are pinned to the top of the WordPress block editor (right under the top toolbar) instead of appearing directly above the block.

![Top toolbar enabled](https://wordpress.org/documentation/files/2022/05/Screen-Shot-2022-05-12-at-9.58.33-PM-1024x219.png)Top toolbar enabled**Spotlight mode**: All blocks are greyed out except for the one you’re working on so that you can focus on a single block at a time.

![Spotlight mode](https://wordpress.org/documentation/files/2022/05/Screen-Shot-2022-05-12-at-10.01.48-PM-1-1024x722.png)Spotlight mode**Distraction Free**: When this options is activated, all non-essential parts of the UI will be hidden to provide a more immersive editing experience.

**Editor**: By default, you will be in the **Visual editor**. Switch to the **Code editor** to view the entire page in HTML code editor.

**Plugins**: Here, you can switch between **Settings** and **Styles** in the Site editor Sidebar.

**Tools**: Here, you can download your theme with the updated templates and styles (**Export**), learn [keyboard shortcuts](https://wordpress.org/documentation/article/block-editor-keyboard-shortcuts/), visit the Site Editor welcome guide, copy all blocks, or view additional support articles.

**Preferences**: Use the [Preferences](https://wordpress.org/documentation/article/preferences-overview/) menu to customize the editing experience and change how you interact with blocks.

## How to use the Site Editor

### To edit the site’s styles

You can use the Site Editor to customize the styles for the entire website and for the blocks. Styles settings are available regardless of what template or template part you are editing.

- Go to **Appearance** &gt; **Editor**.
- Click the Styles menu item or on the icon next to the block settings sidebar.

![](https://wordpress.org/documentation/files/2023/08/site-editor-styles-menu-689x1024.png)![](https://wordpress.org/documentation/files/2023/08/site-editor-styles-icon-693x1024.png)In the **Styles** section, you can browse the style variations available for the theme you have, change the color palettes and typography, and layout across the entire site and also change the appearance of blocks which are also applicable across the whole site.

To review your **style revisions or reset the changes** you made completely, click the three-dot menu icon in the right corner and select either option.

Learn more about Styles in this support article: [Styles overview](https://wordpress.org/documentation/article/styles-overview/).

### To customize the site’s layout

You can use the Site Editor to build the structure and layout of your entire site, using blocks. Eg: areas like headers, footers, and the structural appearance of your site’s posts and pages.

All [blocks](https://wordpress.org/documentation/article/blocks/) that are available in the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/) can be used in the Site Editor. A set of blocks called [Theme blocks](https://wordpress.org/documentation/article/blocks/#theme-blocks) are specifically built for the Site Editor.

Examples: the [Query Loop Block](https://wordpress.org/documentation/article/query-loop-block/) allows you to customize the look and feel of your post layout, the [Navigation Block](https://wordpress.org/documentation/article/navigation-block/) lets you customize the site’s navigation menu, the [Site Title Block](https://wordpress.org/documentation/article/site-title-block/) helps to customize the Site Title and more.

Check out the full list of [Theme blocks](https://wordpress.org/documentation/article/blocks/#theme-blocks).

#### Example – How to Customize Twenty Twenty-Three using the Site Editor

[Twenty Twenty-Three](https://wordpress.org/documentation/article/twenty-twenty-three/) supports the Site Editor and can be customized using it. As an example, let’s remove the gap at the top of the home page in Twenty Twenty-Three. To do this, remove the padding at the bottom of the header template part and the padding at the top of the content area.

![Before](https://wordpress.org/documentation/files/2023/08/before-editing-2023-300x190.jpg)Before![After](https://wordpress.org/documentation/files/2023/08/after-editing-2023-300x191.jpg)AfterFirst, remove bottom padding of Header Template Parts.

1. From Administration Screen, Select **Appearance** &gt; **Editor**
2. Select **Patterns** &gt; **Template Parts** &gt; **Header** &gt; **Header**, and click Pencil icon to edit it.
3. Select the **Group** &gt; **Row** block. Use the bottom block navigation.
4. From Block Settings, Click Styles.

![Styles of Header Template Parts](https://wordpress.org/documentation/files/2023/08/header-styles-2023-1024x653.jpg)Styles of Header Template Parts1. Scroll down to the Padding &gt; Bottom. Current value is 2.
2. Set it to 0.
3. Save the template parts.

Next, remove top padding of content area.

1. Back to the Site Editor.
2. Select Templates &gt; Home, and click Pencil icon to edit it.
3. Select the top Group block. Use the bottom block navigation.
4. From Block Settings, Click Styles.

![Home Template Styles](https://wordpress.org/documentation/files/2023/08/home-templates-styles-2023-1024x734.jpg)Home Template Styles1. Scroll down to the Padding &gt; Top. Current value is 3.
2. Set it to 0.
3. Save the template.

### To browse the templates and template parts

From the Site editor, you can easily browse the [templates](https://wordpress.org/documentation/article/template-editor/) and [templates parts](https://wordpress.org/documentation/article/template-part-block/) available for your site.

- Go to **Appearance** &gt; **Editor** to open the Site editor. This will bring you to a view where you can choose to browse your templates or template parts.
- Click on **Templates** to preview the list of templates available for your site.
- Click on **Patterns** to preview the list of template parts.

### To manage the site’s templates

WordPress uses [templates](https://wordpress.org/documentation/article/template-editor/) to create the layout and structure for specific page types on your site. The Site Editor displays the template choices that you can add to your site and lets you create custom templates using the [Template Editor](https://wordpress.org/documentation/article/template-editor/).

From the **Appearance** &gt; **Editor**, you will be shown a view that includes a sidebar with your list of Templates and Patterns that includes the list of template parts.

Learn more about Templates in this support article: [Template Editor](https://wordpress.org/documentation/article/template-editor/).

### To manage the template parts

A Template part is a block for managing the repeating global areas of the site such as a Header, Footer, Sidebar, etc. They are primarily meant to define the site structure and can be reused. You can also create custom Template Parts that can be reused through the templates.

From the **Appearance** &gt; **Editor**, click the **Patterns** option. From All templates parts, you can access to them.

Learn more about Template Parts in this support article: [Template Part](https://wordpress.org/documentation/article/template-part-block/).

### To manage pages

Since version 6.3, it is possible to manage, edit and create pages via the Site Editor, under the “Pages” section.

Learn more about managing pages via the Site Editor in this support article: [Site Editor Pages](https://wordpress.org/documentation/article/site-editor-pages)

## How to return to the Dashboard

To go back to your dashboard, click the WordPress icon (or Site icon if you have set one) to open the Site Editor left navigation. Select **&lt;** to take you back to your WordPress dashboard. You will be prompted to save the changes you have made in the Site Editor before leaving.

![How to exit the Site Editor by clicking on the WordPress or Site Icon on the top left part of the screen.](https://wordpress.org/documentation/files/2023/08/Screen-Shot-on-2023-08-05-at-073608-1024x728.png)## How to export templates and styles

You can export your theme with the changes you made in the Site Editor including the templates, template parts, and style settings, similar to the [Tools &gt; Export option](https://wordpress.org/documentation/article/tools-export-screen/).

- Open the Site Editor by going to **Appearance** &gt; **Editor**.
- Select the three vertical dots icon next to your **Styles** settings option.
- Under **Tools**, select **Export**. This will begin the export process and you will receive a downloaded zip file of your theme with the templates and template parts included.

![How to find the "Export" option under the three-dot "More Options" menu on the top right part of the screen.](https://wordpress.org/documentation/files/2023/08/Screen-Shot-on-2023-08-05-at-073719-1024x752.png)## Useful tools when using the Site Editor

The following tools are helpful when using the Site Editor.

### The Command Palette

The Command Palette offers you a quick way to navigate the **content** of your site and to invoke different **actions** such as creating new posts/pages, toggling preferences, and accessing your styles and custom CSS settings.

You can open the Command Palette in the Site View in the sidebar by clicking on the **search icon** and. In Edit View, the Command Palette is in the **top Title Bar**. You can also use the **keyboard shortcut** `Cmd+k` on Mac or `Ctrl+k` on Windows

Learn more about the Command Palette in this support article: [Site Editor Command Palette](https://wordpress.org/support/article/site-editor-command-palette).

### List View

List View helps you navigate complex block layouts and nested block structures. You can select exactly which block you need, and get a quick overview of the block layout on the page you are working on. You can easily select multiple blocks and edit, move or group them.

Learn more about List View in this support article: [List View](https://wordpress.org/documentation/article/list-view/).

### Block Patterns

Block Patterns are a collection of predefined blocks that you can insert into posts and pages. You can then customize them further. WordPress comes with a set of standard Block Patterns. You can also find Block Patterns bundled with the [block themes](https://wordpress.org/documentation/article/block-themes/).

Learn more about Block Patterns in this support article: [Block Pattern](https://wordpress.org/documentation/article/block-pattern/).

### Copy and paste styles

With WordPress 6.2, a new option was added to allow you to copy and paste block styles, making it easy to reuse designs you’ve created. You can find this from the three dot menu in any block and it’s meant to be used to copy and paste between the same type of block:

### Apply style changes globally

If you’re more comfortable with more advanced options when creating a design or customizing individual blocks, as of WordPress 6.2, you can take changes made to an individual block and apply it to **all blocks of the same type**. For example, you could apply a single design for an individual block to all blocks in your site with a new option under the **Advanced** section of block settings.

![How to apply the current's block style to all styles of that same type across your site by clicking on Block Settings > Advanced > Apply Globally](https://wordpress.org/documentation/files/2023/08/site-editor-apply-styles-globally-1024x593.png)### Resize the preview of the Site Editor

When you’re in the Site Editor, you might want to change the preview of the template or template part you’re viewing. You can do this by selecting the handles of the dark gray sidebar and moving it to your liking.

## Resource Links

- [Additional guide to using Site Editor](https://wordpress.org/documentation/article/additional-guide-to-using-the-site-editor)
- [Simple Site Design and Site Editing](https://learn.wordpress.org/course/simple-site-design-with-full-site-editing/)
- [Intro into the Site Editor and Template Editor](https://learn.wordpress.org/workshop/intro-to-the-site-editor-and-template-editor/)

## Changelog

- Updated 2024-09-14
    - Updated template and template parts management section with Grid View
- Updated 2023-08-13
    - Added example of Site Editor usage.
- Updated 2023-08-08
    - Replaced “Reusable Blocks” with “Patterns”
    - Updated wording &amp; screenshots to match the new interface.
    - Added a reference to the Command Palette &amp; Site Editor Pages.
- Updated 2023-03-27
    - Updated content and screenshots for 6.2
- Updated 2022-10-17
    - Updated content and screenshots/video for 6.1
- Updated 2022-05-17
    - Reworking the content &amp; updating videos/screenshots for 6.0
- Created 2022-01-05
