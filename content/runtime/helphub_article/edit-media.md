---
type: document
title: Edit Media
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/edit-media/"
tags:
timestamp: "2026-06-16T19:28:37+00:00"
wordpress:
  id: 2234
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:37"
  date_gmt: "2026-06-16 19:28:37"
  modified: "2026-06-16 19:28:37"
  modified_gmt: "2026-06-16 19:28:37"
  slug: edit-media
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/edit-media/"
  comment_count: 0
  terms:
    category:
      - media
      - support-guides
---

## Overview

The **Edit Media** page is where you manage information about your media that is saved in the [Media Library](https://wordpress.org/documentation/article/media-library-screen/). To reach the **Edit Media** page, go to **Media &gt; Library** and click the name of the media item or the **Edit** link that appears below the name on hover. You can also reach this page by clicking on the **Edit** link when [adding new media](https://wordpress.org/documentation/article/media-add-new-screen/) to your site.

The data entered on the **Edit Media** page is often used by attachment pages and galleries if the theme or plugin chooses to display it, and the data is also used as the default values at the time an image is inserted into a page. Once the image has been inserted as an individual image, it becomes disconnected from the data in the media library and you can use the Image Details screen to update it on a per-image basis.

In addition to managing meta data such as title, caption, alt text, and description, there are also added controls for performing basic media edits such as rotating, scaling, and cropping images. For more information see the [Edit Image](https://wordpress.org/documentation/article/edit-media/#edit-image) section.

![Edit media page showing the options](https://wordpress.org/documentation/files/2023/06/edit-media-1024x973.png)Edit media showing the options## [Edit media page](https://wordpress.org/documentation/article/edit-media/#edit-media-page)

**Title**

The name of the media. A title is displayed in the File column of the [Media Library Screen](https://wordpress.org/documentation/article/media-library-screen/) and is often shown on attachment pages and galleries if themes or plugins are designed to display it.

**Permalink**

This is the URL of the media attachment page. There is also a link to view the attachment page. Next to this, there may be a button to edit the permalink—if there isn’t, you can change the permalink by activating ‘Slug’ from the screen options and changing the slug’s value.

**Edit image button**

(Image files only) allows you to make edits such as rotate, scale, and crop.

**Caption**

A brief explanation of the media.

**Alternate text**

The alt text for the image, e.g. “The Mona Lisa” to describe the media. Used for accessibility.

**Description**

An explanation of this particular media.

**File URL**

Read only display of a direct link to the media file.

**Copy URL to clipboard:**

Click to copy the URL of the file you are editing into the clipboard.

**Download file**

Makes it easier for users to download their uploaded media by providing a download link on the attachment details screen and in the media modal.

**Save meta box**

Displays information about your media, such as the upload date, web address, file name, type, size, and dimensions. Also includes actions to **Delete Permanently** or **Update** any change you have made.

### [More edit media options](https://wordpress.org/documentation/article/edit-media/#more-edit-media-options)

[![Screen options in edit media page](https://i2.wp.com/wordpress.org/documentation/files/2019/01/edit-media-more-options.png?fit=693%2C495&ssl=1)](https://wordpress.org/support/edit-media-more-options/)Screen options in Edit media page***Note:** The following Meta Boxes may not be visible by default. You can enable them by clicking on the **Screen Options** tab at the top right of the **Edit Media** page.*

**Discussion**

Turn the ability to leave comments and/or trackbacks on the media attachment page on or off

**Comments**

List of current comments saved for this media file

**Slug**

the attachment page slug

**Author**

the Author for the media

![Attachment details after clicking on edit image](https://wordpress.org/documentation/files/2023/06/attachment-details-2-1024x541.png)Attachment details### [Edit image](https://wordpress.org/documentation/article/edit-media/#edit-image)

![Edit image options](https://wordpress.org/documentation/files/2023/06/edit-image-1024x601.png)Edit imageClicking the **Edit Image** button launches the image editor screen, giving you access to several useful image editing controls. The edits you make to your image are *non-destructive* and you can restore the image to its original (uploaded) specifications at any time. Here are the various controls available to you in this **Edit Image** mode:

**Crop**

To crop the image, first, click on the image and drag to make your selection. Once a selection has been made, then click the crop icon above the image to finalize the crop. You can use the **Aspect ratio** and **Selection** option to make further adjustments or use [keyboard shortcuts](https://wordpress.org/documentation/article/edit-media/#keyboard-shortcuts) to fine-tune your crop selection before clicking the crop icon.

**Rotate left button**

Rotate the image 90 degrees counter-clockwise.

**Rotate right button**

Rotate the image 90 degrees clockwise.

**Flip vertical button**

Flip the image upside-down.

**Flip horizontal button**

Flip the image left-to-right.

**Undo/Redo button**

Remove or restore your last edit. You can click as many times as you want in succession to “step” through the edit history.

**Scale image**

Proportionally scale the original image. For best results, scaling should be done before you crop, flip, or rotate. Images can only be scaled down, not up. The original dimensions are displayed as a guideline above the box for entering new dimensions. Click **Scale** button to display the new scaled image. Also **Restore Original Image** button appears to allow you restore the change.

**Restore original image**

If changes have been made to an image, the Restore Original Image pull-down allows you to discard any changes and restore the original image. Previously edited copies of the image will not be deleted. Press the Restore Image button to complete the action.

![restore original image size after scaling the image](https://wordpress.org/documentation/files/2023/06/restore-image.gif)Restore original image**Image crop**

Used in combination with the *Crop* icon, this tool allows you to make the following precise adjustments:

- **Crop aspect Ratio:** You can specify the crop selection aspect ratio then hold down the Shift key while dragging to lock it. The values can be 1:1 (square), 4:3, 16:9, etc. If there is a selection, specifying aspect ratio will set it immediately.
- **Crop selection**: Once started, the selection can be adjusted by entering new values (in pixels). Note that these values are scaled to approximately match the original image dimensions. The minimum selection size equals the thumbnail size as set in the [Settings Media Screen](https://wordpress.org/documentation/article/settings-media-screen/).

**Thumbnail settings**

WordPress thumbnails are smaller, usually square, versions of your main image. They are automatically created each time you upload a new image. By default, a WordPress thumbnail image is 150px x 150px, and cropped as a perfect square. (You can adjust this on the [Settings Media Screen](https://wordpress.org/documentation/article/settings-media-screen/).)

When editing an image, you have three options. You can apply your changes to

- All image sizes
- Thumbnail
- All sizes except thumbnail

![Options for thumbnail settings](https://wordpress.org/documentation/files/2021/06/edit-image-thumbnail.png)Thumbnail Settings**Save**

Use this to save the changes made to an image and return to the **Edit Media** screen for this image.

**Cancel**

Use this to cancel any operation that has been performed on the image in the current session.

### [Keyboard shortcuts](https://wordpress.org/documentation/article/edit-media/#keyboard-shortcuts)

When cropping your image, these keyboard combinations can ‘fine-tune’ the size of the crop frame. Note: The arrow key can be any of four arrow keys–up arrow, down arrow, left arrow, or right arrow:

- **Arrow:** move by 10px
- **Shift + arrow:** move by 1px
- **Ctrl + arrow:** resize by 10px
- **Ctrl + Shift + arrow:** resize by 1px
- **Shift + drag:** lock aspect ratio

## [Further reading](https://wordpress.org/documentation/article/edit-media/#further-reading)

- [Media Add New Screen](https://wordpress.org/documentation/article/media-add-new-screen/)
- [Media library screen](https://wordpress.org/documentation/article/media-library-screen/)
- [Settings Media Screen](https://wordpress.org/documentation/article/settings-media-screen/)
- [Image Size and Quality](https://wordpress.org/documentation/article/image-size-and-quality/)
- [Use Images](https://wordpress.org/documentation/article/use-images/)
- [Use image and file attachments](https://wordpress.org/documentation/article/use-image-and-file-attachments/)
- [Inserting Images into Posts and Pages (Block Editor)](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages-block-editor/)
- [Inserting Images into Posts and Pages (Classic Editor)](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages-classic/)

## Changelog

- Updated 2023-07-04
    - Updated screenshots for media item edit page, attachment details and made those relevant to 6.2.2
    - Updated GIF for Restore original image
    - Made sure there is alt tag and caption for all the images
    - Added the paragraph Download file for edit media page
    - Made sure all the Headings are in sentence case
