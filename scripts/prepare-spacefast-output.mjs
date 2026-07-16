import { rm } from 'node:fs/promises';

// Spacefast reserves this root path; Blume also exports the source as README.mdx.
await rm('dist/README.md', { force: true });
