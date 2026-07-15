---
type: document
title: Avatar block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/avatar-block/"
tags:
timestamp: "2026-06-16T19:28:19+00:00"
wordpress:
  id: 2158
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:19"
  date_gmt: "2026-06-16 19:28:19"
  modified: "2026-06-16 19:28:19"
  modified_gmt: "2026-06-16 19:28:19"
  slug: avatar-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/avatar-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

[Go to the List of Blocks](https://wordpress.org/documentation/article/blocks/)

Use the Avatar block to display the user’s profile picture on any post, page, or template. Although the block can be added anywhere, the most common use is in the single post template to display the author. Another use case is in the Query Loop block to include the post author’s avatar in the query.

![Adding the avatar block to the post meta](https://wordpress.org/documentation/files/2023/05/image-22.png)To add the Avatar block, click the **Add block** button to open the block inserter pop-up window and choose the Avatar block.

![Using the block inserter to add the avatar block](https://wordpress.org/documentation/files/2023/05/image-23.png)If you want to add one in the Query Loop block, be sure to add it inside the Post Template block.

![Adding an avatar block in a query loop block](https://wordpress.org/documentation/files/2023/05/image-24.png)You can also use the keyboard shortcut /avatar to quickly insert an Avatar block.

[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

Every block comes with unique toolbar icons and blocks specific user controls that allow you to manipulate the block right in the editor. To view the block toolbar, click on the *Avatar* block, and the toolbar will be displayed.

![The block toolbar for the avatar block](https://wordpress.org/documentation/files/2023/05/image-29.png)There are six buttons on the *Avatar* block toolbar:

- Transform to
- Drag icon
- Move arrows
- Align
- Duotone filter
- Options

### Transform to

![The transform options for the avatar block](https://wordpress.org/documentation/files/2023/05/image-30.png)Click on the “Transform” button to convert the *Avatar* block into a “Group” or “Columns” block.

### Drag icon

![The drag icon on the avatar block toolbar](https://wordpress.org/documentation/files/2023/05/image-31.png)To drag and drop the block to a new location on the page template, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

### Move arrows

![The move arrows on the avatar block toolbar](https://wordpress.org/documentation/files/2023/05/image-33.png)The up and down arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the editor](https://wordpress.org/documentation/article/moving-blocks/)

### Align

![The align options for the avatar block toolbar](https://wordpress.org/documentation/files/2023/05/image-36.png)Use the change alignment tool to align the Avatar block. The following is a list of the block align options:

- **None**
- **Align left** – make the block left-aligned.
- **Align center** – make the block alignment centered.
- **Align right** – make the block right aligned.

Note that the align option is only available if the Avatar block is inside a container block.

### Duotone filter

![The duotone filter on the avatar block toolbar](https://wordpress.org/documentation/files/2023/05/image-34.png)The duotone filter lets you create a two-tone color effect without losing your original image.

![Using the duotone filter for the avatar block](https://wordpress.org/documentation/files/2023/05/image-35.png)### Options

The Options button on a block toolbar gives you more features to customize a specific button.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

The block settings panel contains customization options specific to the block. To open it, select the block and click the **Settings** button next to the **Publish** button.

![The settings button at the top right corner of editor](https://wordpress.org/documentation/files/2023/03/settings.png)The block settings panel consists of two tabs – **Settings** and **Styles**

![The avatar block settings panel](https://wordpress.org/documentation/files/2023/05/image-37.png)### Settings

You can adjust various settings and add additional CSS classes for the Avatar block. The panel is divided into **Settings** and **Advanced** sections.

Here are the options available in the **Settings** section:

![The avatar block setting options](https://wordpress.org/documentation/files/2023/05/image-38.png)- **Image size** – lets you adjust the avatar image size in pixels. There are two ways to do this: the first is by using the slider to fine-tune the size, and the other is by using the pixel field to specify the image size in pixels.
- **Link to user profile** – enable this toggle option if you want to link the avatar image to the user profile page.
- **Open in new tab** – enable this toggle option if you want to open the user profile page in a new tab. This option is only available if you enable the **Link to user profile** option.
- **User** – select a specific user to be displayed on the Avatar block. If left empty, the block will use the post or page author.

#### Advanced

The List block provides the following Advanced settings options: HTML anchor, Additional CSS Class(es), and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

![The advanced section on the avatar block's settings panel](https://wordpress.org/documentation/files/2023/05/image-39.png)### Styles

The Avatar block has two styles settings – **dimensions** and **border**.

#### Dimensions

The Avatar block provides dimension settings options to change padding and margin size.

[Learn more about dimension controls.](https://wordpress.org/documentation/article/dimension-controls-overview/)

#### Border

Border settings provide options to control the width and radius on each side of the button.

[Learn more about border settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

## Changelog

- Updated 2026-05-25 (props @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- Updated 2025-12-08
    - Changed the capitalization in the title to Avatar block
- Created 2023-06-27
