module.exports = {
    stories: ['../src/**/*.stories.@(js|jsx|ts|tsx|mdx)'],
    framework: {
      name: '@storybook/react-vite',
      options: {}
    },
    features: {
      storyStoreV7: true,
    },
    typescript: {
      reactDocgen: 'react-docgen-typescript'
    },
    async viteFinal(config) {
      return {
        ...config,
        resolve: {
          ...config.resolve,
          alias: {
            ...config.resolve.alias,
            // Добавьте ваши алиасы здесь
            '@': '/src',
            '@app': '/src/app',
            '@shared': '/src/shared'
          }
        }
      };
    }
  };