---
type: document
title: Colors Settings overview
description: ""
resource: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/colors-settings-overview/"
tags:
timestamp: "2026-06-16T19:28:23+00:00"
wordpress:
  id: 2185
  status: publish
  type: helphub_article
  author: 0
  date: "2026-06-16 19:28:23"
  date_gmt: "2026-06-16 19:28:23"
  modified: "2026-06-16 19:28:23"
  modified_gmt: "2026-06-16 19:28:23"
  slug: colors-settings-overview
  parent: 0
  menu_order: 0
  comment_status: closed
  ping_status: closed
  guid: "https://bountiful-impassioned-hygiea.wpcloudstation.dev/wordpress-org-documentation/article/colors-settings-overview/"
  comment_count: 0
  terms:
    category:
      - block-editor
      - customization
---

You can use the color settings in your [block](https://wordpress.org/documentation/article/blocks/) to set the text color, background color, link color, gradient options, and duotone filters for your content. They are designed to make it as simple as possible to update your block’s colors.

The color settings available will vary based on the theme and the block in use.

## How to access color settings

Colors can be set on a site basis or on a block basis. Setting color on a site basis will affect the color of the entire site.

### How to access color settings for your site

1. From your Administration Screens, Select Appearance &gt; Editor
2. Select Styles
3. Select Colors

### How to access color settings for a single block

1. Select the block you want to modify the color
2. Open the Block Settings sidebar of a block by clicking the Settings icon that is to the right of the Publish or Save buttons.
3. Find the Color section.
4. or, In some blocks (e.g. Group block), the Color section is located in the Styles tab represented by a black and white circle.

![Color settings of Paragraph block](https://wordpress.org/documentation/files/2022/11/color-settings-1-6.8.jpg)Color settings of Paragraph block

![Color settings of Group block](https://wordpress.org/documentation/files/2022/11/color-settings-2-6.8-538x1024.jpg)Color settings of Group block

### Viewing all settings

![All color settings and Reset all](https://wordpress.org/documentation/files/2022/11/color-settings-all-settings-6.8-300x151.jpg)All color settings and Reset allIn the Color section, click on the three-dot menu (also known as an ellipsis) to explore all the color settings that are not visible by default. Note that not every block supports all the color settings.

### Resetting all settings

If you make customizations to these settings and want to revert back to the original settings quickly, you can do so by selecting the three-dot menu icon and clicking **Reset all**. This resets the settings and removes all of your changes.

### Add a custom color

To add a custom color, click on the color box above the color palette options. It may read “no color selected” if your block is using the default color.

![Example of a custom color box with No color selected text](https://wordpress.org/documentation/files/2022/11/Screenshot-2026-05-23-at-9.29.30-AM-1024x691.png)Next, you can paste in a color HEX code or named color value such as black, darkblue, or deeppink.

![Editor showing result of pasting text deeppink when custom color picker is active](https://wordpress.org/documentation/files/2022/11/Screenshot-2026-05-23-at-9.26.54-AM-1024x457.jpg)## Type of settings

Each supported block comes with different color settings.

### Text and background colors

This option allows you to change the color of the text, and background on the block you are working on. A combination of these color settings can be used to call attention to your most important content.

You can pick a color from the color palette of your theme. You can also add a custom color from the color picker or enter the HEX, RGB, or HSL color values based on your brand. Click the two rectangle boxes next to the color slider to copy the HEX, RGB, or HSL color values.

Accessibility tests are built into the editor to warn you when the text may become hard to read against the background color choices as shown.

### Link colors

On some blocks, you will find the option to change the link color.

### Gradient background colors

Some blocks such as the [Heading block](https://wordpress.org/documentation/article/heading-block/) allow you to set either a solid color or a gradient as the background. A gradient is a mix of two or more colors, displayed using a certain pattern (from lighter to darker, or one color blending into the other).

A slider will appear that shows the two color points that make up the gradient.

![Color points in the gradient](https://wordpress.org/documentation/files/2022/11/image-2.png)You can click on any of the two color points to display the color picker for changing the color value. You can either choose a color from the color picker or enter the HEX, RGB, or HSL color values.

You can add additional color points if you like by clicking the **+** icon that appears when you hover over the gradient slider.

![Gradient type](https://wordpress.org/documentation/files/2022/11/color-settings-gradient-type-1024x849.jpg)Screenshot

You can choose between the **Linear** or **Radial** gradient type. The angle control shifts the position of the gradient.

The **Linear** type creates a gradient between the two colors along a straight line, whereas the **Radial** type starts from the center and moves to the borders.

![Liner and Radial gradient options](https://wordpress.org/documentation/files/2022/10/gradient-example.png)

### Duotone filter

You can create a two-tone color effect (called the duotone effect) on images without actually changing the original image

The duotone filter option allows you to add this filter color to your block content from the block toolbar. The filter can be black, white, or *any* other color combination of your choosing. The duotone effect works best on high-contrast images.

To get started, select the Duotone filter icon in the block toolbar. You can pick the two colors for the effect from the list of duotone presets provided in the drop-down.

You can also pick your own colors for the shadows and highlights by clicking on the **Shadows** /**Highlights** option which opens up the color picker and then selecting your custom color from the color palette.

If you want to remove the duotone filter you can click the **Clear** button found at the bottom-right of the color palette.

## Reset settings

When hovering over the Color option, if a color has been selected, a reset button (displayed as a dash icon) will appear. Clicking this button will remove the applied color and reset the field to its default state, indicating “No color selected.”

![Reset color button](https://wordpress.org/documentation/files/2022/11/color-reset.png)Reset color button## Demonstration

To illustrate the above settings, below is an example of how to add custom colors so that the social link icons will match the branding on your site:

## Changelog

- Updated 2026-06-23
    - Added custom color section
- Updated 2025-05-04
    - Add site’s color settings.
    - Update screenshots and videos.
- Update 2025-04-22 (props to [@nikunj8866](https://profiles.wordpress.org/nikunj8866/))
    - Add color reset button.
- Created 2022-11-01
