---
type: document
title: Use image and file attachments
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/use-image-and-file-attachments/"
tags:
timestamp: "2026-06-16T19:29:00+00:00"
wordpress:
  id: 2339
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:29:00"
  date_gmt: "2026-06-16 19:29:00"
  modified: "2026-06-16 19:29:00"
  modified_gmt: "2026-06-16 19:29:00"
  slug: use-image-and-file-attachments
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/use-image-and-file-attachments/"
  comment_count: 0
  terms:
    category:
      - media
      - support-guides
---

In WordPress you can upload, store, and display a variety of file types (media). The most common file types are image, video and audio files, but other file types such as document files, spreadsheet files, and code samples (amongst others) can also be managed within WordPress.

Media can be uploaded via the [Media Add New Screen](https://wordpress.org/documentation/article/media-add-new-screen/) or [Media Library Screen](https://wordpress.org/documentation/article/media-library-screen/) in the admin area, or via quick links on the edit screen.

In order to upload media, you may need to ensure that the correct [file permissions](https://developer.wordpress.org/advanced-administration/server/file-permissions/) are set for the wp-content directory in your WordPress installation.

## Edit Screen Links

By default, above the post editing area is a link to Upload/Insert media in to the post.

## Attachment to a Post

If a media file is uploaded within the edit screen, it will automatically be attached to the current post being edited. If it is uploaded via the 
 [Media Add New Screen](https://wordpress.org/documentation/article/media-add-new-screen/) or [Media Library Screen](https://wordpress.org/documentation/article/media-library-screen/) it will be unattached, but may become attached to a post when it is inserted into post. There also is an option on the [Media Library Screen](https://wordpress.org/documentation/article/media-library-screen/) to attach unattached media items.

Note that media items are also ‘Posts’ in their own right and can be displayed as such via the WordPress [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/). Themes can make use of this to loop over media items or create galleries.

If the parent post of an attached media item is deleted, the media item will become attached to the deleted post’s parent if it exists or if it doesn’t exist, the media item will become unattached and is open for re-attachment to another post.

## Inserting in a Post

Once a media file has been uploaded, it may be [inserted in to a post](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages-block-editor/).

When the media file is inserted you can choose to:

- Link directly to the media file
- Link to the attachment post, in which case the file will be served via the WordPress [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- Not link to the media file (e.g. in the case of images, the image file will still be embedded in the page, but not linked to allow the browser to display the image file by itself)

## Usage in Themes

Themes may use various template tags to display post attachments or utilize the [attachment.php](https://developer.wordpress.org/themes/basics/template-hierarchy/) file to customize the display of attachments. A [shortcode](https://developer.wordpress.org/themes/functionality/media/galleries/#gallery-shortcode) tag is also available to display a gallery of images attached to a post.

## Further reading

- [Use Images](https://wordpress.org/documentation/article/use-images/)
- [Image Size and Quality](https://wordpress.org/documentation/article/image-size-and-quality/)
- [Settings Media Screen](https://wordpress.org/documentation/article/settings-media-screen/)
- [Media library screen](https://wordpress.org/documentation/article/media-library-screen/)
- [Media Add New Screen](https://wordpress.org/documentation/article/media-add-new-screen/)
- [Edit Media](https://wordpress.org/documentation/article/edit-media/)
- [Inserting Images into Posts and Pages (Block Editor)](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages-block-editor/)
- [Inserting Images into Posts and Pages (Classic Editor)](https://wordpress.org/documentation/article/inserting-images-into-posts-and-pages-classic/)
