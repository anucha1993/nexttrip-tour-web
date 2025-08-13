// NextTrip Performance Optimizer
(() => {
    // Resource Loading Priority
    const resources = {
        critical: [
            '/css/critical.css',
            '/js/critical.js'
        ],
        important: [
            '/css/combined.css',
            '/js/bundle.js'
        ],
        async: [
            'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js',
            '/js/analytics.js'
        ]
    };

    // Load Critical Resources Immediately
    resources.critical.forEach(resource => {
        const el = document.createElement(resource.endsWith('.css') ? 'link' : 'script');
        if (resource.endsWith('.css')) {
            el.rel = 'stylesheet';
            el.href = resource;
        } else {
            el.src = resource;
        }
        document.head.appendChild(el);
    });

    // Load Important Resources with High Priority
    window.addEventListener('DOMContentLoaded', () => {
        resources.important.forEach(resource => {
            if (resource.endsWith('.css')) {
                loadStylesheet(resource);
            } else {
                loadScript(resource);
            }
        });
    });

    // Load Async Resources with Low Priority
    window.addEventListener('load', () => {
        setTimeout(() => {
            resources.async.forEach(resource => {
                if (resource.endsWith('.css')) {
                    loadStylesheet(resource, true);
                } else {
                    loadScript(resource, true);
                }
            });
        }, 100);
    });

    // Utility Functions
    function loadScript(src, async = false) {
        const script = document.createElement('script');
        script.src = src;
        if (async) script.async = true;
        document.body.appendChild(script);
        return script;
    }

    function loadStylesheet(href, async = false) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = href;
        if (async) {
            link.media = 'print';
            link.onload = () => { link.media = 'all'; };
        }
        document.head.appendChild(link);
        return link;
    }

    // Image Loading Optimization
    document.addEventListener('DOMContentLoaded', () => {
        const images = document.querySelectorAll('img[loading="lazy"]');
        if ('loading' in HTMLImageElement.prototype) {
            images.forEach(img => {
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                }
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = loadScript('https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js');
            script.onload = () => {
                window.lazySizes.init();
            };
        }
    });

    // Performance Monitoring
    if ('performance' in window && 'PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                // Log performance metrics
                console.log(`${entry.name}: ${entry.startTime}ms`);
            }
        });
        observer.observe({ entryTypes: ['paint', 'largest-contentful-paint'] });
    }
})();
