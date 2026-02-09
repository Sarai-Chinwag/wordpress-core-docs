# image-edit.php

## Overview

Image editor (crop/rotate/scale) helpers used by the media edit UI.

## Functions

- `wp_image_editor()` — WordPress Image Editor
- `wp_stream_image()` — Shows the settings in the Image Editor that allow selecting to edit only the thumbnail of an image.
- `wp_save_image_file()` — Filters the WP_Image_Editor instance for the image to be streamed to the browser.
- `image_edit_apply_changes()` — Performs group of changes on Editor specified.
- `stream_preview_image()` — Filters the WP_Image_Editor instance before applying changes to the image.
- `wp_restore_image()` — Restores the metadata for a given attachment.
- `wp_save_image()` — Saves image to post, along with enqueued changes
