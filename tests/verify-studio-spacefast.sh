#!/usr/bin/env bash
set -euo pipefail

npm ci
npm run test:setup
npm run build

test -f dist/index.html
test "$(find content/runtime/documentation -type f -name '*.md' | wc -l)" -eq 89
test "$(find content/runtime/helphub_article -type f -name '*.md' | wc -l)" -eq 314
test -f dist/documentation/developer-tools/wp-cli/common-commands/index.html
test -f dist/helphub_article/search-block/index.html
test -f dist/llms.txt
test -f dist/robots.txt
test -f dist/sitemap.xml
test -f dist/blume-search.json
test ! -e dist/README.md

for page in dist/index.html dist/documentation/developer-tools/wp-cli/common-commands/index.html dist/helphub_article/search-block/index.html; do
  test -s "$page"
  grep -qi '<!doctype html>' "$page"
  grep -q '<main' "$page"
done

grep -q 'WordPress.com developer documentation' dist/index.html
grep -q 'WordPress.org documentation' dist/index.html
if grep -R -E -i -n 'wpcloudstation\.dev' dist; then
  echo 'Generated output contains a retired WP Cloud runtime URL.' >&2
  exit 1
fi

sf_bin=$(mktemp -d)
sf_args=$(mktemp)
sf_expected=$(mktemp)
cleanup() {
  rm -rf "$sf_bin"
  rm -f "$sf_args" "$sf_expected"
}
trap cleanup EXIT

cat > "$sf_bin/sf" <<'EOF'
#!/usr/bin/env bash
set -euo pipefail
printf '%s\n' "$@" > "$SF_ARGS_FILE"
EOF
chmod +x "$sf_bin/sf"

PATH="$sf_bin:$PATH" SF_ARGS_FILE="$sf_args" WP_DOCS_SPACEFAST_TARGET=customer-docs npm run publish:spacefast -- --dry-run
printf 'publish\ndist\n--prebuilt\n--space\ncustomer-docs\n--yes\n--wait\n--dry-run\n' > "$sf_expected"
cmp -s "$sf_expected" "$sf_args"
