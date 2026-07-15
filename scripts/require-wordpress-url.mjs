if (!process.env.WP_DOCS_WORDPRESS_URL) {
  console.error('WP_DOCS_WORDPRESS_URL is required for a Studio-backed build. Example: WP_DOCS_WORDPRESS_URL=http://localhost:8888 npm run build:studio');
  process.exit(1);
}
