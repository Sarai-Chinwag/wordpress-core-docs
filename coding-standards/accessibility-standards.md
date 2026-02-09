# WordPress Accessibility Standards

WordPress follows **WCAG 2.1 Level AA** guidelines. Accessibility is not optional.

## Core Principles (POUR)

1. **Perceivable** - Information must be presentable to users
2. **Operable** - Interface must be usable by all
3. **Understandable** - Content must be readable and predictable
4. **Robust** - Content must work with assistive technologies

---

## Semantic Structure

### Landmarks

```html
<!-- ✅ Use ARIA landmarks or HTML5 elements -->
<header role="banner">
	<nav role="navigation" aria-label="Main navigation">
		<!-- Navigation -->
	</nav>
</header>

<main role="main" id="main-content">
	<article>
		<!-- Primary content -->
	</article>
</main>

<aside role="complementary">
	<!-- Sidebar -->
</aside>

<footer role="contentinfo">
	<!-- Footer -->
</footer>
```

### Heading Structure

```html
<!-- ✅ Logical heading hierarchy - one h1 per page -->
<h1>Page Title</h1>
	<h2>Section</h2>
		<h3>Subsection</h3>
		<h3>Subsection</h3>
	<h2>Section</h2>
		<h3>Subsection</h3>

<!-- ❌ Never skip levels -->
<h1>Title</h1>
<h3>Subsection</h3>  <!-- Missing h2! -->

<!-- ❌ Never use headings for styling -->
<h4>This text should be bold</h4>  <!-- Use CSS instead -->
```

---

## Keyboard Navigation

### Focus Management

```css
/* ✅ NEVER remove focus outlines without replacement */
/* ❌ Breaks accessibility */
:focus {
	outline: none;
}

/* ✅ Custom focus styles */
:focus {
	outline: 2px solid #0073aa;
	outline-offset: 2px;
}

/* ✅ Focus-visible for keyboard only */
:focus:not(:focus-visible) {
	outline: none;
}

:focus-visible {
	outline: 2px solid #0073aa;
	outline-offset: 2px;
}
```

### Skip Links

```html
<!-- ✅ First element after body open -->
<body>
	<a class="skip-link screen-reader-text" href="#main-content">
		Skip to main content
	</a>
	
	<header><!-- ... --></header>
	
	<main id="main-content">
		<!-- Content -->
	</main>
</body>
```

```css
.skip-link {
	position: absolute;
	top: -40px;
	left: 0;
	background: #000;
	color: #fff;
	padding: 8px;
	z-index: 100000;
}

.skip-link:focus {
	top: 0;
}
```

### Tab Order

```html
<!-- ✅ Natural tab order follows DOM -->
<button>First</button>
<button>Second</button>
<button>Third</button>

<!-- ❌ Avoid positive tabindex -->
<button tabindex="3">Third</button>
<button tabindex="1">First</button>
<button tabindex="2">Second</button>

<!-- ✅ Use tabindex="0" to make non-interactive elements focusable -->
<div role="button" tabindex="0">Custom Button</div>

<!-- ✅ Use tabindex="-1" for programmatic focus only -->
<div id="modal" tabindex="-1">
	<!-- Modal content - can receive focus via JS -->
</div>
```

### Keyboard Handlers

```javascript
// ✅ Handle both click and keyboard
element.addEventListener( 'click', handleAction );
element.addEventListener( 'keydown', function( e ) {
	// Enter or Space activates buttons
	if ( e.key === 'Enter' || e.key === ' ' ) {
		e.preventDefault();
		handleAction();
	}
} );

// ✅ Escape closes modals
document.addEventListener( 'keydown', function( e ) {
	if ( e.key === 'Escape' && modalIsOpen ) {
		closeModal();
	}
} );
```

---

## Images and Media

### Alternative Text

