import { mkdir, readdir, readFile, rm, writeFile } from 'node:fs/promises';
import { dirname, join, relative } from 'node:path';
import matter from 'gray-matter';

const sourceRoot = 'content/runtime';
const outputRoot = '.blume-content';

async function markdownFiles(directory) {
  const entries = await readdir(directory, { withFileTypes: true });
  const files = await Promise.all(entries.map((entry) => {
    const path = join(directory, entry.name);
    return entry.isDirectory() ? markdownFiles(path) : path;
  }));

  return files.flat().filter((path) => path.endsWith('.md'));
}

await rm(outputRoot, { recursive: true, force: true });

for (const sourcePath of await markdownFiles(sourceRoot)) {
  const document = matter(await readFile(sourcePath, 'utf8'));
  const outputPath = join(outputRoot, relative(sourceRoot, sourcePath));
  const metadata = Object.fromEntries(Object.entries({
    title: document.data.title,
    description: document.data.description,
    type: 'doc',
    lastModified: document.data.timestamp
  }).filter(([, value]) => value !== undefined && value !== null));

  await mkdir(dirname(outputPath), { recursive: true });
  await writeFile(outputPath, matter.stringify(document.content, metadata));
}

const landingPages = {
  'index.md': `---
title: WP Docs
description: WordPress.com developer documentation and WordPress.org documentation.
---

# WP Docs

- [WordPress.com developer documentation](/documentation/)
- [WordPress.org documentation](/helphub_article/)
`,
  'documentation/index.md': `---
title: WordPress.com developer documentation
description: Documentation for developing on WordPress.com.
---

# WordPress.com developer documentation
`,
  'helphub_article/index.md': `---
title: WordPress.org documentation
description: Documentation for using and developing with WordPress.
---

# WordPress.org documentation
`
};

for (const [path, content] of Object.entries(landingPages)) {
  const outputPath = join(outputRoot, path);
  await mkdir(dirname(outputPath), { recursive: true });
  await writeFile(outputPath, content);
}
