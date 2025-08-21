const fs = require('fs');
const path = require('path');

function readJson(p) {
  return JSON.parse(fs.readFileSync(p, 'utf8'));
}
function listFiles(dir) {
  if (!fs.existsSync(dir)) return [];
  return fs.readdirSync(dir).filter((f) => fs.statSync(path.join(dir, f)).isFile());
}
function baseNoExt(f) {
  return f.replace(/\.[^.]+$/, '');
}
function ensureDir(p) {
  fs.mkdirSync(path.dirname(p), { recursive: true });
}
function writeFile(p, content) {
  ensureDir(p);
  fs.writeFileSync(p, content);
}
function removeFile(p) {
  if (fs.existsSync(p)) fs.rmSync(p, { force: true });
}
function removeTree(p) {
  if (fs.existsSync(p)) fs.rmSync(p, { recursive: true, force: true });
}
function uniq(a) {
  return Array.from(new Set(a));
}
function mapSlug(slug, aliases) {
  return aliases && aliases[slug] ? aliases[slug] : slug;
}

function pruneDir(dir, keepSet, exts, aliasMap) {
  const removed = [];
  if (!fs.existsSync(dir)) return removed;
  const files = listFiles(dir);
  files.forEach((f) => {
    const ext = path.extname(f).toLowerCase();
    if (!exts.includes(ext)) return;
    const raw = baseNoExt(f).replace(/^_/, '');
    let keep = false;
    keepSet.forEach((k) => {
      const mapped = mapSlug(k, aliasMap);
      if (mapped === raw) keep = true;
    });
    if (!keep) {
      removeFile(path.join(dir, f));
      removed.push(f);
    }
  });
  return removed;
}

function replaceBetweenMarkers(src, startMarker, endMarker, newLines) {
  const start = src.indexOf(startMarker);
  const end = src.indexOf(endMarker);
  if (start !== -1 && end !== -1 && end > start) {
    const before = src.slice(0, start + startMarker.length);
    const after = src.slice(end);
    return before + '\n' + newLines.join('\n') + '\n' + after;
  }
  return null;
}

function rewriteStyleScss(stylePath, scssBlocksDir, keep, scssAliases, removeWoo) {
  if (!fs.existsSync(stylePath)) return false;
  let txt = fs.readFileSync(stylePath, 'utf8');
  if (removeWoo) txt = txt.replace(/^\s*@import\s+["']scss\/woocommerce\/[^"']+["'];\s*$/gm, '');
  const imports = keep.map((k) => `@import 'scss/blocks/${mapSlug(k, scssAliases)}';`);
  const repl = replaceBetweenMarkers(txt, '/* @blocks:start */', '/* @blocks:end */', imports);
  if (repl !== null) {
    writeFile(stylePath, repl + '\n');
    return true;
  }
  txt = txt.replace(/^\s*\/{0,2}\s*@import\s+['"]scss\/blocks\/[^'"]+['"];\s*$/gm, '');
  txt += imports.length ? '\n' + imports.join('\n') + '\n' : '\n';
  writeFile(stylePath, txt);
  return true;
}

function rewriteJsIndex(jsIndexPath, jsBlocksDir, keep, enableWoo, jsAliases) {
  if (!fs.existsSync(jsIndexPath)) return false;
  let txt = fs.readFileSync(jsIndexPath, 'utf8');
  if (!enableWoo) txt = txt.replace(/^\s*\/{0,2}\s*import\s+['"]\.\/woocommerce\/[^'"]+['"];\s*$/gm, '');
  const imports = keep
    .map((k) => {
      const slug = mapSlug(k, jsAliases);
      const f = path.join(jsBlocksDir, `${slug}.js`);
      return fs.existsSync(f) ? `import './blocks/${slug}';` : '';
    })
    .filter(Boolean);
  const repl = replaceBetweenMarkers(txt, '/* @blocks:start */', '/* @blocks:end */', imports);
  if (repl !== null) {
    writeFile(jsIndexPath, repl + '\n');
    return true;
  }
  txt = txt.replace(/^\s*\/{0,2}\s*import\s+['"]\.\/blocks\/[^'"]+['"];\s*$/gm, '');
  const lastImport = (() => {
    const lines = txt.split(/\r?\n/);
    let idx = -1;
    for (let i = 0; i < lines.length; i++) {
      if (/^\s*import\s/.test(lines[i])) idx = i;
    }
    return idx;
  })();
  if (lastImport >= 0) {
    const lines = txt.split(/\r?\n/);
    lines.splice(lastImport + 1, 0, ...imports);
    writeFile(jsIndexPath, lines.join('\n') + '\n');
    return true;
  }
  txt = (imports.length ? imports.join('\n') + '\n' : '') + txt;
  writeFile(jsIndexPath, txt);
  return true;
}

function slugifyAcfBlockTitle(s) {
  return String(s || '')
    .replace(/^block:\s*/i, '')
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .toLowerCase()
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/^-+|-+$/g, '');
}

