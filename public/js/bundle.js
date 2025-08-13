// Combined JS files
document.addEventListener('DOMContentLoaded', function() {
    // Load scripts dynamically
    const scripts = [
        '/script-filter.js',
        '/data-filter.js',
        '/data-filter-holiday.js',
        '/data-filter-inthai.js'
    ];

    function loadScript(src) {
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = src;
            script.onload = resolve;
            script.onerror = reject;
            document.body.appendChild(script);
        });
    }

    // Load scripts in parallel but execute in order
    Promise.all(scripts.map(src => fetch(src)))
        .then(responses => Promise.all(responses.map(r => r.text())))
        .then(contents => {
            const combinedScript = document.createElement('script');
            combinedScript.textContent = contents.join('\n');
            document.body.appendChild(combinedScript);
        })
        .catch(console.error);
});
