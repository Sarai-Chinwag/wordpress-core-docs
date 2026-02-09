# Widget Blocks

Dynamic content blocks for sidebars and widgets.

## core/archives

Post archives list by date.

**Attributes:**
- `displayAsDropdown` (boolean) — Display as dropdown
- `showLabel` (boolean) — Show label (default: true)
- `showPostCounts` (boolean) — Show post counts
- `type` (string) — Archive type (monthly, yearly, weekly, daily)

**Supports:** align, className, color, spacing, typography

---

## core/calendar

Calendar widget showing posts by date.

**Attributes:**
- `month` (integer) — Month to display
- `year` (integer) — Year to display

**Supports:** align, className, color, typography, spacing

---

## core/categories

Taxonomy terms list (was categories, now handles any taxonomy).

**Attributes:**
- `displayAsDropdown` (boolean) — Display as dropdown
- `showHierarchy` (boolean) — Show hierarchy
- `showPostCounts` (boolean) — Show post counts
- `showOnlyTopLevel` (boolean) — Show only top level
- `showEmpty` (boolean) — Show empty terms
- `label` (string) — Dropdown label
- `showLabel` (boolean) — Show label (default: true)
- `taxonomy` (string) — Taxonomy slug (default: category)

**Supports:** align, className, color, spacing, typography

---

## core/latest-comments

Recent comments list.

**Attributes:**
- `commentsToShow` (integer) — Number to show (default: 5)
- `displayAvatar` (boolean) — Show avatar (default: true)
- `displayDate` (boolean) — Show date (default: true)
- `displayExcerpt` (boolean) — Show excerpt (default: true)

**Supports:** align, className, color, spacing, typography

---

## core/latest-posts

Recent posts list.

**Attributes:**
- `categories` (array) — Category IDs
- `selectedAuthor` (integer) — Author ID
- `postsToShow` (integer) — Number to show (default: 5)
- `displayPostContent` (boolean) — Show content
- `displayPostContentRadio` (string) — Content type (excerpt, full_post)
- `excerptLength` (integer) — Excerpt length (default: 55)
- `displayAuthor` (boolean) — Show author
- `displayPostDate` (boolean) — Show date
- `displayFeaturedImage` (boolean) — Show featured image
- `featuredImageAlign` (string) — Image alignment
- `featuredImageSizeSlug` (string) — Image size
- `featuredImageSizeWidth` (number) — Image width
- `featuredImageSizeHeight` (number) — Image height
- `addLinkToFeaturedImage` (boolean) — Link image
- `postLayout` (string) — Layout (list, grid)
- `columns` (integer) — Grid columns (default: 3)
- `order` (string) — Order (asc, desc)
- `orderBy` (string) — Order by (date, title, author, random)

**Supports:** align, className, color, spacing, typography

---

## core/rss

External RSS feed display.

**Attributes:**
- `feedURL` (string) — Feed URL
- `itemsToShow` (integer) — Items to show (default: 5)
- `displayExcerpt` (boolean) — Show excerpt
- `displayAuthor` (boolean) — Show author
- `displayDate` (boolean) — Show date
- `excerptLength` (integer) — Excerpt length (default: 55)
- `blockLayout` (string) — Layout (list, grid)
- `columns` (integer) — Grid columns (default: 2)

**Supports:** align, className, color, spacing, typography

---

## core/search

Search form.

**Attributes:**
- `label` (string) — Label text
- `showLabel` (boolean) — Show label (default: true)
- `placeholder` (string) — Placeholder text
- `width` (number) — Input width percentage
- `widthUnit` (string) — Width unit
- `buttonText` (string) — Button text
- `buttonPosition` (string) — Button position (button-inside, button-outside, no-button)
- `buttonUseIcon` (boolean) — Use icon button
- `query` (object) — Query args
- `isSearchFieldHidden` (boolean) — Hide search field

**Supports:** align, className, color, spacing, typography

---

## core/tag-cloud

Tag/term cloud visualization.

**Attributes:**
- `numberOfTags` (integer) — Number of tags (default: 45)
- `taxonomy` (string) — Taxonomy (default: post_tag)
- `showTagCounts` (boolean) — Show counts
- `smallestFontSize` (string) — Smallest font (default: 8pt)
- `largestFontSize` (string) — Largest font (default: 22pt)

**Supports:** align, className, color, spacing, typography

---

## core/page-list

Auto-generated page hierarchy.

**Attributes:**
- `parentPageID` (integer) — Parent page ID (0 for all)
- `isNested` (boolean) — Is nested in navigation

**Supports:** className, color, spacing, typography

---

## core/page-list-item

Single page list item (auto-generated).

**Attributes:**
- `id` (integer) — Page ID
- `label` (string) — Page title
- `title` (string) — Title attribute
- `link` (string) — Page URL
- `hasChildren` (boolean) — Has child pages

**Supports:** className

---

## core/social-links

Social media links container.

**Attributes:**
- `iconColor` (string) — Icon color
- `customIconColor` (string) — Custom icon color
- `iconColorValue` (string) — Icon color value
- `iconBackgroundColor` (string) — Background color
- `customIconBackgroundColor` (string) — Custom background
- `iconBackgroundColorValue` (string) — Background value
- `openInNewTab` (boolean) — Open in new tab
- `showLabels` (boolean) — Show labels
- `size` (string) — Icon size

**Supports:** align, anchor, className, color, spacing, layout

---

## core/social-link

Individual social media link.

**Attributes:**
- `url` (string) — Profile URL
- `service` (string) — Service name (facebook, twitter, etc.)
- `label` (string) — Accessible label
- `rel` (string) — Link rel

**Supports:** className

---

## core/html

Custom HTML block.

**Attributes:**
- `content` (string) — HTML content

**Supports:** className, customClassName: false

---

## core/shortcode

WordPress shortcode block.

**Attributes:**
- `text` (string) — Shortcode text

**Supports:** className, customClassName: false

---

## core/legacy-widget

Classic widget in block form.

**Attributes:**
- `id` (string) — Widget instance ID
- `idBase` (string) — Widget ID base
- `instance` (object) — Widget instance data

**Supports:** className, customClassName: false

---

## core/widget-group

Widget area group.

**Attributes:**
- `title` (string) — Widget group title

**Supports:** className, color, spacing, typography
