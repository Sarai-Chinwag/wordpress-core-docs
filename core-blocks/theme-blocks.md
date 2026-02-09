# Theme Blocks

Site structure, query loop, and post content blocks.

## Site Blocks

### core/site-title

Site title from Settings.

**Attributes:**
- `level` (integer) — Heading level 0-6 (0 = paragraph)
- `levelOptions` (array) — Available levels
- `textAlign` (string) — Text alignment
- `isLink` (boolean) — Link to home (default: true)
- `linkTarget` (string) — Link target

**Supports:** align, className, color, spacing, typography

---

### core/site-tagline

Site tagline from Settings.

**Attributes:**
- `textAlign` (string) — Text alignment
- `level` (integer) — Heading level 0-6

**Supports:** align, className, color, spacing, typography

---

### core/site-logo

Site logo from Customizer.

**Attributes:**
- `width` (number) — Logo width
- `isLink` (boolean) — Link to home (default: true)
- `linkTarget` (string) — Link target
- `shouldSyncIcon` (boolean) — Sync with site icon

**Supports:** align, className, color, spacing

---

### core/loginout

Login/logout link.

**Attributes:**
- `displayLoginAsForm` (boolean) — Show login form
- `redirectToCurrent` (boolean) — Redirect to current page (default: true)

**Supports:** className, color, spacing, typography

---

## Navigation

### core/navigation

(See design-blocks.md)

### core/template-part

Reusable template part.

**Attributes:**
- `slug` (string) — Template part slug
- `theme` (string) — Theme name
- `tagName` (string) — HTML tag (header, footer, aside, section, div)
- `area` (string) — Template part area

**Supports:** align, className

---

## Query Loop

### core/query

Query loop container.

**Attributes:**
- `queryId` (integer) — Unique query ID
- `query` (object) — Query parameters:
  - `perPage` (integer) — Posts per page
  - `pages` (integer) — Total pages
  - `offset` (integer) — Offset
  - `postType` (string) — Post type
  - `order` (string) — Order (asc, desc)
  - `orderBy` (string) — Order by field
  - `author` (string) — Author ID
  - `search` (string) — Search term
  - `exclude` (array) — Exclude post IDs
  - `sticky` (string) — Sticky handling
  - `inherit` (boolean) — Inherit from main query
  - `taxQuery` (object) — Taxonomy query
  - `parents` (array) — Parent page IDs
  - `format` (array) — Post formats
- `tagName` (string) — HTML tag (default: div)
- `namespace` (string) — Block namespace
- `enhancedPagination` (boolean) — Enhanced pagination

**Supports:** align, layout, color, typography, spacing

---

### core/post-template

Template for each post in query.

**Attributes:**
- `layout` (object) — Layout settings

**Supports:** align, className, color, spacing, typography, layout

---

### core/query-pagination

Query pagination container.

**Attributes:**
- `paginationArrow` (string) — Arrow style (none, arrow, chevron)
- `showLabel` (boolean) — Show labels (default: true)

**Supports:** align, className, color, spacing, typography, layout

---

### core/query-pagination-previous

Previous page link.

**Attributes:**
- `label` (string) — Link text

**Supports:** className, color, typography

---

### core/query-pagination-next

Next page link.

**Attributes:**
- `label` (string) — Link text

**Supports:** className, color, typography

---

### core/query-pagination-numbers

Page numbers.

**Attributes:**
- `midSize` (integer) — Pages around current (default: 2)

**Supports:** className, color, typography

---

### core/query-title

Query archive title.

**Attributes:**
- `type` (string) — Title type (archive, search, filter)
- `level` (integer) — Heading level (default: 1)
- `levelOptions` (array) — Available levels
- `textAlign` (string) — Text alignment
- `showPrefix` (boolean) — Show prefix (default: true)
- `showSearchTerm` (boolean) — Show search term (default: true)

**Supports:** align, className, color, spacing, typography

---

### core/query-no-results

No results message container.

**Supports:** align, className, color, typography

---

### core/query-total

Total results count.

**Attributes:**
- `displayType` (string) — Display type (total-results, range, page-count)

