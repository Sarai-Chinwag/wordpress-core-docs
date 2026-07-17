import { existsSync } from 'node:fs';
import { mkdir, readdir, readFile, rm, writeFile } from 'node:fs/promises';
import { dirname, join, relative } from 'node:path';
import matter from 'gray-matter';

const configuredRoot = process.env.WP_DOCS_CONTENT_ROOT || 'content/runtime';
const sourceRoot = existsSync(join(configuredRoot, 'wpdocs_document'))
  ? join(configuredRoot, 'wpdocs_document')
  : configuredRoot;
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

const bundledCorpus = existsSync(join(sourceRoot, 'documentation')) && existsSync(join(sourceRoot, 'helphub_article'));
const landingPages = bundledCorpus ? {
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
} : {
  'index.md': `---
title: WP Docs
description: Documentation published from WordPress through Push MD.
---

# WP Docs
`
};

for (const [path, content] of Object.entries(landingPages)) {
  const outputPath = join(outputRoot, path);
  await mkdir(dirname(outputPath), { recursive: true });
  await writeFile(outputPath, content);
}
