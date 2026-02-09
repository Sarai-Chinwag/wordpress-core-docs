# WordPress HTML Coding Standards

## Document Structure

### Doctype and Language

```html
<!-- ✅ HTML5 doctype -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
```

### Required Meta Tags

```html
<head>
	<!-- Character encoding first -->
	<meta charset="UTF-8">
	
	<!-- Viewport for responsive design -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- Other meta tags -->
	<?php wp_head(); ?>
</head>
```

---

## Semantic Markup

### Use Semantic Elements

```html
<!-- ✅ Semantic structure -->
<header class="site-header">
	<nav class="main-navigation">
		<!-- Navigation -->
	</nav>
</header>

<main id="main-content">
	<article class="post">
		<header class="entry-header">
			<h1 class="entry-title">Post Title</h1>
		</header>
		
		<div class="entry-content">
			<!-- Content -->
		</div>
		
		<footer class="entry-footer">
			<!-- Meta info -->
		</footer>
	</article>
</main>

<aside class="sidebar">
	<!-- Sidebar content -->
</aside>

<footer class="site-footer">
	<!-- Footer content -->
</footer>

<!-- ❌ Non-semantic (div soup) -->
<div class="header">
	<div class="navigation">
	</div>
</div>
<div class="content">
	<div class="post">
	</div>
</div>
```

### Heading Hierarchy

```html
<!-- ✅ Proper heading order -->
<h1>Site Title or Page Title</h1>
	<h2>Section Heading</h2>
		<h3>Subsection Heading</h3>
		<h3>Another Subsection</h3>
	<h2>Next Section</h2>

<!-- ❌ Wrong - skipping levels -->
<h1>Title</h1>
<h3>Subsection</h3>  <!-- Skipped h2 -->

<!-- ❌ Wrong - multiple h1s on a page -->
<h1>Title One</h1>
<h1>Title Two</h1>
```

### Lists

```html
<!-- ✅ Unordered list for navigation -->
<nav>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/about">About</a></li>
		<li><a href="/contact">Contact</a></li>
	</ul>
</nav>

<!-- ✅ Ordered list for steps -->
<ol>
	<li>First step</li>
	<li>Second step</li>
	<li>Third step</li>
</ol>

<!-- ✅ Definition list for terms -->
<dl>
	<dt>Term</dt>
	<dd>Definition of the term</dd>
</dl>
```

---

## Formatting

### Indentation

- Use **TABS** (consistent with PHP/JS/CSS)
- Indent child elements

```html
<!-- ✅ Correct -->
<div class="container">
	<div class="row">
		<div class="column">
			<p>Content</p>
		</div>
	</div>
</div>
```

### Self-Closing Tags

```html
<!-- ✅ HTML5 style - no self-closing slash needed -->
<img src="image.jpg" alt="Description">
<br>
<hr>
<input type="text">
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">

<!-- XHTML style - also acceptable -->
<img src="image.jpg" alt="Description" />
<br />
```

### Attribute Order

Consistent attribute ordering improves readability:

```html
<a 
	class="button button-primary"
	id="submit-btn"
	href="/submit"
	title="Submit your form"
	data-action="submit"
	aria-label="Submit form"
>
	Submit
</a>
```

Recommended order:
1. `class`
2. `id`, `name`
3. `src`, `href`, `for`, `type`
4. `title`, `alt`
5. `data-*`
6. `aria-*`, `role`

### Attribute Quotes

```html
<!-- ✅ Always use double quotes -->
<div class="container" id="main">

<!-- ❌ Wrong -->
<div class=container id=main>
<div class='container' id='main'>
```

---

## WordPress Template Tags

### Theme Templates

```php
<!-- header.php -->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary">
		<?php esc_html_e( 'Skip to content', 'theme-name' ); ?>
	</a>
```

```php
<!-- footer.php -->
	<footer id="colophon" class="site-footer">
		<!-- Footer content -->
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
```

### Outputting Content

```php
<!-- ✅ Always escape output -->
<h1 class="entry-title">
	<?php echo esc_html( get_the_title() ); ?>
</h1>

<a href="<?php echo esc_url( get_permalink() ); ?>">
	<?php esc_html_e( 'Read more', 'theme-name' ); ?>
</a>

<div class="entry-content">
	<?php 
	// the_content() handles escaping internally
	the_content(); 
	?>
</div>

<!-- ✅ With allowed HTML -->
<div class="description">
	<?php echo wp_kses_post( $description ); ?>
</div>
```

---

