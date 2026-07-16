---
type: document
title: Gallery block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/gallery-block/"
tags:
timestamp: "2026-06-16T19:28:58+00:00"
wordpress:
  id: 2332
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:58"
  date_gmt: "2026-06-16 19:28:58"
  modified: "2026-06-16 19:28:58"
  modified_gmt: "2026-06-16 19:28:58"
  slug: gallery-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/gallery-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - media-blocks
---

[Go back to the list of Blocks](https://wordpress.org/documentation/article/blocks/)

The Gallery block allows you to easily add multiple photos and automatically arrange them in a gallery. You can control the number of columns and the size of the images in the gallery.

## Add a Gallery block

Add the Gallery block to a page by clicking on the **Block Inserter +** icon and selecting the Gallery block.

![Image showing the Quick Inserter with gallery in the search field. ](https://wordpress.org/documentation/files/2021/12/Screen-Shot-2021-12-21-at-4.09.44-PM-1024x542.png)Adding the Gallery blockAlternatively, you can type `/gallery` and press Enter.

![Image of the slash inserter with the gallery block listed.](https://wordpress.org/documentation/files/2021/12/Screen-Shot-2021-12-21-at-4.08.17-PM-1024x726.png)Adding the Gallery block with */gallery* shortcut[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

Each block has its own block-specific controls that allow you to manipulate the block right in the editor.

### For the entire block

The Gallery block has a toolbar for the individual images as well as a toolbar for the entire Gallery block.

![Block editor toolbar showing image tools and formatting options, with a Replace button on the right.](https://wordpress.org/documentation/files/2019/03/2026-02-15_12-20.jpg)Block editor toolbar showing image tools and formatting options, with a Replace button on the right.The main options in the Gallery block toolbar are:

- Transform to
- Block moving handles
    - Drag and drop
    - Move up and down
- Change alignment
- Link
- Caption
- Add button
- More options

#### Transform to

![Block editor ‘Transform to’ menu open, showing options like Columns, Details, Group, and Image.](https://wordpress.org/documentation/files/2019/03/galler-block-transform-to.jpg)Block editor ‘Transform to’ menu open, showing options like Columns, Details, Group, and Image.The buttons in **Transform To** let you change the block to a Group, Image, Columns or Details block.

When you change the block type to the Image block, every image in your gallery will be converted into a single Image block.

#### Block moving handles

![Moving a gallery block](https://wordpress.org/documentation/files/2022/08/Screen-Shot-2022-08-20-at-10.16.08-AM.png)The block-moving handles allow you to move the block up and down the editor. Use the grab handle (six dots button) to drag and drop the Gallery block and place it anywhere on the page. Alternatively, click on the up and down arrows to move the block up or down by one step.

[](https://wordpress.org/documentation/article/adding-a-new-block/)[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

#### Change alignment

![Gallery block alignment and width](https://wordpress.org/documentation/files/2022/08/Screen-Shot-2022-08-20-at-10.16.28-AM.png)- **Align left** – Align the block to the left
- **Align center** – Center the block
- **Align right** – Align the block to the right
- **Wide width** – Increase the width of the block beyond the content size
- **Full width** – Extend the block to cover the full width of the screen

**Wide width** and **Full width** alignment options are only available if they are enabled in your theme.

#### Link

You can choose link options to apply to all images in your gallery.

![Gallery link options.](https://wordpress.org/documentation/files/2019/03/Screenshot-2026-03-06-at-3.05.21-PM-1024x408.jpg)- **Link images to attachment pages** – Selecting this option will link the image to its WordPress media [attachment](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages/#step-4-attachment-details) page.
    - This is an informational page about your image, which includes the image, the caption, the image description, and a comment field.
- **Link images to media files** – Selecting this option will link the image to the image file in the original size in a new browser window.
- **Enlarge on click** – Selecting this option lets visitors open gallery images in a larger view, also known as a lightbox, without leaving the page. Visitors will be able to move forward and backward through each image in the lightbox.
- **None**: Selecting this option will not link the image to anything.

#### Caption for the gallery

You can add a caption to the whole gallery by clicking on the **Caption** icon on the block settings toolbar.

![Adding a caption to the gallery block](https://wordpress.org/documentation/files/2019/03/gallery-caption-1024x641.png)Adding a caption to the Gallery blockYou can add captions for individual images using the caption button in each image block’s toolbar.

![Caption text on top of an individual image in the Gallery block](https://wordpress.org/documentation/files/2019/03/gallery-block-individual-image-caption.png)Caption text on an individual image in the Gallery block#### Adding images

The **Add** button in the Gallery block lets you add images to the gallery. You have two ways of doing this: **Open Media Library** and **Upload**.

![Adding images to the gallery block](https://wordpress.org/documentation/files/2022/08/Screen-Shot-2022-08-20-at-10.16.45-AM.png)Adding images to the Gallery blockThe Upload option allows you to upload a new image or multiple images to the Gallery block. It will add them to your Media Library at the same time. The Media Library option lets you choose from images you uploaded to your Media Library earlier.

You can also drag and drop multiple images at the same time from your explorer or finder window into the Gallery block.

Alternatively, you can open the main inserter panel on the editor and open the media tab. Then, you can drag and drop images from the media library and Openverse into the Gallery block.

#### More options

These controls give you the option to copy, duplicate, and edit your block as HTML.

[](https://wordpress.org/documentation/article/moving-blocks/)[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

### For an individual image

Each image inside a Gallery block is an Image block. When you select an individual image, the toolbar shows Image block controls for that image, such as link, crop, replace, and more. These settings affect only the selected image, not the entire Gallery block.

![Individual image block toolbar with the 'Select parent block: Gallery' button in focus](https://wordpress.org/documentation/files/2019/03/gallery-block-toolbar-select-gallery-button-1024x219.png)If you want to return to the full Gallery block settings, use the **Select parent block: Gallery** button in the toolbar.. This lets you edit gallery-wide settings, such as columns, image resolution, cropping, and layout.

**Note**: Some options such as **Add text over image** or **Align** may not be present or may not work as expected when an Image block is inside a Gallery block.

#### Move images

Once you have added images to your Gallery block, you can change the order of the images in the gallery. Click on an image, and in the block toolbar use the **move left** and **move right** arrow handles or the grab handle (six dots button) to arrange the images as you like.

[Learn about additional block settings on the Image block page.](https://wordpress.org/documentation/article/image-block/)

## Block settings

As well as the options in the block toolbar, every block has specific options in the editor sidebar. If you don’t see the sidebar, click on the **Settings** button next to the **Save/Publish** button.

![Settings button highlighted in the block editor next to the Save button.](https://wordpress.org/documentation/files/2019/03/block-settings-7-0.png)The Gallery block settings panel is divided into three tabs – **List View**, **Settings**, and **Styles**.

### List View

The **List View** tab allows you to drag and drop images within the gallery to reorder them. When hovering over an image in List View, click on the More options (three dots) button for additional block controls like copy, duplicate, hide, delete, and more.

 

[Learn about the More options menu](https://wordpress.org/documentation/article/more-options/).

### Settings

The Gallery block includes the following settings:

- Columns
- Resolution
- Crop images to fit
- Randomize order
- Open images in a new tab
    - Only appears if [Link options](#link) are enabled
- Aspect Ratio
- Navigation button type
    - Only appears if **Enlarge on click** is enabled in [Link options](#link)
- Advanced

![Gallery block settings including column slider, resolution dropdown, and image controls.](https://wordpress.org/documentation/files/2019/03/gallery-block-settings-e1779421075171.png)#### Columns

Use the Columns setting to choose how many columns appear in the gallery.

You can choose 1 to 8 columns, but only up to the number of images in the gallery. For example, a gallery with 4 images can have up to 4 columns. Add more images to use more columns, up to the maximum of 8.

To change the number of columns, either:

- Enter a number in the field
- Use the slider to increase or decrease the number of columns

#### Resolution

You can also choose the **Resolution** of your image with options that may include **Full Size**, **Large**, **Medium** and **Thumbnail** depending on what your theme supports and the size of the originally uploaded image.

[Learn more about image size and quality](https://wordpress.org/documentation/article/image-size-and-quality/)

#### Crop images to fit

You can select whether or not you’d like all of your images to be cropped in your Gallery block.

This option is useful if you have images of varying sizes and shapes. Cropping them will make the images in each row of the gallery the same size. Toggle this option on and off to see which way you’d prefer.

#### Open images in a new tab

If any [Link options](https://wordpress.org/documentation/article/gallery-block/#link) are enabled for the gallery, you can choose whether you want images to open in a new browser tab window when the visitor clicks on them.

#### Randomize order

This button will juggle the order of images in the Gallery block.

**Note**: in the block editor, the images will still appear in the order they were added. But on the published post, they will be displayed in a random order.

#### Aspect ratio

This setting changes the aspect ratio of all of the images in the Gallery to one consistent ratio.

#### Navigation button type

If **Enlarge on click** is enabled in [Link options](#link) for the Gallery, you can choose the style of the lightbox’s previous, next, and close navigation buttons.

- **Icon**: only icons display
- **Text**: only text labels display
- **Both**: both icons and text labels display

#### Advanced settings

The Gallery block provides the following Advanced settings options: HTML Anchor, Additional CSS Class(es), Additional CSS, and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

### Styles

![](https://wordpress.org/documentation/files/2019/03/gallery-block-styles-425x1024.png)#### Color

The Gallery block provides color settings options to change the background for the block

For details, refer to this support article: [Color settings overview](https://wordpress.org/documentation/article/colors-settings-overview/)

#### Dimensions

The Gallery block provides dimension settings options to add padding and margin.

For details refer to this support article: [Dimension settings overview](https://wordpress.org/documentation/article/dimension-controls-overview/)

#### Border

The Gallery block provides border settings options to add border color, width, and radius.

For details refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

## Changelog

- Update 2026-06-13-26 (props to @andyfinally @kjoyner)
    - Minor content updates to improve plain language and tense
- Updated 2026-05-21 (props to @kjoyner @madhudollu @jameskoster @paaljoachim @wildworks @joen @dmsnell)
    - Updated block toolbar and block settings to include new lightbox controls and settings
    - Updated Enlarge on click definition to clarify lightbox effect
    - Updated screenshots and videos for WordPress 7.0
    - Updated Advanced Settings to refer to new advanced settings overview page
    - Added video of List View, moving images, and lightbox navigation controls
- Updated 2026-03-08 (props to @awetz583 @CalolanC @leonnugraha)
    - Removed duplicate content
    - Updated gallery link options
    - Updated block toolbar and settings screenshots
    - Updated settings with randomize feature
- Updated 2026-02-15
    - Updated toolbar &amp; “transform to” screenshots(@rollybueno)
- Updated 2025-07-05
    - Added Enlarge on click option of the image
- Updated 2024-01-16
    - Updated screenshots and content for 6.3
    - Fixed text formatting consistecy
    - Added missing alt text to screenshots
- Updated 2023-03-29
    - Added the option to clear duotone
    - Added information about the style settings tab
    - Added caption button for Gallery
    - Updated screenshot and Videos for 6.2
    - Added Alt text
- Updated 2022-12-12
    - Added color settings
- Updated 2022-11-20
    - Adjusted images for mobile view
    - Added caption for images
    - Removed redundant content
- Updated 2022-08-21
    - Added 6.0 screenshots and videos.Updated block toolbar with Add button and replace the info with the updated process for adding images to the gallery.Reordered the info to separate for the block toolbar and block sidebar. Adding Dimensions to the block settings with video.Updating the blosk settings for images.
- Updated 2021-12-21
    - Updated all screenshots for 5.9 with higher resolution.
    - Added in a context related to the refactoring.
- Updated 2021-02-02
    - Updated the 5.5 video with 5.6 gifs
    - Updated all screenshots with 5.6
    - Added details to Advanced block settings options
    - Updated out-of-date contents
- Updated 2020-10-05
    - Updated the video
- Updated 2020-09-14
    - Updated 5.5 screenshots
    - Updated Block toolbar new features
    - Updated Block settings new features
- Updated 2020-06-18
    - Added ‘Link back to blocks’ to the top of the page
- Updated 2020-04-24
    - Added Drag &amp; Drop multiple images to the Gallery block
    - Added video to change the background color as group block
    - Added updated UI displays for WordPress 5.4
    - Added “More Options” to the Block Toolbar section and updated the existing once to fit other block descriptions.
    - Reorganized the post into 3 sections: How to add gallery and images, Block Toolbar and Block Settings.
    - Converted all reusable blocks to regular blocks.
- Created 2019-03-07
