import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import compress from 'vite-plugin-compression';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        compress({
            algorithm: 'brotli',
            threshold: 0
        })
    ],
    build: {
        // Generate sourcemaps for dev only
        sourcemap: process.env.NODE_ENV === 'development',
        // Minify output
        minify: 'terser',
        // Split chunks
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['/resources/js/vendor.js'],
                    utils: ['/resources/js/utils.js']
                }
            }
        },
        // Cache busting
        chunkSizeWarningLimit: 1000,
        assetsDir: 'assets',
        emptyOutDir: true
    },
    server: {
        // Enable HMR
        hmr: true
    }
});
