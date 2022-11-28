import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
// import dotenv from 'dotenv'

// dotenv.config({path:'./.env'})

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
    build: {
        rollupOptions: {
            plugins: [
                {
                    name: 'no-treeshake',
                    transform(_, id) {
                        if (id.includes('integration/jquery')) {
                            return { moduleSideEffects: 'no-treeshake' }
                        }
                        if (id.includes('ui/data_grid')) {
                            return { moduleSideEffects: 'no-treeshake' }
                        }
                    }
                }
            ]
        }
    }
    // server: {
    //     host: process.env.APP_URL
    // }
});
