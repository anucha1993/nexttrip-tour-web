// NextTrip Tour Performance Optimizations
(() => {
    // Progressive Image Loading
    const lazyImages = document.querySelectorAll('[data-src]');
    const imageOptions = {
        root: null,
        threshold: 0,
        rootMargin: '50px'
    };

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('lazyloaded');
                observer.unobserve(img);
            }
        });
    }, imageOptions);

    lazyImages.forEach(img => imageObserver.observe(img));

    // Resource Hints
    const preconnectURLs = [
        'https://cdnjs.cloudflare.com',
        'https://fonts.googleapis.com'
    ];

    preconnectURLs.forEach(url => {
        const link = document.createElement('link');
        link.rel = 'preconnect';
        link.href = url;
        link.crossOrigin = 'anonymous';
        document.head.appendChild(link);
    });

    // Defer Non-Critical JavaScript
    const deferScripts = () => {
        const scripts = document.querySelectorAll('script[data-defer]');
        scripts.forEach(script => {
            script.setAttribute('defer', '');
            script.removeAttribute('data-defer');
        });
    };

    // Execute after DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', deferScripts);
    } else {
        deferScripts();
    }
})();
