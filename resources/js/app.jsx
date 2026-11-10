import './bootstrap';
import '../css/app.css';

import { createRoot, hydrateRoot } from 'react-dom/client';
import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { QueryClient, QueryClientProvider } from '@tanstack/react-query';
import { ImageKitProvider } from '@imagekit/react';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const imageKitEndpoint = import.meta.env.VITE_IMAGEKIT_ENDPOINT_URL;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.jsx`, import.meta.glob('./Pages/**/*.jsx')),
    setup({ el, App, props }) {
        const queryClient = new QueryClient();
        const app = (
            <ImageKitProvider 
                urlEndpoint={imageKitEndpoint}
            >
                <QueryClientProvider client={queryClient}>
                    <App {...props} />
                </QueryClientProvider>
            </ImageKitProvider>
        );

        // Hydrate hanya bila server benar-benar mengirim markup hasil SSR.
        // Root kosong + hydrateRoot() memicu React error #418 (hydration
        // mismatch); tanpa SSR aktif, mount biasa lewat createRoot().
        if (import.meta.env.DEV || el.innerHTML.trim() === '') {
            createRoot(el).render(app);
            return;
        }

        hydrateRoot(el, app);
    },
    progress: {
        color: '#4B5563',
    },
});
