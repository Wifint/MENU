import { defineConfig } from 'astro/config';

// https://astro.build/config
export default defineConfig({
  // Configuración para Vercel - no necesita base path
  outDir: './dist',
  publicDir: './public'
});