## Forms

### Form Structure

```html
<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
	<?php wp_nonce_field( 'my_action', 'my_nonce' ); ?>
	<input type="hidden" name="action" value="my_form_handler">
	
	<div class="form-field">
		<label for="user-email">
			<?php esc_html_e( 'Email Address', 'theme-name' ); ?>
			<span class="required">*</span>
		</label>
		<input 
			type="email" 
			id="user-email" 
			name="user_email" 
			required
			aria-required="true"
		>
	</div>
	
	<div class="form-field">
		<label for="user-message">
			<?php esc_html_e( 'Message', 'theme-name' ); ?>
		</label>
		<textarea 
			id="user-message" 
			name="user_message" 
			rows="5"
		></textarea>
	</div>
	
	<button type="submit" class="button">
		<?php esc_html_e( 'Submit', 'theme-name' ); ?>
	</button>
</form>
```

### Form Accessibility

```html
<!-- ✅ Labels linked to inputs -->
<label for="username">Username</label>
<input type="text" id="username" name="username">

<!-- ✅ Fieldset for groups -->
<fieldset>
	<legend>Contact Preferences</legend>
	
	<input type="checkbox" id="pref-email" name="prefs[]" value="email">
	<label for="pref-email">Email</label>
	
	<input type="checkbox" id="pref-phone" name="prefs[]" value="phone">
	<label for="pref-phone">Phone</label>
</fieldset>

<!-- ✅ Error messages -->
<div class="form-field has-error">
	<label for="email">Email</label>
	<input 
		type="email" 
		id="email" 
		name="email"
		aria-describedby="email-error"
		aria-invalid="true"
	>
	<span id="email-error" class="error-message" role="alert">
		Please enter a valid email address.
	</span>
</div>
```

---

## Images

### Basic Images

```html
<!-- ✅ Always include alt text -->
<img src="photo.jpg" alt="Description of the image">

<!-- ✅ Decorative images - empty alt -->
<img src="decorative-border.png" alt="">

<!-- ✅ With dimensions for layout stability -->
<img 
	src="photo.jpg" 
	alt="Description" 
	width="800" 
	height="600"
	loading="lazy"
>
```

### Responsive Images

```html
<!-- ✅ srcset for different sizes -->
<img 
	src="image-800.jpg"
	srcset="image-400.jpg 400w,
	        image-800.jpg 800w,
	        image-1200.jpg 1200w"
	sizes="(max-width: 600px) 100vw,
	       (max-width: 900px) 50vw,
	       33vw"
	alt="Description"
>

<!-- ✅ picture element for art direction -->
<picture>
	<source 
		media="(min-width: 800px)" 
		srcset="hero-wide.jpg"
	>
	<source 
		media="(min-width: 400px)" 
		srcset="hero-medium.jpg"
	>
	<img src="hero-small.jpg" alt="Hero image">
</picture>
```

### WordPress Images

```php
<!-- ✅ Use wp_get_attachment_image() -->
<?php echo wp_get_attachment_image( $attachment_id, 'large', false, array(
	'class'   => 'featured-image',
	'loading' => 'lazy',
) ); ?>

<!-- ✅ Featured image -->
<?php if ( has_post_thumbnail() ) : ?>
	<figure class="post-thumbnail">
		<?php the_post_thumbnail( 'large', array(
			'alt' => the_title_attribute( array( 'echo' => false ) ),
		) ); ?>
	</figure>
<?php endif; ?>
```

---

## Links

### Link Best Practices

```html
<!-- ✅ Descriptive link text -->
<a href="/pricing">View our pricing plans</a>

<!-- ❌ Non-descriptive -->
<a href="/pricing">Click here</a>
<a href="/pricing">Read more</a>

<!-- ✅ External links -->
<a href="https://example.com" target="_blank" rel="noopener noreferrer">
	External Site
	<span class="screen-reader-text">(opens in new tab)</span>
</a>

<!-- ✅ Download links -->
<a href="/files/report.pdf" download>
	Download Report (PDF, 2MB)
</a>

<!-- ✅ Skip links for accessibility -->
<a class="skip-link screen-reader-text" href="#main-content">
	Skip to main content
</a>
```

### WordPress Links

```php
<!-- ✅ Escaped URLs -->
<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php bloginfo( 'name' ); ?>
</a>

<!-- ✅ Post links -->
<a href="<?php echo esc_url( get_permalink() ); ?>">
	<?php echo esc_html( get_the_title() ); ?>
</a>

<!-- ✅ Archive links -->
<a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
	<?php echo esc_html( $term->name ); ?>
</a>
```

