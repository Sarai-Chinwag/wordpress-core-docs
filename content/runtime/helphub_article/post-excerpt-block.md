---
type: document
title: Excerpt block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/post-excerpt-block/"
tags:
timestamp: "2026-06-16T19:28:28+00:00"
wordpress:
  id: 2211
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:28"
  date_gmt: "2026-06-16 19:28:28"
  modified: "2026-06-16 19:28:28"
  modified_gmt: "2026-06-16 19:28:28"
  slug: post-excerpt-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/post-excerpt-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - theme-blocks
---

[Go to the List of Blocks](https://wordpress.org/documentation/article/blocks/)

Use the Excerpt block to display the excerpt of a post. This block is primarily nested inside a[ query loop](https://wordpress.org/documentation/article/query-loop-block/) block and helps to customize the appearance of the query loop.

If the post does not have an [excerpt](https://wordpress.org/documentation/article/excerpt), the Excerpt block displays the first 55 words in the post as the excerpt, followed by the characters ‘\[…\]’.

The block has an optional **Read More** link which will direct the website visitor to the URL of the full post. You can customize this link text to anything you like. The **Read More** link can be styled independently.

![Post excerpt block is added from template using the block inserter. ](https://wordpress.org/documentation/files/2023/08/excerpt-block.png)Excerpt blockTo add an Excerpt block, click the **Block Inserter** icon when editing the page template. Search for the **Excerpt** block. Click on it to add the block to your page template.

![Post excerpt blocks are added inside query loop from template.](https://wordpress.org/documentation/files/2023/08/adding-post-excerpt-block.gif)How to add Excerpt blockYou can also type `/excerpt` and hit enter in a new paragraph block to add the Excerpt block quickly.

![The excerpt block can be added quickly by typing /excerpt.](https://wordpress.org/documentation/files/2023/08/adding-excerpt-block-1024x370.png)Adding Excerpt block quickly[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

To view the block toolbar, click on the block and the toolbar will be displayed.

Every block comes with unique toolbar icons. These block-specific controls allow you to manipulate the block right in the editor.

The Excerpt block shows these buttons in the block toolbar:

- Transform to
- Drag icon
- Move arrows
- Change text alignment
- Bold
- Italic
- Link
- More
- More options

![Excerpt block toolbar shows multiple options as icon. ](https://wordpress.org/documentation/files/2022/11/image12.png)Excerpt block toolbar### Transform to

![Transform to is the first option from left in Excerpt block toolbar. ](https://wordpress.org/documentation/files/2022/11/image8-1.png)Transform options in Excerpt blockClick on the **Transform** button to convert the Excerpt block into a **Group** block or **Columns** block.

Transform button from Excerpt block toolbar### Drag icon

![Beside transform to option, the Drag icon shows with two columns of three dots. ](https://wordpress.org/documentation/files/2022/11/image3.png)Drag icon in the Post Excerpt blockTo drag and drop the block to a new location on the page template, click and hold the rectangle of dots, then drag it to the new location. The blue separator line indicates where the block will be placed. Release the left mouse button when you find the new location to place the block.

### Move arrows

![Next to drag icon, move arrows option shows in up and down arrow angle icon.  ](https://wordpress.org/documentation/files/2022/11/image1.png)Move arrows in the Excerpt blockThe up and down arrow icons can be used to move the block up and down on the page.

[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### Change text alignment

![Change text alignment option shows an alignment icon beside the move arrows icon.](https://wordpress.org/documentation/files/2022/11/image4.png)Change text alignment in Excerpt blockClick the **Change alignment** button in the Block toolbar to display the alignment drop-down. You can align the block text to the left, make it center-aligned or align it to the right.

### Bold

![Next to alignment, Bold option shows as B.](https://wordpress.org/documentation/files/2022/03/Next-to-alignment-Bold-option-shows-as-B.png)The bold option will make the selected text bolded.

### Italic

![Similar to bold, an I icon represents Italic option in excerpt block toolbar. ](https://wordpress.org/documentation/files/2022/03/Similar-to-bold-an-I-icon-represents-Italic-option-in-excerpt-block-toolbar.png)The italic option will make the selected text italic.

### Link

![](https://wordpress.org/documentation/files/2022/03/add-read-more-text-1024x293.png)A field to customize the ‘Read more’ link text, the link URL is automatically set to the post.

### More

Click the down arrow button to display more styling tools for the **Read More** link.

[Get more information about rich text editing options](https://wordpress.org/documentation/article/more-text-editing-overview/).

### Options

These controls give you the option to copy, duplicate, and edit your block as HTML.

![The three dots beside the angle arrow down icon shows list of more options. ](https://wordpress.org/documentation/files/2023/08/more-options-excerpt-block-toolbar.png)[Read about these and other settings.](https://wordpress.org/documentation/article/more-options/)

## Block settings

The block settings panel contains customization options specific to the block. To open it, select the block and click the settings icon next to the **Save** button.

![Block settings sidebar shows sidebar icon next to save or publish button. ](https://wordpress.org/documentation/files/2023/07/block-settings-sidebar-2.png)Block settings to enable sidebar*If you do not see the sidebar, click the ‘sidebar’ icon next to the Publish button.* *The device icon between **Save draft** and Publish button shows the preview of the block.*

![After enabling the sidebar, the block section shows the settings and style for excerpt block.](https://wordpress.org/documentation/files/2023/08/post-excerpt-block-settings-561x1024.png)Excerpt block settings#### Show link on new line

Turn on **Show link on new line** button in the Block Settings to show the Excerpt Read More link on a new line instead of inline next to the excerpt text.

![Show link on new line setting appears as a toggle button to show the excerpt link on new line. ](https://lh5.googleusercontent.com/QcdK0a2urmazcyYYnUOthL973dmdGlyac2TzOhcr572sUj2ZukcCyvhUZfcmh577shPDG2OzbcsSh_GP9sWixHfHRk4QDFlLpTnTLvACRKDE58luG_8_K9eAKa0RcJ1inZLCopp9)Show Excerpt settings on new line#### Max number of words

Adds the ability to control the excerpt length in a design. The default value is 55 words, to match the WordPress default length for excerpts.

![Max number of words for excerpt settings appears as a range slider. ](https://wordpress.org/documentation/files/2023/08/max-number-of-words.png)Max number of words for excerpt#### Advanced

The **Advanced** tab lets you add CSS class(es) to your block. This will allow you to write custom CSS and styles to the block.

![Advanced setting in excerpt block shows a text field to add CSS class.](https://wordpress.org/documentation/files/2022/11/Screenshot-2022-11-11-at-11.26.17-AM-1-1.png)Advanced option in the selected Block### Color

The **Excerpt block** provides Color settings options to change the text, background, and link colors. Pick a color from the suggestions, or add a custom color using the color picker or by adding a color code.

[See this guide for more information about changing colors.](https://wordpress.org/documentation/article/colors-settings-overview/)

### Typography

The **Excerpt block** provides typography settings to change the font family, appearance, line height, letter spacing, decoration, letter case, and font size.

[Get more details about changing typography settings.](https://wordpress.org/documentation/article/typography-settings-overview/)

### Dimensions

Dimension controls are used to control how groups of blocks are placed alongside one another, by changing the values for padding, margin, and other dimensions

[Learn more about dimension controls.](https://wordpress.org/documentation/article/dimension-controls-overview/)

## Changelog

- Updated 2022-11-11
    - Updated all screenshots and updated content for 6.1
- Created 2023-07-17
    - Added excerpt length control as described here [44964](https://github.com/WordPress/gutenberg/pull/44964)
- Updated on 2023-07-22
    - Updated all the headings
- Updated on 2023-07-23
    - added new gif and screenshot for excerpt block and how to add excerpt block from template
    - added the new video for the **transform to** button on the block toolbar
    - Updated the block settings sidebar image to update to the latest version
- Updated on 2023-07-29
    - Updated the screenshot under Rich text editing option in the block toolbar and included Footnote. Also added link to this page: <https://wordpress.org/documentation/article/more-text-editing-overview/> and removed the details for that section from this page.
    - Updated the More Options screenshot.
