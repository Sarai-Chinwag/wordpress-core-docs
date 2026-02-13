# Selective Refresh

Classes for implementing selective (partial) refresh in the Customizer preview.

---

## WP_Customize_Selective_Refresh

Core class for implementing selective refresh. Manages partial registration and handles Ajax rendering requests.

**Source:** `wp-includes/customize/class-wp-customize-selective-refresh.php`  
**Since:** 4.5.0  
**Final:** Yes  
**Attributes:** `#[AllowDynamicProperties]`

### Constants

| Constant | Value | Description |
|----------|-------|-------------|
| `RENDER_QUERY_VAR` | `'wp_customize_render_partials'` | POST query var used in partial render requests |

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$manager` | WP_Customize_Manager | public | — | 4.5.0 | Customize manager instance |
| `$partials` | WP_Customize_Partial[] | protected | `array()` | 4.5.0 | Registered partial instances |
| `$triggered_errors` | array | protected | `array()` | 4.5.0 | Log of errors during partial rendering |
| `$current_partial_id` | string\|null | protected | — | 4.5.0 | Currently-rendering partial ID |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $manager )` | public | 4.5.0 | Stores manager, requires `class-wp-customize-partial.php`, hooks `init_preview` to `customize_preview_init`. |
| `partials()` | public | 4.5.0 | Returns all registered partials. |
| `add_partial( $id, $args )` | public | 4.5.0 | Adds a partial. Accepts `WP_Customize_Partial` object or ID + args. Applies `customize_dynamic_partial_args` and `customize_dynamic_partial_class` filters when constructing from args. |
| `get_partial( $id )` | public | 4.5.0 | Returns partial by ID, or `null`. |
| `remove_partial( $id )` | public | 4.5.0 | Removes a partial by ID. |
| `init_preview()` | public | 4.5.0 | Hooks `handle_render_partials_request` to `template_redirect` and `enqueue_preview_scripts` to `wp_enqueue_scripts`. |
| `enqueue_preview_scripts()` | public | 4.5.0 | Enqueues `customize-selective-refresh` script and hooks `export_preview_data` to `wp_footer` at priority 1000. |
| `export_preview_data()` | public | 4.5.0 | Exports partials JSON, `renderQueryVar`, and localized strings to JS via inline script `_customizePartialRefreshExports`. Switches to user locale for l10n. |
| `add_dynamic_partials( $partial_ids )` | public | 4.5.0 | Registers partials dynamically. For each ID, applies `customize_dynamic_partial_args` filter (must return non-false array) and `customize_dynamic_partial_class` filter. Returns array of newly-added partials. |
| `is_render_partials_request()` | public | 4.5.0 | Returns `true` if `$_POST[RENDER_QUERY_VAR]` is set. |
| `handle_error( $errno, $errstr, $errfile, $errline )` | public | 4.5.0 | Error handler during rendering. Logs error with partial ID, number, string, file, and line. Always returns `true`. |
| `handle_render_partials_request()` | public | 4.5.0 | Main Ajax handler. Validates customize preview, decodes `$_POST['partials']` JSON, registers dynamic partials, renders each partial for its container contexts, and sends JSON response with `contents`, `errors` (if `WP_DEBUG_DISPLAY`), and `setting_validities`. |

### Hooks

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `customize_dynamic_partial_args` | filter | 4.5.0 | Filters dynamic partial constructor args. Must return non-false array for partial to be registered. |
| `customize_dynamic_partial_class` | filter | 4.5.0 | Filters the class used to construct partials. Default `'WP_Customize_Partial'`. |
| `customize_render_partials_before` | action | 4.5.0 | Fires immediately before partials are rendered. Plugins can enqueue scripts/styles here. |
| `customize_render_partials_after` | action | 4.5.0 | Fires immediately after partials are rendered. Plugins can scrape footer scripts here. |
| `customize_render_partials_response` | filter | 4.5.0 | Filters the response array. Plugins can inject `$scripts` and `$styles` dependencies. |

### Localized Strings (exported to JS)

| Key | Text |
|-----|------|
| `shiftClickToEdit` | "Shift-click to edit this element." |
| `clickEditMenu` | "Click to edit this menu." |
| `clickEditWidget` | "Click to edit this widget." |
| `clickEditTitle` | "Click to edit the site title." |
| `clickEditMisc` | "Click to edit this element." |
| `badDocumentWrite` | "document.write() is forbidden" |

---

## WP_Customize_Partial

Representation of a rendered region in the previewed page that gets selectively refreshed when an associated setting changes.

**Source:** `wp-includes/customize/class-wp-customize-partial.php`  
**Since:** 4.5.0  
**Attributes:** `#[AllowDynamicProperties]`

### Properties

| Property | Type | Visibility | Default | Since | Description |
|----------|------|-----------|---------|-------|-------------|
| `$component` | WP_Customize_Selective_Refresh | public | — | 4.5.0 | Parent selective refresh component |
| `$id` | string | public | — | 4.5.0 | Unique identifier. Typically matches the associated setting ID. |
| `$id_data` | array | protected | — | 4.5.0 | Parsed ID with `base` and `keys` for multidimensional settings |
| `$type` | string | public | `'default'` | 4.5.0 | Partial type |
| `$selector` | string | public | — | 4.5.0 | jQuery selector to find the container element |
| `$settings` | string[] | public | — | 4.5.0 | IDs for settings tied to this partial. Defaults to `[$id]`. |
| `$primary_setting` | string | public | — | 4.5.0 | ID of the primary setting. Defaults to first setting. |
| `$capability` | string | public | — | 4.5.0 | Required capability. Empty = derived from settings. |
| `$render_callback` | callable | public | — | 4.5.0 | Render callback. Called with `($partial, $container_context)`. Can echo or return string/array, or return `false` on error. Defaults to `[$this, 'render_callback']`. |
| `$container_inclusive` | bool | public | `false` | 4.5.0 | Whether the container element is included in the partial |
| `$fallback_refresh` | bool | public | `true` | 4.5.0 | Whether to do a full refresh if partial render fails |

### Methods

| Method | Visibility | Since | Description |
|--------|-----------|-------|-------------|
| `__construct( $component, $id, $args )` | public | 4.5.0 | Accepts args matching property names. Parses ID into `id_data`. Defaults `render_callback` to `$this->render_callback()`. Normalizes `$settings` to array; defaults to `[$id]`. Sets `$primary_setting` to first setting if empty. |
| `id_data()` | public final | 4.5.0 | Returns parsed `$id_data` array with `base` and `keys`. |
| `render( $container_context )` | public final | 4.5.0 | Calls `$render_callback`, captures output buffer. Warns if callback both echoes and returns. Applies `customize_partial_render` and `customize_partial_render_{$partial->id}` filters. Returns string, array, or `false`. |
| `render_callback( $partial, $context )` | public | 4.5.0 | Default callback — returns `false` (no render). Subclasses override this. |
| `json()` | public | 4.5.0 | Returns array with `settings`, `primarySetting`, `selector`, `type`, `fallbackRefresh`, `containerInclusive`. |
| `check_capabilities()` | public final | 4.5.0 | Returns `false` if user lacks `$capability` or if any associated setting fails `check_capabilities()`. |

### Hooks

| Hook | Type | Since | Description |
|------|------|-------|-------------|
| `customize_partial_render` | filter | 4.5.0 | Filters partial rendering result. Params: `$rendered`, `$partial`, `$container_context`. |
| `customize_partial_render_{$partial->id}` | filter | 4.5.0 | Filters partial rendering for a specific partial ID. Same params. |
