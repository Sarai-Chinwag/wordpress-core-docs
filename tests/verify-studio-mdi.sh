#!/usr/bin/env bash
# Verify the optional local WordPress Studio/MDI authoring loop. This never
# starts a site or contacts one; WP-CLI boots the explicitly supplied site.
set -euo pipefail

usage() {
  cat <<'EOF'
Usage: bash tests/verify-studio-mdi.sh --site-dir /path/to/wordpress [--mutate]

Options:
  --site-dir DIR  WordPress Studio site directory (or set WP_DOCS_STUDIO_SITE_DIR).
  --mutate        Opt in to the reversible WordPress <-> Markdown round trip.
EOF
}

site_dir=${WP_DOCS_STUDIO_SITE_DIR:-}
mutate=0
while (($#)); do
  case "$1" in
    --site-dir) site_dir=${2:?--site-dir requires a directory}; shift 2 ;;
    --mutate) mutate=1; shift ;;
    --help|-h) usage; exit 0 ;;
    *) printf 'Unknown option: %s\n' "$1" >&2; usage >&2; exit 2 ;;
  esac
done

[[ -n "$site_dir" ]] || { printf 'Provide --site-dir or WP_DOCS_STUDIO_SITE_DIR.\n' >&2; exit 2; }
[[ -d "$site_dir" ]] || { printf 'Studio site directory does not exist: %s\n' "$site_dir" >&2; exit 2; }

repo_root=$(git rev-parse --show-toplevel)
runtime_root=$(cd "$repo_root/content/runtime" && pwd -P)
site_dir=$(cd "$site_dir" && pwd -P)
fixture_rel='documentation/agent-skills.md'
fixture_git_rel="content/runtime/$fixture_rel"
fixture="$runtime_root/$fixture_rel"
wordpress_marker='WP Docs Studio verification marker: WordPress write'
markdown_marker='WP Docs Studio verification marker: external Markdown write'

if command -v studio >/dev/null; then
  wp_cmd=(studio wp --path "$site_dir")
elif command -v wp >/dev/null; then
  wp_cmd=(wp --path="$site_dir")
else
  printf 'Studio CLI or WP-CLI is required for the Studio verification gate.\n' >&2
  exit 2
fi
wp_eval() { WP_DOCS_RUNTIME_ROOT="$runtime_root" "${wp_cmd[@]}" eval "$1"; }
wp_read() { WP_DOCS_RUNTIME_ROOT="$runtime_root" "${wp_cmd[@]}" post get 2431 --field=post_content; }
assert() { "$@" || { printf 'FAIL: %s\n' "$*" >&2; exit 1; }; }

printf 'Checking Studio MDI runtime at the supplied site directory.\n'
runtime=$(wp_eval '
global $wpdb;
$content = realpath( MARKDOWN_DB_CONTENT_DIR );
$state = realpath( MARKDOWN_DB_STATE_DIR );
$index = defined( "MARKDOWN_DB_INDEX_PATH" ) ? MARKDOWN_DB_INDEX_PATH : rtrim( $state ?: "", "/\\" ) . "/markdown-index.sqlite";
$documentation = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = \"documentation\"" );
$helphub = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = \"helphub_article\"" );
printf( "%s\t%s\t%s\t%s\t%s\t%d\t%d\n", get_class( $wpdb ), MARKDOWN_DB_MODE, $content, $state, $index, $documentation, $helphub );
')
IFS=$'\t' read -r wpdb_class mdi_mode content_root state_root index_path documentation_count helphub_count <<< "$runtime"

