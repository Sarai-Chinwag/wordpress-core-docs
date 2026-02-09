# WordPress CSS Coding Standards

## Naming Conventions

### Class Names

```css
/* ✅ Lowercase with hyphens */
.site-header {}
.main-navigation {}
.post-thumbnail {}

/* ❌ Wrong */
.siteHeader {}      /* camelCase */
.site_header {}     /* underscores */
.SiteHeader {}      /* PascalCase */
```

### BEM Convention (Recommended)

```css
/* Block */
.card {}

/* Element (part of block) */
.card__title {}
.card__content {}
.card__footer {}

/* Modifier (variation) */
.card--featured {}
.card--compact {}
.card__title--large {}
```

### Prefixing for Themes/Plugins

```css
/* ✅ Prefix to avoid conflicts */
.theme-name-header {}
.plugin-name-widget {}

/* WordPress core prefixes */
.wp-block-paragraph {}
.wp-element-button {}
```

### State Classes

```css
/* ✅ Use is-* or has-* prefixes */
.menu-item.is-active {}
.dropdown.is-open {}
.form-field.has-error {}

/* ✅ WordPress state classes */
.current-menu-item {}
.current-menu-ancestor {}
```

### JavaScript Hook Classes

```css
/* ✅ Prefix JS-only classes with js- */
.js-toggle-menu {}
.js-accordion-trigger {}

/* These classes should NOT have styles */
```

---

## Formatting

### Indentation

- Use **TABS** (consistent with PHP/JS)

```css
/* ✅ Correct */
.selector {
	property: value;
}

/* ❌ Wrong (spaces) */
.selector {
    property: value;
}
```

### Property Order

Organize properties logically:

```css
.element {
	/* 1. Positioning */
	position: absolute;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 100;
	
	/* 2. Display & Box Model */
	display: flex;
	flex-direction: column;
	align-items: center;
	width: 100%;
	max-width: 1200px;
	height: auto;
	margin: 0 auto;
	padding: 20px;
	
	/* 3. Typography */
	font-family: sans-serif;
	font-size: 16px;
	font-weight: 400;
	line-height: 1.5;
	text-align: left;
	color: #333;
	
	/* 4. Visual */
	background-color: #fff;
	border: 1px solid #ddd;
	border-radius: 4px;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	
	/* 5. Animation & Misc */
	transition: all 0.3s ease;
	cursor: pointer;
}
```

### Selectors

**One selector per line:**
```css
/* ✅ Correct */
.selector-one,
.selector-two,
.selector-three {
	property: value;
}

/* ❌ Wrong */
.selector-one, .selector-two, .selector-three {
	property: value;
}
```

**Opening brace on same line:**
```css
/* ✅ Correct */
.selector {
	property: value;
}

/* ❌ Wrong */
.selector
{
	property: value;
}
```

### Properties

**One property per line:**
```css
/* ✅ Correct */
.element {
	margin: 0;
	padding: 0;
	border: none;
}

/* ❌ Wrong */
.element { margin: 0; padding: 0; border: none; }
```

**Space after colon:**
```css
/* ✅ Correct */
.element {
	color: #333;
	font-size: 16px;
}

/* ❌ Wrong */
.element {
	color:#333;
	font-size:16px;
}
```

**Always end with semicolon:**
```css
/* ✅ Correct */
.element {
	color: #333;
	font-size: 16px;
}

/* ❌ Wrong (missing last semicolon) */
.element {
	color: #333;
	font-size: 16px
}
```

---

## Values

### Colors

```css
/* ✅ Lowercase hex, shorthand when possible */
.element {
	color: #333;
	background-color: #f5f5f5;
	border-color: #aabbcc;  /* Can't shorten */
}

/* ✅ RGBA for transparency */
.element {
	background-color: rgba(0, 0, 0, 0.5);
}

/* ❌ Wrong */
.element {
	color: #333333;         /* Use shorthand #333 */
	color: #FFF;            /* Lowercase #fff */
}
```

### Units

```css
/* ✅ No unit for zero */
.element {
	margin: 0;
	padding: 0;
}

/* ❌ Wrong */
.element {
	margin: 0px;
	padding: 0em;
}

/* ✅ Use relative units for accessibility */
.element {
	font-size: 1rem;        /* Relative to root */
	padding: 1em;           /* Relative to element font-size */
	max-width: 80ch;        /* Character-based for readability */
}
```

### Quotes

```css
/* ✅ Double quotes */
.element {
	font-family: "Helvetica Neue", Arial, sans-serif;
	content: "";
	background-image: url("image.png");
}

/* ✅ No quotes for generic families */
.element {
	font-family: sans-serif;
}
```

### Font Stacks

```css
/* ✅ Complete font stack with fallbacks */
.element {
	font-family: "Source Sans Pro", "Helvetica Neue", Arial, sans-serif;
}

/* System font stack */
.element {
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, 
	             Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
}
```

---

## Specificity

### Keep Specificity Low

```css
/* ✅ Low specificity - easy to override */
.card-title {
	font-size: 1.5rem;
}

/* ❌ High specificity - hard to override */
div#main .content article.post .card .card-title {
	font-size: 1.5rem;
}
```

### Avoid !important

```css
/* ❌ Avoid */
.element {
	color: red !important;
}

/* ✅ Increase specificity instead */
.component .element {
	color: red;
}
```

