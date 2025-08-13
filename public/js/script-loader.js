// JavaScript Loader Utility
(function() {
    // Check if jQuery is needed and not loaded
    if (typeof jQuery === 'undefined' && document.querySelector('[data-requires-jquery]')) {
        loadScript('https://code.jquery.com/jquery-3.7.1.min.js')
            .then(() => {
                // Load jQuery dependent scripts
                loadDependentScripts();
            });
    }

    function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.async = true;
            script.onload = resolve;
            script.onerror = reject;
            document.body.appendChild(script);
        });
    }

    function loadDependentScripts() {
        // Load other scripts that depend on jQuery
        const scripts = [
            '/js/bundle.js',
            'https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js'
        ];

        Promise.all(scripts.map(src => loadScript(src)))
            .then(() => {
                // Initialize components after all scripts are loaded
                if (typeof initializeComponents === 'function') {
                    initializeComponents();
                }
            })
            .catch(console.error);
    }

    // Detect errors
    window.addEventListener('error', function(e) {
        if (e.message.includes("$ is not defined") || e.message.includes("jQuery is not defined")) {
            console.warn('jQuery error detected, attempting to reload...');
            loadScript('https://code.jquery.com/jquery-3.7.1.min.js');
        }
    });
})();
