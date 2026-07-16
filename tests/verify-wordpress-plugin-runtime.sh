#!/usr/bin/env bash
set -euo pipefail

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 <wordpress-path>" >&2
  exit 2
fi

wp_path=$1
test -f "$wp_path/wp-load.php"

php -r '
require $argv[1] . "/wp-load.php";
require_once ABSPATH . "wp-admin/includes/plugin.php";
$activation = activate_plugin("wp-docs/wp-docs.php");
if (is_wp_error($activation)) { throw new RuntimeException("WP Docs activation failed: " . $activation->get_error_message()); }
do_action("init");
$post_type = get_post_type_object("wpdocs_document");
if (! $post_type || ! $post_type->show_ui || ! $post_type->show_in_rest || $post_type->public || $post_type->publicly_queryable) { throw new RuntimeException("WP Docs CPT visibility is wrong"); }
foreach (["wpdocs_collection", "wpdocs_topic"] as $taxonomy) { $object = get_taxonomy($taxonomy); if (! $object || ! $object->show_in_rest) { throw new RuntimeException("WP Docs taxonomy registration is wrong"); } }
do_action("rest_api_init");
$routes = rest_get_server()->get_routes();
foreach (["/wpdocs/v1/export", "/wp/v2/wpdocs-documents", "/wp/v2/wpdocs-collections", "/wp/v2/wpdocs-topics"] as $route) { if (! isset($routes[$route])) { throw new RuntimeException("Missing REST route: " . $route); } }
$artifact = WPDocs_Sync::export_artifact(WPDocs_Plugin::records(), "https://docs.example.com", WPDocs_Plugin::term_records());
if (! isset($artifact["manifest"]["terms"], $artifact["manifest"]["manifest_hash"])) { throw new RuntimeException("Read-only export failed"); }
echo "WP Docs runtime verification passed.\n";
' "$wp_path"
