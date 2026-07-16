---
type: document
title: Template Editor
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/template-editor/"
tags:
timestamp: "2026-06-16T19:28:36+00:00"
wordpress:
  id: 2230
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:36"
  date_gmt: "2026-06-16 19:28:36"
  modified: "2026-06-16 19:28:36"
  modified_gmt: "2026-06-16 19:28:36"
  slug: template-editor
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/template-editor/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

The Template Editor allows you to edit and create templates, using [blocks](https://wordpress.org/documentation/article/blocks/). These templates control the layout of the posts, pages, or page types on your site.

The Template Editor is **only** available if your site is using a [block theme](https://wordpress.org/documentation/article/block-themes/) or a classic theme that has enabled the Template Editor on the backend.

## About Templates

WordPress uses templates to create the layout and structure for posts, pages, or specific page types on your site page. There are a few base templates that are generated when you select a theme. For example:

- The **Home** template is used to display the site’s home page if your site is set up to display the [latest posts ](https://wordpress.org/documentation/article/settings-reading-screen/#reading-settings)on the home page.
- The **Index** template is used to display the index page of all the blog posts.
- The **Page** template is used to display the site’s pages if no specific templates are assigned to the page.
- Many block themes offer other built-in templates like the **Single Post** template to customize the layout of single blog posts, the **404** template to customize the layout of the 404 error page, the **Search** template to customize the layout of the search results page, and the **Archive** template for categories/archives page, etc.

In addition, your [block theme](https://wordpress.org/documentation/article/block-themes/) may come bundled with custom templates.

In the Template Editor, you can find all the templates on your site, including any custom templates you created and the ones that came bundled with your theme. You can edit these templates and create custom layouts using [blocks](https://wordpress.org/documentation/article/blocks/).

When you make changes to a template, the editor updates the blocks on all pages/posts that use the template. These changes take precedence over your theme’s bundled template files.

## What you need, to use the Template Editor

To work with the Template Editor, you need to use a [block theme](https://wordpress.org/documentation/article/block-themes/) on your site. A block theme is a theme that uses [blocks](https://wordpress.org/documentation/article/blocks/) for all parts of a site, including navigation menus, header, content, and site footer.

All [blocks](https://wordpress.org/documentation/article/blocks/) that are available in the [WordPress Block editor](https://wordpress.org/documentation/article/wordpress-editor/) can be used in the Template Editor. To find block themes, from the WordPress dashboard, go to **Appearance** &gt; **Themes** and click **Add New**. In the **Add Themes** page, select **Block Themes** to find the growing list of [Block themes](https://wordpress.org/documentation/article/block-themes/) in the [WordPress theme directory](https://wordpress.org/themes/tags/full-site-editing/).

![How to find a block theme](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-17-at-9.36.15-AM-2-1024x493.png)How to find a block themeOnce you install and activate a Block theme on your site, go to **Appearance** &gt; **Editor** to open the Site Editor.

## Two ways to access the Template Editor

There are two different ways you can access the Template Editor depending on what type of theme you are using:

- If you are using a [block theme](https://wordpress.org/documentation/article/block-themes/), you can access the Template Editor when editing posts or pages via the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/) and also via the [Site Editor](https://wordpress.org/documentation/article/site-editor/).
- If you are using a classic theme that has enabled the Template Editor on the backend, you can access the Template Editor only when editing posts or pages via the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/).

## How to use the Template Editor via the WordPress Block Editor

To use the Template Editor via the WordPress Block Editor, make sure your site is using a [block theme](https://wordpress.org/documentation/article/block-themes/) or a classic theme that has enabled the Template Editor on the backend.

### To edit a template

1. Click **Posts** &gt; **Add New** to add a new post or **Pages** &gt; **Add New** to add a new page.
2. This opens the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/).
3. Navigate to the [Post/Page Settings](https://wordpress.org/documentation/article/settings-sidebar/) sidebar tab.
4. Under the **Summary** section, click the name of the template. A popup will appear. Click **Edit template**.

![How to edit template](https://wordpress.org/support/files/2022/10/Screen-Shot-2022-10-18-at-11.51.20-AM.png)How to edit templateThe **Edit** option is **only** available if you are using a [block theme](https://wordpress.org/documentation/article/block-themes/) that lets you edit custom templates.

1. This opens the Template Editor and takes you to the template editing mode where you can make changes to the selected template. To go back to the WordPress Block Editor and continue making content changes, click the **Back** link in the top panel of the editor.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-1.51.55-pm-1024x580.png)Back link in the Template Editor1. When you’re done making changes, select **Publish**. This will prompt you to save all the changes you made including the template and the post or page.
2. Click **Save** to confirm the changes.

Editing an existing page templateWhen you make changes to a template, the editor updates the blocks on all pages/posts that use the template

### To create a new custom template

1. Click **Posts** &gt; **Add New** to add a new post or **Pages** &gt; **Add New** to add a new page.
2. This opens the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/).
3. Navigate to the [Post/Page Settings](https://wordpress.org/documentation/article/settings-sidebar/) sidebar tab.
4. Under the **Summary** section, click the name of the template. A popup will appear. Click the add template icon in the top right corner.

![How to add a new template](https://wordpress.org/support/files/2022/10/Screen-Shot-2022-10-18-at-12.25.40-PM-624x1024.png)How to add a new templateThis option is **only** available if you are using a [block theme](https://wordpress.org/documentation/article/block-themes/) that lets you create custom templates.

1. This opens a dialog box where you can give a name for the custom template you are about to create. Make sure to give it a descriptive name that describes the purpose of the template e.g. “Full Width”.
2. Click **Create** to open the Template Editor and go to the template editing mode where you can build the custom template using [blocks](https://wordpress.org/documentation/article/blocks/). To go back to the WordPress Block Editor and continue making content changes, click the **Back** link at the top left corner.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-1.51.55-pm-1024x580.png)Back link in the Template Editor1. When you’re done making changes, select **Publish**. This will prompt you to save all the changes you made including the template and the post or page.
2. Click **Save** to confirm the changes.

Creating a new custom page template## How to use the Template Editor via the Site Editor

### To navigate to templates

- Go to **Appearance** &gt; **Editor** to open the[ Site Editor](https://wordpress.org/documentation/article/site-editor/). You will be taken to an interface showing a preview of your site and a dark gray sidebar where you can navigate between your templates, template parts, and other aspects of your site.
- To view the list of templates available for your site and switch between templates:
    - If you are already in a template, click on the WordPress icon (or Site icon if you have set one) to open the Site Editor left navigation.If you are just entering the Site Editor, skip this step.
    - Click on **Templates** to view the list of templates.
    - Click on any template name from the list to preview that template and see a description of what the template does.

### **To edit a template**

- From the Site Editor (**Appearance** &gt; **Editor**), click on **Templates** to view the list of templates on your site, including any you have created and any that come with your theme. If you are already editing a template, click on the WordPress icon (or Site icon if you have set one) to open the Site Editor left navigation.
- Click on any of the templates in the list to to preview that template and see a description of what the template does. From there, you can either click the pencil icon or on the template itself to edit it directly and customize the layout of the selected template using[ blocks](https://wordpress.org/documentation/article/blocks/).
- When you are done with the template customization, click **Save**.

When you make changes to a template, the editor updates the blocks on all pages/posts that use the template.

- To go back to the overall view of the **Site Editor**, click on the WordPress icon (or Site icon if you have set one) to open the Site Editor left navigation.

### **To add a new template**

The Template Editor displays the templates that you can add to your site.

- From the **Appearance** &gt; **Editor**, click on **Templates** to view the list of templates on your site, including any you have created and any that come with your theme. If you are already editing a template, click on the WordPress icon (or Site icon if you have set one) to open the Site Editor left navigation.
- Click the **+** button in the top right corner of the sidebar to the optional types of new templates you can add to your site.

![](https://wordpress.org/documentation/files/2023/08/add_template-1024x578.png)Add new templates from the dark gray sidebar in the Site Editor- **Front Page** – to display the home page of your site if your site is set up to display a[ regular page](https://wordpress.org/documentation/article/settings-reading-screen/#reading-settings) for the home page.
- **Page** – It allows the creation of templates that can be applied to a specific page on the site or as the default page template (if not already defined by the theme).
- **Author** – It allows the creation of templates that can be applied to posts by a specific author on the site or as the default template for all authors (if not already defined by the theme).
- **Category** – It allows the creation of templates that can be applied to posts by a specific category on the site or as the default template for all categories (if not already defined by the theme).
- **Date** – It allows the creation of templates that can be applied to posts by date (if not already defined by the theme).
- **Tag** – It allows the creation of templates that can be applied to posts by tag (if not already defined by the theme).
- **Taxonomy** – It allows the creation of templates that can be applied to posts by a specific taxonomy term (if not already defined by the theme).
- **Single item: Post** – It allows the creation of post-specific templates.
- **Custom Template** – A template that can be applied to any post or page

You can also go to Templates &gt; Manage all templates and select the Add New button to add the same templates listed above.

If you already added a template from the Template Editor (for eg: Front Page), it will not display that template name (in this case, Front Page) in the drop-down menu, when you try to add a new template.

![](https://wordpress.org/documentation/files/2023/08/add_template_2-1024x580.png)Add new templates from the dark gray sidebar in the Site EditorAdd new templates from the ‘All Templates’ pageOnce you select the template to add, you will be shown an option to start the template with content from one of the existing patterns in the site. This means you can start with content already in the template, or start from scratch. You can design the layout further by adding or removing blocks from the template.

Start with a Pattern when adding a new template.### **To add a new Page template**

To create a custom page template, select **Page** from the drop-down menu after you choose to add a new template.

A new dialog will appear listing all the pages on your site. If your site has more than **10** Pages, the dialog box will also show a Search box and you can search by the Page name to find the one you are looking for.

You can select a specific page to apply the template. Once you select the page, you are taken to the Template Editor where you can design the layout of the template.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.35.51-pm-1024x579.png)Add a Page template just for a specific page### **To add a single template for all post types and specific post types**

Selecting Author, Category, and Single item: Post allows you to create a single template for all the post types or a specific template for a certain post type. This is helpful, for example, if you want to show a grid of posts for a specific “photography” category but not change the default list style for others.

To create a custom category template, select **Category** from the drop-down menu, after you choose to add a new template. A new dialog will appear with two choices:

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.37.16-pm-1024x583.png)Creating templates for Category**All Categories** – for creating the default category template. This is used as a fallback when a more specific category template does not exist.

**Category** – for creating a custom template for an individual category. Selecting this option will open a new dialog listing all the categories on your site. . If your site has more than **10** Categories, the dialog box will also show a Search box and you can search by the Category name to find the one you are looking for.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.40.36-pm-1024x580.png)Creating template for specific categoryOnce you make your choice between All Categories or Categories you will be taken to the Template Editor, where you can design the layout of the template.

To create a custom author template, select **Author** from the drop-down menu, after you click on the **Add New** button in the Template Editor. This will open up a dialog where you can choose between creating one template for all the authors (**All Authors**) or a specific template for a certain author(**Author**). If you choose a specific template for an author, you will be prompted to choose from the list of authors on your site.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.42.15-pm-1024x577.png)Creating templates for author![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.42.27-pm-1024x576.png)Choosing the specific author for creating the templateTo create a post-specific template, select **Single item:Post** from the drop-down menu after you choose to add a new template. This will open up a dialog where you can choose between creating one template for all the Posts (**All Posts**) or a specific template for a certain Post (**Post**). If you choose a specific template for a Post, you will be prompted to choose from the list of Posts on your site.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.44.32-pm-1024x577.png)Creating template for Posts![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-2.44.45-pm-1024x581.png)Creating template for a specific post### **To add an archive and single template for custom post types**

Archive and Single item: If your site has Custom Post Types, like testimonials, movies, books, or recipes, you will also be able to create a separate template for their archive pages or single posts.

For eg: to create a custom archive template for a specific custom post type eg: Testimonial, select **Archive: Testimonial** from the drop-down menu, after you choose to add a new template. This will open the Template Editor pre-populated with the content of the Custom Post Type. This means you would be presented with content already in the template rather than starting from scratch. You can design the layout further by adding or removing blocks from the template.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-4.19.51-pm-1024x580.png)Adding a template for a custom post typeTo create a single template for a single item in the Custom Post Type eg: Testimonials, select **Single item: Testimonial** from the drop-down menu, after you choose to add a new template. A new dialog will appear with two choices:

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-4.17.53-pm-1-1024x579.png)Adding a template for all posts of a custom post type**All Testimonials**: for creating the default single template for all single items in the Custom Post Type. This is used as a fallback when a more specific single template for that custom post type does not exist.

**Testimonial**: for creating a single template for an individual item in the Custom Post Type (in this example **Testimonial**). Selecting this option will open a new dialog listing all the items on your site for that Custom Post Type (in this example **Testimonial**). Once you make your choice between All or Single Item for the Custom Post Type you will be taken to the Template Editor, where you can design the layout of the template.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-4.18.06-pm-1024x580.png)Adding template for a specific custom post### **To create a new custom template**

A custom template can be assigned to any post, page, or custom post type.

When you add a new template from the list of choices provided in the Template Editor, they are automatically assigned to their respective page, post, or post type. For eg: The Author template gets automatically assigned to posts based on authors. When you create a new custom template, it is not assigned to anything specific until you assign a template to the post or page.

To create a custom template, select **Custom Template** from the drop-down menu, after you choose to add a new template. In the dialog that appears, give a name for the new custom template and click **Create**. Make sure the name describes the template eg: Post with sidebar.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-4.23.58-pm-1024x582.png)Adding a custom templateIn the dialog that appears, give a name for the new custom template and click **Create**. Make sure the name describes the template eg: Post with sidebar.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-4.26.57-pm-1024x580.png)Naming a custom templateYou will be taken to the Template Editor pre-populated with content and you can design the layout of the template further by adding or removing blocks.

## How to assign a custom template to a post or page

1. From the WordPress Dashboard, open the post or page that you want to assign the template.
2. This opens the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/).
3. Navigate to the [Post/Page Settings](https://wordpress.org/documentation/article/settings-sidebar/) sidebar tab.
4. Under the **Summary** section, click the name of the template. A popup will appear.
5. In the popup, open the drop-down list to find the list of all custom templates. Pick the template you want to assign to the post or page.

![How to assign a template to a post or page](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-20-at-3.49.22-PM.png)Changing a page’s template affects that page only (not your entire site.)

## How to rename custom templates

You can only rename a custom template that you created. This means the default templates in WordPress and custom templates that came bundled with your theme cannot be renamed.

There are two ways you can rename custom templates:

### From the detail view of the template

- Click on **Templates** to view the list of templates on your site.
- Click on the custom template you created, that you want to rename. This will display a preview of the template along with its details.
- In the detail view of the template click the three-dot icon next to the title and select the ‘Rename’ option in the menu that appears.
- This will open a dialog box where you can type in a new name for the custom template you selected. Make sure the name describes the template eg: Post with sidebar.
- Click **Save** to save the custom template with the new name.

Rename a template from the template detail view### From the templates list in the Template Editor

- Click on **Templates** to view the list of templates on your site.
- Click the three-dot menu icon next to any of the custom templates you created. From the drop-down menu and select **Rename**.
- This will open a dialog box where you can type in a new name for the custom template you selected. Make sure the name describes the template eg: Post with sidebar.
- Click **Save** to save the custom template with the new name.

Renaming a custom template from the template list## Clear customizations to templates in your block theme

When changes are made to templates that came bundled with your block theme, you will see the option to clear customizations.

You can see whether a template has been customized in 2 locations.

1. In the detail view you will see an additional ‘customized’ label on templates with customizations.
2. When viewing the details of the template you will see a note indicating when the template was last updated, at the bottom of the details column.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-5.26.28-pm-1024x75.png)Customized label shows in the ‘All Templates’ view![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-5.26.14-pm-1024x581.png)‘Last Modified’ indicates this template has customizationsThis feature is **only** available for the templates that you have already customized. If you don’t find this option, it means your template is already in its default state.

There are three ways you can clear customizations:

### From the actions in the template detail view

- Click on **Templates** to view the list of templates on your site.
- Click on the custom template you created, that you want to rename. This will display a preview of the template along with its details.
- Click the the three-dot menu icon near the template name which opens a drop-down menu. Click Clear customizations in the drop-down menu. Note that this option only appears if customizations have been done and saved. You will see a message at the bottom left corner of the window **Template reverted**.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-5.35.49-pm-1024x579.png)Clear customizations on a template detail page![Template reverted message](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-20-at-7.46.28-PM.png)Template reverted message### From the templates list in the Template Editor

- Click on **Templates** to view the list of templates on your site.
- Scroll down and click on **Manage all templates.** This will take you to a list of your templates.
- Click the three-dot menu icon to open a drop-down menu and select **Clear customizations**. This will reset the template to the default state and you will lose the changes you made to that template.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-5.37.57-pm-1024x578.png)Clear customizations for Template### From the Settings sidebar within a template

- Click on **Templates** to view the list of templates on your site.
- Click on the template you want to clear customizations for. This will open the template in the Template Editor.
- Click the three-dot menu icon in the Template settings sidebar. This will open a drop-down menu. Select **Clear customizations**. This will reset the template to the default state and you will lose the changes you made to that template. You will see a message at the bottom left corner of the window **Template reverted**.

![](https://wordpress.org/documentation/files/2023/08/Screenshot-2023-08-08-at-5.40.13-pm-1024x581.png)Clear customization from the Template settings sidebar## How to delete a template

You can only delete the custom templates that you created, in either of two different ways:

### From the actions in the template detail view

- Click on **Templates** to view the list of templates on your site.
- Click on the custom template you created, that you want to delete. This will display a preview of the template along with its details.
- Click the the three-dot menu icon near the template name which opens a drop-down menu, and select the ‘Delete’ option.
- Confirm you want to delete the template in the dialog that displays, and you will be notified once it is complete.

Delete a template from the detail view### From the templates list in the Template Editor

- Click on **Templates** to view the list of templates on your site.
- Scroll down and click on **Manage all templates.** This will take you to a list of your templates.
- Click the three-dot menu icon of a custom template you created, that you want to delete and click the ‘Delete’ option.
- Confirm you want to delete the template in the dialog that displays, and you will be notified once it is complete.

Delete a template from the list view## Resource Links

- [Deeper customization with template options](https://make.wordpress.org/core/2022/07/21/core-editor-improvement-deeper-customization-with-more-template-options/)
- **Workshops**
    - [Creating a landing page with a block theme](https://wordpress.tv/2022/08/15/creating-a-landing-page-with-a-block-theme-2/)
    - [Personalizing your 404 template](https://wordpress.tv/2022/09/28/personalizing-your-404-template/)
- **Courses**
    - [Simple Site Design and Site Editing](https://learn.wordpress.org/course/simple-site-design-with-full-site-editing/)
    - [Personalized Site Design and Theme Blocks](https://learn.wordpress.org/course/part-2-personalized-site-design-with-full-site-editing-and-theme-blocks/)
    - [Advanced Site Design using the Site Editor](https://learn.wordpress.org/course/part-3-advanced-site-design-with-full-site-editing-site-editor-templates-and-template-parts/)

Changelog:

- Updated on July 8th, 2023
    - Updated content, videos and Screenshots for 6.3.
- Updated on March 27th, 2023
    - Updated content, videos, and screenshots for 6.2.
    - Removed references to “Beta” for the Site Editor.
- Updated on October 20th, 2022
    - Updated content, videos, and screenshots for 6.1
    - Updated resources section to remove external links and add links to Learn workshops and courses
- Updated on May 22, 2022
    - Adding 6.0 features. updating screenshots and videos and reworking content.
- Edited to add in content around the Site Editor on January 5, 2022
- Edited to add in an additional Resource item on July 30, 2021
- Created on July 11, 2021
