import { defineConfig } from 'blume';

export default defineConfig({
  title: 'WP Docs',
  description: 'WordPress.com developer documentation and WordPress.org documentation.',
  content: {
    root: '.blume-content'
  },
  github: {
    owner: 'chubes4',
    repo: 'wp-docs',
    branch: 'feat/studio-spacefast-headless'
  },
  navigation: {
    tabs: [
      { label: 'WordPress.com developer documentation', path: '/documentation' },
      { label: 'WordPress.org documentation', path: '/helphub_article' }
    ],
    sidebar: { display: 'page' }
  },
  search: { provider: 'orama' },
  ai: { llmsTxt: true },
  seo: {
    sitemap: true,
    robots: true,
    structuredData: true
  },
  deployment: {
    output: 'static',
    site: 'https://wp-docs.view.fast/'
  }
});
