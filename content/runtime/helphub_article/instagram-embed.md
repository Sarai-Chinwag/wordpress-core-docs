---
type: document
title: Instagram embed
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/instagram-embed/"
tags:
timestamp: "2026-06-16T19:28:47+00:00"
wordpress:
  id: 2283
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:47"
  date_gmt: "2026-06-16 19:28:47"
  modified: "2026-06-16 19:28:47"
  modified_gmt: "2026-06-16 19:28:47"
  slug: instagram-embed
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/instagram-embed/"
  comment_count: 0
  terms:
    category:
      - customization
      - embed-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

Due to Facebook’s [decision to close the oEmbed end ](<http://Facebook announced updates to their Marketing API>)point for embedding Instagram links, the block will not work anymore after October 24, 2020. Publishers who want to embed Facebook links into their sites will require a developer account and an appid, and provide an authenication token with their call to the endpoint. Facebook Documentation: [create an app](https://developers.facebook.com/docs/apps/)

*WordPress leadership reached out to Facebook but it seems the policy change is final. Apart from alerting users here and other place, WordPress contributors can’t do anything about it.*

---

The Facebook embed block was removed for the Gutenberg plugin version 9.0 and will be removed from the upcoming WordPress core version in 5.6

With the Instagram Embed block, you can embed Instagram posts on your posts and pages. You don’t need an Instagram account to be able to use it. You can only embed public posts, though.

**An Example:**

![Screenshot of of an instagram post](https://wordpress.org/documentation/files/2020/06/first-instagram-embed.png)**Steps to embed an Instagram Post**

1. **Find the URL of the post**

FinNavigate to the Instagram post you want to embed on your page. Copy the link of that post by clicking on it, then on the more options button, and then on the Copy Link. The process is similar for mobile devices.

![The correct URL to copy to use the embed block](https://wordpress.org/documentation/files/2020/06/second-instagram-embed.png)1. **Go to your post or page**
2. **Add the Instagram block**
3. **Paste the link into the text box and click the “Embed” button**

![Screenshot of Unstagramand the correct URL to copy to use the embed block.](https://wordpress.org/documentation/files/2020/06/third-instagram-embed.png)If the link is embedded successfully, you’ll see a preview in your editor.

![Preview of the embedded Instagram post within the WordPress editor.](https://wordpress.org/documentation/files/2020/06/fourth-instagram-embed.png)If you’re using a link that cannot be embedded, the block shows a message, “*Sorry, this content could not be embedded.*”

You will have two choices: Try again with a different URL or convert it to a link.

![Example of a URL that cannot be embedded. Two options are presented, try again or convert to link.](https://wordpress.org/documentation/files/2020/06/fifth-instagram-embed.png)**6. Click on “Preview” to see how it will look on the front-end.**

![Preview of the Instagram post ](https://wordpress.org/documentation/files/2020/06/sixth-instagram-embed.png)## Block Toolbar

Besides the Mover and Drag &amp; Drop Handle, the Block Toolbar for the Instagram embed shows four buttons:

![](https://wordpress.org/documentation/files/2020/06/seventh-instagram-embed.png)- Transform to
- Change alignment
- Edit URL, and
- More Options.

**Transform to**:

![Options to transform the Instagram block to Group.](https://wordpress.org/documentation/files/2020/06/eight-instagram-embed.png)You can transform an Instagram embed to a Group. This would give you the ability to change the background color around the Instagram embed.

![Editor view of a Instagram Embed as a group with Color Settings controls](https://wordpress.org/documentation/files/2020/06/ninth-instagram-embed.png)Editor view of an Instagram Embed as a group with Color Settings controls![Instagram embed with a green background](https://wordpress.org/documentation/files/2020/06/tenth-instagram-embed.png)Instagram embed with a green background**Change Alignment**

![Alignment options for the Instagram block: align left, align center, and align right.](https://wordpress.org/documentation/files/2020/06/eleven-instagram-embed.png)- **Align left** – Make the Instagram post left aligned
- **Align center** – Make the Instagram post alignment centered
- **Align right** – Make the Instagram post align right

**Edit URL**

Via the edit URL, you can change the Instagram Embed URL in the embed block. Overwrite the existing URL and click on the “Embed” Button.

![Editing the block URL via the "edit" option.](https://wordpress.org/documentation/files/2020/06/twelth-instagram-embed.png)**More Options:**

These controls give you the option to copy, duplicate, and edit your block as HTML.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block Settings

**Media Settings**

![Media settings for the embed block with the toggle OFF for resizing on smaller devices.](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-20-at-9.29.46-AM.png)![Media settings for the embed block with the toggle ON for resizing on smaller devices.](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-20-at-9.29.55-AM.png)Via the *Media Settings* you can control the behavior of your post embed when viewed from a smaller device, like on a phone screen.

The Toggle switch turns on or off the resize functionality for smaller devices. The default setting is “on” or blue.

**“Off:”** This embed may not preserve its aspect ratio when the browser is resized. In the off position the toggle switch is gray.

**“On:”** This embed will preserve its aspect ratio when the browser is resized. The toggle switch turns blue in the “On” position.

**Advanced**

The advanced tab lets you add a CSS class to your block, allowing you to write custom CSS and style the block as you see fit.

[![](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.33.35-AM.png)](https://wordpress.org/documentation/files/2020/04/Screen-Shot-2020-04-22-at-10.33.35-AM.png)The advanced section lets you add a CSS class to your block.## Changelog

- Updated 2022-11-27
    - Removed redundant content
    - Aligned images for mobile view
    - Added alt text to images
- Updated 2020-09-21
- Updated 2020-08-18
    - Replaced ‘More Options’ – new screenshot
    - Added “Move To” and “Copy” section under More Options
- Created 2020-06-05
