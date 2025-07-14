import { createBrowserRouter } from 'react-router-dom';
import App from '@/app/App';
import { MainPage } from '@/pages/MainPage';

export const router = createBrowserRouter([
    {
        path: '/',
        element: <App />,
        children: [
            {
                index: true,
                element: <MainPage />,
            },
        ],
    },
]);