[[ "$wpdb_class" == 'WP_Markdown_DB' ]] || { printf 'FAIL: active $wpdb is %s, not WP_Markdown_DB.\n' "$wpdb_class" >&2; exit 1; }
[[ "$mdi_mode" == 'primary' ]] || { printf 'FAIL: MDI mode is %s, not primary.\n' "$mdi_mode" >&2; exit 1; }
[[ "$content_root" == "$runtime_root" ]] || { printf 'FAIL: MDI content root is not this checkout\047s content/runtime.\n' >&2; exit 1; }
[[ -n "$state_root" && "$state_root" != "$content_root" ]] || { printf 'FAIL: MDI content and runtime-state roots must be split.\n' >&2; exit 1; }
[[ "$index_path" == "$state_root/markdown-index.sqlite" ]] || { printf 'FAIL: primary index is not owned by the runtime-state root.\n' >&2; exit 1; }
[[ "$documentation_count" == 89 ]] || { printf 'FAIL: expected 89 documentation posts, found %s.\n' "$documentation_count" >&2; exit 1; }
[[ "$helphub_count" == 314 ]] || { printf 'FAIL: expected 314 helphub_article posts, found %s.\n' "$helphub_count" >&2; exit 1; }
assert test -f "$state_root/markdown-index.sqlite"
assert test -d "$state_root/_options"
assert test -d "$state_root/_tables"
assert test ! -e "$runtime_root/_options"
assert test ! -e "$runtime_root/_tables"
assert test ! -e "$runtime_root/_schema"
assert test ! -e "$runtime_root/markdown-index.sqlite"
assert test -z "$(find "$runtime_root" -type f -name '*.sqlite*' -print -quit)"
users=$("${wp_cmd[@]}" user list --format=count)
[[ "$users" -ge 1 ]] || { printf 'FAIL: expected at least one local WordPress user.\n' >&2; exit 1; }
printf 'PASS: primary MDI uses this checkout\047s 403-post corpus with split local state.\n'

((mutate)) || exit 0

assert test -z "$(git -C "$repo_root" status --porcelain -- "$fixture_git_rel")"
if grep -Fq "$wordpress_marker" "$fixture" || grep -Fq "$markdown_marker" "$fixture"; then
  printf 'FAIL: fixture already contains the verification marker.\n' >&2
  exit 1
fi

backup=$(mktemp)
original_hash=$(shasum -a 256 "$fixture" | cut -d ' ' -f 1)
cleanup_done=0
cleanup() {
  local status=$?
  trap - EXIT HUP INT TERM
  ((cleanup_done)) && return "$status"
  cleanup_done=1
  if [[ -f "$backup" ]]; then
    cp "$backup" "$fixture"
    # A fresh normal WordPress read proves neither temporary marker survived restoration.
    local restored_content
    if ! restored_content=$(wp_read); then
      status=1
    elif [[ "$restored_content" == *"$wordpress_marker"* || "$restored_content" == *"$markdown_marker"* ]]; then
      printf 'FAIL: verification markers remain after restoration.\n' >&2
      status=1
    fi
    if [[ $(shasum -a 256 "$fixture" | cut -d ' ' -f 1) != "$original_hash" ]] || ! cmp -s "$backup" "$fixture"; then
      printf 'FAIL: fixture bytes were not restored exactly.\n' >&2
      status=1
    fi
    if [[ -n $(git -C "$repo_root" status --porcelain -- "$fixture_git_rel") ]]; then
      printf 'FAIL: fixture is not clean in Git after restoration.\n' >&2
      status=1
    fi
    rm -f "$backup"
  fi
  return "$status"
}
trap cleanup EXIT HUP INT TERM
cp "$fixture" "$backup"

printf 'Running reversible WordPress-to-Markdown and Markdown-to-WordPress checks.\n'
wp_eval '$result = wp_update_post( array( "ID" => 2431, "post_content" => "<!-- WP Docs Studio verification marker: WordPress write -->" ), true ); if ( is_wp_error( $result ) ) { fwrite( STDERR, $result->get_error_message() . "\n" ); exit( 1 ); }' >/dev/null
post_content=$(wp_read)
[[ "$post_content" == *"$wordpress_marker"* ]] || { printf 'FAIL: WordPress write did not persist through a fresh WordPress read.\n' >&2; exit 1; }
printf '\n<!-- WP Docs Studio verification marker: external Markdown write -->\n' >> "$fixture"
post_content=$(wp_read)
[[ "$post_content" == *"$wordpress_marker"* && "$post_content" == *"$markdown_marker"* ]] || { printf 'FAIL: round-trip markers were not visible through a fresh WordPress read.\n' >&2; exit 1; }
printf 'PASS: shutdown persistence and warm Markdown synchronization succeeded; restoring fixture.\n'
