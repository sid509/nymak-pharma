import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';

// While Vite is hot, laravel/inertia POSTs SSR requests to
// {vite-hot-url}/__inertia_ssr — an endpoint the dev server doesn't ship.
// The standalone SSR server (php artisan inertia:start-ssr) answers /render;
// bridge the two so server-side rendering still runs for Pest tests and any
// local SSR checks. Browsers shouldn't hydrate this markup (dev React ≠ the
// prod React inside bootstrap/ssr), so keep INERTIA_SSR_ENABLED=false in .env.
const inertiaSsrProxy = () => ({
    name: 'inertia-ssr-proxy',
    configureServer(server) {
        const ssrUrl = new URL(loadEnv(server.config.mode, process.cwd(), '').INERTIA_SSR_URL || 'http://127.0.0.1:13714');
        server.middlewares.use('/__inertia_ssr', (req, res) => {
            fetch(`${ssrUrl.origin}/render`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: req,
                duplex: 'half',
            })
                .then(async (r) => {
                    res.statusCode = r.status;
                    res.setHeader('Content-Type', 'application/json');
                    res.end(await r.text());
                })
                .catch(() => {
                    res.statusCode = 502;
                    res.end(JSON.stringify({ error: 'SSR server unreachable' }));
                });
        });
    },
});

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            ssr: 'resources/js/ssr.jsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
        inertiaSsrProxy(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
