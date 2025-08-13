// Critical JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Performance Metrics
    if ('performance' in window) {
        // Report Core Web Vitals
        const vitals = {
            getFCP: () => performance.getEntriesByName('first-contentful-paint')[0],
            getLCP: () => performance.getEntriesByName('largest-contentful-paint')[0],
            getFID: () => performance.getEntriesByName('first-input-delay')[0],
            getCLS: () => performance.getEntriesByName('cumulative-layout-shift')[0]
        };

        // Initialize Performance Observer
        const observer = new PerformanceObserver((list) => {
            list.getEntries().forEach(entry => {
                // Log performance metrics
                console.log(`${entry.name}: ${entry.startTime}ms`);
            });
        });

        observer.observe({ entryTypes: ['paint', 'largest-contentful-paint', 'first-input', 'layout-shift'] });
    }

    // Dynamic Import of Non-Critical JavaScript
    const loadNonCritical = () => {
        // Load scripts that are not needed immediately
        const scripts = [
            '/js/bundle.js',
            'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js'
        ];

        scripts.forEach(src => {
            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            document.body.appendChild(script);
        });
    };

    // Delay loading of non-critical resources
    if ('requestIdleCallback' in window) {
        requestIdleCallback(loadNonCritical);
    } else {
        setTimeout(loadNonCritical, 1000);
    }

    // Optimize Image Loading
    const images = document.querySelectorAll('img[loading="lazy"]');
    if ('loading' in HTMLImageElement.prototype) {
        images.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
            }
        });
    } else {
        // Fallback for browsers that don't support native lazy loading
        import('https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js')
            .then(() => {
                window.lazySizes.init();
            });
    }

    // Initialize Intersection Observer for lazy loading
    const lazyLoadOptions = {
        root: null,
        rootMargin: '50px',
        threshold: 0.1
    };

    const lazyLoadObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                if (element.dataset.src) {
                    element.src = element.dataset.src;
                    element.classList.add('loaded');
                }
                lazyLoadObserver.unobserve(element);
            }
        });
    }, lazyLoadOptions);

    images.forEach(img => lazyLoadObserver.observe(img));
});