```html
<!-- ✅ Informative images need descriptive alt -->
<img src="chart.png" alt="Sales increased 50% from Q1 to Q2">

<!-- ✅ Decorative images use empty alt -->
<img src="decorative-divider.png" alt="">

<!-- ✅ Linked images describe the destination -->
<a href="/products">
	<img src="product.jpg" alt="View our product catalog">
</a>

<!-- ✅ Complex images need longer descriptions -->
<figure>
	<img src="infographic.png" alt="Infographic about climate change">
	<figcaption>
		Detailed description of the infographic content...
	</figcaption>
</figure>

<!-- Or use aria-describedby -->
<img 
	src="complex-chart.png" 
	alt="Quarterly revenue chart"
	aria-describedby="chart-description"
>
<div id="chart-description" class="screen-reader-text">
	Q1: $100,000, Q2: $150,000, Q3: $200,000, Q4: $175,000
</div>
```

### Video and Audio

```html
<!-- ✅ Captions for video -->
<video controls>
	<source src="video.mp4" type="video/mp4">
	<track 
		kind="captions" 
		src="captions.vtt" 
		srclang="en" 
		label="English"
	>
</video>

<!-- ✅ Transcript for audio -->
<audio controls>
	<source src="podcast.mp3" type="audio/mpeg">
</audio>
<details>
	<summary>View transcript</summary>
	<p>Full transcript of the audio content...</p>
</details>
```

---

## Forms

### Labels

```html
<!-- ✅ Explicit label association -->
<label for="email">Email Address</label>
<input type="email" id="email" name="email">

<!-- ✅ Implicit label (wrapping) -->
<label>
	Email Address
	<input type="email" name="email">
</label>

<!-- ❌ No label association -->
<span>Email:</span>
<input type="email" name="email">
```

### Required Fields

```html
<!-- ✅ Indicate required fields -->
<label for="name">
	Name <span class="required" aria-hidden="true">*</span>
	<span class="screen-reader-text">(required)</span>
</label>
<input 
	type="text" 
	id="name" 
	name="name"
	required
	aria-required="true"
>

<!-- ✅ Legend for required indicator -->
<p class="form-note">
	Fields marked with <span aria-hidden="true">*</span> are required.
</p>
```

### Error Handling

```html
<!-- ✅ Error messages linked to inputs -->
<div class="form-field has-error">
	<label for="email">Email</label>
	<input 
		type="email" 
		id="email" 
		name="email"
		aria-invalid="true"
		aria-describedby="email-error"
	>
	<span id="email-error" class="error-message" role="alert">
		Please enter a valid email address.
	</span>
</div>
```

```javascript
// ✅ Announce errors to screen readers
function showError( inputId, message ) {
	const input = document.getElementById( inputId );
	const errorId = inputId + '-error';
	
	// Create or update error message
	let error = document.getElementById( errorId );
	if ( ! error ) {
		error = document.createElement( 'span' );
		error.id = errorId;
		error.className = 'error-message';
		error.setAttribute( 'role', 'alert' );
		input.parentNode.appendChild( error );
	}
	
	error.textContent = message;
	input.setAttribute( 'aria-invalid', 'true' );
	input.setAttribute( 'aria-describedby', errorId );
}
```

### Fieldsets for Groups

```html
<!-- ✅ Group related inputs -->
<fieldset>
	<legend>Shipping Address</legend>
	
	<label for="street">Street</label>
	<input type="text" id="street" name="street">
	
	<label for="city">City</label>
	<input type="text" id="city" name="city">
</fieldset>

<!-- ✅ Radio/checkbox groups -->
<fieldset>
	<legend>Preferred contact method</legend>
	
	<input type="radio" id="contact-email" name="contact" value="email">
	<label for="contact-email">Email</label>
	
	<input type="radio" id="contact-phone" name="contact" value="phone">
	<label for="contact-phone">Phone</label>
</fieldset>
```

---

## ARIA

### When to Use ARIA

