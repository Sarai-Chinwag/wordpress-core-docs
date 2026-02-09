# Patterns

Complete reference for `patterns` in theme.json.

## Overview

The `patterns` array registers block patterns that are bundled with or referenced by your theme.

```json
{
  "patterns": [
    "theme-slug/hero-section",
    "theme-slug/cta-newsletter",
    "theme-slug/testimonials"
  ]
}
```

## Pattern Registration Methods

### Method 1: Pattern Directory (Automatic)

Create PHP files in the `patterns/` directory:

```
theme-root/
├── theme.json
├── patterns/
│   ├── hero.php
│   ├── cta-newsletter.php
│   └── testimonials.php
└── ...
```

WordPress automatically registers patterns from this directory. **No theme.json entry needed.**

### Method 2: Remote Patterns (theme.json)

Reference patterns from the WordPress.org Pattern Directory:

```json
{
  "patterns": [
    "developer-slug/pattern-slug"
  ]
}
```

The pattern must exist in the [WordPress Pattern Directory](https://wordpress.org/patterns/).

### Method 3: PHP Registration

Register patterns in `functions.php`:

```php
register_block_pattern(
    'theme-slug/hero-section',
    array(
        'title'       => __( 'Hero Section', 'theme-slug' ),
        'description' => __( 'A hero section with heading and CTA.', 'theme-slug' ),
        'categories'  => array( 'featured', 'banner' ),
        'keywords'    => array( 'hero', 'header', 'cta' ),
        'content'     => '<!-- wp:group -->...',
    )
);
```

## Pattern File Structure

### Basic Pattern File

`patterns/hero.php`:

```php
<?php
/**
 * Title: Hero Section
 * Slug: theme-slug/hero
 * Categories: featured, banner
 * Keywords: hero, header, call to action
 * Description: A large hero section with heading, text, and call-to-action buttons.
 * Viewport Width: 1400
 */
?>

<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-bg.jpg' ) ); ?>","dimRatio":50,"overlayColor":"black","minHeight":80,"minHeightUnit":"vh","align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull" style="min-height:80vh">
  <span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background-dim-50 has-background-dim"></span>
  <img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-bg.jpg' ) ); ?>" data-object-fit="cover"/>
  <div class="wp-block-cover__inner-container">
  
    <!-- wp:heading {"textAlign":"center","level":1,"style":{"typography":{"fontSize":"clamp(3rem, 6vw, 5rem)"}}} -->
    <h1 class="wp-block-heading has-text-align-center" style="font-size:clamp(3rem, 6vw, 5rem)">
      <?php esc_html_e( 'Welcome to Our Site', 'theme-slug' ); ?>
    </h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center","fontSize":"large"} -->
    <p class="has-text-align-center has-large-font-size">
      <?php esc_html_e( 'Discover amazing content and join our community.', 'theme-slug' ); ?>
    </p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
      <!-- wp:button {"backgroundColor":"primary"} -->
      <div class="wp-block-button">
        <a class="wp-block-button__link has-primary-background-color has-background wp-element-button">
          <?php esc_html_e( 'Get Started', 'theme-slug' ); ?>
        </a>
      </div>
      <!-- /wp:button -->
      <!-- wp:button {"className":"is-style-outline"} -->
      <div class="wp-block-button is-style-outline">
        <a class="wp-block-button__link wp-element-button">
          <?php esc_html_e( 'Learn More', 'theme-slug' ); ?>
        </a>
      </div>
      <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->

  </div>
</div>
<!-- /wp:cover -->
```

## Pattern Header Properties

| Property | Required | Description |
|----------|----------|-------------|
| `Title` | Yes | Display name in inserter |
| `Slug` | Yes | Unique identifier (`theme-slug/pattern-name`) |
| `Categories` | No | Comma-separated category slugs |
| `Keywords` | No | Comma-separated search keywords |
| `Description` | No | Description shown in inserter |
| `Viewport Width` | No | Preview width in pixels |
| `Block Types` | No | Block types this pattern is suggested for |
| `Post Types` | No | Post types where pattern is available |
| `Inserter` | No | `true`/`false` - whether to show in inserter |
| `Template Types` | No | Template types where pattern is available |

### Advanced Header Example

```php
<?php
/**
 * Title: Feature Grid
 * Slug: theme-slug/feature-grid
 * Categories: featured, services
 * Keywords: features, services, grid, icons
 * Description: A three-column grid showcasing features or services.
 * Viewport Width: 1200
 * Block Types: core/group
 * Post Types: page, landing-page
 * Inserter: true
 */
?>
```

## Pattern Categories

### Default Categories

| Slug | Name |
|------|------|
| `featured` | Featured |
| `about` | About |
| `banner` | Banner |
| `buttons` | Buttons |
| `call-to-action` | Call to Action |
| `columns` | Columns |
| `contact` | Contact |
| `footer` | Footers |
| `gallery` | Gallery |
| `header` | Headers |
| `media` | Media |
| `portfolio` | Portfolio |
| `posts` | Posts |
| `query` | Query |
| `services` | Services |
| `team` | Team |
| `testimonials` | Testimonials |
| `text` | Text |

### Register Custom Category

```php
register_block_pattern_category(
    'theme-slug-category',
    array(
        'label'       => __( 'Theme Category', 'theme-slug' ),
        'description' => __( 'Custom patterns for this theme.', 'theme-slug' ),
    )
);
```

## Pattern Content Examples

### Call to Action

`patterns/cta-newsletter.php`:

```php
<?php
/**
 * Title: Newsletter CTA
 * Slug: theme-slug/cta-newsletter
 * Categories: call-to-action, featured
 * Keywords: newsletter, email, subscribe, cta
 */
?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"backgroundColor":"primary","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

  <!-- wp:heading {"textAlign":"center","textColor":"white"} -->
  <h2 class="wp-block-heading has-text-align-center has-white-color has-text-color">
    <?php esc_html_e( 'Stay Updated', 'theme-slug' ); ?>
  </h2>
  <!-- /wp:heading -->

  <!-- wp:paragraph {"align":"center","textColor":"white"} -->
  <p class="has-text-align-center has-white-color has-text-color">
    <?php esc_html_e( 'Subscribe to our newsletter for the latest updates.', 'theme-slug' ); ?>
  </p>
  <!-- /wp:paragraph -->

  <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
  <div class="wp-block-buttons">
    <!-- wp:button {"backgroundColor":"white","textColor":"primary"} -->
    <div class="wp-block-button">
      <a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button">
        <?php esc_html_e( 'Subscribe Now', 'theme-slug' ); ?>
      </a>
    </div>
    <!-- /wp:button -->
  </div>
  <!-- /wp:buttons -->

</div>
<!-- /wp:group -->
```

### Testimonials

`patterns/testimonials.php`:

```php
<?php
/**
 * Title: Testimonials
 * Slug: theme-slug/testimonials
 * Categories: testimonials, featured
 * Keywords: testimonials, reviews, quotes, clients
 */
?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">

  <!-- wp:heading {"textAlign":"center"} -->
  <h2 class="wp-block-heading has-text-align-center">
    <?php esc_html_e( 'What Our Clients Say', 'theme-slug' ); ?>
  </h2>
  <!-- /wp:heading -->

  <!-- wp:columns {"align":"wide"} -->
  <div class="wp-block-columns alignwide">
  
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:quote -->
      <blockquote class="wp-block-quote">
        <p><?php esc_html_e( 'Amazing service! Highly recommend to everyone.', 'theme-slug' ); ?></p>
        <cite><?php esc_html_e( '— Sarah Johnson', 'theme-slug' ); ?></cite>
      </blockquote>
      <!-- /wp:quote -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:quote -->
      <blockquote class="wp-block-quote">
        <p><?php esc_html_e( 'Professional and responsive. A pleasure to work with.', 'theme-slug' ); ?></p>
        <cite><?php esc_html_e( '— Mike Chen', 'theme-slug' ); ?></cite>
      </blockquote>
      <!-- /wp:quote -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:quote -->
      <blockquote class="wp-block-quote">
        <p><?php esc_html_e( 'Exceeded all our expectations. Thank you!', 'theme-slug' ); ?></p>
        <cite><?php esc_html_e( '— Emily Davis', 'theme-slug' ); ?></cite>
      </blockquote>
      <!-- /wp:quote -->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->

</div>
<!-- /wp:group -->
```

### Feature Grid

`patterns/feature-grid.php`:

```php
<?php
/**
 * Title: Feature Grid
 * Slug: theme-slug/feature-grid
 * Categories: services, featured
 * Keywords: features, services, grid, icons
 */
?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">

  <!-- wp:heading {"textAlign":"center"} -->
  <h2 class="wp-block-heading has-text-align-center">
    <?php esc_html_e( 'Our Features', 'theme-slug' ); ?>
  </h2>
  <!-- /wp:heading -->

  <!-- wp:columns {"align":"wide"} -->
  <div class="wp-block-columns alignwide">
  
    <!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
    <div class="wp-block-column" style="padding:var(--wp--preset--spacing--50)">
      <!-- wp:heading {"level":3,"fontSize":"large"} -->
      <h3 class="wp-block-heading has-large-font-size">⚡ Fast</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p><?php esc_html_e( 'Lightning-fast performance optimized for speed.', 'theme-slug' ); ?></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
    <div class="wp-block-column" style="padding:var(--wp--preset--spacing--50)">
      <!-- wp:heading {"level":3,"fontSize":"large"} -->
      <h3 class="wp-block-heading has-large-font-size">🔒 Secure</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p><?php esc_html_e( 'Enterprise-grade security to protect your data.', 'theme-slug' ); ?></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

    <!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50"}}}} -->
    <div class="wp-block-column" style="padding:var(--wp--preset--spacing--50)">
      <!-- wp:heading {"level":3,"fontSize":"large"} -->
      <h3 class="wp-block-heading has-large-font-size">🎨 Beautiful</h3>
      <!-- /wp:heading -->
      <!-- wp:paragraph -->
      <p><?php esc_html_e( 'Stunning designs that look great everywhere.', 'theme-slug' ); ?></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->

  </div>
  <!-- /wp:columns -->

</div>
<!-- /wp:group -->
```

## Using Theme Assets in Patterns

### Images

```php
<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large">
  <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/example.jpg' ) ); ?>" alt=""/>
</figure>
<!-- /wp:image -->
```

### Cover Backgrounds

```php
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.jpg' ) ); ?>"} -->
```

### Placeholders

Use placeholder images for patterns:

```php
<!-- wp:image -->
<figure class="wp-block-image">
  <img src="<?php echo esc_url( 'https://images.unsplash.com/photo-example?w=800' ); ?>" alt=""/>
</figure>
<!-- /wp:image -->
```

Or use local placeholders:

```php
<?php echo esc_url( get_theme_file_uri( 'assets/images/placeholder-16x9.svg' ) ); ?>
```

## theme.json patterns Array

The `patterns` array in theme.json serves two purposes:

### 1. Reference Remote Patterns

```json
{
  "patterns": [
    "developer/pattern-from-wp-org"
  ]
}
```

Pulls patterns from WordPress.org Pattern Directory.

### 2. Disable Core Patterns

To opt out of core patterns while keeping only your theme's:

```json
{
  "patterns": []
}
```

Combined with removing core patterns in PHP:

```php
remove_theme_support( 'core-block-patterns' );
```

## Complete theme.json Example

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 3,
  "patterns": [
    "developer/featured-hero-pattern",
    "developer/cta-pattern"
  ]
}
```

Combined with local patterns in `patterns/` directory (auto-registered).

## Pattern for Specific Templates

Make patterns available only for certain template types:

```php
<?php
/**
 * Title: Page Header
 * Slug: theme-slug/page-header
 * Categories: header
 * Template Types: page, single
 */
?>
```

## Hidden Patterns (Not in Inserter)

Create patterns for internal use (e.g., template composition):

```php
<?php
/**
 * Title: Internal Hero
 * Slug: theme-slug/internal-hero
 * Inserter: false
 */
?>
```

These patterns can be used in templates but won't appear in the pattern inserter.

## Block Type Suggestions

Suggest patterns when inserting specific block types:

```php
<?php
/**
 * Title: Gallery Grid
 * Slug: theme-slug/gallery-grid
 * Categories: gallery
 * Block Types: core/gallery, core/image
 */
?>
```

When users insert a Gallery or Image block, this pattern appears as a suggestion.

## Synced Patterns (Reusable Blocks)

Synced patterns (formerly reusable blocks) are created by users and stored in the database. They're not defined in theme.json.

Theme patterns are always independent copies when inserted.
