import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig(({ command }) => {
  const isProd = command === 'build'
  return {
    root: path.resolve(__dirname),
    base: isProd ? '/src/' : '/',
    plugins: [vue()],
    build: {
      outDir: path.resolve(__dirname, '..', 'web', 'src'), // путь до директории
      emptyOutDir: true, // очищает директорию перед сборкой
      manifest: true, // создает manifest.json файл
      rollupOptions: {
        input: path.resolve(__dirname, 'src', 'main.js'),
      },
    },
    server: {
      host: true,
      cors: true,
    }
  }
})