### Avoid IDs for Styling

```css
/* ❌ IDs have high specificity */
#header {
	background: #000;
}

/* ✅ Use classes */
.site-header {
	background: #000;
}
```

### Specificity for Overrides

```css
/* Base styles */
.button {
	background-color: #0073aa;
	color: #fff;
}

/* Contextual override - slightly higher specificity */
.admin-bar .button {
	margin-top: 32px;
}

/* State override */
.button:hover,
.button:focus {
	background-color: #005a87;
}
```

---

## Responsive Design

### Mobile-First Approach

```css
/* ✅ Base styles for mobile */
.container {
	padding: 1rem;
}

/* ✅ Enhance for larger screens */
@media (min-width: 782px) {
	.container {
		padding: 2rem;
	}
}

@media (min-width: 1200px) {
	.container {
		padding: 3rem;
		max-width: 1140px;
	}
}
```

### WordPress Breakpoints

```css
/* WordPress admin breakpoints */
@media (min-width: 600px) { }   /* Larger phones */
@media (min-width: 782px) { }   /* Tablets */
@media (min-width: 960px) { }   /* Small desktop */
@media (min-width: 1280px) { }  /* Desktop */
```

### Media Query Organization

```css
/* ✅ Group related styles together */
.navigation {
	display: none;
}

.navigation-toggle {
	display: block;
}

@media (min-width: 782px) {
	.navigation {
		display: flex;
	}
	
	.navigation-toggle {
		display: none;
	}
}
```

---

## WordPress-Specific

### Block Editor Classes

```css
/* WordPress block alignment */
.alignwide {
	max-width: var(--wp--style--global--wide-size, 1200px);
	margin-left: auto;
	margin-right: auto;
}

.alignfull {
	max-width: none;
	margin-left: calc(-50vw + 50%);
	margin-right: calc(-50vw + 50%);
	width: 100vw;
}

/* Block spacing */
.wp-block-group {
	padding: var(--wp--preset--spacing--40);
}
```

### Theme.json Aware CSS

```css
/* ✅ Use CSS custom properties from theme.json */
.element {
	color: var(--wp--preset--color--primary);
	font-size: var(--wp--preset--font-size--medium);
	padding: var(--wp--preset--spacing--20);
}

/* ✅ Provide fallbacks */
.element {
	color: var(--wp--preset--color--primary, #0073aa);
}
```

### Admin Styles

```css
/* ✅ Scope admin-only styles */
.wp-admin .my-plugin-widget {
	/* Admin-specific styles */
}

/* ✅ Use admin color scheme variables */
.my-plugin-button {
	background-color: #2271b1;  /* WordPress blue */
}

.my-plugin-button:hover {
	background-color: #135e96;
}
```

### RTL Support

```css
/* ✅ Use logical properties for RTL support */
.element {
	margin-inline-start: 1rem;  /* Left in LTR, right in RTL */
	padding-inline-end: 1rem;   /* Right in LTR, left in RTL */
	text-align: start;          /* Left in LTR, right in RTL */
}

/* ❌ Avoid directional properties when possible */
.element {
	margin-left: 1rem;          /* Always left, breaks RTL */
}

/* Or use RTL stylesheet */
/* style-rtl.css */
.element {
	margin-left: 0;
	margin-right: 1rem;
}
```

---

## Comments

### Section Comments

```css
/*--------------------------------------------------------------
>>> TABLE OF CONTENTS:
----------------------------------------------------------------
# Variables
# Base
# Components
# Utilities
--------------------------------------------------------------*/

/*--------------------------------------------------------------
# Variables
--------------------------------------------------------------*/

:root {
	--color-primary: #0073aa;
}

/*--------------------------------------------------------------
# Base
--------------------------------------------------------------*/

body {
	margin: 0;
}
```

### Inline Comments

```css
.element {
	/* Offset for fixed header */
	margin-top: 60px;
	
	/* Fallback for older browsers */
	display: block;
	display: flex;
}
```

---

## Performance

### Avoid Expensive Selectors

```css
/* ❌ Expensive - matches all elements */
* {
	box-sizing: border-box;
}

/* ✅ Better - apply to specific elements */
html {
	box-sizing: border-box;
}

*,
*::before,
*::after {
	box-sizing: inherit;
}

/* ❌ Expensive - universal attribute selector */
[class*="icon-"] {
	font-family: "Icons";
}

/* ❌ Expensive - deep nesting */
body > div > main > article > section > p {
	color: #333;
}
```

### Minimize Reflows

```css
/* ✅ Use transform/opacity for animations (GPU accelerated) */
.element {
	transition: transform 0.3s ease, opacity 0.3s ease;
}

.element:hover {
	transform: translateY(-5px);
	opacity: 0.9;
}

/* ❌ Avoid animating layout properties */
.element {
	transition: width 0.3s, height 0.3s, margin 0.3s;  /* Triggers reflow */
}
```

### Use CSS Variables

```css
/* ✅ Define once, use everywhere */
:root {
	--color-primary: #0073aa;
	--color-secondary: #23282d;
	--spacing-unit: 8px;
}

.button {
	background-color: var(--color-primary);
	padding: calc(var(--spacing-unit) * 2);
}

.link {
	color: var(--color-primary);
}
```
