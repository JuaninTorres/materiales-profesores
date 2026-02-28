import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        })
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Bootstrap 5.x usa sintaxis Sass deprecada en Dart Sass 1.80+.
                // Estos warnings son de Bootstrap, no del código propio del proyecto.
                silenceDeprecations: ['import', 'global-builtin', 'color-functions', 'if-function'],
            }
        }
    },
    server: {
        cors: true,
    },
});
