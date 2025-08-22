import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import removeConsole from "vite-plugin-remove-console";
export default defineConfig({
    plugins: [

        laravel({
            input: [
                //'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        react(),
        removeConsole()
    ],
});
