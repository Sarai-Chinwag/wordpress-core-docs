---
type: document
title: Crowdsignal embed
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/crowdsignal-embed/"
tags:
timestamp: "2026-06-16T19:28:45+00:00"
wordpress:
  id: 2275
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:45"
  date_gmt: "2026-06-16 19:28:45"
  modified: "2026-06-16 19:28:45"
  modified_gmt: "2026-06-16 19:28:45"
  slug: crowdsignal-embed
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/crowdsignal-embed/"
  comment_count: 0
  terms:
    category:
      - customization
      - embed-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

With the *Crowdsignal Embed* block, you can embed Crowdsignal polls (or surveys or votes) into your posts and pages. You need a Crowdsignal account to be able to create polls (or surveys or votes) before you can embed them into your posts or pages.

Since WordPress 4.2, it has supported surveys created with the block editor powered survey/project editor, which are published on `*.crowdsignal.net`.

**Example of an Embedded Crowsignal Poll**:

![Example of an embedded Crowdsignal Poll with the question "what is the best color?"](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-1.png)## Steps to embed Crowdsignal polls (or surveys or votes):

1. **Go to crowdsignal.com and signup for a free account.** 
    On your Crowdsignal Dashboard, create a new survey, poll, quiz, or rating, or select one you’ve already created.

![Crowdsignal dashboard to create a survey, poll, quiz or rating.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-2.png)1. **Get the custom link to share your poll**
    Either from the Dashboard or within the editor, find the “Share” button.

![Sharing your Crowdsignal poll via the Edtior panel.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-3.png)Find the share link within the Editor panel![Sharing your Crowdsignal poll via the Dashboard.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-4.png)Find the share link within the Dashboard for the pollWithin the **Share Your Poll** pop up, click “Copy to Clipboard”.

![The "Share your Poll" pop up with the link to copy to clipboard.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-5.png)1. **Add a Crowdsignal Embed Block to your post/page**

![Adding the Crowdsignal block via the WordPress slash command /crowdsignal.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-6.png)Adding a block via the “Slash” command from an empty row[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

1. **Paste the Crowdsignal Poll link from step 2** **into the text box**

![Embed option for the Crowdsignal block to paste the URL.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-7.png)1. **Click the “Embed” button**

If it’s a link that can be successfully embedded you will see a preview in your editor.

![Preview of the embedded Crowdsignal poll within the WordPress editor.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-8-1.png)If you use a URL that can’t be embedded, the block shows the message *“Sorry, this content could not be embedded.”* You will have two choices: Try again with a different URL or convert to link.

![Example of a URL that cannot be embedded. Two options are presented, try again or convert to link.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-9.png)## Block Toolbar

Besides the Mover and Drag &amp; Drop Handle, the Block Toolbar for the Crowdsignal embed shows four buttons:

- Transform to
- Change alignment
- Edit URL, and
- More options.

![Block Toolbar with options available for the Crowdsignal Block.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-10-1.png)**Transform to**:

![Options to transform the Crowdsignal block to Paragraph, Columns or Group.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-11-1.png)You can transform a Crowdsignal embed into a Paragraph, Columns, or Group. Transforming it into a Group would give you the ability to change the background color around the Crowdsignal embed.

![Example of transforming Crowdsignal block to group and updating the background to gradient.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-12-1024x727.png)*Editor view of a Crowdsignal Embed as a group with Color Settings controls*![Front end example of Crowdsignal embed group with gradient background.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-13.png)Crowdsignal embed with a gradient background.**Change alignment:**

![Alignment options for the Crowdsignal block: wide width, full width, align left, align center, and align right.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-14-1.png)- Wide width – Increase the width of the post beyond the content size
- Full width – extend the Crowdsignal post to cover the full width of the screen.
- Align left – Make the Crowdsignal post left aligned
- Align center – Make the Crowdsignal post alignment centered
- Align right – Make the Crowdsignal post align right

*“Wide width” and “Full width” alignment need to be enabled by the Theme of your site.*

**Edit URL**:

Via the edit URL, you can change the Crowdsignal Embed URL in the embed block. Overwrite the existing URL and click on the “Embed” Button.

![Editing the Crowdsignal block URL via the "edit" option.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-15-1.png)**More options**

The More Options menu represented by three vertical dots on the far right of the toolbar gives you more features such as the ability to duplicate, remove, or edit your block as HTML.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block Settings

Besides the Advanced section, the Crowdsignal embed has only one other setting in the “Block Settings” sidebar: Media Settings.

### Media Settings

![Media settings for the Crowdsignal embed block with the toggle OFF for resizing on smaller devices.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-20.png)

![Media settings for the Crowdsignal embed block with the toggle ON for resizing on smaller devices.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-19.png)

Via the *Media Settings* you can control the behavior of your embed when viewed from a smaller device, like on a phone screen.

The Toggle switch turns on or off the resize functionality for smaller devices. The default setting is “on” or blue.

**“Off:”** This embed may not preserve its aspect ratio when the browser is resized. In the off position, the toggle switch is gray.

**“On:”** This embed will preserve its aspect ratio when the browser is resized. The toggle switch turns blue in the “On” position.

**Advanced**

The “Advanced” tab lets you add CSS class(es) to your block.

![Additional CSS Class(es) option for the Crowdsignal Embed block.](https://wordpress.org/documentation/files/2022/08/Crowdsignal-HelpHub-SS-21.png)The “Additional CSS class(es)” lets you add CSS class(es) to your block, allowing you to write custom CSS and style the block as you see fit.

## Changelog

- Updated 2026-02-15
    - Added \*.cloudsignal.net support from WordPress 4.2
- Updated 2022-11-26
    - Removed redundant content
    - Aligned images for mobile view
- Updated 2022-08-29
    - Removed the external link
- Updated 2022-08-26
    - Video walkthrough created
- Updated 2020-08-17
    - Updated 5.5 screenshots
    - Replaced “More Options” – new screenshot,
    - Added “Move to” and “Copy” section under More Options
- Updated 2020-07-25
    - Uploaded image for crowdsignal embed with green background
- Created 2020-07-03
