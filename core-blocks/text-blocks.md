# Text Blocks

Content and typography blocks.

## core/paragraph

Basic text content block.

**Attributes:**
- `content` (rich-text) — Paragraph text
- `dropCap` (boolean) — Enable drop cap
- `placeholder` (string) — Placeholder text
- `direction` (string) — Text direction (ltr/rtl)

**Supports:** align, anchor, className, color, spacing, typography, splitting, __unstableOnSplit

---

## core/heading

Section heading (h1-h6).

**Attributes:**
- `content` (rich-text) — Heading text
- `level` (integer) — Heading level 1-6 (default: 2)
- `textAlign` (string) — Text alignment
- `placeholder` (string) — Placeholder text

**Supports:** align, anchor, className, color, spacing, typography, splitting

---

## core/list

Ordered or unordered list.

**Attributes:**
- `ordered` (boolean) — Use ordered list
- `values` (string) — Deprecated: list HTML
- `type` (string) — List type (1, A, a, I, i)
- `start` (integer) — Starting number
- `reversed` (boolean) — Reverse order
- `placeholder` (string) — Placeholder

**Supports:** anchor, className, typography, color, spacing, splitting

---

## core/list-item

Individual list item inside core/list.

**Attributes:**
- `content` (rich-text) — Item content
- `placeholder` (string) — Placeholder

**Supports:** className, splitting, typography

---

## core/quote

Block quote with citation.

**Attributes:**
- `value` (string) — Deprecated
- `citation` (rich-text) — Citation text
- `textAlign` (string) — Text alignment

**Supports:** anchor, className, color, spacing, typography, layout

**Styles:** default, plain

---

## core/pullquote

Emphasized pull quote.

**Attributes:**
- `value` (string) — Quote text
- `citation` (rich-text) — Citation
- `textAlign` (string) — Alignment

**Supports:** anchor, align, color, spacing, typography, background, dimensions

---

## core/code

Preformatted code block.

**Attributes:**
- `content` (rich-text) — Code content

**Supports:** anchor, className, color, spacing, typography

---

## core/preformatted

Preformatted text preserving whitespace.

**Attributes:**
- `content` (rich-text) — Text content

**Supports:** anchor, className, color, spacing, typography

---

## core/verse

Poetry or verse with preserved formatting.

**Attributes:**
- `content` (rich-text) — Verse content
- `textAlign` (string) — Text alignment

**Supports:** anchor, className, color, spacing, typography

---

## core/table

Data table.

**Attributes:**
- `hasFixedLayout` (boolean) — Fixed width columns
- `caption` (rich-text) — Table caption
- `head` (array) — Header rows
- `body` (array) — Body rows
- `foot` (array) — Footer rows

**Supports:** anchor, align, className, color, spacing, typography

**Styles:** regular, stripes

---

## core/details

Collapsible content section.

**Attributes:**
- `showContent` (boolean) — Default open state
- `summary` (rich-text) — Summary text

**Supports:** align, className, color, spacing, typography, layout

---

## core/footnotes

Post footnotes (auto-generated).

**Attributes:** None (pulls from post meta)

**Supports:** className, color, spacing, typography

---

## core/freeform

Classic Editor block (TinyMCE).

**Attributes:**
- `content` (string) — HTML content

**Supports:** className, customClassName: false, reusable: false

---

## core/missing

Placeholder for unrecognized blocks.

**Attributes:**
- `originalName` (string) — Original block name
- `originalUndelimitedContent` (string) — Original content
- `originalContent` (string) — Original HTML

**Supports:** className, customClassName: false, inserter: false, html: false, reusable: false
