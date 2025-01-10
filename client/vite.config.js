import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [react()],
    resolve: {
        alias: {
            '@Pages': path.resolve(__dirname, './src/pages'),
            '@Routes': path.resolve(__dirname, './src/routes'),
            '@Utilities': path.resolve(__dirname, './src/pages/utilities'),
            '@Hooks': path.resolve(__dirname, './src/hooks'),
        },
    },
});
