import { themeClass } from '../src/shared/styles/theme.css';
import '../src/app/index.css';

export const parameters = {
  actions: { argTypesRegex: "^on[A-Z].*" },
  controls: {
    matchers: {
      color: /(background|color)$/i,
      date: /Date$/,
    },
  },
  backgrounds: {
    default: 'light',
    values: [
      { name: 'light', value: '#ffffff' },
      { name: 'dark', value: '#333333' },
    ],
  },
};

export const decorators = [
  (Story) => (
    <div className={themeClass}>
      <Story />
    </div>
  )
];