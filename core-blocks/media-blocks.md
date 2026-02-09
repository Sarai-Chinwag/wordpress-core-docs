# Media Blocks

Image, video, audio, and file blocks.

## core/image

Single image with optional caption.

**Attributes:**
- `id` (integer) — Attachment ID
- `url` (string) — Image URL
- `alt` (string) — Alt text
- `caption` (rich-text) — Caption
- `title` (string) — Title attribute
- `href` (string) — Link URL
- `rel` (string) — Link rel attribute
- `linkClass` (string) — Link CSS class
- `linkDestination` (string) — Link destination (none, media, attachment, custom)
- `linkTarget` (string) — Link target
- `width` (string) — Width
- `height` (string) — Height
- `aspectRatio` (string) — Aspect ratio
- `scale` (string) — Scale (cover, contain)
- `sizeSlug` (string) — Image size (thumbnail, medium, large, full)
- `lightbox` (object) — Lightbox settings

**Supports:** align, anchor, className, color, filter, spacing, shadow

**Styles:** default, rounded

---

## core/gallery

Image gallery with multiple images.

**Attributes:**
- `images` (array) — Deprecated: image data
- `ids` (array) — Attachment IDs
- `shortCodeTransforms` (array) — Shortcode data
- `columns` (integer) — Number of columns (default: 3)
- `caption` (rich-text) — Gallery caption
- `imageCrop` (boolean) — Crop images to fit
- `randomOrder` (boolean) — Random order
- `fixedHeight` (boolean) — Fixed height
- `linkTarget` (string) — Link target
- `linkTo` (string) — Link destination (none, media, attachment)
- `sizeSlug` (string) — Image size
- `allowResize` (boolean) — Allow resize

**Supports:** align, anchor, className, color, spacing, layout, units

---

## core/video

Self-hosted video.

**Attributes:**
- `id` (integer) — Attachment ID
- `src` (string) — Video URL
- `caption` (rich-text) — Caption
- `poster` (string) — Poster image URL
- `autoplay` (boolean) — Autoplay
- `controls` (boolean) — Show controls (default: true)
- `loop` (boolean) — Loop playback
- `muted` (boolean) — Muted
- `playsInline` (boolean) — Plays inline
- `preload` (string) — Preload (auto, metadata, none)
- `tracks` (array) — Subtitle tracks

**Supports:** align, anchor, className, color, spacing

---

## core/audio

Self-hosted audio.

**Attributes:**
- `id` (integer) — Attachment ID
- `src` (string) — Audio URL
- `caption` (rich-text) — Caption
- `autoplay` (boolean) — Autoplay
- `loop` (boolean) — Loop
- `preload` (string) — Preload

**Supports:** align, anchor, className, color, spacing

---

## core/cover

Image/video with text overlay.

**Attributes:**
- `id` (integer) — Media ID
- `url` (string) — Media URL
- `useFeaturedImage` (boolean) — Use post featured image
- `alt` (string) — Alt text
- `hasParallax` (boolean) — Fixed background
- `isRepeated` (boolean) — Repeated background
- `dimRatio` (integer) — Overlay opacity (0-100, default: 100)
- `overlayColor` (string) — Overlay color slug
- `customOverlayColor` (string) — Custom overlay color
- `backgroundType` (string) — Background type (image, video)
- `focalPoint` (object) — Focal point {x, y}
- `minHeight` (number) — Minimum height
- `minHeightUnit` (string) — Height unit
- `contentPosition` (string) — Content position
- `isDark` (boolean) — Dark background
- `allowedBlocks` (array) — Allowed inner blocks
- `templateLock` (string/boolean) — Template lock

**Supports:** align, anchor, className, color, spacing, layout, dimensions

---

## core/file

Downloadable file with optional embed.

**Attributes:**
- `id` (integer) — Attachment ID
- `href` (string) — File URL
- `fileId` (string) — Unique ID
- `fileName` (rich-text) — Display name
- `textLinkHref` (string) — Link URL
- `textLinkTarget` (string) — Link target
- `showDownloadButton` (boolean) — Show download button
- `downloadButtonText` (rich-text) — Button text
- `displayPreview` (boolean) — Show inline preview
- `previewHeight` (number) — Preview height

**Supports:** align, anchor, className, color, spacing

---

## core/media-text

Two-column media and text layout.

**Attributes:**
- `mediaId` (integer) — Media ID
- `mediaUrl` (string) — Media URL
- `mediaLink` (string) — Media link
- `linkDestination` (string) — Link destination
- `linkTarget` (string) — Link target
- `linkClass` (string) — Link class
- `rel` (string) — Link rel
- `mediaAlt` (string) — Alt text
- `mediaPosition` (string) — Media position (left, right)
- `mediaType` (string) — Media type (image, video)
- `mediaWidth` (number) — Media width % (default: 50)
- `mediaSizeSlug` (string) — Image size
- `isStackedOnMobile` (boolean) — Stack on mobile (default: true)
- `verticalAlignment` (string) — Vertical align
- `imageFill` (boolean) — Fill container
- `focalPoint` (object) — Focal point
- `allowedBlocks` (array) — Allowed inner blocks

**Supports:** align, anchor, className, color, spacing, typography
