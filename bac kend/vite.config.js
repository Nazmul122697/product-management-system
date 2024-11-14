import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    vue(),
  ],
  server: {
    proxy: {
      '/api': 'http://localhost:8000',  // Proxy requests starting with /api to your Laravel backend
      // Optionally, you can also proxy other routes if needed:
      // '/another-api': 'http://localhost:8000',
    },
  },
});
