import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'AksesPro';

createInertiaApp({
    /**
     * Title template — ditampilkan di <title> browser.
     * Setiap halaman menggunakan <Head title="Nama Halaman" /> dari @inertiajs/react.
     */
    title: (title) => `${title} — ${appName}`,

    /**
     * Page resolver — mencari komponen di resources/js/Pages/**‌/‌*.jsx
     * Mendukung semua subfolder: Auth/, User/, Admin/, Profile/
     */
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),

    /**
     * Setup function — dipanggil sekali saat aplikasi dimuat.
     */
    setup({ el, App, props }) {
        const root = createRoot(el);
        root.render(<App {...props} />);
    },

    /**
     * Progress bar — ditampilkan saat navigasi Inertia berlangsung.
     * Menggunakan warna brand AksesPro (#00E5FF).
     */
    progress: {
        color: '#00E5FF',
        showSpinner: false,
    },
});
