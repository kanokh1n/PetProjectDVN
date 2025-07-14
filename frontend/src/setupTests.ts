// src/setupTests.ts
import '@testing-library/jest-dom';

// Мок для Vite env переменных
const { env } = import.meta;
Object.defineProperty(env, 'VITE_API_URL', {
    value: 'http://localhost:3000',
    writable: true,
});

// Глобальные моки
global.matchMedia =
    global.matchMedia ||
    function () {
        return {
            matches: false,
            addListener: function () {},
            removeListener: function () {},
        };
    };

class ResizeObserver {
    observe() {}
    unobserve() {}
    disconnect() {}
}
global.ResizeObserver = ResizeObserver;
