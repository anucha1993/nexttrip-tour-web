// Service Worker for NextTrip Tour
const CACHE_NAME = 'nexttrip-cache-v1';
const STATIC_CACHE = 'static-cache-v1';

// Assets to cache
const STATIC_ASSETS = [
    '/css/app.css',
    '/js/app.js',
    '/js/bundle.js',
    'https://code.jquery.com/jquery-3.7.1.min.js',
    'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css',
    'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js'
];

// Install Event
self.addEventListener('install', event => {
    event.waitUntil(
        Promise.all([
            // Cache static assets
            caches.open(STATIC_CACHE).then(cache => {
                console.log('Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            }),
            // Cache root page
            caches.open(CACHE_NAME).then(cache => {
                console.log('Caching root page');
                return cache.add('/');
            })
        ]).catch(error => {
            console.error('Cache installation failed:', error);
        })
    );
});

// Fetch Event
self.addEventListener('fetch', event => {
    const request = event.request;
    
    // Skip cross-origin requests
    if (!request.url.startsWith(self.location.origin)) {
        return;
    }

    event.respondWith(
        caches.match(request)
            .then(cachedResponse => {
                if (cachedResponse) {
                    // Return cached response
                    return cachedResponse;
                }

                return fetch(request).then(response => {
                    // Don't cache if not successful
                    if (!response || response.status !== 200) {
                        return response;
                    }

                    // Cache successful responses
                    if (request.url.startsWith(self.location.origin)) {
                        const responseToCache = response.clone();
                        caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.put(request, responseToCache);
                            })
                            .catch(error => {
                                console.error('Cache put failed:', error);
                            });
                    }

                    return response;
                });
            })
            .catch(error => {
                console.error('Fetch failed:', error);
                // Return offline page or fallback content
                return caches.match('/offline.html');
            })
    );
});

// Activate Event - Clean up old caches
self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME, STATIC_CACHE];

    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
