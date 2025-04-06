import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            usePolling: true, // ファイル変更の検知を改善
            interval: 100,    // ポーリング間隔を短く設定
        },
        hmr: {
            overlay: false,   // エラーオーバーレイを無効化
        },
    },
});
