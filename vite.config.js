import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/scss/front/style.scss',
                'resources/scss/admin/style.scss',
                'resources/js/admin/app.js',
                'resources/js/risk_evaluation/risk.js',
                'resources/js/bot_evaluation/risk.js',
                'resources/js/awareness_evaluation/app.js',
                'resources/js/portal/portal.js',
            ],
            refresh: true,
        })
    ],
});
