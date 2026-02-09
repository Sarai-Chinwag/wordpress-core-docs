# image.php

## Overview

Core image handling helpers used by the media library and image processing workflows.

## Functions

- `wp_crop_image()` — File contains all the administration image manipulation functions.
- `wp_get_missing_image_subsizes()` — Compare the existing image sub-sizes (as saved in the attachment meta)
- `wp_update_image_subsizes()` — Filters the array of missing image sub-sizes for an uploaded image.
- `wp_create_image_subsizes()` — Creates image sub-sizes, adds the new data to the image meta `sizes` array, and updates the image metadata.
- `wp_copy_parent_attachment_properties()` — Copy parent attachment properties to newly cropped image.
- `wp_generate_attachment_metadata()` — Generates attachment meta data and create image sub-sizes for images.
- `wp_exif_frac2dec()` — Filters the parameters for the attachment thumbnail creation.
- `wp_exif_date2ts()` — Converts the exif date format to a unix timestamp.
- `wp_read_image_metadata()` — Gets extended image metadata, exif or iptc as available.
- `file_is_valid_image()` — Filters the image types to check for exif data.
- `file_is_displayable_image()` — Validates that file is suitable for displaying within a web page.
- `load_image_to_edit()` — Filters whether the current image is displayable in the browser.
