/* ==========================================================================
   Badal Umrah Progressive Web App Service Worker
   - Cache First for local static assets (CSS, JS, images, icons, fonts)
   - Network Only (no caching) for /admin, /login, /logout, /storage, video streams & non-GET
   - Network First with offline cache & offline.html fallback for public HTML pages
   ========================================================================== */

const CACHE_VERSION = 'badal-umrah-v1';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const PAGE_CACHE = `${CACHE_VERSION}-pages`;
const OFFLINE_FALLBACK = './offline.html';

const PRECACHE_ASSETS = [
  './offline.html',
  './manifest.json',
  './favicon.ico',
  './css/smoked-glass.css?v=1',
  './js/smoked-glass.js?v=1',
  './img/bg-haram-blur.jpg',
  './img/bg-haram.jpg',
  './img/logo-utama.png',
  './icons/icon-192x192.png',
  './icons/icon-512x512.png',
  './icons/apple-touch-icon-180x180.png'
];

const getRelativePath = (url) => {
  const scopePath = new URL(self.registration.scope).pathname;
  if (url.pathname.startsWith(scopePath)) {
    return '/' + url.pathname.slice(scopePath.length).replace(/^\/+/, '');
  }
  return url.pathname;
};

const isSensitiveOrStreamPath = (relPath) => {
  return (
    relPath === '/admin' ||
    relPath.startsWith('/admin/') ||
    relPath === '/login' ||
    relPath.startsWith('/login/') ||
    relPath === '/logout' ||
    relPath.startsWith('/storage/') ||
    /^\/video\/[^/]+\/(stream|download)/i.test(relPath)
  );
};

const isStaticAssetRequest = (request, relPath) => {
  if (isSensitiveOrStreamPath(relPath)) return false;

  if (['style', 'script', 'image', 'font', 'manifest'].includes(request.destination)) {
    return true;
  }

  return (
    relPath.startsWith('/css/') ||
    relPath.startsWith('/js/') ||
    relPath.startsWith('/img/') ||
    relPath.startsWith('/icons/') ||
    relPath.startsWith('/fonts/') ||
    /\.(css|js|png|jpe?g|webp|svg|gif|ico|woff2?|ttf|json)$/i.test(relPath)
  );
};

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(STATIC_CACHE).then((cache) => cache.addAll(PRECACHE_ASSETS))
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  const allowedCaches = new Set([STATIC_CACHE, PAGE_CACHE]);
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => !allowedCaches.has(key))
          .map((oldKey) => caches.delete(oldKey))
      )
    )
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const { request } = event;

  // Never intercept POST / form submissions or cross-origin requests
  if (request.method !== 'GET') return;

  const url = new URL(request.url);
  if (url.origin !== self.location.origin) return;

  const relPath = getRelativePath(url);
  const isNavigation =
    request.mode === 'navigate' ||
    (request.headers.get('accept') || '').includes('text/html');

  // 1. Sensitive Admin, Auth, Storage PDFs & Video Streams: Network Only (never store in CacheStorage)
  if (isSensitiveOrStreamPath(relPath)) {
    if (isNavigation) {
      event.respondWith(
        fetch(request).catch(() => caches.match(OFFLINE_FALLBACK))
      );
    }
    return;
  }

  // 2. Local Static Assets: Cache First
  if (isStaticAssetRequest(request, relPath)) {
    event.respondWith(
      caches.match(request).then((cached) => {
        if (cached) return cached;

        return fetch(request).then((networkResponse) => {
          if (
            networkResponse &&
            networkResponse.status === 200 &&
            networkResponse.type === 'basic'
          ) {
            const copy = networkResponse.clone();
            caches.open(STATIC_CACHE).then((cache) => cache.put(request, copy));
          }
          return networkResponse;
        });
      })
    );
    return;
  }

  // 3. Public Dynamic PHP Pages (/, /pendaftaran, /sertifikat, /video/*): Network First + Offline Fallback
  if (isNavigation) {
    event.respondWith(
      fetch(request)
        .then((networkResponse) => {
          if (
            networkResponse &&
            networkResponse.status === 200 &&
            networkResponse.type === 'basic'
          ) {
            const copy = networkResponse.clone();
            caches.open(PAGE_CACHE).then((cache) => cache.put(request, copy));
          }
          return networkResponse;
        })
        .catch(async () => {
          const cachedPage = await caches.match(request);
          if (cachedPage) return cachedPage;
          return caches.match(OFFLINE_FALLBACK);
        })
    );
  }
});
