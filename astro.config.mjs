import { defineConfig } from 'astro/config';

export default defineConfig({
  srcDir: './frontend/src',
  publicDir: './frontend/public',
  outDir: './dist',
  build: {
    format: 'directory'
  }
});
