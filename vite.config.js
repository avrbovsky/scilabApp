import vue from '@vitejs/plugin-vue';
import vuetify, {transformAssetUrls} from 'vite-plugin-vuetify';
import eslintPlugin from "vite-plugin-eslint";
import {defineConfig} from 'vite';
import {fileURLToPath, URL} from 'node:url';

export default defineConfig({
    define: {'process.env': {}},
    plugins: [
        vue({
            template: {transformAssetUrls}
        }),
        eslintPlugin({cache: false, fix: true}),
        vuetify({
            autoImport: true,
        })
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('resources/js', import.meta.url))
        },
        extensions: [
            '.js',
            '.json',
            '.jsx',
            '.mjs',
            '.ts',
            '.tsx',
            '.vue',
        ],
    },
    server: {
        port: 3000,
    },
    base: "./"
});