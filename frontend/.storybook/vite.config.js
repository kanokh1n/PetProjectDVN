import { mergeConfig } from 'vite';
import { vanillaExtractPlugin } from '@vanilla-extract/vite-plugin';

export default {
  async viteFinal(config) {
    return mergeConfig(config, {
      plugins: [vanillaExtractPlugin()],
      resolve: {
        alias: {
          // Дублируем алиасы из основного vite.config.js
          '@': '/src',
          '@app': '/src/app',
          '@shared': '/src/shared'
        }
      }
    });
  }
};