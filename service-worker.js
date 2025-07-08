const CACHE_NAME = "gstoreq8-v1";
const FILES_TO_CACHE = [
  "index.html",
  "products.html",
  "about.html",
  "contact.html",
  "styles.css",
  "app.js",
  "images/logo.png"
];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(FILES_TO_CACHE))
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => response || fetch(event.request))
  );
});

