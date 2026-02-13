# NOOP_Translations

Provides the same interface as `Translations` but performs no actual translation. All lookups return the original string. Used as a stand-in when no translation file is loaded.

**Source:** `wp-includes/pomo/translations.php`
**Since:** 2.8.0

**Note:** This class does **not** extend `Translations`. It is a standalone class with the same public interface. Uses `#[AllowDynamicProperties]`.

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `$entries` | Translation_Entry[] | `array()` | Always empty |
| `$headers` | array\<string, string\> | `array()` | Always empty |

---

## Methods

All methods match the `Translations` interface but are no-ops or passthroughs:

| Method | Returns | Behavior |
|--------|---------|----------|
| `add_entry( $entry )` | `true` | No-op, always returns `true` |
| `set_header( $header, $value )` | void | No-op |
| `set_headers( $headers )` | void | No-op |
| `get_header( $header )` | `false` | Always returns `false` |
| `translate_entry( &$entry )` | `false` | Always returns `false` |
| `translate( $singular, $context = null )` | string | Returns `$singular` unchanged |
| `select_plural_form( $count )` | int | English rules: `1 === $count ? 0 : 1` |
| `get_plural_forms_count()` | int | Always returns `2` |
| `translate_plural( $singular, $plural, $count, $context = null )` | string | Returns `$singular` if count is 1, `$plural` otherwise |
| `merge_with( &$other )` | void | No-op |