function allowedAcfSets(keep, acfAliases) {
  const slugs = new Set();
  const full = new Set();
  keep.forEach((k) => {
    const a = acfAliases && acfAliases[k] ? acfAliases[k] : k;
    slugs.add(a);
    full.add('acf/' + a);
  });
  return { slugs, full };
}

function pruneAcfLocalJson(localDir, keep, acfAliases) {
  const removed = [];
  if (!fs.existsSync(localDir)) return removed;
  const { slugs, full } = allowedAcfSets(keep, acfAliases);
  const files = listFiles(localDir).filter((f) => f.endsWith('.json'));
  files.forEach((f) => {
    const fullPath = path.join(localDir, f);
    let data = null;
    try {
      data = JSON.parse(fs.readFileSync(fullPath, 'utf8'));
    } catch (e) {
      data = null;
    }
    if (!data) return;
    const title = String(data.title || data.label || '').trim();
    const isTitleBlock = /^block:\s*/i.test(title);
    const isTitleKeep = /^(theme settings|component:|global:)/i.test(title);
    const loc = data.location;
    let hasBlockRule = false;
    let matches = false;
    if (Array.isArray(loc)) {
      loc.forEach((andG) => {
        (andG || []).forEach((rule) => {
          if (rule && rule.param === 'block') {
            hasBlockRule = true;
            const v = String(rule.value || '');
            if (full.has(v) || slugs.has(v.replace(/^acf\//, ''))) matches = true;
          }
        });
      });
    }
    let isBlockGroup = hasBlockRule || isTitleBlock;
    if (isTitleKeep) isBlockGroup = false;
    if (isBlockGroup && !matches) {
      removeFile(fullPath);
      removed.push(f);
    }
  });
  return removed;
}

function filterBlocksPhp(blocksPhpPath, keep) {
  if (!fs.existsSync(blocksPhpPath)) return false;
  const txt = fs.readFileSync(blocksPhpPath, 'utf8');
  const body = txt.replace(/^<\?php\s*/, '').trim();
  const items = {};
  const re = /'([a-z0-9\-\_]+)'\s*=>\s*\[/gi;
  let m;
  while ((m = re.exec(body)) !== null) {
    const slug = m[1];
    const start = m.index;
    let i = re.lastIndex,
      depth = 1;
    while (i < body.length && depth > 0) {
      const ch = body[i++];
      if (ch === '[') depth++;
      else if (ch === ']') depth--;
    }
    const end = i;
    items[slug] = body.slice(start, end) + ',';
  }
  const parts = [];
  keep.forEach((slug) => {
    if (items[slug]) parts.push(items[slug]);
    else {
      const title = slug.replace(/[\-\_]+/g, ' ').replace(/\b\w/g, (s) => s.toUpperCase());
      parts.push(
        `'${slug}' => [ 'title' => __('${title}', 'ercodingtheme'), 'category' => 'ercodingtheme', 'align' => 'full' ],`,
      );
    }
  });
  const out = '<?php\nreturn [\n\t' + parts.join('\n\t') + '\n];\n';
  writeFile(blocksPhpPath, out);
  return true;
}

function run() {
  const cfg = readJson(path.resolve('blocks.use.json'));
  const keep = uniq(cfg.keep.map(String));
  const keepSet = new Set(keep);
  const scssAliases = cfg.aliases && cfg.aliases.scss ? cfg.aliases.scss : {};
  const jsAliases = cfg.aliases && cfg.aliases.js ? cfg.aliases.js : {};
  const acfAliases = cfg.aliases && cfg.aliases.acf ? cfg.aliases.acf : {};
  const removeWoo = cfg.features && cfg.features.woocommerce === false;
  const paths = {
    styleScss: path.resolve('style.scss'),
    phpBlocks: path.resolve('acf/blocks'),
    phpBlocksList: path.resolve('acf/blocks.php'),
    scssBlocks: path.resolve('scss/blocks'),
    jsIndex: path.resolve('js/src/index.js'),
    jsBlocks: path.resolve('js/src/blocks'),
    scssWoo: path.resolve('scss/woocommerce'),
    jsWoo: path.resolve('js/src/woocommerce'),
    acfLocal: path.resolve('acf/local-json'),
  };
  const removed = {
    php: pruneDir(paths.phpBlocks, keepSet, ['.php']),
    scss: pruneDir(paths.scssBlocks, keepSet, ['.scss'], scssAliases),
    js: pruneDir(paths.jsBlocks, keepSet, ['.js', '.mjs', '.ts'], jsAliases),
    acfJson: pruneAcfLocalJson(paths.acfLocal, keep, acfAliases),
  };
  rewriteStyleScss(paths.styleScss, paths.scssBlocks, keep, scssAliases, removeWoo);
  rewriteJsIndex(paths.jsIndex, paths.jsBlocks, keep, !removeWoo, jsAliases);
  if (removeWoo) {
    removeTree(paths.scssWoo);
    removeTree(paths.jsWoo);
  }
  filterBlocksPhp(paths.phpBlocksList, keep);
  process.stdout.write(JSON.stringify({ kept: keep, removed }, null, 2) + '\n');
}

run();
