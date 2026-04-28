import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            // Beritahu Laravel di mana folder public yang sebenarnya
            publicDirectory: '../musdaphri', 
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        // Menentukan folder output agar masuk ke dalam folder musdaphri/build
        outDir: '../musdaphri/build',
        emptyOutDir: true,
    }
});