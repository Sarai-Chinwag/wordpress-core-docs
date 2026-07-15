import { cp, mkdir, readFile, rm, writeFile } from 'node:fs/promises';
import path from 'node:path';
import { createHash } from 'node:crypto';

const root = process.cwd();
const source = process.env.WP_DOCS_SOURCE ?? 'fixture';
const generated = path.join(root, 'frontend/src/generated');
const mediaOutput = path.join(root, 'frontend/public/media');

function text(value) {
  return value?.rendered ?? value ?? '';
}

function normalizedOrigin(value) {
  const url = new URL(value);
  return url.origin;
}

async function loadFixture() {
  return JSON.parse(await readFile(path.join(root, 'frontend/fixtures/pages.json'), 'utf8'));
}

async function loadWordPress() {
  const base = process.env.WP_DOCS_WORDPRESS_URL;
  if (!base) throw new Error('WP_DOCS_WORDPRESS_URL is required when WP_DOCS_SOURCE=wordpress.');
  const endpoint = new URL('/wp-json/wp/v2/pages?context=view&per_page=100&_fields=id,parent,slug,title,content,menu_order,link', base);
  const pages = [];
  for (let page = 1; ; page += 1) {
    endpoint.searchParams.set('page', String(page));
    const response = await fetch(endpoint);
    if (response.status === 400 && page > 1) break;
    if (!response.ok) throw new Error(`WordPress Pages request failed (${response.status}): ${endpoint}`);
    const batch = await response.json();
    pages.push(...batch);
    if (batch.length < 100) break;
  }
  return { pages, origin: normalizedOrigin(base), media: {} };
}

function hierarchy(pages) {
  const byId = new Map(pages.map((page) => [page.id, page]));
  const children = new Map();
  for (const page of pages) {
    const list = children.get(page.parent) ?? [];
    list.push(page);
    children.set(page.parent, list);
  }
  for (const list of children.values()) list.sort((a, b) => a.menu_order - b.menu_order || text(a.title).localeCompare(text(b.title)) || a.id - b.id);
  const routeFor = (page) => {
    const ancestors = [];
    let current = page;
    const visited = new Set();
    while (current && !visited.has(current.id)) {
      visited.add(current.id);
      ancestors.unshift(current.slug);
      current = byId.get(current.parent);
    }
    if (current) throw new Error(`Page hierarchy contains a cycle at page ${page.id}.`);
    return `/${ancestors.join('/')}/`;
  };
  return { byId, children, routeFor };
}

function mediaName(url) {
  const parsed = new URL(url);
  const extension = path.extname(parsed.pathname) || '.bin';
  return `${createHash('sha256').update(url).digest('hex').slice(0, 16)}${extension}`;
}

async function copyMedia(url, context) {
  const outputName = mediaName(url);
  const destination = path.join(mediaOutput, outputName);
  const fixtureFile = context.media[url];
  if (fixtureFile) {
    await cp(path.join(root, fixtureFile), destination);
    return `/media/${outputName}`;
  }
  if (!context.origin || new URL(url).origin !== context.origin) {
    throw new Error(`Unsupported media URL "${url}". Use media hosted by WP_DOCS_WORDPRESS_URL; external and data URLs are not published.`);
  }
  const response = await fetch(url);
  if (!response.ok) throw new Error(`Could not copy WordPress media "${url}" (${response.status}). Upload a supported local media file or remove this reference.`);
  await writeFile(destination, Buffer.from(await response.arrayBuffer()));
  return `/media/${outputName}`;
}

async function main() {
  await rm(generated, { recursive: true, force: true });
  await rm(mediaOutput, { recursive: true, force: true });
  await mkdir(generated, { recursive: true });
  await mkdir(mediaOutput, { recursive: true });
  const input = source === 'fixture' ? await loadFixture() : source === 'wordpress' ? await loadWordPress() : (() => { throw new Error(`Unknown WP_DOCS_SOURCE "${source}". Use fixture or wordpress.`); })();
  const { byId, children, routeFor } = hierarchy(input.pages);
  const links = new Map(input.pages.filter((page) => page.link).map((page) => [page.link.replace(/\/$/, ''), routeFor(page)]));
  const pages = [];
  for (const page of input.pages) {
    let content = text(page.content);
    const urls = [...content.matchAll(/\b(src|href)=(['"])(.*?)\2/gi)].map((match) => ({ attribute: match[1].toLowerCase(), url: match[3] }));
    for (const { attribute, url } of urls) {
      if (url.startsWith('#') || url.startsWith('mailto:')) continue;
      const resolved = new URL(url, input.origin);
      const knownRoute = links.get(resolved.href.replace(/\/$/, ''));
      if (knownRoute) {
        content = content.split(url).join(knownRoute);
      } else if (attribute === 'src') {
        const localPath = await copyMedia(resolved.href, input);
        content = content.split(url).join(localPath);
      } else if (input.origin && resolved.origin === input.origin) {
        throw new Error(`Unsupported local WordPress link "${url}" on page ${page.id}. Link to a published Page or remove it.`);
      }
    }
    if (input.origin && content.includes(input.origin)) {
      throw new Error(`Page ${page.id} still contains a local WordPress URL after conversion. Use a published Page link or supported WordPress media URL.`);
    }
    const ancestors = [];
    let ancestor = byId.get(page.parent);
    while (ancestor) {
      ancestors.unshift({ title: text(ancestor.title), route: routeFor(ancestor) });
      ancestor = byId.get(ancestor.parent);
    }
    pages.push({ id: page.id, title: text(page.title), route: routeFor(page), content, ancestors, children: (children.get(page.id) ?? []).map((child) => ({ title: text(child.title), route: routeFor(child) })) });
  }
  pages.sort((a, b) => a.route.localeCompare(b.route));
  await writeFile(path.join(generated, 'pages.json'), `${JSON.stringify({ pages }, null, 2)}\n`);
}

main().catch((error) => {
  console.error(`wp-docs build failed: ${error.message}`);
  process.exit(1);
});
