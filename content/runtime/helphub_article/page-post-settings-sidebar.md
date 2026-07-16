---
type: document
title: Page/Post Settings sidebar
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/page-post-settings-sidebar/"
tags:
timestamp: "2026-06-16T19:28:41+00:00"
wordpress:
  id: 2252
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:41"
  date_gmt: "2026-06-16 19:28:41"
  modified: "2026-06-16 19:28:41"
  modified_gmt: "2026-06-16 19:28:41"
  slug: page-post-settings-sidebar
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/page-post-settings-sidebar/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

The Settings Sidebar is used to customize the key aspects of the page or post that is being published. It’s an essential component of the [WordPress Block Editor](https://wordpress.org/documentation/article/wordpress-editor/#the-anatomy-of-a-block).

This sidebar was introduced in WordPress 5.6 and was called Document Settings. It has been renamed now to the Page/Post settings. Depending on whether you are working on a Post or Page, the tab in the sidebar is named **Post** or **Page**.

If you are working in a custom post type such as Article, this tab will be labeled with the name of the custom post type, which would be **Article** in this case. If you are in the Site Editor, the tab is named **Template**.

## How to open

![How to open Page/Post settings](https://wordpress.org/documentation/files/2023/10/Settings-Icon.png)In the upper-right corner of the WordPress Editor, select the gear icon. This toggles the sidebar. Within the sidebar, the left tab features the settings for the entire Page or Post you’re working on. The right tab shows the settings for the individual Block selected.

![Page Settings](https://wordpress.org/documentation/files/2020/11/image11.png)Page Settings![Post Settings](https://wordpress.org/documentation/files/2020/11/image9.png)Post Settings

## Settings Sidebar

The following sections are available in the settings sidebar for Pages and Posts. This may vary based on the themes and plugins you have on your site.

### Featured image

Featured Images (also sometimes called Post Thumbnails) are used in different ways depending on the theme. Many themes use this image to showcase the post on the home page or blog index page.

![Featured Image in Settings sidebar](https://wordpress.org/documentation/files/2020/11/chrome_ZNu0I0kE8Y.png)To set the **Featured image**, drag an image from your computer and drop it in the gray box.

You can also click the **Set featured image** box, which opens the Media Library where you can select the image or upload a new image. Once you have an image picked, you will see a blue check box around the selected image. Click **Set featured image** button at the bottom right corner to have this image as the Featured Image for the page/post.

![Adding a featured image](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-10.36.03-AM-1024x575.png)Once you’ve set a Featured Image for a page or post, you have two choices available. First, you can **Replace** the current Featured Image with a new one. Second, you can **Remove** the Featured Image, so there’s no image displayed for that page or post anymore.

![Replace and Remove Options under Featured Image Settings](https://wordpress.org/documentation/files/2023/10/FeaturedImage_Update-1.png)### Excerpt

This section is optional and only applicable to post types that have excerpts enabled, such as posts. Here you can write a one to two sentence description of the post.

![Excerpt in the Settings sidebar](https://wordpress.org/documentation/files/2020/11/image5-1.png)Depending on the theme, these excerpts can be used as a preview, in place of showing the full post or page content on different places such as the homepage, search results, or the archive page.

If the excerpt is empty, WordPress automatically creates an excerpt using the first 55 words of the post.

#### Status

This setting controls the Status of the page/post and how it is viewed once it is published.

Clicking on the current setting for **Status** will open a pop-over where you can change the Status &amp; Visibility setting. Click **X** in the top right corner in the pop-over to close it.

![Status Settings
](https://wordpress.org/documentation/files/2020/11/image3-1.png)- **Draft:** For a post/page that is not ready to be published
- **Pending:** The pending review checkmark indicates that the page/post is ready for someone to review it. Posts that are pending review are marked as **Pending** in the list of posts and will also show up in the filter under **Pending**. This check box will NOT be available once a page/post is published.

![Pending review posts in the Pending filter](https://wordpress.org/documentation/files/2020/11/chrome_i4iNC7fxIb.png)- **Private:** Only visible to site admins and editors.
- **Scheduled:** Publish automatically on a choosen date
- **Published:** Visible to everyone
- **Password protected:** Only those with the password can see the post. You will be prompted to enter a secure password when you choose this setting.

![Visibility in the Summary section, making a post password protected](https://wordpress.org/documentation/files/2020/11/image5.png)- **Sticky**: This Check Box controls if you want to make the post a [sticky post](https://wordpress.org/documentation/article/sticky-posts/). A Sticky Post is a post placed at the top of the front page of Posts.

![Stick to the top of the blog ](https://wordpress.org/documentation/files/2020/11/image10.png)#### Publish

This setting controls when the post will be published. Clicking on the current setting for ****Publish**** will open a pop-over where you can change the settings. Click **X** in the top right corner in the pop-over to close it.

![Publish Settings](https://wordpress.org/documentation/files/2020/11/image1-1.png)Clicking **Now** in the top right corner (next to the **X**) will set **Publish** to **Immediately**.

To backdate the post or change it to a date and time in the future, use the calendar. This will schedule the post to publish at a different time.

- Change the time by the **hour** : **minute**. Also select **AM**/**PM**
- Select the month from the drop-down under **Date** and pick the date and year.
- Click the right or left arrows next to the current month, to select other months in the past or the future, and click the desired day in the month to select it.
- The current day is highlighted in a gray circle. The day picked for publishing is highlighted in a blue circle.
- Note that the calendar shows the start week based on the [**Week Starts On** setting ](https://wordpress.org/documentation/article/settings-general-screen/#week-starts-on)that your site has.

#### Slug

This setting controls the **Permalink** for the page/post. A [permalink](https://wordpress.org/documentation/article/using-permalinks/) is a permanent URL of your post or page. They are used to link to the page/post from another blog, email, or from social media profile.

![Slug Settings ](https://wordpress.org/documentation/files/2020/11/image2-1.png)Clicking on the current setting for the **Slug** will open a pop-over where you can change the settings. Click **X** in the top right corner in the pop-over to close it.

If you have your [Permalink settings](https://wordpress.org/documentation/article/using-permalinks/#choosing-your-permalink-structure) to *Plain*, you will NOT have the option to customize the URL. the U pretty permalinks for draft and schedule posts.

- **Permalink:** Once your post or page is saved as a draft, you can edit the last part of the URL (also called the **Slug**). Depending on your [Permalink settings](https://wordpress.org/documentation/article/using-permalinks/#choosing-your-permalink-structure), the **Slug** will be appended to the end of your site’s URL. For example: https://example.com/**\[slug\]**
- The **Slug** is automatically pre-populated as a URL-friendly version of your post/page title. To change that, you can type into the **Permalink** text field.

- **View Post:** The link here is the complete URL of the post once it’s published. Clicking on this link will open the post or page in a new tab.

#### Author

This setting will show the author of the page/post. If you have enough permission, you can change the author by selecting a different author from the dropdown list.

![Author Setting](https://wordpress.org/documentation/files/2020/11/image4-1.png)#### Template

This setting controls which template is used by the page/post. A template defines the way content is displayed when viewing your post or page. Clicking on the current setting for the ******Template****** will open a pop-over where you can change the settings. Click **X** in the top right corner in the pop-over to close it.

![Template Settings ](https://wordpress.org/documentation/files/2020/11/image8.png)Template popup for block themesYou can change the template by clicking on the dropdown list and selecting a different template. All your theme’s templates will be displayed in the drop down list.

If you are using a [block theme](https://wordpress.org/documentation/article/block-themes/), you will have the option to edit the current template. Click **Edit template** at the bottom of the dropdown list which will open the current template in the [Template Editor](https://wordpress.org/documentation/article/template-editor/#to-edit-a-template). Here you can make changes to the selected template.

You will also have the option to create a new template if you are using a [block theme](https://wordpress.org/documentation/article/block-themes/). Click the add template icon in the top right corner (next to the **X** icon). This will open a dialog box where you can give a name for the new template you are about to create and click **Create** to open the [Template Editor](https://wordpress.org/documentation/article/template-editor/#new-template) where you can build out the new template.

The Edit template and Add template options are NOT available if you have Editor permissions

### Discussion

Here you can control how people interact with your post through comments.

![Discussion in the settings sidebar](https://wordpress.org/documentation/files/2020/11/image7.png)- You can turn on comments on the Post by checking **Open**.
- You can also turn on [pingbacks](https://wordpress.org/documentation/article/introduction-to-blogging/#pingbacks) and [trackbacks](https://wordpress.org/documentation/article/introduction-to-blogging/#trackbacks) by checking **Enable pingbacks &amp; trackbacks**. Trackbacks and Pingbacks both aim to provide some verification to blog commenting. *This feature is only available for Posts.*

#### Post format

This feature is only available for Posts AND on certain themes only. In some themes, like Twenty Sixteen, there is a dropdown menu for Post Format. A Post Format is used by a theme for presenting posts in a certain style. Refer to your theme’s documentation for how each Post Format will show up on your site.

![Post formats](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-11.32.08-AM.png)### Parent

This section allows you to set parent pages and change the order of your pages. This feature is only available for hierarchical post types, such as Pages.

![Parent attributes in the settings sidebar](https://wordpress.org/documentation/files/2020/11/chrome_PRyEpRDS5n.png)- Using **Parent Pages** is a good way to organize your site Pages into hierarchies. A parent page is a top-level page, with child pages nested under it. Clicking inside the **Parent Page** text box will show the pages on the site in the hierarchy. You can select any page to be the top-level Page with the current Page as its child.
- You can change the order that your pages are displayed when using a default menu by using the **Order** field. This sets the order in which your Pages are displayed in the Page hierarchy.

#### Move to trash

Once the post or page is saved for the first time as a draft, a new button will appear named **Move to trash**. This button will continue to show up in the sidebar for a page/post that is pending review, scheduled, or published. Once an item is placed into the trash, it remains there for 30 days (by default), then is permanently deleted.

![Move to trash feature in Post](https://wordpress.org/documentation/files/2023/10/Move-to-Trash.gif)### Categories

Each post in WordPress is filed under one or more [Categories](https://wordpress.org/documentation/article/posts-categories-screen/). Categories provide a helpful way to group related blog posts together. They not only help keep posts organized, but you can also use categories to display posts in several places across your site, making it easier for your visitors to find what they’re looking for quickly.

On the Settings sidebar for Posts, a list of your categories will show up with checkboxes. Add your post to one or more categories by checking the checkbox next to the Category name.

![Categories settings](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-9.38.20-AM.png)To add a new category, click **Add New Category** to open a new panel.

- Type a name for the **New Category**.
- Select a **Parent Category** for the New Category. Each Category may be assigned to a Parent Category, allowing you to set a hierarchy within the Category structure.
- Click the **Add New Category** button.

### Tags

Tags provide a useful way to group related posts together and quickly tell your readers what a post is about. Tags also make it easier for people to find your content. Each post in WordPress can be filed under one or more Tags. Unlike Categories, Tags are not required.

![Tags in Settings sidebar](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-10.30.42-AM.png)By default, this feature is only available for posts.

- To add a new tag to your post, type in the text box **Add New Tag**. Then press `Enter` or `Return` on your keyboard.
- If the tag has already been created for a previous post, the Tags box will begin to auto-populate with matching tags.
- To remove a tag, click on the **X** to the right of the tag.

If you have more than 3 tags that you frequently use on your Posts, they will be displayed under **Most Used**. Clicking on any one of them will add it to the current Post.

![Tags in Settings sidebar](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-1.20.08-PM.png)## How to customize

You can change which sections appear in the sidebar of the WordPress Editor by using the [Preferences](https://wordpress.org/documentation/article/preferences-overview/) tool.

## The Site Editor Settings Sidebar

The settings sidebar in the [Site Editor](https://wordpress.org/documentation/article/site-editor/) (**only** available if your site is using a [block theme](https://wordpress.org/documentation/article/block-themes/)) is shown below:

![Settings sidebar in site editor](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-2.25.23-PM.png)- You can find the name of the Template and what it’s purpose is. Under **Areas,** the Template Parts that make up the Template are listed.
- Clicking on any one of the Template Parts in the list will navigate you to where that Template Part is located on the template page. It will also open up a new panel in the sidebar showing the details for that Template Part as shown below:

![Customizing the template part in the sidebar settings](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-4.35.19-PM.png)- Under the **Advanced** section, you can change the Title, Area, HTML element for the Template Part and also add additional CSS classes.
- If you are viewing a template that came bundled with your block theme and you have made changes to the template, you can clear the customizations by clicking the three-dot menu icon in the top right corner of the Template settings sidebar. This will open a drop-down menu. Select **Clear customizations**. This will reset the template to the default state and you will lose the changes you made to that template.

![Clear customizations in the sidebar for site editor](https://wordpress.org/documentation/files/2022/10/Screen-Shot-2022-10-27-at-4.50.45-PM.png)## Changelog

- Updated 2024-10-14
    - Updated screenshots and alt texts as it appears in the latest Gutenberg editor.
    - Replaced the URL section with Slug as it appears in the latest Gutenberg release.
    - Removed the switch to Draft section as it is not present in the latest Gutenberg release.
    - Edited some part of the docs based on the features from the latest version of WordPress and block editor.
- Updated 2023-10-19
    - Updated content for Switch to Draft Replacement in 6.3 release.
    - Added content for Featured Image(Replace &amp; Remove Buttons)
    - Updated Screenshots and alt texts.
- Updated 2022-10-26
    - Content, screenshots, and videos updated for the 6.1 release
    - Linked to the Preferences Overview page and removed content from here
- Updated 2021-02-22
    - Updated Preferences section ahead of WP 5.7 release.
- Created 2020-11-26
