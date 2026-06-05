import { Head, Link, router } from '@inertiajs/react';
import { useEffect, useRef, useState } from 'react';
import UserDashboardLayout from '@/Layouts/UserDashboardLayout';

/**
 * User/Checkout.jsx
 *
 * Props (dikirim dari TransactionController::processPayment()):
 *  - snapToken:         string   — token Midtrans Snap
 *  - transaction:       { id, invoice_id, amount }
 *  - product:           { id, name, slug, category, description, original_price,
 *                         aksespro_price, duration_days, logo_path }
 *  - userName:          string
 *  - userRole:          string
 *  - midtransClientKey: string   — dikirim dari backend, bukan hardcode di frontend
 *  - isProduction:      boolean
 */
export default function Checkout({
    snapToken,
    transaction,
    product,
    user,
    userName,
    userRole,
    midtransClientKey,
    isProduction,
}) {
    /* ── State ──────────────────────────────────────────────────────── */
    const [isLoading, setIsLoading] = useState(false);
    const [snapReady, setSnapReady] = useState(false);
    const snapScriptRef = useRef(null);

    /* ── TASK 4: Load Midtrans Snap Script Secara Dinamis ──────────── */
    /*
     * ⚠️ PENTING: Jangan letakkan <script> statis di JSX.
     * Gunakan useEffect agar script dimuat setelah komponen mount.
     * Ini adalah cara yang benar untuk mengintegrasikan third-party
     * payment gateway di aplikasi SPA React.
     */
    useEffect(() => {
        const snapJsUrl = isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';

        // Cek apakah script sudah ada (mencegah duplikasi saat navigasi)
        const existingScript = document.querySelector(`script[src="${snapJsUrl}"]`);
        if (existingScript) {
            setSnapReady(true);
            return;
        }

        const script = document.createElement('script');
        script.src = snapJsUrl;
        script.setAttribute('data-client-key', midtransClientKey);
        script.async = true;

        script.onload = () => {
            setSnapReady(true);
        };
        script.onerror = () => {
            console.error('Gagal memuat script Midtrans Snap.');
        };

        document.head.appendChild(script);
        snapScriptRef.current = script;

        // Cleanup: hapus script saat komponen unmount
        return () => {
            if (snapScriptRef.current && document.head.contains(snapScriptRef.current)) {
                document.head.removeChild(snapScriptRef.current);
            }
        };
    }, [midtransClientKey, isProduction]);

    /* ── TASK 4: Handler Tombol Bayar ──────────────────────────────── */
    const handlePayment = () => {
        if (!snapReady || !window.snap) {
            alert('Gateway pembayaran belum siap. Coba lagi sesaat.');
            return;
        }

        setIsLoading(true);

        window.snap.pay(snapToken, {
            onSuccess: (result) => {
                /*
                 * Gunakan router.visit() dari Inertia untuk navigasi SPA
                 * setelah pembayaran berhasil — tanpa full page reload.
                 */
                router.visit(
                    route('user.transaksi') + `?payment=success&order_id=${result.order_id}`,
                    { replace: true }
                );
            },
            onPending: (result) => {
                router.visit(
                    route('user.transaksi') + `?payment=pending&order_id=${result.order_id}`,
                    { replace: true }
                );
            },
            onError: (result) => {
                setIsLoading(false);
                router.visit(
                    route('user.transaksi') + `?payment=error&order_id=${result.order_id}`,
                    { replace: true }
                );
            },
            onClose: () => {
                // User menutup popup tanpa bayar
                setIsLoading(false);
            },
        });
    };

    /* ── Format harga ───────────────────────────────────────────────── */
    const formatRupiah = (amount) =>
        'Rp ' + Number(amount).toLocaleString('id-ID');

    /* ── Render ─────────────────────────────────────────────────────── */
    return (
        <UserDashboardLayout user={user ?? { name: userName, points: 0 }} title="Checkout">
            <Head title="Checkout - Pembayaran" />

            <div className="mx-auto max-w-4xl space-y-6">
                {/* ── Back Button ─────────────────────────────────────── */}
                <div>
                    {/* ✅ Navigasi internal pakai <Link> Inertia */}
                    <Link
                        href={route('user.katalog.detail', product.slug)}
                        className="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-500 shadow-sm transition-colors hover:text-[#0A2540]"
                    >
                        <svg className="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Detail Produk
                    </Link>
                </div>

                <div className="grid grid-cols-1 gap-6 lg:grid-cols-3">
                    {/* ── Left Column: Summary ──────────────────────────── */}
                    <div className="space-y-6 lg:col-span-2">
                        {/* Order Summary Card */}
                        <div className="relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
                            <div className="absolute -mr-12 -mt-12 right-0 top-0 h-40 w-40 rounded-full bg-[#00E5FF] opacity-5 blur-2xl" />

                            <h2 className="mb-6 border-b border-gray-100 pb-4 text-xl font-bold text-[#0A2540]">
                                Ringkasan Pesanan
                            </h2>

                            {/* Product Info */}
                            <div className="mb-6 flex items-center gap-5">
                                <div className="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-xl border border-gray-100 bg-gray-50 p-2">
                                    <img
                                        src={`/${product.logo_path}`}
                                        alt={product.name}
                                        className="h-full w-full rounded-lg object-contain"
                                        onError={(e) => { e.target.src = '/image/zoom.jpg'; }}
                                    />
                                </div>
                                <div>
                                    <h3 className="text-lg font-bold leading-tight text-gray-900">
                                        {product.name}
                                    </h3>
                                    <p className="mt-1 text-sm font-medium text-[#00b8cc]">
                                        {product.category} • Masa Aktif {product.duration_days} Hari
                                    </p>
                                </div>
                            </div>

                            {/* Price Breakdown */}
                            <div className="space-y-3 rounded-xl border border-slate-100/80 bg-slate-50 p-5 text-sm">
                                <div className="flex items-center justify-between font-medium text-slate-500">
                                    <span>Harga Patungan</span>
                                    <span className="text-slate-950">{formatRupiah(product.aksespro_price)}</span>
                                </div>
                                <div className="flex items-center justify-between font-medium text-slate-500">
                                    <span>Pajak &amp; Biaya Transaksi</span>
                                    <span className="font-semibold text-emerald-500">FREE (Rp 0)</span>
                                </div>
                                <div className="flex items-center justify-between border-t border-slate-200/60 pt-3 font-medium text-slate-500">
                                    <span className="text-base font-bold text-[#0A2540]">Total Bayar</span>
                                    <span className="text-xl font-black text-[#0A2540]">
                                        {formatRupiah(product.aksespro_price)}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {/* Guarantee Card */}
                        <div className="flex items-start gap-4 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                            <div className="flex-shrink-0 rounded-xl bg-emerald-50 p-3 text-emerald-600">
                                <svg className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 className="mb-1 font-bold text-gray-900">Garansi Legalitas 100%</h4>
                                <p className="text-xs leading-relaxed text-gray-500">
                                    Semua paket patungan di AksesPro dijamin legal, aman, dan bergaransi penuh selama masa aktif. Tim support kami siap melayani 24/7 jika Anda mengalami kendala akses.
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* ── Right Column: Action Box ──────────────────────── */}
                    <div className="lg:col-span-1">
                        <div className="sticky top-6 space-y-6 rounded-2xl border border-gray-100 bg-white p-6 shadow-xl shadow-[#0A2540]/5">
                            <div>
                                <h3 className="text-lg font-bold text-gray-900">Metode Pembayaran</h3>
                                <p className="mt-1 text-xs text-gray-400">Midtrans Snap secure gateway</p>
                            </div>

                            {/* Order ID */}
                            <div className="flex items-center justify-between rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                <span className="text-xs font-semibold text-slate-500">Order ID:</span>
                                <span className="font-mono text-xs font-bold text-slate-700">
                                    {transaction.invoice_id}
                                </span>
                            </div>

                            {/* ── Tombol Bayar ─────────────────────────────── */}
                            {/*
                             * ⚠️ PENTING: Gunakan onClick handler biasa.
                             * Jangan gunakan <form> atau <Link> Inertia untuk ini,
                             * karena kita memanggil window.snap.pay() secara langsung.
                             */}
                            <button
                                id="pay-button"
                                onClick={handlePayment}
                                disabled={isLoading || !snapReady}
                                className="flex w-full transform items-center justify-center gap-2 rounded-xl bg-[#00E5FF] py-4 text-lg font-bold text-[#0A2540] shadow-lg shadow-[#00E5FF]/20 transition-all hover:scale-[1.02] hover:bg-[#00b8cc] disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:scale-100"
                            >
                                {isLoading ? (
                                    <>
                                        <svg className="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                                        </svg>
                                        Memproses...
                                    </>
                                ) : !snapReady ? (
                                    <>
                                        <svg className="h-5 w-5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3" />
                                        </svg>
                                        Memuat Gateway...
                                    </>
                                ) : (
                                    <>
                                        <svg className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm-5-4h.01M6 16h.01" />
                                        </svg>
                                        Bayar Sekarang
                                    </>
                                )}
                            </button>

                            <p className="flex items-center justify-center gap-1 text-center text-[10px] leading-relaxed text-gray-400">
                                <svg className="h-3.5 w-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Enkripsi keamanan SSL 256-bit
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </UserDashboardLayout>
    );
}