**Supports:** className, color, spacing, typography

---

## Post Content

### core/post-title

Post/page title.

**Attributes:**
- `level` (integer) — Heading level (default: 2)
- `levelOptions` (array) — Available levels
- `textAlign` (string) — Text alignment
- `isLink` (boolean) — Link to post
- `rel` (string) — Link rel
- `linkTarget` (string) — Link target

**Uses Context:** postId, postType, queryId

**Supports:** align, className, color, spacing, typography

---

### core/post-content

Post/page content.

**Attributes:**
- `layout` (object) — Layout settings

**Uses Context:** postId, postType

**Supports:** align, className, color, spacing, typography, layout, dimensions, background

---

### core/post-excerpt

Post excerpt.

**Attributes:**
- `textAlign` (string) — Text alignment
- `moreText` (string) — "Read more" text
- `showMoreOnNewLine` (boolean) — More on new line (default: true)
- `excerptLength` (integer) — Excerpt length (default: 55)

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-date

Post publication date.

**Attributes:**
- `textAlign` (string) — Text alignment
- `format` (string) — Date format
- `isLink` (boolean) — Link to post
- `displayType` (string) — Display type (date, modified, both)

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-featured-image

Post featured image.

**Attributes:**
- `isLink` (boolean) — Link to post
- `aspectRatio` (string) — Aspect ratio
- `width` (string) — Width
- `height` (string) — Height
- `scale` (string) — Scale (cover, contain)
- `sizeSlug` (string) — Image size
- `rel` (string) — Link rel
- `linkTarget` (string) — Link target
- `overlayColor` (string) — Overlay color
- `customOverlayColor` (string) — Custom overlay
- `dimRatio` (integer) — Overlay opacity
- `gradient` (string) — Gradient
- `customGradient` (string) — Custom gradient
- `useFirstImageFromPost` (boolean) — Fallback to first image

**Uses Context:** postId, postType, queryId

**Supports:** align, className, color, spacing, shadow

---

### core/post-author

Post author with avatar.

**Attributes:**
- `textAlign` (string) — Text alignment
- `avatarSize` (integer) — Avatar size (default: 48)
- `showAvatar` (boolean) — Show avatar (default: true)
- `showBio` (boolean) — Show bio
- `byline` (string) — Byline text
- `isLink` (boolean) — Link to author archive
- `linkTarget` (string) — Link target

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-author-name

Author name only.

**Attributes:**
- `textAlign` (string) — Text alignment
- `isLink` (boolean) — Link to author archive
- `linkTarget` (string) — Link target

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-author-biography

Author bio text.

**Attributes:**
- `textAlign` (string) — Text alignment

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-terms

Post taxonomy terms (categories, tags).

**Attributes:**
- `term` (string) — Taxonomy (default: post_tag)
- `textAlign` (string) — Text alignment
- `separator` (string) — Separator (default: ", ")
- `prefix` (string) — Prefix text
- `suffix` (string) — Suffix text

**Uses Context:** postId, postType

**Supports:** className, color, spacing, typography

---

### core/post-navigation-link

Previous/next post link.

**Attributes:**
- `textAlign` (string) — Text alignment
- `type` (string) — Link type (previous, next)
- `label` (string) — Label text
- `showTitle` (boolean) — Show post title
- `linkLabel` (boolean) — Link the label
- `arrow` (string) — Arrow style (none, arrow, chevron)
- `taxonomy` (string) — Taxonomy for adjacency

**Supports:** className, color, spacing, typography

---

### core/read-more

Read more link.

**Attributes:**
- `content` (string) — Link text
- `linkTarget` (string) — Link target

**Uses Context:** postId, postType, queryId

**Supports:** className, color, spacing, typography

---

### core/post-time-to-read

Estimated reading time.

**Attributes:**
- `textAlign` (string) — Text alignment
- `minutesToRead` (integer) — Minutes to read
- `wordsPerMinute` (integer) — Words per minute (default: 200)

**Uses Context:** postId, postType

**Supports:** className, color, spacing, typography

