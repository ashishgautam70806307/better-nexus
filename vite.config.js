import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    const origins = ['http://localhost:8000', 'http://127.0.0.1:8000'];
    if (env.APP_URL) origins.push(new URL(env.APP_URL).origin);

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
        ],
        server: {
            host: '127.0.0.1',
            port: 5173,
            strictPort: true,
            cors: { origin: [...new Set(origins)] },
        },
    };
});
