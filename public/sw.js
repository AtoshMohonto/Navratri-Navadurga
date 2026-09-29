const CACHE_NAME = 'navadurga-shell-v1';
const SHELL_URLS = [
    './',
    'assets/css/app.css',
    'assets/js/app.js',
    'assets/images/favicon.svg',
    'offline.html',
];

self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME).then(function (cache) {
            return cache.addAll(SHELL_URLS.map(function (u) { return new URL(u, self.registration.scope).toString(); }));
        }).catch(function () { /* best-effort; ignore failures during install */ })
    );
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (keys) {
            return Promise.all(keys.filter(function (k) { return k !== CACHE_NAME; }).map(function (k) { return caches.delete(k); }));
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', function (event) {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request).then(function (response) {
            return response;
        }).catch(function () {
            return caches.match(event.request).then(function (cached) {
                if (cached) return cached;
                if (event.request.mode === 'navigate') {
                    return caches.match(new URL('offline.html', self.registration.scope).toString());
                }
                return Response.error();
            });
        })
    );
});
