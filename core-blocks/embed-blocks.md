# Embed Blocks

External content embedding via oEmbed.

## core/embed

Universal embed block with provider variations.

**Attributes:**
- `url` (string) — Content URL
- `caption` (rich-text) — Embed caption
- `type` (string) — Embed type (video, rich, photo, link)
- `providerNameSlug` (string) — Provider slug
- `allowResponsive` (boolean) — Allow responsive (default: true)
- `responsive` (boolean) — Is responsive
- `previewable` (boolean) — Can preview (default: true)

**Supports:** align, className, spacing

## Embed Variations

Each variation sets the `providerNameSlug` attribute:

### Video Providers

| Variation | Provider | URL Pattern |
|-----------|----------|-------------|
| `youtube` | YouTube | youtube.com, youtu.be |
| `vimeo` | Vimeo | vimeo.com |
| `dailymotion` | Dailymotion | dailymotion.com |
| `videopress` | VideoPress | videopress.com |
| `tiktok` | TikTok | tiktok.com |
| `ted` | TED | ted.com |
| `animoto` | Animoto | animoto.com |
| `cloudup` | Cloudup | cloudup.com |
| `crowdsignal` | Crowdsignal | crowdsignal.com |

### Social Providers

| Variation | Provider | URL Pattern |
|-----------|----------|-------------|
| `twitter` | Twitter/X | twitter.com, x.com |
| `instagram` | Instagram | instagram.com |
| `facebook` | Facebook | facebook.com |
| `flickr` | Flickr | flickr.com |
| `pinterest` | Pinterest | pinterest.com |
| `reddit` | Reddit | reddit.com |
| `tumblr` | Tumblr | tumblr.com |
| `bluesky` | Bluesky | bsky.app |

### Audio Providers

| Variation | Provider | URL Pattern |
|-----------|----------|-------------|
| `spotify` | Spotify | spotify.com |
| `soundcloud` | SoundCloud | soundcloud.com |
| `mixcloud` | Mixcloud | mixcloud.com |
| `pocketcasts` | Pocket Casts | pocketcasts.com |

### Other Providers

| Variation | Provider | URL Pattern |
|-----------|----------|-------------|
| `wordpress` | WordPress.com | wordpress.com |
| `wordpress-tv` | WordPress.tv | wordpress.tv |
| `amazon-kindle` | Amazon Kindle | amazon.com |
| `issuu` | Issuu | issuu.com |
| `scribd` | Scribd | scribd.com |
| `slideshare` | SlideShare | slideshare.net |
| `speaker-deck` | Speaker Deck | speakerdeck.com |
| `kickstarter` | Kickstarter | kickstarter.com |
| `imgur` | Imgur | imgur.com |
| `wolfram-cloud` | Wolfram Cloud | wolframcloud.com |

### How Variations Work

```json
{
  "name": "youtube",
  "title": "YouTube",
  "icon": "embed-video",
  "keywords": ["video", "music"],
  "description": "Embed a YouTube video.",
  "patterns": ["https?://((m|www)\\.)?youtube\\.com/.+", "https?://youtu\\.be/.+"],
  "attributes": {
    "providerNameSlug": "youtube",
    "responsive": true
  }
}
```

The embed block detects the URL and automatically selects the appropriate variation.

## oEmbed Flow

1. User pastes URL
2. Block sends URL to `/wp-json/oembed/1.0/proxy`
3. WordPress fetches oEmbed data from provider
4. Embed HTML is cached in post meta
5. Block renders provider HTML in iframe/figure

## Responsive Embeds

Responsive embeds (videos) are wrapped:

```html
<figure class="wp-block-embed is-type-video is-provider-youtube wp-block-embed-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">
  <div class="wp-block-embed__wrapper">
    <!-- provider embed HTML -->
  </div>
  <figcaption class="wp-element-caption">Caption</figcaption>
</figure>
```

Aspect ratio classes:
- `wp-embed-aspect-21-9`
- `wp-embed-aspect-18-9`
- `wp-embed-aspect-16-9`
- `wp-embed-aspect-4-3`
- `wp-embed-aspect-1-1`
- `wp-embed-aspect-9-16`
- `wp-embed-aspect-1-2`