---

### core/post-comments-count

Comment count.

**Attributes:**
- `textAlign` (string) — Text alignment

**Uses Context:** postId

**Supports:** className, color, spacing, typography

---

### core/post-comments-link

Link to comments section.

**Attributes:**
- `textAlign` (string) — Text alignment

**Uses Context:** postId

**Supports:** className, color, spacing, typography

---

### core/post-comments-form

Comment submission form.

**Uses Context:** postId

**Supports:** className, color, spacing, typography

---

## Comments

### core/comments

Comments section container.

**Attributes:**
- `tagName` (string) — HTML tag (div, section, aside)
- `legacy` (boolean) — Legacy mode

**Uses Context:** postId

**Supports:** align, className, color, spacing, typography

---

### core/comment-template

Template for each comment.

**Supports:** align, className, color, spacing, typography

---

### core/comment-author-name

Comment author name.

**Attributes:**
- `isLink` (boolean) — Link to author URL (default: true)
- `linkTarget` (string) — Link target
- `textAlign` (string) — Text alignment

**Supports:** className, color, spacing, typography

---

### core/comment-content

Comment text content.

**Attributes:**
- `textAlign` (string) — Text alignment

**Supports:** className, color, spacing, typography

---

### core/comment-date

Comment date.

**Attributes:**
- `format` (string) — Date format
- `isLink` (boolean) — Link to comment (default: true)

**Supports:** className, color, spacing, typography

---

### core/comment-edit-link

Edit comment link (for authorized users).

**Attributes:**
- `textAlign` (string) — Text alignment
- `linkTarget` (string) — Link target

**Supports:** className, color, spacing, typography

---

### core/comment-reply-link

Reply to comment link.

**Attributes:**
- `textAlign` (string) — Text alignment

**Supports:** className, color, spacing, typography

---

### core/comments-title

Comments section heading.

**Attributes:**
- `level` (integer) — Heading level (default: 2)
- `levelOptions` (array) — Available levels
- `textAlign` (string) — Text alignment
- `showPostTitle` (boolean) — Show post title (default: true)
- `showCommentsCount` (boolean) — Show count (default: true)

**Uses Context:** postId

**Supports:** align, className, color, spacing, typography

---

### core/comments-pagination

Comments pagination container.

**Attributes:**
- `paginationArrow` (string) — Arrow style

**Supports:** align, className, color, spacing, typography, layout

---

### core/comments-pagination-previous

Previous comments page link.

**Attributes:**
- `label` (string) — Link text

**Supports:** className, color, typography

---

### core/comments-pagination-next

Next comments page link.

**Attributes:**
- `label` (string) — Link text

**Supports:** className, color, typography

---

### core/comments-pagination-numbers

Comments page numbers.

**Supports:** className, color, typography

---

## Terms/Taxonomy Query

### core/terms-query

Term query loop.

**Attributes:**
- `query` (object) — Term query parameters
- `tagName` (string) — HTML tag

**Supports:** align, className, color, spacing, typography, layout

---

### core/term-template

Template for each term.

**Attributes:**
- `layout` (object) — Layout settings

**Supports:** align, className, color, spacing, typography, layout

---

### core/term-name

Term name.

**Attributes:**
- `level` (integer) — Heading level
- `isLink` (boolean) — Link to term archive

**Uses Context:** termId

**Supports:** className, color, spacing, typography

---

### core/term-description

Term description.

**Uses Context:** termId

**Supports:** className, color, spacing, typography

---

### core/term-count

Term post count.

**Uses Context:** termId

**Supports:** className, color, spacing, typography

---

## Other

### core/avatar

User avatar image.

**Attributes:**
- `userId` (integer) — User ID
- `size` (integer) — Avatar size (default: 96)
- `isLink` (boolean) — Link to author archive
- `linkTarget` (string) — Link target

**Uses Context:** postId, postType, commentId

**Supports:** align, className, color, spacing

---

### core/pattern

Pattern placeholder (internal use).

**Attributes:**
- `slug` (string) — Pattern slug

**Supports:** inserter: false