```html
<!-- ✅ ARIA for custom widgets -->
<div 
	role="tablist" 
	aria-label="Product information"
>
	<button 
		role="tab" 
		aria-selected="true" 
		aria-controls="panel-1"
		id="tab-1"
	>
		Description
	</button>
	<button 
		role="tab" 
		aria-selected="false" 
		aria-controls="panel-2"
		id="tab-2"
	>
		Reviews
	</button>
</div>

<div 
	role="tabpanel" 
	id="panel-1" 
	aria-labelledby="tab-1"
>
	<!-- Description content -->
</div>

<!-- ❌ Don't use ARIA when HTML suffices -->
<button role="button">Submit</button>  <!-- Redundant -->
<a role="link" href="/">Home</a>  <!-- Redundant -->
```

### Common ARIA Patterns

```html
<!-- Live regions for dynamic content -->
<div aria-live="polite" aria-atomic="true">
	<!-- Content updates announced to screen readers -->
	<p>3 items in cart</p>
</div>

<!-- Assertive for important announcements -->
<div role="alert" aria-live="assertive">
	Error: Form submission failed.
</div>

<!-- Expanded/collapsed state -->
<button 
	aria-expanded="false" 
	aria-controls="menu"
>
	Menu
</button>
<ul id="menu" hidden>
	<li><a href="/">Home</a></li>
</ul>

<!-- Current page in navigation -->
<nav aria-label="Main">
	<ul>
		<li><a href="/" aria-current="page">Home</a></li>
		<li><a href="/about">About</a></li>
	</ul>
</nav>

<!-- Busy state for loading -->
<div aria-busy="true" aria-live="polite">
	Loading results...
</div>
```

### ARIA Labels

```html
<!-- aria-label for elements without visible text -->
<button aria-label="Close modal">×</button>
<button aria-label="Search"><svg>...</svg></button>

<!-- aria-labelledby references visible element -->
<dialog aria-labelledby="dialog-title">
	<h2 id="dialog-title">Confirm Deletion</h2>
	<!-- ... -->
</dialog>

<!-- aria-describedby for additional context -->
<input 
	type="password" 
	aria-describedby="password-hint"
>
<p id="password-hint">
	Must be at least 8 characters with one number.
</p>
```

---

## Color and Contrast

### Contrast Requirements

```css
/* ✅ WCAG AA requirements */
/* Normal text: 4.5:1 contrast ratio */
/* Large text (18px+ or 14px+ bold): 3:1 ratio */

/* ✅ Good contrast */
.text-normal {
	color: #333333;      /* Dark gray on white: ~12.6:1 */
	background: #ffffff;
}

.text-large {
	color: #767676;      /* Gray on white: ~4.5:1 */
	background: #ffffff;
	font-size: 18px;
}

/* ❌ Poor contrast */
.text-low-contrast {
	color: #999999;      /* Light gray on white: ~2.8:1 */
	background: #ffffff;
}
```

### Don't Rely on Color Alone

```html
<!-- ❌ Color only indicates error -->
<input type="text" class="error">  <!-- Red border only -->

<!-- ✅ Color + icon + text -->
<div class="form-field has-error">
	<input 
		type="text" 
		aria-invalid="true"
		aria-describedby="field-error"
	>
	<span id="field-error" class="error-message">
		<svg aria-hidden="true"><!-- Error icon --></svg>
		This field is required.
	</span>
</div>

<!-- ❌ Color-coded status only -->
<span class="status status-success"></span>  <!-- Green dot -->

<!-- ✅ Color + text -->
<span class="status status-success">
	<svg aria-hidden="true"><!-- Checkmark --></svg>
	Published
</span>
```

---

## WordPress-Specific

### Screen Reader Text

```css
/* WordPress standard screen reader text class */
.screen-reader-text {
	border: 0;
	clip: rect(1px, 1px, 1px, 1px);
	clip-path: inset(50%);
	height: 1px;
	margin: -1px;
	overflow: hidden;
	padding: 0;
	position: absolute;
	width: 1px;
	word-wrap: normal !important;
}

.screen-reader-text:focus {
	background-color: #f1f1f1;
	clip: auto !important;
	clip-path: none;
	color: #21759b;
	display: block;
	font-size: 0.875rem;
	font-weight: 600;
	height: auto;
	left: 5px;
	line-height: normal;
	padding: 15px 23px 14px;
	text-decoration: none;
	top: 5px;
	width: auto;
	z-index: 100000;
}
```

