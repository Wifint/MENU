import { defineConfig } from 'astro/config';

export default defineConfig({
  site: 'https://tecnet-ca.com',
  output: 'static',
  build: {
    assets: '_assets'
  }
});
