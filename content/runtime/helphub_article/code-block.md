---
type: document
title: Code block
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/code-block/"
tags:
timestamp: "2026-06-16T19:28:55+00:00"
wordpress:
  id: 2323
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:55"
  date_gmt: "2026-06-16 19:28:55"
  modified: "2026-06-16 19:28:55"
  modified_gmt: "2026-06-16 19:28:55"
  slug: code-block
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/code-block/"
  comment_count: 0
  terms:
    category:
      - customization
      - text-blocks
---

[Go back to the list of **Blocks**](https://wordpress.org/documentation/article/blocks/)

**Code** block lets you add and display code snippets for others to view.

**Code** block example:

```
if ( condition ) {
    action1();
    action2();
} elseif ( condition2 && condition3 ) {
    action3();
    action4();
} else {
    defaultaction();
}
```

## Add a Code block

To add the **Code** block, open the block inserter by clicking the (**+**) icon on the upper left corner of the editor. After that, look for **Code** using the search bar and click it to insert the block into the editor.

A demonstration to add and use code blockAlternatively, you can type `/code` on the editor to insert the **Code** block manually.

![Code block keyboard shortcut](https://wordpress.org/documentation/files/2021/02/Screenshot-454535.png)[Detailed instructions on adding blocks](https://wordpress.org/documentation/article/adding-a-new-block/)

## Block toolbar

Most blocks have their own block-specific controls that allow you to manipulate the block right in the editor.

The **Code** Block shows the following buttons:

- Transform to
- Moving handles
- Bold
- Italic
- Link
- More Rich Text controls
- More options

![Code block toolbar](https://wordpress.org/documentation/files/2024/03/257561204-45bc26bb-f192-4fdd-a870-d3834c91c7f8.png)### Transform to

The Transform to button lets you change the **Code** block into a *Paragraph*, *Columns*, *Group*, *Custom HTML* or *Preformatted blocks*.

![Code block toolbar with the transform option highlighted](https://wordpress.org/documentation/files/2024/03/257561888-d7ce127c-9cc4-4396-8a9e-fa443fce8ddf.png)Transforming the **Code** block into *Group* will give you the ability to change the background color around the code.

![Code block in a group with a colored background](https://wordpress.org/documentation/files/2019/03/Untitled-2676757.png)### Moving handles

The dotted icons can be used to drag and drop a block to the place of your choosing. The up and down arrow icons can be used to shift a block up and down in your document.

![Code block toolbar with moving handles highlighted](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28.png)[Get more information about moving a block within the editor.](https://wordpress.org/documentation/article/moving-blocks/)

### Change alignment

![Code block toolbar with the alignment option highlighted](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28-5.png)The *change alignment* tool lets you align the **Code** block within the content. You can choose one of the following alignment options:

**None:** Leaves the block alignment as is.

**Wide width:** Increase the block’s width beyond the content size.

### Bold

![Code block toolbar with bold option highlighted](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28-1.png)You can select the text in the **Code** block and use the *Bold* option or **Ctrl+B** / **Cmd+B** on your keyboard to bold it, which is usually heavier than the surrounding text.

### Italic

![Code block toolbar with italic option highlighted](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28-2.png)You can select the text in the **Code** block and use the *Italic* option or **Ctrl+I** / **Cmd+I** on your keyboard to italicize it, which usually appears slanted to the right.

### Link

![Code block toolbar with link option highlighted](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28-3.png)Use the link icon to hyperlink the highlighted text inside the **Code** block.

[Read about more link editing options.](https://wordpress.org/documentation/article/link-editing/)

### More rich text options

The drop-down menu to the left of the [More options menu](https://wordpress.org/documentation/article/more-options/) contains a range of additional rich text editing options such as highlighting, inline code, strikethrough, and more.

[Read about more rich text editing options.](https://wordpress.org/documentation/article/more-text-editing-overview/)

### More options

The Options menu represented by three vertical dots on the far right of the toolbar gives you more features such as the ability to duplicate or remove the block.

[Read about these and other settings.](https://wordpress.org/documentation/article/more-text-editing-overview/)

## Block settings

The block settings panel contains customization options specific to the block. To open it, select the block and click the **Settings** button next to the **Publish** button.

![Block settings panel](https://wordpress.org/documentation/files/2024/03/257561238-782eee25-933c-4f66-95b7-439ae8022e28-4.png)### Color

The **Code** block provides color settings options to change the text and background colors.

For details, refer to this support article: [Color settings overview](https://wordpress.org/support/article/colors-settings-overview/)

### Typography

The **Code** block provides typography settings to change the font family, appearance, line height, letter spacing, decoration, letter case, and font size.

For details, refer to this support article: [Typography settings overview](https://wordpress.org/support/article/typography-settings-overview/)

### Dimensions

The **Code** block provides dimension settings options to add padding and margin.

For details, refer to this support article: [Dimension settings overview](https://wordpress.org/support/article/dimension-controls-overview/)

### Border

The **Code** block provides border settings options to add border color, width, and radius.

For details, refer to this support article: [Border settings overview](https://wordpress.org/documentation/article/border-settings-overview/)

### Advanced

The Code block provides the following Advanced settings options: HTML Anchor, Additional CSS Class(es), and Styles.

[Learn more about advanced settings](https://wordpress.org/documentation/article/advanced-settings-overview/)

## Changelog

- Updated 2026-05-25 (props to @kjoyner @awetz583)
    - Updated “Advanced” section to refer to new overview page
- Updated 2026-03-01
    - Updated block name from italic to bold (props katmoody, rollybueno)
    - Monospaced when referrencing `/code` block (props katmoody, rollybueno)
    - Add a section heading on how to add a Code block (props katmoody, rollybueno)
- Updated 2025-12-08
    - Changed the capitalization in the title to Code block.
- Updated 2024-03-26
    - Add wide align support
    - Update videos and screenshots for 6.3
- Updated 2023-08-09
    - Replaced the link section with short summary linking to new dedicated page.
- Updated 2023-06-08
    - Replaced “More rich text options” section with short summary linking to new dedicated page for rich text editing options.
- Updated 2023-06-02
    - Screenshots for 6.2
    - Revised formatting
    - Added transform to paragraph support
- Updated 2021-02-27
    - Added Typography option
- Updated 2020-09-13
    - Screenshots and video as per WordPress 5.5
    - Added feature changes in Block Toolbar
    - Added feature changes in Block Settings
- Created 2019-03-07