---

## Tables

### Accessible Tables

```html
<table>
	<caption>Monthly Sales Report</caption>
	<thead>
		<tr>
			<th scope="col">Month</th>
			<th scope="col">Sales</th>
			<th scope="col">Revenue</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="row">January</th>
			<td>150</td>
			<td>$15,000</td>
		</tr>
		<tr>
			<th scope="row">February</th>
			<td>200</td>
			<td>$20,000</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th scope="row">Total</th>
			<td>350</td>
			<td>$35,000</td>
		</tr>
	</tfoot>
</table>
```

### Complex Tables

```html
<table>
	<caption>Quarterly Results by Region</caption>
	<thead>
		<tr>
			<th scope="col" rowspan="2">Region</th>
			<th scope="colgroup" colspan="2">Q1</th>
			<th scope="colgroup" colspan="2">Q2</th>
		</tr>
		<tr>
			<th scope="col">Sales</th>
			<th scope="col">Revenue</th>
			<th scope="col">Sales</th>
			<th scope="col">Revenue</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th scope="row">North</th>
			<td>100</td>
			<td>$10,000</td>
			<td>120</td>
			<td>$12,000</td>
		</tr>
	</tbody>
</table>
```

---

## Comments

### HTML Comments

```html
<!-- Navigation starts -->
<nav class="main-navigation">
	<!-- ... -->
</nav>
<!-- Navigation ends -->

<!-- TODO: Add search form -->

<!-- 
	Multi-line comment
	for longer explanations
-->
```

### Closing Tag Comments

```html
<!-- ✅ Helpful for deep nesting -->
<div class="wrapper">
	<div class="container">
		<div class="row">
			<div class="column">
				<!-- Content -->
			</div><!-- .column -->
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .wrapper -->
```

---

## Common Patterns

### Card Component

```html
<article class="card">
	<figure class="card__image">
		<img src="thumbnail.jpg" alt="">
	</figure>
	<div class="card__content">
		<h3 class="card__title">
			<a href="/post-url">Card Title</a>
		</h3>
		<p class="card__excerpt">
			Brief description of the content.
		</p>
		<footer class="card__meta">
			<time datetime="2024-01-15">January 15, 2024</time>
		</footer>
	</div>
</article>
```

### Modal/Dialog

```html
<div 
	id="my-modal" 
	class="modal" 
	role="dialog"
	aria-labelledby="modal-title"
	aria-describedby="modal-description"
	aria-modal="true"
	hidden
>
	<div class="modal__overlay" data-close-modal></div>
	<div class="modal__content">
		<header class="modal__header">
			<h2 id="modal-title">Modal Title</h2>
			<button 
				type="button" 
				class="modal__close"
				aria-label="Close modal"
				data-close-modal
			>
				×
			</button>
		</header>
		<div id="modal-description" class="modal__body">
			<!-- Modal content -->
		</div>
		<footer class="modal__footer">
			<button type="button" data-close-modal>Cancel</button>
			<button type="submit">Confirm</button>
		</footer>
	</div>
</div>
```

### Pagination

```html
<nav class="pagination" aria-label="Posts navigation">
	<ul class="pagination__list">
		<li class="pagination__item pagination__item--prev">
			<a href="/page/1" aria-label="Previous page">
				← Previous
			</a>
		</li>
		<li class="pagination__item">
			<a href="/page/1">1</a>
		</li>
		<li class="pagination__item pagination__item--current">
			<span aria-current="page">2</span>
		</li>
		<li class="pagination__item">
			<a href="/page/3">3</a>
		</li>
		<li class="pagination__item pagination__item--next">
			<a href="/page/3" aria-label="Next page">
				Next →
			</a>
		</li>
	</ul>
</nav>
```

---

## Validation

### HTML Validation Rules

1. **Close all tags** that require closing
2. **Proper nesting** - don't overlap tags
3. **Unique IDs** - no duplicate id attributes
4. **Required attributes** - alt for img, type for button
5. **Valid attribute values** - proper URLs, correct data types

```html
<!-- ❌ Invalid nesting -->
<p>Text <strong>bold <em>italic</strong> more</em></p>

<!-- ✅ Correct nesting -->
<p>Text <strong>bold <em>italic</em></strong> <em>more</em></p>

<!-- ❌ Block inside inline -->
<span><div>Content</div></span>

<!-- ✅ Correct -->
<div><span>Content</span></div>
```