### WordPress Functions

```php
// ✅ Screen reader text helper
function theme_name_screen_reader_text( $text ) {
	return '<span class="screen-reader-text">' . esc_html( $text ) . '</span>';
}

// ✅ Read more links with context
the_content( sprintf(
	wp_kses(
		__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'theme-name' ),
		array( 'span' => array( 'class' => array() ) )
	),
	get_the_title()
) );

// ✅ Pagination with context
the_posts_pagination( array(
	'mid_size'           => 2,
	'prev_text'          => sprintf(
		'%s <span class="screen-reader-text">%s</span>',
		'←',
		__( 'Previous page', 'theme-name' )
	),
	'next_text'          => sprintf(
		'<span class="screen-reader-text">%s</span> %s',
		__( 'Next page', 'theme-name' ),
		'→'
	),
	'screen_reader_text' => __( 'Posts navigation', 'theme-name' ),
) );
```

### Comment Form Accessibility

```php
// ✅ Accessible comment form args
$comments_args = array(
	'fields' => array(
		'author' => sprintf(
			'<p class="comment-form-author"><label for="author">%s%s</label><input id="author" name="author" type="text" value="%s" size="30" maxlength="245" required aria-required="true"></p>',
			__( 'Name', 'theme-name' ),
			'<span class="required">*</span>',
			esc_attr( $commenter['comment_author'] )
		),
		'email' => sprintf(
			'<p class="comment-form-email"><label for="email">%s%s</label><input id="email" name="email" type="email" value="%s" size="30" maxlength="100" required aria-required="true"></p>',
			__( 'Email', 'theme-name' ),
			'<span class="required">*</span>',
			esc_attr( $commenter['comment_author_email'] )
		),
	),
);
```

---

## Testing Checklist

### Automated Testing

- [ ] Run axe-core or WAVE browser extensions
- [ ] Check HTML validation
- [ ] Test color contrast with tools
- [ ] Run Pa11y or Lighthouse accessibility audits

### Manual Testing

- [ ] **Keyboard navigation** - Tab through entire page
- [ ] **Screen reader** - Test with NVDA, VoiceOver, or JAWS
- [ ] **Zoom** - Test at 200% and 400% zoom
- [ ] **Color blindness** - Test with color blindness simulators
- [ ] **Reduced motion** - Test with prefers-reduced-motion

### WordPress Testing Commands

```bash
# Install accessibility checker
npm install -g pa11y

# Test a page
pa11y https://example.com

# Test with specific standard
pa11y --standard WCAG2AA https://example.com
```

---

## Common Violations

### Most Frequent Issues

1. **Missing alt text** on images
2. **Low color contrast** 
3. **Missing form labels**
4. **Empty links** or buttons
5. **Missing skip links**
6. **Non-descriptive link text** ("click here")
7. **Keyboard traps** (can't escape modals)
8. **Missing focus indicators**
9. **Auto-playing media**
10. **Missing page titles**

### Quick Fixes

```php
// ✅ Add alt text to post thumbnails
the_post_thumbnail( 'large', array(
	'alt' => get_the_title(),
) );

// ✅ Descriptive read more links
echo '<a href="' . esc_url( get_permalink() ) . '">';
echo sprintf(
	/* translators: %s: Post title */
	esc_html__( 'Read more about %s', 'theme-name' ),
	get_the_title()
);
echo '</a>';

// ✅ Screen reader text for icons
echo '<button type="button" class="menu-toggle">';
echo '<span class="screen-reader-text">' . esc_html__( 'Menu', 'theme-name' ) . '</span>';
echo '<span class="icon-hamburger" aria-hidden="true"></span>';
echo '</button>';
```
