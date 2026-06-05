import { usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

/**
 * FlashMessage — Komponen global untuk menampilkan flash messages
 * dari session Laravel yang di-share via HandleInertiaRequests middleware.
 *
 * Cara pakai:
 *   import FlashMessage from '@/Components/FlashMessage';
 *   <FlashMessage />  ← tempatkan di bagian atas layout atau halaman
 *
 * Data berasal dari: usePage().props.flash.{success, error, warning}
 */
export default function FlashMessage() {
    const { flash } = usePage().props;
    const [visible, setVisible] = useState(true);

    // Auto-dismiss setelah 5 detik
    useEffect(() => {
        setVisible(true);
        const timer = setTimeout(() => setVisible(false), 5000);
        return () => clearTimeout(timer);
    }, [flash?.success, flash?.error, flash?.warning]);

    if (!visible) return null;

    const message = flash?.success || flash?.error || flash?.warning;
    if (!message) return null;

    const type = flash?.success ? 'success' : flash?.error ? 'error' : 'warning';

    const styles = {
        success: {
            wrapper: 'bg-green-50 border-green-200 text-green-800',
            icon: (
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            ),
            iconColor: 'text-green-500',
        },
        error: {
            wrapper: 'bg-red-50 border-red-200 text-red-800',
            icon: (
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            ),
            iconColor: 'text-red-500',
        },
        warning: {
            wrapper: 'bg-yellow-50 border-yellow-200 text-yellow-800',
            icon: (
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2}
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            ),
            iconColor: 'text-yellow-500',
        },
    };

    const s = styles[type];

    return (
        <div className={`mb-4 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm ${s.wrapper}`}
             role="alert"
        >
            <svg className={`mt-0.5 h-5 w-5 flex-shrink-0 ${s.iconColor}`} fill="none" viewBox="0 0 24 24" stroke="currentColor">
                {s.icon}
            </svg>
            <span className="flex-1">{message}</span>
            <button
                onClick={() => setVisible(false)}
                className="flex-shrink-0 text-current opacity-50 hover:opacity-100 transition-opacity"
                aria-label="Tutup"
            >
                <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    );
}
