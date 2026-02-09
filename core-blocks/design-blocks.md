# Design Blocks

Layout, structure, and design blocks.

## core/group

Generic container block.

**Attributes:**
- `tagName` (string) — HTML tag (div, main, section, article, aside, header, footer)
- `templateLock` (string/boolean) — Template lock (all, insert, contentOnly, false)
- `allowedBlocks` (array) — Allowed inner blocks

**Supports:** align, anchor, className, color, spacing, typography, layout, background, dimensions, position, shadow

---

## core/columns

Multi-column layout container.

**Attributes:**
- `verticalAlignment` (string) — Vertical align
- `isStackedOnMobile` (boolean) — Stack on mobile (default: true)
- `templateLock` (string/boolean) — Template lock

**Supports:** align, anchor, className, color, spacing, layout, typography

---

## core/column

Single column inside columns block.

**Attributes:**
- `verticalAlignment` (string) — Vertical alignment
- `width` (string) — Column width
- `allowedBlocks` (array) — Allowed inner blocks
- `templateLock` (string/boolean) — Template lock

**Supports:** align, anchor, className, color, spacing, layout, typography

---

## core/buttons

Button group container.

**Attributes:**
- `layout` (object) — Layout settings

**Supports:** align, anchor, className, color, spacing, typography, layout

---

## core/button

Single button.

**Attributes:**
- `text` (rich-text) — Button text
- `url` (string) — Link URL
- `title` (string) — Title attribute
- `linkTarget` (string) — Link target
- `rel` (string) — Link rel
- `placeholder` (string) — Placeholder
- `width` (number) — Width percentage (25, 50, 75, 100)
- `tagName` (string) — HTML tag (a, button)
- `type` (string) — Button type (submit, reset, button)

**Supports:** align, anchor, className, color, spacing, typography, shadow, splitting

**Styles:** fill, outline

---

## core/separator

Horizontal line separator.

**Attributes:**
- `opacity` (string) — Opacity (css, alpha-channel)

**Supports:** align, anchor, className, color, spacing

**Styles:** default, wide, dots

---

## core/spacer

Vertical spacing block.

**Attributes:**
- `height` (string) — Height (default: 100px)
- `width` (string) — Width

**Supports:** anchor, spacing

---

## core/more

"Read more" break point.

**Attributes:**
- `customText` (string) — Custom text
- `noTeaser` (boolean) — Hide excerpt

**Supports:** className, customClassName: false, multiple: false

---

## core/nextpage

Page break for paginated posts.

**Attributes:** None

**Supports:** className, customClassName: false

---

## core/navigation

Site navigation menu.

**Attributes:**
- `ref` (integer) — Navigation menu ID
- `textColor` (string) — Text color
- `customTextColor` (string) — Custom text color
- `backgroundColor` (string) — Background color
- `customBackgroundColor` (string) — Custom background
- `overlayMenu` (string) — Overlay mode (never, mobile, always)
- `overlayBackgroundColor` (string) — Overlay background
- `overlayTextColor` (string) — Overlay text color
- `icon` (string) — Menu icon
- `hasIcon` (boolean) — Show icon (default: true)
- `openSubmenusOnClick` (boolean) — Click to open submenus
- `showSubmenuIcon` (boolean) — Show submenu icons (default: true)
- `maxNestingLevel` (number) — Max nesting (default: 5)
- `templateLock` (string/boolean) — Template lock

**Supports:** align, anchor, className, typography, spacing, layout, color

---

## core/navigation-link

Navigation menu link item.

**Attributes:**
- `label` (rich-text) — Link text
- `type` (string) — Link type
- `description` (string) — Description
- `rel` (string) — Link rel
- `id` (integer) — Post/page ID
- `opensInNewTab` (boolean) — Open in new tab
- `url` (string) — URL
- `title` (string) — Title attribute
- `kind` (string) — Link kind
- `isTopLevelLink` (boolean) — Top level

**Supports:** className, typography

---

## core/navigation-submenu

Navigation submenu container.

**Attributes:**
- `label` (rich-text) — Submenu label
- `type` (string) — Link type
- `description` (string) — Description
- `rel` (string) — Link rel
- `id` (integer) — Post/page ID
- `opensInNewTab` (boolean) — Open in new tab
- `url` (string) — URL
- `title` (string) — Title attribute
- `kind` (string) — Link kind
- `isTopLevelItem` (boolean) — Top level

**Supports:** className

---

## core/home-link

Home page link for navigation.

**Attributes:**
- `label` (string) — Link text

**Supports:** className, typography

---

## core/accordion

Accordion container.

**Attributes:**
- `allowMultiple` (boolean) — Allow multiple open

**Supports:** align, anchor, className, color, spacing, typography, layout

---

## core/accordion-item

Single accordion item.

**Attributes:**
- `defaultOpen` (boolean) — Open by default

**Supports:** className, color, spacing, typography

---

## core/accordion-heading

Accordion item heading.

**Attributes:**
- `content` (rich-text) — Heading text

**Supports:** className, color, typography

---

## core/accordion-panel

Accordion item content panel.

**Attributes:** None

**Supports:** className, color, spacing, typography, layout
